@extends('layout.app1')
@section('title')
@endsection
@section('content')
    <div class="app-content content">
        <section id="responsive-datatable fit-content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom mb-0 pb-0">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="row">
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-3" style="text-align: left !important;align-items: center;padding: 10px 5px;">
                                        <h3 class="card-title form_title">Goods Receiving</h3>
                                    </div>
                                    <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-6" style="text-align: center !important;">
                                        <ul class="nav nav-tabs justify-content-center" role="tablist"> 
                                            <li class="nav-item">
                                                <a class="nav-link active header-tab pur-view receiving-tab-view" id="purchase-tab" data-toggle="tab" href="#purchase-view" aria-controls="purchase-tab" role="tab" aria-selected="false" title="Purchase List"><i class="fas fa-dolly"></i><span class="tab-text">Purchase</span></a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link header-tab prd-view receiving-tab-view" id="production-tab" data-toggle="tab" href="#production-view" aria-controls="production-tab" role="tab" aria-selected="true" title="Production List"><i class="fas fa-industry"></i><span class="tab-text">Production</span></a>                                
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3" style="text-align: right !important;align-items: center;padding: 10px 5px;">
                                        <button type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm" onclick="refreshReceivingDataFn()"><i class="fas fa-sync-alt"></i></button>
                                        @if (auth()->user()->can('Receiving-Add'))
                                        <button type="button" class="btn btn-gradient-info btn-sm addrecbutton header-prop" id="addrecbutton"><i class="fas fa-plus"></i><span class="header-text">&nbsp Add</span></button>
                                        @endcan 
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-datatable">
                            <div class="tab-content">
                                <div class="tab-pane active pur-view receiving-tab-view" id="purchase-view" aria-labelledby="purchase-view" role="tabpanel">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
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
                                                            <span class="font-weight-bolder mb-0 receiving_status_record_lbl" id="receiving_draft_record_lbl"></span>
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
                                                            <span class="font-weight-bolder mb-0 receiving_status_record_lbl" id="receiving_pending_record_lbl"></span>
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
                                                            <span class="font-weight-bolder mb-0 receiving_status_record_lbl" id="receiving_checked_record_lbl"></span>
                                                            <p class="card-text font-small-3 mb-0">Checked</p>
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
                                                            <span class="font-weight-bolder mb-0 receiving_status_record_lbl" id="receiving_confirmed_record_lbl"></span>
                                                            <p class="card-text font-small-3 mb-0">Confirmed</p>
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
                                                            <span class="font-weight-bolder mb-0 receiving_status_record_lbl" id="receiving_void_record_lbl"></span>
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
                                                            <span class="font-weight-bolder mb-0 receiving_status_record_lbl" id="receiving_total_record_lbl"></span>
                                                            <p class="card-text font-small-3 mb-0">Total</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6 col-lg custom-col mb-1" title="Purchase Orders and Invoices ready for receiving" id="ready_for_receiving_div" style="display: none;">
                                                <div class="stat-item">
                                                    <div class="media">
                                                        <div class="avatar bg-light-success mr-1">
                                                            <div class="avatar-content">
                                                                <i class="fa-solid fa-check-double"></i>
                                                            </div>
                                                        </div>
                                                        <div class="media-body my-auto mr-1">
                                                            <span class="font-weight-bolder mb-0 receiving_status_record_lbl" id="receiving_ready_record_lbl"></span>
                                                            <p class="card-text font-small-3 mb-0">Ready for Receiving</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>      
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="row main_datatable" id="receiving_tbl" style="display: none;">
                                            <div style="width:99%; margin-left:0.5%;">
                                                <table id="laravel-datatable-crud" class="display table-bordered table-striped table-hover defaultdatatable mb-0 mobile-dt" style="width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 0%;display:none;"></th>
                                                            <th style="width: 3%;">#</th>
                                                            <th style="width: 12%;" title="Good Receiving Voucher Number">GRV No.</th>
                                                            <th style="width: 14%;">Reference Type</th>
                                                            <th style="width: 15%;">Reference</th>
                                                            <th style="width: 7%;">Product Type</th>
                                                            <th style="width: 14%;">Supplier Name</th>
                                                            <th style="width: 7%;" title="Taxpayer Identification Number">TIN</th> 
                                                            <th style="width: 7%;">Payment Type</th>
                                                            <th style="width: 11%;">Station</th>
                                                            <th style="width: 6%;">Invoice Type</th>
                                                            <th style="width: 6%;" title="MRC Number">MRC No.</th>
                                                            <th style="width: 6%;" title="Document or FS Number">FS No.</th>
                                                            <th style="width: 6%;" title="Invoice or Reference Number">Invoice No.</th>
                                                            <th style="width: 6%;">Invoice Date</th>
                                                            <th style="width: 8%;">Received Date</th>
                                                            <th style="width: 6%;">Status</th>
                                                            <th style="width: 4%;">Action</th>
                                                            <th style="width: 0%;display:none;"></th>
                                                            <th style="width: 0%;display:none;"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="table table-sm"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="tab-pane prd-view receiving-tab-view" id="production-view" aria-labelledby="production-view" role="tabpanel">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="row mt-1 border-bottom">
                                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-4 col-4 mb-1">
                                                <div class="stat-item">
                                                    <div class="media">
                                                        <div class="avatar bg-light-secondary mr-1">
                                                            <div class="avatar-content">
                                                                <i class="fas fa-industry"></i>
                                                            </div>
                                                        </div>
                                                        <div class="media-body my-auto mr-1">
                                                            <span class="font-weight-bolder mb-0 prd_rec_status_record_lbl" id="prd_rec_draft_record_lbl"></span>
                                                            <p class="card-text font-small-3 mb-0">Draft</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-4 col-4 mb-1">
                                                <div class="stat-item">
                                                    <div class="media">
                                                        <div class="avatar bg-light-warning mr-1">
                                                            <div class="avatar-content">
                                                                <i class="fas fa-industry"></i>
                                                            </div>
                                                        </div>
                                                        <div class="media-body my-auto mr-1">
                                                            <span class="font-weight-bolder mb-0 prd_rec_status_record_lbl" id="prd_rec_pending_record_lbl"></span>
                                                            <p class="card-text font-small-3 mb-0">Pending</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-4 col-4 mb-1">
                                                <div class="stat-item">
                                                    <div class="media">
                                                        <div class="avatar bg-light-primary mr-1">
                                                            <div class="avatar-content">
                                                                <i class="fas fa-industry"></i>
                                                            </div>
                                                        </div>
                                                        <div class="media-body my-auto mr-1">
                                                            <span class="font-weight-bolder mb-0 prd_rec_status_record_lbl" id="prd_rec_checked_record_lbl"></span>
                                                            <p class="card-text font-small-3 mb-0">Checked</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-lg-2 col-md-3 col-sm-4 col-4 mb-1">
                                                <div class="stat-item">
                                                    <div class="media">
                                                        <div class="avatar bg-light-success mr-1">
                                                            <div class="avatar-content">
                                                                <i class="fas fa-industry"></i>
                                                            </div>
                                                        </div>
                                                        <div class="media-body my-auto mr-1">
                                                            <span class="font-weight-bolder mb-0 prd_rec_status_record_lbl" id="prd_rec_confirmed_record_lbl"></span>
                                                            <p class="card-text font-small-3 mb-0">Confirmed</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-4 col-4 mb-1">
                                                <div class="stat-item">
                                                    <div class="media">
                                                        <div class="avatar bg-light-danger mr-1">
                                                            <div class="avatar-content">
                                                                <i class="fas fa-industry"></i>
                                                            </div>
                                                        </div>
                                                        <div class="media-body my-auto mr-1">
                                                            <span class="font-weight-bolder mb-0 prd_rec_status_record_lbl" id="prd_rec_void_record_lbl"></span>
                                                            <p class="card-text font-small-3 mb-0">Void</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-4 col-4 mb-1">
                                                <div class="stat-item">
                                                    <div class="media">
                                                        <div class="avatar bg-light-secondary mr-1">
                                                            <div class="avatar-content">
                                                                <i class="fas fa-industry"></i>
                                                            </div>
                                                        </div>
                                                        <div class="media-body my-auto mr-1">
                                                            <span class="font-weight-bolder mb-0 prd_rec_status_record_lbl" id="prd_rec_total_record_lbl"></span>
                                                            <p class="card-text font-small-3 mb-0">Total</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>      
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="row main_datatable" id="prd_tbl">
                                            <div style="width:99%; margin-left:0.5%;">
                                                <table id="laravel-datatable-crud-prd" class="display table-bordered table-striped table-hover defaultdatatable mb-0 mobile-dt" style="width: 100%">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 0%;display:none;"></th>
                                                            <th style="width: 3%;">#</th>
                                                            <th style="width: 15%;" title="Good Receiving Voucher Number">GRV No.</th>
                                                            <th style="width: 16%;" title="Production Number">Production No.</th>
                                                            <th style="width: 16%;" title="Requisition Number">Requisition No.</th>
                                                            <th style="width: 16%;">Station</th>
                                                            <th style="width: 15%;">Date</th>
                                                            <th style="width: 15%;">Status</th>
                                                            <th style="width: 4%;">Action</th>
                                                            <th style="width: 0%;display:none;"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="table table-sm"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" class="form-control" name="fiscalyearval" id="fiscalyearval" value="{{$fiscalyr}}" readonly/>
                            <input type="hidden" class="form-control" name="currentdateval" id="currentdateval" value="{{$curdate}}" readonly/>
                            <input type="hidden" class="form-control" name="receiving_mode" id="receiving_mode" value="{{$receiving_mode}}" readonly/>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!--Start Info Modal -->
    <div class="modal fade text-left fit-content" id="docInfoModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="docInfoModal" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title form_title" id="receivinginfomodaltitle">Receiving Information</h4>
                    <div class="row">
                        <div style="text-align: right;" class="form_title info_modal_title_lbl" id="statustitles"></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>  
                </div>
                <form id="receivingInfoForm">
                    @csrf
                    <div class="modal-body">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <section id="card-text-alignment">
                                        <div class="d-flex justify-content-between align-items-center cursor-pointer border-bottom" data-toggle="collapse" data-target=".infoscl" aria-expanded="true">
                                            <h5 class="mb-0 form_title receiving_header_info"><i class="far fa-info-circle"></i> Basic Information</h5>
                                            <div class="d-flex align-items-center header-tab">
                                                <span class="text-uppercase font-weight-bold mr-50 toggle-text-label tab-text">Collapse</span>
                                                <div class="collapse-icon">
                                                    <i class="fas text-secondary fa-minus-circle"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="collapse show infoscl shadow pl-1 pr-1">
                                            <div class="row mb-1">
                                                
                                                <div class="col-xl-3 col-lg-12 col-md-12 col-sm-12 col-12 mt-1">
                                                    <div class="card shadow-none border m-0">
                                                        <div class="card-body">
                                                            <h6 class="card-title mb-0">
                                                                <i class="fas fa-share-alt"></i> Source Information
                                                            </h6>
                                                            <hr class="my-50">
                                                            <table class="infotbl" style="width:100%;font-size:12px;">
                                                                <tr>
                                                                    <td><label class="info_lbl">Source Type</label></td>
                                                                    <td><label class="info_lbl" id="info_source_type" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr class="purchase_tr">
                                                                    <td><label class="info_lbl">Reference Type</label></td>
                                                                    <td><label class="info_lbl" id="infoReferenceType" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr class="procurement_cl purchase_tr" id="reference_td">
                                                                    <td><label class="info_lbl">Reference</label></td>
                                                                    <td><label class="info_lbl" id="infoReference" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr class="purchase_tr">
                                                                    <td><label class="info_lbl">Product Type</label></td>
                                                                    <td><label class="info_lbl" id="infoProductType" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 mt-1 mb-1 info_common_div" id="info_purchase_div">
                                                    <div class="card shadow-none border m-0">
                                                        <div class="card-body mb-0">
                                                            <h6 class="card-title mb-0"><i class="fas fa-dolly"></i> Purchase Information</h6>
                                                            <hr class="my-50">
                                                            <div class="row">
                                                                <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                    <table class="infotbl" style="width:100%;font-size:12px;">
                                                                        <tr>
                                                                            <td colspan="2" class="text-center"><b><u>Supplier Information</u></b></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label class="info_lbl" title="Supplier Name">Name</label></td>
                                                                            <td><label class="info_lbl" id="infoDocCustomerName" style="font-weight: bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label class="info_lbl" title="Supplier Code">Code</label></td>
                                                                            <td><label class="info_lbl" id="infoCusCode" style="font-weight: bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label class="info_lbl" title="Supplier Category">Category</label></td>
                                                                            <td><label class="info_lbl" id="infoCusCategory" style="font-weight: bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label class="info_lbl" title="Taxpayer Identification Number">TIN</label></td>
                                                                            <td><label class="info_lbl" id="infoCusTin" style="font-weight: bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label class="info_lbl" title="Vat Registration Number">VAT No.</label></td>
                                                                            <td><label class="info_lbl" id="infoCusVat" style="font-weight: bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label class="info_lbl" title="Supplier Phone Number">Phone No.</label></td>
                                                                            <td><label class="info_lbl" id="infoCusPhone" style="font-weight: bold;"></label></td>
                                                                        </tr>
                                                                        <tr class="procurement_cl">
                                                                            <td><label class="info_lbl" title="Document Number">Document No.</label></td>
                                                                            <td><label class="info_lbl" id="infoDocNumber" style="font-weight: bold;"></label></td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                                <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 receipt_data_cl">
                                                                    <table class="infotbl" style="width:100%;font-size:12px;">
                                                                        <tr>
                                                                            <td colspan="2" class="text-center"><b><u>Receipt Information</u></b></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label class="info_lbl">Payment Type</label></td>
                                                                            <td><label class="info_lbl" id="infoDocPaymentType" style="font-weight: bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label class="info_lbl">Receiving Type</label></td>
                                                                            <td><label class="info_lbl" id="infoVoucherStatus" style="font-weight: bold;"></label></td>
                                                                        </tr>
                                                                        <tr class="receipt-prop">
                                                                            <td><label class="info_lbl">Invoice Type</label></td>
                                                                            <td><label class="info_lbl" id="infoDocVoucherType" style="font-weight: bold;"></label></td>
                                                                        </tr>
                                                                        <tr class="receipt-prop">
                                                                            <td><label class="info_lbl">Invoice Date</label></td>
                                                                            <td><label class="info_lbl infoDocDate" id="infoInvoiceDocDate" style="font-weight: bold;"></label></td>
                                                                        </tr>
                                                                        <tr class="receipt-prop">
                                                                            <td><label class="info_lbl" title="Manual Document or FS Number">FS No.</label></td>
                                                                            <td><label class="info_lbl" id="infoDocVoucherNumber" style="font-weight: bold;"></label></td>
                                                                        </tr>
                                                                        <tr class="receipt-prop">
                                                                            <td><label class="info_lbl" title="Invoice Number">Invoice No.</label></td>
                                                                            <td><label class="info_lbl" id="infoinvoicenumber" style="font-weight: bold;"></label></td>
                                                                        </tr>
                                                                        <tr class="receipt-prop">
                                                                            <td><label class="info_lbl" title="MRC Number">MRC No.</label></td>
                                                                            <td><label class="info_lbl" id="infoDocMrcNumber" style="font-weight: bold;"></label></td>
                                                                        </tr>
                                                                        <tr class="infowitholdrectr" style="display: none;">
                                                                            <td><label class="info_lbl" title="Withholding Receipt Number">Withholding Rec. No.</label></td>
                                                                            <td><label id="infoWitholdReceiptLbl" style="font-weight: bold;"></label></td>
                                                                        </tr>
                                                                        <tr class="infowitholdrectr" style="display: none;">
                                                                            <td><label class="info_lbl" title="Withholding Receipt Date">Withholding Rec. Date</label></td>
                                                                            <td><label id="infoWitholdDateLbl" style="font-weight: bold;"></label></td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 mt-1 info_common_div" id="info_production_div">
                                                    <div class="card shadow-none border m-0">
                                                        <div class="card-body">
                                                            <h6 class="card-title mb-0"><i class="fas fa-industry"></i> Production Information</h6>
                                                            <hr class="my-50">
                                                            <table class="infotbl" style="width:100%;font-size:12px;">
                                                                <tr>
                                                                    <td><label class="info_lbl">Production No.</label></td>
                                                                    <td><label class="info_lbl" id="info_receiving_prdno" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl">Requisition No.</label></td>
                                                                    <td><label class="info_lbl" style="font-weight: bold;" id="info_receiving_reqno"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl">Delivered By</label></td>
                                                                    <td><label class="info_lbl info_delivered_by" style="font-weight: bold;" id="info_delivered_by_pur"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl">Production Date</label></td>
                                                                    <td><label class="info_lbl infoDocDate" id="infoProductionDocDate" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-3 col-lg-12 col-md-12 col-sm-12 col-12 mt-1">
                                                    <div class="card shadow-none border mb-1">
                                                        <div class="card-body">
                                                            <h6 class="card-title mb-0"><i class="fas fa-database"></i> General Information</h6>
                                                            <hr class="my-50">
                                                            <table class="infotbl" style="width:100%;font-size:12px;">
                                                                <tr>
                                                                    <td><label class="info_lbl">Station</label></td>
                                                                    <td><label class="info_lbl" style="font-weight: bold;" id="infoDocReceivingStore"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl">Received By</label></td>
                                                                    <td><label class="info_lbl" style="font-weight: bold;" id="info_received_by"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl">Received Date</label></td>
                                                                    <td><label class="info_lbl" style="font-weight: bold;" id="info_received_date"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl">Remark</label></td>
                                                                    <td><label class="info_lbl" style="font-weight: bold;" id="info_receiving_remark"></label></td>
                                                                </tr>
                                                                <tr class="delivery_info_cl" style="display: none;">
                                                                    <td colspan="2" class="text-center"><b><u>Delivery Information</u></b></td>
                                                                </tr>
                                                                <tr class="delivery_info_cl" style="display: none;">
                                                                    <td><label class="info_lbl">Delivered By</label></td>
                                                                    <td><label class="info_lbl info_delivered_by" style="font-weight: bold;" id="info_delivered_by_prd"></label></td>
                                                                </tr>
                                                                <tr class="delivery_info_cl" style="display: none;">
                                                                    <td><label class="info_lbl">Plate No.</label></td>
                                                                    <td><label class="info_lbl" style="font-weight: bold;" id="info_plate_no"></label></td>
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
                                    <div class="tab-pane rec_info_tab tab-view" id="info-rec-view" role="tabpanel" aria-labelledby="info-rec-view">
                                        <ul class="nav nav-tabs nav-fill" role="tablist">
                                            <li class="nav-item formnavitm note">
                                                <a class="nav-link active receiving-tabs tab-title active-tab-title" id="info_rec_item_tab" data-toggle="tab" href="#info_rec_item_view" aria-controls="info_rec_item_tab" role="tab" aria-selected="true" title="Items"><i class="fas fa-list-ul"></i><span class="tab-text">Items</span></a>                                
                                            </li>
                                            <li class="nav-item formnavitm note">
                                                <a class="nav-link receiving-tabs tab-title" id="info_rec_doc_tab" data-toggle="tab" href="#info_rec_doc_view" aria-controls="info_rec_doc_tab" role="tab" aria-selected="true" title="Documents"><i class="fas fa-file-alt"></i><span class="tab-text">Documents</span></a>                                
                                            </li>
                                        </ul>
                                        <div class="tab-content formtabcon" style="margin-top:-14px;">
                                            <div class="tab-pane receiving-view active tab-view active-tab-view border" id="info_rec_item_view" aria-labelledby="info_rec_item_view" role="tabpanel">
                                                <div class="row mt-0 mr-1 ml-1 mb-1">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <div class="table-responsive scroll scrdiv">
                                                            <div class="row infoRecDiv">
                                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="receiving_item_div">
                                                                    <table id="docRecInfoItem" class="display table-bordered table-striped dt-responsive defaultdatatable mb-0 info_datatable receiving_item_dt" style="width: 100%;">
                                                                        <thead>
                                                                            <tr>
                                                                                <th style="display: none;"></th>
                                                                                <th style="width: 2%"></th>
                                                                                <th style="width: 3%">#</th>
                                                                                <th style="width: 10%">Item Code</th>
                                                                                <th style="width: 20%">Item Name</th>
                                                                                <th style="width: 10%" title="Barcode Number">Barcode No.</th>
                                                                                <th style="width: 7%" title="Unit of Measurement">UOM</th>
                                                                                <th style="width: 7%">Quantity</th>
                                                                                <th style="width: 8%">Unit Cost</th>
                                                                                <th id="before_total_cost" style="width: 10%">Before Tax</th>
                                                                                <th style="width: 10%">Tax Amount</th>
                                                                                <th style="width: 10%">Total Cost</th>
                                                                                <th style="width: 3%"></th>
                                                                                <th style="display: none;"></th>
                                                                                <th style="display: none;"></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody class="table table-sm"></tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xl-9 col-lg-6 col-md-3 col-sm-3 col-12" id="witholdingtablediv"></div>
                                                                <div class="col-xl-3 col-lg-6 col-md-9 col-sm-9 col-12 mt-1 receipt_data_total_price" style="text-align: right;">
                                                                    <table style="width: 100%;font-size:12px" class="rtable infoRecDiv" id="receiving_pricing_tbl">
                                                                        <tr>
                                                                            <td style="text-align: right;width:55%;">
                                                                                <label id="info_subtotal_lbl" class="info_lbl">Sub Total</label>
                                                                            </td>
                                                                            <td style="text-align: center;width:45%;">
                                                                                <label id="infosubtotalLbl" class="formattedNum info_lbl" style="font-weight: bold;"></label>
                                                                                <input type="hidden" class="form-control" name="infosubtotali" id="infosubtotali" readonly="true" value="0" />
                                                                            </td>
                                                                        </tr>
                                                                        <tr class="vatpropinfo">
                                                                            <td style="text-align: right;">
                                                                                <label class="info_lbl" id="info_tax_pricing_tbl">Tax</label>
                                                                            </td>
                                                                            <td style="text-align: center;">
                                                                                <label id="infotaxLbl" class="formattedNum info_lbl" style="font-weight: bold;"></label>
                                                                                <input type="hidden" class="form-control" name="infotaxi" id="infotaxi" readonly="true" value="0" />
                                                                            </td>
                                                                        </tr>
                                                                        <tr class="vatpropinfo">
                                                                            <td style="text-align: right;">
                                                                                <label class="info_lbl">Grand Total</label>
                                                                            </td>
                                                                            <td style="text-align: center;">
                                                                                <label id="infograndtotalLbl" class="formattedNum info_lbl" style="font-weight: bold;"></label>
                                                                                <input type="hidden" class="form-control" name="infograndtotali" id="infograndtotali" readonly="true" value="0" />
                                                                            </td>
                                                                        </tr>
                                                                        <tr id="infowitholdingTr" style="display: none">
                                                                            <td style="text-align: right;">
                                                                                <label id="settledLabelPr" class="badge badge-success withold_lbl withhold_sett_lbl" style="font-size: 9px;font-weight:bold;">Settled</label>
                                                                                <label id="notsettledLabelPr" class="badge badge-warning withold_lbl withhold_notsett_lbl" style="font-size: 9px;font-weight:bold;">Not-Settled</label>
                                                                                <label id="infowitholdingTitle" class="info_lbl">Witholding</label>
                                                                            </td>
                                                                            <td style="text-align: center;">
                                                                                <label id="infowitholdinglbl" class="formattedNum info_lbl" style="font-weight: bold;"></label>
                                                                                <input type="hidden" class="form-control" name="infowitholdingi" id="infowitholdingi" readonly="true" value="0" />
                                                                            </td>
                                                                        </tr>
                                                                        <tr id="infonetpayTr" style="display: none">
                                                                            <td style="text-align: right;">
                                                                                <label class="info_lbl">Net Pay</label>
                                                                            </td>
                                                                            <td style="text-align: center;">
                                                                                <label id="infoNetPayLbl" class="formattedNum info_lbl" style="font-weight: bold;"></label>
                                                                                <input type="hidden" class="form-control" name="infoNetPayi" id="infoNetPayi" readonly="true" value="0" />
                                                                            </td>
                                                                        </tr>
                                                                        <tr style="display: none;">
                                                                            <td style="text-align: right;">
                                                                                <label class="info_lbl">No. of Items</label>
                                                                            </td>
                                                                            <td style="text-align: center;">
                                                                                <label id="infonumberofItemsLbl" class="info_lbl" style="font-weight: bold;"></label>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane receiving-view tab-view border" id="info_rec_doc_view" aria-labelledby="info_rec_doc_view" role="tabpanel">
                                                <div class="row mt-0 mr-1 ml-1 mb-1">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="document_div" style="display: none;">
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
                                        <button type="button" class="btn btn-outline-info dropdown-toggle hide-arrow action-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa-sharp fa-solid fa-caret-up fa-xl"></i><span class="btn-text">&nbsp Actions</span>
                                        </button>
                                        <ul class="dropdown-menu" id="receiving_action_ul"></ul>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align:right">
                                    <input type="hidden" class="form-control" name="usernamelbl" id="usernamelbl" readonly="true" value="{{$user}}">
                                    <input type="hidden" class="form-control" name="selectedids" id="selectedids" readonly="true">
                                    <input type="hidden" class="form-control" name="recordIds" id="recordIds" readonly="true">
                                    <input type="hidden" class="form-control" name="statusIds" id="statusIds" readonly="true">
                                    <input type="hidden" class="form-control" name="customerIdInp" id="customerIdInp" readonly="true">
                                    <input type="hidden" class="form-control" name="info_source_types" id="info_source_types" readonly="true">
                                    <input type="hidden" class="form-control" name="info_reference_type" id="info_reference_type" readonly="true">
                                    <input type="hidden" class="form-control" name="info_cost_visibility" id="info_cost_visibility" readonly="true">
                                    <input type="hidden" class="form-control" name="info_voucher_status" id="info_voucher_status" readonly="true">

                                    <input type="hidden" class="form-control" name="infoWitholdPercent" id="infoWitholdPercent" readonly="true">
                                    <input type="hidden" class="form-control" name="currentStatus" id="currentStatus" readonly="true">
                                    <input type="hidden" class="form-control" name="forwardReqId" id="forwardReqId" readonly="true">
                                    <input type="hidden" class="form-control" name="newForwardStatusValue" id="newForwardStatusValue" readonly="true">
                                    <input type="hidden" class="form-control" name="forwarkBtnTextValue" id="forwarkBtnTextValue" readonly="true">
                                    <input type="hidden" class="form-control" name="forwardActionValue" id="forwardActionValue" readonly="true">
                                    
                                    <button id="closebuttonrec" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Info Modal -->

    <!--Start Registration Modal -->
    <div class="modal fade text-left fit-content" id="inlineForm" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="inlineForm" aria-hidden="true" style="overflow-y:scroll;">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="newreceivingmodaltitles">Add Receiving</h4>
                    <div class="row">
                        <div style="text-align: right;" id="statusdisplay"></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>   
                </div>
                <form id="RegisterRec">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row"> 
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-0 mb-1">
                                <div class="demo-inline-spacing">
                                    <div class="custom-control custom-radio mt-0">
                                        <input type="radio" id="SourceType1" name="SourceType" class="custom-control-input" value="Purchase"/>
                                        <label class="custom-control-label form_lbl" for="SourceType1">Purchase</label>
                                    </div>
                                    <div class="custom-control custom-radio mt-0">
                                        <input type="radio" id="SourceType2" name="SourceType" class="custom-control-input" value="Production"/>
                                        <label class="custom-control-label form_lbl" for="SourceType2">Production</label>
                                    </div>
                                </div>
                                <span class="text-danger">
                                    <strong id="source_type-error" class="errordatalabel"></strong>
                                </span>
                            </div>

                            <div class="col-xl-9 col-lg-8 col-md-12 col-sm-12 col-12 mb-1 purchase_class major_class" style="display: none;">
                                <fieldset class="fset">
                                    <legend>Purchase Data</legend>
                                    <div class="row">
                                        <div class="col-xl-7 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                            <div class="divider" style="margin-top:-1rem;">
                                                <div class="divider-text"><b>Source Data</b></div>
                                            </div>
                                            <div class="row" style="margin-top:-1rem;">
                                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-1" style="position: relative;" class="select-wrapper">
                                                    <label class="form_lbl">Reference Type<b style="color: red; font-size:16px;">*</b></label>
                                                    <select class="select2 form-control" name="ReferenceType" id="ReferenceType"></select>
                                                    <span class="text-danger">
                                                        <strong id="reference-type-error" class="errordatalabel purchase_error"></strong>
                                                    </span>
                                                </div>
                                                <div class="col-xl-5 col-lg-4 col-md-4 col-sm-12 col-12 mb-1 reference_doc default_hidden_div" id="reference_doc_div">
                                                    <label class="form_lbl" title="Reference">Reference<b style="color: red; font-size:16px;">*</b></label>
                                                    <select class="select2 form-control" name="Reference" id="Reference"></select>
                                                    <span class="text-danger">
                                                        <strong id="reference-doc-error" class="errordatalabel purchase_error"></strong>
                                                    </span>
                                                </div>
                                                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-12 col-12 mb-1" id="product_type_div">
                                                    <label class="form_lbl">Product Type<b style="color: red; font-size:16px;">*</b></label>
                                                    <select class="select2 form-control" name="ProductType" id="ProductType" onchange="productTypeFn()">
                                                    </select>
                                                    <span class="text-danger">
                                                        <strong id="product-type-error" class="errordatalabel purchase_error"></strong>
                                                    </span>
                                                </div>
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 source_data_dynamic_div" id="src_expiry_date">
                                                    <label class="form_lbl" id="reference_date_lbl"></label>
                                                </div>
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 source_data_dynamic_div" id="src_cost_visibility">
                                                    <div class="form-check form-check-inline">
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="VisibleCost" name="VisibleCost"/>
                                                            <label class="custom-control-label form_lbl" for="VisibleCost">Show Cost Columns</label>                                  
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-5 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                            <div class="divider" style="margin-top:-1rem;">
                                                <div class="divider-text"><b>Supplier Data</b></div>
                                            </div>
                                            <div class="row" style="margin-top:-1rem;">
                                                <div class="col-xl-7 col-lg-7 col-md-7 col-sm-7 col-12 mb-1">
                                                    <label class="form_lbl">Supplier<b style="color: red; font-size:16px;">*</b></label>
                                                    <select class="select2 form-control purchase_select" name="supplier" id="supplier" onchange="supplierVal()"></select>
                                                    <span class="text-danger">
                                                        <strong id="supplier-error" class="errordatalabel purchase_error"></strong>
                                                    </span>
                                                </div>
                                                <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-12 mb-1" id="document_no_div">
                                                    <label class="form_lbl" title="Document Number">Document No.</label>
                                                    <input type="text" name="DocumentNumber" id="DocumentNumber" placeholder="Enter document number here" class="form-control mainforminp purchase_input" onkeyup="docNumberFn()"/>
                                                    <span class="text-danger">
                                                        <strong id="docnumber-error" class="errordatalabel purchase_error"></strong>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 receipt_data_div">
                                            <div class="divider" style="margin-top:-1rem;">
                                                <div class="divider-text">
                                                    <b>Receipt Data</b>
                                                    <div class="form-check form-check-inline mb-1">
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" title="If checked purchase have receipt else no receipt found!" id="VoucherSt" name="VoucherStatus" checked/>
                                                            <label class="custom-control-label form_lbl" for="VoucherSt"></label>                                  
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" style="margin-top:-1rem;">
                                                <div class="col-xl-2 col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                                                    <label class="form_lbl">Payment Type<b style="color: red; font-size:16px;">*</b></label>
                                                    <select class="select2 form-control purchase_select receipt_select" name="PaymentType" id="PaymentType" onchange="paymentTypeVal()">
                                                        <option selected disabled value=""></option>
                                                        <option value="Cash">Cash</option>
                                                        <option value="Credit">Credit</option>
                                                    </select>
                                                    <span class="text-danger">
                                                        <strong id="paymentType-error" class="errordatalabel purchase_error receipt_error"></strong>
                                                    </span>
                                                </div>
                                                <div class="col-xl-2 col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                                                    <label id="invoice_deliver_lbl" class="form_lbl">Date<b style="color: red; font-size:16px;">*</b></label>
                                                    <input type="text" id="date" name="date" class="form-control flatpickr-basic mainforminp purchase_input receipt_input" placeholder="YYYY-MM-DD" onchange="dateVal()"/>
                                                    <span class="text-danger">
                                                        <strong id="date-error" class="errordatalabel purchase_error receipt_error"></strong>
                                                    </span>
                                                </div>
                                                <div class="col-xl-2 col-lg-6 col-md-6 col-sm-6 col-12 mb-1 with_rec invprop">
                                                    <label class="form_lbl">Invoice Type<b style="color: red; font-size:16px;">*</b></label>
                                                    <select class="select2 form-control purchase_select with_select receipt_select" name="voucherType" id="voucherType" onchange="voucherTypeVal()">
                                                        <option selected disabled value=""></option>
                                                        <option class="regularoption" value="Fiscal-Receipt">Fiscal-Receipt</option>
                                                        <option class="regularoption" value="Manual-Receipt">Manual-Receipt</option>
                                                        <option class="irregularoption" value="Declarasion">Declarasion</option>
                                                    </select>
                                                    <span class="text-danger">
                                                        <strong id="voucherType-error" class="errlblclass errordatalabel purchase_error with_error receipt_error"></strong>
                                                    </span>
                                                </div>
                                                <div class="col-xl-2 col-lg-6 col-md-6 col-sm-6 col-12 mb-1 with_rec invprop">
                                                    <label class="form_lbl">FS No.<b style="color: red; font-size:16px;">*</b></label>
                                                    <input type="text" placeholder="Enter FS/Doc no. here" class="form-control invtypeval mainforminp purchase_input with_input receipt_input" name="VoucherNumber" id="VoucherNumber" onkeyup="voucherNumberval()" onkeypress="return ValidateOnlyNum(event);" />
                                                    <span class="text-danger">
                                                        <strong id="voucherNumber-error" class="errlblclass errordatalabel purchase_error with_error receipt_error"></strong>
                                                    </span>
                                                </div>
                                                <div class="col-xl-2 col-lg-6 col-md-6 col-sm-6 col-12 mb-1 with_rec invprop">
                                                    <label class="form_lbl" title="Invoice/ Reference Number">Invoice No.</label>
                                                    <input type="text" placeholder="Enter invoice/ reference no. here" class="form-control invtypeval mainforminp purchase_input with_input receipt_input" name="InvoiceNumber" id="InvoiceNumber" onkeyup="invoiceNumberval()"/>
                                                    <span class="text-danger">
                                                        <strong id="invoiceNumber-error" class="errlblclass errordatalabel purchase_error with_error receipt_error"></strong>
                                                    </span>
                                                </div>
                                                <div class="col-xl-2 col-lg-6 col-md-6 col-sm-6 col-12 mb-1 with_rec invprop">
                                                    <label class="form_lbl">MRC No.<b style="color: red; font-size:16px;">*</b></label>
                                                    <select class="select2 form-control purchase_select with_select receipt_select" name="MrcNumber" id="MrcNumber" onchange="mrcNumberVal()">
                                                        <option selected disabled value=""></option>
                                                    </select>
                                                    <span class="text-danger">
                                                        <strong id="mrcNumber-error" class="errlblclass errordatalabel purchase_error with_error receipt_error"></strong>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>

                            <div class="col-xl-9 col-lg-8 col-md-12 col-sm-12 col-12 mb-1 production_class major_class" style="display: none;">
                                <fieldset class="fset">
                                    <legend>Production Data</legend>
                                    <div class="row">
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                                            <label class="form_lbl">Production No.<b style="color: red; font-size:16px;">*</b></label>
                                            <input type="text" placeholder="Enter production number here" class="form-control mainforminp production_input" name="productionNumber" id="production_number" onkeyup="productionNumFn()"/>
                                            <span class="text-danger">
                                                <strong id="production-number-error" class="errordatalabel production_error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                                            <label class="form_lbl">Requisition No.</label>
                                            <input type="text" placeholder="Enter requisition number here" class="form-control mainforminp production_input" name="requisitionNumber" id="requisition_number" onkeyup="requisitionNumFn()"/>
                                            <span class="text-danger">
                                                <strong id="req-number-error" class="errordatalabel production_error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                                            <label class="form_lbl">Delivered By</label>
                                            <input type="text" name="ProductionDeliveredBy" id="ProductionDeliveredBy" placeholder="Enter name here" class="form-control mainforminp production_input" onkeyup="prdDeliveredByFn()"/>
                                            <span class="text-danger">
                                                <strong id="prd-deliveredby-error" class="errordatalabel production_error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                                           <label class="form_lbl">Production Date</label>
                                            <input type="text" name="ProductionDate" id="ProductionDate" placeholder="YYYY-MM-DD" class="form-control mainforminp production_input" onchange="productionDateFn()"/>
                                            <span class="text-danger">
                                                <strong id="production-date-error" class="errordatalabel production_error"></strong>
                                            </span>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>

                            <div class="col-xl-3 col-lg-4 col-md-12 col-sm-12 col-12 mb-1 global_class">
                                <fieldset class="fset">
                                    <legend>General Data</legend>
                                    <div class="row">  
                                        <div class="col-xl-6 col-lg-12 col-md-6 col-sm-6 col-12 mb-1">
                                            <label class="form_lbl">Station<b style="color: red; font-size:16px;">*</b></label>
                                            <select class="select2 form-control" name="store" id="store" onchange="stationFn()">
                                                <option selected disabled value=""></option>
                                                @foreach ($storeSrc as $storeSrc)
                                                    <option value="{{ $storeSrc->StoreId }}">{{ $storeSrc->StoreName }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">
                                                <strong id="store-error" class="errordatalabel"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-6 col-lg-12 col-md-6 col-sm-6 col-12 mb-1">
                                            <label class="form_lbl">Received By<b style="color: red; font-size:16px;">*</b></label>
                                            <select class="select2 form-control" name="ReceivedBy" id="ReceivedBy" onchange="recievedByFn()">
                                                <option selected disabled value=""></option>
                                                @foreach ($uses_data as $receivedby)
                                                    <option value="{{ $receivedby->username }}"> {{ $receivedby->username }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">
                                                <strong id="receivedby-error" class="errordatalabel"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-6 col-lg-12 col-md-6 col-sm-6 col-12 mb-1">
                                           <label class="form_lbl">Received Date<b style="color: red; font-size:16px;">*</b></label>
                                            <input type="text" name="ReceivedDate" id="ReceivedDate" placeholder="YYYY-MM-DD" class="form-control mainforminp" onchange="receivedDateFn()"/>
                                            <span class="text-danger">
                                                <strong id="received-date-error" class="errordatalabel"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-6 col-lg-12 col-md-6 col-sm-6 col-12 mb-1">
                                            <label class="form_lbl">Remark</label>
                                            <textarea type="text" placeholder="Enter remark here" class="form-control mainforminp" name="Memo" id="Memo" rows="1"></textarea>
                                            <span class="text-danger">
                                                <strong id="memo-error" class="errordatalabel"></strong>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="divider major_class purchase_class" style="margin-top:-1rem;">
                                        <div class="divider-text"><b>Delivery Data</b></div>
                                    </div>
                                    <div class="row major_class purchase_class" style="margin-top:-1rem;">
                                        <div class="col-xl-12 col-lg-12 col-md-6 col-sm-6 col-12 mb-1" style="display:none">
                                            <label id="purchase_deliver_lbl" class="form_lbl">Purchased By<b style="color: red; font-size:16px;">*</b></label>
                                            <select class="select2 form-control purchase_select" name="Purchaser" id="Purchaser" onchange="purchaserVal()">
                                                <option selected disabled value=""></option>
                                                @foreach ($purchaser as $purchaser)
                                                    <option value="{{ $purchaser->username }}"> {{ $purchaser->username }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">
                                                <strong id="purchaser-error" class="errordatalabel purchase_error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-6 col-lg-12 col-md-6 col-sm-6 col-12 mb-1">
                                            <label class="form_lbl">Delivered By</label>
                                            <input type="text" name="DeliveredBy" id="DeliveredBy" placeholder="Enter Name here" class="form-control mainforminp purchase_input" onkeyup="deliveredByFn()"/>
                                            <span class="text-danger">
                                                <strong id="deliveredby-error" class="errordatalabel purchase_error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-6 col-lg-12 col-md-6 col-sm-6 col-12 mb-1">
                                            <label class="form_lbl" title="Plate Number">Plate No.</label>
                                            <input type="text" name="PlateNumber" id="PlateNumber" placeholder="Enter Truck plate number here" class="form-control mainforminp purchase_input" onkeyup="plateNumFn()" style="text-transform:uppercase"/>
                                            <span class="text-danger">
                                                <strong id="platenum-error" class="errordatalabel purchase_error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-12 col-lg-6 col-md-6 col-sm-6 col-12 mb-1" style="display:none">
                                            <label class="form_lbl" title="Phone Number">Phone No.</label>
                                            <input type="tel" placeholder="+251-XXX-XX-XX-XX" class="form-control mainforminp phone_number purchase_input" name="DriverPhoneNo" id="DriverPhoneNo" onkeyup="driverPhoneFn()"/>
                                            <span class="text-danger">
                                                <strong id="driverphone-error" class="errordatalabel purchase_error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-12 col-lg-6 col-md-6 col-sm-6 col-12 mb-1" style="display:none">
                                            <label class="form_lbl" title="Driver License Number">Driver License No.</label>
                                            <input type="text" placeholder="Enter Driver license number here" class="form-control mainforminp purchase_input" name="DriverLicenseNo" id="DriverLicenseNo" onkeyup="driverLicFn()"/>
                                            <span class="text-danger">
                                                <strong id="driverlic-error" class="errordatalabel purchase_error"></strong>
                                            </span>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <hr class="mb-1"/>
                        <div class="row receiving_child_data_div"> 
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="table-responsive pr-0 pl-0" style="width: 100%;overflow-x: auto;-webkit-overflow-scrolling: touch;margin: 0 0rem;padding: 0 1rem;">
                                    <table id="dynamicTable" class="mb-0 rtable form_dynamic_table fit-content" style="width:100%;min-width: 950px;">
                                        <thead>
                                            <tr>
                                                <th class="form_lbl" style="width:3%;">#</th>
                                                <th class="form_lbl" style="width:21%">Item Name<b style="color: red; font-size:16px;">*</b></th>
                                                <th class="form_lbl" style="width:11%" title="Unit of Measurement">UOM</th>
                                                <th class="form_lbl proc_module" style="width:12%" title="Ordered Quantity">Ordered Qty.</th>
                                                <th class="form_lbl proc_module" style="width:12%" title="Remaining Quantity">Remaining Qty.</th>
                                                <th class="form_lbl" style="width:12%" id="qty_header">Quantity<b style="color: red; font-size:16px;">*</b></th>
                                                <th class="form_lbl cost_visibility_div unorder_price_col prd_price_con" style="width:12%">Unit Cost<b style="color: red; font-size:16px;">*</b></th>
                                                <th class="form_lbl cost_visibility_div unorder_price_col prd_price_con" style="width:12%" id="beforeAfterTax">Before Tax</th>
                                                <th style="width:12%" class="form_lbl vatproperty cost_visibility_div">Tax Amount</th>
                                                <th style="width:12%" class="form_lbl vatproperty cost_visibility_div">Total Cost</th>
                                                <th class="form_lbl" style="width:5%"></th>
                                            </tr>
                                        <thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                                <table class="mb-0">
                                    <tr>
                                        <td>
                                            <button type="button" name="adds" id="adds" class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i>  Add New</button>
                                        <td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-xl-9 col-lg-8 col-md-5 col-sm-5 col-12"></div>
                            <div class="col-xl-3 col-lg-4 col-md-7 col-sm-7 col-12" style="text-align: right;">
                                <table style="width:100%;" id="pricingTable" class="rtable cost_visibility_div unorder_price_div prd_price_con">
                                    <tr>
                                        <td style="text-align: right;width:45%">
                                            <label id="subGrandTotalLbl" class="form_lbl">Sub Total</label>
                                        </td>
                                        <td style="text-align: center; width:55%">
                                            <label id="subtotalLbl" class="formattedNum form_lbl form_reset_cls" style="font-weight: bold;"></label>
                                            <input type="hidden" class="form-control" name="subtotali" id="subtotali" readonly="true" value="0" />
                                        </td>
                                    </tr>
                                    <tr class="vatproperty">
                                        <td style="text-align: right;">
                                            <label class="form_lbl" id="pricing_tbl_tax">Tax</label>
                                        </td>
                                        <td style="text-align: center;">
                                            <label id="taxLbl" class="formattedNum form_lbl form_reset_cls" style="font-weight: bold;"></label>
                                            <input type="hidden" class="form-control" name="taxi" id="taxi" readonly="true" value="0" />
                                        </td>
                                    </tr>
                                    <tr class="vatproperty">
                                        <td style="text-align: right;">
                                            <label class="form_lbl">Grand Total</label>
                                        </td>
                                        <td style="text-align: center;">
                                            <label id="grandtotalLbl" class="formattedNum form_lbl form_reset_cls" style="font-weight: bold;"></label>
                                            <input type="hidden" class="form-control" name="grandtotali" id="grandtotali" readonly="true" value="0" />
                                        </td>
                                    </tr>
                                    <tr id="witholdingTr">
                                        <td style="text-align: right;">
                                            <label id="withodingTitleLbl" class="form_lbl">Witholding</label>
                                        </td>
                                        <td style="text-align: center;">
                                            <label id="witholdingAmntLbl" class="formattedNum form_lbl form_reset_cls" style="font-weight: bold;"></label>
                                            <input type="hidden" class="form-control" name="witholdingAmntin" id="witholdingAmntin" readonly="true" value="0" />
                                        </td>
                                    </tr>
                                    <tr id="netpayTr">
                                        <td style="text-align: right;">
                                            <label class="form_lbl">Net Pay</label>
                                        </td>
                                        <td style="text-align: center;">
                                            <label id="netpayLbl" class="formattedNum form_lbl form_reset_cls" style="font-weight: bold;"></label>
                                            <input type="hidden" class="form-control" name="netpayin" id="netpayin" readonly="true" value="0" />
                                        </td>
                                    </tr>  
                                    <tr style="display: none;">
                                        <td style="text-align: right;">
                                            <label class="form_lbl">No. of Items</label>
                                        </td>
                                        <td style="text-align: center;">
                                            <label id="numberofItemsLbl form_lbl" style="font-weight: bold;">0</label>
                                        </td>
                                    </tr>
                                </table>
                                <table style="width:100%;" class="mt-1">
                                    <tr>
                                        <td style="text-align: right;align-items: center;" colspan="2">
                                            @can('Receiving-Hide')
                                                <div class="form-check form-check-inline" id="hideGRV">
                                                    <div class="custom-control custom-control-primary custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="hideGRVCBX" name="hideGRVCBX"/>
                                                        <label class="custom-control-label mr-1" for="hideGRVCBX" style="font-size:12px">Hide GRV</label>                                  
                                                    </div>
                                                    <input type="hidden" class="form-control" name="hidegrvcheckbox" id="hidegrvcheckbox" readonly="true" value="0" />
                                                </div>
                                            @endcan
                                            <div class="form-check form-check-inline" id="printgrvdiv">
                                                <div class="custom-control custom-control-primary custom-checkbox ml-1">
                                                    <input type="checkbox" class="custom-control-input" id="printGRVCBX" name="printGRVCBX" checked/>
                                                    <label class="custom-control-label" for="printGRVCBX" style="font-size:12px">Print GRV</label>                                  
                                                </div>
                                                <input type="hidden" class="form-control" name="checkboxVali" id="checkboxVali" readonly="true" value="" />
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <div style="display:none;">
                            <select class="select2 form-control" name="ReferenceTypeDefault" id="ReferenceTypeDefault">
                                @foreach ($ref_type_data as $ref_type)
                                    <option value="{{ $ref_type->id }}">{{ $ref_type->LookupName }}</option>
                                @endforeach
                            </select>
                            <select class="select2 form-control" name="item_default" id="item_default">
                                <option selected disabled value=""></option>
                                @foreach ($itemSrcs as $itm)
                                    <option data-type="{{ $itm->Type }}" value="{{ $itm->id }}">{{ $itm->items }}</option>
                                @endforeach 
                            </select>
                            <select class="select2 form-control" name="supplier_default" id="supplier_default">
                                <option selected disabled value=""></option>
                                @foreach ($customerSrc as $cusdata)
                                    <option value="{{ $cusdata->id }}">{{ $cusdata->customer }}</option>
                                @endforeach
                            </select>
                            <select class="select2 form-control" name="proc_data_default" id="proc_data_default">
                                <option selected disabled value=""></option>
                                @foreach ($proc_data as $p_data)
                                    <option data-type="{{$p_data->type}}" value="{{ $p_data->rec_id }}">{{ $p_data->proc_data }}</option>
                                @endforeach
                            </select>
                            <select class="select2 form-control" name="proc_item_default" id="proc_item_default">
                                <option selected disabled value=""></option>
                            </select>
                        </div>
                        <input type="hidden" class="form-control" name="cdatevals" id="cdatevals" readonly="true" value="{{$curdate}}"/>
                        <input type="hidden" class="form-control" name="hiddenstoreval" id="hiddenstoreval" readonly="true"/>
                        <input type="hidden" class="form-control mainforminp" name="formId" id="formId" readonly="true"/>
                        <input type="hidden" class="form-control" name="tid" id="tid" readonly="true"/>
                        <input type="hidden" class="form-control" name="receivingId" id="receivingId" readonly="true"/>
                        <input type="hidden" class="form-control" name="operationtypes" id="operationtypes" readonly="true" value="1"/>
                        <input type="hidden" class="form-control" name="witholdMinAmounti" id="witholdMinAmounti" readonly="true"/>
                        <input type="hidden" class="form-control" name="witholdPercenti" id="witholdPercenti" readonly="true"/>
                        <input type="hidden" class="form-control" name="commonVal" id="commonVal" readonly="true"/>
                        <input type="hidden" class="form-control" name="holdnumberi" id="holdnumberi" readonly="true" value=""/>
                        <input type="hidden" class="form-control" name="receivingnumberi" id="receivingnumberi" readonly="true" value=""/>
                        @can('Receiving-Add')
                            <button id="savebutton" type="button" class="btn btn-info form_btn">Save</button>
                        @endcan
                        <button id="closebuttonk" type="button" class="btn btn-danger form_btn closebutton" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End Registation Modal -->

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
                            <textarea type="text" placeholder="Enter reason here" class="form-control" rows="3" name="CommentOrReason" id="CommentOrReason" onkeyup="receivingReasonFn()"></textarea>
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

    <!--Start Void modal -->
    <div class="modal fade text-left fit-content" id="voidreasonmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="voidreasonmodal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="void-title">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="voidReason()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="voidreasonform">
                    @csrf
                    <div class="modal-body">
                        <label class="form_lbl">Reason</label>
                        <textarea type="text" placeholder="Enter reason here" class="form-control Reason" rows="3" name="Reason" id="Reason" onkeyup="voidReason()"></textarea>
                        <span class="text-danger">
                            <strong id="void-error"></strong>
                        </span>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control voidid" name="voidid" id="voidid" readonly="true">
                        <input type="hidden" class="form-control vstatus" name="vstatus" id="vstatus" readonly="true">
                        <button id="voidbtn" type="button" class="btn btn-info">Void</button>
                        <button id="closebuttoni" type="button" class="btn btn-danger" data-dismiss="modal" onclick="voidReason()">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Void modal -->

    <!-- start manage withold modal-->
    <div class="modal modal-slide-in event-sidebar fade fit-content" id="witholdManageModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="witholdManageModal" aria-hidden="true">
        <form id="ManageWitholdForm">    
            <div class="modal-dialog sidebar-xl withholding_mgt_modal" style="width: 50%;">
                <div class="modal-content p-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #ea5455 !important;font-weight:bold;">x</button>
                    <div class="modal-header mb-1">
                        <h5 class="modal-title form_title" id="manage-withold-title">Withholding Management</h5>
                        <div class="info_modal_title_lbl info_modal_title_lbl" style="text-align: center;padding-right:30px;" id="managewitholdlbl"></div>
                    </div>
                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3 scrdivhor scrollhor" style="overflow-y:auto;height:100vh;">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="card shadow-none border">
                                    <div class="card-body p-1">
                                        {{-- <h6 class="card-title mb-0"><i class="fas fa-sliders-h"></i> Withholding Management</h6>
                                        <hr class="my-50"> --}}
                                        <div class="row">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 table-responsive" id="withholding_dt_div">
                                                <table id="witholdingTables" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable mb-0 info_datatable">
                                                    <thead>
                                                        <th style="display: none;"></th>
                                                        <th style="display: none;"></th>
                                                        <th style="width: 5%">#</th>
                                                        <th style="width: 21%" title="Good Receiving Voucher Number">GRV No.</th>
                                                        <th style="width: 15%" title="Document or FS Number">FS No.</th>
                                                        <th style="width: 20%" title="Withholding Receipt Number">Rec. No.</th>
                                                        <th style="width: 20%" title="Withholding Receipt Date">Rec. Date</th>
                                                        <th style="width: 15%">Sub Total</th>
                                                        <th style="display: none;"></th>
                                                        <th style="width: 4%;">
                                                            <div class="text-center custom-control custom-control-primary custom-checkbox" style="padding: 0px 2px 0px 2px !important;">
                                                                <input type="checkbox" class="custom-control-input" data-id="settle_all_grv" id="settle_all_grv" name="settle_all_grv[]"/>
                                                                <label class="custom-control-label" for="settle_all_grv" style="font-size:0px"></label>                                  
                                                            </div>
                                                        </th>
                                                    </thead>
                                                    <tbody class="table table-sm"></tbody>
                                                    <tfoot class="table table-sm">
                                                        <tr>
                                                            <td colspan="7" style="text-align:right;padding-right:2px !important">
                                                                <label id="witholdAmountTotalTitle" style="font-size: 12px;font-weight:bold;">Total</label>
                                                            </td>
                                                            <td style="padding-left:7px !important;">
                                                                <label id="witholdSubtotalLbl" style="font-size: 12px;font-weight:bold;"></label>
                                                            </td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="7" style="text-align:right;padding-right:2px !important">
                                                                <label id="witholdreceiptlbl" class="badge badge-success" style="font-size: 9px;font-weight:bold;display:none;"></label>
                                                                <label id="settledLabel" class="badge badge-success withold_status_class" style="font-size: 9px;font-weight:bold;">Fully-Settled</label>
                                                                <label id="partialsettledLabel" class="badge badge-primary withold_status_class" style="font-size: 9px;font-weight:bold;">Partially-Settled</label>
                                                                <label id="notsettledLabel" class="badge badge-warning withold_status_class" style="font-size: 9px;font-weight:bold;">Not-Settled</label>
                                                                <label id="witholdAmountLblTitle" style="font-size: 12px;font-weight:bold;"></label>
                                                            </td>
                                                            <td style="padding-left:7px !important;">
                                                                <label id="witholdAmountLbl" style="font-size: 12px;font-weight:bold;"></label>
                                                            </td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="row" style="display: none;">
                                            <div class="col-xl-6 col-lg-4 col-md-4 col-sm-2 col-12"></div>
                                            <div class="col-xl-6 col-lg-8 col-md-8 col-sm-10 col-12 mt-1" style="text-align: right">
                                                @can('Withold-Settle')
                                                    <button id="settlemodalbtn" type="button" class="btn btn-icon btn-gradient-info btn-sm SettleWiholdBtn" title="Add / Edit Withholding Receipt"><i class="fa fa-plus"></i></button>
                                                    <button id="unsettlemodalbtn" type="button" class="btn btn-icon btn-gradient-warning btn-sm UnSettleWiholdBtn" title="Remove Withholding Receipt"><i class="fa fa-minus-circle"></i></button>
                                                @endcan
                                            </div>
                                        </div>
                                        <div class="row mt-1 mb-1">
                                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12"></div>
                                            @can('Withold-Settle')
                                            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12 border" style="display: none;" id="receipt_div">
                                                <div class="row mt-1 mb-1">
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                                                        <label class="form_lbl">Receipt No.<b style="color: red; font-size:16px;">*</b></label>
                                                        <input type="number" placeholder="Enter receipt number here..." class="form-control mainforminp" name="ReceiptNumber" id="ReceiptNumber" onkeyup="ReceiptNumberVal()" onkeypress="return ValidateOnlyNum(event);" />
                                                        <span class="text-danger">
                                                            <strong id="receipt-error" class="errlblclass errordatalabel"></strong>
                                                        </span>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                                                        <label class="form_lbl">Receipt Date<b style="color: red; font-size:16px;">*</b></label>
                                                        <input type="text" placeholder="YYYY-MM-DD" class="form-control mainforminp" name="ReceiptDate" id="ReceiptDate" onchange="ReceiptDateFn()"/>
                                                        <span class="text-danger">
                                                            <strong id="receipt-date-error" class="errlblclass errordatalabel"></strong>
                                                        </span>
                                                    </div>
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center">
                                                        <button id="settlewitholdbtn" type="button" class="btn btn-info btn-sm">Settle</button>
                                                        <button id="unSettlewitholdbtn" type="button" class="btn btn-info btn-sm">Unsettle</button>
                                                    </div>
                                                </div>
                                            </div>
                                            @endcan
                                           <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12"></div>
                                        </div>
                                    </div>
                                </div> 
                            </div>

                            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12" style="display: none;">
                                <div class="card shadow-none border">
                                    <div class="card-body p-1">
                                        <h6 class="card-title mb-0"><i class="fas fa-database"></i> Current Record Information</h6>
                                        <hr class="my-50">
                                        <div class="row">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 table-responsive" id="current_record_canvas"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-6 col-lg-5 col-md-5 col-sm-4 col-12"></div>
                                            <div class="col-xl-6 col-lg-7 col-md-7 col-sm-8 col-12 mt-1" id="current_rec_pricing_canvas" style="text-align: right;"></div>
                                        </div>
                                    </div>
                                </div>                                
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control" name="currRecId" id="currRecId" readonly="true"/>
                        <input type="hidden" class="form-control" name="witholdRecFlag" id="witholdRecFlag" readonly="true"/>
                        <input type="hidden" class="form-control" name="settWitholdPercent" id="settWitholdPercent" readonly="true"/>
                        <button id="closebutton-withold" type="button" class="btn btn-danger" data-dismiss="modal">Close</button> 
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!--/ end manage withold modal-->

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
                            <input type="hidden" class="form-control" name="uploadReceivingDoc" id="uploadReceivingDoc" readonly="true">
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

    @include('parts.batch_serial')
    <script type="text/javascript">
        var errorcolor = "#ffcccc";
        var voideditor;
        var fyears = $('#fiscalyearval').val();
        var currentdate = $('#currentdateval').val();
        var CURRENT_YEAR = currentdate.split("-")[0];
        var cdatevar = $('#currentdateval').val();
        var table = "";
        var detail_table = "";
        var prd_table = "";
        var can_change_src_type = true;
        var srctype_value = "";
        var with_table = "";
        var selectAllCheckbox = $('#settle_all_grv');
        var j = 0;
        var i = 0;
        var m = 0;
        var x3 = 0;
        var y3 = 0;
        var z3 = 0;
        var purGlobalIndex = -1;
        var prdGlobalIndex = -1;
        var firstLevelIndex = -1;
        var infoTblIndex = -1;
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
                    status: 'Checked',
                    text: 'Check',
                    action: 'Checked',
                    message: 'Are you sure you want to change the status of this record to Checked?',
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
            'Checked': {
                forward: {
                    status: 'Confirmed',
                    text: 'Confirm',
                    action: 'Confirmed',
                    message: 'Are you sure you want to change the status of this record to Confirmed?',
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
            'Confirmed': {
                backward: {
                    status: 'Checked',
                    text: 'Back to Check',
                    action: 'Back to Check',
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

        function formatText (icon) {
            return $('<span><i class="fas ' + $(icon.element).data('icon') + '"></i> ' + icon.text + '</span>');
        };

        function getReceivingData(fyears){
            var receivng_md = $("#receiving_mode").val();
            var visibility_flag = false;
            var column_index = [];
            if(receivng_md == 0){
                column_index = [3,4,15];
            }
            else{
                column_index = [8,10,11,12,13,14];
            }

            table = $('#laravel-datatable-crud').DataTable({
                destroy:true,
                processing: true,
                serverSide: true,
                searchHighlight: true,
                "order": [[ 2, "desc" ]],
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
                dom: "<'row'<'col-sm-3 col-md-2 col-6'f><'col-sm-3 col-md-2 col-6 mt-1 custom-1'><'col-sm-3 col-md-2 col-6 mt-1 custom-2'><'col-sm-3 col-md-2 col-6 mt-1 custom-3'><'col-sm-3 col-md-2 col-6 mt-1 custom-4'><'col-sm-3 col-md-2 col-6 mt-1 custom-5'>>" +
                    "<'row'<'col-sm-12 margin_top_class'tr>>" +
                    "<'row'<'col-sm-4 col-md-4 col-4'l><'col-sm-4 col-md-4 col-4 d-flex justify-content-center'i><'col-sm-4 col-md-4 col-4 d-flex justify-content-end'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/receivingtable/1/'+fyears,
                    type: 'DELETE',
                    beforeSend: function () { 
                        blockPage(cardSection, 'Loading receiving data...');
                    },
                    complete: function () { 
                        setPurFocus('#laravel-datatable-crud');
                        $('#laravel-datatable-crud').DataTable().columns.adjust();
                    },
                },
                columns: [{
                        data: 'id',
                        "render": function (data, type, row, meta) {
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
                        data: 'reference_type',
                        name: 'reference_type',
                        width:"14%"
                    },
                    {
                        data: 'doc_reference',
                        name: 'doc_reference',
                        width:"15%",
                        "render": function ( data, type, row, meta ) {
                            return `<a style="text-decoration:underline;color:blue;" onclick=openPurchaseFn("${row.PoId}")>${data != null ? data : ""}</a>`;
                        }
                    },
                    {
                        data: 'ProductType',
                        name: 'ProductType',
                        width:"7%"
                    },
                    {
                        data: 'CustomerName',
                        name: 'CustomerName',
                        width:"14%"
                    },
                    {
                        data: 'TIN',
                        name: 'TIN',
                        width:"7%"
                    },
                    {
                        data: 'PaymentType',
                        name: 'PaymentType',
                        width:"7%"//8
                    },
                    {
                        data: 'StoreName',
                        name: 'StoreName',
                        width:"11%"
                    },
                    {
                        data: 'VoucherType',
                        name: 'VoucherType',
                        width:"6%"//10
                    },
                    {
                        data: 'CustomerMRC',
                        name: 'CustomerMRC',
                        width:"6%"//11
                    },
                    {
                        data: 'VoucherNumber',
                        name: 'VoucherNumber',
                        "render": function ( data, type, row, meta ) {
                            return  row.IsSeparatelySettled == 1 ? 
                                        `${data} <b title="Withholding Settled" style="color:#28c76f;font-size:9px">(WS)</b>` 
                                    : (row.IsSeparatelySettled != 1 && parseFloat(row.WitholdAmount) > 0 ? `${data} <b title="Withholding Not Settled" style="color:#ff9f43;font-size:9px">(NS)</b>` : data)
                                ;
                        },
                        width:"6%"//12
                    },
                    {
                        data: 'InvoiceNumber',
                        name: 'InvoiceNumber',
                        width:"6%"//13
                    },
                    {
                        data: 'TransactionDate',
                        name: 'TransactionDate',
                        width:"6%"//14
                    },
                    {
                        data: 'ReceivedDate',
                        name: 'ReceivedDate',
                        width:"8%"
                    },
                    {
                        data: 'Status',name: 'Status',
                        "render": function ( data, type, row, meta ) {
                            if(data == "Draft"){
                                return `<span class="badge bg-secondary bg-glow">${data}</span>`;
                            }
                            else if(data == "Pending"){
                                return `<span class="badge bg-warning bg-glow">${data}</span>`;
                            }
                            else if(data == "Checked"){
                                return `<span class="badge bg-primary bg-glow">${data}</span>`;
                            }
                            else if(data == "Confirmed"){
                                return `<span class="badge bg-success bg-glow">${data}</span>`;
                            }
                            else if(data == "Void" || data == "Void(Draft)" || data == "Void(Pending)" || data == "Void(Checked)" || data == "Void(Confirmed)"){
                                return `<span class="badge bg-danger bg-glow">${data}</span>`;
                            }
                            else{
                                return `<span class="badge bg-dark bg-glow">${data}</span>`;
                            }
                        },
                        width:"6%"
                    },
                    {
                        data: 'action',
                        "render": function ( data, type, row, meta ) {
                            return `<div class="text-center"><a class="receivingInfo" href="javascript:void(0)" onclick="receivingInfoFn(${row.id},${row.VoucherStatus})" data-id="receiving_tbl_id${row.id}" id="receiving_tbl_id${row.id}" title="Open receiving information page"><i class="fa-sharp fa-regular fa-circle-info fa-xl" style="color: #00cfe8;"></i></a></div>`;
                        },
                        width:"4%"
                    },
                    {
                        data: 'StoreId',
                        "render": function ( data, type, row, meta ) {
                            return "";
                        },
                        'visible': false
                    },
                    {
                        data: 'Type',
                        "render": function ( data, type, row, meta ) {
                            return "";
                        },
                        'visible': false
                    },
                ],
                "columnDefs": [
                    {
                        "targets": column_index,
                        "visible": visibility_flag,
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

                    unblockPage(cardSection);  

                    $('#receiving_tbl').show();
                    $('#laravel-datatable-crud').DataTable().columns.adjust();
                },
                fixedHeader: {
                    header: true,
                    headerOffset: $('.header-navbar').outerHeight(),
                },
            });
            appendReceivingFilterFn(fyears);
        }

        $('#purchase-tab').on('shown.bs.tab', function () {
            $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
            $('#laravel-datatable-crud').DataTable().columns.adjust();
        });

        function appendReceivingFilterFn(fyears){
            var receivng_md = $("#receiving_mode").val();
            var reference_option = $("#ReferenceTypeDefault");

            var receiving_fiscalyear = $(`
                <select class="selectpicker form-control dropdownclass" id="receiving_fy" name="receiving_fy[]" title="Select fiscal year here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" data-actions-box="true" data-selected-text-format="count" data-count-selected-text="Fiscal Year ({0})">
                    @foreach ($fiscalyears as $receivingfy)
                        <option value="{{ $receivingfy->FiscalYear }}">{{ $receivingfy->Monthrange }}</option>
                    @endforeach
                </select>
            `);

            $('.custom-1').html(receiving_fiscalyear);
            $('#receiving_fy')
            .selectpicker()
            .selectpicker('val', fyears)
            .off('changed.bs.select') 
            .on('changed.bs.select', function () {
                let fyear = $(this).val();
                countReceivingStatusFn(fyear,"pur");
                getReceivingData(fyear); 
            });

            if(receivng_md == 0){
                var reference_type_filter = $(`
                    <select class="selectpicker form-control dropdownclass" id="reference_type_filter" name="reference_type_filter[]" title="Select reference type here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" data-actions-box="true" multiple data-selected-text-format="count" data-count-selected-text="Reference Type ({0})"></select>
                `).append(reference_option.find(`option[value="503"]`).clone());

                $('.custom-2').hide();
                $('#ready_for_receiving_div').hide();
            }
            else if(receivng_md == 1){
                var reference_type_filter = $(`
                    <select class="selectpicker form-control dropdownclass" id="reference_type_filter" name="reference_type_filter[]" title="Select reference type here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" data-actions-box="true" multiple data-selected-text-format="count" data-count-selected-text="Reference Type ({0})"></select>
                `).append(reference_option.find(`option[value!="503"]`).clone());

                $('.custom-2').show();
                $('#ready_for_receiving_div').show();
            }

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
                    table.column(19).search('^$', true, false).draw(); // Match an impossible pattern
                } else {
                    // Options selected: build regex for filtering
                    var searchRegex = search.join('|'); // OR-separated values for regex
                    table.column(19).search(searchRegex, true, false).draw();
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
                <select class="selectpicker form-control dropdownclass" id="receiving_store_filter" name="receiving_store_filter[]" title="Select station here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" data-actions-box="true" multiple data-selected-text-format="count" data-count-selected-text="Station ({0})">
                    @foreach ($storefilter as $receivingstr)
                        <option selected value="{{ $receivingstr->store_id }}">{{ $receivingstr->store_name }}</option>
                    @endforeach
                </select>
            `);

            $('.custom-4').html(store_filter);
            $('#receiving_store_filter')
            .selectpicker()
            .off('changed.bs.select') 
            .on('changed.bs.select', function () {  
                var selected = $('#receiving_store_filter option:selected');
                var search = [];

                // Collect selected option values
                $.each(selected, function() {
                    search.push($(this).val());
                });

                if (search.length === 0) {
                    // No option selected: force DataTable to return no data
                    table.column(18).search('^$', true, false).draw(); // Match an impossible pattern
                } else {
                    // Options selected: build regex for filtering
                    var searchRegex = search.join('|'); // OR-separated values for regex
                    table.column(18).search(searchRegex, true, false).draw();
                }
            });

            var status_filter = $(`
                <select class="selectpicker form-control dropdownclass" id="receiving_status_filter" name="receiving_status_filter[]" title="Select status here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" data-actions-box="true" multiple data-selected-text-format="count" data-count-selected-text="Status ({0})">
                    <option selected value="Draft">Draft</option>
                    <option selected value="Pending">Pending</option>
                    <option selected value="Checked">Checked</option>
                    <option selected value="Confirmed">Confirmed</option>
                    <option selected value="Void">Void</option>
                </select>
            `);

            $('.custom-5').html(status_filter);
            $('#receiving_status_filter')
            .selectpicker()
            .off('changed.bs.select') 
            .on('changed.bs.select', function () {  
                var selected = $('#receiving_status_filter option:selected');
                var search = [];

                // Collect selected option values
                $.each(selected, function() {
                    search.push($(this).val());
                });

                if (search.length === 0) {
                    // No option selected: force DataTable to return no data
                    table.column(16).search('^$', true, false).draw(); // Match an impossible pattern
                } else {
                    // Options selected: build regex for filtering
                    var searchRegex = search.join('|'); // OR-separated values for regex
                    table.column(16).search(searchRegex, true, false).draw();
                }
            });
        }

        function getProductionData(fyears){
            prd_table = $('#laravel-datatable-crud-prd').DataTable({
                destroy:true,
                processing: true,
                serverSide: true,
                searchHighlight: true,
                "order": [[ 2, "desc" ]],
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
                dom: "<'row'<'col-sm-3 col-md-2 col-6'f><'col-sm-3 col-md-2 col-6 mt-1 prd-custom-1'><'col-sm-3 col-md-2 col-6 mt-1 prd-custom-2'><'col-sm-3 col-md-2 col-6 mt-1 prd-custom-3'>>" +
                    "<'row'<'col-sm-12 margin_top_class'tr>>" +
                    "<'row'<'col-sm-4 col-md-4 col-4'l><'col-sm-4 col-md-4 col-4 d-flex justify-content-center'i><'col-sm-4 col-md-4 col-4 d-flex justify-content-end'p>>",

                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/receivingtable/2/'+fyears,
                    type: 'DELETE',
                    complete: function () { 
                        setPrdFocus('#laravel-datatable-crud-prd');
                        $('#laravel-datatable-crud-prd').DataTable().columns.adjust();
                    },
                },

                columns: [{
                        data: 'id',
                        name: 'id',
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
                        data: 'productiono',
                        name: 'productiono',
                        width:"16%"
                    },
                    {
                        data: 'requisitiono',
                        name: 'requisitiono',
                        width:"16%"
                    },
                    {
                        data: 'StoreName',
                        name: 'StoreName',
                        width:"16%"
                    },                
                    {
                        data: 'TransactionDate',
                        name: 'TransactionDate',
                        width:"15%"
                    },
                    {
                        data: 'Status',name: 'Status',
                        "render": function ( data, type, row, meta ) {
                            if(data == "Draft"){
                                return `<span class="badge bg-secondary bg-glow">${data}</span>`;
                            }
                            else if(data == "Pending"){
                                return `<span class="badge bg-warning bg-glow">${data}</span>`;
                            }
                            else if(data == "Checked"){
                                return `<span class="badge bg-primary bg-glow">${data}</span>`;
                            }
                            else if(data == "Confirmed"){
                                return `<span class="badge bg-success bg-glow">${data}</span>`;
                            }
                            else if(data == "Void" || data == "Void(Draft)" || data == "Void(Pending)" || data == "Void(Checked)" || data == "Void(Confirmed)"){
                                return `<span class="badge bg-danger bg-glow">${data}</span>`;
                            }
                            else{
                                return `<span class="badge bg-dark bg-glow">${data}</span>`;
                            }
                        },
                        width:"15%"
                    },
                    {
                        data: 'action',name: 'action',
                        "render": function ( data, type, row, meta ) {
                            return `<div class="text-center"><a class="receivingInfo" href="javascript:void(0)" onclick="receivingInfoFn(${row.id},${row.VoucherStatus})" data-id="receiving_tbl_id${row.id}" id="receiving_tbl_id${row.id}" title="Open receiving information page"><i class="fa-sharp fa-regular fa-circle-info fa-xl" style="color: #00cfe8;"></i></a></div>`;
                        },
                        width:"4%"
                    },
                    {
                        data: 'StoreId',
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
                    $('#prd_tbl').show();  
                    $('#laravel-datatable-crud-prd').DataTable().columns.adjust();
                },
                fixedHeader: {
                    header: true,
                    headerOffset: $('.header-navbar').outerHeight(),
                },
            });
            appendPrdFilterFn(fyears);
        } 

        $('#production-tab').on('shown.bs.tab', function () {
            $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
            $('#laravel-datatable-crud-prd').DataTable().columns.adjust();
        });

        function appendPrdFilterFn(fyears){
            var prd_fiscalyear = $(`
                <select class="selectpicker form-control dropdownclass" id="prd_fy" name="prd_fy[]" title="Select fiscal year here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" data-actions-box="true" data-selected-text-format="count" data-count-selected-text="Fiscal Year ({0})">
                    @foreach ($fiscalyears as $prdfy)
                        <option value="{{ $prdfy->FiscalYear }}">{{ $prdfy->Monthrange }}</option>
                    @endforeach
                </select>
            `);

            $('.prd-custom-1').html(prd_fiscalyear);
            $('#prd_fy')
            .selectpicker()
            .selectpicker('val', fyears)
            .off('changed.bs.select') 
            .on('changed.bs.select', function () {
                let year = $(this).val();
                getProductionData(year); 
            });

            var store_filter = $(`
                <select class="selectpicker form-control dropdownclass" id="prd_store_filter" name="prd_store_filter[]" title="Select store/ shop here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" data-actions-box="true" multiple data-selected-text-format="count" data-count-selected-text="Station ({0})">
                    @foreach ($storefilter as $holdstr)
                        <option selected value="{{ $holdstr->store_id }}">{{ $holdstr->store_name }}</option>
                    @endforeach
                </select>
            `);

            $('.prd-custom-2').html(store_filter);
            $('#prd_store_filter')
            .selectpicker()
            .off('changed.bs.select') 
            .on('changed.bs.select', function () {  
                var selected = $('#prd_store_filter option:selected');
                var search = [];

                // Collect selected option values
                $.each(selected, function() {
                    search.push($(this).val());
                });

                if (search.length === 0) {
                    // No option selected: force DataTable to return no data
                    prd_table.column(9).search('^$', true, false).draw(); // Match an impossible pattern
                } else {
                    // Options selected: build regex for filtering
                    var searchRegex = search.join('|'); // OR-separated values for regex
                    prd_table.column(9).search(searchRegex, true, false).draw();
                }
            });

            var status_filter = $(`
                <select class="selectpicker form-control dropdownclass" id="prd_rec_status_filter" name="prd_rec_status_filter[]" title="Select status here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" data-actions-box="true" multiple data-selected-text-format="count" data-count-selected-text="Status ({0})">
                    <option selected value="Draft">Draft</option>
                    <option selected value="Pending">Pending</option>
                    <option selected value="Checked">Checked</option>
                    <option selected value="Confirmed">Confirmed</option>
                    <option selected value="Void">Void</option>
                </select>
            `);

            $('.prd-custom-3').html(status_filter);
            $('#prd_rec_status_filter')
            .selectpicker()
            .off('changed.bs.select') 
            .on('changed.bs.select', function () {  
                var selected = $('#prd_rec_status_filter option:selected');
                var search = [];

                // Collect selected option values
                $.each(selected, function() {
                    search.push($(this).val());
                });

                if (search.length === 0) {
                    // No option selected: force DataTable to return no data
                    prd_table.column(7).search('^$', true, false).draw(); // Match an impossible pattern
                } else {
                    // Options selected: build regex for filtering
                    var searchRegex = search.join('|'); // OR-separated values for regex
                    prd_table.column(7).search(searchRegex, true, false).draw();
                }
            });
        }

        function countReceivingStatusFn(fiscalyear,src_type) {
            var fyear = 0;
            var pur_void_cnt = 0;
            var prd_void_cnt = 0;
            
            $.ajax({
                url: '/countReceivingStatus',
                type: 'POST',
                data:{
                    fyear: fiscalyear,
                },
                dataType: 'json',
                success: function(data) {
                    if(src_type == "pur"){
                        $(".receiving_status_record_lbl").html("0");
                        $.each(data.purchase_receiving_status, function(key, value) {
                            if(value.Status == "Draft"){
                                $("#receiving_draft_record_lbl").html(value.status_count);
                            }
                            else if(value.Status == "Pending"){
                                $("#receiving_pending_record_lbl").html(value.status_count);
                            }
                            else if(value.Status == "Checked"){
                                $("#receiving_checked_record_lbl").html(value.status_count);
                            }
                            else if(value.Status == "Confirmed"){
                                $("#receiving_confirmed_record_lbl").html(value.status_count);
                            }
                            else if(value.Status == "Total"){
                                $("#receiving_total_record_lbl").html(value.status_count);
                            }
                            else {
                                pur_void_cnt += parseInt(value.status_count);
                                $("#receiving_void_record_lbl").html(pur_void_cnt);
                            }
                        });

                        $("#receiving_ready_record_lbl").html(data.ready_rec_cnt);
                    }

                    if(src_type == "prd"){
                        $(".prd_rec_status_record_lbl").html("0");
                        $.each(data.production_receiving_status, function(key, value) {
                            if(value.Status == "Draft"){
                                $("#prd_rec_draft_record_lbl").html(value.status_count);
                            }
                            else if(value.Status == "Pending"){
                                $("#prd_rec_pending_record_lbl").html(value.status_count);
                            }
                            else if(value.Status == "Checked"){
                                $("#prd_rec_checked_record_lbl").html(value.status_count);
                            }
                            else if(value.Status == "Confirmed"){
                                $("#prd_rec_confirmed_record_lbl").html(value.status_count);
                            }
                            else if(value.Status == "Total"){
                                $("#prd_rec_total_record_lbl").html(value.status_count);
                            }
                            else {
                                prd_void_cnt += parseInt(value.status_count);
                                $("#prd_rec_void_record_lbl").html(prd_void_cnt);
                            }
                        });
                    }
                }
            });
        }

        //Start page load
        $(document).ready(function() {
            $('.main_datatable').hide();
            countReceivingStatusFn(fyears,"pur");
            countReceivingStatusFn(fyears,"prd");
            getReceivingData(fyears);
            getProductionData(fyears);
        });
        //End page load

        $('#laravel-datatable-crud tbody').on('click', 'tr', function () {
            $('#laravel-datatable-crud tbody > tr').removeClass('selected');
            $(this).addClass('selected');
            purGlobalIndex = $(this).index();
        });

        $('#laravel-datatable-crud-prd tbody').on('click', 'tr', function () {
            $('#laravel-datatable-crud-prd tbody > tr').removeClass('selected');
            $(this).addClass('selected');
            prdGlobalIndex = $(this).index();
        });

        function setPurFocus(targetTable) {
            $($(targetTable + ' tbody > tr')[purGlobalIndex]).addClass('selected');
        }

        function setPrdFocus(targetTable) {
            $($(targetTable + ' tbody > tr')[prdGlobalIndex]).addClass('selected');
        }

        function refreshReceivingDataFn(){
            var f_year = $('#receiving_fy').val();
            countReceivingStatusFn(f_year,"pur");

            var prd_fyear = $('#prd_fy').val();
            countReceivingStatusFn(prd_fyear,"prd");

            var rTable = $('#laravel-datatable-crud').dataTable();
            rTable.fnDraw(false);

            var hTable = $('#laravel-datatable-crud-prd').dataTable();
            hTable.fnDraw(false);
        }

        $('input[name="SourceType"]').on('change', function() {
            if(can_change_src_type){
                var source_type = $(this).val();
                $(".major_class").hide();
                $('.receipt_data_div').hide();
                $('.cost_visibility_div').hide();
                $('#dynamicTable > tbody').empty();
                $('#VoucherSt').prop('checked', false);
                if(source_type == "Purchase"){
                    $(".purchase_class").show();
                    $("#purchase_deliver_lbl").html("Purchased By<b style='color: red; font-size:16px;'>*</b>");
                    $("#invoice_deliver_lbl").html("Invoice Date<b style='color: red; font-size:16px;'>*</b>");
                    $('#Purchaser').select2({placeholder: "Select purchased by here"});

                    $(".production_input").val("");
                    $(".production_error").html("");

                }
                else if(source_type == "Production"){
                    $(".production_class").show();
                    $('.prd_price_con').show();
                    $('.vatproperty').hide();
                    $("#purchase_deliver_lbl").html("Delivered By<b style='color: red; font-size:16px;'>*</b>");
                    $("#invoice_deliver_lbl").html("Date<b style='color: red; font-size:16px;'>*</b>");
                    $('#Purchaser').select2({placeholder: "Select delivered by here"});

                    $("#beforeAfterTax").html("Total Cost");
                    $("#subGrandTotalLbl").html("Grand Total");
                    
                    $(".purchase_input").val("");
                    $(".purchase_error").html("");
                    $('.purchase_select').val(null).select2({placeholder: "Select value here..."});
                    resWitholdCalcFn();
                }
                resetSourceDateFn();
                $("#source_type-error").html("");
            }
            else{
                $(`input[name="SourceType"][value="${srctype_value}"]`).prop('checked', true);
                toastrMessage('error',"You can not change source type, because there is a record after this receiving.","Error");
            }
            CalculateGrandTotal();
        });

        function productionNumFn(){
            $("#production-number-error").html("");
        }

        function requisitionNumFn(){
            $("#req-number-error").html("");
        }

        $(document).on('show.bs.collapse hide.bs.collapse', '.collapse', function (e) {
            e.stopPropagation();
            const collapse = $(this);
            const container = collapse.closest('.card, .modal-content, .row');
            const infoTarget = container.find('.receiving_header_info');
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
                const source_type = container.find('#info_source_type').text().trim();
                const station = container.find('#infoDocReceivingStore').text().trim();
                const supplier_name = `Supplier Name: <b>${container.find('#infoDocCustomerName').text().trim()}</b>, `;
                const summaryHtml = `
                    Source Type: <b>${source_type}</b>, 
                    ${source_type == "Purchase" ? supplier_name : ""}
                    Station: <b>${station}</b>`;
                infoTarget.html(summaryHtml);
            }
        });

        //Start get customer info
        $('#supplier').on('change', function() {
            var registerForm = $("#RegisterRec");
            var formData = registerForm.serialize();
            var sid = $('#supplier').val();
            var voucherTypeVar = $('#voucherType').val();
            var supNameVar = null;
            var supCategoryVar = null;
            var supTinNumberVar = null;
            var supVatNumberVar = null;
            var mrc_option = `<option selected disabled value=''></option>`;
            if(sid == "supp01"){
                addsupplier();
            }
            else{
                $.ajax({
                    url: 'showSupplierInfo/' + sid,
                    type: 'GET',
                    success: function(data) {
                        $.each(data.customer, function(key, value) {
                            supCategoryVar = value.CustomerCategory;
                            $('#nameInfoLbl').text(value.Name);
                            $('#categoryInfoLbl').text(value.CustomerCategory);
                            $('#tinInfoLbl').text(value.TinNumber);
                            $('#vatInfoLbl').text(value.VatNumber);
                            $('#infoCardDiv').show();

                            if ((supCategoryVar === "Supplier" || supCategoryVar ==="Customer&Supplier") && voucherTypeVar === "Fiscal-Receipt") {
                                $("#voucherType option[value=Fiscal-Receipt]").show();
                                $("#voucherType option[value=Manual-Receipt]").show();
                                $("#voucherType option[value=Declarasion]").hide();
                                $("#netpayin").val($("#netpayLbl").text());
                                $("#witholdingAmntin").val($("#witholdingAmntLbl").text());
                            }
                            else if (supCategoryVar != "Foreigner-Supplier" && voucherTypeVar ==="Manual-Receipt") {
                                $('#invoicenumberdiv').hide();
                                $('#MrcNumber').val(null).trigger('change');
                                $("#voucherType option[value=Fiscal-Receipt]").show();
                                $("#voucherType option[value=Manual-Receipt]").show();
                                $("#voucherType option[value=Declarasion]").hide();
                                $("#netpayin").val($("#netpayLbl").text());
                                $("#witholdingAmntin").val($("#witholdingAmntLbl").text());
                            } 
                            else if (supCategoryVar === "Foreigner-Supplier") {
                                $('#invoicenumberdiv').hide();
                                $('#MrcNumber').val(null).trigger('change');
                                $("#voucherType option[value=Fiscal-Receipt]").hide();
                                $("#voucherType option[value=Manual-Receipt]").hide();
                                $("#voucherType").val("Declarasion");
                                $("#witholdingTr").hide();
                                $("#netpayTr").hide();
                                $("#netpayin").val("0");
                                $("#witholdingAmntin").val("0");
                            } 
                            else {
                                //$('#MrcNumber').val(null).trigger('change');
                                $("#voucherType option[value=Fiscal-Receipt]").show();
                                $("#voucherType option[value=Manual-Receipt]").show();
                                $("#voucherType option[value=Declarasion]").hide();
                                $("#witholdingTr").show();
                                $("#netpayTr").show();
                                $("#netpayin").val($("#netpayLbl").text());
                                $("#witholdingAmntin").val($("#witholdingAmntLbl").text());
                            }
                            CalculateGrandTotal();
                        });
                    }
                });

                $.ajax({
                    url: 'showMRCInfo/' + sid,
                    type: 'DELETE',
                    data: formData,
                    success: function(data) {
                        $.each(data.mrc, function(key, value) {
                            mrc_option += `<option value='${value.MRCNumber}'>${value.MRCNumber}</option>`;
                        });
                        $("#MrcNumber").empty().append(mrc_option).select2({placeholder: "Select MRC here"});
                    },
                });
            }
        });
        //End get customer info

        //Start get item info
        $('#itemNameSl').on('change', function() {
            var sid = $(this).val();
            $.ajax({
                url: 'showItemInfo/' + sid,
                type: 'GET',
                success: function(data) {
                    $.each(data.item, function(key, value) {
                        $('#itemcodeInfoLbl').text(value.Code);
                        $('#itemInfoLbl').text(value.Type);
                        $('#itemInfoLbl').text(value.Name);
                        $('#uomInfoLbl').text(value.UOM);
                        $('#itemCategoryInfoLbl').text(value.Category);
                        $('#rpInfoLbl').text(value.RetailerPrice);
                        $('#wsInfoLbl').text(value.WholesellerPrice);
                        $('#partNumInfoLbl').text(value.PartNumber);
                        $('#skuInfoLbl').text(value.SKUNumber);
                        $('#taxInfoLbl').text(value.TaxTypeId);
                        $('#itemInfoCardDiv').show();
                    });
                },
            });
        });
        //End get item info

        //Start Show Item Info
        function showItemInfos(sid){
            $.ajax({
                url: 'showItemInfo/' + sid,
                type: 'GET',
                success: function(data) {
                    $.each(data.item, function(key, value) {
                        $('#itemcodeInfoLbl').text(value.Code);
                        $('#itemInfoLbl').text(value.Type);
                        $('#itemInfoLbl').text(value.Name);
                        $('#uomInfoLbl').text(value.UOM);
                        $('#itemCategoryInfoLbl').text(value.Category);
                        $('#rpInfoLbl').text(value.RetailerPrice);
                        $('#wsInfoLbl').text(value.WholesellerPrice);
                        $('#partNumInfoLbl').text(value.PartNumber);
                        $('#skuInfoLbl').text(value.SKUNumber);
                        $('#taxInfoLbl').text(value.TaxTypeId);
                        $('#itemInfoCardDiv').show();
                    });
                },
            });
        }
        //End Show Item Info

        //Start Show Item Info
        function itemFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            var item_id = $(`#itemNameSl${idval}`).val();
            
            var arr = [];
            var found = 0;
            var reqsn = "";
            var reqed = "";
            $('.itemName').each (function(){ 
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
                $(`#unitcost${idval}`).val("");
                $(`#beforetax${idval}`).val("");
                $(`#taxamounts${idval}`).val("");
                $(`#total${idval}`).val("");
                $(`#tax${idval}`).val("");
                $(`#uom${idval}`).empty().select2({minimumResultsForSearch: -1,placeholder: "Select item first"});
                $(`#select2-itemNameSl${idval}-container`).parent().css('background-color',errorcolor);
                $(`#select2-uom${idval}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                toastrMessage('error',"Item already exist in the list","Error");
                CalculateGrandTotal();
            }
            else{
                fetchItemInfoFn(idval);
                fetchUOMListFn(idval);
         
                $(`#select2-itemNameSl${idval}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
                $(`#select2-uom${idval}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
            }
        }
        //End Show Item Info

        function fetchItemInfoFn(indx){
            var itemid = null;
            var reference_id = null;
            var reference_type = null;
            var ref_type = $('#ReferenceType').val() || 0;
            var reqsn = null;
            var reqed = null;
            var itm = $(`#itemNameSl${indx}`).val() || 0;

            $.ajax({
                url: '/fetchItemInfo', 
                type: 'POST',
                data:{
                    itemid: $(`#itemNameSl${indx}`).val() || 0,
                    reference_id: $('#Reference').val() || 0,
                    reference_type: ref_type,
                },
                beforeSend: function() {
                    blockPage(cardSection, 'Fetching item data...');
                },
                complete: function () { 
                    unblockPage(cardSection);
                },
                success: function(data) {
                    $.each(data.item_info, function(key, value) {
                        
                        reqsn = value.RequireSerialNumber;
                        reqed = value.RequireExpireDate;

                        var is_batch_req = value.RequireExpireDate == "Require-BatchNumber" || value.RequireExpireDate == "Require-Both" ? "Yes" : "No";
                        var is_expiry_req = value.RequireExpireDate == "Require-ExpireDate" || value.RequireExpireDate == "Require-Both" ? "Yes" : "No";
                        var is_serial_req = value.RequireSerialNumber == "Required" ? "Yes" : "No";
                        var tax_percent = value.TaxTypeId;
                        tax_percent = tax_percent == '' || tax_percent == null ? 0 : tax_percent;

                        $(`#uom${indx}`).empty().append(`<option selected value='${value.uom}'>${value.uom_name}</option>`).select2();

                        $('#pricing_tbl_tax').text(`Tax (${tax_percent}%)`);

                        $(`#tax${indx}`).val(tax_percent);

                        var quantity = $(`#quantity${indx}`).val() || 0;
                        var unitcost = $(`#unitcost${indx}`).val() || 0;

                        var total = parseFloat(unitcost) * parseFloat(quantity);
                        var taxamount = (parseFloat(total) * parseFloat(tax_percent) / 100);
                        var linetotal = parseFloat(total) + parseFloat(taxamount);

                        $(`#beforetax${indx}`).val(parseFloat(total).toFixed(2));
                        $(`#taxamounts${indx}`).val(parseFloat(taxamount) > 0 ? parseFloat(taxamount).toFixed(2) : 0);
                        $(`#total${indx}`).val(parseFloat(linetotal).toFixed(2));
                        CalculateGrandTotal();

                        if(is_batch_req == "Yes" || is_expiry_req == "Yes" || is_serial_req == "Yes"){
                            $(`#batch_serial_info${indx}`).attr("title",`Is Batch No. Req.: ${is_batch_req}\nIs Expiry Date Req.: ${is_expiry_req}\nIs Serial No. Req.: ${is_serial_req}`);
                            $(`#batch_serial_info${indx}`).show();
                        }

                        if(ref_type == 501 || ref_type == 502){
                            $(`#ordered_qty${indx}`).val(value.qty);
                            var remaining_qty = parseFloat(value.qty) - parseFloat(value.receivedqty);
                            remaining_qty >= 0 ? remaining_qty : 0;
                            $(`#remaining_qty${indx}`).val(remaining_qty);
                        }
                    });
                }
            });
        }

        function fetchUOMListFn(indx){
            var registerForm = $("#RegisterRec");
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
                        if(parseFloat(lastcost) > 0){
                            $(`#unitcost${indx}`).css("background","white");
                        }
                        $("#taxpercenti").val(taxper);
                        option += `<option value='${value.ToUomID}'>${value.ToUnitName}</option>`;
                    });

                    $(`#uom${indx}`).append(option).select2();
                },
            });
        }

        //Start UOM Change
        function uomsavedVal(ele) {
            var uomnewval = $('#uoms').val();
            $('#newuomi').val(uomnewval);
            var uomdefval = $('#defaultuomi').val();
            if (parseFloat(uomnewval) == parseFloat(uomdefval)) {
                $('#convertedamnti').val("1");
            } else if (parseFloat(uomnewval) != parseFloat(uomdefval)) {
                var registerForm = $("#RegisterRec");
                var formData = registerForm.serialize();
                $.ajax({
                    url: 'getUOMAmount/' + uomdefval + "/" + uomnewval,
                    type: 'DELETE',
                    data: formData,
                    success: function(data) {
                        if (data.sid) {
                            var amount = data['sid'];
                            $('#convertedamnti').val(amount);
                        }
                    },
                });
            }
            $('#convertedqi').val("");
            $('#quantityhold').val("");
        }
        //End UOM change

        //Start UOM Change
        function uomVal(ele) {
            var uomnewval = $(ele).closest('tr').find('.uom').val();
            $(ele).closest('tr').find('.NewUOMId').val(uomnewval);
            var uomdefval = $(ele).closest('tr').find('.DefaultUOMId').val();
            if (parseFloat(uomnewval) == parseFloat(uomdefval)) {
                $(ele).closest('tr').find('.ConversionAmount').val("1");
            } else if (parseFloat(uomnewval) != parseFloat(uomdefval)) {
                var registerForm = $("#RegisterRec");
                var formData = registerForm.serialize();
                $.ajax({
                    url: 'getUOMAmount/' + uomdefval + "/" + uomnewval,
                    type: 'DELETE',
                    data: formData,
                    success: function(data) {
                        if (data.sid) {
                            var amount = data['sid'];
                            $(ele).closest('tr').find('.ConversionAmount').val(amount);
                        }
                    },
                });
            }
            $(ele).closest('tr').find('.quantity').val("");
            $(ele).closest('tr').find('.ConvertedQuantity').val("");
        }
        //End UOM change

        //Start Voucher type info
        $('#voucherType').on('change', function() {
            var sid = $('#supplier').val();
            var voucherTypeVar = $('#voucherType').val();
            if (voucherTypeVar === "Manual-Receipt") {
                $('#mrcDiv').hide();
                $('#MrcNumber').val(null).trigger('change');
                $('#invoicenumberdiv').hide();
                $('#InvoiceNumber').val("");
                $('#invoiceNumber-error').html("");
                $('#docinfolbl').html("Doc. Number");
            }
            else if (voucherTypeVar === "Fiscal-Receipt") {
                $('#mrcDiv').show();
                $('#MrcNumber').val(null).trigger('change');
                $('#invoicenumberdiv').show();
                $('#InvoiceNumber').val("");
                $('#invoiceNumber-error').html("");
                $('#docinfolbl').html("FS Number");
            } 
            else if (($('#categoryInfoLbl').text() == "Supplier" || $('#categoryInfoLbl').text() =="Customer&Supplier") && voucherTypeVar == "Fiscal-Receipt") {
                $('#mrcDiv').show();
                $('#invoicenumberdiv').show();
                $('#InvoiceNumber').val("");
                $('#invoiceNumber-error').html("");
                $('#docinfolbl').html("FS Number");
            } else if ($('#categoryInfoLbl').text() == "") {
                $('#mrcDiv').hide();
                $('#MrcNumber').val(null).trigger('change');
                $('#invoicenumberdiv').hide();
                $('#InvoiceNumber').val("");
                $('#invoiceNumber-error').html("");
                $('#docinfolbl').html("Doc. Number");
            } else {
                $('#mrcDiv').hide();
                $('#MrcNumber').val(null).trigger('change');
                $('#invoicenumberdiv').hide();
                $('#InvoiceNumber').val("");
                $('#invoiceNumber-error').html("");
                $('#docinfolbl').html("Doc. Number");
            }
        });
        //End Voucher type info

        //Start Store events
        $('#store').on('change', function() {
            var sroreidvar = $(this).val();
            $('.storeid').val(sroreidvar);
        });
        //End Store events
        
        $("#adds").click(function() {
            var voucherst = $('#VoucherStatus').val()||0;
            var reference_type = $('#ReferenceType').val();
            var production_type = $('#ProductType').val();
            var source_type = $('input[name="SourceType"]:checked').val();
            var lastrowcount = $('#dynamicTable tr:last').find('td').eq(1).find('input').val();
            var itemids = $(`#itemNameSl${lastrowcount}`).val();
            var options = null;

            if(itemids !== undefined && itemids === null){
                $(`#select2-itemNameSl${lastrowcount}-container`).parent().css('background-color',errorcolor);
                toastrMessage('error',"Please select item from highlighted field","Error");
            }
            else if((production_type == "" || production_type == null) && (source_type == "Purchase" || source_type == null)){
                $('#product-type-error').html("The product type field is required");
                toastrMessage('error',"Please select source type or product type first","Error");
            }
            else{
                ++i;
                ++m;
                j += 1;
                
                $("#dynamicTable > tbody").append(`<tr>
                    <td style="font-weight:bold;text-align:center;width:3%">${j}</td>
                    <td style="display:none;"><input type="hidden" name="row[${m}][vals]" id="vals${m}" class="vals form-control" readonly="true" style="font-weight:bold;" value="${m}"/></td>
                    <td style="width:21%"><select id="itemNameSl${m}" class="select2 form-control itemName" onchange="itemFn(this)" name="row[${m}][ItemId]"></select></td>
                    <td style="width:11%"><select id = "uom${m}" class ="select2 form-control uom" onchange = "uomVal(this)" name = "row[${m}][uom]"></select></td>
                    <td style="width:12%" class="proc_module"><input type="number" name="row[${m}][ordered_qty]" id="ordered_qty${m}" class="ordered_qty form-control numeral-mask" readonly="true" style="font-weight:bold;"/></td>
                    <td style="width:12%" class="proc_module"><input type="number" name="row[${m}][remaining_qty]" id="remaining_qty${m}" class="remaining_qty form-control numeral-mask" readonly="true" style="font-weight:bold;"/></td>
                    <td style="width:12%"><input type="number" name="row[${m}][Quantity]" placeholder="Enter quantity here" id="quantity${m}" class="quantity form-control numeral-mask" onkeyup="CalculateTotal(this)" onkeypress="return ValidateNum(event);" ondrop="return false;" onpaste="return false;"/></td>
                    <td style="width:12%" class="cost_visibility_div unorder_price_col prd_price_con"><input type="number" name="row[${m}][UnitCost]" placeholder="Unit Cost" id="unitcost${m}" class="unitcost form-control numeral-mask" onkeyup="CalculateTotal(this)" onkeypress="return ValidateNum(event);"/></td>
                    <td style="width:12%" class="cost_visibility_div unorder_price_col prd_price_con"><input type="number" name="row[${m}][BeforeTaxCost]" id="beforetax${m}" class="beforetax form-control numeral-mask" readonly="true" style="font-weight:bold;"/></td>
                    <td style="width:12%" class="vatproperty cost_visibility_div"><input type="number" name="row[${m}][TaxAmount]" id="taxamounts${m}" class="taxamount form-control numeral-mask" readonly="true" style="font-weight:bold;"/></td>
                    <td style="width:12%" class="vatproperty cost_visibility_div"><input type="number" name="row[${m}][TotalCost]" id="total${m}" class="total form-control numeral-mask" readonly="true" style="font-weight:bold;"/></td>
                    <td style="width:5%;text-align:center;">
                        <a id="batch_serial_info${m}" href="javascript:void(0)" class="batch_serial_info" style="display:none;"><i class="fas fa-info-circle" style="color: #82868b;"></i></a>
                        <button type="button" id="remove_rec_item${m}" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button>
                    </td>
                    <td style="display:none;"><input type="hidden" name="row[${m}][tax]" id="tax${m}" class="tax form-control" readonly="true" style="font-weight:bold;"/></td>
                </tr>`);

                columnMgtFn();

                var default_option = `<option selected disabled value=""></option>`;
                if(source_type == "Purchase"){
                    if(reference_type == 501 || reference_type == 502){
                        options = $("#proc_item_default > option").clone();
                        $(`#itemNameSl${m}`).append(options);
                    }
                    else{
                        options = $("#item_default");
                        $(`#itemNameSl${m}`).append(options.find(`option[data-type="${production_type}"]`).clone());
                    }
                }
                else if(source_type == "Production"){
                    options = $("#item_default > option").clone();
                    $(`#itemNameSl${m}`).append(options);
                }
                
                $('#dynamicTable > tbody > tr').each(function(index, tr) {
                    let item_id = $(this).find('.itemName').val();
                    $(`#itemNameSl${m} option[value="${item_id}"]`).remove(); 
                });
                
                $(`#itemNameSl${m}`).append(default_option);
                $(`#itemNameSl${m}`).select2
                ({
                    placeholder: "Select item here...",
                });

                $(`#uom${m}`).select2
                ({
                    placeholder: "Select UOM here...",
                });

                $(`#rowId${m}`).val(generateUUIDv4Fn());

                $(`#select2-itemNameSl${m}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                $(`#select2-uom${m}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
            
                CalculateGrandTotal();
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
                $('#numberofItemsLbl').html(index);
                ind = index;
            });
            if (ind == 0) {
                $('#itemcodeInfoLbl').text("");
                $('#itemInfoLbl').text("");
                $('#itemInfoLbl').text("");
                $('#uomInfoLbl').text("");
                $('#itemCategoryInfoLbl').text("");
                $('#rpInfoLbl').text("");
                $('#wsInfoLbl').text("");
                $('#partNumInfoLbl').text("");
                $('#skuInfoLbl').text("");
                $('#taxInfoLbl').text("");
                $('#itemInfoCardDiv').hide();
                $('#pricingTable').hide();
            } else {
                $('#itemInfoCardDiv').show();
                $('#pricingTable').show();
            }
            columnMgtFn();
        }

        //Start save receiving
        $('#savebutton').click(function() {
            var optype = $("#operationtypes").val();
            var vType = $("#VoucherStatus").val() == 1 && $("#source_type").val() == "Purchase" ? 1 : 2;
            var source_type = $("#source_type").val();
            var voucher_st = $("#VoucherStatus").val();
            var sup = supplier.value;
            var str = store.value;
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
                var numofitems = $('#numberofItemsLbl').text();
                var registerForm = $("#RegisterRec");
                var formData = registerForm.serialize();
                $.ajax({
                    url: '/saveReceiving',
                    type: 'POST',
                    data: formData,
                    beforeSend: function() { 
                        if(parseInt(optype) == 1){
                            $('#savebutton').text('Saving...');
                            $('#savebutton').prop("disabled", true);
                            progress_text = "Saving receiving";
                        }
                        else if(parseInt(optype) == 2){
                            $('#savebutton').text('Updating...');
                            $('#savebutton').prop("disabled", true);
                            progress_text = "Updating receiving";
                        }

                        blockPage(cardSection,progress_text);
                    },
                    complete: function () { 
                        unblockPage(cardSection);     
                    },
                    success: function(data) {
                        if (data.errors) {
                            if (data.errors.SourceType) {
                                $('#source_type-error').html(data.errors.SourceType[0]);
                            }
                            if (data.errors.ReferenceType) {
                                $('#reference-type-error').html(data.errors.ReferenceType[0]);
                            }
                            if (data.errors.Reference) {
                                var text = data.errors.Reference[0];
                                text = text.replace("501", "PO");
                                text = text.replace("502", "PI");
                                $('#reference-doc-error').html(text);
                            }
                            if (data.errors.ProductType) {
                                $('#product-type-error').html(data.errors.ProductType[0]);
                            }
                            if (data.errors.supplier) {
                                $('#supplier-error').html(data.errors.supplier[0]);
                            }
                            if (data.errors.DocumentNumber) {
                                $('#docnumber-error').html(data.errors.DocumentNumber[0]);
                            }

                            if (data.errors.VoucherStatus) {
                                var text = data.errors.VoucherStatus[0];
                                text = text.replace("voucher status", "receiving type");
                                $('#voucherstatus-error').html(text);
                            }

                            if (data.errors.PaymentType) {
                                var text = data.errors.PaymentType[0];
                                text = text.replace("503", "Unorder");
                                $('#paymentType-error').html(text);
                            }
                            if (data.errors.date) {
                                var text = data.errors.date[0];
                                text = text.replace("503", "Unorder");
                                $('#date-error').html(text);
                            }
                            if (data.errors.voucherType) {
                                var text = data.errors.voucherType[0];
                                text = text.replace("1", "available");
                                text = text.replace("voucher", "invoice");
                                $('#voucherType-error').html(text);
                            }
                            if (data.errors.VoucherNumber) {
                                var text = data.errors.VoucherNumber[0];
                                text = text.replace("1", "available");
                                $('#voucherNumber-error').html(text);
                            }
                            if (data.errors.InvoiceNumber) {
                                $('#invoiceNumber-error').html(data.errors.InvoiceNumber[0]);
                            }
                            if (data.errors.MrcNumber) {
                                $('#mrcNumber-error').html(data.errors.MrcNumber[0]);
                            }
                            if (data.errors.store) {
                                var text = data.errors.store[0];
                                text = text.replace("store", "station");
                                $('#store-error').html(text);
                            }
                            if (data.errors.Purchaser) {
                                var src_type = $('#source_type').html();
                                var text = data.errors.Purchaser[0];
                                text = text.replace("purchaser", "purchaser/ delivered by");
                                $('#purchaser-error').html(text);
                            }

                            if (data.errors.ReceivedBy) {
                                $('#receivedby-error').html(data.errors.ReceivedBy[0]);
                            }
                            if (data.errors.ReceivedDate) {
                                $('#received-date-error').html(data.errors.ReceivedDate[0]);
                            }

                            if (data.errors.productionNumber) {
                                $('#production-number-error').html(data.errors.productionNumber[0]);
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
                        } 
                        else if (data.errorv2) {
                            var error_html = '';
                            var selecteditemsvar = '';
                            var reference_type =  $('#ReferenceType').val();
                            var isChecked = $('#VisibleCost').is(':checked');
                            $('#dynamicTable > tbody > tr').each(function (index) {
                                let k = $(this).find('.vals').val();
                                var itmid = ($(`#itemNameSl${k}`)).val();
                                var insqnt = ($(`#insertedqty${k}`)).val();
                                if(($(`#quantity${k}`).val())!=undefined){
                                    var qnt = $(`#quantity${k}`).val();
                                    if(isNaN(parseFloat(qnt)) || parseFloat(qnt) == 0){
                                        $(`#quantity${k}`).css("background", errorcolor);
                                    }
                                }
                                if(($(`#unitcost${k}`).val()) != undefined && (reference_type == 503 || isChecked)){
                                    var unitc = $(`#unitcost${k}`).val();
                                    if(isNaN(parseFloat(unitc)) || parseFloat(unitc) == 0){
                                        $(`#unitcost${k}`).css("background", errorcolor);
                                    }
                                }
                                if(($(`#beforetax${k}`).val()) != undefined && (reference_type == 503 || isChecked)){
                                    var beforetx = $(`#beforetax${k}`).val();
                                    if(isNaN(parseFloat(beforetx)) || parseFloat(beforetx) == 0){
                                        $(`#beforetax${k}`).css("background", errorcolor);
                                    }
                                }
                                if(($(`#taxamounts${k}`).val()) != undefined && (reference_type == 503 || isChecked)){
                                    var totaltax = $(`#taxamounts${k}`).val();
                                    if(isNaN(parseFloat(totaltax)) || parseFloat(totaltax) == 0){
                                        $(`#taxamounts${k}`).css("background", errorcolor);
                                    }
                                }
                                if(($(`#total${k}`).val()) != undefined && (reference_type == 503 || isChecked)){
                                    var gtotal=$(`#total${k}`).val();
                                    if(isNaN(parseFloat(gtotal)) || parseFloat(gtotal) == 0){
                                        $(`#total${k}`).css("background", errorcolor);
                                    }
                                }
                                if(isNaN(parseFloat(itmid)) || parseFloat(itmid) == 0){
                                    $(`#select2-itemNameSl${k}-container`).parent().css('background-color',errorcolor);
                                }
                                if(($(`#insertedqty${k}`).val())!=undefined && ($(`#quantity${k}`).val())!=undefined){
                                    var insertedquantitys = $(`#insertedqty${k}`).val();
                                    var actualquantity = $(`#quantity${k}`).val()||0;
                                    if((parseFloat(insertedquantitys) != parseFloat(actualquantity)) && parseFloat(actualquantity) != 0){
                                        $(`#itemNameSl${k} :selected`).each(function() {
                                            selecteditemsvar += `${this.text} </br>`;
                                        });
                                        error_html = ` and insert serial number or expire date for</br>${selecteditemsvar}`;
                                    } 
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
                            toastrMessage('error',"Please insert valid data on highlighted fields!</br>"+error_html,"Error");
                        } 
                        else if (data.dberrors) {
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
                            if(parseInt(optype) == 1){
                                $('#savebutton').text('Save');
                                $('#savebutton').prop("disabled", false);
                            }
                            else if(parseInt(optype) == 2){
                                $('#savebutton').text('Update');
                                $('#savebutton').prop("disabled", false);
                            }
                            toastrMessage('error',"Please add atleast one item","Error");
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
                        else if (data.success) {
                            toastrMessage('success',"Successful","Success");
                            $(".receiving-tab-view").removeClass("active");
                            var source_type = $('input[name="SourceType"]:checked').val();
                            source_type == "Production" ? $(".prd-view").addClass("active") : $(".pur-view").addClass("active");
                            countReceivingStatusFn(data.fiscalyr,"pur");
                            countReceivingStatusFn(data.fiscalyr,"prd");

                            var oTable = $('#laravel-datatable-crud').dataTable();
                            oTable.fnDraw(false);

                            var pTable = $('#laravel-datatable-crud-prd').dataTable();
                            pTable.fnDraw(false);
                            if(parseFloat(optype) == 2){
                                createReceivingInfoFn(data.receivingId,vType);
                            }
                            $("#inlineForm").modal('hide');
                            var isChecked = $('#printGRVCBX').is(':checked');
                            if (isChecked == true) {
                                var link = source_type == "Purchase" ? "/grv/" + data.receivingId : "/grv_prd/" + data.receivingId;
                                window.open(link, 'GRV', 'width=1200,height=800,scrollbars=yes');
                            }
                        }
                    },
                });
            }
        });
        //End save receiving

        //Start get hold number value
        $('#addrecbutton').click(function(){ 
            $.get("/getHoldNumber", function(data) {
                $('#holdnumberi').val(data.holdnum);
                $('#receivingnumberi').val(data.recnum);
                $('#witholdPercenti').val(data.witholdPer);
                $('#withodingTitleLbl').html("Witholding (" + data.witholdPer + "%)");
                $('#witholdMinAmounti').val(data.witholdAmnt);
                var dbval = data.ReceivingHoldCount;
                var rnum = (Math.floor(Math.random() * 10000) + 10000).toString().substring(1);
                $('#commonVal').val(rnum + dbval);
            });
            resetFormFn();

            $('#formId').val(generateUUIDv4Fn());
            $('#tid').val("");
            $('#receivingId').val("");
            $('#hiddenstoreval').val("");
            $("#newreceivingmodaltitles").html("Add Receiving");
            $("#inlineForm").modal('show');
        });
        //End get hold number value

        function resetFormFn(){
            $('#Reference').val(null).select2({
                placeholder: "Select reference here",
            });
            $('#ProductType').val(null).select2({
                placeholder: "Select product type here",
                minimumResultsForSearch: -1
            });
            $('#source_type').val(null).select2({
                placeholder: "Select source type here",
                minimumResultsForSearch: -1
            });
            $('#supplier').val(null).select2({
                placeholder: "Select supplier here",
                dropdownCssClass : 'commprp',
            });
            $('#store').val(null).select2({
                placeholder: "Select station here",
            });
            $('#Purchaser').val(null).select2({
                placeholder: "Select purchased by here",
            });
            $('#voucherType').val(null).select2({
                placeholder: "Select voucher type here",
                minimumResultsForSearch: -1
            });
            $('#PaymentType').val(null).select2({
                placeholder: "Select payment type here",
                minimumResultsForSearch: -1
            });
            $('#MrcNumber').val(null).select2({
                placeholder: "Select MRC No. here",
            });
            $('#VoucherStatus').val(null).select2({
                placeholder: "Select receiving type here",
                minimumResultsForSearch: -1
            });
            $('#ReceivingType').val(null).select2({
                placeholder: "Select type here",
                minimumResultsForSearch: -1
            });
            $('#ProductType').val(null).select2({
                placeholder: "Select production type here",
                minimumResultsForSearch: -1
            });

            $('#ReceivedBy').val(null).select2({
                placeholder: "Select received by here",
            });

            $('input[name="SourceType"]').prop('checked', false);

            $("#printgrvdiv").show();
            $("#savebutton").show();
            $('#savebutton').text('Save');
            $('#savebutton').prop("disabled", false);
            $("#checkboxVali").val("1");
            $("#operationtypes").val("1");
            $("#witholdingTr").hide();
            $("#netpayTr").hide();
            
            $('#docinfolbl').html("FS No.");
            $("#voucherType option[value=Declarasion]").hide();
            $("#voucherType option[value=Manual-Receipt]").show();
            $('#invoicenumberdiv').hide();
            $('.invprop').show(); 
            $('.vatproperty').show();
            $('#beforeAfterTax').html("Before Tax");
            $('#subGrandTotalLbl').html("Sub Total");
            $('#invdatelbl').html("Invoice Date");
            $('#mrcDiv').hide();

            $("#statusdisplay").html("");
            $(".errordatalabel").html("");
            $(".mainforminp").val("");
            $(".form_reset_cls").html("");
            $("#invoicenumberdiv").show();
            $(".major_class").hide();
            $(".receipt_data_div").hide();
            $("#document_no_div").hide();
            $('.cost_visibility_div').hide(); 

            $("#purchase_deliver_lbl").html("Purchased By");
            $("#invoice_deliver_lbl").html("Date<b style='color: red; font-size:16px;'>*</b>");

            $("#voucherType option[value=Declarasion]").hide();
            $("#voucherType option[value=Fiscal-Receipt]").show();
            $("#voucherType option[value=Manual-Receipt]").show();

            $("#dynamicTable > tbody").empty();
            $(".receiving_child_data_div").show();

            $('.proc_module').hide();
            $("#qty_header").html(`Quantity<b style="color: red; font-size:16px;">*</b>`);

            can_change_src_type = true;

            $('#printGRVCBX').prop('checked', true);
            $('#hideGRVCBX').prop('checked', false);

            flatpickr('#date', { dateFormat: 'Y-m-d',clickOpens:true,maxDate:currentdate});
            flatpickr('#ReceivedDate', { dateFormat: 'Y-m-d',clickOpens:true,maxDate:currentdate});
            flatpickr('#ProductionDate', { dateFormat: 'Y-m-d',clickOpens:true,maxDate:currentdate});
            resetSourceDateFn();
        }

        function resetSourceDateFn(){
            var receivng_md = $("#receiving_mode").val();
            var reference_option = $("#ReferenceTypeDefault");

            if(receivng_md == 0){
                $('#ReferenceType').empty().append(reference_option.find(`option[value="503"]`).clone());
                $('#ReferenceType').trigger('change').select2({minimumResultsForSearch: -1});
                $('.cost_visibility_div').show(); 
            }
            else if(receivng_md == 1){
                $('#ReferenceType').empty().append(reference_option.find(`option[value!=503]`).clone());
                //$('.cost_visibility_div').hide(); 

                $('#ReferenceType').val(null).select2({
                    placeholder: "Select reference type here",
                    minimumResultsForSearch: -1
                });

                $('#ProductType').empty().select2({
                    placeholder: "Select product type here",
                    minimumResultsForSearch: -1
                });
            }

            $('#Reference').empty().select2({
                placeholder: "Select reference here",
                minimumResultsForSearch: -1
            });

            $('#VisibleCost').prop('checked', false);
            $('.default_hidden_div').hide();
            $('.source_data_dynamic_div').hide();
        }

        function showCostColumnFn(){
            var receivng_type = $("#ReferenceType").val(); 
            var isChecked = $('#VisibleCost').is(':checked');
            $('#VoucherSt').prop('checked', false);
            if(isChecked){
                $('.cost_visibility_div').show();
            }
            else{
                $('.cost_visibility_div').hide();
            }
        }

        function mngReceiptDataFn(){
            $('.receipt_data_div').show();
            $('.unorder_price_col').show();
            $('.unorder_price_div').show();
            $('#VoucherSt').prop('checked', true);
            voucherStatusFn();
            resetReceiptDataFn();
        }

        function columnMgtFn(){
            var source_type = $('input[name="SourceType"]:checked').val();
            var receivng_type = $("#ReferenceType").val();
            var isChecked = $('#VisibleCost').is(':checked');
            var voucherst = $('#VoucherSt').is(':checked') ? 1 : 2;

            if(source_type == "Purchase"){
                if(parseInt(receivng_type) == 500){
                    if(isChecked){
                        $('.cost_visibility_div').show();
                    }
                    else{
                        $('.cost_visibility_div').hide();
                    }
                    $('.proc_module').hide();
                    $("#qty_header").html(`Quantity<b style="color: red; font-size:16px;">*</b>`);
                }
                else if(parseInt(receivng_type) == 501 || parseInt(receivng_type) == 502){
                    $('.cost_visibility_div').hide();
                    $('.proc_module').show();
                    $("#qty_header").html(`Received Qty<b style="color: red; font-size:16px;">*</b>`);
                }
                else if(parseInt(receivng_type) == 503){
                    $('.receipt_data_div').show();
                    $('.unorder_price_col').show();
                    $('.unorder_price_div').show();
                    $('.proc_module').hide();
                    $("#qty_header").html(`Quantity<b style="color: red; font-size:16px;">*</b>`);
                    voucherStatusFn();
                }
            }
            else{
                $(".production_class").show();
                $('.prd_price_con').show();
                $('.vatproperty').hide();
                $('.proc_module').hide();
                $("#qty_header").html(`Quantity<b style="color: red; font-size:16px;">*</b>`);
            }
        }

        function calculateVat(vstatus){
            var quantity = 0;
            var unitcost = 0;
            var beforetax = 0;
            var tax = 0;
            var total = 0;
            var linetotal = 0;
            var taxpercent = 0;
            
            if(parseInt(vstatus) == 1){
                for(var i = 0;i <= m;i++){
                    var taxpercent = $(`#tax${i}`).val()||0;
                    quantity = $(`#quantity${i}`).val()||0;
                    unitcost = $(`#unitcost${i}`).val()||0;
                    unitcost = unitcost == '' ? 0 : unitcost;
                    quantity = quantity == '' ? 0 : quantity;
                    total = parseFloat(unitcost) * parseFloat(quantity);
                    taxamount = (parseFloat(total) * parseFloat(taxpercent) / 100);
                    linetotal = parseFloat(total) + parseFloat(taxamount);
                    $(`#beforetax${i}`).val(total.toFixed(2));
                    $(`#taxamounts${i}`).val(taxamount.toFixed(2));
                    $(`#total${i}`).val(linetotal.toFixed(2));
                }
            }
            else if(parseInt(vstatus)==2){
                for(var i = 0;i <= m;i++){
                    quantity = $(`#quantity${i}`).val()||0;
                    unitcost = $(`#unitcost${i}`).val()||0;
                    unitcost = unitcost == '' ? 0 : unitcost;
                    quantity = quantity == '' ? 0 : quantity;
                    total = parseFloat(unitcost) * parseFloat(quantity);
                    
                    $(`#beforetax${i}`).val(total.toFixed(2));
                    $(`#taxamounts${i}`).val("0");
                    $(`#total${i}`).val(total.toFixed(2));
                }
            }
            CalculateGrandTotal();
        }

        function CalculateTotal(ele) {
            var inputid = ele.getAttribute('id');
            var cid = $(ele).closest('tr').find('.vals').val();
            var taxpercent = $(`#tax${cid}`).val() > 0 ? $(`#tax${cid}`).val() : 0;
            var unitcost = $(ele).closest('tr').find('.unitcost').val();
            var quantity = $(ele).closest('tr').find('.quantity').val();
            var retailerprice = $(ele).closest('tr').find('.RetailerPrice').val();
            var wholeseller = $(ele).closest('tr').find('.Wholeseller').val();
            var reqexp = $(ele).closest('tr').find('.RequireExpireDate').val();
            var reqser = $(ele).closest('tr').find('.RequireSerialNumber').val();
            
            unitcost = unitcost == '' ? 0 : unitcost;
            quantity = quantity == '' ? 0 : quantity;
            retailerprice = retailerprice == '' ? 0 : retailerprice;
            wholeseller = wholeseller == '' ? 0 : wholeseller;
            
            if (!isNaN(unitcost) && !isNaN(quantity)) {
                var total = parseFloat(unitcost) * parseFloat(quantity);
                var taxamount = (parseFloat(total) * parseFloat(taxpercent) / 100);
                var linetotal = parseFloat(total) + parseFloat(taxamount);
                $(ele).closest('tr').find('.beforetax').val(total.toFixed(2));
                $(ele).closest('tr').find('.taxamount').val(taxamount.toFixed(2));
                $(ele).closest('tr').find('.total').val(linetotal.toFixed(2));

                if(inputid==="unitcost"+cid){
                    $(ele).closest('tr').find('.unitcost').css("background","white");
                }
                if(inputid==="quantity"+cid){
                    $(ele).closest('tr').find('.quantity').css("background","white");
                }
                if(parseFloat(total)>0){
                    $(ele).closest('tr').find('.beforetax').css("background","#efefef");
                    $(ele).closest('tr').find('.taxamount').css("background","#efefef");
                    $(ele).closest('tr').find('.total').css("background","#efefef");
                }
            }
            var defuom = $(ele).closest('tr').find('.DefaultUOMId').val();
            var newuom = $(ele).closest('tr').find('.NewUOMId').val();
            var convamount = $(ele).closest('tr').find('.ConversionAmount').val();
            var convertedq = parseFloat(quantity) / parseFloat(convamount);


            CalculateGrandTotal();
        }

        function CalculateGrandTotal() {
            var subtotal = 0;
            var tax = 0;
            var grandTotal = 0;
            var witholdam = $('#witholdMinAmounti').val()||0;
            var witholdpr = $('#witholdPercenti').val()||0;
            var source_type = $('#source_type').val();
            var receiving_type = $('#VoucherStatus').val();

            $.each($('#dynamicTable').find('.beforetax'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    subtotal += parseFloat($(this).val());
                }
            });
            $.each($('#dynamicTable').find('.taxamount'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    tax += parseFloat($(this).val());
                }
            });
            $.each($('#dynamicTable').find('.total'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    grandTotal += parseFloat($(this).val());
                }
            });
            var cc = $('#categoryInfoLbl').text();
            if (parseFloat(subtotal.toFixed(2)) >= parseFloat(witholdam) && parseFloat(witholdpr) > 0 && source_type == "Purchase" && receiving_type == 1) {
                var st = parseFloat(subtotal.toFixed(2));
                var wp = parseFloat(witholdpr);
                var tt = 0;
                var np = 0;
                tt = (st * wp) / 100;
                np = parseFloat(grandTotal.toFixed(2)) - tt;
                $('#witholdingAmntLbl').html(numformat(tt.toFixed(2)));
                $('#witholdingAmntin').val(tt.toFixed(2));
                $('#netpayLbl').html(numformat(np.toFixed(2)));
                $('#netpayin').val(np.toFixed(2));
                if (cc === "Foreigner-Supplier" || cc === "Person") {
                    $("#witholdingTr").hide();
                    $("#netpayTr").hide();
                } 
                else if (parseFloat(subtotal.toFixed(2)) >= parseFloat(witholdam) && parseFloat(witholdpr) > 0) {
                    $("#witholdingTr").show();
                    $("#netpayTr").show();
                }
            } 
            else if (parseFloat(subtotal.toFixed(2)) < parseFloat(witholdam) || parseFloat(witholdpr) == 0 || cc ==="Foreigner-Supplier" || cc === "Person") {
                resWitholdCalcFn();
            }
            $('#subtotalLbl').html(numformat(subtotal.toFixed(2)));
            $('#subtotali').val(subtotal.toFixed(2));
            $('#taxLbl').html(numformat(tax.toFixed(2)));
            $('#taxi').val(tax.toFixed(2));
            $('#grandtotalLbl').html(numformat(grandTotal.toFixed(2)));
            $('#grandtotali').val(grandTotal.toFixed(2));
        }

        function resWitholdCalcFn(){
            $('#witholdingAmntLbl').html("0");
            $('#witholdingAmntin').val("0");
            $('#netpayLbl').html("0");
            $('#netpayin').val("0");
            $("#witholdingTr").hide();
            $("#netpayTr").hide();
        }

        function CalculateAddHoldTotal(ele) {
            var taxpercent = $("#taxpercenti").val();
            var quantity = $('#quantityhold').val();
            var unitcost = $('#unitcosthold').val();
            var retailerprice = $('#retailerpricei').val();
            var wholeseller = $('#wholeselleri').val();
            unitcost = unitcost == '' ? 0 : unitcost;
            quantity = quantity == '' ? 0 : quantity;
            if (!isNaN(unitcost) && !isNaN(quantity)) {
                var total = parseFloat(unitcost) * parseFloat(quantity);
                var taxamount = (parseFloat(total) * parseFloat(taxpercent) / 100);
                var linetotal = parseFloat(total) + parseFloat(taxamount);
                $('#beforetaxhold').val(total.toFixed(2));
                $('#taxamounthold').val(taxamount.toFixed(2));
                $('#totalcosthold').val(linetotal.toFixed(2));
            }
            var defuom = $('#defaultuomi').val();
            var newuom = $('#newuomi').val();
            var convamount = $('#convertedamnti').val();
            var convertedq = parseFloat(quantity) / parseFloat(convamount);
            $('#convertedqi').val(convertedq);
        }

        //Start withold settle 
        $('#settlewitholdbtn').click(function(){
            var receipt_num = $('#ReceiptNumber').val();
            var receipt_date = $('#ReceiptDate').val();

            if(!isNaN(parseInt(receipt_num)) && receipt_date != ""){
                Swal.fire({
                    title: confirmation_title,
                    text: 'Are you sure you want to settle the withholding receipts for the selected records?',
                    icon: confirmation_icon,
                    showCloseButton: true,
                    showCancelButton: true,      
                    allowOutsideClick: false,
                    confirmButtonText: 'Settle',
                    cancelButtonText: 'Close',
                    customClass: {
                        confirmButton: 'btn btn-info',
                        cancelButton: 'btn btn-danger'
                    }
                }).then(function (result) {
                    if (result.value) {
                        settleWitholdRecFn();
                    }
                    else if (result.dismiss === Swal.DismissReason.cancel) {}
                });
            }
            else{
                if(isNaN(parseInt(receipt_num))){
                    $('#receipt-error').html("The receipt number field is required.");
                }
                if(receipt_date == "" || receipt_date == null){
                    $('#receipt-date-error').html("The receipt date field is required.");
                }
                toastrMessage('error',"Check your inputs","Error");
            }
        });
        //End withold settle number

        function settleWitholdRecFn(){
            var registerForm = $('#ManageWitholdForm');
            var formData = registerForm.serialize();
            
            $.ajax({
                url: '/settleWitholdFn',
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    blockPage(cardSection, 'Settling withholding...');
                },
                complete: function () { 
                    unblockPage(cardSection);    
                },
                success: function(data) {
                    if (data.recerror) {
                        $('#receipt-error').html("receipt number already taken.");
                        toastrMessage('error',"Check your inputs, receipt number already taken.","Error");
                    }
                    else if (data.errors) {
                        if (data.errors.ReceiptNumber) {
                            $('#receipt-error').html(data.errors.ReceiptNumber[0]);
                        }
                        if (data.errors.ReceiptDate) {
                            $('#receipt-date-error').html(data.errors.ReceiptDate[0]);
                        }
                        toastrMessage('error',"Check your inputs","Error");
                    }
                    else if (data.dberrors) {
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if (data.success){
                        toastrMessage('success',"Successful","Success");
                        createReceivingInfoFn(data.recId,data.vStatus);
                        getWitholdDataFn(data.cus_id,data.trn_date);
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                    }
                }
            });
        }

        //Start withold settle 
        $('#separateSettleBtn').click(function(){
            var registerForm = $('#sepwitholdSettleForm');
            var formData = registerForm.serialize();
            $.ajax({
                url: '/sepsettleWitholdFn',
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('#separateSettleBtn').text('Please Wait...');
                    $('#separateSettleBtn').prop("disabled", true);
                },
                success: function(data) {
                    if (data.recerror) {
                        $('#receipts-error').html("receipt number already taken.");
                        $('#separateSettleBtn').text('Settle');
                        $('#separateSettleBtn').prop("disabled", false);
                        toastrMessage('error',"Check your inputs","Error");
                    }
                    if (data.errors) {
                        if (data.errors.ReceiptNumbers) {
                            $('#receipts-error').html(data.errors.ReceiptNumbers[0]);
                        }
                        $('#separateSettleBtn').text('Settle');
                        $('#separateSettleBtn').prop("disabled", false);
                        toastrMessage('error',"Check your inputs","Error");
                    }
                    if (data.success) {
                        $('#separateSettleBtn').text('Settle');
                        $('#separateSettleBtn').prop("disabled", false);
                        toastrMessage('success',"Successful","Success");
                        $("#separateSettleModal").modal('hide');
                        ReceiptNumberVal();
                    }
                },
            });
        });
        //End withold settle number

        function resetSourceDataForEditFn(){
            $(".major_class").hide();
            $("#dynamicTable > tbody").empty();
            $(".receiving_child_data_div").hide();
            $('#printGRVCBX').prop('checked', false);
            $("#witholdingTr").hide();
            $("#netpayTr").hide();
            $('.reference_doc').hide();
            $('.default_hidden_div').hide();
            $('.source_data_dynamic_div').hide();
            $('.receipt_data_div').hide();
            $('.unorder_pricing_div').hide();
            $('.unorder_price_col').hide();
            $('.cost_visibility_div').show();
            $('.errordatalabel').html("");
        }

        function editReceivingFn(recIdVar) {
            var customercat = "";
            var status_color = "";
            var receivng_md = $("#receiving_mode").val();
            var reference_option = $("#ReferenceTypeDefault");
            var j = 0;
            var options = null;
            var source_type = null;
            var reference_type = null;
            var product_type = null;
            var ref_options = $("#proc_data_default");
            $('#VoucherSt').prop('checked', false);
            resetSourceDataForEditFn();
            resetFormFn();
            $.ajax({
                type: "get",
                url: "{{url('getWithNumber')}}",
                dataType: "json",
                success: function (data) {
                    $('#witholdPercenti').val(data.witholdPer);
                    $('#withodingTitleLbl').html("Witholding (" + data.witholdPer + "%)");
                    $('#witholdMinAmounti').val(data.witholdAmnt);
                }
            });

            $.ajax({
                type: "get",
                url: "{{url('recevingedit')}}"+"/"+recIdVar,
                dataType: "json",
                beforeSend: function () { 
                    blockPage(cardSection, 'Fetching receiving record...');
                },
                complete: function () {
                    unblockPage(cardSection);    
                },
                success: function (data) {
                    customercat = data.cuscatdata;
                    var statusvals = data.recData.Status;
                    var fyearrec = data.recData.fiscalyear;
                    var fyearcurr = data.fiscalyr;
                    var fyearstore = data.fiscalyrval;
                    
                    $.each(data.recData, function(key, value) {
                        source_type = value.source_type;
                        reference_type = value.Type;
                        product_type = value.ProductType;
                        
                        $(`input[name="SourceType"][value="${value.source_type}"]`).prop('checked', true);

                        if(receivng_md == 0){
                            $('#ReferenceType').empty().append(reference_option.find(`option[value="503"]`).clone());
                        }
                        else if(receivng_md == 1){
                            $('#ReferenceType').empty().append(reference_option.find(`option[value!=503]`).clone());
                        }

                        $(`#ReferenceType option[value="${value.Type}"]`).remove(); 
                        $('#ReferenceType').append(`<option selected value="${value.Type}">${value.reference_type}</option>`).select2({minimumResultsForSearch: -1});

                        if(value.Type == 500 || value.Type == 503){
                            var product_type_options = `
                                <option value="Goods">Goods</option>
                                <option value="Commodity">Commodity</option>
                                <option value="Metal">Metal</option>`;

                            var supplier_options = $("#supplier_default > option").clone();

                            $('#ProductType').empty().append(product_type_options).select2();
                            $(`#ProductType option[value="${value.ProductType}"]`).remove();
                            $('#ProductType').append(`<option selected value="${value.ProductType}">${value.ProductType}</option>`).select2({minimumResultsForSearch: -1});

                            $('#supplier').empty().append(supplier_options).select2();
                            $(`#supplier option[value="${value.CustomerId}"]`).remove();
                            $('#supplier').append(`<option selected value="${value.CustomerId}">${value.supplier_name}</option>`).select2();
                            options = $("#item_default");
                            $('#Reference').empty().select2();

                            if(value.Type == 503){
                                $('#PaymentType').val(value.PaymentType).select2({minimumResultsForSearch: -1});
                                $('#VoucherSt').prop('checked', value.VoucherStatus == 1);
                                //$('#VoucherStatus').val(value.VoucherStatus).select2({minimumResultsForSearch: -1});
                                $('#voucherType').val(value.VoucherType).select2({minimumResultsForSearch: -1});
                                $('#VoucherNumber').val(value.VoucherNumber);
                                $('#InvoiceNumber').val(value.InvoiceNumber);
                                $(`#MrcNumber option[value="${value.CustomerMRC}"]`).remove(); 
                                $('#MrcNumber').append(`<option selected value="${value.CustomerMRC}">${value.CustomerMRC}</option>`).select2();
                                $('#date').val(value.TransactionDate);

                                $('.receipt_data_div').show();
                                $('.unorder_price_col').show();
                                $('.unorder_price_div').show();
                                $("#document_no_div").hide();
                            }
                            else{
                                $('#DocumentNumber').val(value.DeliveryOrderNo);
                                $('#VisibleCost').prop('checked', value.is_cost_shown == 1);
                                $('#src_cost_visibility').show();
                                $("#document_no_div").show();
                                $('.cost_visibility_div').hide();
                            }
                            $("#src_expiry_date").hide();
                        }
                        else if(value.Type == 501 || value.Type == 502){
                            $('#VoucherSt').prop('checked', false);
                            $('#ProductType').empty().append(`<option selected value="${value.ProductType}">${value.ProductType}</option>`).select2({minimumResultsForSearch: -1});
                            $('#supplier').empty().append(`<option selected value="${value.CustomerId}">${value.supplier_name}</option>`).select2({minimumResultsForSearch: -1});
                            var p_type = value.Type == 501 ? "po" : "pi";
                            $('#Reference').append(ref_options.find(`option[data-type="${p_type}"]`).clone());
                            $(`#Reference option[value="${value.PoId}"]`).remove();
                            $('#Reference').append(`<option selected value="${value.PoId}">${value.porderno}, ${value.supplier_name}</option>`).select2();
                            $('#DocumentNumber').val(value.DeliveryOrderNo);

                            fetchReferenceDataEditFn(value.Type,value.PoId);
                            options = $("#proc_item_default > option").clone();

                            $('#reference_doc_div').show();
                            $("#document_no_div").show();
                            $('.cost_visibility_div').hide();

                            var expiry_flag_color = "";
                            var expiry_info = "";
                            var delivery_date = new Date(value.deliverydate);
                            var current_date = new Date(currentdate);

                            if(delivery_date < current_date){
                                expiry_flag_color = "#ea5455";
                                expiry_info = '<a id="expiry_info_btn" href="javascript:void(0)" class="expiry_info_btn" title="Purchase order expired."><i class="fas fa-info-circle" style="color: #82868b;"></i></a>';
                            }
                            else{
                                expiry_flag_color = "#5e5873";
                                expiry_info = "";
                            }
                  
                            $("#reference_date_lbl").html(`Expiry Date: <b style="color:${expiry_flag_color}">${value.deliverydate}</b> ${expiry_info}`);
                            $("#src_expiry_date").show();
                        }

                        $('#store').val(value.StoreId).select2();
                        $('#hiddenstoreval').val(value.StoreId);
                        $('#ReceivedBy').val(value.ReceivedBy).select2();
                        flatpickr('#ReceivedDate', { dateFormat: 'Y-m-d',clickOpens:true,maxDate:currentdate});
                        $('#ReceivedDate').val(value.ReceivedDate);
                        $('#Memo').val(value.Memo);

                        $('#DeliveredBy').val(value.DeliveredBy);
                        $('#PlateNumber').val(value.TruckPlateNo);

                        $('#production_number').val(value.productiono);
                        $('#requisition_number').val(value.requisitiono);
                        $('#ProductionDeliveredBy').val(value.DeliveredBy);
                        $('#ProductionDate').val(value.TransactionDate);

                        if(value.source_type == "Purchase"){
                            $(".purchase_class").show();
                            $("#purchase_deliver_lbl").html("Purchased By<b style='color: red; font-size:16px;'>*</b>");
                            $("#invoice_deliver_lbl").html("Invoice Date<b style='color: red; font-size:16px;'>*</b>");
                        }
                        else if(value.source_type == "Production"){
                            options = $("#item_default > option").clone();
                            $(".production_class").show();
                            $("#purchase_deliver_lbl").html("Delivered By<b style='color: red; font-size:16px;'>*</b>");
                            $("#invoice_deliver_lbl").html("Date<b style='color: red; font-size:16px;'>*</b>");
                        }

                        var sid = value.CustomerId;
                        var statusvals = value.Status;
                        var voucherTypeVar = value.VoucherType;

                        if (voucherTypeVar == "Manual-Receipt") {
                            $('#mrcDiv').hide();
                            $('#MrcNumber').val(null).trigger('change');
                            $('#invoicenumberdiv').hide();
                            $('#invoiceNumber-error').html("");
                            $('#docinfolbl').html("Doc. Number");
                        }
                        else if (voucherTypeVar == "Fiscal-Receipt") {
                            $('#mrcDiv').show();
                            $('#invoicenumberdiv').show();
                            $('#invoiceNumber-error').html("");
                            $('#docinfolbl').html("FS Number");
                        }
                        else if ((customercat == "Supplier" || customercat =="Customer&Supplier") && voucherTypeVar == "Fiscal-Receipt") {
                            $('#mrcDiv').show();
                            $('#invoicenumberdiv').show();
                            $('#invoiceNumber-error').html("");
                            $('#docinfolbl').html("FS Number");
                        } 
                        else if (customercat == "") {
                            $('#mrcDiv').hide();
                            $('#MrcNumber').val(null).trigger('change');
                            $('#invoicenumberdiv').hide();
                            $('#invoiceNumber-error').html("");
                            $('#docinfolbl').html("Doc. Number");
                        } 
                        else {
                            $('#mrcDiv').hide();
                            $('#MrcNumber').val(null).trigger('change');
                            $('#invoicenumberdiv').hide();
                            $('#invoiceNumber-error').html("");
                            $('#docinfolbl').html("Doc. Number");
                        }

                        if(value.Status == "Draft"){
                            status_color = "#A8AAAE";
                        }
                        else if(value.Status == "Pending"){
                            status_color = "#f6c23e";
                        }
                        else if(value.Status == "Verified" || value.Status == "Checked"){
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

                    $.each(data.receivingdt, function(key, value) {
                        ++i;
                        ++m;
                        ++j;

                        $("#dynamicTable > tbody").append(`<tr>
                            <td style="font-weight:bold;text-align:center;width:3%;">${j}</td>
                            <td style="display:none;"><input type="hidden" name="row[${m}][vals]" id="vals${m}" class="vals form-control" readonly="true" style="font-weight:bold;" value="${m}"/></td>
                            <td style="width:21%;"><select id="itemNameSl${m}" class="select2 form-control itemName" onchange="itemFn(this)" name="row[${m}][ItemId]"></select></td>
                            <td style="width:11%"><select id="uom${m}" class = "select2 form-control uom" onchange="uomVal(this)" name = "row[${m}][uom]"></select></td>
                            <td style="width:12%" class="proc_module"><input type="number" name="row[${m}][ordered_qty]" id="ordered_qty${m}" class="ordered_qty form-control numeral-mask" readonly="true" style="font-weight:bold;"/></td>
                            <td style="width:12%" class="proc_module"><input type="number" name="row[${m}][remaining_qty]" id="remaining_qty${m}" class="remaining_qty form-control numeral-mask" readonly="true" style="font-weight:bold;"/></td>
                            <td style="width:12%"><input type="number" name="row[${m}][Quantity]" placeholder="Enter quantity here" id="quantity${m}" class="quantity form-control numeral-mask" onkeyup="CalculateTotal(this)" value="${value.Quantity}" onkeypress="return ValidateNum(event);" placeholder="Enter quantity here" ondrop="return false;" onpaste="return false;"/></td>
                            <td style="width:12%" class="cost_visibility_div unorder_price_col prd_price_con"><input type="number" name="row[${m}][UnitCost]" placeholder="Unit Cost" id="unitcost${m}" class="unitcost form-control numeral-mask" onkeyup="CalculateTotal(this)" value="${value.UnitCost}" onkeypress="return ValidateNum(event);"/></td>
                            <td style="width:12%" class="cost_visibility_div unorder_price_col prd_price_con"><input type="number" name="row[${m}][BeforeTaxCost]" id="beforetax${m}" class="beforetax form-control numeral-mask" readonly="true" value="${value.BeforeTaxCost}" style="font-weight:bold;"/></td>
                            <td style="width:12%" class="vatproperty cost_visibility_div"><input type="number" name="row[${m}][TaxAmount]" id="taxamounts${m}" class="taxamount form-control numeral-mask" readonly="true" value="${value.TaxAmount}" style="font-weight:bold;"/></td>
                            <td style="width:12%" class="vatproperty cost_visibility_div"><input type="number" name="row[${m}][TotalCost]" id="total${m}" class="total form-control numeral-mask" readonly="true" value="${value.TotalCost}" style="font-weight:bold;"/></td>
                            <td style="width:5%;text-align:center">
                                <a id="batch_serial_info${m}" href="javascript:void(0)" class="batch_serial_info" style="display:none;"><i class="fas fa-info-circle" style="color: #82868b;"></i></a>
                                <button type="button" id="remove_rec_item${m}" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button>
                            </td>
                            <td style="display:none;"><input type="hidden" name="row[${m}][tax]" id="tax${m}" class="tax form-control" readonly="true" value="${value.TaxTypeId}" style="font-weight:bold;"/></td>
                        </tr>`);

                        var default_item = `<option selected value='${value.ItemId}'>${value.item_name}</option>`;
                        var default_uom = `<option selected value='${value.NewUOMId}'>${value.UomName}</option>`;

                        if(source_type == "Purchase"){
                            if(reference_type == 501 || reference_type == 502){
                                $(`#itemNameSl${m}`).append(options);
                                $(`#ordered_qty${m}`).val(value.ordered_qty);
                                var remaining_qty = parseFloat(value.ordered_qty) - parseFloat(value.received_qty);
                                $(`#remaining_qty${m}`).val(parseFloat(remaining_qty) > 0 ? remaining_qty : 0);
                            }
                            else{
                                $(`#itemNameSl${m}`).append(options.find(`option[data-type="${product_type}"]`).clone());
                            }
                        }
                        else if(source_type == "Production"){
                            $(`#itemNameSl${m}`).append(options);
                        }

                        $('#dynamicTable > tbody > tr').each(function(index, tr) {
                            let item_id = $(this).find('.itemName').val();
                            $(`#itemNameSl${m} option[value="${value.ItemId}"]`).remove(); 
                        });
                        $(`#itemNameSl${m} option[value="${value.ItemId}"]`).remove();

                        $(`#itemNameSl${m}`).append(default_item).select2();
                        $(`#uom${m}`).append(default_uom).select2({minimumResultsForSearch: -1});
                        $(`#select2-itemNameSl${m}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                        $(`#select2-uom${m}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                        $('#pricing_tbl_tax').text(`Tax (${value.TaxTypeId}%)`);

                        if(parseFloat(value.sold_issued) > 0 || parseFloat(value.is_sold) > 0){
                            $(`#remove_rec_item${m}`).remove();
                        }

                        var is_batch_req = value.RequireExpireDate == "Require-BatchNumber" || value.RequireExpireDate == "Require-Both" ? "Yes" : "No";
                        var is_expiry_req = value.RequireExpireDate == "Require-ExpireDate" || value.RequireExpireDate == "Require-Both" ? "Yes" : "No";
                        var is_serial_req = value.RequireSerialNumber == "Required" ? "Yes" : "No";

                        if(is_batch_req == "Yes" || is_expiry_req == "Yes" || is_serial_req == "Yes"){
                            $(`#batch_serial_info${m}`).attr("title",`Is Batch No. Req.: ${is_batch_req}\nIs Expiry Date Req.: ${is_expiry_req}\nIs Serial No. Req.: ${is_serial_req}`);
                            $(`#batch_serial_info${m}`).show();
                        }

                        columnMgtFn();
                    });
                    $(".receiving_child_data_div").show();
                    //voucherStatusFn();
                    CalculateGrandTotal();
                }
            });

            $("#operationtypes").val(2);
            $('#receivingId').val(recIdVar);
            $('#savebutton').text('Update');
            $('#savebutton').prop("disabled", false);
            $("#printgrvdiv").hide();
            $("#newreceivingmodaltitles").html("Edit Receiving");
            $('#inlineForm').modal('show');
        }

        function fetchReferenceDataEditFn(ref_type,ref_id){
            var reference_type = null;
            var reference_id = null;
            $.ajax({ 
                url: '/fetchReceivingRefData', 
                type: 'POST',
                data:{
                    reference_type : ref_type,
                    reference_id : ref_id,
                },
                
                success: function(data) {
                    if(ref_type == 501){
                        populateProcItemFn(data.purchase_detail_data);
                    }
                }
            });
        }

        function populateProcItemFn(detail_data){
            var item_options = null;
            var remaining_qty = null;
            $.each(detail_data, function(key, value) {
                remaining_qty = (parseFloat(value.qty) - parseFloat(value.receivedqty)) + parseFloat(value.receivedqty);
                if(parseFloat(remaining_qty) > 0){
                    item_options += `<option value="${value.itemid}">${value.items}</option>`; 
                }
            });

            item_options += `<option selected disabled value=""></option>`;
            $('#proc_item_default').empty().append(item_options).select2();
        }

        //Start show receiving doc info
        function receivingInfoFn(recordId,vStatus){
            createReceivingInfoFn(recordId,vStatus);
            $("#docInfoModal").modal('show');
        }

        function createReceivingInfoFn(recordId,vStatus){
            $("#statusid").val(recordId);
            $("#recordIds").val(recordId); 
            $('.info_common_div').hide();
            $('.withold_lbl').hide();
            $('.infowitholdrectr').hide();  
            $('.delivery_info_cl').hide();
            $('.receipt_data_cl').hide();
            $('.receipt_data_total_price').hide();
            $('.procurement_cl').hide();
            $('.infoRecDiv').hide();  
            $('.purchase_tr').hide();  
            var visibilitymode = false;
            var withold_count = null;
            infoTblIndex = -1;
            expand_flag = [];
            var subtotal = 0;
            var withold_min_amount = 0;
            var receiving_type = 0;
            var lidata = "";
            var status_color = "";
            var action_links = "";
            var withold_btn_link = "";
            var major_btn_link = `<li><hr class="dropdown-divider"></li>`;
            var status_btn_link = `<li><hr class="dropdown-divider"></li>`;
            var flag_btn_link = `@can("Receiving-Hide")<li><hr class="dropdown-divider"></li>@endcan`;
            var print_btn_link = "";
            var edit_link = `
                @can("Receiving-Edit")
                    <li>
                        <a class="dropdown-item editReceivingRecord" href="javascript:void(0)" onclick="editReceivingFn(${recordId})" data-id="editReceivingLink${recordId}" id="editReceivingLink${recordId}" title="Edit record">
                        <span><i class="fa-solid fa-pencil"></i> Edit</span>  
                        </a>
                    </li>
                @endcan`;

            var withold_link = `
                @can("Withold-Settle")
                    <li>
                        <a class="dropdown-item witholdRecevingRecord" href="javascript:void(0)" onclick="witholdReceivingFn(${recordId})" data-id="witholdRecevingLink${recordId}" id="witholdRecevingLink${recordId}" title="Manage withold">
                        <span><i class="fas fa-sliders-h"></i> Manage Withholding</span>  
                        </a>
                    </li>
                @endcan`;
            
            var void_link = `
                @can("Receiving-Void")
                    <li>
                        <a class="dropdown-item voidlnbtn" href="javascript:void(0)" onclick="voidReceivingFn(${recordId})" data-id="voidReceivingLink${recordId}" id="voidReceivingLink${recordId}" title="Void record">
                        <span><i class="fa-solid fa-ban"></i> Void</span>  
                        </a>
                    </li>
                @endcan`;

            var undovoid_link = `
                @can("Receiving-Void")
                <li>
                    <a class="dropdown-item undovoidlnbtn" href="javascript:void(0)" onclick="undoReceivingFn(${recordId})" data-id="undovoidlink${recordId}" id="undovoidlink${recordId}" title="Undo void record">
                    <span><i class="fa fa-undo"></i> Undo Void</span>  
                    </a>
                </li>
                @endcan`;

            var show_link = `
                @can("Receiving-Hide")
                <li>
                    <a class="dropdown-item showreceivinglink" href="javascript:void(0)" onclick="showReceivingFn(${recordId})" data-id="showreceivinglink${recordId}" id="showreceivinglink${recordId}" title="Show receiving record">
                    <span><i class="fa fa-eye"></i> Show</span>  
                    </a>
                </li>
                @endcan`;

            var hide_link = `
                @can("Receiving-Hide")
                <li>
                    <a class="dropdown-item hideModal" href="javascript:void(0)" onclick="hideReceivingFn(${recordId})" data-id="hidereceivinglink${recordId}" id="hidereceivinglink${recordId}" title="Hide receiving record">
                    <span><i class="fa fa-eye-slash"></i> Hide</span>  
                    </a>
                </li>
                @endcan`;

            var change_to_pending_link = `
                @can("Receiving-ChangeToPending")
                <li>
                    <a class="dropdown-item changetopending" onclick="forwardReceivingFn()" id="changetopending" title="Change record to pending">
                    <span><i class="fa-solid fa-forward"></i> Change to Pending</span>  
                    </a>
                </li>
                @endcan`;

            var back_to_draft_link = `
                @can("Receiving-ChangeToPending")
                <li>
                    <a class="dropdown-item receivingbackward" id="backtodraft" title="Change record to draft">
                    <span><i class="fa-solid fa-backward"></i> Back to Draft</span>  
                    </a>
                </li>
                @endcan`;

            var check_link = `
                @can("Receiving-Check")
                <li>
                    <a class="dropdown-item checkreceiving" onclick="forwardReceivingFn()" id="checkreceiving" title="Change record to checked">
                    <span><i class="fa-solid fa-forward"></i> Check</span>  
                    </a>
                </li>
                @endcan`;

            var back_to_pending = `
                @can("Receiving-Check")
                <li>
                    <a class="dropdown-item receivingbackward" id="backtopending" title="Change record to pending">
                    <span><i class="fa-solid fa-backward"></i> Back to Pending</span>  
                    </a>
                </li>
                @endcan`;

            var approve_link = `
                @can("Receiving-Confirm")
                <li>
                    <a class="dropdown-item confirmreceiving" onclick="forwardReceivingFn()" id="confirmreceiving" title="Change record to confirmed">
                    <span><i class="fa-solid fa-forward"></i> Confirm</span>  
                    </a>
                </li>
                @endcan`;

            var back_to_check_link = `
                @can("Receiving-Confirm")
                <li>
                    <a class="dropdown-item receivingbackward" id="backtocheck" title="Change record to checked">
                    <span><i class="fa-solid fa-backward"></i> Back to Checked</span>  
                    </a>
                </li>
                @endcan`;

            var upload_document_link = `
                @can("Receiving-Confirm")
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item" id="managedocumentBtn" onclick="openDocumentUploadFn(${recordId})" title="Open document manage form">
                    <span><i class="fas fa-sliders-h"></i> Manage Documents</span>
                    </a>
                </li>
                @endcan`;

            var print_purchase_link = `
                <li>
                    <a class="dropdown-item printGrnLink" href="javascript:void(0)" data-link="/grv/${recordId}" data-id="printgrnlink${recordId}" id="printgrnlink${recordId}" title="Print GRV Attachment">
                    <span><i class="fa fa-file"></i> Print GRV</span>  
                    </a>
                </li>`;

            var print_batch_serial_link = `
                <li>
                    <a class="dropdown-item printGrnLink" href="javascript:void(0)" data-link="/grv_batch/${recordId}" data-id="printgrnlink${recordId}" id="printgrnlink${recordId}" title="Print GRV Attachment">
                    <span><i class="fa fa-file"></i> Print GRV with Batch & Serial No.</span>  
                    </a>
                </li>`;

            var print_production_link = `
                <li>
                    <a class="dropdown-item printGrnLink" href="javascript:void(0)" data-link="/grv_prd/${recordId}" data-id="printgrnprdlink${recordId}" id="printgrnprdlink${recordId}" title="Print GRV Attachment">
                    <span><i class="fa fa-file"></i> Print GRV</span>  
                    </a>
                </li>`;

            $.ajax({
                type: "get",
                url: "{{url('getWithNumber')}}",
                dataType: "json",
                success: function (data) {
                    $('#witholdPercenti').val(data.witholdPer);
                    $('#infowitholdingTitle').html("Witholding (" + data.witholdPer + "%)");
                    $('#witholdMinAmounti').val(data.witholdAmnt);
                    $("#infoWitholdPercent").val(data.witholdPer);
                }
            });

            $.ajax({
                type: "get",
                url: "{{url('showRecDataRec')}}"+'/'+recordId,
                dataType: "json",
                beforeSend: function () { 
                    blockPage(cardSection, 'Fetching receiving record...');                    
                },
                complete: function () {
                    visibilitymode = parseInt(vStatus) == 1 ? true : false;
                    getReceivingItemFn(recordId,visibilitymode);
                    getDocumentDataFn(recordId);
                },
                success: function (data) {
                    can_change_src_type = data.can_change_srctype;
                    withold_count = data.getcountRec;
                    ids = [];
                    $('#selectedids').val(ids);
                    $('.infolbls').text("");
                    $('#infonumberofItemsLbl').text(data.count);
                    withold_min_amount = $('#witholdMinAmounti').val();

                    $.each(data.pricing, function(key, value) {
                        subtotal = value.SubTotal;
                    });

                    $.each(data.holdHeader, function(key, value) {
                        $('#info_source_type').html(value.source_type);
                        srctype_value = value.source_type;
                        receiving_type = value.VoucherStatus;
                        $('#infoReferenceType').html(value.reference_type);
                        $('#infoReference').html(`<a style="text-decoration:underline;color:blue;" onclick=openPurchaseFn("${value.PoId}")>${value.porderno != null ? value.porderno : ""}</a>`);
                        $('#infoProductType').html(value.ProductType);
                        $('#infoDocNumber').html(value.DeliveryOrderNo);
                        $("#customerIdInp").val(value.CustomerId);

                        $('#infoDocCustomerName').html(value.CustomerName);
                        $('#infoCusCode').html(value.Code);
                        $('#infoCusCategory').html(value.CustomerCategory);
                        $('#infoCusTin').html(value.TinNumber);
                        $('#infoCusVat').html(value.VatNumber); 
                        $('#infoCusPhone').html(value.phone_number); 
                        
                        $('#infoDocDocNo').html(value.DocumentNumber);
                        $('#infoDocPaymentType').html(value.PaymentType);
                        $('#infoVoucherStatus').html(value.VoucherStatusName);
                        $('#infoDocVoucherType').html(value.VoucherType);
                        $('#infoDocVoucherNumber').html(value.VoucherNumber);
                        $('#infoinvoicenumber').html(value.InvoiceNumber);
                        $('#infoDocMrcNumber').html(value.CustomerMRC);
                        $('.infoDocDate').html(value.TransactionDate);

                        $('#infoDocReceivingStore').html(value.StoreName);
                        $('#infoDocPurchaserName').html(value.source_type == "Purchase" ? value.PurchaserName : value.DeliveredBy);

                        $('#info_receiving_remark').html(value.Memo);
                        $('#info_received_by').html(value.ReceivedBy);
                        $('#info_received_date').html(value.ReceivedDate);
                        $('.info_delivered_by').html(value.DeliveredBy);
                        $('#info_plate_no').html(value.TruckPlateNo);
                        
                        $('#infoWitholdReceiptLbl').html(value.WitholdReceipt);
                        $('#infoWitholdDateLbl').html(value.withhold_receipt_date);

                        value.WitholdReceipt != null ? $('.infowitholdrectr').show() : $('.infowitholdrectr').hide();
                        
                        $('#infotinnumberlbl').html(value.TinNumber);
                        $('#infovatnumberlbl').html(value.VatNumber);
                        $('#witholdreceiptlbl').html(`Withholding Receipt: ${value.WitholdReceipt}`);
                        $('#info_receiving_prdno').html(value.productiono);
                        $('#info_receiving_reqno').html(value.requisitiono);

                        $("#statusIds").val(value.Status);
                        $("#currentStatus").val(value.Status);

                        $("#info_source_types").val(value.source_type); 
                        $("#info_reference_type").val(value.Type); 
                        $("#info_cost_visibility").val(value.is_cost_shown); 
                        $("#info_voucher_status").val(value.VoucherStatus); 
                        
                        if(value.source_type == "Purchase"){
                            $('.purchase_tr').show();
                            $('#info_purchase_div').show();
                            $('.delivery_info_cl').show();
                            $('#invoice_deliver_date').html(value.VoucherStatus == 1 ? "Invoice Date" : "Date");
                            $('#purchase_deliver_infolbl').html("Purchased By");
                            
                            if(value.Type == 500){
                                $('#reference_td').hide();
                                value.is_cost_shown == 1 ? $('.receipt_data_total_price').show() : $('.receipt_data_total_price').hide();
                                $('.procurement_cl').show();
                            }
                            else if(value.Type == 503){
                                $('.receipt_data_cl').show();
                                $('.receipt_data_total_price').show();
                                //value.VoucherStatus == 1 ? $('.receipt-prop').show() : $('.receipt-prop').hide();
                                
                                if(parseInt(value.VoucherStatus) == 1){
                                    $('.receipt-prop').show();
                                    $('.vatpropinfo').show();
                                    $('#before_total_cost').html("Before Tax");
                                    $('#info_subtotal_lbl').html("Sub Total");
                                }
                                else{
                                    $('.receipt-prop').hide();
                                    $('.vatpropinfo').hide();
                                    $('#info_subtotal_lbl').html("Grand Total");
                                }
                            }
                            else{
                                $('.procurement_cl').show();
                            }
                        }
                        else if(value.source_type == "Production"){
                            $('.purchase_tr').hide();
                            $('#info_production_div').show();
                            $('.receipt_data_cl').show();
                            $('.delivery_info_cl').hide();
                            $('#invoice_deliver_date').html("Date");
                            $('#purchase_deliver_infolbl').html("Delivered By");

                            $('.vatpropinfo').hide();
                            $('#before_total_cost').html("Total Cost");
                            $('#info_subtotal_lbl').html("Grand Total");
                        }

                        $('#infosubtotalLbl').html(value.SubTotal === 0 ? '' : numformat(parseFloat(value.SubTotal).toFixed(2)));
                        $('#infotaxLbl').html(value.Tax === 0 ? '' : numformat(parseFloat(value.Tax).toFixed(2)));
                        $('#infograndtotalLbl').html(value.GrandTotal === 0 ? '' : numformat(parseFloat(value.GrandTotal).toFixed(2)));
                        $('#infowitholdinglbl').html(value.WitholdAmount === 0 ? '' : numformat(parseFloat(value.WitholdAmount).toFixed(2)));
                        $('#infoNetPayLbl').html(value.NetPay === 0 ? '' : numformat(parseFloat(value.NetPay).toFixed(2)));

                        $("#infotaxi").val(value.Tax);
                        $("#infograndtotali").val(value.GrandTotal);
                        $("#infowitholdingi").val(value.WitholdAmount);
                        $("#infoNetPayi").val(value.NetPay);
                        $('#infocreateddate').text(value.created_at);
                        $('#infowitholdingTitle').html(`Witholding(${value.WitholdPercent}%)`);

                        value.IsSeparatelySettled == 1 ? $('.withhold_sett_lbl').show() : $('.withhold_notsett_lbl').show();    

                        withold_btn_link = value.Type == 503 && withold_count > 0 && parseFloat(subtotal) >= parseFloat(withold_min_amount) && srctype_value == "Purchase" && receiving_type == 1 ? withold_link : "";

                        if(value.IsFromProcurement == 0 && value.IsHide == 1){
                            flag_btn_link += show_link;
                        }
                        if(value.IsFromProcurement == 0 && value.IsHide == 0){
                            flag_btn_link += hide_link;
                        }

                        if(value.Status == "Draft"){
                            major_btn_link += edit_link;
                            major_btn_link += withold_btn_link;
                            major_btn_link += void_link;

                            status_btn_link += change_to_pending_link;

                            print_btn_link = `<li><hr class="dropdown-divider"></li>`;
                            print_btn_link += value.source_type == "Purchase" ? print_purchase_link : print_production_link;
                            status_color = "#A8AAAE";
                        }
                        else if(value.Status == "Pending"){
                            major_btn_link += edit_link;
                            major_btn_link += withold_btn_link;
                            major_btn_link += void_link;

                            status_btn_link += back_to_draft_link;
                            status_btn_link += check_link;

                            print_btn_link = `<li><hr class="dropdown-divider"></li>`;
                            print_btn_link += value.source_type == "Purchase" ? print_purchase_link : print_production_link;
                            status_color = "#f6c23e";
                        }
                        else if(value.Status == "Verified" || value.Status == "Checked"){
                            major_btn_link += edit_link;
                            major_btn_link += withold_btn_link;
                            major_btn_link += void_link;

                            status_btn_link += approve_link;
                            status_btn_link += back_to_pending;

                            print_btn_link = `<li><hr class="dropdown-divider"></li>`;
                            print_btn_link += value.source_type == "Purchase" ? print_purchase_link : print_production_link;
                            status_color = "#7367F0";
                        }
                        else if(value.Status == "Approved" || value.Status == "Confirmed"){
                            major_btn_link += edit_link;
                            major_btn_link += withold_btn_link;
                            major_btn_link += void_link;

                            status_btn_link = "";
                            print_btn_link = `<li><hr class="dropdown-divider"></li>`;
                            print_btn_link += value.source_type == "Purchase" ? print_purchase_link : print_production_link;
                            status_color = "#1cc88a";
                        }
                        else if(value.Status == "Void" || value.Status == "Void(Draft)" || value.Status == "Void(Pending)" || value.Status == "Void(Checked)" || value.Status == "Void(Verified)" || value.Status == "Void(Confirmed)"){
                            major_btn_link += undovoid_link;

                            status_btn_link = "";
                            upload_document_link = "";
                            print_btn_link = `<li><hr class="dropdown-divider"></li>`;
                            print_btn_link += value.source_type == "Purchase" ? print_purchase_link : print_production_link;
                            status_color = "#e74a3b";
                        }
                        else{
                            status_color = "#e74a3b";
                        }
                        $(".info_modal_title_lbl").html(`<span class="form_title" style='color:${status_color};font-weight:bold;text-shadow;1px 1px 10px ${status_color};font-size:16px;'>${value.DocumentNumber},     ${value.Status}</span>`);
                        //$("#action-log-status-lbl").html(`<span class="form_title" style='color:${status_color};font-weight:bold;text-shadow;1px 1px 10px ${status_color};font-size:13px;'>${value.DocumentNumber},     ${value.Status}</span>`);

                        action_links = `
                        <li>
                            <a class="dropdown-item viewReceivingAction" onclick="viewReceivingActionFn(${recordId})" data-id="view_receiving_actionbtn${recordId}" id="view_receiving_actionbtn${recordId}" title="View user log">
                            <span><i class="fa-solid fa-eye"></i> View User Log</span>  
                            </a>
                        </li>
                        ${major_btn_link}
                        ${upload_document_link}
                        ${status_btn_link}
                        ${flag_btn_link}
                        ${print_btn_link}
                        ${print_batch_serial_link}`;

                        $("#receiving_action_ul").empty().append(action_links);

                        var trdate = value.TransactionDate;
                        var cusId = value.CustomerId;
                        var settlementType = value.IsWitholdSettle;

                        var stotal = value.SubTotal;
                        var withold_amnt = value.WitholdAmount;
                        var withold_percent = value.WitholdPercent;
                        var customer_category = value.CustomerCategory;
                        var st = value.Status;
                        var status = value.Status;

                        if (parseFloat(withold_amnt) > 0 && parseFloat(withold_percent) > 0 && customer_category != "Foreigner-Supplier" && customer_category != "Person") {
                            $("#infowitholdingTr").show();
                            $("#infonetpayTr").show();
                        } 
                        else if (parseFloat(withold_amnt) == 0 || parseFloat(withold_percent) == 0 || customer_category ==="Foreigner-Supplier" || customer_category === "Person") {
                            $("#infowitholdingTr").hide();
                            $("#infonetpayTr").hide();
                        }

                        if (settlementType == "Settled") {
                            $('#settledLabel').show();
                        } 
                        else {
                            $('#notsettledLabelPr').show();
                        }
                    });

                    $.each(data.activitydata, function(key, value) {
                        var classes = "";
                        var reasonbody = "";
                        if(value.action == "Edited" || value.action == "Change to Pending" || value.action == "Hide-Record"){
                            classes = "warning";
                        }
                        else if(value.action == "Verified" || value.action == "Show-Record" || value.action == "Withholding Settled"){
                            classes = "primary";
                        }
                        else if(value.action == "Back to Draft" || value.action == "Undo Void" || value.action == "Back to Pending" || value.action == "Back to Verify" || value.action == "Withholding Unsettled" || value.action == "Document-Uploaded"){
                            classes = "secondary";
                        }
                        else if(value.action == "Created" || value.action == "Approved" || value.action == "Confirmed"){
                            classes = "success";
                        }
                        else if(value.action == "Void"){
                            classes = "danger";
                        }

                        if(value.status == "Created"){
                            classes = "success";
                        }
                        if(value.status == "Edited"){
                            classes = "warning";
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

            tabMgtFn();
            $(".infoscl").collapse('show');
        }

        function viewReceivingActionFn(recordId){
            $("#action-log-title").html("User Log Information");
            $("#action-log-universal-modal").modal('show');
        }

        function tabMgtFn(){
            $(".tab-title").removeClass("active");
            $(".tab-view").removeClass("active");
            
            $(".active-tab-title").addClass("active");
            $(".active-tab-view").addClass("active");
        }
        
        function getReceivingItemFn(recordId,visibilitymode){
            var src_type = $('#info_source_types').val();
            var ref_type = $('#info_reference_type').val();
            var cost_visiblity = $('#info_cost_visibility').val();
            var v_status = $('#info_voucher_status').val();
            var visibility_flag = false;
            var column_index = [];

            if(src_type == "Purchase"){
                if(ref_type == 500){
                    if(cost_visiblity == 1){
                        column_index = [8,9,10,11];
                        visibility_flag = true;
                    }
                    else{
                        column_index = [8,9,10,11];
                        visibility_flag = false;
                    }
                }
                else if(ref_type == 503){
                    if(v_status == 1){
                        column_index = [8,9,10,11];
                        visibility_flag = true;
                    }
                    else{
                        column_index = [10,11];
                        visibility_flag = false;
                    }
                }
                else{
                    column_index = [8,9,10,11];
                    visibility_flag = false;
                }
            }
            else{
                column_index = [10,11];
                visibility_flag = false;
            }

            detail_table = $('#docRecInfoItem').DataTable({
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
                    url: '/showrecDetail/' + recordId,
                    type: 'DELETE',
                    complete: function () { 
                        setFocusInfoTable('#docRecInfoItem');
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
                        "render": function ( data, type, row, meta ) {
                            $('#info_tax_pricing_tbl').text(`Tax (${row.TaxTypeId}%)`);
                            return `<div>${data}</div>`;
                        } 
                    },
                    {
                        data: 'SKUNumber',
                        name: 'SKUNumber',
                        width:'10%',
                    },
                    {
                        data: 'UOM',
                        name: 'UOM',
                        width:'7%',
                    },
                    {
                        data: 'Quantity',
                        name: 'Quantity',
                        width:'7%',
                        render: $.fn.dataTable.render.number(',', '.',0, '')
                    },
                    {
                        data: 'UnitCost',
                        name: 'UnitCost',
                        width:'8%',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'BeforeTaxCost',
                        name: 'BeforeTaxCost',
                        width:'10%',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'TaxAmount',
                        name: 'TaxAmount',
                        width:'10%',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'TotalCost',
                        name: 'TotalCost',
                        width:'10%',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },   
                    {
                        data: null,
                        name: 'action',
                        orderable: false,
                        "render": function ( data, type, row, meta ) {
                            if((row.RequireSerialNumber != "Not-Require" || row.RequireExpireDate != "Not-Require") && row.Status != "Void"){
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
                                                onclick="mngBatchSerialExpireFn(${row.id},${row.HeaderId},${row.ItemId},${row.Quantity},${row.trn_type})" 
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
                "columnDefs": [
                    {
                        "targets": column_index,
                        "visible": visibility_flag,
                    },
                ],
                drawCallback: function () { 
                    unblockPage(cardSection);
                    $('.infoRecDiv').show();  
                },
            });

            $('#docRecInfoItem').on('draw.dt', function () {
                let keyword = $('#docRecInfoItem_filter input').val();
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

        $('#docRecInfoItem tbody').on('click', 'td.dt-show-1', async function () {
            let tr = $(this).closest('tr');
            let row = $('#docRecInfoItem').DataTable().row(tr);
            
            if (row.child.isShown()) {
                row.child.hide();
                $(this).html('<i class="fas fa-caret-right fa-xl"></i>');
            } else {
                let data = row.data();
                let html = await formatLevel1Fn(data.HeaderId,data.ItemId);
                
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
                url: '/getItemBactchData', 
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
                    <td class="${class_name}" data-batchid="${value.id}">${batch_id}</td>
                    <td>${++index}</td>
                    <td>${value.brand_name}</td>
                    <td>${value.model_name}</td>
                    <td class="batch_number_class" style="display:${is_batch_req == "No" ? "none" : ""}">${value.batch_number}</td>
                    <td>${value.received_qty}</td>
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

        $('#docRecInfoItem tbody').on('click', 'tr', function () {
            $('#docRecInfoItem tbody > tr').removeClass('selected');
            $(this).addClass('selected');
            infoTblIndex = $(this).index();
        });

        function setFocusInfoTable(targetTable) {
            $($(targetTable + ' tbody > tr')[infoTblIndex]).addClass('selected');
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
                    let html = await formatLevel2Fn(batchId);

                    tr.next('.child-level-2').html(`<td colspan="8">${html}</td>`);
                }
                catch(e){
                    tr.next('.child-level-2').html(`<td colspan="8" style="color:red;">Error loading data</td>`);
                }  
            }
        });

        async function formatLevel2Fn(batch_id) {
            var batchId = null;
            let response = await $.ajax({ 
                url: '/getItemSerialData', 
                type: 'POST',
                data:{
                    batchId : batch_id,
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
            let table = $('#docRecInfoItem').DataTable();
            var count_req = 0;

            for (let i = 0; i < table.rows().count(); i++) {

                let row = table.row(i);

                if (!row || !row.node()) continue;

                let tr = $(row.node());
                let data = row.data();

                if (!data) continue;

                if(data.RequireSerialNumber != "Not-Require" || data.RequireExpireDate != "Not-Require"){
                
                    // 🔥 FIX: ensure HTML exists
                    let html = await formatLevel1Fn(data.HeaderId, data.ItemId);

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
            let table = $('#docRecInfoItem').DataTable();

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
                    url: '/showDocumentData/' + recordId,
                    type: 'POST',
                },
                columns: [{
                        data: 'id',
                        name: 'id',
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
                ],
                drawCallback: function () { 
                    $('#document_div').show();
                },
            });
        }

        function showReceivingFn(recordId){
            Swal.fire({
                title: confirmation_title,
                text: 'Are you sure you want to show this record? It will be visible to all users with viewing permissions.',
                icon: confirmation_icon,
                showCloseButton: true,
                showCancelButton: true,      
                allowOutsideClick: false,
                confirmButtonText: 'Show',
                cancelButtonText: 'Close',
                customClass: {
                    confirmButton: 'btn btn-info',
                    cancelButton: 'btn btn-danger'
                }
            }).then(function (result) {
                if (result.value) {
                    showReceivingRecordFn(recordId);
                }
                else if (result.dismiss === Swal.DismissReason.cancel) {}
            });
        }
        
        function showReceivingRecordFn(recordId){
            var registerForm = $("#receivingInfoForm");
            var formData = registerForm.serialize();
            $.ajax({
                url: '/showReceiving',
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    blockPage(cardSection, 'Showing receiving record...');
                },
                complete: function () { 
                    unblockPage(cardSection);   
                },
                success: function(data) {
                    if (data.dberrors) {
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if (data.success) {
                        toastrMessage('success',"Successful","Success");
                        createReceivingInfoFn(recordId,data.vstatus);
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);

                        var pTable = $('#laravel-datatable-crud-prd').dataTable();
                        pTable.fnDraw(false);
                    }
                },
            });
        }

        function hideReceivingFn(recordId){
            Swal.fire({
                title: confirmation_title,
                text: 'Are you sure you want to hide this record? It will no longer be visible to all users.',
                icon: confirmation_icon,
                showCloseButton: true,
                showCancelButton: true,      
                allowOutsideClick: false,
                confirmButtonText: 'Hide',
                cancelButtonText: 'Close',
                customClass: {
                    confirmButton: 'btn btn-info',
                    cancelButton: 'btn btn-danger'
                }
            }).then(function (result) {
                if (result.value) {
                    hideReceivingRecordFn(recordId);
                }
                else if (result.dismiss === Swal.DismissReason.cancel) {}
            });
        }

        function hideReceivingRecordFn(recordId){
            var registerForm = $("#receivingInfoForm");
            var formData = registerForm.serialize();
            $.ajax({
                url: '/hideReceiving',
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    blockPage(cardSection, 'Hiding receiving record...');
                },
                complete: function () { 
                    unblockPage(cardSection);     
                },
                success: function(data) {
                    if (data.dberrors) {
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if (data.success) {
                        toastrMessage('success',"Successful","Success");
                        createReceivingInfoFn(recordId,data.vstatus);
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);

                        var pTable = $('#laravel-datatable-crud-prd').dataTable();
                        pTable.fnDraw(false);
                    }
                },
            });
        }

        function forwardReceivingFn() {
            const requestId = $('#recordIds').val();
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
                    receivingForwardActionFn();
                }
                else if (result.dismiss === Swal.DismissReason.cancel) {}
            });
        }

        function receivingForwardActionFn(){
            var forwardForm = $("#receivingInfoForm");
            var formData = forwardForm.serialize();
            var recordId = $('#recordIds').val();
            $.ajax({
                url: '/receivingForwardAction',
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    blockPage(cardSection, 'Forwarding receiving record...');
                },
                complete: function () { 
                    unblockPage(cardSection); 
                },
                success: function(data) {
                    if (data.dberrors) {
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if(data.item_variances){
                        var item_list = "";
                        $.each(data.item_variances, function(key, value) {
                            item_list += `${++key}. ${value.item_name}</br>`;
                        });
                        toastrMessage('warning',`Please enter all required batch and/or serial numbers for the items listed below</br>----------------</br>${item_list}`,"Warning");
                    }
                    else if (data.success) {
                        toastrMessage('success',"Successful","Success");
                        createReceivingInfoFn(recordId,data.vstatus);
                        countReceivingStatusFn(data.fiscalyr,"pur");
                        countReceivingStatusFn(data.fiscalyr,"prd");

                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);

                        var pTable = $('#laravel-datatable-crud-prd').dataTable();
                        pTable.fnDraw(false);
                    }
                }
            });
        }

        $(document).on('click', '.receivingbackward', function(){
            const requestId = $('#recordIds').val();
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
                url: '/receivingBackwardAction',
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    blockPage(cardSection, 'Backwarding receiving record...');

                    $('#backwardActionBtn').text('Changing...');
                    $('#backwardActionBtn').prop("disabled", true);
                },
                complete: function () { 
                    unblockPage(cardSection);

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
                        createReceivingInfoFn(recordId,data.vstatus);
                        countReceivingStatusFn(data.fiscalyr,"pur");
                        countReceivingStatusFn(data.fiscalyr,"prd");

                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);

                        var pTable = $('#laravel-datatable-crud-prd').dataTable();
                        pTable.fnDraw(false);
                        $('#backwardActionModal').modal('hide');
                    }
                }
            });
        });

        function receivingReasonFn() {
            $('#commentres-error').html("");
        }

        //Start Void Modal With Value 
        function voidReceivingFn(recordId){
            $('.Reason').val("");
            var fiscal_year_current = null;
            var fiscal_year_store = null;
            var fiscal_year_record = null;
            var is_sold = null;
            var sold_issued = null;
            var status = "";
            $.ajax({
                type: "get",
                url: "{{url('showRecDataRec')}}"+'/'+recordId,
                dataType: "json",
                success: function (data) {
                    fiscal_year_current = data.fyear;
                    fiscal_year_store = data.fyearstr;
                    sold_issued = data.sold_issued;
                    is_sold = data.is_sold;
                    $.each(data.holdHeader, function(key, value) {
                        status = value.Status;
                        fiscal_year_record = value.fiscalyear;
                    });

                    if (status == "Void") {
                        toastrMessage('error',"This record cannot be voided again because its current status is Void","Error");
                        $("#voidreasonmodal").modal('hide');
                    }
                    else if(parseInt(fiscal_year_record) != parseInt(fiscal_year_store)){
                        toastrMessage('error',"You can not void a closed fiscal year transaction","Error");
                        $("#voidreasonmodal").modal('hide');
                    }
                    else if(parseFloat(sold_issued) > 0 || parseFloat(is_sold) > 0){
                        toastrMessage('error',"This record cannot be voided because the associated batch or serial numbers have already been sold or issued","Error");
                        $("#voidreasonmodal").modal('hide');
                    }
                    else{
                        $("#voidid").val(recordId);
                        $('#vstatus').val(status);
                        $('#voidbtn').prop("disabled", false);
                        $('#voidbtn').text("Void");
                        $("#voidreasonmodal").modal('show');
                    }
                }
            });
        }
        //End Void Modal With Value 

        //Start void
        $('#voidbtn').click(function(){    
            var registerForm = $("#voidreasonform");
            var formData = registerForm.serialize();
            var recordId = $('#voidid').val();
            var fiscalyearcurr = "";

            var fiscal_year_current = null;
            var fiscal_year_store = null;
            var fiscal_year_record = null;
            var status = "";

            $.ajax({
                type: "get",
                url: "{{url('showRecDataRec')}}"+'/'+recordId,
                dataType: "json",
                success: function (data) {
                    fiscal_year_current = data.fyear;
                    fiscal_year_store = data.fyearstr;
                    $.each(data.holdHeader, function(key, value) {
                        status = value.Status;
                        fiscal_year_record = value.fiscalyear;
                    });

                    if (status == "Void") {
                        toastrMessage('error',"This item cannot be voided again because its current status is void","Error");
                        $("#voidreasonmodal").modal('hide');
                    }
                    else if(parseInt(fiscal_year_record) != parseInt(fiscal_year_store)){
                        toastrMessage('error',"You cant void a closed fiscal year transaction","Error");
                        $("#voidreasonmodal").modal('hide');
                    }
                    else{
                        $.ajax({
                            url: '/voidRec',
                            type: 'POST',
                            data: formData,
                            beforeSend: function() {
                                blockPage(cardSection, 'Voiding receiving record...');
                                $('#voidbtn').text('Voiding...');
                                $('#voidbtn').prop("disabled", true);
                            },
                            complete: function () { 
                                unblockPage(cardSection);   
                            },
                            success: function(data) {
                                if (data.errors) {
                                    if (data.errors.Reason) {
                                        $('#void-error').html(data.errors.Reason[0]);
                                    }
                                    $('#voidbtn').text('Void');
                                    $('#voidbtn').prop("disabled", false);
                                    toastrMessage('error',"Check your inputs","Error");
                                }
                                else if (data.balance_error) {
                                    var item_list = "";
                                    $.each(data.items, function(index, value) {
                                        item_list += `<b>${++index},</b> ${value.name}</br>`;
                                    });
                                    $('#voidbtn').text('Void');
                                    $('#voidbtn').prop("disabled", false);
                                    toastrMessage('error',`These items cannot be void, the requested change is not supported by the available quantity and would result negative balance.</br>-------------------</br>${item_list}`,"Error");
                                } 
                                else if (data.dberrors) {
                                    $('#voidbtn').text('Void');
                                    $('#voidbtn').prop("disabled", false);
                                    $("#voidreasonmodal").modal('hide');
                                    toastrMessage('error',"Please contact administrator","Error");
                                }
                                else if (data.success) {
                                    $('#voidbtn').text('Void');
                                    toastrMessage('success',"Successful","Success");
                                    createReceivingInfoFn(recordId,data.vstatus);
                                    countReceivingStatusFn(data.fiscalyr,"pur");
                                    countReceivingStatusFn(data.fiscalyr,"prd");

                                    var oTable = $('#laravel-datatable-crud').dataTable();
                                    oTable.fnDraw(false);

                                    var pTable = $('#laravel-datatable-crud-prd').dataTable();
                                    pTable.fnDraw(false);
                                    $("#voidreasonmodal").modal('hide');
                                }
                            },
                        });
                    }
                }
            });
        });
        //End void

        function undoReceivingFn(recordId){
            var fiscalyearcurr = null;
            var fyearstrs = null;
            var fyear_rec = null;
            var status = "";
            $.ajax({
                type: "get",
                url: "{{url('showRecDataRec')}}"+'/'+recordId,
                dataType: "json",
                success: function (data) {
                    fiscal_year_curr = data.fyear;
                    fyearstrs = data.fyearstr;

                    $.each(data.holdHeader, function(key, value) {
                        status = value.Status;
                        fyear_rec = value.fiscalyear
                    });

                    if (status != "Void") {
                        toastrMessage('error',"Record status should be void","Error");
                    }
                    else if(parseInt(fyear_rec) != parseInt(fyearstrs)){
                        toastrMessage('error',"You can not undo void on a closed fiscal year transaction","Error");
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
                                undoVoidReceivingFn(recordId);
                            }
                            else if (result.dismiss === Swal.DismissReason.cancel) {}
                        });
                    }
                }
            });
        }

        //Start undo void
        function undoVoidReceivingFn(recordId){
            var registerForm = $("#receivingInfoForm");
            var formData = registerForm.serialize();
            var status = "";
            var old_status = "";
            $.ajax({
                type: "get",
                url: "{{url('showRecDataRec')}}"+'/'+recordId,
                dataType: "json",
                success: function (data) {
                    $.each(data.holdHeader, function(key, value) {
                        status = value.Status;
                        old_status = value.Status;
                    });
                    if(status == "Void") {
                        $.ajax({
                            url: '/undoVd',
                            type: 'POST',
                            data: formData,
                            beforeSend: function() {
                                blockPage(cardSection, 'Restoring receiving record...');
                            },
                            complete: function () { 
                                unblockPage(cardSection);    
                            },
                            success: function(data) {
                                if(data.undoerror){
                                    toastrMessage('error',"This doc/fs number is taken by another transaction","Error");
                                }
                                else if (data.pocnterror) {
                                    toastrMessage('error',"This record cannot be restored because newer receiving records exist for this PO.","Error");
                                }
                                else if (data.batch_error) {
                                    var batch_number = "";
                                    var row_num = 0;
                                    $.each(data.duplicates, function(index, value) {
                                        batch_number += `<b>${++row_num},</b> ${value.item_name} (${value.batch_number})</br>`;
                                    });
                                    toastrMessage('error',`This record cannot be restored because another receiving entry already exists with the same batch number.</br>-----------</br>${batch_number}`,"Error");
                                }
                                else if (data.serial_error) {
                                    var serial_number = "";
                                    var row_num = 0;
                                    $.each(data.duplicates, function(index, value) {
                                        serial_number += `<b>${++row_num},</b> ${value.item_name} (${value.serial_number})</br>`;
                                    });
                                    toastrMessage('error',`This record cannot be restored because another receiving entry already uses the same serial number.</br>-----------</br>${serial_number}`,"Error");
                                }
                                else if (data.dberrors) {
                                    toastrMessage('error',"Please contact administrator","Error");
                                }
                                else if (data.success){
                                    toastrMessage('success',"Successful","Success");
                                    createReceivingInfoFn(recordId,data.vstatus);
                                    countReceivingStatusFn(data.fiscalyr,"pur");
                                    countReceivingStatusFn(data.fiscalyr,"prd");

                                    var oTable = $('#laravel-datatable-crud').dataTable();
                                    oTable.fnDraw(false);

                                    var pTable = $('#laravel-datatable-crud-prd').dataTable();
                                    pTable.fnDraw(false);
                                }
                            },
                        });
                    }
                    else{
                        toastrMessage('error',"Receiving should be on void status","Error");
                    }
                }
            });
        }
        //End undo void

        function witholdReceivingFn(recordId){
            $('#currRecId').val(recordId);
            flatpickr('#ReceiptDate', { dateFormat: 'Y-m-d',clickOpens:true,maxDate:currentdate});
            var withold_percent = $('#infoWitholdPercent').val();
            $('#settWitholdPercent').val(withold_percent);
            const tbl_id = 'receiving_item_tbl';
            const cloned_dt = $('#docRecInfoItem').clone(true, true);
            const cloned_pt = $('#receiving_pricing_tbl').clone(true, true);
            cloned_dt.attr('id', tbl_id);
            $('#current_record_canvas').empty().append(cloned_dt);
            $('#current_rec_pricing_canvas').empty().append(cloned_pt);

            $('#'+tbl_id).DataTable({
                destroy:true,
                processing: true,
                serverSide: false,
                paging: false,
                info:false,
                searchHighlight: true,
                "order": [[ 1, "asc" ]],
                language: { 
                    search: '', 
                    searchPlaceholder: "Search here"
                },
                autoWidth: false,
                deferRender: true,
                dom: "<'row'<'col-sm-4 col-md-4 col-6'f><'col-sm-3 col-md-2 col-6'><'col-sm-3 col-md-2 col-6'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-4 col-md-4 col-4'l><'col-sm-4 col-md-4 col-4 d-flex justify-content-center'i><'col-sm-4 col-md-4 col-4 d-flex justify-content-end'p>>",
            });

            var cus_id = $('#customerIdInp').val();
            var trn_date = $('#infoInvoiceDocDate').text();

            getWitholdDataFn(cus_id,trn_date);

            $('#witholdManageModal').modal('show');
        }

        function getWitholdDataFn(cus_id,trn_date){
            var withold_percent = $('#settWitholdPercent').val();
            $('#withholding_dt_div').hide();
            with_table = $('#witholdingTables').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                paging: false,
                searching: true,
                info: false,
                searchHighlight: true,
                "order": [
                    [0, "desc"]
                ],
                "pagingType": "simple",
                language: {
                    search: '',
                    searchPlaceholder: "Search here"
                },
                autoWidth: false,
                deferRender: true,
                dom: "<'row'<'col-sm-4 col-md-4 col-6'f><'col-sm-3 col-md-2 col-6'><'col-sm-3 col-md-2 col-6'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-4 col-md-4 col-4'l><'col-sm-4 col-md-4 col-4 d-flex justify-content-center'i><'col-sm-4 col-md-4 col-4 d-flex justify-content-end'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/showwitholdDt/' + cus_id + '/' + trn_date,
                    type: 'DELETE',
                },
                columns: [{
                        data: 'id',
                        name: 'id',
                        'visible': false
                    },
                    {
                        data: 'Type',
                        name: 'Type',
                        'visible': false
                    },
                    {
                        data:'DT_RowIndex',
                        width:'5%'
                    },
                    {
                        data: 'DocumentNumber',
                        name: 'DocumentNumber',
                        width:'21%'
                    },
                    {
                        data: 'VoucherNumber',
                        name: 'VoucherNumber',
                        width:'15%'
                    },
                    {
                        data: 'WitholdReceipt',
                        name: 'WitholdReceipt',
                        width:'20%'
                    },
                    {
                        data: 'withhold_receipt_date',
                        name: 'withhold_receipt_date',
                        width:'20%'
                    },
                    {
                        data: 'SubTotal',
                        name: 'SubTotal',
                        render: $.fn.dataTable.render.number(',','.',2,''),
                        width:'15%'
                    },
                    {
                        data: 'IsSeparatelySettled',
                        name: 'IsSeparatelySettled',
                        'visible': false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        "render": function ( data, type, row, meta ) {
                           return `<div class="text-center custom-control custom-control-primary custom-checkbox" style="padding: 0px 2px 0px 2px !important;">
                                        <input type="checkbox" class="custom-control-input settleSeparateCbx" data-id="settle_grv${row.id}" id="settle_grv${row.id}" value="${row.id}" name="settleSeparateCbx[]"/>
                                        <label class="custom-control-label" for="settle_grv${row.id}" style="font-size:0px"></label>                                  
                                    </div>`;
                        },
                        orderable: false,
                        searchable: false,
                        width:'4%'
                    },
                ],
                
                "fnRowCallback": function(nRow, aData, iDisplayIndex,iDisplayIndexFull) {
                    if (aData.IsSeparatelySettled == 1) {
                        for (var i = 0;i <= 5;i++){
                            $(nRow).find('td:eq('+i+')').css({"color": "#1cc88a"});
                        }
                    }
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

                    var total = api
                    .column(7)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    $('#witholdSubtotalLbl').html(parseFloat(total) === 0 ? '' : numformat(parseFloat(total).toFixed(2)));
                    withold_percent = withold_percent == null ? 0 : withold_percent;
                    var withold_amnt = parseFloat(total) * (withold_percent / 100);
                    $('#witholdAmountLbl').html(parseFloat(withold_amnt) === 0 ? '' : numformat(parseFloat(withold_amnt).toFixed(2)));
                    $('#witholdAmountLblTitle').html(`Withold (${withold_percent}%)`);

                    let settCount = 0;
                    let total_count = api.rows().count();
                    api.rows().every(function() {
                        const rowData = this.data();
                        if (rowData.IsSeparatelySettled == 1) {
                            settCount++;
                        }
                    });

                    $('.withold_status_class').hide();
                    if(settCount == 0){
                        $('#notsettledLabel').show();
                    }
                    else if(settCount == total_count){
                        $('#settledLabel').show();
                    }
                    else{
                        $('#partialsettledLabel').show();
                    }
                },
                drawCallback: function(settings) {
                    $("#withholding_dt_div").show();
                },
            });

            resetWitholdReceiptFormFn();
            selectAllCheckbox.prop('checked', false);
            selectAllCheckbox.prop('indeterminate', false);
        }

        function updateSelectAllState() {
            const totalRows = with_table.rows({ search: 'applied' }).count();
            const checkedRows = with_table.$('input.settleSeparateCbx:checked', { search: 'applied' }).length;
            
            if (checkedRows === 0) {
                // No rows selected
                selectAllCheckbox.prop('checked', false);
                selectAllCheckbox.prop('indeterminate', false);
            } else if (checkedRows === totalRows) {
                // All rows selected
                selectAllCheckbox.prop('checked', true);
                selectAllCheckbox.prop('indeterminate', false);
            } else {
                // Some rows selected (indeterminate state)
                selectAllCheckbox.prop('checked', false);
                selectAllCheckbox.prop('indeterminate', true);
            }

            getSelectedColumnSum(with_table, 7, checkboxClass = 'settleSeparateCbx');
        }

        $('#settle_all_grv').on('click', function() {
            const isChecked = $(this).prop('checked');
            const checkboxes = with_table.$('input.settleSeparateCbx', { search: 'applied' });
            
            // Check/uncheck all visible checkboxes
            checkboxes.each(function() {
                $(this).prop('checked', isChecked);
            });
            
            // Update DataTable's selection state
            if (isChecked) {
                with_table.rows({ search: 'applied' }).select();
            } else {
                with_table.rows({ search: 'applied' }).deselect();
            }
            
            // Remove indeterminate state
            selectAllCheckbox.prop('indeterminate', false);

            getSelectedColumnSum(with_table, 7, checkboxClass = 'settleSeparateCbx');
        });

        $(document).on("change", ".settleSeparateCbx", function () {
            const row = with_table.row($(this).closest('tr'));
            
            if ($(this).prop('checked')) {
                row.select();
            } else {
                row.deselect();
            }
            
            updateSelectAllState();
        });

        function getSelectedColumnSum(table, columnIndex, checkboxClass = 'settleSeparateCbx') {
            let sum = 0;
            let total = 0;
            var withold_min_amount = $('#witholdMinAmounti').val();
            // Get all checked checkboxes in the table
            $(table.table().node()).find('.' + checkboxClass + ':checked').each(function() {
                const row = table.row($(this).closest('tr'));
                const rowData = row.data();
                
                if (rowData) {
                    // Get cell data from the DataTable API
                    const cellData = table.cell(row.index(), columnIndex).data();
                    
                    // Parse numeric value (remove non-numeric characters)
                    const numericValue = parseFloat(
                        String(cellData).replace(/[^0-9.-]+/g, '')
                    ) || 0;
                    
                    sum += numericValue;
                }
            });

            if(parseFloat(sum) >= parseFloat(withold_min_amount)){
                $('#receipt_div').show();
            }
            else{
                resetWitholdReceiptFormFn();
            }
        }

        function getUnselectedColumnSum(table, columnIndex, checkboxClass = 'settleSeparateCbx') {
            let total_checked = 0;
            let total_unchecked = 0;
            let total = 0;
            var withold_min_amount = $('#witholdMinAmounti').val();
            // Get all checked checkboxes in the table

            $(table.table().node()).find('.' + checkboxClass + ':checked').each(function() {
                const row = table.row($(this).closest('tr'));
                const rowData = row.data();
                
                if (rowData) {
                    // Get cell data from the DataTable API
                    const cellData = table.cell(row.index(), columnIndex).data();
                    
                    // Parse numeric value (remove non-numeric characters)
                    const numericValue = parseFloat(
                        String(cellData).replace(/[^0-9.-]+/g, '')
                    ) || 0;
                    
                    total_checked += numericValue;
                }
            });

            $(table.table().node()).find('.' + checkboxClass + ':not(:checked)').each(function() {
                const row = table.row($(this).closest('tr'));
                const rowData = row.data();
                
                if (rowData) {
                    // Get cell data from the DataTable API
                    const cellData = table.cell(row.index(), columnIndex).data();
                    
                    // Parse numeric value (remove non-numeric characters)
                    const numericValue = parseFloat(
                        String(cellData).replace(/[^0-9.-]+/g, '')
                    ) || 0;
                    
                    total_unchecked += numericValue;
                }
            });

            return parseFloat(total_unchecked) >= parseFloat(withold_min_amount) || parseFloat(total_unchecked) == 0 ? true : false;
        }

        function getUnselectedColumnCount(table, columnIndex, checkboxClass = 'settleSeparateCbx') {
            let count = 0;
            let total = 0;
            // Get all checked checkboxes in the table
            $(table.table().node()).find('.' + checkboxClass + ':checked').each(function() {
                const row = table.row($(this).closest('tr'));
                const rowData = row.data();
                
                if (rowData) {
                    // Get cell data from the DataTable API
                    const cellData = table.cell(row.index(), columnIndex).data();
                    
                    // Parse numeric value (remove non-numeric characters)
                    const numericValue = parseFloat(
                        String(cellData).replace(/[^0-9.-]+/g, '')
                    ) || 0;
                    
                    count += numericValue;
                }
            });

            return count;
        }

        $('#unSettlewitholdbtn').click(function(){   
            var is_valid_to_unsettle = getUnselectedColumnSum(with_table, 7, checkboxClass = 'settleSeparateCbx');
            var unsettle_count = getUnselectedColumnCount(with_table, 8, checkboxClass = 'settleSeparateCbx');
            var count = $('.settleSeparateCbx:checked').length;

            if(!is_valid_to_unsettle){
                toastrMessage('error',"You can not unsettle records, because the remaining amount would be less than the required minimum for withholding.","Error");
            }
            else if(unsettle_count != count){
                toastrMessage('error',"You can not unsettle these records because some of the selected records have not yet been settled.","Error");
            }
            else if(count == 0){
                toastrMessage('error',"Please select one or more records to unsettle.","Error");
            }
            else{
                Swal.fire({
                    title: confirmation_title,
                    text: 'Are you sure you want to unsettle the selected records?',
                    icon: confirmation_icon,
                    showCloseButton: true,
                    showCancelButton: true,      
                    allowOutsideClick: false,
                    confirmButtonText: 'Unsettle',
                    cancelButtonText: 'Close',
                    customClass: {
                        confirmButton: 'btn btn-info',
                        cancelButton: 'btn btn-danger'
                    }
                }).then(function (result) {
                    if (result.value) {
                        unSettleWitholdRecFn();
                    }
                    else if (result.dismiss === Swal.DismissReason.cancel) {}
                });
            }
        });

        function unSettleWitholdRecFn(){
            var registerForm = $('#ManageWitholdForm');
            var formData = registerForm.serialize();
            
            $.ajax({
                url: '/unsettleWithold',
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    blockPage(cardSection, 'Unsettling withholding...');
                },
                complete: function () { 
                    unblockPage(cardSection);   
                },
                success: function(data) {
                    if (data.dberrors) {
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if (data.success){
                        toastrMessage('success',"Successful","Success");
                        createReceivingInfoFn(data.recId,data.vStatus);
                        getWitholdDataFn(data.cus_id,data.trn_date);
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                    }
                }
            });
        }

        function resetWitholdReceiptFormFn(){
            $('#receipt_div').hide();
            $('.mainforminp').val("");
            $('.errordatalabel').html("");
            $('#settlewitholdbtn').text('Settle');
            $('#settlewitholdbtn').prop("disabled", false);
        }

        //hide receiving btn starts
        $('#removeReceiptBtn').click(function(){    
            $('#removeReceiptBtn').prop("disabled", true);
            var recordId = $('#unsettledid').val();
            var registerForm = $("#showunsettledform");
            var formData = registerForm.serialize();
            $.ajax({
                url: '/unsettleWithold',
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('#removeReceiptBtn').text('Removing...');
                    $('#removeReceiptBtn').prop("disabled", true);
                },
                success: function(data) {
                    if (data.success) {
                        $('#removeReceiptBtn').text('Remove');
                        $('#removeReceiptBtn').prop("disabled", false);
                        toastrMessage('success',"Successful","Success");
                        $("#showUnsettledModal").modal('hide');
                        var oTable = $('#witholdingTables').dataTable();
                        oTable.fnDraw(false);
                        ids = [];
                        $('#selectedids').val(ids);
                        var len = data.recData.length;
                        for (var i = 0; i <= len; i++) {
                            var settleType = data.recData[i].IsWitholdSettle;
                            $('#infoWitholdReceiptLbl').html(data.recData[i].WitholdReceipt);
                            $('#infoWitholdSettleBy').html(data.recData[i].WitholdSettledBy);
                            $('#infoWitholdSettleDate').html(data.recData[i].WitholdSettleDate);
                            if (settleType === "Settled") {
                                $('#settledLabelPr').show();
                                $('#notsettledLabelPr').hide();
                            } else if (settleType === "Not-Settled") {
                                $('#settledLabelPr').hide();
                                $('#notsettledLabelPr').show();
                            }
                            var total = data.TotalCount;
                            var settled = data.Settled;
                            var notsettled = data.NotSettled;

                            if (parseFloat(total) == parseFloat(settled) && parseFloat(notsettled) == 0) {
                                $('#settledLabel').show();
                                $('#notsettledLabel').hide();
                            } else if (parseFloat(total) == parseFloat(notsettled) && parseFloat(
                                    settled) == 0) {
                                $('#settledLabel').hide();
                                $('#notsettledLabel').show();
                                $('#notsettledLabel').text('Not-Settled');
                            } else if (parseFloat(settled) >= 1 && parseFloat(notsettled) >= 1) {
                                $('#settledLabel').hide();
                                $('#notsettledLabel').show();
                                $('#notsettledLabel').text('Partially-Settled');
                            }
                        }
                    }
                },
            });
        });
        //Hide receiving btn ends

        //Start Print Attachment
        $('body').on('click', '.printGrnLink', function() {
            var id = $(this).data('id');
            var link = $(this).data('link');
            window.open(link, 'GRV', 'width=1200,height=800,scrollbars=yes');
        });
        //End Print Attachment

        function supplierVal() {
            $('#supplier-error').html("");
            CalculateGrandTotal();
        }

        function paymentTypeVal() {
            $('#paymentType-error').html("");
        }

        function voucherTypeVal() {
            $('#voucherType-error').html("");
        }

        $('#VoucherSt').on('change', function() {
            voucherStatusFn();
        });

        $('#VisibleCost').on('change', function() {
            showCostColumnFn();
        });

        function voucherStatusFn() {
            var voucherst = $('#VoucherSt').is(':checked') ? 1 : 2;
            var source_type = $('input[name="SourceType"]:checked').val();

            $('.unorder_pricing_div').show();
            $('.unorder_price_col').show();

            if((parseInt(voucherst) == 0 || parseInt(voucherst) == 1) && source_type == "Purchase"){
               $('.invprop').show(); 
               $('.vatproperty').show();
               $('.with_rec').show();
               $('#invdatelbl').html("Invoice Date");
               $('#beforeAfterTax').html("Before Tax");
               $('#subGrandTotalLbl').html("Sub Total");
               $('#invoice_deliver_lbl').html("Invoice Date<b style='color: red; font-size:16px;'>*</b>");
            }
            if(parseInt(voucherst) == 2 || source_type == "Production"){
                $('.invprop').hide();
                $('.vatproperty').hide();
                $('.with_rec').hide();
                
                $('#invdatelbl').html("Purchase Date");
                $('#beforeAfterTax').html("Total Cost");
                $('#subGrandTotalLbl').html("Grand Total");
                $('#invoice_deliver_lbl').html("Date<b style='color: red; font-size:16px;'>*</b>");

                $('.with_error').html("");
                $('.with_input').val("");
                $('.with_select').val(null).select2({placeholder: "Select value here..."});
            }
            
            $('#voucherstatus-error').html("");
            calculateVat(voucherst);
        }

        function resetReceiptDataFn(){
            $('.receipt_error').html("");
            $('.receipt_input').val("");
            $('.receipt_select').val(null).select2({placeholder: "Select value here..."});
        }

        $('#ReferenceType').on('change', function() {
            var reference_type = $(this).val();
            $('.reference_doc').hide();
            $('.default_hidden_div').hide();
            $('.source_data_dynamic_div').hide();
            $('.receipt_data_div').hide();
            
            $('.unorder_pricing_div').hide();
            $('.unorder_price_col').hide();
            fillProductTypeDataFn(reference_type);
            $('#VoucherSt').prop('checked', false);
            $('#VisibleCost').prop('checked', false);
            showCostColumnFn();
            if(reference_type == 500){
                $('#src_cost_visibility').show();
                $("#document_no_div").show();
                $('.cost_visibility_div').hide();
            }
            else if(reference_type == 503){
                mngReceiptDataFn();
            }
            else{
                $('#reference_doc_div').show();
                $("#document_no_div").show();
                $('.cost_visibility_div').hide();
                fetchReceivingRefDocFn();
                $('#product-type-error').html("");
            }
            $('#voucherType').val(null).select2({placeholder: "Select invoice type here..."});
            $("#dynamicTable > tbody").empty();
            $(".proc_module").hide();
            $("#qty_header").html(`Quantity<b style="color: red; font-size:16px;">*</b>`);
            $('#reference-type-error').html("");
        });

        function fillProductTypeDataFn(ref_type){
            if(ref_type == 500 || ref_type == 503){
                var product_type_options = `
                    <option value="Goods">Goods</option>
                    <option value="Commodity">Commodity</option>
                    <option value="Metal">Metal</option>`;

                var supplier_options = $("#supplier_default > option").clone();

                $('#ProductType').empty().append(product_type_options).val(null).select2({
                    placeholder: "Select product type here",
                    minimumResultsForSearch: -1
                });

                $('#supplier').empty().append(supplier_options).val(null).select2({
                    placeholder: "Select supplier here",
                });
            }
            else{
                $('#ProductType').empty().select2({
                    placeholder: "Select reference first",
                    minimumResultsForSearch: -1
                });

                $('#supplier').empty().select2({
                    placeholder: "Select reference first",
                    minimumResultsForSearch: -1
                });
            }
            $("#document_no_div").hide();
            $("#DocumentNumber").val("");
            $('#docnumber-error').html("");
        }

        function fetchReceivingRefDocFn(){
            var reference_type = null;
            var options = null;
            $.ajax({ 
                url: '/fetchReceivingRefDoc', 
                type: 'POST',
                data:{
                    reference_type:$('#ReferenceType').val(),
                },
                beforeSend: function() {
                    blockPage(cardSection, 'Fetching references...');
                },
                complete: function () { 
                    unblockPage(cardSection);
                },
                success: function(data) {
                    var ref_type = $('#ReferenceType').val();

                    if(ref_type == 501){
                        $.each(data.purchase_order_data, function(key, value) {
                            options += `<option value="${value.po_id}">${value.po_data}</option>`;
                        });
                    }
                    else if(ref_type == 502){
                        $.each(data.purchase_invoice_data, function(key, value) {
                            options += `<option value="${value.pi_id}">${value.pi_data}</option>`;
                        });
                    }
                    $('#Reference')
                    .empty()
                    .append(options)
                    .val(null)
                    .select2({
                        placeholder: "Select reference here"
                    });
                }
            });
        }

        function fetchReferenceDataFn(){
            var reference_type = null;
            var reference_id = null;
            var supplier_option = null;
            var product_type_option = null;
            var ref_type = $('#ReferenceType').val();
            var block_ui_message = "";
            $.ajax({ 
                url: '/fetchReceivingRefData', 
                type: 'POST',
                data:{
                    reference_type:$('#ReferenceType').val(),
                    reference_id:$('#Reference').val(),
                },
                beforeSend: function() {
                    if(ref_type == 501){
                        block_ui_message = "purchase order";
                    }
                    else if(ref_type == 502){
                        block_ui_message = "purchase invoice";
                    }
                    blockPage(cardSection, `Fetching ${block_ui_message} data...`);
                },
                complete: function () { 
                    unblockPage(cardSection);
                },
                success: function(data) {
                    if(ref_type == 501){
                        $.each(data.purchase_order_data, function(key, value) {
                            supplier_option = `<option selected value="${value.supplier_id}">${value.supplier}</option>`;
                            product_type_option = `<option selected value="${value.purchaseordertype}">${value.purchaseordertype}</option>`;
                            
                            var expiry_flag_color = "";
                            var expiry_info = "";
                            var delivery_date = new Date(value.deliverydate);
                            var current_date = new Date(currentdate);

                            if(delivery_date < current_date){
                                expiry_flag_color = "#ea5455";
                                expiry_info = '<a id="expiry_info_btn" href="javascript:void(0)" class="expiry_info_btn" title="Purchase order expired."><i class="fas fa-info-circle" style="color: #82868b;"></i></a>';
                            }
                            else{
                                expiry_flag_color = "#5e5873";
                                expiry_info = "";
                            }

                            
                            $("#reference_date_lbl").html(`Expiry Date: <b style="color:${expiry_flag_color}">${value.deliverydate}</b> ${expiry_info}`);
                            
                        });

                        listPurchaseOrderDetailFn(data.purchase_detail_data);
                    }
                    else if(ref_type == 502){
                        $.each(data.purchase_invoice_data, function(key, value) {
                            supplier_option = `<option selected value="${value.id}">${value.supplier}</option>`;
                            product_type_option = `<option selected value="${value.productype}">${value.productype}</option>`;
                            $('#reference_date_lbl').html(`Invoice Date: <b>${value.invoicedate}</b>`);
                        });
                    }

                    $('#supplier')
                    .empty()
                    .append(supplier_option)
                    .select2({
                        minimumResultsForSearch: -1
                    });

                    $('#ProductType')
                    .empty()
                    .append(product_type_option)
                    .select2({
                        minimumResultsForSearch: -1
                    });

                    $('#src_expiry_date').show();
                }
            });
        }

        function listPurchaseOrderDetailFn(detail_data){
            j = 0;
            var vis = "";
            var item_options = null;
            var remaining_qty = null;
            $("#dynamicTable > tbody").empty();
            $.each(detail_data, function(key, value) {
                ++j;
                ++i;
                ++m;
                remaining_qty = parseFloat(value.qty) - parseFloat(value.receivedqty);
                if(parseFloat(remaining_qty) > 0){
                    $("#dynamicTable > tbody").append(`<tr>
                        <td style="font-weight:bold;text-align:center;width:3%;">${j}</td>
                        <td style="display:none;"><input type="hidden" name="row[${m}][vals]" id="vals${m}" class="vals form-control" readonly="true" style="font-weight:bold;" value="${m}"/></td>
                        <td style="width:21%;"><select id="itemNameSl${m}" class="select2 form-control itemName" onchange="itemFn(this)" name="row[${m}][ItemId]"><option selected value="${value.itemid}">${value.items}</option></select></td>
                        <td style="width:11%"><select id="uom${m}" class = "select2 form-control uom" onchange="uomVal(this)" name = "row[${m}][uom]"><option selected disabled value="${value.uom}">${value.uom_name}</option></select></td>
                        <td style="width:12%" class="proc_module"><input type="number" name="row[${m}][ordered_qty]" id="ordered_qty${m}" class="ordered_qty form-control numeral-mask" readonly="true" value="${value.qty}" style="font-weight:bold;"/></td>
                        <td style="width:12%" class="proc_module"><input type="number" name="row[${m}][remaining_qty]" id="remaining_qty${m}" class="remaining_qty form-control numeral-mask" value="${remaining_qty >= 0 ? remaining_qty : 0}" readonly="true" style="font-weight:bold;"/></td>
                        <td style="width:12%"><input type="number" name="row[${m}][Quantity]" placeholder="Enter quantity here" id="quantity${m}" class="quantity form-control numeral-mask" onkeyup="CalculateTotal(this)" onkeypress="return ValidateNum(event);" ondrop="return false;" onpaste="return false;"/></td>
                        <td style="width:12%" class="cost_visibility_div unorder_price_col prd_price_con"><input type="number" name="row[${m}][UnitCost]" placeholder="Unit Cost" id="unitcost${m}" class="unitcost form-control numeral-mask" onkeyup="CalculateTotal(this)" value="0" onkeypress="return ValidateNum(event);"/></td>
                        <td style="width:12%" class="cost_visibility_div unorder_price_col prd_price_con"><input type="number" name="row[${m}][BeforeTaxCost]" id="beforetax${m}" class="beforetax form-control numeral-mask" readonly="true" value="0" style="font-weight:bold;"/></td>
                        <td style="width:12%" class="vatproperty cost_visibility_div"><input type="number" name="row[${m}][TaxAmount]" id="taxamounts${m}" class="taxamount form-control numeral-mask" readonly="true" value="0" style="font-weight:bold;"/></td>
                        <td style="width:12%" class="vatproperty cost_visibility_div"><input type="number" name="row[${m}][TotalCost]" id="total${m}" class="total form-control numeral-mask" readonly="true" value="0" style="font-weight:bold;"/></td>
                        <td style="width:5%;text-align:center">
                            <a id="batch_serial_info${m}" href="javascript:void(0)" class="batch_serial_info" style="display:none;"><i class="fas fa-info-circle" style="color: #82868b;"></i></a>
                            <button type="button" id="remove_rec_item${m}" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button>
                        </td>
                        <td style="display:none;"><input type="hidden" name="row[${m}][tax]" id="tax${m}" class="tax form-control" readonly="true" value="${value.TaxTypeId}" style="font-weight:bold;"/></td>
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
            $('#proc_item_default').empty().append(item_options).select2();
            renumberRows();
        }

        $('#Reference').on('change', function() {
            fetchReferenceDataFn();
            $('#product-type-error').html("");
            $('#supplier-error').html("");
            $('#reference-doc-error').html("");
        });

        function voucherNumberval() {
            $('#voucherNumber-error').html("");
        }

        function invoiceNumberval() {
            $('#invoiceNumber-error').html("");
        }

        function mrcNumberVal() {
            $('#mrcNumber-error').html("");
        }

        function dateVal() {
            $('#date-error').html("");
        }

        function productTypeFn(){
            $("#dynamicTable > tbody").empty();
            CalculateGrandTotal();
            $('#product-type-error').html("");
        }

        function stationFn() {
            $('#store-error').html("");
        }

        function recievedByFn() {
            $('#receivedby-error').html("");
        }

        function receivedDateFn() {
            $('#received-date-error').html("");
        }

        function purchaserVal() {
            $('#purchaser-error').html("");
        }

        function deliveredByFn() {
            $('#deliveredby-error').html("");
        }

        function driverPhoneFn() {
            $('#driverphone-error').html("");
        }

        function driverLicFn() {
            $('#driverlic-error').html("");
        }

        function plateNumFn() {
            $('#platenum-error').html("");
        }

        function docNumberFn() {
            $('#docnumber-error').html("");
        }

        function prdDeliveredByFn() {
            $('#prd-deliveredby-error').html("");
        }

        function productionDateFn() {
            $('#production-date-error').html("");
        }

        function validateQuantityVal() {
            $('#addHoldQuantity-error').html("");
        }

        function validateUnitcostVal() {
            $('#addHoldunitCost-error').html("");
        }

        function voidReason() {
            $('#void-error').html("");
        }

        function ReceiptNumberVal() {
            $('#receipt-error').html("");
        }

        function ReceiptDateFn() {
            $('#receipt-date-error').html("");
        }

        function ReceiptNumberVals() {
            $('#receipts-error').html("");
        }

        function numformat(val) {
            while (/(\d+)(\d{3})/.test(val.toString())) {
                val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
            }
            return val;
        }

        function updateTextView(_obj) {
            var num = getNumber(_obj.val());
            if (num == 0) {
                _obj.val('');
            } else {
                _obj.val(num.toLocaleString());
            }
        }

        function getNumber(_str) {
            var arr = _str.split('');
            var out = new Array();
            for (var cnt = 0; cnt < arr.length; cnt++) {
                if (isNaN(arr[cnt]) == false) {
                    out.push(arr[cnt]);
                }
            }
            return Number(out.join(''));
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

        function openPurchaseFn(po_id){
            var link = `/directpoattachemnt/${po_id}`;
            window.open(link, '', 'width=1200,height=800,scrollbars=yes');
        }
        //----------Document start---------------

        function openDocumentUploadFn(rec_id){
            var receiving_id = null;
            var default_date = "1900-01-01";
            $.ajax({
                url: '/fetchReceivingDoc', 
                type: 'POST',
                data:{
                    receiving_id:rec_id,
                },
                beforeSend: function() {
                    blockPage(cardSection, 'Fetching documents...');
                },
                complete: function () { 
                    unblockPage(cardSection);    
                },
                success: function(data) {
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

                        flatpickr(`#upload_date${z3}`, { dateFormat: 'Y-m-d',allowInput: true,clickOpens:true,minDate:default_date,maxDate:currentdate});
                        $(`#select2-document_type${z3}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                        $(`#select2-doc_status${z3}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                    });
                    renumberDocRows();
                }
            });

            $('#uploadReceivingDoc').val(rec_id);
            $('#uploadDocButton').text('Upload');
            $('#uploadDocButton').prop("disabled", false);
            $('#manageDocumentModal').modal('show');
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
            flatpickr(`#upload_date${z3}`, {dateFormat: 'Y-m-d',allowInput: true,clickOpens:true,minDate:default_date,maxDate:currentdate});
            $(`#select2-document_type${z3}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
            $(`#select2-doc_status${z3}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
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

            const filePath = `/storage/uploads/Receiving/${document_folder}/${file_name}`;
            window.open(filePath, '_blank', features);
        }

        function openDocFn(row_id,doc_name,doc_type){
            var link = `../../../storage/uploads/Receiving/SupportingDocument/${doc_name}`;
            window.open(link, '', 'width=1200,height=800,scrollbars=yes');
        }

        $('#ManageDocumentForm').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                url: '/uploadDocument',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    blockPage(cardSection, 'Uploading documents...');

                    $('#uploadDocButton').text('Uploading...');
                    $('#uploadDocButton').prop("disabled", true);
                },
                complete: function () { 
                    unblockPage(cardSection);    
                },
                success: function(data) {
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
                        createReceivingInfoFn(data.rec_id,data.vstatus);

                        $(".tab-title").removeClass("active");
                        $(".tab-view").removeClass("active");
                        
                        $("#info_rec_doc_tab").addClass("active");
                        $("#info_rec_doc_view").addClass("active");
                        $("#manageDocumentModal").modal('hide');
                    }
                }
            });
        });
        //----------Document ends---------------
        
        function generateUUIDv4Fn() {
            // Generate random bytes
            var bytes = new Uint8Array(16);
            crypto.getRandomValues(bytes);
            
            // Set version (4) and variant bits
            bytes[6] = (bytes[6] & 0x0f) | 0x40; // Version 4
            bytes[8] = (bytes[8] & 0x3f) | 0x80; // Variant
            
            // Convert to hex string
            var hex = Array.from(bytes, b => b.toString(16).padStart(2, '0')).join('');
            
            // Format as UUID
            return `${hex.slice(0,8)}-${hex.slice(8,12)}-${hex.slice(12,16)}-${hex.slice(16,20)}-${hex.slice(20,32)}`;
        }
    </script>
@endsection