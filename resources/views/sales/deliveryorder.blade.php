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
                                            <h3 class="card-title form_title">Delivery Order</h3>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align: right !important;align-items: center;padding: 10px 5px;">
                                            <button type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm" onclick="refreshDOFn()"><i class="fas fa-sync-alt"></i></button>
                                            @can('Dispatch-Add')
                                            <button type="button" class="btn btn-gradient-info btn-sm addDeliveryOrder header-prop" id="addDeliveryOrder"><i class="fas fa-plus"></i><span class="header-text">&nbsp Add</span></button>
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
                                                            <i class="fa-solid fa-box-archive"></i>
                                                        </div>
                                                    </div>
                                                    <div class="media-body my-auto mr-1">
                                                        <span class="font-weight-bolder mb-0 do_status_record_lbl" id="do_draft_record_lbl"></span>
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
                                                            <i class="fa-solid fa-box-archive"></i>
                                                        </div>
                                                    </div>
                                                    <div class="media-body my-auto mr-1">
                                                        <span class="font-weight-bolder mb-0 do_status_record_lbl" id="do_pending_record_lbl"></span>
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
                                                            <i class="fa-solid fa-box-archive"></i>
                                                        </div>
                                                    </div>
                                                    <div class="media-body my-auto mr-1">
                                                        <span class="font-weight-bolder mb-0 do_status_record_lbl" id="do_verified_record_lbl"></span>
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
                                                            <i class="fa-solid fa-box-archive"></i>
                                                        </div>
                                                    </div>
                                                    <div class="media-body my-auto mr-1">
                                                        <span class="font-weight-bolder mb-0 do_status_record_lbl" id="do_approved_record_lbl"></span>
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
                                                            <i class="fa-solid fa-box-archive"></i>
                                                        </div>
                                                    </div>
                                                    <div class="media-body my-auto mr-1">
                                                        <span class="font-weight-bolder mb-0 do_status_record_lbl" id="do_void_record_lbl"></span>
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
                                                            <i class="fa-solid fa-box-archive"></i>
                                                        </div>
                                                    </div>
                                                    <div class="media-body my-auto mr-1">
                                                        <span class="font-weight-bolder mb-0 do_status_record_lbl" id="do_total_record_lbl"></span>
                                                        <p class="card-text font-small-3 mb-0">Total</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-sm-3 col-lg custom-col mb-1">
                                            <div class="stat-item">
                                                <div class="media">
                                                    <div class="avatar bg-light-success mr-1">
                                                        <div class="avatar-content">
                                                            <i class="fa-solid fa-check-double"></i>
                                                        </div>
                                                    </div>
                                                    <div class="media-body my-auto mr-1">
                                                        <span class="font-weight-bolder mb-0 do_status_record_lbl" id="do_ready_record_lbl"></span>
                                                        <p title="Total records of &#10; ✓ Proforma Invoice &#10; ✓ Sales Invoice &#10; ✓ Sales Order" class="card-text font-small-3 mb-0">Ready for DO</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>      
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 fit-content">
                                    <div class="row main_datatable" id="delivery_order_tbl">
                                        <div style="width:99%; margin-left:0.5%;">
                                            <table id="laravel-datatable-crud" class="display table-bordered table-striped table-hover defaultdatatable mb-0 mobile-dt" style="width: 100%">
                                                <thead>
                                                    <tr>
                                                        <th style="display: none;"></th>
                                                        <th style="width:3%;">#</th>
                                                        <th style="width:12%;" title="Delivery Order Number">DO. No.</th>
                                                        <th style="width:11%;">Reference Type</th>
                                                        <th style="width:11%;">Reference</th>
                                                        <th style="width:8%;">Product Type</th>
                                                        <th style="width:14%;">Customer Name</th>
                                                        <th style="width:8%;">TIN</th>
                                                        <th style="width:11%;">Station</th>
                                                        <th style="width:10%;">Delivery Date</th>
                                                        <th style="width:8%;">Status</th>
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
    <div class="modal fade text-left fit-content" id="doInfoModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="dispatchinfotitle" aria-hidden="true" style=" overflow-y: scroll;">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title form_title" id="doinfotitle">Delivery Order Information</h4>
                    <div class="row">
                        <div style="text-align: right" class="form_title info_modal_title_lbl" id="statustitles"></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <form id="doInfoForm">
                    @csrf
                    <div class="modal-body">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <section id="card-text-alignment">
                                        <div class="d-flex justify-content-between align-items-center cursor-pointer border-bottom" data-toggle="collapse" data-target=".infoscl" aria-expanded="true">
                                            <h5 class="mb-0 form_title do_header_info"><i class="far fa-info-circle"></i> Basic Information</h5>
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
                                                            <h6 class="card-title mb-0"><i class="fas fa-database"></i> General Information</h6>
                                                            <hr class="my-50">
                                                            <div class="row">
                                                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                                                    <table class="infotbl" style="width:100%;font-size:12px;">
                                                                        <tr>
                                                                            <td><label class="info_lbl">Reference Type</label></td>
                                                                            <td><label class="info_lbl" id="info_reference_type" style="font-weight: bold;"></label></td>
                                                                        </tr>
                                                                        <tr class="fl_class info_non_direct_ref">
                                                                            <td><label class="info_lbl">Reference</label></td>
                                                                            <td><label class="info_lbl" id="info_reference" style="font-weight: bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label class="info_lbl">Product Type</label></td>
                                                                            <td><label class="info_lbl" id="info_product_type" style="font-weight: bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label class="info_lbl">Station</label></td>
                                                                            <td><label class="info_lbl" id="info_station" style="font-weight: bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label class="info_lbl">Delivery Date</label></td>
                                                                            <td><label class="info_lbl" id="info_delivery_date" style="font-weight: bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label class="info_lbl">Expiry Date</label></td>
                                                                            <td><label class="info_lbl" id="info_expiry_date" style="font-weight: bold;"></label></td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                                                    <table class="infotbl" style="width:100%;font-size:12px;">
                                                                        <tr>
                                                                            <td><label class="info_lbl">Order By</label></td>
                                                                            <td><label class="info_lbl" id="info_order_by" style="font-weight: bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label class="info_lbl">Sales Person</label></td>
                                                                            <td><label class="info_lbl" id="info_sales_person" style="font-weight: bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label class="info_lbl">Document No.</label></td>
                                                                            <td><label class="info_lbl" id="info_doc_no" style="font-weight: bold;"></label></td>
                                                                        </tr>
                                                                        <tr class="fl_class info_direct_ref">
                                                                            <td><label class="info_lbl">Payment Type</label></td>
                                                                            <td><label class="info_lbl" id="info_payment_type" style="font-weight: bold;"></label></td>
                                                                        </tr>
                                                                        <tr class="fl_class info_direct_ref">
                                                                            <td><label class="info_lbl">Payment Term</label></td>
                                                                            <td><label class="info_lbl" id="info_payment_term" style="font-weight: bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label class="info_lbl">Remark</label></td>
                                                                            <td><label class="info_lbl" id="info_remark" style="font-weight: bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label class="info_lbl">Is Price Visible</label></td>
                                                                            <td><label class="info_lbl" id="info_price_column_vis" style="font-weight: bold;"></label></td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mt-1 mb-1 allinfo">
                                                    <div class="card shadow-none border m-0">
                                                        <div class="card-body">
                                                            <h6 class="card-title mb-0"><i class="fas fa-user"></i> Customer Information</h6>
                                                            <hr class="my-50">
                                                            <div class="row">
                                                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                                                    <table class="infotbl" style="width:100%;font-size:12px;">
                                                                        <tr>
                                                                            <td><label class="info_lbl" title="Customer Name">Name</label></td>
                                                                            <td><label class="info_lbl" id="info_customer_name" style="font-weight: bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label class="info_lbl" title="Customer Code">Code</label></td>
                                                                            <td><label class="info_lbl" id="info_customer_code" style="font-weight: bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label class="info_lbl" title="Customer Category">Category</label></td>
                                                                            <td><label class="info_lbl" id="info_customer_category" style="font-weight: bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label class="info_lbl" title="Taxpayer Identification Number">TIN</label></td>
                                                                            <td><label class="info_lbl" id="info_tin" style="font-weight: bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label class="info_lbl" title="Vat Registration Number">VAT No.</label></td>
                                                                            <td><label class="info_lbl" id="info_vat_no" style="font-weight: bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label class="info_lbl" title="Customer Phone Number">Customer Phone No.</label></td>
                                                                            <td><label class="info_lbl" id="info_customer_phone" style="font-weight: bold;"></label></td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                                                    <table class="infotbl" style="width:100%;font-size:12px;">
                                                                        <tr>
                                                                            <td><label class="info_lbl">Deliver By</label></td>
                                                                            <td><label class="info_lbl" id="info_delivery_by" style="font-weight: bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label class="info_lbl" title="Phone Number">Phone No.</label></td>
                                                                            <td><label class="info_lbl" id="info_phone_no" style="font-weight: bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label class="info_lbl">ID No.</label></td>
                                                                            <td><label class="info_lbl" id="info_id_no" style="font-weight: bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label class="info_lbl">Plate No.</label></td>
                                                                            <td><label class="info_lbl" id="info_plate_no" style="font-weight: bold;"></label></td>
                                                                        </tr>
                                                                    </table>
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
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="tab-pane do_info_tab tab-view" id="info-do-view" role="tabpanel" aria-labelledby="info-do-view">
                                        <ul class="nav nav-tabs nav-fill" role="tablist">
                                            <li class="nav-item formnavitm note">
                                                <a class="nav-link active do-tabs tab-title active-tab-title" id="info_do_item_tab" data-toggle="tab" href="#info_do_item_view" aria-controls="info_do_item_tab" role="tab" aria-selected="true" title="Items"><i class="fas fa-list-ul"></i><span class="tab-text">Items</span></a>                                
                                            </li>
                                            <li class="nav-item formnavitm note">
                                                <a class="nav-link do-tabs tab-title" id="info_do_doc_tab" data-toggle="tab" href="#info_do_doc_view" aria-controls="info_do_doc_tab" role="tab" aria-selected="true" title="Documents"><i class="fas fa-file-alt"></i><span class="tab-text">Documents</span></a>                                
                                            </li>
                                        </ul>
                                        <div class="tab-content formtabcon" style="margin-top:-14px;">
                                            <div class="tab-pane do-view active tab-view active-tab-view border" id="info_do_item_view" aria-labelledby="info_do_item_view" role="tabpanel">
                                                <div class="row mt-0 mr-1 ml-1 mb-1">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <div class="table-responsive scroll scrdiv">
                                                            <div class="row infoRecDiv" id="do_item_div">
                                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                    <table id="doInfoDataTbl" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable" style="width: 100%">
                                                                        <thead>
                                                                            <tr>
                                                                                <th style="display:none;"></th>
                                                                                <th style="width:2%"></th>
                                                                                <th style="width:3%;">#</th>
                                                                                <th style="width:10%;">Item Code</th>
                                                                                <th style="width:20%;">Item Name</th>
                                                                                <th style="width:10%;" title="Barcode Number">Barcode No.</th>
                                                                                <th style="width:8%;" title="Unit of Measurement">UOM</th>
                                                                                <th style="width:8%;">Quantity</th>
                                                                                <th style="width:10%;">Unit Price</th>
                                                                                <th style="width:10%;">Total Price</th>
                                                                                <th style="width:16%;">Remark</th>
                                                                                <th style="width:3%"></th>
                                                                                <th style="display:none;"></th>
                                                                                <th style="display:none;"></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody class="table table-sm"></tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <div class="row fl_class pricing_flag" style="display: none;">
                                                                <div class="col-xl-10 col-lg-9 col-md-8 col-sm-6 col-12"></div>
                                                                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12 mt-1" style="text-align: right;">
                                                                    <table style="width: 100%;font-size:12px" class="rtable">
                                                                        <tr>
                                                                            <td style="text-align: right;width:50%;">
                                                                                <label class="info_lbl">Grand Total</label>
                                                                            </td>
                                                                            <td style="text-align: center;width:50%;">
                                                                                <label id="info_total_price" class="info_lbl info_total_price" style="font-weight: bold;"></label>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane do-view tab-view border" id="info_do_doc_view" aria-labelledby="info_do_doc_view" role="tabpanel">
                                                <div class="row mt-0 mr-1 ml-1 mb-1">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <table id="info-document-datatable" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable mb-0 info_datatable" style="width: 100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th style="display: none;"></th>
                                                                    <th style="width:3%;">#</th>
                                                                    <th style="width:13%;">Type</th>
                                                                    <th style="width:10%;">Date</th>
                                                                    <th style="width:40%;">Document</th>
                                                                    <th style="width:24%;">Remark</th>
                                                                    <th style="width:10%;">Status</th>
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
                                        <button type="button" class="btn btn-outline-info dropdown-toggle hide-arrow action-btn form_btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa-sharp fa-solid fa-caret-up fa-xl"></i><span class="btn-text">&nbsp Actions</span>
                                        </button>
                                        <ul class="dropdown-menu" id="do_action_ul"></ul>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align:right">
                                    <input type="hidden" class="form-control" name="dstockin_type_inp" id="dstockin_type_inp" readonly="true">
                                    <input type="hidden" class="form-control" name="dstockinid" id="dstockinid" readonly="true">
                                    <input type="hidden" class="form-control" name="recId" id="recId" readonly="true">
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

    <div class="modal fade text-left fit-content" id="inlineForm" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title form_title" id="delivery_order_title"></h4>
                    <div class="row">
                        <div style="text-align: right;" class="form_title" id="delivery_order_status"></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>  
                </div>
                <form id="Register">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-8 col-lg-6 col-md-12 col-sm-12 col-12 mb-1"> 
                                <fieldset class="fset">
                                    <legend>General Data</legend>
                                    <div class="row">
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                                            <label class="form_lbl">Reference Type<b style="color: red; font-size:16px;">*</b></label>
                                            <select class="select2 form-control" name="ReferenceType" id="ReferenceType">
                                                @foreach ($ref_type_data as $reftype)
                                                    <option value="{{ $reftype->id }}">{{ $reftype->LookupName }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">
                                                <strong id="reference-type-error" class="errordatalabel"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-6 col-lg-12 col-md-6 col-sm-6 col-12 mb-1 reference_doc default_hidden_div" id="reference_doc_div">
                                            <label class="form_lbl" title="Reference Document">Reference<b style="color: red; font-size:16px;">*</b></label>
                                            <div class="row">
                                                <div class="col-xl-11 col-lg-11 col-md-11 col-sm-11 col-11 mr-0 pr-0">
                                                    <select class="select2 form-control" name="Reference" id="Reference"></select>
                                                </div>
                                                <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-1 ml-0 mr-0 pr-0" style="display: flex;align-items: center;justify-content: left;">
                                                    <a id="show_reference" href="javascript:void(0)" class="show_reference" onclick="openReferenceDocFn()" title="Open reference document">
                                                       <i class="fas fa-info fa-lg" style="color: #00cfe8;"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <span class="text-danger">
                                                <strong id="reference-doc-error" class="errordatalabel"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-1" id="product_type_div">
                                            <label class="form_lbl">Product Type<b style="color: red; font-size:16px;">*</b></label>
                                            <select class="select2 form-control" name="ProductType" id="ProductType" onchange="productTypeFn()"></select>
                                            <span class="text-danger">
                                                <strong id="product-type-error" class="errordatalabel"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                                            <label class="form_lbl">Station<b style="color: red; font-size:16px;">*</b></label>
                                            <select class="select2 form-control" name="station" id="station"></select>
                                            <span class="text-danger">
                                                <strong id="station-error" class="errordatalabel"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                                            <label class="form_lbl">Delivery Date<b style="color: red; font-size:16px;">*</b></label>
                                            <input type="text" id="DeliveryDate" name="DeliveryDate" class="form-control flatpickr-basicl reg_form" placeholder="YYYY-MM-DD" onchange="deliveryDateFn()"/>
                                            <span class="text-danger">
                                                <strong id="delivery-date-error" class="errordatalabel"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                                            <label class="form_lbl">Expiry Date<b style="color: red; font-size:16px;">*</b></label>
                                            <input type="text" id="ExpiryDate" name="ExpiryDate" class="form-control flatpickr-basicl reg_form" placeholder="YYYY-MM-DD" onchange="expiryDateFn()"/>
                                            <span class="text-danger">
                                                <strong id="expiry-date-error" class="errordatalabel"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                                            <label class="form_lbl">Order By<b style="color: red; font-size:16px;">*</b></label>
                                            <select class="select2 form-control" name="OrderedBy" id="OrderedBy" onchange="orderedByFn()">
                                                @foreach ($uses_data as $orderby)
                                                    <option value="{{ $orderby->username }}">{{ $orderby->username }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">
                                                <strong id="orderby-error" class="errordatalabel"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                                            <label class="form_lbl">Sales Person<b style="color: red; font-size:16px;">*</b></label>
                                            <select class="select2 form-control" name="SalesPerson" id="SalesPerson" onchange="salesPersonFn()"></select>
                                            <span class="text-danger">
                                                <strong id="sales-person-error" class="errordatalabel"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-1" id="document_no_div">
                                            <label class="form_lbl" title="Document Number">Document No.</label>
                                            <input type="text" name="DocumentNumber" id="DocumentNumber" placeholder="Enter document number here" class="form-control reg_form" onkeyup="docNumberFn()"/>
                                            <span class="text-danger">
                                                <strong id="docnumber-error" class="errordatalabel"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-1 direct-reference" style="display: none;">
                                            <label class="form_lbl">Payment Type<b style="color: red; font-size:16px;">*</b></label>
                                            <select class="select2 form-control" name="PaymentType" id="PaymentType" onchange="paymentTypeFn()">
                                                <option value="Cash">Cash</option>
                                                <option value="Credit">Credit</option>
                                            </select>
                                            <span class="text-danger">
                                                <strong id="paymentType-error" class="errordatalabel"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-1 direct-reference" style="display: none;">
                                            <label class="form_lbl">Payment Term<b style="color: red; font-size:16px;">*</b></label>
                                            <select class="select2 form-control" name="PaymentTerm" id="PaymentTerm" onchange="PaymentTermFn()">
                                                <option selected disabled value=""></option>
                                                <option value="1">1 Month</option>
                                                <option value="2">2 Month</option>
                                            </select>
                                            <span class="text-danger">
                                                <strong id="paymentTerm-error" class="errordatalabel"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                                            <label class="form_lbl">Remark</label>
                                            <textarea type="text" placeholder="Enter remark here" class="form-control reg_form" name="Remark" id="Remark" rows="1" onkeyup="remarkFn()"></textarea>
                                            <span class="text-danger">
                                                <strong id="remark-error" class="errordatalabel"></strong>
                                            </span>
                                        </div>

                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-1" id="do_cost_visibility">
                                            <div class="form-check form-check-inline">
                                                <div class="custom-control custom-control-primary custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="VisiblePrice" name="VisiblePrice"/>
                                                    <label class="custom-control-label form_lbl" for="VisiblePrice">Show Price Columns</label>                                  
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>

                            <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12 mb-1">
                                <fieldset class="fset">
                                    <legend>Customer Data</legend>
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                                            <label class="form_lbl">Customer<b style="color: red; font-size:16px;">*</b></label>
                                            <select class="select2 form-control" name="customer" id="customer" onchange="customerFn()">
                                            </select>
                                            <span class="text-danger">
                                                <strong id="customer-error" class="errordatalabel"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                                            <label class="form_lbl">Deliver By</label>
                                            <input type="text" placeholder="Enter deliver by here" class="form-control reg_form" name="DeliverBy" id="DeliverBy" onkeyup="deliverByFn()"/>
                                            <span class="text-danger">
                                                <strong id="deliverby-error" class="errordatalabel"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                                            <label class="form_lbl" title="Phone Number">Phone No.</label>
                                            <input type="tel" placeholder="+251-XXX-XX-XX-XX" class="form-control reg_form phone_number" name="PhoneNumber" id="PhoneNumber" onkeyup="phoneNoFn()"/>
                                            <span class="text-danger">
                                                <strong id="phone-no-error" class="errordatalabel"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                                            <label class="form_lbl">ID No.</label>
                                            <input type="text" placeholder="Enter ID number here" class="form-control reg_form" name="IdNumber" id="IdNumber" onkeyup="idNumberFn()"/>
                                            <span class="text-danger">
                                                <strong id="id-no-error" class="errordatalabel"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-6 col-lg-12 col-md-6 col-sm-6 col-12 mb-1">
                                            <label class="form_lbl" title="Plate Number">Plate No.</label>
                                            <input type="text" name="PlateNumber" id="PlateNumber" placeholder="Enter plate number here" class="form-control reg_form" onkeyup="plateNumFn()" style="text-transform:uppercase"/>
                                            <span class="text-danger">
                                                <strong id="platenum-error" class="errordatalabel"></strong>
                                            </span>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <hr class="my-30"/>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="tab-pane do_form_tab tab-view" id="form-do-view" role="tabpanel" aria-labelledby="form-do-view">
                                    <ul class="nav nav-tabs nav-fill" role="tablist">
                                        <li class="nav-item formnavitm note">
                                            <a class="nav-link active do-form-tabs form-tab-title active-tab-title" id="form_do_actual_tab" data-toggle="tab" href="#form_do_actual_view" aria-controls="form_do_actual_tab" role="tab" aria-selected="true" title="Actual"><i class="fas fa-database"></i><span class="tab-text">Actual</span></a>                                
                                        </li>
                                        <li class="nav-item formnavitm note">
                                            <a class="nav-link do-form-tabs form-tab-title" id="form_do_standard_tab" data-toggle="tab" href="#form_do_standard_view" aria-controls="form_do_standard_tab" role="tab" aria-selected="true" title="Standard"><i class="fas fa-clipboard"></i><span class="tab-text">Standard</span></a>                                
                                        </li>
                                    </ul>
                                    <div class="tab-content formtabcon" style="margin-top:-14px;">
                                        <div class="tab-pane do-form-view active form-tab-view active-form-tab-view border" id="form_do_actual_view" aria-labelledby="form_do_actual_view" role="tabpanel">
                                            <div class="row mt-1 pr-1 pl-1 pb-1">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <div class="table-responsive pr-0 pl-0" style="width: 100%;overflow-x: auto;-webkit-overflow-scrolling: touch;margin: 0 0rem;padding: 0 1rem;">
                                                        <table id="dynamicTable" class="mb-0 rtable fit-content" style="width:100%;">
                                                            <thead>
                                                                <th style="width:3%;">#</th>
                                                                <th style="width:14%;">Item Name<b style="color: red; font-size:16px;">*</b></th>
                                                                <th style="width:8%;" title="Unit of Measurement">UOM</th>
                                                                <th style="width:10%;" class="direct_reference" title="Quantity on Hand">Qty. on Hand</th>
                                                                <th style="width:10%;" class="non_direct_reference" title="Ordered Quantity">Ordered Qty.</th>
                                                                <th style="width:10%;" class="non_direct_reference" title="Remaining Quantity">Remaining Qty.</th>
                                                                <th style="width:10%;" title="Delivery Quantity">Delivery Qty.<b style="color: red; font-size:16px;">*</b></th>
                                                                <th style="width:9%;" class="pricing_column">Unit Price<b style="color: red; font-size:16px;">*</b></th>
                                                                <th style="width:9%;" class="pricing_column">Total Price</th>
                                                                <th style="width:12%;">Remark</th>
                                                                <th style="width:5%;"></th>
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
                                                <div class="col-xl-10 col-lg-9 col-md-8 col-sm-6 col-12"></div>
                                                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12" style="text-align: right;">
                                                    <table style="width:100%;" id="pricingTable" class="rtable pricing_column">
                                                        <tr style="display: none;">
                                                            <td style="text-align: right;width:45%">
                                                                <label id="subGrandTotalLbl" class="form_lbl">Sub Total</label>
                                                            </td>
                                                            <td style="text-align: center; width:55%">
                                                                <label id="subtotalLbl" class="formattedNum form_lbl form_reset_cls" style="font-weight: bold;"></label>
                                                            </td>
                                                        </tr>
                                                        <tr style="display: none;">
                                                            <td style="text-align: right;">
                                                                <label class="form_lbl" id="pricing_tbl_tax">Tax</label>
                                                            </td>
                                                            <td style="text-align: center;">
                                                                <label id="taxLbl" class="formattedNum form_lbl form_reset_cls" style="font-weight: bold;"></label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align: right;width:50%">
                                                                <label class="form_lbl">Grand Total</label>
                                                            </td>
                                                            <td style="text-align: center;width:50%">
                                                                <label id="grandtotalLbl" class="formattedNum form_lbl form_reset_cls" style="font-weight: bold;"></label>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane do-form-view form-tab-view border" id="form_do_standard_view" aria-labelledby="form_do_standard_view" role="tabpanel">
                                            <div class="row mt-1 pr-1 pl-1 pb-1">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <div class="table-responsive pr-0 pl-0" style="width: 100%;overflow-x: auto;-webkit-overflow-scrolling: touch;margin: 0 0rem;padding: 0 1rem;">
                                                        <table id="stdDynamicTable" class="mb-0 rtable fit-content" style="width:100%;">
                                                            <thead>
                                                                <th style="width:2%;">#</th>
                                                                <th style="width:16%;">Item Name<b style="color: red; font-size:16px;">*</b></th>
                                                                <th style="width:11%;" title="Quantity on Hand">Qty. on Hand</th>
                                                                <th style="width:8%;" title="Factor">Factor</th>
                                                                <th style="width:12%;" title="Quantity per PCs">Qty. per PCs</th>
                                                                <th style="width:12%;" title="Standard KG">Standard KG</th>
                                                                <th style="width:11%;" class="pricing_column">Price per KG<b style="color: red; font-size:16px;">*</b></th>
                                                                <th style="width:11%;" class="pricing_column">Total Price</th>
                                                                <th style="width:14%;">Remark</th>
                                                                <th style="width:3%;"></th>
                                                            </thead>
                                                            <tbody></tbody>
                                                        </table>
                                                        <table style="width:100%">
                                                            <tr>
                                                                <td>
                                                                    <button type="button" name="std-adds" id="std-adds" class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i> Add New</button>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="col-xl-10 col-lg-9 col-md-8 col-sm-6 col-12"></div>
                                                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12" style="text-align: right;">
                                                    <table style="width:100%;" id="stdPricingTable" class="rtable pricing_column">
                                                        <tr style="display: none;">
                                                            <td style="text-align: right;width:45%">
                                                                <label id="stdSubGrandTotalLbl" class="form_lbl">Sub Total</label>
                                                            </td>
                                                            <td style="text-align: center; width:55%">
                                                                <label id="stdSubtotalLbl" class="formattedNum form_lbl form_reset_cls" style="font-weight: bold;"></label>
                                                            </td>
                                                        </tr>
                                                        <tr style="display: none;">
                                                            <td style="text-align: right;">
                                                                <label class="form_lbl" id="std_pricing_tbl_tax">Tax</label>
                                                            </td>
                                                            <td style="text-align: center;">
                                                                <label id="std_taxLbl" class="formattedNum form_lbl form_reset_cls" style="font-weight: bold;"></label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align: right;width:50%">
                                                                <label class="form_lbl">Grand Total</label>
                                                            </td>
                                                            <td style="text-align: center;width:50%">
                                                                <label id="std_grandtotalLbl" class="formattedNum form_lbl form_reset_cls" style="font-weight: bold;"></label>
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
                    </div>
                    <div class="modal-footer">
                        <div style="display: none;">
                            <select class="select2 form-control" name="default_customer" id="default_customer">
                                @foreach ($customer_src as $customer_src)
                                    <option value="{{ $customer_src->id }}">{{ $customer_src->customer }}</option>
                                @endforeach
                            </select>
                            <select class="select2 form-control" name="default_station" id="default_station">
                                @foreach ($station_src as $default_st)
                                    <option value="{{ $default_st->id }}">{{ $default_st->Name }}</option>
                                @endforeach
                            </select>
                            <select class="select2 form-control" name="DefaultSalesPerson" id="DefaultSalesPerson">
                                @foreach ($uses_data as $salesperson)
                                    <option value="{{ $salesperson->username }}">{{ $salesperson->username }}</option>
                                @endforeach
                            </select>
                            <select class="select2 form-control" name="item_default" id="item_default">
                                <option selected disabled value=""></option>
                                @foreach ($itemSrcs as $itm)
                                    <option data-type="{{ $itm->Type }}" value="{{ $itm->id }}">{{ $itm->items }}</option>
                                @endforeach 
                            </select>
                            <select class="select2 form-control" name="reference_item_default" id="reference_item_default">
                                <option selected disabled value=""></option>
                            </select>
                        </div>
                        <input type="hidden" class="form-control reg_form" name="recordId" id="recordId" readonly="true"/>
                        <input type="hidden" class="form-control reg_form" name="operationtypes" id="operationtypes" readonly="true" value="1"/>
                        <button id="savebutton" type="button" class="btn btn-info">Save</button>
                        <button id="closebutton" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--Start Void modal -->
    <div class="modal fade text-left fit-content" id="voidDOModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="voidreasonmodal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="void-title">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="voidDOForm">
                    @csrf
                    <div class="modal-body">
                        <label class="form_lbl">Reason</label>
                        <textarea type="text" placeholder="Enter reason here" class="form-control Reason" rows="3" name="Reason" id="Reason" onkeyup="voidReasonFn()"></textarea>
                        <span class="text-danger">
                            <strong id="void-error"></strong>
                        </span>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control voidid" name="voidid" id="voidid" readonly="true">
                        <input type="hidden" class="form-control vstatus" name="vstatus" id="vstatus" readonly="true">
                        <button id="voiddobtn" type="button" class="btn btn-info">Void</button>
                        <button id="closebuttonvoid" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Void modal -->

    <!--Start backward action modal -->
    <div class="modal fade text-left fit-content" id="backwardActionModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="backwardActionModal" aria-hidden="true">
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
                            <textarea type="text" placeholder="Enter reason here" class="form-control" rows="3" name="CommentOrReason" id="CommentOrReason" onkeyup="backwardReasonFn()"></textarea>
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

    <!-- start manage document modal-->
    <div class="modal modal-slide-in event-sidebar fade fit-content" id="manageDocumentModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="manageDocumentModal" aria-hidden="true">
        <form id="ManageDocumentForm">    
            <div class="modal-dialog sidebar-xl" style="width: 95%;">
                <div class="modal-content p-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #ea5455 !important;font-weight:bold;">x</button>
                    <div class="modal-header mb-1">
                        <h5 class="modal-title form_title" id="manage-document-title">Manage Documents</h5>
                        <div class="info_modal_title_lbl info_modal_title_lbl" style="text-align: center;padding-right:30px;"></div>
                    </div>
                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3 scrdivhor scrollhor" style="overflow-y:auto;height:100vh;">
                        <div class="row mr-1 ml-1">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="width: 100%;overflow-x: auto;-webkit-overflow-scrolling: touch;margin: 0 -1rem;padding: 0 1rem;">
                                <table id="documentDynamicTable" class="mt-0 rtable form_dynamic_table" style="width: 100%;min-width: 900px;">
                                    <thead>
                                        <tr style="text-align:center;">
                                            <th style="width:3%;">#</th>
                                            <th style="width:20%;">Type</th>
                                            <th style="width:20%;">Date</th>
                                            <th style="width:20%;">Document</th>
                                            <th style="width:20%;">Remark</th>
                                            <th style="width:14%;">Status</th>
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
                    <div class="modal-footer">
                        <div style="display: none;">
                            <select class="select2 form-control" name="DocumentTypeDefault" id="DocumentTypeDefault">
                                <option selected disabled value=""></option>
                                @foreach ($doc_type_data as $doc_type)
                                    <option value="{{ $doc_type->id }}">{{ $doc_type->LookupName }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" class="form-control" name="uploadRecordDocId" id="uploadRecordDocId" readonly="true">
                        </div>
                        <button id="uploadDocButton" type="submit" class="btn btn-info form_btn">Upload</button>
                        <button id="closebutton-doc" type="button" class="btn btn-danger form_btn" data-dismiss="modal">Close</button> 
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!--/ end manage document modal-->

    @include('layout.universal-component')

    @include('parts.batch_serial_out')

    <script type="text/javascript">
        var errorcolor = "#ffcccc";
        var fyears = $('#fiscalyearval').val();
        var current_date = $('#currentdateval').val();
        var table = "";
        var detail_table = "";
        var gblIndex = -1;
        var infoTblIndex = -1;
        var i = 0;
        var m = 0;
        var j = 0;

        var i1 = 0;
        var m1 = 0;
        var j1 = 0;

        var x3 = 0;
        var y3 = 0;
        var z3 = 0;
        var expand_flag = [];

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

        $(document).ready(async function() {
            await getDODataFn(fyears);
            countDOStatusFn(fyears);
        });

        function getDODataFn(fy){
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
                dom: "<'row'<'col-sm-3 col-md-2 col-6'f><'col-sm-3 col-md-2 col-6 mt-1 custom-1'><'col-sm-3 col-md-2 col-6 mt-1 custom-2'><'col-sm-3 col-md-2 col-6 mt-1 custom-3'><'col-sm-3 col-md-2 col-6 mt-1 custom-4'><'col-sm-3 col-md-2 col-6 mt-1 custom-5'>>" +
                    "<'row'<'col-sm-12 margin_top_class'tr>>" +
                    "<'row'<'col-sm-4 col-md-4 col-4'l><'col-sm-4 col-md-4 col-4 d-flex justify-content-center'i><'col-sm-4 col-md-4 col-4 d-flex justify-content-end'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/showDOData/' + fy,
                    type: 'POST',
                    beforeSend: function() {
                       blockPage(cardSection,'Loading delivery order data...');
                    },
                    complete: function () { 
                        setFocus('#laravel-datatable-crud');
                        $('#laravel-datatable-crud').DataTable().columns.adjust();
                    },
                    error: function () { 
                        unblockPage(cardSection);
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
                        data: 'document_number',
                        name: 'document_number',
                        width:"12%"
                    },
                    {
                        data: 'reference_types',
                        name: 'reference_types',
                        width:"11%"
                    },
                    {
                        data: 'reference_no',
                        name: 'reference_no',
                        "render": function ( data, type, row, meta ) {
                            return `<a style="text-decoration:underline;color:blue;" onclick=openReferenceDocLinkFn("${row.reference_type}","${row.id}")>${row.reference_type != 600 ? data : ""}</a>`;
                        },
                        width:"11%"
                    },
                    {
                        data: 'product_type',
                        name: 'product_type',
                        width:"8%"
                    },
                    {
                        data: 'customer_name',
                        name: 'customer_name',
                        width:"14%"
                    },
                    {
                        data: 'TIN',
                        name: 'TIN',
                        width:"8%"
                    },
                    {
                        data: 'store_name',
                        name: 'store_name',
                        width:"11%"
                    },
                    {
                        data: 'delivery_date',
                        name: 'delivery_date',
                        width:"10%"
                    },
                    {
                        data: 'status',
                        name: 'status',
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
                            return `<div class="text-center"><a class="doInfo" href="javascript:void(0)" onclick="doInfoFn(${row.id})" data-id="doInfo${row.id}" id="doInfo${row.id}" title="Open information form"><i class="fa-sharp fa-regular fa-circle-info fa-xl" style="color: #00cfe8;"></i></a></div>`;
                        },
                        width:"4%",
                    },
                    { 
                        data: 'reference_type', 
                        name: 'reference_type',
                        "render": function ( data, type, row, meta ) {
                            return "";
                        },
                        'visible': false //12
                    },
                    { 
                        data: 'station', 
                        name: 'station',
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
                "initComplete": function(settings, json) {
                    unblockPage(cardSection);
                },
                drawCallback: function () { 
                    this.api().columns().every(function() {
                        var column = this;
                        var header = $(column.header()).text().trim();
                        
                        $(column.nodes()).each(function() {
                            $(this).attr('data-title', header);
                        });
                    });
                    $('#laravel-datatable-crud').DataTable().columns.adjust();
                    unblockPage(cardSection);
                },     
                fixedHeader: {
                    header: true,
                    headerOffset: $('.header-navbar').outerHeight(),
                },
            });

            appendDOFilterFn(fy);
        }

        function appendDOFilterFn(fyears){
            var do_fiscalyear = $(`
                <select class="selectpicker form-control dropdownclass" id="do_fy" name="do_fy[]" title="Select fiscal year here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" data-actions-box="true" data-selected-text-format="count" data-count-selected-text="Fiscal Year ({0})">
                    @foreach ($fiscalyears as $dofy)
                        <option value="{{ $dofy->FiscalYear }}">{{ $dofy->Monthrange }}</option>
                    @endforeach
                </select>
            `);

            $('.custom-1').html(do_fiscalyear);
            $('#do_fy')
            .selectpicker()
            .selectpicker('val', fyears)
            .off('changed.bs.select') 
            .on('changed.bs.select',async function () {
                let fyear = $(this).val();
                countDOStatusFn(fyear);
                await getDODataFn(fyear);
            });

            var reference_type_filter = $(`
                <select class="selectpicker form-control dropdownclass" id="reference_type_filter" name="reference_type_filter[]" title="Select reference type here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" data-actions-box="true" multiple data-selected-text-format="count" data-count-selected-text="Reference Type ({0})">
                    @foreach ($ref_type_data as $reftype_filter)
                        <option selected value="{{ $reftype_filter->id }}">{{ $reftype_filter->LookupName }}</option>
                    @endforeach
                </select>
            `);

            $('.custom-2').html(reference_type_filter);
            $("#reference_type_filter").selectpicker('selectAll');
            $('#reference_type_filter')
            .selectpicker()
            .off('changed.bs.select') 
            .on('changed.bs.select', function () {  
                var selected = $('#reference_type_filter option:selected');
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

            var product_type_filter = $(`
                <select class="selectpicker form-control dropdownclass" id="product_type_filter" name="product_type_filter[]" title="Select product type here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" data-actions-box="true" multiple data-selected-text-format="count" data-count-selected-text="Product Type ({0})">
                    <option selected value="Goods">Goods</option>
                    <option selected value="Commodity">Commodity</option>
                    <option selected value="Metal">Metal</option>
                </select>
            `);

            $('.custom-3').html(product_type_filter);
            $('#product_type_filter')
            .selectpicker()
            .off('changed.bs.select') 
            .on('changed.bs.select', function () {  
                var selected = $('#product_type_filter option:selected');
                var search = [];

                // Collect selected option values
                $.each(selected, function() {
                    search.push($(this).val());
                });

                if (search.length === 0) {
                    // No option selected: force DataTable to return no data
                    table.column(5).search('^$', true, false).draw(); // Match an impossible pattern
                } else {
                    // Options selected: build regex for filtering
                    var searchRegex = search.join('|'); // OR-separated values for regex
                    table.column(5).search(searchRegex, true, false).draw();
                }
            });

            var store_filter = $(`
                <select class="selectpicker form-control dropdownclass" id="do_store_filter" name="do_store_filter[]" title="Select station here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" data-actions-box="true" multiple data-selected-text-format="count" data-count-selected-text="Station ({0})">
                    @foreach ($station_src as $station_filter)
                        <option selected value="{{ $station_filter->id }}">{{ $station_filter->Name }}</option>
                    @endforeach
                </select>
            `);

            $('.custom-4').html(store_filter);
            $('#do_store_filter')
            .selectpicker()
            .off('changed.bs.select') 
            .on('changed.bs.select', function () {  
                var selected = $('#do_store_filter option:selected');
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
                <select class="selectpicker form-control dropdownclass" id="do_status_filter" name="do_status_filter[]" title="Select status here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" data-actions-box="true" multiple data-selected-text-format="count" data-count-selected-text="Status ({0})">
                    <option selected value="Draft">Draft</option>
                    <option selected value="Pending">Pending</option>
                    <option selected value="Verified">Verified</option>
                    <option selected value="Approved">Approved</option>
                    <option selected value="Void">Void</option>
                </select>
            `);

            $('.custom-5').html(status_filter);
            $('#do_status_filter')
            .selectpicker()
            .off('changed.bs.select') 
            .on('changed.bs.select', function () {  
                var selected = $('#do_status_filter option:selected');
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

        $('#laravel-datatable-crud tbody').on('click', 'tr', function () {
            $('#laravel-datatable-crud tbody > tr').removeClass('selected');
            $(this).addClass('selected');
            gblIndex = $(this).index();
        });

        function setFocus(targetTable) {
            $($(targetTable + ' tbody > tr')[gblIndex]).addClass('selected');
        }

        $("#addDeliveryOrder").click(function() {
            resetDOFormFn();
            $("#delivery_order_title").html('Add Delivery Order');
            $('#savebutton').text('Save');
            $('#savebutton').prop("disabled",false);
            $("#inlineForm").modal('show');
        });

        $("#savebutton").click(function() {
            var optype = $("#operationtypes").val();
            var arr = [];
            var found = 0;
            var progress_text = "";
            $('.itemName').each(function() {
                var name = $(this).val();
                if (arr.includes(name)) {
                    found++;
                } else {
                    arr.push(name);
                }
            });

            if(found){
                if(parseInt(optype) == 1){
                    $('#savebutton').text('Save');
                    $('#savebutton').prop("disabled", false);
                }
                else if(parseInt(optype) == 2){
                    $('#savebutton').text('Update');
                    $('#savebutton').prop("disabled", false);
                }
                toastrMessage('error',"There is duplicate item found in the list","Error");
            }
            else{
                var registerForm = $("#Register");
                var formData = registerForm.serialize();
                $.ajax({
                    url: '/saveDeliveryOrder',
                    type: 'POST',
                    data: formData,
                    beforeSend: function() { 
                        if(parseInt(optype) == 1){
                            $('#savebutton').text('Saving...');
                            $('#savebutton').prop("disabled", true);
                            progress_text = "Saving delivery order...";
                        }
                        else if(parseInt(optype) == 2){
                            $('#savebutton').text('Updating...');
                            $('#savebutton').prop("disabled", true);
                            progress_text = "Updating delivery order...";
                        }

                        blockPage(cardSection,progress_text);
                    },
                    success: async function(data) {
                        await saveDeliveryOrderFn(data);
                    },
                    error: function () { 
                        unblockPage(cardSection);     
                    },
                });
            }
        });

        function saveDeliveryOrderFn(data){
            var optype = $("#operationtypes").val();
            if(data.errors) {
                if (data.errors.ReferenceType) {
                    $('#reference-type-error').html(data.errors.ReferenceType[0]);
                }
                if (data.errors.Reference) {
                    var text = data.errors.Reference[0];
                    text = text.replace("601", "PI");
                    text = text.replace("602", "SO");
                    text = text.replace("603", "SI");
                    $('#reference-doc-error').html(text);
                }
                if (data.errors.ProductType) {
                    $('#product-type-error').html(data.errors.ProductType[0]);
                }
                if (data.errors.station) {
                    $('#station-error').html(data.errors.station[0]);
                }
                if (data.errors.DeliveryDate) {
                    $('#delivery-date-error').html(data.errors.DeliveryDate[0]);
                }
                if (data.errors.ExpiryDate) {
                    $('#expiry-date-error').html(data.errors.ExpiryDate[0]);
                }
                if (data.errors.OrderedBy) {
                    $('#orderby-error').html(data.errors.OrderedBy[0]);
                }
                if (data.errors.SalesPerson) {
                    $('#sales-person-error').html(data.errors.SalesPerson[0]);
                }
                if (data.errors.DocumentNumber) {
                    $('#docnumber-error').html(data.errors.DocumentNumber[0]);
                }
                if (data.errors.PaymentType) {
                    var text = data.errors.PaymentType[0];
                    text = text.replace("600", "direct");
                    $('#paymentType-error').html(text);
                }
                if (data.errors.PaymentTerm) {
                    var text = data.errors.PaymentTerm[0];
                    text = text.replace("600", "direct");
                    $('#paymentTerm-error').html(text);
                }
                if (data.errors.customer) {
                    $('#customer-error').html(data.errors.customer[0]);
                }

                if(parseInt(optype) == 1){
                    $('#savebutton').text('Save');
                    $('#savebutton').prop("disabled", false);
                }
                else if(parseInt(optype) == 2){
                    $('#savebutton').text('Update');
                    $('#savebutton').prop("disabled", false);
                }
                toastrMessage('error',"Check your inputs","Error");
                unblockPage(cardSection);
            }
            
            else if(data.errorv2) {
                var error_html = '';
                var selecteditemsvar = '';
                var reference_type =  $('#ReferenceType').val();
                var isChecked = $('#VisiblePrice').is(':checked');

                $('#dynamicTable > tbody > tr').each(function (index) {
                    let k = $(this).find('.vals').val();
                    var itmid = ($(`#itemNameSl${k}`)).val();

                    if(($(`#quantity${k}`).val())!=undefined){
                        var qnt = $(`#quantity${k}`).val();
                        if(isNaN(parseFloat(qnt)) || parseFloat(qnt) == 0){
                            $(`#quantity${k}`).css("background", errorcolor);
                        }
                    }
                    if(($(`#unitprice${k}`).val()) != undefined && isChecked){
                        var unit_price = $(`#unitprice${k}`).val();
                        if(isNaN(parseFloat(unit_price)) || parseFloat(unit_price) == 0){
                            $(`#unitprice${k}`).css("background", errorcolor);
                        }
                    }
                    if(isNaN(parseFloat(itmid)) || parseFloat(itmid) == 0){
                        $(`#select2-itemNameSl${k}-container`).parent().css('background-color',errorcolor);
                    }
                });

                if(parseInt(optype) == 1){
                    $('#savebutton').text('Save');
                    $('#savebutton').prop("disabled", false);
                }
                else if(parseInt(optype) == 2){
                    $('#savebutton').text('Update');
                    $('#savebutton').prop("disabled", false);
                }
                toastrMessage('error',`Please insert valid data on highlighted fields!</br>${error_html}`,"Error");
                unblockPage(cardSection);
            }
            
            else if(data.empty_table){
                if(parseInt(optype) == 1){
                    $('#savebutton').text('Save');
                    $('#savebutton').prop("disabled", false);
                }
                else if(parseInt(optype) == 2){
                    $('#savebutton').text('Update');
                    $('#savebutton').prop("disabled", false);
                }
                toastrMessage('error',"You should add atleast one item","Error");
                unblockPage(cardSection);
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
                unblockPage(cardSection);
            } 

            else if(data.dberrors) {
                if(parseInt(optype) == 1){
                    $('#savebutton').text('Save');
                    $('#savebutton').prop("disabled", false);
                }
                else if(parseInt(optype) == 2){
                    $('#savebutton').text('Update');
                    $('#savebutton').prop("disabled", false);
                }
                toastrMessage('error',"Please contact administrator","Error");
                unblockPage(cardSection);
            }

            else if(data.success) {
                toastrMessage('success',"Successful","Success");
                countDOStatusFn(data.fiscal_year);
                if(parseInt(optype) == 1){
                    refreshDTUpdateFn();
                }
                else if(parseInt(optype) == 2){
                    createDOInfoFn(data.rec_id);
                    tabMgtFn();
                    refreshMainDatatbleFn();
                }    
                $("#inlineForm").modal('hide');
            }
        }

        function fetchReferenceDataFn(){
            var reference_type = null;
            var reference_id = null;
            var ref_type = $('#ReferenceType').val();
            var block_ui_message = "";
            $.ajax({ 
                url: '/fetchReferenceData', 
                type: 'POST',
                data:{
                    reference_type:$('#ReferenceType').val(),
                    reference_id:$('#Reference').val(),
                },
                beforeSend: function() {
                    if(ref_type == 601){
                        block_ui_message = "proforma";
                    }
                    if(ref_type == 602){
                        block_ui_message = "sales order";
                    }
                    if(ref_type == 603){
                        block_ui_message = "sales invoice";
                    }
                    blockPage(cardSection, `Fetching ${block_ui_message} data...`);
                },
                success: async function(data) {
                    await getReferenceDataFn(data,ref_type);
                    unblockPage(cardSection);
                },
                error: function () { 
                    unblockPage(cardSection);
                },
            });
        }

        function getReferenceDataFn(data,ref_type){
            var expiry_date = null;
            var sales_person = null;
            var product_type = null;
            var station = null;
            var customer_option = null;
            var payment_type_option = null;
            
            if(ref_type == 601){
                $.each(data.customer_data, function(key, value) {
                    customer_option = `<option selected value="${value.id}">${value.customer}</option>`;
                });

                $.each(data.main_data, function(key, value) {
                    flatpickr('#ExpiryDate', {dateFormat: 'Y-m-d',clickOpens:false});
                    $('#ExpiryDate').val(value.expireDate);

                    station = `<option selected value="${value.store_id}">${value.station}</option>`;
                    product_type = `<option selected value="${value.product_type}">${value.product_type}</option>`;
                    sales_person = `<option selected value="${value.Username}">${value.Username}</option>`;
                });

                listReferenceItemFn(data.detail_data);
            }
            else if(ref_type == 602){
                $.each(data.customer_data, function(key, value) {
                    customer_option = `<option selected value="${value.id}">${value.customer}</option>`;
                });

                $.each(data.main_data, function(key, value) {
                    flatpickr('#ExpiryDate', {dateFormat: 'Y-m-d',clickOpens:false});
                    $('#ExpiryDate').val(value.expiredate);

                    station = `<option selected value="${value.store_id}">${value.station}</option>`;
                    product_type = `<option selected value="${value.product_type}">${value.product_type}</option>`;
                    sales_person = `<option selected value="${value.username}">${value.username}</option>`;
                });

                listReferenceItemFn(data.detail_data);
            }
            else if(ref_type == 603){
                $.each(data.customer_data, function(key, value) {
                    customer_option = `<option selected value="${value.id}">${value.customer}</option>`;
                });

                $.each(data.main_data, function(key, value) {
                    flatpickr('#ExpiryDate', { dateFormat: 'Y-m-d',clickOpens:true,minDate:current_date});
                    $('#ExpiryDate').val(value.expiredate);

                    station = `<option selected value="${value.store_id}">${value.station}</option>`;
                    product_type = `<option selected value="${value.product_type}">${value.product_type}</option>`;
                    sales_person = `<option selected value="${value.Username}">${value.Username}</option>`;
                });

                //populateReferenceItemFn(data.detail_data);
                listReferenceItemFn(data.detail_data);
            }
            
            $('#customer').empty().append(customer_option).select2({
                minimumResultsForSearch: -1
            });

            $('#ProductType').empty().append(product_type).select2({
                minimumResultsForSearch: -1
            });

            $('#SalesPerson').empty().append(sales_person).select2({
                minimumResultsForSearch: -1
            });

            $('#station').empty().append(station).select2({
                minimumResultsForSearch: -1
            });
        }

        function populateReferenceItemFn(detail_data){
            var item_options = null;
            var remaining_qty = null;
            $.each(detail_data, function(key, value) {
                remaining_qty = (parseFloat(value.Quantity || 0) - parseFloat(value.issued_qty || 0)) + parseFloat(value.issued_qty || 0);
                if(parseFloat(remaining_qty) > 0){
                    item_options += `<option value="${value.itemid}">${value.items}</option>`; 
                }
            });

            item_options += `<option selected disabled value=""></option>`;
            $('#reference_item_default').empty().append(item_options).select2();
        }

        function listReferenceItemFn(detail_data){
            j = 0;
            var item_options = null;
            var remaining_qty = null;
            $("#dynamicTable > tbody").empty();

            $.each(detail_data, function(key, value) {
                ++i;
                ++j;
                ++m;
                
                remaining_qty = parseFloat(value.Quantity || 0) - parseFloat(value.issued_qty || 0);
                if(parseFloat(remaining_qty) > 0){
                    $("#dynamicTable > tbody").append(`<tr>
                        <td style="font-weight:bold;text-align:center;width:3%">${j}</td>
                        <td style="display:none;"><input type="hidden" name="row[${m}][vals]" id="vals${m}" class="vals form-control" readonly="true" style="font-weight:bold;" value="${m}"/></td>
                        <td style="width:14%"><select id="itemNameSl${m}" class="select2 form-control itemName" onchange="itemFn(this)" name="row[${m}][ItemId]"><option selected value="${value.itemid}">${value.items}</option></select></td>
                        <td style="width:8%"><select id="uom${m}" class ="select2 form-control uom" onchange="uomFn(this)" name = "row[${m}][uom]"><option selected value="${value.uom}">${value.uom_name}</option></select></td>
                        <td style="width:10%;" class="direct_reference"><input type="text" name="row[${m}][qty_on_hand]" placeholder="Quantity on hand" id="qty_on_hand${m}" class="qty_on_hand form-control" readonly="true" style="font-weight:bold;"/></td>
                        <td style="width:10%" class="non_direct_reference"><input type="number" name="row[${m}][ordered_qty]" placeholder="Ordered quantity" id="ordered_qty${m}" class="ordered_qty form-control numeral-mask" value="${value.Quantity}" readonly="true" style="font-weight:bold;"/></td>
                        <td style="width:10%" class="non_direct_reference"><input type="number" name="row[${m}][remaining_qty]" placeholder="Remaining quantity" id="remaining_qty${m}" class="remaining_qty form-control numeral-mask" value="${remaining_qty >= 0 ? remaining_qty : 0}" readonly="true" style="font-weight:bold;"/></td>
                        <td style="width:10%"><input type="number" name="row[${m}][Quantity]" placeholder="Enter quantity here" id="quantity${m}" class="quantity form-control numeral-mask" onkeyup="CalculateTotal(this)" onkeypress="return ValidateNum(event);" ondrop="return false;" onpaste="return false;"/></td>
                        <td style="width:9%" class="pricing_column"><input type="number" name="row[${m}][UnitPrice]" placeholder="Enter unit price here" id="unitprice${m}" class="unitprice form-control numeral-mask" value="${value.UnitPrice}" onkeyup="CalculateTotal(this)" onkeypress="return ValidateNum(event);"/></td>
                        <td style="width:9%" class="pricing_column"><input type="number" name="row[${m}][TotalPrice]" placeholder="Total price" id="total${m}" class="total form-control numeral-mask" readonly="true" style="font-weight:bold;"/></td>
                        <td style="width:12%;"><input type="text" name="row[${m}][remark]" id="remark${m}" class="remark form-control" placeholder="Enter remark here"/></td>
                        <td style="width:5%;text-align:center;">
                            <a id="batch_serial_info${m}" href="javascript:void(0)" class="batch_serial_info" style="display:none;"><i class="fas fa-info-circle" style="color: #82868b;"></i></a>
                            <button type="button" id="remove_rec_item${m}" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button>
                        </td>
                    </tr>`);

                    columnMgtFn();

                    $(`#itemNameSl${m}`).select2({minimumResultsForSearch: -1});
                    $(`#uom${m}`).select2({minimumResultsForSearch: -1});
                    $(`#select2-itemNameSl${m}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                    $(`#select2-uom${m}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});

                    item_options += `<option value="${value.itemid}">${value.items}</option>`; 

                    var is_batch_req = value.RequireExpireDate == "Require-BatchNumber" || value.RequireExpireDate == "Require-Both" ? "Yes" : "No";
                    var is_expiry_req = value.RequireExpireDate == "Require-ExpireDate" || value.RequireExpireDate == "Require-Both" ? "Yes" : "No";
                    var is_serial_req = value.RequireSerialNumber == "Required" ? "Yes" : "No";

                    if(is_batch_req == "Yes" || is_expiry_req == "Yes" || is_serial_req == "Yes"){
                        $(`#batch_serial_info${m}`).attr("title",`Is Batch No. Req.: ${is_batch_req}\nIs Expiry Date Req.: ${is_expiry_req}\nIs Serial No. Req.: ${is_serial_req}`);
                        $(`#batch_serial_info${m}`).show();
                    }
                }
            });

            item_options += `<option selected disabled value=""></option>`;
            $('#reference_item_default').empty().append(item_options).select2();
            renumberRows();
            CalculateGrandTotal();
        }

        $('#ReferenceType').on('change', function() {
            var reference_type = $(this).val();
            var sales_person = null;
            $('.reference_doc').hide();
            $('.default_hidden_div').hide();
            $("#dynamicTable > tbody").empty();
            fillProductTypeDataFn(reference_type);
            $('#PaymentType').val(null).select2({placeholder: "Select payment type here",minimumResultsForSearch: -1});
            $('#PaymentTerm').val(null).select2({placeholder: "Select payment term here",minimumResultsForSearch: -1});
            $('#SalesPerson').empty().select2({placeholder: "Select sales person here"});
            if(reference_type == 600){
                $('.non_direct_reference').hide();
                $('.direct_reference').show();
                $('.unitprice').prop("readonly",false);       
                $('.pricing_inp').val("");
                $('#ExpiryDate').val("");
                $('.direct-reference').show();
                sales_person = $("#DefaultSalesPerson > option").clone();
                $('#SalesPerson').append(sales_person).val(null).select2({placeholder: "Select sales person here"});
            }
            else{
                $('.non_direct_reference').show();
                $('.direct_reference').hide();
                $('.unitprice').prop("readonly",true);
                $('#reference_doc_div').show();
                $('.direct-reference').hide();
                fetchReferenceDocFn();
            }
            CalculateGrandTotal();
            $('#reference-type-error').html("");
        });

        $('#Reference').on('change', function() {
            fetchReferenceDataFn();
            $('#reference-doc-error').html("");
            $('#product-type-error').html("");
            $('#station-error').html("");
            $('#expiry-date-error').html("");
            $('#sales-person-error').html("");
            $('#customer-error').html("");
        });

        function fetchReferenceDocFn(){
            var reference_type = null;
            $.ajax({ 
                url: '/fetchReferenceDoc', 
                type: 'POST',
                data:{
                    reference_type:$('#ReferenceType').val(),
                },
                beforeSend: function() {
                    blockPage(cardSection, 'Fetching references...');
                },  
                success: async function(data) {
                    await fetchReferenceListFn(data);
                    unblockPage(cardSection);
                },
                error: function () { 
                    unblockPage(cardSection);
                },
            });
        }

        function fetchReferenceListFn(data){
            var ref_type = $('#ReferenceType').val();
            var options = null;
            if(ref_type == 601){
                $.each(data.proforma_invoice_data, function(key, value) {
                    options += `<option value="${value.proforma_id}">${value.proforma_data}</option>`;
                });
            }
            else if(ref_type == 602){
                $.each(data.sales_order_data, function(key, value) {
                    options += `<option value="${value.sales_id}">${value.sales_data}</option>`;
                });
            }
            else if(ref_type == 603){
                $.each(data.sales_invoice_data, function(key, value) {
                    options += `<option value="${value.sales_id}">${value.sales_data}</option>`;
                });
            }

            $('#Reference').empty().append(options).val(null).select2({
                placeholder: "Select reference here"
            });
        }

        //-----Actual starts-----
        $("#adds").click(function() {
            var lastrowcount = $('#dynamicTable tr:last').find('td').eq(1).find('input').val();
            var itemids = $(`#itemNameSl${lastrowcount}`).val();
            var product_type = $("#ProductType").val();
            var reference_type = $("#ReferenceType").val();
            var station = $("#station").val();
            var options = null;

            if(itemids !== undefined && itemids === null){
                $(`#select2-itemNameSl${lastrowcount}-container`).parent().css('background-color',errorcolor);
                toastrMessage('error',"Please select item from highlighted field","Error");
            }
            else if((product_type !== undefined && (product_type == null || product_type == "")) || (station !== undefined && (station == null || station == ""))){
                if(product_type !== undefined && (product_type == null || product_type == "")){
                    $('#product-type-error').html("The product type field is required.");
                }
                if(station !== undefined && (station == null || station == "")){
                    $('#station-error').html("The station field is required.");
                }
                toastrMessage('error',"Please fill required fields first","Error");
            }
            else{
                ++i;
                ++m;
                j += 1;

                $("#dynamicTable > tbody").append(`<tr>
                    <td style="font-weight:bold;text-align:center;width:3%">${j}</td>
                    <td style="display:none;"><input type="hidden" name="row[${m}][vals]" id="vals${m}" class="vals form-control" readonly="true" style="font-weight:bold;" value="${m}"/></td>
                    <td style="width:14%"><select id="itemNameSl${m}" class="select2 form-control itemName" onchange="itemFn(this)" name="row[${m}][ItemId]"></select></td>
                    <td style="width:8%"><select id="uom${m}" class ="select2 form-control uom" onchange="uomFn(this)" name="row[${m}][uom]"></select></td>
                    <td style="width:10%;" class="direct_reference"><input type="text" name="row[${m}][qty_on_hand]" placeholder="Quantity on hand" id="qty_on_hand${m}" class="qty_on_hand form-control" readonly="true" style="font-weight:bold;"/></td>
                    <td style="width:10%" class="non_direct_reference"><input type="number" name="row[${m}][ordered_qty]" placeholder="Ordered quantity" id="ordered_qty${m}" class="ordered_qty form-control numeral-mask" readonly="true" style="font-weight:bold;"/></td>
                    <td style="width:10%" class="non_direct_reference"><input type="number" name="row[${m}][remaining_qty]" placeholder="Remaining quantity" id="remaining_qty${m}" class="remaining_qty form-control numeral-mask" readonly="true" style="font-weight:bold;"/></td>
                    <td style="width:10%"><input type="number" name="row[${m}][Quantity]" placeholder="Enter quantity here" id="quantity${m}" class="quantity form-control numeral-mask" onkeyup="CalculateTotal(this)" onkeypress="return ValidateNum(event);" ondrop="return false;" onpaste="return false;"/></td>
                    <td style="width:9%" class="pricing_column"><input type="number" name="row[${m}][UnitPrice]" placeholder="Enter unit price here" id="unitprice${m}" class="unitprice pricing_inp form-control numeral-mask" onkeyup="CalculateTotal(this)" onkeypress="return ValidateNum(event);"/></td>
                    <td style="width:9%" class="pricing_column"><input type="number" name="row[${m}][TotalPrice]" placeholder="Total price" id="total${m}" class="total pricing_inp form-control numeral-mask" readonly="true" style="font-weight:bold;"/></td>
                    <td style="width:12%;"><input type="text" name="row[${m}][remark]" id="remark${m}" class="remark form-control" placeholder="Enter remark here"/></td>
                    <td style="width:5%;text-align:center;">
                        <a id="batch_serial_info${m}" href="javascript:void(0)" class="batch_serial_info" style="display:none;"><i class="fas fa-info-circle" style="color: #82868b;"></i></a>
                        <button type="button" id="remove_rec_item${m}" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button>
                    </td>
                </tr>`);

                columnMgtFn();

                var default_option = `<option selected disabled value=""></option>`;
                if(reference_type == 600){
                    options = $("#item_default");
                    $(`#itemNameSl${m}`).append(options.find(`option[data-type="${product_type}"]`).clone());
                }
                else if(reference_type != 600){
                    options = $("#reference_item_default > option").clone();
                    $(`#itemNameSl${m}`).append(options);
                }

                $('#dynamicTable > tbody > tr').each(function(index, tr) {
                    let item_id = $(this).find('.itemName').val();
                    $(`#itemNameSl${m} option[value="${item_id}"]`).remove(); 
                });

                $(`#itemNameSl${m}`).append(default_option);
                $(`#itemNameSl${m}`).select2({
                    placeholder: "Select item here",
                });

                $(`#uom${m}`).select2({
                    placeholder: "Select UOM here",
                });

                $(`#select2-itemNameSl${m}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                $(`#select2-uom${m}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});

                renumberRows();
            }
        });

        $(document).on('click', '.remove-tr', function() {
            $(this).parents('tr').remove();
            CalculateGrandTotal();
            renumberRows();
            --i;
        });

        function renumberRows() {
            var ind;
            $('#dynamicTable > tbody > tr').each(function(index, el) {
                $(this).children('td').first().text(++index);
                ind = index;
            });
            columnMgtFn();
        }

        function itemFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            var item_id = $(`#itemNameSl${idval}`).val();
            
            var arr = [];
            var found = 0;
            $('.itemName').each(function(){ 
                var name = $(this).val();
                if(arr.includes(name)){
                    found++;
                }
                else{
                    arr.push(name);
                }
            });
            
            if(found){
                $(`#quantity${idval}`).val("");
                $(`#unitprice${idval}`).val("");
                $(`#total${idval}`).val("");
                $(`#uom${idval}`).empty().select2({minimumResultsForSearch: -1,placeholder: "Select item first"});
                $(`#select2-itemNameSl${idval}-container`).parent().css('background-color',errorcolor);
                $(`#select2-uom${idval}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                toastrMessage('error',"Item already exist in the list","Error");
                CalculateGrandTotal();
            }
            else{
                fetchItemInfoFn(idval);
                fetchUOMListFn(idval);
                calcBalanceFn(idval);
                $(`#select2-itemNameSl${idval}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
                $(`#select2-uom${idval}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
            }
        }

        function uomFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            $(`#select2-uom${idval}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
        }

        function fetchItemInfoFn(indx){
            var itemid = null;
            var reference_id = null;
            var reference_type = null;
            var ref_type = $('#ReferenceType').val() || 0;
            var itm = $(`#itemNameSl${indx}`).val() || 0;
            var record_id = null;

            $.ajax({
                url: '/fetchDOItemInfo', 
                type: 'POST',
                data:{
                    itemid: $(`#itemNameSl${indx}`).val() || 0,
                    reference_id: $('#Reference').val() || 0,
                    reference_type: ref_type,
                    record_id: $('#recordId').val() || 0,
                },
                success: function(data) {
                    $.each(data.item_info, function(key, value) {
                        var is_batch_req = value.RequireExpireDate == "Require-BatchNumber" || value.RequireExpireDate == "Require-Both" ? "Yes" : "No";
                        var is_expiry_req = value.RequireExpireDate == "Require-ExpireDate" || value.RequireExpireDate == "Require-Both" ? "Yes" : "No";
                        var is_serial_req = value.RequireSerialNumber == "Required" ? "Yes" : "No";
                        var tax_percent = 15;
                        tax_percent = tax_percent == '' || tax_percent == null ? 0 : tax_percent;

                        $(`#uom${indx}`).empty().append(`<option selected value='${value.uom}'>${value.uom_name}</option>`).select2();
                        $(`#unitprice${indx}`).val(value.UnitPrice);

                        var quantity = $(`#quantity${indx}`).val() || 0;
                        var unitprice = $(`#unitprice${indx}`).val() || 0;

                        var total = parseFloat(value.UnitPrice || 0) * parseFloat(quantity);

                        $(`#total${indx}`).val(parseFloat(total).toFixed(2));
                        CalculateGrandTotal();

                        if(is_batch_req == "Yes" || is_expiry_req == "Yes" || is_serial_req == "Yes"){
                            $(`#batch_serial_info${indx}`).attr("title",`Is Batch No. Req.: ${is_batch_req}\nIs Expiry Date Req.: ${is_expiry_req}\nIs Serial No. Req.: ${is_serial_req}`);
                            $(`#batch_serial_info${indx}`).show();
                        }

                        if(ref_type == 601){
                            $(`#ordered_qty${indx}`).val(value.Quantity);
                            var remaining_qty = (parseFloat(value.Quantity || 0) - parseFloat(value.issued_qty || 0)) + parseFloat(data.do_qty || 0);
                            remaining_qty >= 0 ? remaining_qty : 0;
                            $(`#remaining_qty${indx}`).val(remaining_qty);
                        }
                        else if(ref_type == 602){
                            $(`#ordered_qty${indx}`).val(value.Quantity);
                            var remaining_qty = (parseFloat(value.Quantity || 0) - parseFloat(value.issued_qty || 0)) + parseFloat(data.do_qty || 0);
                            remaining_qty >= 0 ? remaining_qty : 0;
                            $(`#remaining_qty${indx}`).val(remaining_qty);
                        }
                        else if(ref_type == 603){
                            $(`#ordered_qty${indx}`).val(value.Quantity);
                            var remaining_qty = (parseFloat(value.Quantity || 0) - parseFloat(value.issued_qty || 0)) + parseFloat(data.do_qty || 0);
                            remaining_qty >= 0 ? remaining_qty : 0;
                            $(`#remaining_qty${indx}`).val(remaining_qty);
                        }
                    });
                },
                error: function () {
                    unblockPage(cardSection);
                }
            });
        }

        function fetchUOMListFn(indx){
            var registerForm = $("#Register");
            var formData = registerForm.serialize();
            var itemid = $(`#itemNameSl${indx}`).val() || 0;
            $.ajax({
                url: 'getUOMS/' + itemid,
                type: 'DELETE',
                data: formData,
                success: function(data) {
                    var defname = data.defuom;
                    var defid = data.defuomid;
                    var lastcost = data.lastCost;
                    var taxper = data.taxpr;
                    var option = null;
                    $.each(data.sid, function(key, value) {
                        option += `<option value='${value.ToUomID}'>${value.ToUnitName}</option>`;
                    });

                    $(`#uom${indx}`).append(option).select2();
                },
            });
        }

        function calcBalanceFn(rowid){
            var baseRecordId = null;
            var storeval = null;
            var itemid = null;
            
            $.ajax({
                url: '/calcDOBalance', 
                type: 'POST',
                data:{
                    baseRecordId:$('#recordId').val() || 0,
                    storeval:$('#station').val(),
                    itemid:$(`#itemNameSl${rowid}`).val(),
                },
                beforeSend: function() {
                    blockPage(cardSection, 'Fetching item data...');
                },
                success: async function(data) {
                    await getBalanceFn(data,rowid);
                    unblockPage(cardSection);
                },
                error: function () {
                    unblockPage(cardSection);
                }
            });
        }

        function getBalanceFn(data,rowid){
            var net_balance = null;
            var qty = null;

            net_balance = parseFloat(data.available_qty);
            qty = $(`#quantity${rowid}`).val();
            $(`#qty_on_hand${rowid}`).val(net_balance);

            if(parseFloat(qty) > parseFloat(net_balance)){
                $(`#qty_on_hand${rowid}`).val("");
            }
        }

        $('#VisiblePrice').on('change', function() {
            showCostColumnFn();
        });

        function showCostColumnFn(){
            var reference_type = $("#ReferenceType").val(); 
            var isChecked = $('#VisiblePrice').is(':checked');
            if(isChecked){
                $('.pricing_column').show();
            }
            else{
                $('.pricing_column').hide();
            }
        }

        function columnMgtFn(){
            var reference_type = $("#ReferenceType").val(); 
            var isChecked = $('#VisiblePrice').is(':checked');

            if(reference_type == 600){
                $('.non_direct_reference').hide();
                $('.direct_reference').show();
                $('.unitprice').prop("readonly",false);
            }
            else if(reference_type != 600){
                $('.non_direct_reference').show();
                $('.direct_reference').hide();
                $('.unitprice').prop("readonly",true);
            }

            if(isChecked){
                $('.pricing_column').show();
            }
            else if(!isChecked){
                $('.pricing_column').hide();
            }
        }

        function CalculateTotal(ele) {
            var inputid = ele.getAttribute('id');
            var cid = $(ele).closest('tr').find('.vals').val();
            var unitprice = $(ele).closest('tr').find('.unitprice').val();
            var quantity = $(ele).closest('tr').find('.quantity').val();

            unitprice = unitprice == '' ? 0 : unitprice;
            quantity = quantity == '' ? 0 : quantity;
            
            if(!isNaN(unitprice) && !isNaN(quantity)) {
                var total = parseFloat(unitprice) * parseFloat(quantity);
                $(`#total${cid}`).val(parseFloat(total).toFixed(2));

                if(inputid === `unitprice${cid}`){
                    $(`#unitprice${cid}`).css("background","white");
                }
                if(inputid === `quantity${cid}`){
                    var reference_type = $("#ReferenceType").val();
                    if(reference_type == 600){
                        var qty_on_hand = $(`#qty_on_hand${cid}`).val();
                        qty_on_hand = qty_on_hand == '' ? 0 : qty_on_hand;

                        if(parseFloat(quantity) > parseFloat(qty_on_hand)){
                            $(`#quantity${cid}`).css("background",errorcolor);
                            $(`#quantity${cid}`).val("");
                            $(`#total${cid}`).val("");
                            toastrMessage('error',"Quantity exceeds available stock.","Error");
                        }
                        else{
                            $(`#quantity${cid}`).css("background","white");
                        }
                    }
                    else{
                        var remaining_qty = $(`#remaining_qty${cid}`).val();
                        remaining_qty = remaining_qty == '' ? 0 : remaining_qty;

                        if(parseFloat(quantity) > parseFloat(remaining_qty)){
                            $(`#quantity${cid}`).css("background",errorcolor);
                            $(`#quantity${cid}`).val("");
                            $(`#total${cid}`).val("");
                            toastrMessage('error',"Quantity exceeds remaining balance.","Error");
                        }
                        else{
                            $(`#quantity${cid}`).css("background","white");
                        }
                    }
                }
                if(parseFloat(total) > 0){
                    $(`#total${cid}`).css("background","#efefef");
                }
            }
            CalculateGrandTotal();
        }

        function CalculateGrandTotal() {
            var grandTotal = 0;

            $.each($('#dynamicTable').find('.total'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    grandTotal += parseFloat($(this).val());
                }
            });

            $('#grandtotalLbl').html(numformat(parseFloat(grandTotal).toFixed(2)));
        }
        //-------Actual ends-------

        //-----Standard starts-----
        $("#std-adds").click(function() {
            var lastrowcount = $('#stdDynamicTable tr:last').find('td').eq(1).find('input').val();
            var itemids = $(`#std_itemNameSl${lastrowcount}`).val();
            var product_type = $("#ProductType").val();
            var reference_type = $("#ReferenceType").val();
            var station = $("#station").val();
            var options = null;

            if(itemids !== undefined && itemids === null){
                $(`#select2-std_itemNameSl${lastrowcount}-container`).parent().css('background-color',errorcolor);
                toastrMessage('error',"Please select item from highlighted field","Error");
            }
            else if((product_type !== undefined && (product_type == null || product_type == "")) || (station !== undefined && (station == null || station == ""))){
                if(product_type !== undefined && (product_type == null || product_type == "")){
                    $('#product-type-error').html("The product type field is required.");
                }
                if(station !== undefined && (station == null || station == "")){
                    $('#station-error').html("The station field is required.");
                }
                toastrMessage('error',"Please fill required fields first","Error");
            }
            else{
                ++i1;
                ++m1;
                j1 += 1;
                
                $("#stdDynamicTable > tbody").append(`<tr>
                    <td style="font-weight:bold;text-align:center;width:2%">${j1}</td>
                    <td style="display:none;"><input type="hidden" name="stdrow[${m1}][std_vals]" id="std_vals${m1}" class="std_vals form-control" readonly="true" style="font-weight:bold;" value="${m1}"/></td>
                    <td style="width:16%"><select id="std_itemNameSl${m1}" class="select2 form-control std_itemName" onchange="itemFn(this)" name="stdrow[${m1}][ItemId]"></select></td>
                    <td style="width:11%;"><input type="text" name="stdrow[${m1}][std_qty_on_hand]" placeholder="Quantity on hand" id="std_qty_on_hand${m1}" class="std_qty_on_hand form-control" readonly="true" style="font-weight:bold;"/></td>
                    <td style="width:8%;"><input type="text" name="stdrow[${m1}][factor]" placeholder="Factor" id="factor${m1}" class="factor form-control"  style="font-weight:bold;"/></td>
                    <td style="width:12%"><input type="number" name="stdrow[${m1}][quantity_pcs]" placeholder="Enter quantity here" id="std_quantity${m1}" class="std_quantity form-control numeral-mask" onkeyup="CalculateStdTotal(this)" onkeypress="return ValidateNum(event);" ondrop="return false;" onpaste="return false;"/></td>
                    <td style="width:12%;"><input type="text" name="stdrow[${m1}][std_kg]" placeholder="Standard KG" id="standard_kg${m1}" class="standard_kg form-control" readonly="true" style="font-weight:bold;"/></td>
                    <td style="width:11%" class="pricing_column"><input type="number" name="stdrow[${m1}][std_unitprice]" placeholder="Enter price per KG here" id="std_unitprice${m1}" class="std_unitprice pricing_inp form-control numeral-mask" onkeyup="CalculateStdTotal(this)" onkeypress="return ValidateNum(event);"/></td>
                    <td style="width:11%" class="pricing_column"><input type="number" name="stdrow[${m1}][std_totalprice]" placeholder="Total price" id="std_total${m1}" class="std_total pricing_inp form-control numeral-mask" readonly="true" style="font-weight:bold;"/></td>
                    <td style="width:14%;"><input type="text" name="stdrow[${m1}][std_remark]" id="std_remark${m1}" class="remark form-control" placeholder="Enter remark here"/></td>
                    <td style="width:3%;text-align:center;">
                        <button type="button" id="std_remove_std_item${m1}" class="btn btn-light btn-sm remove-std-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button>
                    </td>
                </tr>`);

                columnMgtFn();

                var default_option = `<option selected disabled value=""></option>`;
                if(reference_type == 600){
                    options = $("#item_default");
                    $(`#std_itemNameSl${m1}`).append(options.find(`option[data-type="${product_type}"]`).clone());
                }
                else if(reference_type != 600){
                    options = $("#reference_item_default > option").clone();
                    $(`#std_itemNameSl${m1}`).append(options);
                }

                $('#stdDynamicTable > tbody > tr').each(function(index, tr) {
                    let item_id = $(this).find('.itemName').val();
                    $(`#std_itemNameSl${m1} option[value="${item_id}"]`).remove(); 
                });

                $(`#std_itemNameSl${m1}`).append(default_option);
                $(`#std_itemNameSl${m1}`).select2({
                    placeholder: "Select item here",
                });

                $(`#select2-std_itemNameSl${m1}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});

                renumberStdRows();
            }
        });

        $(document).on('click', '.remove-std-tr', function() {
            $(this).parents('tr').remove();
            CalculateStdGrandTotal();
            renumberStdRows();
            --i2;
        });

        function renumberStdRows() {
            $('#stdDynamicTable > tbody > tr').each(function(index, el) {
                $(this).children('td').first().text(++index);
            });
            columnMgtFn();
        }

        function CalculateStdTotal(ele) {
            var inputid = ele.getAttribute('id');
            var cid = $(ele).closest('tr').find('.std_vals').val();
            var unitprice = $(ele).closest('tr').find('.std_unitprice').val();
            var factor = $(ele).closest('tr').find('.factor').val();
            var quantity = $(ele).closest('tr').find('.std_quantity').val();

            unitprice = unitprice == '' ? 0 : unitprice;
            factor = factor == '' ? 0 : factor;
            quantity = quantity == '' ? 0 : quantity;
            
            if(!isNaN(unitprice) && !isNaN(factor) && !isNaN(quantity)) {
                var stadard_kg = parseFloat(factor) * parseFloat(quantity);
                var total = parseFloat(unitprice) * parseFloat(stadard_kg);
                $(`#standard_kg${cid}`).val(parseFloat(stadard_kg).toFixed(2));
                $(`#std_total${cid}`).val(parseFloat(total).toFixed(2));

                if(inputid === `std_unitprice${cid}`){
                    $(`#std_unitprice${cid}`).css("background","white");
                }
                if(inputid === `std_quantity${cid}`){
                    $(`#std_quantity${cid}`).css("background","white");
                }
            }
            CalculateStdGrandTotal();
        }

        function CalculateStdGrandTotal() {
            var grandTotal = 0;

            $.each($('#stdDynamicTable').find('.std_total'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    grandTotal += parseFloat($(this).val());
                }
            });

            $('#std_grandtotalLbl').html(numformat(parseFloat(grandTotal).toFixed(2)));
        }
        //-----Standard ends-----

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

        $('#station').on('change', function() {
            getStoreBalanceFn($(this).val());
            $('#station-error').html("");
        });

        function getStoreBalanceFn(str_id){
            var store_id = null;
            var item_id = null;
            var record_id = null;
            var selected_items = [];
            $('#dynamicTable > tbody > tr').each(function(index, tr) {
                selected_items.push($(this).find('.itemName').val());
            });

            if(selected_items.length > 0) {
                $.ajax({ 
                    url: '/getDOStoreBalance', 
                    type: 'POST',
                    data:{
                        store_id : str_id,
                        item_id : selected_items,
                        record_id : $('#recordId').val() || 0,
                    },      
                    beforeSend: function() {
                        blockPage(cardSection, 'Calculating available balance...');
                    }, 
                    success: async function(data) {
                        await getAllItemBalanceFn(data);
                        unblockPage(cardSection);
                    },
                    error: function () {
                        unblockPage(cardSection);
                    }
                });
            }
        }

        function getAllItemBalanceFn(data){
            $('.qty_on_hand').val(0);
            if(parseFloat(data.result.length) == 0){
                $('.quantity').val("");
            }
            else{
                $.each(data.result, function(key, value) {
                    $('#dynamicTable > tbody > tr').each(function(index, tr) {
                        var itm = $(this).find('.itemName').val();

                        if(parseInt(value.ItemId) == parseInt(itm)){
                            var qty = $(this).find('.quantity').val();
                            var available_qty = value.available_quantity;
                            $(this).find('.qty_on_hand').val(available_qty);

                            if(parseFloat(qty) > parseFloat(available_qty)){
                                $(this).find('.quantity').val("");
                            }
                        }
                    });
                });
            }
        }

        function editDOFn(recordId){
            resetDOFormFn();

            $.ajax({
                type: "get",
                url: "{{url('getDOData')}}"+'/'+recordId,
                dataType: "json",
                beforeSend: function() {
                    blockPage(cardSection, 'Fetching delivery order data...');
                },
                success: async function(data) {
                    await getEditDataFn(data);
                    unblockPage(cardSection);
                },
                error: function () {
                    unblockPage(cardSection);
                }
            });

            $('#recordId').val(recordId);
            $('#operationtypes').val(2);
            $("#delivery_order_title").html('Edit Delivery Order');
            $('#savebutton').text('Update');
            $('#savebutton').prop("disabled",false);
            $("#inlineForm").modal('show');
        }

        function getEditDataFn(data){
            j = 0;
            var remaining_qty = 0;
            var item_options = null;
            var product_type = null;
            var options = null;
            var ref_options = null;
            var is_batch_req = null;
            var is_expiry_req = null;
            var is_serial_req = null;
            var status_color = null;

            $.each(data.reference_data, function(key, value) {
                if(data.reference_type == 601){
                    ref_options += `<option value="${value.proforma_id}">${value.proforma_data}</option>`;
                }
                else{
                    ref_options += `<option value="${value.sales_id}">${value.sales_data}</option>`;
                }
            });
            $('#Reference').append(ref_options).val(null).select2({placeholder: "Select reference here"});

            $.each(data.do_data, function(key, value) {
                $('#ReferenceType').val(value.reference_type).select2({minimumResultsForSearch: -1});
                $('#DeliveryDate').val(value.delivery_date);
                $('#OrderedBy').val(value.order_by).select2();
                $('#DocumentNumber').val(value.supporting_doc_no);
                $('#Remark').val(value.remark);
                $('#VisiblePrice').prop('checked', value.show_pricing == 1);

                $('#DeliverBy').val(value.delivery_by);
                $('#PhoneNumber').val(value.phone_no);
                $('#IdNumber').val(value.id_no);
                $('#PlateNumber').val(value.plate_no);

                product_type = value.product_type;

                if(value.reference_type == 600){
                    var product_type_options = `
                        <option value="Goods">Goods</option>
                        <option value="Commodity">Commodity</option>
                        <option value="Metal">Metal</option>`;

                    var customer_options = $("#default_customer > option").clone();
                    var station_options = $("#default_station > option").clone();
                    var sales_person_list = $("#DefaultSalesPerson > option").clone();

                    $('#ProductType').empty().append(product_type_options).select2();
                    $(`#ProductType option[value="${value.product_type}"]`).remove();
                    $('#ProductType').append(`<option selected value="${value.product_type}">${value.product_type}</option>`).select2({minimumResultsForSearch: -1});

                    $('#station').empty().append(station_options).select2();
                    $(`#station option[value="${value.station}"]`).remove();
                    $('#station').append(`<option selected value="${value.station}">${value.store_name}</option>`).select2();

                    $('#customer').empty().append(customer_options).select2();
                    $(`#customer option[value="${value.customers_id}"]`).remove();
                    $('#customer').append(`<option selected value="${value.customers_id}">${value.customer_code}, ${value.customer_name}, ${value.TIN}</option>`).select2();

                    $('#SalesPerson').empty().append(sales_person_list).select2();
                    $(`#SalesPerson option[value="${value.sales_person}"]`).remove();
                    $('#SalesPerson').append(`<option selected value="${value.sales_person}">${value.sales_person}</option>`).select2();

                    flatpickr('#ExpiryDate', {dateFormat: 'Y-m-d',clickOpens:true,minDate:current_date}); 
                    $('#ExpiryDate').val(value.expiry_date);  

                    $('#PaymentType').val(value.payment_type).select2({minimumResultsForSearch: -1});
                    $('#PaymentTerm').val(value.payment_term).select2({minimumResultsForSearch: -1});
                }
                else if(value.reference_type != 600){
                    
                    $(`#Reference option[value="${value.reference_id}"]`).remove();
                    $('#Reference').append(`<option selected value="${value.reference_id}">${value.reference_no}, ${value.customer_code}, ${value.customer_name}, ${value.TIN}</option>`).select2();

                    $('#ProductType').empty().append(`<option selected value="${value.product_type}">${value.product_type}</option>`).select2({minimumResultsForSearch: -1});
                    $('#station').empty().append(`<option selected value="${value.station}">${value.store_name}</option>`).select2({minimumResultsForSearch: -1});
                    $('#customer').empty().append(`<option selected value="${value.customers_id}">${value.customer_code}, ${value.customer_name}, ${value.TIN}</option>`).select2({minimumResultsForSearch: -1});
                    $('#SalesPerson').empty().append(`<option selected value="${value.sales_person}">${value.sales_person}</option>`).select2();

                    flatpickr('#ExpiryDate', {dateFormat: 'Y-m-d',clickOpens:false});
                    $('#ExpiryDate').val(value.expiry_date);
                }

                if(value.status == "Draft"){
                    status_color = "#A8AAAE";
                }
                else if(value.status == "Pending"){
                    status_color = "#f6c23e";
                }
                else if(value.status == "Verified" || value.status == "Checked"){
                    status_color = "#7367F0";
                }
                else if(value.status == "Approved" || value.status == "Confirmed"){
                    status_color = "#1cc88a";
                }
                else{
                    status_color = "#e74a3b";
                }
                $("#delivery_order_status").html(`<span class="form_title" style='color:${status_color};font-weight:bold;text-shadow;1px 1px 10px ${status_color};font-size:16px;'>${value.document_number},     ${value.status}</span>`);
            });

            $.each(data.detail_data, function(key, value) {
                ++i;
                ++j;
                ++m;
                remaining_qty = (parseFloat(value.ordered_qty || 0) - parseFloat(value.issued_qty || 0)) + parseFloat(value.quantity || 0);

                $("#dynamicTable > tbody").append(`<tr>
                    <td style="font-weight:bold;text-align:center;width:3%">${j}</td>
                    <td style="display:none;"><input type="hidden" name="row[${m}][vals]" id="vals${m}" class="vals form-control" readonly="true" style="font-weight:bold;" value="${m}"/></td>
                    <td style="width:14%"><select id="itemNameSl${m}" class="select2 form-control itemName" onchange="itemFn(this)" name="row[${m}][ItemId]"><option selected value="${value.regitems_id}">${value.items}</option></select></td>
                    <td style="width:8%"><select id="uom${m}" class="select2 form-control uom" onchange="uomFn(this)" name = "row[${m}][uom]"><option selected value="${value.new_uom}">${value.UOM}</option></select></td>
                    <td style="width:10%;" class="direct_reference"><input type="text" name="row[${m}][qty_on_hand]" placeholder="Quantity on hand" id="qty_on_hand${m}" class="qty_on_hand form-control" readonly="true" style="font-weight:bold;"/></td>
                    <td style="width:10%" class="non_direct_reference"><input type="number" name="row[${m}][ordered_qty]" placeholder="Ordered quantity" id="ordered_qty${m}" class="ordered_qty form-control numeral-mask" value="${value.ordered_qty}" readonly="true" style="font-weight:bold;"/></td>
                    <td style="width:10%" class="non_direct_reference"><input type="number" name="row[${m}][remaining_qty]" placeholder="Remaining quantity" id="remaining_qty${m}" class="remaining_qty form-control numeral-mask" value="${remaining_qty >= 0 ? remaining_qty : 0}" readonly="true" style="font-weight:bold;"/></td>
                    <td style="width:10%"><input type="number" name="row[${m}][Quantity]" placeholder="Enter quantity here" id="quantity${m}" class="quantity form-control numeral-mask" onkeyup="CalculateTotal(this)" value="${value.quantity}" onkeypress="return ValidateNum(event);" ondrop="return false;" onpaste="return false;"/></td>
                    <td style="width:9%" class="pricing_column"><input type="number" name="row[${m}][UnitPrice]" placeholder="Enter unit price here" id="unitprice${m}" class="unitprice form-control numeral-mask" value="${value.unit_price}" onkeyup="CalculateTotal(this)" onkeypress="return ValidateNum(event);"/></td>
                    <td style="width:9%" class="pricing_column"><input type="number" name="row[${m}][TotalPrice]" placeholder="Total price" id="total${m}" class="total form-control numeral-mask" readonly="true" value="${value.total_price}" style="font-weight:bold;"/></td>
                    <td style="width:12%;"><input type="text" name="row[${m}][remark]" id="remark${m}" class="remark form-control" placeholder="Enter remark here" value="${(value.remark == null || value.remark == "") ? "" : value.remark}"/></td>
                    <td style="width:5%;text-align:center;">
                        <a id="batch_serial_info${m}" href="javascript:void(0)" class="batch_serial_info" style="display:none;"><i class="fas fa-info-circle" style="color: #82868b;"></i></a>
                        <button type="button" id="remove_rec_item${m}" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button>
                    </td>
                </tr>`);
                
                is_batch_req = value.RequireExpireDate == "Require-BatchNumber" || value.RequireExpireDate == "Require-Both" ? "Yes" : "No";
                is_expiry_req = value.RequireExpireDate == "Require-ExpireDate" || value.RequireExpireDate == "Require-Both" ? "Yes" : "No";
                is_serial_req = value.RequireSerialNumber == "Required" ? "Yes" : "No";

                if(is_batch_req == "Yes" || is_expiry_req == "Yes" || is_serial_req == "Yes"){
                    $(`#batch_serial_info${m}`).attr("title",`Is Batch No. Req.: ${is_batch_req}\nIs Expiry Date Req.: ${is_expiry_req}\nIs Serial No. Req.: ${is_serial_req}`);
                    $(`#batch_serial_info${m}`).show();
                }

                if(data.reference_type == 600){
                    options = $("#item_default");
                    $(`#itemNameSl${m}`).append(options.find(`option[data-type="${product_type}"]`).clone());
                    $(`#itemNameSl option[value="${value.regitems_id}"]`).remove();
                    $(`#itemNameSl${m}`).append(`<option selected value="${value.regitems_id}">${value.items}</option>`).select2();
                    calcBalanceFn(m);
                }
                else if(data.reference_type != 600){
                    $(`#itemNameSl${m}`).select2({minimumResultsForSearch: -1});
                }

                $(`#uom${m}`).select2({minimumResultsForSearch: -1});
                $(`#select2-itemNameSl${m}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                $(`#select2-uom${m}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
            });

            $.each(data.item_info, function(key, value) {
                item_options += `<option value="${value.itemid}">${value.items}</option>`; 
            });

            if(data.reference_type == 600){
                $('.non_direct_reference').hide();
                $('.direct_reference').show();
                $('.unitprice').prop("readonly",false);       
                $('.pricing_inp').val("");
                $('.direct-reference').show();
            }
            else if(data.reference_type != 600){
                $('.non_direct_reference').show();
                $('.direct_reference').hide();
                $('.unitprice').prop("readonly",true);
                $('#reference_doc_div').show();
                $('.direct-reference').hide();
            }

            item_options += `<option selected disabled value=""></option>`;
            $('#reference_item_default').empty().append(item_options).select2();

            showCostColumnFn();
            CalculateGrandTotal();
        }

        function doInfoFn(recordId){
            createDOInfoFn(recordId);
            tabMgtFn();
            $("#doInfoModal").modal('show');
        }

        function createDOInfoFn(recordId){
            $("#statusIds").val(recordId);
            $("#recordIds").val(recordId);
            $('.fl_class').hide();
            infoTblIndex = -1;
            var visibilitymode = false;
            
            $.ajax({
                type: "get",
                url: "{{url('getDOData')}}"+'/'+recordId,
                dataType: "json",
                beforeSend: function() {
                    blockPage(cardSection, 'Fetching delivery order data...');
                },
                success: async function(data) {
                    await getInfoDataFn(data);
                },
                error: function () {
                    unblockPage(cardSection);
                }
            });
        }

        function getInfoDataFn(data){
            expand_flag = [];
            var lidata = "";
            var status_color = "";
            var action_links = "";
            var major_btn_link = `<li><hr class="dropdown-divider"></li>`;
            var status_btn_link = `<li><hr class="dropdown-divider"></li>`;
            var edit_link = `
                @can("Receiving-Edit")
                    <li>
                        <a class="dropdown-item editDORecord" href="javascript:void(0)" onclick="editDOFn(${data.rec_id})" data-id="editDOLink${data.rec_id}" id="editDOLink${data.rec_id}" title="Edit record">
                        <span><i class="fa-solid fa-pencil"></i> Edit</span>  
                        </a>
                    </li>
                @endcan`;

            var void_link = `
                @can("Receiving-Void")
                    <li>
                        <a class="dropdown-item voidDORecord" href="javascript:void(0)" onclick="voidDOFn(${data.rec_id})" data-id="voidDOLink${data.rec_id}" id="voidDOLink${data.rec_id}" title="Void record">
                        <span><i class="fa-solid fa-ban"></i> Void</span>  
                        </a>
                    </li>
                @endcan`;

            var undovoid_link = `
                @can("Receiving-Void")
                <li>
                    <a class="dropdown-item undoVoidDORecord" href="javascript:void(0)" onclick="undoVoidDOFn(${data.rec_id})" data-id="undoVoidDOLink${data.rec_id}" id="undoVoidDOLink${data.rec_id}" title="Undo void record">
                    <span><i class="fa fa-undo"></i> Undo Void</span>  
                    </a>
                </li>
                @endcan`;

            var change_to_pending_link = `
                @can("Receiving-ChangeToPending")
                <li>
                    <a class="dropdown-item changeToPending" onclick="forwardDOFn()" id="changeToPendingLink${data.rec_id}" title="Change record to pending">
                    <span><i class="fa-solid fa-forward"></i> Change to Pending</span>  
                    </a>
                </li>
                @endcan`;

            var back_to_draft_link = `
                @can("Receiving-ChangeToPending")
                <li>
                    <a class="dropdown-item dobackward" id="backToDraftLink${data.rec_id}" title="Change record to draft">
                    <span><i class="fa-solid fa-backward"></i> Back to Draft</span>  
                    </a>
                </li>
                @endcan`;

            var verify_link = `
                @can("Receiving-ChangeToPending")
                <li>
                    <a class="dropdown-item changeToVerified" onclick="forwardDOFn()" id="changeToVerifiedLink${data.rec_id}" title="Change record to verified">
                    <span><i class="fa-solid fa-forward"></i> Verify</span>  
                    </a>
                </li>
                @endcan`;

            var back_to_pending = `
                @can("Receiving-ChangeToPending")
                <li>
                    <a class="dropdown-item dobackward" id="backToPendingLink${data.rec_id}" title="Change record to pending">
                    <span><i class="fa-solid fa-backward"></i> Back to Pending</span>  
                    </a>
                </li>
                @endcan`;

            var approve_link = `
                @can("Receiving-ChangeToPending")
                <li>
                    <a class="dropdown-item changeToApproved" onclick="forwardDOFn()" id="changeToApprovedLink${data.rec_id}" title="Change record to approved">
                    <span><i class="fa-solid fa-forward"></i> Approve</span>  
                    </a>
                </li>
                @endcan`;

            var upload_document_link = `
                @can("Receiving-Confirm")
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item" id="managedocumentBtn" onclick="openDocumentUploadFn(${data.rec_id})" title="Open document manage form">
                    <span><i class="fas fa-sliders-h"></i> Manage Documents</span>
                    </a>
                </li>
                @endcan`;

            $.each(data.do_data, function(key, value) {
                $('#info_reference_type').html(value.reference_types);
                $('#info_reference').html(`<a style="text-decoration:underline;color:blue;" onclick=openReferenceDocLinkFn("${value.reference_type}","${data.rec_id}")>${value.reference_no != null ? value.reference_no : ""}</a>`);
                $('#info_product_type').html(value.product_type);
                $('#info_station').html(value.store_name);
                $('#info_delivery_date').html(value.delivery_date);
                $('#info_expiry_date').html(value.expiry_date);

                $('#info_order_by').html(value.order_by);
                $('#info_sales_person').html(value.sales_person);
                $('#info_doc_no').html(value.supporting_doc_no);
                $('#info_payment_type').html(value.payment_type);
                $('#info_payment_term').html(value.payment_term);
                $('#info_remark').html(value.remark);
                $('#info_price_column_vis').html(value.show_pricing == 1 ? "Yes" : "No");

                $('#info_customer_name').html(value.customer_name);
                $('#info_customer_code').html(value.customer_code);
                $('#info_customer_category').html(value.CustomerCategory);
                $('#info_tin').html(value.TIN);
                $('#info_vat_no').html(value.VatNumber);
                $('#info_customer_phone').html(`${value.PhoneNumber}, ${value.OfficePhone}`);

                $('#info_delivery_by').html(value.delivery_by);
                $('#info_phone_no').html(value.phone_no);
                $('#info_id_no').html(value.id_no);
                $('#info_plate_no').html(value.plate_no);

                $('#info_total_price').html(numformat(parseFloat(value.total_price).toFixed(2)));

                $('#recId').val(data.rec_id);
                $('#currentStatus').val(value.status);

                if(value.status == "Draft"){
                    major_btn_link += edit_link;
                    major_btn_link += void_link;

                    status_btn_link += change_to_pending_link;
                    status_color = "#A8AAAE";
                }
                else if(value.status == "Pending"){
                    major_btn_link += edit_link;
                    major_btn_link += void_link;
                    
                    status_btn_link += verify_link;
                    status_btn_link += back_to_draft_link;

                    status_color = "#f6c23e";
                }
                else if(value.status == "Verified"){
                    major_btn_link += edit_link;
                    major_btn_link += void_link;

                    status_btn_link += approve_link;
                    status_btn_link += back_to_pending;
                    status_color = "#7367F0";
                }
                else if(value.status == "Approved"){
                    major_btn_link += edit_link;
                    major_btn_link += void_link;

                    status_btn_link = ""; 
                    status_color = "#1cc88a";
                }
                else if(value.status == "Void"){
                    major_btn_link += undovoid_link;
                    upload_document_link = "";
                    status_color = "#e74a3b";
                }
                else{
                    status_color = "#e74a3b";
                }
                $(".info_modal_title_lbl").html(`<span class="form_title" style='color:${status_color};font-weight:bold;text-shadow;1px 1px 10px ${status_color};font-size:16px;'>${value.document_number},     ${value.status}</span>`);

                if(value.reference_type == 600){
                    $('.info_direct_ref').show();
                }
                if(value.reference_type != 600){
                    $('.info_non_direct_ref').show();
                }

                if(value.show_pricing == 1){
                    $('.pricing_flag').show();
                }

                action_links = `
                <li>
                    <a class="dropdown-item viewDOAction" onclick="viewDOActionFn(${data.rec_id})" data-id="view_do_actionbtn${recordId}" id="view_do_actionbtn${recordId}" title="View user log">
                        <span><i class="fa-solid fa-eye"></i> View User Log</span>  
                    </a>
                </li>
                ${major_btn_link}
                ${upload_document_link}
                ${status_btn_link}`;

                $("#do_action_ul").empty().append(action_links);
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

            getDocumentDataFn(data.rec_id);
            fetchDOItemFn(data.rec_id,data.is_price_vis);
            $(".infoscl").collapse('show');
        }

        function fetchDOItemFn(recordId,is_price_vis){
            var visibility_flag = false;
            var column_index = [];

            if(is_price_vis == 1){
                column_index = [8,9];
                visibility_flag = true;
            }
            else{
                column_index = [8,9];
                visibility_flag = false;
            }

            detail_table = $('#doInfoDataTbl').DataTable({
                destroy:true,
                processing: true,
                serverSide: false,
                paging: false,
                info:false,
                searchHighlight: true,
                searching: true,
                "order": [[ 0, "asc" ]],
                language: { 
                    search: '', 
                    searchPlaceholder: "Search here"
                },
                autoWidth: false,
                deferRender: true,
                dom: "<'row'<'col-sm-6 col-md-6 col-6 ml-0'f><'col-sm-6 col-md-6 col-6 mt-2 d-flex justify-content-end expand-collapse-class'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-4 col-md-4 col-4'l><'col-sm-4 col-md-4 col-4 d-flex justify-content-center'i><'col-sm-4 col-md-4 col-4 d-flex justify-content-end'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/showDODetailData/' + recordId,
                    type: 'POST',
                    complete: function () { 
                        setFocusInfoTable('#doInfoDataTbl');
                    },
                },
                columns: [{
                        data: 'id',
                        name: 'id',
                        'visible': false
                    },
                    {
                        data:null,
                        orderable: false,
                        "render": function ( data, type, row, meta ) {
                            if(row.RequireSerialNumber != "Not-Require" || row.RequireExpireDate != "Not-Require"){
                                $('.expand-collapse-class').empty().append(`<a class="expandrow" href="javascript:void(0)" id="expandrow" style="color:#82868b;"><i class="far fa-plus"></i> Expand All</a>`);
                                return `<i title="Show batch number, serial number, expiry date under ${row.ItemName} item!" class="fas fa-caret-right fa-xl"></i>`;
                            }
                            else{
                                return "";
                            }
                        },
                        createdCell: function (td, row, data) {
                            if(row.RequireSerialNumber != "Not-Require" || row.RequireExpireDate != "Not-Require"){
                                $(td).addClass('dt-show-1');
                            }
                        },
                        width:'2%',
                    },
                    {
                        data:'DT_RowIndex',
                        width:'3%',
                    },
                    {
                        data: 'ItemCode',
                        name: 'ItemCode',
                        width:'10%',
                    },
                    {
                        data: 'ItemName',
                        name: 'ItemName',
                        width:'20%',
                    },
                    {
                        data: 'SKUNumber',
                        name: 'SKUNumber',
                        width:'10%',
                    },
                    {
                        data: 'UOM',
                        name: 'UOM',
                        width:'8%',
                    },
                    {
                        data: 'quantity',
                        name: 'quantity',
                        width:'8%',
                        render: $.fn.dataTable.render.number(',', '.',0, '')
                    },
                    {
                        data: 'unit_price',
                        name: 'unit_price',
                        width:'10%',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'total_price',
                        name: 'total_price',
                        width:'10%',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },   
                    {
                        data: 'remark',
                        name: 'remark',
                        width:'16%',
                    },
                    {
                        data: null,
                        name: 'action',
                        orderable: false,
                        "render": function ( data, type, row, meta ) {
                            if((row.RequireSerialNumber != "Not-Require" || row.RequireExpireDate != "Not-Require") && row.status != "Void"){
                                var fore_color = "";
                                if(parseInt(row.is_fully_entered) == 1){
                                    fore_color = "#28c76f";
                                }
                                else{
                                    fore_color = "#ff9f43";
                                }
                                return `<div class="text-center">
                                            <a 
                                                class="addsernum" 
                                                href="javascript:void(0)" 
                                                onclick="mngBatchSerialExpireFn(${row.id},${row.delivery_order_id},${row.regitems_id},${row.station},${row.quantity},${row.trn_type})" 
                                                data-id="addsernum${row.id}" 
                                                id="addsernum${row.id}" 
                                                title="Add batch number, serial number, expiry date for ${row.ItemName} item!">
                                                <i class="fa fa-plus fa-xl" style="color:${fore_color};"></i>
                                            </a>
                                        </div>`;
                            }
                            else{
                                return "";
                            }
                        },
                        width:'3%',
                    },
                    {
                        data: 'batch_numers',
                        name: 'batch_numers',
                        'visible': false
                    },
                    {
                        data: 'serial_numbers',
                        name: 'serial_numbers',
                        'visible': false
                    },
                ],
                "columnDefs": [{
                    "targets": column_index,
                    "visible": visibility_flag,
                }],
                "initComplete": function(settings, json) {
                    unblockPage(cardSection);
                },
            });

            $('#doInfoDataTbl').on('draw.dt', function () {
                let keyword = $('#doInfoDataTbl_filter input').val();
                detail_table.rows({ search: 'applied' }).every(function () {
                    // parent row
                    highlight(this.node(), keyword);

                    // child row (if exists)
                    if (this.child && this.child.isShown()) {
                        highlight(this.child(), keyword);
                    }
                });
            });
        }

        $('#doInfoDataTbl tbody').on('click', 'tr', function () {
            $('#doInfoDataTbl tbody > tr').removeClass('selected');
            $(this).addClass('selected');
            infoTblIndex = $(this).index();
        });

        function setFocusInfoTable(targetTable) {
            $($(targetTable + ' tbody > tr')[infoTblIndex]).addClass('selected');
        }

        function highlight(container, keyword) {
            if (!keyword || keyword.trim() === '') {
                // Restore original HTML
                $(container).find('td').each(function() {
                    let original = $(this).attr('data-original');
                    if (original) {
                        $(this).html(original);
                    }
                });
                return;
            }

            let safeKeyword = keyword.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
            let regex = new RegExp(`(${safeKeyword})`, 'gi');

            $(container).find('td').each(function() {
                let $td = $(this);
                
                // Store original HTML if not already stored
                if (!$td.attr('data-original')) {
                    $td.attr('data-original', $td.html());
                }
                
                // Get original HTML
                let originalHtml = $td.attr('data-original');
                
                // Create a temporary div to manipulate DOM
                let $temp = $('<div>').html(originalHtml);
                
                // Function to highlight text in text nodes only
                function highlightTextNodes(element) {
                    $(element).contents().each(function() {
                        if (this.nodeType === Node.TEXT_NODE && this.textContent.trim() !== '') {
                            let text = this.textContent;
                            let newText = text.replace(regex, '<b class="highlightsearch">$1</b>');
                            if (newText !== text) {
                                $(this).replaceWith(newText);
                            }
                        } else if (this.nodeType === Node.ELEMENT_NODE && 
                                !['SCRIPT', 'STYLE', 'MARK'].includes(this.tagName)) {
                            highlightTextNodes(this);
                        }
                    });
                }
                
                highlightTextNodes($temp[0]);
                $td.html($temp.html());
            });
        }

        function tabMgtFn(){
            $(".tab-title").removeClass("active");
            $(".tab-view").removeClass("active");
            
            $(".active-tab-title").addClass("active");
            $(".active-tab-view").addClass("active");
        }

        function viewDOActionFn(recordId){
            $("#action-log-title").html("User Log Information");
            $("#action-log-universal-modal").modal('show');
        }

        //-----Expand & collapse start--------
        $('#doInfoDataTbl tbody').on('click', 'td.dt-show-1', async function () {
            let tr = $(this).closest('tr');
            let row = $('#doInfoDataTbl').DataTable().row(tr);
            
            if (row.child.isShown()) {
                row.child.hide();
                $(this).html('<i class="fas fa-caret-right fa-xl"></i>');
            } else {
                let data = row.data();
                let html = await formatLevel1Fn(data.delivery_order_id,data.regitems_id);
                
                if(html != undefined){
                    row.child('Loading...').show();
                    row.child(html).show();
                    $(this).html('<i class="fas fa-caret-down fa-xl"></i>');
                }
            }
        }); 

        async function formatLevel1Fn(header_id,item_id) {
            var headerId = null;
            var itemId = null;
            var is_batch_req = null;
            var is_expiry_req = null;
            
            let response = await $.ajax({ 
                url: '/getItemBactchDataIssue', 
                type: 'POST',
                data:{
                    headerId : header_id,
                    itemId : item_id,
                },
            });

            $.each(response.batch_data, function (index, value) {
                is_batch_req = value.RequireExpireDate == "Require-BatchNumber" || value.RequireExpireDate == "Require-Both" ? "Yes" : "No";
                is_expiry_req = value.RequireExpireDate == "Require-ExpireDate" || value.RequireExpireDate == "Require-Both" ? "Yes" : "No";
            });

            let html = `<table class="first-level table-striped dt-responsive" width="100%">`;
            html += `<tr>
                <th style="width:2%"></th>
                <th style="width:3%">#</th>
                <th style="width:18%"><i class="fas fa-info-circle" title="Country, manufacturer, brand"></i> Brand</th>
                <th style="width:17%">Generic/ Model Name</th>
                <th class="batch_number_class" style="width:15%;display:${is_batch_req == "No" ? "none" : ""}">Batch Number</th>
                <th style="width:15%">Quantity</th>
                <th style="width:15%">Manufacturing Date</th>
                <th class="expiry_date_class" style="width:15%;display:${is_expiry_req == "No" ? "none" : ""}">Expiry Date</th>
            </tr><tbody>`;

            $.each(response.batch_data, function (index, value) {
                var class_name = "";
                var batch_id = "";
                
                if(value.RequireSerialNumber == 'Required'){
                    class_name = "dt-show-2";
                    batch_id = '<i class="fas fa-caret-right fa-xl"></i>';
                }

                html += `<tr>
                    <td class="${class_name}" data-batchid="${value.id}" data-sourceid="${header_id}">${batch_id}</td>
                    <td>${++index}</td>
                    <td>${value.brand_name}</td>
                    <td>${value.model_name}</td>
                    <td class="batch_number_class" style="display:${is_batch_req == "No" ? "none" : ""}">${value.batch_number}</td>
                    <td>${value.sold_issued_qty}</td>
                    <td>${value.manufacturing_date}</td>
                    <td class="expiry_date_class" style="display:${is_expiry_req == "No" ? "none" : ""}">${value.expiry_date}</td>
                </tr>`;
            });

            html += `</tbody></table>`;

            expand_flag.push(response.batch_data.length);
            var has_value = expand_flag.some(value => value > 0);

            if(has_value){
                return html;
            }
            else{
                toastrMessage('info',"No batch and/or serial numbers are available to expand.","Info");
            }
        }

        $(document).on('click', '.dt-show-2', async function () {
            let tr = $(this).closest('tr');

            if ($(this).hasClass('shown')) {
                tr.next('.child-level-2').remove();
                $(this).removeClass('shown').html('<i class="fas fa-caret-right fa-xl"></i>');
            } 
            else {
                let loadingRow = `<tr class="child-level-2">
                        <td colspan="8" class="child-container">Loading...</td>
                    </tr>`;

                tr.after(loadingRow);
                $(this).addClass('shown').html('<i class="fas fa-caret-down fa-xl"></i>');

                try{
                    let batchId = $(this).data('batchid');
                    let sourceId = $(this).data('sourceid');
                    let html = await formatLevel2Fn(batchId,sourceId);

                    tr.next('.child-level-2').html(`<td colspan="8">${html}</td>`);
                }
                catch(e){
                    tr.next('.child-level-2').html(`<td colspan="8" style="color:red;">Error loading data</td>`);
                }  
            }
        });

        async function formatLevel2Fn(batch_id,sourceId) {
            var batchId = null;
            var source_id = null;
            var source_type = null;
            let response = await $.ajax({ 
                url: '/getItemSerialDataIssue', 
                type: 'POST',
                data:{
                    batchId : batch_id,
                    source_id : sourceId,
                },
            });

            let html = `<table class="second-level table-striped dt-responsive" width="100%">`;
            $.each(response.serial_data, function (index, value) {
                html += `<tr><th>Serial Number (${value.count_serial})</th></tr>`;
                html += `<tr style="background-color:#FFFFFF;"><td>${value.serial_number}</td></tr>`;
            });

            html += `</table>`;
            return html;
        }

        async function expandAllLevel1Fn() {
            let table = $('#doInfoDataTbl').DataTable();
            var count_req = 0;

            for (let i = 0; i < table.rows().count(); i++) {

                let row = table.row(i);

                if (!row || !row.node()) continue;

                let tr = $(row.node());
                let data = row.data();

                if (!data) continue;

                if(data.RequireSerialNumber != "Not-Require" || data.RequireExpireDate != "Not-Require"){
                
                    // 🔥 FIX: ensure HTML exists
                    let html = await formatLevel1Fn(data.delivery_order_id,data.regitems_id);

                    if (!html) continue; // ← IMPORTANT

                    // 🔥 FIX: check child() exists
                    let child = row.child(html);

                    if (child && typeof child.show === 'function') {
                        child.show();
                        tr.find('.dt-show-1').html('<i class="fas fa-caret-down fa-xl"></i>');
                    }
                }
                // else{
                //     //toastrMessage('info',"No batch and/or serial numbers are available to expand.","Info");
                // }
            }
        }

        function expandAllLevel2Fn() {
            // find only visible Level 1 rows
            $('.dt-show-2').each(function () {
                let el = $(this);
                if (!el.hasClass('shown')) {
                    el.trigger('click');
                }
            });
        }

        $(document).on('click', '#expandrow',async function() {
            await expandAllLevel1Fn();

            setTimeout(function () {
                expandAllLevel2Fn();
                var has_value = expand_flag.some(value => value > 0);
                if(has_value){
                    $('.expand-collapse-class').empty().append(`<a class="collapserow" href="javascript:void(0)" id="collapserow" style="color:#82868b;"><i class="far fa-minus"></i> Collapse All</a>`);
                }
            }, 300);
        });

        $(document).on('click', '#collapserow',async function() {
            let table = $('#doInfoDataTbl').DataTable();

            table.rows().every(function () {

                let row = this;
                let tr = $(row.node());

                if (row.child.isShown()) {
                    row.child.hide();
                    tr.find('.dt-show-1').html('<i class="fas fa-caret-right fa-xl"></i>');
                }
            });

            // remove all level 2 DOM rows
            $('.child-level-2').remove();
            $('.dt-show-2').removeClass('shown').html('<i class="fas fa-caret-right fa-xl"></i>');
            $('.expand-collapse-class').empty().append(`<a class="expandrow" href="javascript:void(0)" id="expandrow" style="color:#82868b;"><i class="far fa-plus"></i> Expand All</a>`);
        });
        //-----Expand & collapse end---------

        //-----Forward & backward action start--------
        function forwardDOFn() {
            const requestId = $('#recId').val();
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
                    doForwardActionFn();
                }
                else if (result.dismiss === Swal.DismissReason.cancel) {}
            });
        }

        function doForwardActionFn(){
            var forwardForm = $("#doInfoForm");
            var formData = forwardForm.serialize();
            var recordId = $('#recId').val();
            $.ajax({
                url: '/doForwardAction',
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    blockPage(cardSection, 'Forwarding delivery order record...');
                },
                error: function () { 
                    unblockPage(cardSection); 
                },
                success: async function(data) {
                    await doForwardRecordFn(data);
                }
            });
        }

        function doForwardRecordFn(data){
            if(data.dberrors) {
                toastrMessage('error',"Please contact administrator","Error");
            }
            else if(data.item_variances){
                var item_list = "";
                $.each(data.item_variances, function(key, value) {
                    item_list += `${++key}. ${value.item_name}</br>`;
                });
                toastrMessage('warning',`Please select all required batch and/or serial numbers for the items listed below</br>----------------</br>${item_list}`,"Warning");
            }
            else if(data.balance_error) {
                var item_list = "";
                $.each(data.items, function(index, value) {
                    item_list += `<b>${++index},</b> ${value.name}</br>`;
                });
                toastrMessage('error',`There is no available quantity for the following items</br>-------------------</br>${item_list}`,"Error");
            } 
            else if(data.success) {
                toastrMessage('success',"Successful","Success");
                
                createDOInfoFn(data.rec_id);
                countDOStatusFn(data.fiscal_year);

                refreshMainDatatbleFn();
            }
        }

        $(document).on('click', '.dobackward', function(){
            const requestId = $('#recId').val();
            const currentStatus = $('#currentStatus').val();

            const transition = $(this).attr('id') == "salrejectbtn" ? statusTransitions[currentStatus].reject : statusTransitions[currentStatus].backward;

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
                url: '/doBackwardAction',
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    blockPage(cardSection, 'Backwarding delivery order record...');

                    $('#backwardActionBtn').text('Changing...');
                    $('#backwardActionBtn').prop("disabled", true);
                },
                error: function () { 
                    unblockPage(cardSection);

                    $('#backwardActionBtn').text(btntxt);
                    $('#backwardActionBtn').prop("disabled", false);
                },
                success:async function(data) {
                    await backwardDORecordFn(data);
                }
            });
        });

        function backwardDORecordFn(data){
            var btntxt = $('#backwardBtnTextValue').val();
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
                createDOInfoFn(data.rec_id);
                countDOStatusFn(data.fiscal_year);

                refreshMainDatatbleFn();
                $('#backwardActionModal').modal('hide');
            }
        }
        //-----Forward & backward action end----------

        //-----Document start-------
        function openDocumentUploadFn(rec_id){
            var do_id = null;
            
            $.ajax({
                url: '/fetchDODoc', 
                type: 'POST',
                data:{
                    do_id:rec_id,
                },
                beforeSend: function() {
                    blockPage(cardSection, 'Fetching documents...');
                },
                error: function () { 
                    unblockPage(cardSection);    
                },
                success:async function(data) {
                    await fetchDocumentsFn(data);
                    renumberDocRows();
                    unblockPage(cardSection);
                }
            });

            $('#uploadRecordDocId').val(rec_id);
            $('#uploadDocButton').text('Upload');
            $('#uploadDocButton').prop("disabled", false);
            $('#manageDocumentModal').modal('show');
        }

        function fetchDocumentsFn(data){
            var default_date = "1900-01-01";
            $("#documentDynamicTable > tbody").empty();
            $.each(data.document_data, function(key, value) {
                ++y3;
                ++z3;
                ++x3;
                $("#documentDynamicTable > tbody").append(`<tr id="docrowtr${z3}">
                    <td style="font-weight:bold;width:3%;text-align:center;">${x3}</td>
                    <td style="display:none;"><input type="hidden" name="docrow[${z3}][docvals]" id="docvals${z3}" class="docvals form-control" readonly="true" style="font-weight:bold;" value="${z3}"/></td>
                    <td style="width:20%;"><select id="document_type${z3}" class="select2 form-control document_type" onchange="docTypeFn(this)" name="docrow[${z3}][document_type]"></select></td>
                    <td style="width:20%;"><input type="text" id="upload_date${z3}" name="docrow[${z3}][upload_date]" class="form-control upload_date${z3}" value="${value.date}" placeholder="YYYY-MM-DD" readonly onchange="uploadDateFn(this)"/></td>
                    <td style="width:20%;">
                        <div class="input-group">
                            <input class="form-control fileuploads" type="file" id="doc_upload${z3}" name="docrow[${z3}][doc_upload]" onchange="docmntUploadFn(this)" accept=".jpg, .jpeg, .png,.pdf" style="width:90%;">
                            <button type="button" id="doc_view${z3}" class="btn btn-light btn-sm doc_view view-doc" onclick="previewDocFn(this,'doc')" style="color:#00cfe8;background-color:#FFFFFF;border-color:#FFFFFF;padding: 1px 1px;width:9%;" title="Open uploaded document"><i class="fas fa-eye fa-lg" aria-hidden="true"></i></button>
                            <input type="hidden" class="form-control" value="${value.doc_name}" name="docrow[${z3}][documents]" id="documents${z3}"/>
                            <input type="hidden" class="form-control" value="${value.doc_name}" name="docrow[${z3}][doc_upload_hidden]" id="doc_upload_hidden${z3}"/>
                            <input type="hidden" class="form-control" value="${value.actual_file_name}" name="docrow[${z3}][doc_actual_name]" id="doc_actual_name${z3}"/>
                        <div>
                    </td>
                    <td style="width:20%;"><input type="text" name="docrow[${z3}][doc_remark]" id="cont_remark${z3}" class="cont_remark form-control" value="${value.remark == "" || value.remark == null ? "" : value.remark}" placeholder="Enter remark here"/></td>
                    <td style="width:14%;"><select id="doc_status${z3}" class="select2 form-control doc_status" name="docrow[${z3}][doc_status]"></select></td>
                    <td style="width:3%;text-align:center;"></td>
                </tr>`);

                var default_document_type = `<option selected value="${value.document_type}">${value.doc_type}</option>`;
                
                var doc_type_opt = $("#DocumentTypeDefault > option").clone();
                $(`#document_type${z3}`).append(doc_type_opt);
                $(`#document_type${z3} option[value="${value.document_type}"]`).remove(); 
                $(`#document_type${z3}`).append(default_document_type);
                $(`#document_type${z3}`).select2({dropdownCssClass : 'cusprop'});

                var statusdefopt = `<option selected value="${value.status}">${value.status}</option>`;
                var statusopt = '<option value="Active">Active</option><option value="Inactive">Inactive</option>';
                $(`#doc_status${z3}`).append(statusopt);
                $(`#doc_status${z3} option[value="${value.status}"]`).remove(); 
                $(`#doc_status${z3}`).append(statusdefopt).select2({minimumResultsForSearch: -1});

                flatpickr(`#upload_date${z3}`, { dateFormat: 'Y-m-d',allowInput: true,clickOpens:true,minDate:default_date,maxDate:current_date});
                $(`#select2-document_type${z3}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                $(`#select2-doc_status${z3}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
            });
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
                <td style="width:20%;"><select id="document_type${z3}" class="select2 form-control document_type" onchange="docTypeFn(this)" name="docrow[${z3}][document_type]"></select></td>
                <td style="width:20%;"><input type="text" id="upload_date${z3}" name="docrow[${z3}][upload_date]" class="form-control upload_date${z3}" placeholder="YYYY-MM-DD" readonly onchange="uploadDateFn(this)"/></td>
                <td style="width:20%;">
                    <div class="input-group">
                        <input class="form-control fileuploads" type="file" id="doc_upload${z3}" name="docrow[${z3}][doc_upload]" onchange="docmntUploadFn(this)" accept=".jpg, .jpeg, .png,.pdf" style="width:90%;">
                        <button type="button" id="doc_view${z3}" class="btn btn-light btn-sm doc_view" onclick="previewDocFn(this,'doc')" style="color:#00cfe8;background-color:#FFFFFF;border-color:#FFFFFF;padding: 1px 1px;width:9%;display:none;" title="Open uploaded document"><i class="fas fa-eye fa-lg" aria-hidden="true"></i></button>
                        <input type="hidden" class="form-control" name="docrow[${z3}][documents]" id="documents${z3}"/>
                        <input type="hidden" class="form-control" name="docrow[${z3}][doc_upload_hidden]" id="doc_upload_hidden${z3}"/>
                        <input type="hidden" class="form-control" name="docrow[${z3}][doc_actual_name]" id="doc_actual_name${z3}"/>
                    <div>
                </td>
                <td style="width:20%;"><input type="text" name="docrow[${z3}][doc_remark]" id="cont_remark${z3}" class="cont_remark form-control" placeholder="Write Remark here..."/></td>
                <td style="width:14%;"><select id="doc_status${z3}" class="select2 form-control doc_status" name="docrow[${z3}][doc_status]"></select></td>
                <td style="width:3%;text-align:center;"><button type="button" id="remove_doc_btn${z3}" class="btn btn-light btn-sm remove_doc_btn" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF;padding: 1px 1px"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>
            </tr>`);

            var default_option = `<option selected disabled value=""></option>`;
            var doc_type_opt = $("#DocumentTypeDefault > option").clone();
            $(`#document_type${z3}`).append(doc_type_opt);
            $(`#document_type${z3}`).append(default_option);
            $(`#document_type${z3}`).val(null).select2({
                placeholder: "Select type here...",
                dropdownCssClass : 'cusprop',
            });

            var statusopt = '<option value="Active">Active</option><option value="Inactive">Inactive</option>';
            $(`#doc_status${z3}`).append(statusopt).select2({
                placeholder: "Select status here",
                minimumResultsForSearch: -1
            });

            renumberDocRows();
            flatpickr(`#upload_date${z3}`, {dateFormat: 'Y-m-d',allowInput: true,clickOpens:true,minDate:default_date,maxDate:current_date});
            $(`#select2-document_type${z3}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
            $(`#select2-doc_status${z3}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
            $("#docmnt-doc-error").html("");
        });

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
                document_folder = "SupportingDocument";
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

            const filePath = `/storage/uploads/DeliveryOrder/${document_folder}/${file_name}`;
            window.open(filePath, '_blank', features);
        }

        function openDocFn(row_id,doc_name,doc_type){
            var link = `../../../storage/uploads/Receiving/SupportingDocument/${doc_name}`;
            window.open(link, '', 'width=1200,height=800,scrollbars=yes');
        }

        function renumberDocRows() {
            $('#documentDynamicTable tr').each(function(index, el) {
                $(this).children('td').first().text(index++);
            });
        }

        $('#ManageDocumentForm').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                url: '/uploadDODocument',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    blockPage(cardSection, 'Uploading documents...');
                    $('#uploadDocButton').text('Uploading...');
                    $('#uploadDocButton').prop("disabled", true);
                },
                error: function () { 
                    unblockPage(cardSection);    
                },
                success:async function(data) {
                    await uploadDODocumentFn(data);
                }
            });
        });

        function uploadDODocumentFn(data){
            if (data.errorv2) {
                $('#documentDynamicTable > tbody > tr').each(function (index) {
                    let k = $(this).find('.docvals').val()
                    var doc_type = $(`#document_type${k}`).val();
                    var doc_date = $(`#upload_date${k}`).val();
                    var docuplaod = $(`#doc_upload${k}`).val();
                    var doc_upload = $(`#contract_hidden${k}`).val();
                    
                    if(isNaN(parseFloat(doc_type)) || parseFloat(doc_type) == 0){
                        $(`#select2-document_type${k}-container`).parent().css('background-color',errorcolor);
                    }
                    if(($(`#upload_date${k}`).val()) != undefined){
                        if(doc_date == "" || doc_date == null){
                            $(`#upload_date${k}`).css("background", errorcolor);
                        }
                    }
                    if(doc_upload == null || doc_upload == ""){
                        $(`#doc_upload${k}`).css("background", errorcolor);
                    }
                });
                
                $('#uploadDocButton').text('Upload');
                $('#uploadDocButton').prop("disabled", false);
                toastrMessage('error',"Please fill all highlighted required fields","Error");
            }
            else if (data.dberrors){
                $('#uploadDocButton').text('Upload');
                $('#uploadDocButton').prop("disabled", false);
                toastrMessage('error',"Please contact administrator","Error");
            }
            else if(data.emptyerror){
                $('#uploadDocButton').text('Upload');
                $('#uploadDocButton').prop("disabled", false);
                toastrMessage('error',"You should add atleast one document","Error");
            } 
            else if(data.success){
                toastrMessage('success',"Successful","Success");
                createDOInfoFn(data.rec_id);
                docTabMgtFn();
                $("#manageDocumentModal").modal('hide');
            }
        }

        function getDocumentDataFn(recordId){
            $('#document_div').hide();
            $('#info-document-datatable').DataTable({
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
                    url: '/showDODocument/' + recordId,
                    type: 'POST',
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
                        width:'3%',
                    },    
                    {
                        data: 'doc_type',
                        name: 'doc_type',
                        width:'13%',
                    },   
                    {
                        data: 'date',
                        name: 'date',
                        width:'10%',
                    },
                    {
                        data: 'actual_file_name',
                        name: 'actual_file_name',
                        width:'40%',
                        "render": function ( data, type, row, meta ) {
                            return `<a style="text-decoration:underline;color:blue;" onclick=openDocFn("${row.id}","${row.doc_name}","${row.upload_type}")>${data}</a>`;
                        } 
                    },
                    {
                        data: 'remark',
                        name: 'remark',
                        width:'24%',
                    },
                    { data: 'status', name: 'status',
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
                        width:"10%"
                    },
                ]
            });
        }

        function openDocFn(row_id,doc_name,doc_type){
            var link = `../../../storage/uploads/DeliveryOrder/SupportingDocument/${doc_name}`;
            window.open(link, '', 'width=1200,height=800,scrollbars=yes');
        }

        function docTabMgtFn(){
            $(".tab-title").removeClass("active");
            $(".tab-view").removeClass("active");
            
            $("#info_do_doc_tab").addClass("active");
            $("#info_do_doc_view").addClass("active");
        }
        //-----Document end---------

        //-----Void & Undo Void Start------
        function voidDOFn(recordId){
            $.ajax({
                type: "get",
                url: "{{url('getDOData')}}"+'/'+recordId,
                dataType: "json",
                beforeSend: function() {
                    blockPage(cardSection, 'Preparing to void record...');
                },
                success: async function(data) {
                    await getVoidDataFn(data);
                    unblockPage(cardSection);
                },
                error: function () {
                    unblockPage(cardSection);
                }
            });
        }

        function getVoidDataFn(data){
            $.each(data.do_data, function(key, value) {
                if(value.status == "Void"){
                    toastrMessage('error',"This record cannot be voided again because its current status is Void","Error");
                }
                else{
                    $("#voidid").val(data.rec_id);
                    $('#vstatus').val(status);
                    $('#voiddobtn').prop("disabled", false);
                    $('#voiddobtn').text("Void");
                    $('#void-error').html("");
                    $('#Reason').val("");
                    $("#voidDOModal").modal('show');
                }
            });
        }

        $('#voiddobtn').click(function(){ 
            var registerForm = $("#voidDOForm");
            var formData = registerForm.serialize();
            $.ajax({
                url: '/voidDeliveryOrder',
                type: 'POST',
                data: formData,
                beforeSend: function() { 
                    $('#voiddobtn').text('Voiding...');
                    $('#voiddobtn').prop("disabled", true);

                    blockPage(cardSection,"Voiding delivery order record...");
                },
                success: async function(data) {
                    await voidDeliveryOrderFn(data);
                },
                error: function () { 
                    unblockPage(cardSection);     
                },
            });
        });

        function voidDeliveryOrderFn(data){
            if(data.errors) {
                if(data.errors.Reason) {
                    $('#void-error').html(data.errors.Reason[0]);
                }
                $('#voiddobtn').text('Void');
                $('#voiddobtn').prop("disabled", false);
                toastrMessage('error',"Check your inputs","Error");
                unblockPage(cardSection);
            }
            else if(data.dberrors) {
                $('#voiddobtn').text('Void');
                $('#voiddobtn').prop("disabled", false);
                toastrMessage('error',"Please contact administrator","Error");
                unblockPage(cardSection);
            }
            else if(data.success) {
                toastrMessage('success',"Successful","Success");
                countDOStatusFn(data.fiscal_year);
                createDOInfoFn(data.rec_id);
                refreshMainDatatbleFn();
                $("#voidDOModal").modal('hide');
            }
        }

        function undoVoidDOFn(recordId){
            $.ajax({
                type: "get",
                url: "{{url('getDOData')}}"+'/'+recordId,
                dataType: "json",
                beforeSend: function() {
                    blockPage(cardSection, 'Preparing to restore record...');
                },
                success: async function(data) {
                    await getUndoVoidDataFn(data);
                },
                error: function () {
                    unblockPage(cardSection);
                }
            });
        }

        function getUndoVoidDataFn(data){
            $.each(data.do_data, function(key, value) {
                if(value.status == "Void"){
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
                            undoVoidDORecordFn(data.rec_id);
                        }
                        else if (result.dismiss === Swal.DismissReason.cancel) {}
                    });
                }
                else{
                    toastrMessage('error',"Record status should be void","Error");
                }
            });
        }

        function undoVoidDORecordFn(recordId){
            var registerForm = $("#doInfoForm");
            var formData = registerForm.serialize();
            $.ajax({
                url: '/undoVoidDeliveryOrder',
                type: 'POST',
                data: formData,
                beforeSend: function() { 
                    blockPage(cardSection,"Restoring delivery order record...");
                },
                success: async function(data) {
                    await undoVoidDeliveryOrderFn(data);
                },
                error: function () { 
                    unblockPage(cardSection);     
                },
            });
        }

        function undoVoidDeliveryOrderFn(data){
            if(data.dberrors) {
                toastrMessage('error',"Please contact administrator","Error");
                unblockPage(cardSection);
            }
            else if(data.create_error){
                toastrMessage('error',"Cannot restore. Another record already exists with reference number.","Error");
                unblockPage(cardSection);
            }
            else if(data.success){
                toastrMessage('success',"Successful","Success");
                createDOInfoFn(data.rec_id);
                countDOStatusFn(data.fiscal_year);
                refreshMainDatatbleFn();
            }
        }
        //-----Void & Undo Void End------

        function productTypeFn(){
            $('#product-type-error').html("");
        }

        function openReferenceDocFn(){
            var reference_type = $('#ReferenceType').val();
            var reference = $('#Reference').val();

            if(reference == null || reference == ""){
                $('#reference-doc-error').html("Reference field is required");
                toastrMessage('error',"Please fill required field","Error");
            }
            else{
                var link = null;
                if(reference_type == 601){
                    link = `/proformadownload/${reference}`;
                }
                else if(reference_type == 602){
                    
                }
                else if(reference_type == 603){
                    link = `/salereport/${reference}`;
                }
                
                window.open(link, '', 'width=1200,height=800,scrollbars=yes');
            }
        }

        function openReferenceDocLinkFn(reference_type,reference){
            if(reference == null || reference == ""){
                $('#reference-doc-error').html("Reference field is required");
                toastrMessage('error',"Please fill required field","Error");
            }
            else{
                var link = null;
                if(reference_type == 601){
                    link = `/proformadownload/${reference}`;
                }
                else if(reference_type == 602){
                    
                }
                else if(reference_type == 603){
                    link = `/salereport/${reference}`;
                }
                
                window.open(link, '', 'width=1200,height=800,scrollbars=yes');
            }
        }

        function deliveryDateFn(){
            $('#delivery-date-error').html("");
        }

        function expiryDateFn(){
            $('#expiry-date-error').html("");
        }

        function orderedByFn(){
            $('#orderby-error').html("");
        }

        function salesPersonFn(){
            $('#sales-person-error').html("");
        }

        function docNumberFn(){
            $('#docnumber-error').html("");
        }

        function paymentTypeFn(){
            $('#paymentType-error').html("");
        }

        function PaymentTermFn(){
            $('#paymentTerm-error').html("");
        }

        function remarkFn(){
            $('#remark-error').html("");
        }

        function customerFn(){
            $('#customer-error').html("");
        }

        function deliverByFn(){
            $('#deliverby-error').html("");
        }

        function phoneNoFn(){
            $('#phone-no-error').html("");
        }

        function idNumberFn(){
            $('#id-no-error').html("");
        }

        function plateNumFn(){
            $('#platenum-error').html("");
        }

        function voidReasonFn(){
            $('#void-error').html("");
        }

        function backwardReasonFn(){
            $('#commentres-error').html("");
        }

        function fillProductTypeDataFn(ref_type){
            if(ref_type == 600){
                var product_type_options = `
                    <option value="Goods">Goods</option>
                    <option value="Commodity">Commodity</option>
                    <option value="Metal">Metal</option>`;

                var customer_options = $("#default_customer > option").clone();
                var station_options = $("#default_station > option").clone();

                $('#ProductType').empty().append(product_type_options).val(null).select2({
                    placeholder: "Select product type here",
                    minimumResultsForSearch: -1
                });

                $('#customer').empty().append(customer_options).val(null).select2({
                    placeholder: "Select customer here",
                });

                $('#station').empty().append(station_options).val(null).select2({
                    placeholder: "Select station here",
                });
            }
            else{
                $('#ProductType').empty().select2({
                    placeholder: "Select reference document first",
                    minimumResultsForSearch: -1
                });

                $('#customer').empty().select2({
                    placeholder: "Select reference document first",
                    minimumResultsForSearch: -1
                });
            }
        }

        $(document).on('show.bs.collapse hide.bs.collapse', '.collapse', function (e) {
            e.stopPropagation();
            const collapse = $(this);
            const container = collapse.closest('.card, .modal-content, .row');
            const infoTarget = container.find('.do_header_info');
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
                const reference_type = container.find('#info_reference_type').text().trim();
                const station = container.find('#info_station').text().trim();
                const customer_name = container.find('#info_customer_name').text().trim();
                const summaryHtml = `
                    Reference Type: <b>${reference_type}</b>, 
                    Customer Name: <b>${customer_name}</b>, 
                    Station: <b>${station}</b>`;
                infoTarget.html(summaryHtml);
            }
        });

        function countDOStatusFn(fiscalyear){
            var fyear = 0;
            var do_void_cnt = 0;
            
            $.ajax({
                url: '/countDOStatus',
                type: 'POST',
                data:{
                    fyear: fiscalyear,
                },
                dataType: 'json',
                success: function(data) {
                    $(".do_status_record_lbl").html("0");
                    $.each(data.delivery_order_status, function(key, value) {
                        if(value.status == "Draft"){
                            $("#do_draft_record_lbl").html(value.status_count);
                        }
                        else if(value.status == "Pending"){
                            $("#do_pending_record_lbl").html(value.status_count);
                        }
                        else if(value.status == "Verified"){
                            $("#do_verified_record_lbl").html(value.status_count);
                        }
                        else if(value.status == "Approved"){
                            $("#do_approved_record_lbl").html(value.status_count);
                        }
                        else if(value.status == "Total"){
                            $("#do_total_record_lbl").html(value.status_count);
                        }
                        else {
                            do_void_cnt += parseInt(value.status_count);
                            $("#do_void_record_lbl").html(do_void_cnt);
                        }
                    });

                    $("#do_ready_record_lbl").html(data.ready_do_cnt);
                }
            });
        }

        function resetDOFormFn(){
            $('#ReferenceType').val(null).select2({
                placeholder: "Select reference type here",
                minimumResultsForSearch: -1
            });
            $('#Reference').val(null).select2({
                placeholder: "Select reference document here",
            });
            $('#ProductType').empty().select2({
                placeholder: "Select product type here",
                minimumResultsForSearch: -1
            });
            $('#station').val(null).select2({
                placeholder: "Select station here",
            });
            $('#OrderedBy').val(null).select2({
                placeholder: "Select order by here",
            });
            $('#SalesPerson').empty().select2({
                placeholder: "Select sales person here",
            });
            $('#PaymentType').val(null).select2({
                placeholder: "Select payment type here",
                minimumResultsForSearch: -1
            });
            $('#PaymentTerm').val(null).select2({
                placeholder: "Select payment term here",
                minimumResultsForSearch: -1
            });
            $('#customer').val(null).select2({
                placeholder: "Select reference type first",
            });
            $('.default_hidden_div').hide();
            $('.direct-reference').hide();
            $('.reg_form').val("");
            $('#VisiblePrice').prop('checked', false);
            showCostColumnFn();
            $('.non_direct_reference').hide();
            $('.direct_reference').hide();
            $('#delivery_order_status').html("");
            $('.errordatalabel').html("");
            flatpickr('#DeliveryDate', { dateFormat: 'Y-m-d',clickOpens:true,maxDate:current_date});
            flatpickr('#ExpiryDate', { dateFormat: 'Y-m-d',clickOpens:true,minDate:current_date});
            $("#dynamicTable > tbody").empty();
            $('#operationtypes').val(1);
        }

        function refreshDOFn(){
            var f_year = $('#do_fy').val();
            countDOStatusFn(f_year);

            table.ajax.reload(function() {
                unblockPage(cardSection);
            }, false); 
        }

        function refreshMainDatatbleFn(){
            var oTable = $('#laravel-datatable-crud').dataTable(); 
            oTable.fnDraw(false);
        }

        function refreshDTUpdateFn(){
            table.ajax.reload(function() {
                unblockPage(cardSection);
            }, false); 
        }
        
        function numformat(val) {
            while (/(\d+)(\d{3})/.test(val.toString())) {
                val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
            }
            return val;
        }
    </script>
@endsection