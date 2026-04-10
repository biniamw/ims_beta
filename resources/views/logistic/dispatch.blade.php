@extends('layout.app1')

@section('title')
@endsection

@section('content')
    @can('Dispatch-View')
    <div class="app-content content">
        <section id="responsive-datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-header border-bottom fit-content mb-0 pb-0">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align: left !important;align-items: center;padding: 10px 5px;">
                                        <h3 class="card-title form_title">Dispatch</h3>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align: right !important;align-items: center;padding: 10px 5px;">
                                        <button type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm" onclick="refreshDispatchDataFn()"><i class="fas fa-sync-alt"></i></button>
                                        @can('Dispatch-Add')
                                        <button type="button" class="btn btn-gradient-info btn-sm addDispatch header-prop" id="addDispatch"><i class="fas fa-plus"></i><span class="header-text">&nbsp Add</span></button>
                                        @endcan 
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-datatable">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 fit-content">
                                <div class="row mt-1 border-bottom mx-n2 pl-1">
                                    <div class="col-6 col-sm-3 col-lg custom-col mb-1">
                                        <div class="stat-item">
                                            <div class="media">
                                                <div class="avatar bg-light-secondary mr-1">
                                                    <div class="avatar-content">
                                                        <i class="fas fa-dolly-flatbed-alt"></i>
                                                    </div>
                                                </div>
                                                <div class="media-body my-auto mr-1">
                                                    <span class="font-weight-bolder mb-0 dispatch_status_record_lbl" id="dispatch_draft_record_lbl"></span>
                                                    <p class="card-text font-small-3 mb-0">Draft</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-3 col-lg custom-col mb-1">
                                        <div class="stat-item">
                                            <div class="media">
                                                <div class="avatar bg-light-warning mr-1">
                                                    <div class="avatar-content">
                                                        <i class="fas fa-dolly-flatbed-alt"></i>
                                                    </div>
                                                </div>
                                                <div class="media-body my-auto mr-1">
                                                    <span class="font-weight-bolder mb-0 dispatch_status_record_lbl" id="dispatch_pending_record_lbl"></span>
                                                    <p class="card-text font-small-3 mb-0">Pending</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-3 col-lg custom-col mb-1">
                                        <div class="stat-item">
                                            <div class="media">
                                                <div class="avatar bg-light-primary mr-1">
                                                    <div class="avatar-content">
                                                        <i class="fas fa-dolly-flatbed-alt"></i>
                                                    </div>
                                                </div>
                                                <div class="media-body my-auto mr-1">
                                                    <span class="font-weight-bolder mb-0 dispatch_status_record_lbl" id="dispatch_verified_record_lbl"></span>
                                                    <p class="card-text font-small-3 mb-0">Verified</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-3 col-lg custom-col mb-1">
                                        <div class="stat-item">
                                            <div class="media">
                                                <div class="avatar bg-light-success mr-1">
                                                    <div class="avatar-content">
                                                        <i class="fas fa-dolly-flatbed-alt"></i>
                                                    </div>
                                                </div>
                                                <div class="media-body my-auto mr-1">
                                                    <span class="font-weight-bolder mb-0 dispatch_status_record_lbl" id="dispatch_approved_record_lbl"></span>
                                                    <p class="card-text font-small-3 mb-0">Approved</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-3 col-lg custom-col mb-1" style="display: none;">
                                        <div class="stat-item">
                                            <div class="media">
                                                <div class="avatar bg-light-success mr-1">
                                                    <div class="avatar-content">
                                                        <i class="fas fa-dolly-flatbed-alt"></i>
                                                    </div>
                                                </div>
                                                <div class="media-body my-auto mr-1">
                                                    <span class="font-weight-bolder mb-0 dispatch_status_record_lbl" id="dispatch_received_record_lbl"></span>
                                                    <p class="card-text font-small-3 mb-0">Received</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-3 col-lg custom-col mb-1">
                                        <div class="stat-item">
                                            <div class="media">
                                                <div class="avatar bg-light-danger mr-1">
                                                    <div class="avatar-content">
                                                        <i class="fas fa-dolly-flatbed-alt"></i>
                                                    </div>
                                                </div>
                                                <div class="media-body my-auto mr-1">
                                                    <span class="font-weight-bolder mb-0 dispatch_status_record_lbl" id="dispatch_void_record_lbl"></span>
                                                    <p class="card-text font-small-3 mb-0">Void</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-3 col-lg custom-col mb-1">
                                        <div class="stat-item">
                                            <div class="media">
                                                <div class="avatar bg-light-secondary mr-1">
                                                    <div class="avatar-content">
                                                        <i class="fas fa-dolly-flatbed-alt"></i>
                                                    </div>
                                                </div>
                                                <div class="media-body my-auto mr-1">
                                                    <span class="font-weight-bolder mb-0 dispatch_status_record_lbl" id="dispatch_total_record_lbl"></span>
                                                    <p class="card-text font-small-3 mb-0">Total</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>      
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 fit-content">
                                <div class="row main_datatable" id="dispatch_tbl">
                                    <div style="width:99%; margin-left:0.5%;">
                                        <table id="laravel-datatable-crud" class="display table-bordered table-striped table-hover defaultdatatable mb-0 mobile-dt" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th style="display: none;"></th>
                                                    <th style="width:3%;">#</th>
                                                    <th style="width:11%;" title="Dispatch Document Number">Document No.</th>
                                                    <th style="width:10%;">Dispatch Type</th>
                                                    <th style="width:10%;">Dispatch Mode</th>
                                                    <th style="width:11%;">Driver/ Person Name</th>
                                                    <th style="width:11%;" title="Driver or Person Phone Number">Driver/ Person Phone No.</th>
                                                    <th style="width:10%;" title="Driver License Number">Driver License No.</th>
                                                    <th style="width:10%;" title="Plate Number">Plate No.</th>
                                                    <th style="width:10%;">Date</th>
                                                    <th style="width:10%;">Status</th>
                                                    <th style="width:4%;">Action</th>
                                                    <th style="display: none;"></th>
                                                    <th style="display: none;"></th>
                                                </tr>
                                            </thead>
                                            <tbody class="table table-sm"></tbody>
                                        </table>
                                    </div>
                                </div>
                                <input type="hidden" class="form-control" name="fiscalyearval" id="fiscalyearval" value="{{$fiscalyr}}" readonly/>
                                <input type="hidden" class="form-control" name="currentdateval" id="currentdateval" value="{{$curdate}}" readonly/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @endcan

    <!--Start Info Modal -->
    <div class="modal fade text-left fit-content" id="dispInfoModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="dispatchinfotitle" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title form_title" id="dispatchinfotitle">Dispatch Information</h4>
                    <div class="row">
                        <div style="text-align: right" class="form_title info_modal_title_lbl" id="statustitles"></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <form id="dispatchInfoform">
                    @csrf
                    <div class="modal-body">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <section id="card-text-alignment">
                                        <div class="d-flex justify-content-between align-items-center cursor-pointer border-bottom" data-toggle="collapse" data-target=".infoscl" aria-expanded="true">
                                            <h5 class="mb-0 form_title dispatch_header_info"><i class="far fa-info-circle"></i> Basic Information</h5>
                                            <div class="d-flex align-items-center header-tab">
                                                <span class="text-uppercase font-weight-bold mr-50 toggle-text-label tab-text">Collapse</span>
                                                <div class="collapse-icon">
                                                    <i class="fas text-secondary fa-minus-circle"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="collapse show infoscl shadow pl-1 pr-1">
                                            <div class="row mb-1">
                                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mt-1 mb-1">
                                                    <div class="card shadow-none border m-0">
                                                        <div class="card-body">
                                                            <h6 class="card-title mb-0"><i class="fas fa-database"></i> General</h6>
                                                            <hr class="my-50">
                                                            <table class="infotbl" style="width:100%;font-size:12px;">
                                                                <tr>
                                                                    <td><label class="info_lbl">Dispatch Type</label></td>
                                                                    <td><label class="info_lbl" id="infoDispatchTypeLbl" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl">Dispatch Mode</label></td>
                                                                    <td><label class="info_lbl" id="infoDispatchModeLbl" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl">Date</label></td>
                                                                    <td><label class="info_lbl" id="infoDate" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl">Remark</label></td>
                                                                    <td><label class="info_lbl" id="infoRemark" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mt-1 mb-1 allinfo vehinfo">
                                                    <div class="card shadow-none border m-0">
                                                        <div class="card-body">
                                                            <h6 class="card-title mb-0"><i class="fas fa-truck-moving"></i> Vehicle Detail</h6>
                                                            <hr class="my-50">
                                                            <table class="infotbl" style="width:100%;font-size:12px;">
                                                                <tr>
                                                                    <td><label class="info_lbl">Driver Name</label></td>
                                                                    <td><label class="info_lbl" id="infoDriverNameLbl" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl" title="Driver License Number">Driver License No.</label></td>
                                                                    <td><label class="info_lbl" id="infoDriverLiceNoLbl" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl" title="Driver Phone Number">Driver Phone No.</label></td>
                                                                    <td><label class="info_lbl" id="infoDriverPhoneNoLbl" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl" title="Plate Number">Plate No.</label></td>
                                                                    <td><label class="info_lbl" id="infoPlateNoLbl" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr style="display: none;">
                                                                    <td><label class="info_lbl" title="Container Number">Container No.</label></td>
                                                                    <td><label class="info_lbl" id="infoContainerNoLbl" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr style="display: none;">
                                                                    <td><label class="info_lbl" title="Seal Number">Seal No.</label></td>
                                                                    <td><label class="info_lbl" id="infoSealNoLbl" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mt-1 mb-1 allinfo perinfo">
                                                    <div class="card shadow-none border m-0">
                                                        <div class="card-body">
                                                            <h6 class="card-title mb-0"><i class="fas fa-person-dolly"></i> Person's Detail</h6>
                                                            <hr class="my-50">
                                                            <table class="infotbl" style="width:100%;font-size:12px;">
                                                                <tr>
                                                                    <td><label class="info_lbl">Person's Name</label></td>
                                                                    <td><label class="info_lbl" id="infoPersonNameLbl" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl" title="Person's Phone Number">Person's Phone No.</label></td>
                                                                    <td><label class="info_lbl" id="infoPersonPhoneLbl" style="font-weight: bold;"></label></td>
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
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="table-responsive scroll scrdiv">
                                        <div class="row infoRecDiv">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="dispatch_item_div">
                                                <table id="dispatchinfodatatbl" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable" style="width: 100%">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:3%;">#</th>
                                                            <th style="width:16%;" title="Sales, Transfer, Requisition Reference Number">Reference No.</th>
                                                            <th style="width:10%;">Item Code</th>
                                                            <th style="width:17%;">Item Name</th>
                                                            <th style="width:10%;" title="Barcode Number">Barcode No.</th>
                                                            <th style="width:6%;" title="Unit of Measurement">UOM</th>
                                                            <th style="width:10%;" title="Sold or Issued Quantity">Sold/ Issued Qty.</th>
                                                            <th style="width:10%;" title="Dispatched Quantity">Dispatched Qty.</th>
                                                            <th style="width:18%;">Remark</th>
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
                    <div class="modal-footer">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align:left">
                                    <div class="btn-group dropup">
                                        <button type="button" class="btn btn-outline-info dropdown-toggle hide-arrow action-btn form_btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa-sharp fa-solid fa-caret-up fa-xl"></i><span class="btn-text">&nbsp Actions</span>
                                        </button>
                                        <ul class="dropdown-menu" id="dispatch_action_ul"></ul>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align:right">
                                    <input type="hidden" class="form-control" name="dispatch_type_inp" id="dispatch_type_inp" readonly="true">
                                    <input type="hidden" class="form-control" name="dispid" id="dispid" readonly="true">
                                    <input type="hidden" class="form-control" name="reqId" id="reqId" readonly="true">
                                    <input type="hidden" class="form-control" name="currentStatus" id="currentStatus" readonly="true">
                                    <input type="hidden" class="form-control" name="forwardReqId" id="forwardReqId" readonly="true">
                                    <input type="hidden" class="form-control" name="newForwardStatusValue" id="newForwardStatusValue" readonly="true">
                                    <input type="hidden" class="form-control" name="forwarkBtnTextValue" id="forwarkBtnTextValue" readonly="true">
                                    <input type="hidden" class="form-control" name="forwardActionValue" id="forwardActionValue" readonly="true">
                                    <button id="closebuttondisp" type="button" class="btn btn-danger form_btn" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Info -->

    <div class="modal fade text-left fit-content" id="inlineForm" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title form_title" id="dispatchtitle"></h4>
                    <div class="row">
                        <div style="text-align: right;" class="form_title" id="dispatchstatus"></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeRegModal()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>  
                </div>
                <form id="Register">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-4 col-lg-5 col-md-12 col-sm-12 col-12 mb-1"> 
                                <fieldset class="fset">
                                    <legend>General</legend>
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 mb-1">
                                            <label class="form_lbl">Type<b style="color: red; font-size:16px;">*</b></label>
                                            <select class="select2 form-control" name="DispatchType" id="DispatchType" onchange="dispatchTypeFn()">
                                                <option value="1">Sales</option>
                                                <option value="2">Transfer</option>
                                                {{-- <option value="3">Requisition</option> --}}
                                            </select>
                                            <span class="text-danger">
                                                <strong id="dispatchtype-error" class="errordatalabel"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 mb-1">
                                            <label class="form_lbl">Dispatch Mode<b style="color: red; font-size:16px;">*</b></label>
                                            <select class="select2 form-control" name="DispatchMode" id="DispatchMode" onchange="dispatchModeFn()">
                                                @foreach ($dispmodedata as $dispmodeform)
                                                <option value="{{$dispmodeform->DispatchModeValue}}">{{$dispmodeform->DispatchModeName}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">
                                                <strong id="dispatchmode-error" class="errordatalabel"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 mb-1">
                                            <label class="form_lbl">Date<b style="color: red; font-size:16px;">*</b></label>
                                            <input type="text" id="date" name="date" class="form-control flatpickr-basic generalcls" placeholder="YYYY-MM-DD" onchange="dateVal()"/>
                                            <span class="text-danger">
                                                <strong id="date-error" class="errordatalabel"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                            <label class="form_lbl">Remark</label>
                                            <textarea type="text" placeholder="Write Remark here..." class="form-control generalcls" name="Remark" id="Remark" rows="1"></textarea>
                                            <span class="text-danger">
                                                <strong id="remark-error" class="errordatalabel"></strong>
                                            </span>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-xl-8 col-lg-7 col-md-12 col-sm-12 col-12 mb-1 vech mainprop">
                                <fieldset class="fset">
                                    <legend>Vehicle Detail</legend>
                                    <div class="row">
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                                            <label class="form_lbl">Driver Name<b style="color: red; font-size:16px;">*</b></label>
                                            <input type="text" placeholder="Write Driver name here" class="form-control mainforminp" name="DriverName" id="DriverName" onkeyup="driverNameFn()"/>
                                            <span class="text-danger">
                                                <strong id="drivername-error" class="errordatalabel dispmode_err"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                                            <label class="form_lbl" title="Driver License Number">Driver License No.<b style="color: red; font-size:16px;">*</b></label>
                                            <input type="text" placeholder="Write Driver license number here" class="form-control mainforminp" name="DriverLicenseNo" id="DriverLicenseNo" onkeyup="driverLicFn()"/>
                                            <span class="text-danger">
                                                <strong id="driverlic-error" class="errordatalabel dispmode_err"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                                            <label class="form_lbl" title="Driver Phone Number">Driver Phone No.<b style="color: red; font-size:16px;">*</b></label>
                                            <input type="tel" placeholder="+251-XXX-XX-XX-XX" class="form-control mainforminp phone_number" name="DriverPhoneNo" id="DriverPhoneNo" onkeyup="driverPhoneFn()"/>
                                            <span class="text-danger">
                                                <strong id="driverphone-error" class="errordatalabel dispmode_err"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                                            <label class="form_lbl" title="Plate Number">Plate No.<b style="color: red; font-size:16px;">*</b></label>
                                            <input type="text" name="PlateNumber" id="PlateNumber" placeholder="Write Truck plate number here" class="PlateNumber form-control mainforminp" onkeyup="plateNumFn()" style="text-transform:uppercase"/>
                                            <span class="text-danger">
                                                <strong id="platenum-error" class="errordatalabel dispmode_err"></strong>
                                            </span>
                                        </div>

                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-1 mainprop">
                                            <label class="form_lbl" title="Container Number">Container No.</label>
                                            <input type="text" placeholder="Write Container number here" class="ContainerNumber form-control mainforminp" name="ContainerNumber" id="ContainerNumber" onkeyup="containerNumFn()"/>
                                            <span class="text-danger">
                                                <strong id="containernumber-error" class="errordatalabel dispmode_err"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-1 mainprop">
                                            <label class="form_lbl" title="Seal Number">Seal No.</label>
                                            <input type="text" placeholder="Write Seal number here" class="SealNumber form-control mainforminp" name="SealNumber" id="SealNumber" onkeyup="sealNumFn()"/>
                                            <span class="text-danger">
                                                <strong id="sealnumber-error" class="errordatalabel dispmode_err"></strong>
                                            </span>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-xl-8 col-lg-7 col-md-12 col-sm-12 col-12 mb-1 per mainprop">
                                <fieldset class="fset">
                                    <legend>Person's Detail</legend>
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                                            <label class="form_lbl">Person's Name<b style="color: red; font-size:16px;">*</b></label>
                                            <input type="text" placeholder="Write Person's full name here" class="form-control mainforminp" name="PersonName" id="PersonName" onkeyup="personNameFn()"/>
                                            <span class="text-danger">
                                                <strong id="personname-error" class="errordatalabel dispmode_err"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                                            <label class="form_lbl" title="Person's Phone Number">Person's Phone No.<b style="color: red; font-size:16px;">*</b></label>
                                            <input type="tel" placeholder="+251-XXX-XX-XX-XX" class="form-control mainforminp phone_number" name="PersonPhoneNo" id="PersonPhoneNo" onkeyup="personPhoneFn()"/>
                                            <span class="text-danger">
                                                <strong id="personphone-error" class="errordatalabel dispmode_err"></strong>
                                            </span>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <hr class="my-30"/>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="table-responsive pr-0 pl-0" style="width: 100%;overflow-x: auto;-webkit-overflow-scrolling: touch;margin: 0 0rem;padding: 0 1rem;">
                                    <table id="dynamicTable" class="mb-0 rtable fit-content" style="width:100%;">
                                        <thead>
                                            <th style="width:3%;">#</th>
                                            <th style="width:14%;" title="Sales, Transfer, Requisition Document Number">Reference No.<b style="color: red; font-size:16px;">*</b></th>
                                            <th style="width:20%;">Item Name<b style="color: red; font-size:16px;">*</b></th>
                                            <th style="width:10%;" title="Unit of Measurement">UOM</th>
                                            <th style="width:11%;" title="Sold/ Issued Quantity" id="qty_data">Sold/ Issued Qty.</th>
                                            <th style="width:11%;" title="Remaining Quantity">Remaining  Qty.</th>
                                            <th style="width:11%;" title="Dispatch Quantity">Dispatch Qty.<b style="color: red; font-size:16px;">*</b></th>
                                            <th style="width:14%;">Remark</th>
                                            <th style="width:6%;"></th>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                    <table style="width:100%">
                                        <tr>
                                            <td>
                                                <button type="button" name="adds" id="adds" class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i> Add New</button>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div style="display: none;">
                            <select class="select2 form-control TransferDocDefault" name="TransferDocDefault" id="TransferDocDefault">
                                <option selected disabled value=""></option>
                                @foreach ($transferdocnum as $transferdocnum)
                                    <option data-type="{{ $transferdocnum->type }}" value="{{ $transferdocnum->id }}">{{ $transferdocnum->DocumentNumber }}</option>
                                @endforeach 
                            </select>
                            <select class="select2 form-control ItemNameDefault" name="ItemNameDefault" id="ItemNameDefault">
                                <option selected disabled value=""></option>
                                @foreach ($transferitem as $transferitem)
                                    <option title="{{$transferitem->HeaderId }}" label="{{ $transferitem->ItemId }}" value="{{ $transferitem->id }}">{{ $transferitem->ItemName }}</option>
                                @endforeach 
                            </select>
                            <select class="select2 form-control salesitemdata" name="salesitemdata" id="salesitemdata">
                                <option selected disabled value=""></option>
                                @foreach ($salesitem as $salesitem)
                                    <option title="{{$salesitem->HeaderId }}" label="{{ $salesitem->ItemId }}" value="{{ $salesitem->id }}">{{ $salesitem->ItemName }}</option>
                                @endforeach 
                            </select>
                        </div>
                        <input type="hidden" class="form-control" name="recordId" id="recordId" readonly="true"/>
                        <input type="hidden" class="form-control" name="operationtypes" id="operationtypes" readonly="true" value="1"/>
                        <button id="savebutton" type="button" class="btn btn-info">Save</button>
                        <button id="closebutton" type="button" class="btn btn-danger" onclick="closeRegModal()" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--Start Dispatch-Void Modal -->
    <div class="modal fade text-left" id="voiddispatchmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="voiddispatchtitle">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="voiddispatchform">
                    @csrf
                    <div class="modal-body">
                        <label class="form_lbl">Reason</label>
                        <textarea type="text" placeholder="Write Reason here..." class="form-control DispatchReason" rows="3" name="DispatchReason" id="DispatchReason" onkeyup="voidDispReason()"></textarea>
                        <span class="text-danger">
                            <strong id="dispvoid-error"></strong>
                        </span>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control" name="voiddispid" id="voiddispid" readonly="true">
                        <button id="voiddispatchbtn" type="button" class="btn btn-info">Void</button>
                        <button id="closebuttonvoiddisp" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Dispatch-Void Modal -->

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
                            <textarea type="text" placeholder="Write Reason here..." class="form-control" rows="3" name="CommentOrReason" id="CommentOrReason" onkeyup="dispatchReasonFn()"></textarea>
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

    <!--Start Reference Info Modal -->
    <div class="modal modal-slide-in event-sidebar fade fit-content" id="reqInfoModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <form id="TransferInfoForm"> 
            {{ csrf_field() }}
            <div class="modal-dialog sidebar-xl" style="width:95%;">
                <div class="modal-content p-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #ea5455 !important;font-weight:bold;">x</button>
                    <div class="modal-header">
                        <h4 class="modal-title form_title" id="detailinfomodaltitle"></h4>
                        <div style="text-align: center;padding-right:30px;" class="form_title info_modal_title_lbl" id="statusdisplay"></div>
                    </div>
                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <section id="card-text-alignment">
                                        <div class="d-flex justify-content-between align-items-center cursor-pointer border-bottom" data-toggle="collapse" data-target=".inforef" aria-expanded="true">
                                            <h5 class="mb-0 form_title reference_header_info"><i class="far fa-info-circle"></i> Basic Information</h5>
                                            <div class="d-flex align-items-center header-tab">
                                                <span class="text-uppercase font-weight-bold mr-50 toggle-text-label tab-text">Collapse</span>
                                                <div class="collapse-icon">
                                                    <i class="fas text-secondary fa-minus-circle"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="collapse show inforef shadow pl-1 pr-1">
                                            <div class="row mb-1">
                                                <div class="col-xl-6 col-lg-8 col-md-12 col-sm-12 col-12 mt-1 mb-1">
                                                    <div class="card shadow-none border m-0">
                                                        <div class="card-body">
                                                            <h4 class="card-title mb-0"></h4>
                                                            <table class="infotbl info_tbl" id="transfer_data" style="width:100%;font-size:12px;display: none;">
                                                                <tr style="display: none;">
                                                                    <td><label class="info_lbl" title="Transfer Document Number">Transfer Doc. No.</label></td>
                                                                    <td><label class="info_lbl" id="infodocnum" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl">Source Station</label></td>
                                                                    <td><label class="info_lbl" id="infosourcestore" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl">Destination Station</label></td>
                                                                    <td><label class="info_lbl" id="infodestinationstore" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr style="display: none;">
                                                                    <td><label class="info_lbl">Deliver By</label></td>
                                                                    <td><label class="info_lbl" id="infodeliveredby" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr style="display: none;">
                                                                    <td><label class="info_lbl">Shipment Date</label></td>
                                                                    <td><label class="info_lbl" id="infodelivereddate" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl">Reason</label></td>
                                                                    <td><label class="info_lbl" id="infopurpose" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl">Dispatch Status</label></td>
                                                                    <td><label class="info_lbl" id="infodispatchstatus" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                            </table>
                                                            <table class="infotbl info_tbl" id="sales_data" style="width:100%;font-size:12px;display: none;">
                                                                <tr>
                                                                    <td><label class="info_lbl">Point of Sales</label></td>
                                                                    <td><label class="info_lbl" id="pos_lbl" style="font-weight:bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl">Voucher Type</label></td>
                                                                    <td><label class="info_lbl" id="voucher_type" style="font-weight:bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl">Payment Type</label></td>
                                                                    <td><label class="info_lbl" id="payment_type" style="font-weight:bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl" title="Document or FS Number">Doc/ FS No.</label></td>
                                                                    <td><label class="info_lbl" id="fs_number" style="font-weight:bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl" title="Invoice Number">Invoice No.</label></td>
                                                                    <td><label class="info_lbl" id="inv_number" style="font-weight:bold;"></label></td>
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
                            <div class="row detail_info_tbl" id="dt_info_tbl">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="table-responsive scroll scrdiv">
                                        <div class="row">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="requisition_item_div">
                                                <table id="sales_info_dt" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable" style="width: 100%">
                                                    <thead>
                                                        <th style="width: 3%;">#</th>
                                                        <th style="width: 14%;">Item Code</th>
                                                        <th style="width: 14%;">Item Name</th>
                                                        <th style="width: 14%;" title="Barcode Number">Barcode No.</th>
                                                        <th style="width: 13%;" title="Unit of Measurement">UOM</th>
                                                        <th style="width: 13%;" title="Sold Quantity">Sold Qty.</th>
                                                        <th style="width: 13%;" title="Dispatched Quantity">Dispatched Qty.</th>
                                                        <th style="width: 16%;">Remark</th>
                                                    </thead>
                                                    <tbody class="table table-sm"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row detail_info_tbl" id="detailcontent">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="table-responsive scroll scrdiv">
                                        <div class="row">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="requisition_item_div">
                                                <table id="reqinfodetail" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable" style="width: 100%">
                                                    <thead>
                                                        <th style="width: 3%;">#</th>
                                                        <th style="width: 10%;">Item Code</th>
                                                        <th style="width: 10%;">Item Name</th>
                                                        <th style="width: 10%;" title="Barcode Number">Barcode No.</th>
                                                        <th style="width: 7%;" title="Unit of Measurement">UOM</th>
                                                        <th style="width: 10%;" title="Requested Quantity">Requested Qty.</th>
                                                        <th style="width: 10%;" title="Approved Quantity">Approved Qty.</th>
                                                        <th style="width: 10%;" title="Issued Quantity">Issued Qty.</th>
                                                        <th style="width: 10%;" title="Dispatched Quantity">Dispatched Qty.</th>
                                                        <th style="width: 10%;">Requested Remark</th>
                                                        <th style="width: 10%;">Approved Remark</th>
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
                    <div class="modal-footer">
                        <button id="closebuttone" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- End Reference Info Modal -->

    @include('layout.universal-component')

    <script type="text/javascript">
        var errorcolor = "#ffcccc";
        var fyears = $('#fiscalyearval').val();
        var current_date = $('#currentdateval').val();
        var table = "";
        var gblIndex = -1;

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
            },
            'Approved': {
                forward: {
                    status: 'Received',
                    text: 'Receive',
                    action: 'Receive',
                    message: 'Are you sure you want to change the status of this record to Received?'
                },
                backward: {
                    status: 'Verified',
                    text: 'Back to Verify',
                    action: 'Back to Verify',
                    message: 'Reason'
                },
            },
            'Received': {
                
            },
        };
        
        var j = 0;
        var i = 0;
        var m = 0;

        var j2 = 0;
        var i2 = 0;
        var m2 = 0;

        var j3 = 0;
        var i3 = 0;
        var m3 = 0;

        var j4 = 0;
        var i4 = 0;
        var m4 = 0;

        $(function () {
            cardSection = $('#page-block');
        });

        $(document).ready(function() {
            $('#fiscalyear').select2();
            $('.main_datatable').hide(); 
            countDispatchStatusFn(fyears);
            fetchDispatchFn(fyears);
        });

        function fetchDispatchFn(fy){
            table = $('#laravel-datatable-crud').DataTable({
                destroy:true,
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
                fixedHeader:true,
                dom: "<'row'<'col-sm-3 col-md-2 col-6'f><'col-sm-3 col-md-2 col-6 mt-1 dispatch-custom-1'><'col-sm-3 col-md-2 col-6 mt-1 dispatch-custom-2'><'col-sm-3 col-md-2 col-6 mt-1 dispatch-custom-3'><'col-sm-3 col-md-2 col-12 mt-1 dispatch-custom-4'>>" +
                    "<'row'<'col-sm-12 margin_top_class'tr>>" +
                    "<'row'<'col-sm-4 col-md-4 col-4'l><'col-sm-4 col-md-4 col-4 d-flex justify-content-center'i><'col-sm-4 col-md-4 col-4 d-flex justify-content-end'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/getDispatchData/' + fy,
                    type: 'DELETE',
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
                        setFocus('#laravel-datatable-crud');
                        $('#laravel-datatable-crud').DataTable().columns.adjust();
                    },
                },
                columns: [{
                        data: 'id',
                        name: 'id',
                        "render": function ( data, type, row, meta ) {
                            return "";
                        },
                        'visible': false
                    },
                    {
                        data:'DT_RowIndex',
                        width:"3%"
                    },
                    {
                        data: 'DispatchDocNo',
                        name: 'DispatchDocNo',
                        width:"11%"
                    },
                    {
                        data: 'DispatchType',
                        name: 'dispatchparents.Type',
                        width:"10%"
                    },
                    {
                        data: 'DispatchModeName',
                        name: 'DispatchModeName',
                        width:"10%"
                    },
                    {
                        data: 'DriverOrPersonName',
                        name: 'DriverOrPersonName',
                        width:"11%"
                    },
                    {
                        data: 'DriverOrPersonPhone',
                        name: 'DriverOrPersonPhone',
                        width:"11%"
                    },
                    {
                        data: 'DriverLicenseNo',
                        name: 'DriverLicenseNo',
                        width:"10%"
                    },
                    {
                        data: 'PlateNumber',
                        name: 'PlateNumber',
                        width:"10%"
                    },
                    {
                        data: 'Date',
                        name: 'Date',
                        width:"10%"
                    },
                    {
                        data: 'Status',
                        name: 'Status',
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
                            else if(data == "Approved" || data == "Received"){
                                return `<span class="badge bg-success bg-glow">${data}</span>`;
                            }
                            else if(data == "Void"){
                                return `<span class="badge bg-danger bg-glow">${data}</span>`;
                            }
                            else{
                                return `<span class="badge bg-danger bg-glow">${data}</span>`;
                            }
                        },
                        width:"10%"
                    },
                    { 
                        data: 'action', 
                        name: 'action',
                        "render": function ( data, type, row, meta ) {
                            return `<div class="text-center"><a class="infoDispatch" href="javascript:void(0)" onclick="infoDispatchFn(${row.id})" data-id="infoDispatch${row.id}" id="infoDispatch${row.id}" title="Open dispatch information form"><i class="fa-sharp fa-regular fa-circle-info fa-xl" style="color: #00cfe8;"></i></a></div>`;
                        },
                        width:"4%",
                    },
                    { 
                        data: 'Type', 
                        name: 'Type',
                        "render": function ( data, type, row, meta ) {
                            return "";
                        },
                        'visible': false
                    },
                    { 
                        data: 'DispatchMode', 
                        name: 'DispatchMode',
                        "render": function ( data, type, row, meta ) {
                            return "";
                        },
                        'visible': false
                    },
                ],
                createdRow: function(row, data, dataIndex) {
                    $('td', row).each(function() {
                        // If the cell's text is "0", set it to an empty string
                        if ($(this).text() == "NULL" || $(this).text() === "NULL") {
                            $(this).text('');
                        }
                    });
                },
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
                    $('#dispatch_tbl').show();
                    $('#laravel-datatable-crud').DataTable().columns.adjust();
                },
                fixedHeader: {
                    header: true,
                    headerOffset: $('.header-navbar').outerHeight(),
                },
            });

            appendDispatchFilterFn(fy);
        }

        function setFocus(){ 
            $($('#laravel-datatable-crud tbody > tr')[gblIndex]).addClass('selected');  
        }

        $('#laravel-datatable-crud tbody').on('click', 'tr', function () {
            $('#laravel-datatable-crud tbody > tr').removeClass('selected');
            $(this).addClass('selected');
            gblIndex = $(this).index();
        });

        function appendDispatchFilterFn(fyears){
            var dispatch_fiscalyear = $(`
                <select class="selectpicker form-control dropdownclass" id="fiscalyear" name="fiscalyear[]" title="Select fiscal year here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" data-actions-box="true" data-selected-text-format="count" data-count-selected-text="Fiscal Year ({0})">
                    @foreach ($fiscalyears as $fiscalyears)
                        <option value="{{ $fiscalyears->FiscalYear }}">{{ $fiscalyears->Monthrange }}</option>
                    @endforeach
                </select>`);

            $('.dispatch-custom-1').html(dispatch_fiscalyear);
            $('#fiscalyear')
            .selectpicker()
            .selectpicker('val', fyears)
            .off('changed.bs.select') 
            .on('changed.bs.select', function () {
                let fyear = $(this).val();
                countDispatchStatusFn(fyear);
                fetchDispatchFn(fyear); 
            });

            var dispatch_type_filter = $(`
                <select class="selectpicker form-control dropdownclass" id="dis_type_filter" name="dis_type_filter[]" title="Select dispatch type here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" data-actions-box="true" multiple data-selected-text-format="count" data-count-selected-text="Dispatch Type ({0})">
                    <option selected value="1">Sales</option>
                    <option selected value="2">Transfer</option>
                </select>`);

            $('.dispatch-custom-2').html(dispatch_type_filter);
            $('#dis_type_filter')
            .selectpicker()
            .off('changed.bs.select') 
            .on('changed.bs.select', function () {  
                var selected = $('#dis_type_filter option:selected');
                var search = [];

                // Collect selected option values
                $.each(selected, function() {
                    search.push($(this).val());
                });

                if (search.length === 0) {
                    // No option selected: force DataTable to return no data
                    table.column(12).search('^$', true, false).draw();
                } else {
                    var searchRegex = '^(' + search.join('|') + ')$'; // More precise regex pattern
                    table.column(12).search(searchRegex, true, false).draw();
                }
            });

            var dispatch_mode_filter = $(`
                <select class="selectpicker form-control dropdownclass" id="dis_mode_filter" name="dis_mode_filter[]" title="Select dispatch mode here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" data-actions-box="true" multiple data-selected-text-format="count" data-count-selected-text="Dispatch Mode ({0})">
                    @foreach ($dispmodedata as $dispmodefilter)
                        <option selected value="{{ $dispmodefilter->DispatchModeValue }}">{{ $dispmodefilter->DispatchModeName }}</option>
                    @endforeach
                </select>`);

            $('.dispatch-custom-3').html(dispatch_mode_filter);
            $('#dis_mode_filter')
            .selectpicker()
            .off('changed.bs.select') 
            .on('changed.bs.select', function () {  
                var selected = $('#dis_mode_filter option:selected');
                var search = [];

                // Collect selected option values
                $.each(selected, function() {
                    search.push($(this).val());
                });

                if (search.length === 0) {
                    // No option selected: force DataTable to return no data
                    table.column(13).search('^$', true, false).draw(); // Match an impossible pattern
                } else {
                    // Options selected: build regex for filtering
                    var searchRegex = search.join('|'); // OR-separated values for regex
                    table.column(13).search(searchRegex, true, false).draw();
                }
            });

            var status_filter = $(`
                <select class="selectpicker form-control dropdownclass" id="dispatch_status_filter" name="dispatch_status_filter[]" title="Select status here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" data-actions-box="true" multiple data-selected-text-format="count" data-count-selected-text="Status ({0})">
                    <option selected value="Draft">Draft</option>
                    <option selected value="Pending">Pending</option>
                    <option selected value="Verified">Verified</option>
                    <option selected value="Approved">Approved</option>
                    <option selected value="Received">Received</option>
                    <option selected value="Void">Void</option>
                </select>`);

            $('.dispatch-custom-4').html(status_filter);
            $('#dispatch_status_filter')
            .selectpicker()
            .off('changed.bs.select') 
            .on('changed.bs.select', function () {  
                var selected = $('#dispatch_status_filter option:selected');
                var search = [];

                // Collect selected option values
                $.each(selected, function() {
                    search.push($(this).val());
                });

                if (search.length === 0) {
                    // No option selected: force DataTable to return no data
                    table.column(10).search('^$', true, false).draw(); // Match an impossible pattern
                } else {
                    // Options selected: build regex for filtering
                    var searchRegex = search.join('|'); // OR-separated values for regex
                    table.column(10).search(searchRegex, true, false).draw();
                }
            });
        }

        function countDispatchStatusFn(fiscalyear) {
            var fyear = 0;
            var disp_void_cnt = 0;
            
            $.ajax({
                url: '/countDispatchStatus',
                type: 'POST',
                data:{
                    fyear: fiscalyear,
                },
                dataType: 'json',
                success: function(data) {
                    $(".dispatch_status_record_lbl").html("0");
                    $.each(data.dispatch_status_count, function(key, value) {
                        if(value.Status == "Draft"){
                            $("#dispatch_draft_record_lbl").html(value.status_count);
                        }
                        else if(value.Status == "Pending"){
                            $("#dispatch_pending_record_lbl").html(value.status_count);
                        }
                        else if(value.Status == "Verified"){
                            $("#dispatch_verified_record_lbl").html(value.status_count);
                        }
                        else if(value.Status == "Approved"){
                            $("#dispatch_approved_record_lbl").html(value.status_count);
                        }
                        else if(value.Status == "Received"){
                            $("#dispatch_received_record_lbl").html(value.status_count);
                        }
                        else if(value.Status == "Total"){
                            $("#dispatch_total_record_lbl").html(value.status_count);
                        }
                        else {
                            disp_void_cnt += parseInt(value.status_count);
                            $("#dispatch_void_record_lbl").html(disp_void_cnt);
                        }
                    });
                }
            });
        }

        function refreshDispatchDataFn(){
            var f_year = $('#fiscalyear').val();
            countDispatchStatusFn(f_year);

            var rTable = $('#laravel-datatable-crud').dataTable();
            rTable.fnDraw(false);
        }

        $("#addDispatch").click(function() {
            resetDispatchFormFn();
            $("#dispatchtitle").html('Add Dispatch');
            $('#savebutton').text('Save');
            $('#savebutton').prop("disabled",false);
            $("#inlineForm").modal('show');
        });

        function resetDispatchFormFn(){
            $('#DispatchMode').val(null).select2({
                placeholder:"Select Dispatch mode here",
                minimumResultsForSearch: -1
            });
            $('#DispatchType').val(null).select2({
                placeholder:"Select Dispatch type here",
                minimumResultsForSearch: -1
            });
            $('.mainprop').hide();
            $('.mainforminp').val("");
            $('.generalcls').val("");
            $('#operationtypes').val(1);
            $('#recordId').val("");
            $('#dispatchstatus').html("");
            $('.errordatalabel').html("");
            flatpickr('#date', { dateFormat: 'Y-m-d',clickOpens:true,maxDate:current_date});
            $("#dynamicTable > tbody").empty();
        }

        $("#adds").click(function() {
            var lastrowcount = $('#dynamicTable > tbody > tr:last').find('td').eq(1).find('input').val();
            var docnumber = $(`#DocumentNum${lastrowcount}`).val();
            var itemids = $(`#ItemName${lastrowcount}`).val();
            var type = $("#DispatchType").val();
            if((docnumber !== undefined && docnumber === null) || (itemids !== undefined && itemids === null)){
                if(docnumber !== undefined && docnumber === null){
                    $(`#select2-DocumentNum${lastrowcount}-container`).parent().css('background-color',errorcolor);
                }
                if(itemids !== undefined && itemids === null){
                    $(`#select2-ItemName${lastrowcount}-container`).parent().css('background-color',errorcolor);
                }
                toastrMessage('error',"Please select item from highlighted field","Error");
            }
            else{
                ++i;
                ++m;
                j += 1;

                $("#dynamicTable > tbody").append(`<tr><td style="font-weight:bold;text-align:center;width:3%">${j}</td>'+
                    <td style="display:none;"><input type="hidden" name="row[${m}][vals]" id="vals${m}" class="vals form-control" readonly="true" style="font-weight:bold;" value="${m}"/></td>
                    <td style="width:14%"><select id="DocumentNum${m}" class="select2 form-control DocumentNum" onchange="DocumentNumFn(this)" name="row[${m}][DocumentNum]"></select></td>
                    <td style="width:20%"><select id="ItemName${m}" class="select2 form-control ItemName" onchange="ItemNameFn(this)" name="row[${m}][ItemName]"></select></td>
                    <td style="width:10%"><input id="uom${m}" type="text" name="row[${m}][uom]" placeholder="Unit of Measurement" class="uom form-control" readonly/></td>
                    <td style="width:11%"><input id="issuedqty${m}" type="text" name="row[${m}][issuedqty]" placeholder="Issued Quantity" class="issuedqty form-control" readonly/></td>
                    <td style="width:11%"><input id="remainingqty${m}" type="text" name="row[${m}][remainingqty]" placeholder="Remaining Quantity" class="remainingqty form-control" readonly/></td>
                    <td style="width:11%"><input id="quantity${m}" type="number" name="row[${m}][Quantity]" placeholder="Write dispatch quantity here..." class="quantity form-control numeral-mask" onkeyup="quantityFn(this)" onkeypress="return ValidateNum(event);"/></td>
                    <td style="width:14%"><input id="remark${m}" type="text" name="row[${m}][remark]" placeholder="Write remark here..." class="remark form-control"/></td>
                    <td style="width:6%;text-align:center;"><a class="infodisp" href="javascript:void(0)" onclick="dispInfoFn(${m},1)" id="dispinfo${m}" style="display:none;" title="Show transfer/requisition detail inforamtion"><i class="fa-sharp fa-regular fa-circle-info fa-lg" style="color: #00cfe8;"></i></a><button type="button" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button</td>
                    <td style="display:none;"><input id="id${m}" type="hidden" name="row[${m}][id]" class="id form-control" readonly="true" style="font-weight:bold;"/></td>
                </tr>`);

                var defaultoption = '<option selected disabled value=""></option>';
                var transferdocopt = $("#TransferDocDefault > option").clone();
                $(`#DocumentNum${m}`).append(transferdocopt);
                $(`#DocumentNum${m} option[data-type!="${type}"]`).remove(); 
                $(`#DocumentNum${m}`).append(defaultoption);
                $(`#DocumentNum${m}`).select2
                ({
                    placeholder: "Select document number here",
                    dropdownCssClass : 'commprp',
                });

                $(`#ItemName${m}`).append(defaultoption);
                $(`#ItemName${m}`).select2
                ({
                    placeholder: "Select document no. first",
                    minimumResultsForSearch: -1
                });

                $(`#select2-DocumentNum${m}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
                $(`#select2-ItemName${m}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
                renumberRows();
            }
        });

        $(document).on('click', '.remove-tr', function() {
            $(this).parents('tr').remove();
            renumberRows();
            --i;
        });

        function dispInfoFn(indx,flg){
            var recordId = 0;
            var dispatch_type = 0;
            $('.info_tbl').hide();
            $('.detail_info_tbl').hide();

            if(parseInt(flg) == 1){
                recordId = $(`#DocumentNum${indx}`).val();
                dispatch_type = $('#DispatchType').val();
            }
            else if(parseInt(flg) == 2){
                recordId = indx;
                dispatch_type = $('#dispatch_type_inp').val();
            }

            $.ajax({
                url: '/showDisData'+'/'+recordId+'/'+dispatch_type,
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
                complete: function() {
                    if(dispatch_type == 1){
                        fetchSalesDataFn(recordId);
                    }
                    else if(dispatch_type == 2){
                        fetchTransferDataFn(recordId);
                    }
                },
                success: function(data) {
                    if(dispatch_type == 1){
                        $('#detailinfomodaltitle').text("Sales Information");

                        $.each(data.header_data, function(key,value) {
                            $('#pos_lbl').text(value.pos);
                            $('#voucher_type').text(value.VoucherType);
                            $('#payment_type').text(value.PaymentType);
                            $('#fs_number').text(value.VoucherNumber);
                            $('#inv_number').text(value.invoiceNo);
                            if(value.Status == "Confirmed"){
                                $("#statusdisplay").html(`<span class="form_title" style='color:#28c76f;font-weight:bold;font-size:16px;text-align:right;'>${value.Status}</span>`);
                            }
                        });
                        $('#acc_data_title').text("Sales Basic Information");
                        $('#sales_data').show();
                    }
                    else if(dispatch_type == 2){
                        $('#detailinfomodaltitle').text("Transfer Information");

                        $.each(data.header_data, function(key,value) {
                            $('#infodocnum').text(value.DocumentNumber);
                            $('#infoissuedocnum').text(value.IssueDocNumber); 
                            $('#infosourcestore').text(value.SourceStore);
                            $('#infodestinationstore').text(value.DestinationStore);
                            $('#infopurpose').text(value.Reason);
                            $('#infodispatchstatus').text(value.DispatchStatus);
                            $('#commentslbl').text(value.Memo);
                            $('#infostatus').text(value.Status);
                            $('#infocomment').text(value.Memo);
                            comments = value.Memo;
                            $("#recTrStatus").val(value.Status);

                            if(value.Status == "Issued"){
                                $("#statusdisplay").html(`<span class="form_title" style='color:#7367f0;font-weight:bold;font-size:16px;text-align:right;'>${value.DocumentNumber},     ${value.Status}</span>`);
                            }
                            else if(value.Status == "Issued(Received)" || value.Status == "Issued(Partially-Received)" || value.Status == "Issued(Fully-Received)"){
                                $("#statusdisplay").html(`<span class="form_title" style='color:#7367f0;font-weight:bold;font-size:16px;text-align:right;'>${value.DocumentNumber},     ${value.Status}</span>`);
                            }
                        });
                        $('#acc_data_title').text("Transfer Basic Information");
                        $('#transfer_data').show();
                    }
                }
            });

            $(".inforef").collapse('show');
            $("#reqInfoModal").modal('show');
        }

        function fetchSalesDataFn(recordId){
            $('#sales_info_dt').DataTable({
                destroy:true,
                processing: true,
                serverSide: true,
                paging: false,
                info:false,
                searchHighlight: true,
                "order": [[ 0, "asc" ]],
                language: { 
                    search: '', 
                    searchPlaceholder: "Search here"
                },
                autoWidth: false,
                deferRender: true,
                dom: "<'row'<'col-sm-4 col-md-5 col-6'f><'col-sm-3 col-md-2 col-6'><'col-sm-3 col-md-2 col-6'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-4 col-md-4 col-4'l><'col-sm-4 col-md-4 col-4 d-flex justify-content-center'i><'col-sm-4 col-md-4 col-4 d-flex justify-content-end'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/showSalesDetailData/' + recordId,
                    type: 'DELETE',
                },
                columns: [
                    {
                        data:'DT_RowIndex',
                        width:"3%"
                    },
                    {
                        data: 'ItemCode',
                        name: 'ItemCode',
                        width:"14%"
                    },
                    {
                        data: 'ItemName',
                        name: 'ItemName',
                        width:"14%"
                    },
                    {
                        data: 'SKUNumber',
                        name: 'SKUNumber',
                        width:"14%"
                    },
                    {
                        data: 'UOM',
                        name: 'UOM',
                        width:"13%"
                    },
                    {
                        data: 'Quantity',
                        name: 'Quantity',
                        render: $.fn.dataTable.render.number(',', '.',2, ''),
                        width:"13%"
                    },
                    {
                        data: 'dispatched_qty',
                        name: 'dispatched_qty',
                        render: $.fn.dataTable.render.number(',', '.',2, ''),
                        width:"13%"
                    },
                    {
                        data: 'Memo',
                        name: 'Memo',
                        width:"16%"
                    },
                ],
                createdRow: function(row, data, dataIndex) {
                    // Loop through each cell in the row
                    $('td', row).each(function() {
                        // If the cell's text is "0", set it to an empty string
                        if ($(this).text() == "0.00" || $(this).text() == "0" || $(this).text() == "NULL") {
                            $(this).text('');
                        }
                    });
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
                    $('#dt_info_tbl').show();
                },
            });
        }

        function fetchTransferDataFn(recordId){
            $('#reqinfodetail').DataTable({
                destroy:true,
                processing: true,
                serverSide: true,
                paging: false,
                info:false,
                searchHighlight: true,
                "order": [[ 0, "asc" ]],
                language: { 
                    search: '', 
                    searchPlaceholder: "Search here"
                },
                autoWidth: false,
                deferRender: true,
                dom: "<'row'<'col-sm-4 col-md-5 col-6'f><'col-sm-3 col-md-2 col-6'><'col-sm-3 col-md-2 col-6'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-4 col-md-4 col-4'l><'col-sm-4 col-md-4 col-4 d-flex justify-content-center'i><'col-sm-4 col-md-4 col-4 d-flex justify-content-end'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/showTrDetail/' + recordId,
                    type: 'DELETE',
                },
                columns: [
                    {
                        data:'DT_RowIndex',
                        width:"3%"
                    },
                    {
                        data: 'ItemCode',
                        name: 'ItemCode',
                        width:"10%"
                    },
                    {
                        data: 'ItemName',
                        name: 'ItemName',
                        width:"10%"
                    },
                    {
                        data: 'SKUNumber',
                        name: 'SKUNumber',
                        width:"10%"
                    },
                    {
                        data: 'UOM',
                        name: 'UOM',
                        width:"7%"
                    },
                    {
                        data: 'Quantity',
                        name: 'Quantity',
                        render: $.fn.dataTable.render.number(',', '.',2, ''),
                        width:"10%"
                    },
                    {
                        data: 'ApprovedQuantity',
                        name: 'ApprovedQuantity',
                        render: $.fn.dataTable.render.number(',', '.',2, ''),
                        width:"10%"
                    },
                    {
                        data: 'IssuedQuantity',
                        name: 'IssuedQuantity',
                        render: $.fn.dataTable.render.number(',', '.',2, ''),
                        width:"10%"
                    },
                    {
                        data: 'DispatchQuantity',
                        name: 'DispatchQuantity',
                        render: $.fn.dataTable.render.number(',', '.',2, ''),
                        width:"10%"
                    },
                    {
                        data: 'Memo',
                        name: 'Memo',
                        width:"10%"
                    },
                    {
                        data: 'ApprovedMemo',
                        name: 'ApprovedMemo',
                        width:"10%"
                    }
                ],
                createdRow: function(row, data, dataIndex) {
                    // Loop through each cell in the row
                    $('td', row).each(function() {
                        // If the cell's text is "0", set it to an empty string
                        if ($(this).text() == "0.00" || $(this).text() == "0" || $(this).text() == "NULL") {
                            $(this).text('');
                        }
                    });
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
                    $('#detailcontent').show(); 
                },
            });
        }

        function renumberRows() {
            var ind;
            $('#dynamicTable > tbody > tr').each(function(index, el) {
                $(this).children('td').first().text(++index);
                ind = index - 1;
            });
        }

        function DocumentNumFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            var trnid = $('#DocumentNum'+idval).val();
            var detid = $('#ItemName'+idval).val();
            var dispatch_type = $('#DispatchType').val();
            var dupcnt = 0;
            var defaultoption = '<option selected disabled value=""></option>';
            var transferitemopt = $("#ItemNameDefault > option").clone();
            var salesitemopt = $("#salesitemdata > option").clone();
            $('#ItemName'+idval).empty();
            $('#uom'+idval).val("");
            $('#issuedqty'+idval).val("");
            $('#remainingqty'+idval).val("");
            $('#quantity'+idval).val("");

            for(var k=1;k<=m;k++){
                if(($('#DocumentNum'+k).val())!=undefined){
                    if((parseInt($('#DocumentNum'+k).val()) == parseInt(trnid)) && (parseInt($('#ItemName'+k).val()) == parseInt(detid))){
                        dupcnt+=1;
                    }
                }
            }

            if(parseInt(dupcnt)<=1){
                if(parseInt(dispatch_type) == 1){
                    $('#ItemName'+idval).append(salesitemopt);
                }
                else if(parseInt(dispatch_type) == 2){
                    $('#ItemName'+idval).append(transferitemopt);
                }
                $("#ItemName"+idval+" option[title!='"+trnid+"']").remove(); 
                $('#ItemName'+idval).append(defaultoption);
                $('#ItemName'+idval).select2
                ({
                    placeholder: "Select item here",
                    dropdownCssClass : 'cusmidprp',
                });
                $('#select2-DocumentNum'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
                $('#dispinfo'+idval).show();
            }
            else if(parseInt(dupcnt)>1){
                $('#DocumentNum'+idval).val(null).trigger('change').select2
                ({
                    placeholder: "Select document number here",
                });
                $('#select2-DocumentNum'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                $('#dispinfo'+idval).hide();
                toastrMessage('error',"Document number is selected with Item name","Error");
            }
        }

        function ItemNameFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            var trnid = $(`#DocumentNum${idval}`).val();
            var detid = $(`#ItemName${idval}`).val();
            var dispatch_type = $('#DispatchType').val();
            var dupcnt=0;
            for(var k=1;k<=m;k++){
                if(($('#ItemName'+k).val())!=undefined){
                    if((parseInt($('#DocumentNum'+k).val()) == parseInt(trnid)) && (parseInt($('#ItemName'+k).val()) == parseInt(detid))){
                        dupcnt+=1;
                    }
                }
            }

            if(parseInt(dupcnt) <= 1){
                if(parseInt(dispatch_type) == 1){
                    CalculateRemSales(idval);
                }
                else if(parseInt(dispatch_type) == 2){
                    CalculateRemTransfer(idval);
                }
                $('#select2-ItemName'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
            }
            else if(parseInt(dupcnt) > 1){
                $('#ItemName'+idval).val(null).select2
                ({
                    placeholder: "Select item here",
                    dropdownCssClass : 'cusmidprp',
                });
                $('#select2-ItemName'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                toastrMessage('error',"Item name is selected with Document number","Error");
            }
        }

        function CalculateRemTransfer(rowid){
            var baseRecordId = null;
            var trnDetailId = null;
            var qnt = 0;

            $.ajax({ 
                url: '/calcRemTransfer', 
                type: 'POST',
                data:{
                    baseRecordId:$('#recordId').val()||0,
                    trnDetailId:$(`#ItemName${rowid}`).val(),
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
                    $(`#uom${rowid}`).val(data.uomname);
                    $(`#issuedqty${rowid}`).val(data.issuedqty);
                    $(`#remainingqty${rowid}`).val(data.remqty);
                }
            });
        }

        function CalculateRemSales(rowid){
            var baseRecordId = null;
            var salesDetailId = null;
            var qnt = 0;

            $.ajax({ 
                url: '/calcRemSales', 
                type: 'POST',
                data:{
                    baseRecordId:$('#recordId').val()||0,
                    salesDetailId:$(`#ItemName${rowid}`).val(),
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
                    $(`#uom${rowid}`).val(data.uomname);
                    $(`#issuedqty${rowid}`).val(data.issuedqty);
                    $(`#remainingqty${rowid}`).val(data.remqty);
                }
            });
        }

        function quantityFn(ele){
            var idval = $(ele).closest('tr').find('.vals').val();
            var remqnt=$('#remainingqty'+idval).val();
            var qnt=$('#quantity'+idval).val();
            $('#quantity'+idval).css("background","white");
            if(parseFloat(qnt) == 0){
                $('#quantity'+idval).val("");
            }
            else if(parseFloat(qnt) > parseFloat(remqnt)){
                $('#quantity'+idval).css("background",errorcolor);
                $('#quantity'+idval).val("");
                toastrMessage('error',"The maximum allowed quantity is <b>"+remqnt+"</b>","Error");
            }
        }

        function dispatchTypeFn(){
            // var type = $("#DispatchType").val();
            // if(type == 1){
            //     $("#qty_data").html("Sold Qty.");
            // }
            // else if(type == 2){
            //     $("#qty_data").html("Issued Qty.");
            // }
            // else if(type == 3){
            //     $("#qty_data").html("Issued Qty.");
            // }

            $("#dynamicTable > tbody").empty();
            $('#dispatchtype-error').html("");
        }

        function dispatchModeFn(){
            var dispmode = $('#DispatchMode').val();
            $('.mainprop').hide();
            $('.mainforminp').val("");
            $('#dispatchmode-error').html("");
            $('.dispmode_err').html("");
            if(parseInt(dispmode) == 1){
                $('.vech').show();
            }
            else if(parseInt(dispmode) == 2){
                $('.per').show();
            }
        }

        function dateVal(){
            $('#date-error').html("");
        }

        $("#savebutton").click(function() {
            var registerForm = $("#Register");
            var formData = registerForm.serialize();
            var optype = $("#operationtypes").val();
            $.ajax({ 
                url: '/saveDispatchTransfer',
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
                    if(parseInt(optype) == 1){
                        $('#savebutton').text('Saving...');
                        $('#savebutton').prop("disabled", true);
                    }
                    else if(parseInt(optype) == 2){
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
                    if(data.errors){
                        if (data.errors.DispatchType) {
                            $('#dispatchtype-error').html(data.errors.DispatchType[0]);
                        }
                        if (data.errors.DispatchMode) {
                            $('#dispatchmode-error').html(data.errors.DispatchMode[0]);
                        }
                        if (data.errors.date) {
                            $('#date-error').html(data.errors.date[0]);
                        }
                        if (data.errors.DriverName) {
                            var text=data.errors.DriverName[0];
                            text = text.replace("1", "vehicle");
                            $('#drivername-error').html(text);
                        }
                        if (data.errors.DriverLicenseNo) {
                            var text=data.errors.DriverLicenseNo[0];
                            text = text.replace("1", "vehicle");
                            $('#driverlic-error').html(text);
                        }
                        if (data.errors.DriverPhoneNo) {
                            var text=data.errors.DriverPhoneNo[0];
                            text = text.replace("1", "vehicle");
                            $('#driverphone-error').html(text);
                        }
                        if (data.errors.PlateNumber) {
                            var text=data.errors.PlateNumber[0];
                            text = text.replace("1", "vehicle");
                            $('#platenum-error').html(text);
                        }
                        if (data.errors.ContainerNumber) {
                            var text=data.errors.ContainerNumber[0];
                            text = text.replace("1", "vehicle");
                            $('#containernumber-error').html(text);
                        }
                        if (data.errors.PersonName) {
                            var text=data.errors.PersonName[0];
                            text = text.replace("2", "person");
                            $('#personname-error').html(text);
                        }
                        if (data.errors.PersonPhoneNo) {
                            var text=data.errors.PersonPhoneNo[0];
                            text = text.replace("2", "person");
                            $('#personphone-error').html(text);
                        }
                        if (data.errors.Remark) {
                            $('#remark-error').html(data.errors.Remark[0]);
                        }

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
                    else if (data.emptyerror) {
                        if(parseFloat(optype) == 1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled",false);
                        }
                        else if(parseFloat(optype) == 2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled",false);
                        }
                        toastrMessage('error',"You should add atleast one item","Error");
                    }
                    else if (data.errorv2) {
                        for(var k=1;k<=m;k++){
                            var docnum=$('#DocumentNum'+k).val();
                            var itemorheaderid=$('#ItemName'+k).val();
                            var qnty=$('#quantity'+k).val();

                            if(isNaN(parseFloat(docnum))||parseFloat(docnum)==0){
                                $('#select2-DocumentNum'+k+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                            }
                            if(isNaN(parseFloat(itemorheaderid))||parseFloat(itemorheaderid)==0){
                                $('#select2-ItemName'+k+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                            }
                            if(($('#quantity'+k).val())!=undefined){
                                if(qnty=="" || qnty==null){
                                    $('#quantity'+k).css("background", errorcolor);
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
                    else if (data.dberrors) {
                        if(parseFloat(optype) == 1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled",false);
                        }
                        else if(parseFloat(optype) == 2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled",false);
                        }
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if(data.success){
                        if(parseFloat(optype) == 2){
                            createDispatchInfoFn(data.rec_id);
                        }
                        countDispatchStatusFn(data.fyear);                        
                        var iTable = $('#laravel-datatable-crud').dataTable();
                        iTable.fnDraw(false);

                        toastrMessage('success',"Successful","Success");
                        $("#inlineForm").modal('hide');
                    }
                }
            });
        });

        function editDispatchFn(recordId){
            var recId = "";
            var status_color = "";
            $('#recordId').val(recordId);
            $('.mainprop').hide();
            $("#dynamicTable > tbody").empty();
            var transferdocopt = $("#TransferDocDefault > option").clone();
            var transferitemopt = $("#ItemNameDefault > option").clone();
            j=0;
            $.ajax({
                url: '/fetchTransferDispData',
                type: 'POST',
                data:{
                    recId:recordId,
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
                    $.each(data.disparentdata,function(key,value) { 
                        $('#DispatchType').val(value.Type).select2({minimumResultsForSearch:-1});
                        $('#DispatchMode').val(value.DispatchMode).select2({minimumResultsForSearch:-1});
                        flatpickr('#date', { dateFormat: 'Y-m-d',clickOpens:true,maxDate:current_date});   
                        $('#date').val(value.Date);                     
                        $('#DriverName').val(value.DriverName);
                        $('#DriverLicenseNo').val(value.DriverLicenseNo);
                        $('#DriverPhoneNo').val(value.DriverPhoneNo);
                        $('#PlateNumber').val(value.PlateNumber);
                        $('#PersonName').val(value.PersonName);
                        $('#PersonPhoneNo').val(value.PersonPhoneNo);
                        $('#Remark').val(value.Remark);
                        
                        if(parseInt(value.DispatchMode) == 1){
                            $('.vech').show();
                        }
                        if(parseInt(value.DispatchMode) == 2){
                            $('.per').show();
                        }

                        if(value.Status == "Draft"){
                            status_color = "#A8AAAE";
                        }
                        else if(value.Status == "Pending"){
                            status_color = "#f6c23e";
                        }
                        else if(value.Status == "Verified"){
                            status_color = "#7367F0";
                        }
                        else if(value.Status == "Approved" || value.Status == "Received"){
                            status_color = "#1cc88a";
                        }
                        else{
                            status_color = "#e74a3b";
                        }
                        $("#dispatchstatus").html(`<span class="form_title" style='color:${status_color};font-weight:bold;text-shadow;1px 1px 10px ${status_color};font-size:16px;'>${value.DispatchDocNo},     ${value.Status}</span>`);
                    });

                    $.each(data.dispchilddata,function(key,value) { 
                        ++i;
                        ++m;
                        ++j;
                       
                        $("#dynamicTable > tbody").append(`<tr><td style="font-weight:bold;text-align:center;width:3%"> ${j}</td>
                            <td style="display:none;"><input type="hidden" name="row[${m}][vals]" id="vals+m+" class="vals form-control" readonly="true" style="font-weight:bold;" value="${m}"/></td>
                            <td style="width:14%"><select id="DocumentNum${m}" class="select2 form-control DocumentNum" onchange="DocumentNumFn(this)" name="row[${m}][DocumentNum]"></select></td>
                            <td style="width:20%"><select id="ItemName${m}" class="select2 form-control ItemName" onchange="ItemNameFn(this)" name="row[${m}][ItemName]"></select></td>
                            <td style="width:10%"><input id="uom${m}" type="text" name="row[${m}][uom]" placeholder="Unit of Measurement" class="uom form-control" value="${value.UOM}" readonly/></td>
                            <td style="width:11%"><input id="issuedqty${m}" type="text" name="row[${m}][issuedqty]" placeholder="Issued Quantity" class="issuedqty form-control" value="${value.SoldIssued}" readonly/></td>
                            <td style="width:11%"><input id="remainingqty${m}" type="text" name="row[${m}][remainingqty]" placeholder="Remaining Quantity" class="remainingqty form-control" readonly/></td>
                            <td style="width:11%"><input id="quantity${m}" type="number" name="row[${m}][Quantity]" placeholder="Write quantity here..." class="quantity form-control numeral-mask" onkeyup="quantityFn(this)" value="${value.DispatchedQnt}" onkeypress="return ValidateNum(event);"/></td>
                            <td style="width:14%"><input id="remark${m}" type="text" name="row[${m}][remark]" placeholder="Write remark here..." class="remark form-control" value="${value.Remark}"/></td>
                            <td style="width:6%;text-align:center;"><a class="infodisp" href="javascript:void(0)" onclick="dispInfoFn(${m},1)" id="dispinfo${m}" title="Show transfer/requisition detail inforamtion"><i class="fa-sharp fa-regular fa-circle-info fa-lg" style="color: #00cfe8;"></i></a><button type="button" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button</td>
                            <td style="display:none;"><input id="id${m}" type="hidden" name="row[${m}][id]" class="id form-control" readonly="true" value="+value.id+" style="font-weight:bold;"/></td>
                            </tr>`);

                        var defaultdocument=`<option selected value='${value.TrId}'>${value.DocumentNumber}</option>`;
                        var defaultheaderid=`<option selected value='${value.ReqDetailId}'>${value.ItemCode}, ${value.ItemName}, ${value.SKUNumber}</option>`;

                        $(`#DocumentNum${m}`).append(transferdocopt);
                        $(`#DocumentNum${m} option[data-type!="${value.Type}"]`).remove(); 
                        $(`#DocumentNum${m} option[value="${value.TrId}"]`).remove(); 
                        $(`#DocumentNum${m}`).append(defaultdocument);
                        $(`#DocumentNum${m}`).select2
                        ({
                            placeholder: "Select document number here",
                        });

                        $(`#ItemName${m}`).append(transferitemopt);
                        $(`#ItemName${m} option[title!="${value.TrId}"]`).remove(); 
                        $(`#ItemName${m} option[value="${value.ReqDetailId}"]`).remove(); 
                        $(`#ItemName${m}`).append(defaultheaderid);
                        $(`#ItemName${m}`).select2
                        ({
                            placeholder: "Select item here",
                            dropdownCssClass : 'cusmidprp',
                        });
                        if(value.Type == 1){
                            CalculateRemSales(m);
                        }
                        else if(value.Type == 2){
                            CalculateRemTransfer(m);
                        }

                        $(`#quantity${m}`).append(value.DispatchedQnt);
                        $(`#select2-DocumentNum${m}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
                        $(`#select2-ItemName${m}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
                    });
                    renumberRows();
                },
            });

            $("#dispatchtitle").html('Edit Dispatch');
            $('#operationtypes').val(2);
            $('#savebutton').text('Update');
            $('#savebutton').prop("disabled",false);
            $("#inlineForm").modal('show');
        }

        function createDispatchInfoFn(recordId){
            $('.allinfo').hide();
            $('.dispbtnprop').hide();
            $('#dispatch_item_div').hide();
            $('.infodispfooter').html("");
            $('#dispid').val(recordId);
            var recId = "";
            var lidata = "";
            var status_color = "";
            var action_links = "";
            var withold_btn_link = "";
            var major_btn_link = `<li><hr class="dropdown-divider"></li>`;
            var status_btn_link = `<li><hr class="dropdown-divider"></li>`;
            var flag_btn_link = `<li><hr class="dropdown-divider"></li>`;
            var print_btn_link = "";
            var edit_link = `
                @can("Dispatch-Edit")
                    <li>
                        <a class="dropdown-item editDispatch" href="javascript:void(0)" onclick="editDispatchFn(${recordId})" data-id="editDispatchLink${recordId}" id="editDispatchLink${recordId}" title="Edit record">
                        <span><i class="fa-solid fa-pencil"></i> Edit</span>  
                        </a>
                    </li>
                @endcan`;

            var void_link = `
                @can("Dispatch-Void")
                    <li>
                        <a class="dropdown-item voidDispatch" href="javascript:void(0)" onclick="voidDispatchFn(${recordId})" data-id="voidDispatch${recordId}" id="voidDispatch${recordId}" title="Void record">
                        <span><i class="fa-solid fa-ban"></i> Void</span>  
                        </a>
                    </li>
                @endcan`;

            var undovoid_link = `
                @can("Dispatch-Void")
                <li>
                    <a class="dropdown-item undoVoidDispatch" href="javascript:void(0)" onclick="undoVoidDispatchFn(${recordId})" data-id="undoVoidDispatch${recordId}" id="undoVoidDispatch${recordId}" title="Undo void record">
                    <span><i class="fa fa-undo"></i> Undo Void</span>  
                    </a>
                </li>
                @endcan`;

            var change_to_pending_link = `
                @can("Dispatch-ChangeToPending")
                <li>
                    <a class="dropdown-item changetopending" onclick="forwardDispatchFn()" id="changetopending" title="Change record to pending">
                    <span><i class="fa-solid fa-forward"></i> Change to Pending</span>  
                    </a>
                </li>
                @endcan`;

            var back_to_draft_link = `
                @can("Dispatch-ChangeToPending")
                <li>
                    <a class="dropdown-item dispatchbackward" id="backtodraft" title="Change record to draft">
                    <span><i class="fa-solid fa-backward"></i> Back to Draft</span>  
                    </a>
                </li>
                @endcan`;

            var verify_link = `
                @can("Dispatch-Verify")
                <li>
                    <a class="dropdown-item verifydispatch" onclick="forwardDispatchFn()" id="verifydispatch" title="Change record to verified">
                    <span><i class="fa-solid fa-forward"></i> Verify</span>  
                    </a>
                </li>
                @endcan`;

            var back_to_pending = `
                @can("Dispatch-Verify")
                <li>
                    <a class="dropdown-item dispatchbackward" id="backtopending" title="Change record to pending">
                    <span><i class="fa-solid fa-backward"></i> Back to Pending</span>  
                    </a>
                </li>
                @endcan`;

            var approve_link = `
                @can("Dispatch-Approve")
                <li>
                    <a class="dropdown-item approvedispatch" onclick="forwardDispatchFn()" id="approvedispatch" title="Change record to approved">
                    <span><i class="fa-solid fa-forward"></i> Approve</span>  
                    </a>
                </li>
                @endcan`;

            var back_to_verify_link = `
                @can("Dispatch-Approve")
                <li>
                    <a class="dropdown-item dispatchbackward" id="backtoverify" title="Change record to verified">
                    <span><i class="fa-solid fa-backward"></i> Back to Verified</span>  
                    </a>
                </li>
                @endcan`;

            var received_link = `
                @can("Dispatch-Receive")
                <li>
                    <a class="dropdown-item receivedispatch" onclick="forwardDispatchFn()" id="receivedispatch" title="Change record to received">
                    <span><i class="fa-solid fa-forward"></i> Receive</span>  
                    </a>
                </li>
                @endcan`;

            var print_dispatch_link = `
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item printdispatch" href="javascript:void(0)" onclick="dispattFn(${recordId})" data-link="/dispatt/${recordId}" data-id="printdispatch${recordId}" id="printdispatch${recordId}" title="Print Dispatch Voucher">
                    <span><i class="fa fa-file"></i> Print Dispatch Voucher</span>  
                    </a>
                </li>`;

            
            $.ajax({
                url: '/fetchTransferDispData',
                type: 'POST',
                data:{
                    recId:recordId,
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
                complete: function() {
                    fetchDispatchItemListFn(recordId);
                },
                success: function(data) {
                    $.each(data.disparentdata,function(key,value) { 
                        $('#infoReqDocNoLbl').html(value.DocumentNumber);
                        $('#infoDispatchTypeLbl').html(value.DispatchType);
                        $('#infoDispatchModeLbl').html(value.DispatchModeName);
                        $('#infoDriverNameLbl').html(value.DriverName);
                        $('#infoDriverLiceNoLbl').html(value.DriverLicenseNo);
                        $('#infoDriverPhoneNoLbl').html(value.DriverPhoneNo);
                        $('#infoPlateNoLbl').html(value.PlateNumber);
                        $('#infoContainerNoLbl').html(value.ContainerNumber);
                        $('#infoSealNoLbl').html(value.SealNumber);
                        $('#infoPersonNameLbl').html(value.PersonName);
                        $('#infoPersonPhoneLbl').html(value.PersonPhoneNo);
                        $('#infoDate').html(value.Date);
                        $('#infoRemark').html(value.Remark);
                        $('#dispatch_type_inp').val(value.Type);
                        $('#currentStatus').val(value.Status);
                        
                        if(parseInt(value.DispatchMode)==1){
                            $('.vehinfo').show();
                        }
                        if(parseInt(value.DispatchMode)==2){
                            $('.perinfo').show();
                        }

                        if(value.Status == "Draft"){
                            major_btn_link += edit_link;
                            major_btn_link += void_link;

                            status_btn_link += change_to_pending_link;
                            
                            status_color = "#A8AAAE";
                        }
                        else if(value.Status == "Pending"){
                            major_btn_link += edit_link;
                            major_btn_link += void_link;

                            status_btn_link += verify_link;
                            status_btn_link += back_to_draft_link;

                            status_color = "#f6c23e";
                        }
                        else if(value.Status == "Verified"){
                            major_btn_link += edit_link;
                            major_btn_link += void_link;

                            status_btn_link += approve_link;
                            status_btn_link += back_to_pending;
                            
                            status_color = "#7367F0";
                        }
                        else if(value.Status == "Approved"){

                            major_btn_link += void_link;
                            status_btn_link = "";
                            //status_btn_link = value.Type == 1 ? "" : `<li><hr class="dropdown-divider"></li>${received_link}`;
                            
                            status_color = "#1cc88a";
                        }
                        else if(value.Status == "Received"){
                            major_btn_link = "";
                            status_btn_link = "";

                            status_color = "#1cc88a";
                        }
                        else if(value.Status == "Void" || value.Status == "Void(Draft)" || value.Status == "Void(Pending)" || value.Status == "Void(Verified)" || value.Status == "Void(Approved)" || value.Status == "Void(Issued)" || value.Status == "Void(Received)"){
                            major_btn_link += undovoid_link;
                            status_btn_link = "";

                            status_color = "#e74a3b";
                        }
                        else{
                            major_btn_link = "";
                            status_btn_link = "";

                            status_color = "#e74a3b";
                        }

                        $(".info_modal_title_lbl").html(`<span class="form_title" style='color:${status_color};font-weight:bold;text-shadow;1px 1px 10px ${status_color};font-size:16px;'>${value.DispatchDocNo},     ${value.Status}</span>`);

                        action_links = `
                        <li>
                            <a class="dropdown-item viewDispatchAction" onclick="viewDispatchActionFn(${recordId})" data-id="view_dispatch_actionbtn${recordId}" id="view_dispatch_actionbtn${recordId}" title="View user log">
                                <span><i class="fa-solid fa-eye"></i> View User Log</span>  
                            </a>
                        </li>
                        ${major_btn_link}
                        ${status_btn_link}
                        ${print_dispatch_link}`;

                        $("#dispatch_action_ul").empty().append(action_links);
                    });

                    $.each(data.activitydata, function(key, value) {
                        var classes = "";
                        var reasonbody = "";
                        if(value.action == "Edited" || value.action == "Change to Pending" || value.action == "Back to Pending" || value.action == "Edited (Dispatch)" || value.action == "Back to Pending (Dispatch)"){
                            classes = "warning";
                        }
                        else if(value.action == "Verified" || value.action == "Change to Counting" || value.action == "Verified (Dispatch)"){
                            classes = "primary";
                        }
                        else if(value.action == "Back to Draft" || value.action == "Back to Verify" || value.action == "Back to Review" || value.action == "Undo Void" || value.action == "Created (Dispatch)" || value.action == "Undo Void (Dispatch)"){
                            classes = "secondary";
                        }
                        else if(value.action == "Created" || value.action == "Approved" || value.action == "Received" || value.action == "Approved (Dispatch)"){
                            classes = "success";
                        }
                        else if(value.action == "Void" || value.action=="Void(Draft)" || value.action=="Void(Pending)" || value.action=="Void(Approved)" || value.action=="Void(Reviewed)" || value.action=="Rejected" || value.action=="Void (Dispatch)"){
                            classes = "danger";
                        }
                        if(value.reason != null && value.reason != ""){
                            reasonbody = `</br><span class="text-muted"><b>Reason:</b> ${value.reason}</span>`;
                        }
                        else{
                            reasonbody="";
                        }
                        lidata += `<li class="timeline-item"><span class="timeline-point timeline-point-${classes} timeline-point-indicator"></span><div class="timeline-header mb-sm-0 mb-0"><h6 class="mb-0">${value.action}</h6><span class="text-muted"><i class="fa-regular fa-user"></i> ${value.FullName}</span>${reasonbody}</br><span class="text-muted"><i class="fa-regular fa-clock"></i> ${value.time}</span></div></li>`;
                    });

                    $('#actiondiv').empty().append(lidata);
                    $("#universal-action-log-canvas").empty().append(lidata);
                }
            });
            $(".infoscl").collapse('show');
        }

        $(document).on('show.bs.collapse hide.bs.collapse', '.collapse', function (e) {
            e.stopPropagation();
            const collapse = $(this);
            const container = collapse.closest('.card, .modal-content, .row');
            const infoTarget = container.find('.dispatch_header_info');
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
                const dispatch_type = container.find('#infoDispatchTypeLbl').text().trim();
                const dispatch_mode = container.find('#infoDispatchModeLbl').text().trim();
                const summaryHtml = `
                    Dispatch Type: <b>${dispatch_type}</b>,
                    Dispatch Mode: <b>${dispatch_mode}</b>`;
                infoTarget.html(summaryHtml);
            }
        });

        $(document).on('show.bs.collapse hide.bs.collapse', '.collapse', function (e) {
            e.stopPropagation();
            const collapse = $(this);
            const container = collapse.closest('.card, .modal-content, .row');
            const infoTarget = container.find('.reference_header_info');
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
                var d_type = $('#dispatch_type_inp').val();
                const src_station = container.find('#infosourcestore').text().trim();
                const dest_station = container.find('#infodestinationstore').text().trim();
                const summaryTransferHtml = `
                    Source Station: <b>${src_station}</b>,
                    Destination Station: <b>${dest_station}</b>`;

                const pos = container.find('#pos_lbl').text().trim();
                const payment_type = container.find('#payment_type').text().trim();
                const summarySalesHtml = `
                    Point of Sales: <b>${pos}</b>,
                    Payment Type: <b>${payment_type}</b>`;

                infoTarget.html(d_type == 1 ? summarySalesHtml : summaryTransferHtml);
            }
        });

        function fetchDispatchItemListFn(recordId){
            $('#dispatchinfodatatbl').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                paging: false,
                searching: true,
                info: false,
                searchHighlight: true,
                autoWidth: false,
                "order": [
                    [0, "desc"]
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
                    url: '/getDispatchDetailData/' + recordId,
                    type: 'DELETE',
                },
                columns: [
                    {
                        data:'DT_RowIndex',
                        width:"3%"
                    },
                    {
                        data: 'DocumentNumber',
                        name: 'DocumentNumber',
                        "render": function ( data, type, row, meta ) {
                            return `<a style="text-decoration:underline;color:blue;" onclick=dispInfoFn("${row.TrId}",2)>${data}</a>`;
                        },
                        width:"16%"
                    },
                    {
                        data: 'ItemCode',
                        name: 'ItemCode',
                        width:"10%"
                    },
                    {
                        data: 'ItemName',
                        name: 'ItemName',
                        width:"17%"
                    },
                    {
                        data: 'SKUNumber',
                        name: 'SKUNumber',
                        width:"10%"
                    },
                    {
                        data: 'UOM',
                        name: 'UOM',
                        width:"6%"
                    },
                    {
                        data: 'SoldIssued',
                        name: 'SoldIssued',
                        render: $.fn.dataTable.render.number(',', '.',2, ''),
                        width:"10%"
                    },
                    {
                        data: 'DispatchedQnt',
                        name: 'DispatchedQnt',
                        render: $.fn.dataTable.render.number(',', '.',2, ''),
                        width:"10%"
                    },
                    {
                        data: 'Remark',
                        name: 'Remark',
                        width:"18%"
                    },
                ],
                createdRow: function(row, data, dataIndex) {
                    $('td', row).each(function() {
                        // If the cell's text is "0", set it to an empty string
                        if ($(this).text() == "NULL" || $(this).text() === "NULL") {
                            $(this).text('');
                        }
                    });
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
                    $('#dispatch_item_div').show();
                },
            });
        }

        function infoDispatchFn(recordId){
            createDispatchInfoFn(recordId);
            $('#dispInfoModal').modal('show');
        }

        function viewDispatchActionFn(recordId){
            $("#action-log-title").html("User Log Information");
            $("#action-log-universal-modal").modal('show');
        }

        function forwardDispatchFn() {
            const requestId = $('#dispid').val();
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
                    dispatchForwardActionFn();
                }
                else if (result.dismiss === Swal.DismissReason.cancel) {}
            });
        }

        function dispatchForwardActionFn(){
            var forwardForm = $("#dispatchInfoform");
            var formData = forwardForm.serialize();
            var recordId = $('#dispid').val();
            $.ajax({
                url: '/dispatchForwardAction',
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
                        createDispatchInfoFn(data.rec_id);
                        countDispatchStatusFn(data.fiscalyr);
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                    }
                }
            });
        }

        $(document).on('click', '.dispatchbackward', function(){
            const requestId = $('#dispid').val();
            const currentStatus = $('#currentStatus').val();

            const transition = $(this).attr('id') == "reqrejectbtn" ? statusTransitions[currentStatus].reject : statusTransitions[currentStatus].backward;

            $('#backwardReqId').val(requestId);
            $('#newBackwardStatusValue').val(transition.status);
            $('#backwardActionLabel').html(transition.message);
            $('#backwardBtnTextValue').val(transition.text);
            $('#backwardActionBtn').text(transition.text);
            $('#backwardActionBtn').prop("disabled",false);
            $('#backwardActionValue').val(transition.action);
            $('#CommentOrReason').val("");
            $('#commentres-error').html("");
            $('#backwardActionModal').modal('show');
        });

        $("#backwardActionBtn").click(function() {
            var registerForm = $("#backwardActionForm");
            var formData = registerForm.serialize();
            var btntxt = $('#backwardBtnTextValue').val();
            var recordId = $('#backwardReqId').val();
            $.ajax({
                url: '/dispatchBackwardAction',
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
                        createDispatchInfoFn(data.rec_id);
                        countDispatchStatusFn(data.fiscalyr);

                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);

                        $('#backwardActionModal').modal('hide');
                    }
                }
            });
        });

        function dispatchReasonFn() {
            $('#commentres-error').html("");
        }

        function voidDispatchFn(recordId){
            $('#voiddispid').val(recordId);
            $('#DispatchReason').val("");
            $('#dispvoid-error').html("");
            $('#voiddispatchbtn').text('Void');
            $('#voiddispatchbtn').prop("disabled", false);
            $('#voiddispatchmodal').modal('show');
        }

        function voidDispReason(){
            $('#dispvoid-error').html("");
        }

        $("#voiddispatchbtn").click(function() {
            var registerForm = $("#voiddispatchform");
            var formData = registerForm.serialize();
            $.ajax({
                url: '/voidTrnDispatchData',
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
                    $('#voiddispatchbtn').text('Voiding...');
                    $('#voiddispatchbtn').prop("disabled", true);
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
                    if(data.errors){
                        if (data.errors.DispatchReason) {
                            $('#dispvoid-error').html(data.errors.DispatchReason[0]);
                        }
                        $('#voiddispatchbtn').text('Void');
                        $('#voiddispatchbtn').prop("disabled", false);
                    }
                    else if(data.statuserror){
                        $('#voiddispatchbtn').text('Void');
                        $('#voiddispatchbtn').prop("disabled", false);
                        $('#voiddispatchmodal').modal('hide');
                        toastrMessage('error',"Dispatch status should be on Active","Error");
                    }
                    else if (data.dberrors) {
                        $('#voiddispatchbtn').text('Void');
                        $('#voiddispatchbtn').prop("disabled", false);
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if(data.success){
                        createDispatchInfoFn(data.rec_id);
						countDispatchStatusFn(data.fyear);  
                        var iTable = $('#laravel-datatable-crud').dataTable();
                        iTable.fnDraw(false);
                        $('#voiddispatchmodal').modal('hide');
                        toastrMessage('success',"Successful","Success");
                    }
                }
            });
        });

        function undoVoidDispatchFn(recordId){
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
                    undoVoidDispatchTrnFn(recordId);
                }
                else if (result.dismiss === Swal.DismissReason.cancel) {}
            });
        }

        function undoVoidDispatchTrnFn(recordId){
            var registerForm = $("#dispatchInfoform");
            var formData = registerForm.serialize();
            $.ajax({
                url: '/undoVoidTrnDispatchData',
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
                    if(data.discerror){
                        toastrMessage('error',"All requested amount is dispatched.","Error");
                    }
                    else if (data.dberrors) {
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if(data.success){
                        createDispatchInfoFn(data.rec_id);
						countDispatchStatusFn(data.fyear);
                        var iTable = $('#laravel-datatable-crud').dataTable();
                        iTable.fnDraw(false);
                        toastrMessage('success',"Successful","Success");
                    }
                }
            });
        }

        function commentValFn() {
            $('#comment-error').html("");
        }

        //Start Print Dispatch Attachment
        $('body').on('click', '.printDispatchAttachment', function() {
            var id = $(this).data('id');
            var link="/dispcomm/"+id;
            window.open(link, 'Dispatch', 'width=1200,height=800,scrollbars=yes');
        });
        //End Print Dispatch Attachment

        function dispattFn(recordId){
            var link="/disptr/"+recordId;
            window.open(link, 'Dispatch', 'width=1200,height=800,scrollbars=yes');
        }

        function driverNameFn() {
            $('#drivername-error').html("");
        }

        function driverLicFn() {
            $('#driverlic-error').html("");
        }

        function driverPhoneFn() {
            $('#driverphone-error').html("");
        }

        function plateNumFn() {
            $('#platenum-error').html("");
        }

        function containerNumFn() {
            $('#containernumber-error').html("");
        }

        function sealNumFn() {
            $('#sealnumber-error').html("");
        }

        function personNameFn() {
            $('#personname-error').html("");
        }

        function personPhoneFn() {
            $('#personphone-error').html("");
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

        function closeRegModal(){
            $('#DispatchMode').val(null).select2({
                placeholder:"Select Dispatch mode here",
                minimumResultsForSearch: -1
            });
            $('#operationtypes').val("1");
            $('#recordId').val("");
            $('#Remark').val("");
            $('.errordatalabel').html("");
            $("#dynamicTable > tbody").empty();
        }

    </script>

@endsection
