@extends('layout.app1')

@section('title')
@endsection

@section('content')

    <div class="app-content content ">
        <section id="responsive-datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom">
                            <h3 class="card-title">Leave Request</h3>
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
                            <div style="width:99%; margin-left:0.5%;" id="leaveReqDiv" style="display: none;">
                                <table id="laravel-datatable-crud" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable mb-0" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th style="display: none;"></th>
                                            <th rowspan="2" style="width:3%;">#</th>
                                            <th colspan="6" style="text-align: center;font-size:13px;">Employee Information</th>
                                            <th colspan="5" style="text-align: center;font-size:13px;">Leave Request Information</th>
                                            <th rowspan="2" style="width:4%;">Action</th>
                                        </tr>
                                        <tr>
                                            <th style="display: none;"></th>
                                            <th style="width:5%;">Photo</th>
                                            <th style="width:12%;">Request For</th>
                                            <th style="width:6%;">Gender</th>
                                            <th style="width:8%;">Branch</th>
                                            <th style="width:9%;">Department</th>
                                            <th style="width:9%;">Position</th>
                                            <th style="width:8%;" title="Leave Request ID">Leave Req. ID</th>
                                            <th style="width:10%;">Leave Duration Type</th>
                                            <th style="width:10%;">Leave Type</th>
                                            <th style="width:8%;">Request Date</th>
                                            <th style="width:8%;">Status</th>
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
        <input type="hidden" class="form-control" name="currentdateval" id="currentdateval" value="{{$currentdate}}" readonly/>
        <input type="hidden" class="form-control" name="useridval" id="useridval" value="{{$userid}}" readonly/>
        <input type="hidden" class="form-control" name="empidval" id="empidval" value="{{$empid}}" readonly/>
        <input type="hidden" class="form-control" name="genderval" id="genderval" value="{{$gender}}" readonly/>
        <input type="hidden" class="form-control" name="userfullname" id="userfullname" value="{{$fullname}}" readonly/>
    </div>

    <div class="modal fade text-left" id="inlineForm" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="banktitlelbl" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modaltitle">Add Leave Request</h4>
                    <div class="row">
                        <div style="text-align: right;" class="errordatalabel" id="statusdisplay"></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeRegisterModal()"><span aria-hidden="true">&times;</span></button>
                    </div>   
                </div>
                <form id="Register">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 mb-1">
                                <fieldset class="fset">
                                    <legend>Basic Information</legend>
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-1">
                                            <label style="font-size: 14px;">Request For</label><label style="color: red; font-size:16px;">*</label>
                                            <select class="select2 form-control mainformdd" name="RequestFor" id="RequestFor" onchange="requestforFn()">
                                                @foreach ($user as $user)
                                                <option label="{{$user->Gender}}" value="{{$user->id}}">{{$user->name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">
                                                <strong id="reqfor-error" class="errordatalabel"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-1">
                                            <label style="font-size: 14px;">Leave Duration Type</label><label style="color: red; font-size:16px;">*</label>
                                            <select class="select2 form-control mainformdd" name="LeaveDurationType" id="LeaveDurationType" onchange="leaveDurTypeFn()">
                                                <option value="Consecutive">Consecutive</option>
                                                @can('Allow-Non-Consecutive')
                                                    <option value="Non-Consecutive">Non-Consecutive</option>
                                                @endcan
                                            </select>
                                            <span class="text-danger">
                                                <strong id="leavedur-error" class="errordatalabel"></strong>
                                            </span>
                                        </div>

                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-1">
                                            <label style="font-size: 14px;">Leave From<b style="color:red;">*</b></label>
                                            <input type="text" id="LeaveFrom" name="LeaveFrom" class="form-control mainforminp" placeholder="YYYY-MM-DD" onchange="leavefromFn()"/>
                                            <span class="text-danger">
                                                <strong id="leavefrom-error" class="errordatalabel"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-1">
                                            <label style="font-size: 14px;">Leave To<b style="color:red;">*</b></label>
                                            <input type="text" id="LeaveTo" name="LeaveTo" class="form-control mainforminp" placeholder="YYYY-MM-DD" onchange="leavetoFn()"/>
                                            <span>
                                                <label id="consdescription" style="color: #00cfe8;font-size:10px;" class="errordatalabel"></label></br>
                                                <strong id="leaveto-error" class="text-danger errordatalabel"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-2 mb-1">
                                            <label style="font-size: 14px;">Request Date: </label>
                                            <label id="reqdatelbl" style="font-size: 14px;font-weight:bold;"></label>
                                            <input type="hidden" id="RequestDate" name="RequestDate" class="form-control" readonly/>
                                        </div>

                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12">
                                <fieldset class="fset">
                                    <legend>Miscellaneous Information</legend>
                                    <div class="row">
                                        <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                            <div class="row">
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-1">
                                                    <label style="font-size: 14px;">Leave Reason</label>
                                                    <textarea type="text" placeholder="Write leave reason here..." class="form-control mainforminp" rows="2" name="LeaveReason" id="LeaveReason" onkeyup="leaveReasonFn()"></textarea>
                                                    <span class="text-danger">
                                                        <strong id="leavereason-error" class="errordatalabel"></strong>
                                                    </span>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-1">
                                                    <label style="font-size: 14px;">Address During Leave</label>
                                                    <textarea type="text" placeholder="Write address during leave here..." class="form-control mainforminp" rows="2" name="AddressDuringLeave" id="AddressDuringLeave" onkeyup="addressOnLeave()"></textarea>
                                                    <span class="text-danger">
                                                        <strong id="addressleave-error" class="errordatalabel"></strong>
                                                    </span>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                                    <label style="font-size: 14px;">Supporting Document</label>
                                                    <input class="form-control fileuploads mainforminp" type="file" id="DocumentUpload" name="DocumentUpload" accept=".jpg, .jpeg, .png,.pdf">
                                                    <span>
                                                        <button type="button" id="documentuploadlinkbtn" name="documentuploadlinkbtn" class="btn btn-flat-info waves-effect btn-sm documentuploadlinkbtn" onclick="documenDocumentFn()" style="display:none;"></button>
                                                        <button type="button" id="docBtn" name="docBtn" class="btn btn-flat-danger waves-effect btn-sm docBtn" onclick="docBtnFn();"><i class="fa fa-times" aria-hidden="true"></i></button>
                                                        <strong id="documentupload-error" class="text-danger errordatalabel"></strong>
                                                        <input type="hidden" class="form-control mainforminp linkname" name="documentuploadfilelbl" id="documentuploadfilelbl" readonly="true" value=""/> 
                                                    </span>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                                    <label style="font-size: 14px;">Additional Remark</label>
                                                    <textarea type="text" placeholder="Write remark here..." class="form-control mainforminp" rows="3" name="Remark" id="Remark" onkeyup="remarkFn()"></textarea>
                                                    <span class="text-danger">
                                                        <strong id="remark-error" class="errordatalabel"></strong>
                                                    </span>
                                                </div>
                                            </div>

                                        </div>
                                        
                                        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
                                            <div class="divider" style="margin-top:-1rem;">
                                                <div class="divider-text"><b>Emergency Contact During Leave</b></div>
                                            </div>
                                            <div class="row" style="margin-top:-1rem;">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-1">
                                                    <label style="font-size: 14px;">Name</label>
                                                    <input type="text" id="EmergencyName" name="EmergencyName" class="form-control mainforminp" placeholder="Write contact person name" onkeyup="emergencyNameFn()">
                                                    <span class="text-danger">
                                                        <strong id="emergencyname-error" class="errordatalabel"></strong>
                                                    </span>
                                                </div>
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-1">
                                                    <label style="font-size: 14px;">Phone</label>
                                                    <input type="number" id="EmergencyPhone" name="EmergencyPhone" class="form-control mainforminp" onkeypress="return ValidateNum(event);" placeholder="Write contact mobile or office phone number" onkeyup="emergencyPhoneFn()/>
                                                    <span class="text-danger">
                                                        <strong id="emergencyphone-error" class="errordatalabel"></strong>
                                                    </span>
                                                </div>
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                    <label style="font-size: 14px;">Email</label>
                                                    <input type="text" id="EmergencyEmail" name="EmergencyEmail" class="form-control mainforminp" placeholder="Write email address here..." onkeydown="emergencyEmailFn()" onkeyup="ValidateEmail(this);"/>
                                                    <span class="text-danger">
                                                        <strong id="Email-error" class="errordatalabel"></strong>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <hr class="m-0.5">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-1">
                                <span class="text-danger">
                                    <strong id="table-error" class="dataclass"></strong>
                                </span>
                                <table id="leavetypetbl" class="rtable" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th style="width:3%;">#</th>
                                            <th style="width:15%;">Leave Type</th>
                                            <th style="width:13%;">Year</th>
                                            <th style="width:13%;">Leave Payment Type</th>
                                            <th style="width:13%;">Requires Balance</th>
                                            <th style="width:13%;">Leave Balance</th>
                                            <th style="width:13%;">No. of Day(s)</th>
                                            <th style="width:14%;">Remark</th>
                                            <th style="width:3%;"></th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                        <tr style="font-size: 16px;text-align:left;">
                                            <th colspan="6" style="text-align:left;background-color: #FFFFFF;border:none;padding:0px;">
                                                <button type="button" name="leaveadds" id="leaveadds" class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i>  Add New</button>
                                                <label style="font-size: 16px;text-align:right;float:right;">Total</label>
                                            </th>
                                            <th class="dataclass" id="totalnumberofdays"></th>
                                            <th style="background-color: #FFFFFF;border:none;padding:0px;" colspan="2"></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control mainforminp" name="dependOnBal" id="dependOnBal" readonly="true" value=""/>     
                        <input type="hidden" class="form-control linkid" name="recId" id="recId" readonly="true" value=""/>     
                        <input type="hidden" class="form-control" name="operationtypes" id="operationtypes" readonly="true"/>
                        <input type="hidden" class="form-control" name="leaveEndDateMinDate" id="leaveEndDateMinDate" readonly="true"/>
                        <div style="display: none;">
                            <select name="defaultleavetype" id="defaultleavetype" class="select2 form-control">
                                <option selected disabled value=""></option>
                                @foreach ($hrleavetype as $hrleavetype)
                                <option data-reqbalance="{{$hrleavetype->RequiresBalance}}" title="{{$hrleavetype->LeavePaymentType}}" label="{{ $hrleavetype->RequiresBalance }}" value="{{ $hrleavetype->id }}">{{ $hrleavetype->LeaveType }}</option>
                                @endforeach
                            </select>
                            <select class="select2 form-control" name="defaultyear" id="defaultyear">
                                <option selected disabled value=""></option>
                                @foreach ($yeardata as $yeardata)
                                <option title="{{ $yeardata->EmpLeave }}" value="{{ $yeardata->Year }}">{{ $yeardata->Year }}</option>
                                @endforeach
                            </select>
                            <select name="LeaveTypeCbx" id="LeaveTypeCbx" class="select2 form-control">
                                @foreach ($leavetype as $leavetype)
                                <option title="{{$leavetype->userid}}" value="{{$leavetype->hr_leavetypes_id}}">{{$leavetype->LeaveType}}</option>
                                @endforeach
                            </select>
                        </div>
                        <button id="savebutton" type="submit" class="btn btn-info">Save</button>
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
                    <h4 class="modal-title">Leave Request Information</h4>
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
                                            <div id="headingCollapse2" class="card-header" data-toggle="collapse" role="button" data-target=".infoleave" aria-expanded="false" aria-controls="collapse1">
                                                <span class="lead collapse-title">Employee, Basic, Miscellaneous & Action Information</span>
                                                <div id="shiftScheduleTitle" style="font-weight: bold;font-size:15px;"></div>
                                            </div>
                                            <div id="collapse2" role="tabpanel" aria-labelledby="headingCollapse2" class="collapse infoleave">
                                                <div class="row ml-1 mb-1">
                                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
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
                                                                        <div class="avatar-preview" style="width: 120px;height:120px;">
                                                                            <img id="infoActualImage" src="../../../storage/uploads/HrEmployee/dummypic.jpg">
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><label style="font-size: 14px;">Employee ID</label></td>
                                                                <td><label id="employeeidlbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                            </tr>
                                                            <tr>
                                                                <td><label style="font-size: 14px;">Employee Name</label></td>
                                                                <td><label id="requestedbylbl" style="font-size: 14px;font-weight:bold;"></label></td>
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
                                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                        <table style="width: 100%;">
                                                            <tr>
                                                                <td colspan="2">
                                                                    <label id="basictitle" strong style="font-size: 16px;font-weight:bold;">Basic Information</label>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width: 45%;"><label style="font-size: 14px;">Leave Duration Type</label></td>
                                                                <td style="width: 55%;"><label id="leavedurationtypelbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                            </tr>
                                                            <tr>
                                                                <td><label style="font-size: 14px;">Leave From</label></td>
                                                                <td><label id="leavefromlbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                            </tr>
                                                            <tr>
                                                                <td><label style="font-size: 14px;">Leave To</label></td>
                                                                <td><label id="leavetolbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                            </tr>
                                                            <tr style="display: none;">
                                                                <td><label style="font-size: 14px;">Number of Days</label></td>
                                                                <td><label id="numofdaylbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                            </tr>
                                                            <tr>
                                                                <td><label style="font-size: 14px;">Request Date</label></td>
                                                                <td><label id="requestdatelbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                            </tr>
                                                            
                                                        </table>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                        <table style="width: 100%;">
                                                            <tr>
                                                                <td colspan="2">
                                                                    <label id="misctitle" strong style="font-size: 16px;font-weight:bold;">Miscellaneous Information</label>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width: 42%"><label style="font-size: 14px;">Leave Reason</label></td>
                                                                <td style="width: 58%"><label id="leavereasonlbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                            </tr>
                                                            
                                                            <tr>
                                                                <td><label style="font-size: 14px;">Address During Leave</label></td>
                                                                <td><label id="addressduringleave" style="font-size: 14px;font-weight:bold;"></label></td>
                                                            </tr>
                                                            <tr>
                                                                <td><label style="font-size: 14px;" title="Supporting Document">Supporting Doc.</label></td>
                                                                <td><a style="text-decoration:underline;color:blue;" onclick="documentDocumentInfoFn()" id="supportingDocumentInfo"></a></td>
                                                            </tr>
                                                            <tr>
                                                                <td><label style="font-size: 14px;">Remark</label></td>
                                                                <td><label id="remarklbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2" style="text-align: center;">
                                                                    <label style="font-size: 12px;font-weight:bold;"><u>Emergency Contact During Leave</u></label>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><label style="font-size: 14px;">Name</label></td>
                                                                <td><label id="emergencynameinfo" style="font-size: 14px;font-weight:bold;"></label></td>
                                                            </tr>
                                                            <tr>
                                                                <td><label style="font-size: 14px;">Phone</label></td>
                                                                <td><label id="emergencyphoneinfo" style="font-size: 14px;font-weight:bold;"></label></td>
                                                            </tr>
                                                            <tr>
                                                                <td><label style="font-size: 14px;">Email</label></td>
                                                                <td><label id="emergencyemailinfo" style="font-size: 14px;font-weight:bold;"></label></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12">
                                                        <label id="actioninformationtitle" style="font-size: 16px;font-weight:bold;">Action Information</label>
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
                            <hr class="m-1">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                    <div class="table-responsive scroll scrdiv" id="leaveTypeDiv">
                                        <table id="leavereqtypeinfotbl" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable mb-0" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th style="width:3%;">#</th>
                                                    <th style="width:18%;">Leave Type</th>
                                                    <th style="width:15%;">Year</th>
                                                    <th style="width:15%;">Leave Payment Type</th>
                                                    <th style="width:15%;">Requires Balance</th>
                                                    <th style="width:15%;">No. of Day(s)</th>
                                                    <th style="width:19%;">Remark</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table table-sm"></tbody>
                                            <tfoot>
                                                <th colspan="5" style="font-size:16px;text-align: right;padding-right:7px;">Total Number of Day(s)</th>
                                                <th style="font-size: 14px;" id="totalnumofday"></th>
                                                <th></th>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control linkid" name="reqId" id="reqId" readonly="true">
                        <input type="hidden" class="form-control linkname" name="filenameinfo" id="filenameinfo" readonly="true">
                        <input type="hidden" class="form-control" name="statusi" id="statusi" readonly="true">
                        <input type="hidden" class="form-control" name="statusid" id="statusid" readonly="true">
                        <input type="hidden" class="form-control" name="currentStatus" id="currentStatus" readonly="true">
                        @can('Leave-Request-ChangeToPending')
                        <button id="changetopending" type="button" onclick="forwardActionFn()" class="btn btn-info actionpropbtn">Change to Pending</button>
                        <button id="backtodraft" type="button" class="btn btn-info backwardbtn actionpropbtn">Back to Draft</button>
                        @endcan
                        @can('Leave-Request-Verify')
                        <button id="verifybtn" type="button" onclick="forwardActionFn()" class="btn btn-info actionpropbtn">Verify Leave Request</button>
                        <button id="backtopending" type="button" class="btn btn-info backwardbtn actionpropbtn">Back to Pending</button>
                        @endcan
                        @can('Leave-Request-Approve')
                        <button id="approvebtn" type="button" onclick="forwardActionFn()" class="btn btn-info actionpropbtn">Approve Leave Request</button>
                        {{-- <button id="backtoverify" type="button" class="btn btn-info backwardbtn actionpropbtn">Back to Verify</button> --}}
                        <button id="rejectbtn" type="button" class="btn btn-info backwardbtn actionpropbtn">Reject</button>
                        @endcan

                        <button id="closebuttonk" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End Information Modal -->

    <!--Start Approve modal -->
    <div class="modal fade text-left" id="approveconmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
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
                        <label strong style="font-size: 16px; color:white;font-weight:bold;">Do you really want to approve leave requisition?</label>
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="appId" id="appId" readonly="true">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="conapprovebtn" type="button" class="btn btn-info">Approve</button>
                        <button id="closebutton" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Approve modal -->

    <!--Start Comment modal -->
    <div class="modal fade text-left" id="commentModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeCommentReqFn()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="commentform">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label strong style="font-size: 16px;">Write your comment</label>
                        </div>
                        <div class="divider">
                            <div class="divider-text">Comment</div>
                        </div>
                        <label strong style="font-size: 16px;"></label>
                        <div class="form-group">
                            <textarea type="text" placeholder="Write Comment here..." class="form-control" rows="3" name="Comment" id="Comment" onkeyup="commentReqFn()" autofocus></textarea>
                            <span class="text-danger">
                                <strong id="comment-error"></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="commentid" id="commentid" readonly="true">
                            <input type="hidden" class="form-control" name="commentstatus" id="commentstatus" readonly="true">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="concommentbtn" type="button" class="btn btn-info">Comment</button>
                        <button id="closebutton" type="button" class="btn btn-danger" data-dismiss="modal" onclick="closeCommentReqFn()">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Comment modal -->

    <!--Start Reject modal -->
    <div class="modal fade text-left" id="rejectconmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
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
                        <label strong style="font-size: 16px; color:white;font-weight:bold;">Do you really want to reject leave requisition?</label>
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="rejId" id="rejId" readonly="true">
                            <input type="hidden" class="form-control" name="rejstatus" id="rejstatus" readonly="true">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="conrejectbtn" type="button" class="btn btn-info">Reject</button>
                        <button id="closebutton" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Reject modal -->

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
                        <label strong style="font-size: 16px;font-weight:bold;color:white;">Do you really want to delete this position?</label>
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

    <!--Start Delete modal -->
    <div class="modal fade text-left" id="deletereq" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="voidReasonCloseFn()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="deletereqform">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label strong style="font-size: 16px;font-weight:bold;">Do you really want to void leave requisition?</label>
                        </div>
                        <div class="divider">
                            <div class="divider-text">Reason</div>
                        </div>
                        <label strong style="font-size: 16px;"></label>
                        <textarea type="text" placeholder="Write Reason here..." class="form-control Reason" rows="3" name="Reason" id="Reason" onkeyup="voidReason()"></textarea>
                        <span class="text-danger">
                            <strong id="void-error"></strong>
                        </span>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control" name="delidi" id="delidi" readonly="true">
                        <button id="deletereqdatabtn" type="button" class="btn btn-info">Void</button>
                        <button id="closebuttond" type="button" class="btn btn-danger" data-dismiss="modal" onclick="voidReasonCloseFn()">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Delete modal -->

    <!--Start undo void modal -->
    <div class="modal fade text-left" id="undovoidmodal" data-keyboard="false" data-backdrop="static" tabindex="-1"
        role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
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
                        <label strong style="font-size: 16px;font-weight:bold;">Do you really want to undo void leave requisition?</label>
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="undovoidid" id="undovoidid" readonly="true">
                            <input type="hidden" class="form-control" name="ustatus" id="ustatus" readonly="true">
                            <input type="hidden" class="form-control" name="oldstatus" id="oldstatus" readonly="true">
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
        var errorcolor = "#ffcccc";
        var currdate = $('#currentdateval').val();
        var userid = $('#useridval').val();
        var empid = $('#empidval').val();
        var gender = $('#genderval').val();
        var fullname = $('#userfullname').val();
        var leavendDateDesc = `<i class="fad fa-info-circle"></i> Date is not editable for Consecutive duration type.`;
        var mindatecalendar = "";
        var defaultoption = '<option selected disabled value=""></option>';
        $(function () {
            cardSection = $('#page-block');
        });

        var j = 0;
        var i = 0;
        var m = 0;
        var ctable = "";

        var statusTransitions = {
            'Draft': {
                forward: {
                    status: 'Pending',
                    text: 'Change to Pending',
                    action: 'Change to Pending',
                    message: 'Do you really want to change leave request to pending?',
                    forecolor: '#6e6b7b',
                    backcolor: '#f6c23e'
                }
            },
            'Pending': {
                forward: {
                    status: 'Verified',
                    text: 'Verify',
                    action: 'Verified',
                    message: 'Do you really want to verify leave request?',
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
                    message: 'Do you really want to approve leave request?',
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
                    message: 'Do you really want to approve leave request?',
                    forecolor: '#FFFFFF',
                    backcolor: '#28c76f'
                }
            },
        };

        $(document).ready( function () {
            getEmployeeData(empid);
            $('#leaveReqDiv').hide();
            $('#filter_div').hide();
            ctable = $('#laravel-datatable-crud').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                searchHighlight: true,
                "order": [[ 0, "desc" ]],
                "pagingType": "simple",
                language: { search: '', searchPlaceholder: "Search here"},
                "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8 custom-buttons'>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4 d-flex justify-content-center'i><'col-sm-12 col-md-4 d-flex justify-content-end'p>>",
                scrollY:'60vh',
                scrollX: true,
                scrollCollapse: true,
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/leavelist',
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
                    }
                },
                columns: [
                    { data: 'id', name: 'id', 'visible': false},
                    { data: 'DT_RowIndex', width:"3%"},
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
                    { data: 'FullName', name: 'FullName',width:"12%"},
                    { data: 'Gender', name: 'Gender', width:'6%'},
                    { data: 'BranchName', name: 'BranchName',width:"8%"},
                    { data: 'DepartmentName', name: 'DepartmentName',width:"9%"},
                    { data: 'PositionName', name: 'PositionName',width:"9%"},
                    { data: 'LeaveID', name: 'LeaveID',width:"8%"},
                    { data: 'LeaveDurationType', name: 'LeaveDurationType',width:"10%"},
                    { data: 'LeaveType', name: 'LeaveType',width:"10%"},
                    { data: 'RequestedDate', name: 'RequestedDate',width:"8%"},
                    { data: 'Status', name: 'Status',
                        "render": function ( data, type, row, meta ) {
                            if(data == "Draft"){
                                return '<span class="badge bg-secondary bg-glow">'+data+'</span>';
                            }
                            else if(data == "Pending"){
                                return '<span class="badge bg-warning bg-glow">'+data+'</span>';
                            }
                            else if(data == "Verified"){
                                return '<span class="badge bg-primary bg-glow">'+data+'</span>';
                            }
                            else if(data == "Approved"){
                                return '<span class="badge bg-success bg-glow">'+data+'</span>';
                            }
                            else if(data == "Void" || data == "Void(Draft)" || data == "Void(Pending)" || data == "Void(Verified)" || data == "Void(Approved)" || data == "Rejected"){
                                return '<span class="badge bg-danger bg-glow">'+data+'</span>';
                            }
                            else{
                                return '<span class="badge bg-dark bg-glow">'+data+'</span>';
                            }
                        },
                        width:"8%"
                    },
                    { data: 'action', name: 'action',width:"4%"}
                ],
                "initComplete": function () {
                    $('.custom-buttons').html(`
                        <button type="button" class="btn btn-gradient-info btn-sm addleavereq" id="addleavereq" data-toggle="modal">Add</button>
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
                    $('#leaveReqDiv').show();
                    $('#filter_div').show();
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
                ctable.column(5).search('^$', true, false).draw(); // Match an impossible pattern
            } else {
                // Options selected: build regex for filtering
                var searchRegex = search.join('|'); // OR-separated values for regex
                ctable.column(5).search(searchRegex, true, false).draw();
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
                ctable.column(6).search('^$', true, false).draw(); // Match an impossible pattern
            } else {
                // Options selected: build regex for filtering
                var searchRegex = search.join('|'); // OR-separated values for regex
                ctable.column(6).search(searchRegex, true, false).draw();
            }
        });

        $('body').on('click', '#addleavereq', function() {
            var defleaveopt='<option value=""></option>';
            $("#RequestFor option[value='"+empid+"']").remove();
            var defoption='<option selected value='+empid+'>'+fullname+'</option>';
            $('#RequestFor').append(defoption);
            $('#LeaveDurationType').val(null).select2({
                placeholder: "Select leave duration type here",
                minimumResultsForSearch: -1
            });
            var currentdate = $('#currentdateval').val();
            $('#RequestDate').val(currentdate);
            $('#reqdatelbl').html(currentdate);
            $("#LeaveTo").prop("readonly",true);
            $('#LeaveTo').css("background", "white");
            $("#LeaveFrom").prop("readonly",true);
            $('.mainforminp').val("");
            $('#recId').val("");
            $('#operationtypes').val("1");
            $("#modaltitle").html("Add Leave Request");
            $('#savebutton').text('Save');
            $('#savebutton').prop("disabled",false);
            $('#docBtn').hide();
            $('#commentformdiv').hide();
            $('#documentuploadlinkbtn').hide();
            $("#inlineForm").modal('show');
        });
       
        $('#Register').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var optype = $("#operationtypes").val();
            $.ajax({
                url: '/saveLeaveReq',
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
                        if (data.errors.RequestFor) {
                            $('#reqfor-error').html(data.errors.RequestFor[0]);
                        }
                        if (data.errors.LeaveDurationType) {
                            $('#leavedur-error').html(data.errors.LeaveDurationType[0]);
                        }
                        if (data.errors.LeaveType) {
                            $('#leavetype-error').html(data.errors.LeaveType[0]);
                        }
                        if (data.errors.LeaveFrom) {
                            $('#leavefrom-error').html(data.errors.LeaveFrom[0]);
                        }
                        if (data.errors.LeaveTo) {
                            $('#leaveto-error').html(data.errors.LeaveTo[0]);
                        }
                        if (data.errors.NumberOfDays) {
                            $('#numofdays-error').html(data.errors.NumberOfDays[0]);
                        }
                        if (data.errors.LeaveReason) {
                            $('#leavereason-error').html(data.errors.LeaveReason[0]);
                        }
                        if (data.errors.AddressDuringLeave) {
                            $('#addressleave-error').html(data.errors.AddressDuringLeave[0]);
                        }
                        if (data.errors.DocumentUpload) {
                            $('#documentupload-error').html(data.errors.DocumentUpload[0]);
                        }
                        if (data.errors.DocumentUpload) {
                            $('#documentupload-error').html(data.errors.DocumentUpload[0]);
                        }
                        if (data.errors.Remark) {
                            $('#remark-error').html(data.errors.Remark[0]);
                        }
                        if (data.errors.EmergencyName) {
                            $('#emergencyname-error').html(data.errors.EmergencyName[0]);
                        }
                        if (data.errors.EmergencyPhone) {
                            $('#emergencyphone-error').html(data.errors.EmergencyPhone[0]);
                        }
                        if (data.errors.EmergencyEmail) {
                            $('#Email-error').html(data.errors.EmergencyEmail[0]);
                        }

                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }  
                        toastrMessage('error',"Please check your inputs","Error");
                    }
                    if(data.errorsv2){
                        $('#leavetypetbl > tbody > tr').each(function () {
                            let leavetype = $(this).find('.leavetype').val();
                            let leaveyear = $(this).find('.leaveyear').val();
                            let leavepaymenttype = $(this).find('.LeavePaymentType').val();
                            let numofday = $(this).find('.NoOfDays').val();
                            let rowind = $(this).find('.vals').val();

                            if(isNaN(parseFloat(leavetype))||parseFloat(leavetype)==0){
                                $(`#select2-leavetype${rowind}-container`).parent().css('background-color',errorcolor);
                            }
                            if(isNaN(parseFloat(leaveyear))||parseFloat(leaveyear)==0){
                                $(`#select2-leaveyear${rowind}-container`).parent().css('background-color',errorcolor);
                            }
                            if(isNaN(parseFloat(leavepaymenttype))||parseFloat(leavepaymenttype)==0){
                                $(`#select2-LeavePaymentType${rowind}-container`).parent().css('background-color',errorcolor);
                            }
                            if(numofday != undefined){
                                if(isNaN(parseFloat(numofday))||parseFloat(numofday)==0){
                                    $(`#NoOfDays${rowind}`).css("background", errorcolor);
                                }
                            }
                        });

                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                        toastrMessage('error',"Please insert valid data on highlighted fields!","Error");
                    }
                    else if(data.emptyerror){
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled",false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled",false);
                        }
                        $("#table-error").html("Please add leave type here");
                        toastrMessage('error',"Please add atleast one leave type","Error");
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
                        var oTable = $('#laravel-datatable-crud').dataTable(); 
                        oTable.fnDraw(false);
                        closeRegisterModal();
                        $("#inlineForm").modal('hide');
                    }
                }
            });
        });

        function leavemgtEditFn(recordId) { 
            $('.select2').select2();
            $("#operationtypes").val("2");
            $("#recId").val(recordId);
            var defleaveopt="";
            var leavetypeopt = "";
            var forecolor = "";
            var booleanFlag = null;
            j=0;
            $.ajax({
                url: '/showleave'+'/'+recordId,
                type: 'GET',
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
                    $.each(data.leavelist, function(key, value) {
                        $('#RequestFor').val(value.requested_for).select2();
                        $('#LeaveDurationType').val(value.LeaveDurationType).select2({minimumResultsForSearch: -1});
                        flatpickr('#LeaveFrom', { dateFormat: 'Y-m-d',clickOpens:true,minDate: data.mindate,defaultDate: value.LeaveFrom});
                        $('#RequestDate').val(value.RequestedDate);
                        $('#reqdatelbl').html(value.RequestedDate);

                        booleanFlag = value.LeaveDurationType == "Non-Consecutive" ? true : false;

                        flatpickr('#LeaveTo', { dateFormat: 'Y-m-d',clickOpens:booleanFlag,minDate: data.end_date,defaultDate: value.LeaveTo});

                        $('#consdescription').html(value.LeaveDurationType == "Consecutive" ? leavendDateDesc : "");
                        $('#LeaveTo').css("background",value.LeaveDurationType == "Consecutive" ? "#efefef" : "white");

                        $('#LeaveReason').val(value.LeaveReason);
                        $('#AddressDuringLeave').val(value.AddressDuringLeave);
                        $('#Remark').val(value.Remark);
                        $('#EmergencyName').val(value.EmergencyName);
                        $('#EmergencyPhone').val(value.EmergencyPhone);
                        $('#EmergencyEmail').val(value.EmergencyEmail);

                        if(value.DocumentUpload == null){
                            $("#docBtn").hide();
                            $("#documentuploadlinkbtn").hide();
                            $("#documentuploadlinkbtn").text(value.DocumentUpload);
                            $("#documentuploadfilelbl").val(value.DocumentUpload);
                        }
                        else if(value.DocumentUpload != null){
                            $("#docBtn").show();
                            $("#documentuploadlinkbtn").show();
                            $("#documentuploadlinkbtn").text(value.DocumentUpload);
                            $("#documentuploadfilelbl").val(value.DocumentUpload);
                        }

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
                        $("#statusdisplay").html(`<span style='color:${forecolor};font-weight:bold;font-size:16px;text-align:right;'>${value.LeaveID}, ${value.Status}</span>`);
                    });

                    $.each(data.leavetypedata, function(key, value) {
                        ++i;
                        ++j;
                        ++m;

                        $("#leavetypetbl > tbody").append(`<tr>
                            <td style="font-weight:bold;text-align:center;width:3%">${j}</td>
                            <td style="display:none;"><input type="hidden" name="leaverow[${m}][vals]" id="vals${m}" class="vals form-control" readonly="true" style="font-weight:bold;" value="${m}"/></td>
                            <td style="width:15%"><select id="leavetype${m}" class="select2 form-control leavetype" onchange="leavetypeFn(this)" name="leaverow[${m}][LeaveType]"></select></td> 
                            <td style="width:13%"><select id="leaveyear${m}" class="select2 form-control leaveyear" onchange="leaveyearFn(this)" name="leaverow[${m}][Year]"></select></td> 
                            <td style="width:13%"><select id="LeavePaymentType${m}" class="select2 form-control LeavePaymentType" onchange="LeavePaymentTypeFn(this)" name="leaverow[${m}][LeavePaymentType]"></select></td> 
                            <td style="width:13%"><input type="text" placeholder="Requires Balance" id="RequireBalance${m}" class="RequireBalance form-control numeral-mask" name="leaverow[${m}][RequireBalance]" readonly style="font-weight:bold;font-size:13px;" value="${value.RequireBalance}"/></td>
                            <td style="width:13%"><input type="number" placeholder="Leave Balance" id="leavebalance${m}" class="leavebalance form-control numeral-mask" name="leaverow[${m}][LeaveBalance]" readonly onkeypress="return ValidateNum(event);" style="font-weight:bold;font-size:13px;"/></td>
                            <td style="width:13%"><input type="number" placeholder="Write no. of day(s) here..." id="NoOfDays${m}" class="NoOfDays form-control numeral-mask" name="leaverow[${m}][NoOfDays]" value="${value.NumberOfDays}" onkeyup="TotalLeaveBalanceFn(this)" readonly onkeypress="return ValidateNum(event);" step="any"/></td>
                            <td style="width:14%;"><input type="text" placeholder="Write remark here..." id="Remark${m}" class="Remark form-control" name="leaverow[${m}][Remark]" value="${value.Remark == null ? "" : value.Remark}"/></td>
                            <td style="width:5%;text-align:center;"><button type="button" id="remove-btn${m}" class="btn btn-light btn-sm remove-tr" style="display:none;color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>
                        </tr>`);

                        var defaultleavetype = `<option selected value="${value.hr_leavetypes_id}">${value.LeaveType}</option>`;
                        var defaultyear = `<option selected value="${value.Year}">${value.Year}</option>`;
                        var defaultpaymenttype = `<option selected value="${value.LeavePaymentType}">${value.LeavePaymentType}</option>`;
                        
                        if(parseInt(value.CountTransaction) == 0){
                            var leavetypelist = $("#defaultleavetype > option").clone();
                            $(`#leavetype${m}`).append(leavetypelist);
                            $(`#leavetype${m} option[value="${value.hr_leavetypes_id}"]`).remove(); 

                            var yearlist = $("#defaultyear > option").clone();
                            $(`#leaveyear${m}`).append(yearlist);
                            $(`#leaveyear${m} option[value="${value.Year}"]`).remove(); 
                            $(`#NoOfDays${m}`).prop("readonly",false);
                            $(`#remove-btn${m}`).show();
                        }
                        $(`#leavetype${m}`).append(defaultleavetype);
                        $(`#leavetype${m}`).select2({placeholder: "Select leave type here"});

                        $(`#leaveyear${m}`).append(defaultyear);
                        $(`#leaveyear${m}`).select2({placeholder: "Select year here"});

                        var paymenttype = $(`#defaultleavetype option[value="${value.hr_leavetypes_id}"]`).attr('title');

                        if(paymenttype == "Paid" || paymenttype == "Unpaid"){
                            $(`#LeavePaymentType${m}`).append(`<option selected value="${paymenttype}">${paymenttype}</option>`);
                            $(`#LeavePaymentType${m}`).select2({minimumResultsForSearch: -1});
                        }
                        else if(paymenttype == "Paid-or-Unpaid"){
                            $(`#LeavePaymentType${m}`).append(`<option value="Paid">Paid</option><option value="Unpaid">Unpaid</option>`);
                            $(`#LeavePaymentType${m} option[value="${value.LeavePaymentType}"]`).remove(); 
                            $(`#LeavePaymentType${m}`).append(defaultpaymenttype);
                            $(`#LeavePaymentType${m}`).select2({placeholder: "Select leave payment type here...",minimumResultsForSearch: -1});
                        }

                        $(`#select2-leavetype${m}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                        $(`#select2-leaveyear${m}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                        $(`#select2-LeavePaymentType${m}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                        calculateLeaveBalance(m);
                        totalCalcNumOfDay();
                        renumberRows();
                    });
                }
            });
            $("#modaltitle").html("Edit Leave Request");
            $('#savebutton').text('Update');
            $('#savebutton').prop("disabled",false);
            $("#inlineForm").modal('show'); 
        }

        function leavemgtInfoFn(recordId) { 
            $("#reqId").val(recordId);
            var forecolor = "";
            var lidata = "";
            $(".actionpropbtn").hide();
            $.ajax({
                url: '/showleave'+'/'+recordId,
                type: 'GET',
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
                },

                success:function(data) {
                    $.each(data.leavelist, function(key, value) {
                        $("#employeeidlbl").html(value.EmployeeID);
                        $("#requestedbylbl").html(value.RequestedBy);
                        $("#departmentLbl").html(value.DepartmentName);
                        $("#positionLbl").html(value.PositionName);
                        $("#brancnLbl").html(value.BranchName);
                        $("#genderLbl").html(value.Gender);
                        $("#employementTypeLbl").html(value.EmploymentTypeName);

                        if(value.ActualPicture!=null || value.BiometricPicture!=null){
                            $('#infoActualImage').attr("src",value.ActualPicture!=null ? "../../../storage/uploads/HrEmployee/"+value.ActualPicture : "../../../storage/uploads/BioEmployee/"+value.BiometricPicture);
                            $('#infoActualImage').show();
                        }
                        if(value.ActualPicture===null && value.BiometricPicture===null){
                            $('#infoActualImage').attr("src","../../../storage/uploads/HrEmployee/dummypic.jpg");
                            $("#infoActualImage").show(); 
                        }

                        if(value.EmpStatus=="Active"){
                            $(".avatar-preview").css({
                                "border": "4px solid #28c76f"
                            });
                        }
                        else if(value.EmpStatus=="Inactive"){
                            $(".avatar-preview").css({
                                "border": "4px solid #ea5455"
                            });
                        }
                        else{
                            $(".avatar-preview").css({
                                "border": "4px solid #ff9f43"
                            });
                        }

                        $("#leavedurationtypelbl").html(value.LeaveDurationType);
                        $("#leaveidlbl").html(value.LeaveID);
                        $("#leavetypelbl").html(value.LeaveType);
                        $("#requestdatelbl").html(value.RequestedDate);
                        $("#leavefromlbl").html(value.LeaveFrom);
                        $("#leavetolbl").html(value.LeaveTo);
                        $("#numofdaylbl").html(value.NumberOfDays);
                        $("#totalnumofday").html(value.NumberOfDays);
                        
                        $("#leavereasonlbl").html(value.LeaveReason);
                        $("#addressduringleave").html(value.AddressDuringLeave);
                        $("#supportingDocumentInfo").text(value.DocumentUpload);
                        $("#remarklbl").html(value.Remark);

                        $("#emergencynameinfo").html(value.EmergencyName);
                        $("#emergencyphoneinfo").html(value.EmergencyPhone);
                        $("#emergencyemailinfo").html(value.EmergencyEmail);
                        $("#filenameinfo").val(value.DocumentUpload);
                        
                        $("#currentStatus").val(value.Status);
                        
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
                        $("#statustitles").html(`<span style='color:${forecolor};font-weight:bold;font-size:16px;text-align:right;'>${value.LeaveID}, ${value.Status}</span>`);
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

            fetchLeaveTypeData(recordId);
            
        }

        function fetchLeaveTypeData(recordId){
            var recid="";
            $('#leaveTypeDiv').hide();
            $('#leavereqtypeinfotbl').DataTable({
                destroy: true,
                processing: false,
                serverSide: true,
                searching: true,
                info: false,
                fixedHeader: true,
                paging: false,
                searchHighlight: true,
                responsive:true,
                deferRender: true,
                
                "lengthMenu": [[50, 100], [50, 100]],
                "pagingType": "simple",
                language: {
                    search: '',
                    searchPlaceholder: "Search here"
                },
                "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-4'><'col-sm-12 col-md-4'i><'col-sm-12 col-md-4'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{url('showLeaveType')}}",
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
                        data: 'LeaveType',
                        name: 'LeaveType',
                        width:"18%"
                    },
                    {
                        data: 'Year',
                        name: 'Year',
                        width:"15%"
                    },
                    {
                        data: 'LeavePaymentType',
                        name: 'LeavePaymentType',
                        width:"15%"
                    },
                    {
                        data: 'RequireBalance',
                        name: 'RequireBalance',
                        width:"15%"
                    },
                    {
                        data: 'NumberOfDays',
                        name: 'NumberOfDays',
                        width:"15%"
                    },
                    {
                        data: 'Remark',
                        name: 'Remark',
                        width:"19%"
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
                    $('#leaveTypeDiv').show();
                    $(".infoleave").collapse('show');
                    $("#informationmodal").modal('show');
                }
            });
        }

        $("#leaveadds").click(function() {
            var leavefrom = $('#LeaveFrom').val();
            if(leavefrom == "" || leavefrom == null){
                $('#leavefrom-error').html("Leave from field is required");
                toastrMessage('error',"Please fill required fields","Error");
            }
            else{
                ++i;
                ++m;
                j += 1;
                $("#leavetypetbl > tbody").append(`<tr>
                    <td style="font-weight:bold;text-align:center;width:3%">${j}</td>
                    <td style="display:none;"><input type="hidden" name="leaverow[${m}][vals]" id="vals${m}" class="vals form-control" readonly="true" style="font-weight:bold;" value="${m}"/></td>
                    <td style="width:15%"><select id="leavetype${m}" class="select2 form-control leavetype" onchange="leavetypeFn(this)" name="leaverow[${m}][LeaveType]"></select></td> 
                    <td style="width:13%"><select id="leaveyear${m}" class="select2 form-control leaveyear" onchange="leaveyearFn(this)" name="leaverow[${m}][Year]"></select></td> 
                    <td style="width:13%"><select id="LeavePaymentType${m}" class="select2 form-control LeavePaymentType" onchange="LeavePaymentTypeFn(this)" name="leaverow[${m}][LeavePaymentType]"></select></td> 
                    <td style="width:13%"><input type="text" placeholder="Requires Balance" id="RequireBalance${m}" class="RequireBalance form-control numeral-mask" name="leaverow[${m}][RequireBalance]" readonly style="font-weight:bold;font-size:13px;"/></td>
                    <td style="width:13%"><input type="number" placeholder="Leave Balance" id="leavebalance${m}" class="leavebalance form-control numeral-mask" name="leaverow[${m}][LeaveBalance]" readonly onkeypress="return ValidateNum(event);" style="font-weight:bold;font-size:13px;"/></td>
                    <td style="width:13%"><input type="number" placeholder="Write no. of day(s) here..." id="NoOfDays${m}" class="NoOfDays form-control numeral-mask" name="leaverow[${m}][NoOfDays]" onkeyup="TotalLeaveBalanceFn(this)" onkeypress="return ValidateNum(event);" step="any"/></td>
                    <td style="width:14%;"><input type="text" placeholder="Write remark here..." id="Remark${m}" class="Remark form-control" name="leaverow[${m}][Remark]"/></td>
                    <td style="width:5%;text-align:center;"><button type="button" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>
                </tr>`);

                var defaultoption = '<option selected disabled value=""></option>';
                var leavetypelist = $("#defaultleavetype > option").clone();
                $(`#leavetype${m}`).append(leavetypelist);
                $(`#leavetype${m}`).append(defaultoption);
                $(`#leavetype${m}`).select2({placeholder: "Select leave type here"});

                $(`#leaveyear${m}`).append(defaultoption);
                $(`#leaveyear${m}`).select2({placeholder: "Select leave type first",minimumResultsForSearch: -1});

                $(`#LeavePaymentType${m}`).append(defaultoption);
                $(`#LeavePaymentType${m}`).select2({placeholder: "Select leave type first",minimumResultsForSearch: -1});

                $(`#select2-leavetype${m}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                $(`#select2-leaveyear${m}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                $("#table-error").html("");
                renumberRows();
            }
        });

        $(document).on('click', '.remove-tr', function() {
            $(this).parents('tr').remove();
            TotalLeaveBalanceFn(this);
            renumberRows();
            calculateEndDateFn();
            --i;
        });

        function renumberRows() {
            $('#leavetypetbl > tbody > tr').each(function(index, el) {
                $(this).children('td').first().text(++index);
            });
        }

        function TotalLeaveBalanceFn(ele){
            var totalleave=0;
            var idval = $(ele).closest('tr').find('.vals').val();
            var leavetypes = $(`#leavetype${idval}`).val();
            var requirebalance = $(`#defaultleavetype option[value="${leavetypes}"]`).attr('label');
            var numofday = $(`#NoOfDays${idval}`).val();
            var leavebalance = $(`#leavebalance${idval}`).val();

            $(`#NoOfDays${idval}`).css("background","#FFFFFF");
            $('#savebutton').prop("disabled",true);

            if(requirebalance == "Yes"){
                numofday = numofday == '' ? 0 : numofday;
                leavebalance = leavebalance == '' ? 0 : leavebalance;
                if(parseFloat(leavebalance) < parseFloat(numofday)){
                    $(`#NoOfDays${idval}`).val("");
                    $(`#NoOfDays${idval}`).css("background",errorcolor);
                    toastrMessage('error',"Insufficient leave balance","Error");
                }
            }

            $.each($('#leavetypetbl').find('.NoOfDays'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    totalleave += parseFloat($(this).val());
                }
            });
            $("#LeaveTo").val("");
            $('#totalnumberofdays').html(parseFloat(totalleave) <= 0 ? '' : `${totalleave} day(s)`);
        }

        function totalCalcNumOfDay(){
            var totalleave = 0;
            $.each($('#leavetypetbl').find('.NoOfDays'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    totalleave += parseFloat($(this).val());
                }
            });
            $('#totalnumberofdays').html(parseFloat(totalleave) <= 0 ? '' : `${totalleave} day(s)`);
        }

        function totalNumOfDay(){
            var totalleave = 0;
            $.each($('#leavetypetbl').find('.NoOfDays'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    totalleave += parseFloat($(this).val());
                }
            });
            return totalleave;
        }

        // Final validation on blur
        $(document).on('blur', '.NoOfDays', function () {
            const val = $(this).val();
            const num = parseFloat(val);
            var leaveFrom=$('#LeaveFrom').val();
            var maxdate=$("#LeaveTo").val();
            var leaveDurType=$("#LeaveDurationType").val();

            calculateEndDateFn();
            // Allow empty
            if (val === '') return;

            // Allow natural numbers and .5 fractions
            const isValid = Number.isInteger(num) || (num % 1 === 0.5);

            if (!isValid) {
                $(this).val('');
                toastrMessage('error',"Only natural numbers or X.5 values are allowed","Error");
                TotalLeaveBalanceFn(this);
                $(this).css("background",errorcolor);
            }
            
        });

        function calculateEndDateFn(){
            var leavefrom = $('#LeaveFrom').val();

            if (leavefrom == "" || leavefrom == null || totalNumOfDay() <= 0) {
                return false; 
            }

            var leavefrom = "";
            var employeeid = "";
            var totalday = 0;
            
            $.ajax({
                url: "{{ url('calcEndDate') }}",
                type: 'POST',
                data:{
                    employeeid:$("#RequestFor").val(),
                    leavefrom:$("#LeaveFrom").val(),
                    totalday:totalNumOfDay(),
                },
                success: function(data) {
                    if(data.emptyAssign){
                        flatpickr('#LeaveTo', {clickOpens:false,defaultDate: ""});
                        $("#LeaveTo").val("");
                        $('#leaveto-error').html("Schedule assignment not found");
                        toastrMessage('error',"Schedule assignment not found","Error");
                        $('#savebutton').prop("disabled",false);
                    }
                    else if(data.assignError){
                        flatpickr('#LeaveTo', {clickOpens:false,defaultDate: ""});
                        $("#LeaveTo").val("");
                        $('#leaveto-error').html("Schedule assignment not found");
                        toastrMessage('error',`Schedule assignment not found from <b>${data.date}</b>`,"Error");
                        $('#savebutton').prop("disabled",false);
                    }
                    else if(data.end_date){
                        $("#leaveEndDateMinDate").val(data.end_date);
                        var readonlyboolean = $("#LeaveDurationType").val() == "Non-Consecutive" ? true : false;
                        flatpickr('#LeaveTo', { dateFormat: 'Y-m-d',clickOpens:readonlyboolean,minDate:data.end_date,defaultDate: ""});

                        $("#LeaveTo").val($("#LeaveDurationType").val() == "Non-Consecutive" ? "" : data.end_date);
                        $('#savebutton').prop("disabled",false);
                        $('#leaveto-error').html("");
                    }
                }
            });
        }

        function leavetypeFn(ele){
            var idval = $(ele).closest('tr').find('.vals').val();
            var leavetypeval = $(`#leavetype${idval}`).val();
            var leaveyear = $(`#leaveyear${idval}`).val();
            var leavepaymenttype = $(`#LeavePaymentType${idval}`).val();
            var paymenttype = $(`#leavetype${idval} option[value="${leavetypeval}"]`).attr('title');
            
            $(`#RequireBalance${idval}`).val("");

            if (isDuplicateCombination(leavetypeval, leaveyear, leavepaymenttype, idval)) {
                $(`#leavetype${idval}`).val(null).trigger('change').select2
                ({
                    placeholder: "Select leave type here",
                });
                toastrMessage('error',"Duplicate leave type found with all property","Error");
                $(`#select2-leavetype${idval}-container`).parent().css('background-color',errorcolor);
            }
            else{
                var reqbalance = $(`#leavetype${idval} option[value="${leavetypeval}"]`).attr('data-reqbalance');
                $(`#RequireBalance${idval}`).val(reqbalance);
                getYears(idval);
                $(`#LeavePaymentType${idval}`).empty();

                if(paymenttype == "Paid" || paymenttype == "Unpaid"){
                    $(`#LeavePaymentType${idval}`).append(`<option selected value="${paymenttype}">${paymenttype}</option>`);
                    $(`#LeavePaymentType${idval}`).select2({minimumResultsForSearch: -1});
                }
                else if(paymenttype == "Paid-or-Unpaid"){
                    $(`#LeavePaymentType${idval}`).append(`<option value="Paid">Paid</option><option value="Unpaid">Unpaid</option>`);
                    $(`#LeavePaymentType${idval}`).append(defaultoption);
                    $(`#LeavePaymentType${idval}`).select2({placeholder: "Select leave payment type here...",minimumResultsForSearch: -1});
                }

                var leaveyeardupcheck = $(`#leaveyear${idval}`).val();
                var leavepaymenttypedupcheck = $(`#LeavePaymentType${idval}`).val();

                if (isDuplicateCombination(leavetypeval, leaveyeardupcheck, leavepaymenttypedupcheck, idval)) {
                    $(`#leavetype${idval}`).val(null).trigger('change').select2
                    ({
                        placeholder: "Select leave type here",
                    });
                    $(`#leaveyear${idval}`).val(null).trigger('change').select2
                    ({
                        placeholder: "Select year here",
                    });
                    $(`#LeavePaymentType${idval}`).val(null).trigger('change').select2
                    ({
                        placeholder: "Select leave payment type here",
                    });
                    
                    $(`#select2-leavetype${idval}-container`).parent().css('background-color',errorcolor);
                    $(`#select2-leaveyear${idval}-container`).parent().css('background-color',errorcolor);
                    $(`#select2-LeavePaymentType${idval}-container`).parent().css('background-color',errorcolor);

                    toastrMessage('error',"Duplicate record found","Error");
                }
            }
        }

        function leaveyearFn(ele){
            var idval = $(ele).closest('tr').find('.vals').val();
            var leavetypeval = $(`#leavetype${idval}`).val();
            var leaveyear = $(`#leaveyear${idval}`).val();
            var leavepaymenttype = $(`#LeavePaymentType${idval}`).val();

            if (isDuplicateCombination(leavetypeval, leaveyear, leavepaymenttype, idval)) {
                $(`#leaveyear${idval}`).val(null).trigger('change').select2
                ({
                    placeholder: "Select year here",
                });
                toastrMessage('error',"Duplicate year found with all property","Error");
                $(`#select2-leaveyear${idval}-container`).parent().css('background-color',errorcolor);
            }
            else{
                calculateLeaveBalance(idval);
                $(`#select2-leaveyear${idval}-container`).parent().css('background-color',"white");
            }
        }

        function LeavePaymentTypeFn(ele){
            var idval = $(ele).closest('tr').find('.vals').val();
            var leavetypeval = $(`#leavetype${idval}`).val();
            var leaveyear = $(`#leaveyear${idval}`).val();
            var leavepaymenttype = $(`#LeavePaymentType${idval}`).val();

            if (isDuplicateCombination(leavetypeval, leaveyear, leavepaymenttype, idval)) {
                $(`#LeavePaymentType${idval}`).val(null).trigger('change').select2
                ({
                    placeholder: "Select leave payment type here",
                });
                toastrMessage('error',"Duplicate leave payment found with all property","Error");
                $(`#select2-LeavePaymentType${idval}-container`).parent().css('background-color',errorcolor);
            }
            else{
                $(`#select2-LeavePaymentType${idval}-container`).parent().css('background-color',"white");
            }
        }

        function getYears(indx){
            var leavetypes = $(`#leavetype${indx}`).val();
            var employee = $("#RequestFor").val();
            var empleave = employee+""+leavetypes;
            var requirebalance = $(`#leavetype${indx} option[value="${leavetypes}"]`).attr('label');

            $(`#leaveyear${indx}`).empty();
            if(requirebalance == "Yes"){
                var yearlist = $("#defaultyear > option").clone();
                $(`#leaveyear${indx}`).append(yearlist);
                $(`#leaveyear${indx} option[title!="${empleave}"]`).remove(); 
                $(`#leaveyear${indx}`).append(defaultoption);
                $(`#leaveyear${indx}`).select2({placeholder: "Select year here"});

                calculateLeaveBalance(indx);
            }
            else{
                $(`#leaveyear${indx}`).append(`<option selected value="-">-</option>`);
                $(`#leaveyear${indx}`).select2({minimumResultsForSearch: -1});
            }

            $(`#select2-leavetype${indx}-container`).parent().css('background-color',"white");
        }

        function calculateLeaveBalance(indx){
            var leavetypes = $(`#leavetype${indx}`).val();
            var leaveyear = $(`#leaveyear${indx}`).val();
            var employee = $("#RequestFor").val();
            var requirebalance = $(`#defaultleavetype option[value="${leavetypes}"]`).attr('label');

            if (!leavetypes || !leaveyear || !employee || requirebalance == "No") {
                $(`#leavebalance${indx}`).val("");
                return false; 
            }

            var leavetypedata, leaveyeardata, employeedata, recordId;

            $.ajax({
                url: "{{ url('calcLeaveBalance') }}",
                type: 'POST',
                data:{
                    leavetypedata:$(`#leavetype${indx}`).val(),
                    leaveyeardata:$(`#leaveyear${indx}`).val(),
                    employeedata:$("#RequestFor").val(),
                    recordId:$('#recId').val(),
                },
                success: function(data) {
                    $(`#leavebalance${indx}`).val(data.leavebalance);
                }
            });
        }

        function isDuplicateCombination(firstValue, secondValue, thirdValue, currentRow) {
            if (!firstValue || !secondValue || !thirdValue) {
                return false; // Skip check if either value is empty
            }

            let isDuplicate = false;
            let count = 0;

            $('#leavetypetbl > tbody > tr').each(function () {
                if ($(this).is(currentRow)) return;

                let first = $(this).find('.leavetype').val();
                let second = $(this).find('.leaveyear').val();
                let third = $(this).find('.LeavePaymentType').val();

                if (first === firstValue && second === secondValue && third === thirdValue) {
                    count++;
                }
            });

            return count > 1;
        }

        function getEmployeeData(empid){
            $.get("/showEmployeeData" + '/' + empid, function(data) {
                flatpickr('#LeaveFrom', { dateFormat: 'Y-m-d',clickOpens:true,minDate:data.mindate,defaultDate: ""});
                $('#LeaveFrom').val("");
            });
        }

        function assignEndDate(leaveDurType,leaveFrom){
            if (!leaveDurType || !leaveFrom) {
                return false; // Skip check if either value is empty
            }
            var mindate=$('#LeaveFrom').val();
            var mindateval=$('#leaveEndDateMinDate').val();

            if(leaveDurType == "Non-Consecutive"){
                flatpickr('#LeaveTo', { dateFormat: 'Y-m-d',clickOpens:true,minDate:mindateval,defaultDate: ""});
                $("#LeaveTo").val("");
                $('#LeaveTo').css("background", "white");
                $("#consdescription").html("");
            }
            else{
                $("#LeaveTo").val("");
                flatpickr('#LeaveTo', {clickOpens:false});
                $('#LeaveTo').css("background", "#efefef");
                $("#consdescription").html(leavendDateDesc);
            }
        }

        function forwardActionFn() {
            const requestId = $('#reqId').val();
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
                url: '/leaveReqForwardAction',
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
                    if (data.inserror) {
                        $('#forwardActionBtn').text(btntxt);
                        $('#forwardActionBtn').prop("disabled",false);
                        $("#forwardActionModal").modal('hide');
                        toastrMessage('error',"Thea following leave type and year have no balance</br>---------------------</br>"+data.insList,"Error");
                    }
                    else if (data.dberrors) {
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
            const requestId = $('#reqId').val();
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
                url: '/leaveReqBackwardAction',
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
                    // else if(data.statuserror){
                    //     $('#backwardActionBtn').text(btntxt);
                    //     $('#backwardActionBtn').prop("disabled",false);
                    //     $('#backwardActionModal').modal('hide');
                    //     toastrMessage('error',"Leave request status should be on Pending","Error");
                    // }
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

        function commentValFn() {
            $('#commentres-error').html("");
        }

        function getApproveInfo()
        {
            var rid=$('#reqId').val();
            $('#appId').val(rid);
            $('#approveconmodal').modal('show');
            $('#conapprovebtn').text("Approve");
            $('#conapprovebtn').prop( "disabled", false );
        }

        function getCommentInfo()
        {
            var status=$('#statusi').val();
            var rid=$('#reqId').val();
            $('#commentid').val(rid);
            $('#commentstatus').val(status);
            $('#commentModal').modal('show');
            $("#Comment").focus();
            $('#concommentbtn').text("Comment");
            $('#concommentbtn').prop( "disabled", false );
        }

        function getRejectInfo()
        {
            var status=$('#statusi').val();
            var rid=$('#reqId').val();
            $('#rejId').val(rid);
            $('#rejstatus').val(status);
            $('#rejectconmodal').modal('show');
            $('#conrejectbtn').text("Reject");
            $('#conrejectbtn').prop( "disabled", false );
        }

        //Start approve here
        $('#conapprovebtn').click(function() {
            var registerForm = $("#approveform");
            var formData = registerForm.serialize();
            $.ajax({
                url:'/approveLeaveReq',
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
                    $('#conapprovebtn').text('Approving...');
                    $('#conapprovebtn').prop( "disabled", true );
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
                success:function(data) 
                {
                    if(data.errorins){
                        $('#conapprovebtn').text('Approve');
                        $('#conapprovebtn').prop("disabled",false);
                        $("#approveconmodal").modal('hide');
                        toastrMessage('error',"Insufficient leave balance ","Error");
                    }
                    else if (data.dberrors) {
                        $('#conapprovebtn').text('Approve');
                        $('#conapprovebtn').prop("disabled",false);
                        $("#approveconmodal").modal('hide');
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if(data.success){
                        $('#conapprovebtn').text('Approve');
                        toastrMessage('success',"Successful","Success");
                        $("#approveconmodal").modal('hide');
                        $("#informationmodal").modal('hide');
                        var oTable = $('#laravel-datatable-crud').dataTable(); 
                        oTable.fnDraw(false);
                    }
                },
            });
        });
        //End Approve

        //Start Rejection
        $('#conrejectbtn').click(function() {
            var registerForm = $("#rejectform");
            var formData = registerForm.serialize();
            $.ajax({
            url:'/rejLeaveReq',
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
                    $('#conrejectbtn').text('Rejecting...');
                    $('#conrejectbtn').prop( "disabled", true );
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
                    if (data.dberrors) {
                        $('#conrejectbtn').text('Reject');
                        $('#conrejectbtn').prop("disabled",false);
                        $("#rejectconmodal").modal('hide');
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if(data.success) {
                        $('#conrejectbtn').text('Reject');
                        toastrMessage('success',"Successful","Success");
                        $("#rejectconmodal").modal('hide');
                        $("#informationmodal").modal('hide');
                        var oTable = $('#laravel-datatable-crud').dataTable(); 
                        oTable.fnDraw(false);
                        $("#rejectform")[0].reset();
                    }
                },
            });
        });
        //End Rejection

        //Start Comment
        $('#concommentbtn').click(function() {
            var registerForm = $("#commentform");
            var formData = registerForm.serialize();
            $.ajax({
            url:'/commLeaveReq',
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
                    $('#concommentbtn').text('Commenting...');
                    $('#concommentbtn').prop( "disabled", true );
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
                    if(data.errors){
                        if(data.errors.Comment){
                            $('#comment-error' ).html( data.errors.Comment[0] );
                        }
                        $('#concommentbtn').text('Comment');
                        $('#concommentbtn').prop( "disabled",false);
                        closeCommentReqFn();
                        toastrMessage('error',"Check your inputs","Error"); 
                    }
                    else if (data.dberrors) {
                        $('#concommentbtn').text('Reject');
                        $('#concommentbtn').prop("disabled",false);
                        $("#commentModal").modal('hide');
                        closeCommentReqFn();
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if(data.success) {
                        $('#concommentbtn').text('Comment');
                        $('#concommentbtn').prop("disabled",false);
                        toastrMessage('success',"Successful","Success");
                        $("#commentModal").modal('hide');
                        $("#informationmodal").modal('hide');
                        var oTable = $('#laravel-datatable-crud').dataTable(); 
                        oTable.fnDraw(false);
                        closeCommentReqFn();
                    }
                },
            });
        });
        //End Comment

        function leavemgtVoidFn(recordId) { 
            var settcnt=0;
            var detcnt=0;
            $('#delidi').val(recordId);
            $('.Reason').val("");
            $.get("/showleave" + '/' + recordId, function(data) {
                $.each(data.leavelist, function(key, value) {
                    var statusvals = value.Status;
                    if (statusvals === "Draft" || statusvals === "Pending" || statusvals === "Verified" || statusvals === "Approved") {
                        $("#deletereq").modal('show');
                    } 
                    else {
                        toastrMessage('error',"You cant void on this status","Error");
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                    }
                });
            });
        }

        //Void requisition starts
        $('#deletereqdatabtn').click(function() {
            var deleteForm = $("#deletereqform");
            var formData = deleteForm.serialize();
            $.ajax({
                url: '/voidLeaveReq',
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
                    $('#deletereqdatabtn').text('Voiding...');
                    $('#deletereqdatabtn').prop("disabled", true);
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
                        $('#deletereqdatabtn').text('Void');
                        $('#deletereqdatabtn').prop("disabled", false);
                        toastrMessage('error',"Check your inputs","Error");
                    }
                    else if (data.dberrors) {
                        $('#deletereqdatabtn').text('Void');
                        $('#deletereqdatabtn').prop("disabled",false);
                        $("#deletereq").modal('hide');
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if (data.success) {
                        $('#deletereqdatabtn').text('Void');
                        toastrMessage('success',"Successful","Success");
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                        $("#deletereq").modal('hide');
                        $('#deletereqdatabtn').prop("disabled", false);
                        voidReasonCloseFn();
                    }
                }
            });
        });
        //Void requisition ends

        function leavemgtUndoVoidFn(recordId) { 
            var settcnt=0;
            var detcnt=0;
            $('#undovoidid').val(recordId);
            $.get("/showleave" + '/' + recordId, function(data) {
                $.each(data.leavelist, function(key, value) {
                    var statusvals = value.Status;
                    if (statusvals == "Void" || statusvals == "Void(Draft)" || statusvals == "Void(Pending)" || statusvals == "Void(Verified)" || statusvals == "Void(Approved)"){
                        $('#undovoidbtn').prop("disabled", false);
                        $('#undovoidbtn').text("Undo Void");
                        $("#undovoidmodal").modal('show');
                    } 
                    else {
                        toastrMessage('error',"The requisition should be voided","Error");
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                    }
                });
            });
        }
        
        //Undo void requisition starts
        $('#undovoidbtn').click(function() {
            var deleteForm = $("#undovoidform");
            var formData = deleteForm.serialize();
            $.ajax({
                url: '/undoVoidLeaveReq',
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
                    if (data.inserror) {
                        $('#undovoidbtn').text('Undo Void');
                        $('#undovoidbtn').prop("disabled",false);
                        $("#undovoidmodal").modal('hide');
                        toastrMessage('error',"Thea following leave type and year have no balance</br>---------------------</br>"+data.insList,"Error");
                    }
                    else if (data.dberrors) {
                        $('#undovoidbtn').text('Undo Void');
                        $('#undovoidbtn').prop("disabled",false);
                        $("#undovoidmodal").modal('hide');
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if (data.success) {
                        $('#undovoidbtn').text('Undo Void');
                        toastrMessage('success',"Successful","Success");
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                        $("#undovoidmodal").modal('hide');
                        $('#undovoidbtn').prop("disabled", false);
                    }
                }
            });
        });
        //Undo void requisition ends
        
        $('#deleterecbtn').click(function() {
            var delform = $("#deleteForm");
            var formData = delform.serialize();
            $.ajax({
                url: '/deleteposition',
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

        function requestforFn() {
            var reqfor=$('#RequestFor').val();
            getEmployeeData(reqfor);
            $("#LeaveFrom").val("");

            $('#leavetypetbl > tbody > tr').each(function () {
                let rowind = $(this).find('.vals').val();
                getYears(rowind);
            });

            $('#reqfor-error').html("");
        }

        function leavetypesFn() {
            var leavebalance=null;
            var leavetypes=$('#LeaveType').val();
            var registerForm = $("#Register");
            var formData = registerForm.serialize();
            $.ajax({
                url: '/getLeaveBalance',
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
                    $.each(data.leavedata, function(key, value) {
                        $('#dependOnBal').val(value.DepOnBalance);
                        $('#LeaveBalance').val(value.LeaveBalance);
                    });
                    
                }
            });
            $('#LeaveFrom').daterangepicker({ 
                singleDatePicker: true,
                showDropdowns: true,
                autoApply:true,
                //minDate:currdate,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });
            $("#LeaveFrom").prop("disabled",false);
            $('#LeaveFrom').val("");
            $('#LeaveTo').val("");
            $('#LeaveBalance').val("");
            $('#NumberOfDays').val("");
            $('#leavetype-error').html('');
        }

        function leavefromFn() {
            var leaveFrom=$('#LeaveFrom').val();
            var maxdate=$("#LeaveTo").val();
            var leaveDurType=$("#LeaveDurationType").val();
            
            assignEndDate(leaveDurType,leaveFrom);
            calculateEndDateFn();
            $('#leavefrom-error').html('');
        }

        function leavetoFn() {
            $('#leaveto-error').html('');
        }

        function dateDiff(){
            var leavetypes=$('#LeaveType').val();
            var leavebalance=$('#LeaveBalance').val()||0;
            var deponbalanceval=$('#dependOnBal').val()||0;
            var registerForm = $("#Register");
            var formData = registerForm.serialize();
            $.ajax({
                url: '/getLeaveDiff',
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
                    if(parseInt(deponbalanceval)==1){
                        if(parseInt(data.days)>parseInt(leavebalance)){
                            $('#NumberOfDays').val("");
                            $('#LeaveTo').val("");
                            toastrMessage('error',"Insufficient leave balance ","Error");
                        }
                        else if(parseInt(data.days)<=parseInt(leavebalance)){
                            $('#NumberOfDays').val(data.days);
                            $('#numofdays-error').html("");
                        }
                    }
                    else if(parseInt(deponbalanceval)==0){
                        $('#NumberOfDays').val(data.days);
                        $('#numofdays-error').html("");
                    }
                }
            });
        }

        function leaveDurTypeFn() {
            var leaveFrom=$('#LeaveFrom').val();
            var maxdate=$("#LeaveTo").val();
            var leaveDurType=$("#LeaveDurationType").val();
            
            assignEndDate(leaveDurType,leaveFrom);
            calculateEndDateFn();
            $('#leavedur-error').html('');
        }

        function leaveReasonFn() {
            $('#leavereason-error').html('');
        }

        function addressOnLeave() {
            $('#addressleave-error').html('');
        }

        function emergencyNameFn() {
            $('#emergencyname-error').html('');
        }

        function emergencyPhoneFn() {
            $('#emergencyphone-error').html('');
        }

        function emergencyEmailFn() {
            $('#Email-error').html('');
        }

        $("#DocumentUpload").change(function() {
            $('#docBtn').show();
            $('#documentupload-error').html('');
        });

        function docBtnFn() {
            $('#DocumentUpload').val("");
            $('#documentuploadfilelbl').val("");
            $('#DocumentUpload').val(null);
            $('#docBtn').hide();
            $('#documentupload-error').html('');
            $("#documentuploadlinkbtn").hide();
        }

        function documenDocumentFn() {
            var recordId = $('#recId').val();
            var filenames = $('#documentuploadfilelbl').val();
            $.get("/downloadLeaveDoc" + '/' + recordId + '/' + filenames, function(data) {
                var link = "../../../storage/uploads/LeaveSupportingDocument/" + filenames;
                window.open(link, '', 'width=1200,height=800,scrollbars=yes');
            });
        }

        function documentDocumentInfoFn() {
            var recordId = $('#reqId').val();
            var filenames = $('#filenameinfo').val();
            $.get("/downloadLeaveDoc" + '/' + recordId + '/' + filenames, function(data) {
                var link = "../../../storage/uploads/LeaveSupportingDocument/" + filenames;
                window.open(link, '', 'width=1200,height=800,scrollbars=yes');
            });
        }

        function remarkFn() {
            $('#remark-error').html('');
        }

        function commentReqFn(){
            $('#comment-error').html('');
        }

        function closeCommentReqFn(){
            $('#Comment').val('');
            $('#comment-error').html('');
        }

        function voidReason()
        {
            $('#void-error').html("");
        }

        function voidReasonCloseFn()
        {
            $('#Reason').val('');
            $('#void-error').html("");
        }

        function closeRegisterModal() {
            $('.mainforminp').val("");
            $('.errordatalabel').html("");
            $('#recId').val("");
            $('#operationtypes').val("1");
            $('#commentformdiv').hide();
            $("#leavetypetbl > tbody").empty();
            $('.dataclass').html("");
        }

    </script>
@endsection
