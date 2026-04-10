@extends('layout.app1')
@section('title')
@endsection
@section('content')
    @can('Direct-StockOUT-View')
        <div class="app-content content">
            <section id="responsive-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-bottom fit-content mb-0 pb-0">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align: left !important;align-items: center;padding: 10px 5px;">
                                            <h3 class="card-title form_title">Direct Stock-Out</h3>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align: right !important;align-items: center;padding: 10px 5px;">
                                            <button type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm" onclick="refreshDStockOutDataFn()"><i class="fas fa-sync-alt"></i></button>
                                            @if (auth()->user()->can('Direct-StockOUT-Add'))
                                            <button type="button" class="btn btn-gradient-info btn-sm addstockout header-prop" id="addstockout"><i class="fas fa-plus"></i><span class="header-text">&nbsp Add</span></button>
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
                                                            <i class="fas fa-shopping-cart"></i>
                                                        </div>
                                                    </div>
                                                    <div class="media-body my-auto mr-1">
                                                        <span class="font-weight-bolder mb-0 dstockout_status_record_lbl" id="dstockout_draft_record_lbl"></span>
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
                                                            <i class="fas fa-shopping-cart"></i>
                                                        </div>
                                                    </div>
                                                    <div class="media-body my-auto mr-1">
                                                        <span class="font-weight-bolder mb-0 dstockout_status_record_lbl" id="dstockout_pending_record_lbl"></span>
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
                                                            <i class="fas fa-shopping-cart"></i>
                                                        </div>
                                                    </div>
                                                    <div class="media-body my-auto mr-1">
                                                        <span class="font-weight-bolder mb-0 dstockout_status_record_lbl" id="dstockout_verified_record_lbl"></span>
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
                                                            <i class="fas fa-shopping-cart"></i>
                                                        </div>
                                                    </div>
                                                    <div class="media-body my-auto mr-1">
                                                        <span class="font-weight-bolder mb-0 dstockout_status_record_lbl" id="dstockout_approved_record_lbl"></span>
                                                        <p class="card-text font-small-3 mb-0">Approved</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-sm-3 col-lg custom-col mb-1">
                                            <div class="stat-item">
                                                <div class="media">
                                                    <div class="avatar bg-light-danger mr-1">
                                                        <div class="avatar-content">
                                                            <i class="fas fa-shopping-cart"></i>
                                                        </div>
                                                    </div>
                                                    <div class="media-body my-auto mr-1">
                                                        <span class="font-weight-bolder mb-0 dstockout_status_record_lbl" id="dstockout_void_record_lbl"></span>
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
                                                            <i class="fas fa-shopping-cart"></i>
                                                        </div>
                                                    </div>
                                                    <div class="media-body my-auto mr-1">
                                                        <span class="font-weight-bolder mb-0 dstockout_status_record_lbl" id="dstockout_total_record_lbl"></span>
                                                        <p class="card-text font-small-3 mb-0">Total</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>      
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 fit-content">
                                    <div class="row main_datatable" id="dstockout_tbl">
                                        <div style="width:99%; margin-left:0.5%;"> 
                                            <table id="laravel-datatable-crud" class="display table-bordered table-striped table-hover defaultdatatable mb-0 mobile-dt" style="width: 100%">
                                                <thead>
                                                    <tr>
                                                        <th style="display: none;"></th>
                                                        <th style="width: 3%;">#</th>
                                                        <th style="width: 12%;" title="Direct Stock-Out Document Number">Document No.</th>
                                                        <th style="width: 8%;">Type</th>
                                                        <th style="width: 17%;">Customer</th>
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
    <div class="modal fade text-left fit-content" id="dstockoutInfoModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="dispatchinfotitle" aria-hidden="true" style=" overflow-y: scroll;">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title form_title" id="dstockininfotitle">Direct Stock-OUT Information</h4>
                    <div class="row">
                        <div style="text-align: right" class="form_title info_modal_title_lbl" id="statustitles"></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <form id="dstockoutInfoForm">
                    @csrf
                    <div class="modal-body">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <section id="card-text-alignment">
                                        <div class="d-flex justify-content-between align-items-center cursor-pointer border-bottom" data-toggle="collapse" data-target=".infoscl" aria-expanded="true">
                                            <h5 class="mb-0 form_title dstockout_header_info"><i class="far fa-info-circle"></i> Basic Information</h5>
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
                                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mt-1 mb-1 allinfo salesinfo">
                                                    <div class="card shadow-none border m-0">
                                                        <div class="card-body">
                                                            <h6 class="card-title mb-0"><i class="fas fa-shopping-cart"></i> Sales Information</h6>
                                                            <hr class="my-50">
                                                            <table class="infotbl" style="width:100%;font-size:12px;">
                                                                <tr>
                                                                    <td><label class="info_lbl">Customer</label></td>
                                                                    <td><label class="info_lbl" id="infoCustomerNameLbl" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl">Payment Type</label></td>
                                                                    <td><label class="info_lbl" id="infoPaymentTypeLbl" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl">Station</label></td>
                                                                    <td><label class="info_lbl" id="infoStationLbl" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mt-1 mb-1 allinfo internalinfo">
                                                    <div class="card shadow-none border m-0">
                                                        <div class="card-body">
                                                            <h6 class="card-title mb-0"><i class="fas fa-grip-horizontal"></i> Internal Information</h6>
                                                            <hr class="my-50">
                                                            <table class="infotbl" style="width:100%;font-size:12px;">
                                                                <tr>
                                                                    <td><label class="info_lbl">Customer</label></td>
                                                                    <td><label class="info_lbl" id="infoIntCustomerNameLbl" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl">Payment Type</label></td>
                                                                    <td><label class="info_lbl" id="infoIntPaymentTypeLbl" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl">Reference</label></td>
                                                                    <td><label class="info_lbl" id="infoReferenceLbl" style="font-weight: bold;"></label></td>
                                                                </tr>
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
                                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mt-1 mb-1 allinfo othersinfo">
                                                    <div class="card shadow-none border m-0">
                                                        <div class="card-body">
                                                            <h6 class="card-title mb-0" id="othersinfo_title"></h6>
                                                            <hr class="my-50">
                                                            <table class="infotbl" style="width:100%;font-size:12px;">
                                                                <tr>
                                                                    <td><label class="info_lbl">Station</label></td>
                                                                    <td><label class="info_lbl" id="infoOtherStationLbl" style="font-weight: bold;"></label></td>
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
                                        <div class="row infoRecDiv" id="dstockout_item_div">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <table id="dstockoutInfodatatbl" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable" style="width: 100%">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:3%;">#</th>
                                                            <th style="width:10%;">Item Code</th>
                                                            <th style="width:21%;">Item Name</th>
                                                            <th style="width:10%;">Barcode No.</th>
                                                            <th style="width:8%;" title="Unit of Measurement">UOM</th>
                                                            <th style="width:8%;">Quantity</th>
                                                            <th style="width:10%;">Unit Price</th>
                                                            <th style="width:10%;">Total Price</th>
                                                            <th style="width:20%;">Remark</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="table table-sm"></tbody>
                                                    <tfoot class="table table-sm" id="item_tbl_footer">
                                                        <tr>
                                                            <td colspan="7" style="padding-right: 2px !important;text-align:right;font-weight: bold;">Total</td>
                                                            <td>
                                                                <label id="infoDSTotalPriceFooter" class="info_lbl infoDSTotalPrice" style="font-weight: bold;"></label>
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
                                                            <label class="info_lbl">Total Price</label>
                                                        </td>
                                                        <td style="text-align: center;width:45%;">
                                                            <label id="infoDSTotalPriceT" class="formattedNum info_lbl infoDSPriceCost" style="font-weight: bold;"></label>
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
                                        <ul class="dropdown-menu" id="dstockout_action_ul"></ul>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align:right">
                                    <input type="hidden" class="form-control" name="dstockout_type_inp" id="dstockout_type_inp" readonly="true">
                                    <input type="hidden" class="form-control" name="dstockoutid" id="dstockoutid" readonly="true">
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
                    <h4 class="modal-title form_title" id="stockoutformtitle"></h4>
                    <div class="row">
                        <div style="text-align: right;" class="form_title" id="dstockout_status"></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>   
                </div>
                <form id="Register">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="row">
                                <div class="col-xl-3 col-lg-5 col-md-12 col-sm-12 col-12 mb-1">
                                    <fieldset class="fset">
                                        <legend>General</legend>
                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 mb-1">
                                                <label class="form_lbl">Type<b style="color: red; font-size:16px;">*</b></label>
                                                <select class="select2 form-control" name="Type" id="Type">
                                                    <option value="1">Sales</option>
                                                    <option value="2">Internal</option>
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
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                                <label class="form_lbl">Remark</label>
                                                <textarea type="text" placeholder="Write Remark here..." class="form-control reg_form generalcls" name="Memo" id="Memo" rows="1"></textarea>
                                                <span class="text-danger">
                                                    <strong id="memo-error" class="errordatalabel"></strong>
                                                </span>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-xl-9 col-lg-7 col-md-12 col-sm-12 col-12 mb-1 type_div" style="display: none;" id="sales_div">
                                    <fieldset class="fset">
                                        <legend>Sales Data</legend>
                                        <div class="row">
                                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 mb-1">
                                                <label class="form_lbl">Customer<b style="color: red; font-size:16px;">*</b></label>
                                                <select class="select2 form-control" name="customer" id="customer" onchange="customerFn()">
                                                    @foreach ($customerSrcSales as $cussales)
                                                        <option value="{{$cussales->id}}"> {{$cussales->Code}}  ,  {{$cussales->Name}}   ,   {{$cussales->TinNumber}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger">
                                                    <strong class="errordatalabel sales_error" id="customer-error"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 mb-1">
                                                <label class="form_lbl">Payment Type<b style="color: red; font-size:16px;">*</b></label>
                                                <select class="select2 form-control" name="PaymentType" id="PaymentType" onchange="paymentTypeFn()">
                                                    <option value="--">--</option>
                                                    <option value="Cash">Cash</option>
                                                    <option value="Credit">Credit</option>
                                                </select>
                                                <span class="text-danger">
                                                    <strong class="errordatalabel sales_error" id="paymentType-error"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 mb-1">
                                                <label class="form_lbl">Station<b style="color: red; font-size:16px;">*</b></label>
                                                <select class="select2 form-control source_station" name="Station" id="Station" onchange="stationFn()">
                                                    @foreach ($SourceStoreSrc as $station)
                                                        <option value="{{$station->StoreId}}">{{$station->StoreName}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger">
                                                    <strong class="errordatalabel sales_error src_station" id="station-error"></strong>
                                                </span>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-xl-9 col-lg-7 col-md-12 col-sm-12 col-12 mb-1 type_div" style="display: none;" id="internal_div">
                                    <fieldset class="fset">
                                        <legend>Internal Data</legend>
                                        <div class="row">
                                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 mb-1">
                                                <label class="form_lbl">Customer<b style="color: red; font-size:16px;">*</b></label>
                                                <select class="select2 form-control" name="internal_customer" id="internal_customer" onchange="intCustomerFn()">
                                                    <option selected disabled value=""></option>
                                                    @foreach ($customerSrcSales as $cusint)
                                                        <option value="{{$cusint->id}}"> {{$cusint->Code}}  ,  {{$cusint->Name}}   ,   {{$cusint->TinNumber}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger">
                                                    <strong class="errordatalabel int_error" id="intcustomer-error"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 mb-1">
                                                <label class="form_lbl">Payment Type<b style="color: red; font-size:16px;">*</b></label>
                                                <select class="select2 form-control" name="InternalPaymentType" id="InternalPaymentType" onchange="intPaymentTypeFn()">
                                                    <option selected disabled value=""></option>
                                                    <option value="--">--</option>
                                                    <option value="Cash">Cash</option>
                                                    <option value="Credit">Credit</option>
                                                </select>
                                                <span class="text-danger">
                                                    <strong class="errordatalabel int_error" id="intpaymentType-error"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 mb-1">
                                                <label class="form_lbl">Reference</label>
                                                <input type="text" placeholder="Write reference here" class="form-control reg_form" name="reference" id="reference" onkeyup="referenceFn()"/>
                                                <span class="text-danger">
                                                    <strong class="errordatalabel int_error" id="reference-error"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mb-1">
                                                <label class="form_lbl">Source Station<b style="color: red; font-size:16px;">*</b></label>
                                                <select class="select2 form-control source_station" name="SourceStore" id="SourceStore">
                                                    @foreach ($SourceStoreSrc as $srcStation)
                                                        <option value="{{$srcStation->StoreId}}">{{$srcStation->StoreName}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger">
                                                    <strong class="errordatalabel int_error src_station" id="sourcestore-error"></strong>
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
                                                    <strong class="errordatalabel int_error" id="destinationstore-error"></strong>
                                                </span>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-xl-9 col-lg-7 col-md-12 col-sm-12 col-12 mb-1 type_div" style="display: none;" id="others_div">
                                    <fieldset class="fset">
                                        <legend>Others Data</legend>
                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mb-1">
                                                <label class="form_lbl">Station<b style="color: red; font-size:16px;">*</b></label>
                                                <select class="select2 form-control source_station" name="OtherStore" id="OtherStore" onchange="otherStationFn()">
                                                    @foreach ($SourceStoreSrc as $othStation)
                                                        <option value="{{$othStation->StoreId}}">{{$othStation->StoreName}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger">
                                                    <strong class="errordatalabel oth_error src_station" id="otherstation-error"></strong>
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
                                                <th class="form_lbl" style="width:20%;">Item Name<b style="color: red; font-size:16px;">*</b></th>
                                                <th class="form_lbl" style="width:10%;" title="Unit of Measurement">UOM</th>
                                                <th class="form_lbl" style="width:12%;" title="Quantity on Hand">Qty. on Hand</th>
                                                <th class="form_lbl" style="width:12%;">Quantity<b style="color: red; font-size:16px;">*</b></th>
                                                <th class="form_lbl" style="width:12%;">Unit Price</th>
                                                <th class="form_lbl" style="width:12%;">Total Price</th>
                                                <th class="form_lbl" style="width:16%;">Remark</th>
                                                <th class="form_lbl" style="width:3%;"></th>
                                            </thead>
                                            <tbody></tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="4" style="text-align: left !important;border: none;">
                                                        <button type="button" name="adds" id="adds" class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i> Add New</button>
                                                    </td>
                                                    <td colspan="2" style="padding-right: 3px !important;text-align:right;vertical-align: middle;font-weight: bold;border: none;">Total</td>
                                                    <td style="vertical-align: middle;padding-top:3px;">
                                                        <label id="subtotalLbl" class="form_lbl pricing_cls" style="padding-left: 15px !important;font-weight: bold;font-size:15px;"></label>
                                                    </td>
                                                    <td  colspan="2" style="border: none;"></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
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
                        <button id="savebutton" type="button" class="btn btn-info">Save</button>
                        <button id="closebuttonk" type="button" class="btn btn-danger closebutton" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End Registation Modal -->

    <!--Start DStockOUT-Void Modal -->
    <div class="modal fade text-left fit-content" id="voidDStockOutModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="voiddstockoutform">
                    @csrf
                    <div class="modal-body">
                        <label class="form_lbl">Reason</label>
                        <textarea type="text" placeholder="Write Reason here..." class="form-control DSReason" rows="3" name="DSReason" id="DSReason" onkeyup="voidDSReasonFn()"></textarea>
                        <span class="text-danger">
                            <strong class="errordatalabel" id="dsvoid-error"></strong>
                        </span>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control" name="voidDStockOutid" id="voidDStockOutid" readonly="true">
                        <button id="voidDSbtn" type="button" class="btn btn-info">Void</button>
                        <button id="closebuttonvoid" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End DStockOUT-Void Modal -->

    <!--Start backward action modal -->
    <div class="modal fade text-left fit-content" id="backwardActionModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
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
                        <label class="form_lbl" id="backwardActionLabel"></label>
                        <textarea type="text" placeholder="Write Reason here..." class="form-control" rows="3" name="CommentOrReason" id="CommentOrReason" onkeyup="dstockoutReasonFn()"></textarea>
                        <span class="text-danger">
                            <strong id="comment-error"></strong>
                        </span>
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
                
            },
        };

        $(document).ready(function() {
            $('.main_datatable').hide(); 
            countDStockOutStatusFn(fyears);
            fetchDStockOutDataFn(fyears);
        });

        function fetchDStockOutDataFn(fy){
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
                dom: "<'row'<'col-sm-3 col-sm-3 col-md-2 col-6'f><'col-sm-3 col-md-2 col-6 mt-1 dsout-custom-1'><'col-sm-3 col-md-1 col-6 mt-1 dsout-custom-2'><'col-sm-3 col-md-1 col-6 mt-1 dsout-custom-3'><'col-sm-4 col-md-2 col-6 mt-1 dsout-custom-4'><'col-sm-4 col-md-2 col-6 mt-1 dsout-custom-5'><'col-sm-4 col-md-2 col-12 mt-1 dsout-custom-6'>>" +
                    "<'row'<'col-sm-12 margin_top_class'tr>>" +
                    "<'row'<'col-sm-4 col-md-4 col-4'l><'col-sm-4 col-md-4 col-4 d-flex justify-content-center'i><'col-sm-4 col-md-4 col-4 d-flex justify-content-end'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/getDStockOutData/' + fy,
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
                        data: 'customer_name',
                        name: 'customer_name',
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
                            return `<div class="text-center"><a class="dstockoutInfo" href="javascript:void(0)" onclick="dstockoutInfoFn(${row.id})" data-id="dstockoutInfo${row.id}" id="dstockoutInfo${row.id}" title="Open information form"><i class="fa-sharp fa-regular fa-circle-info fa-xl" style="color: #00cfe8;"></i></a></div>`;
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
                        data: 'StoreId', 
                        name: 'StoreId',
                        "render": function ( data, type, row, meta ) {
                            return "";
                        },
                        'visible': false //12
                    },
                    { 
                        data: 'DestinationStore', 
                        name: 'DestinationStore',
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
                    $('#dstockout_tbl').show();
                    $('#laravel-datatable-crud').DataTable().columns.adjust();
                },
                fixedHeader: {
                    header: true,
                    headerOffset: $('.header-navbar').outerHeight(),
                },
            });

            appendDStockOutFilterFn(fy);
        }

        function appendDStockOutFilterFn(fyears){
            var dstockout_fiscalyear = $(`
                <select class="selectpicker form-control dropdownclass" id="fiscalyear" name="fiscalyear[]" title="Select fiscal year here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" data-actions-box="true" data-selected-text-format="count" data-count-selected-text="Fiscal Year ({0})">
                    @foreach ($fiscalyears as $fiscalyears)
                        <option value="{{ $fiscalyears->FiscalYear }}">{{ $fiscalyears->Monthrange }}</option>
                    @endforeach
                </select>`);

            $('.dsout-custom-1').html(dstockout_fiscalyear);
            $('#fiscalyear')
            .selectpicker()
            .selectpicker('val', fyears)
            .off('changed.bs.select') 
            .on('changed.bs.select', function () {
                let fyear = $(this).val();
                countDStockOutStatusFn(fyear);
                fetchDStockOutDataFn(fyear); 
            });

            var dsout_type_filters = $(`
                <select class="selectpicker form-control dropdownclass" id="dsout_type_filter" name="dsout_type_filter[]" title="Select type here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" data-actions-box="true" multiple data-selected-text-format="count" data-count-selected-text="Type ({0})">
                    <option selected value="1">Sales</option>
                    <option selected value="2">Internal</option>
                    <option selected value="3">Others</option>
                </select>`);

            $('.dsout-custom-2').html(dsout_type_filters);
            $('#dsout_type_filter')
            .selectpicker()
            .off('changed.bs.select') 
            .on('changed.bs.select', function () {  
                var selected = $('#dsout_type_filter option:selected');
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

            var dsout_payment_type_filters = $(`
                <select class="selectpicker form-control dropdownclass" id="dsout_payment_type_filter" name="dsout_payment_type_filter[]" title="Select payment type here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" data-actions-box="true" multiple data-selected-text-format="count" data-count-selected-text="Payment Type ({0})">
                    <option selected value="--">--</option>
                    <option selected value="Cash">Cash</option>
                    <option selected value="Credit">Credit</option>
                </select>`);

            $('.dsout-custom-3').html(dsout_payment_type_filters);
            $('#dsout_payment_type_filter')
            .selectpicker()
            .off('changed.bs.select') 
            .on('changed.bs.select', function () {  
                var selected = $('#dsout_payment_type_filter option:selected');
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

            var dsout_src_filters = $(`
                <select class="selectpicker form-control dropdownclass" id="dsout_src_filter" name="dsout_src_filter[]" title="Select source station here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" data-actions-box="true" multiple data-selected-text-format="count" data-count-selected-text="Source Station ({0})">
                    <option selected value="1">--</option>
                    @foreach ($SourceStoreSrc as $filter_station)
                        <option selected value="{{$filter_station->StoreId}}">{{$filter_station->StoreName}}</option>
                    @endforeach
                </select>`);

            $('.dsout-custom-4').html(dsout_src_filters);
            $('#dsout_src_filter')
            .selectpicker()
            .off('changed.bs.select') 
            .on('changed.bs.select', function () {  
                var selected = $('#dsout_src_filter option:selected');
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

            var dsout_dest_filters = $(`
                <select class="selectpicker form-control dropdownclass" id="dsout_dest_filter" name="dsout_dest_filter[]" title="Select destination station here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" data-actions-box="true" multiple data-selected-text-format="count" data-count-selected-text="Destination Station ({0})">
                    <option selected value="1">--</option>
                    @foreach(collect($SourceStoreSrc)->merge($storeSrc)->unique('StoreId')->values() as $station)
                        <option selected value="{{$station->StoreId}}">{{$station->StoreName}}</option>
                    @endforeach
                </select>`);

            $('.dsout-custom-5').html(dsout_dest_filters);
            $('#dsout_dest_filter')
            .selectpicker()
            .off('changed.bs.select') 
            .on('changed.bs.select', function () {  
                var selected = $('#dsout_dest_filter option:selected');
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
                <select class="selectpicker form-control dropdownclass" id="dsout_status_filter" name="dsout_status_filter[]" title="Select status here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" data-actions-box="true" multiple data-selected-text-format="count" data-count-selected-text="Status ({0})">
                    <option selected value="Draft">Draft</option>
                    <option selected value="Pending">Pending</option>
                    <option selected value="Verified">Verified</option>
                    <option selected value="Approved">Approved</option>
                    <option selected value="Void">Void</option>
                </select>`);

            $('.dsout-custom-6').html(status_filter);
            $('#dsout_status_filter')
            .selectpicker()
            .off('changed.bs.select') 
            .on('changed.bs.select', function () {  
                var selected = $('#dsout_status_filter option:selected');
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

        function countDStockOutStatusFn(fiscalyear){
            var fyear = 0;
            var disp_void_cnt = 0;
            
            $.ajax({
                url: '/countDStockOutStatus',
                type: 'POST',
                data:{
                    fyear: fiscalyear,
                },
                dataType: 'json',
                success: function(data) {
                    $(".dstockout_status_record_lbl").html("0");
                    $.each(data.dstockout_status_count, function(key, value) {
                        if(value.Status == "Draft"){
                            $("#dstockout_draft_record_lbl").html(value.status_count);
                        }
                        else if(value.Status == "Pending"){
                            $("#dstockout_pending_record_lbl").html(value.status_count);
                        }
                        else if(value.Status == "Verified"){
                            $("#dstockout_verified_record_lbl").html(value.status_count);
                        }
                        else if(value.Status == "Approved"){
                            $("#dstockout_approved_record_lbl").html(value.status_count);
                        }
                        else if(value.Status == "Total"){
                            $("#dstockout_total_record_lbl").html(value.status_count);
                        }
                        else {
                            disp_void_cnt += parseInt(value.status_count);
                            $("#dstockout_void_record_lbl").html(disp_void_cnt);
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

        $("#addstockout").click(function() { 
            resetStockOutFormFn();
            $("#stockoutformtitle").html('Add Stock-Out');
            $("#inlineForm").modal('show');
        });

        $('#savebutton').click(function() {
            var optype = $('#operationtypes').val();
            var registerForm = $("#Register");
            var formData = registerForm.serialize();

            $.ajax({
                url: '/saveDStockOut',
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
                        if (data.errors.customer) {
                            var text = data.errors.customer[0];
                            text = text.replace("1", "sales");
                            $('#customer-error').html(text);
                        }
                        if (data.errors.PaymentType) {
                            var text = data.errors.PaymentType[0];
                            text = text.replace("1", "sales");
                            $('#paymentType-error').html(text);
                        }
                        if (data.errors.Station) {
                            var text = data.errors.Station[0];
                            text = text.replace("1", "sales");
                            $('#station-error').html(text);
                        }

                        if (data.errors.internal_customer) {
                            var text = data.errors.internal_customer[0];
                            text = text.replace("2", "internal");
                            text = text.replace("internal", "");
                            $('#intcustomer-error').html(text);
                        }
                        if (data.errors.InternalPaymentType) {
                            var text = data.errors.InternalPaymentType[0];
                            text = text.replace("2", "internal");
                            text = text.replace("internal", "");
                            $('#intpaymentType-error').html(text);
                        }
                        if (data.errors.reference) {
                            $('#reference-error').html(data.errors.reference[0]);
                        }
                        if (data.errors.SourceStore) {
                            var text = data.errors.SourceStore[0];
                            text = text.replace("2", "internal");
                            text = text.replace("3", "others");
                            text = text.replace("store", "station");
                            $('#sourcestore-error').html(text);
                        }
                        if (data.errors.DestinationStore) {
                            var text = data.errors.DestinationStore[0];
                            text = text.replace("2", "internal");
                            
                            text = text.replace("store", "station");
                            $('#destinationstore-error').html(text);
                        }

                        if (data.errors.OtherStore) {
                            var text = data.errors.OtherStore[0];
                            text = text.replace("3", "others");
                            text = text.replace("other", "");
                            $('#otherstation-error').html(text);
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
                            if(($(`#quantity${k}`).val())!=undefined){
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
                            createDStockOutInfo(data.rec_id);
                        }
                        countDStockOutStatusFn(data.fiscalyr);
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                        $("#inlineForm").modal('hide');
                    }
                }
            });
        });

        function dstockoutInfoFn(recordId){
            createDStockOutInfo(recordId);
            $("#dstockoutInfoModal").modal('show');
        }

        function createDStockOutInfo(recordId){
            $('.allinfo').hide();
            $('.dispbtnprop').hide();
            $('.infoRecDiv').hide();
            $('.infofooter').html("");
            $('#dstockoutid').val(recordId);
            var recId = "";
            var lidata = "";
            var status_color = "";
            var action_links = "";
            var withold_btn_link = "";
            var major_btn_link = `<li><hr class="dropdown-divider"></li>`;
            var status_btn_link = `<li><hr class="dropdown-divider"></li>`;
            var flag_btn_link = `<li><hr class="dropdown-divider"></li>`;
            var edit_link = `
                @can("Direct-StockOUT-Edit")
                    <li>
                        <a class="dropdown-item editDStockOut" href="javascript:void(0)" onclick="editDStockOutFn(${recordId})" data-id="editDSLink${recordId}" id="editDSLink${recordId}" title="Edit record">
                        <span><i class="fa-solid fa-pencil"></i> Edit</span>  
                        </a>
                    </li>
                @endcan`;

            var void_link = `
                @can("Direct-StockOUT-Void")
                    <li>
                        <a class="dropdown-item voidDS" href="javascript:void(0)" onclick="voidDStockOutFn(${recordId})" data-id="voidDS${recordId}" id="voidDS${recordId}" title="Void record">
                        <span><i class="fa-solid fa-ban"></i> Void</span>  
                        </a>
                    </li>
                @endcan`;

            var undovoid_link = `
                @can("Direct-StockOUT-Void")
                <li>
                    <a class="dropdown-item undoVoidDS" href="javascript:void(0)" onclick="undoVoidDSFn(${recordId})" data-id="undoVoidDS${recordId}" id="undoVoidDS${recordId}" title="Undo void record">
                    <span><i class="fa fa-undo"></i> Undo Void</span>  
                    </a>
                </li>
                @endcan`;

            var change_to_pending_link = `
                @can("Direct-StockOUT-ChangeToPending")
                <li>
                    <a class="dropdown-item changetopending" onclick="forwardDStockOutFn()" id="changetopending" title="Change record to pending">
                    <span><i class="fa-solid fa-forward"></i> Change to Pending</span>  
                    </a>
                </li>
                @endcan`;

            var back_to_draft_link = `
                @can("Direct-StockOUT-ChangeToPending")
                <li>
                    <a class="dropdown-item dstockoutbackward" id="backtodraft" title="Change record to draft">
                    <span><i class="fa-solid fa-backward"></i> Back to Draft</span>  
                    </a>
                </li>
                @endcan`;

            var verify_link = `
                @can("Direct-StockOUT-Verify")
                <li>
                    <a class="dropdown-item verifyrecord" onclick="forwardDStockOutFn()" id="verifyrecord" title="Change record to verified">
                    <span><i class="fa-solid fa-forward"></i> Verify</span>  
                    </a>
                </li>
                @endcan`;

            var back_to_pending = `
                @can("Direct-StockOUT-Verify")
                <li>
                    <a class="dropdown-item dstockoutbackward" id="backtopending" title="Change record to pending">
                    <span><i class="fa-solid fa-backward"></i> Back to Pending</span>  
                    </a>
                </li>
                @endcan`;

            var approve_link = `
                @can("Direct-StockOUT-Receive")
                <li>
                    <a class="dropdown-item approverecord" onclick="forwardDStockOutFn()" id="approverecord" title="Change record to approved">
                    <span><i class="fa-solid fa-forward"></i> Approve</span>  
                    </a>
                </li>
                @endcan`;

            var print_btn_link = `
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item printdstockout" href="javascript:void(0)" data-link="/dspo/${recordId}" data-id="printdstockout${recordId}" id="printdstockout${recordId}" title="Print Direct Stock-Out Voucher">
                    <span><i class="fa fa-file"></i> Print Stock-OUT Voucher</span>  
                    </a>
                </li>`;


            $.ajax({
                url: '/fetchDStockOutData',
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
                   fetchDStockOutItemListFn(recordId);
                },
                success: function(data) {
                    $.each(data.dstockoutdata,function(key,value) { 
                        $('#infoDSTypeLbl').html(value.rec_type);
                        $('#infoDSDate').html(value.TransactionDate);
                        $('#infoDSRemark').html(value.Memo);

                        $('#infoCustomerNameLbl').html(value.customer_name);
                        $('#infoPaymentTypeLbl').html(value.PaymentType);
                        $('#infoStationLbl').html(value.src_store_name);

                        $('#infoIntCustomerNameLbl').html(value.customer_name);
                        $('#infoIntPaymentTypeLbl').html(value.PaymentType);
                        $('#infoReferenceLbl').html(value.Reference);
                        $('#infoSourceStationLbl').html(value.src_store_name);
                        $('#infoDestinationStationLbl').html(value.des_store_name);

                        $('#infoOtherStationLbl').html(value.src_store_name);

                        $('#dstockout_type_inp').val(value.Type);
                        $('#currentStatus').val(value.Status);

                        if(parseInt(value.Type) == 1){
                            $('.salesinfo').show();
                        }
                        if(parseInt(value.Type) == 2){
                            $('.internalinfo').show();
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

                            status_btn_link += approve_link;
                            status_btn_link += back_to_pending;
                            
                            status_color = "#7367F0";
                        }
                        
                        else if(value.Status == "Approved"){
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

                        $("#dstockout_action_ul").empty().append(action_links);
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

        function viewDSActionFn(recordId){
            $("#action-log-title").html("User Log Information");
            $("#action-log-universal-modal").modal('show');
        }

        function fetchDStockOutItemListFn(recordId){
            var ds_type = $('#dstockin_type_inp').val();
            $('#dstockoutInfodatatbl').DataTable({
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
                    url: '/getDStockOutDetailData/' + recordId,
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
                        data: 'UnitPrice',
                        name: 'UnitPrice',
                        render: $.fn.dataTable.render.number(',', '.',2, ''),
                        width:"10%"
                    },
                    {
                        data: 'BeforeTaxPrice',
                        name: 'BeforeTaxPrice',
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
                        if ($(this).text() == "NULL" || $(this).text() === "NULL" || $(this).text() == 0) {
                            $(this).text('');
                        }
                    });
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
                        $('.infoDSTotalPrice').html(`${total === 0 ? '' : numformat(parseFloat(total).toFixed(2))}`);
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

        function editDStockOutFn(recordId){
            var recId = "";
            var status_color = "";
            resetStockOutFormFn();
            $('#recordId').val(recordId);
            $('.mainprop').hide();
            $('.type_div').hide();
            $("#dynamicTable > tbody").empty();
            var options = null;
            j = 0;
            $.ajax({
                url: '/fetchDStockOutData',
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
                    $.each(data.dstockoutdata,function(key,value) { 
                        $('#Type').val(value.Type).select2({minimumResultsForSearch:-1});
                        flatpickr('#date', { dateFormat: 'Y-m-d',clickOpens:true,maxDate:current_date});   
                        $('#date').val(value.TransactionDate);               

                        $('#customer').val(value.CustomerId).select2();
                        $('#PaymentType').val(value.PaymentType).select2({minimumResultsForSearch:-1});
                        $('#Station').val(value.StoreId).select2();
                        
                        $('#internal_customer').val(value.CustomerId).select2();
                        $('#InternalPaymentType').val(value.PaymentType).select2({minimumResultsForSearch:-1});
                        $('#reference').val(value.Reference);
                        $('#SourceStore').val(value.StoreId).select2();
                        $('#DestinationStore').val(value.DestinationStore).select2();

                        $('#OtherStore').val(value.StoreId).select2();
                        
                        $('#Memo').val(value.Memo);
                        
                        if(value.Type == 1){
                            $('#sales_div').show();
                        }
                        else if(value.Type == 2){
                            $('#internal_div').show();
                        }
                        else if(value.Type == 3){
                            $('#others_div').show();
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
                        else if(value.Status == "Approved"){
                            status_color = "#1cc88a";
                        }
                        else{
                            status_color = "#e74a3b";
                        }
                        $("#dstockout_status").html(`<span class="form_title" style='color:${status_color};font-weight:bold;text-shadow;1px 1px 10px ${status_color};font-size:16px;'>${value.DocumentNumber},     ${value.Status}</span>`);
                    });

                    $.each(data.detaildata,function(key,value) { 
                        ++i;
                        ++m;
                        ++j;
                    
                        $("#dynamicTable > tbody").append(`<tr>
                            <td style="font-weight:bold;width:3%;text-align:center;">${j}</td>
                            <td style="display:none;"><input type="hidden" name="row[${m}][idvals]" id="idval${m}" class="idval form-control" readonly="true" style="font-weight:bold;" value="${m}"/></td>
                            <td style="width:20%;"><select id="itemNameSl${m}" onchange="itemFn(${m})" class="select2 form-control itemName" name="row[${m}][ItemId]"></select></td>
                            <td style="width:10%;"><input type="text" name="row[${m}][UOM]" placeholder="UOM" id="uom${m}" class="uom form-control" readonly="true"/></td>
                            <td style="width:12%;"><input type="text" name="row[${m}][AvQuantity]" placeholder="Quantity on hand" id="AvQuantity${m}" class="AvQuantity form-control" readonly="true"/></td>
                            <td style="width:12%;"><input type="number" name="row[${m}][Quantity]" onkeyup="CalculateTotal(this)" placeholder="Write quantity here" id="quantity${m}" value="${value.Quantity}" class="quantity form-control numeral-mask"/></td>
                            <td style="width:12%;"><input type="number" name="row[${m}][UnitPrice]" onkeyup="CalculateTotal(this)" placeholder="Write unit price here" id="unitprice${m}" value="${value.UnitPrice}" class="unitprice form-control numeral-mask"/></td>
                            <td style="width:12%;"><input type="number" name="row[${m}][TotalPrice]" placeholder="Total Price" id="totalprice${m}" value="${value.BeforeTaxPrice}" class="totalprice form-control numeral-mask" readonly/></td>
                            <td style="width:16%;"><input type="text" name="row[${m}][Memo]" id="Memo${m}" class="Memo form-control" value="${value.Memo != null ? value.Memo : ""}" placeholder="Write remark here..."/></td>
                            <td style="width:3%;text-align:center;"><button type="button" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button><input type="hidden" name="row[${m}][Common]" id="common${m}" class="common form-control" readonly="true" style="font-weight:bold;"/><input type="hidden" name="row[${m}][StoreId]" id="storeid${m}" class="storeid form-control" readonly="true" style="font-weight:bold;"/></td>
                        </tr>`);

                        var default_item = `<option selected value='${value.ItemId}'>${value.ItemCode}, ${value.ItemName}, ${value.SKUNumber}</option>`;
                        
                        options = $("#stockitems");
                        $(`#itemNameSl${m}`).append(options.find(`option[data-storeid="${value.StoreId}"]`).clone()); 

                        $('#dynamicTable > tbody  > tr').each(function(index, tr) {
                            let item_id = $(this).find('.itemName').val();
                            $(`#itemNameSl${m} option[value="${value.ItemId}"]`).remove(); 
                        });

                        $(`#itemNameSl${m}`).append(default_item).select2();
                        
                        itemFn(m);

                        $(`#unitprice${m}`).val(value.UnitPrice);
                        $(`#select2-itemNameSl${m}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
                    });

                    renumberRows();
                    CalculateGrandTotal();
                },
            });

            $("#stockinformtitle").html('Edit Stock-Out');
            $('#operationtypes').val(2);
            $('#savebutton').text('Update');
            $('#savebutton').prop("disabled",false);
            $("#inlineForm").modal('show');
        }

        $(document).on('show.bs.collapse hide.bs.collapse', '.collapse', function (e) {
            e.stopPropagation();
            const collapse = $(this);
            const container = collapse.closest('.card, .modal-content, .row');
            const infoTarget = container.find('.dstockout_header_info');
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
                var d_type = $('#dstockout_type_inp').val();
                const type = container.find('#infoDSTypeLbl').text().trim();
                const customer = container.find('#infoCustomerNameLbl').text().trim();
                const payment_type = container.find('#infoPaymentTypeLbl').text().trim();
                const station = container.find('#infoStationLbl').text().trim();
                const summarySalesHtml = `
                    Type: <b>${type}</b>,
                    Customer: <b>${customer}</b>,
                    Payment Type: <b>${payment_type}</b>,
                    Station: <b>${station}</b>`;
                   
                const int_customer = container.find('#infoIntCustomerNameLbl').text().trim();
                const int_payment_type = container.find('#infoIntPaymentTypeLbl').text().trim();
                const src_station = container.find('#infoSourceStationLbl').text().trim();
                const dest_station = container.find('#infoDestinationStationLbl').text().trim();
                const summaryIntHtml = `
                    Type: <b>${type}</b>,
                    Customer: <b>${int_customer}</b>,
                    Payment Type: <b>${int_payment_type}</b>,
                    Source Station: <b>${src_station}</b>,
                    Destination Station: <b>${dest_station}</b>`;

                const oth_station = container.find('#infoOtherStationLbl').text().trim();
                const summaryOthHtml = `Type: <b>${type}</b>, Station: <b>${oth_station}</b>`;

                infoTarget.html(d_type == 1 ? summarySalesHtml : (d_type == 2 ? summaryIntHtml : summaryOthHtml));
            }
        });

        $("#adds").click(function() {
            var it = 0;
            var type = $('#Type').val();
            var storeidvar = null;
            if(type == 1){
                storeidvar = $('#Station').val();
            }
            else if(type == 2){
                storeidvar = $('#SourceStore').val();
            }
            else if(type == 3){
                storeidvar = $('#OtherStore').val();
            }
            
            var last_row = $('#dynamicTable > tbody > tr:last').find('td').eq(1).find('input').val();
            var itemids = $(`#itemNameSl${last_row}`).val();
            var default_opt = '<option selected disabled value=""></option>';
            var options = null;
            if(isNaN(parseFloat(storeidvar)) || storeidvar == null){
                toastrMessage('error',"Please select station first","Error");
                $('.src_station').html("The station field is required.");
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
                    <td style="width:20%;"><select id="itemNameSl${m}" onchange="itemFn(${m})" class="select2 form-control itemName" name="row[${m}][ItemId]"></select></td>
                    <td style="width:10%;"><input type="text" name="row[${m}][UOM]" placeholder="UOM" id="uom${m}" class="uom form-control" readonly="true"/></td>
                    <td style="width:12%;"><input type="text" name="row[${m}][AvQuantity]" placeholder="Quantity on hand" id="AvQuantity${m}" class="AvQuantity form-control" readonly="true"/></td>
                    <td style="width:12%;"><input type="number" name="row[${m}][Quantity]" onkeyup="CalculateTotal(this)" placeholder="Write quantity here" id="quantity${m}" class="quantity form-control numeral-mask"/></td>
                    <td style="width:12%;"><input type="number" name="row[${m}][UnitPrice]" onkeyup="CalculateTotal(this)" placeholder="Write unit price here" id="unitprice${m}" class="unitprice form-control numeral-mask"/></td>
                    <td style="width:12%;"><input type="number" name="row[${m}][TotalPrice]" placeholder="Total Price" id="totalprice${m}" class="totalprice form-control numeral-mask" readonly/></td>
                    <td style="width:16%;"><input type="text" name="row[${m}][Memo]" id="Memo${m}" class="Memo form-control" placeholder="Write remark here..."/></td>
                    <td style="width:3%;text-align:center;"><button type="button" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button><input type="hidden" name="row[${m}][Common]" id="common${m}" class="common form-control" readonly="true" style="font-weight:bold;"/><input type="hidden" name="row[${m}][StoreId]" id="storeid${m}" class="storeid form-control" readonly="true" style="font-weight:bold;"/></td>
                </tr>`);

                $(`#itemNameSl${m}`).append(default_opt);
                options = $("#stockitems");
                $(`#itemNameSl${m}`).append(options.find(`option[data-storeid="${storeidvar}"]`).clone()); 
                $(`#itemNameSl${m} option[data-balance = 0]`).remove();

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
                        //$(`#unitprice${row_id}`).val(value.dsmaxcosteditable);
                    });
                    $(`#select2-itemNameSl${row_id}-container`).parent().css('background-color',"white");
                }
            });

            calcDSRemBalanceFn(row_id);
        }  

        function calcDSRemBalanceFn(rowid){
            var baseRecordId = null;
            var storeval = null;
            var itemid = null;
            var net_balance = null;
            var qty = null;
            var type = $('#Type').val();
            var storeidvar = null;
            if(type == 1){
                storeidvar = $('#Station').val();
            }
            else if(type == 2){
                storeidvar = $('#SourceStore').val();
            }
            else if(type == 3){
                storeidvar = $('#OtherStore').val();
            }
            $.ajax({
                url: '/calcDStockOutRemBalance', 
                type: 'POST',
                data:{
                    baseRecordId:$('#recordId').val() || 0,
                    storeval:storeidvar,
                    itemid:$(`#itemNameSl${rowid}`).val(),
                },
                success: function(data) {
                    net_balance = parseFloat(data.available_qty);
                    qty = $(`#quantity${rowid}`).val();
                    $(`#AvQuantity${rowid}`).val(net_balance);

                    if(parseFloat(qty) > parseFloat(net_balance)){
                        $(`#quantity${rowid}`).val("");
                        $(`#totalprice${rowid}`).val("");
                        CalculateGrandTotal();
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
            
            var availableq = $(ele).closest('tr').find('.AvQuantity').val();
            availableq = availableq == '' ? 0 : availableq;
            
            var unitprice = $(ele).closest('tr').find('.unitprice').val();
            if(parseFloat(unitprice) == 0){
                $(ele).closest('tr').find('.unitprice').val(''); 
            }
            if(parseFloat(quantity) == 0){
                $(ele).closest('tr').find('.quantity').val(''); 
            }
            unitprice = unitprice == '' ? 0 : unitprice;
            
            if(inputid === "unitprice"+cid){
                $(ele).closest('tr').find('.unitprice').css("background","white");
            }
        
            if(inputid === "quantity"+cid){
                $(ele).closest('tr').find('.quantity').css("background","white");
            }

            if (!isNaN(unitprice) && !isNaN(quantity)){
                var total = parseFloat(unitprice) * parseFloat(quantity);
                $(ele).closest('tr').find('.totalprice').val(total.toFixed(2));
                if(parseFloat(total) > 0){
                    $(ele).closest('tr').find('.totalprice').css("background","#efefef");
                }
            }

            if(parseFloat(quantity) > parseFloat(availableq)){     
                toastrMessage('error',"There is no available quantity","Error");
                $(ele).closest('tr').find('.quantity').val("");
                $(ele).closest('tr').find('.quantity').css("background",errorcolor);
                $(ele).closest('tr').find('.totalprice').val("");
            }
            CalculateGrandTotal();
        }
    
        function CalculateGrandTotal(){
            var subtotal = 0;
            $.each($('#dynamicTable').find('.totalprice'), function () {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    subtotal += parseFloat($(this).val());
                }
            });
            $('#subtotali').val(subtotal.toFixed(2));
            $('#subtotalLbl').html(numformat(subtotal.toFixed(2)));
        }

        function resetStockOutFormFn(){
            $('#Type').val(null).select2
            ({
                placeholder: "Select type here",
                
                minimumResultsForSearch: -1
            });

            resetSalesFn();
            resetInternalFn();
            resetOthersFn();

            $('.reg_form').val("");
            $('.errordatalabel').html("");
            $('.pricing_cls').html("");
            $("#statusdisplay").html("");
            $('#dstockout_status').html("");
            $('.type_div').hide();
            flatpickr('#date',{dateFormat: 'Y-m-d',clickOpens:true,maxDate:current_date});
            $('#savebutton').text('Save');
            $('#savebutton').prop("disabled", false);
            $('#operationtypes').val(1);
            $('#dynamicTable > tbody').empty();
        }

        function resetSalesFn(){
            $('#customer').val(null).select2
            ({
                placeholder: "Select customer here",
                
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
        }

        function resetInternalFn(){
            $('#internal_customer').val(null).select2
            ({
                placeholder: "Select customer here",
                
            });

            $('#InternalPaymentType').val(null).select2
            ({
                placeholder: "Select payment type here",
                
                minimumResultsForSearch: -1
            });

            $('#SourceStore').val(null).select2
            ({
                placeholder: "Select source station here",
                
            });

            $('#DestinationStore').val(null).select2
            ({
                placeholder: "Select destination station here",
                
            });
            $("#reference").val("");
        }

        function resetOthersFn(){
            $('#OtherStore').val(null).select2
            ({
                placeholder: "Select station here",
                
            });
        }

        $('#Type').change(function() {
            var type = $(this).val();
            $('.type_div').hide();
            if(type == 1){
                resetSalesFn();
                $('.sales_error').html("");
                $('#sales_div').show();
            }
            else if(type == 2){
                resetInternalFn();
                $('.int_error').html("");
                $('#internal_div').show();
            }
            else if(type == 3){
                resetOthersFn();
                $('.oth_error').html("");
                $('#others_div').show();
            }

            $('.AvQuantity').val("");
            CalculateGrandTotal();
            $('#Type-error').html("");
        });

        function voidDStockOutFn(recordId){
            $('#DSReason').val("");
            $('#dsvoid-error').html("");
            $('#voidDStockOutid').val(recordId);
            $('#voidDSbtn').text('Void');
            $('#voidDSbtn').prop("disabled", false);
            $("#voidDStockOutModal").modal('show');
        }

        $("#voidDSbtn").click(function() {
            var registerForm = $("#voiddstockoutform");
            var formData = registerForm.serialize();
            $.ajax({
                url: '/voidDStockOutData',
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
                        $('#voidDStockOutModal').modal('hide');
                        toastrMessage('error',"Record status is already voided","Error");
                    }
                    else if(data.balerror){
                        var item_name = "";
                        $.each(data.item_list, function(index, value) {
                            item_name += `${++index}, ${value.items_list}</br>`;
                        });

                        toastrMessage('error',`You can not void the following items, </br>${item_name}`,"Error");
                        $('#voidDSbtn').text('Void');
                        $('#voidDSbtn').prop("disabled", false);
                        $('#voidDStockOutModal').modal('hide');
                    }
                    else if (data.dberrors) {
                        $('#voidDSbtn').text('Void');
                        $('#voidDSbtn').prop("disabled", false);
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if(data.success){
                        createDStockOutInfo(data.rec_id);
						countDStockOutStatusFn(data.fyear);  
                        var iTable = $('#laravel-datatable-crud').dataTable();
                        iTable.fnDraw(false);
                        $('#voidDStockOutModal').modal('hide');
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
                    undoVoidDStockOutFn(recordId);
                }
                else if (result.dismiss === Swal.DismissReason.cancel) {}
            });
        }

        function undoVoidDStockOutFn(recordId){
            var registerForm = $("#dstockoutInfoForm");
            var formData = registerForm.serialize();
            $.ajax({
                url: '/undoVoidDStockOut',
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
                    if (data.balance_error) {
                        var item_list = "";
                        $.each(data.items, function(index, value) {
                            item_list += `<b>${++index},</b> ${value.name}</br>`;
                        });
                        toastrMessage('error',`There is no available quantity for the following items</br>-------------------</br>${item_list}`,"Error");
                    } 
                    else if (data.dberrors) {
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if(data.success){
                        createDStockOutInfo(data.rec_id);
						countDStockOutStatusFn(data.fyear);
                        var iTable = $('#laravel-datatable-crud').dataTable();
                        iTable.fnDraw(false);
                        toastrMessage('success',"Successful","Success");
                    }
                }
            });
        }

        function forwardDStockOutFn(){
            const requestId = $('#dstockoutid').val();
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
                    dstockOutForwardActionFn();
                }
                else if (result.dismiss === Swal.DismissReason.cancel) {}
            });
        }

        function dstockOutForwardActionFn(){
            var forwardForm = $("#dstockoutInfoForm");
            var formData = forwardForm.serialize();
            var recordId = $('#dstockoutid').val();
            $.ajax({
                url: '/dstockOutForwardAction',
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
                    if (data.balance_error) {
                        var item_list = "";
                        $.each(data.items, function(index, value) {
                            item_list += `<b>${++index},</b> ${value.name}</br>`;
                        });
                        toastrMessage('error',`There is no available quantity for the following items</br>-------------------</br>${item_list}`,"Error");
                    } 
                    else if (data.dberrors) {
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if (data.success) {
                        toastrMessage('success',"Successful","Success");
                        createDStockOutInfo(data.rec_id);
                        countDStockOutStatusFn(data.fiscalyr);
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                    }
                }
            });
        }

        $(document).on('click', '.dstockoutbackward', function(){
            const requestId = $('#dstockoutid').val();
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
                url: '/dstockOutBackwardAction',
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
                        createDStockOutInfo(data.rec_id);
                        countDStockOutStatusFn(data.fiscalyr);

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

        function customerFn() {
            $('#customer-error').html("");
        }

        function paymentTypeFn() {
            $('#paymentType-error').html("");
        }

        function stationFn() {
            $('#station-error').html("");
        }

        function intCustomerFn() {
            $('#intcustomer-error').html("");
        }

        function intPaymentTypeFn() {
            $('#intpaymentType-error').html("");
        }

        function referenceFn() {
            $('#reference-error').html("");
        }

        $('.source_station').change(function() {
            var type = $(this).val();
            $('.AvQuantity').html("");
            $('#dynamicTable > tbody > tr').each(function(index, tr) {
                let row_id = $(this).find('.idval').val();
                calcDSRemBalanceFn(row_id);
            });

            $('.src_station').html("");
        });

        function destStationFn() {
            $('#destinationstore-error').html("");
        }

        function otherStationFn() {
            $('#otherstation-error').html("");
        }

        function voidDSReasonFn() {
            $('#dsvoid-error').html("");
        }

        function dstockoutReasonFn() {
            $('#comment-error').html("");
        }

        $('body').on('click', '.printdstockout', function() {
            var id = $(this).data('id');
            var link = $(this).data('link');
            window.open(link, 'Stock-Out', 'width=1200,height=800,scrollbars=yes');
        });

        function refreshDStockOutDataFn(){
            var f_year = $('#fiscalyear').val();
            countDStockOutStatusFn(f_year);

            var dsTable = $('#laravel-datatable-crud').dataTable();
            dsTable.fnDraw(false);
        }

        function numformat(val){
            while (/(\d+)(\d{3})/.test(val.toString())){
                val = val.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
            }
            return val;
        }
    </script>
@endsection