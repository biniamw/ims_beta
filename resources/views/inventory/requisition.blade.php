@extends('layout.app1')
@section('title')
@endsection
@section('content')
    @can('Requisition-View')
        <div class="app-content content fit-content">
            <section id="responsive-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-bottom mb-0 pb-0">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align: left !important;align-items: center;padding: 10px 5px;">
                                            <h3 class="card-title form_title">Stock Requisition</h3>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align: right !important;align-items: center;padding: 10px 5px;">
                                            <button type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm" onclick="refreshRequisistionDataFn()"><i class="fas fa-sync-alt"></i></button>
                                            @if (auth()->user()->can('Requisition-Add'))
                                            <button type="button" class="btn btn-gradient-info btn-sm addreqbutton header-prop" id="addreqbutton"><i class="fas fa-plus"></i><span class="header-text">&nbsp Add</span></button>
                                            @endcan 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-datatable">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="row mt-1 border-bottom mx-n2 pl-1">
                                        <div class="col-6 col-sm-3 col-lg custom-col mb-1">
                                            <div class="stat-item">
                                                <div class="media">
                                                    <div class="avatar bg-light-secondary mr-1">
                                                        <div class="avatar-content">
                                                            <i class="fas fa-boxes"></i>
                                                        </div>
                                                    </div>
                                                    <div class="media-body my-auto mr-1">
                                                        <span class="font-weight-bolder mb-0 requisition_status_record_lbl" id="requisition_draft_record_lbl"></span>
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
                                                            <i class="fas fa-boxes"></i>
                                                        </div>
                                                    </div>
                                                    <div class="media-body my-auto mr-1">
                                                        <span class="font-weight-bolder mb-0 requisition_status_record_lbl" id="requisition_pending_record_lbl"></span>
                                                        <p class="card-text font-small-3 mb-0">Pending</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-sm-3 col-lg custom-col mb-1" style="display: none;">
                                            <div class="stat-item">
                                                <div class="media">
                                                    <div class="avatar bg-light-primary mr-1">
                                                        <div class="avatar-content">
                                                            <i class="fas fa-boxes"></i>
                                                        </div>
                                                    </div>
                                                    <div class="media-body my-auto mr-1">
                                                        <span class="font-weight-bolder mb-0 requisition_status_record_lbl" id="requisition_verified_record_lbl"></span>
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
                                                            <i class="fas fa-boxes"></i>
                                                        </div>
                                                    </div>
                                                    <div class="media-body my-auto mr-1">
                                                        <span class="font-weight-bolder mb-0 requisition_status_record_lbl" id="requisition_approved_record_lbl"></span>
                                                        <p class="card-text font-small-3 mb-0">Approved</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-sm-3 col-lg custom-col mb-1">
                                            <div class="stat-item">
                                                <div class="media">
                                                    <div class="avatar bg-light-primary mr-1">
                                                        <div class="avatar-content">
                                                            <i class="fas fa-boxes"></i>
                                                        </div>
                                                    </div>
                                                    <div class="media-body my-auto mr-1">
                                                        <span class="font-weight-bolder mb-0 requisition_status_record_lbl" id="requisition_issued_record_lbl"></span>
                                                        <p class="card-text font-small-3 mb-0">Issued</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-sm-3 col-lg custom-col mb-1">
                                            <div class="stat-item">
                                                <div class="media">
                                                    <div class="avatar bg-light-success mr-1">
                                                        <div class="avatar-content">
                                                            <i class="fas fa-boxes"></i>
                                                        </div>
                                                    </div>
                                                    <div class="media-body my-auto mr-1">
                                                        <span class="font-weight-bolder mb-0 requisition_status_record_lbl" id="requisition_received_record_lbl"></span>
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
                                                            <i class="fas fa-boxes"></i>
                                                        </div>
                                                    </div>
                                                    <div class="media-body my-auto mr-1">
                                                        <span class="font-weight-bolder mb-0 requisition_status_record_lbl" id="requisition_void_record_lbl"></span>
                                                        <p class="card-text font-small-3 mb-0">Void</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-sm-3 col-lg custom-col mb-1">
                                            <div class="stat-item">
                                                <div class="media">
                                                    <div class="avatar bg-light-danger mr-1">
                                                        <div class="avatar-content">
                                                            <i class="fas fa-boxes"></i>
                                                        </div>
                                                    </div>
                                                    <div class="media-body my-auto mr-1">
                                                        <span class="font-weight-bolder mb-0 requisition_status_record_lbl" id="requisition_reject_record_lbl"></span>
                                                        <p class="card-text font-small-3 mb-0">Rejected</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-sm-3 col-lg custom-col mb-1">
                                            <div class="stat-item">
                                                <div class="media">
                                                    <div class="avatar bg-light-secondary mr-1">
                                                        <div class="avatar-content">
                                                            <i class="fas fa-boxes"></i>
                                                        </div>
                                                    </div>
                                                    <div class="media-body my-auto mr-1">
                                                        <span class="font-weight-bolder mb-0 requisition_status_record_lbl" id="requisition_total_record_lbl"></span>
                                                        <p class="card-text font-small-3 mb-0">Total</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>      
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="row main_datatable" id="requisition_tbl">
                                        <div style="width:99%; margin-left:0.5%;"> 
                                            <table id="laravel-datatable-crud" class="display table-bordered table-striped table-hover defaultdatatable mb-0 mobile-dt" style="width: 100%">
                                                <thead>
                                                    <tr>
                                                        <th style="display: none;"></th>
                                                        <th style="width: 3%;">#</th>
                                                        <th style="width: 15%;" title="Requisition Document Number">Document No.</th>
                                                        <th style="width: 16%;">Station</th>
                                                        <th style="width: 16%;">Request Reason</th>
                                                        <th style="width: 16%;">Request For</th>
                                                        <th style="width: 15%;">Date</th>
                                                        <th style="width: 15%;">Status</th>
                                                        <th style="width: 4%;">Action</th>
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
    <div class="modal fade text-left fit-content" id="reqInfoModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title form_title" id="stock_requisition_title">Stock Requisition Information</h4>
                    <div class="row">
                        <div style="text-align: right;" class="form_title info_modal_title_lbl" id="req_statustitles"></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>  
                </div>
                <form id="reqInfoform">
                   {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <section id="card-text-alignment">
                                        <div class="d-flex justify-content-between align-items-center cursor-pointer border-bottom" data-toggle="collapse" data-target=".infoscl" aria-expanded="true">
                                            <h5 class="mb-0 form_title requisition_header_info"><i class="far fa-info-circle"></i> Basic Information</h5>
                                            <div class="d-flex align-items-center header-tab">
                                                <span class="text-uppercase font-weight-bold mr-50 toggle-text-label tab-text">Collapse</span>
                                                <div class="collapse-icon">
                                                    <i class="fas text-secondary fa-minus-circle"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="collapse show infoscl shadow pl-1 pr-1">
                                            <div class="row mb-1">
                                                <div class="col-xl-6 col-lg-8 col-md-12 col-sm-12 col-12 mt-1 mb-1">
                                                    <div class="card shadow-none border m-0">
                                                        <div class="card-body">
                                                            <h4 class="card-title mb-0"></h4>
                                                            <table class="infotbl" style="width:100%;font-size:12px;">
                                                                <tr>
                                                                    <td><label class="info_lbl">Station</label></td>
                                                                    <td><label class="info_lbl" id="infosourcestore" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl">Request Reason</label></td>
                                                                    <td><label class="info_lbl" id="inforequestreason" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl">Request For</label></td>
                                                                    <td><label class="info_lbl" id="inforequestby" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl">Request Date</label></td>
                                                                    <td><label class="info_lbl" id="inforeqdate" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl">Remark</label></td>
                                                                    <td><label class="info_lbl" id="infopurpose" style="font-weight: bold;"></label></td>
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
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="requisition_item_div">
                                                <table id="reqinfodetail" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable mb-0" style="width: 100%;">
                                                    <thead>
                                                        <th style="width: 3%">#</th>
                                                        <th style="width: 20%">Item Code</th>
                                                        <th style="width: 20%">Item Name</th>
                                                        <th style="width: 20%">Barcode No.</th>
                                                        <th style="width: 7%" title="Unit of Measurement">UOM</th>
                                                        <th style="width: 10%">Quantity</th>
                                                        <th style="width: 20%">Remark</th>
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
                                        <ul class="dropdown-menu" id="requisition_action_ul"></ul>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align:right">
                                    <input type="hidden" class="form-control" name="undovoidid" id="undovoidid" readonly="true">
                                    <input type="hidden" class="form-control" name="ustatus" id="ustatus" readonly="true">
                                    <input type="hidden" class="form-control" name="oldstatus" id="oldstatus" readonly="true">

                                    <input type="hidden" class="form-control" name="itemid" id="itemid" readonly="true">
                                    <input type="hidden" class="form-control" name="statusi" id="statusi" readonly="true">
                                    <input type="hidden" class="form-control" name="statusid" id="statusid" readonly="true">
                                    <input type="hidden" class="form-control" name="usernamelbl" id="usernamelbl" readonly="true" value="{{$user}}">

                                    <input type="hidden" class="form-control" name="reqId" id="reqId" readonly="true">
                                    <input type="hidden" class="form-control" name="currentStatus" id="currentStatus" readonly="true">
                                    <input type="hidden" class="form-control" name="forwardReqId" id="forwardReqId" readonly="true">
                                    <input type="hidden" class="form-control" name="newForwardStatusValue" id="newForwardStatusValue" readonly="true">
                                    <input type="hidden" class="form-control" name="forwarkBtnTextValue" id="forwarkBtnTextValue" readonly="true">
                                    <input type="hidden" class="form-control" name="forwardActionValue" id="forwardActionValue" readonly="true">

                                    <button id="closebuttone" type="button" class="btn btn-danger form_btn" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Info -->

    <!--Registration Modal -->
    <div class="modal fade text-left fit-content" id="inlineForm" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title form_title" id="requisitionformtitle">Requisition Form</h4>
                    <div class="row">
                        <div style="text-align: right;" id="statusdisplay"></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                </div>
                <form id="Register">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="row">
                                <div class="col-xl-3 col-lg-2 col-md-6 col-sm-6 col-12 mb-1" id="sourceDiv">
                                    <label class="form_lbl">Station<b style="color: red; font-size:16px;">*</b></label>
                                    <select class="select2 form-control" name="SourceStore" id="sstore">
                                        <option selected disabled value=""></option>
                                        @foreach ($storeSrc as $srcStoreForm)
                                            <option value="{{ $srcStoreForm->StoreId }}">{{ $srcStoreForm->StoreName }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger">
                                        <strong class="errordatalabel" id="sourcestore-error"></strong>
                                    </span>
                                </div>
                                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-12 mb-1">
                                    <label class="form_lbl">Request Reason<b style="color: red; font-size:16px;">*</b></label>
                                    <select class="select2 form-control" name="RequestReason" id="RequestReason" onchange="requestReasonFn()">
                                        @foreach ($reqreasonReg as $reqreasonReg)
                                        <option value="{{$reqreasonReg->RequestReasonValue}}">{{$reqreasonReg->RequestReason}}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger">
                                        <strong class="errordatalabel" id="request-reason-error"></strong>
                                    </span>
                                </div>
                                <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-12 mb-1">
                                    <label class="form_lbl">Request For<b style="color: red; font-size:16px;">*</b></label>
                                    <select class="select2 form-control" name="RequestedBy" id="RequestedBy" onchange="requestedByVal()">
                                        <option selected value="{{ $user }}">{{ $user }}</option>
                                        @foreach ($users as $users)
                                            <option value="{{ $users->username }}">{{ $users->username }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger">
                                        <strong class="errordatalabel" id="requestedby-error"></strong>
                                    </span>
                                </div>
                                <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-12 mb-1">
                                    <label class="form_lbl">Date<b style="color: red; font-size:16px;">*</b></label>
                                    <input type="text" id="date" name="date" class="form-control reg_form" placeholder="YYYY-MM-DD" onchange="dateVal()" readonly="true" />
                                    <span class="text-danger">
                                        <strong class="errordatalabel" id="date-error"></strong>
                                    </span>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-1">
                                    <label class="form_lbl">Remark</label>
                                    <textarea type="text" placeholder="Write remark here..." class="form-control reg_form" rows="1" name="Purpose" id="Purpose" onkeyup="reqReqpurposeVal()"></textarea>
                                    <span class="text-danger">
                                        <strong class="errordatalabel" id="purpose-error"></strong>
                                    </span>
                                </div>
                            </div>
                            <hr class="my-30"/>         
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="table-responsive pr-0 pl-0" style="width: 100%;overflow-x: auto;-webkit-overflow-scrolling: touch;margin: 0 0rem;padding: 0 1rem;">
                                        <table id="dynamicTable" class="mb-0 rtable form_dynamic_table fit-content" style="width:100%;min-width: 950px;">
                                            <thead>
                                                <th class="form_lbl" style="width:3%;">#</th>
                                                <th class="form_lbl" style="width:27%;">Item Name<b style="color: red; font-size:16px;">*</b></th>
                                                <th class="form_lbl" style="width:11%;" title="Unit of Measurement">UOM</th>
                                                <th class="form_lbl" style="width:15%;">Qty. on Hand</th>
                                                <th class="form_lbl" style="width:15%;">Quantity<b style="color: red; font-size:16px;">*</b></th>
                                                <th class="form_lbl" style="width:26%;">Remark</th>
                                                <th class="form_lbl" style="width:3%;"></th>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                    <table class="mb-0">
                                        <tr>
                                            <td>
                                                <button type="button" name="adds" id="adds" class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i> Add New</button>
                                            <td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div style="display:none;">
                            <select class="select2 form-control allitems" name="allitems" id="allitems">
                                <option selected disabled value=""></option> 
                                @foreach ($itemSrcs as $itemSrc)
                                    <option data-balance="{{ $itemSrc->Balance }}" data-storeid="{{ $itemSrc->StoreId }}" value="{{ $itemSrc->ItemId }}">{{ $itemSrc->Code }}   ,   {{ $itemSrc->ItemName }}   ,   {{ $itemSrc->SKUNumber }}</option>
                                @endforeach 
                            </select>
                        </div>
                        <input type="hidden" class="form-control reg_form" name="hiddenstoreval" id="hiddenstoreval" readonly="true"/>
                        <input type="hidden" class="form-control reg_form" name="operationtypes" id="operationtypes" readonly="true" value="1"/>
                        <input type="hidden" class="form-control reg_form" name="cdate" id="cdate" readonly="true" value="{{ $curdate }}"/>
                        <input type="hidden" class="form-control reg_form" name="uname" id="uname" readonly="true" value="{{ $user }}"/>
                        <input type="hidden" class="form-control reg_form" name="tid" id="tid" readonly="true"/>
                        <input type="hidden" class="form-control reg_form" name="requistionId" id="requistionId" readonly="true"/>
                        <input type="hidden" class="form-control" name="commonVal" id="commonVal" readonly="true" /></label>
                        <input type="hidden" class="form-control" name="reqnumberi" id="reqnumberi" readonly="true" value=""/>
                        <input type="hidden" class="form-control" name="numberofItems" id="numberofItems" readonly="true" value=""/>
                        <input type="hidden" class="form-control" name="commenttype" id="commenttype" readonly="true" value=""/>
                        <button id="savebutton" type="button" class="btn btn-info form_btn">Save</button>
                        <button id="closebuttona" type="button" class="btn btn-danger form_btn closebutton" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End Registation Modal -->

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
                        <label class="form_lbl">Reason</label>
                        <textarea type="text" placeholder="Write Reason here..." class="form-control Reason" rows="3" name="Reason" id="Reason" onkeyup="voidReason()"></textarea>
                        <span class="text-danger">
                            <strong class="errordatalabel" id="void-error"></strong>
                        </span>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control" name="voidreqid" id="voidreqid" readonly="true">
                        <button id="voidreqbtn" type="button" class="btn btn-info">Void</button>
                        <button id="closebuttond" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End void modal -->

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
                            <textarea type="text" placeholder="Write Reason here..." class="form-control" rows="3" name="CommentOrReason" id="CommentOrReason" onkeyup="requisitionReasonFn()"></textarea>
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

    @include('layout.universal-component')

    <script type="text/javascript">
        var errorcolor = "#ffcccc";
        var fyears = $('#fiscalyearval').val();
        var current_date = $('#currentdateval').val();
        
        $(function () {
            cardSection = $('#page-block');
        });

        var table = "";
        var j = 0;
        var i = 0;
        var m = 0;
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
                    status: 'Approved',
                    text: 'Approve',
                    action: 'Approved',
                    message: 'Are you sure you want to change the status of this record to Approved?',
                    forecolor: '#FFFFFF',
                    backcolor: '#28c76f'
                },
                backward: {
                    status: 'Draft',
                    text: 'Back to Draft',
                    action: 'Back to Draft',
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
                forward: {
                    status: 'Issued',
                    text: 'Issue',
                    action: 'Issue',
                    message: 'Are you sure you want to change the status of this record to Issued?'
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
            'Issued': {
                forward: {
                    status: 'Received',
                    text: 'Receive',
                    action: 'Received',
                    message: 'Are you sure you want to change the status of this record to Received?'
                }
            },
            'Received': {
                backward: {
                    status: 'Issued',
                    text: 'Back to Issue',
                    action: 'Back to Issue',
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

        //Start page load event
        $(document).ready(function() {
            $('#fiscalyear').select2();
            $('.main_datatable').hide(); 
            getRequisitionData(fyears);
            countRequisitionStatusFn(fyears);
        });
        //End page load event

        function getRequisitionData(fyears){
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
                dom: "<'row'<'col-sm-3 col-md-2 col-6'f><'col-sm-3 col-md-2 col-6 mt-1 custom-1'><'col-sm-3 col-md-2 col-6 mt-1 custom-2'><'col-sm-3 col-md-2 col-6 mt-1 custom-3'>>" +
                    "<'row'<'col-sm-12 margin_top_class'tr>>" +
                    "<'row'<'col-sm-4 col-md-4 col-4'l><'col-sm-4 col-md-4 col-4 d-flex justify-content-center'i><'col-sm-4 col-md-4 col-4 d-flex justify-content-end'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/reqdata/'+fyears,
                    type: 'DELETE',
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
                        data: 'DocumentNumber',
                        name: 'DocumentNumber',
                        width:"15%"
                    },
                    {
                        data: 'SourceStore',
                        name: 'SourceStore',
                        width:"16%",
                    },
                    {
                        data: 'req_reason',
                        name: 'req_reason',
                        width:"16%"
                    },
                    {
                        data: 'RequestedBy',
                        name: 'RequestedBy',
                        width:"16%"
                    },
                    {
                        data: 'Date',
                        name: 'Date',
                        width:"15%"
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
                            else if(data == "Verified" || data == "Issued"){
                                return `<span class="badge bg-primary bg-glow">${data}</span>`;
                            }
                            else if(data == "Approved" || data == "Received"){
                                return `<span class="badge bg-success bg-glow">${data}</span>`;
                            }
                            else if(data == "Void" || data == "Void(Draft)" || data == "Void(Pending)" || data == "Void(Verified)" || data == "Void(Approved)" || data == "Void(Issued)" || data == "Rejected"){
                                return `<span class="badge bg-danger bg-glow">${data}</span>`;
                            }
                            else{
                                return `<span class="badge bg-dark bg-glow">${data}</span>`;
                            }
                        },
                        width:"15%"
                    },
                    {
                        data: 'action',
                        "render": function ( data, type, row, meta ) {
                            return `<div class="text-center"><a class="DocReqInfo" href="javascript:void(0)" onclick="DocReqInfoFn(${row.id})" data-id="requisition_id${row.id}" id="requisition_id${row.id}" title="Open requisition information page"><i class="fa-sharp fa-regular fa-circle-info fa-xl" style="color: #00cfe8;"></i></a></div>`;
                        },
                        width:"4%"
                    },
                    {
                        data: 'SourceStoreId',
                        "render": function ( data, type, row, meta ) {
                            return "";
                        },
                        'visible': false
                    },
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

                    $('#requisition_tbl').show();
                    $('#laravel-datatable-crud').DataTable().columns.adjust();
                },
                fixedHeader: {
                    header: true,
                    headerOffset: $('.header-navbar').outerHeight(),
                },
            });
            appendRequisitionFilterFn(fyears);
        }

        function appendRequisitionFilterFn(fyears){
            var requisition_fiscalyear = $(`
                <select class="selectpicker form-control dropdownclass" id="fiscalyear" name="fiscalyear[]" title="Select fiscal year here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" data-actions-box="true" data-selected-text-format="count" data-count-selected-text="Fiscal Year ({0})">
                    @foreach ($fiscalyears as $fiscalyears)
                        <option value="{{ $fiscalyears->FiscalYear }}">{{ $fiscalyears->Monthrange }}</option>
                    @endforeach
                </select>
            `);

            $('.custom-1').html(requisition_fiscalyear);
            $('#fiscalyear')
            .selectpicker()
            .selectpicker('val', fyears)
            .off('changed.bs.select') 
            .on('changed.bs.select', function () {
                let fyear = $(this).val();
                countRequisitionStatusFn(fyear);
                getRequisitionData(fyear); 
            });

            var station_filter = $(`
                <select class="selectpicker form-control dropdownclass" id="req_store_filter" name="req_store_filter[]" title="Select station here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" data-actions-box="true" multiple data-selected-text-format="count" data-count-selected-text="Station ({0})">
                    @foreach ($storeSrc as $srcStoreFilter)
                        <option selected value="{{ $srcStoreFilter->StoreId }}">{{ $srcStoreFilter->StoreName }}</option>
                    @endforeach
                </select>
            `);

            $('.custom-2').html(station_filter);
            $('#req_store_filter')
            .selectpicker()
            .off('changed.bs.select') 
            .on('changed.bs.select', function () {  
                var selected = $('#req_store_filter option:selected');
                var search = [];

                // Collect selected option values
                $.each(selected, function() {
                    search.push($(this).val());
                });

                if (search.length === 0) {
                    // No option selected: force DataTable to return no data
                    table.column(9).search('^$', true, false).draw(); // Match an impossible pattern
                } else {
                    // Options selected: build regex for filtering
                    var searchRegex = search.join('|'); // OR-separated values for regex
                    table.column(9).search(searchRegex, true, false).draw();
                }
            });

            var status_filter = $(`
                <select class="selectpicker form-control dropdownclass" id="req_status_filter" name="req_status_filter[]" title="Select status here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" data-actions-box="true" multiple data-selected-text-format="count" data-count-selected-text="Status ({0})">
                    <option selected value="Draft">Draft</option>
                    <option selected value="Pending">Pending</option>
                    <option selected value="Approved">Approved</option>
                    <option selected value="Issued">Issued</option>
                    <option selected value="Received">Received</option>
                    <option selected value="Void">Void</option>
                    <option selected value="Reject">Reject</option>
                </select>
            `);

            $('.custom-3').html(status_filter);
            $('#req_status_filter')
            .selectpicker()
            .off('changed.bs.select') 
            .on('changed.bs.select', function () {  
                var selected = $('#req_status_filter option:selected');
                var search = [];

                // Collect selected option values
                $.each(selected, function() {
                    search.push($(this).val());
                });

                if (search.length === 0) {
                    // No option selected: force DataTable to return no data
                    table.column(7).search('^$', true, false).draw(); // Match an impossible pattern
                } else {
                    // Options selected: build regex for filtering
                    var searchRegex = search.join('|'); // OR-separated values for regex
                    table.column(7).search(searchRegex, true, false).draw();
                }
            });
        }

        $('#laravel-datatable-crud tbody').on('click', 'tr', function () {
            $('#laravel-datatable-crud tbody > tr').removeClass('selected');
            $(this).addClass('selected');
            globalIndex = $(this).index();
        });

        function setFocus(targetTable) {
            $($(targetTable + ' tbody > tr')[globalIndex]).addClass('selected');
        }

        $("#addreqbutton").click(function() { 
            $('#sstore').val(null).select2
            ({
                placeholder: "Select station here",
            });

            $('#RequestReason').val(null).select2
            ({
                placeholder: "Select request reason here",
            });

            $('.reg_form').val("");
            $('.errordatalabel').html("");
            $("#statusdisplay").html("");
            $('#RequestedBy').select2();
            flatpickr('#date',{dateFormat: 'Y-m-d',clickOpens:true,maxDate:current_date});
            $('#date').val(current_date);
            $('#savebutton').text('Save');
            $('#savebutton').prop("disabled", false);
            $('#operationtypes').val(1);
            $('#dynamicTable > tbody').empty();
            $("#requisitionformtitle").html('Add Stock Requisition');
            $("#inlineForm").modal('show');
        });

        //Start type change
        $('#sstore').on('change', function() {
            var sid = $('#supplier').val();
            var storeidvar = $('#sstore').val();

            $('#dynamicTable > tbody > tr').each(function(index, tr) {
                let indx = $(this).find('.idval').val();
                calcBalanceFn(indx);
            });
            $('#sourcestore-error').html("");
        });
        //End Type change

        //Start save requistion
        $('#savebutton').click(function() {
            var optype = $('#operationtypes').val();
            var registerForm = $("#Register");
            var formData = registerForm.serialize();
            var arr = [];
            var found = 0;
            $('.itemName').each(function() {
                var name = $(this).val();

                if (arr.includes(name)) {
                    found++;
                } else {
                    arr.push(name);
                }
            });
            if (found) {
                if(parseFloat(optype) == 1){
                    $('#savebutton').text('Save');
                    $('#savebutton').prop("disabled", false);
                }
                else if(parseFloat(optype) == 2){
                    $('#savebutton').text('Update');
                    $('#savebutton').prop("disabled", false);
                }
                toastrMessage('error',"There is duplicate item","Error"); 
            } 
            else {
                $.ajax({
                    url: '/saveRequisition',
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
                            if (data.errors.SourceStore) {
                                $('#sourcestore-error').html(data.errors.SourceStore[0]);
                            }
                            if (data.errors.RequestReason) {
                                $('#request-reason-error').html(data.errors.RequestReason[0]);
                            }
                            if (data.errors.RequestedBy) {
                                $('#requestedby-error').html(data.errors.RequestedBy[0]);
                            }
                            if (data.errors.date) {
                                $('#date-error').html(data.errors.date[0]);
                            }
                            if (data.errors.Purpose) {
                                $('#purpose-error').html(data.errors.Purpose[0]);
                            }

                            if(parseFloat(optype) == 1){
                                $('#savebutton').text('Save');
                                $('#savebutton').prop("disabled", false);
                            }
                            else if(parseFloat(optype) == 2){
                                $('#savebutton').text('Update');
                                $('#savebutton').prop("disabled", false);
                            }
                            toastrMessage('error',"Check your inputs","Error");
                        } 
                        else if (data.errorv2) {
                            var error_html = '';
                            $('#dynamicTable > tbody > tr').each(function (index) {
                                let k = $(this).find('.idval').val();
                                var itmid = ($(`#itemNameSl${k}`)).val();

                                if(($(`#quantity${k}`).val()) != undefined){
                                    var qnt = $(`#quantity${k}`).val();
                                    var qntonhand = $(`#AvQuantity${k}`).val();
                                    if(isNaN(parseFloat(qnt)) || parseFloat(qnt) == 0){
                                        $(`#quantity${k}`).css("background", errorcolor);
                                        toastrMessage('error',"Please insert valid data on highlighted fields!","Error");
                                    }
                                    if(parseFloat(qnt) > parseFloat(qntonhand)){
                                        $(`#quantity${k}`).css("background", errorcolor);
                                        toastrMessage('error',"Quantity is greater than available quantity!","Error");
                                    }
                                }
                                if(isNaN(parseFloat(itmid)) || parseFloat(itmid) == 0){
                                    $(`#select2-itemNameSl${k}-container`).parent().css('background-color',errorcolor);
                                    toastrMessage('error',"Please insert valid data on highlighted fields!","Error");
                                }
                            });
                            if(parseFloat(optype) == 1){
                                $('#savebutton').text('Save');
                                $('#savebutton').prop("disabled", false);
                            }
                            else if(parseFloat(optype) == 2){
                                $('#savebutton').text('Update');
                                $('#savebutton').prop("disabled", false);
                            }   
                        } 
                        else if (data.dberrors) {
                            if(parseFloat(optype)==1){
                                $('#savebutton').text('Save');
                                $('#savebutton').prop("disabled", false);
                            }
                            else if(parseFloat(optype)==2){
                                $('#savebutton').text('Update');
                                $('#savebutton').prop("disabled", false);
                            }
                            toastrMessage('error',"Please contact administrator","Error");
                        }
                        else if(data.emptyerror){
                            if(parseFloat(optype)==1){
                                $('#savebutton').text('Save');
                                $('#savebutton').prop("disabled", false);
                            }
                            else if(parseFloat(optype)==2){
                                $('#savebutton').text('Update');
                                $('#savebutton').prop("disabled", false);
                            }
                            toastrMessage('error',"You should add atleast one item","Error");
                        } 
                        else if(data.strdifferrors){
                            if(parseFloat(optype) == 1){
                                $('#savebutton').text('Save');
                                $('#savebutton').prop("disabled", false);
                            }
                            else if(parseFloat(optype) == 2){
                                $('#savebutton').text('Update');
                                $('#savebutton').prop("disabled", false);
                            }
                            toastrMessage('error',"You can not change current station to posted station","Error");
                        }
                        else if (data.success) {
                            if(parseFloat(optype) == 1){
                                $('#savebutton').text('Save');
                                $('#savebutton').prop("disabled", false);
                            }
                            else if(parseFloat(optype) == 2){
                                $('#savebutton').text('Update');
                                $('#savebutton').prop("disabled", false);
                            }
                            countRequisitionStatusFn(data.fiscalyr);
                            if(parseFloat(optype) == 2){
                                createRequisitionInfoFn(data.rec_id);
                            }
                            var oTable = $('#laravel-datatable-crud').dataTable();
                            oTable.fnDraw(false);
                            toastrMessage('success',"Successful","Success");
                            $("#inlineForm").modal('hide');
                        }
                    },
                });
            }
        });
        //End save requistion

        function countRequisitionStatusFn(fiscalyear) {
            var fyear = 0;
            var req_void_cnt = 0;
            
            $.ajax({
                url: '/countRequisitionStatus',
                type: 'POST',
                data:{
                    fyear: fiscalyear,
                },
                dataType: 'json',
                success: function(data) {
                    $(".requisition_status_record_lbl").html("0");
                    $.each(data.requisition_status_count, function(key, value) {
                        if(value.Status == "Draft"){
                            $("#requisition_draft_record_lbl").html(value.status_count);
                        }
                        else if(value.Status == "Pending"){
                            $("#requisition_pending_record_lbl").html(value.status_count);
                        }
                        else if(value.Status == "Verified"){
                            $("#requisition_verified_record_lbl").html(value.status_count);
                        }
                        else if(value.Status == "Approved"){
                            $("#requisition_approved_record_lbl").html(value.status_count);
                        }
                        else if(value.Status == "Issued"){
                            $("#requisition_issued_record_lbl").html(value.status_count);
                        }
                        else if(value.Status == "Received"){
                            $("#requisition_received_record_lbl").html(value.status_count);
                        }
                        else if(value.Status == "Rejected"){
                            $("#requisition_reject_record_lbl").html(value.status_count);
                        }
                        else if(value.Status == "Total"){
                            $("#requisition_total_record_lbl").html(value.status_count);
                        }
                        else {
                            req_void_cnt += parseInt(value.status_count);
                            $("#requisition_void_record_lbl").html(req_void_cnt);
                        }
                    });
                }
            });
        }

        $(document).on('show.bs.collapse hide.bs.collapse', '.collapse', function (e) {
            e.stopPropagation();
            const collapse = $(this);
            const container = collapse.closest('.card, .modal-content, .row');
            const infoTarget = container.find('.requisition_header_info');
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
                const req_for = container.find('#inforequestby').text().trim();
                const station = container.find('#infosourcestore').text().trim();
                const summaryHtml = `
                    Station: <b>${station}</b>,
                    Request For: <b>${req_for}</b>`;
                infoTarget.html(summaryHtml);
            }
        });

        //Start append item dynamically
        $("#adds").click(function() {
            var it=0;
            var storeidvar = $('#sstore').val();
            var desstoreidvar = $('#dstore').val();
            var lastrowcount = $('#dynamicTable tr:last').find('td').eq(1).find('input').val();
            var itemids = $(`#itemNameSl${lastrowcount}`).val();
            if(isNaN(parseFloat(storeidvar)) || storeidvar == null){
                toastrMessage('error',"Please select source station first","Error");
                $('#sourcestore-error').html("The source station field is required.");
            }
            else if(itemids !== undefined && itemids === null){
                $(`#select2-itemNameSl${lastrowcount}-container`).parent().css('background-color',errorcolor);
                toastrMessage('error',"Please select item from highlighted field","Error");
            }
            else{
                ++i;
                j += 1;
                ++m;
                $("#dynamicTable > tbody").append(`<tr>
                    <td style="font-weight:bold;width:3%;text-align:center;">${j}</td>
                    <td style="display:none;"><input type="hidden" name="row[${m}][idvals]" id="idval${m}" class="idval form-control" readonly="true" style="font-weight:bold;" value="${m}"/></td>
                    <td style="width:27%;"><select id="itemNameSl${m}" onchange="itemVal(this)" class="select2 form-control form-control-lg itemName" name="row[${m}][ItemId]"></select></td>
                    <td style="width:11%;"><input type="text" name="row[${m}][UOM]" placeholder="UOM" id="uom${m}" class="uom form-control" readonly="true"/></td>
                    <td style="width:15%;"><input type="text" name="row[${m}][AvQuantity]" placeholder="Quantity on hand" id="AvQuantity${m}" class="AvQuantity form-control" readonly="true"/></td>
                    <td style="width:15%;"><input type="number" name="row[${m}][Quantity]" onkeyup="checkQ(this)" ondrop="return false;" onpaste="return false;" placeholder="Quantity" id="quantity${m}" class="quantity form-control numeral-mask"/></td>
                    <td style="width:26%;"><input type="text" name="row[${m}][Memo]" id="Memo${m}" class="Memo form-control" placeholder="Write remark here..."/></td>
                    <td style="width:3%;text-align:center;"><button type="button" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button><input type="hidden" name="row[${m}][Common]" id="common${m}" class="common form-control" readonly="true" style="font-weight:bold;"/><input type="hidden" name="row[${m}][StoreId]" id="storeid${m}" class="storeid form-control" readonly="true" style="font-weight:bold;"/></td>
                    <td style="display:none;></td>
                    <td style="display:none;"><input type="hidden" name="row[${m}][ItemType]" id="ItemType${m}" class="ItemType form-control" readonly="true" style="font-weight:bold;"/></td>
                    <td style="display:none;></td>
                    <td style="display:none;"><input type="hidden" name="row[${m}][DestStoreId]" id="desstoreid${m}" class="desstoreid form-control" readonly="true" style="font-weight:bold;" value="1"/></td>
                    <td style="display:none;"><input type="hidden" name="row[${m}][PartNumber]" placeholder="Part No." id="PartNumber${m}" class="PartNumber form-control" readonly="true"/></td>
                    <td style="display:none;"><input type="hidden" name="row[${m}][TransactionType]" id="TransactionType${m}" class="TransactionType form-control" readonly="true" value="Requisition" style="font-weight:bold;"/></td>
                    <td style="display:none;"><input type="hidden" name="row[${m}][UnitCost]" id="UnitCost${m}" class="UnitCost form-control" readonly="true" style="font-weight:bold;"/></td>
                </tr>`);

                renumberRows();
                var rnum = $('#commonVal').val();
                $('.common').val(rnum);
                $('.storeid').val(storeidvar);
                var default_opt = '<option selected disabled value=""></option>';
                var options = $("#allitems");
                $(`#itemNameSl${m}`).append(default_opt);
                $(`#itemNameSl${m}`).append(options.find(`option[data-storeid="${storeidvar}"]`).clone()); 
                $(`#itemNameSl${m} option[data-balance = 0]`).remove();
                $('#dynamicTable > tbody  > tr').each(function(index, tr) {
                    let item_id = $(this).find('.itemName').val();
                    $(`#itemNameSl${m} option[value="${item_id}"]`).remove(); 
                });

                $(`#itemNameSl${m}`).append(default_opt);
                $(`#itemNameSl${m}`).select2
                ({
                    placeholder: "Select item here",
                });
                $(`#select2-itemNameSl${m}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
            }
        });
        //End append item dynamically

        function calcBalanceFn(rowid){
            var baseRecordId = null;
            var storeval = null;
            var itemid = null;
            var net_balance = null;
            var qty = null;
            $.ajax({
                url: '/calcReqStBalance', 
                type: 'POST',
                data:{
                    baseRecordId:$('#tid').val() || 0,
                    storeval:$('#sstore').val(),
                    itemid:$(`#itemNameSl${rowid}`).val(),
                },
                success: function(data) {
                    net_balance = parseFloat(data.available_qty);
                    qty = $(`#quantity${rowid}`).val();
                    $(`#AvQuantity${rowid}`).val(net_balance);

                    if(parseFloat(qty) > parseFloat(net_balance)){
                        $(`#quantity${rowid}`).val("");
                    }

                    $.each(data.itemdata, function(key, value) {
                        $(`#uom${rowid}`).val(value.uom_name);
                    }); 
                }
            });
        }

        //start select item
        function itemVal(ele) {
            var stid = $(ele).closest('tr').find('.storeid').val();
            var itid = $(ele).closest('tr').find('.itemName').val();
            var idval = $(ele).closest('tr').find('.idval').val();
            var arr = [];
            var found = 0;
            var storeidvar = $('#sstore').val();
            var registerForm = $("#Register");
            var formData = registerForm.serialize();
            $('.itemName').each(function() 
            { 
                var name=$(this).val();
                if(arr.includes(name))
                found++;
                else
                arr.push(name);
            });
            if(found) 
            {
                toastrMessage('error',"Item already exist","Error"); 
                $(ele).closest('tr').find('.itemName').val("0").trigger('change');
                $(ele).closest('tr').find('.PartNumber').val("");
                $(ele).closest('tr').find('.Code').val("");
                $(ele).closest('tr').find('.uom').val("");
                $(ele).closest('tr').find('.UnitCost').val("");
                $(ele).closest('tr').find('.quantity').val("");
                $(ele).closest('tr').find('.AvQuantity').val("");
                $(`#select2-itemNameSl${idval}-container`).parent().css('background-color',errorcolor);
            }
            else{
                calcBalanceFn(idval);
                $(`#select2-itemNameSl${idval}-container`).parent().css('background-color',"white");
            }
        }
        //end select type

        //start quantity check
        function checkQ(ele) {
            var availableq = $(ele).closest('tr').find('.AvQuantity').val()||0;
            var quantity = $(ele).closest('tr').find('.quantity').val();
            $(ele).closest('tr').find('.quantity').css("background","white");
            if (parseFloat(quantity) > parseFloat(availableq)) {
                toastrMessage('error',"There is no available quantity","Error");
                $(ele).closest('tr').find('.quantity').val("");
                $(ele).closest('tr').find('.quantity').css("background",errorcolor);
            }
            if (parseFloat(quantity) == 0) {
                $(ele).closest('tr').find('.quantity').val("");
            }
            
        }
        //end quantity check

        //start quantity check
        function findQuantitys(ele) {
            var availableq = $('#itemquantity').val();
            var quantity = $('#reqquantity').val();
            if (parseFloat(quantity) > parseFloat(availableq)) {
                toastrMessage('error',"There is no available quantity","Error");
                $('#reqquantity').val("");
            }
            if (parseFloat(quantity) == 0) {
                $('#reqquantity').val("");
            }
            $('#newquantity-error').html("");
        }
        //end quantity check

        //Start remove item dynamically
        $(document).on('click', '.remove-tr', function() {
            $(this).parents('tr').remove();
            renumberRows();
            --i;
        });
        //End remove item dynamically

        //Start reorder number
        function renumberRows() {
            var ind;
            $('#dynamicTable > tbody > tr').each(function(index, el) {
                $(this).children('td').first().text(++index);
                $('#numberofItems').val(index);
                $('#numberofItemsLbl').text(index);
                ind = index;
            });
            if (ind == 0) {
                $('.totalrownumber').hide();
            }
            else{
                $('.totalrownumber').show();
            }
        }
        //End reorder table

        //edit modal open
        function editRequisitionFn(recIdVar) {
            $('.select2').select2();
            var sourcestr = "";
            var status_color = "";
            var cmnt;
            var j = 0;
            $('#dynamicTable > tbody').empty();

            $.ajax({
                type: "get",
                url: "{{url('requisitionedit')}}"+'/'+recIdVar,
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
                    var srcStore = data.srcstores;
                    var desStore = data.desstores;
                    $('#soustoredis').val(srcStore);
                    $('#desstoredis').val(desStore);
                    $('#requistionId').val(recIdVar);

                    $.each(data.reqheader, function(key, value) {
                        $('#sstore').val(value.SourceStoreId).select2();
                        $('#RequestedBy').val(value.RequestedBy).select2();
                        $('#RequestReason').val(value.RequestReason).select2();
                        flatpickr('#date',{dateFormat: 'Y-m-d',clickOpens:true,maxDate:current_date});
                        $('#date').val(value.Date);
                        $('#Purpose').val(value.Purpose);
                        sourcestr = value.SourceStoreId;

                        if(value.Status == "Draft"){
                            status_color = "#A8AAAE";
                        }
                        else if(value.Status == "Pending"){
                            status_color = "#f6c23e";
                        }
                        else if(value.Status == "Verified" || value.Status == "Checked" || value.Status == "Issued"){
                            status_color = "#7367F0";
                        }
                        else if(value.Status == "Approved" || value.Status == "Confirmed"){
                            status_color = "#1cc88a";
                        }
                        else{
                            status_color = "#e74a3b";
                        }

                        $("#statusdisplay").html(`<span class="form_title" style='color:${status_color};font-weight:bold;text-shadow;1px 1px 10px ${status_color};font-size:16px;'>${value.DocumentNumber},     ${value.Status}</span>`);
                    });

                    $.each(data.reqdetail, function(key, value) {
                        ++i;
                        ++m;
                        ++j;
                        var vis = "";
                        $("#dynamicTable > tbody").append(`<tr>
                            <td style="font-weight:bold;width:3%;text-align:center;">${j}</td>
                            <td style="display:none;"><input type="hidden" name="row[${m}][idvals]" id="idval${m}" class="idval form-control" readonly="true" style="font-weight:bold;" value="${m}"/></td>
                            <td style="width:27%;"><select id="itemNameSl${m}" onchange="itemVal(this)" class="select2 form-control itemName" name="row[${m}][ItemId]"></select></td>
                            <td style="width:10%;display:none;"><input type="text" name="row[${m}][Code]" placeholder="Code" id="Code${m}" class="Code form-control" readonly="true" value="${value.ItemCode}"/></td>
                            <td style="width:11%;"><input type="text" name="row[${m}][UOM]" placeholder="UOM" id="uom${m}" class="uom form-control" readonly="true" value="${value.UomName}"/></td>
                            <td style="width:15%;"><input type="text" name="row[${m}][AvQuantity]" placeholder="Quantity On Hand" id="AvQuantity${m}" class="AvQuantity form-control" readonly="true" value=""/></td>
                            <td style="width:15%;"><input type="number" name="row[${m}][Quantity]" onkeyup="checkQ(this)" ondrop="return false;" onpaste="return false;" placeholder="Quantity" id="quantity${m}" class="quantity form-control numeral-mask" value="${value.Quantity}"/></td>
                            <td style="width:26%;"><input type="text" name="row[${m}][Memo]" id="Memo${m}" class="Memo form-control" value="${value.ReqMemo}" placeholder="Write remark here..."/></td>
                            <td style="width:3%;text-align:center;"><button type="button" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button><input type="hidden" name="row[${m}][Common]" id="common${m}" class="common form-control" readonly="true" style="font-weight:bold;" value="${value.Common}"/><input type="hidden" name="row[${m}][StoreId]" id="storeid${m}" class="storeid form-control" readonly="true" style="font-weight:bold;" value="${value.StoreId}"/></td>
                            <td style="display:none;></td>
                            <td style="display:none;"><input type="hidden" name="row[${m}][ItemType]" id="ItemType${m}" class="ItemType form-control" readonly="true" style="font-weight:bold;" value="${value.ItemType}"/></td>
                            <td style="display:none;></td>
                            <td style="display:none;"><input type="hidden" name="row[${m}][DestStoreId]" id="desstoreid${m}" class="desstoreid form-control" readonly="true" style="font-weight:bold;" value="1"/></td>
                            <td style="display:none;"><input type="hidden" name="row[${m}][PartNumber]" placeholder="Part No." id="PartNumber${m}" class="PartNumber form-control" readonly="true" value="${value.PartNumber}"/></td>
                            <td style="display:none;"><input type="hidden" name="row[${m}][TransactionType]" id="TransactionType${m}" class="TransactionType form-control" readonly="true" value="Requisition" style="font-weight:bold;"/></td>
                            <td style="display:none;"><input type="hidden" name="row[${m}][UnitCost]" id="UnitCost${m}" class="UnitCost form-control" readonly="true" style="font-weight:bold;" value="${value.UnitCost}"/></td>
                        </tr>`);

                        var selectedoptions = `<option selected value="${value.ItemId}">${value.ItemCode}, ${value.ItemName}, ${value.SKUNumber}</option>`;
                        var options = $("#allitems"); 
                        $(`#itemNameSl${m}`).append(options.find(`option[data-storeid="${sourcestr}"]`).clone()); 
                        $(`#itemNameSl${m} option[data-balance = 0]`).remove();
                        $('#dynamicTable > tbody > tr').each(function(index, tr) {
                            let item_id = $(this).find('.itemName').val();
                            $(`#itemNameSl${m} option[value="${item_id}"]`).remove(); 
                        });

                        $(`#itemNameSl${m} option[value="${value.ItemId}"]`).remove(); 
                        $(`#itemNameSl${m}`).append(selectedoptions).select2(); 

                        $(`#select2-itemNameSl${m}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                        calcBalanceFn(m);
                    });
                    renumberRows();
                }
            });

            $('.errordatalabel').html("");
            $('#operationtypes').val(2);
            $('#savebutton').text('Update');
            $('#savebutton').prop("disabled", false);
            $("#requisitionformtitle").html('Edit Stock Requisition');
            $('#inlineForm').modal('show');
        }
        //end edit modal open

        function refreshRequisistionDataFn(){
            var f_year = $('#fiscalyear').val();
            countRequisitionStatusFn(f_year);

            var rTable = $('#laravel-datatable-crud').dataTable();
            rTable.fnDraw(false);
        }

        //Start Print Attachment
        $('body').on('click', '.printReqAttachment', function() {
            var id = $(this).data('id');
            var link = $(this).data('link');
            window.open(link, 'Requisition', 'width=1200,height=800,scrollbars=yes');
        });
        //End Print Attachment

        //Start show requisition doc info
        function DocReqInfoFn(recordId) {
            createRequisitionInfoFn(recordId);
            $("#reqInfoModal").modal('show');
        }
        //End show requisition doc info

        function createRequisitionInfoFn(recordId){
            var comments;
            var issstore;
            var appstore;
            var statusvals = "";
            var lidata = "";
            var status_color = "";
            var action_links = "";
            var withold_btn_link = "";
            var major_btn_link = `<li><hr class="dropdown-divider"></li>`;
            var status_btn_link = `<li><hr class="dropdown-divider"></li>`;
            var flag_btn_link = `<li><hr class="dropdown-divider"></li>`;
            var print_btn_link = "";
            var edit_link = `
                @can("Requisition-Edit")
                    <li>
                        <a class="dropdown-item editReqRecord" href="javascript:void(0)" onclick="editRequisitionFn(${recordId})" data-id="editRequisitionLink${recordId}" id="editRequisitionLink${recordId}" title="Edit record">
                        <span><i class="fa-solid fa-pencil"></i> Edit</span>  
                        </a>
                    </li>
                @endcan`;

            var void_link = `
                @can("Requisition-Void")
                    <li>
                        <a class="dropdown-item voidReqRecord" href="javascript:void(0)" onclick="voidRequisitionFn(${recordId})" data-id="voidReqLink${recordId}" id="voidReqLink${recordId}" title="Void record">
                        <span><i class="fa-solid fa-ban"></i> Void</span>  
                        </a>
                    </li>
                @endcan`;

            var undovoid_link = `
                @can("Requisition-Void")
                <li>
                    <a class="dropdown-item undovoidlnbtn" href="javascript:void(0)" onclick="undoRequisitionFn(${recordId})" data-id="undovoidlink${recordId}" id="undovoidlink${recordId}" title="Undo void record">
                    <span><i class="fa fa-undo"></i> Undo Void</span>  
                    </a>
                </li>
                @endcan`;

            var change_to_pending_link = `
                @can("Requisition-ChangeToPending")
                <li>
                    <a class="dropdown-item changetopending" onclick="forwardRequisitionFn()" id="changetopending" title="Change record to pending">
                    <span><i class="fa-solid fa-forward"></i> Change to Pending</span>  
                    </a>
                </li>
                @endcan`;

            var back_to_draft_link = `
                @can("Requisition-ChangeToPending")
                <li>
                    <a class="dropdown-item requisitionbackward" id="backtodraft" title="Change record to draft">
                    <span><i class="fa-solid fa-backward"></i> Back to Draft</span>  
                    </a>
                </li>
                @endcan`;

            var verify_link = `
                @can("Requisition-Verify")
                <li>
                    <a class="dropdown-item verifyrequisition" onclick="forwardRequisitionFn()" id="verifyrequisition" title="Change record to verified">
                    <span><i class="fa-solid fa-forward"></i> Verify</span>  
                    </a>
                </li>
                @endcan`;

            var back_to_pending = `
                @can("Requisition-Verify")
                <li>
                    <a class="dropdown-item requisitionbackward" id="backtopending" title="Change record to pending">
                    <span><i class="fa-solid fa-backward"></i> Back to Pending</span>  
                    </a>
                </li>
                @endcan`;

            var approve_link = `
                @can("Requisition-Approve")
                <li>
                    <a class="dropdown-item approverequisition" onclick="forwardRequisitionFn()" id="approverequisition" title="Change record to approved">
                    <span><i class="fa-solid fa-forward"></i> Approve</span>  
                    </a>
                </li>
                @endcan`;

            var back_to_verify_link = `
                @can("Requisition-Approve")
                <li>
                    <a class="dropdown-item requisitionbackward" id="backtoverify" title="Change record to verified">
                    <span><i class="fa-solid fa-backward"></i> Back to Verified</span>  
                    </a>
                </li>
                @endcan`;

            var reject_link = `
                @can("Requisition-Approve")
                <li>
                    <a class="dropdown-item requisitionbackward" id="reqrejectbtn" title="Change record to rejected">
                    <span><i class="fa-solid fa-ban"></i> Reject</span>  
                    </a>
                </li>
                @endcan`;

            var issue_link = `
                @can("Requisition-Issue")
                <li>
                    <a class="dropdown-item issuebtn" onclick="forwardRequisitionFn()" id="issuebtn" title="Change record to issued">
                    <span><i class="fa-solid fa-forward"></i> Issue</span>  
                    </a>
                </li>
                @endcan`;

            var received_link = `
                @can("Requisition-Receive")
                <li>
                    <a class="dropdown-item issuebtn" onclick="forwardRequisitionFn()" id="receivebtn" title="Change record to received">
                    <span><i class="fa-solid fa-forward"></i> Receive</span>  
                    </a>
                </li>
                @endcan`;

            var back_to_issue_link = `
                @can("Requisition-Receive")
                <li>
                    <a class="dropdown-item requisitionbackward" id="backtoissue" title="Change record to issued">
                    <span><i class="fa-solid fa-backward"></i> Back to Issue</span>  
                    </a>
                </li>
                @endcan`;

            var print_requisition_link = `
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item printReqAttachment" href="javascript:void(0)" data-link="/req/${recordId}" data-id="printreqlink${recordId}" id="printreqlink${recordId}" title="Print Store Issue Voucher Attachment">
                    <span><i class="fa fa-file"></i> Print SRV</span>  
                    </a>
                </li>`;

            $('.infoRecDiv').hide();  
            $("#statusid").val(recordId);
            $("#reqId").val(recordId);

            $.ajax({
                type: "get",
                url: "{{url('showReqData')}}"+'/'+recordId,
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
                    fetchStoreRequisitionFn(recordId);
                    $(".infoscl").collapse('show');
                },
                success: function (data) {
                    var dc = data;
                    issstore = data.issuecnt;
                    appstore = data.approvecnt;
                    $.each(data.reqHeader, function(key, value) {
                        $('#infoissdocnum').text(value.IssueDocNumber);
                        $('#infosourcestore').text(value.SourceStore);
                        $('#inforequestreason').text(value.RequestReason);
                        $('#inforequestby').text(value.RequestedBy);
                        $('#inforeqdate').text(value.Date);
                        $('#infopurpose').html(value.Purpose);
                        statusvals = value.Status;
                        $("#currentStatus").val(statusvals);

                        if(statusvals == "Draft"){
                            major_btn_link += edit_link;
                            major_btn_link += void_link;

                            status_btn_link += change_to_pending_link;
                            status_color = "#A8AAAE";
                        }
                        else if(statusvals == "Pending"){
                            major_btn_link += edit_link;
                            major_btn_link += void_link;

                            if(parseFloat(appstore) > 0){
                                status_btn_link += approve_link;
                                status_btn_link += back_to_draft_link;
                                status_btn_link += reject_link;
                            }
                            status_color = "#f6c23e";
                        }
                        // else if(statusvals == "Verified"){
                        //     major_btn_link += edit_link;
                        //     major_btn_link += void_link;

                        //     if(parseFloat(appstore) > 0){
                        //         status_btn_link += approve_link;
                        //         status_btn_link += back_to_pending;
                        //         status_btn_link += reject_link;
                        //     }
                        //     status_color = "#7367F0";
                        // }
                        else if(statusvals == "Approved"){ 
                            if(parseFloat(issstore) > 0){
                                status_btn_link += issue_link;
                            }
                            if(parseFloat(appstore) > 0){
                                status_btn_link += back_to_pending;
                            }
                            if(parseFloat(issstore) > 0){ // to keep orders
                                status_btn_link += reject_link;
                            }
                            major_btn_link = "";
                            status_color = "#1cc88a";
                        }
                        else if(statusvals == "Issued"){
                            major_btn_link += void_link;
                            status_btn_link += received_link;

                            status_color = "#7367F0";
                        }
                        else if(statusvals == "Received"){
                            major_btn_link = "";
                            status_btn_link += back_to_issue_link;

                            status_color = "#1cc88a";
                        }
                        else if(statusvals == "Void" || statusvals == "Void(Draft)" || statusvals == "Void(Pending)" || statusvals == "Void(Verified)" || statusvals == "Void(Approved)" || statusvals == "Void(Issued)" || statusvals == "Void(Received)"){
                            major_btn_link += undovoid_link;
                            status_btn_link = "";

                            status_color = "#e74a3b";
                        }
                        else if(statusvals == "Rejected"){
                            major_btn_link = "";
                            status_btn_link += approve_link;
                            status_color = "#e74a3b";
                        }
                        else{
                            major_btn_link = "";
                            status_btn_link = "";
                            status_color = "#e74a3b";
                        }

                        $(".info_modal_title_lbl").html(`<span class="form_title" style='color:${status_color};font-weight:bold;text-shadow;1px 1px 10px ${status_color};font-size:16px;'>${value.DocumentNumber},     ${statusvals}</span>`);

                        action_links = `
                        <li>
                            <a class="dropdown-item viewRequisitionAction" onclick="viewRequisitionActionFn(${recordId})" data-id="view_requisition_actionbtn${recordId}" id="view_requisition_actionbtn${recordId}" title="View user log">
                            <span><i class="fa-solid fa-eye"></i> View User Log</span>  
                            </a>
                        </li>
                        ${major_btn_link}
                        ${status_btn_link}
                        ${print_requisition_link}`;

                        $("#requisition_action_ul").empty().append(action_links);
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
                        else if(value.action == "Back to Draft" || value.action == "Undo Void" || value.action == "Back to Pending" || value.action == "Back to Verify" || value.action == "Back to Issue" || value.action == "Withholding Unsettled"){
                            classes = "secondary";
                        }
                        else if(value.action == "Created" || value.action == "Approved" || value.action == "Confirmed" || value.action == "Received"){
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
                    $("#universal-action-log-canvas").empty().append(lidata);
                }
            });
        }

        function viewRequisitionActionFn(recordId){
            $("#action-log-title").html("User Log Information");
            $("#action-log-universal-modal").modal('show');
        }

        function fetchStoreRequisitionFn(recordId){
            $('#reqinfodetail').DataTable({
                destroy:true,
                processing: true,
                serverSide: true,
                paging: false,
                info:false,
                searchHighlight: true,
                "order": [[ 0, "desc" ]],
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
                    url: '/showReqDetail/' + recordId,
                    type: 'DELETE',
                },
                columns: [
                    {
                        data:'DT_RowIndex',
                        width:'3%',
                    },
                    {
                        data: 'ItemCode',
                        name: 'ItemCode',
                        width:'20%',
                    },
                    {
                        data: 'ItemName',
                        name: 'ItemName',
                        width:'20%',
                    },
                    {
                        data: 'SKUNumber',
                        name: 'SKUNumber',
                        width:'20%',
                    },
                    {
                        data: 'UOM',
                        name: 'UOM',
                        width:'7%',
                    },
                    {
                        data: 'Quantity',
                        name: 'Quantity',
                        width:'10%',
                        render: $.fn.dataTable.render.number(',', '.',0, '')
                    },
                    {
                        data: 'Memo',
                        name: 'Memo',
                        width:'20%',
                    }
                ],
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
                    $('.infoRecDiv').show();  
                },
            });
        }

        //Start Void Modal 
        function voidRequisitionFn(recordId){
            $('.Reason').val("");
            $('.errordatalabel').html("");
            var fiscal_year_current = null;
            var fiscal_year_store = null;
            var fiscal_year_record = null;
            var status = "";
            $.ajax({
                type: "get",
                url: "{{url('showReqData')}}"+'/'+recordId,
                dataType: "json",
                success: function (data) {
                    fiscal_year_current = data.fyear;
                    fiscal_year_store = data.fyearstr;
                    $.each(data.reqHeader, function(key, value) {
                        status = value.Status;
                        fiscal_year_record = value.fiscalyear;
                    });

                    if (status == "Void") {
                        toastrMessage('error',"This record cannot be voided again because its current status is Void","Error");
                        $("#voidmodal").modal('hide');
                    }
                    else if(parseInt(fiscal_year_record) != parseInt(fiscal_year_store)){
                        toastrMessage('error',"You can not void a closed fiscal year transaction","Error");
                        $("#voidmodal").modal('hide');
                    }
                    else{
                        $("#voidreqid").val(recordId);
                        $('#voidreqbtn').prop("disabled", false);
                        $('#voidreqbtn').text("Void");
                        $("#voidmodal").modal('show');
                    }
                }
            });
        }
        //End Void Modal 

        //Void requisition Starts
        $('#voidreqbtn').click(function() {
            var deleteForm = $("#voidform");
            var formData = deleteForm.serialize();
            var recid = $("#voidreqid").val();
            $.ajax({
                url: '/deleteReqData/' + recid,
                type: 'DELETE',
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
                    $('#voidreqbtn').text('Voiding...');
                    $('#voidreqbtn').prop("disabled", true);
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
                        $('#voidreqbtn').text('Void');
                        $('#voidreqbtn').prop("disabled", false);
                        toastrMessage('error',"Check your inputs","Error");
                    }
                    else if (data.dberrors) {
                        $('#voidreqbtn').text('Void');
                        $('#voidreqbtn').prop("disabled", false);
                        $("#voidmodal").modal('hide');
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if (data.success) {
                        toastrMessage('success',"Successful","Success");
                        createRequisitionInfoFn(data.reqId);
                        countRequisitionStatusFn(data.fiscalyr);
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                        $("#voidmodal").modal('hide');
                    }
                }
            });
        });
        //Void requisition Ends

        function forwardRequisitionFn() {
            const requestId = $('#reqId').val();
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
                    requisitionForwardActionFn();
                }
                else if (result.dismiss === Swal.DismissReason.cancel) {}
            });
        }

        function requisitionForwardActionFn(){
            var forwardForm = $("#reqInfoform");
            var formData = forwardForm.serialize();
            var recordId = $('#reqId').val();
            $.ajax({
                url: '/requisitionForwardAction',
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
                    else if(data.valerror){
                        var item_name = "";
                        $.each(data.valerror, function(key, value) {
                            item_name += `${++key}) ${value.approved_item}</br>`;
                        });
                        toastrMessage('error',"There is no available quantity for the following items</br>"+item_name,"Error");
                    }
                    else if (data.success) {
                        toastrMessage('success',"Successful","Success");
                        createRequisitionInfoFn(recordId);
                        countRequisitionStatusFn(data.fiscalyr);

                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                    }
                }
            });
        }

        $(document).on('click', '.requisitionbackward', function(){
            const requestId = $('#reqId').val();
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
                url: '/requisitionBackwardAction',
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
                        createRequisitionInfoFn(recordId);
                        countRequisitionStatusFn(data.fiscalyr);

                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);

                        $('#backwardActionModal').modal('hide');
                    }
                }
            });
        });

        function requisitionReasonFn() {
            $('#commentres-error').html("");
        }

        function reqTypeVal() {
            $('#type-error').html(""); 
        }

        function sourcestoreVal() {
            $('#sourcestore-error').html("");
        }

        function destinationstoreVal() {
            $('#destinationstore-error').html("");
        }

        function dateVal() {
            $('#date-error').html("");
        }

        function reqReqpurposeVal() {
            $('#purpose-error').html("");
        }

        function requestedByVal() {
            $('#requestedby-error').html("");
        }

        function requestReasonFn() {
            $('#request-reason-error').html("");
        }

        $(function () {
            cardSection = $('#page-block');
        });

        //Start Print Attachment
        $('body').on('click', '.printSIVAttachment', function () 
        {
            var id = $(this).data('id');
            var link=$(this).data('link');
            window.open(link, 'Issue', 'width=1200,height=800,scrollbars=yes');
        });
        //End Print Attachment

        function voidReason(){
            $('#void-error').html("");
        }

        function undoRequisitionFn(recordId){
            var fiscalyearcurr = null;
            var fyearstrs = null;
            var fyear_rec = null;
            var status = "";
            $.ajax({
                type: "get",
                url: "{{url('showReqData')}}"+'/'+recordId,
                dataType: "json",
                success: function (data) {
                    fiscal_year_curr = data.fyear;
                    fyearstrs = data.fyearstr;

                    $.each(data.reqHeader, function(key, value) {
                        status = value.Status;
                        fyear_rec = value.fiscalyear
                    });

                    if (status == "Draft" || status == "Pending" || status == "Verified" || status == "Approved" || status == "Issued" || status == "Rejected") {
                        toastrMessage('error',"Record status should be void","Error");
                    }
                    else if(parseInt(fyear_rec) != parseInt(fyearstrs)){
                        toastrMessage('error',"You cannot undo void on a closed fiscal year transaction","Error");
                    }
                    else{
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
                                $("#undovoidid").val(recordId);
                                $("#ustatus").val(data.Status);
                                $("#oldstatus").val(data.StatusOld);
                                undoVoidRequisitionFn(recordId);
                            }
                            else if (result.dismiss === Swal.DismissReason.cancel) {}
                        });
                    }
                }
            });
        }

        function undoVoidRequisitionFn(recordId){
            var registerForm = $("#reqInfoform");
            var formData = registerForm.serialize();
            var statusVal = $("#ustatus").val();
            var oldstatusVal = $("#oldstatus").val();
            $.ajax({
                url: '/undorequistion',
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
                    if(data.valerror){
                        var items_list = '';
                        $.each(data.countItems, function(key, value) {
                            items_list += `${++key}, ${value.ItemName}`;
                        });
                        toastrMessage('error',"You cannot void the following Item(s) because item(s) have transactions.</br>" + items_list,"Error");   
                    }
                    else if (data.dberrors) {
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if (data.success) {
                        toastrMessage('success',"Successful","Success");
                        createRequisitionInfoFn(data.reqId);
                        countRequisitionStatusFn(data.fiscalyr);
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                    }
                },
            });
        }
    </script>
@endsection
