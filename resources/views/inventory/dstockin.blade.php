@extends('layout.app1')
@section('title')
@endsection
@section('content')
    @can('Direct-StockIN-View')
        <div class="app-content content">
            <section id="responsive-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-bottom fit-content mb-0 pb-0">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align: left !important;align-items: center;padding: 10px 5px;">
                                            <h3 class="card-title form_title">Direct Stock-IN</h3>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align: right !important;align-items: center;padding: 10px 5px;">
                                            <button type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm" onclick="refreshDStockInDataFn()"><i class="fas fa-sync-alt"></i></button>
                                            @if (auth()->user()->can('Direct-StockIN-Add'))
                                            <button type="button" class="btn btn-gradient-info btn-sm addstockin header-prop" id="addstockin"><i class="fas fa-plus"></i><span class="header-text">&nbsp Add</span></button>
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
                                                            <i class="fas fa-dolly"></i>
                                                        </div>
                                                    </div>
                                                    <div class="media-body my-auto mr-1">
                                                        <span class="font-weight-bolder mb-0 dstockin_status_record_lbl" id="dstockin_draft_record_lbl"></span>
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
                                                            <i class="fas fa-dolly"></i>
                                                        </div>
                                                    </div>
                                                    <div class="media-body my-auto mr-1">
                                                        <span class="font-weight-bolder mb-0 dstockin_status_record_lbl" id="dstockin_pending_record_lbl"></span>
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
                                                            <i class="fas fa-dolly"></i>
                                                        </div>
                                                    </div>
                                                    <div class="media-body my-auto mr-1">
                                                        <span class="font-weight-bolder mb-0 dstockin_status_record_lbl" id="dstockin_verified_record_lbl"></span>
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
                                                            <i class="fas fa-dolly"></i>
                                                        </div>
                                                    </div>
                                                    <div class="media-body my-auto mr-1">
                                                        <span class="font-weight-bolder mb-0 dstockin_status_record_lbl" id="dstockin_received_record_lbl"></span>
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
                                                            <i class="fas fa-dolly"></i>
                                                        </div>
                                                    </div>
                                                    <div class="media-body my-auto mr-1">
                                                        <span class="font-weight-bolder mb-0 dstockin_status_record_lbl" id="dstockin_void_record_lbl"></span>
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
                                                            <i class="fas fa-dolly"></i>
                                                        </div>
                                                    </div>
                                                    <div class="media-body my-auto mr-1">
                                                        <span class="font-weight-bolder mb-0 dstockin_status_record_lbl" id="dstockin_total_record_lbl"></span>
                                                        <p class="card-text font-small-3 mb-0">Total</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>      
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 fit-content">
                                    <div class="row main_datatable" id="dstockin_tbl">
                                        <div style="width:99%; margin-left:0.5%;"> 
                                            <table id="laravel-datatable-crud" class="display table-bordered table-striped table-hover defaultdatatable mb-0 mobile-dt" style="width: 100%">
                                                <thead>
                                                    <tr>
                                                        <th style="display: none;"></th>
                                                        <th style="width: 3%;">#</th>
                                                        <th style="width: 12%;" title="Direct Stock-In Document Number">Document No.</th>
                                                        <th style="width: 8%;">Type</th>
                                                        <th style="width: 17%;">Supplier</th>
                                                        <th style="width: 10%;">Payment Type</th>
                                                        <th style="width: 15%;">Source Station</th>
                                                        <th style="width: 15%;">Destination Station</th>
                                                        <th style="width: 8%;">Date</th>
                                                        <th style="width: 8%;">Status</th>
                                                        <th style="width: 4%;">Action</th>
                                                        <th style="display: none;"></th>
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
    <div class="modal fade text-left fit-content" id="dstockinInfoModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="dispatchinfotitle" aria-hidden="true" style=" overflow-y: scroll;">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title form_title" id="dstockininfotitle">Direct Stock-IN Information</h4>
                    <div class="row">
                        <div style="text-align: right" class="form_title info_modal_title_lbl" id="statustitles"></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <form id="dstockinInfoForm">
                    @csrf
                    <div class="modal-body">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <section id="card-text-alignment">
                                        <div class="d-flex justify-content-between align-items-center cursor-pointer border-bottom" data-toggle="collapse" data-target=".infoscl" aria-expanded="true">
                                            <h5 class="mb-0 form_title dstockin_header_info"><i class="far fa-info-circle"></i> Basic Information</h5>
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
                                                                    <td><label class="info_lbl">Type</label></td>
                                                                    <td><label class="info_lbl" id="infoDSTypeLbl" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl">Date</label></td>
                                                                    <td><label class="info_lbl" id="infoDSDate" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl">Remark</label></td>
                                                                    <td><label class="info_lbl" id="infoDSRemark" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mt-1 mb-1 allinfo purchaseinfo">
                                                    <div class="card shadow-none border m-0">
                                                        <div class="card-body">
                                                            <h6 class="card-title mb-0"><i class="fas fa-dolly"></i> Purchase Information</h6>
                                                            <hr class="my-50">
                                                            <table class="infotbl" style="width:100%;font-size:12px;">
                                                                <tr>
                                                                    <td><label class="info_lbl">Supplier</label></td>
                                                                    <td><label class="info_lbl" id="infoSupplierNameLbl" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl">Payment Type</label></td>
                                                                    <td><label class="info_lbl" id="infoPaymentTypeLbl" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl">Station</label></td>
                                                                    <td><label class="info_lbl" id="infoStationLbl" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl">Purchased By</label></td>
                                                                    <td><label class="info_lbl" id="infoPurchaseByLbl" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mt-1 mb-1 allinfo othersinfo">
                                                    <div class="card shadow-none border m-0">
                                                        <div class="card-body">
                                                            <h6 class="card-title mb-0" id="othersinfo_title"></h6>
                                                            <hr class="my-50">
                                                            <table class="infotbl" style="width:100%;font-size:12px;">
                                                                <tr>
                                                                    <td><label class="info_lbl">Source Station</label></td>
                                                                    <td><label class="info_lbl" id="infoSourceStationLbl" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl">Destination Station</label></td>
                                                                    <td><label class="info_lbl" id="infoDestinationStationLbl" style="font-weight: bold;"></label></td>
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
                                        <div class="row infoRecDiv" id="dstockin_item_div">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <table id="dstockinInfodatatbl" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable" style="width: 100%">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:3%;">#</th>
                                                            <th style="width:10%;">Item Code</th>
                                                            <th style="width:21%;">Item Name</th>
                                                            <th style="width:10%;" title="Barcode Number">Barcode No.</th>
                                                            <th style="width:8%;" title="Unit of Measurement">UOM</th>
                                                            <th style="width:8%;">Quantity</th>
                                                            <th style="width:10%;" class="purchase_prop">Unit Cost</th>
                                                            <th style="width:10%;" class="purchase_prop">Total Cost</th>
                                                            <th style="width:20%;">Remark</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="table table-sm"></tbody>
                                                    <tfoot class="table table-sm" id="item_tbl_footer">
                                                        <tr>
                                                            <td colspan="7" style="padding-right: 2px !important;text-align:right;font-weight: bold;">Total</td>
                                                            <td>
                                                                <label id="infoDSTotalCostFooter" class="info_lbl infoDSTotalCost" style="font-weight: bold;"></label>
                                                            </td>
                                                            <td></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="row" style="display: none;">
                                            <div class="col-xl-8 col-lg-6 col-md-3 col-sm-3 col-12"></div>
                                            <div class="col-xl-4 col-lg-6 col-md-9 col-sm-9 col-12 mt-1" style="text-align: right;">
                                                <table style="width: 100%;font-size:12px" class="rtable">
                                                    <tr>
                                                        <td style="text-align: right;width:55%;">
                                                            <label class="info_lbl">Total Cost</label>
                                                        </td>
                                                        <td style="text-align: center;width:45%;">
                                                            <label id="infoDSTotalCostT" class="formattedNum info_lbl infoDSTotalCost" style="font-weight: bold;"></label>
                                                        </td>
                                                    </tr>
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
                                        <ul class="dropdown-menu" id="dstockin_action_ul"></ul>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align:right">
                                    <input type="hidden" class="form-control" name="dstockin_type_inp" id="dstockin_type_inp" readonly="true">
                                    <input type="hidden" class="form-control" name="dstockinid" id="dstockinid" readonly="true">
                                    <input type="hidden" class="form-control" name="reqId" id="reqId" readonly="true">
                                    <input type="hidden" class="form-control" name="currentStatus" id="currentStatus" readonly="true">
                                    <input type="hidden" class="form-control" name="forwardReqId" id="forwardReqId" readonly="true">
                                    <input type="hidden" class="form-control" name="newForwardStatusValue" id="newForwardStatusValue" readonly="true">
                                    <input type="hidden" class="form-control" name="forwarkBtnTextValue" id="forwarkBtnTextValue" readonly="true">
                                    <input type="hidden" class="form-control" name="forwardActionValue" id="forwardActionValue" readonly="true">
                                    <button id="closebuttonds" type="button" class="btn btn-danger form_btn" data-dismiss="modal">Close</button>
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
    <div class="modal fade text-left fit-content" id="inlineForm" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style=" overflow-y: scroll;">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title form_title" id="stockinformtitle"></h4>
                    <div class="row">
                        <div style="text-align: right;" class="form_title" id="dstockin_status"></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>   
                </div>
                <form id="Register">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-3 col-lg-5 col-md-12 col-sm-12 col-12 mb-1">
                                <fieldset class="fset">
                                    <legend>General</legend>
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 mb-1">
                                            <label class="form_lbl">Type<b style="color: red; font-size:16px;">*</b></label>
                                            <select class="select2 form-control" name="Type" id="Type">
                                                <option selected disabled value=""></option>
                                                <option value="1">Purchase</option>
                                                <option value="2">Transfer</option>
                                                <option value="3">Others</option>
                                            </select>
                                            <span class="text-danger">
                                                <strong class="errordatalabel" id="Type-error"></strong>
                                            </span>
                                        </div>
                                        
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 mb-1">
                                            <label class="form_lbl">Date<b style="color: red; font-size:16px;">*</b></label>
                                            <input type="text" id="date" name="date" class="form-control reg_form generalcls" placeholder="YYYY-MM-DD" onchange="dateFn()"/>
                                            <span class="text-danger">
                                                <strong id="date-error" class="errordatalabel"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <label class="form_lbl">Remark</label>
                                            <textarea type="text" placeholder="Write Remark here..." class="form-control reg_form generalcls" name="Memo" id="Memo" rows="1"></textarea>
                                            <span class="text-danger">
                                                <strong id="memo-error" class="errordatalabel"></strong>
                                            </span>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-xl-9 col-lg-7 col-md-12 col-sm-12 col-12 mb-1 type_div" style="display: none;" id="purchase_div">
                                <fieldset class="fset">
                                    <legend>Purchase Data</legend>
                                    <div class="row">
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 mb-1">
                                            <label class="form_lbl">Supplier<b style="color: red; font-size:16px;">*</b></label>
                                            <select class="select2 form-control" name="supplier" id="supplier" onchange="supplierFn()">
                                                <option selected disabled value=""></option>
                                                @foreach ($customerSrc as $customerSrc)
                                                    <option value="{{$customerSrc->id}}"> {{$customerSrc->Code}}  ,  {{$customerSrc->Name}}   ,   {{$customerSrc->TinNumber}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">
                                                <strong class="errordatalabel pur_error" id="supplier-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 mb-1">
                                            <label class="form_lbl">Payment Type<b style="color: red; font-size:16px;">*</b></label>
                                            <select class="select2 form-control" name="PaymentType" id="PaymentType" onchange="paymentTypeFn()">
                                                <option selected disabled value=""></option>
                                                <option value="--">--</option>
                                                <option value="Cash">Cash</option>
                                                <option value="Credit">Credit</option>
                                            </select>
                                            <span class="text-danger">
                                                <strong class="errordatalabel pur_error" id="paymentType-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 mb-1">
                                            <label class="form_lbl">Station<b style="color: red; font-size:16px;">*</b></label>
                                            <select class="select2 form-control" name="Station" id="Station" onchange="stationFn()">
                                                <option selected disabled value=""></option>
                                                @foreach ($SourceStoreSrc as $deststation)
                                                    <option value="{{$deststation->StoreId}}">{{$deststation->StoreName}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">
                                                <strong class="errordatalabel pur_error" id="station-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 mb-1">
                                            <label class="form_lbl">Purchased By<b style="color: red; font-size:16px;">*</b></label>
                                            <select class="select2 form-control" name="Purchaser" id="Purchaser" onchange="purchaserFn()">
                                                <option selected disabled value=""></option>
                                                @foreach ($purchaser as $purchaser)
                                                    <option value="{{$purchaser->username}}">{{$purchaser->username}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">
                                                <strong class="errordatalabel pur_error" id="purchaser-error"></strong>
                                            </span>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-xl-9 col-lg-7 col-md-12 col-sm-12 col-12 mb-1 type_div" style="display: none;" id="others_div">
                                <fieldset class="fset">
                                    <legend id="otherfieldset"></legend>
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mb-1">
                                            <label class="form_lbl">Source Station<b style="color: red; font-size:16px;">*</b></label>
                                            <select class="select2 form-control" name="SourceStore" id="SourceStore">
                                                @foreach ($SourceStoreSrc as $srcStation)
                                                    <option value="{{$srcStation->StoreId}}">{{$srcStation->StoreName}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">
                                                <strong class="errordatalabel oth_error" id="sourcestore-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mb-1">
                                            <label class="form_lbl">Destination Station<b style="color: red; font-size:16px;">*</b></label>
                                            <select class="select2 form-control" name="DestinationStore" id="DestinationStore" onchange="destStationFn()">
                                                @foreach ($storeSrc as $strDest)
                                                    <option value="{{$strDest->StoreId}}">{{$strDest->StoreName}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">
                                                <strong class="errordatalabel oth_error" id="destinationstore-error"></strong>
                                            </span>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <hr class="my-30"/>
                        <div class="row" id="dynamicDiv">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="table-responsive pr-0 pl-0" style="width: 100%;overflow-x: auto;-webkit-overflow-scrolling: touch;margin: 0 0rem;padding: 0 1rem;">
                                    <table id="dynamicTable" class="mb-0 rtable form_dynamic_table" style="width:100%;min-width: 950px;">
                                        <thead>
                                            <th class="form_lbl" style="width:3%;">#</th>
                                            <th class="form_lbl" style="width:16%;">Item Name<b style="color: red; font-size:16px;">*</b></th>
                                            <th class="form_lbl" style="width:8%;" title="Unit of Measurement">UOM</th>
                                            <th class="form_lbl purchase_td" style="width:11%;">Selling Price</th>
                                            <th class="form_lbl qtyonhandtds" style="width:11%;" id="qtyonhand" title="Quantity on Hand">Qty. on Hand</th>
                                            <th class="form_lbl" style="width:11%;">Quantity<b style="color: red; font-size:16px;">*</b></th>
                                            <th class="form_lbl purchase_td" style="width:12%;">Unit Cost</th>
                                            <th class="form_lbl purchase_td" style="width:12%;">Total Cost</th>
                                            <th class="form_lbl" style="width:13%;">Remark</th>
                                            <th class="form_lbl" style="width:3%;"></th>
                                        </thead>
                                        <tbody></tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3" style="text-align: left !important;border: none;">
                                                    <button type="button" name="adds" id="adds" class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i> Add New</button>
                                                </td>
                                                <td class="purchase_td" colspan="3" style="padding-right: 3px !important;text-align:right;vertical-align: middle;font-weight: bold;border: none;">Total</td>
                                                <td class="purchase_td" style="vertical-align: middle;padding-top:3px;">
                                                    <label id="subtotalLbl" class="form_lbl pricing_cls" style="padding-left: 15px !important;font-weight: bold;font-size:15px;"></label>
                                                </td>
                                                <td class="purchase_td" colspan="2" style="border: none;"></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="col-xl-9 col-lg-8 col-md-6 col-sm-5 col-12"></div>
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-7 col-12" style="text-align: right;">
                                <table style="width:100%;text-align:right;display:none;">
                                    <tr>
                                        <td style="text-align: right;width:45%">
                                            <label class="form_lbl">Total Cost</label>
                                        </td>
                                        <td style="text-align: center; width:55%">
                                            
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>  
                    </div>
                    <div class="modal-footer">
                        <div style="display:none;">
                            <select class="select2 form-control allitems" name="allitems" id="allitems">
                                <option selected disabled value=""></option>
                                @foreach ($itemSrc as $itemlist)
                                    <option value="{{ $itemlist->id }}">{{ $itemlist->Code }},   {{ $itemlist->Name }},   {{ $itemlist->SKUNumber }}</option>
                                @endforeach 
                            </select>
                            <select class="select2 form-control stockitems" name="stockitems" id="stockitems">
                                <option selected disabled value=""></option> 
                                @foreach ($itemSrcs as $stockitemlist)
                                    <option data-balance="{{ $stockitemlist->Balance }}" data-storeid="{{ $stockitemlist->StoreId }}" value="{{ $stockitemlist->ItemId }}">{{ $stockitemlist->Code }},   {{ $stockitemlist->ItemName }},   {{ $stockitemlist->SKUNumber }}</option>
                                @endforeach 
                            </select>
                            <input type="hidden" class="form-control reg_form" name="operationtypes" id="operationtypes" readonly="true"/>  
                            <input type="hidden" class="form-control reg_form" name="recordId" id="recordId" readonly="true"/> 
                        </div>
                        <button id="savebutton" type="button" class="btn btn-info form_btn">Save</button>
                        <button id="closebuttonk" type="button" class="btn btn-danger form_btn closebutton" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End Registation Modal -->

    <!--Start DStockIN-Void Modal -->
    <div class="modal fade text-left" id="voidDStockInModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="voiddstockinform">
                    @csrf
                    <div class="modal-body">
                        <label class="form_lbl">Reason</label>
                        <textarea type="text" placeholder="Write Reason here..." class="form-control DSReason" rows="3" name="DSReason" id="DSReason" onkeyup="voidDSReasonFn()"></textarea>
                        <span class="text-danger">
                            <strong class="errordatalabel" id="dsvoid-error"></strong>
                        </span>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control" name="voidDStockInid" id="voidDStockInid" readonly="true">
                        <button id="voidDSbtn" type="button" class="btn btn-info">Void</button>
                        <button id="closebuttonvoid" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End DStockIN-Void Modal -->

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
                            <textarea type="text" placeholder="Write Reason here..." class="form-control" rows="3" name="CommentOrReason" id="CommentOrReason" onkeyup="dstockinReasonFn()"></textarea>
                            <span class="text-danger">
                                <strong id="comment-error"></strong>
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
                    status: 'Received',
                    text: 'Receive',
                    action: 'Received',
                    message: 'Are you sure you want to change the status of this record to Received?',
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
            'Received': {
                
            },
        };

        $(document).ready(function() {
            $('.main_datatable').hide(); 
            countDStockInStatusFn(fyears);
            fetchDStockInDataFn(fyears);
        });

        function fetchDStockInDataFn(fy){
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
                dom: "<'row'<'col-sm-3 col-sm-3 col-md-2 col-6'f><'col-sm-3 col-md-2 col-6 mt-1 dsin-custom-1'><'col-sm-3 col-md-1 col-6 mt-1 dsin-custom-2'><'col-sm-3 col-md-1 col-6 mt-1 dsin-custom-3'><'col-sm-4 col-md-2 col-6 mt-1 dsin-custom-4'><'col-sm-4 col-md-2 col-6 mt-1 dsin-custom-5'><'col-sm-4 col-md-2 col-12 mt-1 dsin-custom-6'>>" +
                    "<'row'<'col-sm-12 margin_top_class'tr>>" +
                    "<'row'<'col-sm-4 col-md-4 col-4'l><'col-sm-4 col-md-4 col-4 d-flex justify-content-center'i><'col-sm-4 col-md-4 col-4 d-flex justify-content-end'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/getDStockInData/' + fy,
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
                        width:"12%"
                    },
                    {
                        data: 'rec_type',
                        name: 'rec_type',
                        width:"8%"
                    },
                    {
                        data: 'supplier_name',
                        name: 'supplier_name',
                        width:"17%"
                    },
                    {
                        data: 'PaymentType',
                        name: 'PaymentType',
                        width:"10%"
                    },
                    {
                        data: 'src_store_name',
                        name: 'src_store_name',
                        width:"15%"
                    },
                    {
                        data: 'des_store_name',
                        name: 'des_store_name',
                        width:"15%"
                    },
                    {
                        data: 'TransactionDate',
                        name: 'TransactionDate',
                        width:"8%"
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
                        width:"8%"
                    },
                    { 
                        data: 'action', 
                        name: 'action',
                        "render": function ( data, type, row, meta ) {
                            return `<div class="text-center"><a class="dstockinInfo" href="javascript:void(0)" onclick="dstockinInfoFn(${row.id})" data-id="dstockinInfo${row.id}" id="dstockinInfo${row.id}" title="Open information form"><i class="fa-sharp fa-regular fa-circle-info fa-xl" style="color: #00cfe8;"></i></a></div>`;
                        },
                        width:"4%",
                    },
                    { 
                        data: 'Type', 
                        name: 'Type',
                        "render": function ( data, type, row, meta ) {
                            return "";
                        },
                        'visible': false //11
                    },
                    { 
                        data: 'SourceStore', 
                        name: 'SourceStore',
                        "render": function ( data, type, row, meta ) {
                            return "";
                        },
                        'visible': false //12
                    },
                    { 
                        data: 'StoreId', 
                        name: 'StoreId',
                        "render": function ( data, type, row, meta ) {
                            return "";
                        },
                        'visible': false //13
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
                    $('#dstockin_tbl').show();
                    $('#laravel-datatable-crud').DataTable().columns.adjust();
                },
                fixedHeader: {
                    header: true,
                    headerOffset: $('.header-navbar').outerHeight(),
                },
            });

            appendDStockInFilterFn(fy);
        }

        function appendDStockInFilterFn(fyears){
            var dstockin_fiscalyear = $(`
                <select class="selectpicker form-control dropdownclass" id="fiscalyear" name="fiscalyear[]" title="Select fiscal year here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" data-actions-box="true" data-selected-text-format="count" data-count-selected-text="Fiscal Year ({0})">
                    @foreach ($fiscalyears as $fiscalyears)
                        <option value="{{ $fiscalyears->FiscalYear }}">{{ $fiscalyears->Monthrange }}</option>
                    @endforeach
                </select>`);

            $('.dsin-custom-1').html(dstockin_fiscalyear);
            $('#fiscalyear')
            .selectpicker()
            .selectpicker('val', fyears)
            .off('changed.bs.select') 
            .on('changed.bs.select', function () {
                let fyear = $(this).val();
                countDStockInStatusFn(fyear);
                fetchDStockInDataFn(fyear); 
            });

            var dsin_type_filters = $(`
                <select class="selectpicker form-control dropdownclass" id="dsin_type_filter" name="dsin_type_filter[]" title="Select type here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" data-actions-box="true" multiple data-selected-text-format="count" data-count-selected-text="Type ({0})">
                    <option selected value="1">Purchase</option>
                    <option selected value="2">Transfer</option>
                    <option selected value="3">Others</option>
                </select>`);

            $('.dsin-custom-2').html(dsin_type_filters);
            $('#dsin_type_filter')
            .selectpicker()
            .off('changed.bs.select') 
            .on('changed.bs.select', function () {  
                var selected = $('#dsin_type_filter option:selected');
                var search = [];

                // Collect selected option values
                $.each(selected, function() {
                    search.push($(this).val());
                });

                if (search.length === 0) {
                    // No option selected: force DataTable to return no data
                    table.column(11).search('^$', true, false).draw();
                } else {
                    var searchRegex = '^(' + search.join('|') + ')$'; // More precise regex pattern
                    table.column(11).search(searchRegex, true, false).draw();
                }
            });

            var dsin_payment_type_filters = $(`
                <select class="selectpicker form-control dropdownclass" id="dsin_payment_type_filter" name="dsin_payment_type_filter[]" title="Select payment type here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" data-actions-box="true" multiple data-selected-text-format="count" data-count-selected-text="Payment Type ({0})">
                    <option selected value="--">--</option>
                    <option selected value="Cash">Cash</option>
                    <option selected value="Credit">Credit</option>
                </select>`);

            $('.dsin-custom-3').html(dsin_payment_type_filters);
            $('#dsin_payment_type_filter')
            .selectpicker()
            .off('changed.bs.select') 
            .on('changed.bs.select', function () {  
                var selected = $('#dsin_payment_type_filter option:selected');
                var search = [];

                // Collect selected option values
                $.each(selected, function() {
                    search.push($(this).val());
                });

                if (search.length === 0) {
                    // No option selected: force DataTable to return no data
                    table.column(5).search('^$', true, false).draw();
                } else {
                    var searchRegex = '^(' + search.join('|') + ')$'; // More precise regex pattern
                    table.column(5).search(searchRegex, true, false).draw();
                }
            });

            var dsin_src_filters = $(`
                <select class="selectpicker form-control dropdownclass" id="dsin_src_filter" name="dsin_src_filter[]" title="Select source station here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" data-actions-box="true" multiple data-selected-text-format="count" data-count-selected-text="Source Station ({0})">
                    <option selected value="1">--</option>
                    @foreach ($SourceStoreSrc as $filter_station)
                        <option selected value="{{$filter_station->StoreId}}">{{$filter_station->StoreName}}</option>
                    @endforeach
                </select>`);

            $('.dsin-custom-4').html(dsin_src_filters);
            $('#dsin_src_filter')
            .selectpicker()
            .off('changed.bs.select') 
            .on('changed.bs.select', function () {  
                var selected = $('#dsin_src_filter option:selected');
                var search = [];

                // Collect selected option values
                $.each(selected, function() {
                    search.push($(this).val());
                });

                if (search.length === 0) {
                    // No option selected: force DataTable to return no data
                    table.column(12).search('^$', true, false).draw(); // Match an impossible pattern
                } else {
                    // Options selected: build regex for filtering
                    var searchRegex = search.join('|'); // OR-separated values for regex
                    table.column(12).search(searchRegex, true, false).draw();
                }
            });

            var dsin_dest_filters = $(`
                <select class="selectpicker form-control dropdownclass" id="dsin_dest_filter" name="dsin_dest_filter[]" title="Select destination station here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" data-actions-box="true" multiple data-selected-text-format="count" data-count-selected-text="Destination Station ({0})">
                    @foreach(collect($SourceStoreSrc)->merge($storeSrc)->unique('StoreId')->values() as $station)
                        <option selected value="{{$station->StoreId}}">{{$station->StoreName}}</option>
                    @endforeach
                </select>`);

            $('.dsin-custom-5').html(dsin_dest_filters);
            $('#dsin_dest_filter')
            .selectpicker()
            .off('changed.bs.select') 
            .on('changed.bs.select', function () {  
                var selected = $('#dsin_dest_filter option:selected');
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
                <select class="selectpicker form-control dropdownclass" id="dsin_status_filter" name="dsin_status_filter[]" title="Select status here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" data-actions-box="true" multiple data-selected-text-format="count" data-count-selected-text="Status ({0})">
                    <option selected value="Draft">Draft</option>
                    <option selected value="Pending">Pending</option>
                    <option selected value="Verified">Verified</option>
                    <option selected value="Received">Received</option>
                    <option selected value="Void">Void</option>
                </select>`);

            $('.dsin-custom-6').html(status_filter);
            $('#dsin_status_filter')
            .selectpicker()
            .off('changed.bs.select') 
            .on('changed.bs.select', function () {  
                var selected = $('#dsin_status_filter option:selected');
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
        }

        function countDStockInStatusFn(fiscalyear){
            var fyear = 0;
            var disp_void_cnt = 0;
            
            $.ajax({
                url: '/countDStockInStatus',
                type: 'POST',
                data:{
                    fyear: fiscalyear,
                },
                dataType: 'json',
                success: function(data) {
                    $(".dstockin_status_record_lbl").html("0");
                    $.each(data.dstockin_status_count, function(key, value) {
                        if(value.Status == "Draft"){
                            $("#dstockin_draft_record_lbl").html(value.status_count);
                        }
                        else if(value.Status == "Pending"){
                            $("#dstockin_pending_record_lbl").html(value.status_count);
                        }
                        else if(value.Status == "Verified"){
                            $("#dstockin_verified_record_lbl").html(value.status_count);
                        }
                        else if(value.Status == "Received"){
                            $("#dstockin_received_record_lbl").html(value.status_count);
                        }
                        else if(value.Status == "Total"){
                            $("#dstockin_total_record_lbl").html(value.status_count);
                        }
                        else {
                            disp_void_cnt += parseInt(value.status_count);
                            $("#dstockin_void_record_lbl").html(disp_void_cnt);
                        }
                    });
                }
            });
        }

        function setFocus(targetTable) {
            $($(targetTable + ' tbody > tr')[globalIndex]).addClass('selected');
        }

        $('#laravel-datatable-crud tbody').on('click', 'tr', function () {
            $('#laravel-datatable-crud tbody > tr').removeClass('selected');
            $(this).addClass('selected');
            globalIndex = $(this).index();
        });

        $("#addstockin").click(function() { 
            resetStockInFormFn();
            $("#stockinformtitle").html('Add Stock-IN');
            $("#inlineForm").modal('show');
        });

        $('#savebutton').click(function() {
            var optype = $('#operationtypes').val();
            var registerForm = $("#Register");
            var formData = registerForm.serialize();
            $.ajax({
                url: '/saveDStockIn',
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
                    if (data.errors){
                        if (data.errors.Type) {
                            $('#Type-error').html(data.errors.Type[0]);
                        }
                        if (data.errors.date) {
                            $('#date-error').html(data.errors.date[0]);
                        }
                        if (data.errors.supplier) {
                            var text = data.errors.supplier[0];
                            text = text.replace("1", "purchase");
                            $('#supplier-error').html(text);
                        }
                        if (data.errors.PaymentType) {
                            var text = data.errors.PaymentType[0];
                            text = text.replace("1", "purchase");
                            $('#paymentType-error').html(text);
                        }
                        if (data.errors.Station) {
                            var text = data.errors.Station[0];
                            text = text.replace("1", "purchase");
                            $('#station-error').html(text);
                        }
                        if (data.errors.Purchaser) {
                            var text = data.errors.Purchaser[0];
                            text = text.replace("1", "purchase");
                            $('#purchaser-error').html(text);
                        }
                        if (data.errors.SourceStore) {
                            var text = data.errors.SourceStore[0];
                            text = text.replace("2", "transfer");
                            text = text.replace("3", "others");
                            text = text.replace("store", "station");
                            $('#sourcestore-error').html(text);
                        }
                        if (data.errors.DestinationStore) {
                            var text = data.errors.DestinationStore[0];
                            text = text.replace("2", "transfer");
                            text = text.replace("3", "others");
                            text = text.replace("store", "station");
                            $('#destinationstore-error').html(text);
                        }

                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                        toastrMessage('error',"Check your inputs","Error");
                    }

                    else if (data.errorv2){
                        var error_html = '';
                        var selecteditemsvar = '';
                        $('#dynamicTable > tbody > tr').each(function (index) {
                            let k = $(this).find('.idval').val();
                            var itmid = ($(`#itemNameSl${k}`)).val();
                            if(($(`#quantity${k}`).val()) != undefined){
                                var qnt = $(`#quantity${k}`).val();
                                if(isNaN(parseFloat(qnt)) || parseFloat(qnt) == 0){
                                    $(`#quantity${k}`).css("background", errorcolor);
                                }
                            }
                            if(isNaN(parseFloat(itmid)) || parseFloat(itmid) == 0){
                                $(`#select2-itemNameSl${k}-container`).parent().css('background-color',errorcolor);
                            }
                        });

                        if(parseInt(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseInt(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                        toastrMessage('error',"Please insert valid data on highlighted fields!</br>","Error");
                    }

                    else if (data.balance_error) {
                        var item_list = "";
                        $.each(data.items, function(index, value) {
                            item_list += `<b>${++index},</b> ${value.name}</br>`;
                        });
                        if(parseInt(optype) == 1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseInt(optype) == 2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                        toastrMessage('error',`These items cannot be updated, the requested change is not supported by the available quantity and would result negative balance.</br>-------------------</br>${item_list}`,"Error");
                    } 

                    else if (data.dberrors){
                        if(parseInt(optype) == 1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseInt(optype) == 2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                        toastrMessage('error',"Please contact administrator","Error");
                    }

                    else if(data.emptyerror){
                        if(parseInt(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseInt(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                        toastrMessage('error',"Please add atleast one item","Error");
                    }

                    else if (data.success){
                        toastrMessage('success',"Successful","Success");
                        if(parseInt(optype) == 2){
                            createDStockInInfo(data.rec_id);
                        }
                        countDStockInStatusFn(data.fiscalyr);
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                        $("#inlineForm").modal('hide');
                    }
                }
            });

        });

        function dstockinInfoFn(recordId){
            createDStockInInfo(recordId);
            $("#dstockinInfoModal").modal('show');
        }

        function createDStockInInfo(recordId){
            $('.allinfo').hide();
            $('.dispbtnprop').hide();
            $('.infoRecDiv').hide();
            $('#item_tbl_footer').hide();
            $('.infofooter').html("");
            $('#dstockinid').val(recordId);
            var recId = "";
            var lidata = "";
            var status_color = "";
            var action_links = "";
            var withold_btn_link = "";
            var major_btn_link = `<li><hr class="dropdown-divider"></li>`;
            var status_btn_link = `<li><hr class="dropdown-divider"></li>`;
            var flag_btn_link = `<li><hr class="dropdown-divider"></li>`;
            var edit_link = `
                @can("Direct-StockIN-Edit")
                    <li>
                        <a class="dropdown-item editDStockIn" href="javascript:void(0)" onclick="editDStockInFn(${recordId})" data-id="editDSLink${recordId}" id="editDSLink${recordId}" title="Edit record">
                        <span><i class="fa-solid fa-pencil"></i> Edit</span>  
                        </a>
                    </li>
                @endcan`;

            var void_link = `
                @can("Direct-StockIN-Void")
                    <li>
                        <a class="dropdown-item voidDS" href="javascript:void(0)" onclick="voidDStockInFn(${recordId})" data-id="voidDS${recordId}" id="voidDS${recordId}" title="Void record">
                        <span><i class="fa-solid fa-ban"></i> Void</span>  
                        </a>
                    </li>
                @endcan`;

            var undovoid_link = `
                @can("Direct-StockIN-Void")
                <li>
                    <a class="dropdown-item undoVoidDS" href="javascript:void(0)" onclick="undoVoidDSFn(${recordId})" data-id="undoVoidDS${recordId}" id="undoVoidDS${recordId}" title="Undo void record">
                    <span><i class="fa fa-undo"></i> Undo Void</span>  
                    </a>
                </li>
                @endcan`;

            var change_to_pending_link = `
                @can("Direct-StockIN-ChangeToPending")
                <li>
                    <a class="dropdown-item changetopending" onclick="forwardDStockInFn()" id="changetopending" title="Change record to pending">
                    <span><i class="fa-solid fa-forward"></i> Change to Pending</span>  
                    </a>
                </li>
                @endcan`;

            var back_to_draft_link = `
                @can("Direct-StockIN-ChangeToPending")
                <li>
                    <a class="dropdown-item dstockinbackward" id="backtodraft" title="Change record to draft">
                    <span><i class="fa-solid fa-backward"></i> Back to Draft</span>  
                    </a>
                </li>
                @endcan`;

            var verify_link = `
                @can("Direct-StockIN-Verify")
                <li>
                    <a class="dropdown-item verifyrecord" onclick="forwardDStockInFn()" id="verifyrecord" title="Change record to verified">
                    <span><i class="fa-solid fa-forward"></i> Verify</span>  
                    </a>
                </li>
                @endcan`;

            var back_to_pending = `
                @can("Direct-StockIN-Verify")
                <li>
                    <a class="dropdown-item dstockinbackward" id="backtopending" title="Change record to pending">
                    <span><i class="fa-solid fa-backward"></i> Back to Pending</span>  
                    </a>
                </li>
                @endcan`;


            var received_link = `
                @can("Direct-StockIN-Receive")
                <li>
                    <a class="dropdown-item receiverecord" onclick="forwardDStockInFn()" id="receiverecord" title="Change record to received">
                    <span><i class="fa-solid fa-forward"></i> Receive</span>  
                    </a>
                </li>
                @endcan`;

            var print_btn_link = `
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item printdstockin" href="javascript:void(0)" data-link="/dshi/${recordId}" data-id="printdstockin${recordId}" id="printdstockin${recordId}" title="Print Direct Stock-IN Voucher">
                    <span><i class="fa fa-file"></i> Print Stock-IN Voucher</span>  
                    </a>
                </li>`;


            $.ajax({
                url: '/fetchDStockInData',
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
                    fetchDStockInItemListFn(recordId);
                },
                success: function(data) {
                    $.each(data.dstockindata,function(key,value) { 
                        $('#infoDSTypeLbl').html(value.rec_type);
                        $('#infoDSDate').html(value.TransactionDate);
                        $('#infoDSRemark').html(value.Memo);

                        $('#infoSupplierNameLbl').html(value.supplier_name);
                        $('#infoPaymentTypeLbl').html(value.PaymentType);
                        $('#infoStationLbl').html(value.des_store_name);
                        $('#infoPurchaseByLbl').html(value.PurchaserName);

                        $('#infoSourceStationLbl').html(value.src_store_name);
                        $('#infoDestinationStationLbl').html(value.des_store_name);

                       
                        $('#dstockin_type_inp').val(value.Type);
                        $('#currentStatus').val(value.Status);

                        if(parseInt(value.Type) == 1){
                            $('.purchaseinfo').show();
                        }
                        if(parseInt(value.Type) == 2){
                            $('#othersinfo_title').html(`<i class="fas fa-exchange-alt"></i> Transfer Information`);
                            $('.othersinfo').show();
                        }
                        if(parseInt(value.Type) == 3){
                            $('#othersinfo_title').html(`<i class="fas fa-list"></i> Others Information`);
                            $('.othersinfo').show();
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

                            status_btn_link += received_link;
                            status_btn_link += back_to_pending;
                            
                            status_color = "#7367F0";
                        }
                        
                        else if(value.Status == "Received"){
                            major_btn_link += edit_link;
                            major_btn_link += void_link;
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

                        $(".info_modal_title_lbl").html(`<span class="form_title" style='color:${status_color};font-weight:bold;text-shadow;1px 1px 10px ${status_color};font-size:16px;'>${value.DocumentNumber},     ${value.Status}</span>`);

                        action_links = `
                        <li>
                            <a class="dropdown-item viewDSAction" onclick="viewDSActionFn(${recordId})" data-id="view_ds_actionbtn${recordId}" id="view_ds_actionbtn${recordId}" title="View user log">
                                <span><i class="fa-solid fa-eye"></i> View User Log</span>  
                            </a>
                        </li>
                        ${major_btn_link}
                        ${status_btn_link}
                        ${print_btn_link}`;

                        $("#dstockin_action_ul").empty().append(action_links);
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

                    $("#universal-action-log-canvas").empty().append(lidata);
                }
            });

            $(".infoscl").collapse('show');
        }

        function fetchDStockInItemListFn(recordId){
            var ds_type = $('#dstockin_type_inp').val();
            $('#dstockinInfodatatbl').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                paging: false,
                searching: true,
                info: false,
                searchHighlight: true,
                autoWidth: false,
                "order": [
                    [0, "asc"]
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
                    url: '/getDStockInDetailData/' + recordId,
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
                        width:"21%"
                    },
                    {
                        data: 'SKUNumber',
                        name: 'SKUNumber',
                        width:"10%"
                    },
                    {
                        data: 'UOM',
                        name: 'UOM',
                        width:"8%"
                    },
                    {
                        data: 'Quantity',
                        name: 'Quantity',
                        render: $.fn.dataTable.render.number(',', '.',2, ''),
                        width:"8%"
                    },
                    {
                        data: 'UnitCost',
                        name: 'UnitCost',
                        render: $.fn.dataTable.render.number(',', '.',2, ''),
                        width:"10%"
                    },
                    {
                        data: 'BeforeTaxCost',
                        name: 'BeforeTaxCost',
                        render: $.fn.dataTable.render.number(',', '.',2, ''),
                        width:"10%"
                    },
                    {
                        data: 'Memo',
                        name: 'Memo',
                        width:"20%"
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
                "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull){
                    var api = this.api();
                    if(ds_type == 1){
                        api.column(6).visible(true);
                        api.column(7).visible(true);
                        $("#item_tbl_footer").show();
                    }
                    else{
                        api.column(6).visible(false);
                        api.column(7).visible(false);
                        $("#item_tbl_footer").hide();
                    }
                },
                "footerCallback": function (row,data,start,end,display) {
                    var api = this.api(),data;
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };
                    var total = api
                        .column(7)
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                        $('.infoDSTotalCost').html(`${total === 0 ? '' : numformat(parseFloat(total).toFixed(2))}`);
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
                    $('.infoRecDiv').show();
                },
            });
        }

        function viewDSActionFn(recordId){
            $("#action-log-title").html("User Log Information");
            $("#action-log-universal-modal").modal('show');
        }

        function editDStockInFn(recordId){
            var recId = "";
            var status_color = "";
            resetStockInFormFn();
            $('#recordId').val(recordId);
            $('.mainprop').hide();
            $('.type_div').hide();
            $("#dynamicTable > tbody").empty();
            var options = null;
            j=0;
            $.ajax({
                url: '/fetchDStockInData',
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
                    $.each(data.dstockindata,function(key,value) { 
                        $('#Type').val(value.Type).select2({minimumResultsForSearch:-1});
                        flatpickr('#date', { dateFormat: 'Y-m-d',clickOpens:true,maxDate:current_date});   
                        $('#date').val(value.TransactionDate);               

                        $('#supplier').val(value.CustomerId).select2();
                        $('#PaymentType').val(value.PaymentType).select2({minimumResultsForSearch:-1});
                        $('#Station').val(value.StoreId).select2();
                        $('#Purchaser').val(value.PurchaserName).select2();
                        
                        $('#SourceStore').val(value.SourceStore).select2();
                        $('#DestinationStore').val(value.StoreId).select2();

                        $('#Memo').val(value.Memo);
                        
                        if(value.Type == 1){
                            $('.qtyonhandtds').hide();
                            $('#purchase_div').show();
                            $('.purchase_td').show();
                        }
                        else{
                            $('#otherfieldset').html(value.Type == 2 ? "Transfer Data" : "Others Data");
                            $('#others_div').show();
                            $('.purchase_td').hide();
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
                        else if(value.Status == "Received"){
                            status_color = "#1cc88a";
                        }
                        else{
                            status_color = "#e74a3b";
                        }
                        $("#dstockin_status").html(`<span class="form_title" style='color:${status_color};font-weight:bold;text-shadow;1px 1px 10px ${status_color};font-size:16px;'>${value.DocumentNumber},     ${value.Status}</span>`);
                    });

                    $.each(data.detaildata,function(key,value) { 
                        ++i;
                        ++m;
                        ++j;
                       
                        $("#dynamicTable > tbody").append(`<tr>
                            <td style="font-weight:bold;width:3%;text-align:center;">${j}</td>
                            <td style="display:none;"><input type="hidden" name="row[${m}][idvals]" id="idval${m}" class="idval form-control" readonly="true" style="font-weight:bold;" value="${m}"/></td>
                            <td style="width:16%;"><select id="itemNameSl${m}" onchange="itemFn(this)" class="select2 form-control itemName" name="row[${m}][ItemId]"></select></td>
                            <td style="width:8%;"><input type="text" name="row[${m}][UOM]" placeholder="UOM" id="uom${m}" class="uom form-control" readonly="true"/></td>
                            <td style="width:11%;" class="purchase_td"><input type="number" name="row[${m}][SellingPrice]" placeholder="Selling price" id="SellingPrice${m}" class="SellingPrice form-control" readonly="true" onkeypress="return ValidateNum(event);" @can('StockBalance-EditPrice') ondblclick="sellingPricePer(this)"; @endcan/></td>
                            <td style="width:11%;" id="qtyonhandtd${m}" class="qtyonhandtds"><input type="text" name="row[${m}][AvQuantity]" placeholder="Quantity on hand" id="AvQuantity${m}" class="AvQuantity form-control" readonly="true"/></td>
                            <td style="width:11%;"><input type="number" name="row[${m}][Quantity]" onkeyup="CalculateTotal(this)" placeholder="Quantity" id="quantity${m}" class="quantity form-control numeral-mask" value="${value.Quantity}"/></td>
                            <td style="width:12%;" class="purchase_td"><input type="number" name="row[${m}][UnitCost]" onkeyup="CalculateTotal(this)" placeholder="Unit cost" id="unitcost${m}" value="${value.UnitCost}" class="unitcost form-control numeral-mask"/></td>
                            <td style="width:12%;" class="purchase_td"><input type="number" name="row[${m}][BeforeTaxCost]" placeholder="Total cost" id="beforetax${m}" value="${value.BeforeTaxCost}" class="beforetax form-control numeral-mask" readonly/></td>
                            <td style="width:13%;"><input type="text" name="row[${m}][Memo]" id="Memo${m}" class="Memo form-control" value="${value.Memo != null ? value.Memo : ""}" placeholder="Write remark here..."/></td>
                            <td style="width:3%;text-align:center;"><button type="button" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button><input type="hidden" name="row[${m}][Common]" id="common${m}" class="common form-control" readonly="true" style="font-weight:bold;"/><input type="hidden" name="row[${m}][StoreId]" id="storeid${m}" class="storeid form-control" readonly="true" style="font-weight:bold;"/></td>
                        </tr>`);

                        var default_item = `<option selected value='${value.ItemId}'>${value.ItemCode}, ${value.ItemName}, ${value.SKUNumber}</option>`;

                        if(value.Type == 1 || value.Type == 3){
                            options = $("#allitems > option").clone();
                            $(`#itemNameSl${m}`).append(options);
                            $('.qtyonhandtds').hide();

                            value.Type == 1 ? $('.purchase_td').show() : $('.purchase_td').hide();
                        }
                        else if(value.Type == 2){
                            options = $("#stockitems");
                            $(`#itemNameSl${m}`).append(options.find(`option[data-storeid="${value.recdetstoreid}"]`).clone()); 
                            $(`#itemNameSl${m} option[data-balance = 0]`).remove();
                            $('.qtyonhandtds').show();
                            $('.purchase_td').hide();
                        }

                        $('#dynamicTable > tbody  > tr').each(function(index, tr) {
                            let item_id = $(this).find('.itemName').val();
                            $(`#itemNameSl${m} option[value="${value.ItemId}"]`).remove(); 
                        });

                        $(`#itemNameSl${m}`).append(default_item).select2();
                        
                        itemFn(m);
                        $(`#select2-itemNameSl${m}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
                    });

                    renumberRows();
                    CalculateGrandTotal();
                },
            });

            $("#stockinformtitle").html('Edit Stock-IN');
            $('#operationtypes').val(2);
            $('#savebutton').text('Update');
            $('#savebutton').prop("disabled",false);
            $("#inlineForm").modal('show');
        }

        $(document).on('show.bs.collapse hide.bs.collapse', '.collapse', function (e) {
            e.stopPropagation();
            const collapse = $(this);
            const container = collapse.closest('.card, .modal-content, .row');
            const infoTarget = container.find('.dstockin_header_info');
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
                const type = container.find('#infoDSTypeLbl').text().trim();
                var d_type = $('#dstockin_type_inp').val();
                const src_station = container.find('#infoSourceStationLbl').text().trim();
                const dest_station = container.find('#infoDestinationStationLbl').text().trim();
                const summaryOthersHtml = `
                    Type: <b>${type}</b>,
                    Source Station: <b>${src_station}</b>,
                    Destination Station: <b>${dest_station}</b>`;

                const supplier = container.find('#infoSupplierNameLbl').text().trim();
                const station = container.find('#infoStationLbl').text().trim();
                const payment_type = container.find('#infoPaymentTypeLbl').text().trim();
                const summaryPurchaseHtml = `
                    Type: <b>${type}</b>,
                    Supplier: <b>${supplier}</b>,
                    Payment Type: <b>${payment_type}</b>,
                    Station: <b>${station}</b>`;

                infoTarget.html(d_type == 1 ? summaryPurchaseHtml : summaryOthersHtml);
            }
        });

        $("#adds").click(function() {
            var it = 0;
            var type = $('#Type').val();
            var storeidvar = $('#SourceStore').val();
            var last_row = $('#dynamicTable > tbody > tr:last').find('td').eq(1).find('input').val();
            var itemids = $(`#itemNameSl${last_row}`).val();
            var default_opt = '<option selected disabled value=""></option>';
            var options = null;
            if((isNaN(parseFloat(storeidvar)) || storeidvar == null) && type == 2){
                toastrMessage('error',"Please select source station first","Error");
                $('#sourcestore-error').html("The source station field is required.");
            }
            else if(itemids !== undefined && itemids === null){
                $(`#select2-itemNameSl${last_row}-container`).parent().css('background-color',errorcolor);
                toastrMessage('error',"Please select item from highlighted field","Error");
            }
            else{
                ++i;
                j += 1;
                ++m;
                $("#dynamicTable > tbody").append(`<tr>
                    <td style="font-weight:bold;width:3%;text-align:center;">${j}</td>
                    <td style="display:none;"><input type="hidden" name="row[${m}][idvals]" id="idval${m}" class="idval form-control" readonly="true" style="font-weight:bold;" value="${m}"/></td>
                    <td style="width:16%;"><select id="itemNameSl${m}" onchange="itemFn(${m})" class="select2 form-control itemName" name="row[${m}][ItemId]"></select></td>
                    <td style="width:8%;"><input type="text" name="row[${m}][UOM]" placeholder="UOM" id="uom${m}" class="uom form-control" readonly="true"/></td>
                    <td style="width:11%;" class="purchase_td"><input type="number" name="row[${m}][SellingPrice]" placeholder="Selling price" id="SellingPrice${m}" class="SellingPrice form-control" readonly="true" onkeypress="return ValidateNum(event);" @can('StockBalance-EditPrice') ondblclick="sellingPricePer(this)"; @endcan/></td>
                    <td style="width:11%;" id="qtyonhandtd${m}" class="qtyonhandtds"><input type="text" name="row[${m}][AvQuantity]" placeholder="Quantity on hand" id="AvQuantity${m}" class="AvQuantity form-control" readonly="true"/></td>
                    <td style="width:11%;"><input type="number" name="row[${m}][Quantity]" onkeyup="CalculateTotal(this)" placeholder="Quantity" id="quantity${m}" class="quantity form-control numeral-mask"/></td>
                    <td style="width:12%;" class="purchase_td"><input type="number" name="row[${m}][UnitCost]" onkeyup="CalculateTotal(this)" placeholder="Unit cost" id="unitcost${m}" class="unitcost form-control numeral-mask"/></td>
                    <td style="width:12%;" class="purchase_td"><input type="number" name="row[${m}][BeforeTaxCost]" placeholder="Total cost" id="beforetax${m}" class="beforetax form-control numeral-mask" readonly/></td>
                    <td style="width:13%;"><input type="text" name="row[${m}][Memo]" id="Memo${m}" class="Memo form-control" placeholder="Write remark here..."/></td>
                    <td style="width:3%;text-align:center;"><button type="button" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button><input type="hidden" name="row[${m}][Common]" id="common${m}" class="common form-control" readonly="true" style="font-weight:bold;"/><input type="hidden" name="row[${m}][StoreId]" id="storeid${m}" class="storeid form-control" readonly="true" style="font-weight:bold;"/></td>
                </tr>`);

                $(`#itemNameSl${m}`).append(default_opt);
                if(type == 1 || type == 3){
                    options = $("#allitems > option").clone();
                    $(`#itemNameSl${m}`).append(options);
                    $('.qtyonhandtds').hide();

                    type == 1 ? $('.purchase_td').show() : $('.purchase_td').hide();
                }
                else if(type == 2){
                    options = $("#stockitems");
                    $(`#itemNameSl${m}`).append(options.find(`option[data-storeid="${storeidvar}"]`).clone()); 
                    $(`#itemNameSl${m} option[data-balance = 0]`).remove();
                    $('.qtyonhandtds').show();
                    $('.purchase_td').hide();
                }

                $('#dynamicTable > tbody > tr').each(function(index, tr) {
                    let item_id = $(this).find('.itemName').val();
                    $(`#itemNameSl${m} option[value="${item_id}"]`).remove(); 
                });

                $(`#itemNameSl${m}`).append(default_opt);
                $(`#itemNameSl${m}`).select2({placeholder: "Select item here..."});
                $(`#select2-itemNameSl${m}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                renumberRows();
            }
        });

        function itemFn(row_id){
            var type = $('#Type').val();
            var item_id = $(`#itemNameSl${row_id}`).val(); 
            
            $.ajax({
                type: "get",
                url: "{{url('showdsItemInfo')}}"+'/'+item_id,
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
                    $.each(data.item_data, function(key, value) {
                        $(`#uom${row_id}`).val(value.UOM);
                        $(`#SellingPrice${row_id}`).val(value.dsmaxcosteditable);
                        //$(`#unitcost${row_id}`).val(value.DeadStockPrice);
                    });
                    $(`#select2-itemNameSl${row_id}-container`).parent().css('background-color',"white");
                }
            });

            if(type == 2){
                calcDSRemBalanceFn(row_id);
            }
        }  

        function calcDSRemBalanceFn(rowid){
            var baseRecordId = null;
            var storeval = null;
            var itemid = null;
            var net_balance = null;
            var qty = null;
            $.ajax({
                url: '/calcDSRemBalance', 
                type: 'POST',
                data:{
                    baseRecordId:$('#recordId').val() || 0,
                    storeval:$('#SourceStore').val(),
                    itemid:$(`#itemNameSl${rowid}`).val(),
                },
                success: function(data) {
                    net_balance = parseFloat(data.available_qty);
                    qty = $(`#quantity${rowid}`).val();
                    $(`#AvQuantity${rowid}`).val(net_balance);

                    if(parseFloat(qty) > parseFloat(net_balance)){
                        $(`#quantity${rowid}`).val("");
                    }
                }
            });
        }

        $(document).on('click', '.remove-tr', function() {
            $(this).parents('tr').remove();
            renumberRows();
            CalculateGrandTotal();
            --i;
        });

        function renumberRows() {
            var ind;
            $('#dynamicTable > tbody > tr').each(function(index, el) {
                $(this).children('td').first().text(++index);
            });
        }

        function CalculateTotal(ele){
            var typ = $('#Type').val();
            var cid = $(ele).closest('tr').find('.idval').val();
            var quantity = $(ele).closest('tr').find('.quantity').val();
            var inputid = ele.getAttribute('id');
            quantity = quantity == '' ? 0 : quantity;
            if(typ == 2){
                var availableq = $(ele).closest('tr').find('.AvQuantity').val();
                availableq = availableq == '' ? 0 : availableq;
                
                if(parseFloat(quantity) > parseFloat(availableq)){     
                    toastrMessage('error',"There is no available quantity","Error");
                    $(ele).closest('tr').find('.quantity').val("");
                    $(ele).closest('tr').find('.quantity').css("background",errorcolor);
                }
                else{
                    $(ele).closest('tr').find('.quantity').css("background","white");
                }
            }
            
            var unitcost = $(ele).closest('tr').find('.unitcost').val();
            var selling_price = $(ele).closest('tr').find('.SellingPrice').val();
            var wholeseller = $(ele).closest('tr').find('.Wholeseller').val();
            if(parseFloat(unitcost) == 0){
                $(ele).closest('tr').find('.unitcost').val(''); 
            }
            if(parseFloat(quantity) == 0){
                $(ele).closest('tr').find('.quantity').val(''); 
            }
            unitcost = unitcost == '' ? 0 : unitcost;
            
            selling_price = selling_price == '' ? 0 : selling_price;
            

            if(inputid === "unitcost"+cid){
                if(parseFloat(selling_price) > 0){
                    if(parseFloat(selling_price) < parseFloat(unitcost)){
                        $(ele).closest('tr').find('.unitcost').val("");
                        toastrMessage('error',"Unit cost is greater than selling price","Error");
                    }
                }
                $(ele).closest('tr').find('.unitcost').css("background","white");
            }
        
            if(inputid === "quantity"+cid){
                $(ele).closest('tr').find('.quantity').css("background","white");
            }
        
            if (!isNaN(unitcost) && !isNaN(quantity)){
                var total = parseFloat(unitcost) * parseFloat(quantity);
                $(ele).closest('tr').find('.beforetax').val(total.toFixed(2));
                if(parseFloat(total) > 0){
                    $(ele).closest('tr').find('.beforetax').css("background","#efefef");
                }
            }
            CalculateGrandTotal();
        }
    
        function CalculateGrandTotal(){
            var subtotal = 0;
            $.each($('#dynamicTable').find('.beforetax'), function () {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    subtotal += parseFloat($(this).val());
                }
            });
            $('#subtotali').val(subtotal.toFixed(2));
            $('#subtotalLbl').html(numformat(subtotal.toFixed(2)));
        }

        function resetStockInFormFn(){
            $('#Type').val(null).select2
            ({
                placeholder: "Select type here",
                
                minimumResultsForSearch: -1
            });

            resetPurchaseFn();
            resetOthersFn();

            $('.reg_form').val("");
            $('.errordatalabel').html("");
            $('.pricing_cls').html("");
            $("#statusdisplay").html("");
            $('#dstockin_status').html("");
            $('.type_div').hide();
            flatpickr('#date',{dateFormat: 'Y-m-d',clickOpens:true,maxDate:current_date});
            $('#savebutton').text('Save');
            $('#savebutton').prop("disabled", false);
            $('#operationtypes').val(1);
            $('#dynamicTable > tbody').empty();
        }
        
        function resetPurchaseFn(){
            $('#supplier').val(null).select2
            ({
                placeholder: "Select supplier here",
                
            });

            $('#PaymentType').val(null).select2
            ({
                placeholder: "Select payment type here",
                
                minimumResultsForSearch: -1
            });

            $('#Station').val(null).select2
            ({
                placeholder: "Select station here",
            });

            $('#Purchaser').val(null).select2
            ({
                placeholder: "Select purchaser here",
                
            });
        }

        function resetOthersFn(){
            $('#SourceStore').val(null).select2
            ({
                placeholder: "Select source station here",
                
            });

            $('#DestinationStore').val(null).select2
            ({
                placeholder: "Select destination station here",
                
            });
        }

        $('#Type').change(function() {
            var type = $(this).val();
            $('.type_div').hide();
            $('.AvQuantity').val("");
            if(type == 1){
                resetPurchaseFn();
                $('.pur_error').html("");
                $('.qtyonhandtds').hide();
                $('#purchase_div').show();
                $('.purchase_td').show();
            }
            else{
                resetOthersFn();
                $('#otherfieldset').html(type == 2 ? "Transfer Data" : "Others Data");
                $('.oth_error').html("");
                if(type == 2){
                    $('.qtyonhandtds').show();
                }
                else if(type == 3){
                    $('.qtyonhandtds').hide();
                }
                $('#others_div').show();
                $('.purchase_td').hide();
            }
            $('#Type-error').html("");
        });

        function voidDStockInFn(recordId){
            $('#DSReason').val("");
            $('#dsvoid-error').html("");
            $('#voidDStockInid').val(recordId);
            $('#voidDSbtn').text('Void');
            $('#voidDSbtn').prop("disabled", false);
            $("#voidDStockInModal").modal('show');
        }

        $("#voidDSbtn").click(function() {
            var registerForm = $("#voiddstockinform");
            var formData = registerForm.serialize();
            $.ajax({
                url: '/voidDStockInData',
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
                    $('#voidDSbtn').text('Voiding...');
                    $('#voidDSbtn').prop("disabled", true);
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
                        if (data.errors.DSReason) {
                            $('#dsvoid-error').html("The reason field is required.");
                        }
                        $('#voidDSbtn').text('Void');
                        $('#voidDSbtn').prop("disabled", false);
                    }
                    else if(data.statuserror){
                        $('#voidDSbtn').text('Void');
                        $('#voidDSbtn').prop("disabled", false);
                        $('#voidDStockInModal').modal('hide');
                        toastrMessage('error',"Record status is already voided","Error");
                    }
                    else if (data.balance_error) {
                        var item_list = "";
                        $.each(data.items, function(index, value) {
                            item_list += `<b>${++index},</b> ${value.name}</br>`;
                        });

                        $('#voidDSbtn').text('Void');
                        $('#voidDSbtn').prop("disabled", false);
                        $('#voidDStockInModal').modal('hide');
                        toastrMessage('error',`You cannot void this record because the following items have insufficient quantity.</br>-------------------</br>${item_list}`,"Error");
                    } 
                    else if (data.dberrors) {
                        $('#voidDSbtn').text('Void');
                        $('#voidDSbtn').prop("disabled", false);
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if(data.success){
                        createDStockInInfo(data.rec_id);
						countDStockInStatusFn(data.fyear);  
                        var iTable = $('#laravel-datatable-crud').dataTable();
                        iTable.fnDraw(false);
                        $('#voidDStockInModal').modal('hide');
                        toastrMessage('success',"Successful","Success");
                    }
                }
            });
        });

        function undoVoidDSFn(recordId){
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
                    undoVoidDStockInFn(recordId);
                }
                else if (result.dismiss === Swal.DismissReason.cancel) {}
            });
        }

        function undoVoidDStockInFn(recordId){
            var registerForm = $("#dstockinInfoForm");
            var formData = registerForm.serialize();
            $.ajax({
                url: '/undoVoidDStockIn',
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
                        createDStockInInfo(data.rec_id);
						countDStockInStatusFn(data.fyear);
                        var iTable = $('#laravel-datatable-crud').dataTable();
                        iTable.fnDraw(false);
                        toastrMessage('success',"Successful","Success");
                    }
                }
            });
        }

        function forwardDStockInFn(){
            const requestId = $('#dstockinid').val();
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
                    dstockInForwardActionFn();
                }
                else if (result.dismiss === Swal.DismissReason.cancel) {}
            });
        }

        function dstockInForwardActionFn(){
            var forwardForm = $("#dstockinInfoForm");
            var formData = forwardForm.serialize();
            var recordId = $('#dstockinid').val();
            $.ajax({
                url: '/dstockInForwardAction',
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
                        createDStockInInfo(data.rec_id);
                        countDStockInStatusFn(data.fiscalyr);
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                    }
                }
            });
        }

        $(document).on('click', '.dstockinbackward', function(){
            const requestId = $('#dstockinid').val();
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
            $('#comment-error').html("");
            $('#backwardActionModal').modal('show');
        });

        $("#backwardActionBtn").click(function() {
            var registerForm = $("#backwardActionForm");
            var formData = registerForm.serialize();
            var btntxt = $('#backwardBtnTextValue').val();
            var recordId = $('#backwardReqId').val();
            $.ajax({
                url: '/dstockInBackwardAction',
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
                            $('#comment-error').html(text);
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
                        createDStockInInfo(data.rec_id);
                        countDStockInStatusFn(data.fiscalyr);

                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);

                        $('#backwardActionModal').modal('hide');
                    }
                }
            });
        });

        function dateFn() {
            $('#date-error').html("");
        }

        function supplierFn() {
            $('#supplier-error').html("");
        }

        function paymentTypeFn() {
            $('#paymentType-error').html("");
        }

        function stationFn() {
            $('#station-error').html("");
        }

        function purchaserFn() {
            $('#purchaser-error').html("");
        }

        $('#SourceStore').change(function() {
            var type = $(this).val();
            $('.AvQuantity').html("");
            $('#dynamicTable > tbody > tr').each(function(index, tr) {
                let row_id = $(this).find('.idval').val();
                calcDSRemBalanceFn(row_id);
            });
            $('#sourcestore-error').html("");
        });

        function destStationFn() {
            $('#destinationstore-error').html("");
        }

        function voidDSReasonFn() {
            $('#dsvoid-error').html("");
        }

        function dstockinReasonFn() {
            $('#comment-error').html("");
        }

        $('body').on('click','.printdstockin',function() {
            var id = $(this).data('id');
            var link = $(this).data('link');
            window.open(link, 'Stock-IN', 'width=1200,height=800,scrollbars=yes');
        });

        function refreshDStockInDataFn(){
            var f_year = $('#fiscalyear').val();
            countDStockInStatusFn(f_year);

            var dsTable = $('#laravel-datatable-crud').dataTable();
            dsTable.fnDraw(false);
        }

        function sellingPricePer(ele){
            $(ele).closest('tr').find('.SellingPrice').prop("readonly", false);
            $(ele).closest('tr').find('.SellingPrice').css("background","white");
        }

        function numformat(val){
            while (/(\d+)(\d{3})/.test(val.toString())){
                val = val.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
            }
            return val;
        }
    </script>
@endsection
