@extends('layout.app1')


@section('title')
@endsection

@section('content')

    @can('Employee-View')
    <div class="app-content content">
        <section id="responsive-datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom fit-content mb-0 pb-0">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 border-bottom">
                                <div class="row">
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3" style="text-align: left !important;align-items: center;padding: 10px 5px;">
                                        <h3 class="card-title form_title">Employee</h3>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align: center !important;">
                                        <ul class="nav nav-tabs justify-content-center" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active header-tab" id="TableView-tab" data-toggle="tab" href="#tableview" aria-controls="tableview" role="tab" aria-selected="false" title="Table View"><i class="fas fa-table"></i><span class="tab-text">Table View</span></a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link header-tab" id="HierarchyView-tab" data-toggle="tab" href="#hierarchyview" aria-controls="hierarchyview" role="tab" aria-selected="true" onclick="hierarchyviewFn()" title="Tree View"><i class="fas fa-sitemap"></i><span class="tab-text">Tree View</span></a>                                
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3" style="text-align: right !important;align-items: center;padding: 10px 5px;">
                                        <button type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm" onclick="refreshEmpDataFn()"><i class="fas fa-sync-alt"></i></button>
                                        @can('Employee-Add')
                                            <button type="button" class="btn btn-gradient-info btn-sm addemployees header-prop" id="addemployees"><i class="fas fa-plus"></i><span class="header-text">&nbsp Add</span></button>
                                        @endcan 
                                        <input type="hidden" class="form-control" name="currentdateval" id="currentdateval" value="{{$currentdate}}" readonly/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pl-0">
                                <div class="row mt-1 mx-n2 pl-1">
                                    <div class="col-6 col-sm-3 col-lg custom-col mb-1">
                                        <div class="stat-item">
                                            <div class="media">
                                                <div class="avatar bg-light-success mr-1">
                                                    <div class="avatar-content">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users avatar-icon"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                                    </div>
                                                </div>
                                                <div class="media-body my-auto mr-1">
                                                    <span class="font-weight-bolder mb-0 status_record_lbl" id="active_record_lbl"></span>
                                                    <p class="card-text font-small-3 mb-0">Active</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-3 col-lg custom-col mb-1">
                                        <div class="stat-item">
                                            <div class="media">
                                                <div class="avatar bg-light-danger mr-1">
                                                    <div class="avatar-content">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users avatar-icon"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                                    </div>
                                                </div>
                                                <div class="media-body my-auto mr-1">
                                                    <span class="font-weight-bolder mb-0 status_record_lbl" id="inactive_record_lbl"></span>
                                                    <p class="card-text font-small-3 mb-0">Inactive</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-3 col-lg custom-col mb-1">
                                        <div class="stat-item">
                                            <div class="media">
                                                <div class="avatar bg-light-danger mr-1">
                                                    <div class="avatar-content">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users avatar-icon"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                                    </div>
                                                </div>
                                                <div class="media-body my-auto mr-1">
                                                    <span class="font-weight-bolder mb-0 status_record_lbl" id="dismissal_record_lbl"></span>
                                                    <p class="card-text font-small-3 mb-0">Dismissal</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-3 col-lg custom-col mb-1">
                                        <div class="stat-item">
                                            <div class="media">
                                                <div class="avatar bg-light-secondary mr-1">
                                                    <div class="avatar-content">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users avatar-icon"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                                    </div>
                                                </div>
                                                <div class="media-body my-auto mr-1">
                                                    <span class="font-weight-bolder mb-0 status_record_lbl" id="resign_record_lbl"></span>
                                                    <p class="card-text font-small-3 mb-0">Resign</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-3 col-lg custom-col mb-1">
                                        <div class="stat-item">
                                            <div class="media">
                                                <div class="avatar bg-light-secondary mr-1">
                                                    <div class="avatar-content">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users avatar-icon"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                                    </div>
                                                </div>
                                                <div class="media-body my-auto mr-1">
                                                    <span class="font-weight-bolder mb-0 status_record_lbl" id="total_record_lbl"></span>
                                                    <p class="card-text font-small-3 mb-0">Total</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="card-datatable">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tableview" aria-labelledby="tableview" role="tabpanel">
                                    <div style="width:99%; margin-left:0.5%;">
                                        <div style="display: none;" id="emp_tbl" class="main_datatable">
                                            <table id="laravel-datatable-crud" class="display table-bordered table-striped table-hover defaultdatatable mb-0 mobile-dt" style="width: 100%">
                                                <thead>
                                                    <tr>
                                                        <th style="display: none"></th>
                                                        <th style="width:3%;">#</th>
                                                        <th style="width:5%;">Photo</th>
                                                        <th style="width:20%;">Employee ID, Name</th>
                                                        <th style="width:12%;">Phone No.</th>
                                                        <th style="width:7%;">Gender</th>
                                                        <th style="width:10%;">Branch</th>
                                                        <th style="width:11%;">Department</th>
                                                        <th style="width:11%;">Position</th>
                                                        <th style="width:10%;">Employment Type</th>
                                                        <th style="width:7%;">Status</th>
                                                        <th style="width:4%;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="table table-sm"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="hierarchyview" aria-labelledby="hierarchyview" role="tabpanel">
                                    <div class="row" id="hierarchyviewdiv">
                                        <div class="col-xl-3 col-md-12 col-sm-3 mb-1 mt-1">
                                            <div class="input-group ml-1">
                                                {{-- <span class="input-group-text"><i class="fa fa-search" aria-hidden="true"></i></span> --}}
                                                {{-- <input type="text" class="form-control mainforminp" name="SearchEmployee" id="SearchEmployee" placeholder="Search Employee or Position here..." aria-label="Search Employee here..." aria-describedby="button-addon"> --}}
                                                {{-- <button class="btn btn-outline-danger waves-effect btn-sm" type="button" id="button-addon"><i class="fa fa-times fa-1x" aria-hidden="true"></i></button> --}}
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-md-12 col-sm-6"></div>
                                        <div class="col-xl-3 col-md-12 col-sm-3 mb-1 mt-1" style="text-align: right;">
                                            <button type="button" onclick="downloadPDF()" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm" title="Export the entire tree to pdf"><i class="fa-solid fa-file-pdf fa-lg" aria-hidden="true"></i></button>
                                        </div>
                                        
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1" id="pdfExport">
                                            <h2 style="font-weight:bold;text-align: center; color: #82868b;">
                                                <i class="fas fa-sitemap"></i> Employee Structure
                                            </h2>
                                            <div id="emp_tree" class="strclass" style="width: 100%;text-align: center"></div>
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
    @endcan

    <!--Start Information Modal -->
    <div class="modal fade fit-content" id="informationmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel35" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title form_title">Employee Information</h4>
                    <div class="row">
                        <div style="text-align: right;font-size:16px;" class="form_title" id="statusdisplay"></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                </div>
                <form id="InformationForm">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                <ul class="nav nav-tabs info-note" role="tablist">
                                    <li class="nav-item genformnavcon">
                                        <a class="nav-link genformnav disabled" id="Info-general-tab" data-toggle="tab" href="#infogeneralview" aria-controls="Info-general-tab" role="tab" aria-selected="false" title="Common Information"><i class="fas fa-database"></i><span class="tab-text">Common Information</span></a>
                                    </li>
                                </ul>
                                <div class="tab-content genformtabcon" style="border: 0.1px solid #d9d7ce;margin-top:-14px;">
                                    <div class="tab-pane genformtab active" id="infogeneralview" aria-labelledby="infogeneralview" role="tabpanel">
                                        <div class="row">
                                            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12" style="text-align: center; vertical-align:middle;">
                                                <div class="profile-section photo-padding pt-2">
                                                    <img id="infoActualImage" class="img-thumbnail employee_img_cls" src="../../../storage/uploads/HrEmployee/dummypic.jpg" alt="Employee Image" style="width: 130px; height: 130px; border-radius: 50%; object-fit: cover; display: block; margin: 0 auto;">
                                                </div>
                                            </div>
                                            <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12 pt-1">
                                                <table class="infotbl" style="width:100%;font-size:12px;">
                                                    <tr>
                                                        <td><label class="info_lbl">Full Name</label></td>
                                                        <td><label class="info_lbl" id="fullNameLbl" style="font-weight:bold;"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label class="info_lbl">Gender</label></td>
                                                        <td><label class="info_lbl" id="genderLbl" style="font-weight:bold;"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label class="info_lbl">D.O.B</label></td>
                                                        <td><label class="info_lbl" id="DobLbl" style="font-weight:bold;"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label class="info_lbl">Branch</label></td>
                                                        <td><label class="info_lbl" id="BranchLbl" style="font-weight:bold;"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label class="info_lbl">Department</label></td>
                                                        <td><label class="info_lbl" id="DepartmentLbl" style="font-weight:bold;"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label class="info_lbl">Position</label></td>
                                                        <td><label class="info_lbl" id="PositionLbl" style="font-weight:bold;"></label></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12 mb-1">
                                <ul class="nav nav-tabs info-note" role="tablist">
                                    <li class="nav-item genformnavcon">
                                        <a class="nav-link genformnav disabled" id="Info-address-tab" data-toggle="tab" href="#infoaddresstab" aria-controls="Info-address-tab" role="tab" aria-selected="false" title="Address Information"><i class="fas fa-address-card"></i><span class="tab-text">Address Information</span></a>
                                    </li>
                                </ul>
                                <div class="tab-content genformtabcon" style="border: 0.1px solid #d9d7ce;margin-top:-14px;">
                                    <div class="tab-pane genformtab active" id="infoaddresstab" aria-labelledby="infoaddresstab" role="tabpanel">
                                        <div class="row">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <table class="infotbl" style="width:100%;font-size:12px;">
                                                    <tr>
                                                        <td><label class="info_lbl">Primary Phone No.</label></td>
                                                        <td><label class="info_lbl" id="MobileNumberLbl" style="font-weight:bold;"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label class="info_lbl">Optional Phone No.</label></td>
                                                        <td><label class="info_lbl" id="OfficePhoneNumberLbl" style="font-weight:bold;"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label class="info_lbl">Email</label></td>
                                                        <td><label class="info_lbl" id="EmailLbl" style="font-weight:bold;"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label class="info_lbl">Country</label></td>
                                                        <td><label class="info_lbl" id="countryLbl" style="font-weight:bold;"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label class="info_lbl">City</label></td>
                                                        <td><label class="info_lbl" id="city-ddLbl" style="font-weight:bold;"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label class="info_lbl">Subcity</label></td>
                                                        <td><label class="info_lbl" id="subcity-ddLbl" style="font-weight:bold;"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label class="info_lbl">Woreda</label></td>
                                                        <td><label class="info_lbl" id="WoredaLbl" style="font-weight:bold;"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label class="info_lbl">Kebele</label></td>
                                                        <td><label class="info_lbl" id="Kebele_Lbl" style="font-weight:bold;"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label class="info_lbl">House No.</label></td>
                                                        <td><label class="info_lbl" id="House_Num_Lbl" style="font-weight:bold;"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label class="info_lbl">Street Address</label></td>
                                                        <td><label class="info_lbl" id="AddressLbl" style="font-weight:bold;"></label></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12 mb-1">
                                <ul class="nav nav-tabs info-note" role="tablist">
                                    <li class="nav-item genformnavcon">
                                        <a class="nav-link genformnav disabled" id="Info-others-tab" data-toggle="tab" href="#infootherstab" aria-controls="Info-others-tab" role="tab" aria-selected="false" title="Others Information"><i class="fas fa-ellipsis-h"></i><span class="tab-text">Others Information</span></a>
                                    </li>
                                </ul>
                                <div class="tab-content genformtabcon" style="border: 0.1px solid #d9d7ce;margin-top:-14px;">
                                    <div class="tab-pane genformtab active" id="infootherstab" aria-labelledby="infootherstab" role="tabpanel">
                                        <div class="row">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 scrdivhor scrollhor" style="overflow-y: scroll;height:15rem">
                                                <table class="infotbl" style="width:100%;font-size:12px;">
                                                    <tr>
                                                        <td><label class="info_lbl">Nationality</label></td>
                                                        <td><label class="info_lbl" id="nationalityLbl" style="font-weight:bold;"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label class="info_lbl">Residance ID</label></td>
                                                        <td><label class="info_lbl" id="ResidanceIdNumberLbl" style="font-weight:bold;"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label class="info_lbl">National ID</label></td>
                                                        <td><label class="info_lbl" id="NationalIdNumberLbl" style="font-weight:bold;"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label class="info_lbl">Passport No.</label></td>
                                                        <td><label class="info_lbl" id="PassportNumberLbl" style="font-weight:bold;"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label class="info_lbl">Driving License No.</label></td>
                                                        <td><label class="info_lbl" id="DrivingLicenseNumberLbl" style="font-weight:bold;"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label class="info_lbl">Postcode</label></td>
                                                        <td><label class="info_lbl" id="PostcodeLbl" style="font-weight:bold;"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label class="info_lbl">Martial Status</label></td>
                                                        <td><label class="info_lbl" id="MartialStatusLbl" style="font-weight:bold;"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label class="info_lbl">Blood Type</label></td>
                                                        <td><label class="info_lbl" id="BloodType_Lbl" style="font-weight:bold;"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label class="info_lbl">Memo</label></td>
                                                        <td><label class="info_lbl" id="DescriptionLbl" style="font-weight:bold;"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" style="text-align: center;font-weight:bold"><u>Emergency Contact</u></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label class="info_lbl">Name</label></td>
                                                        <td><label class="info_lbl" id="EmergencyNameLbl" style="font-weight:bold;"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label class="info_lbl">Phone No.</label></td>
                                                        <td><label class="info_lbl" id="EmergencyPhoneLbl" style="font-weight:bold;"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label class="info_lbl">Street Address</label></td>
                                                        <td><label class="info_lbl" id="EmergencyAddressLbl" style="font-weight:bold;"></label></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-12 col-sm-12 col-12" style="display: none;">
                                <ul class="nav nav-tabs info-note" role="tablist">
                                    <li class="nav-item genformnavcon">
                                        <a class="nav-link genformnav disabled" id="Info-action-tab" data-toggle="tab" href="#infoactiontab" aria-controls="Info-action-tab" role="tab" aria-selected="false" title="Action Information"><i class="fas fa-bars"></i><span class="tab-text">Action Information</span></a>
                                    </li>
                                </ul>
                                <div class="tab-content genformtabcon" style="border: 0.1px solid #d9d7ce;margin-top:-14px;">
                                    <div class="tab-pane genformtab active" id="infoactiontab" aria-labelledby="infoactiontab" role="tabpanel">
                                        <div class="row">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 scrdivhor scrollhor" style="overflow-y: scroll;height:14rem">
                                                <ul id="actiondiv" class="timeline mb-0 mt-1"></ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-1 mt-1">
                                <!-- Tab navs -->
                                <div class="nav flex-column nav-tabs text-left" id="v-tabs-modules" role="tablist" aria-orientation="vertical">
                                    <a class="nav-link mod-vertical-tab active verticalinfo tab-title active-tab-title ver-cus-tab" id="info-v-general-tab" data-toggle="tab" href="#info-v-general-view" role="tab" aria-controls="info-general-tab" aria-selected="true" title="General"><i class="fas fa-clipboard"></i><span class="tab-text">General</span></a>
                                    <a class="nav-link mod-vertical-tab verticalinfo mod tab-title ver-cus-tab" id="info-hr-tab" data-mod="hr" data-toggle="tab" href="#info-hr-view" role="tab" aria-controls="info-hr-tab" aria-selected="false" title="HR (Human Resource)"><i class="fas fa-users"></i><span class="tab-text">HR</span></a>
                                    <a class="nav-link mod-vertical-tab verticalinfo mod tab-title ver-cus-tab" id="info-wellness-tab" data-mod="wellness" data-toggle="tab" href="#info-wellness-side-view" role="tab" aria-controls="info-wellness-tab" aria-selected="false" title="Wellness"><i class="fas fa-spa"></i><span class="tab-text">Wellness</span></a>
                                    <a class="nav-link mod-vertical-tab verticalinfo mod tab-title ver-cus-tab" id="info-medical-tab" data-mod="medical" data-toggle="tab" href="#info-medical-view" role="tab" aria-controls="info-medical-tab" aria-selected="false" title="Medical"><i class="fas fa-stethoscope"></i><span class="tab-text">Medical</span></a>
                                </div>
                                <!-- Tab navs -->
                            </div>
                            <div class="col-xl-11 col-lg-11 col-md-11 col-sm-11 col-11 mt-1" style="margin-right: -5rem;padding-right: -5rem !important;">
                                <div class="tab-content" id="v-tabs-tabContent" style="border: 0.1px solid #d9d7ce;">
                                    <div class="tab-pane active verticalviewinfo tab-view active-tab-view" id="info-v-general-view" role="tabpanel" aria-labelledby="info-v-general-view">
                                        <ul class="nav nav-tabs nav-fill" role="tablist">
                                            <li class="nav-item general-entity note">
                                                <a class="nav-link general-entity-tab active tab-title active-tab-title" id="info-AccessSetting-tab" data-toggle="tab" href="#info-accessSetting" aria-controls="info-accessSetting" role="tab" aria-selected="true" title="System Access Setting"><i class="fas fa-user-cog"></i><span class="tab-text">System Access Setting</span></a>                                
                                            </li>
                                        </ul>
                                        <div class="tab-content general-entity" style="margin-top:-14px;">
                                            <div class="tab-pane general-entity-view active tab-view active-tab-view" id="info-accessSetting" aria-labelledby="info-accessSetting" role="tabpanel">
                                                <div class="row mt-1 ml-0 mb-1">
                                                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-5 col-5 mt-1">
                                                        <table class="infotbl" style="width: 100%;font-size:12px;">
                                                            <tr>
                                                                <td><label class="info_lbl">Access Status</label></td>
                                                                <td><label class="info_lbl" id="AccessStatusLbl" style="font-weight: bold"></label></td>
                                                            </tr>
                                                            <tr>
                                                                <td><label class="info_lbl">Username</label></td>
                                                                <td><label class="info_lbl" id="emp_username" style="font-weight: bold"></label></td>
                                                            </tr>
                                                        </table>
                                                    </div>                                                    
                                                    <div class="col-xl-10 col-lg-9 col-md-8 col-sm-7 col-7 mt-1 info_role_data_div" style="display:none;">
                                                        <ul class="nav nav-tabs justify-content-end" role="tablist">
                                                            <li class="nav-item assign-entity">
                                                                <a class="nav-link general-assign-tab active assigninfo tab-title active-tab-title role-assign" id="info-v-role-tab" data-toggle="tab" href="#info-role-view" aria-controls="info-role-view" role="tab" aria-selected="true" title="Assigned Role(s)"><i class="fas fa-user-tag"></i><span class="tab-text">Assigned Role(s)</span></a>     
                                                            </li>
                                                            <li class="nav-item assign-entity">
                                                                <a class="nav-link general-assign-tab assigninfo tab-title role-assign" id="info-acc-assign-tab" data-toggle="tab" href="#info-acc-assign-view" aria-controls="info-acc-assign-view" role="tab" aria-selected="true" title="Assigned Store/Shop Access"><i class="fas fa-store"></i><span class="tab-text">Assigned Store/Shop Access</span></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="row info_role_data_div" style="display: none;">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <div class="tab-content" id="info-v-tabs-AssignTabContent">
                                                            <div class="tab-pane active general-assign-view tab-view active-tab-view" id="info-role-view" role="tabpanel" aria-labelledby="info-v-role-view">
                                                                <div class="row ml-1 mb-1 mr-1" style="border:1px solid #D3D3D3;">
                                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-1 section-path">
                                                                        <div class="breadcrumb-path">
                                                                            <div class="crumb"><a>General</a></div>
                                                                            <div class="crumb"><a>System Access Setting</a></div>
                                                                            <div class="crumb active"><a>Assigned Role(s)</a></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ml-2 mt-1 mb-1">
                                                                        <div id="roledatacanvas_info" class="row scrollhor append-data info_lbl" style="width: 100%;overflow-y: scroll;max-height: 10rem;"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tab-pane general-assign-view tab-view" id="info-acc-assign-view" role="tabpanel" aria-labelledby="info-acc-assign-view">
                                                                
                                                                <div class="row ml-1 mb-1 mr-1">
                                                                    <div class="col-xl-2 col-lg-1 col-md-2 col-sm-2 col-2">
                                                                        <!-- Tab navs -->
                                                                        <div class="nav flex-column nav-tabs text-center" id="info-v-tabs-module" role="tablist" aria-orientation="vertical">
                                                                            <a class="nav-link form-module active moduleinfo ass-mod tab-title active-tab-title ver-cus-tab" id="info-pos-tab" data-assmod="pos" data-toggle="tab" href="#info-pos-view" role="tab" aria-controls="info-pos-tab" aria-selected="true" title="POS (Point of Sales)"><i class="fas fa-cash-register"></i><span class="tab-text">POS</span></a>
                                                                            <a class="nav-link form-module moduleinfo ass-mod tab-title ver-cus-tab" id="info-inventory-tab" data-assmod="inventory" data-toggle="tab" href="#info-inventory-view" role="tab" aria-controls="info-inventory-tab" aria-selected="false" title="Warehouse & Inventory"><i class="fas fa-boxes"></i><span class="tab-text">Inventory</span></a>
                                                                            <a class="nav-link form-module moduleinfo ass-mod tab-title ver-cus-tab" id="info-fitness-tab" data-assmod="wellness" data-toggle="tab" href="#info-wellness-view" role="tab" aria-controls="info-fitness-tab" aria-selected="true" title="Wellness"><i class="fas fa-spa"></i><span class="tab-text">Wellness</span></a>
                                                                            <a class="nav-link form-module moduleinfo tab-title ver-cus-tab" id="info-report-tab" data-toggle="tab" href="#info-report-view" role="tab" aria-controls="info-report-tab" aria-selected="true"><i class="fas fa-analytics" title="Report"></i><span class="tab-text">Report</span></a>
                                                                        </div>
                                                                        <!-- Tab navs -->
                                                                    </div>
                                                                    <div class="col-xl-10 col-lg-11 col-md-10 col-sm-10 col-10 mt-0" style="border:1px solid #D3D3D3;">
                                                                        <div class="tab-content" id="info-v-tabs-AssignModuleContent">
                                                                            <div class="tab-pane active module-assignment ass-view tab-view active-tab-view" id="info-pos-view" role="tabpanel" aria-labelledby="info-pos-view">
                                                                                <div class="row">
                                                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-1 section-path">
                                                                                        <div class="breadcrumb-path">
                                                                                            <div class="crumb"><a>General</a></div>
                                                                                            <div class="crumb"><a>System Access Setting</a></div>
                                                                                            <div class="crumb"><a>Assigned Store/Shop Access</a></div>
                                                                                            <div class="crumb active"><a>POS</a></div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12" style="border-bottom:1px solid #D3D3D3;border-right:1px solid #D3D3D3;">
                                                                                        <div class="row">
                                                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="text-align:center;">
                                                                                                <label style="font-weight: bold;font-size: 15px;text-align:center;" id="info_pos_title_lbl"></label>
                                                                                            </div>
                                                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                                                <div id="info_posdatacanvas" class="row scrollhor append-data" style="width: 100%;overflow-y: scroll;max-height: 10rem;"></div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12" style="border-bottom:1px solid #D3D3D3;">
                                                                                        <div class="row">
                                                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="text-align:center;border-right:1px solid #D3D3D3">
                                                                                                <label style="font-weight: bold;font-size: 15px;text-align:center;" id="info_proforma_title_lbl"></label>
                                                                                            </div>
                                                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                                                <div id="info_proformadatacanvas" class="row scrollhor append-data" style="width: 100%;overflow-y: scroll;max-height: 10rem;"></div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="tab-pane module-assignment tab-view" id="info-inventory-view" role="tabpanel" aria-labelledby="info-inventory-view">
                                                                                <div class="row">
                                                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-1 section-path">
                                                                                        <div class="breadcrumb-path">
                                                                                            <div class="crumb"><a>General</a></div>
                                                                                            <div class="crumb"><a>System Access Setting</a></div>
                                                                                            <div class="crumb"><a>Assigned Store/Shop Access</a></div>
                                                                                            <div class="crumb active"><a>Inventory</a></div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12" style="border-bottom:1px solid #D3D3D3;">
                                                                                        <div class="row">
                                                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="text-align:center;">
                                                                                                <label style="font-weight: bold;font-size: 15px;text-align:center;" id="info_receiving_title_lbl"></label>
                                                                                            </div>
                                                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                                                <div id="info_receivingdatacanvas" class="row scrollhor append-data" style="width: 100%;overflow-y: scroll;max-height: 10rem;"></div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12" style="border-bottom:1px solid #D3D3D3;border-left:1px solid #D3D3D3;">
                                                                                        <div class="row">
                                                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="text-align:center;">
                                                                                                <label style="font-weight: bold;font-size: 15px;text-align:center;" id="info_requisition_title_lbl"></label>
                                                                                            </div>
                                                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                                                <div id="info_reqdatacanvas" class="row scrollhor append-data" style="width: 100%;overflow-y: scroll;max-height: 10rem;"></div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12" style="border-bottom:1px solid #D3D3D3;border-left:1px solid #D3D3D3;">
                                                                                        <div class="row">
                                                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="text-align:center;">
                                                                                                <label style="font-weight: bold;font-size: 15px;text-align:center;" id="info_trnsrc_title_lbl"></label>
                                                                                            </div>
                                                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                                                <div id="info_trsrcdatacanvas" class="row scrollhor append-data" style="width: 100%;overflow-y: scroll;max-height: 10rem;"></div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12" style="border-bottom:1px solid #D3D3D3;border-left:1px solid #D3D3D3;">
                                                                                        <div class="row">
                                                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="text-align:center;">
                                                                                                <label style="font-weight: bold;font-size: 15px;text-align:center;" id="info_trndes_title_lbl"></label>
                                                                                            </div>
                                                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                                                <div id="info_trdesdatacanvas" class="row scrollhor append-data" style="width: 100%;overflow-y: scroll;max-height: 10rem;"></div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12" style="border-bottom:1px solid #D3D3D3;border-left:1px solid #D3D3D3;">
                                                                                        <div class="row">
                                                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="text-align:center;">
                                                                                                <label style="font-weight: bold;font-size: 15px;text-align:center;" id="info_trnrec_title_lbl"></label>
                                                                                            </div>
                                                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                                                <div id="info_trnrecdatacanvas" class="row scrollhor append-data" style="width: 100%;overflow-y: scroll;max-height: 10rem;"></div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12" style="border-bottom:1px solid #D3D3D3;border-left:1px solid #D3D3D3;">
                                                                                        <div class="row">
                                                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="text-align:center;">
                                                                                                <label style="font-weight: bold;font-size: 15px;text-align:center;" id="info_appr_title_lbl"></label>
                                                                                            </div>
                                                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                                                <div id="info_apprdatacanvas" class="row scrollhor append-data" style="width: 100%;overflow-y: scroll;max-height: 10rem;"></div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>


                                                                                    <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12" style="border-bottom:1px solid #D3D3D3;border-left:1px solid #D3D3D3;">
                                                                                        <div class="row">
                                                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="text-align:center;">
                                                                                                <label style="font-weight: bold;font-size: 15px;text-align:center;" id="info_issue_title_lbl"></label>
                                                                                            </div>
                                                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                                                <div id="info_issuedatacanvas" class="row scrollhor append-data" style="width: 100%;overflow-y: scroll;max-height: 10rem;"></div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12" style="border-bottom:1px solid #D3D3D3;border-left:1px solid #D3D3D3;">
                                                                                        <div class="row">
                                                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="text-align:center;">
                                                                                                <label style="font-weight: bold;font-size: 15px;text-align:center;" id="info_adj_title_lbl"></label>
                                                                                            </div>
                                                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                                                <div id="info_adjdatacanvas" class="row scrollhor append-data" style="width: 100%;overflow-y: scroll;max-height: 10rem;"></div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12" style="border-bottom:1px solid #D3D3D3;border-left:1px solid #D3D3D3;">
                                                                                        <div class="row">
                                                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="text-align:center;">
                                                                                                <label style="font-weight: bold;font-size: 15px;text-align:center;" id="info_beg_title_lbl"></label>
                                                                                            </div>
                                                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                                                <div id="info_begdatacanvas" class="row scrollhor append-data" style="width: 100%;overflow-y: scroll;max-height: 10rem;"></div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12" style="border-bottom:1px solid #D3D3D3;border-left:1px solid #D3D3D3;">
                                                                                        <div class="row">
                                                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="text-align:center;">
                                                                                                <label style="font-weight: bold;font-size: 15px;text-align:center;" id="info_stbal_title_lbl"></label>
                                                                                            </div>
                                                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                                                <div id="info_stbaldatacanvas" class="row scrollhor append-data" style="width: 100%;overflow-y: scroll;max-height: 10rem;"></div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12" style="border-bottom:1px solid #D3D3D3;border-left:1px solid #D3D3D3;">
                                                                                        <div class="row mt-1 ml-1 mb-1">
                                                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                                                <div id="info_is_purchaser" class="row scrollhor append-data" style="width: 100%;overflow-y: scroll;max-height: 10rem;"></div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12" style="border-bottom:1px solid #D3D3D3;border-left:1px solid #D3D3D3;"></div>
                                                                                    
                                                                                </div>
                                                                            </div>
                                                                            <div class="tab-pane module-assignment tab-view" id="info-wellness-view" role="tabpanel" aria-labelledby="info-wellness-view">
                                                                                <div class="row">
                                                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-1 section-path">
                                                                                        <div class="breadcrumb-path">
                                                                                            <div class="crumb"><a>General</a></div>
                                                                                            <div class="crumb"><a>System Access Setting</a></div>
                                                                                            <div class="crumb"><a>Assigned Store/Shop Access</a></div>
                                                                                            <div class="crumb active"><a>Wellness</a></div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12" style="border-bottom:1px solid #D3D3D3;border-right:1px solid #D3D3D3;">
                                                                                        <div class="row">
                                                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="text-align:center;">
                                                                                                <label style="font-weight: bold;font-size: 15px;text-align:center;" id="info_fit_pos_title_lbl"></label>
                                                                                            </div>
                                                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                                                <div id="info_fitposdatacanvas" class="row scrollhor append-data" style="width: 100%;overflow-y: scroll;max-height: 10rem;"></div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12"></div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="tab-pane module-assignment tab-view" id="info-report-view" role="tabpanel" aria-labelledby="info-report-view">
                                                                                <div class="row">
                                                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-1 section-path">
                                                                                        <div class="breadcrumb-path">
                                                                                            <div class="crumb"><a>General</a></div>
                                                                                            <div class="crumb"><a>System Access Setting</a></div>
                                                                                            <div class="crumb"><a>Assigned Store/Shop Access</a></div>
                                                                                            <div class="crumb active"><a>Report</a></div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12" style="border-bottom:1px solid #D3D3D3;">
                                                                                        <div class="row">
                                                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="text-align:center;">
                                                                                                <label style="font-weight: bold;font-size: 15px;text-align:center;" id="info_posreport_title_lbl"></label>
                                                                                            </div>
                                                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                                                <div id="info_posreportdatacanvas" class="row scrollhor append-data" style="width: 100%;overflow-y: scroll;max-height: 10rem;"></div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12" style="border-bottom:1px solid #D3D3D3;border-left:1px solid #D3D3D3;">
                                                                                        <div class="row">
                                                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="text-align:center;">
                                                                                                <label style="font-weight: bold;font-size: 15px;text-align:center;" id="info_purchase_title_lbl"></label>
                                                                                            </div>
                                                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                                                <div id="info_purchasedatacanvas" class="row scrollhor append-data" style="width: 100%;overflow-y: scroll;max-height: 10rem;"></div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12" style="border-bottom:1px solid #D3D3D3;border-left:1px solid #D3D3D3;">
                                                                                        <div class="row">
                                                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="text-align:center;">
                                                                                                <label style="font-weight: bold;font-size: 15px;text-align:center;" id="info_invrep_title_lbl"></label>
                                                                                            </div>
                                                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                                                <div id="info_invrepdatacanvas" class="row scrollhor append-data" style="width: 100%;overflow-y: scroll;max-height: 10rem;"></div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12" style="border-bottom:1px solid #D3D3D3;border-left:1px solid #D3D3D3;">
                                                                                        <div class="row">
                                                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="text-align:center;">
                                                                                                <label style="font-weight: bold;font-size: 15px;text-align:center;" id="info_wellness_title_lbl"></label>
                                                                                            </div>
                                                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                                                <div id="info_wellnessrepdatacanvas" class="row scrollhor append-data" style="width: 100%;overflow-y: scroll;max-height: 10rem;"></div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12" style="border-bottom:1px solid #D3D3D3;border-left:1px solid #D3D3D3;">
                                                                                        <div class="row">
                                                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="text-align:center;">
                                                                                                <label style="font-weight: bold;font-size: 15px;text-align:center;" id="info_medical_title_lbl"></label>
                                                                                            </div>
                                                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                                                <div id="info_medicaldatacanvas" class="row scrollhor append-data" style="width: 100%;overflow-y: scroll;max-height: 10rem;"></div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12" style="border-top:1px solid #D3D3D3;;border-left:1px solid #D3D3D3;">
                                                                                        
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
                                        </div>
                                    </div>
                                    <div class="tab-pane verticalviewinfo tab-view" id="info-hr-view" role="tabpanel" aria-labelledby="info-hr-view">
                                        <ul class="nav nav-tabs nav-fill" role="tablist">
                                            <li class="nav-item formnavitm note">
                                                <a class="nav-link active hr-tabs tab-title active-tab-title" id="info-hrbasic-tab" data-toggle="tab" href="#info-hrbasic-view" aria-controls="info-hrbasic-tab" role="tab" aria-selected="true" title="Basic"><i class="fas fa-user-circle"></i><span class="tab-text">Basic</span></a>                                
                                            </li>
                                            <li class="nav-item formnavitm note">
                                                <a class="nav-link hr-tabs tab-title" id="info-hratt-tab" data-toggle="tab" href="#info-hratt-view" aria-controls="info-hratt-tab" role="tab" aria-selected="true" title="Attendance"><i class="fas fa-calendar-check"></i><span class="tab-text">Attendance</span></a>                                
                                            </li>
                                            <li class="nav-item formnavitm note">
                                                <a class="nav-link hr-tabs tab-title" id="info-hrguar-tab" data-toggle="tab" href="#info-hrguar-view" aria-controls="info-hrguar-tab" role="tab" aria-selected="true" title="Guarantor"><i class="fas fa-user-shield"></i><span class="tab-text">Guarantor</span></a>                                
                                            </li>
                                            <li class="nav-item formnavitm note">
                                                <a class="nav-link hr-tabs tab-title" id="info-hrbio-tab" data-toggle="tab" href="#info-hrbio-view" aria-controls="info-hrbio-tab" role="tab" aria-selected="true" title="Biometric"><i class="fas fa-id-card-alt"></i><span class="tab-text">Biometric</span></a>                                
                                            </li>
                                            <li class="nav-item formnavitm note">
                                                <a class="nav-link hr-tabs tab-title" id="info-payroll-tab" data-toggle="tab" href="#info-payroll-view" aria-controls="info-payroll-tab" role="tab" aria-selected="true" title="Salary"><i class="fas fa-calculator"></i><span class="tab-text">Salary</span></a>                                
                                            </li>
                                            <li class="nav-item formnavitm note">
                                                <a class="nav-link hr-tabs tab-title" id="info-hrdoc-tab" data-toggle="tab" href="#info-hrdoc-view" aria-controls="info-hrdoc-tab" role="tab" aria-selected="true" title="Documents"><i class="fas fa-file-alt"></i><span class="tab-text">Documents</span></a>                                
                                            </li>
                                            <li id="cont-tab" class="nav-item formnavitm note">
                                                <a class="nav-link hr-tabs tab-title" id="info-hrcont-tab" data-toggle="tab" href="#info-hrcont-view" aria-controls="info-hrcont-tab" role="tab" aria-selected="true" title="Contract Agreement"><i class="fas fa-handshake"></i><span class="tab-text">Contract Agreement</span></a>                                
                                            </li>
                                            <li class="nav-item formnavitm note">
                                                <a class="nav-link hr-tabs tab-title" id="info-leavehis-tab" data-toggle="tab" href="#info-leavehis-view" aria-controls="info-leavehis-tab" role="tab" aria-selected="true" title="Leave History"><i class="fas fa-calendar-lines"></i><span class="tab-text">Leave History</span></a>                                
                                            </li>
                                        </ul>
                                        <div class="tab-content formtabcon" style="margin-top:-14px;">
                                            <div class="tab-pane hr-views active tab-view active-tab-view" id="info-hrbasic-view" aria-labelledby="info-hrbasic-view" role="tabpanel">
                                                <div class="row mt-2 mb-1 ml-0">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1 section-path">
                                                        <div class="breadcrumb-path">
                                                            <div class="crumb"><a>HR</a></div>
                                                            <div class="crumb active"><a>Basic</a></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <table class="infotbl" style="width:100%;font-size:12px;">
                                                            <tr>
                                                                <td><label class="info_lbl">Immedaite Manager</label></td>
                                                                <td><label class="info_lbl" id="SupervisorOrImmedaiteManagerLbl" style="font-weight:bold;"></label></td>
                                                            </tr>
                                                            <tr>
                                                                <td><label class="info_lbl">Employment Type</label></td>
                                                                <td><label class="info_lbl" id="EmploymentTypeLbl" style="font-weight:bold;"></label></td>
                                                            </tr>
                                                            <tr>
                                                                <td><label class="info_lbl">Hired Date</label></td>
                                                                <td><label class="info_lbl" id="HiredDateLbl" style="font-weight:bold;"></label></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane hr-views tab-view" id="info-hratt-view" aria-labelledby="info-hratt-view" role="tabpanel">
                                                <div class="row mt-2 mb-1 ml-0">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1 section-path">
                                                        <div class="breadcrumb-path">
                                                            <div class="crumb"><a>HR</a></div>
                                                            <div class="crumb active"><a>Attendance</a></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <table class="infotbl" style="width:100%;font-size:12px;">
                                                            <tr>
                                                                <td><label class="info_lbl">Enable Attendance</label></td>
                                                                <td><label class="info_lbl" id="EnableAttendanceLbl" style="font-weight:bold;"></label></td>
                                                            </tr>
                                                            <tr>
                                                                <td><label class="info_lbl">Enable Holliday</label></td>
                                                                <td><label class="info_lbl" id="EnableHolidayLbl" style="font-weight:bold;"></label></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane hr-views tab-view" id="info-hrguar-view" aria-labelledby="info-hrguar-view" role="tabpanel">
                                                <div class="row mt-2 mb-1 ml-0">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1 section-path">
                                                        <div class="breadcrumb-path">
                                                            <div class="crumb"><a>HR</a></div>
                                                            <div class="crumb active"><a>Guarantor</a></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                                        <table class="infotbl" style="width:100%;font-size:12px;">
                                                            <tr>
                                                                <td><label class="info_lbl">Guarantor Name</label></td>
                                                                <td><label class="info_lbl" id="guarantornamelbl" style="font-weight:bold;"></label></td>
                                                            </tr>
                                                            <tr>
                                                                <td><label class="info_lbl">Guarantor Phone No.</label></td>
                                                                <td><label class="info_lbl" id="guarantorphonelbl" style="font-weight:bold;"></label></td>
                                                            </tr>
                                                            <tr>
                                                                <td><label class="info_lbl">Guarantor Address</label></td>
                                                                <td><label class="info_lbl" id="guarantoraddresslbl" style="font-weight:bold;"></label></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    
                                                    <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12" style="height: 30rem;">
                                                        <label class="info_lbl">Guarantor Letter Document</label>
                                                        <iframe id="guaranteInfoForm" class="scrdivhor scrollhor" src="" width="99%" height="96%"></iframe>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane hr-views tab-view" id="info-hrbio-view" aria-labelledby="info-hrbio-view" role="tabpanel">
                                                <div class="row mt-2 mb-1 ml-0">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1 section-path">
                                                        <div class="breadcrumb-path">
                                                            <div class="crumb"><a>HR</a></div>
                                                            <div class="crumb active"><a>Biometric</a></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-12 col-md-12 col-sm-12 col-12 mb-2">
                                                        <table class="infotbl" style="width:100%;font-size:12px;">
                                                            <tr>
                                                                <td><label class="info_lbl">PIN</label></td>
                                                                <td><label class="info_lbl" id="PINLbl" style="font-weight:bold;"></label></td>
                                                            </tr>
                                                            <tr>
                                                                <td><label class="info_lbl">Card Number</label></td>
                                                                <td><label class="info_lbl" id="CardNumberLbl" style="font-weight:bold;"></label></td>
                                                            </tr>
                                                            <tr>
                                                                <td><label class="info_lbl">Enroll Device</label></td>
                                                                <td><label class="info_lbl" id="EnrollDeviceLbl" style="font-weight:bold;"></label></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-12 col-md-12 col-sm-12 col-12 mb-2" style="text-align: center !important;border-left:1px solid #D3D3D3">
                                                        <p class="mt-0" style="text-align: center;"><label style="font-size: 20px;font-weight:bold;"><i class="fas fa-camera"></i> Picture</label></p>
                                                        <img id="infoBioImage" class="employee-photo-preview employee_img_cls"/>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12" style="border-left:1px solid #D3D3D3;text-align:center !mportant;z-index:999">
                                                        <p class="mt-0" style="text-align: center;"><label style="font-size: 20px;font-weight:bold;"><i class="fas fa-fingerprint"></i> Fingerprints</label></p>
                                                        <div class="table-responsive">
                                                            <table style="width: 100%;text-align:center;">
                                                                <tr>
                                                                    <td style="width: 20%" class="right_thumb">
                                                                        <span style="font-size: 25px;"><i class="fas fa-fingerprint fa-lg"></i></span></br>
                                                                        <label style="font-size:12px;font-weight:bold;" class="form-label">Right Thumb</label></br>
                                                                        <label style="font-size:12px;" class="form-label fingerprintcls rightthumblbl"></label>
                                                                    </td>
                                                                    <td style="width: 20%" class="right_index">
                                                                        <span style="font-size: 25px;"><i class="fas fa-fingerprint fa-lg"></i></span></br>
                                                                        <label style="font-size:12px;font-weight:bold;" class="form-label">Right Index</label></br>
                                                                        <label style="font-size:12px;" class="form-label fingerprintcls rightindexlbl"></label>
                                                                    </td>
                                                                    <td style="width: 20%" class="right_middle">
                                                                        <span style="font-size: 25px;"><i class="fas fa-fingerprint fa-lg"></i></span></br>
                                                                        <label style="font-size:12px;font-weight:bold;" class="form-label">Right Middle</label></br>
                                                                        <label style="font-size:12px;" class="form-label fingerprintcls rightmiddlelbl"></label>
                                                                    </td>
                                                                    <td style="width: 20%" class="right_ring">
                                                                        <span style="font-size: 25px;"><i class="fas fa-fingerprint fa-lg"></i></span></br>
                                                                        <label style="font-size:12px;font-weight:bold;" class="form-label">Right Ring</label></br>
                                                                        <label style="font-size:12px;" class="form-label fingerprintcls rightringlbl"></label>
                                                                    </td>
                                                                    <td style="width: 20%" class="right_pinky">
                                                                        <span style="font-size: 25px;"><i class="fas fa-fingerprint fa-lg"></i></span></br>
                                                                        <label style="font-size:12px;font-weight:bold;" class="form-label">Right Pinky</label></br>
                                                                        <label style="font-size:12px;" class="form-label fingerprintcls rightpinkylbl"></label>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="5" style="height: 1rem;"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="left_thumb">
                                                                        <span style="font-size: 25px;"><i class="fas fa-fingerprint fa-lg"></i></span></br>
                                                                        <label style="font-size:12px;font-weight:bold;" class="form-label">Left Thumb</label></br>
                                                                        <label style="font-size:12px;" class="form-label fingerprintcls leftthumblbl"></label>
                                                                    </td>
                                                                    <td class="left_index">
                                                                        <span style="font-size: 25px;"><i class="fas fa-fingerprint fa-lg"></i></span></br>
                                                                        <label style="font-size:12px;font-weight:bold;" class="form-label">Left Index</label></br>
                                                                        <label style="font-size:12px;" class="form-label fingerprintcls leftindexlbl"></label>
                                                                    </td>
                                                                    <td class="left_middle">
                                                                        <span style="font-size: 25px;"><i class="fas fa-fingerprint fa-lg"></i></span></br>
                                                                        <label style="font-size:12px;font-weight:bold;" class="form-label">Left Middle</label></br>
                                                                        <label style="font-size:12px;" class="form-label fingerprintcls leftmiddlelbl"></label>
                                                                    </td>
                                                                    <td class="left_ring">
                                                                        <span style="font-size: 25px;"><i class="fas fa-fingerprint fa-lg"></i></span></br>
                                                                        <label style="font-size:12px;font-weight:bold;" class="form-label">Left Ring</label></br>
                                                                        <label style="font-size:12px;" class="form-label fingerprintcls leftringlbl"></label>
                                                                    </td>
                                                                    <td class="left_pinky">
                                                                        <span style="font-size: 25px;"><i class="fas fa-fingerprint fa-lg"></i></span></br>
                                                                        <label style="font-size:12px;font-weight:bold;" class="form-label">Left Pinky</label></br>
                                                                        <label style="font-size:12px;" class="form-label fingerprintcls leftpinkylbl"></label>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane hr-views tab-view" id="info-hrdoc-view" aria-labelledby="info-hrdoc-view" role="tabpanel">
                                                <div class="row mt-2 ml-0 mr-1 mb-1">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1 section-path">
                                                        <div class="breadcrumb-path">
                                                            <div class="crumb"><a>HR</a></div>
                                                            <div class="crumb active"><a>Documents</a></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <p class="mt-0 mb-0" style="text-align: left;"><label style="font-size: 18px;font-weight:bold;" class="form_lbl"><i class="fas fa-file-alt"></i> Employee's Relevant Document(s)</label></p>
                                                        <table id="info-doc-datatable" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable mb-0 info_datatable" style="width: 100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width:3%;">#</th>
                                                                    <th style="width:22%;">Type</th>
                                                                    <th style="width:20%;">Date</th>
                                                                    <th style="width:30%;">Document</th>
                                                                    <th style="width:25%;">Remark</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="table table-sm"></tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane hr-views tab-view" id="info-hrcont-view" aria-labelledby="info-hrcont-view" role="tabpanel">
                                                <div class="row mt-2 ml-0 mr-1 mb-1">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1 section-path">
                                                        <div class="breadcrumb-path">
                                                            <div class="crumb"><a>HR</a></div>
                                                            <div class="crumb active"><a>Contract Agreement</a></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <p class="mt-0 mb-0" style="text-align: left;"><label style="font-size: 20px;font-weight:bold;" class="form_lbl"><i class="fas fa-handshake"></i> Signed Contract Agreement(s)</label></p>
                                                        <table id="info-cont-datatable" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable mb-0 info_datatable" style="width: 100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width:3%;">#</th>
                                                                    <th style="width:17%;">Sign Date</th>
                                                                    <th style="width:17%;">Expire Date</th>
                                                                    <th style="width:20%;">Duration <i>(Days)</i></th>
                                                                    <th style="width:24%;">Document</th>
                                                                    <th style="width:19%;">Remark</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="table table-sm"></tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane hr-views tab-view" id="info-payroll-view" aria-labelledby="info-payroll-view" role="tabpanel">
                                                <div class="row mt-2 mb-1 mr-1 ml-0">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1 section-path">
                                                        <div class="breadcrumb-path">
                                                            <div class="crumb"><a>HR</a></div>
                                                            <div class="crumb active"><a>Salary</a></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <table class="infotbl" style="width: 100%;font-size:12px;">
                                                            <tr>
                                                                <td><label class="info_lbl">Monthly Work Hour</label></td>
                                                                <td><label class="info_lbl" id="monthly_workhr" style="font-weight:bold;"></label></td>
                                                            </tr>
                                                            <tr>
                                                                <td><label class="info_lbl">Payment Type</label></td>
                                                                <td><label class="info_lbl" id="PaymentTypeLbl" style="font-weight:bold;"></label></td>
                                                            </tr>
                                                            <tr>
                                                                <td><label class="info_lbl">Payment Period</label></td>
                                                                <td><label class="info_lbl" id="PaymentPeriodLbl" style="font-weight:bold;"></label></td>
                                                            </tr>
                                                            <tr class="bankprop">
                                                                <td><label class="info_lbl">Bank</label></td>
                                                                <td><label class="info_lbl" id="BankLbl" style="font-weight:bold;"></label></td>
                                                            </tr>
                                                            <tr class="bankprop">
                                                                <td><label class="info_lbl">Bank Account</label></td>
                                                                <td><label class="info_lbl" id="BankAccountNumberLbl" style="font-weight:bold;"></label></td>
                                                            </tr>
                                                            <tr>
                                                                <td><label class="info_lbl">Provident Fund Account</label></td>
                                                                <td><label class="info_lbl" id="ProvidentFundAccountLbl" style="font-weight:bold;"></label></td>
                                                            </tr>
                                                            <tr>
                                                                <td><label class="info_lbl">Pension Number</label></td>
                                                                <td><label class="info_lbl" id="PensionNumberLbl" style="font-weight:bold;"></label></td>
                                                            </tr>
                                                            <tr>
                                                                <td><label class="info_lbl">TIN</label></td>
                                                                <td><label class="info_lbl" id="TinLbl" style="font-weight:bold;"></label></td>
                                                            </tr> 
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane hr-views tab-view" id="info-leavehis-view" aria-labelledby="info-leavehis-view" role="tabpanel">
                                                <div class="row mt-2 mb-1 mr-0 ml-0">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1 section-path">
                                                        <div class="breadcrumb-path">
                                                            <div class="crumb"><a>HR</a></div>
                                                            <div class="crumb active"><a>Leave History</a></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <p class="mt-0 mb-0" style="text-align: left;"><label style="font-size: 18px;font-weight:bold;" class="form_lbl"><i class="fas fa-calendar-lines"></i> Leave History</label></p>
                                                        <table id="info-leavehis-datatable" class="display table-bordered table-striped table-hover table-responsive mb-0 info_datatable" style="width: 100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width:3%;">#</th>
                                                                    <th style="width:16%;">Reference No.</th>
                                                                    <th style="width:13%;">Leave Type</th>
                                                                    <th style="width:13%;">Allocated</th>
                                                                    <th style="width:13%;">Utilized</th>
                                                                    <th style="width:16%;">Running Balance</th>
                                                                    <th style="width:13%;">Record Type</th>
                                                                    <th style="width:13%;">Date</th>
                                                                    <th style="display:none;"></th>
                                                                    <th style="display:none;"></th>
                                                                    <th style="display:none;"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="table table-sm"></tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <th id="total_balance_info" style="text-align: right;font-size: 16px;padding-right:5px !important" colspan="8"></th>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane verticalviewinfo tab-view" id="info-wellness-side-view" role="tabpanel" aria-labelledby="info-wellness-side-view">
                                        <ul class="nav nav-tabs nav-fill" role="tablist">
                                            <li class="nav-item wellness-entity note">
                                                <a class="nav-link wellness-entity-tab active wellness-skill tab-title active-tab-title" id="info-wellness-skill-tab" data-toggle="tab" href="#info-wellness-skill-view" aria-controls="info-wellness-skill-tab" role="tab" aria-selected="true" title="Skills"><i class="fas fa-brain"></i><span class="tab-text">Skills</span></a>                                
                                            </li>
                                        </ul>
                                        <div class="tab-content well-entity-view">
                                            <div class="tab-pane wellness-entity-view active active-tab-view" id="info-wellness-skill-view" aria-labelledby="info-wellness-skill-view" role="tabpanel">
                                                <div class="row mt-0 ml-0 mr-1 mb-1">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1 section-path">
                                                        <div class="breadcrumb-path">
                                                            <div class="crumb"><a>Wellness</a></div>
                                                            <div class="crumb active"><a>Skills</a></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <p class="mt-0 mb-0" style="text-align: left;"><label style="font-size: 20px;font-weight:bold;" class="form_lbl"><i class="fas fa-brain"></i> Wellness Skill(s)</label></p>
                                                        <table id="info-wellness-datatable" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable mb-0 info_datatable" style="width: 100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width:3%;">#</th>
                                                                    <th style="width:26%;">Skill</th>
                                                                    <th style="width:26%;">Level</th>
                                                                    <th style="width:45%;">Remark</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="table table-sm"></tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>     
                                    </div>

                                    <div class="tab-pane verticalviewinfo tab-view" id="info-medical-view" role="tabpanel" aria-labelledby="info-medical-view">
                                        <ul class="nav nav-tabs nav-fill" role="tablist">
                                            <li class="nav-item medical-entity note">
                                                <a class="nav-link medical-entity-tab active medical-skill tab-title active-tab-title" id="info-medical-skill-tab" data-toggle="tab" href="#info-medical-skill-view" aria-controls="info-medical-skill-tab" role="tab" aria-selected="true" title="Skills"><i class="fas fa-brain"></i><span class="tab-text">Skills</span></a>                                
                                            </li>
                                        </ul>
                                        <div class="tab-content med-entity-view">
                                            <div class="tab-pane formtab medical-entity-view active tab-view active-tab-view" id="info-medical-skill-view" aria-labelledby="info-medical-skill-view" role="tabpanel">
                                                <div class="row mt-0 ml-0 mr-1 mb-1">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1 section-path">
                                                        <div class="breadcrumb-path">
                                                            <div class="crumb"><a>Medical</a></div>
                                                            <div class="crumb active"><a>Skills</a></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <p class="mt-0 mb-0" style="text-align: left;"><label style="font-size: 20px;font-weight:bold;" class="form_lbl"><i class="fas fa-brain"></i> Medical Skill(s)</label></p>
                                                        <table id="info-medical-datatable" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable mb-0 info_datatable" style="width: 100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width:3%;">#</th>
                                                                    <th style="width:26%;">Skill</th>
                                                                    <th style="width:26%;">Level</th>
                                                                    <th style="width:45%;">Remark</th>
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
                             </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align:left">
                                    <div class="btn-group dropup">
                                        <button type="button" class="btn btn-outline-info dropdown-toggle hide-arrow action-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa-sharp fa-solid fa-caret-up fa-xl"></i><span class="btn-text">&nbsp Actions</span>
                                        </button>
                                        <ul class="dropdown-menu" id="employee_action_ul"></ul>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align:right">
                                    <input type="hidden" id="info_employee_id" name="info_employee_id"/>
                                    <input type="hidden" id="info_employee_code" name="info_employee_code"/>
                                    <button id="closebuttonk" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="display:none;">
                            <table id="company_info_tbl" class="table table-sm" style="width:100%;border: none !important;">
                                <tbody>
                                    <tr>
                                        <td style="width:8%;border: none !important;"><b>Tel:</b></td>
                                        <td style="width:42%;border: none !important;">{{$compInfo->Phone}}, {{$compInfo->OfficePhone}}</td>
                                        <td style="width:10%;border: none !important;"><b>Website:</b></td>
                                        <td style="width:40%;border: none !important;">{{$compInfo->Website}}</td>
                                    </tr>
                                    <tr>
                                        <td style="border: none !important;"><b>Email:</b></td>
                                        <td style="border: none !important;">{{$compInfo->Email}}</td>
                                        <td style="border: none !important;"><b>Address:</b></td>
                                        <td style="border: none !important;">{{$compInfo->Address}}</td>
                                    </tr>
                                    <tr style="border-bottom: 1px solid #000000;">
                                        <td style="border: none !important;"><b>TIN:</b></td>
                                        <td style="border: none !important;">{{$compInfo->TIN}}</td>
                                        <td style="border: none !important;"><b>VAT No:</b></td>
                                        <td style="border: none !important;">{{$compInfo->VATReg}}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <input type="hidden" id="info_company_name" name="info_company_name" value="{{$compInfo->Name}}"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End Information Modal -->

    <!--Start employee registration modal -->
    <div class="modal fade text-left fit-content" id="inlineForm" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="banktitlelbl" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title form_title" id="modaltitle">Add Employee</h4>
                    <div class="row">
                        <div style="text-align: right;font-size:16px;font-weight:bold;" id="reg_form_title" class="form_title"></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeRegisterModal()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <form id="Register">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                <ul class="nav nav-tabs one-note" role="tablist">
                                    <li class="nav-item genformnavcon">
                                        <a class="nav-link genformnav disabled one-tab-prop" id="General-tab" data-toggle="tab" href="#generalinformationview" aria-controls="generalinformationview" role="tab" aria-selected="false" title="Common Information"><i class="fas fa-database"></i><span class="tab-text">Common Information</span></a>
                                    </li>
                                </ul>
                                <div class="tab-content genformtabcon common-view" style="border: 0.1px solid #d9d7ce;margin-top:-14px;">
                                    <div class="tab-pane active" id="generalinformationview" aria-labelledby="generalinformationview" role="tabpanel">
                                        <div class="row">
                                            <div class="col-xl-3 col-lg-12 col-md-12 col-sm-12 col-12 mt-1 mb-1">
                                                <div class="row">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                                        <div class="avatar-upload" style="margin-bottom: -4px;margin-top:-2px;">
                                                            <div class="avatar-edit">
                                                                <input type="file" id="imageUpload" name="imageUpload" accept=".png, .jpg, .jpeg" />
                                                                <label for="imageUpload"><p style="text-align: center;margin-top:5px;color:#757575"><i class="fa fa-pencil fa-lg" aria-hidden="true"></i></p></label>
                                                            </div>
                                                            <div class="avatar-preview">
                                                                <img id="imagePreview" class="employee_img_cls"/></br>
                                                                <p id="actimageclosebtn" class="imageclosecls" style="text-align:center;margin-top:5px;">
                                                                    <button type="button" id="removeActualPhotoBtn" name="removeActualPhotoBtn" class="btn btn-flat-danger waves-effect btn-sm removeActualPhotoBtn" onclick="removeActualPhotoFn();"><i class="fa fa-times" aria-hidden="true"></i></button>
                                                                </p>
                                                                <input type="hidden" class="form-control emp_reg_form" name="actualPhoto" id="actualPhoto" readonly="true" value=""/>  
                                                                {{-- <div id="imagePreview"></div> --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pl-2 pr-2">
                                                        <label class="form_lbl">Status<b style="color: red;">*</b></label>
                                                        <select class="select2 form-control" name="status" id="status" onchange="statusFn()">
                                                            <option value="Active">Active</option>
                                                            <option value="Inactive">Inactive</option>
                                                            <option value="Dismissal">Dismissal</option>
                                                            <option value="Resign">Resign</option>
                                                        </select>
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel" id="status-error"></strong>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-9 col-lg-12 col-md-12 col-sm-12 col-12 mt-1 mb-1 pl-2 pr-2">
                                                <div class="row">
                                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 mb-1 pl-2 pr-2">
                                                       <label class="form_lbl">Title<b style="color: red;">*</b></label>
                                                        <select class="select2 form-control" name="title" id="title" onchange="titleFn()">
                                                            <option selected disabled value=""></option>
                                                            @foreach ($titles as $titles)
                                                            <option value="{{$titles->id}}">{{$titles->LookupName}}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel" id="title-error"></strong>
                                                        </span>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 mb-1 pl-2 pr-2">
                                                       <label class="form_lbl">First Name<b style="color: red;">*</b></label>
                                                        <input type="text" placeholder="First Name" class="form-control emp_reg_form" name="FirstName" id="FirstName" onkeyup="firstNameFn()"/>
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel" id="firstname-error"></strong>
                                                        </span>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 mb-1 pl-2 pr-2">
                                                        <label class="form_lbl">Middle Name<b style="color: red;">*</b></label>
                                                        <input type="text" placeholder="Middle Name" class="form-control emp_reg_form" name="MiddleName" id="MiddleName" onkeyup="middleNameFn()"/>
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel" id="middlename-error"></strong>
                                                        </span>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 mb-1 pl-2 pr-2">
                                                       <label class="form_lbl">Last Name</label>
                                                        <input type="text" placeholder="Last Name" class="form-control emp_reg_form" name="LastName" id="LastName" onkeyup="lastNameFn()"/>
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel" id="lastname-error"></strong>
                                                        </span>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 mb-1 pl-2 pr-2">
                                                       <label class="form_lbl">Gender</label>
                                                        <select class="select2 form-control" name="gender" id="gender" onchange="cleargendererror()">
                                                            <option value=""></option>
                                                            <option value="Male">Male</option>
                                                            <option value="Female">Female</option>
                                                        </select>
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel" id="gender-error"></strong>
                                                        </span>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 mb-1 pl-2 pr-2">
                                                       <label class="form_lbl" for="Dob" title="Date of Birth">DOB <i style="font-size: 8px;">(Date of Birth)</i></label>
                                                        <input type="text" name="Dob" id="Dob" class="form-control emp_reg_form" placeholder="YYYY-MM-DD" onchange="clearDobError()" readonly/>
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel" id="dob-error"></strong>
                                                        </span>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 mb-1 pl-2 pr-2">
                                                       <label class="form_lbl">Branch<b style="color: red;">*</b></label>
                                                        <select class="select2 form-control" name="Branch" id="Branch" onchange="branchFn()">
                                                            @foreach ($branch as $branch)
                                                            <option value="{{$branch->id}}">{{$branch->BranchName}}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel" id="branch-error"></strong>
                                                        </span>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 mb-1 pl-2 pr-2">
                                                       <label class="form_lbl">Department<b style="color: red;">*</b></label>
                                                        <select class="select2 form-control" name="Department" id="Department" onchange="departmentFn()">
                                                            @foreach ($department as $department)
                                                            <option value="{{$department->id}}">{{$department->DepartmentName}}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel" id="department-error"></strong>
                                                        </span>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 mb-1 pl-2 pr-2">
                                                       <label class="form_lbl">Position<b style="color: red;">*</b></label>
                                                        <select class="select2 form-control" name="Position" id="Position" onchange="positionFn()"></select>
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel" id="position-error"></strong>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                <ul class="nav nav-tabs nav-fill" role="tablist">
                                    <li class="nav-item adress note">
                                        <a class="nav-link adressnav formsidetab tab-title active active-tab-title" id="address-tab" data-toggle="tab" href="#adress-view" aria-controls="adress-view" role="tab" aria-selected="false" title="Address Information"><i class="fas fa-address-card"></i><span class="tab-text">Address Information</span></a>
                                    </li>
                                    <li class="nav-item misc note">
                                        <a class="nav-link miscnav formsidetab tab-title" id="misc-tab" data-toggle="tab" href="#misc-view" aria-controls="misc-view" role="tab" aria-selected="false" title="Others Information"><i class="fas fa-ellipsis-h"></i><span class="tab-text">Others Information</span></a>
                                    </li>
                                </ul>
                                <div class="tab-content adress-tab-view common-view" style="border: 0.1px solid #d9d7ce;margin-top:-14px;">
                                    <div class="tab-pane formsideview active tab-view active-tab-view" id="adress-view" aria-labelledby="adress-view" role="tabpanel">
                                        <div class="row">   
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-1 pl-2 pr-2 section-path">
                                                <div class="breadcrumb-path">
                                                    <div class="crumb active"><a>Address Information</a></div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-1">
                                                <div class="row">
                                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 mb-1 pl-2 pr-2">
                                                       <label class="form_lbl" for="Mobilenumber" title="Primary Phone Number">Primary Phone No.<b style="color:red;">*</b></label>
                                                        <input type="tel" id="MobileNumber" name="MobileNumber" class="form-control phone_number emp_reg_form" placeholder="+251-XXX-XX-XX-XX" onkeyup="clearMobileError()" />
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel" id="Mobilenumber-error"></strong>
                                                        </span>
                                                    </div>
                                                    
                                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 mb-1 pl-2 pr-2">
                                                       <label class="form_lbl" for="OfficePhoneNumber" title="Optional Phone Number">Optional Phone No.</label>  
                                                        <input type="tel" id="OfficePhoneNumber" name="OfficePhoneNumber" class="form-control phone_number emp_reg_form" placeholder="+251-XXX-XX-XX-XX" onkeyup="clearpPhoneError()" />
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel" id="Phonenumber-error"></strong>
                                                        </span>
                                                    </div>

                                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 mb-1 pl-2 pr-2">
                                                       <label class="form_lbl">Email</label>
                                                        <input type="email" id="Email" name="Email" class="form-control email_validation emp_reg_form" placeholder="abc@domain.com" onkeydown="clearEmailError()"/>
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel" id="Email-error"></strong>
                                                        </span>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-1 pl-2 pr-2">
                                                       <label class="form_lbl">Country<b style="color:red;">*</b></label> 
                                                        <select name="country" id="country-dd" class="select2 form-control" onchange="clearCountryError()">
                                                            @foreach ($country as $data)
                                                            <option selected value="{{$data->name}}">{{$data->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel" id="country-error"></strong>
                                                        </span>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-1 pl-2 pr-2">
                                                       <label class="form_lbl">City<b style="color:red;">*</b></label>
                                                        <select name="city" id="city-dd" class="select2 form-control" onchange="cityFn()">
                                                            <option value=""></option>
                                                            @foreach ($city as $data)
                                                            <option value="{{$data->id}}">{{$data->city_name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel" id="city-error"></strong>
                                                        </span>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-1 pl-2 pr-2">
                                                       <label class="form_lbl">Subcity<b style="color:red;">*</b></label>
                                                        <select class="select2 form-control" name="subcity" id="subcity-dd" onchange="clearSubcityError()">
                                                            <option selected value=13>-</option>
                                                        </select>
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel" id="subcity-error"></strong>
                                                        </span>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-1 pl-2 pr-2">
                                                       <label class="form_lbl">Woreda<b style="color:red;">*</b></label>
                                                        <select class="select2 form-control" name="Woreda" id="Woreda" onchange="clearWoredaError()"></select>
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel" id="Woreda-error"></strong>
                                                        </span>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-1 pl-2 pr-2">
                                                       <label class="form_lbl">Kebele</label>
                                                        <input type="text" placeholder="Kebele" class="form-control emp_reg_form" name="Kebele" id="Kebele" onkeyup="kebeleFn()"/>
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel" id="kebele-error"></strong>
                                                        </span>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-1 pl-2 pr-2">
                                                       <label class="form_lbl" title="House Number">House No.</label>
                                                        <input type="text" placeholder="House Number" class="form-control emp_reg_form" name="HouseNumber" id="HouseNumber" onkeyup="housenoFn()()"/>
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel" id="houseno-error"></strong>
                                                        </span>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 mb-1 pl-2 pr-2">
                                                       <label class="form_lbl">Street Address</label>
                                                        <textarea type="text" placeholder="Write Specific address here..." class="form-control emp_reg_form" rows="1" name="Address" id="Address" onkeyup="addressFn()"></textarea>
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel" id="address-error"></strong>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane formsideview misc-tab tab-view" id="misc-view" aria-labelledby="misc-view" role="tabpanel">
                                        <div class="row">   
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-1 pl-2 pr-2 section-path">
                                                <div class="breadcrumb-path">
                                                    <div class="crumb active"><a>Others Information</a></div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-1">
                                                <div class="row">
                                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 mb-1 pl-2 pr-2">
                                                       <label class="form_lbl">Nationality</label> 
                                                        <select name="nationality" id="nationality" class="select2 form-control" placeholder="Select Nationality" onchange="clearNationalityError()">
                                                            <option selected disabled value=""></option>
                                                            @foreach ($countrynat as $countrynat)
                                                            <option value="{{$countrynat->name}}">{{$countrynat->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel" id="nationality-error"></strong>
                                                        </span>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 mb-1 pl-2 pr-2">
                                                       <label class="form_lbl" for="ResidanceIdNumber">Residance ID</label>
                                                        <input type="text" id="ResidanceIdNumber" name="ResidanceIdNumber" class="form-control emp_reg_form" onkeyup="clearResidenceidError()" placeholder="Residance ID" />
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel" id="Residenceid-error"></strong>
                                                        </span>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 mb-1 pl-2 pr-2">
                                                       <label class="form_lbl" for="NationalIdNumber">National ID</label>
                                                        <input type="text" name="NationalIdNumber" id="NationalIdNumber" class="form-control emp_reg_form" placeholder="National ID" onkeypress="return ValidateNum(event);" onkeyup="nationalIdFn()"/>
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel" id="nationalid-error"></strong>
                                                        </span>
                                                    </div>

                                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 mb-1 pl-2 pr-2">
                                                       <label class="form_lbl" for="PassportNumber">Passport No.</label>
                                                        <input type="text" id="PassportNumber" name="PassportNumber" class="form-control emp_reg_form" onkeyup="clearPassportnoError()" placeholder="Passport number" />
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel" id="Passport-error"></strong>
                                                        </span>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 mb-1 pl-2 pr-2">
                                                       <label class="form_lbl" for="DrivingLicenseNumber">Driving License No.</label>
                                                        <input type="text" name="DrivingLicenseNumber" id="DrivingLicenseNumber" class="form-control emp_reg_form" placeholder="Driving license number" onkeypress="return ValidateNum(event);" onkeyup="drivingLicenceFn()"/>
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel" id="drivinglicence-error"></strong>
                                                        </span>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 mb-1 pl-2 pr-2">
                                                       <label class="form_lbl" for="Postcode">Postcode</label>
                                                        <input type="text" name="Postcode" id="Postcode" class="form-control emp_reg_form" placeholder="Postal code" onkeypress="return ValidateNum(event);" onkeyup="postcodeFn()"/>
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel" id="postcode-error"></strong>
                                                        </span>
                                                    </div>

                                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 mb-1 pl-2 pr-2">
                                                       <label class="form_lbl">Martial Status</label>
                                                        <select class="select2 form-control" name="MartialStatus" id="MartialStatus" onchange="martialStatusFn()">
                                                            <option selected disabled value=""></option>
                                                            <option value="Single">Single</option>
                                                            <option value="Married">Married</option>
                                                            <option value="Widowed">Widowed</option>
                                                            <option value="Divorced">Divorced</option>
                                                            <option value="Separated">Separated</option>
                                                        </select>
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel" id="martialstatus-error"></strong>
                                                        </span>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 mb-1 pl-2 pr-2">
                                                       <label class="form_lbl">Blood Type</label>
                                                        <select class="select2 form-control" name="BloodType" id="BloodType" onchange="bloodTypeFn()">
                                                            <option selected disabled value=""></option>
                                                            @foreach ($blood_type as $blood_type)
                                                            <option value="{{$blood_type->id}}">{{$blood_type->LookupName}}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel" id="bloodtype-error"></strong>
                                                        </span>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 mb-1 pl-2 pr-2">
                                                        <label class="form_lbl">Memo</label>
                                                        <textarea type="text" placeholder="Write Memo here..." class="form-control emp_reg_form" rows="1" name="Description" id="Description" onkeyup="descriptionfn()"></textarea>
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel" id="memo-error"></strong>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="divider" style="margin-top:-1rem;">
                                                    <div class="divider-text"><b>Emergency Contact</b></div>
                                                </div>
                                                <div class="row" style="margin-top:-1rem;">
                                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 mb-1 pl-2 pr-2">
                                                       <label class="form_lbl">Name</label>
                                                        <input type="text" id="EmergencyName" name="EmergencyName" class="form-control emp_reg_form" placeholder="Emergency contact person name" onkeyup="emergencyNameFn()"> 
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel" id="emergencyname-error"></strong>
                                                        </span>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 mb-1 pl-2 pr-2">
                                                       <label class="form_lbl" title="Phone Number">Phone No.</label>
                                                        <input type="tel" id="EmergencyPhone" name="EmergencyPhone" class="form-control phone_number emp_reg_form" placeholder="+251-XXX-XX-XX-XX" onkeyup="emergencyPhoneFn()"/>
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel" id="emergencyphone-error"></strong>
                                                        </span>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 mb-1 pl-2 pr-2">
                                                       <label class="form_lbl">Street Address</label>
                                                        <textarea type="text" placeholder="Write Specific address here..." class="form-control emp_reg_form" rows="1" name="EmergencyAddress" id="EmergencyAddress" onkeyup="emergencyAddFn()"></textarea>
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel" id="emergencyaddress-error"></strong>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-1 mt-1">
                                <!-- Tab navs -->
                                <div class="nav flex-column nav-tabs text-left" id="v-tabs-modules" role="tablist" aria-orientation="vertical">
                                    <a class="nav-link mod-vertical-tab active verticalinfo tab-title active-tab-title ver-cus-tab" id="v-general-tab" data-toggle="tab" href="#v-general-view" role="tab" aria-controls="general-tab" aria-selected="true" title="General"><i class="fas fa-clipboard"></i><span class="tab-text">General</span></a>
                                    <a class="nav-link mod-vertical-tab verticalinfo mod tab-title ver-cus-tab" id="hr-tab" data-mod="hr" data-toggle="tab" href="#hr-view" role="tab" aria-controls="hr-tab" aria-selected="false" title="HR (Human Resource)"><i class="fas fa-users"></i><span class="tab-text">HR</span></a>
                                    <a class="nav-link mod-vertical-tab verticalinfo mod tab-title ver-cus-tab" id="wellness-tab" data-mod="wellness" data-toggle="tab" href="#wellness-side-view" role="tab" aria-controls="wellness-tab" aria-selected="false" title="Wellness"><i class="fas fa-spa"></i><span class="tab-text">Wellness</span></a>
                                    <a class="nav-link mod-vertical-tab verticalinfo mod tab-title ver-cus-tab" id="medical-tab" data-mod="medical" data-toggle="tab" href="#medical-view" role="tab" aria-controls="medical-tab" aria-selected="false" title="Medical"><i class="fas fa-stethoscope"></i><span class="tab-text">Medical</span></a>
                                </div>
                                <!-- Tab navs -->
                            </div>
                            <div class="col-xl-11 col-lg-11 col-md-11 col-sm-11 col-11 mt-1" style="margin-right: -5rem;padding-right: -5rem !important;">
                                <div class="tab-content" id="v-tabs-tabContent" style="border: 0.1px solid #d9d7ce;">
                                    <div class="tab-pane active verticalviewinfo tab-view active-tab-view" id="v-general-view" role="tabpanel" aria-labelledby="v-general-view">
                                        <ul class="nav nav-tabs nav-fill" role="tablist">
                                            <li class="nav-item general-entity note">
                                                <a class="nav-link general-entity-tab active tab-title active-tab-title" id="AccessSetting-tab" data-toggle="tab" href="#accessSetting" aria-controls="accessSetting" role="tab" aria-selected="true"><i class="fas fa-user-cog"></i><span class="tab-text">System Access Setting</span></a>                                
                                            </li>
                                        </ul>
                                        <div class="tab-content general-entity">
                                            <div class="tab-pane general-entity-view active tab-view active-tab-view" id="accessSetting" aria-labelledby="accessSetting" role="tabpanel">
                                                <div class="row ml-0 mb-1">  
                                                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-5 col-5 mt-1 access_control_div general-tab-view">
                                                       <label class="form_lbl">Access Status<b style="color: red;">*</b></label>
                                                        <select class="select2 form-control" name="AccessStatus" id="AccessStatus" onchange="accessStatusFn()">
                                                            @can("Employee-Edit-General-Tab")<option value="Enable">Enable</option>@endcan
                                                            <option value="Disable">Disable</option>
                                                        </select>
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel" id="accstatus-error"></strong>
                                                        </span>
                                                    </div>
                                                    <div class="col-xl-10 col-lg-9 col-md-8 col-sm-7 col-7 mt-1 role_data_div" style="display:none;">
                                                        <ul class="nav nav-tabs justify-content-end" role="tablist">
                                                            <li class="nav-item assign-entity">
                                                                <a class="nav-link general-assign-tab active assigninfo tab-title active-tab-title role-assign" id="v-role-tab" data-toggle="tab" href="#role-view" aria-controls="role-view" role="tab" aria-selected="true" title="Role Assignment"><i class="fas fa-user-tag"></i><span class="tab-text">Role Assignment</span></a>     
                                                            </li>
                                                            <li class="nav-item assign-entity">
                                                                <a class="nav-link general-assign-tab assigninfo tab-title role-assign" id="acc-assign-tab" data-toggle="tab" href="#acc-assign-view" aria-controls="acc-assign-view" role="tab" aria-selected="true" title="Store/Shop Access Assignment"><i class="fas fa-store"></i><span class="tab-text">Store/Shop Access Assignment</span></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="row role_data_div" style="display: none;">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <div class="row">
                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                <div class="tab-content" id="v-tabs-AssignTabContent">
                                                                    <div class="tab-pane active general-assign-view tab-view active-tab-view" id="role-view" role="tabpanel" aria-labelledby="v-role-view">
                                                                        <div class="row ml-1 mb-1 mr-1" style="border:1px solid #D3D3D3;">
                                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-1 section-path">
                                                                                <div class="breadcrumb-path">
                                                                                    <div class="crumb"><a>General</a></div>
                                                                                    <div class="crumb"><a>System Access Setting</a></div>
                                                                                    <div class="crumb active"><a>Role Assignment</a></div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 mt-1 access_control_div general-tab-view" style="text-align: left;">
                                                                                <div class="custom-control custom-control-primary custom-checkbox">
                                                                                    <input type="checkbox" class="custom-control-input select-all-role" id="select-all-role" name="select-all-role[]"/>
                                                                                    <label class="custom-control-label" for="select-all-role" style="font-weight: bold;">Select All</label>                                                
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 mt-1" style="text-align: right;">
                                                                                <div class="search-container">
                                                                                    <input type="text" id="search-role" class="form-control search-box emp_reg_form" placeholder="Search...">
                                                                                    <span style="color: #ea5455" id="clear-search-role" class="clear-search">&times;</span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1 access_control_div general-tab-view">
                                                                                <span class="text-danger">
                                                                                    <strong class="errordatalabel" id="roledata-error"></strong>
                                                                                    <div id="roledatasearchresult"></div>
                                                                                </span>
                                                                                <div id="roledatacanvas" class="row scrollhor append-data" style="width: 100%;overflow-y: scroll;max-height: 10rem;"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="tab-pane general-assign-view tab-view" id="acc-assign-view" role="tabpanel" aria-labelledby="acc-assign-view">
                                                                        <div class="row ml-1 mb-1 mr-1">
                                                                            <div class="col-xl-2 col-lg-1 col-md-2 col-sm-2 col-2">
                                                                                <!-- Tab navs -->
                                                                                <div class="nav flex-column nav-tabs text-center" id="v-tabs-module" role="tablist" aria-orientation="vertical">
                                                                                    <a class="nav-link form-module active moduleinfo ass-mod tab-title active-tab-title ver-cus-tab" id="pos-tab" data-assmod="pos" data-toggle="tab" href="#pos-view" role="tab" aria-controls="pos-tab" aria-selected="true" title="POS & Proforma"><i class="fas fa-cash-register"></i><span class="tab-text">POS</span></a>
                                                                                    <a class="nav-link form-module moduleinfo ass-mod tab-title ver-cus-tab" id="inventory-tab" data-assmod="inventory" data-toggle="tab" href="#inventory-view" role="tab" aria-controls="inventory-tab" aria-selected="false" title="Warehouse & Inventory"><i class="fas fa-boxes"></i><span class="tab-text">Inventory</span></a>
                                                                                    <a class="nav-link form-module moduleinfo ass-mod tab-title ver-cus-tab" id="fitness-tab" data-assmod="wellness" data-toggle="tab" href="#wellness-view" role="tab" aria-controls="fitness-tab" aria-selected="true" title="Wellness"><i class="fas fa-spa"></i><span class="tab-text">Wellness</span></a>
                                                                                    <a class="nav-link form-module moduleinfo tab-title ver-cus-tab" id="report-tab" data-toggle="tab" href="#report-view" role="tab" aria-controls="report-tab" aria-selected="true" title="Report"><i class="fas fa-analytics"></i><span class="tab-text">Report</span></a>
                                                                                </div>
                                                                                <!-- Tab navs -->
                                                                            </div>
                                                                            <div class="col-xl-10 col-lg-11 col-md-10 col-sm-10 col-10" style="border:1px solid #D3D3D3;">
                                                                                <div class="tab-content general-tab-view" id="v-tabs-AssignModuleContent">
                                                                                    <div class="tab-pane active module-assignment ass-view tab-view active-tab-view" id="pos-view" role="tabpanel" aria-labelledby="pos-view">
                                                                                        <div class="row" style="display: none;">
                                                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-1">
                                                                                                <div class="custom-control custom-control-primary custom-checkbox">
                                                                                                    <input type="checkbox" class="custom-control-input select-all-pos_pro" id="select-all-pos_pro" name="select-all-pos_pro[]"/>
                                                                                                    <label class="custom-control-label" for="select-all-pos_pro" style="font-weight: bold;">Select All POS & Proforma</label>                                                
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-1 section-path">
                                                                                                <div class="breadcrumb-path">
                                                                                                    <div class="crumb"><a>General</a></div>
                                                                                                    <div class="crumb"><a>System Access Setting</a></div>
                                                                                                    <div class="crumb"><a>Store/Shop Access Assignment</a></div>
                                                                                                    <div class="crumb active"><a>POS</a></div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12" style="border-bottom:1px solid #D3D3D3;">
                                                                                                <div class="row checkbox-grp">
                                                                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="text-align: center;">
                                                                                                        <label style="font-weight: bold;font-size: 15px;" id="pos_title_lbl">POS (Point of Sales)</label> 
                                                                                                    </div>
                                                                                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12" style="text-align: left;">
                                                                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                                                                            <input type="checkbox" class="custom-control-input select-all-pos select-all-checkbox pos_pro" id="select-all-pos" name="select-all-pos[]" data-target=".pos"/>
                                                                                                            <label class="custom-control-label" for="select-all-pos" style="font-weight: bold;">Select All</label>                                                
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-xl-6 col-lg-6 col-md-8 col-sm-12 col-12" style="text-align: right; display:none;">
                                                                                                        <div class="search-container">
                                                                                                            <input type="text" id="search-pos" class="search-box emp_reg_form" placeholder="Search...">
                                                                                                            <span style="color: #ea5455" id="clear-search-pos" class="clear-search">&times;</span>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                                                                                        <div id="posdatacanvas" class="row scrollhor append-data checkbox-itm" style="width: 100%;overflow-y: scroll;max-height: 10rem;"></div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12" style="border-bottom:1px solid #D3D3D3;border-left:1px solid #D3D3D3">
                                                                                                <div class="row checkbox-grp">
                                                                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="text-align: center;">
                                                                                                        <label style="font-weight: bold;font-size: 15px;" id="proforma_title_lbl">Proforma</label> 
                                                                                                    </div>
                                                                                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12" style="text-align: left;">
                                                                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                                                                            <input type="checkbox" class="custom-control-input select-all-proforma select-all-checkbox" id="select-all-proforma" name="select-all-proforma[]" data-target=".pos_pro"/>
                                                                                                            <label class="custom-control-label" for="select-all-proforma" style="font-weight: bold;">Select All</label>                                                
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-xl-6 col-lg-6 col-md-8 col-sm-12 col-12" style="text-align: right; display:none;">
                                                                                                        <div class="search-container">
                                                                                                            <input type="text" id="search-proforma" class="search-box emp_reg_form" placeholder="Search...">
                                                                                                            <span style="color: #ea5455" id="clear-search-proforma" class="clear-search">&times;</span>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                                                                                        <div id="proformadatacanvas" class="row scrollhor append-data checkbox-itm" style="width: 100%;overflow-y: scroll;max-height: 10rem;"></div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="tab-pane module-assignment tab-view" id="inventory-view" role="tabpanel" aria-labelledby="inventory-view">
                                                                                        <div class="row">
                                                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-1 section-path">
                                                                                                <div class="breadcrumb-path">
                                                                                                    <div class="crumb"><a>General</a></div>
                                                                                                    <div class="crumb"><a>System Access Setting</a></div>
                                                                                                    <div class="crumb"><a>Store/Shop Access Assignment</a></div>
                                                                                                    <div class="crumb active"><a>Inventory</a></div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12" style="border-bottom:1px solid #D3D3D3;border-left:1px solid #D3D3D3">
                                                                                                <div class="row checkbox-grp">
                                                                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="text-align: center;">
                                                                                                        <label style="font-weight: bold;font-size: 15px;" id="receiving_title_lbl">Receiving</label> 
                                                                                                    </div>
                                                                                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12" style="text-align: left;">
                                                                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                                                                            <input type="checkbox" class="custom-control-input select-all-receiving select-all-checkbox" id="select-all-receiving" name="select-all-receiving[]" data-target=".receiving"/>
                                                                                                            <label class="custom-control-label" for="select-all-receiving" style="font-weight: bold;">Select All</label>                                                
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-xl-6 col-lg-6 col-md-8 col-sm-12 col-12" style="text-align: right; display:none;">
                                                                                                        <div class="search-container">
                                                                                                            <input type="text" id="search-receiving" class="search-box emp_reg_form" placeholder="Search...">
                                                                                                            <span style="color: #ea5455" id="clear-search-receiving" class="clear-search">&times;</span>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                                                                                        <div id="receivingdatacanvas" class="row scrollhor append-data checkbox-itm" style="width: 100%;overflow-y: scroll;max-height: 10rem;"></div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12" style="border-bottom:1px solid #D3D3D3;border-left:1px solid #D3D3D3">
                                                                                                <div class="row checkbox-grp">
                                                                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="text-align: center;">
                                                                                                        <label style="font-weight: bold;font-size: 15px;" id="requisition_title_lbl">Requisition</label> 
                                                                                                    </div>
                                                                                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12" style="text-align: left;">
                                                                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                                                                            <input type="checkbox" class="custom-control-input select-all-req select-all-checkbox" id="select-all-req" name="select-all-req[]" data-target=".req"/>
                                                                                                            <label class="custom-control-label" for="select-all-req" style="font-weight: bold;">Select All</label>                                                
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-xl-6 col-lg-6 col-md-8 col-sm-12 col-12" style="text-align: right; display:none;">
                                                                                                        <div class="search-container">
                                                                                                            <input type="text" id="search-req" class="search-box emp_reg_form" placeholder="Search...">
                                                                                                            <span style="color: #ea5455" id="clear-search-req" class="clear-search">&times;</span>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                                                                                        <div id="reqdatacanvas" class="row scrollhor append-data checkbox-itm" style="width: 100%;overflow-y: scroll;max-height: 10rem;"></div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12" style="border-bottom:1px solid #D3D3D3;border-left:1px solid #D3D3D3">
                                                                                                <div class="row checkbox-grp">
                                                                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="text-align: center;">
                                                                                                        <label style="font-weight: bold;font-size: 15px;" id="trnsrc_title_lbl"></label> 
                                                                                                    </div>
                                                                                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12" style="text-align: left;">
                                                                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                                                                            <input type="checkbox" class="custom-control-input select-all-trsrc select-all-checkbox" id="select-all-trsrc" name="select-all-trsrc[]" data-target=".trnsrc"/>
                                                                                                            <label class="custom-control-label" for="select-all-trsrc" style="font-weight: bold;">Select All</label>                                                
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-xl-6 col-lg-6 col-md-8 col-sm-12 col-12" style="text-align: right; display:none;">
                                                                                                        <div class="search-container">
                                                                                                            <input type="text" id="search-trsrc" class="search-box emp_reg_form" placeholder="Search...">
                                                                                                            <span style="color: #ea5455" id="clear-search-trsrc" class="clear-search">&times;</span>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                                                                                        <div id="trsrcdatacanvas" class="row scrollhor append-data checkbox-itm" style="width: 100%;overflow-y: scroll;max-height: 10rem;"></div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12" style="border-bottom:1px solid #D3D3D3;border-left:1px solid #D3D3D3">
                                                                                                <div class="row checkbox-grp">
                                                                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="text-align: center;">
                                                                                                        <label style="font-weight: bold;font-size: 15px;" id="trndes_title_lbl"></label> 
                                                                                                    </div>
                                                                                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12" style="text-align: left;">
                                                                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                                                                            <input type="checkbox" class="custom-control-input select-all-trdes select-all-checkbox" id="select-all-trdes" name="select-all-trdes[]" data-target=".trndes"/>
                                                                                                            <label class="custom-control-label" for="select-all-trdes" style="font-weight: bold;">Select All</label>                                                
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-xl-6 col-lg-6 col-md-8 col-sm-12 col-12" style="text-align: right; display:none;">
                                                                                                        <div class="search-container">
                                                                                                            <input type="text" id="search-trdes" class="search-box emp_reg_form" placeholder="Search...">
                                                                                                            <span style="color: #ea5455" id="clear-search-trdes" class="clear-search">&times;</span>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                                                                                        <div id="trdesdatacanvas" class="row scrollhor append-data checkbox-itm" style="width: 100%;overflow-y: scroll;max-height: 10rem;"></div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12" style="border-bottom:1px solid #D3D3D3;border-left:1px solid #D3D3D3">
                                                                                                <div class="row checkbox-grp">
                                                                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="text-align: center;">
                                                                                                        <label style="font-weight: bold;font-size: 15px;" id="trnrec_title_lbl"></label> 
                                                                                                    </div>
                                                                                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12" style="text-align: left;">
                                                                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                                                                            <input type="checkbox" class="custom-control-input select-all-trnrec select-all-checkbox" id="select-all-trnrec" name="select-all-trnrec[]" data-target=".trnrec"/>
                                                                                                            <label class="custom-control-label" for="select-all-trnrec" style="font-weight: bold;">Select All</label>                                                
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-xl-6 col-lg-6 col-md-8 col-sm-12 col-12" style="text-align: right; display:none;">
                                                                                                        <div class="search-container">
                                                                                                            <input type="text" id="search-trnrec" class="search-box emp_reg_form" placeholder="Search...">
                                                                                                            <span style="color: #ea5455" id="clear-search-trnrec" class="clear-search">&times;</span>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                                                                                        <div id="trnrecdatacanvas" class="row scrollhor append-data checkbox-itm" style="width: 100%;overflow-y: scroll;max-height: 10rem;"></div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12" style="border-bottom:1px solid #D3D3D3;border-left:1px solid #D3D3D3">
                                                                                                <div class="row checkbox-grp">
                                                                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="text-align: center;">
                                                                                                        <label style="font-weight: bold;font-size: 15px;" id="appr_title_lbl"></label> 
                                                                                                    </div>
                                                                                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12" style="text-align: left;">
                                                                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                                                                            <input type="checkbox" class="custom-control-input select-all-appr select-all-checkbox" id="select-all-appr" name="select-all-appr[]" data-target=".appr"/>
                                                                                                            <label class="custom-control-label" for="select-all-appr" style="font-weight: bold;">Select All</label>                                                
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-xl-6 col-lg-6 col-md-8 col-sm-12 col-12" style="text-align: right; display:none;">
                                                                                                        <div class="search-container">
                                                                                                            <input type="text" id="search-appr" class="search-box emp_reg_form" placeholder="Search...">
                                                                                                            <span style="color: #ea5455" id="clear-search-appr" class="clear-search">&times;</span>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                                                                                        <div id="apprdatacanvas" class="row scrollhor append-data checkbox-itm" style="width: 100%;overflow-y: scroll;max-height: 10rem;"></div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12" style="border-bottom:1px solid #D3D3D3;border-left:1px solid #D3D3D3">
                                                                                                <div class="row checkbox-grp">
                                                                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="text-align: center;">
                                                                                                        <label style="font-weight: bold;font-size: 15px;" id="issue_title_lbl"></label> 
                                                                                                    </div>
                                                                                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12" style="text-align: left;">
                                                                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                                                                            <input type="checkbox" class="custom-control-input select-all-issue select-all-checkbox" id="select-all-issue" name="select-all-issue[]" data-target=".issue"/>
                                                                                                            <label class="custom-control-label" for="select-all-issue" style="font-weight: bold;">Select All</label>                                                
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-xl-6 col-lg-6 col-md-8 col-sm-12 col-12" style="text-align: right; display:none;">
                                                                                                        <div class="search-container">
                                                                                                            <input type="text" id="search-issue" class="search-box emp_reg_form" placeholder="Search...">
                                                                                                            <span style="color: #ea5455" id="clear-search-issue" class="clear-search">&times;</span>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                                                                                        <div id="issuedatacanvas" class="row scrollhor append-data checkbox-itm" style="width: 100%;overflow-y: scroll;max-height: 10rem;"></div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12" style="border-bottom:1px solid #D3D3D3;border-left:1px solid #D3D3D3">
                                                                                                <div class="row checkbox-grp">
                                                                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="text-align: center;">
                                                                                                        <label style="font-weight: bold;font-size: 15px;" id="adj_title_lbl"></label> 
                                                                                                    </div>
                                                                                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12" style="text-align: left;">
                                                                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                                                                            <input type="checkbox" class="custom-control-input select-all-adj select-all-checkbox" id="select-all-adj" name="select-all-adj[]" data-target=".adj"/>
                                                                                                            <label class="custom-control-label" for="select-all-adj" style="font-weight: bold;">Select All</label>                                                
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-xl-6 col-lg-6 col-md-8 col-sm-12 col-12" style="text-align: right; display:none;">
                                                                                                        <div class="search-container">
                                                                                                            <input type="text" id="search-adj" class="search-box emp_reg_form" placeholder="Search...">
                                                                                                            <span style="color: #ea5455" id="clear-search-adj" class="clear-search">&times;</span>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                                                                                        <div id="adjdatacanvas" class="row scrollhor append-data checkbox-itm" style="width: 100%;overflow-y: scroll;max-height: 10rem;"></div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12" style="border-bottom:1px solid #D3D3D3;border-left:1px solid #D3D3D3">
                                                                                                <div class="row checkbox-grp">
                                                                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="text-align: center;">
                                                                                                        <label style="font-weight: bold;font-size: 15px;" id="beg_title_lbl"></label> 
                                                                                                    </div>
                                                                                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12" style="text-align: left;">
                                                                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                                                                            <input type="checkbox" class="custom-control-input select-all-beg select-all-checkbox" id="select-all-beg" name="select-all-beg[]" data-target=".beg"/>
                                                                                                            <label class="custom-control-label" for="select-all-beg" style="font-weight: bold;">Select All</label>                                                
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-xl-6 col-lg-6 col-md-8 col-sm-12 col-12" style="text-align: right; display:none;">
                                                                                                        <div class="search-container">
                                                                                                            <input type="text" id="search-beg" class="search-box emp_reg_form" placeholder="Search...">
                                                                                                            <span style="color: #ea5455" id="clear-search-beg" class="clear-search">&times;</span>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                                                                                        <div id="begdatacanvas" class="row scrollhor append-data checkbox-itm" style="width: 100%;overflow-y: scroll;max-height: 10rem;"></div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12" style="border-bottom:1px solid #D3D3D3;border-left:1px solid #D3D3D3">
                                                                                                <div class="row checkbox-grp">
                                                                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="text-align: center;">
                                                                                                        <label style="font-weight: bold;font-size: 15px;" id="stbal_title_lbl"></label> 
                                                                                                    </div>
                                                                                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12" style="text-align: left;">
                                                                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                                                                            <input type="checkbox" class="custom-control-input select-all-stbal select-all-checkbox" id="select-all-stbal" name="select-all-stbal[]" data-target=".stbal"/>
                                                                                                            <label class="custom-control-label" for="select-all-stbal" style="font-weight: bold;">Select All</label>                                                
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-xl-6 col-lg-6 col-md-8 col-sm-12 col-12" style="text-align: right; display:none;">
                                                                                                        <div class="search-container">
                                                                                                            <input type="text" id="search-stbal" class="search-box emp_reg_form" placeholder="Search...">
                                                                                                            <span style="color: #ea5455" id="clear-search-stbal" class="clear-search">&times;</span>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                                                                                        <div id="stbaldatacanvas" class="row scrollhor append-data checkbox-itm" style="width: 100%;overflow-y: scroll;max-height: 10rem;"></div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12" style="border-bottom:1px solid #D3D3D3;border-left:1px solid #D3D3D3">
                                                                                                <div class="row">
                                                                                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mt-2 mb-2" style="text-align: left;">
                                                                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                                                                            <input type="checkbox" class="custom-control-input select-all-pur" id="select-all-pur" name="select-all-pur"/>
                                                                                                            <label class="custom-control-label" for="select-all-pur">Is Purchaser</label>                                              
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12" style="border-bottom:1px solid #D3D3D3;border-left:1px solid #D3D3D3"></div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="tab-pane module-assignment tab-view" id="wellness-view" role="tabpanel" aria-labelledby="wellness-view">
                                                                                        <div class="row">
                                                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-1 section-path">
                                                                                                <div class="breadcrumb-path">
                                                                                                    <div class="crumb"><a>General</a></div>
                                                                                                    <div class="crumb"><a>System Access Setting</a></div>
                                                                                                    <div class="crumb"><a>Store/Shop Access Assignment</a></div>
                                                                                                    <div class="crumb active"><a>Wellness</a></div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12" style="border-bottom:1px solid #D3D3D3;border-left:1px solid #D3D3D3">
                                                                                                <div class="row checkbox-grp">
                                                                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="text-align: center;">
                                                                                                        <label style="font-weight: bold;font-size: 15px;" id="fit_pos_title_lbl">POS (Point of Sales)</label> 
                                                                                                    </div>
                                                                                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12" style="text-align: left;">
                                                                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                                                                            <input type="checkbox" class="custom-control-input select-all-fitpos select-all-checkbox" id="select-all-fitpos" name="select-all-fitpos[]" data-target=".fitpos"/>
                                                                                                            <label class="custom-control-label" for="select-all-fitpos" style="font-weight: bold;">Select All</label>                                                
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-xl-6 col-lg-6 col-md-8 col-sm-12 col-12" style="text-align: right; display:none;">
                                                                                                        <div class="search-container">
                                                                                                            <input type="text" id="search-fitpos" class="search-box emp_reg_form" placeholder="Search...">
                                                                                                            <span style="color: #ea5455" id="clear-search-fitpos" class="clear-search">&times;</span>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                                                                                        <div id="fitposdatacanvas" class="row scrollhor append-data checkbox-itm" style="width: 100%;overflow-y: scroll;max-height: 10rem;"></div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            
                                                                                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12" style="border-bottom:1px solid #D3D3D3;border-left:1px solid #D3D3D3"></div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="tab-pane module-assignment tab-view" id="report-view" role="tabpanel" aria-labelledby="report-view">
                                                                                        <div class="row">
                                                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-1 section-path">
                                                                                                <div class="breadcrumb-path">
                                                                                                    <div class="crumb"><a>General</a></div>
                                                                                                    <div class="crumb"><a>System Access Setting</a></div>
                                                                                                    <div class="crumb"><a>Store/Shop Access Assignment</a></div>
                                                                                                    <div class="crumb active"><a>Report</a></div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12 rep-acc" data-report-access="pos" style="border-bottom:1px solid #D3D3D3;border-left:1px solid #D3D3D3">
                                                                                                <div class="row checkbox-grp">
                                                                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="text-align: center;">
                                                                                                        <label style="font-weight: bold;font-size: 15px;" id="posreport_title_lbl">POS (Point of Sales)</label> 
                                                                                                    </div>
                                                                                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12" style="text-align: left;">
                                                                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                                                                            <input type="checkbox" class="custom-control-input select-all-posreport select-all-checkbox" id="select-all-posreport" name="select-all-posreport[]" data-target=".posrep"/>
                                                                                                            <label class="custom-control-label" for="select-all-posreport" style="font-weight: bold;">Select All</label>                                                
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-xl-6 col-lg-6 col-md-8 col-sm-12 col-12" style="text-align: right; display:none;">
                                                                                                        <div class="search-container">
                                                                                                            <input type="text" id="search-posreport" class="search-box emp_reg_form" placeholder="Search...">
                                                                                                            <span style="color: #ea5455" id="clear-search-posreport" class="clear-search">&times;</span>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                                                                                        <div id="posreportdatacanvas" class="row scrollhor append-data checkbox-itm" style="width: 100%;overflow-y: scroll;max-height: 10rem;"></div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12 rep-acc" data-report-access="inventory" style="border-bottom:1px solid #D3D3D3;border-left:1px solid #D3D3D3">
                                                                                                <div class="row checkbox-grp">
                                                                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="text-align: center;">
                                                                                                        <label style="font-weight: bold;font-size: 15px;" id="purchase_title_lbl"></label> 
                                                                                                    </div>
                                                                                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12" style="text-align: left;">
                                                                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                                                                            <input type="checkbox" class="custom-control-input select-all-purchase select-all-checkbox" id="select-all-purchase" name="select-all-purchase[]" data-target=".purchaserep"/>
                                                                                                            <label class="custom-control-label" for="select-all-purchase" style="font-weight: bold;">Select All</label>                                                
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-xl-6 col-lg-6 col-md-8 col-sm-12 col-12" style="text-align: right; display:none;">
                                                                                                        <div class="search-container">
                                                                                                            <input type="text" id="search-purchase" class="search-box emp_reg_form" placeholder="Search...">
                                                                                                            <span style="color: #ea5455" id="clear-search-purchase" class="clear-search">&times;</span>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                                                                                        <div id="purchasedatacanvas" class="row scrollhor append-data checkbox-itm" style="width: 100%;overflow-y: scroll;max-height: 10rem;"></div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12 rep-acc" data-report-access="inventory" style="border-bottom:1px solid #D3D3D3;border-left:1px solid #D3D3D3">
                                                                                                <div class="row checkbox-grp">
                                                                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="text-align: center;">
                                                                                                        <label style="font-weight: bold;font-size: 15px;" id="invrep_title_lbl"></label> 
                                                                                                    </div>
                                                                                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12" style="text-align: left;">
                                                                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                                                                            <input type="checkbox" class="custom-control-input select-all-invrep select-all-checkbox" id="select-all-invrep" name="select-all-invrep[]" data-target=".invreport"/>
                                                                                                            <label class="custom-control-label" for="select-all-invrep" style="font-weight: bold;">Select All</label>                                                
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-xl-6 col-lg-6 col-md-8 col-sm-12 col-12" style="text-align: right; display:none;">
                                                                                                        <div class="search-container">
                                                                                                            <input type="text" id="search-invrep" class="search-box emp_reg_form" placeholder="Search...">
                                                                                                            <span style="color: #ea5455" id="clear-search-invrep" class="clear-search">&times;</span>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                                                                                        <div id="invrepdatacanvas" class="row scrollhor append-data checkbox-itm" style="width: 100%;overflow-y: scroll;max-height: 10rem;"></div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12 rep-acc" data-report-access="wellness" style="border-bottom:1px solid #D3D3D3;border-left:1px solid #D3D3D3">
                                                                                                <div class="row checkbox-grp">
                                                                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="text-align: center;">
                                                                                                        <label style="font-weight: bold;font-size: 15px;" id="wellness_title_lbl"></label> 
                                                                                                    </div>
                                                                                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12" style="text-align: left;">
                                                                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                                                                            <input type="checkbox" class="custom-control-input select-all-wellness select-all-checkbox" id="select-all-wellness" name="select-all-wellness[]" data-target=".wellrep"/>
                                                                                                            <label class="custom-control-label" for="select-all-wellness" style="font-weight: bold;">Select All</label>                                                
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-xl-6 col-lg-6 col-md-8 col-sm-12 col-12" style="text-align: right; display:none;">
                                                                                                        <div class="search-container">
                                                                                                            <input type="text" id="search-wellness" class="search-box emp_reg_form" placeholder="Search...">
                                                                                                            <span style="color: #ea5455" id="clear-search-wellness" class="clear-search">&times;</span>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                                                                                        <div id="wellnessrepdatacanvas" class="row scrollhor append-data checkbox-itm" style="width: 100%;overflow-y: scroll;max-height: 10rem;"></div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12 rep-acc" data-report-access="medical" style="border-bottom:1px solid #D3D3D3;border-left:1px solid #D3D3D3">
                                                                                                <div class="row checkbox-grp">
                                                                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="text-align: center;">
                                                                                                        <label style="font-weight: bold;font-size: 15px;" id="medical_title_lbl"></label> 
                                                                                                    </div>
                                                                                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12" style="text-align: left;">
                                                                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                                                                            <input type="checkbox" class="custom-control-input select-all-medical select-all-checkbox" id="select-all-medical" name="select-all-medical[]" data-target=".medrep"/>
                                                                                                            <label class="custom-control-label" for="select-all-medical" style="font-weight: bold;">Select All</label>                                                
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-xl-6 col-lg-6 col-md-8 col-sm-12 col-12" style="text-align: right; display:none;">
                                                                                                        <div class="search-container">
                                                                                                            <input type="text" id="search-medical" class="search-box emp_reg_form" placeholder="Search...">
                                                                                                            <span style="color: #ea5455" id="clear-search-medical" class="clear-search">&times;</span>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                                                                                        <div id="medicaldatacanvas" class="row scrollhor append-data checkbox-itm" style="width: 100%;overflow-y: scroll;max-height: 10rem;"></div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12" style="border-bottom:1px solid #D3D3D3;border-left:1px solid #D3D3D3"></div>
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
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="tab-pane verticalviewinfo tab-view" id="hr-view" role="tabpanel" aria-labelledby="hr-view">
                                        <ul class="nav nav-tabs nav-fill" role="tablist">
                                            <li class="nav-item formnavitm note">
                                                <a class="nav-link active hr-tabs tab-title active-tab-title" id="hrbasic-tab" data-toggle="tab" href="#hrbasic-view" aria-controls="hrbasic-tab" role="tab" aria-selected="true" title="Basic"><i class="fas fa-user-circle"></i><span class="tab-text">Basic</span></a>                                
                                            </li>
                                            <li class="nav-item formnavitm note">
                                                <a class="nav-link hr-tabs tab-title" id="hratt-tab" data-toggle="tab" href="#hratt-view" aria-controls="hratt-tab" role="tab" aria-selected="true" title="Attendance"><i class="fas fa-calendar-check"></i><span class="tab-text">Attendance</span></a>                                
                                            </li>
                                            <li class="nav-item formnavitm note">
                                                <a class="nav-link hr-tabs tab-title" id="hrguar-tab" data-toggle="tab" href="#hrguar-view" aria-controls="hrguar-tab" role="tab" aria-selected="true" title="Guarantor"><i class="fas fa-user-shield"></i><span class="tab-text">Guarantor</span></a>                                
                                            </li>
                                            <li class="nav-item formnavitm note">
                                                <a class="nav-link hr-tabs tab-title" id="hrbio-tab" data-toggle="tab" href="#hrbio-view" aria-controls="hrbio-tab" role="tab" aria-selected="true" title="Biometric"><i class="fas fa-id-card-alt"></i><span class="tab-text">Biometric</span></a>                                
                                            </li>
                                            <li class="nav-item formnavitm note">
                                                <a class="nav-link hr-tabs tab-title" id="payroll-tab" data-toggle="tab" href="#payroll-view" aria-controls="payroll-tab" role="tab" aria-selected="true" title="Salary"><i class="fas fa-calculator"></i><span class="tab-text">Salary</span></a>                                
                                            </li>
                                            <li class="nav-item formnavitm note">
                                                <a class="nav-link hr-tabs tab-title" id="hrdoc-tab" data-toggle="tab" href="#hrdoc-view" aria-controls="hrdoc-tab" role="tab" aria-selected="true" title="Documents"><i class="fas fa-file-alt"></i><span class="tab-text">Documents</span></a>                                
                                            </li>
                                            <li id="cont-tab" class="nav-item formnavitm note">
                                                <a class="nav-link hr-tabs tab-title" id="hrcont-tab" data-toggle="tab" href="#hrcont-view" aria-controls="hrcont-tab" role="tab" aria-selected="true" title="Contract Agreement"><i class="fas fa-handshake"></i><span class="tab-text">Contract Agreement</span></a>                                
                                            </li>
                                        </ul>
                                        <div class="tab-content formtabcon hr-content-view">
                                            <div class="tab-pane hr-views active tab-view active-tab-view" id="hrbasic-view" aria-labelledby="hrbasic-view" role="tabpanel">
                                                <div class="row ml-1 mb-1 mr-1">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1 section-path">
                                                        <div class="breadcrumb-path">
                                                            <div class="crumb"><a>HR</a></div>
                                                            <div class="crumb active"><a>Basic</a></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-1">
                                                       <label class="form_lbl">Immedaite Manager</label><label style="color: red; font-size:16px;">*</label>
                                                        <select class="select2 form-control" name="SupervisorOrImmedaiteManager" id="SupervisorOrImmedaiteManager" onchange="supervisorFn()">
                                                            @foreach ($employee as $employee)
                                                            <option value="{{$employee->id}}">{{$employee->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel" id="supervisor-error"></strong>
                                                        </span>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-1">
                                                       <label class="form_lbl">Employment Type</label><label style="color: red; font-size:16px;">*</label>
                                                        <select class="select2 form-control" name="EmploymentType" id="EmploymentType" onchange="employmentTypeFn()">
                                                            @foreach ($employment as $employment)
                                                            <option value="{{$employment->id}}">{{$employment->EmploymentTypeName}}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel" id="employmenttype-error"></strong>
                                                        </span>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-1">
                                                       <label class="form_lbl">Hired Date<b style="color:red;">*</b></label>
                                                        <input type="text" id="HiredDate" name="HiredDate" class="form-control emp_reg_form" placeholder="YYYY-MM-DD" readonly onchange="hiredDateVal()"/>
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel" id="hireddate-error"></strong>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane hr-views tab-view" id="hratt-view" aria-labelledby="hratt-view" role="tabpanel">
                                                <div class="row ml-1 mb-1 mr-1">  
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1 section-path">
                                                        <div class="breadcrumb-path">
                                                            <div class="crumb"><a>HR</a></div>
                                                            <div class="crumb active"><a>Attendance</a></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                                                       <label class="form_lbl">Enable Attendance</label><label style="color: red; font-size:16px;">*</label>
                                                        <select class="select2 form-control" name="EnableAttendance" id="EnableAttendance" onchange="enableAttFn()">
                                                            <option value="Yes">Yes</option>
                                                            <option value="No">No</option>
                                                        </select>
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel" id="enableatt-error"></strong>
                                                        </span>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                                                       <label class="form_lbl">Enable Holiday</label><label style="color: red; font-size:16px;">*</label>
                                                        <select class="select2 form-control" name="EnableHoliday" id="EnableHoliday" onchange="enableHolidayFn()">
                                                            <option value="Yes">Yes</option>
                                                            <option value="No">No</option>
                                                        </select>
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel" id="enableholiday-error"></strong>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane hr-views tab-view" id="hrguar-view" aria-labelledby="hrguar-view" role="tabpanel">
                                                <div class="row ml-1 mb-1 mr-1">  
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1 section-path">
                                                        <div class="breadcrumb-path">
                                                            <div class="crumb"><a>HR</a></div>
                                                            <div class="crumb active"><a>Guarantor</a></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                                                       <label class="form_lbl">Guarantor Name<b style="color: red; font-size:16px;">*</b></label>
                                                        <input type="text" id="GuarantorName" name="GuarantorName" class="form-control emp_reg_form" placeholder="Guarantor person name" onkeyup="guarantorNameFn()">
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel" id="guarantorname-error"></strong>
                                                        </span>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                                                       <label class="form_lbl" title="Guarantor Phone Number">Guarantor Phone No.<b style="color: red; font-size:16px;">*</b></label>
                                                        <input type="tel" id="GuarantorPhone" name="GuarantorPhone" class="form-control phone_number emp_reg_form" placeholder="+251-XXX-XX-XX-XX" onkeyup="guarantorPhoneFn()"/>
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel" id="guarantorphone-error"></strong>
                                                        </span>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-6 col-md-12 col-sm-12 col-12 mb-1">
                                                       <label class="form_lbl" title="Guarantor Letter Document">Guarantor Letter Doc.<b style="color: red; font-size:16px;">*</b></label>
                                                        <div class="input-group">
                                                            <input class="form-control fileuploads emp_reg_form" type="file" id="guarantorFile" name="guarantorFile" onchange="showGuarLetterFn()" accept=".jpg, .jpeg, .png,.pdf" style="width:80%;">
                                                            <button type="button" id="preview_guar_file" class="btn btn-light btn-sm guarantor_prop_btn view-doc" onclick="previewGuarFn()" style="color:#00cfe8;background-color:#FFFFFF;border-color:#FFFFFF;padding: 1px 1px;width:9%;display:none;" title="Open uploaded document"><i class="fas fa-eye fa-lg" aria-hidden="true"></i></button>
                                                            <button type="button" id="guarantorBtn" name="guarantorBtn" class="btn btn-light btn-sm guarantor_prop_btn" onclick="guarantorBtnDocFn()" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF;padding: 1px 1px;width:9%;display:none;" title="Remove uploaded document"><i class="fas fa-times fa-lg" aria-hidden="true"></i></button>
                                                        </div>
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel" id="guarantordoc-error"></strong>
                                                            <input type="hidden" class="form-control emp_reg_form" name="GuarantorFileName" id="GuarantorFileName"/>
                                                        </span>                                                   
                                                    </div>
                                                    <div class="col-xl-3 col-lg-6 col-md-12 col-sm-12 col-12 mb-1">
                                                       <label class="form_lbl" title="Guarantor Street Address">Guarantor Address</label>
                                                        <textarea type="text" placeholder="Write street address here..." class="form-control" rows="1" name="GuarantorAddress" id="GuarantorAddress" onkeyup="guarantorAddFn()"></textarea>
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel" id="guarantoraddress-error"></strong>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane hr-views tab-view" id="hrbio-view" aria-labelledby="hrbio-view" role="tabpanel">
                                                <div class="row mt-1 mb-1 ml-1 mr-1">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1 section-path">
                                                        <div class="breadcrumb-path">
                                                            <div class="crumb"><a>HR</a></div>
                                                            <div class="crumb active"><a>Biometric</a></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                                        <div class="row">
                                                            <div class="col-xl-12 col-lg-12 col-md-6 col-sm-6 col-12 mb-1 pl-2 pr-2">
                                                               <label class="form_lbl" class="form-label" for="PIN">PIN</label>
                                                                <input type="text" name="PIN" id="PIN" class="form-control emp_reg_form" placeholder="Personal Identification Number" onkeypress="return ValidateNum(event);" onkeyup="pinFn()"/>
                                                                <span class="text-danger">
                                                                    <strong class="errordatalabel" id="pin-error"></strong>
                                                                </span>
                                                            </div>
                                                            <div class="col-xl-12 col-lg-12 col-md-6 col-sm-6 col-12 mb-1 pl-2 pr-2">
                                                               <label class="form_lbl" class="form-label" for="CardNumber">Card Number</label>
                                                                <input type="text" name="CardNumber" id="CardNumber" class="form-control emp_reg_form" placeholder="Card number" onkeypress="return ValidateNum(event);" onkeyup="cardNumFn()"/>
                                                                <span class="text-danger">
                                                                    <strong class="errordatalabel" id="cardnum-error"></strong>
                                                                </span>
                                                            </div>
                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1 pl-2 pr-2">
                                                               <label class="form_lbl">Enroll Device</label><label style="color: red; font-size:16px;">*</label>
                                                                <select class="select2 form-control" name="EnrollDevice" id="EnrollDevice" onchange="enrolldevFn()">
                                                                    @foreach ($devices as $devices)
                                                                    <option value="{{$devices->id}}">{{$devices->DeviceName}}</option>
                                                                    @endforeach
                                                                </select>
                                                                <span class="text-danger">
                                                                    <strong class="errordatalabel" id="enroll-error"></strong>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-12 col-md-12 col-sm-12 col-12 mb-2 pl-2 pr-2 biometric_div" style="border-left:1px solid #D3D3D3;text-align: center !important;display:none;">
                                                        <p class="mt-0" style="text-align: center;margin-bottom:2px;"><label style="font-size: 20px;font-weight:bold;"><i class="fas fa-camera"></i> Picture</label></p>
                                                        <div class="photo-preview-container mb-1">
                                                            <img id="bioImagePreview" alt="Employee Photo" class="employee-photo-preview employee_img_cls">
                                                            <p id="bioimageclosebtn" class="imageclosecls" style="text-align:center;margin-top:5px;">
                                                                <button type="button" id="removeBioPhotoBtn" name="removeBioPhotoBtn" class="btn btn-flat-danger waves-effect btn-sm removeBioPhotoBtn" onclick="removeBioPhotoFn();"><i class="fa fa-times" aria-hidden="true"></i></button>
                                                            </p>
                                                            <input type="hidden" class="form-control" name="bioPhoto" id="bioPhoto" readonly="true" value=""/>  
                                                        </div>
                                                        <button id="syncbutton" type="button" class="btn btn-outline-info waves-effect" title="Get Face ID data from the device" style="width: 60%;">Get FaceID</button>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 mb-1 pl-2 pr-2 biometric_div" style="border-left:1px solid #D3D3D3;text-align:center !mportant;z-index:999;display:none;">
                                                        <p class="mt-0" style="text-align: center;"><label style="font-size: 20px;font-weight:bold;"><i class="fas fa-fingerprint"></i> Fingerprints</label></p>
                                                        <div class="table-responsive">
                                                            <table style="width: 100%;text-align:center;">
                                                                <tr>
                                                                    <td style="width: 20%" class="right_thumb">
                                                                        <span style="font-size: 22px;"><i class="fas fa-fingerprint fa-lg"></i></span></br>
                                                                        <label style="font-size:12px;font-weight:bold;" class="form-label">Right Thumb</label></br>
                                                                        <label style="font-size:11px;" class="form-label fingerprintcls rightthumblbl"></label>
                                                                    </td>
                                                                    <td style="width: 20%" class="right_index">
                                                                        <span style="font-size: 22px;"><i class="fas fa-fingerprint fa-lg"></i></span></br>
                                                                        <label style="font-size:12px;font-weight:bold;" class="form-label">Right Index</label></br>
                                                                        <label style="font-size:11px;" class="form-label fingerprintcls rightindexlbl"></label>
                                                                    </td>
                                                                    <td style="width: 20%" class="right_middle">
                                                                        <span style="font-size: 22px;"><i class="fas fa-fingerprint fa-lg"></i></span></br>
                                                                        <label style="font-size:12px;font-weight:bold;" class="form-label">Right Middle</label></br>
                                                                        <label style="font-size:11px;" class="form-label fingerprintcls rightmiddlelbl"></label>
                                                                    </td>
                                                                    <td style="width: 20%" class="right_ring">
                                                                        <span style="font-size: 22px;"><i class="fas fa-fingerprint fa-lg"></i></span></br>
                                                                        <label style="font-size:12px;font-weight:bold;" class="form-label">Right Ring</label></br>
                                                                        <label style="font-size:11px;" class="form-label fingerprintcls rightringlbl"></label>
                                                                    </td>
                                                                    <td style="width: 20%" class="right_pinky">
                                                                        <span style="font-size: 22px;"><i class="fas fa-fingerprint fa-lg"></i></span></br>
                                                                        <label style="font-size:12px;font-weight:bold;" class="form-label">Right Pinky</label></br>
                                                                        <label style="font-size:11px;" class="form-label fingerprintcls rightpinkylbl"></label>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="5" style="height: 1rem;"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="left_thumb">
                                                                        <span style="font-size: 22px;"><i class="fas fa-fingerprint fa-lg"></i></span></br>
                                                                        <label style="font-size:12px;font-weight:bold;" class="form-label">Left Thumb</label></br>
                                                                        <label style="font-size:11px;" class="form-label fingerprintcls leftthumblbl"></label>
                                                                    </td>
                                                                    <td class="left_index">
                                                                        <span style="font-size: 22px;"><i class="fas fa-fingerprint fa-lg"></i></span></br>
                                                                        <label style="font-size:12px;font-weight:bold;" class="form-label">Left Index</label></br>
                                                                        <label style="font-size:11px;" class="form-label fingerprintcls leftindexlbl"></label>
                                                                    </td>
                                                                    <td class="left_middle">
                                                                        <span style="font-size: 22px;"><i class="fas fa-fingerprint fa-lg"></i></span></br>
                                                                        <label style="font-size:12px;font-weight:bold;" class="form-label">Left Middle</label></br>
                                                                        <label style="font-size:11px;" class="form-label fingerprintcls leftmiddlelbl"></label>
                                                                    </td>
                                                                    <td class="left_ring">
                                                                        <span style="font-size: 22px;"><i class="fas fa-fingerprint fa-lg"></i></span></br>
                                                                        <label style="font-size:12px;font-weight:bold;" class="form-label">Left Ring</label></br>
                                                                        <label style="font-size:11px;" class="form-label fingerprintcls leftringlbl"></label>
                                                                    </td>
                                                                    <td class="left_pinky">
                                                                        <span style="font-size: 22px;"><i class="fas fa-fingerprint fa-lg"></i></span></br>
                                                                        <label style="font-size:12px;font-weight:bold;" class="form-label">Left Pinky</label></br>
                                                                        <label style="font-size:11px;" class="form-label fingerprintcls leftpinkylbl"></label>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="5" style="height: 1rem;"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td colspan="3">
                                                                        <button id="syncbuttonfp" type="button" class="btn btn-outline-info waves-effect" title="Get Fingerprint data from the device" style="width: 100%">Get Fingerprints</button>
                                                                    </td>
                                                                    <td></td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="tab-pane hr-views tab-view" id="payroll-view" aria-labelledby="payroll-view" role="tabpanel">
                                                <div class="row ml-1 mb-1 mr-1">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1 section-path">
                                                        <div class="breadcrumb-path">
                                                            <div class="crumb"><a>HR</a></div>
                                                            <div class="crumb active"><a>Salary</a></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                                                        <label class="form_lbl">Monthly Work Hour<b style="color: red; font-size:16px;">*</b></label>
                                                        <input type="number" id="monthly_work_hour" name="monthly_work_hour" class="form-control emp_reg_form" placeholder="Monthly work hour" step="any" onkeyup="monthlyworkhrfn()" onkeypress="return ValidateNum(event);"/>
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel payroll-class" id="monthlyworkhr-error"></strong>
                                                        </span>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                                                        <label class="form_lbl">Payment Type<b style="color: red; font-size:16px;">*</b></label>
                                                        <select class="select2 form-control" name="PaymentType" id="PaymentType" onchange="paymentTypeFn()">
                                                            <option value="Bank-Transfer">Bank-Transfer</option>
                                                            <option value="Cash">Cash</option>
                                                        </select>
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel payroll-class" id="paymenttype-error"></strong>
                                                        </span>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                                                        <label class="form_lbl">Payment Period<b style="color: red; font-size:16px;">*</b></label>
                                                        <select class="select2 form-control" name="PaymentPeriod" id="PaymentPeriod" onchange="paymentPeriodFn()">
                                                            <option value="Monthly">Monthly</option>
                                                        </select>
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel payroll-class" id="paymentperiod-error"></strong>
                                                        </span>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-1 bankprop">
                                                        <label class="form_lbl">Bank</label>
                                                        <select class="select2 form-control" name="Bank" id="Bank" onchange="bankNameFn()">
                                                            @foreach ($banks as $banks)
                                                            <option value="{{$banks->id}}">{{$banks->BankName}}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel payroll-class" id="bankname-error"></strong>
                                                        </span>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-1 bankprop">
                                                        <label class="form_lbl">Bank Account No.</label>
                                                        <input type="text" name="BankAccountNumber" id="BankAccountNumber" class="form-control emp_reg_form" placeholder="Bank account number" onkeypress="return ValidateNum(event);" onkeyup="bankAccNumFn()"/>
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel payroll-class" id="bankaccnumber-error"></strong>
                                                        </span>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                                                        <label class="form_lbl">Provident Fund Account</label>
                                                        <input type="text" name="ProvidentFundAccount" id="ProvidentFundAccount" class="form-control emp_reg_form" placeholder="Provident fund account" onkeypress="return ValidateNum(event);" onkeyup="providentFundAccFn()"/>
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel payroll-class" id="providentfundacc-error"></strong>
                                                        </span> 
                                                    </div>
                                                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                                                        <label class="form_lbl">Pension No.</label>
                                                        <input type="text" name="PensionNumber" id="PensionNumber" class="form-control emp_reg_form" placeholder="Pension number" onkeypress="return ValidateNum(event);" onkeyup="pensionNumFn()"/>
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel payroll-class" id="pensionnumber-error"></strong>
                                                        </span>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                                                        <label class="form_lbl" for="Tin">TIN</label>
                                                        <input type="text" name="Tin" id="Tin" class="form-control emp_reg_form" placeholder="Taxpayer identification number" onkeypress="return ValidateNum(event);" onkeydown="clearTinnumberError()" onkeyup="TinNumberCounter()"/>
                                                        <span><label class="form_lbl" id="tinCounter">0/13</label></span></br>
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel payroll-class" id="TinNumber-error"></strong>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane hr-views tab-view" id="hrdoc-view" aria-labelledby="hrdoc-view" role="tabpanel">
                                                <div class="row ml-1 mb-1 mr-1">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1 section-path">
                                                        <div class="breadcrumb-path">
                                                            <div class="crumb"><a>HR</a></div>
                                                            <div class="crumb active"><a>Documents</a></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="width: 100%;overflow-x: auto;-webkit-overflow-scrolling: touch;margin: 0 -1rem;padding: 0 1rem;">
                                                        <label style="font-size:16px;">Add Documents</label>
                                                        <table id="documentDynamicTable" class="mt-0 rtable form_dynamic_table table-responsive" style="width: 100%;min-width: 900px;">
                                                            <thead>
                                                                <tr style="text-align:center;">
                                                                    <th style="width:3%;">#</th>
                                                                    <th style="width:22%;">Type</th>
                                                                    <th style="width:22%;">Date</th>
                                                                    <th style="width:25%;">Document</th>
                                                                    <th style="width:25%;">Remark</th>
                                                                    <th style="width:3%;"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody></tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <th style="background-color:#FFFFFF;padding: 0px 0px 0px 0px">
                                                                        <button type="button" name="docmnt_btn" id="docmnt_btn" class="btn btn-sm btn-light" style="color:#28c76f;background-color:#FFFFFF;border-color:#FFFFFF;padding: 4px 5px;font-weight:bold;"><i class="fa fa-plus fa-lg" aria-hidden="true" style="font-size: :14%;"></i></button>
                                                                    </th>
                                                                    <th colspan="5" style="background-color:#FFFFFF;border-color:#FFFFFF;"></th>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel" id="docmnt-doc-error"></strong>
                                                        </span>                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane hr-views tab-view" id="hrcont-view" aria-labelledby="hrcont-view" role="tabpanel">
                                                <div class="row ml-1 mb-1 mr-1">  
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1 section-path">
                                                        <div class="breadcrumb-path">
                                                            <div class="crumb"><a>HR</a></div>
                                                            <div class="crumb active"><a>Contract Agreement</a></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="width: 100%;overflow-x: auto;-webkit-overflow-scrolling: touch;margin: 0 -1rem;padding: 0 1rem;">
                                                        <label style="font-size:16px;">Add Contracts</label>
                                                        <table id="contractDynamicTable" class="mt-0 rtable form_dynamic_table table-responsive" style="width: 100%;min-width: 900px;">
                                                            <thead>
                                                                <tr style="text-align:center;">
                                                                    <th style="width:3%;">#</th>
                                                                    <th style="width:15%;">Sign Date</th>
                                                                    <th style="width:15%;">Expire Date</th>
                                                                    <th style="width:15%;">Duration <i>(Days)</i></th>
                                                                    <th style="width:25%;">Document</th>
                                                                    <th style="width:24%;">Remark</th>
                                                                    <th style="width:3%;"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody></tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <th style="background-color:#FFFFFF;padding: 0px 0px 0px 0px">
                                                                        <button type="button" name="cont_doc_btn" id="cont_doc_btn" class="btn btn-sm btn-light" style="color:#28c76f;background-color:#FFFFFF;border-color:#FFFFFF;padding: 4px 5px;font-weight:bold;"><i class="fa fa-plus fa-lg" aria-hidden="true" style="font-size: :14%;"></i></button>
                                                                    </th>
                                                                    <th colspan="6" style="background-color:#FFFFFF;border-color:#FFFFFF;"></th>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel" id="cont-doc-error"></strong>
                                                        </span>                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane hr-views" id="leaveallocation" aria-labelledby="leaveallocation" role="tabpanel">
                                                <div class="row ml-1 mb-1 mr-1">
                                                    <div class="col-lg-12 col-md-12 col-12 mt-1">
                                                        
                                                    </div>
                                                    <div class="col-lg-3 col-md-12 col-12 mt-1" style="display: none;">
                                                       <label class="form_lbl">Leave Allocation Memo</label>
                                                        <textarea type="text" placeholder="Write Leave allocation memo here..." class="form-control" rows="2" name="LeaveAllocation" id="LeaveAllocation" onkeyup="leaveAllocMemoFn()"></textarea>
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel" id="leaveallocation-error"></strong>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                    </div>

                                    <div class="tab-pane verticalviewinfo tab-view" id="wellness-side-view" role="tabpanel" aria-labelledby="wellness-side-view">
                                        <ul class="nav nav-tabs nav-fill" role="tablist">
                                            <li class="nav-item wellness-entity note">
                                                <a class="nav-link wellness-entity-tab active wellness-skill tab-title active-tab-title" id="wellness-skill-tab" data-toggle="tab" href="#wellness-skill-view" aria-controls="wellness-skill-tab" role="tab" aria-selected="true" title="Skills"><i class="fas fa-brain"></i><span class="tab-text">Skills</span></a>                                
                                            </li>
                                        </ul>
                                        <div class="tab-content well-entity-view wellness-skill-content-view">
                                            <div class="tab-pane wellness-entity-view active active-tab-view" id="wellness-skill-view" aria-labelledby="wellness-skill-view" role="tabpanel">
                                                <div class="row ml-1 mb-1 mr-1">  
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1 section-path">
                                                        <div class="breadcrumb-path">
                                                            <div class="crumb"><a>Wellness</a></div>
                                                            <div class="crumb active"><a>Skills</a></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="width: 100%;overflow-x: auto;-webkit-overflow-scrolling: touch;margin: 0 -1rem;padding: 0 1rem;">
                                                        <label style="font-size:16px;">Add Skills</label>
                                                        <table id="wellnessDynamicTable" class="mt-0 rtable form_dynamic_table" style="width: 100%;min-width: 900px;">
                                                            <thead>
                                                                <tr style="text-align:center;">
                                                                    <th style="width:5%;">#</th>
                                                                    <th style="width:25%;">Skill</th>
                                                                    <th style="width:25%;">Level</th>
                                                                    <th style="width:40%;">Remark</th>
                                                                    <th style="width:5%;"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody></tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <th style="background-color:#FFFFFF;padding: 0px 0px 0px 0px">
                                                                        <button type="button" name="well_skill_btn" id="well_skill_btn" class="btn btn-sm btn-light" style="color:#28c76f;background-color:#FFFFFF;border-color:#FFFFFF;padding: 4px 5px;font-weight:bold;"><i class="fa fa-plus" aria-hidden="true" style="font-size: :14%;"></i></button>
                                                                    </th>
                                                                    <th colspan="3" style="background-color:#FFFFFF;border-color:#FFFFFF;"></th>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel" id="wellness-skill-error"></strong>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane verticalviewinfo tab-view" id="medical-view" role="tabpanel" aria-labelledby="medical-view">
                                        <ul class="nav nav-tabs nav-fill" role="tablist">
                                            <li class="nav-item medical-entity note">
                                                <a class="nav-link medical-entity-tab active medical-skill tab-title active-tab-title" id="medical-skill-tab" data-toggle="tab" href="#medical-skill-view" aria-controls="medical-skill-tab" role="tab" aria-selected="true" title="Skills"><i class="fas fa-brain"></i><span class="tab-text">Skills</span></a>                                
                                            </li>
                                        </ul>
                                        <div class="tab-content med-entity-view medical-skill-content-view">
                                            <div class="tab-pane formtab medical-entity-view active tab-view active-tab-view" id="medical-skill-view" aria-labelledby="medical-skill-view" role="tabpanel">
                                                <div class="row ml-1 mb-1 mr-1">  
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1 section-path">
                                                        <div class="breadcrumb-path">
                                                            <div class="crumb"><a>Medical</a></div>
                                                            <div class="crumb active"><a>Skills</a></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="width: 100%;overflow-x: auto;-webkit-overflow-scrolling: touch;margin: 0 -1rem;padding: 0 1rem;">
                                                        <label style="font-size:16px;">Add Skills</label>
                                                        <table id="medicalDynamicTable" class="mt-0 rtable form_dynamic_table" style="width: 100%;min-width: 900px;">
                                                            <thead>
                                                                <tr style="text-align:center;">
                                                                    <th style="width:5%;">#</th>
                                                                    <th style="width:25%;">Skill</th>
                                                                    <th style="width:25%;">Level</th>
                                                                    <th style="width:40%;">Remark</th>
                                                                    <th style="width:5%;"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody></tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <th style="background-color:#FFFFFF;padding: 0px 0px 0px 0px">
                                                                        <button type="button" name="med_skill_btn" id="med_skill_btn" class="btn btn-sm btn-light" style="color:#28c76f;background-color:#FFFFFF;border-color:#FFFFFF;padding: 4px 5px;font-weight:bold;"><i class="fa fa-plus" aria-hidden="true" style="font-size: :14%;"></i></button>
                                                                    </th>
                                                                    <th colspan="3" style="background-color:#FFFFFF;border-color:#FFFFFF;"></th>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel" id="medical-skill-error"></strong>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>     
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control emp_reg_form" name="name" id="fullName" readonly="true" value=""/>  
                        <input type="hidden" class="form-control fingerprintval emp_reg_form" name="LeftThumbVal" id="LeftThumbVal" readonly="true" value=""/>
                        <input type="hidden" class="form-control fingerprintval emp_reg_form" name="LeftIndexVal" id="LeftIndexVal" readonly="true" value=""/>
                        <input type="hidden" class="form-control fingerprintval emp_reg_form" name="LeftMiddelVal" id="LeftMiddelVal" readonly="true" value=""/>
                        <input type="hidden" class="form-control fingerprintval emp_reg_form" name="LeftRingVal" id="LeftRingVal" readonly="true" value=""/>
                        <input type="hidden" class="form-control fingerprintval emp_reg_form" name="LeftPickyVal" id="LeftPickyVal" readonly="true" value=""/>
                        <input type="hidden" class="form-control fingerprintval emp_reg_form" name="RightThumbVal" id="RightThumbVal" readonly="true" value=""/>
                        <input type="hidden" class="form-control fingerprintval emp_reg_form" name="RightIndexVal" id="RightIndexVal" readonly="true" value=""/>
                        <input type="hidden" class="form-control fingerprintval emp_reg_form" name="RightMiddleVal" id="RightMiddleVal" readonly="true" value=""/>
                        <input type="hidden" class="form-control fingerprintval emp_reg_form" name="RightRingVal" id="RightRingVal" readonly="true" value=""/>
                        <input type="hidden" class="form-control fingerprintval emp_reg_form" name="RightPickyVal" id="RightPickyVal" readonly="true" value=""/>
                        <input type="hidden" class="form-control emp_reg_form" name="recId" id="recId" readonly="true" value=""/>   
                        <input type="hidden" class="form-control emp_reg_form" name="personuuid" id="personuuid" readonly="true" value=""/>       
                        <input type="hidden" class="form-control emp_reg_form" name="operationtypes" id="operationtypes" readonly="true"/>
                        <input type="hidden" class="form-control emp_reg_form" name="faceidencoded" id="faceidencoded" readonly="true" value=""/>  
                        <div style="display: none;">
                            <div class="col-xl-3 col-md-12 col-sm-12 mb-1">
                               <label class="form_lbl">Shift</label><label style="color: red; font-size:16px;">*</label>
                                <select class="select2 form-control" name="Shift" id="Shift" onchange="shiftFn()">
                                    @foreach ($shift as $shift)
                                        <option value="{{$shift->id}}">{{$shift->ShiftName}}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger">
                                    <strong class="errordatalabel" id="shift-error"></strong>
                                </span>
                            </div>
                            <select name="PositionCbx" id="PositionCbx" class="select2 form-control">
                                @foreach ($position as $position)
                                <option title="{{$position->departments_id}}" value="{{$position->id}}">{{$position->PositionName}}</option>
                                @endforeach
                            </select>
                            <select name="subcitycbx" id="subcitycbx" class="select2 form-control">
                                <option disabled selected value=""></option>
                                @foreach ($subcity as $subcity)
                                <option data-city="{{$subcity->city_id}}" value="{{$subcity->id}}">{{$subcity->subcity_name}}</option>
                                @endforeach
                            </select>
                            <select name="AccessRoleCbx" id="AccessRoleCbx" class="select2 form-control">
                                @foreach ($roles as $role)
                                <option value='{{ $role }}'>{{ $role }}</option>
                                @endforeach
                            </select>
                            <select name="skillset_default" id="skillset_default" class="select2 form-control">
                                <option selected disabled value=""></option>
                                @foreach ($skill_set as $skill_set)
                                <option data-skill-type="{{$skill_set->type}}" value="{{$skill_set->id}}">{{$skill_set->name}}</option>
                                @endforeach
                            </select>
                            <select name="level_default" id="level_default" class="select2 form-control">
                                <option selected disabled value=""></option>
                                @foreach ($level as $level)
                                <option value="{{$level->id}}">{{$level->LookupName}}</option>
                                @endforeach
                            </select>
                            <select name="doc_type_default" id="doc_type_default" class="select2 form-control">
                                <option selected disabled value=""></option>
                                @foreach ($doc_type as $doc_type)
                                <option value="{{$doc_type->id}}">{{$doc_type->LookupName}}</option>
                                @endforeach
                            </select>
                            <select class="select2 form-control" name="woreda_default" id="woreda_default">
                                <option selected disabled value=""></option>
                                <option data-w="main" value="-">-</option>
                                <option data-w="main" value="Woreda 1">Woreda 1</option>
                                <option data-w="main" value="Woreda 2">Woreda 2</option>
                                <option data-w="main" value="Woreda 3">Woreda 3</option>
                                <option data-w="main" value="Woreda 4">Woreda 4</option>
                                <option data-w="main" value="Woreda 5">Woreda 5</option>
                                <option data-w="main" value="Woreda 6">Woreda 6</option>
                                <option data-w="main" value="Woreda 7">Woreda 7</option>
                                <option data-w="main" value="Woreda 8">Woreda 8</option>
                                <option data-w="main" value="Woreda 9">Woreda 9</option>
                                <option data-w="main" value="Woreda 10">Woreda 10</option>
                                <option data-w="main" value="Woreda 11">Woreda 11</option>
                                <option data-w="main" value="Woreda 12">Woreda 12</option>
                                <option data-w="main" value="Woreda 13">Woreda 13</option>
                                <option data-w="main" value="Woreda 14">Woreda 14</option>
                            </select>
                        </div>
                        @can('Employee-Add')
                        <button style="display: none;" id="savenewbutton" type="button" class="btn btn-info">Save & New</button>
                        <button id="savebutton" type="submit" class="btn btn-info">Save</button>
                        @endcan
                        <button id="closebutton" type="button" class="btn btn-danger" onclick="closeRegisterModal()" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End employee registration modal -->

    <!--Start employee delete modal -->
    <div class="modal fade text-left" id="deleteconfmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel35" aria-hidden="true">
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
                        <label style="font-size: 16px;font-weight:bold;color:white;">Do you really want to delete this employee?</label>
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="delId" id="delId" readonly="true">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="deletempbtn" type="button" class="btn btn-info">Delete</button>
                        <button id="closebuttonl" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End employee delete modal -->

    <!--Start manage leave allocation modal -->
    <div class="modal modal-slide-in event-sidebar fade fit-content" id="manageleaveallocmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="banktitlelbl" aria-hidden="true" style="overflow-y: scroll;">
        <form id="LeaveAllocForm">
        {{ csrf_field() }}
        <div class="modal-dialog sidebar-xl" role="document" style="width: 95%">
            <div class="modal-content p-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #ea5455 !important;font-weight:bold;">x</button>
                <div class="modal-header mb-1">
                    <h5 class="modal-title form_title" id="modalleavealloc">Leave Allocation Setup</h5>
                    <div class="form_title" style="text-align: center;padding-right:30px;" id="leavealloc"></div>
                </div>
                <div class="modal-body flex-grow-1 pb-sm-0">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-1" style="text-align: left">
                            <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mt-1" style="text-align: center;">
                                <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto mt-2">
                                    <img id="employeepicleavealloc" src="../../../storage/uploads/HrEmployee/dummypic.jpg" alt="-" class="employee-photo-preview-info employee_img_cls">
                                </div>
                                <div class="flex-grow-0 mt-0 mt-sm-0" style="margin-left: -25px;">
                                    <div class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                                        <div class="user-profile-info" style="text-align: left;">
                                            <h3 id="employeenameleavealloc" class="info-main-title" title="Employee Full Name"></h3>
                                            <ul class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                                                <li class="list-inline-item d-flex gap-1">
                                                    <label id="branchleavealloc" class="info-sub-title" title="Branch"></label>
                                                </li>
                                                <li class="list-inline-item d-flex gap-1">
                                                    <label id="departmentleavealloc" class="info-sub-title" title="Department"></label>
                                                </li>
                                                <li class="list-inline-item d-flex gap-1">
                                                    <label id="positionleavealloc" class="info-sub-title" title="Position"></label>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="mb-1"/>
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="text-align: right;">
                            <button type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm" onclick="refreshEmpLeaveFn()"><i class="fas fa-sync-alt"></i></button>
                            @if (auth()->user()->can('Leave-Allocation-Add'))
                                <button type="button" class="btn btn-gradient-info btn-sm addleavealloc" id="addleavealloc">Add</button>
                            @endif
                        </div>
                    </div>
                    <hr class="mb-0"/>
                    <div class="row mt-1 border-bottom">
                        <div class="col-xl-1 col-lg-2 col-md-2 col-sm-4 col-4 mb-1">
                            <div class="stat-item">
                                <div class="media">
                                    <div class="avatar bg-light-secondary mr-1">
                                        <div class="avatar-content">
                                            <i class="fas fa-calendar-lines"></i>
                                        </div>
                                    </div>
                                    <div class="media-body my-auto mr-1">
                                        <span class="font-weight-bolder mb-0 leave_status_record_lbl" id="leave_draft_record_lbl"></span>
                                        <p class="card-text font-small-3 mb-0">Draft</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-1 col-lg-2 col-md-2 col-sm-4 col-4 mb-1">
                            <div class="stat-item">
                                <div class="media">
                                    <div class="avatar bg-light-warning mr-1">
                                        <div class="avatar-content">
                                            <i class="fas fa-calendar-lines"></i>
                                        </div>
                                    </div>
                                    <div class="media-body my-auto mr-1">
                                        <span class="font-weight-bolder mb-0 leave_status_record_lbl" id="leave_pending_record_lbl"></span>
                                        <p class="card-text font-small-3 mb-0">Pending</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-1 col-lg-2 col-md-2 col-sm-4 col-4 mb-1">
                            <div class="stat-item">
                                <div class="media">
                                    <div class="avatar bg-light-primary mr-1">
                                        <div class="avatar-content">
                                            <i class="fas fa-calendar-lines"></i>
                                        </div>
                                    </div>
                                    <div class="media-body my-auto mr-1">
                                        <span class="font-weight-bolder mb-0 leave_status_record_lbl" id="leave_verified_record_lbl"></span>
                                        <p class="card-text font-small-3 mb-0">Verified</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-1 col-lg-2 col-md-2 col-sm-4 col-4 mb-1">
                            <div class="stat-item">
                                <div class="media">
                                    <div class="avatar bg-light-success mr-1">
                                        <div class="avatar-content">
                                            <i class="fas fa-calendar-lines"></i>
                                        </div>
                                    </div>
                                    <div class="media-body my-auto mr-1">
                                        <span class="font-weight-bolder mb-0 leave_status_record_lbl" id="leave_approved_record_lbl"></span>
                                        <p class="card-text font-small-3 mb-0">Approved</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-1 col-lg-2 col-md-2 col-sm-4 col-4 mb-1">
                            <div class="stat-item">
                                <div class="media">
                                    <div class="avatar bg-light-danger mr-1">
                                        <div class="avatar-content">
                                            <i class="fas fa-calendar-lines"></i>
                                        </div>
                                    </div>
                                    <div class="media-body my-auto mr-1">
                                        <span class="font-weight-bolder mb-0 leave_status_record_lbl" id="leave_void_record_lbl"></span>
                                        <p class="card-text font-small-3 mb-0">Void</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-1 col-lg-2 col-md-2 col-sm-4 col-4 mb-1">
                            <div class="stat-item">
                                <div class="media">
                                    <div class="avatar bg-light-secondary mr-1">
                                        <div class="avatar-content">
                                            <i class="fas fa-calendar-lines"></i>
                                        </div>
                                    </div>
                                    <div class="media-body my-auto mr-1">
                                        <span class="font-weight-bolder mb-0 leave_status_record_lbl" id="leave_total_record_lbl"></span>
                                        <p class="card-text font-small-3 mb-0">Total</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>       
                    
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 table-responsive">
                            <div style="width:99%; margin-left:0.5%;">
                                <div style="display: none;" id="leaveAllocDiv">
                                    <table id="leavealloctable" class="display table-bordered table-striped table-hover defaultdatatable mb-0" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th style="display: none;"></th>
                                                <th style="width:3%;">#</th>
                                                <th style="width:24%;">Reference No.</th>
                                                <th style="width:23%;">Type</th>
                                                <th style="width:23%;">Date</th>
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
                <div class="modal-footer">
                    <input type="hidden" class="form-control" name="leaveFormEmpId" id="leaveFormEmpId" readonly="true"/> 
                    <button id="closebuttonleave" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
                
            </div>
        </div>
        </form>
    </div>
    <!--End manage leave allocation modal -->

    <!-- start leave allocation info modal-->
    <div class="modal modal-slide-in event-sidebar fade fit-content" id="leaveallocinfomodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y:scroll;">
        <form id="LeaveAllocationInfo">    
            <div class="modal-dialog sidebar-xl side_slide_modal" style="width: 93%;">
                <div class="modal-content p-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #ea5455 !important;font-weight:bold;">x</button>
                    <div class="modal-header mb-1">
                        <h4 class="modal-title form_title">Leave Allocation Information</h4>
                        <div style="text-align: center;padding-right:30px;" id="leaveallocinfostatus"></div>
                    </div>
                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <section id="collapsible">
                                    <div class="card collapse-icon">
                                        <div class="collapse-default">
                                            <div class="card">
                                                <div id="headingCollapse3" class="card-header" data-toggle="collapse" role="button" data-target=".infoleavealloc" aria-expanded="false" aria-controls="collapse1">
                                                    <span class="lead collapse-title form_title">Basic Information</span>
                                                    <div id="shiftScheduleTitle" style="font-weight: bold;font-size:15px;"></div>
                                                </div>
                                                <div id="collapse3" role="tabpanel" aria-labelledby="headingCollapse3" class="collapse infoleavealloc">
                                                    <div class="row ml-1 mb-1">
                                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                            <table class="infotbl" style="width: 100%;font-size:12px">
                                                                <tr>
                                                                    <td><label class="info_lbl">Employee Name</label></td>
                                                                    <td><label class="info_lbl sl_emp_name" id="leave_emp_name" style="font-weight:bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl">Type</label></td>
                                                                    <td><label class="info_lbl" id="leavealloctypelbl" style="font-weight:bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl">Date</label></td>
                                                                    <td><label class="info_lbl" id="leaveallocdate" style="font-weight:bold;"></label></td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                        <div class="col-xl-4 col-lg-5 col-md-12 col-sm-12 col-12" style="border-left: 1px solid #D3D3D3;display:none;">
                                                            <label id="leaveallocationaction" style="font-size: 15px;font-weight:bold;">Action Information</label>
                                                            <div class="col-lg-12 col-md-12 col-sm-12 scrdivhor scrollhor" style="overflow-y: scroll;height:13rem">
                                                                <ul id="leaveallocactiondiv" class="timeline mb-0 mt-0"></ul>
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
                        <hr class="m-0"/>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 table-responsive">
                                <div style="display: none" id="leaveallocTblDiv">
                                    <table id="leaveallocTbl" class="display table-bordered table-striped table-hover defaultdatatable mb-0" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th style="width:3%;">#</th>
                                                <th style="width:20%;">Leave Type</th>
                                                <th style="width:19%;">Leave Payment Type</th>
                                                <th style="width:19%;">Year</th>
                                                <th style="width:19%;">Leave Balance</th>
                                                <th style="width:20%;">Remark</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table table-sm"></tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="4" style="text-align: right;">Total</th>
                                                <th id="totaldaysLbl" style="text-align: left;font-weight:bold;padding-left:8px;"></th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
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
                                        <button type="button" class="btn btn-outline-info dropdown-toggle hide-arrow action-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa-sharp fa-solid fa-caret-up fa-xl"></i><span class="btn-text">&nbsp Actions</span>
                                        </button>
                                        <ul class="dropdown-menu" id="leave_alloc_action_ul"></ul>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align:right">
                                    <input type="hidden" class="form-control" name="allocEmpId" id="allocEmpId" readonly="true"/>
                                    <input type="hidden" class="form-control" name="allocDetRecId" id="allocDetRecId" readonly="true"/> 
                                    <input type="hidden" class="form-control" name="recordCountVal" id="recordCountVal" readonly="true"/>    
                                    <input type="hidden" class="form-control" name="la_currentStatus" id="la_currentStatus" readonly="true">
                                    <input type="hidden" class="form-control" name="la_forwardReqId" id="la_forwardReqId" readonly="true">
                                    <input type="hidden" class="form-control" name="la_newForwardStatusValue" id="la_newForwardStatusValue" readonly="true">
                                    <input type="hidden" class="form-control" name="la_forwarkBtnTextValue" id="la_forwarkBtnTextValue" readonly="true">
                                    <input type="hidden" class="form-control" name="la_forwardActionValue" id="la_forwardActionValue" readonly="true">
                                    <button id="closebuttonleaveinfo" type="button" class="btn btn-danger" data-dismiss="modal">Close</button> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!--/ end leave allocation info modal-->

    <!-- start leave allocation form modal-->
    <div class="modal modal-slide-in event-sidebar fade fit-content" id="leaveallocformmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y:scroll;">
        <form id="LeaveAllocationForm">    
            <div class="modal-dialog sidebar-xl side_slide_modal" style="width: 93%;">
                <div class="modal-content p-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #ea5455 !important;font-weight:bold;">x</button>
                    <div class="modal-header mb-1">
                        <h4 class="modal-title form_title" id="leavealloctitle"></h4>
                        <div style="text-align: center;padding-right:30px;" class="form_title" id="leaveallocstatus"></div>
                    </div>
                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <span class="text-danger">
                                    <strong class="errordatalabel" id="table-error" class="dataclass"></strong>
                                </span>
                                <table id="leavealloctbl" class="rtable slide_modal_lbl" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th style="width:3%;">#</th>
                                            <th style="width:19%;">Leave Type</th>
                                            <th style="width:19%;">Leave Payment Type</th>
                                            <th style="width:18%;">Year</th>
                                            <th style="width:18%;">Leave Balance</th>
                                            <th style="width:19%;">Remark</th>
                                            <th style="width:4%;"></th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                        <tr style="text-align:left;">
                                            <th colspan="4" style="text-align:left;background-color: #FFFFFF;border:none;padding:0px;">
                                                <button type="button" name="leaveadds" id="leaveadds" class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i>  Add New</button>
                                                <label style="text-align:right;float:right;">Total</label>
                                            </th>
                                            <th class="dataclass" id="totalleavebalance"></th>
                                            <th style="background-color: #FFFFFF;border:none;padding:0px;" colspan="2"></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div style="display: none;">
                            <input type="hidden" class="form-control" name="allocEmployeeId" id="allocEmployeeId" readonly="true"/>     
                            <input type="hidden" class="form-control" name="allocRecId" id="allocRecId" readonly="true"/>     
                            <input type="hidden" class="form-control" name="allocOperationType" id="allocOperationType" readonly="true"/>
                            <select name="defaultleavetype" id="defaultleavetype" class="select2 form-control">
                                <option selected disabled value=""></option>
                                @foreach ($hrleavetype as $hrleavetype)
                                <option data-ptype="{{$hrleavetype->LeavePaymentType}}" value="{{ $hrleavetype->id }}">{{ $hrleavetype->LeaveType }}</option>
                                @endforeach
                            </select>
                            <select class="select2 form-control" name="defaultyear" id="defaultyear"></select>
                        </div>
                        <button id="saveleaveallocbtn" type="button" class="btn btn-info">Save</button>
                        <button id="closebuttonleaveform" type="button" class="btn btn-danger" data-dismiss="modal">Close</button> 
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!--/ end leave allocation form modal-->

    <!--Start Void modal -->
    <div class="modal fade text-left" id="voidleaveallocmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="voidReason()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="voidreasonform">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group" style="display: none;">
                            <label style="font-size: 16px;font-weight:bold;">Are you sure want to void leave allocation?</label>
                        </div>
                        <div class="divider" style="display: none;">
                            <div class="divider-text">Reason</div>
                        </div>
                        <label class="form_lbl">Reason</label>
                        <textarea type="text" placeholder="Write Reason here..." class="form-control Reason" rows="3" name="Reason" id="Reason" onkeyup="voidReason()"></textarea>
                        <span class="text-danger">
                            <strong class="errordatalabel" id="void-error"></strong>
                        </span>
                        <div class="form-group">
                            <input type="hidden" class="form-control voidid" name="voidid" id="voidid" readonly="true">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="voidbtn" type="button" class="btn btn-info">Void</button>
                        <button id="closebuttoni" type="button" class="btn btn-danger" data-dismiss="modal" onclick="voidReason()">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Void modal -->

    <!--Start leave allocation backward action modal -->
    <div class="modal fade text-left" id="la_backwardActionModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="la_backwardActionForm">
                    @csrf
                    <div class="modal-body">
                        <label style="font-size: 14px;" id="la_backwardActionLabel"></label>
                        <div class="form-group">
                            <textarea type="text" placeholder="Write Reason here..." class="form-control" rows="3" name="la_CommentOrReason" id="la_CommentOrReason" onkeyup="leaveReasonFn()"></textarea>
                            <span class="text-danger">
                                <strong id="la_commentres-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control" name="la_backwardReqId" id="la_backwardReqId" readonly="true">
                        <input type="hidden" class="form-control" name="la_newBackwardStatusValue" id="la_newBackwardStatusValue" readonly="true">
                        <input type="hidden" class="form-control" name="la_backwardBtnTextValue" id="la_backwardBtnTextValue" readonly="true">
                        <input type="hidden" class="form-control" name="la_backwardActionValue" id="la_backwardActionValue" readonly="true">
                        <button id="la_backwardActionBtn" type="button" class="btn btn-info"></button>
                        <button id="la_closebuttonbackwardAction" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End leave allocation backward action modal -->

    <!--Start payroll setting modal -->
    <div class="modal modal-slide-in event-sidebar fade fit-content" id="managepayrollsettingmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="banktitlelbl" aria-hidden="true" style="overflow-y: scroll;">
        <form id="PayrollSettingForm">
            {{ csrf_field() }}
            <div class="modal-dialog sidebar-xl side_slide_modal" style="width: 95%">
                <div class="modal-content p-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #ea5455 !important;font-weight:bold;">x</button>
                    <div class="modal-header mb-1">
                        <h4 class="modal-title form_title" id="modalpayrollsettingtitle">Salary Setup</h4>
                        <div style="text-align: center;padding-right:30px;" class="form_title" id="salary_setting_title"></div>
                    </div>
                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-1" style="text-align: left">
                                <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mt-1" style="text-align: center;">
                                    <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto mt-2">
                                        <img id="employeepicpayrollsett" src="../../../storage/uploads/HrEmployee/dummypic.jpg" alt="-" class="employee-photo-preview-info employee_img_cls">
                                    </div>
                                    <div class="flex-grow-0 mt-0 mt-sm-0" style="margin-left: -25px;">
                                        <div class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                                            <div class="user-profile-info" style="text-align: left;">
                                                <h3 id="employeenamepayrollsett" class="info-main-title" title="Employee Full Name"></h3>
                                                <ul class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                                                    <li class="list-inline-item d-flex gap-1">
                                                        <label id="branchpayrollsett" class="info-sub-title" title="Branch"></label>
                                                    </li>
                                                    <li class="list-inline-item d-flex gap-1">
                                                        <label id="departmentpayrollsett" class="info-sub-title" title="Department"></label>
                                                    </li>
                                                    <li class="list-inline-item d-flex gap-1">
                                                        <label id="positionpayrollsett" class="info-sub-title" title="Position"></label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="mb-1"/>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="text-align: right">
                                <button type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm" onclick="refreshEmpSalaryFn()"><i class="fas fa-sync-alt"></i></button>
                                @can('Employee-Salary-Add')
                                <button type="button" class="btn btn-gradient-info btn-sm addsalary" id="addsalary">Add</button>
                                @endcan
                            </div>
                        </div>
                        <hr class="mb-0"/>
                        <div class="row mt-1 border-bottom">
                            <div class="col-xl-1 col-lg-1 col-md-3 col-sm-3 col-4 mb-1">
                                <div class="stat-item">
                                    <div class="media">
                                        <div class="avatar bg-light-secondary mr-1">
                                            <div class="avatar-content">
                                                <i class="fas fa-money-bill-wave"></i>
                                            </div>
                                        </div>
                                        <div class="media-body my-auto mr-1">
                                            <span class="font-weight-bolder mb-0 salary_status_record_lbl" id="salary_draft_record_lbl"></span>
                                            <p class="card-text font-small-3 mb-0">Draft</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-1 col-lg-1 col-md-3 col-sm-3 col-4 mb-1">
                                <div class="stat-item">
                                    <div class="media">
                                        <div class="avatar bg-light-warning mr-1">
                                            <div class="avatar-content">
                                                <i class="fas fa-money-bill-wave"></i>
                                            </div>
                                        </div>
                                        <div class="media-body my-auto mr-1">
                                            <span class="font-weight-bolder mb-0 salary_status_record_lbl" id="salary_pending_record_lbl"></span>
                                            <p class="card-text font-small-3 mb-0">Pending</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-1 col-lg-1 col-md-3 col-sm-3 col-4 mb-1">
                                <div class="stat-item">
                                    <div class="media">
                                        <div class="avatar bg-light-primary mr-1">
                                            <div class="avatar-content">
                                                <i class="fas fa-money-bill-wave"></i>
                                            </div>
                                        </div>
                                        <div class="media-body my-auto mr-1">
                                            <span class="font-weight-bolder mb-0 salary_status_record_lbl" id="salary_verified_record_lbl"></span>
                                            <p class="card-text font-small-3 mb-0">Verified</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-1 col-lg-1 col-md-3 col-sm-3 col-4 mb-1">
                                <div class="stat-item">
                                    <div class="media">
                                        <div class="avatar bg-light-success mr-1">
                                            <div class="avatar-content">
                                                <i class="fas fa-money-bill-wave"></i>
                                            </div>
                                        </div>
                                        <div class="media-body my-auto mr-1">
                                            <span class="font-weight-bolder mb-0 salary_status_record_lbl" id="salary_approved_record_lbl"></span>
                                            <p class="card-text font-small-3 mb-0">Approved</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-1 col-lg-1 col-md-3 col-sm-3 col-4 mb-1">
                                <div class="stat-item">
                                    <div class="media">
                                        <div class="avatar bg-light-primary mr-1">
                                            <div class="avatar-content">
                                                <i class="fas fa-money-bill-wave"></i>
                                            </div>
                                        </div>
                                        <div class="media-body my-auto mr-1">
                                            <span class="font-weight-bolder mb-0 salary_status_record_lbl" id="salary_closed_record_lbl"></span>
                                            <p class="card-text font-small-3 mb-0">Closed</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-1 col-lg-1 col-md-3 col-sm-3 col-4 mb-1">
                                <div class="stat-item">
                                    <div class="media">
                                        <div class="avatar bg-light-danger mr-1">
                                            <div class="avatar-content">
                                                <i class="fas fa-money-bill-wave"></i>
                                            </div>
                                        </div>
                                        <div class="media-body my-auto mr-1">
                                            <span class="font-weight-bolder mb-0 salary_status_record_lbl" id="salary_void_record_lbl"></span>
                                            <p class="card-text font-small-3 mb-0">Void</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-1 col-lg-1 col-md-3 col-sm-3 col-4 mb-1">
                                <div class="stat-item">
                                    <div class="media">
                                        <div class="avatar bg-light-secondary mr-1">
                                            <div class="avatar-content">
                                                <i class="fas fa-money-bill-wave"></i>
                                            </div>
                                        </div>
                                        <div class="media-body my-auto mr-1">
                                            <span class="font-weight-bolder mb-0 salary_status_record_lbl" id="salary_total_record_lbl"></span>
                                            <p class="card-text font-small-3 mb-0">Total</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>   

                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 table-responsive" id="payroll-dt-div">
                                <table id="salary-datatable" class="display table-bordered table-striped table-hover defaultdatatable mb-0" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th style="display: none;"></th>
                                            <th style="width:3%;">#</th>
                                            <th style="width:15%;">Reference No.</th>
                                            <th style="width:15%;">Is Negotiable</th>
                                            <th style="width:15%;">Salary</th>
                                            <th style="width:15%;">Letter Date</th>
                                            <th style="width:18%;">Letter Doc.</th>
                                            <th style="width:15%;">Status</th>
                                            <th style="width:4%;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table table-sm"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="payrollEmpId" name="payrollEmpId" class="form-control" readonly="true">
                        <button id="closebuttonpayrollsett" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!--End payroll setting modal -->

    <!-- start salary info modal-->
    <div class="modal modal-slide-in event-sidebar fade fit-modal" id="salaryinfomodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y:scroll;">
        <form id="SalaryInfoForm">    
            <div class="modal-dialog sidebar-xl side_slide_modal" style="width:93%;">
                <div class="modal-content p-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #ea5455 !important;font-weight:bold;">x</button>
                    <div class="modal-header mb-1">
                        <h4 class="modal-title form_title">Salary Information</h4>
                        <div class="form_title" style="text-align: center;padding-right:30px;" id="salaryinfostatuslbl"></div>
                    </div>
                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <section id="collapsible">
                                    <div class="card collapse-icon">
                                        <div class="collapse-default">
                                            <div class="card">
                                                <div id="headingCollapse4" class="card-header" data-toggle="collapse" role="button" data-target=".infosalary" aria-expanded="false" aria-controls="collapse4">
                                                    <span class="lead collapse-title form_title">Basic Information</span>
                                                    <div id="info_status_lbl" style="font-weight: bold;font-size:15px;"></div>
                                                </div>
                                                <div id="collapse4" role="tabpanel" aria-labelledby="headingCollapse4" class="collapse infosalary">
                                                    <div class="row ml-1 mb-1 mr-1">
                                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                            <table class="infotbl" style="width: 100%;font-size:12px;">
                                                                <tr>
                                                                    <td><label class="info_lbl">Employee Name</label></td>
                                                                    <td><label class="info_lbl sl_emp_name" id="salary_emp_name" style="font-weight:bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl">Is Negotiable</label></td>
                                                                    <td><label class="info_lbl" id="info_isneg_lbl" style="font-weight:bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl">Salary</label></td>
                                                                    <td><label class="info_lbl" id="info_salary_lbl" style="font-weight:bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl">Letter Date</label></td>
                                                                    <td><label class="info_lbl" id="info_letterdate_lbl" style="font-weight:bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl">Letter Doc.</label></td>
                                                                    <td><label class="info_lbl" id="info_letterdoc_lbl" style="font-weight:bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl">Remark</label></td>
                                                                    <td><label class="info_lbl" id="info_remark_lbl" style="font-weight:bold;"></label></td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12" style="border-left: 1px solid #D3D3D3;display:none;">
                                                            <label id="salaryinfoactiontitle" style="font-size: 15px;font-weight:bold;">Action Information</label>
                                                            <div class=" col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 scrdivhor scrollhor" style="overflow-y: scroll;height:13rem;">
                                                                <ul id="salaryactiondiv" class="timeline mb-0 mt-0"></ul>
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
                        <hr class="m-0"/>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">                                                           
                                <div class="row" id="salarydetaildiv">
                                    <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 mt-1">
                                        <table id="salaryinfotbl" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable mb-0" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th colspan="6" style="font-size: 14px;text-align:center;">Earnings</th>
                                                </tr>
                                                <tr>
                                                    <th style="width:3%;font-size: 12px;">#</th>
                                                    <th style="width:32%;font-size: 12px;">Salary Component Name</th>
                                                    <th style="width:15%;font-size: 12px;">Taxable</th>
                                                    <th style="width:15%;font-size: 12px;">Non-Taxable</th>
                                                    <th style="width:15%;font-size: 12px;">Total</th>
                                                    <th style="width:20%;font-size: 12px;">Remark</th>
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
                                    <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 mt-1">
                                        <table id="salarydedinfotbl" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable mb-0" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th colspan="4" style="font-size: 14px;text-align:center;">Deductions</th>
                                                </tr>
                                                <tr>
                                                    <th style="width:3%;font-size: 12px;">#</th>
                                                    <th style="width:33%;font-size: 12px;">Salary Component Name</th>
                                                    <th style="width:32%;font-size: 12px;">Amount</th>
                                                    <th style="width:32%;font-size: 12px;">Remark</th>
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
                                    <div class="col-xl-4 col-lg-3 col-md-0 col-sm-0 col-0 mt-1"></div>
                                    <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12 mt-1">
                                        <table id="infoSummaryTable" class="rtable infotbl" style="width:100%;text-align: center">
                                            <thead>
                                                <tr>
                                                    <th colspan="2" style="text-align: center">Summary</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td style="width: 50%" id="infosummcompanypensionLbl"><label class="info_lbl">Company Pension</label></td>
                                                    <td style="width: 50%" id="infocompensiondiv">
                                                        <div class="input-group">
                                                            <label id="infosummcompanypension" class="summfig info_lbl" style="font-weight:bold;width:95%;position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);"></label>
                                                            <i id="companypensioninfobtn" class="fas fa-info-circle" style="width:5%;position: absolute;top: 50%;left: 95%;transform: translate(-50%, -50%);"></i>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" style="text-align: center">-</td>
                                                </tr>
                                                <tr>
                                                    <td><label class="info_lbl">Taxable Earning</label></td>
                                                    <td><label id="infosummtaxableearning" class="summfig info_lbl" style="font-weight:bold"></label></td>
                                                </tr>
                                                <tr>
                                                    <td><label class="info_lbl">Non-Taxable Earning</label></td>
                                                    <td><label id="infosummnontaxableearning" class="summfig info_lbl" style="font-weight:bold"></label></td>
                                                </tr>
                                                <tr>
                                                    <td><label class="info_lbl">Total Earning</label></td>
                                                    <td><label id="infosummtotalearning" class="summfig info_lbl" style="font-weight:bold"></label></td>
                                                </tr>
                                                <tr>
                                                    <td><label class="info_lbl">Total Deduction</label></td>
                                                    <td><label id="infosummtotaldeduction" class="summfig info_lbl" style="font-weight:bold"></label></td>
                                                </tr>
                                                <tr>
                                                    <td><label class="info_lbl">Net Pay</label></td>
                                                    <td id="infonetpaydiv">
                                                        <div class="input-group">
                                                            <label id="infosummnetpay" class="summfig info_lbl" style="font-weight:bold;width:95%;position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);"></label>
                                                            <i id="infonetpayinfo" class="fas fa-info-circle" style="width:5%;position: absolute;top: 50%;left: 95%;transform: translate(-50%, -50%);"></i>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-xl-4 col-lg-3 col-md-0 col-sm-0 col-0 mt-1"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align:left">
                                    <div class="btn-group dropup">
                                        <button type="button" class="btn btn-outline-info dropdown-toggle hide-arrow action-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa-sharp fa-solid fa-caret-up fa-xl"></i><span class="btn-text">&nbsp Actions</span>
                                        </button>
                                        <ul class="dropdown-menu" id="salary_action_ul"></ul>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align:right">
                                    <input type="hidden" class="form-control" name="infoRecId" id="infoRecId" readonly="true">
                                    <input type="hidden" class="form-control" name="currentStatus" id="currentStatus" readonly="true">
                                    <input type="hidden" class="form-control" name="forwardReqId" id="forwardReqId" readonly="true">
                                    <input type="hidden" class="form-control" name="newForwardStatusValue" id="newForwardStatusValue" readonly="true">
                                    <input type="hidden" class="form-control" name="forwarkBtnTextValue" id="forwarkBtnTextValue" readonly="true">
                                    <input type="hidden" class="form-control" name="forwardActionValue" id="forwardActionValue" readonly="true">
                                    <button id="closebuttonsalaryinfo" type="button" class="btn btn-danger" data-dismiss="modal">Close</button> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!--/ end salary info modal-->

    <!-- start salary setting form modal-->
    <div class="modal modal-slide-in event-sidebar fade fit-content" id="salarysettingmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y:scroll;">
        <form id="SalarySettingForm">    
            <div class="modal-dialog sidebar-xl side_slide_modal" style="width: 93%;">
                <div class="modal-content p-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #ea5455 !important;font-weight:bold;">x</button>
                    <div class="modal-header mb-1">
                        <h4 class="modal-title form_title" id="salary_sett_title"></h4>
                        <div class="form_title" style="text-align: center;padding-right:30px;" id="salary_setting_status"></div>
                    </div>
                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                        <div class="row">
                            <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12 mb-1">
                                <label class="form_lbl">Is Negotiable<b style="color: red; font-size:16px;">*</b></label>
                                <select class="select2 form-control" name="UseCustomizedSalary" id="UseCustomizedSalary" onchange="customizeSalaryFn()">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                                <span class="text-danger">
                                    <strong class="errordatalabel" id="customizesalary-error"></strong>
                                </span>
                            </div>
                            <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12 mb-1" id="salarycontainer">
                                <label class="form_lbl">Salary<b style="color: red; font-size:16px;">*</b></label>
                                <select class="select2 form-control" name="Salary" id="Salary">
                                    @foreach ($salary as $salary)
                                        <option value="{{$salary->id}}">{{$salary->SalaryName}}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger">
                                    <strong class="errordatalabel" id="salary-error"></strong>
                                </span>
                            </div>
                            <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12 mb-1">
                                <label class="form_lbl">Letter Date<b style="color:red;">*</b></label>
                                <input type="text" id="letter_date" name="letter_date" class="form-control emp_reg_form" placeholder="YYYY-MM-DD" readonly onchange="salaryLettDateFn()"/>
                                <span class="text-danger">
                                    <strong class="errordatalabel" id="letterdate-error"></strong>
                                </span>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-1">
                                <label class="form_lbl" title="Letter Document">Letter Doc.</label>
                                <div class="input-group">
                                    <input class="form-control fileuploads emp_reg_form" type="file" id="salary_letter_file" name="salary_letter_file" onchange="showSalaryLetterFn()" accept=".jpg, .jpeg, .png,.pdf" style="width:80%;">
                                    <button type="button" id="preview_salary_lett_file" class="btn btn-light btn-sm salary_letter_prop_btn" onclick="prvSalaryLetterFn()" style="color:#00cfe8;background-color:#FFFFFF;border-color:#FFFFFF;padding: 1px 1px;width:9%;display:none;" title="Open uploaded document"><i class="fas fa-eye fa-lg" aria-hidden="true"></i></button>
                                    <button type="button" id="salary_letter_rem_btn" name="salary_letter_rem_btn" class="btn btn-light btn-sm salary_letter_prop_btn" onclick="salaryLetterBtnDocFn()" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF;padding: 1px 1px;width:9%;display:none;" title="Remove uploaded document"><i class="fas fa-times fa-lg" aria-hidden="true"></i></button>
                                </div>
                                <span class="text-danger">
                                    <strong class="errordatalabel" id="salary-letter-error"></strong>
                                    <input type="hidden" class="form-control emp_reg_form" name="salary_letter_filename" id="salary_letter_filename"/>
                                    <input type="hidden" class="form-control emp_reg_form" name="salary_letter_actual_fn" id="salary_letter_actual_fn"/>
                                </span>                                                   
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-1">
                                <label class="form_lbl">Remark</label>
                                <textarea type="text" placeholder="Write remark here..." class="form-control emp_reg_form" rows="1" name="salary_remark" id="salary_remark" onkeyup="salaryLettRemarkFn()"></textarea>
                                <span class="text-danger">
                                    <strong class="errordatalabel" id="salary-remark-error"></strong>
                                </span>
                            </div>
                        </div>
                        <hr class="m-1"/>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="row" id="salarydynamictable" style="display: none;">
                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-1 table-responsive">
                                        <table id="earningDynamicTable" class="rtable slide_modal_lbl" style="width:100%;min-width:350px;">
                                            <thead>
                                                <tr>
                                                    <th colspan="7" style="text-align:center;">Earnings</th>
                                                </tr>
                                                <tr>
                                                    <th style="width:3%;">#</th>
                                                    <th style="width:25%;">Salary Component Name</th>
                                                    <th style="width:16%;">Taxable</th>
                                                    <th style="width:16%;">Non-Taxable</th>
                                                    <th style="width:16%;">Total</th>
                                                    <th style="width:17%;">Remark</th>
                                                    <th style="width:5%;"></th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="2" style="background-color: #FFFFFF;border:none;padding:0px;">
                                                        <button type="button" name="addearningbtn" id="addearningbtn" class="btn btn-success btn-sm" style="float:left;"><i class="fa fa-plus" aria-hidden="true"></i>  Add New</button>
                                                        <label style="text-align:right;float:right;">Total</label>
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
                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-1 table-responsive">
                                        <table id="deductionDynamicTable" class="rtable slide_modal_lbl" style="width:100%;min-width:350px;">
                                            <thead>
                                                <tr>
                                                    <th colspan="5" style="text-align:center;">Deductions</th>
                                                </tr>
                                                <tr>
                                                    <th style="width:3%;">#</th>
                                                    <th style="width:31%;">Salary Component Name</th>
                                                    <th style="width:30%;">Amount</th>
                                                    <th style="width:31%;">Remark</th>
                                                    <th style="width:5%;"></th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="2" style="background-color: #FFFFFF;border:none;padding:0px;">
                                                        <button type="button" name="adddeductionbtn" id="adddeductionbtn" class="btn btn-success btn-sm" style="float:left;"><i class="fa fa-plus" aria-hidden="true"></i>  Add New</button>
                                                        <label style="text-align:right;float:right;">Total</label>
                                                    </th>
                                                    <th style="text-align: left;">
                                                        <label id="totaldeduction" style="font-weight:bold"></label>
                                                    </th>
                                                    <th colspan="2"></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <div class="col-xl-4 col-lg-3 col-md-1 col-sm-0 col-0"></div>
                                    <div class="col-xl-4 col-lg-6 col-md-10 col-sm-12 col-12 table-responsive">
                                        <table id="summaryTable" class="rtable slide_modal_lbl" style="width:100%;text-align: center">
                                            <thead>
                                                <tr>
                                                    <th colspan="2" style="text-align: center">Summary</th>
                                                </tr>
                                            </thead>
                                            <tbody>
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
                                    <div class="col-xl-4 col-lg-3 col-md-1 col-sm-0 col-0"></div>
                                </div>
                            </div>

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
                            <input type="hidden" class="form-control" name="EmployeePension" id="EmployeePension" readonly/>
                            <input type="hidden" class="form-control" name="CompanyPension" id="CompanyPension" readonly/>
                            <input type="hidden" class="form-control" name="MinimumPensionAmount" id="MinimumPensionAmount" value="0"/>
                            <input type="hidden" id="salaryInpId" name="salaryInpId" class="form-control" readonly="true">
                            <input type="hidden" id="payrollSalaryId" name="payrollSalaryId" class="form-control" readonly="true">
                            <input type="hidden" id="salaryOperationType" name="salaryOperationType" class="form-control" readonly="true">
                            <input type="hidden" id="sal_employee_id" name="sal_employee_id" class="form-control" readonly="true">
                        </div>
                        <button id="savebuttonpayrollsett" type="submit" class="btn btn-info">Save</button>
                        <button id="closebuttonsalarysett" type="button" class="btn btn-danger" data-dismiss="modal">Close</button> 
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!--/ end salary setting form modal-->

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
                            <textarea type="text" placeholder="Write Reason here..." class="form-control" rows="3" name="CommentOrReason" id="CommentOrReason" onkeyup="salReasonFn()"></textarea>
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

    <!--Start void modal -->
    <div class="modal fade text-left" id="salvoidmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="salvoidform">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group" style="display: none;">
                            <label class="form_lbl" style="font-weight:bold;">Do you really want to void this record?</label>
                        </div>
                        <div class="divider" style="display: none;">
                            <div class="divider-text form_lbl">Reason</div>
                        </div>
                        <label class="form_lbl">Reason</label>
                        <textarea type="text" placeholder="Write Reason here..." class="form-control SalaryVoidReason emp_reg_form" rows="3" name="SalaryVoidReason" id="SalaryVoidReason" onkeyup="salVoidReason()"></textarea>
                        <span class="text-danger">
                            <strong class="errordatalabel" id="salary-void-error"></strong>
                        </span>
                        
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control" name="salVoidId" id="salVoidId" readonly="true">
                        <button id="salvoidbtn" type="button" class="btn btn-info">Void</button>
                        <button id="closebuttonsal" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End void modal -->

    @include('layout.universal-component')

    <script type="text/javascript">
        var errorcolor = "#ffcccc";
        var currdate = $('#currentdateval').val();

        $(function () {
            cardSection = $('#page-block');
        });

        var j = 0;
        var i = 0;
        var m = 0;
        var anualleaveid = 1;
        var ctable = "";

        var j = 0;
        var i = 0;
        var m = 0;

        var je = 1;
        var ie = 1;
        var me = 1;

        var jd = 2;
        var id = 2;
        var md = 2;

        var x = 0;
        var y = 0;
        var z = 0;

        var x1 = 0;
        var y1 = 0;
        var z1 = 0;

        var x2 = 0;
        var y2 = 0;
        var z2 = 0;

        var x3 = 0;
        var y3 = 0;
        var z3 = 0;

        var taxRanges = [];

        var globalIndex = -1;

        var statusTransitions = {
            'Draft': {
                forward: {
                    status: 'Pending',
                    text: 'Change to Pending',
                    action: 'Change to Pending',
                    message: 'Are you sure you want to change the status of this record to Pending?',
                    forecolor: '#6e6b7b',
                    backcolor: '#f6c23e'
                }
            },
            'Pending': {
                forward: {
                    status: 'Verified',
                    text: 'Verify',
                    action: 'Verified',
                    message: 'Are you sure you want to change the status of this record to Verified?',
                    forecolor: '#6e6b7b',
                    backcolor: '#f6c23e'
                },
                backward: {
                    status: 'Draft',
                    text: 'Back to Draft',
                    action: 'Back to Draft',
                    message: 'Reason'
                }
            },
            'Verified': {
                forward: {
                    status: 'Approved',
                    text: 'Approve',
                    action: 'Approved',
                    message: 'Are you sure you want to change the status of this record to Approved?',
                    forecolor: '#FFFFFF',
                    backcolor: '#28c76f'
                },
                backward: {
                    status: 'Pending',
                    text: 'Back to Pending',
                    action: 'Back to Pending',
                    message: 'Reason'
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
                    message: 'Reason'
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
                    message: 'Are you sure you want to change the status of this record to Approved?',
                    forecolor: '#FFFFFF',
                    backcolor: '#28c76f'
                }
            },
        };

        $(document).ready( function () {
            $('#HiredDate').daterangepicker({ 
                singleDatePicker: true,
                showDropdowns: true,
                autoApply:true,
                maxDate:currdate,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });

            $('#Dob').daterangepicker({ 
                singleDatePicker: true,
                showDropdowns: true,
                autoApply:true,
                maxDate:currdate,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });
            
            $('#SignDate').daterangepicker({ 
                singleDatePicker: true,
                showDropdowns: true,
                autoApply:true,
                maxDate:currdate,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });

            $('#emp_tbl').hide();

            ctable = $('#laravel-datatable-crud').DataTable({
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
                dom: "<'row'<'col-sm-3 col-md-2 col-4 pr-0 mr-0'f><'col-sm-4 col-md-2 col-4 mt-1 pr-0 mr-0 custom-1'><'col-sm-4 col-md-2 col-4 mt-1 custom-2'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-4 col-md-4 col-4'l><'col-sm-4 col-md-4 col-4 d-flex justify-content-center'i><'col-sm-4 col-md-4 col-4 d-flex justify-content-end'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/emplist',
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
                    { data: 'DT_RowIndex',width:'3%'},
                    { data: 'ActualPicture', 'data-title': "Photo",
                        "render": function( data, type, row, meta) {
                            if(data != null || row.BiometricPicture != null){
                                return data != null ? 
                                `<img id="dtEmployeePreview${row.id}" alt="Employee Photo" class="employee-photo-preview-dt employee_img_cls" src="../../../storage/uploads/HrEmployee/${data}">`
                                :`<img id="dtEmployeePreview${row.id}" alt="Employee Photo" class="employee-photo-preview-dt employee_img_cls" src="../../../storage/uploads/HrEmployee/${row.BiometricPicture}">`;
                            } 
                            if(data == null && row.BiometricPicture == null){
                                if(row.Gender == "Male"){
                                    return `<img id="dtEmployeePreview${row.id}" alt="Employee Photo" class="employee-photo-preview-dt employee_img_cls" src="../../../storage/uploads/HrEmployee/dummypic.jpg">`;
                                }
                                if(row.Gender == "Female"){
                                    return `<img id="dtEmployeePreview${row.id}" alt="Employee Photo" class="employee-photo-preview-dt employee_img_cls" src="../../../storage/uploads/HrEmployee/dummypic.jpg">`;
                                }   
                            }
                        },
                        width:'5%'
                    },
                    { data: 'name', 
                        "render": function( data, type, row, meta) {
                            return `${row.EmployeeID}, </br>${row.emp_title} ${data}`;
                        },
                        width:'20%'
                    },
                    { data: 'MobileNumber', 
                        "render": function( data, type, row, meta) {
                            var primary_phone = data.replace("","");
                            var optional_phone = row.OfficePhoneNumber == null || row.OfficePhoneNumber == "" ? "" : row.OfficePhoneNumber.replace("","");
                            return `${primary_phone}, </br>${optional_phone}`;
                        },
                        width:'12%'
                    },
                    { data: 'Gender', name: 'Gender', width:'7%'},
                    { data: 'BranchName', name: 'BranchName',width:'10%'},
                    { data: 'DepartmentName', name: 'DepartmentName',width:'11%'},
                    { data: 'PositionName', name: 'PositionName',width:'11%'},
                    { data: 'EmploymentTypeName', name: 'EmploymentTypeName',width:'10%'},
                    { data: 'Status', name: 'Status',
                        "render": function ( data, type, row, meta ) {
                            if(data == "Active"){
                                return `<span class="badge bg-success bg-glow">${data}</span>`;
                            }
                            else if(data == "Resign"){
                                return `<span class="badge bg-secondary bg-glow">${data}</span>`;
                            }
                            else{
                                return `<span class="badge bg-danger bg-glow">${data}</span>`;
                            }
                        },
                        width:'7%'
                    },
                    { data: 'action', name: 'action',
                        "render": function ( data, type, row, meta ) {
                            return `<div class="text-center"><a class="empInfo" href="javascript:void(0)" onclick="empInfoFn(${row.id})" data-id="emp_id${row.id}" id="emp_id${row.id}" title="Open employee information page"><i class="fa-sharp fa-regular fa-circle-info fa-xl" style="color: #00cfe8;"></i></a></div>`;
                        },
                        width:'4%'
                    }
                ],
                drawCallback: function () { 
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
                    $('#emp_tbl').show();
                },
                fixedHeader: {
                    header: true,
                    headerOffset: $('.header-navbar').outerHeight(),
                },
            });

            getRangeData();
            hierarchyFn();
            hrSettingFn();
            countEmployeeStatusFn();

            var branch_selectpicker = $(`
                <select class="selectpicker form-control dropdownclass" id="BranchFilter" name="BranchFilter" title="Select Branch here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" multiple="multiple" data-actions-box="true">
                    @foreach ($branchfilter as $branchfilter)
                        <option selected value="{{$branchfilter->BranchName}}">{{$branchfilter->BranchName}}</option>
                    @endforeach
                </select>
            `);

            var department_selectpicker = $(`
                <select class="selectpicker form-control dropdownclass" id="DepartmentFilter" name="DepartmentFilter" title="Select Department here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" multiple="multiple" data-actions-box="true">
                    @foreach ($departmentfilter as $departmentfilter)
                        <option selected value="{{$departmentfilter->DepartmentName}}">{{$departmentfilter->DepartmentName}}</option>
                    @endforeach
                </select>
            `);

            $('.custom-1').empty().append(branch_selectpicker);
            $('.custom-2').empty().append(department_selectpicker);

            if ($.fn.selectpicker) {
                branch_selectpicker.selectpicker();
                department_selectpicker.selectpicker();
            }

            branch_selectpicker.on('change', function() {
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

            department_selectpicker.on('change', function() {
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
        });

        $('#TableView-tab').on('shown.bs.tab', function () {
            $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
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

        function hrSettingFn(){
            $.ajax({ 
                url: '/getHrSetting',
                type: 'POST',
                dataType: 'json',
                success: function(data) {
                    $.each(data.settings, function(module_name, value) {
                        const main_module = $(`.mod[data-mod="${module_name}"]`);
                        const ass_module = $(`.ass-mod[data-assmod="${module_name}"]`);
                        const ass_view = $(`.ass-view[id="${module_name}-view"]`);
                        const rep_view = $(`.rep-acc[data-report-access="${module_name}"]`);
                        if (value.enabled === true) {
                            main_module.show();
                            ass_module.show();
                            ass_view.show();
                            rep_view.show();
                        } else {
                            main_module.hide();
                            ass_module.hide();
                            ass_view.hide();
                            rep_view.hide();
                        }  
                    });
                }
            });
        }

        function hierarchyFn(){
            var alldepdata=[];
            var alldep=[];
            var alldepd=[];
            var empname="";
            var pids="";
            var myObject="";
            var pic="";
            var empId="";
            var statuscolor = "";
            $.get("/showemployeelist", function(data) {
                google.charts.load('current', {packages:["orgchart"]});
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {
                    var chdata = new google.visualization.DataTable();
                    chdata.addColumn('string', 'Name');
                    chdata.addColumn('string', 'Manager');
                    chdata.addColumn('string', 'ToolTip');

                    $.each(data.list, function(key, value) {

                        if(value.ActualPicture != null || value.BiometricPicture != null){
                            pic =  value.ActualPicture != null ? '../../../storage/uploads/HrEmployee/'+value.ActualPicture
                            : './../../storage/uploads/BioEmployee/'+value.BiometricPicture;
                        } 
                        if(value.ActualPicture == null && value.BiometricPicture == null){
                            pic = value.Gender == "Male" ? '../../../storage/uploads/HrEmployee/dummypic.jpg' : '../../../storage/uploads/HrEmployee/dummypic.jpg';
                        }

                        statuscolor = value.Status == "Active" ? "#28c76f" : "#ea5455";

                        empname = value.id ==1 ? "Root" : value.name;
                        pids = value.employees_id==1 ? '' : String(value.employees_id);
                        empId = String(value.id); // Ensure it's a string

                        var rowdata = `<div style="
                                            width: 140px;
                                            height: 150px;
                                            font-family: 'Montserrat', sans-serif;
                                            text-align: center;
                                            padding: 10px;
                                            border-radius: 10px;
                                            background: #fcfcff; 
                                            border: 2px solid #00cfe8;
                                            color: #333;
                                            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
                                            display: flex;
                                            flex-direction: column;
                                            align-items: center;
                                            position: relative;
                                            box-sizing: border-box;
                                            overflow: visible;">
                                            <div class="btn-group" title="Action" style="
                                                position: absolute;
                                                top: 2px;
                                                right: 2px;
                                                background: transparent;
                                                border: none;
                                                font-size: 16px;
                                                color: #00cfe8;
                                                cursor: pointer;
                                                z-index: 1;">
                                                <a class="empInfo" href="javascript:void(0)" onclick="empInfoFn(${value.id})" data-id="emp_id_tree${value.id}" id="emp_id_tree${value.id}" title="Open employee information page"><i class="fa-sharp fa-regular fa-circle-info fa-xl" style="color: #00cfe8;"></i></a>
                                                
                                            </div>

                                            <img src="${pic}" style="
                                                width: 55px;
                                                height: 55px;
                                                border-radius: 50%;
                                                object-fit: cover;"> 
                                            <strong class="errordatalabel" style="font-size:11px;">${empname}</strong>
                                            <span style="font-size:10px;">${value.PositionName}</span>
                                        </div>`;

                        chdata.addRow([
                            {v: empId, f: rowdata},pids,''
                        ]);
                    });

                    var chart = new google.visualization.OrgChart(document.getElementById('emp_tree'));
                    chart.draw(chdata, {allowHtml:true});
                }  
            });            
        }

        async function downloadPDF() {
            const chartElement = document.getElementById('pdfExport');
            const canvas = await html2canvas(chartElement, {
                backgroundColor: null,
                scale: 2
            });
            const imageData = canvas.toDataURL('image/png');
            const { jsPDF } = window.jspdf;
            const pdf = new jsPDF({
                orientation: 'landscape',
                unit: 'px',
                format: [canvas.width, canvas.height]
            });
            pdf.addImage(imageData, 'PNG', 0, 0, canvas.width, canvas.height);
            pdf.save('employee_structure.pdf');
        }

        $('body').on('click', '#addemployees', function() {
            resetForm();
            $("#inlineForm").modal('show');
        });

        function tabMgtFn(){
            $(".tab-title").removeClass("active");
            $(".tab-view").removeClass("active");
            
            $(".active-tab-title").addClass("active");
            $(".active-tab-view").addClass("active");
        }

        function salarytypefn(){
            $.get("/salarytypelistdata" , function(data) {
                $.each(data.salarylists, function(key, value) {
                    ++m;
                    if(parseInt(m)<=9){
                        m="0"+m;
                    }
                    $("#dynamicTable > tbody").append('<tr id="rowind'+m+'"><td style="font-weight:bold;width:3%;text-align:center;">'+m+'</td>'+
                        '<td style="display:none;"><input type="hidden" name="rowsal['+m+'][vals]" id="vals'+m+'" class="vals form-control" readonly="true" style="font-weight:bold;" value="'+m+'"/></td>'+
                        '<td style="width:14%;"><input type="text" name="rowsal['+m+'][SalaryTypeName]" id="SalaryTypeName'+m+'" class="SalaryTypeName form-control" readonly value="'+value.SalaryTypeName+'"/></td>'+
                        '<td style="width:16%;"><input type="text" name="rowsal['+m+'][SalaryTypeDescription]" id="SalaryTypeDescription'+m+'" class="SalaryTypeDescription form-control" readonly value="'+value.Descriptions+'" placeholder="Leave type descrioption"/></td>'+
                        '<td style="width:13%;"><input type="text" name="rowsal['+m+'][SalaryType]" id="SalaryType'+m+'" class="SalaryType form-control" readonly value="'+value.SalaryType+'"/></td>'+
                        '<td style="width:14%;"><input type="text" name="rowsal['+m+'][EarningAmount]" id="EarningAmount'+m+'" class="EarningAmount form-control" onkeypress="return ValidateNum(event);" onkeyup="earningamntFn(this)" readonly placeholder="Earning Amount"/></td>'+
                        '<td style="width:14%;"><input type="text" name="rowsal['+m+'][DeductionAmount]" id="DeductionAmount'+m+'" class="DeductionAmount form-control" onkeypress="return ValidateNum(event);" onkeyup="deductionamntFn(this)" readonly placeholder="Deduction Amount"/></td>'+
                        '<td style="width:16%;"><input type="text" name="rowsal['+m+'][Remark]" id="Remark'+m+'" class="Remark form-control" placeholder="Write remark here..."/></td>'+
                        '<td style="width:10%;"><select id="Status'+m+'" class="select2 form-control form-control Status" name="rowsal['+m+'][Status]" onchange="statusvalfn(this)"></select></td>'+
                        '<td style="display:none;"><input type="hidden" name="rowsal['+m+'][salarytype_id]" id="salarytype_id'+m+'" class="salarytype_id form-control" readonly="true" style="font-weight:bold;" value="'+value.id+'"/></td></tr>'
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

        $('#Register').submit(function(e) {
            e.preventDefault();
            var fname = "";
            let formData = new FormData(this);
            var optype = $("#operationtypes").val();
            var recordId = $("#recId").val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ url('saveHrEmployee') }}",
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
                    if(parseFloat(optype) == 1){
                        $('#savebutton').text('Saving...');
                        $('#savebutton').prop("disabled", true);
                    }
                    else if(parseFloat(optype) == 2){
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
                        if (data.errors.name) {
                            $('#firstname-error').html(data.errors.name[0]);
                            $('#middlename-error').html(data.errors.name[0]);
                            $('#lastname-error').html(data.errors.name[0]);
                        }
                        if (data.errors.title) {
                            $('#title-error').html(data.errors.title[0]);
                        }
                        if (data.errors.FirstName) {
                            $('#firstname-error').html(data.errors.FirstName[0]);
                        }
                        if (data.errors.MiddleName) {
                            $('#middlename-error').html(data.errors.MiddleName[0]);
                        }
                        if (data.errors.LastName) {
                            $('#lastname-error').html(data.errors.LastName[0]);
                        }
                        if (data.errors.gender) {
                            $('#gender-error').html(data.errors.gender[0]);
                        }
                        if (data.errors.Dob) {
                            var text = data.errors.Dob[0];
                            text = text.replace("dob", "date of birth");
                            $('#dob-error').html(text);
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
                        if (data.errors.Shift) {
                            $('#shift-error').html(data.errors.Shift[0]);
                        }
                        if (data.errors.status) {
                            $('#status-error').html(data.errors.status[0]);
                        }
                        //----others validation------
                        if (data.errors.nationality) {
                            $('#nationality-error').html(data.errors.nationality[0]);
                            tabMgtMiscFn();
                        }
                        if (data.errors.PassportNumber) {
                            $('#Passport-error').html(data.errors.PassportNumber[0]);
                            tabMgtMiscFn();
                        }
                        if (data.errors.ResidanceIdNumber) {
                            $('#Residenceid-error').html(data.errors.ResidanceIdNumber[0]);
                            tabMgtMiscFn();
                        }
                        if (data.errors.NationalIdNumber) {
                            $('#nationalid-error').html(data.errors.NationalIdNumber[0]);
                            tabMgtMiscFn();
                        }
                        if (data.errors.DrivingLicenseNumber) {
                            $('#drivinglicence-error').html(data.errors.DrivingLicenseNumber[0]);
                            tabMgtMiscFn();
                        }
                        if (data.errors.Postcode) {
                            $('#postcode-error').html(data.errors.Postcode[0]);
                            tabMgtMiscFn();
                        }
                        if (data.errors.MartialStatus) {
                            $('#martialstatus-error').html(data.errors.MartialStatus[0]);
                            tabMgtMiscFn();
                        }
                        if (data.errors.BloodType) {
                            $('#bloodtype-error').html(data.errors.BloodType[0]);
                            tabMgtMiscFn();
                        }
                        if (data.errors.EmergencyName) {
                            $('#emergencyname-error').html(data.errors.EmergencyName[0]);
                            tabMgtMiscFn();
                        } 
                        if (data.errors.EmergencyPhone) {
                            var text = data.errors.EmergencyPhone[0];
                            text = text.replace("office", "optional");
                            $('#emergencyphone-error').html(text);
                            tabMgtMiscFn();
                        }

                        //-------address validation-------
                        if (data.errors.country) {
                            $('#country-error').html(data.errors.country[0]);
                            tabMgtAddressFn();
                        }
                        if (data.errors.city) {
                            $('#city-error').html(data.errors.city[0]);
                            tabMgtAddressFn();
                        }
                        if (data.errors.subcity) {
                            $('#subcity-error').html(data.errors.subcity[0]);
                            tabMgtAddressFn();
                        }
                        if (data.errors.Woreda) {
                            $('#Woreda-error').html(data.errors.Woreda[0]);
                            tabMgtAddressFn();
                        }
                        if (data.errors.MobileNumber) {
                            var text = data.errors.MobileNumber[0];
                            text = text.replace("office", "optional");
                            $('#Mobilenumber-error').html(text);
                            tabMgtAddressFn();
                        }
                        if (data.errors.OfficePhoneNumber) {
                            var text = data.errors.OfficePhoneNumber[0];
                            text = text.replace("office", "optional");
                            $('#Phonenumber-error').html(text);
                            tabMgtAddressFn();
                        }
                        if (data.errors.Email) {
                            $('#Email-error').html(data.errors.Email[0]);
                            tabMgtAddressFn();
                        }
                        //-------Vertical tab start------
                        
                        //-----Medical tab start--------
                        if (data.errors.medrow) {
                            $('#medical-skill-error').html("You have to add atleast one record");
                            tabMgtMedicalSkillFn();
                        }
                        const medrowErrorsExist = Object.keys(data.errors).some(key => key.startsWith('medrow.'));
                        if (medrowErrorsExist) {
                            $('#medicalDynamicTable > tbody > tr').each(function (index) {
                                let indx = $(this).find('.medvals').val();
                                var med_skill = $(`#med_skill${indx}`).val();
                                var med_level = $(`#med_level${indx}`).val();
                                if(isNaN(parseInt(med_skill)) || parseInt(med_skill) == 0){
                                    $(`#select2-med_skill${indx}-container`).parent().css('background-color',errorcolor);
                                }
                                if(isNaN(parseInt(med_level)) || parseInt(med_level) == 0){
                                    $(`#select2-med_level${indx}-container`).parent().css('background-color',errorcolor);
                                }
                            });
                            tabMgtMedicalSkillFn();
                        }
                        //-----Medical tab end----------

                        //-----Wellness tab start-------
                        if (data.errors.wellrow) {
                            $('#wellness-skill-error').html("You have to add atleast one record");
                            tabMgtWellnessSkillFn();
                        }
                        const wellrowErrorsExist = Object.keys(data.errors).some(key => key.startsWith('wellrow.'));
                        if (wellrowErrorsExist) {
                            $('#wellnessDynamicTable > tbody > tr').each(function (index) {
                                let indx = $(this).find('.wellvals').val();
                                var well_skill = $(`#well_skill${indx}`).val();
                                var well_level = $(`#well_level${indx}`).val();
                                if(isNaN(parseInt(well_skill)) || parseInt(well_skill) == 0){
                                    $(`#select2-well_skill${indx}-container`).parent().css('background-color',errorcolor);
                                }
                                if(isNaN(parseInt(well_level)) || parseInt(well_level) == 0){
                                    $(`#select2-well_level${indx}-container`).parent().css('background-color',errorcolor);
                                }
                            });
                            tabMgtWellnessSkillFn();
                        }
                        //------Wellness tab end-----

                        //------HR tab start------
                        if (data.errors.controw) {
                            $('#cont-doc-error').html("You have to add atleast one record");
                            tabMgtHrContFn();
                        }
                        const controwErrorsExist = Object.keys(data.errors).some(key => key.startsWith('controw.'));
                        if (controwErrorsExist) {
                            $('#contractDynamicTable > tbody > tr').each(function (index) {
                                let indx = $(this).find('.contvals').val();
                                var sign_date = $(`#sign_date${indx}`).val();
                                var expire_date = $(`#expire_date${indx}`).val();
                                var doc_upload = $(`#contract_hidden${indx}`).val();
                                
                                if(sign_date == null || sign_date == ""){
                                    $(`#sign_date${indx}`).css("background", errorcolor);
                                }
                                if(expire_date == null || expire_date == ""){
                                    $(`#expire_date${indx}`).css("background", errorcolor);
                                }
                                if(doc_upload == null || doc_upload == ""){
                                    $(`#cont_document${indx}`).css("background", errorcolor);
                                }
                            });
                            tabMgtHrContFn();
                        }
                        if (data.errors.docrow) {
                            $('#docmnt-doc-error').html("You have to add atleast one record");
                            tabMgtHrDocFn();
                        }
                        const docrowErrorsExist = Object.keys(data.errors).some(key => key.startsWith('docrow.'));
                        if (docrowErrorsExist) {
                            $('#documentDynamicTable > tbody > tr').each(function (index) {
                                let indx = $(this).find('.docvals').val();
                                var document_type = $(`#document_type${indx}`).val();
                                var upload_date = $(`#upload_date${indx}`).val();
                                var doc_upload = $(`#doc_upload_hidden${indx}`).val();
                                if(isNaN(parseInt(document_type)) || parseInt(document_type) == 0){
                                    $(`#select2-document_type${indx}-container`).parent().css('background-color',errorcolor);
                                }
                                if(upload_date == null || upload_date == ""){
                                    $(`#upload_date${indx}`).css("background", errorcolor);
                                }
                                if(doc_upload == null || doc_upload == ""){
                                    $(`#doc_upload${indx}`).css("background", errorcolor);
                                }
                            });
                            tabMgtHrDocFn();
                        }

                        if (data.errors.monthly_work_hour) {
                            $('#monthlyworkhr-error').html(data.errors.monthly_work_hour[0]);
                            tabMgtPayrollFn();
                        } 
                        if (data.errors.PaymentType) {
                            $('#paymenttype-error').html(data.errors.PaymentType[0]);
                            tabMgtPayrollFn();
                        } 
                        if (data.errors.PaymentPeriod) {
                            $('#paymentperiod-error').html(data.errors.PaymentPeriod[0]);
                            tabMgtPayrollFn();
                        }  
                        if (data.errors.Bank) {
                            $('#bankname-error').html(data.errors.Bank[0]);
                            tabMgtPayrollFn();
                        } 
                        if (data.errors.BankAccountNumber) {
                            $('#bankaccnumber-error').html(data.errors.BankAccountNumber[0]);
                            tabMgtPayrollFn();
                        }    
                        if (data.errors.ProvidentFundAccount) {
                            $('#providentfundacc-error').html(data.errors.ProvidentFundAccount[0]);
                            tabMgtPayrollFn();
                        } 
                        if (data.errors.PensionNumber) {
                            $('#pensionnumber-error').html(data.errors.PensionNumber[0]);
                            tabMgtPayrollFn();
                        } 
                        if (data.errors.Tin) {
                            $('#TinNumber-error').html(data.errors.Tin[0]);
                            tabMgtPayrollFn();
                        } 

                        if (data.errors.PIN) {
                            var text=data.errors.PIN[0];
                            text = text.replace("p i n", "personal identification number");
                            $('#pin-error').html(text);
                            tabMgtHrBioFn();
                        }
                        if (data.errors.CardNumber) {
                            $('#cardnum-error').html(data.errors.CardNumber[0]);
                            tabMgtHrBioFn();
                        }
                        if (data.errors.EnrollDevice) {
                            $('#enroll-error').html(data.errors.EnrollDevice[0]);
                            tabMgtHrBioFn();
                        }

                        if (data.errors.GuarantorName) {
                            $('#guarantorname-error').html(data.errors.GuarantorName[0]);
                            tabMgtHrGuarFn();
                        }
                        if (data.errors.GuarantorPhone) {
                            $('#guarantorphone-error').html(data.errors.GuarantorPhone[0]);
                            tabMgtHrGuarFn();
                        }
                        if (data.errors.guarantorFile) {
                            $('#guarantordoc-error').html(data.errors.guarantorFile[0]);
                            tabMgtHrGuarFn();
                        }
                        if (data.errors.GuarantorFileName) {
                            $('#guarantordoc-error').html("The guarantor document field is required.");
                            tabMgtHrGuarFn();
                        }
                        if (data.errors.EnableAttendance) {
                            $('#enableatt-error').html(data.errors.EnableAttendance[0]);
                            tabMgtHrAttFn();
                        }
                        if (data.errors.EnableHoliday) {
                            $('#enableholiday-error').html(data.errors.EnableHoliday[0]);
                            tabMgtHrAttFn();
                        }
                        if (data.errors.SupervisorOrImmedaiteManager) {
                            $('#supervisor-error').html(data.errors.SupervisorOrImmedaiteManager[0]);
                            tabMgtHrBasicFn();
                        }
                        if (data.errors.EmploymentType) {
                            $('#employmenttype-error').html(data.errors.EmploymentType[0]);
                            tabMgtHrBasicFn();
                        }
                        if (data.errors.HiredDate) {
                            $('#hireddate-error').html(data.errors.HiredDate[0]);
                            tabMgtHrBasicFn();
                        }
                        //------HR tab end--------

                        //------General tab start------
                        if (data.errors.AccessStatus) {
                            $('#accstatus-error').html(data.errors.AccessStatus[0]);
                            tabMgtGeneralFn();
                        }
                        if (data.errors.roleid) {
                            var text = data.errors.roleid[0];
                            text = text.replace("roleid field", "role");
                            $('#roledata-error').html(text);
                            tabMgtGeneralRoleFn();
                        }
                        //------General tab end------
                        //-------Vertical tab end-------

                        if(parseFloat(optype) == 1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        if(parseFloat(optype) == 2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }  
                        toastrMessage('error',"Please check your input","Error");
                    }
                    
                    else if(data.errflag){
                        if(parseFloat(optype) == 1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype) == 2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                        toastrMessage('error',"Immedaite Manager and Employee can not be the same","Error");
                    }
                    else if (data.dberrors) {
                        if(parseFloat(optype) == 1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled",false);
                        }
                        else if(parseFloat(optype) == 2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled",false);
                        }
                        toastrMessage('error',"Error found</br>Please contact the administrator","Error");
                    }
                    else if(data.success){
                        if(parseFloat(optype) == 1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype) == 2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                            createInfoFn(recordId);
                        }
                        countEmployeeStatusFn();
                        $.ajax({
                            url: '/getlatestEmp',
                            type: 'POST',
                            data: {
                                fname:$('#fullName').val()||"",
                            },
                            success: function(data) {
                                $.each(data.getlastemp, function(key, value) {
                                    var lastemp = `<option value="${value.id}">${value.name}</option>`;
                                    $('#SupervisorOrImmedaiteManager').append(lastemp);
                                });
                            }
                        });

                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                        hierarchyFn();
                        closeRegisterModal();
                        $("#inlineForm").modal('hide');
                        toastrMessage('success',"Successful","Success");
                    }
                }
            });
        });

        function tabMgtMiscFn(){
            $(".formsidetab").removeClass("active");
            $(".formsideview").removeClass("active");
            $("#misc-tab").addClass("active");
            $("#misc-view").addClass("active");
        }

        function tabMgtAddressFn(){
            $(".formsidetab").removeClass("active");
            $(".formsideview").removeClass("active");
            $("#address-tab").addClass("active");
            $("#adress-view").addClass("active");
        }

        function tabMgtMedicalSkillFn(){
            $(".mod-vertical-tab").removeClass("active");
            $(".verticalviewinfo").removeClass("active");
            $("#medical-tab").addClass("active");
            $("#medical-view").addClass("active");

            $(".medical-entity-tab").removeClass("active");
            $(".medical-entity-view").removeClass("active");
            $("#medical-skill-tab").addClass("active");
            $("#medical-skill-view").addClass("active");
        }

        function tabMgtWellnessSkillFn(){
            $(".mod-vertical-tab").removeClass("active");
            $(".verticalviewinfo").removeClass("active");
            $("#wellness-tab").addClass("active");
            $("#wellness-side-view").addClass("active");

            $(".wellness-entity-tab").removeClass("active");
            $(".wellness-entity-view").removeClass("active");
            $("#wellness-skill-tab").addClass("active");
            $("#wellness-skill-view").addClass("active");
        }

        function tabMgtHrContFn(){
            $(".mod-vertical-tab").removeClass("active");
            $(".verticalviewinfo").removeClass("active");
            $("#hr-tab").addClass("active");
            $("#hr-view").addClass("active");

            $(".hr-tabs").removeClass("active");
            $(".hr-views").removeClass("active");
            $("#hrcont-tab").addClass("active");
            $("#hrcont-view").addClass("active");
        }

        function tabMgtHrDocFn(){
            $(".mod-vertical-tab").removeClass("active");
            $(".verticalviewinfo").removeClass("active");
            $("#hr-tab").addClass("active");
            $("#hr-view").addClass("active");

            $(".hr-tabs").removeClass("active");
            $(".hr-views").removeClass("active");
            $("#hrdoc-tab").addClass("active");
            $("#hrdoc-view").addClass("active");
        }

        function tabMgtHrBioFn(){
            $(".mod-vertical-tab").removeClass("active");
            $(".verticalviewinfo").removeClass("active");
            $("#hr-tab").addClass("active");
            $("#hr-view").addClass("active");

            $(".hr-tabs").removeClass("active");
            $(".hr-views").removeClass("active");
            $("#hrbio-tab").addClass("active");
            $("#hrbio-view").addClass("active");
        }

        function tabMgtPayrollFn(){
            $(".mod-vertical-tab").removeClass("active");
            $(".verticalviewinfo").removeClass("active");
            $("#hr-tab").addClass("active");
            $("#hr-view").addClass("active");

            $(".hr-tabs").removeClass("active");
            $(".hr-views").removeClass("active");
            $("#payroll-tab").addClass("active");
            $("#payroll-view").addClass("active");
        }

        function tabMgtHrGuarFn(){
            $(".mod-vertical-tab").removeClass("active");
            $(".verticalviewinfo").removeClass("active");
            $("#hr-tab").addClass("active");
            $("#hr-view").addClass("active");

            $(".hr-tabs").removeClass("active");
            $(".hr-views").removeClass("active");
            $("#hrguar-tab").addClass("active");
            $("#hrguar-view").addClass("active");
        }

        function tabMgtHrAttFn(){
            $(".mod-vertical-tab").removeClass("active");
            $(".verticalviewinfo").removeClass("active");
            $("#hr-tab").addClass("active");
            $("#hr-view").addClass("active");

            $(".hr-tabs").removeClass("active");
            $(".hr-views").removeClass("active");
            $("#hratt-tab").addClass("active");
            $("#hratt-view").addClass("active");
        }

        function tabMgtHrBasicFn(){
            $(".mod-vertical-tab").removeClass("active");
            $(".verticalviewinfo").removeClass("active");
            $("#hr-tab").addClass("active");
            $("#hr-view").addClass("active");

            $(".hr-tabs").removeClass("active");
            $(".hr-views").removeClass("active");
            $("#hrbasic-tab").addClass("active");
            $("#hrbasic-view").addClass("active");
        }

        function tabMgtGeneralFn(){
            $(".mod-vertical-tab").removeClass("active");
            $(".verticalviewinfo").removeClass("active");
            $("#v-general-tab").addClass("active");
            $("#v-general-view").addClass("active");

            $(".general-entity-tab").removeClass("active");
            $(".general-entity-view").removeClass("active");
            $("#AccessSetting-tab").addClass("active");
            $("#accessSetting").addClass("active");
        }

        function tabMgtGeneralRoleFn(){
            $(".mod-vertical-tab").removeClass("active");
            $(".verticalviewinfo").removeClass("active");
            $("#v-general-tab").addClass("active");
            $("#v-general-view").addClass("active");

            $(".general-entity-tab").removeClass("active");
            $(".general-entity-view").removeClass("active");
            $("#AccessSetting-tab").addClass("active");
            $("#accessSetting").addClass("active");

            $(".general-assign-tab").removeClass("active");
            $(".general-assign-view").removeClass("active");
            $("#v-role-tab").addClass("active");
            $("#role-view").addClass("active");
        }

        $('#savenewbutton').click(function() {
            var optype = $("#operationtypes").val();
            var registerForm = $("#Register");
            var formData = registerForm.serialize();
            var depmame="";
            var lastdep="";
            $.ajax({
                url: '/saveDepartment',
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
                        if (data.errors.DepartmentName) {
                            $('#name-error').html(data.errors.DepartmentName[0]);
                        }
                        if (data.errors.ParentDepartment) {
                            $('#parentdep-error').html(data.errors.ParentDepartment[0]);
                        }
                        if (data.errors.Description) {
                            $('#description-error').html(data.errors.Description[0]);
                        }
                        if (data.errors.status) {
                            $('#status-error').html(data.errors.status[0]);
                        }

                        $('#savenewbutton').text('Save & New');
                        $('#savenewbutton').prop("disabled", false);
                    }
                    else if(data.errflag){
                        $('#savenewbutton').text('Save & New');
                        $('#savenewbutton').prop("disabled", false);
                        toastrMessage('error',"Parent department and Department can't be the same","Error");
                    }
                    else if (data.dberrors) {
                        $('#savenewbutton').text('Save & New');
                        $('#savenewbutton').prop("disabled", false);
                        toastrMessage('error',"Error found</br>"+data.dberrors,"Error");
                    }
                    else if(data.success){
                        $('#savenewbutton').text('Save & New');
                        $('#savenewbutton').prop("disabled", false);
                        toastrMessage('success',"Successful","Success");
                        $.ajax({
                            url: '/getlastdepartment',
                            type: 'POST',
                            data:{
                                depmame:$('#DepartmentName').val()||0,
                            },
                            success: function(data) {
                                $.each(data.getlastdep, function(key, value) {
                                    lastdep='<option value="'+value.id+'">'+value.DepartmentName+'</option>';
                                    $('#ParentDepartment').append(lastdep);
                                });
                            }
                        });
                        hierarchyFn();
                        closeRegisterModal();
                    }
                }
            });
        });

        function retLeaveType(){
            $.get("/leavetypelist" , function(data) {
                $.each(data.leavetypedata, function(key, value) {
                    ++m;
                    $("#leavealloctbl > tbody").append('<tr id="rowind'+m+'"><td style="font-weight:bold;width:3%;text-align:center;">'+m+'</td>'+
                        '<td style="display:none;"><input type="hidden" name="row['+m+'][vals]" id="vals'+m+'" class="vals form-control" readonly="true" style="font-weight:bold;" value="'+m+'"/></td>'+
                        '<td style="width:15%;"><input type="text" name="row['+m+'][LeaveType]" id="LeaveType'+m+'" class="LeaveType form-control" readonly value="'+value.LeaveType+'"/></td>'+
                        '<td style="width:22%;"><input type="text" name="row['+m+'][LeaveDescription]" id="LeaveDescription'+m+'" class="LeaveDescription form-control" readonly value="'+value.Description+'" placeholder="Leave type descrioption"/></td>'+
                        '<td style="width:10%;"><input type="text" name="row['+m+'][LeaveBalance]" id="LeaveBalance'+m+'" class="LeaveBalance form-control" onkeypress="return ValidateNum(event);" readonly onkeyup="leaveBalanceFn(this)" placeholder="Leave balance"/></td>'+
                        '<td style="width:15%;"><select id="DependOnBalance'+m+'" class="select2 form-control DependOnBalance" name="row['+m+'][DependOnBalance]" onchange="useBalanceFn(this)"></select></td>'+
                        '<td style="width:15%;"><select id="IsAllowed'+m+'" class="select2 form-control IsAllowed" name="row['+m+'][IsAllowed]" onchange="isAllowedFn(this)"></select></td>'+
                        '<td style="width:20%;"><input type="text" name="row['+m+'][Remark]" id="Remark'+m+'" class="Remark form-control" placeholder="Write remark here..."/></td>'+
                        '<td style="display:none;"><input type="hidden" name="row['+m+'][hr_leavetypes_id]" id="hr_leavetypes_id'+m+'" class="hr_leavetypes_id form-control" readonly="true" style="font-weight:bold;" value="'+value.id+'"/></td></tr>'
                    );
                    var isallowed = '<option selected value=""></option><option value="Allowed">Allow</option><option value="Not-Allowed">Not-Allow</option>';
                    $('#IsAllowed'+m).append(isallowed);
                    $('#IsAllowed'+m).select2
                    ({
                        placeholder: "Select value here",
                        minimumResultsForSearch: -1
                    });

                    var usebalance = '<option selected value=""></option><option value="1">Yes</option><option value="0">No</option>';
                    $('#DependOnBalance'+m).append(usebalance);
                    $('#DependOnBalance'+m).select2
                    ({
                        placeholder: "Select value here",
                        minimumResultsForSearch: -1
                    });
                    $('#select2-IsAllowed'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                    $('#select2-DependOnBalance'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                });
            });
        }

        function empEditFn(recordId) { 
            $('.select2').select2();
            $("#operationtypes").val("2");
            $("#recId").val(recordId);
            $(".fingerprintval").val("");
            $(".fingerprintcls").html("");
            $('.guarantor_prop_btn').hide();
            $('.form_dynamic_table > tbody').empty();
            $('.tab-content').removeClass('not-editable-div');
            $('.access_control_div').removeClass('not-editable-div');
            $('#savebutton').hide();
            j = 0;
            m = 0;
            z = 0;
            z1 = 0;
            z3 = 0;
            var defopt = "";
            var actualpic = "";
            var guarantorcondoc = "";
            var biopic = "";
            var resdoc = "";
            var workexpdoc = "";
            var awarddoc = "";
            var trcerdoc = "";
            var recdoc = "";
            var otherdoc = "";
            var signedcontract = "";
            var defposition = "";
            var positionopt = "";
            var salaryidval = "";
            var usecustomizedsal = "";
            var picdatabin = null;
            var default_date = "1900-01-01";
            var max_date = "";
            var count_contr = 0;
            var edit_permission_count = 0;

            $.get("/showemployee"+'/'+recordId , function(data) {
                picdatabin = data.picdata;
                count_contr = data.count_contract;

                $.each(data.employeedata, function(key, value) {
                    $('#title').val(value.title).select2();
                    $('#reg_form_title').html(value.EmployeeID);
                    $('#fullName').val(value.name);
                    $('#FirstName').val(value.FirstName);
                    $('#MiddleName').val(value.MiddleName);
                    $('#LastName').val(value.LastName);
                    $('#gender').val(value.Gender).trigger('change').select2({minimumResultsForSearch: -1});
                    $('#Dob').val(value.Dob);
                    $('#Branch').val(value.branches_id).select2({dropdownCssClass : 'cusprop'});
                    $('#Department').val(value.departments_id).select2({dropdownCssClass : 'cusprop'});
                    positionopt = $("#PositionCbx > option").clone();
                    defposition = `<option selected value='${value.positions_id}'>${value.PositionName}</option>`;
                    $('#Position').append(positionopt);
                    $(`#Position option[title!='${value.departments_id}']`).remove();
                    $(`#Position option[value='${value.positions_id}']`).remove();
                    $('#Position').append(defposition).select2({dropdownCssClass : 'cusprop'});
                    $('#status').val(value.Status).trigger('change').select2({minimumResultsForSearch: -1});

                    $('#MobileNumber').val(value.MobileNumber);
                    $('#OfficePhoneNumber').val(value.OfficePhoneNumber);
                    $('#Email').val(value.Email);
                    $('#country').val(value.Country).select2();
                    $('#city-dd').val(value.cities_id).trigger('change').select2({dropdownCssClass : 'cusprop'});
                    $('#subcity-dd').val(value.subcities_id).trigger('change').select2({dropdownCssClass : 'cusprop'});
                    $('#Woreda').val(value.Woreda).trigger('change').select2();
                    $('#Kebele').val(value.kebele);
                    $('#HouseNumber').val(value.house_no);
                    $('#Address').val(value.Address);

                    $('#nationality').val(value.Nationality).select2();
                    $('#ResidanceIdNumber').val(value.ResidanceIdNumber);
                    $('#NationalIdNumber').val(value.NationalIdNumber);
                    $('#PassportNumber').val(value.PassportNumber);
                    $('#DrivingLicenseNumber').val(value.DrivingLicenseNumber);
                    $('#Postcode').val(value.Postcode);
                    $('#MartialStatus').val(value.MartialStatus).trigger('change').select2({minimumResultsForSearch: -1});
                    $('#BloodType').val(value.blood_type).trigger('change').select2();
                    $('#Description').val(value.GeneralMemo);
                    $('#EmergencyName').val(value.EmergencyName);
                    $('#EmergencyPhone').val(value.EmergencyPhone);
                    $('#EmergencyAddress').val(value.EmergencyAddress);
                    
                    $('#EmploymentType').val(value.employementtypes_id).trigger('change').select2({ minimumResultsForSearch: -1});
                    $('#SupervisorOrImmedaiteManager').val(value.employees_id).select2();
                    $('#HiredDate').val(value.HiredDate);

                    $('#AccessStatus').val(value.AccessStatus).select2({minimumResultsForSearch: -1});
                    $('.role_data_div').hide();
                    if(value.AccessStatus == "Enable"){
                        getRoleDataFn();
                    }

                    $('#EnableAttendance').val(value.EnableAttendance).trigger('change').select2({minimumResultsForSearch: -1});

                    $('#EnableHoliday').val(value.EnableHoliday).trigger('change').select2({minimumResultsForSearch: -1});
                    
                    $('#GuarantorName').val(value.GuarantorName);
                    $('#GuarantorPhone').val(value.GuarantorPhone);
                    if(value.GuarantorDocument != null){
                        $('.guarantor_prop_btn').show();
                    }
                    $('#GuarantorAddress').val(value.GuarantorAddress);
                    $('#GuarantorFileName').val(value.GuarantorDocument);

                    $('#monthly_work_hour').val(value.monthly_work_hour);
                    $('#PaymentType').val(value.PaymentType).trigger('change').select2({minimumResultsForSearch: -1});
                    $('#PaymentPeriod').val(value.PaymentPeriond).trigger('change').select2({minimumResultsForSearch: -1});
                    $('#Bank').val(value.banks_id).select2({dropdownCssClass : 'commprp',});
                    $('#BankAccountNumber').val(value.BankAccountNumber);
                    $('#ProvidentFundAccount').val(value.ProvidentFundAccount);
                    $('#PensionNumber').val(value.PensionNumber);
                    $('#Tin').val(value.Tin);
                    $('#tinCounter').html(`${value.Tin > 0 ? value.Tin.length : 0}/13`);

                    value.PaymentType == "Cash" ? $('.bankprop').hide() : $('.bankprop').show();

                    $('#PIN').val(value.PIN);
                    $('#CardNumber').val(value.CardNumber);
                    $('#EnrollDevice').val(value.devices_id).select2();

                    $('#personuuid').val(value.PersonUUID);
                    $('#LeftThumbVal').val(value.LeftThumb);
                    $('#LeftIndexVal').val(value.LeftIndex);
                    $('#LeftMiddelVal').val(value.LeftMiddle);
                    $('#LeftRingVal').val(value.LeftRing);
                    $('#LeftPickyVal').val(value.LeftPinky);
                    $('#RightThumbVal').val(value.RightThumb);
                    $('#RightIndexVal').val(value.RightIndex);
                    $('#RightMiddleVal').val(value.RightMiddle);
                    $('#RightRingVal').val(value.RightRing);
                    $('#RightPickyVal').val(value.RightPinky);

                    setFingerPrintStatus(value.LeftThumb,   'leftthumblbl', 'left_thumb');
                    setFingerPrintStatus(value.LeftIndex,     'leftindexlbl', 'left_index');
                    setFingerPrintStatus(value.LeftMiddle,  'leftmiddlelbl', 'left_middle');
                    setFingerPrintStatus(value.LeftRing,    'leftringlbl', 'left_ring');
                    setFingerPrintStatus(value.LeftPinky,   'leftpinkylbl', 'left_pinky');

                    setFingerPrintStatus(value.RightThumb,  'rightthumblbl', 'right_thumb');
                    setFingerPrintStatus(value.RightIndex,    'rightindexlbl', 'right_index');
                    setFingerPrintStatus(value.RightMiddle, 'rightmiddlelbl', 'right_middle');
                    setFingerPrintStatus(value.RightRing,   'rightringlbl', 'right_ring');
                    setFingerPrintStatus(value.RightPinky,  'rightpinkylbl', 'right_pinky');

                    $('#actualPhoto').val(value.ActualPicture);
                    $('#bioPhoto').val(value.BiometricPicture);
                   
                    actualpic = value.ActualPicture;
                    biopic = value.BiometricPicture;

                    if(actualpic == null){
                        $('#imagePreview').attr("src","../../../storage/uploads/HrEmployee/dummypic.jpg");
                        $('#actimageclosebtn').hide();
                    }
                    if(actualpic != null){
                        $('#imagePreview').attr("src",`../../../storage/uploads/HrEmployee/${actualpic}`);
                        $('#actimageclosebtn').show();
                    }

                    if(biopic == null){
                        $('#bioImagePreview').attr("src","../../../storage/uploads/BioEmployee/dummypic.jpg");
                        $('#bioimageclosebtn').hide();
                        $("#faceidencoded").val("");
                    }
                    if(biopic != null){
                        $('#bioImagePreview').attr("src",`../../../storage/uploads/BioEmployee/${biopic}`);
                        $('#bioimageclosebtn').show();
                        $("#faceidencoded").val(picdatabin);
                    }
                });
                
                $.each(data.documentation, function(key, value) {
                    if(value.upload_type == 1){
                        ++y3;
                        ++z3;
                        ++x3;
                        $("#documentDynamicTable > tbody").append(`<tr id="docrowtr${z3}">
                            <td style="font-weight:bold;width:3%;text-align:center;">${x3}</td>
                            <td style="display:none;"><input type="hidden" name="docrow[${z3}][docvals]" id="docvals${z3}" class="docvals form-control" readonly="true" style="font-weight:bold;" value="${z3}"/></td>
                            <td style="width:22%;"><select id="document_type${z3}" class="select2 form-control document_type" onchange="docTypeFn(this)" name="docrow[${z3}][document_type]"></select></td>
                            <td style="width:22%;"><input type="text" id="upload_date${z3}" name="docrow[${z3}][upload_date]" class="form-control upload_date${z3}" value="${value.doc_date}" placeholder="YYYY-MM-DD" readonly onchange="uploadDateFn(this)"/></td>
                            <td style="width:25%;">
                                <div class="input-group">
                                    <input class="form-control fileuploads" type="file" id="doc_upload${z3}" name="docrow[${z3}][doc_upload]" onchange="docmntUploadFn(this)" accept=".jpg, .jpeg, .png,.pdf" style="width:90%;">
                                    <button type="button" id="doc_view${z3}" class="btn btn-light btn-sm doc_view view-doc" onclick="previewDocFn(this,'doc')" style="color:#00cfe8;background-color:#FFFFFF;border-color:#FFFFFF;padding: 1px 1px;width:9%;" title="Open uploaded document"><i class="fas fa-eye fa-lg" aria-hidden="true"></i></button>
                                    <input type="hidden" class="form-control" value="${value.doc_name}" name="docrow[${z3}][documents]" id="documents${z3}"/>
                                    <input type="hidden" class="form-control" value="${value.doc_name}" name="docrow[${z3}][doc_upload_hidden]" id="doc_upload_hidden${z3}"/>
                                    <input type="hidden" class="form-control" value="${value.actual_file_name}" name="docrow[${z3}][doc_actual_name]" id="doc_actual_name${z3}"/>
                                <div>
                            </td>
                            <td style="width:25%;"><input type="text" name="docrow[${z3}][doc_remark]" id="cont_remark${z3}" class="cont_remark form-control" value="${value.remark == "" || value.remark == null ? "" : value.remark}" placeholder="Write Remark here..."/></td>
                            <td style="width:3%;text-align:center;"><button type="button" id="remove_doc_btn${z3}" class="btn btn-light btn-sm remove_doc_btn" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF;padding: 1px 1px"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>
                        </tr>`);

                        var default_document_type = `<option selected value="${value.type}">${value.doc_type}</option>`;
                        var doc_type_opt = $("#doc_type_default > option").clone();
                        $(`#document_type${z3}`).append(doc_type_opt);
                        $(`#document_type${z3} option[value="${value.type}"]`).remove(); 
                        $(`#document_type${z3}`).append(default_document_type);
                        $(`#document_type${z3}`).select2({dropdownCssClass : 'cusprop'});
                        flatpickr(`#upload_date${z3}`, { dateFormat: 'Y-m-d',allowInput: true,clickOpens:true,minDate:default_date,maxDate:currdate});
                        $(`#select2-document_type${z3}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                    }
                    
                    if(value.upload_type == 2){
                        ++y2;
                        ++z2;
                        ++x2;
                        $("#contractDynamicTable > tbody").append(`<tr id="controwtr${z2}">
                            <td style="font-weight:bold;width:3%;text-align:center;">${x2}</td>
                            <td style="display:none;"><input type="hidden" name="controw[${z2}][contvals]" id="contvals${z2}" class="contvals form-control" readonly="true" style="font-weight:bold;" value="${z2}"/></td>
                            <td style="width:15%;"><input type="text" id="sign_date${z2}" name="controw[${z2}][sign_date]" class="form-control date_prop con_date${z2}" value="${value.sign_date}" placeholder="YYYY-MM-DD" readonly onchange="signDateFn(this)"/></td>
                            <td style="width:15%;"><input type="text" id="expire_date${z2}" name="controw[${z2}][expire_date]" class="form-control date_prop con_date${z2}" value="${value.expire_date}" placeholder="YYYY-MM-DD" readonly onchange="expireDateFn(this)"/></td>
                            <td style="width:15%;"><input type="text" id="cont_duration${z2}" name="controw[${z2}][cont_duration]" class="form-control" value="${value.duration}" readonly placeholder="Duration in days"/></td>
                            <td style="width:25%;">
                                <div class="input-group">
                                    <input class="form-control fileuploads" type="file" id="cont_document${z2}" name="controw[${z2}][cont_document]" onchange="docUploadFn(this)" accept=".jpg, .jpeg, .png,.pdf" style="width:90%;">
                                    <button type="button" id="cont_view${z2}" class="btn btn-light btn-sm cont_view view-doc" onclick="previewDocFn(this,'con')" style="color:#00cfe8;background-color:#FFFFFF;border-color:#FFFFFF;padding: 1px 1px;width:9%;" title="Open uploaded document"><i class="fas fa-eye fa-lg" aria-hidden="true"></i></button>
                                    <input type="hidden" class="form-control" value="${value.doc_name}" name="controw[${z2}][contracts]" id="contracts${z2}"/>
                                    <input type="hidden" class="form-control" value="${value.doc_name}" name="controw[${z2}][contract_hidden]" id="contract_hidden${z2}"/>
                                    <input type="hidden" class="form-control" value="${value.actual_file_name}" name="controw[${z2}][con_actual_name]" id="con_actual_name${z2}"/>
                                <div>
                            </td>
                            <td style="width:24%;"><input type="text" name="controw[${z2}][cont_remark]" id="cont_remark${z2}" class="cont_remark form-control" value="${value.remark == "" || value.remark == null ? "" : value.remark}" placeholder="Write Remark here..."/></td>
                            <td style="width:3%;text-align:center;"><button type="button" id="remove_cont_btn${z2}" class="btn btn-light btn-sm remove_cont_btn" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF;padding: 1px 1px;display:none;"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>
                        </tr>`);

                        if(count_contr != z2){
                            flatpickr(`#sign_date${z2}`, { dateFormat: 'Y-m-d',allowInput: true,clickOpens:false,maxDate:currdate,minDate:max_date,defaultDate:value.sign_date});
                            flatpickr(`#expire_date${z2}`, { dateFormat: 'Y-m-d',allowInput: true,clickOpens:false,minDate:currdate,defaultDate:value.expire_date});
                        }
                        else if(count_contr == z2){
                            flatpickr(`#sign_date${z2}`, { dateFormat: 'Y-m-d',allowInput: true,clickOpens:true,maxDate:currdate,minDate:max_date,defaultDate:value.sign_date});
                            flatpickr(`#expire_date${z2}`, { dateFormat: 'Y-m-d',allowInput: true,clickOpens:true,minDate:currdate,defaultDate:value.expire_date});
                        }
                        $('.remove_cont_btn').hide();
                        $(`#remove_cont_btn${z2}`).show();
                    }
                });

                $.each(data.skill_set, function(key, value) {
                    if(value.type == 1){
                        ++y;
                        ++z;
                        ++x;

                        $("#wellnessDynamicTable > tbody").append(`<tr id="wellrowtr${z}">
                            <td style="font-weight:bold;width:5%;text-align:center;">${x}</td>
                            <td style="display:none;"><input type="hidden" name="wellrow[${z}][wellval]" id="wellval${z}" class="wellvals form-control" readonly="true" style="font-weight:bold;" value="${z}"/></td>
                            <td style="width:25%;"><select id="well_skill${z}" class="select2 form-control well_skill" onchange="wellSkillFn(this)" name="wellrow[${z}][well_skill]"></select></td>
                            <td style="width:25%;"><select id="well_level${z}" class="select2 form-control well_level" onchange="wellLevelFn(this)" name="wellrow[${z}][well_level]"></select></td>
                            <td style="width:40%;"><input type="text" name="wellrow[${z}][well_remark]" id="well_remark${z}" class="well_remark form-control" value="${value.remark == "" || value.remark == null ? "" : value.remark}" placeholder="Write Remark here..."/></td>
                            <td style="width:5%;text-align:center;"><button type="button" id="remove_well_btn${z}" class="btn btn-light btn-sm remove_well_btn" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF;padding: 1px 1px"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>
                        </tr>`);

                        var default_skill = `<option selected value="${value.skills_id}">${value.skill_name}</option>`;
                        var default_level = `<option selected value="${value.level_id}">${value.level}</option>`;

                        var skillset_opt = $("#skillset_default > option").clone();
                        $(`#well_skill${z}`).append(skillset_opt);
                        $(`#well_skill${z} option[data-skill-type!=1]`).remove(); 
                        $(`#well_skill${z} option[value="${value.skills_id}"]`).remove();
                        $(`#well_skill${z}`).append(default_skill);
                        $('#wellnessDynamicTable > tbody  > tr').each(function(index, tr) {
                            let skill_id = $(this).find('.well_skill').val();
                            $(`#well_skill${z} option[value="${skill_id}"]`).remove(); 
                        });
                        $(`#well_skill${z}`).append(default_skill);
                        $(`#well_skill${z}`).select2({dropdownCssClass : 'cusprop'});
                        
                        var level_opt = $("#level_default > option").clone();
                        $(`#well_level${z}`).append(level_opt);
                        $(`#well_level${z} option[value="${value.level_id}"]`).remove();
                        $(`#well_level${z}`).append(default_level);
                        $(`#well_level${z}`).select2({dropdownCssClass : 'cusprop'});

                        $(`#select2-well_skill${z}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                        $(`#select2-well_level${z}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                    }

                    if(value.type == 2){
                        ++y1;
                        ++z1;
                        ++x1;

                        $("#medicalDynamicTable > tbody").append(`<tr id="medrowtr${z1}">
                            <td style="font-weight:bold;width:5%;text-align:center;">${x1}</td>
                            <td style="display:none;"><input type="hidden" name="medrow[${z1}][medvals]" id="medvals${z1}" class="medvals form-control" readonly="true" style="font-weight:bold;" value="${z1}"/></td>
                            <td style="width:25%;"><select id="med_skill${z1}" class="select2 form-control med_skill" onchange="medSkillFn(this)" name="medrow[${z1}][med_skill]"></select></td>
                            <td style="width:25%;"><select id="med_level${z1}" class="select2 form-control med_level" onchange="medLevelFn(this)" name="medrow[${z1}][med_level]"></select></td>
                            <td style="width:40%;"><input type="text" name="medrow[${z1}][med_remark]" id="med_remark${z1}" class="med_remark form-control" value="${value.remark == "" || value.remark == null ? "" : value.remark}" placeholder="Write Remark here..."/></td>
                            <td style="width:5%;text-align:center;"><button type="button" id="remove_med_btn${z1}" class="btn btn-light btn-sm remove_med_btn" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF;padding: 1px 1px"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>
                        </tr>`);

                        var default_skill = `<option selected value="${value.skills_id}">${value.skill_name}</option>`;
                        var default_level = `<option selected value="${value.level_id}">${value.level}</option>`;
                    
                        var skillset_opt = $("#skillset_default > option").clone();
                        $(`#med_skill${z1}`).append(skillset_opt);
                        $(`#med_skill${z1} option[data-skill-type!=2]`).remove();
                        $(`#med_skill${z1} option[value="${value.skills_id}"]`).remove();
                        $(`#med_skill${z1}`).append(default_skill);
                        $('#medicalDynamicTable > tbody  > tr').each(function(index, tr) {
                            let skill_id = $(this).find('.med_skill').val();
                            $(`#med_skill${z1} option[value="${skill_id}"]`).remove(); 
                        });
                        $(`#med_skill${z1}`).append(default_skill);
                        $(`#med_skill${z1}`).select2({dropdownCssClass : 'cusprop'});

                        var level_opt = $("#level_default > option").clone();
                        $(`#med_level${z1}`).append(level_opt);
                        $(`#med_level${z1} option[value="${value.level_id}"]`).remove();
                        $(`#med_level${z1}`).append(default_level);
                        $(`#med_level${z1}`).select2({dropdownCssClass : 'cusprop'});

                        $(`#select2-med_skill${z1}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                        $(`#select2-med_level${z1}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                    }
                });

                if(data.can_edit_common == 0){
                    $('.common-view').addClass('not-editable-div');
                    edit_permission_count += 1;
                }
                if(data.can_edit_general == 0){
                    $('.general-tab-view').addClass('not-editable-div');
                    edit_permission_count += 1;
                }
                if(data.can_edit_hr == 0){
                    $('.hr-content-view').addClass('not-editable-div');
                    edit_permission_count += 1;
                }
                if(data.can_edit_well_skill == 0){
                    $('.wellness-skill-content-view').addClass('not-editable-div');
                    edit_permission_count += 1;
                }
                if(data.can_edit_med_skill == 0){
                    $('.medical-skill-content-view').addClass('not-editable-div');
                    edit_permission_count += 1;
                }

                renumberDocRows();
                renumberContRows();

                renumberWellRows();
                renumberMedRows();

                edit_permission_count == 5 ? $('#savebutton').hide() : $('#savebutton').show();
            });

            $('.biometric_div').show();
            $("#modaltitle").html("Edit Employee");
            $('#savebutton').text('Update');
            $('#savebutton').prop("disabled",false);
            $('#savenewbutton').hide();
            tabMgtFn();
            $("#inlineForm").modal('show'); 
        }

        function setFingerPrintStatus(value, labelId, tdId) {
            const isRegistered = value !== null && value !== '' && value !== 'NULL' && value !== undefined;

            $('.' + labelId)
                .html(isRegistered ? 'Registered' : 'Not Registered')
                .css({
                    'color' : isRegistered ? '#155724' : '#721c24',
                    'background-color' : isRegistered ? '#d4edda' : '#f8d7da',
                    'font-size' : '0.85rem',
                    'padding' : '3px 8px',
                    'border-radius' : '20px',
                    'display' : 'inline-block'
                });
                

            $('.' + tdId).css('color', isRegistered ? '#28c76f' : errorcolor);

            //$(`#${tdId} label`).css('color', isRegistered ? '#28c76f' : errorcolor);

            return isRegistered ? 1 : 0;
        }

        function empInfoFn(recordId) { 
            createInfoFn(recordId);
            $("#informationmodal").modal('show');
        }

        function createInfoFn(recordId){
            var rolename = "";
            var salaryidval = "";
            var usecustomizedsal = "";
            var typeflag = "";
            var compPensionPercent = 11;
            var empPensionPercent = 7;
            var totaltaxable = 0;
            var totalnontaxable = 0;
            var totalearning = 0;
            var totaldeduction = 0;
            var netpay = 0;
            var lidata = "";
            var action_links = "";
            var reset_password = "";
            $(".info_datatable").hide();
            $(".bankprop").hide();
            $("#statusdisplay").html("");
            
            $.get("/showemployee"+'/'+recordId , function(data) {
                salaryidval = data.salaryid;
                usecustomizedsal = data.usenegsalary;
                rolename = data.rolename;
                $("#info_employee_id").val(recordId);
                $("#emp_username").html(data.uname);

                $.each(data.employeedata, function(key, value) {
                    $('#infoActualImage').attr("src",value.ActualPicture == null ? "../../../storage/uploads/HrEmployee/dummypic.jpg" : `../../../storage/uploads/HrEmployee/${value.ActualPicture}`);
                    $('#employeeIdLbl').html(value.EmployeeID);
                    $('#fullNameLbl').html(`${value.emp_title} ${value.name}`);
                    $('.sl_emp_name').html(`${value.emp_title} ${value.name}`);
                    $('#FirstNameLbl').html(value.FirstName);
                    $('#MiddleNameLbl').html(value.MiddleName);
                    $('#LastNameLbl').html(value.LastName);
                    $('#genderLbl').html(value.Gender);
                    $('#DobLbl').html(value.Dob);
                    $('#BranchLbl').html(value.BranchName);
                    $('#DepartmentLbl').html(value.DepartmentName);
                    $('#PositionLbl').html(value.PositionName);
                    // $('#SalaryLbl').html(value.SalaryName);

                    $('#MobileNumberLbl').html(value.MobileNumber);
                    $('#OfficePhoneNumberLbl').html(value.OfficePhoneNumber);
                    $('#EmailLbl').html(value.Email);
                    $('#countryLbl').html(value.Country);
                    $('#city-ddLbl').html(value.city_name);
                    $('#subcity-ddLbl').html(value.subcity_name);
                    $('#WoredaLbl').html(value.Woreda);
                    $('#Kebele_Lbl').html(value.kebele);
                    $('#House_Num_Lbl').html(value.house_no);
                    $('#AddressLbl').html(value.Address);

                    $('#nationalityLbl').html(value.Nationality);
                    $('#ResidanceIdNumberLbl').html(value.ResidanceIdNumber);
                    $('#NationalIdNumberLbl').html(value.NationalIdNumber);
                    $('#PassportNumberLbl').html(value.PassportNumber);
                    $('#DrivingLicenseNumberLbl').html(value.DrivingLicenseNumber);
                    $('#PostcodeLbl').html(value.Postcode);
                    $('#MartialStatusLbl').html(value.MartialStatus);
                    $('#BloodType_Lbl').html(value.bloodtype);
                    $('#DescriptionLbl').html(value.GeneralMemo);

                    $('#EmergencyNameLbl').html(value.EmergencyName);
                    $('#EmergencyPhoneLbl').html(value.EmergencyPhone);
                    $('#EmergencyAddressLbl').html(value.EmergencyAddress);

                    $('#SupervisorOrImmedaiteManagerLbl').html(value.Supervisor);
                    $('#EmploymentTypeLbl').html(value.EmploymentTypeName);
                    $('#HiredDateLbl').html(value.HiredDate);
                    
                    $('#EnableAttendanceLbl').html(value.EnableAttendance);
                    $('#EnableHolidayLbl').html(value.EnableHoliday);
                    
                    $('#guarantornamelbl').html(value.GuarantorName);
                    $('#guarantorphonelbl').html(value.GuarantorPhone);
                    $('#guarantoraddresslbl').html(value.GuarantorAddress);
                    $('#guaranteInfoForm').attr("src",value.GuarantorDocument == null ? "../../../storage/uploads/EmployeeDocumets/GuarantorDocument/123.png" : `../../../storage/uploads/EmployeeDocumets/GuarantorDocument/${value.GuarantorDocument}`);
                    
                    $('#PINLbl').html(value.PIN);
                    $('#CardNumberLbl').html(value.CardNumber);
                    $('#EnrollDeviceLbl').html(value.DeviceName);
                    $('#infoBioImage').attr("src",value.BiometricPicture == null ? "../../../storage/uploads/BioEmployee/dummypic.jpg" : `../../../storage/uploads/BioEmployee/${value.BiometricPicture}`);
                  
                    setFingerPrintStatus(value.LeftThumb,   'leftthumblbl', 'left_thumb');
                    setFingerPrintStatus(value.LeftIndex,     'leftindexlbl', 'left_index');
                    setFingerPrintStatus(value.LeftMiddle,  'leftmiddlelbl', 'left_middle');
                    setFingerPrintStatus(value.LeftRing,    'leftringlbl', 'left_ring');
                    setFingerPrintStatus(value.LeftPinky,   'leftpinkylbl', 'left_pinky');

                    setFingerPrintStatus(value.RightThumb,  'rightthumblbl', 'right_thumb');
                    setFingerPrintStatus(value.RightIndex,    'rightindexlbl', 'right_index');
                    setFingerPrintStatus(value.RightMiddle, 'rightmiddlelbl', 'right_middle');
                    setFingerPrintStatus(value.RightRing,   'rightringlbl', 'right_ring');
                    setFingerPrintStatus(value.RightPinky,  'rightpinkylbl', 'right_pinky');

                    $('#AccessStatusLbl').html(value.AccessStatus);

                    value.AccessStatus == "Enable" ?  $('.info_role_data_div').show() : $('.info_role_data_div').hide();
                    $("#statusdisplay").html(value.Status == "Active" ? `<b style='color:#1cc88a'>${value.EmployeeID}, ${value.Status}</b>` : value.Status == "Resign" ? `<b style='color:#82868b'>${value.EmployeeID}, ${value.Status}</b>` : `<b style='color:#e74a3b'>${value.EmployeeID}, ${value.Status}</b>`);
                    $("#action-log-status-lbl").html(value.Status == "Active" ? `<b style='color:#1cc88a'>${value.EmployeeID}, ${value.Status}</b>` : `<b style='color:#e74a3b'>${value.EmployeeID}, ${value.Status}</b>`);

                    $('#monthly_workhr').html(value.monthly_work_hour);
                    $('#PaymentTypeLbl').html(value.PaymentType);
                    $('#PaymentPeriodLbl').html(value.PaymentPeriond);
                    $('#BankLbl').html(value.BankName);
                    $('#BankAccountNumberLbl').html(value.BankAccountNumber);
                    $('#ProvidentFundAccountLbl').html(value.ProvidentFundAccount);
                    $('#PensionNumberLbl').html(value.PensionNumber);
                    $('#TinLbl').html(value.Tin);
                    $('#negotaiblesalarylblinfo').html(value.SalaryTypeFlag);
                    $('#salarynameinfolbl').html(value.SalaryName);
                    $('#info_employee_code').val(value.EmployeeID);

                    value.PaymentType == "Cash" ? $('.bankprop').hide() : $('.bankprop').show();

                    reset_password = value.AccessStatus == "Enable" ? `@can("userpaswword-reset")<li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item passwordReset" onclick="passwordResetLinkFn(${recordId})" data-id="passwordReset${recordId}" id="passwordReset${recordId}" title="Open password reset confirmation">
                           <span><i class="fas fa-unlock-alt"></i> Reset Password</span>  
                        </a>
                    </li>@endcan` : "";
                });

                $.each(data.activitydata, function(key, value) {
                    var classes = "";
                    if(value.action == "Edited" || value.action == "Salary-Edited"){
                        classes = "warning";
                    }
                    else if(value.action == "Created" || value.action == "Salary-Created"){
                        classes = "success";
                    }
                    else if(value.action == "Password Reset"){
                        classes = "secondary";
                    }
                    lidata += `<li class="timeline-item"><span class="timeline-point timeline-point-${classes} timeline-point-indicator"></span><div class="timeline-header mb-sm-0 mb-0"><h6 class="mb-0">${value.action}</h6><span class="text-muted"><i class="fa-regular fa-user"></i> ${value.FullName}</span></br><span class="text-muted"><i class="fa-regular fa-clock"></i> ${value.time}</span></div></li>`;
                });

                $("#actiondiv").empty().append(lidata);
                $("#universal-action-log-canvas").empty().append(lidata);

                action_links = `
                    <li>
                        <a class="dropdown-item viewEmpAction" onclick="viewEmpFn(${recordId})" data-id="viewactionbtn${recordId}" id="viewactionbtn${recordId}" title="View user log">
                           <span><i class="fa-solid fa-eye"></i> View User Log</span>  
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    @can("Employee-Edit")
                    <li>
                        <a class="dropdown-item empEdit" onclick="empEditFn(${recordId})" data-id="dteditbtn${recordId}" id="dteditbtn${recordId}" title="Open employee edit page">
                           <span><i class="fa-solid fa-pencil"></i> Edit</span>  
                        </a>
                    </li>
                    @endcan
                    @can("Employee-Delete")
                    <li>
                        <a class="dropdown-item empDelete" onclick="empDeleteFn(${recordId})" data-id="dtdeletebtn${recordId}" id="dtdeletebtn${recordId}" title="Open employee delete confirmation">
                           <span><i class="fa-solid fa-xmark"></i> Delete</span>  
                        </a>
                    </li>
                    @endcan
                    <li><hr class="dropdown-divider"></li>
                    @can("Leave-Allocation-View")
                    <li>
                        <a class="dropdown-item leaveAlloc" onclick="leaveAllocFn(${recordId})" data-id="leavealloc${recordId}" id="leavealloc${recordId}" title="Open leave allocation setup form">
                           <span><i class="fas fa-calendar-plus"></i> Leave Allocation Setup</span>  
                        </a>
                    </li>
                    @endcan
                    @can("Employee-Salary-View")
                    <li>
                        <a class="dropdown-item salarySetup" onclick="salarySetupFn(${recordId})" data-id="salarySetup${recordId}" id="salarySetup${recordId}" title="Open salary setup form">
                           <span><i class="fas fa-money-bill-wave"></i> Salary Setup</span>  
                        </a>
                    </li>
                    @endcan
                    ${reset_password}`;

                $("#employee_action_ul").empty().append(action_links);
                
                getDocumentFn(recordId,1);
                getContractFn(recordId,2);

                getWellnessFn(recordId,1);
                getMedicalFn(recordId,2);

                getLeaveHistoryFn(recordId);
            });

            getSelectedRoleAndAssignInfo(recordId)
            
            tabMgtFn();
        }

        function viewEmpFn(recordId){
            $("#action-log-title").html("Employee → User Log Information");
            $("#action-log-universal-modal").modal('show');
        }

        function getDocumentFn(em_id,doc_type){
            var e_id = "";
            var type = "";
            $('#info-doc-datatable').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                paging: false,
                searching: false,
                info: false,
                searchHighlight: true,
                autoWidth: false,
                "order": [[ 0, "asc" ]],
                "pagingType": "simple",
                language: { search: '', searchPlaceholder: "Search here"},
                "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4 d-flex justify-content-center'i><'col-sm-12 col-md-4 d-flex justify-content-end'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/getEmployeeDocuments',
                    type: 'POST',
                    data:{
                        e_id: em_id,
                        type: doc_type,
                    },
                    dataType: "json",
                },
                columns: [
                    { data: 'DT_RowIndex', width:'3%'},
                    { data: 'doc_type', name: 'doc_type', width:'22%'},
                    { data: 'doc_date', name: 'doc_date',width:"20%"},
                    { 
                        data: 'actual_file_name', 
                        name: 'actual_file_name',
                        width:"30%",
                        "render": function ( data, type, row, meta ) {
                            return `<a style="text-decoration:underline;color:blue;" onclick=openDocFn("${row.id}","${row.doc_name}","${row.upload_type}")>${data}</a>`;
                        }   
                    },   
                    { data: 'remark', name: 'remark', width:'25%'} 
                ],
                drawCallback: function(settings) {
                    this.api().columns().every(function() {
                        var column = this;
                        var header = $(column.header()).text().trim();
                        
                        $(column.nodes()).each(function() {
                            $(this).attr('data-title', header);
                        });
                    });
                    $("#info-doc-datatable").show();
                },
            });
        }

        function getContractFn(em_id,doc_type){
            var e_id = "";
            var type = "";
            $('#info-cont-datatable').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                paging: false,
                searching: false,
                info: false,
                searchHighlight: true,
                autoWidth: false,
                "order": [[ 0, "asc" ]],
                "pagingType": "simple",
                language: { search: '', searchPlaceholder: "Search here"},
                "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4 d-flex justify-content-center'i><'col-sm-12 col-md-4 d-flex justify-content-end'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/getEmployeeDocuments',
                    type: 'POST',
                    data:{
                        e_id: em_id,
                        type: doc_type,
                    },
                    dataType: "json",
                },
                columns: [
                    { data: 'DT_RowIndex', width:'3%'},
                    { data: 'sign_date', name: 'sign_date', width:'17%'},
                    { data: 'expire_date', name: 'expire_date',width:"17%"},
                    { data: 'duration', name: 'duration',width:"20%"},
                    { 
                        data: 'actual_file_name', 
                        name: 'actual_file_name',
                        width:"24%",
                        "render": function ( data, type, row, meta ) {
                            return `<a style="text-decoration:underline;color:blue;" onclick=openDocFn("${row.id}","${row.doc_name}","${row.upload_type}")>${data}</a>`;
                        }   
                    },   
                    { data: 'remark', name: 'remark', width:'19%'} 
                ],
                drawCallback: function(settings) {
                    this.api().columns().every(function() {
                        var column = this;
                        var header = $(column.header()).text().trim();
                        
                        $(column.nodes()).each(function() {
                            $(this).attr('data-title', header);
                        });
                    });
                    $("#info-cont-datatable").show();
                },
            });
        }

        function getWellnessFn(em_id,doc_type){
            var e_id = "";
            var type = "";
            $('#info-wellness-datatable').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                paging: false,
                searching: false,
                info: false,
                searchHighlight: true,
                autoWidth: false,
                "order": [[ 0, "asc" ]],
                "pagingType": "simple",
                language: { search: '', searchPlaceholder: "Search here"},
                "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4 d-flex justify-content-center'i><'col-sm-12 col-md-4 d-flex justify-content-end'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/getEmployeeSkillSet',
                    type: 'POST',
                    data:{
                        e_id: em_id,
                        type: doc_type,
                    },
                    dataType: "json",
                },
                columns: [
                    { data: 'DT_RowIndex', width:'3%'},
                    { data: 'skill_name', name: 'skill_name', width:'26%'},
                    { data: 'level', name: 'level',width:"26%"},
                    { data: 'remark', name: 'remark', width:'45%'} 
                ],
                drawCallback: function(settings) {
                    this.api().columns().every(function() {
                        var column = this;
                        var header = $(column.header()).text().trim();
                        
                        $(column.nodes()).each(function() {
                            $(this).attr('data-title', header);
                        });
                    });
                    $("#info-wellness-datatable").show();
                },
            });
        }

        function getMedicalFn(em_id,doc_type){
            var e_id = "";
            var type = "";
            $('#info-medical-datatable').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                paging: false,
                searching: false,
                info: false,
                searchHighlight: true,
                autoWidth: false,
                "order": [[ 0, "asc" ]],
                "pagingType": "simple",
                language: { search: '', searchPlaceholder: "Search here"},
                "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4 d-flex justify-content-center'i><'col-sm-12 col-md-4 d-flex justify-content-end'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/getEmployeeSkillSet',
                    type: 'POST',
                    data:{
                        e_id: em_id,
                        type: doc_type,
                    },
                    dataType: "json",
                },
                columns: [
                    { data: 'DT_RowIndex', width:'3%'},
                    { data: 'skill_name', name: 'skill_name', width:'26%'},
                    { data: 'level', name: 'level',width:"26%"},
                    { data: 'remark', name: 'remark', width:'45%'} 
                ],
                drawCallback: function(settings) {
                    this.api().columns().every(function() {
                        var column = this;
                        var header = $(column.header()).text().trim();
                        
                        $(column.nodes()).each(function() {
                            $(this).attr('data-title', header);
                        });
                    });
                    $("#info-medical-datatable").show();
                },
            });
        }

        function getPayrollDataFn(salaryidval){
            var compPensionPercent = 11;
            var empPensionPercent = 7;
            $('#salarydedinfotbl').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                paging:false,
                searching:false,
                info:false,
                searchHighlight: true,
                "order": [[ 0, "asc" ]],
                "pagingType": "simple",
                language: { search: '', searchPlaceholder: "Search here"},
                "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-12'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-12'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/showSalaryDetails/'+salaryidval,
                    type: 'POST',
                    data:{
                        typeflag: 2,
                    },
                    dataType: "json",
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
                paging:false,
                searching:false,
                info:false,
                searchHighlight: true,
                "order": [[ 0, "asc" ]],
                "pagingType": "simple",
                language: { search: '', searchPlaceholder: "Search here"},
                "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-12'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-12'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/showSalaryDetails/'+salaryidval,
                    type: 'POST',
                    data:{
                        typeflag: 1,
                    },
                    dataType: "json",
                },
                columns: [
                    { data:'DT_RowIndex', width:'3%'},
                    { data: 'SalaryTypeName', name: 'SalaryTypeName', width:'30%'},
                    { data: 'Amount', name: 'Amount',width:"15%",render: $.fn.dataTable.render.number(',', '.',2, '')},
                    { data: 'NonTaxableAmount', name: 'NonTaxableAmount',width:"15%",render: $.fn.dataTable.render.number(',', '.',2, '')},   
                    { data: 'TotalAmount', name: 'TotalAmount',width:"15%",render: $.fn.dataTable.render.number(',', '.',2, '')},   
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
                    this.api().columns().every(function() {
                        var column = this;
                        var header = $(column.header()).text().trim();
                        
                        $(column.nodes()).each(function() {
                            $(this).attr('data-title', header);
                        });
                    });
                    $("#salarydetaildiv").show();
                },
            });
        }

        function getLeaveHistoryFn(em_id){
            var e_id = "";
            var colorA = 'style="font-size:14px;font-weight:bold;background:#F9F9F9;"';
            $('#info-leavehis-datatable').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                searching: true,
                info: false,
                searchHighlight: true,
                autoWidth: false,
                ordering: false,
                paging: false,
                "pagingType": "simple",
                language: { search: '', searchPlaceholder: "Search here"},
                "dom": "<'row'<'col-sm-4 col-md-2 col-5 ml-0'f><'col-sm-8 col-md-10 col-7 mt-1 d-flex justify-content-end leave-print-export'>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4 d-flex justify-content-center'i><'col-sm-12 col-md-4 d-flex justify-content-end'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/getLeaveHistory',
                    type: 'POST',
                    data:{
                        e_id: em_id,
                    },
                    dataType: "json",
                },
                columns: [
                    { data: 'DT_RowIndex', width:'3%'},
                    { 
                        data: 'ReferenceNumber', 
                        name: 'ReferenceNumber',
                        "render": function ( data, type, row, meta ) {
                            return `<a style="text-decoration:underline;color:blue;" onclick=openLeaveRefFn("${row.HeaderId}","${parseInt(row.LeaveEarned)}","${parseInt(row.LeaveUsage)}","${row.RecordType}")>${data}</a>`;
                        },
                        width:"16%"   
                    },
                    { data: 'LeaveType', name: 'LeaveType', width:'13%'},
                    { data: 'LeaveEarned', name: 'LeaveEarned',render: $.fn.dataTable.render.number(',', '.', 2, ''),width:"13%"},
                    { data: 'LeaveUsage', name: 'LeaveUsage',render: $.fn.dataTable.render.number(',', '.', 2, ''),width:"13%"},
                    { data: 'running_remaining', name: 'running_remaining',render: $.fn.dataTable.render.number(',', '.', 2, ''),width:"16%"},
                    { data: 'RecordType', name: 'RecordType',width:"13%"}, 
                    { data: 'Date', name: 'Date', width:'13%'},
                    { data: 'Year', name: 'Year', width:'0%','visible': false},
                    { data: 'total_balance', name: 'total_balance', width:'0%','visible': false},
                    { data: 'id', name: 'id', width:'0%','visible': false}    
                ],
                "order": [[10, "asc"],[8, "asc"]],
                rowGroup: {
                    startRender: function ( rows, group ) {
                        return $(`<tr ${colorA}>
                            <td colspan="8" style="text-align:center;"><b>${group}</b></td>
                        </tr>`);
                    },
                    endRender: function ( rows, group,level ) {
                        var intVal = function ( i ) {
                            return typeof i === 'string' ?
                                i.replace(/[\$,]/g, '')*1 :
                                typeof i === 'number' ?
                                        i : 0;
                        };

                        var total_balance = rows
                        .data()
                        .pluck('total_balance')
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0); 

                        return $(`<tr ${colorA}>
                            <td colspan="8" style="text-align:right;">Total of ${group}: ${numformat(parseFloat(total_balance).toFixed(2))}</td>
                        </tr>`);     
                    },
                    dataSrc: 'Year'
                },
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(),data;
                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };
                    var total_balance = api
                    .column(9)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
                    $("#total_balance_info").html(`Total: ${total_balance === 0 ? '' : numformat(parseFloat(total_balance).toFixed(2))}`);
                },
                drawCallback: function(settings) {
                    var api = this.api();
                    var currentIndex = 1;
                    var currentGroup = null;
                    this.api().columns().every(function() {
                        var column = this;
                        var header = $(column.header()).text().trim();
                        
                        $(column.nodes()).each(function() {
                            $(this).attr('data-title', header);
                        });
                    });

                    api.rows({ page: 'current', search: 'applied' }).every(function() {
                        var rowData = this.data();
                        if (rowData) {
                            var group = rowData['Year']; // Assuming 'group_column' is the name of the column used for grouping
                            if (group !== currentGroup) {
                                currentIndex = 1; // Reset index for a new group
                                currentGroup = group;
                            }
                            $(this.node()).find('td:first').text(currentIndex++);
                        }
                    });
                    
                    $("#info-leavehis-datatable").show();
                },
            });

            var print_export_btn = $(`
                <div class="btn-group dropdown" style="height:38px !important;">
                    <button type="button" class="btn btn-outline-secondary btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa-sharp fa-solid fa-caret-down fa-xl"></i><span class="btn-text">&nbsp Print & Export</span>
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item printLeaveHistory" data-id="printLeaveHistory" id="printLeaveHistory" title="Print Leave History">
                                <span><i class="fas fa-print"></i> Print</span>  
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item expExcelLeaveHistory" data-id="expExcelLeaveHistory" id="expExcelLeaveHistory" title="Export Leave History to Excel">
                                <span><i class="fas fa-file-excel"></i> Export to Excel</span>  
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item expPdfLeaveHistory" data-id="expPdfLeaveHistory" id="expPdfLeaveHistory" title="Export Leave History to PDF">
                                <span><i class="fas fa-file-pdf"></i> Export to PDF</span>  
                            </a>
                        </li>
                    </ul>
                </div>
            `);

            $('.leave-print-export').empty().append(print_export_btn);
        }

        function openDocFn(row_id,doc_name,doc_type){
            $.get("/openEmployeeDoc" + '/' + row_id+'/'+ doc_name+ '/' + doc_type, function(data) {
                var link = doc_type == 1 ? `../../../storage/uploads/EmployeeDocumets/ResumeAndOther/${doc_name}` : `../../../storage/uploads/EmployeeDocumets/Contracts/${doc_name}`;
                window.open(link, '', 'width=1200,height=800,scrollbars=yes');
            });
        }

        function openSalaryFn(row_id,doc_name){
            var link = `../../../storage/uploads/EmployeeDocumets/Salary/${doc_name}`;
            window.open(link, '', 'width=1200,height=800,scrollbars=yes');
        }

        function openLeaveRefFn(rec_id,earned,utilized,rec_type){
            if(earned > 0 || (utilized > 0 && rec_type == "Void")){
                infoLeaveAllocFn(rec_id);
            }
            else{
                //alert("Not Assigned yet...");
            }
        }

        $(document).on('click', '.employee_img_cls', function() {
            const imageUrl = $(this).attr('src');
        
            if (!imageUrl.includes('placeholder')) {
                Swal.fire({
                    imageUrl: imageUrl,
                    imageAlt: 'Employee Image',
                    imageWidth: '78%',
                    imageHeight: '80%',
                    imageClass: 'swal-image-rounded',
                    showConfirmButton: false,
                    showCloseButton: true,
                    closeButtonHtml: '&times;',
                    padding: '0',
                    background: 'rgba(255, 255, 255, 0.1)',
                    backdrop: 'rgba(0, 0, 0, 0.7)',
                    customClass: {
                        popup: 'swal-glass-popup',
                        closeButton: 'swal-close-button',
                        image: 'swal-image-styled'
                    }
                });
            }
        });

        //--------------Role & assignment start------------------
        function getRoleDataFn(){
            var posinc = 0;
            var proinc = 0;
            var recinc = 0;
            var reqinc = 0;
            var trnsrcinc = 0;
            var trndesinc = 0;
            var trnrecinc = 0;
            var apprinc = 0;
            var issueinc = 0;
            var adjinc = 0;
            var beginc = 0;
            var stbalinc = 0;
            var fitposinc = 0;
            var posrepinc = 0;
            var purhaserepinc = 0;
            var invrepinc = 0;
            var wellrepinc = 0;
            var medrepinc = 0;
            var emp_id = $("#recId").val();

            $.ajax({ 
                url: '/getRoleData',
                type: 'POST',
                dataType: 'json',
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
                    $('.append-data').empty();
                    $('#clear-search-role').hide();
                    $('#roledatasearchresult').html("");
                    $("#select-all-role").prop("checked", false);
                    $("#select-all-role").prop("indeterminate", false);

                    $(".select-all-checkbox").prop("checked", false);
                    $(".select-all-checkbox").prop("indeterminate", false);

                    $("#select-all-pur").prop("checked", false);
                    $("#select-all-pur").prop("indeterminate", false);

                    $.each(data.roles, function(key, value) {
                        $("#roledatacanvas").append(`<div class="col-xl-3 col-lg-6 col-md-12 col-sm-12 col-12"><div class="custom-control custom-control-primary custom-checkbox"><input type="checkbox" class="custom-control-input roleid" id="roleid${value.id}" name="roleid[]" value="${value.id}"/><label class="custom-control-label" for="roleid${value.id}">${++key}) ${value.name}</label></div></div>`);
                    });  

                    $.each(data.shopdata, function(key, value) {
                        ++posinc;
                        ++proinc;
                        ++fitposinc;
                        ++posrepinc;
                        ++purhaserepinc;
                        ++invrepinc;
                        ++wellrepinc;
                        ++medrepinc;

                        $("#posdatacanvas").append(`<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12"><div class="custom-control custom-control-primary custom-checkbox"><input type="checkbox" class="custom-control-input pos pos_pro" id="pos${value.id}" name="pos[]" value="${value.id}"/><label class="custom-control-label" for="pos${value.id}">${posinc}) ${value.Name}</label></div></div>`);
                        $("#proformadatacanvas").append(`<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12"><div class="custom-control custom-control-primary custom-checkbox"><input type="checkbox" class="custom-control-input proforma pos_pro" id="proforma${value.id}" name="proforma[]" value="${value.id}"/><label class="custom-control-label" for="proforma${value.id}">${proinc}) ${value.Name}</label></div></div>`);
                        $("#fitposdatacanvas").append(`<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12"><div class="custom-control custom-control-primary custom-checkbox"><input type="checkbox" class="custom-control-input fitpos fit_spa" id="fitpos${value.id}" name="fitpos[]" value="${value.id}"/><label class="custom-control-label" for="fitpos${value.id}">${fitposinc}) ${value.Name}</label></div></div>`);
                        $("#posreportdatacanvas").append(`<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12"><div class="custom-control custom-control-primary custom-checkbox"><input type="checkbox" class="custom-control-input posrep" id="posrep${value.id}" name="posrep[]" value="${value.id}"/><label class="custom-control-label" for="posrep${value.id}">${posrepinc}) ${value.Name}</label></div></div>`);
                        $("#purchasedatacanvas").append(`<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12"><div class="custom-control custom-control-primary custom-checkbox"><input type="checkbox" class="custom-control-input purchaserep" id="purchaserep${value.id}" name="purchaserep[]" value="${value.id}"/><label class="custom-control-label" for="purchaserep${value.id}">${purhaserepinc}) ${value.Name}</label></div></div>`);
                        $("#invrepdatacanvas").append(`<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12"><div class="custom-control custom-control-primary custom-checkbox"><input type="checkbox" class="custom-control-input invreport" id="invreport${value.id}" name="invreport[]" value="${value.id}"/><label class="custom-control-label" for="invreport${value.id}">${invrepinc}) ${value.Name}</label></div></div>`);
                        $("#wellnessrepdatacanvas").append(`<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12"><div class="custom-control custom-control-primary custom-checkbox"><input type="checkbox" class="custom-control-input wellrep" id="wellrep${value.id}" name="wellrep[]" value="${value.id}"/><label class="custom-control-label" for="wellrep${value.id}">${wellrepinc}) ${value.Name}</label></div></div>`);
                        $("#medicaldatacanvas").append(`<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12"><div class="custom-control custom-control-primary custom-checkbox"><input type="checkbox" class="custom-control-input medrep" id="medrep${value.id}" name="medrep[]" value="${value.id}"/><label class="custom-control-label" for="medrep${value.id}">${medrepinc}) ${value.Name}</label></div></div>`);
                    });  
                    $.each(data.storedata, function(key, value) {
                        ++recinc;
                        ++reqinc;
                        ++trnsrcinc;
                        ++trndesinc;
                        ++trnrecinc;
                        ++apprinc;
                        ++issueinc;
                        ++adjinc;
                        ++beginc;
                        ++stbalinc;
                        ++purhaserepinc;
                        ++invrepinc;

                        $("#receivingdatacanvas").append(`<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12"><div class="custom-control custom-control-primary custom-checkbox"><input type="checkbox" class="custom-control-input receiving" id="receiving${value.id}" name="receiving[]" value="${value.id}"/><label class="custom-control-label" for="receiving${value.id}">${recinc}) ${value.Name}</label></div></div>`);
                        $("#reqdatacanvas").append(`<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12"><div class="custom-control custom-control-primary custom-checkbox"><input type="checkbox" class="custom-control-input req" id="req${value.id}" name="req[]" value="${value.id}"/><label class="custom-control-label" for="req${value.id}">${reqinc}) ${value.Name}</label></div></div>`);
                        $("#trsrcdatacanvas").append(`<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12"><div class="custom-control custom-control-primary custom-checkbox"><input type="checkbox" class="custom-control-input trnsrc" id="trnsrc${value.id}" name="trnsrc[]" value="${value.id}"/><label class="custom-control-label" for="trnsrc${value.id}">${trnsrcinc}) ${value.Name}</label></div></div>`);
                        $("#trdesdatacanvas").append(`<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12"><div class="custom-control custom-control-primary custom-checkbox"><input type="checkbox" class="custom-control-input trndes" id="trndes${value.id}" name="trndes[]" value="${value.id}"/><label class="custom-control-label" for="trndes${value.id}">${trndesinc}) ${value.Name}</label></div></div>`);
                        $("#trnrecdatacanvas").append(`<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12"><div class="custom-control custom-control-primary custom-checkbox"><input type="checkbox" class="custom-control-input trnrec" id="trnrec${value.id}" name="trnrec[]" value="${value.id}"/><label class="custom-control-label" for="trnrec${value.id}">${trnrecinc}) ${value.Name}</label></div></div>`);
                        $("#apprdatacanvas").append(`<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12"><div class="custom-control custom-control-primary custom-checkbox"><input type="checkbox" class="custom-control-input appr" id="appr${value.id}" name="appr[]" value="${value.id}"/><label class="custom-control-label" for="appr${value.id}">${apprinc}) ${value.Name}</label></div></div>`);
                        $("#issuedatacanvas").append(`<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12"><div class="custom-control custom-control-primary custom-checkbox"><input type="checkbox" class="custom-control-input issue" id="issue${value.id}" name="issue[]" value="${value.id}"/><label class="custom-control-label" for="issue${value.id}">${issueinc}) ${value.Name}</label></div></div>`);
                        $("#adjdatacanvas").append(`<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12"><div class="custom-control custom-control-primary custom-checkbox"><input type="checkbox" class="custom-control-input adj" id="adj${value.id}" name="adj[]" value="${value.id}"/><label class="custom-control-label" for="adj${value.id}">${adjinc}) ${value.Name}</label></div></div>`);
                        $("#begdatacanvas").append(`<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12"><div class="custom-control custom-control-primary custom-checkbox"><input type="checkbox" class="custom-control-input beg" id="beg${value.id}" name="beg[]" value="${value.id}"/><label class="custom-control-label" for="beg${value.id}">${beginc}) ${value.Name}</label></div></div>`);
                        $("#stbaldatacanvas").append(`<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12"><div class="custom-control custom-control-primary custom-checkbox"><input type="checkbox" class="custom-control-input stbal" id="stbal${value.id}" name="stbal[]" value="${value.id}"/><label class="custom-control-label" for="stbal${value.id}">${stbalinc}) ${value.Name}</label></div></div>`);
                        $("#purchasedatacanvas").append(`<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12"><div class="custom-control custom-control-primary custom-checkbox"><input type="checkbox" class="custom-control-input purchaserep" id="purchaserep${value.id}" name="purchaserep[]" value="${value.id}"/><label class="custom-control-label" for="purchaserep${value.id}">${purhaserepinc}) ${value.Name}</label></div></div>`);
                        $("#invrepdatacanvas").append(`<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12"><div class="custom-control custom-control-primary custom-checkbox"><input type="checkbox" class="custom-control-input invreport" id="invreport${value.id}" name="invreport[]" value="${value.id}"/><label class="custom-control-label" for="invreport${value.id}">${invrepinc}) ${value.Name}</label></div></div>`);
                    });

                    $('#pos_title_lbl').html(`POS (Point of Sales) (${posinc})`);
                    $('#proforma_title_lbl').html(`Proforma (${proinc})`);
                    $('#receiving_title_lbl').html(`Receiving (${recinc})`);
                    $('#requisition_title_lbl').html(`Requisition (${reqinc})`);
                    $('#trnsrc_title_lbl').html(`Transfer Source (${trnsrcinc})`);
                    $('#trndes_title_lbl').html(`Transfer Destination (${trndesinc})`);
                    $('#trnrec_title_lbl').html(`Transfer Receive (${trnrecinc})`);
                    $('#appr_title_lbl').html(`Approver (${apprinc})`);
                    $('#issue_title_lbl').html(`Issue (${issueinc})`);
                    $('#adj_title_lbl').html(`Adjustment (${adjinc})`);
                    $('#beg_title_lbl').html(`Beginning (${beginc})`);
                    $('#stbal_title_lbl').html(`Stock Balance (${stbalinc})`);

                    $('#fit_pos_title_lbl').html(`POS (Point of Sales) (${fitposinc})`);
                    $('#posreport_title_lbl').html(`POS (Point of Sales) (${posrepinc})`);
                    $('#purchase_title_lbl').html(`Purchase (${purhaserepinc})`);
                    $('#invrep_title_lbl').html(`Inventory (${invrepinc})`);
                    $('#wellness_title_lbl').html(`Wellness (${wellrepinc})`);
                    $('#medical_title_lbl').html(`Medical (${medrepinc})`);

                    if(emp_id != "" && emp_id != null){
                        getSelectedRoleAndAssignment(emp_id)
                    }
                    if(emp_id == "" || emp_id == null){
                        $('.role_data_div').show();
                    }
                },
                error: function(xhr, status, error) {
                    $('#roledatacanvas').text(`Error loading data: ${error}`).css('color', 'red');
                }
            });
        }

        function getSelectedRoleAndAssignment(e_id){
            $.ajax({ 
                url: '/getSelectedRoleAndAssign'+'/'+e_id,
                type: 'POST',
                dataType: 'json',
                success: function(data) {
                    
                    $.each(data.selected_role, function(index, values) {
                        $(`#roleid${values.role_id}`).prop("checked", true);
                    });
                    selectAllRoleFn();
                    $.each(data.assign_data, function(index, assval) {
                        if(assval.Type == 1){ $(`#receiving${assval.StoreId}`).prop("checked", true);}
                        if(assval.Type == 2){ $(`#issue${assval.StoreId}`).prop("checked", true);}
                        if(assval.Type == 3){ $(`#appr${assval.StoreId}`).prop("checked", true);}
                        if(assval.Type == 4){ $(`#pos${assval.StoreId}`).prop("checked", true);}
                        if(assval.Type == 5){ $(`#proforma${assval.StoreId}`).prop("checked", true);}
                        if(assval.Type == 6){ $(`#stbal${assval.StoreId}`).prop("checked", true);}
                        if(assval.Type == 7){ $(`#req${assval.StoreId}`).prop("checked", true);}
                        if(assval.Type == 8){ $(`#trnsrc${assval.StoreId}`).prop("checked", true);}
                        if(assval.Type == 9){ $(`#trndes${assval.StoreId}`).prop("checked", true);}
                        if(assval.Type == 10){ $(`#adj${assval.StoreId}`).prop("checked", true);}
                        if(assval.Type == 11){ $(`#beg${assval.StoreId}`).prop("checked", true);}
                        if(assval.Type == 12){ $(`#posrep${assval.StoreId}`).prop("checked", true);}
                        if(assval.Type == 13){ $(`#purchaserep${assval.StoreId}`).prop("checked", true);}
                        if(assval.Type == 14){ $(`#invreport${assval.StoreId}`).prop("checked", true);}
                        if(assval.Type == 15){ $(`#trnrec${assval.StoreId}`).prop("checked", true);}
                        // if(assval.Type == 16){ }
                        if(assval.Type == 17){ $(`#fitpos${assval.StoreId}`).prop("checked", true);}
                        if(assval.Type == 18){ $(`#wellrep${assval.StoreId}`).prop("checked", true);}
                        if(assval.Type == 19){ $(`#medrep${assval.StoreId}`).prop("checked", true);}
                    });

                    $('.checkbox-itm').each(function () {
                        const masterCheckbox = $(this).closest('.checkbox-grp').find('.select-all-checkbox');
                        updateSelectAllState(masterCheckbox);
                        updateSuperSelectAllState();
                    });

                    $("#select-all-pur").prop("checked", data.is_purchaser == 1);
                    $('.role_data_div').show();
                }
            });
        }

        function getSelectedRoleAndAssignInfo(e_id){
            var role_data = "";
            var recinc = 0;
            var issueinc = 0;
            var apprinc = 0;
            var posinc = 0;
            var proinc = 0;
            var stbalinc = 0;
            var reqinc = 0;
            var trnsrcinc = 0;
            var trndesinc = 0;
            var adjinc = 0;
            var beginc = 0;
            var trnrecinc = 0;
            var posrepinc = 0;
            var purhaserepinc = 0;
            var invrepinc = 0;
            var fitposinc = 0;
            var wellrepinc = 0;
            var medrepinc = 0;
            
            $("#roledatacanvas_info").empty();
            $(".append-data").empty();
            $.ajax({ 
                url: '/getSelectedRoleAndAssign'+'/'+e_id,
                type: 'POST',
                dataType: 'json',
                success: function(data) {
                    $.each(data.selected_role, function(index, values) {
                        $("#roledatacanvas_info").append(`<div class="col-xl-3 col-lg-6 col-md-12 col-sm-12 col-12 info_lbl">${++index}) ${values.role_name}</div>`);
                    });

                    $.each(data.assign_data, function(index, assval) {
                        if(assval.Type == 1){ 
                            ++recinc;
                            $("#info_receivingdatacanvas").append(`<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">${recinc}) ${assval.store_name}</div>`);
                        }
                        if(assval.Type == 2){ 
                            ++issueinc;
                            $("#info_issuedatacanvas").append(`<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">${issueinc}) ${assval.store_name}</div>`);
                        }
                        if(assval.Type == 3){ 
                            ++apprinc;
                            $("#info_apprdatacanvas").append(`<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">${apprinc}) ${assval.store_name}</div>`);
                        }
                        if(assval.Type == 4){ 
                            ++posinc;
                            $("#info_posdatacanvas").append(`<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">${posinc}) ${assval.store_name}</div>`);
                        }
                        if(assval.Type == 5){ 
                            ++proinc;
                            $("#info_proformadatacanvas").append(`<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">${proinc}) ${assval.store_name}</div>`);
                        }
                        if(assval.Type == 6){ 
                            ++stbalinc;
                            $("#info_stbaldatacanvas").append(`<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">${stbalinc}) ${assval.store_name}</div>`);
                        }
                        if(assval.Type == 7){ 
                            ++reqinc;
                            $("#info_reqdatacanvas").append(`<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">${reqinc}) ${assval.store_name}</div>`);
                        }
                        if(assval.Type == 8){ 
                            ++trnsrcinc;
                            $("#info_trsrcdatacanvas").append(`<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">${trnsrcinc}) ${assval.store_name}</div>`);
                        }
                        if(assval.Type == 9){ 
                            ++trndesinc;
                            $("#info_trdesdatacanvas").append(`<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">${trndesinc}) ${assval.store_name}</div>`);
                        }
                        if(assval.Type == 10){ 
                            ++adjinc;
                            $("#info_adjdatacanvas").append(`<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">${adjinc}) ${assval.store_name}</div>`);
                        }
                        if(assval.Type == 11){ 
                            ++beginc;
                            $("#info_begdatacanvas").append(`<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">${beginc}) ${assval.store_name}</div>`);
                        }
                        if(assval.Type == 12){ 
                            ++posrepinc;
                            $("#info_posreportdatacanvas").append(`<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">${posrepinc}) ${assval.store_name}</div>`);
                        }
                        if(assval.Type == 13){ 
                            ++purhaserepinc;
                            $("#info_purchasedatacanvas").append(`<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">${purhaserepinc}) ${assval.store_name}</div>`);
                        }
                        if(assval.Type == 14){ 
                            ++invrepinc;
                            $("#info_invrepdatacanvas").append(`<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">${invrepinc}) ${assval.store_name}</div>`);
                        }
                        if(assval.Type == 15){ 
                            ++trnrecinc;
                            $("#info_trnrecdatacanvas").append(`<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">${trnrecinc}) ${assval.store_name}</div>`);
                        }
                        if(assval.Type == 17){ 
                            ++fitposinc;
                            $("#info_fitposdatacanvas").append(`<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">${fitposinc}) ${assval.store_name}</div>`);
                        }
                        if(assval.Type == 18){ 
                            ++wellrepinc;
                            $("#info_wellnessrepdatacanvas").append(`<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">${wellrepinc}) ${assval.store_name}</div>`);
                        }
                        if(assval.Type == 19){ 
                            ++medrepinc;
                            $("#info_medicaldatacanvas").append(`<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">${medrepinc}) ${assval.store_name}</div>`);
                        }
                    });

                    $("#info_is_purchaser").html(`Is Purchaser: ${data.is_purchaser == 1 ? "&nbsp;<b>Yes</b>" : "&nbsp;<b>No</b>"}`);

                    $('#info_pos_title_lbl').html(`POS (Point of Sales) (${posinc})`);
                    $('#info_proforma_title_lbl').html(`Proforma (${proinc})`);
                    $('#info_receiving_title_lbl').html(`Receiving (${recinc})`);
                    $('#info_requisition_title_lbl').html(`Requisition (${reqinc})`);
                    $('#info_trnsrc_title_lbl').html(`Transfer Source (${trnsrcinc})`);
                    $('#info_trndes_title_lbl').html(`Transfer Destination (${trndesinc})`);
                    $('#info_trnrec_title_lbl').html(`Transfer Receive (${trnrecinc})`);
                    $('#info_appr_title_lbl').html(`Approver (${apprinc})`);
                    $('#info_issue_title_lbl').html(`Issue (${issueinc})`);
                    $('#info_adj_title_lbl').html(`Adjustment (${adjinc})`);
                    $('#info_beg_title_lbl').html(`Beginning (${beginc})`);
                    $('#info_stbal_title_lbl').html(`Stock Balance (${stbalinc})`);

                    $('#info_fit_pos_title_lbl').html(`POS (Point of Sales) (${fitposinc})`);
                    $('#info_posreport_title_lbl').html(`POS (Point of Sales) (${posrepinc})`);
                    $('#info_purchase_title_lbl').html(`Purchase (${purhaserepinc})`);
                    $('#info_invrep_title_lbl').html(`Inventory (${invrepinc})`);
                    $('#info_wellness_title_lbl').html(`Wellness (${wellrepinc})`);
                    $('#info_medical_title_lbl').html(`Medical (${medrepinc})`);
                },
            });
        }

        $("#search-role").on("keyup", function () {
            let keyword = $(this).val().trim().toLowerCase();
            let found = false;

            // Loop all labels
            $("#roledatacanvas .custom-control-label").each(function () {
                let label = $(this);
                let text  = label.text();
                let lower = text.toLowerCase();

                // Remove old highlight
                label.html(text);

                // If empty search: show all
                if (keyword === "") {
                    label.closest("div.col-xl-3, div.col-lg-3, div.col-md-12, div.col-sm-6, div.col-12").show();
                    $('#clear-search-role').hide();
                    found = true;
                    return;
                }

                // Check match
                if (lower.includes(keyword)) {
                    found = true;
                    // Show item
                    label.closest("div.col-xl-3, div.col-lg-3, div.col-md-12, div.col-sm-6, div.col-12").show();

                    // Highlight matched word
                    let regex = new RegExp("(" + keyword + ")", "gi");
                    label.html(text.replace(regex, "<span class='highlight' style='background-color: yellow;padding: 1px 2px;border-radius: 3px;'>$1</span>"));
                    $('#clear-search-role').show();
                } else {
                    // Hide non-matching
                    label.closest("div.col-xl-3, div.col-lg-3, div.col-md-12, div.col-sm-6, div-col-12").hide();
                    $('#clear-search-role').show();
                }
            });
            $('#roledatasearchresult').html(!found ? `</br><b style="color:#ea5455"><i>No result found!</i></b>` : "");
        });

        $("#clear-search-role").on("click", function () {
            // Clear the textbox
            $("#search-role").val("");

            // Reset all labels (show + remove highlight)
            $("#roledatacanvas .custom-control-label").each(function () {
                let label = $(this);
                let text  = label.text();

                // Remove highlight
                label.html(text);

                // Show all items
                label.closest("div.col-xl-3, div.col-lg-3, div.col-md-12, div.col-sm-6, div.col-12").show();
            });
            $('#clear-search-role').hide();
            $('#roledatasearchresult').html("");
        });

        // 1. When clicking Select All
        $("#select-all-role").on("change", function () {
            let checked = $(this).prop("checked");

            // Set all role checkboxes
            $(".roleid").prop("checked", checked);

            // Remove indeterminate state
            this.indeterminate = false;
            $('#roledata-error').html("");
        });

        $(document).on("change", ".roleid", function () {
            selectAllRoleFn();
            $('#roledata-error').html("");
        });

        function selectAllRoleFn(){
            let total = $(".roleid").length;
            let checked = $(".roleid:checked").length;

            // If none checked → Select All unchecked
            if (checked === 0) {
                $("#select-all-role").prop("checked", false);
                $("#select-all-role")[0].indeterminate = false;
            }
            // If all checked → Select All fully checked
            else if (checked === total) {
                $("#select-all-role").prop("checked", true);
                $("#select-all-role")[0].indeterminate = false;
            }
            // If partially checked → Select All indeterminate
            else {
                $("#select-all-role").prop("checked", false);
                $("#select-all-role")[0].indeterminate = true;
            }
        }

        $('.select-all-checkbox').on('change', function() {
            const targetClass = $(this).data('target');
            const isChecked = $(this).is(':checked');
            
            // Select/deselect all checkboxes with the target class within the same group
            $(this).closest('.checkbox-grp').find(targetClass).prop('checked', isChecked);
            
            // Update the select-all state
            updateSelectAllState($(this));
            updateSuperSelectAllState();
        });
        
        //$('.checkbox-itm input[type="checkbox"]').on('change', function() {
        $(document).on("change", ".checkbox-itm", function () {
            // Find the master checkbox in the same group

            const masterCheckbox = $(this).closest('.checkbox-grp').find('.select-all-checkbox');
            updateSelectAllState(masterCheckbox);
            updateSuperSelectAllState();
        });

        function updateSelectAllState(masterCheckbox) {
            const targetClass = masterCheckbox.data('target');
            const checkboxes = masterCheckbox.closest('.checkbox-grp').find(targetClass);
            
            const totalCheckboxes = checkboxes.length;
            const checkedCount = checkboxes.filter(':checked').length;
            
            // Update select-all checkbox state
            if (checkedCount === 0) {
                masterCheckbox.prop('checked', false);
                masterCheckbox.prop('indeterminate', false);
            } else if (checkedCount === totalCheckboxes) {
                masterCheckbox.prop('checked', true);
                masterCheckbox.prop('indeterminate', false);
            } else {
                masterCheckbox.prop('checked', false);
                masterCheckbox.prop('indeterminate', true);
            }
        }

        $('.select-all-checkbox').each(function() {
            updateSelectAllState($(this));
            updateSuperSelectAllState();
        });

        $('#select-all-pos_pro').on('change', function() {
            const isChecked = $(this).is(':checked');
            
            // Select/deselect ALL checkboxes including master checkboxes
            $('input[type="checkbox"]').prop('checked', isChecked);
            
            // Update indeterminate states (remove indeterminate when super select is used)
            $('.select-all-checkbox').prop('indeterminate', false);
        });

        function updateSuperSelectAllState() {
            const allCheckboxes = $('input[type="checkbox"]');
            const allIndividualCheckboxes = $('.checkbox-items input[type="checkbox"]');
            const allMasterCheckboxes = $('.select-all-checkbox');
            
            // Count all checkboxes that should be considered
            const totalCheckableItems = allIndividualCheckboxes.length + allMasterCheckboxes.length;
            
            // Count all checked items
            const totalCheckedItems = allCheckboxes.filter(':checked').length;
            
            // Update super select all state
            if (totalCheckedItems === 0) {
                $('#select-all-pos_pro').prop('checked', false);
                $('#select-all-pos_pro').prop('indeterminate', false);
            } else if (totalCheckedItems === totalCheckableItems) {
                $('#select-all-pos_pro').prop('checked', true);
                $('#select-all-pos_pro').prop('indeterminate', false);
            } else {
                $('#select-all-pos_pro').prop('checked', false);
                $('#select-all-pos_pro').prop('indeterminate', true);
            }
        }
        //--------------Role & assignment end------------------

        //--------------Skill start----------------------------
        $("#well_skill_btn").click(function() { 
            var lastrowcount = $('#wellnessDynamicTable > tbody tr:last').find('td').eq(1).find('input').val();
            var skill = $(`#well_skill${lastrowcount}`).val();
            if(skill !== undefined && isNaN(parseFloat(skill))){
                $(`#select2-well_skill${lastrowcount}-container`).parent().css('background-color',errorcolor);
                toastrMessage('error',"Please fill all required fields","Error");
            }
            else{
                ++y;
                ++z;
                ++x;
                $("#wellnessDynamicTable > tbody").append(`<tr id="wellrowtr${z}">
                    <td style="font-weight:bold;width:5%;text-align:center;">${x}</td>
                    <td style="display:none;"><input type="hidden" name="wellrow[${z}][wellval]" id="wellval${z}" class="wellvals form-control" readonly="true" style="font-weight:bold;" value="${z}"/></td>
                    <td style="width:25%;"><select id="well_skill${z}" class="select2 form-control well_skill" onchange="wellSkillFn(this)" name="wellrow[${z}][well_skill]"></select></td>
                    <td style="width:25%;"><select id="well_level${z}" class="select2 form-control well_level" onchange="wellLevelFn(this)" name="wellrow[${z}][well_level]"></select></td>
                    <td style="width:40%;"><input type="text" name="wellrow[${z}][well_remark]" id="well_remark${z}" class="well_remark form-control" placeholder="Write Remark here..."/></td>
                    <td style="width:5%;text-align:center;"><button type="button" id="remove_well_btn${z}" class="btn btn-light btn-sm remove_well_btn" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF;padding: 1px 1px"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>
                </tr>`);

                var default_option = `<option selected disabled value=""></option>`;
                var skillset_opt = $("#skillset_default > option").clone();
                $(`#well_skill${z}`).append(skillset_opt);
                $(`#well_skill${z} option[data-skill-type!=1]`).remove(); 
                $(`#well_skill${z}`).append(default_option);
                $('#wellnessDynamicTable > tbody  > tr').each(function(index, tr) {
                    let skill_id = $(this).find('.well_skill').val();
                    $(`#well_skill${z} option[value="${skill_id}"]`).remove(); 
                });
                $(`#well_skill${z}`).append(default_option);
                $(`#well_skill${z}`).val(null).select2
                ({
                    placeholder: "Select skill here...",
                    dropdownCssClass : 'cusprop',
                });

                var level_opt = $("#level_default > option").clone();
                $(`#well_level${z}`).append(level_opt);
                $(`#well_level${z}`).append(default_option);
                $(`#well_level${z}`).val(null).select2
                ({
                    placeholder: "Select level here...",
                    dropdownCssClass : 'cusprop',
                });

                renumberWellRows();

                $(`#select2-well_skill${z}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                $(`#select2-well_level${z}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
            
                $('#wellness-skill-error').html("");
            }
        });

        function wellSkillFn(ele) {
            var well_row_id = $(ele).closest('tr').find('.wellvals').val();
            var arr = [];
            var found = 0;
            $('.well_skill').each(function() 
            { 
                var name = $(this).val();
                if(arr.includes(name))
                    found++;
                else
                    arr.push(name);
            });

            if(found) 
            {
                toastrMessage('error',"Skill already exist","Error");
                $(`#well_skill${well_row_id}`).val(null).select2
                ({
                    placeholder: "Select skill here...",
                    dropdownCssClass : 'cusprop',
                });
                $(`#select2-well_skill${well_row_id}-container`).parent().css({"background-color":errorcolor,"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
            }
            else{
                $(`#select2-well_skill${well_row_id}-container`).parent().css({"background-color":"white","position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
            }
        }

        function wellLevelFn(ele) {
            var well_row_id = $(ele).closest('tr').find('.wellvals').val();
            $(`#select2-well_level${well_row_id}-container`).parent().css({"background-color":"white","position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
        }

        $(document).on('click', '.remove_well_btn', function() {
            $(this).parents('tr').remove();
            renumberWellRows();
            --x;
        });

        function renumberWellRows() {
            var ind;
            $('#wellnessDynamicTable tr').each(function(index, el) {
                $(this).children('td').first().text(index++);
                ind = index - 1;
            });
        }

        $("#med_skill_btn").click(function() { 
            var lastrowcount = $('#medicalDynamicTable > tbody tr:last').find('td').eq(1).find('input').val();
            var skill = $(`#med_skill${lastrowcount}`).val();
            if(skill !== undefined && isNaN(parseFloat(skill))){
                $(`#select2-med_skill${lastrowcount}-container`).parent().css('background-color',errorcolor);
                toastrMessage('error',"Please fill all required fields","Error");
            }
            else{
                ++y1;
                ++z1;
                ++x1;
                $("#medicalDynamicTable > tbody").append(`<tr id="medrowtr${z1}">
                    <td style="font-weight:bold;width:5%;text-align:center;">${x1}</td>
                    <td style="display:none;"><input type="hidden" name="medrow[${z1}][medvals]" id="medvals${z1}" class="medvals form-control" readonly="true" style="font-weight:bold;" value="${z1}"/></td>
                    <td style="width:25%;"><select id="med_skill${z1}" class="select2 form-control med_skill" onchange="medSkillFn(this)" name="medrow[${z1}][med_skill]"></select></td>
                    <td style="width:25%;"><select id="med_level${z1}" class="select2 form-control med_level" onchange="medLevelFn(this)" name="medrow[${z1}][med_level]"></select></td>
                    <td style="width:40%;"><input type="text" name="medrow[${z1}][med_remark]" id="med_remark${z1}" class="med_remark form-control" placeholder="Write Remark here..."/></td>
                    <td style="width:5%;text-align:center;"><button type="button" id="remove_med_btn${z1}" class="btn btn-light btn-sm remove_med_btn" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF;padding: 1px 1px"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>
                </tr>`);

                var default_option = `<option selected disabled value=""></option>`;
                var skillset_opt = $("#skillset_default > option").clone();
                $(`#med_skill${z1}`).append(skillset_opt);
                $(`#med_skill${z1} option[data-skill-type!=2]`).remove(); 
                $(`#med_skill${z1}`).append(default_option);
                $('#medicalDynamicTable > tbody  > tr').each(function(index, tr) {
                    let skill_id = $(this).find('.med_skill').val();
                    $(`#med_skill${z1} option[value="${skill_id}"]`).remove(); 
                });
                $(`#med_skill${z1}`).append(default_option);
                $(`#med_skill${z1}`).val(null).select2
                ({
                    placeholder: "Select skill here...",
                    dropdownCssClass : 'cusprop',
                });

                var level_opt = $("#level_default > option").clone();
                $(`#med_level${z1}`).append(level_opt);
                $(`#med_level${z1}`).append(default_option);
                $(`#med_level${z1}`).val(null).select2
                ({
                    placeholder: "Select level here...",
                    dropdownCssClass : 'cusprop',
                });

                renumberMedRows();

                $(`#select2-med_skill${z1}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                $(`#select2-med_level${z1}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                
                $('#medical-skill-error').html("");
            }
        });

        function medSkillFn(ele) {
            var med_row_id = $(ele).closest('tr').find('.medvals').val();
            var arr = [];
            var found = 0;
            $('.med_skill').each(function() 
            { 
                var name = $(this).val();
                if(arr.includes(name))
                    found++;
                else
                    arr.push(name);
            });

            if(found) 
            {
                toastrMessage('error',"Skill already exist","Error");
                $(`#med_skill${med_row_id}`).val(null).select2
                ({
                    placeholder: "Select skill here...",
                    dropdownCssClass : 'cusprop',
                });
                $(`#select2-med_skill${med_row_id}-container`).parent().css({"background-color":errorcolor,"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
            }
            else{
                $(`#select2-med_skill${med_row_id}-container`).parent().css({"background-color":"white","position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
            }
        }

        function medLevelFn(ele) {
            var med_row_id = $(ele).closest('tr').find('.medvals').val();
            $(`#select2-med_level${med_row_id}-container`).parent().css({"background-color":"white","position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
        }

        $(document).on('click', '.remove_med_btn', function() {
            $(this).parents('tr').remove();
            renumberMedRows();
            --x1;
        });

        function renumberMedRows() {
            var ind;
            $('#medicalDynamicTable tr').each(function(index, el) {
                $(this).children('td').first().text(index++);
                ind = index - 1;
            });
        }
        //--------------Skill end------------------------------

        //--------------Dynamic document start-----------------
        $("#cont_doc_btn").click(function() { 
            var last_row_id = $('#contractDynamicTable > tbody tr:last').find('td').eq(1).find('input').val();
            var default_date = "1900-01-01";
            var last_row_sign_date = $(`#sign_date${last_row_id}`).val();
            var last_row_expire_date = $(`#expire_date${last_row_id}`).val();
            var max_sign_date = $(`#expire_date${last_row_id}`).val() == undefined || $(`#expire_date${last_row_id}`).val() == "" ? default_date : moment($(`#expire_date${last_row_id}`).val()).add(1, 'day').format('YYYY-MM-DD'); 

            if((last_row_sign_date !== undefined && last_row_sign_date == "") || (last_row_expire_date !== undefined && last_row_expire_date == "")){
                if(last_row_sign_date !== undefined && last_row_sign_date == ""){
                    $(`#sign_date${last_row_id}`).css("background",errorcolor);
                }
                if(last_row_expire_date !== undefined && last_row_expire_date == ""){
                    $(`#expire_date${last_row_id}`).css("background",errorcolor);
                }
                toastrMessage('error',"Please fill all required fields","Error");
            }
            else{
                ++y2;
                ++z2;
                ++x2;
                $("#contractDynamicTable > tbody").append(`<tr id="controwtr${z2}">
                    <td style="font-weight:bold;width:3%;text-align:center;">${x2}</td>
                    <td style="display:none;"><input type="hidden" name="controw[${z2}][contvals]" id="contvals${z2}" class="contvals form-control" readonly="true" style="font-weight:bold;" value="${z2}"/></td>
                    <td style="width:15%;"><input type="text" id="sign_date${z2}" name="controw[${z2}][sign_date]" class="form-control con_date${z2}" placeholder="YYYY-MM-DD" readonly onchange="signDateFn(this)"/></td>
                    <td style="width:15%;"><input type="text" id="expire_date${z2}" name="controw[${z2}][expire_date]" class="form-control con_date${z2}" placeholder="YYYY-MM-DD" readonly onchange="expireDateFn(this)"/></td>
                    <td style="width:15%;"><input type="text" id="cont_duration${z2}" name="controw[${z2}][cont_duration]" class="form-control" readonly placeholder="Duration in days"/></td>
                    <td style="width:25%;">
                        <div class="input-group">
                            <input class="form-control fileuploads" type="file" id="cont_document${z2}" name="controw[${z2}][cont_document]" onchange="docUploadFn(this)" accept=".jpg, .jpeg, .png,.pdf" style="width:90%;">
                            <button type="button" id="cont_view${z2}" class="btn btn-light btn-sm cont_view" onclick="previewDocFn(this,'con')" style="color:#00cfe8;background-color:#FFFFFF;border-color:#FFFFFF;padding: 1px 1px;width:9%;display:none;" title="Open uploaded document"><i class="fas fa-eye fa-lg" aria-hidden="true"></i></button>
                            <input type="hidden" class="form-control" name="controw[${z2}][contracts]" id="contracts${z2}"/>
                            <input type="hidden" class="form-control" name="controw[${z2}][contract_hidden]" id="contract_hidden${z2}"/>
                        <div>
                    </td>
                    <td style="width:24%;"><input type="text" name="controw[${z2}][cont_remark]" id="cont_remark${z2}" class="cont_remark form-control" placeholder="Write Remark here..."/></td>
                    <td style="width:3%;text-align:center;"><button type="button" id="remove_cont_btn${z2}" class="btn btn-light btn-sm remove_cont_btn" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF;padding: 1px 1px"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>
                </tr>`);

                flatpickr(`#sign_date${last_row_id}`, { dateFormat: 'Y-m-d',clickOpens:false,defaultDate:last_row_sign_date});
                flatpickr(`#expire_date${last_row_id}`, { dateFormat: 'Y-m-d',clickOpens:false,defaultDate:last_row_expire_date});

                flatpickr(`#sign_date${z2}`, { dateFormat: 'Y-m-d',allowInput: true,clickOpens:true,maxDate:currdate,minDate:max_sign_date});

                $(`#sign_date${z2}`).val("");
                $(`#expire_date${z2}`).val("");
                $(`#cont_duration${z2}`).val("");

                $(`#remove_cont_btn${last_row_id}`).hide();

                renumberContRows();
                $('#cont-doc-error').html("");
            }
        });

        $(document).on('click', '.remove_cont_btn', function() {
            $(this).parents('tr').remove();
            var last_row_id = $('#contractDynamicTable > tbody tr:last').find('td').eq(1).find('input').val();
            var last_row_sign_date = $(`#sign_date${last_row_id}`).val();
            var last_row_expire_date = $(`#expire_date${last_row_id}`).val();
            flatpickr(`#sign_date${last_row_id}`, { dateFormat: 'Y-m-d',clickOpens:true,defaultDate:last_row_sign_date});
            flatpickr(`#expire_date${last_row_id}`, { dateFormat: 'Y-m-d',clickOpens:true,defaultDate:last_row_expire_date});
            $(`#remove_cont_btn${last_row_id}`).show();
            renumberContRows();
            --x2;
        });

        function renumberContRows() {
            var ind;
            $('#contractDynamicTable tr').each(function(index, el) {
                $(this).children('td').first().text(index++);
                ind = index - 1;
            });
        }

        function signDateFn(ele) {
            var cont_val = $(ele).closest('tr').find('.contvals').val();
            var sign_date = $(`#sign_date${cont_val}`).val();
            var expire_date = $(`#expire_date${cont_val}`).val();
            flatpickr(`#expire_date${cont_val}`, { dateFormat: 'Y-m-d',clickOpens:true,minDate:sign_date});
            $(`#expire_date${cont_val}`).val("");
            $(`#cont_duration${cont_val}`).val("");

            contDurationFn(sign_date, expire_date, cont_val);
            $(`#sign_date${cont_val}`).css("background","#efefef");
        }

        function expireDateFn(ele) {
            var cont_val = $(ele).closest('tr').find('.contvals').val();
            var sign_date = $(`#sign_date${cont_val}`).val();
            var expire_date = $(`#expire_date${cont_val}`).val();
            contDurationFn(sign_date, expire_date, cont_val);
            $(`#expire_date${cont_val}`).css("background","#efefef");
        }

        function contDurationFn(date1, date2, cont_val) {
            if (!date1 || !date2) {
                $(`#cont_duration${cont_val}`).val("");
            }

            var d1 = new Date(date1);
            var d2 = new Date(date2);

            var diffTime = Math.abs(d2 - d1);
            var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            $(`#cont_duration${cont_val}`).val(!isNaN(diffDays) ? diffDays : "");
        }

        function docUploadFn(ele) {
            var cont_val = $(ele).closest('tr').find('.contvals').val();
            $(`#cont_view${cont_val}`).show();
            $(`#cont_document${cont_val}`).css("background","white");
            $(`#contract_hidden${cont_val}`).val(cont_val);
        }

        $("#docmnt_btn").click(function() { 
            var last_row_id = $('#documentDynamicTable > tbody tr:last').find('td').eq(1).find('input').val();
            var default_date = "1900-01-01";
            ++y3;
            ++z3;
            ++x3;

            $("#documentDynamicTable > tbody").append(`<tr id="docrowtr${z3}">
                <td style="font-weight:bold;width:3%;text-align:center;">${x3}</td>
                <td style="display:none;"><input type="hidden" name="docrow[${z3}][docvals]" id="docvals${z3}" class="docvals form-control" readonly="true" style="font-weight:bold;" value="${z3}"/></td>
                <td style="width:22%;"><select id="document_type${z3}" class="select2 form-control document_type" onchange="docTypeFn(this)" name="docrow[${z3}][document_type]"></select></td>
                <td style="width:22%;"><input type="text" id="upload_date${z3}" name="docrow[${z3}][upload_date]" class="form-control upload_date${z3}" placeholder="YYYY-MM-DD" readonly onchange="uploadDateFn(this)"/></td>
                <td style="width:25%;">
                    <div class="input-group">
                        <input class="form-control fileuploads" type="file" id="doc_upload${z3}" name="docrow[${z3}][doc_upload]" onchange="docmntUploadFn(this)" accept=".jpg, .jpeg, .png,.pdf" style="width:90%;">
                        <button type="button" id="doc_view${z3}" class="btn btn-light btn-sm doc_view" onclick="previewDocFn(this,'doc')" style="color:#00cfe8;background-color:#FFFFFF;border-color:#FFFFFF;padding: 1px 1px;width:9%;display:none;" title="Open uploaded document"><i class="fas fa-eye fa-lg" aria-hidden="true"></i></button>
                        <input type="hidden" class="form-control" name="docrow[${z3}][documents]" id="documents${z3}"/>
                        <input type="hidden" class="form-control" name="docrow[${z3}][doc_upload_hidden]" id="doc_upload_hidden${z3}"/>
                    <div>
                </td>
                <td style="width:25%;"><input type="text" name="docrow[${z3}][doc_remark]" id="cont_remark${z3}" class="cont_remark form-control" placeholder="Write Remark here..."/></td>
                <td style="width:3%;text-align:center;"><button type="button" id="remove_doc_btn${z3}" class="btn btn-light btn-sm remove_doc_btn" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF;padding: 1px 1px"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>
            </tr>`);

            var default_option = `<option selected disabled value=""></option>`;
            var doc_type_opt = $("#doc_type_default > option").clone();
            $(`#document_type${z3}`).append(doc_type_opt);
            $(`#document_type${z3}`).append(default_option);
            $(`#document_type${z3}`).val(null).select2
            ({
                placeholder: "Select type here...",
                dropdownCssClass : 'cusprop',
            });

            renumberDocRows();
            flatpickr(`#upload_date${z3}`, { dateFormat: 'Y-m-d',allowInput: true,clickOpens:true,minDate:default_date,maxDate:currdate});
            $(`#select2-document_type${z3}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
            $("#docmnt-doc-error").html("");
        });

        function renumberDocRows() {
            var ind;
            $('#documentDynamicTable tr').each(function(index, el) {
                $(this).children('td').first().text(index++);
                ind = index - 1;
            });
        }

        $(document).on('click', '.remove_doc_btn', function() {
            $(this).parents('tr').remove();
            var last_row_id = $('#documentDynamicTable > tbody tr:last').find('td').eq(1).find('input').val();
            renumberDocRows();
            --x3;
        });

        function docmntUploadFn(ele) {
            var cont_val = $(ele).closest('tr').find('.docvals').val();
            $(`#doc_view${cont_val}`).show();
            $(`#doc_upload${cont_val}`).css("background","white");
            $(`#doc_upload_hidden${cont_val}`).val(cont_val);
        }

        function uploadDateFn(ele) {
            var cont_val = $(ele).closest('tr').find('.docvals').val();
            $(`#upload_date${cont_val}`).css("background","white");
        }

        function docTypeFn(ele) {
            var doc_indx = $(ele).closest('tr').find('.docvals').val();
            $(`#select2-document_type${doc_indx}-container`).parent().css({"background-color":"white","position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
        }

        function previewDocFn(ele,type) {
            var indx = "";
            var rec_id = "";
            var file_name = "";
            var file_inp = "";
            var document_folder = "";
            if(type == "doc"){
                indx = $(ele).closest('tr').find('.docvals').val();
                rec_id = $(`#documents${indx}`).val();
                file_name = $(`#documents${indx}`).val();
                file_inp = `doc_upload${indx}`;
                document_folder = "ResumeAndOther";
            }
            if(type == "con"){
                indx = $(ele).closest('tr').find('.contvals').val();
                rec_id = $(`#contracts${indx}`).val();
                file_name = $(`#contracts${indx}`).val();
                file_inp = `cont_document${indx}`;
                document_folder = "Contracts";
            }
             
            const features = 'width=1000,height=700,scrollbars=yes,resizable=yes,location=yes,toolbar=yes,menubar=yes';

            // =========================
            // ADD / CREATE MODE
            // =========================
            if (!rec_id) {

                const fileInput = $(`#${file_inp}`)[0];

                if (!fileInput || !fileInput.files || fileInput.files.length === 0) {
                    toastrMessage('error', 'Please select a file first!', 'Error');
                    return;
                }

                const file = fileInput.files[0];

                const isImage = file.type.startsWith('image/');
                const isPDF   = file.type === 'application/pdf';

                if (!isImage && !isPDF) {
                    toastrMessage('error', 'Only PDF and Image files can be opened in new window!', 'Error');
                    return;
                }

                const blobUrl = URL.createObjectURL(file);
                window.open(blobUrl, '_blank', features);

                setTimeout(() => URL.revokeObjectURL(blobUrl), 10000);
                return;
            }

            // =========================
            // EDIT MODE
            // =========================
            if (!file_name) {
                toastrMessage('error', 'No file found!', 'Error');
                return;
            }

            const filePath = `/storage/uploads/EmployeeDocumets/${document_folder}/${file_name}`;
            window.open(filePath, '_blank', features);
        }

        function previewGuarFn() {

            const rec_id    = $('#recId').val();
            const file_name = $('#GuarantorFileName').val();

            const features = 'width=1000,height=700,scrollbars=yes,resizable=yes,location=yes,toolbar=yes,menubar=yes';

            // =========================
            // ADD / CREATE MODE
            // =========================
            if (!rec_id) {

                const fileInput = $('#guarantorFile')[0];

                if (!fileInput || !fileInput.files || fileInput.files.length === 0) {
                    toastrMessage('error', 'Please select a file first!', 'Error');
                    return;
                }

                const file = fileInput.files[0];

                const isImage = file.type.startsWith('image/');
                const isPDF   = file.type === 'application/pdf';

                if (!isImage && !isPDF) {
                    toastrMessage('error', 'Only PDF and Image files can be opened in new window!', 'Error');
                    return;
                }

                const blobUrl = URL.createObjectURL(file);
                window.open(blobUrl, '_blank', features);

                setTimeout(() => URL.revokeObjectURL(blobUrl), 10000);
                return;
            }

            // =========================
            // EDIT MODE
            // =========================
            if (!file_name) {
                toastrMessage('error', 'No file found!', 'Error');
                return;
            }

            const filePath = `/storage/uploads/EmployeeDocumets/GuarantorDocument/${file_name}`;
            window.open(filePath, '_blank', features);
        }

        function showGuarLetterFn(){
            $("#preview_guar_file").show();
            $("#guarantorBtn").show();
            $("#GuarantorFileName").val("Guarantor");
        }

        function guarantorBtnDocFn(){
            $("#preview_guar_file").hide();
            $("#guarantorBtn").hide();
            $("#GuarantorFileName").val("");
            $("#guarantorFile").val("");
        }

        //--------------Dynamic document end-------------------

        //---------------- Leave Allocation Start-----------------
        function leaveAllocFn(recordId){
            $('#defaultyear').empty();
            $('#leaveAllocDiv').hide();
            $(".actionpropbtn").hide();
            $.ajax({
                type: "get",
                url: "{{url('showemployee')}}"+'/'+recordId,
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
                    $('#allocEmployeeId').val(recordId);
                    $('#leaveFormEmpId').val(recordId);
                    $.each(data.employeedata, function(key, value) {
                        $('#employeenameleavealloc').html(`${value.emp_title} ${value.name}`);
                        $('#branchleavealloc').html(`<i class="fas fa-location-dot"></i> ${value.BranchName}`);
                        $('#departmentleavealloc').html(`<i class="fa-solid fa-landmark"></i> ${value.DepartmentName}`);
                        $('#positionleavealloc').html(`<i class="fa-solid fa-up-down-left-right"></i> ${value.PositionName}`);
                    
                        if(value.ActualPicture!=null || value.BiometricPicture!=null){
                            $('#employeepicleavealloc').attr("src",value.ActualPicture!=null ? `../../../storage/uploads/HrEmployee/${value.ActualPicture}` : `../../../storage/uploads/BioEmployee/${value.BiometricPicture}`);
                        }
                        if(value.ActualPicture==null && value.BiometricPicture===null){
                            $('#employeepicleavealloc').attr("src","../../../storage/uploads/HrEmployee/dummypic.jpg");
                        }

                        $("#leavealloc").html(value.Status == "Active" ? `<b style='color:#1cc88a'>${value.EmployeeID}, ${value.Status}</b>` : `<b style='color:#e74a3b'>${value.EmployeeID}, ${value.Status}</b>`);
                    });

                    $.each(data.years, function(key, value) {
                        $('#defaultyear').append(`<option value='${value.value}'>${value.label}</option>`);
                    });
                    var defaultoption = '<option selected disabled value=""></option>';
                    $('#defaultyear').append(defaultoption);
                    $('#defaultyear').select2();
                }
            });
            countEmpLeaveAndSalaryFn(recordId);
            empAllocList(recordId);
        }

        function empAllocList(recordId){
            var empid = "";
            $('#leavealloctable').DataTable({
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
                "dom": "<'row'<'col-sm-3 col-md-2 col-4'f><'col-lg-2 col-md-2 col-xs-8'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                   "<'row'<'col-sm-4 col-md-4 col-4'l><'col-sm-4 col-md-4 col-4 d-flex justify-content-center'i><'col-sm-4 col-md-4 col-4 d-flex justify-content-end'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{url('showEmployeeLeaveAlloc')}}",
                    type: 'POST',
                    data:{
                        empid: recordId,
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
                        data: 'LeaveAllocationNo',
                        name: 'LeaveAllocationNo',
                        width:"24%"
                    },
                    {
                        data: 'Type',
                        name: 'Type',
                        width:"23%"
                    },
                    {
                        data: 'Date',
                        name: 'Date',
                        width:"23%"
                    },
                    {
                        data: 'DisplayStatus',
                        name: 'DisplayStatus',
                        "render": function ( data, type, row, meta ) {
                            if(data == "Draft"){
                                return `<span class="badge bg-secondary bg-glow">${data}</span>`;
                            }
                            else if(data == "Pending"){
                                return `<span class="badge bg-warning bg-glow">${data}</span>`;
                            }
                            else if(data == "Verified"){
                                return `<span class="badge bg-primary bg-glow">${data}</span>`;
                            }
                            else if(data == "Approved"){
                                return `<span class="badge bg-success bg-glow">${data}</span>`;
                            }
                            else if(data == "Void" || data == "Void(Draft)" || data == "Void(Pending)" || data == "Void(Verified)" || data == "Void(Approved)"){
                                return `<span class="badge bg-danger bg-glow">${data}</span>`;
                            }
                            else{
                                return `<span class="badge bg-dark bg-glow">${data}</span>`;
                            }
                        },
                        width:"23%"
                    },
                    { data: 'action', name: 'action',
                        "render": function ( data, type, row, meta ) {
                            return `<div class="text-center"><a class="infoLeaveAlloc" href="javascript:void(0)" onclick="infoLeaveAllocFn(${row.id})" data-id="infoLeaveAlloc${row.id}" id="infoLeaveAlloc${row.id}" title="Open information page"><i class="fa-sharp fa-regular fa-circle-info fa-xl" style="color: #00cfe8;"></i></a></div>`;
                        },
                        width:'4%'
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
                    $('#leaveAllocDiv').show();
                },
            });
            $("#manageleaveallocmodal").modal('show');
        }

        $('#addleavealloc').click(function(){
            $("#leavealloctbl > tbody").empty();
            $('.dataclass').html("");
            $('#leaveallocstatus').html("");
            $('#allocRecId').val("");
            $('#allocOperationType').val(1);
            $('#saveleaveallocbtn').text('Save');
            $('#saveleaveallocbtn').prop("disabled",false);
            $("#leavealloctitle").html("Add Leave Allocation");
            $("#leaveallocformmodal").modal('show');
        });

        $("#leaveadds").click(function() {
            ++i;
            ++m;
            j += 1;

            $("#leavealloctbl > tbody").append(`<tr>
                <td style="font-weight:bold;text-align:center;width:3%">${j}</td>
                <td style="display:none;"><input type="hidden" name="leaverow[${m}][vals]" id="vals${m}" class="vals form-control" readonly="true" style="font-weight:bold;" value="${m}"/></td>
                <td style="width:19%"><select id="leavetype${m}" class="select2 form-control leavetype" onchange="leavetypeFn(this)" name="leaverow[${m}][LeaveType]"></select></td> 
                <td style="width:19%;"><input type="text" placeholder="Leave payment type" id="LeavePaymentType${m}" class="LeavePaymentType form-control" name="leaverow[${m}][LeavePaymentType]" readonly/></td>
                <td style="width:18%"><select id="leaveyear${m}" class="select2 form-control leaveyear" onchange="leaveyearFn(this)" name="leaverow[${m}][Year]"></select></td> 
                <td style="width:18%"><input type="number" placeholder="Leave Balance" id="leavebalance${m}" class="leavebalance form-control numeral-mask" name="leaverow[${m}][LeaveBalance]" onkeyup="TotalLeaveBalanceFn(this)" onkeypress="return ValidateNum(event);"/></td>
                <td style="width:19%;"><input type="text" placeholder="Write remark here..." id="Remark${m}" class="Remark form-control" name="leaverow[${m}][Remark]"/></td>
                <td style="width:4%;text-align:center;"><button type="button" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>
            </tr>`);

            var defaultoption = '<option selected disabled value=""></option>';
            var leavetypelist = $("#defaultleavetype > option").clone();
            $(`#leavetype${m}`).append(leavetypelist);
            $(`#leavetype${m}`).append(defaultoption);
            $(`#leavetype${m}`).select2({placeholder: "Select leave type here",dropdownCssClass : 'cusprop'});

            var yearlist = $("#defaultyear > option").clone();
            $(`#leaveyear${m}`).append(yearlist);
            $(`#leaveyear${m}`).append(defaultoption);
            $(`#leaveyear${m}`).select2({placeholder: "Select year here",dropdownCssClass : 'cusprop'});

            $(`#select2-leavetype${m}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
            $(`#select2-leaveyear${m}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
            $("#table-error").html("");
            renumberRows();
        });

        $(document).on('click', '.remove-tr', function() {
            $(this).parents('tr').remove();
            TotalLeaveBalanceFn(this);
            renumberRows();
            --i;
        });

        function renumberRows() {
            $('#leavealloctbl > tbody > tr').each(function(index, el) {
                $(this).children('td').first().text(++index);
            });
        }

        function leavetypeFn(ele){
            var idval = $(ele).closest('tr').find('.vals').val();
            var leavetypeval = $(`#leavetype${idval}`).val();
            var leaveyear = $(`#leaveyear${idval}`).val();
            var leavepaymenttype = $(`#defaultleavetype option[value="${leavetypeval}"]`).attr('data-ptype');

            if (isDuplicateCombination(leavetypeval, leaveyear, idval)) {
                $(`#leavetype${idval}`).val(null).trigger('change').select2
                ({
                    placeholder: "Select leave type here",
                });
                toastrMessage('error',"Duplicate leave type found with year","Error");
                $(`#select2-leavetype${idval}-container`).parent().css('background-color',errorcolor);
            }
            else{
                if(parseInt(leavetypeval) == parseInt(anualleaveid)){
                    $(`#leaveyear${idval} option[value="-"]`).remove(); 
                }
                else{
                    $(`#leaveyear${idval} option[value="-"]`).remove(); 
                    $(`#leaveyear${idval}`).append('<option value="-">-</option>');
                }
                $(`#LeavePaymentType${idval}`).val(leavepaymenttype);
                $(`#select2-leavetype${idval}-container`).parent().css('background-color',"white");
            }
        }

        function leaveyearFn(ele){
            var idval = $(ele).closest('tr').find('.vals').val();
            var leavetypeval = $(`#leavetype${idval}`).val();
            var leaveyear = $(`#leaveyear${idval}`).val();

            if (isDuplicateCombination(leavetypeval, leaveyear, idval)) {
                $(`#leaveyear${idval}`).val(null).trigger('change').select2
                ({
                    placeholder: "Select year here",
                });
                toastrMessage('error',"Duplicate year found with leave type","Error");
                $(`#select2-leaveyear${idval}-container`).parent().css('background-color',errorcolor);
            }
            else{
                $(`#select2-leaveyear${idval}-container`).parent().css('background-color',"white");
            }
        }

        function TotalLeaveBalanceFn(ele){
            var totalleave=0;
            var idval = $(ele).closest('tr').find('.vals').val();
            $.each($('#leavealloctbl').find('.leavebalance'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    totalleave += parseFloat($(this).val());
                }
            });
            $(`#leavebalance${idval}`).css("background","#FFFFFF");
            $('#totalleavebalance').html(parseFloat(totalleave) <= 0 ? '' : `${totalleave} day(s)`);
        }

        function isDuplicateCombination(firstValue, secondValue, currentRow) {
            if (!firstValue || !secondValue) {
                return false; // Skip check if either value is empty
            }

            let isDuplicate = false;
            let count = 0;

            $('#leavealloctbl > tbody > tr').each(function () {
                if ($(this).is(currentRow)) return;

                let first = $(this).find('.leavetype').val();
                let second = $(this).find('.leaveyear').val();

                if (first === firstValue && second === secondValue) {
                    count++;
                }
            });

            return count > 1;
        }

        $(document).on('keypress', '.leavebalance', function () {
            const char = String.fromCharCode(e.which);

            // Allow only digits and one dot
            if (!/[0-9.]/.test(char)) {
                e.preventDefault();
            }

            // Prevent multiple dots
            if (char === '.' && $(this).val().includes('.')) {
                e.preventDefault();
            }
        });

        // Final validation on blur
        $(document).on('blur', '.leavebalance', function () {
            const val = $(this).val();
            const num = parseFloat(val);

            // Allow empty
            if (val === '') return;

            // Allow whole numbers and .5 fractions
            const isValid = Number.isInteger(num) || (num % 1 === 0.5);

            if (!isValid) {
                $(this).val("");
                toastrMessage('error',"Only natural numbers or X.5 values are allowed","Error");
                TotalLeaveBalanceFn(this);
                $(this).css("background",errorcolor);
            }
        });

        $('#saveleaveallocbtn').click(function() {
            var optype = $("#allocOperationType").val();
            var registerForm = $("#LeaveAllocationForm");
            var formData = registerForm.serialize();
            var rec_id = $("#allocRecId").val();
            var emp_id = $("#allocEmployeeId").val();
            $.ajax({
                url: "{{url('saveLeaveAllocation')}}",
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
                        $('#saveleaveallocbtn').text('Saving...');
                        $('#saveleaveallocbtn').prop("disabled", true);
                    }
                    else if(parseFloat(optype)==2){
                        $('#saveleaveallocbtn').text('Updating...');
                        $('#saveleaveallocbtn').prop("disabled", true);
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
                    if(data.errorsv2){
                        $('#leavealloctbl > tbody > tr').each(function () {
                            let leavetype = $(this).find('.leavetype').val();
                            let leaveyear = $(this).find('.leaveyear').val();
                            let leavebalance = $(this).find('.leavebalance').val();
                            let rowind = $(this).find('.vals').val();

                            if(isNaN(parseFloat(leavetype))||parseFloat(leavetype)==0){
                                $(`#select2-leavetype${rowind}-container`).parent().css('background-color',errorcolor);
                            }
                            if(isNaN(parseFloat(leaveyear))||parseFloat(leaveyear)==0){
                                $(`#select2-leaveyear${rowind}-container`).parent().css('background-color',errorcolor);
                            }
                            if(leavebalance != undefined){
                                if(isNaN(parseFloat(leavebalance))||parseFloat(leavebalance)==0){
                                    $(`#leavebalance${rowind}`).css("background", errorcolor);
                                }
                            }
                        });

                        if(parseFloat(optype)==1){
                            $('#saveleaveallocbtn').text('Save');
                            $('#saveleaveallocbtn').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#saveleaveallocbtn').text('Update');
                            $('#saveleaveallocbtn').prop("disabled", false);
                        }
                        toastrMessage('error',"Please insert valid data on highlighted fields!","Error");
                    }
                    else if(data.emptyerror){
                        if(parseFloat(optype)==1){
                            $('#saveleaveallocbtn').text('Save');
                            $('#saveleaveallocbtn').prop("disabled",false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#saveleaveallocbtn').text('Update');
                            $('#saveleaveallocbtn').prop("disabled",false);
                        }
                        $("#table-error").html("Please add leave type here");
                        toastrMessage('error',"Please add atleast one leave type","Error");
                    } 
                    else if(data.duplicaterr){
                        if(parseFloat(optype)==1){
                            $('#saveleaveallocbtn').text('Save');
                            $('#saveleaveallocbtn').prop("disabled",false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#saveleaveallocbtn').text('Update');
                            $('#saveleaveallocbtn').prop("disabled",false);
                        }
                        toastrMessage('error',"Duplicate leave type and year found </br>----------------</br>"+data.errors,"Error");
                        
                    } 
                    else if(data.negerror){
                        $.each(data.rowids, function(index, rowno) {
                            $(`#select2-leavetype${rowno}-container`).parent().css('background-color',errorcolor);
                            $(`#select2-leaveyear${rowno}-container`).parent().css('background-color',errorcolor);
                            $(`#leavebalance${rowno}`).css("background", errorcolor);
                        });

                        if(parseFloat(optype)==1){
                            $('#saveleaveallocbtn').text('Save');
                            $('#saveleaveallocbtn').prop("disabled",false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#saveleaveallocbtn').text('Update');
                            $('#saveleaveallocbtn').prop("disabled",false);
                        }
                        toastrMessage('error',"The highlighted record cannot be edited because it has dependent records linked to it","Error");
                    } 
                    else if (data.dberrors) {
                        if(parseFloat(optype)==1){
                            $('#saveleaveallocbtn').text('Save');
                            $('#saveleaveallocbtn').prop("disabled",false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#saveleaveallocbtn').text('Update');
                            $('#saveleaveallocbtn').prop("disabled",false);
                        }
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if(data.success){
                        if(parseFloat(optype)==1){
                            $('#saveleaveallocbtn').text('Save');
                            $('#saveleaveallocbtn').prop("disabled",false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#saveleaveallocbtn').text('Update');
                            $('#saveleaveallocbtn').prop("disabled",false);
                            createLeaveAllocInfoFn(rec_id);
                        }
                        toastrMessage('success',"Successful","Success");
                        countEmpLeaveAndSalaryFn(emp_id);
                        var oTable = $('#leavealloctable').dataTable();
                        oTable.fnDraw(false);
                        $("#leaveallocformmodal").modal('hide');
                    }
                }
            });
        });

        function infoLeaveAllocFn(recordId){
            createLeaveAllocInfoFn(recordId);
            $("#leaveallocinfomodal").modal('show');
        }

        function createLeaveAllocInfoFn(recordId){
            var colors = "";
            var lidata = "";
            var action_links = "";
            var major_btn_link = `<li><hr class="dropdown-divider"></li>`;
            var status_btn_link = `<li><hr class="dropdown-divider"></li>`;
            var edit_link = `
                @can("Leave-Allocation-Edit")
                <li>
                    <a class="dropdown-item editLeaveAlloc" onclick="editLeaveAllocFn(${recordId})" data-id="editLeaveAlloc${recordId}" id="editLeaveAlloc${recordId}" title="Edit record">
                    <span><i class="fa-solid fa-pencil"></i> Edit</span>  
                    </a>
                </li>
                @endcan`;
            
            var void_link = `
                @can("Leave-Allocation-Void")
                <li>
                    <a class="dropdown-item voidLeaveAlloc" onclick="voidLeaveAllocFn(${recordId},0)" data-id="voidLeaveAlloc${recordId}" id="voidLeaveAlloc${recordId}" title="Void record">
                    <span><i class="fa-solid fa-ban"></i> Void</span>  
                    </a>
                </li>
                @endcan`;

            var undovoid_link = `
                @can("Leave-Allocation-Void")
                <li>
                    <a class="dropdown-item undoVoidLeaveAlloc" onclick="undoVoidLeaveAllocFn(${recordId},0)" data-id="undoVoidLeaveAlloc${recordId}" id="undoVoidLeaveAlloc${recordId}" title="Undo void record">
                    <span><i class="fa fa-undo"></i> Undo Void</span>  
                    </a>
                </li>
                @endcan`;

            var change_to_pending_link = `
                @can("Leave-Allocation-ChangeToPending")
                <li>
                    <a class="dropdown-item changetopending" onclick="forwardLeaveFn()" id="changetopending" title="Change record to pending">
                    <span><i class="fa-solid fa-forward"></i> Change to Pending</span>  
                    </a>
                </li>
                @endcan`;

            var back_to_draft_link = `
                @can("Leave-Allocation-ChangeToPending")
                <li>
                    <a class="dropdown-item leavebackward" id="backtodraft" title="Change record to draft">
                    <span><i class="fa-solid fa-backward"></i> Back to Draft</span>  
                    </a>
                </li>
                @endcan`;

            var verify_link = `
                @can("Leave-Allocation-Verify")
                <li>
                    <a class="dropdown-item verifyleavealloc" onclick="forwardLeaveFn()" id="verifyleavealloc" title="Change record to verified">
                    <span><i class="fa-solid fa-forward"></i> Verify</span>  
                    </a>
                </li>
                @endcan`;

            var back_to_pending = `
                @can("Leave-Allocation-Verify")
                <li>
                    <a class="dropdown-item leavebackward" id="backtopending" title="Change record to pending">
                    <span><i class="fa-solid fa-backward"></i> Back to Pending</span>  
                    </a>
                </li>
                @endcan`;

            var approve_link = `
                @can("Leave-Allocation-Approve")
                <li>
                    <a class="dropdown-item approveleavealloc" onclick="forwardLeaveFn()" id="approveleavealloc" title="Change record to approved">
                    <span><i class="fa-solid fa-forward"></i> Approve</span>  
                    </a>
                </li>
                @endcan`;

            var back_to_verify_link = `
                @can("Leave-Allocation-Approve")
                <li>
                    <a class="dropdown-item leavebackward" id="backtoverify" title="Change record to verified">
                    <span><i class="fa-solid fa-backward"></i> Back to Verify</span>  
                    </a>
                </li>
                @endcan`;

            $('#leaveallocTblDiv').hide();
            $.ajax({
                type: "get",
                url: "{{url('showleavealloc')}}"+'/'+recordId,
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
                    $('#allocDetRecId').val(recordId);
                    $(".actionpropbtn").hide();
                    $.each(data.allocdata, function(key, value) {
                        $("#leavealloctypelbl").html(value.Type);
                        $("#leaveallocdate").html(value.Date);
                        $("#recordCountVal").val(value.RecordCount);
                        $("#la_currentStatus").val(value.Status);
                        $("#allocEmpId").val(value.employees_id);
                    
                        if(value.Status === "Draft"){
                            major_btn_link += edit_link;
                            major_btn_link += void_link;

                            status_btn_link += change_to_pending_link;
                            colors = "#A8AAAE";
                        }
                        else if(value.Status === "Pending"){
                            major_btn_link += edit_link;
                            major_btn_link += void_link;

                            status_btn_link += back_to_draft_link;
                            status_btn_link += verify_link;
                            colors = "#f6c23e";
                        }
                        else if(value.Status === "Verified"){
                            major_btn_link += edit_link;
                            major_btn_link += void_link;

                            status_btn_link += approve_link;
                            status_btn_link += back_to_pending;
                            colors = "#7367F0";
                        }
                        else if(value.Status === "Approved"){
                            major_btn_link = "";
                            major_btn_link = "";

                            status_btn_link = "";
                            colors = "#1cc88a";
                        }
                        else if(value.Status === "Void"){
                            major_btn_link += undovoid_link;
                            status_btn_link = "";
                            colors = "#e74a3b";
                        }
                        else{
                            $("#changetopending").hide();
                            $("#verifyleavealloc").hide();
                            $("#approveleavealloc").hide();
                            major_btn_link = "";
                            status_btn_link = "";
                            colors = "#e74a3b";
                        }
                        $("#leaveallocinfostatus").html(`<span class="form_title" style='color:${colors};font-weight:bold;text-shadow;1px 1px 10px ${colors};font-size:16px;'>${value.LeaveAllocationNo},     ${value.Status}</span>`);
                        $("#action-log-status-lbl").html(`<span class="form_title" style='color:${colors};font-weight:bold;text-shadow;1px 1px 10px ${colors};font-size:13px;'>${value.LeaveAllocationNo},     ${value.Status}</span>`);
                    });

                    $.each(data.activitydata, function(key, value) {
                        var classes = "";
                        var reasonbody = "";
                        if(value.action == "Edited" || value.action == "Change to Pending"){
                            classes = "warning";
                        }
                        else if(value.action == "Verified"){
                            classes = "primary";
                        }
                        else if(value.action == "Back to Draft" || value.action == "Undo Void" || value.action == "Back to Pending" || value.action == "Back to Verify"){
                            classes = "secondary";
                        }
                        else if(value.action == "Created" || value.action == "Approved"){
                            classes = "success";
                        }
                        else if(value.action == "Void"){
                            classes = "danger";
                        }

                        if(value.reason != null && value.reason != ""){
                            reasonbody = `</br><span class="text-muted"><b>Reason:</b> ${value.reason}</span>`;
                        }
                        else{
                            reasonbody = "";
                        }
                        lidata += `<li class="timeline-item"><span class="timeline-point timeline-point-${classes} timeline-point-indicator"></span><div class="timeline-header mb-sm-0 mb-0"><h6 class="mb-0">${value.action}</h6><span class="text-muted"><i class="fa-regular fa-user"></i> ${value.FullName}</span>${reasonbody}</br><span class="text-muted"><i class="fa-regular fa-clock"></i> ${value.time}</span></div></li>`;
                    });
                    $('#leaveallocactiondiv').empty().append(lidata);
                    $("#universal-action-log-canvas").empty().append(lidata);

                    action_links = `
                        <li>
                            <a class="dropdown-item viewLeaveAllocAction" onclick="viewLeaveAllocFn(${recordId})" data-id="view_leavealloc_actionbtn${recordId}" id="view_leavealloc_actionbtn${recordId}" title="View user log">
                            <span><i class="fa-solid fa-eye"></i> View User Log</span>  
                            </a>
                        </li>
                        ${major_btn_link}
                        ${status_btn_link}`;

                    $("#leave_alloc_action_ul").empty().append(action_links);
                }
            });

            showDetailAllocData(recordId);
            $(".infoleavealloc").collapse('show');
        }

        function showDetailAllocData(recordId){
            $('#leaveallocTbl').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                paging:false,
                searching:true,
                info:false,
                searchHighlight: true,
                "order": [[ 0, "asc" ]],
                "pagingType": "simple",
                language: { search: '', searchPlaceholder: "Search here"},
                "dom": "<'row'<'col-sm-3 col-md-2 col-4'f><'col-lg-2 col-md-2 col-xs-8'>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-12'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-12'p>>",
                ajax: {
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/showEmpLeaveAlloc/'+recordId,
                    type: 'POST',
                    dataType: "json",
                    
                },
                columns: [
                    { data:'DT_RowIndex', width:'3%'},
                    { data: 'LeaveType', name: 'LeaveType', width:'20%'},
                    { data: 'LeavePaymentType', name: 'LeavePaymentType', width:'19%'},
                    { data: 'Year', name: 'Year', width:'19%'},
                    { data: 'LeaveBalance', name: 'LeaveBalance', width:'19%'},
                    { data: 'Remark', name: 'Remark', width:'20%'},    
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

                    var totaldays = api
                    .column(4)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    $('#totaldaysLbl').html(parseFloat(totaldays) <= 0 ? '' : `${totaldays} day(s)`);
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
                    $('#leaveallocTblDiv').show();
                },
            });
        }

        function viewLeaveAllocFn(recordId){
            $("#action-log-title").html("Leave Allocation Setup → User Log Information");
            $("#action-log-universal-modal").modal('show');
        }

        function editLeaveAllocFn(recordId){
            var colors="";
            $('.dataclass').html("");
            $('#allocOperationType').val(2);

            $.ajax({
                type: "get",
                url: "{{url('showleavealloc')}}"+'/'+recordId,
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
                complete: function() {
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
                    $('#allocRecId').val(recordId);
                    $("#leavealloctbl > tbody").empty();
                    $.each(data.allocdata, function(key, value) {
                        if(value.Status === "Draft"){
                            colors = "#A8AAAE";
                        }
                        else if(value.Status==="Pending"){
                            colors = "#f6c23e";
                        }
                        else if(value.Status==="Verified"){
                            colors = "#7367F0";
                        }
                        else if(value.Status==="Approved"){
                            colors = "#1cc88a";
                        }
                        else{
                            colors = "#e74a3b";
                        }
                        $("#leaveallocstatus").html(`<span style='color:${colors};font-weight:bold;text-shadow;1px 1px 10px ${colors};font-size:16px;'>${value.LeaveAllocationNo},     ${value.Status}</span>`);
                    });

                    $.each(data.leavetypedata, function(key, value) {
                        ++i;
                        ++j;
                        ++m;

                        $("#leavealloctbl > tbody").append(`<tr>
                            <td style="font-weight:bold;text-align:center;width:3%">${j}</td>
                            <td style="display:none;"><input type="hidden" name="leaverow[${m}][vals]" id="vals${m}" class="vals form-control" readonly="true" style="font-weight:bold;" value="${m}"/></td>
                            <td style="width:19%"><select id="leavetype${m}" class="select2 form-control leavetype" onchange="leavetypeFn(this)" name="leaverow[${m}][LeaveType]"></select></td> 
                            <td style="width:19%;"><input type="text" placeholder="Leave payment type" id="LeavePaymentType${m}" class="LeavePaymentType form-control" name="leaverow[${m}][LeavePaymentType]" readonly/></td>
                            <td style="width:18%"><select id="leaveyear${m}" class="select2 form-control leaveyear" onchange="leaveyearFn(this)" name="leaverow[${m}][Year]"></select></td> 
                            <td style="width:18%"><input type="number" placeholder="Leave Balance" id="leavebalance${m}" class="leavebalance form-control numeral-mask" name="leaverow[${m}][LeaveBalance]" value="${value.LeaveBalance}" onkeyup="TotalLeaveBalanceFn(this)" onkeypress="return ValidateNum(event);"/></td>
                            <td style="width:19%;"><input type="text" placeholder="Write remark here..." id="Remark${m}" class="Remark form-control" name="leaverow[${m}][Remark]" value="${value.Remark}"/></td>
                            <td style="width:4%;text-align:center;"><button id="remove-btn${m}" type="button" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF;display:none;"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>
                        </tr>`);

                        var defaultleavetype = `<option selected value="${value.hr_leavetypes_id}">${value.LeaveType}</option>`;
                        var defaultyear = `<option selected value="${value.Year}">${value.Year}</option>`;
                        var leavepaymenttype = $(`#defaultleavetype option[value="${value.hr_leavetypes_id}"]`).attr('data-ptype');

                        if(parseInt(value.RecordCount) == 0){
                            var leavetypelist = $("#defaultleavetype > option").clone();
                            $(`#leavetype${m}`).append(leavetypelist);
                            $(`#leavetype${m} option[value="${value.hr_leavetypes_id}"]`).remove(); 

                            var yearlist = $("#defaultyear > option").clone();
                            $(`#leaveyear${m}`).append(yearlist);
                            $(`#leaveyear${m} option[value="${value.Year}"]`).remove(); 
                            $(`#remove-btn${m}`).show();
                        }
                        $(`#leavetype${m}`).append(defaultleavetype);
                        $(`#leavetype${m}`).select2({placeholder: "Select leave type here"});

                        $(`#leaveyear${m}`).append(defaultyear);
                        $(`#leaveyear${m}`).select2({placeholder: "Select year here"});
                        $(`#LeavePaymentType${m}`).val(leavepaymenttype);

                        $(`#select2-leavetype${m}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                        $(`#select2-leaveyear${m}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                        TotalLeaveBalanceFn(m);
                        renumberRows();
                    });
                }
            });
            $('#saveleaveallocbtn').text('Update');
            $('#saveleaveallocbtn').prop("disabled",false);
            $("#leavealloctitle").html("Edit Leave Allocation");
            $("#leaveallocformmodal").modal('show');
        }

        function voidLeaveAllocFn(recordId,recordCount){
            if(parseInt(recordCount) > 0){
                toastrMessage('error',"This record cannot be voided because it has dependent records linked to it","Error");
            }
            else if(parseInt(recordCount) == 0){
                $('#Reason').val("");
                $('#voidid').val(recordId);
                $('#voidbtn').text('Void');
                $('#voidbtn').prop("disabled",false);
                $("#voidleaveallocmodal").modal('show');
            }
        }

        $('#voidbtn').click(function() {
            var registerForm = $("#voidreasonform");
            var formData = registerForm.serialize();
            var rec_id = $('#voidid').val();
            var emp_id = $('#allocEmpId').val();
            $.ajax({
                url: "{{url('voidLeaveAllocation')}}",
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
                    $('#voidbtn').text('Void');
                    $('#voidbtn').prop("disabled", false);
                },
                success: function(data) {
                    if(data.errors) {
                        if (data.errors.Reason) {
                            $('#void-error').html(data.errors.Reason[0]);
                        }
                        $('#voidbtn').text('Void');
                        $('#voidbtn').prop("disabled", false);
                        toastrMessage('error',"Please check your input","Error");
                    }
                    else if(data.voidError) {
                        $('#voidbtn').text('Void');
                        $('#voidbtn').prop("disabled",false);
                        toastrMessage('error',"Record can not be void because other records are linked with this record","Error");
                    }
                    else if(data.dberrors) {
                        $('#voidbtn').text('Void');
                        $('#voidbtn').prop("disabled",false);
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if(data.success){
                        $('#voidbtn').text('Void');
                        $('#voidbtn').prop("disabled",false);
                        countEmpLeaveAndSalaryFn(emp_id);
                        createLeaveAllocInfoFn(rec_id);
                        toastrMessage('success',"Successful","Success");
                        var oTable = $('#leavealloctable').dataTable();
                        oTable.fnDraw(false);
                        var iTable = $('#info-leavehis-datatable').dataTable();
                        iTable.fnDraw(false);
                        $("#voidleaveallocmodal").modal('hide');
                    }
                }
            });
        });

        function voidReason() {
            $('#void-error').html("");
        }

        function undoVoidLeaveAllocFn1(recordId,recordCount){
            $('#undovoidid').val(recordId);
            $('#undovoidleaveallocbtn').text('Undo Void');
            $('#undovoidleaveallocbtn').prop("disabled",false);
            $("#undovoidmodal").modal('show');
        }

        function undoVoidLeaveAllocFn(recordId,recordCount) { 
            Swal.fire({
                title: confirmation_title,
                text: undo_void_confirmation,
                icon: confirmation_icon,
                showCloseButton: true,
                showCancelButton: true,      
                allowOutsideClick: false,
                confirmButtonText: 'Undo Void',
                cancelButtonText: 'Close',
                customClass: {
                    confirmButton: 'btn btn-info',
                    cancelButton: 'btn btn-danger'
                }
            }).then(function (result) {
                if (result.value) {
                    undoVoidLeaveAllocFnc();
                }
                else if (result.dismiss === Swal.DismissReason.cancel) {}
            });
        }

        function undoVoidLeaveAllocFnc() {
            var deleteForm = $("#LeaveAllocationInfo");
            var formData = deleteForm.serialize();
            var rec_id = $('#allocDetRecId').val();
            var emp_id = $('#allocEmpId').val();
            $.ajax({
                url: '/undoVoidLeaveAlloc',
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
                    $('#undovoidleaveallocbtn').text('Changing...');
                    $('#undovoidleaveallocbtn').prop("disabled", true);
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
                    if(data.duplicaterr){
                        $('#undovoidleaveallocbtn').text('Undo Void');
                        $('#undovoidleaveallocbtn').prop("disabled",false);
                        $("#undovoidmodal").modal('hide');
                        toastrMessage('error',"Duplicate leave type and year found </br>----------------</br>"+data.errors,"Error");
                        
                    } 
                    else if (data.dberrors) {
                        $('#undovoidleaveallocbtn').text('Undo Void');
                        $('#undovoidleaveallocbtn').prop("disabled",false);
                        $("#undovoidmodal").modal('hide');
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if (data.success) {
                        $('#undovoidleaveallocbtn').text('Undo Void');
                        toastrMessage('success',"Successful","Success");
                        countEmpLeaveAndSalaryFn(emp_id);
                        createLeaveAllocInfoFn(rec_id);
                        var oTable = $('#leavealloctable').dataTable();
                        oTable.fnDraw(false);
                        var iTable = $('#info-leavehis-datatable').dataTable();
                        iTable.fnDraw(false);
                        $("#undovoidmodal").modal('hide');
                    }
                }
            });
        }

        function commentValFn() {
            $('#comment-error').html("");
        }

        function forwardLeaveFn() {
            var recordCnt = parseInt($('#recordCountVal').val()) > 0 ? $('#recordCountVal').val() : 0;

            const requestId = $('#allocDetRecId').val();
            const currentStatus = $('#la_currentStatus').val();
            const transition = statusTransitions[currentStatus].forward;

            $('#la_forwardReqId').val(requestId);
            $('#la_newForwardStatusValue').val(transition.status);
            $('#la_forwardActionLabel').html(transition.message);
            $('#la_forwarkBtnTextValue').val(transition.text);
            $('#la_forwardActionBtn').text(transition.text);
            $('#la_forwardActionValue').val(transition.action);

            Swal.fire({
                title: confirmation_title,
                text: transition.message,
                icon: confirmation_icon,
                showCloseButton: true,
                showCancelButton: true,      
                allowOutsideClick: false,
                confirmButtonText: transition.text,
                cancelButtonText: 'Close',
                customClass: {
                    confirmButton: 'btn btn-info',
                    cancelButton: 'btn btn-danger'
                }
            }).then(function (result) {
                if (result.value) {
                    leaveAllocForwardActionFn();
                }
                else if (result.dismiss === Swal.DismissReason.cancel) {}
            });
        }

        function leaveAllocForwardActionFn(){
            var forwardForm = $("#LeaveAllocationInfo");
            var formData = forwardForm.serialize();
            var btntxt = $('#la_forwarkBtnTextValue').val();
            var rec_id = $('#la_forwardReqId').val();
            var emp_id = $('#allocEmpId').val();
            $.ajax({
                url: '/leaveAllocForwardAction',
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
                    else if (data.success) {
                        toastrMessage('success',"Successful","Success");
                        countEmpLeaveAndSalaryFn(emp_id);
                        createLeaveAllocInfoFn(rec_id);
                        var oTable = $('#leavealloctable').dataTable();
                        oTable.fnDraw(false);

                        var iTable = $('#info-leavehis-datatable').dataTable();
                        iTable.fnDraw(false);
                    }
                }
            });
        }

        $(document).on('click', '.leavebackward', function(){
            const requestId = $('#allocDetRecId').val();
            const currentStatus = $('#la_currentStatus').val();

            const transition = $(this).attr('id') == "salrejectbtn" ? statusTransitions[currentStatus].reject : statusTransitions[currentStatus].backward;

            $('#la_backwardReqId').val(requestId);
            $('#la_newBackwardStatusValue').val(transition.status);
            $('#la_backwardActionLabel').html(transition.message);
            $('#la_backwardBtnTextValue').val(transition.text);
            $('#la_backwardActionBtn').text(transition.text);
            $('#la_backwardActionValue').val(transition.action);
            $('#la_CommentOrReason').val("");
            $('#la_commentres-error').html("");
            $('#la_backwardActionModal').modal('show');
        });

        $("#la_backwardActionBtn").click(function() {
            var registerForm = $("#la_backwardActionForm");
            var formData = registerForm.serialize();
            var btntxt = $('#la_backwardBtnTextValue').val();
            var rec_id = $('#la_backwardReqId').val();
            var emp_id = $('#allocEmpId').val();
            $.ajax({
                url: '/leaveAllocBackwardAction',
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

                    $('#la_backwardActionBtn').text('Changing...');
                    $('#la_backwardActionBtn').prop("disabled", true);
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
                    $('#la_backwardActionBtn').text(btntxt);
                    $('#la_backwardActionBtn').prop("disabled", false);
                },
                success: function(data) {
                    if (data.errors) {
                        if (data.errors.la_CommentOrReason[0]) {
                            var text = data.errors.la_CommentOrReason[0];
                            text = text.replace("la  comment or", "");                            
                            $('#la_commentres-error').html(text);
                        }
                        $('#la_backwardActionBtn').text(btntxt);
                        $('#la_backwardActionBtn').prop("disabled",false);
                        toastrMessage('error',"Please check your input","Error");
                    }
                    else if (data.dberrors) {
                        $('#la_backwardActionBtn').text(btntxt);
                        $('#la_backwardActionBtn').prop("disabled",false);
                        $('#la_backwardActionModal').modal('hide');
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if(data.success){
                        toastrMessage('success',"Successful","Success");
                        countEmpLeaveAndSalaryFn(emp_id);
                        createLeaveAllocInfoFn(rec_id);
                        var oTable = $('#leavealloctable').dataTable();
                        oTable.fnDraw(false);

                        var iTable = $('#info-leavehis-datatable').dataTable();
                        iTable.fnDraw(false);
                        $('#la_backwardActionModal').modal('hide');
                    }
                }
            });
        });

        function leaveReasonFn(){
            $('#la_commentres-error').html("");
        }
        //---------------- Leave Allocation End------------------

        //---------------- Payroll Setting Start-----------------

        $('#addsalary').click(function() {   
            $('#UseCustomizedSalary').val(null).select2({placeholder: "Select here",minimumResultsForSearch: -1});
            $('#Salary').val(null).select2({placeholder: "Select Salary here"});

            $('#letter_date').daterangepicker({ 
                singleDatePicker: true,
                showDropdowns: true,
                autoApply: true,
                maxDate: currdate,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });
            $('.emp_reg_form').val("");
            $('.errordatalabel').html("");
            $('.salary_setting_status').html("");
            $("#earningDynamicTable > tbody").empty();
            $("#deductionDynamicTable > tbody").empty();
            appendDefaultSalaryComp();
            salaryLetterBtnDocFn();
            $('#addearningbtn').hide();
            $('#adddeductionbtn').hide();
            $('#salary_sett_title').html("Add Salary");
            $('#savebuttonpayrollsett').text("Save");
            $('#savebuttonpayrollsett').prop("disabled",false);
            $('#salaryOperationType').val(1);
            $('#sal_employee_id').val($('#payrollEmpId').val());
            $("#salarysettingmodal").modal('show');
        });

        function editSalaryFn(recordId){
            var colors = "";
            $.ajax({
                type: "get",
                url: "{{url('showSalaryData')}}"+'/'+recordId,
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
                    $.each(data.saldata, function(key, value) {
                        $('#UseCustomizedSalary').val(value.is_negotiable).select2({minimumResultsForSearch: -1});
                        $('#Salary').val(value.salaries_id).select2();
                        $('#letter_date').val(value.date);
                        $('#salary_remark').val(value.remark);
                        $('#salary_letter_filename').val(value.doc_name);
                        $('#salary_letter_actual_fn').val(value.actual_file_name);
                        $('#EmployeePension').val(value.PensionPercent);
                        $('#CompanyPension').val(value.CompanyPensionPercent);

                        value.is_negotiable == 0 ? $('#salarycontainer').show() : $('#salarycontainer').hide();

                        if(value.doc_name == "" || value.doc_name == null){
                            $('.salary_letter_prop_btn').hide();
                        }
                        else{
                            $('.salary_letter_prop_btn').show();
                        }

                        if(value.status === "Draft"){
                            colors = "#A8AAAE";
                        }
                        else if(value.status === "Pending"){
                            colors = "#f6c23e";
                        }
                        else if(value.status === "Verified"){
                            colors = "#7367F0";
                        }
                        else if(value.status === "Approved"){
                            colors = "#1cc88a";
                        }
                        else{
                            colors = "#e74a3b";
                        }
                        $("#salary_setting_status").html(`<span style='color:${colors};font-weight:bold;text-shadow;1px 1px 10px ${colors};font-size:16px;'>${value.doc_number},     ${value.status}</span>`);
                        
                        salaryFetchFn(value.salaries_id);
                    });
                }
            });
            $('#salarydynamictable').show();
            $('#salary_sett_title').html("Edit Salary");
            $('#savebuttonpayrollsett').text("Update");
            $('#savebuttonpayrollsett').prop("disabled",false);
            $('#salaryInpId').val(recordId);
            $('#salaryOperationType').val(2);
            $('#sal_employee_id').val($('#payrollEmpId').val());
            $("#salarysettingmodal").modal('show');
        }

        function infoSalaryFn(recordId){
            createSalaryInfoFn(recordId);
            $("#salaryinfomodal").modal('show');
        }

        function createSalaryInfoFn(recordId){
            var compPensionPercent = 11;
            var empPensionPercent = 7;
            var totaltaxable = 0;
            var totalnontaxable = 0;
            var totalearning = 0;
            var totaldeduction = 0;
            var netpay = 0;
            var colors = "";
            var lidata = "";
            var action_links = "";
            var major_btn_link = `<li><hr class="dropdown-divider"></li>`;
            var status_btn_link = `<li><hr class="dropdown-divider"></li>`;
            var edit_link = `
                @can("Employee-Salary-Edit")
                <li>
                    <a class="dropdown-item editSalary" onclick="editSalaryFn(${recordId})" data-id="editSalary${recordId}" id="editSalary${recordId}" title="Edit record">
                    <span><i class="fa-solid fa-pencil"></i> Edit</span>  
                    </a>
                </li>
                @endcan`;
            
            var void_link = `
                @can("Employee-Salary-Void")
                <li>
                    <a class="dropdown-item voidSalary" onclick="voidSalaryFn(${recordId})" data-id="voidSalary${recordId}" id="voidSalary${recordId}" title="Void record">
                    <span><i class="fa-solid fa-ban"></i> Void</span>  
                    </a>
                </li>
                @endcan`;

            var undovoid_link = `
                @can("Employee-Salary-Void")
                <li>
                    <a class="dropdown-item undoVoidSalary" onclick="undoVoidFn(${recordId})" data-id="undoVoidSalary${recordId}" id="undoVoidSalary${recordId}" title="Undo void record">
                    <span><i class="fa fa-undo"></i> Undo Void</span>  
                    </a>
                </li>
                @endcan`;

            var change_to_pending_link = `
                @can("Employee-Salary-ChangeToPending")
                <li>
                    <a class="dropdown-item salchangetopending" onclick="forwardActionFn()" id="salchangetopending" title="Change record to pending">
                    <span><i class="fa-solid fa-forward"></i> Change to Pending</span>  
                    </a>
                </li>
                @endcan`;

            var back_to_draft_link = `
                @can("Employee-Salary-ChangeToPending")
                <li>
                    <a class="dropdown-item backwardbtn" id="salbacktodraft" title="Change record to draft">
                    <span><i class="fa-solid fa-backward"></i> Back to Draft</span>  
                    </a>
                </li>
                @endcan`;

            var verify_link = `
                @can("Employee-Salary-Verify")
                <li>
                    <a class="dropdown-item salverifybtn" onclick="forwardActionFn()" id="salverifybtn" title="Change record to verified">
                    <span><i class="fa-solid fa-forward"></i> Verify</span>  
                    </a>
                </li>
                @endcan`;

            var back_to_pending = `
                @can("Employee-Salary-Verify")
                <li>
                    <a class="dropdown-item backwardbtn" id="salbacktopending" title="Change record to pending">
                    <span><i class="fa-solid fa-backward"></i> Back to Pending</span>  
                    </a>
                </li>
                @endcan`;

            var approve_link = `
                @can("Employee-Salary-Approve")
                <li>
                    <a class="dropdown-item salapprovebtn" onclick="forwardActionFn()" id="salapprovebtn" title="Change record to approved">
                    <span><i class="fa-solid fa-forward"></i> Approve</span>  
                    </a>
                </li>
                @endcan`;

            var reject_link = `
                @can("Employee-Salary-Approve")
                <li>
                    <a class="dropdown-item backwardbtn" id="salrejectbtn" title="Change record to rejected">
                    <span><i class="fa-solid fa-ban"></i> Reject</span>  
                    </a>
                </li>
                @endcan`;

            $('.actionpropbtn').hide();
            $.ajax({
                type: "get",
                url: "{{url('showSalaryData')}}"+'/'+recordId,
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
                    $.each(data.saldata, function(key, value) {
                        $('#info_isneg_lbl').html(value.is_neg);
                        $('#info_salary_lbl').html(value.salary_name);
                        $('#info_letterdate_lbl').html(value.date);
                        $('#info_letterdoc_lbl').empty().append(value.actual_file_name != null ? `<a style="text-decoration:underline;color:blue;" onclick=openSalaryFn("${recordId}","${value.doc_name}")>${value.actual_file_name}</a>` : "");
                        $('#info_remark_lbl').html(value.remark);
                        
                        if(value.status === "Draft"){
                            major_btn_link += edit_link;
                            major_btn_link += void_link;

                            status_btn_link += change_to_pending_link;
                            colors = "#A8AAAE";
                        }
                        else if(value.status === "Pending"){
                            major_btn_link += edit_link;
                            major_btn_link += void_link;

                            status_btn_link += back_to_draft_link;
                            status_btn_link += verify_link;
                            colors = "#f6c23e";
                        }
                        else if(value.status === "Verified"){
                            major_btn_link += edit_link;
                            major_btn_link += void_link;

                            status_btn_link += approve_link;
                            status_btn_link += back_to_pending;
                            
                            colors = "#7367F0";
                        }
                        else if(value.status === "Approved"){
                            major_btn_link += edit_link;
                            major_btn_link += void_link;

                            status_btn_link = "";
                            colors = "#1cc88a";
                        }
                        else if(value.old_status != ""){
                            major_btn_link += undovoid_link;
                            status_btn_link = "";
                            colors = "#e74a3b";
                        }
                        else if(value.status === "Closed"){
                            major_btn_link = "";
                            status_btn_link = "";
                            colors = "#7367F0";
                        }
                        else if(value.status === "Rejected"){
                            major_btn_link = "";
                            status_btn_link += approve_link;
                            colors = "#e74a3b";
                        }
                        else{
                            major_btn_link = "";
                            status_btn_link = "";
                            colors = "#e74a3b";
                        }
                        $("#salaryinfostatuslbl").html(`<span class"form_title" style='color:${colors};font-weight:bold;text-shadow;1px 1px 10px ${colors};'>${value.doc_number},     ${value.status}</span>`);
                        $("#action-log-status-lbl").html(`<span class"form_title" style='color:${colors};font-weight:bold;text-shadow;1px 1px 10px ${colors};'>${value.doc_number},     ${value.status}</span>`);

                        totaltaxable = value.TaxableEarning;
                        totalnontaxable = value.NonTaxableEarning;
                        totalearning = value.TotalEarnings;
                        totaldeduction = value.TotalDeductions;
                        netpay = value.NetSalary;

                        $("#infosummcompanypension").html(numformat(parseFloat(value.CompanyPension || 0).toFixed(2)));
                        $("#infosummtaxableearning").html(numformat(parseFloat(value.TaxableEarning).toFixed(2)));
                        $("#infosummnontaxableearning").html(numformat(parseFloat(value.NonTaxableEarning).toFixed(2)));
                        $("#infosummtotalearning").html(numformat(parseFloat(value.TotalEarnings).toFixed(2)));
                        $("#infosummtotaldeduction").html(numformat(parseFloat(value.TotalDeductions).toFixed(2)));
                        $("#infosummnetpay").html(numformat(parseFloat(value.NetSalary).toFixed(2)));

                        $('#infocompensiondiv').attr('title', `Pension Percent: ${compPensionPercent}% \nBasic Salary: ${numformat(parseFloat(value.CompanyPension / (compPensionPercent / 100)).toFixed(2))}\n----------------------------------------\nBasic Salary * Pension Percent = Company Pension\n${numformat(parseFloat(value.CompanyPension / (compPensionPercent / 100)).toFixed(2))} * ${parseFloat(compPensionPercent / 100).toFixed(2)} = ${numformat(parseFloat(value.CompanyPension).toFixed(2))}`);
                        $('#infonetpaydiv').attr('title', `(Taxable Earning - Total Deduction) + Total Non-Taxable = Net Pay\n(${numformat(parseFloat(value.TaxableEarning).toFixed(2))} - ${numformat(parseFloat(value.TotalDeductions).toFixed(2))}) + ${numformat(parseFloat(value.NonTaxableEarning).toFixed(2))} = ${numformat(parseFloat(value.NetSalary).toFixed(2))}`); 
                        $("#currentStatus").val(value.status);
                        $("#infoRecId").val(recordId);
                        getPayrollDataFn(value.salaries_id);
                    });

                    $.each(data.activitydata, function(key, value) {
                        var classes = "";
                        var reasonbody = "";
                        if(value.action == "Edited" || value.action == "Change to Pending"){
                            classes = "warning";
                        }
                        else if(value.action == "Verified" || value.action == "Closed"){
                            classes = "primary";
                        }
                        else if(value.action == "Back to Draft" || value.action == "Undo Void" || value.action == "Back to Pending" || value.action == "Back to Verify"){
                            classes = "secondary";
                        }
                        else if(value.action == "Created" || value.action == "Approved"){
                            classes = "success";
                        }
                        else if(value.action == "Void" || value.action == "Rejected"){
                            classes = "danger";
                        }

                        if(value.reason != null && value.reason != ""){
                            reasonbody = `</br><span class="text-muted"><b>Reason:</b> ${value.reason}</span>`;
                        }
                        else{
                            reasonbody = "";
                        }
                        lidata += `<li class="timeline-item"><span class="timeline-point timeline-point-${classes} timeline-point-indicator"></span><div class="timeline-header mb-sm-0 mb-0"><h6 class="mb-0">${value.action}</h6><span class="text-muted"><i class="fa-regular fa-user"></i> ${value.FullName}</span>${reasonbody}</br><span class="text-muted"><i class="fa-regular fa-clock"></i> ${value.time}</span></div></li>`;
                    });
                    $('#salaryactiondiv').empty().append(lidata);

                    $("#universal-action-log-canvas").empty().append(lidata);

                    action_links = `
                        <li>
                            <a class="dropdown-item viewSalaryAction" onclick="viewSalaryActionFn(${recordId})" data-id="view_salary_actionbtn${recordId}" id="view_salary_actionbtn${recordId}" title="View user log">
                            <span><i class="fa-solid fa-eye"></i> View User Log</span>  
                            </a>
                        </li>
                        ${major_btn_link}
                        ${status_btn_link}`;

                    $("#salary_action_ul").empty().append(action_links);
                    
                }
            });
            $(".infosalary").collapse('show');
        }

        function viewSalaryActionFn(recordId){
            $("#action-log-title").html("Salary Setup → User Log Information");
            $("#action-log-universal-modal").modal('show');
        }

        function salarySetupFn(recordId){
            var usecustomizedsal = "";
            $('#payrollEmpId').val(recordId);
            $('#payroll-dt-div').hide();
            $.ajax({
                type: "get",
                url: "{{url('showemployee')}}"+'/'+recordId,
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
                    usecustomizedsal = data.usenegsalary;
                    $.each(data.employeedata, function(key, value) {
                        $('#employeenamepayrollsett').html(`${value.emp_title} ${value.name}`);
                        $('#idpayrollsett').html(`<i class="fas fa-id-badge"></i> ${value.EmployeeID}`);
                        $('#branchpayrollsett').html(`<i class="fas fa-location-dot"></i> ${value.BranchName}`);
                        $('#departmentpayrollsett').html(`<i class="fa-solid fa-landmark"></i> ${value.DepartmentName}`);
                        $('#positionpayrollsett').html(`<i class="fa-solid fa-up-down-left-right"></i> ${value.PositionName}`);
                    
                        if(value.ActualPicture != null || value.BiometricPicture != null){
                            $('#employeepicpayrollsett').attr("src",value.ActualPicture!=null ? `../../../storage/uploads/HrEmployee/${value.ActualPicture}` : `../../../storage/uploads/BioEmployee/${value.BiometricPicture}`);
                        }
                        if(value.ActualPicture === null && value.BiometricPicture === null){
                            $('#employeepicpayrollsett').attr("src","../../../storage/uploads/HrEmployee/dummypic.jpg");
                        }

                        $("#salary_setting_title").html(value.Status == "Active" ? `<b style='color:#1cc88a'>${value.EmployeeID}, ${value.Status}</b>` : `<b style='color:#e74a3b'>${value.EmployeeID}, ${value.Status}</b>`);
                    
                        $("#EmployeePension").val(value.PensionPercent);
                        $("#CompanyPension").val(value.CompanyPensionPercent);
                    });
                    $('.payroll-class').html("");
                }
            });
            countEmpLeaveAndSalaryFn(recordId);
            showPayrollFn(recordId);
        }

        function showPayrollFn(recordId){
            var empid = "";
            $('#salary-datatable').DataTable({
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
                "dom": "<'row'<'col-sm-3 col-md-2 col-4'f><'col-lg-2 col-md-2 col-xs-8'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                   "<'row'<'col-sm-4 col-md-4 col-4'l><'col-sm-4 col-md-4 col-4 d-flex justify-content-center'i><'col-sm-4 col-md-4 col-4 d-flex justify-content-end'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{url('showPayrollData')}}",
                    type: 'POST',
                    data:{
                        empid: recordId,
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
                        data: 'doc_number',
                        name: 'doc_number',
                        width:"15%"
                    },
                    {
                        data: 'is_neg',
                        name: 'is_neg',
                        width:"15%"
                    },
                    {
                        data: 'salary',
                        name: 'salary',
                        width:"15%"
                    },
                    {
                        data: 'date',
                        name: 'date',
                        width:"15%"
                    },
                    {
                        data: 'actual_file_name',
                        name: 'actual_file_name',
                        "render": function ( data, type, row, meta ) {
                            return `<a style="text-decoration:underline;color:blue;" onclick=openSalaryFn("${row.id}","${row.doc_name}")>${data != null ? data : ""}</a>`;
                        },
                        width:"18%"
                    },
                    {
                        data: 'display_status',
                        name: 'display_status',
                        "render": function ( data, type, row, meta ) {
                            if(data == "Draft"){
                                return `<span class="badge bg-secondary bg-glow">${data}</span>`;
                            }
                            else if(data == "Pending"){
                                return `<span class="badge bg-warning bg-glow">${data}</span>`;
                            }
                            else if(data == "Verified"){
                                return `<span class="badge bg-primary bg-glow">${data}</span>`;
                            }
                            else if(data == "Approved"){
                                return `<span class="badge bg-success bg-glow">${data}</span>`;
                            }
                            else if(data == "Rejected" || data == "Void" || data == "Void(Draft)" || data == "Void(Pending)" || data == "Void(Verified)" || data == "Void(Approved)"){
                                return `<span class="badge bg-danger bg-glow">${data}</span>`;
                            }
                            else if(data == "Closed"){
                                return `<span class="badge bg-primary bg-glow">${data}</span>`;
                            }
                            else{
                                return `<span class="badge bg-dark bg-glow">${data}</span>`;
                            }
                        },
                        width:"15%"
                    },
                    {
                        data: 'action', name: 'action',
                        "render": function ( data, type, row, meta ) {
                            return `<div class="text-center"><a class="infoSalary" href="javascript:void(0)" onclick="infoSalaryFn(${row.id})" data-id="infoSalary${row.id}" id="infoSalary${row.id}" title="Open information modal"><i class="fa-sharp fa-regular fa-circle-info fa-xl" style="color: #00cfe8;"></i></a></div>`;
                        },
                        width:'4%'
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

                    $('#payroll-dt-div').show();
                },
            });

            $("#managepayrollsettingmodal").modal('show');
        }

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
                            <input type="number" placeholder="Deduction Amount" id="DedAmount${rowindex}" class="DedAmount form-control numeral-mask" name="drow[${rowindex}][DedAmount]" readonly onkeypress="return ValidateNum(event);" value="0.00" step="any" style="width:55%;"/>
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
                    <td style="width:5%;"><button id="earromvebtn${me}" type="button" class="btn btn-light btn-sm removeer-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times" aria-hidden="true"></i></button></td>
                    <td style="display:none;"><input type="hidden" name="erow[${me}][NonTaxableDef]" id="NonTaxableDef${me}" class="NonTaxableDef form-control" readonly="true" style="font-weight:bold;"/></td>
                </tr>`);

                var defaultoption = '<option selected disabled value=""></option>';
                var earningdefaultdata = $("#earningSalaryTypeDefault > option").clone();
                $(`#SalaryType${me}`).append(earningdefaultdata);

                $.each(selectedValues, function(i, value) {
                    $(`#SalaryType${me} option[value="${value}"]`).remove(); 
                });

                $(`#SalaryType${me}`).append(defaultoption);
                $(`#SalaryType${me}`).select2({placeholder: "Select salary component here",dropdownCssClass : 'commprp'});
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
                    <td style="width:5%;"><button id="dedromvebtn${md}" type="button" class="btn btn-light btn-sm removede-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times" aria-hidden="true"></i></button></td>
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
                $(`#SalaryTypeDed${md}`).select2({placeholder: "Select salary component here",dropdownCssClass : 'commprp'});
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

        function salaryFetchFn(recordId) { 
            var usecustomsalary = $('#UseCustomizedSalary').val();
            $('#addearningbtn').hide();
            $('#adddeductionbtn').hide();
            $("#earningDynamicTable > tbody").empty();
            $("#deductionDynamicTable > tbody").empty();
            var selectedEarningValues = [];
            var selectedDeductionValues = [];
            me = 0;
            md = 0;
            $.get("/showsalary"+'/'+recordId , function(data) {
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

                if(parseInt(usecustomsalary) == 0){
                    $('.SalaryType option').each(function () {
                        if (!$(this).is(':selected')) {
                            $(this).remove();
                        }
                    });
                    $('.SalaryType').select2({minimumResultsForSearch: -1});
                    $(`.select2-SalaryType-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                    $('.Taxable').prop('readonly',true);
                    $('.NonTaxable').prop('readonly',true);
                    $('.Remark').prop('readonly',true);
                    $('.removeer-tr').remove();
                    $('#addearningbtn').hide();

                    $('.SalaryTypeDed option').each(function () {
                        if (!$(this).is(':selected')) {
                            $(this).remove();
                        }
                    });
                    $('.SalaryTypeDed').select2({minimumResultsForSearch: -1});
                    $(`.select2-SalaryTypeDed-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                    $('.DedAmount').prop('readonly',true);
                    $('.RemarkDed').prop('readonly',true);
                    $('.removede-tr').remove();
                    $('#adddeductionbtn').hide();
                }

                if(parseInt(usecustomsalary) == 1){
                    $('#addearningbtn').show();
                    $('#adddeductionbtn').show();
                }
                $('#salarydynamictable').show();
            });
        }

        $('#SalarySettingForm').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            var optype = $("#salaryOperationType").val();
            var rec_id = $("#salaryInpId").val();
            var emp_id = $("#sal_employee_id").val();
            $.ajax({
                url: "{{ url('saveEmpSalary') }}",
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
                    if(parseFloat(optype) == 1){
                        $('#savebuttonpayrollsett').text('Saving...');
                        $('#savebuttonpayrollsett').prop("disabled", true);
                    }
                    else if(parseFloat(optype) == 2){
                        $('#savebuttonpayrollsett').text('Updating...');
                        $('#savebuttonpayrollsett').prop("disabled", true);
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
                        
                        if (data.errors.UseCustomizedSalary) {
                            var text = data.errors.UseCustomizedSalary[0];
                            text = text.replace("use customized salary", "is negotiable");
                            $('#customizesalary-error').html(text);
                        } 
                        if (data.errors.Salary) {
                            var text = data.errors.Salary[0];
                            text = text.replace("use customized salary is 0", "is negotiable is no");
                            $('#salary-error').html(text);
                        }
                        if (data.errors.letter_date) {
                            $('#letterdate-error').html(data.errors.letter_date[0]);
                        }
                        if (data.errors.salary_letter_file) {
                            $('#salary-letter-error').html(data.errors.salary_letter_file[0]);
                        }
                        if (data.errors.salary_remark) {
                            $('#salary-remark-error').html(data.errors.salary_remark[0]);
                        }

                        if(parseFloat(optype) == 1){
                            $('#savebuttonpayrollsett').text('Save');
                            $('#savebuttonpayrollsett').prop("disabled", false);
                        }
                        if(parseFloat(optype) == 2){
                            $('#savebuttonpayrollsett').text('Update');
                            $('#savebuttonpayrollsett').prop("disabled", false);
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


                        if(parseFloat(optype) == 1){
                            $('#savebuttonpayrollsett').text('Save');
                            $('#savebuttonpayrollsett').prop("disabled", false);
                        }
                        else if(parseFloat(optype) == 2){
                            $('#savebuttonpayrollsett').text('Update');
                            $('#savebuttonpayrollsett').prop("disabled", false);
                        }
                        toastrMessage('error',"Please insert valid data on highlighted fields!","Error");
                    }
                    else if (data.dberrors) {
                        if(parseFloat(optype) == 1){
                            $('#savebuttonpayrollsett').text('Save');
                            $('#savebuttonpayrollsett').prop("disabled",false);
                        }
                        else if(parseFloat(optype) == 2){
                            $('#savebuttonpayrollsett').text('Update');
                            $('#savebuttonpayrollsett').prop("disabled",false);
                        }
                        toastrMessage('error',"Please contact the administrator","Error");
                    }
                    else if(data.netsalaryerr){
                        if(parseFloat(optype) == 1){
                            $('#savebuttonpayrollsett').text('Save');
                            $('#savebuttonpayrollsett').prop("disabled", false);
                        }
                        if(parseFloat(optype) == 2){
                            $('#savebuttonpayrollsett').text('Update');
                            $('#savebuttonpayrollsett').prop("disabled", false);
                        }  
                        toastrMessage('error',"Net salary can not be less than or equal to zero(0)","Error");
                    }
                    else if(data.success){
                        if(parseFloat(optype) == 1){
                            $('#savebuttonpayrollsett').text('Save');
                            $('#savebuttonpayrollsett').prop("disabled", false);
                        }
                        else if(parseFloat(optype) == 2){
                            $('#savebuttonpayrollsett').text('Update');
                            $('#savebuttonpayrollsett').prop("disabled", false);
                            createSalaryInfoFn(rec_id);
                        }
                        countEmpLeaveAndSalaryFn(emp_id);
                        toastrMessage('success',"Successful","Success");
                        var oTable = $('#salary-datatable').dataTable();
                        oTable.fnDraw(false);
                        $("#salarysettingmodal").modal('hide');
                    }
                }
            });
        });

        function forwardActionFn() {
            const requestId = $('#infoRecId').val();
            const currentStatus = $('#currentStatus').val();
            const transition = statusTransitions[currentStatus].forward;

            $('#forwardReqId').val(requestId);
            $('#newForwardStatusValue').val(transition.status);
            $('#forwardActionLabel').html(transition.message);
            $('#forwarkBtnTextValue').val(transition.text);
            $('#forwardActionBtn').text(transition.text);
            $('#forwardActionValue').val(transition.action);

            Swal.fire({
                title: confirmation_title,
                text: transition.message,
                icon: confirmation_icon,
                showCloseButton: true,
                showCancelButton: true,      
                allowOutsideClick: false,
                confirmButtonText: transition.text,
                cancelButtonText: 'Close',
                customClass: {
                    confirmButton: 'btn btn-info',
                    cancelButton: 'btn btn-danger'
                }
            }).then(function (result) {
                if (result.value) {
                    salaryForwardActionFn();
                }
                else if (result.dismiss === Swal.DismissReason.cancel) {}
            });
        }

        function salaryForwardActionFn(){
            var forwardForm = $("#SalaryInfoForm");
            var formData = forwardForm.serialize();
            var btntxt = $('#forwarkBtnTextValue').val();
            var rec_id = $('#forwardReqId').val();
            var emp_id = $('#payrollEmpId').val();
            $.ajax({
                url: '/salaryForwardAction',
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
                    else if (data.success) {
                        toastrMessage('success',"Successful","Success");
                        countEmpLeaveAndSalaryFn(emp_id);
                        createSalaryInfoFn(rec_id);
                        var oTable = $('#salary-datatable').dataTable();
                        oTable.fnDraw(false);
                    }
                }
            });
        }

        $(document).on('click', '.backwardbtn', function(){
            const requestId = $('#infoRecId').val();
            const currentStatus = $('#currentStatus').val();

            const transition = $(this).attr('id') == "salrejectbtn" ? statusTransitions[currentStatus].reject : statusTransitions[currentStatus].backward;

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
            var rec_id = $('#backwardReqId').val();
            var emp_id = $('#payrollEmpId').val();
            $.ajax({
                url: '/salaryBackwardAction',
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
                            var text = data.errors.CommentOrReason[0];
                            text = text.replace("comment or ", "");       
                            $('#commentres-error').html(text);
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
                        countEmpLeaveAndSalaryFn(emp_id);
                        createSalaryInfoFn(rec_id);
                        var oTable = $('#salary-datatable').dataTable();
                        oTable.fnDraw(false);
                        $('#backwardActionModal').modal('hide');
                    }
                }
            });
        });

        function voidSalaryFn(recordId){
            $('.emp_reg_form').val("");
            $('.errordatalabel').html("");
            $('#salvoidbtn').text("Void");
            $('#salvoidbtn').prop("disabled", false);
            $('#salVoidId').val(recordId);
            $("#salvoidmodal").modal('show');
        }

        function salVoidReason() {
            $('#salary-void-error').html("");
        }

        $('#salvoidbtn').click(function() {
            var registerForm = $("#salvoidform");
            var formData = registerForm.serialize();
            var rec_id = $('#salVoidId').val();
            var emp_id = $('#payrollEmpId').val();
            $.ajax({
                url: '/voidSalary',
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
                    $('#salvoidbtn').text('Voiding...');
                    $('#salvoidbtn').prop("disabled", true);
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
                        if (data.errors.SalaryVoidReason) {
                            $('#salary-void-error').html(data.errors.SalaryVoidReason[0]);
                        }
                        $('#salvoidbtn').text('Void');
                        $('#salvoidbtn').prop("disabled", false);
                        toastrMessage('error',"Please check your input","Error");
                    }
                    else if (data.dberrors) {
                        $('#salvoidbtn').text('Void');
                        $('#salvoidbtn').prop("disabled", false);
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if(data.success){
                        $('#salvoidbtn').text("Void");
                        $('#salvoidbtn').prop("disabled", false);
                        countEmpLeaveAndSalaryFn(emp_id);
                        createSalaryInfoFn(rec_id);
                        toastrMessage('success',"Successful","Success");
                        var oTable = $('#salary-datatable').dataTable();
                        oTable.fnDraw(false);
                        $("#salvoidmodal").modal('hide');
                    }
                }
            });
        });

        function undoVoidFn(recordId) { 
            Swal.fire({
                title: confirmation_title,
                text: undo_void_confirmation,
                icon: confirmation_icon,
                showCloseButton: true,
                showCancelButton: true,      
                allowOutsideClick: false,
                confirmButtonText: 'Undo Void',
                cancelButtonText: 'Close',
                customClass: {
                    confirmButton: 'btn btn-info',
                    cancelButton: 'btn btn-danger'
                }
            }).then(function (result) {
                if (result.value) {
                    undoVoidSalaryFnc();
                }
                else if (result.dismiss === Swal.DismissReason.cancel) {}
            });
        }

        function undoVoidSalaryFnc(){
            var registerForm = $("#SalaryInfoForm");
            var formData = registerForm.serialize();
            var rec_id = $('#infoRecId').val();
            var emp_id = $('#payrollEmpId').val();
            $.ajax({
                url: '/undoVoidSalary',
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
                    if (data.voidoverlaperr) {
                        toastrMessage('error',`This record can’t be returned to <b>${data.oldstatus}</b> because newer records already exist. Please void the later records before continuing.`,"Error");
                    }
                    else if (data.dberrors) {
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if(data.success){
                        toastrMessage('success',"Successful","Success");
                        countEmpLeaveAndSalaryFn(emp_id);
                        createSalaryInfoFn(rec_id);
                        var oTable = $('#salary-datatable').dataTable();
                        oTable.fnDraw(false);
                    }
                }
            });
        }

        function salReasonFn() {
            $('#commentres-error').html("");
        }
        //---------------- Payroll Setting End-----------------

        function empDeleteFn(recordId) { 
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
                    deleteEmployeeFn();
                }
                else if (result.dismiss === Swal.DismissReason.cancel) {}
            });
        }

        function passwordResetLinkFn(recordId) { 
            Swal.fire({
                title: warning_title,
                text: password_reset_confirmation,
                icon: warning_icon,
                showCloseButton: true,
                showCancelButton: true,      
                allowOutsideClick: false,
                confirmButtonText: 'Reset',
                cancelButtonText: 'Close',
                customClass: {
                    confirmButton: 'btn btn-info',
                    cancelButton: 'btn btn-danger'
                }
            }).then(function (result) {
                if (result.value) {
                    passwordResetFn();
                }
                else if (result.dismiss === Swal.DismissReason.cancel) {}
            });
        }

        $('#syncbuttonfp').click(function() {
            var optype = $("#operationtypes").val();
            var enrolldev = $("#EnrollDevice").val();
            var registerForm = $("#Register");
            var formData = registerForm.serialize();
            if(parseInt(enrolldev)==1){
                $('#enroll-error').html('The enrollment device is required!');
                toastrMessage('error',"Plese select enrollment device","Error");
            }
            else if(parseInt(enrolldev)>1){
                var registerForm = $("#Register");
                var formData = registerForm.serialize();
                $.ajax({
                    url:'/getEmployeeFingerprint',
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
                        $('#syncbuttonfp').text('Getting...');
                        $('#syncbuttonfp').prop("disabled", true);
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
                            if(data.errors.DeviceId){
                                $('#enroll-error').html(data.errors.DeviceId[0]);
                            }
                            $('#syncbuttonfp').text('Get FingerPrint');
                            $('#syncbuttonfp').prop("disabled", false);
                            toastrMessage('error',"Please fill all required fields","Error");
                        }
                        else if (data.dberrors) {
                            $('#syncbuttonfp').text('Get FingerPrint');
                            $('#syncbuttonfp').prop("disabled", false);
                            toastrMessage('error',"Connection Failed </br>Please try again!</br>"+data.dberrors,"Error");
                        }
                        else if(data.success) {
                            
                            var totalfingerprintcnt = 0;

                            $('#LeftThumbVal').val(data.success.info.LeftThumb);
                            $('#LeftIndexVal').val(data.success.info.LeftIndex);
                            $('#LeftMiddelVal').val(data.success.info.LeftMiddle);
                            $('#LeftRingVal').val(data.success.info.LeftRing);
                            $('#LeftPickyVal').val(data.success.info.LeftPinky);
                            $('#RightThumbVal').val(data.success.info.RightThumb);
                            $('#RightIndexVal').val(data.success.info.RightIndex);
                            $('#RightMiddleVal').val(data.success.info.RightMiddle);
                            $('#RightRingVal').val(data.success.info.RightRing);
                            $('#RightPickyVal').val(data.success.info.RightPinky);

                            totalfingerprintcnt += setFingerPrintStatus(data.success.info.LeftThumb,   'leftthumblbl', 'left_thumb');
                            totalfingerprintcnt += setFingerPrintStatus(data.success.info.LeftIndex,     'leftindexlbl', 'left_index');
                            totalfingerprintcnt += setFingerPrintStatus(data.success.info.LeftMiddle,  'leftmiddlelbl', 'left_middle');
                            totalfingerprintcnt += setFingerPrintStatus(data.success.info.LeftRing,    'leftringlbl', 'left_ring');
                            totalfingerprintcnt += setFingerPrintStatus(data.success.info.LeftPinky,   'leftpinkylbl', 'left_pinky');

                            totalfingerprintcnt += setFingerPrintStatus(data.success.info.RightThumb,  'rightthumblbl', 'right_thumb');
                            totalfingerprintcnt += setFingerPrintStatus(data.success.info.RightIndex,    'rightindexlbl', 'right_index');
                            totalfingerprintcnt += setFingerPrintStatus(data.success.info.RightMiddle, 'rightmiddlelbl', 'right_middle');
                            totalfingerprintcnt += setFingerPrintStatus(data.success.info.RightRing,   'rightringlbl', 'right_ring');
                            totalfingerprintcnt += setFingerPrintStatus(data.success.info.RightPinky,  'rightpinkylbl', 'right_pinky');

                            toastrMessage('success',`<b>${totalfingerprintcnt}</b> Fingerprint found`,"Success");
                            $('#syncbuttonfp').text('Get FingerPrint');
                            $('#syncbuttonfp').prop("disabled", false);
                        }
                    },
                });
            }
        });

        $('#syncbutton').click(function() {
            var optype = $("#operationtypes").val();
            var enrolldev = $("#EnrollDevice").val();
            var registerForm = $("#Register");
            var formData = registerForm.serialize();
            if(parseInt(enrolldev) == 1){
                $('#enroll-error').html('The enrollment device is required!');
                toastrMessage('error',"Plese select enrollment device","Error");
            }
            else if(parseInt(enrolldev)>1){
                var registerForm = $("#Register");
                var formData = registerForm.serialize();
                $.ajax({
                    url:'/getEmployeeFaceid',
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
                        $('#syncbutton').text('Getting...');
                        $('#syncbutton').prop("disabled", true);
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
                            if(data.errors.DeviceId){
                                $('#enroll-error').html(data.errors.DeviceId[0]);
                            }
                            $('#syncbutton').text('Get FaceID');
                            $('#syncbutton').prop("disabled", false);
                            toastrMessage('error',"Please fill all required fields","Error");
                        }
                        else if (data.dberrors) {
                            $('#syncbutton').text('Get FaceID');
                            $('#syncbutton').prop("disabled", false);
                            toastrMessage('error',"Connection Failed </br>Please try again!</br>"+data.dberrors,"Error");
                        }
                        else if(data.success) {
                            var pic = data.success.pic;
                            var picfl = data.picflag;
                            $('#previewImg').show();
                            $('#imageprv').show();

                            if(parseInt(picfl) == 0){
                                $('#bioImagePreview').attr("src","../../../storage/uploads/BioEmployee/dummypic.jpg");
                                toastrMessage('warning',"Face ID not found","Warning");
                            }
                            if(parseInt(picfl) == 1){
                                $('#faceidencoded').val(pic);
                                $('#bioImagePreview').attr("src",pic);
                            }
                            
                            $('#syncbutton').text('Get FaceID');
                            $('#syncbutton').prop("disabled", false);
                        }
                    },
                });
            }
        });

        function deleteEmployeeFn(){
            var delform = $("#InformationForm");
            var formData = delform.serialize();
            $.ajax({
                url: '/deleteEmployee',
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
                        toastrMessage('error',"Error found</br>This record cannot be deleted because it exists with other records.","Error");
                    }
                    else if(data.success){
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                        toastrMessage('success',"Successful","Success");
                        $("#informationmodal").modal('hide');
                        hierarchyFn();
                    }
                }
            });
        }

        function passwordResetFn(){
            var infoform = $("#InformationForm");
            var formData = infoform.serialize();
            var recordId = $("#info_employee_id").val();
            $.ajax({
                url: '/resetEmpPass',
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
                        toastrMessage('error',"Error found</br>This record cannot be deleted because it exists with other records.","Error");
                    }
                    else if(data.success){
                        createInfoFn(recordId);
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                        toastrMessage('success',"Successful","Success");
                        //$("#informationmodal").modal('hide');
                        hierarchyFn();
                    }
                }
            });
        }

        function leaveBalanceFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            $('#LeaveBalance'+idval).css("background","white");
        }

        function useBalanceFn(ele){
            var idval = $(ele).closest('tr').find('.vals').val();
            var useBalance=$('#DependOnBalance'+idval).val();
            if(parseInt(useBalance)==0){
                $('#LeaveBalance'+idval).prop("readonly",true);
                $('#LeaveBalance'+idval).css("background","#efefef");
            }
            else if(parseInt(useBalance)==1){
                $('#LeaveBalance'+idval).prop("readonly",false);
                $('#LeaveBalance'+idval).css("background","white");
            }
            $('#LeaveBalance'+idval).val("");
            $('#select2-DependOnBalance'+idval+'-container').parent().css('background-color',"white");
        }

        function isAllowedFn(ele){
            var idval = $(ele).closest('tr').find('.vals').val();
            $('#select2-IsAllowed'+idval+'-container').parent().css('background-color',"white");
        }

        function closeRegisterModal() {
            resetForm();
        }

        function resetForm(){
            $('#Position').empty();
            $('#Branch').val(null).trigger('change').select2
            ({
                placeholder: "Select Branch here",
                dropdownCssClass : 'cusprop',
            });
            $('#Department').val(null).select2
            ({
                placeholder: "Select Department here",
                dropdownCssClass : 'cusprop',
            });
            $('#Position').val(null).select2
            ({
                placeholder: "Select Position here",
                dropdownCssClass : 'cusprop',
            });
            $('#Shift').val(null).trigger('change').select2
            ({
                placeholder: "Select Shift here",
            });
            $('#SupervisorOrImmedaiteManager').val(null).trigger('change').select2
            ({
                placeholder: "Select immedaite manager here",
            });
            $('#EmploymentType').val(null).trigger('change').select2
            ({
                placeholder: "Select Employment type here",
                minimumResultsForSearch: -1
            });
            $('#AccessStatus').val(null).trigger('change').select2
            ({
                placeholder: "Select Access status here",
                minimumResultsForSearch: -1
            });
            $('#EnableAttendance').val(null).trigger('change').select2
            ({
                placeholder: "Select Enable attendance option here",
                minimumResultsForSearch: -1
            });
            $('#EnableHoliday').val(null).trigger('change').select2
            ({
                placeholder: "Select Enable holiday option here",
                minimumResultsForSearch: -1
            });
            $('#status').val("Active").select2({
                minimumResultsForSearch: -1
            });
            $('#subcity-dd').empty();

            $('#gender').val(null).select2({
                placeholder: "Select Gender here",
                minimumResultsForSearch: -1
            });

            $('#title').val(null).select2({
                placeholder: "Select title here",
                dropdownCssClass : 'cusprop',
            });
            $('#nationality').val("--").select2
            ({
                placeholder: "Select Nationality here",
                dropdownCssClass : 'cusprop',
            });
            $('#country-dd').select2({
                minimumResultsForSearch: -1
            });
            $('#city-dd').val(null).select2
            ({
                placeholder: "Select city here",
                dropdownCssClass : 'cusprop',
            });
            $('#subcity-dd').select2
            ({
                placeholder: "Select subcity here",
            });
            $('#Woreda').empty();
            $('#Woreda').select2
            ({
                placeholder: "Select Woreda here",
            });
            $('#MartialStatus').val(null).select2
            ({
                placeholder: "Select Martial status here",
                minimumResultsForSearch: -1
            });
            $('#BloodType').val(null).select2
            ({
                placeholder: "Select Blood type here",
            });

            $('#PaymentType').val(null).select2
            ({
                placeholder: "Select payment type here",
            });

            $('#PaymentPeriod').val(null).select2
            ({
                placeholder: "Select payment period here",
            });

            $('#Bank').val(null).select2
            ({
                placeholder: "Select bank here",
            });

            $('#HiredDate').daterangepicker({ 
                singleDatePicker: true,
                showDropdowns: true,
                autoApply:true,
                maxDate:currdate,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            }); 

            $('#imagePreview').attr("src","../../../storage/uploads/HrEmployee/dummypic.jpg");
            $('#bioImagePreview').attr("src","../../../storage/uploads/BioEmployee/dummypic.jpg");
            
            $('.emp_reg_form').val("");
            $('.errordatalabel').html("");
            $('#tinCounter').html("0/13");
            $('#operationtypes').val("1");
            $('#UseCustomizedSalary').val("0");
            $("#modaltitle").html("Add Employee");
            $('#reg_form_title').html("");
            $('#savebutton').text('Save');
            $('#savebutton').prop("disabled",false);
            $('#savebutton').show();
            $('#role_data_div').hide();
     
            $('.signbtngrps').hide();
            $('.panel-default').hide();
            $('.imageclosecls').hide();
            //flatpickr('#RenewDate', { dateFormat: 'Y-m-d',clickOpens:false});
            //flatpickr('#HiredDate', { dateFormat: 'Y-m-d',monthSelectorType:"dropdown",yearSelectorType: 'static'});
            
            m = 0;
            me = 0;
            md = 0;
            z1 = 0;
            z2 = 0;
            z3 = 0;

            $('.biometric_div').hide();
            $('.guarantor_prop_btn').hide();
            
            $('.form_dynamic_table > tbody').empty();
            $('.tab-content').removeClass('not-editable-div');
            $('.access_control_div').removeClass('not-editable-div');
            tabMgtFn();
        }

        function firstNameFn() {
            fullnameFn();
            $('#firstname-error').html("");
        }

        function middleNameFn() {
            fullnameFn();
            $('#middlename-error').html("");
        }

        function lastNameFn() {
            fullnameFn();
            $('#lastname-error').html("");
        }

        function branchFn() {
            $('#branch-error').html("");
        }

        function titleFn() {
            $('#title-error').html("");
        }

        function departmentFn() {
            var depid=$('#Department').val();
            var positionopt = $("#PositionCbx > option").clone();
            var defopt='<option selected value=""></option>';
            $('#Position').append(positionopt);
            $("#Position option[title!='"+depid+"']").remove();
            $('#Position').append(defopt);
            $('#Position').select2
            ({
                placeholder: "Select Position here",
                dropdownCssClass : 'cusprop',
            });
            $('#department-error').html("");
        }

        function positionFn() {
            $('#position-error').html("");
        }

        function fullnameFn() {
            var fn = $.trim($('#FirstName').val()||"");
            var mn = $.trim($('#MiddleName').val()||"");
            var ln = $.trim($('#LastName').val()||"");
            var fullname = `${fn} ${mn} ${ln}`;
            $('#fullName').val(fullname);
        }

        $('#FirstName').keypress(function( e ) {
            if(e.which === 32) 
                return false;
        });

        $('#MiddleName').keypress(function( e ) {
            if(e.which === 32) 
                return false;
        });

        $('#LastName').keypress(function( e ) {
            if(e.which === 32) 
                return false;
        });

        $('#Salary').on('change', function() {
            salaryFetchFn($(this).val());
            
            $('#salary-error').html("");
            $('#basicsalary-error').html("");
            $('#medicalallowance-error').html("");
            $('#homerentallowance-error').html("");
            $('#transportallowance-error').html("");
            $('#bonus-error').html("");
            $('#others-error').html("");
            $('#tax-error').html("");
            $('#profidentfund-error').html("");
            $('#othersdec-error').html("");
        });

        function calcNetSalary() {
            var totalearning = 0;
            var totaldeduction = 0;
            var g=0;
            var l=0;
            $.each($('#dynamicTable').find('.EarningAmount'), function() {
                ++g;
                if(parseInt(g)<=9){
                    g="0"+g;
                }
                if ($(this).val() != '' && !isNaN($(this).val()) && $('#Status'+g).val()=="Active") {
                    totalearning += parseFloat($(this).val());
                }
            });
            $.each($('#dynamicTable').find('.DeductionAmount'), function() {
                ++l;
                if(parseInt(l)<=9){
                    l="0"+l;
                }
                if ($(this).val() != '' && !isNaN($(this).val()) && $('#Status'+l).val() == "Active") {
                    totaldeduction += parseFloat($(this).val());
                }
            });

            var netsalary = parseFloat(totalearning) - parseFloat(totaldeduction);
            $('#totalearnings').html(numformat(totalearning.toFixed(2)));
            $('#totaldeductions').html(numformat(totaldeduction.toFixed(2)));
            $('#netsalarylbl').html(numformat(netsalary.toFixed(2)));
            $('#NetSalary').val(netsalary.toFixed(2));
        }

        function earningamntFn(ele) {
            calcNetSalary();
            var cid=parseInt($(ele).closest('tr').find('.vals').val());
            if(parseInt(cid) <= 9){
                cid=`0${cid}`;
            }
            $(`#EarningAmount${cid}`).css("background", "white");
        }

        function deductionamntFn(ele) {
            calcNetSalary();
            var cid=parseInt($(ele).closest('tr').find('.vals').val());
            if(parseInt(cid) <= 9){
                cid=`0${cid}`;
            }
            $(`#DeductionAmount${cid}`).css("background", "white");
        }

        function statusvalfn(ele) {
            calcNetSalary();
            var cid=parseInt($(ele).closest('tr').find('.vals').val());
            if(parseInt(cid) <= 9){
                cid=`0${cid}`;
            }
            $(`#select2-Status${cid}-container`).parent().css('background-color',"white");
        }

        function shiftFn() {
            $('#shift-error').html("");
        }

        function supervisorFn() {
            $('#supervisor-error').html("");
        }

        function employmentTypeFn() {
            var emptype = $('#EmploymentType').val();
            $('#cont-doc-error').html("");
            $('#employmenttype-error').html("");
        }

        function hiredDateVal() {
            $('#hireddate-error').html("");
        }

        function descriptionfn() {
            $('#memo-error').html("");
        }

        function statusFn() {
            $('#status-error').html("");
        }

        function cleargendererror(){
            $('#gender-error').html("");
        }

        function clearDobError() {
            $('#dob-error').html("");
        }

        function TinNumberCounter(){
            var tin = $('#Tin').val();
            var len = tin.length;
            $('#tinCounter').html(`${len}/13`);
        }

        function clearTinnumberError() {
            $('#TinNumber-error').html("");
        }

        function clearNationalityError() {
            $('#nationality-error').html("");
        }

        function martialStatusFn() {
            $('#martialstatus-error').html("");
        }

        function kebeleFn() {
            $('#kebele-error').html("");
        }

        function housenoFn() {
            $('#houseno-error').html("");
        }

        function bloodTypeFn() {
            $('#bloodtype-error').html("");
        }

        function clearCountryError() {
            $('#country-error').html("");
        }

        function cityFn() {
            $('#city-error').html("");
        }

        function showguarantdoc() {
            $('#guarantershowdoc').hide();
            $('#guaranterhidedoc').show();
            $('#guaranteddocontent').show();
        }

        function hideguarantdoc() {
            $('#guarantershowdoc').show();
            $('#guaranterhidedoc').hide();
            $('#guaranteddocontent').hide();
        }

        $('#city-dd').on('change', function() {
            var cityval = $('#city-dd').val();
            var subdef = `<option selected disabled value=""></option>`;
            var default_subcity = `<option value="13">-</option>`;
            var subopt = $("#subcitycbx > option").clone();
            $('#subcity-dd').empty();
            $('#subcity-dd').append(subopt);
            $(`#subcity-dd option[data-city!="${cityval}"]`).remove();  
            $('#subcity-dd').append(default_subcity);
            $('#subcity-dd').append(subdef);
            $('#subcity-dd').select2
            ({
                placeholder: "Select Subcity here",
                dropdownCssClass : 'cusprop',
            });
            $('#city-error').html("");
        });

        function clearSubcityError() {
            var sub_city = $('#subcity-dd').val();
            var opt_data = "";
            var default_opt = `<option selected disabled value=""></option>`;
            var default_woreda = `<option selected value="-">-</option>`;
            var woreda_data = $("#woreda_default > option").clone();
            $('#Woreda').empty();
            $('#Woreda').append(woreda_data);
            $(`#Woreda option[data-w!="${opt_data = sub_city == 13 ? "default" : "main"}"]`).remove();
            $('#Woreda').append(sub_city == 13 ? default_woreda : default_opt);
            $('#Woreda').select2
            ({
                placeholder: "Select Woreda here",
            });
            $('#subcity-error').html("");
        }

        function clearWoredaError() {
            $('#Woreda-error').html("");
        }

        function clearMobileError() {
            $('#Mobilenumber-error').html("");
        }

        $('.phone_number').on('input', function (e) {
            let input = $(this);
            let v = input.val();
            
            // If user is deleting and the current value starts with "+251"
            if ((e.originalEvent?.inputType === 'deleteContentBackward' || 
                e.originalEvent?.inputType === 'deleteContentForward') &&
                v.startsWith('+251')) {
                
                // Get digits only (without "+" and "-")
                let digits = v.replace(/\D/g, '');
                
                // If we have only country code digits or less, clear everything
                if (digits.length <= 3) {
                    input.val('');
                    return;
                }
                
                // If we have more than country code, just remove the last digit
                // Keep going with normal formatting below
                v = digits;
            } else {
                // Normal case: get digits only
                v = v.replace(/\D/g, '');
            }
            
            // If empty after cleaning, clear field
            if (v === '') {
                input.val('');
                return;
            }
            
            // Remove leading 251 if user typed it (we'll add it back)
            v = v.replace(/^251/, '');
            
            // Add country code
            v = '251' + v;
            
            // Limit to 12 digits (251 + 9 digits)
            v = v.substring(0, 12);
            
            // Validate first digit after country code
            if (v.length > 3) {
                let firstDigit = v.charAt(3);
                if (firstDigit !== '9' && firstDigit !== '7') {
                    v = v.substring(0, 3);
                }
            }
            
            // Format with dashes
            let formatted = '+251';
            if (v.length > 3) formatted += '-' + v.substring(3, 6);
            if (v.length > 6) formatted += '-' + v.substring(6, 8);
            if (v.length > 8) formatted += '-' + v.substring(8, 10);
            if (v.length > 10) formatted += '-' + v.substring(10, 12);
            
            input.val(formatted);
        });

        $('.email_validation').on('input', function () {
            const email = $(this).val().trim();

            const isValid =
                /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(email);

            $(this).toggleClass('is-invalid', email !== '' && !isValid);
        });

        function clearpPhoneError() {
            $('#Phonenumber-error').html("");
        }

        function clearEmailError() {
            $('#Email-error').html("");
        }

        function clearPassportnoError() {
            $('#Passport-error').html("");
        }

        function clearResidenceidError() {
            $('#Residenceid-error').html("");
        }

        function nationalIdFn() {
            $('#nationalid-error').html("");
        }

        function drivingLicenceFn() {
            $('#drivinglicence-error').html("");
        }

        function postcodeFn() {
            $('#postcode-error').html("");
        }

        function addressFn() {
            $('#address-error').html("");
        }

        function personalMemoFn() {
            $('#personalmemo-error').html("");
        }

        function accessStatusFn() {
            var accsett = $('#AccessStatus').val();
            $('#AccessRole').empty();
            $('#roledatacanvas').empty();
            $('.role_data_div').hide();
            if(accsett == "Enable"){
                getRoleDataFn();
            }
            $('#accstatus-error').html("");
        }

        function accessRoleFn() {
            $('#accrole-error').html("");
        }

        function accessMemoFn() {
            $('#accessmemo-error').html("");
        }

        function enableAttFn() {
            $('#enableatt-error').html("");
        }

        function enableHolidayFn() {
            $('#enableholiday-error').html("");
        }

        function attendanceMemoFn() {
            $('#attmemo-error').html("");
        }

        function emergencyNameFn() {
            $('#emergencyname-error').html("");
        }

        function emergencyPhoneFn() {
            $('#emergencyphone-error').html("");
        }

        function emergencyAddFn() {
            $('#emergencyaddress-error').html("");
        }

        function emergencyMemoFn() {
            $('#emergencymemo-error').html("");
        }

        function guarantorNameFn() {
            $('#guarantorname-error').html("");
        }

        function guarantorPhoneFn() {
            $('#guarantorphone-error').html("");
        }

        function guarantorAddFn() {
            $('#guarantoraddress-error').html("");
        }

        function pinFn() {
            $('#pin-error').html("");
        }

        function cardNumFn() {
            $('#cardnum-error').html("");
        }

        function enrolldevFn() {
            $('#enroll-error').html("");
        }

        function biometricMemoFn() {
            $('#biometricmemo-error').html("");
        }

        function bankNameFn() {
            $('#bankname-error').html("");
        }

        function bankAccNumFn() {
            $('#bankaccnumber-error').html("");
        }

        function providentFundAccFn() {
            $('#providentfundacc-error').html("");
        }

        function pensionNumFn() {
            $('#pensionnumber-error').html("");
        }

        function payrollMemoFn() {
            $('#payrollmemo-error').html("");
        }

        function customizeSalaryFn() {
            var cusSl = $('#UseCustomizedSalary').val();
            var pensionpercent = $('#EmployeePension').val() || 0;
            if(parseInt(cusSl) == 0 && parseFloat(pensionpercent) > 0){
                $('#salarycontainer').show();
                $("#earningDynamicTable > tbody").empty();
                $("#deductionDynamicTable > tbody").empty();
                $('#addearningbtn').hide();
                $('#adddeductionbtn').hide();
                nonTaxableFn(this);
                taxableFn(this);
                calculateGrandTotal();
                calculateTotalDeduction();
            }
            else if(parseInt(cusSl) == 1){
                $('#salarycontainer').hide();
                $('#Salary').val(null).select2
                ({
                    placeholder: "Select Salary here",
                });
                appendDefaultSalaryComp();
                $('#addearningbtn').show();
                $('#adddeductionbtn').show();
            }
            else if(parseInt(cusSl) == 0 && parseFloat(pensionpercent) <= 0){
                toastrMessage('error',"This employee cannot select a pre-defined salary because no pension percentage is defined.</br>Please create a salary here","Error");
            }
            $('#payrollSalaryId').val("");
            $('#summcompanypension').html("0.00");
            $('#companypensiondiv').attr("title","");
            $('#summcompanypensionInp').val("");
            $('#salarydynamictable').show();
            $('#customizesalary-error').html("");
            $('#salary-error').html("");
        }

        function salaryLettDateFn() {
            $('#letterdate-error').html("");
        }

        function prvSalaryLetterFn() {

            const rec_id    = $('#salaryInpId').val();
            const file_name = $('#salary_letter_filename').val();
            const fileInput = $('#salary_letter_file')[0];

            const features = 'width=1000,height=700,scrollbars=yes,resizable=yes,location=yes,toolbar=yes,menubar=yes';

            // =========================
            // ADD / CREATE MODE
            // =========================
            if (fileInput.files && fileInput.files.length > 0) {

                if (!fileInput || !fileInput.files || fileInput.files.length === 0) {
                    toastrMessage('error', 'Please select a file first!', 'Error');
                    return;
                }

                const file = fileInput.files[0];

                const isImage = file.type.startsWith('image/');
                const isPDF   = file.type === 'application/pdf';

                if (!isImage && !isPDF) {
                    toastrMessage('error', 'Only PDF and Image files can be opened in new window!', 'Error');
                    return;
                }

                const blobUrl = URL.createObjectURL(file);
                window.open(blobUrl, '_blank', features);

                setTimeout(() => URL.revokeObjectURL(blobUrl), 10000);
                return;
            }

            // =========================
            // EDIT MODE
            // =========================
            if (fileInput == null && file_name == null) {
                toastrMessage('error', 'No file found!', 'Error');
                return;
            }

            const filePath = `/storage/uploads/EmployeeDocumets/Salary/${file_name}`;
            window.open(filePath, '_blank', features);
        }

        function showSalaryLetterFn(){
            $("#preview_salary_lett_file").show();
            $("#salary_letter_rem_btn").show();
            $("#salary_letter_filename").val("");
            $('#salary-letter-error').html("");
        }

        function salaryLetterBtnDocFn(){
            $("#preview_salary_lett_file").hide();
            $("#salary_letter_rem_btn").hide();
            $("#salary_letter_filename").val("");
            $("#salary_letter_file").val("");
        }

        function salaryLettRemarkFn() {
            $('#salary-remark-error').html("");
        }

        function paymentTypeFn() {
            var ptype = $('#PaymentType').val();
            if(ptype == "Bank-Transfer"){
                $('.bankprop').show();
                $('#Bank').val(null).trigger('change').select2
                ({
                    placeholder: "Select Bank here",
                });
            }
            if(ptype == "Cash"){
                $('.bankprop').hide();
                $('#Bank').val(1).trigger('change').select2
                ({
                    placeholder: "Select Bank here",
                });
            }
            $('#BankAccountNumber').val("");
            $('#ProvidentFundAccount').val("");
            $('#bankname-error').html("");
            $('#bankaccnumber-error').html("");
            $('#providentfundacc-error').html("");
            $('#paymenttype-error').html("");
        }

        function monthlyworkhrfn() {
            $('#monthlyworkhr-error').html("");
        }

        function paymentPeriodFn() {
            $('#paymentperiod-error').html("");
        }

        function signDateVal() {
            var signDate=$('#SignDate').val();
            $('#RenewDate').daterangepicker({ 
                singleDatePicker: true,
                showDropdowns: true,
                autoApply:true,
                minDate:signDate,
                maxDate:"2050-01-01",
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });
            $('#RenewDate').val("");
            //flatpickr('#RenewDate', { dateFormat: 'Y-m-d',clickOpens:true,minDate:signDate,maxDate:"2050-01-01"});
            $('#signdate-error').html("");
        }

        function renewDateVal() {
            var registerForm = $("#Register");
            var formData = registerForm.serialize();
            $.ajax({
                url: '/getDayDiff',
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
                    $('#ContractDuration').val(data.days);
                }
            });
            $('#renewdate-error').html("");
            $('#contractdur-error').html("");
        }

        function contractDurationFn() {
            $('#contractdur-error').html("");
        }

        function contractMemoFn() {
            $('#contractmemo-error').html("");
        }

        function leaveAllocMemoFn() {
            $('#leaveallocation-error').html("");
        }

        function removeActualPhotoFn() {
            $('#imagePreview').attr("src","../../../storage/uploads/HrEmployee/dummypic.jpg");
            $('#actimageclosebtn').hide();
            $('#actualPhoto').val("");
        }

        function removeBioPhotoFn() {
            $('#bioImagePreview').attr("src","../../../storage/uploads/BioEmployee/dummypic.jpg");
            $('#bioimageclosebtn').hide();
            $('#bioPhoto').val("");
        }

        function calculateNetSalary() {
            var basicsalary= $('#BasicSalary').val()||0;
            var medicalallowance= $('#MedicalAllowance').val()||0;
            var homerentallowance= $('#HomeRentAllowance').val()||0;
            var transportallowance= $('#TransportAllowance').val()||0;
            var bonus= $('#Bonus').val()||0;
            var otherearning= $('#OtherEarning').val()||0;

            var tax= $('#Tax').val()||0;
            var profidentfund= $('#ProvidentFund').val()||0;
            var loan= $('#Loan').val()||0;
            var costsharing= $('#CostSharingDeduction').val()||0;
            var otherdeduction= $('#OtherDeduction').val()||0;

            var earnings=parseFloat(basicsalary)+parseFloat(medicalallowance)+parseFloat(homerentallowance)+parseFloat(transportallowance)+parseFloat(bonus)+parseFloat(otherearning);
            var deductions=parseFloat(tax)+parseFloat(profidentfund)+parseFloat(loan)+parseFloat(costsharing)+parseFloat(otherdeduction);
            var netsalary=parseFloat(earnings)-parseFloat(deductions);
            
            $('#netsalarylbl').html("Net Salary: "+numformat(netsalary.toFixed(2)));
            $('#NetSalary').val(netsalary.toFixed(2));
        }

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    //$('#imagePreview').css('background-image', 'url('+e.target.result +')');
                    $('#imagePreview').attr("src",e.target.result);
                    $('#imagePreview').hide();
                    $('#imagePreview').fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#imageUpload").change(function() {
            readURL(this);
            $('#actimageclosebtn').show();
        });

        function readBioURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#bioImagePreview').attr("src",e.target.result);
                    $('#bioImagePreview').hide();
                    $('#bioImagePreview').fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#bioImageUpload").change(function() {
            readBioURL(this);
            $('#bioimageclosebtn').show();
        });

        function documentationMemoFn() {
            $('#documentmemo-error').html("");
        }

        function hierarchyviewFn() {
            $('#hierarchyviewdiv').show();
        }

        function departmentNameFn() {
            $('#name-error').html("");
        }

        function parentdepFn() {
            $('#parentdep-error').html("");
        }

        $(document).on('click', '#expExcelLeaveHistory', function() {
            var employeeid = $("#info_employee_code").val();
            var employeeName = $("#fullNameLbl").text();
            var branch = $("#BranchLbl").text();
            var department = $("#DepartmentLbl").text();
            var position = $("#PositionLbl").text();
            var gender = $("#genderLbl").text();

            var table = document.getElementById("info-leavehis-datatable");
            var workbook = new ExcelJS.Workbook();
            var worksheet = workbook.addWorksheet("Leave History");

            let mergeCells = [];
            let maxColumnWidths = {}; // Store max column widths

            let titleRow = worksheet.addRow(["Leave History"]);
            titleRow.font = { bold: true, size: 16, color: { argb: "000000" } };
            titleRow.alignment = { horizontal: "center", vertical: "middle" };

            worksheet.mergeCells(1, 1, 1, 8); // 🔹 Merge across all columns

            const emptitle = `Employee ID: ${employeeid}  |   Employee Name: ${employeeName}  |   Gender: ${gender}`;
            const emptitleRow = worksheet.addRow([emptitle]);
            emptitleRow.font = { bold: false, size: 11 };
            emptitleRow.alignment = { horizontal: 'center', vertical: 'middle' };
            worksheet.mergeCells(2, 1, 2, 8);

            const subtitle = `Branch: ${branch}  |   Department: ${department}  |   Position: ${position}`;
            const subtitleRow = worksheet.addRow([subtitle]);
            subtitleRow.font = { bold: false, size: 11 };
            subtitleRow.alignment = { horizontal: 'center', vertical: 'middle' };
            worksheet.mergeCells(3, 1, 3, 8);

            // **🔹 Leave an empty row below the title**
            worksheet.addRow([]);
            worksheet.mergeCells(4, 1, 4, 8);

            function processTableRows(tableSection, startRow, isHeader = false, isFooter = false) {
                let excelRowIndex = startRow;
                let rowSpanMap = {}; 

                $(tableSection).find("tr").each(function () {
                    let rowData = [];
                    let colIndex = 1;

                    $(this).find("th, td").each(function () {
                        let text = $(this).text().trim();
                        let colspan = parseInt($(this).attr("colspan") || 1);
                        let rowspan = parseInt($(this).attr("rowspan") || 1);

                        // Ensure column is not occupied by previous row span
                        while (rowSpanMap[`${excelRowIndex}-${colIndex}`]) {
                            colIndex++;
                        }

                        rowData[colIndex - 1] = text;
                        let estimatedWidth = text.length * 1.2; // 1.2 units per character (better scaling)
                        estimatedWidth = Math.max(estimatedWidth, 5); // Minimum width for any column

                        if (colIndex === 1) {
                            maxColumnWidths[colIndex] = 5;
                        }
                        else{
                            maxColumnWidths[colIndex] = Math.max(maxColumnWidths[colIndex] || 5, estimatedWidth);
                            maxColumnWidths[colIndex] = Math.min(maxColumnWidths[colIndex], 50); // **Limit max width to 30**
                        }

                        if (colspan > 1 || rowspan > 1) {
                            mergeCells.push({
                                start: { row: excelRowIndex, col: colIndex },
                                end: { row: excelRowIndex + rowspan - 1, col: colIndex + colspan - 1 },
                                isTotalCell: text.toLowerCase().includes('total') // Check if cell contains "total"
                            });

                            for (let r = 0; r < rowspan; r++) {
                                for (let c = 0; c < colspan; c++) {
                                    rowSpanMap[`${excelRowIndex + r}-${colIndex + c}`] = true;
                                }
                            }
                        }

                        colIndex += colspan;
                    });

                    let row = worksheet.addRow(rowData);

                    if (isHeader) {
                        row.eachCell((cell) => {
                            cell.font = { bold: true, size: 12, color: { argb: "000000" }};
                            cell.fill = { type: "pattern", pattern: "solid", fgColor: { argb: "D1D5DB" }};
                            cell.alignment = { horizontal: "center", vertical: "middle" };
                        });
                    } else {
                        // Apply right alignment to TOTAL cells in any row (including group totals)
                        row.eachCell((cell, cellNumber) => {
                            const cellText = cell.value ? cell.value.toString().toLowerCase() : '';
                            
                            // Check if cell contains "total" (for group totals and footer totals)
                            if (cellText.includes('total') || isFooter) {
                                cell.alignment = { horizontal: "right", vertical: "middle" };
                                cell.font = { bold: true };
                            } else {
                                cell.alignment = { horizontal: "center", vertical: "middle" };
                            }
                        });
                    }
                    
                    excelRowIndex++;
                });
                return excelRowIndex;
            }

            let lastRow = processTableRows($(table).find("thead"), 5, true);
            lastRow = processTableRows($(table).find("tbody"), lastRow);
            lastRow = processTableRows($(table).find("tfoot"), lastRow, false, true); // Handle footer

            // Apply merges and ensure total cells are right-aligned
            mergeCells.forEach((cell) => {
                worksheet.mergeCells(
                    cell.start.row,
                    cell.start.col,
                    cell.end.row,
                    cell.end.col
                );
                
                // If this is a total merged cell, right align it
                if (cell.isTotalCell) {
                    const mergedCell = worksheet.getCell(cell.start.row, cell.start.col);
                    mergedCell.alignment = { horizontal: "right", vertical: "middle" };
                    mergedCell.font = { bold: true };
                }
            });

            // Apply borders to all cells
            worksheet.eachRow((row) => {
                row.eachCell((cell) => {
                    cell.border = {
                        top: { style: "thin" },
                        left: { style: "thin" },
                        bottom: { style: "thin" },
                        right: { style: "thin" },
                    };
                });
            });

            worksheet.columns.forEach((column, i) => {
                column.width = maxColumnWidths[i + 1] || 5; // **Set a default min width of 10**
            });

            workbook.xlsx.writeBuffer().then((data) => {
                var blob = new Blob([data], {
                    type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
                });
                saveAs(blob,`Leave_History_of(${employeeName}).xlsx`);
            });
        });

        $(document).on('click', '#expPdfLeaveHistory', function() {
            
            var employeeid = $("#info_employee_code").val();
            var employeeName = $("#fullNameLbl").text();
            var branch = $("#BranchLbl").text();
            var department = $("#DepartmentLbl").text();
            var position = $("#PositionLbl").text();
            var gender = $("#genderLbl").text();

            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            const company_name = $("#info_company_name").val();

            // 2. Add the first row manually using JS array
            doc.autoTable({
                startY: 2,
                theme: 'plain',
                showHead: 'firstPage',
                styles: { lineWidth: 0, fontSize: 12 },
                columnStyles: { 0: { cellWidth: 50 }, 1: { cellWidth: 50 }, 2: { cellWidth: 50 } },
                body: [
                    [{ 
                        content: company_name, 
                        colSpan: 3, 
                        styles: { halign: 'center', fontStyle: 'bold', fontSize: 20 } 
                    }]
                ]
            });

            doc.autoTable({ 
                html: '#company_info_tbl',
                startY: doc.lastAutoTable.finalY + 0,      // Y position to start the table
                margin: { top: 1, left: 1, right: 1, bottom: 1 },
                styles: { fontSize: 8, cellPadding: 0.6, halign: 'left', valign: 'middle' },
                //headStyles: { fillColor: [220, 220, 220], textColor: 0, fontStyle: 'bold' },
                bodyStyles: { fillColor: [255, 255, 255] },
                columnStyles: { 
                    0: { cellWidth: 13 }, 
                    1: { cellWidth: 77,fontStyle: 'bold' }, 
                    2: { cellWidth: 13 }, 
                    3: { cellWidth: 77,fontStyle: 'bold' }, 
                }, // specific columns
                theme: 'plain',  // 'striped', 'grid', 'plain'
                showHead: 'firstPage', // 'never', 'firstPage', 'everyPage'
                tableWidth: 'auto',     // 'auto', 'wrap', numeric value
                pageBreak: 'auto',      // 'auto', 'avoid', 'always'
                didDrawPage: () => {
                    const y = doc.lastAutoTable.finalY + 15;
                    const pageWidth = doc.internal.pageSize.getWidth();
                    doc.line(0, y, pageWidth, y); // A4 width shortcut
                }
            });

            const totalPagesExp = "{total_pages_count_string}";

            doc.setFontSize(14);  // Title font size
            doc.setFont("helvetica", "bold");
            doc.setTextColor(0, 0, 0);  

            const marginTop = 2; // Enough for title + header lines
            const pageWidth = doc.internal.pageSize.width;
            
            const titleText = "Leave History";
            const textWidth = doc.getStringUnitWidth(titleText) * doc.internal.getFontSize() / doc.internal.scaleFactor;
            const xCoordinate = (pageWidth - textWidth) / 2;  // Centering the text

            doc.text(titleText, xCoordinate, 35); 

            const marginX = 15;
            const startY = 41;
            const rowHeight = 6;
            const colPadding = 0;

            // Column widths
            const col1Width = 25;
            const col2Width = 30;
            const colSpacer = 2;
            const col3Width = 30;
            const col4Width = 65;
            const col5Width = 15;
            const col6Width = 40;
            const marginLeft = 0;

            // Total width to center
            const totalWidth = col1Width + col2Width + colSpacer + col3Width + col4Width + col5Width + col6Width;
            const startX = (pageWidth - totalWidth) / 2;
            // Row 1
            doc.setFontSize(10);

            // Labels normal, values bold
            doc.setFont("helvetica", "normal"); 
            doc.text("Employee ID:", startX + marginLeft, startY);
            doc.setFont("helvetica", "bold");
            doc.text(employeeid, startX + marginLeft + col1Width + colPadding, startY);

            doc.setFont("helvetica", "normal");
            doc.text("Employee Name:", startX + marginLeft + col1Width + col2Width + colPadding, startY);
            doc.setFont("helvetica", "bold");
            doc.text(employeeName, startX + marginLeft + col1Width + col2Width + col3Width + colPadding + colSpacer, startY);

            doc.setFont("helvetica", "normal");
            doc.text(`Gender:`,startX + col1Width + col2Width + col3Width + col4Width, startY);
            doc.setFont("helvetica", "bold");
            doc.text(gender, startX + col1Width + col2Width + col3Width + col4Width + col5Width, startY);

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

            let headers = [];
            let bodyData = [];
            let mergeCells = [];

            // Get headers (handling colspan for headers)
            $("#info-leavehis-datatable thead tr").each(function () {
                let rowData = [];
                let headerMerge = []; // Store merge info for headers

                $(this).find("th").each(function (colIndex) {
                    let colspan = parseInt($(this).attr("colspan")) || 1;
                    let text = $(this).text().trim();

                    rowData.push({ content: text, colSpan: colspan }); // Use colSpan key

                    if (colspan > 1) {
                        headerMerge.push({
                            col: colIndex,
                            colspan: colspan,
                        });
                    }
                });
                headers.push(rowData);
            });

            // Get body data (handling colspan)
            $("#info-leavehis-datatable tbody tr").each(function (rowIndex) {
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

            $("#info-leavehis-datatable tfoot tr").each(function (rowIndex) {
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

            doc.autoTable({
                head: headers,  // Correctly formatted headers
                body: bodyData,
                
                theme: "grid",
                showFoot: 'lastPage', // only on last page
                styles: {
                    fontSize: 9,
                    cellPadding: 1,
                    overflow: "linebreak",
                    valign: "middle",
                    halign: "center",
                },
                headStyles: {
                    fillColor: [209, 213, 219], 
                    textColor: [0, 0, 0], // White text
                    lineWidth: 0.1, // Border thickness
                    lineColor: [0, 0, 0], // White border
                    fontStyle: "bold",
                },
                footStyles: {
                    fontSize: 9,
                    fillColor: [255, 255, 255],  // A bit darker gray than head
                    textColor: [0, 0, 0],
                    halign: 'right', // default center alignment in footer
                },
                startY: 50,
                margin: { top: 50, left: 1, right: 1 },
                didParseCell: function (data) {
                    if (data.row.section === "body"){
                        mergeCells.forEach(function (merge) {
                            if (data.row.index === merge.row && data.column.index === merge.col) {
                                data.cell.colSpan = merge.colspan;
                                data.cell.styles.fontStyle = 'bold';
                            }
                            if(parseInt(data.cell.colSpan) == 8 && data.cell.text[0].toLowerCase().includes('total')){
                                data.cell.styles.halign = "right";
                            }
                        });

                        data.cell.styles.lineWidth = 0.1;  // Thickness of the border
                        data.cell.styles.lineColor = [0, 0, 0];  // Black border color
                    }
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

                    doc.text(`Exported on: ${getDateTimeTZ('Africa/Addis_Ababa')}`, 5, pageHeight - 3);
                
                    // Thin separator line (just above the bottom margin)
                    doc.setDrawColor(0); // Black
                    doc.setLineWidth(0.1); // Thin line
                    doc.line(1, pageHeight - 7, pageWidth - 1, pageHeight - 7); // From (x1, y1) to (x2, y2)
                }
            });

            if (typeof doc.putTotalPages === 'function') {
                doc.putTotalPages(totalPagesExp);
            }


            if (typeof doc.putTotalPages === 'function') {
                doc.putTotalPages(totalPagesExp);
            }

            doc.save(`Leave_History_of(${employeeName}).pdf`);
        });

        $(document).on('click', '#printLeaveHistory', function() {
            
            var employeeid = $("#info_employee_code").val();
            var employeeName = $("#fullNameLbl").text();
            var branch = $("#BranchLbl").text();
            var department = $("#DepartmentLbl").text();
            var position = $("#PositionLbl").text();
            var gender = $("#genderLbl").text();

            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            const company_name = $("#info_company_name").val();

            // 2. Add the first row manually using JS array
            doc.autoTable({
                startY: 2,
                theme: 'plain',
                showHead: 'firstPage',
                styles: { lineWidth: 0, fontSize: 12 },
                columnStyles: { 0: { cellWidth: 50 }, 1: { cellWidth: 50 }, 2: { cellWidth: 50 } },
                body: [
                    [{ 
                        content: company_name, 
                        colSpan: 3, 
                        styles: { halign: 'center', fontStyle: 'bold', fontSize: 20 } 
                    }]
                ]
            });

            doc.autoTable({ 
                html: '#company_info_tbl',
                startY: doc.lastAutoTable.finalY + 0,      // Y position to start the table
                margin: { top: 1, left: 1, right: 1, bottom: 1 },
                styles: { fontSize: 8, cellPadding: 0.6, halign: 'left', valign: 'middle' },
                //headStyles: { fillColor: [220, 220, 220], textColor: 0, fontStyle: 'bold' },
                bodyStyles: { fillColor: [255, 255, 255] },
                columnStyles: { 
                    0: { cellWidth: 13 }, 
                    1: { cellWidth: 77,fontStyle: 'bold' }, 
                    2: { cellWidth: 13 }, 
                    3: { cellWidth: 77,fontStyle: 'bold' }, 
                }, // specific columns
                theme: 'plain',  // 'striped', 'grid', 'plain'
                showHead: 'firstPage', // 'never', 'firstPage', 'everyPage'
                tableWidth: 'auto',     // 'auto', 'wrap', numeric value
                pageBreak: 'auto',      // 'auto', 'avoid', 'always'
                didDrawPage: () => {
                    const y = doc.lastAutoTable.finalY + 15;
                    const pageWidth = doc.internal.pageSize.getWidth();
                    doc.line(0, y, pageWidth, y); // A4 width shortcut
                }
            });

            const totalPagesExp = "{total_pages_count_string}";

            doc.setFontSize(14);  // Title font size
            doc.setFont("helvetica", "bold");
            doc.setTextColor(0, 0, 0);  

            const marginTop = 2; // Enough for title + header lines
            const pageWidth = doc.internal.pageSize.width;
            
            const titleText = "Leave History";
            const textWidth = doc.getStringUnitWidth(titleText) * doc.internal.getFontSize() / doc.internal.scaleFactor;
            const xCoordinate = (pageWidth - textWidth) / 2;  // Centering the text

            doc.text(titleText, xCoordinate, 35); 

            const marginX = 15;
            const startY = 41;
            const rowHeight = 6;
            const colPadding = 0;

            // Column widths
            const col1Width = 25;
            const col2Width = 30;
            const colSpacer = 2;
            const col3Width = 30;
            const col4Width = 65;
            const col5Width = 15;
            const col6Width = 40;
            const marginLeft = 0;

            // Total width to center
            const totalWidth = col1Width + col2Width + colSpacer + col3Width + col4Width + col5Width + col6Width;
            const startX = (pageWidth - totalWidth) / 2;
            // Row 1
            doc.setFontSize(10);

            // Labels normal, values bold
            doc.setFont("helvetica", "normal"); 
            doc.text("Employee ID:", startX + marginLeft, startY);
            doc.setFont("helvetica", "bold");
            doc.text(employeeid, startX + marginLeft + col1Width + colPadding, startY);

            doc.setFont("helvetica", "normal");
            doc.text("Employee Name:", startX + marginLeft + col1Width + col2Width + colPadding, startY);
            doc.setFont("helvetica", "bold");
            doc.text(employeeName, startX + marginLeft + col1Width + col2Width + col3Width + colPadding + colSpacer, startY);

            doc.setFont("helvetica", "normal");
            doc.text(`Gender:`,startX + col1Width + col2Width + col3Width + col4Width, startY);
            doc.setFont("helvetica", "bold");
            doc.text(gender, startX + col1Width + col2Width + col3Width + col4Width + col5Width, startY);

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

            let headers = [];
            let bodyData = [];
            let mergeCells = [];

            // Get headers (handling colspan for headers)
            $("#info-leavehis-datatable thead tr").each(function () {
                let rowData = [];
                let headerMerge = []; // Store merge info for headers

                $(this).find("th").each(function (colIndex) {
                    let colspan = parseInt($(this).attr("colspan")) || 1;
                    let text = $(this).text().trim();

                    rowData.push({ content: text, colSpan: colspan }); // Use colSpan key

                    if (colspan > 1) {
                        headerMerge.push({
                            col: colIndex,
                            colspan: colspan,
                        });
                    }
                });
                headers.push(rowData);
            });

            // Get body data (handling colspan)
            $("#info-leavehis-datatable tbody tr").each(function (rowIndex) {
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

            $("#info-leavehis-datatable tfoot tr").each(function (rowIndex) {
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

            doc.autoTable({
                head: headers,  // Correctly formatted headers
                body: bodyData,
                
                theme: "grid",
                showFoot: 'lastPage', // only on last page
                styles: {
                    fontSize: 9,
                    cellPadding: 1,
                    overflow: "linebreak",
                    valign: "middle",
                    halign: "center",
                },
                headStyles: {
                    fillColor: [209, 213, 219], 
                    textColor: [0, 0, 0], // White text
                    lineWidth: 0.1, // Border thickness
                    lineColor: [0, 0, 0], // White border
                    fontStyle: "bold",
                },
                footStyles: {
                    fontSize: 9,
                    fillColor: [255, 255, 255],  // A bit darker gray than head
                    textColor: [0, 0, 0],
                    halign: 'right', // default center alignment in footer
                },
                startY: 50,
                margin: { top: 50, left: 1, right: 1 },
                didParseCell: function (data) {
                    if (data.row.section === "body"){
                        mergeCells.forEach(function (merge) {
                            if (data.row.index === merge.row && data.column.index === merge.col) {
                                data.cell.colSpan = merge.colspan;
                                data.cell.styles.fontStyle = 'bold';
                            }
                            if(parseInt(data.cell.colSpan) == 8 && data.cell.text[0].toLowerCase().includes('total')){
                                data.cell.styles.halign = "right";
                            }
                        });

                        data.cell.styles.lineWidth = 0.1;  // Thickness of the border
                        data.cell.styles.lineColor = [0, 0, 0];  // Black border color
                    }
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

                    doc.text(`Printed on: ${getDateTimeTZ('Africa/Addis_Ababa')}`, 5, pageHeight - 3);

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
        });

        function countEmployeeStatusFn() {
            $(".status_record_lbl").html("0");
            $.ajax({
                url: '/countEmployeeStatus',
                type: 'POST',
                dataType: 'json',
                success: function(data) {
                    $.each(data.empstatus, function(key, value) {
                        if(value.Status == "Active"){
                            $("#active_record_lbl").html(value.status_count);
                        }
                        if(value.Status == "Inactive"){
                            $("#inactive_record_lbl").html(value.status_count);
                        }
                        if(value.Status == "Dismissal"){
                            $("#dismissal_record_lbl").html(value.status_count);
                        }
                        if(value.Status == "Resign"){
                            $("#resign_record_lbl").html(value.status_count);
                        }
                        if(value.Status == "Total"){
                            $("#total_record_lbl").html(value.status_count);
                        }
                    });  
                }
            });
        }

        function countEmpLeaveAndSalaryFn(recordId) {
            var empid = 0;
            var void_cnt = 0;
            $(".leave_status_record_lbl").html("0");
            $(".salary_status_record_lbl").html("0");
            $.ajax({
                url: '/countEmpLeaveAndSalary',
                type: 'POST',
                data:{
                    empid: recordId,
                },
                dataType: 'json',
                success: function(data) {
                    $.each(data.leavestatus, function(key, value) {
                        if(value.Status == "Draft"){
                            $("#leave_draft_record_lbl").html(value.status_count);
                        }
                        else if(value.Status == "Pending"){
                            $("#leave_pending_record_lbl").html(value.status_count);
                        }
                        else if(value.Status == "Verified"){
                            $("#leave_verified_record_lbl").html(value.status_count);
                        }
                        else if(value.Status == "Approved"){
                            $("#leave_approved_record_lbl").html(value.status_count);
                        }
                        else if(value.Status == "Total"){
                            $("#leave_total_record_lbl").html(value.status_count);
                        }
                        else{
                            $("#leave_void_record_lbl").html(value.status_count);
                        }
                    });  
                    
                    $.each(data.salarystatus, function(key, value) {
                        if(value.Status == "Draft"){
                            $("#salary_draft_record_lbl").html(value.status_count);
                        }
                        else if(value.Status == "Pending"){
                            $("#salary_pending_record_lbl").html(value.status_count);
                        }
                        else if(value.Status == "Verified"){
                            $("#salary_verified_record_lbl").html(value.status_count);
                        }
                        else if(value.Status == "Approved"){
                            $("#salary_approved_record_lbl").html(value.status_count);
                        }
                        else if(value.Status == "Closed"){
                            $("#salary_closed_record_lbl").html(value.status_count);
                        }
                        else if(value.Status == "Total"){
                            $("#salary_total_record_lbl").html(value.status_count);
                        }
                        else {
                            void_cnt += parseInt(value.status_count);
                            $("#salary_void_record_lbl").html(void_cnt);
                        }
                    });
                }
            });
        }

        function refreshEmpDataFn(){
            countEmployeeStatusFn();
            hierarchyFn();
            var oTable = $('#laravel-datatable-crud').dataTable();
            oTable.fnDraw(false);
        }

        function refreshEmpLeaveFn(){
            var recordId = $('#leaveFormEmpId').val();
            countEmpLeaveAndSalaryFn(recordId);

            var oTable = $('#leavealloctable').dataTable();
            oTable.fnDraw(false);
        }

        function refreshEmpSalaryFn(){
            var recordId = $('#payrollEmpId').val();
            countEmpLeaveAndSalaryFn(recordId);

            var iTable = $('#salary-datatable').dataTable();
            iTable.fnDraw(false);
        }

        function numformat(val) {
            while (/(\d+)(\d{3})/.test(val.toString())) {
                val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
            }
            return val;
        }

        function getDateTimeTZ(timezone) {
            const now = new Date();

            const parts = new Intl.DateTimeFormat('en-US', {
                timeZone: timezone,
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: true
            }).formatToParts(now);

            const map = {};
            parts.forEach(p => map[p.type] = p.value);

            return `${map.year}-${map.month}-${map.day} @ ${map.hour}:${map.minute}:${map.second} ${map.dayPeriod}`;
        }
    </script>
@endsection
