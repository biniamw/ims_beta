@extends('layout.app1')

@section('title')
@endsection

@section('content')

    @can('Salary-View')
    <div class="app-content content">
        <section id="responsive-datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom fit-content mb-0 pb-0">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align: left !important;align-items: center;padding: 10px 5px;">
                                        <h3 class="card-title form_title">Salary</h3>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align: right !important;align-items: center;padding: 10px 5px;">
                                        <button type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm" onclick="refreshSalaryDataFn()"><i class="fas fa-sync-alt"></i></button>
                                        @if (auth()->user()->can('Salary-Add'))
                                        <button type="button" class="btn btn-gradient-info btn-sm addsalary header-prop" id="addsalary"><i class="fas fa-plus"></i><span class="header-text">&nbsp Add</span></button>
                                        @endcan 
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-datatable">
                            <div style="width:99%; margin-left:0.5%;display: none;" id="salarydiv">
                                <table id="laravel-datatable-crud" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable mb-0 mobile-dt" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th style="display: none;"></th>
                                            <th style="width:3%;">#</th>
                                            <th style="width:15%;">Salary Name</th>
                                            <th style="width:13%;">Taxable Earnings</th>
                                            <th style="width:13%;">Non-Taxable Earnings</th>
                                            <th style="width:13%;">Total Earnings</th>
                                            <th style="width:13%">Total Deduction</th>
                                            <th style="width:13%;">Net Pay  <i title="Net Pay = (Taxable Earning - Total Deduction) + Total Non-Taxable" class="fas fa-info-circle"></i></th>
                                            <th style="width:13%;">Status</th>
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
                    <h4 class="modal-title form_title">Salary Information</h4>
                    <div class="row">
                        <div style="text-align: right" id="statuslbl_header"></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                </div>
                <form id="InformationForm">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <section id="card-text-alignment">
                                        <div class="d-flex justify-content-between align-items-center cursor-pointer border-bottom" data-toggle="collapse" data-target=".infoscl" aria-expanded="true">
                                            <h5 class="mb-0 form_title salary_header_info"><i class="far fa-info-circle"></i> Basic Information</h5>
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
                                                                    <td><label class="info_lbl">Salary Name</label></td>
                                                                    <td><label class="info_lbl" id="salarynamelbl" style="font-weight: bold;"></label></td>
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
                            <div class="row" id="salarydetaildiv" style="display: none;">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 table-responsive scroll scrdiv">
                                    <table id="salaryinfotbl" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable mb-0" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th colspan="6" style="width:3%;text-align:center;">Earnings</th>
                                            </tr>
                                            <tr>
                                                <th style="width:3%;">#</th>
                                                <th style="width:26%;">Salary Component Name</th>
                                                <th style="width:17%;">Taxable</th>
                                                <th style="width:17%;">Non-Taxable</th>
                                                <th style="width:17%;">Total</th>
                                                <th style="width:20%;">Remark</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table table-sm"></tbody>
                                        <tfoot class="table table-sm">
                                            <tr>
                                                <th colspan="2" style="text-align: right;">Total</th>
                                                <th style="text-align: left" id="infotaxableearning"></th>
                                                <th style="text-align: left" id="infonontaxableearning"></th>
                                                <th style="text-align: left" id="infototalearning"></th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12  table-responsive scroll scrdiv">
                                    <table id="salarydedinfotbl" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable mb-0" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th colspan="4" style="width:3%;text-align:center;">Deductions</th>
                                            </tr>
                                            <tr>
                                                <th style="width:3%;">#</th>
                                                <th style="width:33%;">Salary Component Name</th>
                                                <th style="width:32%;">Amount</th>
                                                <th style="width:32%;">Remark</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table table-sm"></tbody>
                                        <tfoot class="table table-sm">
                                            <tr>
                                                <th colspan="2" style="text-align: right;">Total</th>
                                                <th style="text-align: left" id="infodeductionamount"></th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-2 col-sm-0 col-0 mt-3"></div>
                                <div class="col-xl-4 col-lg-4 col-md-8 col-sm-12 col-12 mt-3">
                                    <table id="infoSummaryTable" class="rtable" style="width:100%;text-align: center">
                                        <thead>
                                            <tr>
                                                <th colspan="2" style="text-align: center">Summary</th>
                                            </tr>
                                        </thead>
                                        <tbody style="font-size: 12px;">
                                            <tr>
                                                <td style="width: 50%" id="infosummcompanypensionLbl">Company Pension</td>
                                                <td style="width: 50%" id="infocompensiondiv">
                                                    <div class="input-group">
                                                        <label id="infosummcompanypension" class="summfig" style="font-weight:bold;width:95%;position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);"></label>
                                                        <i id="companypensioninfobtn" class="fas fa-info-circle" style="width:5%;position: absolute;top: 50%;left: 95%;transform: translate(-50%, -50%);"></i>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="text-align: center">-</td>
                                            </tr>
                                            <tr>
                                                <td>Taxable Earning</td>
                                                <td>
                                                    <label id="infosummtaxableearning" class="summfig" style="font-weight:bold"></label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Non-Taxable Earning</td>
                                                <td>
                                                    <label id="infosummnontaxableearning" class="summfig" style="font-weight:bold"></label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Total Earning</td>
                                                <td>
                                                    <label id="infosummtotalearning" class="summfig" style="font-weight:bold"></label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Total Deduction</td>
                                                <td>
                                                    <label id="infosummtotaldeduction" class="summfig" style="font-weight:bold"></label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Net Pay</td>
                                                <td id="infonetpaydiv">
                                                    <div class="input-group">
                                                        <label id="infosummnetpay" class="summfig" style="font-weight:bold;width:95%;position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);"></label>
                                                        <i id="infonetpayinfo" class="fas fa-info-circle" style="width:5%;position: absolute;top: 50%;left: 95%;transform: translate(-50%, -50%);"></i>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-2 col-sm-0 col-0 mt-3"></div>
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
                                        <ul class="dropdown-menu" id="salary_action_ul"></ul>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align:right">
                                    <input type="hidden" class="form-control" name="delRecId" id="delRecId" readonly="true">
                                    <button id="closebuttonsalary" type="button" class="btn btn-danger form_btn" data-dismiss="modal">Close</button>
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
                    <h4 class="modal-title form_title" id="modaltitle">Add Salary</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="Register">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-1">
                                <label class="form_lbl">Salary Name<b style="color: red; font-size:16px;">*</b></label>
                                <input type="text" placeholder="Salary Name" class="form-control mainforminp reg_form" name="SalaryName" id="SalaryName" onkeyup="salaryNameFn()"/>
                                <span class="text-danger">
                                    <strong class="errordatalabel" id="name-error"></strong>
                                </span>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-1">
                                <label class="form_lbl">Description</label>
                                <textarea type="text" placeholder="Write Description here..." class="form-control mainforminp reg_form" rows="1" name="Description" id="Description" onkeyup="descriptionfn()"></textarea>
                                <span class="text-danger">
                                    <strong class="errordatalabel" id="description-error"></strong>
                                </span>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-1">
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
                        <hr class="my-30">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mt-1">
                                <table id="earningDynamicTable" class="rtable fit-content" style="width:100%">
                                    <thead style="font-size: 12px;">
                                        <tr>
                                            <th colspan="7" class="form_lbl" style="width:3%;text-align:center;">Earnings</th>
                                        </tr>
                                        <tr>
                                            <th class="form_lbl" style="width:3%;">#</th>
                                            <th class="form_lbl" style="width:25%;">Salary Component Name</th>
                                            <th class="form_lbl" style="width:16%;">Taxable</th>
                                            <th class="form_lbl" style="width:16%;">Non-Taxable</th>
                                            <th class="form_lbl" style="width:16%;">Total</th>
                                            <th class="form_lbl" style="width:19%;">Remark</th>
                                            <th class="form_lbl" style="width:5%;"></th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="2" style="background-color: #FFFFFF;border:none;padding:0px;">
                                                <button type="button" name="addearningbtn" id="addearningbtn" class="btn btn-success btn-sm" style="float:left;"><i class="fa fa-plus" aria-hidden="true"></i>  Add New</button>
                                                <label style="text-align:right;float:right;margin-top:5px">Total</label>
                                            </th>
                                            <th style="text-align: left;">
                                                <label id="totaltaxable" style="font-weight:bold"></label>
                                            </th>
                                            <th style="text-align: left;">
                                                <label id="totalnontaxable" style="font-weight:bold"></label>
                                            </th>
                                            <th style="text-align: left;">
                                                <label id="totalearning" style="font-weight:bold"></label>
                                            </th>
                                            <th colspan="2"></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mt-1">
                                <table id="deductionDynamicTable" class="rtable fit-content" style="width:100%">
                                    <thead style="font-size: 12px;">
                                        <tr>
                                            <th colspan="5" class="form_lbl" style="width:3%;text-align:center;">Deductions</th>
                                        </tr>
                                        <tr>
                                            <th class="form_lbl" style="width:3%;">#</th>
                                            <th class="form_lbl" style="width:31%;">Salary Component Name</th>
                                            <th class="form_lbl" style="width:31%;">Amount</th>
                                            <th class="form_lbl" style="width:30%;">Remark</th>
                                            <th class="form_lbl" style="width:5%;"></th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="2" style="background-color: #FFFFFF;border:none;padding:0px;">
                                                <button type="button" name="adddeductionbtn" id="adddeductionbtn" class="btn btn-success btn-sm" style="float:left;"><i class="fa fa-plus" aria-hidden="true"></i>  Add New</button>
                                                <label style="text-align:right;float:right;margin-top:5px">Total</label>
                                            </th>
                                            <th style="text-align: left;">
                                                <label id="totaldeduction" style="font-weight:bold"></label>
                                            </th>
                                            <th colspan="2"></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-2 col-sm-0 col-0 mt-3"></div>
                            <div class="col-xl-4 col-lg-4 col-md-8 col-sm-12 col-12 mt-3">
                                <table id="summaryTable" class="rtable" style="width:100%;text-align: center">
                                    <thead>
                                        <tr>
                                            <th colspan="2" style="text-align: center">Summary</th>
                                        </tr>
                                    </thead>
                                    <tbody style="font-size: 12px;">
                                        <tr>
                                            <td style="width: 50%" id="companypensiontitle">Company Pension</td>
                                            <td style="width: 50%" id="companypensiondiv">
                                                <div class="input-group">
                                                    <label id="summcompanypension" class="summfig" style="font-weight:bold;width:95%;position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);"></label>
                                                    <input type="hidden" class="form-control mainforminp" name="summcompanypensionInp" id="summcompanypensionInp" readonly/>
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
                                                <label id="summtaxableearning" class="summfig" style="font-weight:bold"></label>
                                                <input type="hidden" class="form-control mainforminp" name="summtaxableearningInp" id="summtaxableearningInp" readonly/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Non-Taxable Earning</td>
                                            <td>
                                                <label id="summnontaxableearning" class="summfig" style="font-weight:bold"></label>
                                                <input type="hidden" class="form-control mainforminp" name="summnontaxableearningInp" id="summnontaxableearningInp" readonly/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Total Earning</td>
                                            <td>
                                                <label id="summtotalearning" class="summfig" style="font-weight:bold"></label>
                                                <input type="hidden" class="form-control mainforminp" name="summtotalearningInp" id="summtotalearningInp" readonly/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Total Deduction</td>
                                            <td>
                                                <label id="summtotaldeduction" class="summfig" style="font-weight:bold"></label>
                                                <input type="hidden" class="form-control mainforminp" name="summtotaldeductionInp" id="summtotaldeductionInp" readonly/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Net Pay</td>
                                            <td id="netpaydiv">
                                                <div class="input-group">
                                                    <label id="summnetpay" class="summfig" style="font-weight:bold;width:95%;position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);"></label>
                                                    <input type="hidden" class="form-control mainforminp" name="summnetpayInp" id="summnetpayInp" readonly/>
                                                    <i id="netpayinfo" class="fas fa-info-circle" style="width:5%;position: absolute;top: 50%;left: 95%;transform: translate(-50%, -50%);"></i>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-2 col-sm-0 col-0 mt-3"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div style="display: none;">
                            <select class="select2 form-control" name="earningSalaryTypeDefault" id="earningSalaryTypeDefault">
                                <option selected disabled value=""></option>
                                @foreach ($earningsalary as $earningsalary)
                                    <option data-nontaxable="{{ $earningsalary->NonTaxableAmount }}" data-text="{{ $earningsalary->SalaryTypeName }}" value="{{ $earningsalary->id }}">{{ $earningsalary->SalaryTypeName}}</option>
                                @endforeach
                            </select> 
                            <select class="select2 form-control" name="deductionSalaryTypeDefault" id="deductionSalaryTypeDefault">
                                <option selected disabled value=""></option>
                                @foreach ($deductionsalary as $deductionsalary)
                                    <option data-text="{{ $deductionsalary->SalaryTypeName }}" value="{{ $deductionsalary->id }}">{{ $deductionsalary->SalaryTypeName}}</option>
                                @endforeach
                            </select> 
                            <input type="hidden" class="form-control" name="EmployeePension" id="EmployeePension" value="7"/>
                            <input type="hidden" class="form-control" name="CompanyPension" id="CompanyPension" value="11"/>
                            <input type="hidden" class="form-control" name="MinimumPensionAmount" id="MinimumPensionAmount" value="0"/>
                            <input type="hidden" placeholder="Net Salary" class="form-control" name="NetSalary" id="NetSalary" readonly onkeypress="return ValidateNum(event);" onkeyup="netsalaryFn()" />
                            <input type="hidden" class="form-control reg_form" name="recId" id="recId" readonly="true" value=""/>     
                            <input type="hidden" class="form-control reg_form" name="operationtypes" id="operationtypes" readonly="true"/>
                        </div>
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
        $(function () {
            cardSection = $('#page-block');
        });
        var globalIndex = -1;

        var j = 0;
        var i = 0;
        var m = 0;

        var je = 1;
        var ie = 1;
        var me = 1;

        var jd = 2;
        var id = 2;
        var md = 2;

        var taxRanges = [];

        $(document).ready( function () {
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
                    url: '/salarylist',
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
                    { data: 'id', name: 'id', 'visible': false},
                    { data: 'DT_RowIndex',width:"3%"},
                    { data: 'SalaryName', name: 'SalaryName',width:"15%"},
                    { data: 'TaxableEarning', name: 'TaxableEarning',width:"13%",render: $.fn.dataTable.render.number(',', '.',2, '')},
                    { data: 'NonTaxableEarning', name: 'TotalEarnings',width:"13%",render: $.fn.dataTable.render.number(',', '.',2, '')},
                    { data: 'TotalEarnings', name: 'TotalEarnings',width:"13%",render: $.fn.dataTable.render.number(',', '.',2, '')},
                    { data: 'TotalDeductions', name: 'TotalDeductions',width:"13%",render: $.fn.dataTable.render.number(',', '.',2, '')},
                    { data: 'NetSalary', name: 'NetSalary',width:"13%",render: $.fn.dataTable.render.number(',', '.',2, '')},
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
                        width:"13%"
                    },
                    { data: 'action', name: 'action',
                        "render": function ( data, type, row, meta ) {
                            return `<div class="text-center"><a class="salaryInfo" href="javascript:void(0)" onclick="salaryInfoFn(${row.id})" data-id="salary_id${row.id}" id="salary_id${row.id}" title="Open salary information form"><i class="fa-sharp fa-regular fa-circle-info fa-xl" style="color: #00cfe8;"></i></a></div>`;
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
                    $('#salarydiv').show();
                },
                fixedHeader: {
                    header: true,
                    headerOffset: $('.header-navbar').outerHeight(),
                },
            });
            getRangeData();
        });

        $('#laravel-datatable-crud tbody').on('click', 'tr', function () {
            $('#laravel-datatable-crud tbody > tr').removeClass('selected');
            $(this).addClass('selected');
            globalIndex = $(this).index();
        });

        function setFocus(targetTable) {
            $($(targetTable + ' tbody > tr')[globalIndex]).addClass('selected');
        }

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

        $("#addsalary").click(function() {
            resetSalaryFormFn();
            $("#inlineForm").modal('show');
        });

        function appendDefaultSalaryComp(){
            var earningdefaultdata = $("#earningSalaryTypeDefault > option").clone();
            var deductiondefaultdata = $("#deductionSalaryTypeDefault > option").clone();
            var earningId = [1];
            var deductionId = [2,3];

            $("#earningDynamicTable > tbody").empty();
            $("#deductionDynamicTable > tbody").empty();

            $.each(earningId, function(eindex, evalue) {
                var rowindex = ++eindex;
                $("#earningDynamicTable > tbody").append(`<tr>
                    <td style="font-weight:bold;width:3%;text-align:center;">${rowindex}</td>
                    <td style="display:none;"><input type="hidden" name="erow[${rowindex}][evals]" id="evals${rowindex}" class="evals form-control" readonly="true" style="font-weight:bold;" value="${rowindex}"/></td>
                    <td style="width:25%"><select id="SalaryType${rowindex}" class="select2 form-control SalaryType" onchange="salaryTypeFn(this)" name="erow[${rowindex}][SalaryType]"></select></td>
                    <td style="width:16%"><input type="number" placeholder="Taxable Earning" id="Taxable${rowindex}" class="Taxable form-control numeral-mask" name="erow[${rowindex}][Taxable]" onkeypress="return ValidateNum(event);" onkeyup="taxableFn(this)"/></td>
                    <td style="width:16%"><input type="number" placeholder="Non-Taxable Earning" id="NonTaxable${rowindex}" class="NonTaxable form-control numeral-mask" name="erow[${rowindex}][NonTaxable]" onkeypress="return ValidateNum(event);" onkeyup="nonTaxableFn(this)"/></td>
                    <td style="width:16%"><input type="number" placeholder="Total Earning" id="TotalEarning${rowindex}" class="TotalEarning form-control numeral-mask" name="erow[${rowindex}][TotalEarning]" readonly style="font-weight:bold" onkeypress="return ValidateNum(event);"/></td>
                    <td style="width:19%;"><input type="text" placeholder="Remark" id="Remark${rowindex}" class="Remark form-control" name="erow[${rowindex}][Remark]"/></td>
                    <td style="width:5%;"></td>
                    <td style="display:none;"><input type="hidden" name="erow[${rowindex}][NonTaxableDef]" id="NonTaxableDef${rowindex}" class="NonTaxableDef form-control" readonly="true" style="font-weight:bold;"/></td>
                </tr>`);

                var name = $(`#earningSalaryTypeDefault option[value="${evalue}"]`).attr('data-text');
                var nontaxableamnt = $(`#earningSalaryTypeDefault option[value="${evalue}"]`).attr('data-nontaxable');
                $(`#SalaryType${rowindex}`).append(`<option selected value="${evalue}">${name}</option>`);
                $(`#SalaryType${rowindex}`).select2({placeholder: "Select salary type",minimumResultsForSearch: -1});
                
                $(`#NonTaxable${rowindex}`).val(nontaxableamnt);
                $(`#NonTaxableDef${rowindex}`).val(nontaxableamnt);
                $(`#NonTaxable${rowindex}`).prop("readonly", parseFloat(nontaxableamnt) > 0 ? false : true);
                $(`#select2-SalaryType${rowindex}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
            });

            $.each(deductionId, function(dindex, dvalue) {
                var rowindex = ++dindex;
                $("#deductionDynamicTable > tbody").append(`<tr>
                    <td style="font-weight:bold;width:3%;text-align:center;">${rowindex}</td>
                    <td style="display:none;"><input type="hidden" name="drow[${rowindex}][dvals]" id="dvals${rowindex}" class="dvals form-control" readonly="true" style="font-weight:bold;" value="${rowindex}"/></td>
                    <td style="width:31%"><select id="SalaryTypeDed${rowindex}" class="select2 form-control SalaryTypeDed" onchange="salaryTypeDedFn(this)" name="drow[${rowindex}][SalaryTypeDed]"></select></td>
                    <td style="width:31%">
                        <div class="input-group">
                            <input type="number" placeholder="Deduction Amount" id="DedAmount${rowindex}" class="DedAmount form-control numeral-mask" name="drow[${rowindex}][DedAmount]" readonly onkeypress="return ValidateNum(event);" value="0.00" style="width:55%;"/>
                            <input type="text" id="TaxPercentInp${rowindex}" class="TaxPercentInp form-control numeral-mask" name="drow[${rowindex}][TaxPercentInp]" readonly style="width:40%;"/>  
                            <i id="DedAmountInfo${rowindex}" class="fas fa-info-circle" style="width:5%;position: absolute;top: 50%;left: 95%;transform: translate(-50%, -50%);"></i>
                        </div>  
                    </td>
                    <td style="width:30%;"><input type="text" placeholder="Remark" id="RemarkDed${rowindex}" class="RemarkDed form-control" name="drow[${rowindex}][Remark]"/></td>
                    <td style="width:5%;"></td>
                    <td style="display:none;"><input type="number" placeholder="Tax Percent" id="TaxPercent${rowindex}" class="TaxPercent form-control numeral-mask" name="drow[${rowindex}][TaxPercent]" readonly/></td>
                    <td style="display:none;"><input type="number" placeholder="Deduction" id="Deduction${rowindex}" class="Deduction form-control numeral-mask" name="drow[${rowindex}][Deduction]" readonly/></td>
                </tr>`);

                var name = $(`#deductionSalaryTypeDefault option[value="${dvalue}"]`).attr('data-text');
                $(`#SalaryTypeDed${rowindex}`).append(`<option selected value="${dvalue}">${name}</option>`);
                $(`#SalaryTypeDed${rowindex}`).select2({placeholder: "Select salary type",minimumResultsForSearch: -1});
                $(`#select2-SalaryTypeDed${rowindex}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
            });

            nonTaxableFn(this);
            taxableFn(this);
            calculateGrandTotal();
            calculateTotalDeduction();
            
        }

        function nonTaxableFn(ele){
            var idval = $(ele).closest('tr').find('.evals').val();
            var nontaxablehidden = $(`#NonTaxableDef${idval}`).val();
            var nontaxable = $(`#NonTaxable${idval}`).val();
            var taxable = $(`#Taxable${idval}`).val();
            var totalnontaxable = 0;

            nontaxable = nontaxable == '' ? 0 : nontaxable;
            nontaxablehidden = nontaxablehidden == '' ? 0 : nontaxablehidden;
            taxable = taxable == '' ? 0 : taxable;

            if(parseFloat(nontaxable) > parseFloat(nontaxablehidden)){
                $(`#NonTaxable${idval}`).val(nontaxablehidden);
                toastrMessage('error',`Non-Taxable amount can not be greater than <b>${nontaxablehidden}</b>`,"Error");
            }

            $.each($('#earningDynamicTable').find('.NonTaxable'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    totalnontaxable += parseFloat($(this).val());
                }
            });

            calculateTotal(idval);

            $(`#summnontaxableearning`).html(numformat(parseFloat(totalnontaxable).toFixed(2)));
            $(`#totalnontaxable`).html(numformat(parseFloat(totalnontaxable).toFixed(2)));
            $(`#summnontaxableearningInp`).val(parseFloat(totalnontaxable).toFixed(2));
            calculateGrandTotal();
            calculateTotalDeduction();
            $('#NonTaxable'+idval).css("background","white");
        }

        function nonTaxableKeyFn(ele){
            var idval = $(ele).closest('tr').find('.evals').val();
            $(`#Taxable${idval}`).val("");
            nonTaxableFn(this);
            taxableFn(this);
            calculateTotal(idval);
            calculateGrandTotal();
            calculateTotalDeduction();
        }

        function taxableFn(ele){
            var idval = $(ele).closest('tr').find('.evals').val();
            var nontaxablehidden = $(`#NonTaxableDef${idval}`).val();
            var nontaxable = $(`#NonTaxable${idval}`).val();
            var taxable = $(`#Taxable${idval}`).val();
            var totaltaxable = 0;
            var taxrate = 0;
            var taxpercent = 0;
            var incometax = 0;
            var deductionamount = 0;

            nontaxable = nontaxable == '' ? 0 : nontaxable;
            nontaxablehidden = nontaxablehidden == '' ? 0 : nontaxablehidden;
            taxable = taxable == '' ? 0 : taxable;

            calculateTotal(idval);

            $.each($('#earningDynamicTable').find('.Taxable'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    totaltaxable += parseFloat($(this).val());
                }
            });

            if (!isNaN(totaltaxable)) {
                $.each(taxRanges, function(i, range) {
                    if (parseFloat(totaltaxable) >= parseFloat(range.min) && parseFloat(totaltaxable) <= parseFloat(range.max)) {
                        taxrate = range.tax;
                        deductionamount = range.deduction;
                        return false; // break loop
                    }
                });
            }

            taxpercent = parseFloat(taxrate / 100).toFixed(2);
            incometax = parseFloat((totaltaxable * taxpercent) - deductionamount).toFixed(2);

            $(`#summtaxableearning`).html(numformat(parseFloat(totaltaxable).toFixed(2)));
            $(`#totaltaxable`).html(numformat(parseFloat(totaltaxable).toFixed(2)));
            $(`#summtaxableearningInp`).val(parseFloat(totaltaxable).toFixed(2));
            $(`#DedAmount1`).val(parseFloat(incometax).toFixed(2));
            $(`#TaxPercent1`).val(parseFloat(taxrate).toFixed(2));
            $(`#TaxPercentInp1`).val(`${parseFloat(taxrate).toFixed(2)}%`);
            $(`#Deduction1`).val(parseFloat(deductionamount).toFixed(2));
            $('#DedAmountInfo1').attr('title', `Taxable Earning: ${numformat(parseFloat(totaltaxable).toFixed(2))}\nTax Percent: ${taxrate}% \nDeduction: ${numformat(parseFloat(deductionamount).toFixed(2))}\n----------------------------------------\n(Taxable Earning * Tax Percent) - Deduction = Income Tax\n(${numformat(parseFloat(totaltaxable).toFixed(2))} * ${taxpercent}) - ${numformat(parseFloat(deductionamount).toFixed(2))} = ${numformat(parseFloat(incometax).toFixed(2))}`);
            calculateGrandTotal();
            calculateTotalDeduction();
            $(`#Taxable${idval}`).css("background","white");
        }

        function taxableKeyFn(ele){
            var idval = $(ele).closest('tr').find('.evals').val();
            var nontaxablehidden = $(`#NonTaxableDef${idval}`).val();
            $(`#NonTaxable${idval}`).val(nontaxablehidden);
            nonTaxableFn(this);
            taxableFn(this);
            calculateTotal(idval);
            calculateGrandTotal();
            calculateTotalDeduction();
        }

        function calculateTotal(idval){
            if (typeof idval !== 'undefined') {
                var nontaxablehidden = $(`#NonTaxableDef${idval}`).val();
                var nontaxable = $(`#NonTaxable${idval}`).val();
                var taxable = $(`#Taxable${idval}`).val();
                var salaryTypeId = $(`#SalaryType${idval}`).val();
                var minpensionamount = $(`#MinimumPensionAmount`).val();
                var totaltaxable = 0;
                var empPension = 0;
                var compPension = 0;
                var empPensionPercent = $(`#EmployeePension`).val();
                var compPensionPercent = $(`#CompanyPension`).val();
                var linetotal = 0;
                // $(`#DedAmount2`).val("0.00");
                nontaxable = nontaxable == '' ? 0 : nontaxable;
                nontaxablehidden = nontaxablehidden == '' ? 0 : nontaxablehidden;
                taxable = taxable == '' ? 0 : taxable;
                linetotal = parseFloat(nontaxable) + parseFloat(taxable);
                
                if(parseInt(salaryTypeId) == 1 && parseFloat(linetotal) > parseFloat(minpensionamount)){
                    empPension = ((parseFloat(linetotal) * parseFloat(empPensionPercent)) / 100);
                    compPension = ((parseFloat(linetotal) * parseFloat(compPensionPercent)) / 100);

                    $(`#DedAmount2`).val(parseFloat(empPension) > 0 ? (parseFloat(empPension).toFixed(2)) : "0.00");
                    $(`#summcompanypension`).html(parseFloat(compPension) > 0 ? numformat(parseFloat(compPension).toFixed(2)) : "");
                    $(`#summcompanypensionInp`).val(parseFloat(compPension) > 0 ? (parseFloat(compPension).toFixed(2)) : "");
                    $(`#TaxPercent2`).val(empPensionPercent);
                    $(`#TaxPercentInp2`).val(`${empPensionPercent}%`);
                    $('#DedAmountInfo2').attr('title', `Pension Percent: ${empPensionPercent}% \nBasic Salary: ${numformat(parseFloat(linetotal).toFixed(2))}\n----------------------------------------\nBasic Salary * Pension Percent = Pension\n${numformat(parseFloat(linetotal).toFixed(2))} * ${parseFloat(empPensionPercent / 100).toFixed(2)} = ${numformat(parseFloat(empPension).toFixed(2))}`);
                    $('#companypensiontitle').html(`Company Pension (${compPensionPercent}%)`);
                    $('#companypensioninfo').attr('title', `Pension Percent: ${compPensionPercent}% \nBasic Salary: ${numformat(parseFloat(linetotal).toFixed(2))}\n----------------------------------------\nBasic Salary * Pension Percent = Company Pension\n${numformat(parseFloat(linetotal).toFixed(2))} * ${parseFloat(compPensionPercent / 100).toFixed(2)} = ${numformat(parseFloat(compPension).toFixed(2))}`);
                }
                $(`#TotalEarning${idval}`).val(linetotal);
            }
        }

        function calculateGrandTotal(){
            var grandtotal = 0;
            var totalTaxableEarning =  $(`#summtaxableearningInp`).val();
            var totalDeduction =  $(`#summtotaldeductionInp`).val();
            var totalNonTaxable =  $(`#summnontaxableearningInp`).val();
           
            var netPay = 0;
            $.each($('#earningDynamicTable').find('.TotalEarning'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    grandtotal += parseFloat($(this).val());
                }
            });
            $(`#summtotalearning`).html(numformat(parseFloat(grandtotal).toFixed(2)));
            $(`#totalearning`).html(numformat(parseFloat(grandtotal).toFixed(2)));
            $(`#summtotalearningInp`).val(parseFloat(grandtotal).toFixed(2));

            netPay = (parseFloat(totalTaxableEarning) - parseFloat(totalDeduction)) + parseFloat(totalNonTaxable);
            $(`#summnetpay`).html(numformat(parseFloat(netPay).toFixed(2)));
            $(`#summnetpayInp`).val(parseFloat(netPay).toFixed(2));
            $('#netpayinfo').attr('title', `(Taxable Earning - Total Deduction) + Total Non-Taxable = Net Pay\n(${numformat(parseFloat(totalTaxableEarning).toFixed(2))} - ${numformat(parseFloat(totalDeduction).toFixed(2))}) + ${numformat(parseFloat(totalNonTaxable).toFixed(2))} = ${numformat(parseFloat(netPay).toFixed(2))}`);
        }

        function calculateTotalDeduction(){
            var totalDeduction = 0;
            var totalTaxableEarning =  $(`#summtaxableearningInp`).val();
            var totalNonTaxable =  $(`#summnontaxableearningInp`).val();
            var netPay = 0;
            $.each($('#deductionDynamicTable').find('.DedAmount'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    totalDeduction += parseFloat($(this).val());
                }
            });
            $(`#summtotaldeduction`).html(numformat(parseFloat(totalDeduction).toFixed(2)));
            $(`#totaldeduction`).html(numformat(parseFloat(totalDeduction).toFixed(2)));
            $(`#summtotaldeductionInp`).val(parseFloat(totalDeduction).toFixed(2));

            netPay = (parseFloat(totalTaxableEarning) - parseFloat(totalDeduction)) + parseFloat(totalNonTaxable);
            $(`#summnetpay`).html(numformat(parseFloat(netPay).toFixed(2)));
            $(`#summnetpayInp`).val(parseFloat(netPay).toFixed(2));
            $('#netpayinfo').attr('title', `(Taxable Earning - Total Deduction) + Total Non-Taxable = Net Pay\n(${numformat(parseFloat(totalTaxableEarning).toFixed(2))} - ${numformat(parseFloat(totalDeduction).toFixed(2))}) + ${numformat(parseFloat(totalNonTaxable).toFixed(2))} = ${numformat(parseFloat(netPay).toFixed(2))}`);
        }

        function deductionAmountFn(ele){
            var idval = $(ele).closest('tr').find('.dvals').val();
            var dedamount = $(`#DedAmount${idval}`).val();
            var totaldeduction = 0;

            $.each($('#deductionDynamicTable').find('.DedAmount'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    totaldeduction += parseFloat($(this).val());
                }
            });

            $(`#summtotaldeduction`).html(numformat(parseFloat(totaldeduction).toFixed(2)));
            $(`#totaldeduction`).html(numformat(parseFloat(totaldeduction).toFixed(2)));
            $(`#summtotaldeductionInp`).val(parseFloat(totaldeduction).toFixed(2));

            calculateGrandTotal();
            calculateTotalDeduction();
            $(`#DedAmount${idval}`).css("background","white");
        }

        $("#addearningbtn").click(function() {
            var lastrowindex = $('#earningDynamicTable > tbody > tr:last').find('td').eq(1).find('input').val();
            var salarytypeid = $(`#SalaryType${lastrowindex}`).val();
            var selectedValues = [];

            $('.SalaryType').each(function () {
                var val = $(this).val();
                if (val) {
                    selectedValues.push(val);
                }
            });

            if(salarytypeid !== undefined && salarytypeid === null){
                $(`#select2-SalaryType${lastrowindex}-container`).parent().css('background-color',errorcolor);
                toastrMessage('error',"Please select salary component from highlighted field","Error");
            }
            else{
                ++ie;
                ++me;
                je += 1;
                $("#earningDynamicTable > tbody").append(`<tr>
                    <td style="font-weight:bold;width:3%;text-align:center;">${me}</td>
                    <td style="display:none;"><input type="hidden" name="erow[${me}][evals]" id="evals${me}" class="evals form-control" readonly="true" style="font-weight:bold;" value="${me}"/></td>
                    <td style="width:25%"><select id="SalaryType${me}" class="select2 form-control SalaryType" onchange="salaryTypeFn(this)" name="erow[${me}][SalaryType]"></select></td>
                    <td style="width:16%"><input type="number" placeholder="Taxable Earning" id="Taxable${me}" class="Taxable form-control numeral-mask" name="erow[${me}][Taxable]" onkeypress="return ValidateNum(event);" onkeyup="taxableFn(this)"/></td>
                    <td style="width:16%"><input type="number" placeholder="Non-Taxable Earning" id="NonTaxable${me}" class="NonTaxable form-control numeral-mask" name="erow[${me}][NonTaxable]" onkeypress="return ValidateNum(event);" onkeyup="nonTaxableFn(this)"/></td>
                    <td style="width:16%"><input type="number" placeholder="Total Earning" id="TotalEarning${me}" class="TotalEarning form-control numeral-mask" name="erow[${me}][TotalEarning]" readonly style="font-weight:bold" onkeypress="return ValidateNum(event);"/></td>
                    <td style="width:19%;"><input type="text" placeholder="Remark" id="Remark${me}" class="Remark form-control" name="erow[${me}][Remark]"/></td>
                    <td style="width:5%;"><button id="earromvebtn${me}" type="button" class="btn btn-light btn-sm removeer-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>
                    <td style="display:none;"><input type="hidden" name="erow[${me}][NonTaxableDef]" id="NonTaxableDef${me}" class="NonTaxableDef form-control" readonly="true" style="font-weight:bold;"/></td>
                </tr>`);

                var defaultoption = '<option selected disabled value=""></option>';
                var earningdefaultdata = $("#earningSalaryTypeDefault > option").clone();
                $(`#SalaryType${me}`).append(earningdefaultdata);

                $.each(selectedValues, function(i, value) {
                    $(`#SalaryType${me} option[value="${value}"]`).remove(); 
                });

                $(`#SalaryType${me}`).append(defaultoption);
                $(`#SalaryType${me}`).select2({placeholder: "Select salary component here"});
                $(`#select2-SalaryType${me}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                renumberEarningRows();
            }
        });

        $(document).on('click', '.removeer-tr', function() {
            $(this).parents('tr').remove();
            nonTaxableFn(this);
            taxableFn(this);
            calculateTotal(idval);
            calculateGrandTotal();
            calculateTotalDeduction();
            renumberEarningRows();
            --ie;
        });

        function renumberEarningRows() {
            $('#earningDynamicTable > tbody > tr').each(function(index, el) {
                $(this).children('td').first().text(++index);
            });
        }

        $("#adddeductionbtn").click(function() {
            var lastrowindex = $('#deductionDynamicTable > tbody > tr:last').find('td').eq(1).find('input').val();
            var salarytypeid = $(`#SalaryTypeDed${lastrowindex}`).val();
            var selectedValues = [];

            $('.SalaryTypeDed').each(function () {
                var val = $(this).val();
                if (val) {
                    selectedValues.push(val);
                }
            });

            if(salarytypeid !== undefined && salarytypeid === null){
                $(`#select2-SalaryTypeDed${lastrowindex}-container`).parent().css('background-color',errorcolor);
                toastrMessage('error',"Please select salary component from highlighted field","Error");
            }
            else{
                ++id;
                ++md;
                jd += 1;
                $("#deductionDynamicTable > tbody").append(`<tr>
                    <td style="font-weight:bold;width:3%;text-align:center;">${md}</td>
                    <td style="display:none;"><input type="hidden" name="drow[${md}][dvals]" id="dvals${md}" class="dvals form-control" readonly="true" style="font-weight:bold;" value="${md}"/></td>
                    <td style="width:31%"><select id="SalaryTypeDed${md}" class="select2 form-control SalaryTypeDed" onchange="salaryTypeDedFn(this)" name="drow[${md}][SalaryTypeDed]"></select></td>
                    <td style="width:30%"><input type="number" placeholder="Deduction Amount" id="DedAmount${md}" class="DedAmount form-control numeral-mask" name="drow[${md}][DedAmount]" onkeypress="return ValidateNum(event);" onkeyup="deductionAmountFn(this)"/></td>
                    <td style="width:31%;"><input type="text" placeholder="Remark" id="RemarkDed${md}" class="RemarkDed form-control" name="drow[${md}][Remark]"/></td>
                    <td style="width:5%;"><button id="dedromvebtn${md}" type="button" class="btn btn-light btn-sm removede-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>
                    <td style="display:none;"><input type="number" placeholder="Tax Percent" id="TaxPercent${md}" class="TaxPercent form-control numeral-mask" name="drow[${md}][TaxPercent]" readonly onkeypress="return ValidateNum(event);"/></td>
                    <td style="display:none;"><input type="number" placeholder="Deduction" id="Deduction${md}" class="Deduction form-control numeral-mask" name="drow[${md}][Deduction]" readonly/></td>
                </tr>`);

                var defaultoption = '<option selected disabled value=""></option>';
                var deductiondefaultdata = $("#deductionSalaryTypeDefault > option").clone();
                $(`#SalaryTypeDed${md}`).append(deductiondefaultdata);

                $.each(selectedValues, function(i, value) {
                    $(`#SalaryTypeDed${md} option[value="${value}"]`).remove(); 
                });

                $(`#SalaryTypeDed${md}`).append(defaultoption);
                $(`#SalaryTypeDed${md}`).select2({placeholder: "Select salary component here"});
                $(`#select2-SalaryTypeDed${md}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                renumberDeductionRows();
            }
        });

        $(document).on('click', '.removede-tr', function() {
            $(this).parents('tr').remove();
            nonTaxableFn(this);
            taxableFn(this);
            calculateTotal(idval);
            calculateGrandTotal();
            calculateTotalDeduction();
            renumberDeductionRows();
            --id;
        });

        function renumberDeductionRows() {
            $('#deductionDynamicTable > tbody > tr').each(function(index, el) {
                $(this).children('td').first().text(++index);
            });
        }

        function salaryTypeFn(ele){
            var idval = $(ele).closest('tr').find('.evals').val();
            var salarytypeid = $('#SalaryType'+idval).val();
            var nontaxableamnt = $(`#earningSalaryTypeDefault option[value="${salarytypeid}"]`).attr('data-nontaxable');
            $(`#NonTaxable${idval}`).val(nontaxableamnt);
            $(`#NonTaxableDef${idval}`).val(nontaxableamnt);
            $(`#NonTaxable${idval}`).prop("readonly", parseFloat(nontaxableamnt) > 0 ? false : true);
            $(`#NonTaxable${idval}`).css("background",parseFloat(nontaxableamnt) > 0 ? "white" : "#efefef");
            $(`#select2-SalaryType${idval}-container`).parent().css('background-color',"white");

            nonTaxableFn(this);
            taxableFn(this);
            calculateTotal(idval);
            calculateGrandTotal();
            calculateTotalDeduction();
        }

        function salaryTypeDedFn(ele){
            var idval = $(ele).closest('tr').find('.dvals').val();
            $(`#select2-SalaryTypeDed${idval}-container`).parent().css('background-color',"white");
        }

        function salarytypefn(){
            $.get("/salarytypelistdata" , function(data) {
                $.each(data.salarylists, function(key, value) {
                    ++m;
                    if(parseInt(m)<=9){
                        m="0"+m;
                    }
                    $("#dynamicTable > tbody").append('<tr id="rowind'+m+'"><td style="font-weight:bold;width:3%;text-align:center;">'+m+'</td>'+
                        '<td style="display:none;"><input type="hidden" name="row['+m+'][vals]" id="vals'+m+'" class="vals form-control" readonly="true" style="font-weight:bold;" value="'+m+'"/></td>'+
                        '<td style="width:14%;"><input type="text" name="row['+m+'][SalaryTypeName]" id="SalaryTypeName'+m+'" class="SalaryTypeName form-control" readonly value="'+value.SalaryTypeName+'"/></td>'+
                        '<td style="width:16%;"><input type="text" name="row['+m+'][SalaryTypeDescription]" id="SalaryTypeDescription'+m+'" class="SalaryTypeDescription form-control" readonly value="'+value.Descriptions+'" placeholder="Leave type descrioption"/></td>'+
                        '<td style="width:13%;"><input type="text" name="row['+m+'][SalaryType]" id="SalaryType'+m+'" class="SalaryType form-control" readonly value="'+value.SalaryType+'"/></td>'+
                        '<td style="width:14%;"><input type="text" name="row['+m+'][EarningAmount]" id="EarningAmount'+m+'" class="EarningAmount form-control" onkeypress="return ValidateNum(event);" onkeyup="earningamntFn(this)" readonly placeholder="Earning Amount"/></td>'+
                        '<td style="width:14%;"><input type="text" name="row['+m+'][DeductionAmount]" id="DeductionAmount'+m+'" class="DeductionAmount form-control" onkeypress="return ValidateNum(event);" onkeyup="deductionamntFn(this)" readonly placeholder="Deduction Amount"/></td>'+
                        '<td style="width:16%;"><input type="text" name="row['+m+'][Remark]" id="Remark'+m+'" class="Remark form-control" placeholder="Write remark here..."/></td>'+
                        '<td style="width:10%;"><select id="Status'+m+'" class="select2 form-control form-control Status" name="row['+m+'][Status]" onchange="statusvalfn(this)"></select></td>'+
                        '<td style="display:none;"><input type="hidden" name="row['+m+'][salarytype_id]" id="salarytype_id'+m+'" class="salarytype_id form-control" readonly="true" style="font-weight:bold;" value="'+value.id+'"/></td></tr>'
                    );
                    if(value.SalaryType=="Earnings"){
                        $('#EarningAmount'+m).prop("readonly",false);
                        $('#DeductionAmount'+m).prop("readonly",true);
                        $('#DeductionAmount'+m).val("0");
                    }
                    else if(value.SalaryType=="Deductions"){
                        $('#EarningAmount'+m).prop("readonly",true);
                        $('#EarningAmount'+m).val("0");
                        $('#DeductionAmount'+m).prop("readonly",false);
                    }
                    var statusopt = '<option value="Active">Active</option><option value="Inactive">Inactive</option>';
                    $('#Status'+m).append(statusopt);
                    $('#Status'+m).select2
                    ({
                        placeholder: "Select Status here",
                        minimumResultsForSearch: -1
                    });
                });
            });
        }
       
        $('#savebutton').click(function() {
            var optype = $("#operationtypes").val();
            var registerForm = $("#Register");
            var formData = registerForm.serialize();
            var depmame="";
            var lastdep="";
            $.ajax({
                url: '/saveSalary',
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
                        if (data.errors.SalaryName) {
                            $('#name-error').html(data.errors.SalaryName[0]);
                        }
                        if (data.errors.Description) {
                            $('#description-error').html(data.errors.Description[0]);
                        }
                        if (data.errors.status) {
                            $('#status-error').html(data.errors.status[0]);
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
                    else if(data.errorsv2 || data.errorsv3){
                        $('#earningDynamicTable > tbody > tr').each(function () {
                            let salarytypeid = $(this).find('.SalaryType').val();
                            let taxable = $(this).find('.Taxable').val();
                            let nontaxable = $(this).find('.NonTaxable').val();
                            let rowind = $(this).find('.evals').val();

                            if(isNaN(parseFloat(salarytypeid))||parseFloat(salarytypeid)==0){
                                $(`#select2-SalaryType${rowind}-container`).parent().css('background-color',errorcolor);
                            }
                            if(taxable != undefined){
                                if(isNaN(parseFloat(taxable))){
                                    $(`#Taxable${rowind}`).css("background", errorcolor);
                                }
                            }
                            if(nontaxable != undefined){
                                if(isNaN(parseFloat(nontaxable))){
                                    $(`#NonTaxable${rowind}`).css("background", errorcolor);
                                }
                            }
                        });

                        $('#deductionDynamicTable > tbody > tr').each(function () {
                            let salarytypeid = $(this).find('.SalaryTypeDed').val();
                            let dedamount = $(this).find('.DedAmount').val();
                            let rowind = $(this).find('.dvals').val();

                            if(isNaN(parseFloat(salarytypeid))){
                                $(`#select2-SalaryTypeDed${rowind}-container`).parent().css('background-color',errorcolor);
                            }
                            if(dedamount != undefined){
                                if(isNaN(parseFloat(dedamount))){
                                    $(`#DedAmount${rowind}`).css("background", errorcolor);
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
                    else if (data.dberrors) {
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled",false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled",false);
                        }
                        toastrMessage('error',"Please contact the administrator","Error");
                    }
                    else if(data.netsalaryerr){
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }  
                        toastrMessage('error',"Net salary can not be less than or equal to zero(0)","Error");
                    }
                    else if(data.success){
                        if(parseFloat(optype)==2){
                            createSalaryInfoFn(data.rec_id);
                        }
                        toastrMessage('success',"Successful","Success");
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                        $("#inlineForm").modal('hide');
                    }
                }
            });
        });

        function salaryEditFn(recordId) { 
            resetSalaryFormFn()
            $("#earningDynamicTable > tbody").empty();
            $("#deductionDynamicTable > tbody").empty();
            var selectedEarningValues = [];
            var selectedDeductionValues = [];
            me = 0;
            md = 0;

            $.ajax({
                type: "get",
                url: "{{url('showsalary')}}"+'/'+recordId,
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
                    $.each(data.salarylist, function(key, value) {
                        $("#recId").val(recordId);
                        $('#SalaryName').val(value.SalaryName);
                        $("#Description").val(value.Description);
                        $('#status').val(value.Status).select2({minimumResultsForSearch: -1});
                    });

                    $.each(data.salarydetdata, function(key, value) {
                        if(parseInt(value.Type) == 1){
                            ++me;
                            $("#earningDynamicTable > tbody").append(`<tr>
                                <td style="font-weight:bold;width:3%;text-align:center;">${me}</td>
                                <td style="display:none;"><input type="hidden" name="erow[${me}][evals]" id="evals${me}" class="evals form-control" readonly="true" style="font-weight:bold;" value="${me}"/></td>
                                <td style="width:25%"><select id="SalaryType${me}" class="select2 form-control SalaryType" onchange="salaryTypeFn(this)" name="erow[${me}][SalaryType]"></select></td>
                                <td style="width:16%"><input type="number" placeholder="Taxable Earning" id="Taxable${me}" class="Taxable form-control numeral-mask" name="erow[${me}][Taxable]" onkeypress="return ValidateNum(event);" onkeyup="taxableFn(this)" value="${value.Amount}"/></td>
                                <td style="width:16%"><input type="number" placeholder="Non-Taxable Earning" id="NonTaxable${me}" class="NonTaxable form-control numeral-mask" name="erow[${me}][NonTaxable]" readonly onkeypress="return ValidateNum(event);" onkeyup="nonTaxableFn(this)" value="${value.NonTaxable}"/></td>
                                <td style="width:16%"><input type="number" placeholder="Total Earning" id="TotalEarning${me}" class="TotalEarning form-control numeral-mask" name="erow[${me}][TotalEarning]" readonly style="font-weight:bold" onkeypress="return ValidateNum(event);" value="${value.TotalAmount}"/></td>
                                <td style="width:19%;"><input type="text" placeholder="Remark" id="Remark${me}" class="Remark form-control" name="erow[${me}][Remark]" value="${value.Remark}"/></td>
                                <td style="width:5%;"><button id="earromvebtn${me}" type="button" class="btn btn-light btn-sm removeer-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>
                                <td style="display:none;"><input type="hidden" name="erow[${me}][NonTaxableDef]" id="NonTaxableDef${me}" class="NonTaxableDef form-control" value="${value.NonTaxableAmount}" readonly="true" style="font-weight:bold;"/></td>
                            </tr>`);

                            selectedEarningValues.push(value.salarytypes_id);
                            var defaultearningoption = `<option selected value="${value.salarytypes_id}">${value.SalaryTypeName}</option>`;
                            
                            if(parseInt(me) == 1){
                                $(`#SalaryType${me}`).empty();
                                $(`#SalaryType${me}`).append(defaultearningoption);
                                $(`#SalaryType${me}`).select2({placeholder: "Select salary type",minimumResultsForSearch: -1});
                                $(`#earromvebtn${me}`).remove();
                            }
                            if(parseInt(me) != 1){
                                var earningdefaultdata = $("#earningSalaryTypeDefault > option").clone();
                                $(`#SalaryType${me}`).append(earningdefaultdata);
                                $(`#SalaryType${me} option[value="${value.salarytypes_id}"]`).remove(); 
                                $.each(selectedEarningValues, function(i, value) {
                                    $(`#SalaryType${me} option[value="${value}"]`).remove(); 
                                });
                                $(`#SalaryType${me}`).append(defaultearningoption);
                                $(`#SalaryType${me}`).select2({placeholder: "Select salary component here"});
                                $(`#earromvebtn${me}`).show();
                            }

                            $(`#select2-SalaryType${me}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                            
                            if(parseFloat(value.NonTaxableAmount) > 0){
                                $(`#NonTaxable${me}`).prop('readonly',false);
                            }
                            calculateTotal(me);
                        }

                        if(parseInt(value.Type) == 2){
                            ++md;
                            var rowdata = "";
                            if(value.salarytypes_id == 2 || value.salarytypes_id == 3){
                                rowdata = `<div class="input-group">
                                        <input type="number" placeholder="Deduction Amount" id="DedAmount${md}" class="DedAmount form-control numeral-mask" name="drow[${md}][DedAmount]" readonly onkeypress="return ValidateNum(event);" value="${value.Amount}" style="width:55%;"/>
                                        <input type="text" id="TaxPercentInp${md}" class="TaxPercentInp form-control numeral-mask" name="drow[${md}][TaxPercentInp]" readonly style="width:40%;" value="${value.TaxPercent}%"/>  
                                        <i id="DedAmountInfo${md}" class="fas fa-info-circle" style="width:5%;position: absolute;top: 50%;left: 95%;transform: translate(-50%, -50%);"></i>
                                    </div>`;
                            }
                            else{
                                rowdata =`<input type="number" placeholder="Deduction Amount" id="DedAmount${md}" class="DedAmount form-control numeral-mask" name="drow[${md}][DedAmount]" readonly onkeypress="return ValidateNum(event);" value="${value.Amount}"/>`;
                            }
                            $("#deductionDynamicTable > tbody").append(`<tr>
                                <td style="font-weight:bold;width:3%;text-align:center;">${md}</td>
                                <td style="display:none;"><input type="hidden" name="drow[${md}][dvals]" id="dvals${md}" class="dvals form-control" readonly="true" style="font-weight:bold;" value="${md}"/></td>
                                <td style="width:31%"><select id="SalaryTypeDed${md}" class="select2 form-control SalaryTypeDed" onchange="salaryTypeDedFn(this)" name="drow[${md}][SalaryTypeDed]"></select></td>
                                <td style="width:31%">${rowdata}</td>
                                <td style="width:30%;"><input type="text" placeholder="Remark" id="RemarkDed${md}" class="RemarkDed form-control" name="drow[${md}][Remark]" value="${value.Remark}"/></td>
                                <td style="width:5%;"><button id="dedromvebtn${md}" type="button" class="btn btn-light btn-sm removede-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>
                                <td style="display:none;"><input type="number" placeholder="Tax Percent" id="TaxPercent${md}" class="TaxPercent form-control numeral-mask" name="drow[${md}][TaxPercent]" readonly value="${value.TaxPercent}"/></td>
                                <td style="display:none;"><input type="number" placeholder="Deduction" id="Deduction${md}" class="Deduction form-control numeral-mask" name="drow[${md}][Deduction]" readonly value="${value.Deduction}"/></td>
                            </tr>`);

                            selectedDeductionValues.push(value.salarytypes_id);
                            var defaultdeductionoption = `<option selected value="${value.salarytypes_id}">${value.SalaryTypeName}</option>`;
                            
                            if(parseInt(md) == 1 || parseInt(md) == 2){
                                $(`#SalaryTypeDed${md}`).empty();
                                $(`#SalaryTypeDed${md}`).append(defaultdeductionoption);
                                $(`#SalaryTypeDed${md}`).select2({placeholder: "Select salary type",minimumResultsForSearch: -1});
                                $(`#dedromvebtn${md}`).remove();
                            }
                            else{
                                var deductiondefaultdata = $("#deductionSalaryTypeDefault > option").clone();
                                $(`#SalaryTypeDed${md}`).append(deductiondefaultdata);
                                $.each(selectedDeductionValues, function(i, value) {
                                    $(`#SalaryTypeDed${md} option[value="${value}"]`).remove(); 
                                });
                                $(`#SalaryTypeDed${md}`).append(defaultdeductionoption);
                                $(`#SalaryTypeDed${md}`).select2({placeholder: "Select salary component here"});
                                $(`#dedromvebtn${md}`).show();
                            }
                            $(`#select2-SalaryTypeDed${md}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                        }
                    });
                    nonTaxableFn(this);
                    taxableFn(this);
                    calculateGrandTotal();
                    calculateTotalDeduction();
                    calculateTotal(1);
                }
            });

            $("#modaltitle").html("Edit Salary");
            $("#operationtypes").val(2);
            $('#savebutton').text('Update');
            $('#savebutton').prop("disabled",false);
            $("#inlineForm").modal('show'); 
        }

        function salaryInfoFn(recordId) { 
            createSalaryInfoFn(recordId);
            $("#informationmodal").modal('show');
        }

        function createSalaryInfoFn(recordId) { 
            var lidata = "";
            var typeflag = "";
            var compPensionPercent = 11;
            var empPensionPercent = 7;
            var totaltaxable = 0;
            var totalnontaxable = 0;
            var totalearning = 0;
            var totaldeduction = 0;
            var netpay = 0;
            var action_log = "";
            var action_links = "";
            $("#salarydetaildiv").hide();
            $.ajax({
                type: "get",
                url: "{{url('showsalary')}}"+'/'+recordId,
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
                    fetchSalaryDetailFn(recordId);   
                },
                success: function (data) {
                    $.each(data.salarylist, function(key, value) {
                        $("#salarynamelbl").html(value.SalaryName);
                        $("#descriptionlbl").html(value.Description);
                        $("#statuslbl").html(value.Status == "Active" ? 
                            `<span style='color:#1cc88a;font-weight:bold;text-shadow;1px 1px 10px #1cc88a;font-size:12px;'>${value.Status}</span>` :
                            `<span style='color:#e74a3b;font-weight:bold;text-shadow;1px 1px 10px #e74a3b;font-size:12px;'>${value.Status}</span>`
                        );

                        $("#infosummcompanypension").html(numformat(parseFloat(value.CompanyPension).toFixed(2)));
                        $("#infosummtaxableearning").html(numformat(parseFloat(value.TaxableEarning).toFixed(2)));
                        $("#infosummnontaxableearning").html(numformat(parseFloat(value.NonTaxableEarning).toFixed(2)));
                        $("#infosummtotalearning").html(numformat(parseFloat(value.TotalEarnings).toFixed(2)));
                        $("#infosummtotaldeduction").html(numformat(parseFloat(value.TotalDeductions).toFixed(2)));
                        $("#infosummnetpay").html(numformat(parseFloat(value.NetSalary).toFixed(2)));

                        $("#infosummcompanypensionLbl").html(`Company Pension (${compPensionPercent}%)`);
                        
                        totaltaxable = value.TaxableEarning;
                        totalnontaxable = value.NonTaxableEarning;
                        totalearning = value.TotalEarnings;
                        totaldeduction = value.TotalDeductions;
                        netpay = value.NetSalary;

                        $('#companypensioninfobtn').attr('title', `Pension Percent: ${compPensionPercent}% \nBasic Salary: ${numformat(parseFloat(value.CompanyPension / (compPensionPercent / 100)).toFixed(2))}\n----------------------------------------\nBasic Salary * Pension Percent = Company Pension\n${numformat(parseFloat(value.CompanyPension / (compPensionPercent / 100)).toFixed(2))} * ${parseFloat(compPensionPercent / 100).toFixed(2)} = ${numformat(parseFloat(value.CompanyPension).toFixed(2))}`);
                        $('#infonetpayinfo').attr('title', `(Taxable Earning - Total Deduction) + Total Non-Taxable = Net Pay\n(${numformat(parseFloat(value.TaxableEarning).toFixed(2))} - ${numformat(parseFloat(value.TotalDeductions).toFixed(2))}) + ${numformat(parseFloat(value.NonTaxableEarning).toFixed(2))} = ${numformat(parseFloat(value.NetSalary).toFixed(2))}`);
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
                            <a class="dropdown-item viewSalaryAction" onclick="viewSalaryActionFn(${recordId})" data-id="viewactionbtn${recordId}" id="viewactionbtn${recordId}" title="View user log">
                            <span><i class="fa-solid fa-eye"></i> View User Log</span>  
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        @can("Salary-Edit")
                        <li>
                            <a class="dropdown-item salaryEdit" onclick="salaryEditFn(${recordId})" data-id="editlinkbtn${recordId}" id="editlinkbtn${recordId}" title="Open salary edit form">
                            <span><i class="fa-solid fa-pencil"></i> Edit</span>  
                            </a>
                        </li>
                        @endcan
                        @can("Salary-Delete")
                        <li>
                            <a class="dropdown-item salaryDelete" onclick="salaryDeleteFn(${recordId})" data-id="deletelinkbtn${recordId}" id="deletelinkbtn${recordId}" title="Open salary delete confirmation">
                            <span><i class="fa-solid fa-xmark"></i> Delete</span>  
                            </a>
                        </li>
                        @endcan`;

                    $("#salary_action_ul").empty().append(action_links);
                }
            });

            $(".infoscl").collapse('show');
        }

        function viewSalaryActionFn(recordId){
            $("#action-log-title").html("User Log Information");
            $("#action-log-universal-modal").modal('show');
        }

        function fetchSalaryDetailFn(recordId){
            var compPensionPercent = 11;
            var empPensionPercent = 7;
            $('#salarydedinfotbl').DataTable({
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
                    url: '/showSalaryDetails/'+recordId,
                    type: 'POST',
                    data:{
                        typeflag: 2,
                    },
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
                },
                columns: [
                    { data: 'DT_RowIndex', width:'3%'},
                    { data: 'SalaryTypeName', name: 'SalaryTypeName',
                        "render": function ( data, type, row, meta ) {
                            if(row.salarytypes_id == 2){
                                return `${data} (${row.TaxPercent}%)`;
                            }
                            else if(row.salarytypes_id == 3){
                                return `${data} (${empPensionPercent}%)`;
                            }
                            else{
                               return data;
                            }
                        },
                        width:'33%'
                    },
                    { data: 'TotalAmount', name: 'TotalAmount',
                        "render": function ( data, type, row, meta ) {
                            if(row.salarytypes_id == 2){
                                return `<div class="input-group">
                                    <div style="width:95%;">${numformat(parseFloat(data).toFixed(2))}</div>
                                    <i title="Tax Percent: ${row.TaxPercent}% \nDeduction: ${numformat(parseFloat(row.Deduction).toFixed(2))}\nTaxable Earning: ${numformat(parseFloat(totaltaxable).toFixed(2))}\n----------------------------------------\n(Taxable Earning * Tax Percent) - Deduction = Income Tax\n(${numformat(parseFloat(totaltaxable).toFixed(2))} * ${row.TaxPercent / 100}) - ${numformat(parseFloat(row.Deduction).toFixed(2))} = ${numformat(parseFloat(data).toFixed(2))}" class="fas fa-info-circle" style="width:5%;position: absolute;top: 50%;left: 95%;transform: translate(-50%, -50%);"></i>
                                </div>`;
                            }
                            else if(row.salarytypes_id == 3){
                                return `<div class="input-group">
                                    <div style="width:95%;">${numformat(parseFloat(data).toFixed(2))}</div>
                                    <i title="Pension Percent: ${empPensionPercent}% \nBasic Salary: ${numformat(parseFloat(data / (empPensionPercent / 100)).toFixed(2))}\n----------------------------------------\nBasic Salary * Pension Percent = Pension\n${numformat(parseFloat(data / (empPensionPercent / 100)).toFixed(2))} * ${parseFloat(empPensionPercent / 100).toFixed(2)} = ${numformat(parseFloat(data).toFixed(2))}" class="fas fa-info-circle" style="width:5%;position: absolute;top: 50%;left: 95%;transform: translate(-50%, -50%);"></i>
                                </div>`;
                            }
                            else{
                               return numformat(parseFloat(data).toFixed(2));
                            }
                        },
                        width:"32%"
                    },
                    { data: 'Remarks', name: 'Remarks', width:'32%'},    
                ],
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(),data;
                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    var totaldudction = api
                    .column(2)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    $('#infodeductionamount').html(numformat(parseFloat(totaldudction).toFixed(2)));
                },
            });

            $('#salaryinfotbl').DataTable({
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
                    url: '/showSalaryDetails/'+recordId,
                    type: 'POST',
                    data:{
                        typeflag: 1,
                    },
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
                },
                columns: [
                    { data:'DT_RowIndex', width:'3%'},
                    { data: 'SalaryTypeName', name: 'SalaryTypeName', width:'26%'},
                    { data: 'Amount', name: 'Amount',width:"17%",render: $.fn.dataTable.render.number(',', '.',2, '')},
                    { data: 'NonTaxableAmount', name: 'NonTaxableAmount',width:"17%",render: $.fn.dataTable.render.number(',', '.',2, '')},   
                    { data: 'TotalAmount', name: 'TotalAmount',width:"17%",render: $.fn.dataTable.render.number(',', '.',2, '')},   
                    { data: 'Remarks', name: 'Remarks', width:'20%'},    
                ],
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(),data;
                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    var totaltaxable = api
                    .column(2)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totalnontaxable = api
                    .column(3)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totalearnig = api
                    .column(4)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    $('#infotaxableearning').html(numformat(parseFloat(totaltaxable).toFixed(2)));
                    $('#infonontaxableearning').html(numformat(parseFloat(totalnontaxable).toFixed(2)));
                    $('#infototalearning').html(numformat(parseFloat(totalearnig).toFixed(2)));
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
                    $("#salarydetaildiv").show();
                },
            });
        }

        $(document).on('show.bs.collapse hide.bs.collapse', '.collapse', function (e) {
            e.stopPropagation();
            const collapse = $(this);
            const container = collapse.closest('.card, .modal-content, .row');
            const infoTarget = container.find('.salary_header_info');
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
                const name = container.find('#salarynamelbl').text().trim();
                const status = container.find('#statuslbl').text().trim();
                const summarySalary = `
                    Salary Name: <b>${name}</b>,
                    Status: <b style="color: ${status == "Active" ? "#28c76f" : "#ea5455"}">${status}</b>`;

                infoTarget.html(summarySalary);
            }
        });

        function salaryDeleteFn(recordId) { 
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
                    deleteSalaryFn(recordId);
                }
                else if (result.dismiss === Swal.DismissReason.cancel) {}
            });
        }

        function deleteSalaryFn(recordId){
            var delform = $("#InformationForm");
            var formData = delform.serialize();
            $.ajax({
                url: '/deletesalary',
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

        function calculateNetSalary() {
            var totalearning = 0;
            var totaldeduction = 0;

            $.each($('#dynamicTable').find('.EarningAmount'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    totalearning += parseFloat($(this).val());
                }
            });
            $.each($('#dynamicTable').find('.DeductionAmount'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    totaldeduction += parseFloat($(this).val());
                }
            });

            var netsalary=parseFloat(totalearning)-parseFloat(totaldeduction);
            $('#totalearnings').html(numformat(totalearning.toFixed(2)));
            $('#totaldeductions').html(numformat(totaldeduction.toFixed(2)));
            $('#netsalarylbl').html(numformat(netsalary.toFixed(2)));
            $('#NetSalary').val(netsalary.toFixed(2));
        }

        function resetSalaryFormFn(){
            $('.reg_form').val("");
            $('.errordatalabel').html("");
            $('#status').val("Active").select2({
                minimumResultsForSearch: -1
            });
            $('#operationtypes').val(1);
            $('#savebutton').text('Save');
            $('#savebutton').prop("disabled",false);
            $('.summfig').html("");
            appendDefaultSalaryComp();
            $("#modaltitle").html("Add Salary");
        }

        function refreshSalaryDataFn(){
            var oTable = $('#laravel-datatable-crud').dataTable();
            oTable.fnDraw(false);
        }

        function earningamntFn(ele) {
            calculateNetSalary();
            var cid=$(ele).closest('tr').find('.vals').val();
            $('#EarningAmount'+cid).css("background", "white");
        }

        function deductionamntFn(ele) {
            calculateNetSalary();
            var cid=$(ele).closest('tr').find('.vals').val();
            $('#DeductionAmount'+cid).css("background", "white");
        }

        function statusvalfn(ele) {
            var cid=$(ele).closest('tr').find('.vals').val();
            $('#select2-Status'+cid+'-container').parent().css({"background":"white","position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
        }

        function salaryNameFn() {
            $('#name-error').html('');
        }

        function basicsalaryFn() {
            $('#basicsalary-error').html('');
            calculateNetSalary();
        }

        function netsalaryFn() {
            $('#netsalary-error').html('');
        }

        function medicalallowanceFn() {
            $('#medicalallowance-error').html('');
            calculateNetSalary();
        }

        function homerentallowanceFn() {
            $('#homerentallowance-error').html('');
            calculateNetSalary();
        }

        function transportallowanceFn() {
            $('#transportallowance-error').html('');
            calculateNetSalary();
        }

        function bonusFn() {
            $('#bonus-error').html('');
            calculateNetSalary();
        }

        function otherearningFn() {
            $('#others-error').html('');
            calculateNetSalary();
        }
        
        function taxFn() {
            $('#tax-error').html('');
            calculateNetSalary();
        }

        function profidentfundFn() {
            $('#profidentfund-error').html('');
            calculateNetSalary();
        }

        function loanFn() {
            $('#loan-error').html('');
            calculateNetSalary();
        }

        function othersdeductionFn() {
            $('#othersdec-error').html('');
            calculateNetSalary();
        }
        
        function descriptionfn() {
            $('#description-error').html('');
        }

        function statusFn() {
            $('#status-error').html('');
        }

        function numformat(val) {
            while (/(\d+)(\d{3})/.test(val.toString())) {
                val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
            }
            return val;
        }
    </script>
@endsection
