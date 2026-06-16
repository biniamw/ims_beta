@extends('layout.app1')
@section('title')
@endsection
@section('content')
    @can('StoreBalance-View')
    <div class="app-content content">
        <section id="responsive-datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom fit-content mb-0 pb-0">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align: left !important;align-items: center;padding: 10px 5px;">
                                        <h3 class="card-title form_title">Stock Balance</h3>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align: right !important;align-items: center;padding: 10px 5px;">
                                        <button type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm" onclick="refreshtbl()"><i class="fas fa-sync-alt"></i></button>
                                        <input type="hidden" class="form-control" name="costtype" id="costtype" value="{{ $settingsval->costType }}" readonly/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-datatable fit-content">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="row main_datatable" id="stockbalance_tbl">
                                    <div style="width:99%; margin-left:0.5%;">
                                        <table id="stockbalancedatatable" class="display table-bordered table-striped table-hover defaultdatatable mb-0 mobile-dt" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th style="width:3%;">#</th>
                                                    <th style="width:8%;">Item Type</th>
                                                    <th style="width:8%;">Item Code</th>
                                                    <th style="width:17%;">Item Name</th>
                                                    <th style="width:8%;" title="Barcode Number">Barcode No.</th>
                                                    <th style="width:9%;">Category</th>
                                                    <th style="width:5%;" title="Unit of Measurement">UOM</th>
                                                    <th style="width:7%;">Retail Price</th>
                                                    <th style="width:8%;">Wholesale Price</th>
                                                    <th style="width:7%;" title="Wholesale Minimum Quantity">WS. Min. Qty.</th> 
                                                    <th style="width:7%;" title="Wholesale Maximum Quantity">WS. Max. Qty.</th>  
                                                    <th style="width:10%;">Avaliable Stock</th>
                                                    <th style="width:3%;">Action</th>
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
        </section>
        <input type="hidden" class="form-control" name="wholesalefeaturetable" id="wholesalefeaturetable" readonly="true" value="{{ $settingsval->wholesalefeature }}" />
    </div>
    @endcan

    <!--Start Info Modal -->
    <div class="modal fade text-left fit-content" id="stockInfoModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title form_title">Item Information</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="storeBalanceInfo">
                    @csrf
                    <div class="modal-body">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <section id="stock_balance_item_info">
                                        <div class="d-flex justify-content-between align-items-center cursor-pointer border-bottom" data-toggle="collapse" data-target=".infoscl" aria-expanded="true">
                                            <h5 class="mb-0 form_title stockbalance_header_info"><i class="far fa-info-circle"></i> Basic Information</h5>
                                            <div class="d-flex align-items-center header-tab">
                                                <span class="text-uppercase font-weight-bold mr-50 toggle-text-label tab-text">Collapse</span>
                                                <div class="collapse-icon">
                                                    <i class="fas text-secondary fa-minus-circle"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="collapse stbalance show infoscl shadow pl-1 pr-1">
                                            <div class="row mb-1">
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mt-1 mb-1">
                                                    <div class="card shadow-none border m-0">
                                                        <div class="card-body mb-0">
                                                            <h6 class="card-title mb-0"><i class="fas fa-database"></i> General Details</h6>
                                                            <hr class="my-50">
                                                            <table class="infotbl mb-0" style="width:100%;font-size:12px;">
                                                                <tr>
                                                                    <td><label class="info_lbl">Item Type</label></td>
                                                                    <td><label class="info_lbl itemtypeval" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl">Item Code</label></td>
                                                                    <td><label class="info_lbl itemcodeval" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl">Item Name</label></td>
                                                                    <td><label class="info_lbl itemnameval" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl" title="Barcode Number">Barcode No.</label></td>
                                                                    <td><label class="info_lbl skunumberval" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl">Category</label></td>
                                                                    <td><label class="info_lbl categoryval" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl" title="Unit of Measurement">UOM</label></td>
                                                                    <td><label class="info_lbl uomval" id="uom_lbl" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mt-1 mb-1">
                                                    <div class="card shadow-none border m-0">
                                                        <div class="card-body">
                                                            <h6 class="card-title mb-0"><i class="fa-sharp fa-solid fa-file-invoice-dollar"></i> Sales Pricing</h6>
                                                            <hr class="my-50">
                                                            <table class="infotbl" style="width:100%;font-size:12px;">
                                                                <tr>
                                                                    <td><label class="info_lbl">Retail Price</label></td>
                                                                    <td><label class="info_lbl retailerval" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl">Wholesale Price</label></td>
                                                                    <td><label class="info_lbl wholesaleval" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl" title="Wholesale Minimum Quantity">Wholesale Min. Qty.</label></td>
                                                                    <td><label class="info_lbl wholesaleminval" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl" title="Wholesale Maximum Quantity">Wholesale Max. Qty.</label></td>
                                                                    <td><label class="info_lbl wholesalemaxval" style="font-weight: bold;"></label></td>
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
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="stockbalance_item_div">
                                                <table id="stockinfodetail" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable mb-0" style="width: 100%;">
                                                    <thead>
                                                        <th style="width: 3%">#</th>
                                                        <th style="width: 35%">Station</th>
                                                        <th style="width: 30%">Stock Balance</th>
                                                        <th style="width: 32%">Waiting for Delivery</th>
                                                        <th style="display: none;"></th>
                                                    </thead>
                                                    <tbody class="table table-sm"></tbody>
                                                    <tfoot class="table table-sm">
                                                        <td style="text-align: right;font-size: 12px;font-weight:bold;" colspan="2">
                                                            <label id="avlbl" style="font-size: 12px;">Total</label>
                                                        </td>
                                                        <td>
                                                            <label id="avbalanceval" style="font-size: 12px;font-weight: bold;"></label>
                                                        </td>
                                                        <td>
                                                            <label id="delbalanceval" style="font-size: 12px;font-weight: bold;"></label>
                                                        </td>
                                                        <td></td>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>  
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control" name="batch_serial_flag" id="batch_serial_flag" readonly="true">
                        <input type="hidden" class="form-control" name="uom_inp" id="uom_inp" readonly="true">
                        <input type="hidden" class="form-control" name="wholesalemaxinp" id="wholesalemaxinp" readonly="true">
                        <input type="hidden" class="form-control" name="wholesalemininp" id="wholesalemininp" readonly="true">
                        <button type="button" id="closebutton" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Info -->

    <!--Start delivery modal -->
    <div class="modal modal-slide-in event-sidebar fade fit-content" id="deliveryqtymodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="deliveryqtymodal" aria-hidden="true">
        <form id="deliveryqtyform">
        @csrf
            <div class="modal-dialog modal-xl" role="document" style="width: 96%;">
                <div class="modal-content p-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #ea5455 !important;font-weight:bold;">x</button>
                    <div class="modal-header mb-1">
                        <h4 class="modal-title form_title">Shipping Information</h4>
                    </div>
                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3 scrdivhor scrollhor">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <section id="shipping_item_info">
                                        <div class="d-flex justify-content-between align-items-center cursor-pointer border-bottom" data-toggle="collapse" data-target=".infoshipping" aria-expanded="true">
                                            <h5 class="mb-0 form_title shipping_header_info"><i class="far fa-info-circle"></i> Basic Information</h5>
                                            <div class="d-flex align-items-center header-tab">
                                                <span class="text-uppercase font-weight-bold mr-50 toggle-text-label-shipping tab-text">Collapse</span>
                                                <div class="collapse-icon-shipping">
                                                    <i class="fas text-secondary fa-minus-circle"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="collapse stbalance-shipping show infoshipping shadow pl-1 pr-1">
                                            <div class="row mb-1">
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mt-1 mb-1">
                                                    <div class="card shadow-none border m-0">
                                                        <div class="card-body">
                                                            <h6 class="card-title mb-0"><i class="fas fa-database"></i> General Details</h6>
                                                            <hr class="my-50">
                                                            <table class="infotbl mb-0" style="width:100%;font-size:12px;">
                                                                <tr>
                                                                    <td><label class="info_lbl">Item Type</label></td>
                                                                    <td><label class="info_lbl itemtypeval" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl">Item Code</label></td>
                                                                    <td><label class="info_lbl itemcodeval" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl">Item Name</label></td>
                                                                    <td><label class="info_lbl itemnameval" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl" title="Barcode Number">Barcode No.</label></td>
                                                                    <td><label class="info_lbl skunumberval" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl">Category</label></td>
                                                                    <td><label class="info_lbl categoryval" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl" title="Unit of Measurement">UOM</label></td>
                                                                    <td><label class="info_lbl uomval" id="uom_shipping" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mt-1 mb-1">
                                                    <div class="card shadow-none border m-0">
                                                        <div class="card-body">
                                                            <h6 class="card-title mb-0"><i class="fa-sharp fa-solid fa-file-invoice-dollar"></i> Sales Pricing</h6>
                                                            <hr class="my-50">
                                                            <table class="infotbl" style="width:100%;font-size:12px;">
                                                                <tr>
                                                                    <td><label class="info_lbl">Retail Price</label></td>
                                                                    <td><label class="info_lbl retailerval" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl">Wholesale Price</label></td>
                                                                    <td><label class="info_lbl wholesaleval" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl" title="Wholesale Minimum Quantity">Wholesale Min. Qty.</label></td>
                                                                    <td><label class="info_lbl wholesaleminval" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl" title="Wholesale Maximum Quantity">Wholesale Max. Qty.</label></td>
                                                                    <td><label class="info_lbl wholesalemaxval" style="font-weight: bold;"></label></td>
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
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="shipping_item_div">
                                                <table id="quantityondeliverytbl" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable mb-0" style="width:100%;">
                                                    <thead>
                                                        <th style="width: 3%">#</th>
                                                        <th style="width: 14%">Source Station</th>
                                                        <th style="width: 14%">Destination Station</th>
                                                        <th style="width: 15%" title="Transfer Document Number">Transfer Doc. No.</th>
                                                        <th style="width: 15%" title="Issue Document Number">Issue Doc. No.</th>
                                                        <th style="width: 13%">Deliver By</th>
                                                        <th style="width: 13%">Shipment Date</th>
                                                        <th style="width: 13%">Quantity</th>
                                                        <th style="display: none;"></th>
                                                        <th style="display: none;"></th>
                                                        <th style="display: none;"></th>
                                                    </thead>
                                                    <tbody class="table table-sm"></tbody>
                                                    <tfoot class="table table-sm">
                                                        <td colspan="7" style="padding-right: 2px !important;text-align:right;font-weight: bold;">Total</td>
                                                        <td><label id="totaldeliveredqty" style="font-weight: bold;"></label></td>
                                                        <td></td>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="closebuttonq" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- End delivery modal -->

    <!--Start batch serial modal -->
    <div class="modal modal-slide-in event-sidebar fade fit-content" id="serialBatchModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="serialBatchModal" aria-hidden="true">
        <form id="serialBatchForm">
            @csrf
            <div class="modal-dialog modal-xl" role="document" style="width: 96%;">
                <div class="modal-content p-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #ea5455 !important;font-weight:bold;">x</button>
                    <div class="modal-header mb-1">
                        <h4 class="modal-title form_title">Batch and/or Serial Numbers Information</h4>
                    </div>
                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3 scrdivhor scrollhor">
                        <div class="row mb-1">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <section id="batch_serial_item_info_section">
                                    <div class="d-flex justify-content-between align-items-center cursor-pointer border-bottom" data-toggle="collapse" data-target=".batch_serial_collapse" aria-expanded="true">
                                        <h5 class="mb-0 form_title batch_serial_item_header_info"><i class="far fa-info-circle"></i> Basic Information</h5>
                                        <div class="d-flex align-items-center header-tab">
                                            <span class="text-uppercase font-weight-bold mr-50 toggle-text-label tab-text">Collapse</span>
                                            <div class="collapse-icon">
                                                <i class="fas text-secondary fa-minus-circle"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="collapse batch_coll show batch_serial_collapse shadow pl-1 pr-1">
                                        <div class="row mb-1">
                                            <div class="col-xl-9 col-lg-9 col-md-8 col-sm-12 col-12 mt-1 mb-1">
                                                <div class="card shadow-none border m-0">
                                                    <div class="card-body mb-0">
                                                        <h6 class="card-title mb-0"><i class="fas fa-database"></i> General Information</h6>
                                                        <hr class="my-50">
                                                        <div class="row">
                                                            <div class="col-xl-6 col-lg-6 col-md-7 col-sm-7 col-12">
                                                                <table class="infotbl mb-0" style="width:100%;font-size:12px;">
                                                                    <tr>
                                                                        <td><label class="info_lbl">Item Type</label></td>
                                                                        <td><label class="info_lbl itemtypeval" style="font-weight: bold;"></label></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label class="info_lbl">Item Code</label></td>
                                                                        <td><label class="info_lbl itemcodeval" id="batch_item_code" style="font-weight: bold;"></label></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label class="info_lbl">Item Name</label></td>
                                                                        <td><label class="info_lbl itemnameval" id="batch_item_name" style="font-weight: bold;"></label></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label class="info_lbl" title="Barcode Number">Barcode No.</label></td>
                                                                        <td><label class="info_lbl skunumberval" id="batch_item_barcode" style="font-weight: bold;"></label></td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                            <div class="col-xl-6 col-lg-6 col-md-5 col-sm-5 col-12">
                                                                <table class="infotbl mb-0" style="width:100%;font-size:12px;">
                                                                    <tr>
                                                                        <td><label class="info_lbl">Category</label></td>
                                                                        <td><label class="info_lbl categoryval" id="batch_item_category" style="font-weight: bold;"></label></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label class="info_lbl" title="Unit of Measurement">UOM</label></td>
                                                                        <td><label class="info_lbl uomval" id="batch_item_uom" style="font-weight: bold;"></label></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label class="info_lbl" title="Is Batch Number Required">Is Batch No. Req.</label></td>
                                                                        <td><label class="info_lbl is_batch_req" id="batch_is_batch_req" style="font-weight: bold;"></label></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label class="info_lbl" title="Is Serial Number Required">Is Serial No. Req.</label></td>
                                                                        <td><label class="info_lbl is_serial_req" id="batch_is_serial_req" style="font-weight: bold;"></label></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label class="info_lbl" title="Is Expiry Date Required">Is Expiry Date Req.</label></td>
                                                                        <td><label class="info_lbl is_expiry_date_req" id="batch_is_expiry_date_req" style="font-weight: bold;"></label></td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 col-12 mt-1 mb-1">
                                                <div class="card shadow-none border m-0">
                                                    <div class="card-body">
                                                        <h6 class="card-title mb-0"><i class="fa-sharp fa-solid fa-file-invoice-dollar"></i> Sales Pricing</h6>
                                                        <hr class="my-50">
                                                        <table class="infotbl" style="width:100%;font-size:12px;">
                                                            <tr>
                                                                <td><label class="info_lbl">Retail Price</label></td>
                                                                <td><label class="info_lbl retailerval" style="font-weight: bold;"></label></td>
                                                            </tr>
                                                            <tr>
                                                                <td><label class="info_lbl">Wholesale Price</label></td>
                                                                <td><label class="info_lbl wholesaleval" style="font-weight: bold;"></label></td>
                                                            </tr>
                                                            <tr>
                                                                <td><label class="info_lbl" title="Wholesale Minimum Quantity">Wholesale Min. Qty.</label></td>
                                                                <td><label class="info_lbl wholesaleminval" style="font-weight: bold;"></label></td>
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
                                    <table id="docBatchSerialInfoItem" class="report-dt table-bordered table-hover dt-responsive mb-0 info_datatable receiving_item_dt" style="width: 100%;">
                                        <tbody class="table table-sm"></tbody>
                                        <tfoot class="table table-sm">
                                            <td colspan="6" style="text-align: right" class="report-total-footer" id="total_lbl"></td>
                                            <td id="total_avialable_qty" style="text-align: left" class="report-total-footer"></td>
                                            <td colspan="3" class="report-total-footer"></td>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
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
                        <button id="closebuttonserial" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!--End batch serial modal -->
@endsection

@section('scripts')
    <script  type="text/javascript">
        var stockbaltable = '';
        var gblIndex = -1;
        var batchSerialIndex = -1;

        $(function () {
            cardSection = $('#page-block');
        });

        $(document).ready(async function () {
            await stockbalancedatalist();
            appendStockBalanceFilterFn();
        });

        function stockbalancedatalist(){
            var costType = $('#costtype').val();
            stockbaltable = $('#stockbalancedatatable').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                searchHighlight: true,
                "order": [[ 3, "asc" ]],
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
                fixedHeader: true,
                dom: "<'row'<'col-sm-3 col-md-2 col-6'f><'col-sm-3 col-md-2 col-6 mt-1 sbcustom-1'><'col-sm-3 col-md-2 col-6 mt-1 sbcustom-2'><'col-sm-3 col-md-2 col-6 mt-1 sbcustom-3'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-4 col-md-4 col-4'l><'col-sm-4 col-md-4 col-4 d-flex justify-content-center'i><'col-sm-4 col-md-4 col-4 d-flex justify-content-end'p>>",
                ajax: {
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/stockbalancedata',
                    type: 'DELETE',
                    dataType: "json",
                    beforeSend: function () { 
                        blockPage(cardSection,'Loading stock balance data...');
                    },
                    complete: function () { 
                        setFocus('#stockbalancedatatable');
                        $('#stockbalancedatatable').DataTable().columns.adjust();
                    },
                    error: function () { 
                        unblockPage(cardSection);
                    },
                },
                columns: [
                    { data: 'DT_RowIndex',width:"3%"},
                    { data: 'Type', name:'regitems.Type',width:"8%"},
                    { data: 'ItemCode', name:'regitems.Code',width:"8%"},
                    { data: 'ItemName', name:'regitems.Name',width:"17%"},
                    { data: 'SKUNumber', name:'regitems.SKUNumber',width:"8%"},
                    { data: 'Category', name:'categories.Name',width:"9%"},
                    { data: 'UOM', name:'uoms.Name',width:"5%"},
                    { data: 'RetailerPrice', name:'regitems.RetailerPrice',
                        "render": function ( data, type, row, meta ) {
                            var retailerprice = data > 0 ? data : 0;
                            var maxcost = costType == 0 ? row.MaxCost : row.averageCost;
                            switch(data){
                                case 0:
                                    return '';
                                default:
                                    if(parseFloat(maxcost) > parseFloat(retailerprice)){
                                        return '<span class="badge badge-light-danger">unc</span>';
                                    }
                                    else{
                                        return numformat(data||0);
                                    }
                            } 
                        },
                        width:"7%"
                    },
                    { data: 'Wholeseller', name:'regitems.WholesellerPrice',
                        "render": function ( data, type, row, meta ) {
                            var wholesaleprice = data > 0 ? data : 0;
                            var maxcost = costType == 0 ? row.MaxCost : row.averageCost;
                            switch(data){
                                case 0:
                                    return '';
                                break;
                                default:
                                    if(parseFloat(maxcost) > parseFloat(wholesaleprice)){
                                        return '<span class="badge badge-light-danger">unc</span>';
                                    }
                                    else{
                                        return numformat(data||0);
                                    }
                            } 
                        },
                        width:"8%"
                    },
                    { data: 'wholeSellerMinAmount', name:'regitems.wholeSellerMinAmount',
                        "render": function ( data, type, row, meta ) {
                            switch(data){
                                case 0:
                                    return '';
                                break;
                            default:
                                return data;
                            }
                        },
                        width:"7%"
                    },
                    { data: 'MinimumStock',name:'regitems.MinimumStock',
                        "render": function ( data, type, row, meta ) {
                            var maximum = 0;
                            var maxreturn = '';
                            var balance = row.Balance||0;
                            var minumumstock = row.MinimumStock||0;
                            var pendingquantity = row.PendingQuantity||0;
                            if(minumumstock > 0){
                                var maxc = parseFloat(balance) - parseFloat(minumumstock) - parseFloat(pendingquantity);
                                maximum = maxc > 0 ? maxc : 0;
                                maxreturn = maximum >= row.wholeSellerMinAmount ? maximum : 0;
                            }
                            switch(row.wholeSellerMinAmount){
                                case 0:
                                    return '';
                                break;
                                default:
                                    return numformat(maxreturn);
                            }
                        },
                        width:"7%"
                    },
                    { data: 'AvailableQuantityReg', name:'regitems.AvailableQuantityReg',
                        "render": function ( data, type, row, meta ) {
                            var avbalance = parseFloat(data) > 0 ? data : 0;
                            var balance = parseFloat(row.Balance) > 0 ? parseFloat(row.Balance) : 0;
                            var result = 0;
                            if(parseFloat(avbalance) <= 0 && parseFloat(balance) > 0){
                                return 0;
                            }
                            if(parseFloat(avbalance) <= 0 && parseFloat(balance) == 0){
                                return 0;
                            }
                            if(parseFloat(avbalance) > 0){
                                return `<b>${numformat(parseFloat(data).toFixed(2))}</b>`;
                            }
                        },
                        width:"10%"
                    }, 
                    { data: 'action', name: 'action',
                        "render": function ( data, type, row, meta ) {
                            var balance = parseFloat(row.Balance) > 0 ? parseFloat(row.Balance) : 0;
                            var allbalance = parseFloat(row.AvailableQuantity) > 0 ? parseFloat(row.AvailableQuantity) : 0;
                            var minumumstock = parseFloat(row.MinimumStock) > 0 ? parseFloat(row.MinimumStock) : 0;
                            var pendingquantity = parseFloat(row.PendingQuantity) > 0 ? parseFloat(row.PendingQuantity) : 0;
                            var minamount = parseFloat(row.wholeSellerMinAmount) > 0 ? parseFloat(row.wholeSellerMinAmount) : 0;
                            var minstock = parseFloat(row.MinimumStock) > 0 ? parseFloat(row.MinimumStock) : 0;
                            var wholesalemax = parseFloat(balance) - parseFloat(pendingquantity) - parseFloat(minstock);
                            wholesalemax = wholesalemax > 0 ? wholesalemax : 0;

                            return `<div class="text-center">
                                        <a class="balanceinfo" 
                                            href="javascript:void(0)" 
                                            data-id="${row.id}" 
                                            data-code="${row.ItemCode}" 
                                            data-name="${row.ItemName}" 
                                            data-sku="${row.SKUNumber}" 
                                            data-category="${row.Category}" 
                                            data-uom="${row.UOM}" 
                                            data-ret="${row.RetailerPrice}" 
                                            data-wholesale="${row.Wholeseller}" 
                                            data-wholesalemin="${minamount}" 
                                            data-wholesalemax="${wholesalemax}" 
                                            data-totalq="${row.Balance}" 
                                            data-maxcost="${row.MaxCost}" 
                                            data-pending="${pendingquantity}" 
                                            data-minstock="${minstock}" 
                                            id="stock_balance${row.id}" 
                                            onclick="stbalanceInfoFn(${row.id})"
                                            title="Show item detail information">
                                                <i class="fa-sharp fa-regular fa-circle-info fa-xl" style="color: #00cfe8;"></i>
                                        </a>
                                    </div>`;
                        },
                        width:"3%"
                    }
                ],
                columnDefs: [
                    { 
                        targets: [0,11,12], 
                        orderable: false,
                        searchable: false
                    }
                ],
                "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull){
                    var api = this.api();
                    var maximum = '';
                    var balance = aData.Balance > 0 ? aData.Balance : 0;
                    var pendingbalance = aData.PendingQuantity > 0 ? aData.PendingQuantity : 0;
                    var minstock = aData.MinimumStock > 0 ? aData.MinimumStock : 0;
                    var minamount = aData.wholeSellerMinAmount > 0 ? aData.wholeSellerMinAmount : 0;
                    var allblance = parseFloat(balance) - parseFloat(pendingbalance);
                    if(parseFloat(minstock) > 0){
                        var maxc = parseFloat(allblance) - parseFloat(minstock);
                        maximum = maxc >= 0 ? maxc : 0;
                    }
                    var minimumstock = aData.MinimumStock > 0 ? aData.MinimumStock : 0;    
                    var avquantity = aData.AvailableQuantity > 0 ? aData.AvailableQuantity : 0;  
                    var wholesalefeaturetable = $('#wholesalefeaturetable').val();

                    if(parseFloat(wholesalefeaturetable) == 0){
                        api.column(8).visible(false);
                        api.column(9).visible(false);
                        api.column(10).visible(false);
                        if(parseFloat(allblance) <= 0 || parseFloat(avquantity) <= 0) {
                            $(nRow).find('td:eq(6)').css({"text-decoration": "line-through","text-decoration-color": "red"});
                        }

                        if(aData.StockPr == 1 && aData.StockAv == 1) {
                            $(nRow).find('td:eq(7)').css({"font-weight": "bold"});
                        } 
                        else if(aData.StockPr == 0 && aData.StockAv == 1) {
                            $(nRow).find('td:eq(7)').css({"font-weight": "bold"});
                        }
                        else if(aData.StockPr == 0 && aData.StockAv == 0) {
                            $(nRow).find('td:eq(7)').css({"font-weight": "bold"});
                        }  
                    }
                    if(parseFloat(wholesalefeaturetable) == 1){
                        api.column(8).visible(true);
                        api.column(9).visible(true);
                        api.column(10).visible(true);

                        if(parseFloat(allblance) < parseFloat(minimumstock) || parseFloat(maximum) < parseFloat(minamount) || parseFloat(allblance) <= 0 || parseFloat(maximum) <= 0 || parseFloat(allblance) < parseFloat(minamount)){
                            $(nRow).find('td:eq(8)').css({"text-decoration": "line-through","text-decoration-color": "red"});
                            $(nRow).find('td:eq(9)').css({"text-decoration": "line-through","text-decoration-color": "red"});
                            $(nRow).find('td:eq(10)').css({"text-decoration": "line-through","text-decoration-color": "red"});
                        }
                        if(aData.StockPr == 1 && aData.StockAv == 1){
                            $(nRow).find('td:eq(10)').css({"font-weight": "bold"});
                        } 
                        else if(aData.StockPr == 0 && aData.StockAv == 1){
                            $(nRow).find('td:eq(10)').css({"font-weight": "bold"});
                        }
                        else if(aData.StockPr == 0 && aData.StockAv == 0){
                            $(nRow).find('td:eq(10)').css({"font-weight": "bold"});
                        }  
                    }  
                },
                "initComplete": function(settings, json) {
                    unblockPage(cardSection);
                },
                drawCallback: function(settings) {
                    this.api().columns().every(function() {
                        var column = this;
                        var header = $(column.header()).text().trim();
                        
                        $(column.nodes()).each(function() {
                            $(this).attr('data-title', header);
                        });
                    });
                    $('#stockbalancedatatable').DataTable().columns.adjust();
                    unblockPage(cardSection);
                },
                fixedHeader: {
                    header: true,
                    headerOffset: $('.header-navbar').outerHeight(),
                },
            });
        }

        function appendStockBalanceFilterFn(){
            var stock_balance_type_filter = $(`
                <select class="selectpicker form-control dropdownclass" id="sb_type_filter" name="sb_type_filter[]" title="Select type here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" data-actions-box="true" multiple data-selected-text-format="count" data-count-selected-text="Item Type ({0})">
                    <option selected value="Consumption">Consumption</option>
                    <option selected value="Finished Goods">Finished Goods</option>
                    <option selected value="Fixed Asset">Fixed Asset</option>
                    <option selected value="Goods">Goods</option>
                    <option selected value="Raw Material">Raw Material</option>
                    <option selected value="Service">Service</option>
                </select>`);

            $('.sbcustom-1').html(stock_balance_type_filter);
            $('#sb_type_filter')
            .selectpicker()
            .off('changed.bs.select') 
            .on('changed.bs.select', function () {  
                var selected = $('#sb_type_filter option:selected');
                var search = [];

                // Collect selected option values
                $.each(selected, function() {
                    search.push($(this).val());
                });

                if (search.length === 0) {
                    // No option selected: force DataTable to return no data
                    stockbaltable.column('regitems.Type:name').search('^$', true, false).draw(); // Match an impossible pattern
                } else {
                    // Options selected: build regex for filtering
                    var searchRegex = '^(' + search.join('|') + ')$'; // More precise regex pattern
                    stockbaltable.column('regitems.Type:name').search(searchRegex, true, false).draw();
                }
            });
        }

        function setFocus(targetTable) {
            $($(targetTable + ' tbody > tr')[globalIndex]).addClass('selected');
        }

        $('#stockbalancedatatable tbody').on('click', 'tr', function () {
            $('#stockbalancedatatable tbody > tr').removeClass('selected');
            $(this).addClass('selected');
            gblIndex = $(this).index();
        });

        function stbalanceInfoFn(id){
            $.ajax({
                type: "GET",
                url: "{{ url('showitem') }}/"+id,
                beforeSend: function () { 
                    blockPage(cardSection,'Fetching item data...');
                },
                success:async function (response) {
                    await stockBalanceInfoDataFn(response,id);
                    $(".infoscl").collapse('show');
                    $('#stockInfoModal').modal('show');
                },
                error: function () {
                    unblockPage(cardSection);
                }
            });
        }

        function stockBalanceInfoDataFn(response,id){
            var unc = '<span class="badge badge-light-danger">unc</span>';
            var totalavailableqnt = "";
            var wholemax = -1;
            var wholemin = -1;
            var modal = $(this);
            var is_batch_req;
            var is_expiry_req;
            var is_serial_req;

            $.each(response.item, function (index, value) { 
                var maxc = value.MaxCost;
                var retpr = value.RetailerPrice;
                var wholesale = value.WholesellerPrice;
                var totalq = value.AvailableQuantity;
                var minstock = value.MinimumStock;
                var pending = value.PendingQuantity; 
                var averageCost = value.MaxCost;

                wholemin = value.wholeSellerMinAmount;
                $("#itemid").html(value.id);
                $(".itemtypeval").html(value.Type);
                $(".itemcodeval").html(value.Code);
                $(".itemnameval").html(value.Name);
                $(".skunumberval").html(value.SKUNumber);
                $(".maxcostval").html(maxc > 0 ? numformat(maxc) : 0);
                $(".categoryval").html(value.category_name);
                $(".uomval").html(value.uom_name);
                $("#uom_inp").val(value.uom_name);

                $("#batch_serial_flag").val((value.RequireSerialNumber != "Not-Require" || value.RequireExpireDate != "Not-Require") ? 1 : 0);

                is_batch_req = value.RequireExpireDate == "Require-BatchNumber" || value.RequireExpireDate == "Require-Both" ? "Yes" : "No";
                is_expiry_req = value.RequireExpireDate == "Require-ExpireDate" || value.RequireExpireDate == "Require-Both" ? "Yes" : "No";
                is_serial_req = value.RequireSerialNumber == "Required" ? "Yes" : "No";

                $(".is_batch_req").html(is_batch_req);
                $(".is_expiry_date_req").html(is_expiry_req);
                $(".is_serial_req").html(is_serial_req);

                totalq = parseFloat(value.AvailableQuantity) - parseFloat(value.PendingQuantity);
                wholemax = parseFloat(totalq) - parseFloat(minstock);

                if(parseFloat(retpr) > 0){
                    if(parseFloat(maxc) > parseFloat(retpr)){
                        $(".retailerval").html(unc);
                    } 
                    else{
                        if(parseFloat(totalq) <= 0){
                            retpr = `<p style='text-decoration:line-through;text-decoration-color:red;'>${retpr}</p>`;
                        }
                        else{
                            $(".retailerval").html(numformat(retpr));
                        }
                    }
                } 
                else{
                    $(".retailerval").html("");
                }

                if(parseFloat(wholesale) > 0){
                    if(parseFloat(maxc) > parseFloat(wholesale)){
                        $(".wholesaleval").html(unc);

                        $(".wholesaleminval").html(numformat(wholemin));
                        $(".wholesalemaxval").html(numformat(wholemax));

                        $("#wholesalemininp").val(wholemin);
                        $("#wholesalemaxinp").val(wholemax);
                    } 
                    else{
                        if(parseFloat(totalq) < parseFloat(minstock) || parseFloat(wholemax) < parseFloat(wholemin) || parseFloat(totalq) <= 0 || parseFloat(wholemax) <= 0 || parseFloat(totalq) < parseFloat(wholemin)){
                            switch(minstock){
                                case 0:
                                    wholemax = '';
                                break;
                                default:
                                    if(parseFloat(wholemax) <= 0){
                                        wholemax = 0;
                                    } 
                                    else{
                                        wholemax = wholemax;
                                    }
                                break;
                            }
                            wholesale = `<p style='text-decoration:line-through;text-decoration-color:red;'>${wholesale}</p>`;
                            wholemin = `<p style='text-decoration:line-through;text-decoration-color:red;'>${wholemin}</p>`;
                            wholemax = `<p style='text-decoration:line-through;text-decoration-color:red;'>${wholemax}</p>`;
                            $(".wholesaleval").html(numformat(wholesale));
                            $(".wholesaleminval").html(numformat(wholemin));
                            $(".wholesalemaxval").html(numformat(wholemax));
                            $("#wholesalemininp").val(wholemin);
                            $("#wholesalemaxinp").val(wholemax);
                        } 
                        else{
                            switch(minstock){
                                case 0:
                                    wholemax = '';
                                break;
                                default:
                                    if(parseFloat(wholemax) <= 0){
                                        wholemax = 0;
                                    } 
                                    else{
                                        wholemax = wholemax;
                                    }
                                break;
                            }
                            
                            $(".wholesaleval").html(numformat(wholesale));
                            $(".wholesaleminval").html(numformat(wholemin));
                            $(".wholesalemaxval").html(numformat(wholemax));
                            $("#wholesalemininp").val(wholemin);
                            $("#wholesalemaxinp").val(wholemax);
                        }
                    }
                }
                else{
                    $(".wholesaleval").html("");
                    $(".wholesaleminval").html("");
                    $(".wholesalemaxval").html("");
                    $("#wholesalemininp").val("");
                    $("#wholesalemaxinp").val("");
                } 
            });

            fetchDetailDataFn(id);
        }

        function fetchDetailDataFn(id){
            var total_pending = 0;
            var totalallbalance = 0;
            var storebalanceqnt = 0;
            var quantityondel = 0;
            var batch_serial_btn = "";
            var uom = $('#uom_inp').val();
            var wholemin = $("#wholesalemininp").val();
            var wholemax = $("#wholesalemaxinp").val();
            var batch_serial_fl = $("#batch_serial_flag").val();

            $('#stockinfodetail').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                searchHighlight: true,
                "order": [[ 1, "asc" ]],
                "pagingType": "simple",
                language: { 
                    search: '', 
                    searchPlaceholder: "Search here"
                },
                deferRender: true,
                autoWidth: false,
                info: false,
                length: false,
                paging: false,
                dom: "<'row'<'col-sm-4 col-md-2 col-5 ml-0'f><'col-sm-8 col-md-10 col-7 mt-1 pb-1 d-flex justify-content-end batch-serial-btn'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-4 col-md-4 col-4'l><'col-sm-4 col-md-4 col-4 d-flex justify-content-center'i><'col-sm-4 col-md-4 col-4 d-flex justify-content-end'p>>",
                ajax: {
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/showStockDetail/'+id,
                    type: 'DELETE',
                    dataType: "json",
                },
                columns: [
                    { data: 'DT_RowIndex',width:"3%"},
                    { data: 'StoreName', name: 'StoreName',width:"35%"},
                    { data: 'StoreBalance', name: 'StoreBalance',
                        "render": function (data, type, row, meta) {
                            var pen = row.PendingQuantity > 0 ? row.PendingQuantity : 0;
                            var bal = row.StoreBalance > 0 ? row.StoreBalance : 0;
                            var result = 0;
                            result = parseFloat(bal)-parseFloat(pen);
                            
                            if((parseFloat(result) < 0) && row.UserIds == 0 || row.UserIds == "" || row.UserIds==null){
                                return "N/A";
                            }
                            if(parseFloat(result) < 0 && row.UserIds > 0){
                                return 0;
                            }
                            if((row.UserIds == 0 || row.UserIds == "" || row.UserIds == null) && parseFloat(result) > 0){
                                return "A/V";
                            }
                            if(row.UserIds == 0 || row.UserIds == "" || row.UserIds == null){
                                return "N/A";
                            }
                            if(parseFloat(row.UserIds) > 0){
                                return `${numformat(parseFloat(result).toFixed(2))} ${row.UOM}`;
                            }
                            if(parseFloat(result) > 0 && parseFloat(row.UserIds) > 0){
                                return `${numformat(parseFloat(result).toFixed(2))} ${row.UOM}`;
                            }   
                        },
                        width:"30%"
                    },
                    { data: 'QtyOnDelivery', name: 'QtyOnDelivery',
                        "render": function (data, type, row, meta) {
                            var qtydel = data > 0 ? data : 0;
                            var results = 0;
                            results = parseFloat(qtydel);
                            var with_qty = `<a style="text-decoration:underline;color:blue;" onclick=opendetailmod("${row.ItemId}","${row.StoreId}","${row.QtyOnDelivery}")>${numformat(parseFloat(results).toFixed(2))} ${row.UOM}</a>`;
                            if((parseFloat(results) < 0) && parseFloat(row.UserIds) == 0 || row.UserIds == "" || row.UserIds == null){
                                return "N/A";
                            }
                            if(parseFloat(results) < 0 && parseFloat(row.UserIds) > 0){
                                return 0;
                            }
                            if((row.UserIds == 0 || row.UserIds == "" || row.UserIds == null) && parseFloat(results) > 0){
                                return "A/V";
                            }
                            if(row.UserIds == 0 || row.UserIds == "" || row.UserIds == null){
                                return "N/A";
                            }
                            if(parseFloat(row.UserIds) > 0){
                                return with_qty;
                            }
                            if(parseFloat(results) > 0 && parseFloat(row.UserIds) > 0){
                                return  with_qty;
                            }   
                        },
                        width:"32%"
                    },
                    { data: null, className: "sum",'visible': false,
                        "render": function (data, type, row, meta) {
                            var pen = row.PendingQuantity > 0 ? row.PendingQuantity : 0;
                            var bal = row.StoreBalance > 0 ? row.StoreBalance : 0;
                            var result = 0;
                            result = parseFloat(bal)-parseFloat(pen);
                            if((parseFloat(result) < 0) && row.UserIds == 0 || row.UserIds == "" || row.UserIds == null){
                                return 0;
                            }
                            if(parseFloat(result) < 0 && row.UserIds > 0){
                                return 0;
                            }
                            if((row.UserIds == 0 || row.UserIds == "" || row.UserIds == null ) && parseFloat(result) > 0){
                                return 0;
                            }
                            if(row.UserIds == 0 || row.UserIds == "" || row.UserIds == null){
                                return 0;
                            }
                            if(row.UserIds > 0){
                                return result;
                            }
                            if(parseFloat(result) > 0 && row.UserIds > 0){
                                return result;
                            }   
                        }
                    },
                ],
                
                "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    var qtydel = aData.QtyOnDelivery > 0 ? aData.QtyOnDelivery : 0;
                    var pen = aData.PendingQuantity > 0 ? aData.PendingQuantity : 0;
                    var bal = aData.StoreBalance > 0 ? aData.StoreBalance : 0;
                    var userid = aData.UserIds > 0 ? aData.UserIds : 0;
                    var result = 0;
                    var total = 0;
                    result = parseFloat(bal) - parseFloat(pen);
                    total_pending += userid > 0 ? parseFloat(pen) : 0;
                    storebalanceqnt += userid > 0 ? parseFloat(bal) : 0;
                    totalallbalance += parseFloat(bal);
                    quantityondel += parseFloat(qtydel);
                    if ((parseFloat(userid) == 0) && (parseFloat(result) > 0)) {
                        for(var i = 0;i <= 3;i++){
                            $(nRow).find('td:eq('+i+')').css({"color":"#f6c23e","font-weight":"bold"});
                        }
                    } 
                    else if (parseFloat(result) > 0) {
                        for(var i = 0;i <= 3;i++){
                            $(nRow).find('td:eq('+i+')').css({"color":"#1cc88a","font-weight":"bold"});
                        }
                    } 
                    else if (parseFloat(result) <= 0) {
                        for(var i = 0;i <= 3;i++){
                            $(nRow).find('td:eq('+i+')').css({"color":"#e74a3b","font-weight":"bold"});
                        }
                    }
                    if(parseFloat(result) <= 0 && parseFloat(qtydel) <= 0){
                        $(nRow).css({"display":"none"});
                    }
                },    

                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api();
                    var columns = [0];

                    var total = parseFloat(storebalanceqnt) - parseFloat(total_pending); 
                    if(parseFloat(total) <= 0){
                        totalavailableqnt = `0 ${uom}`;
                    }
                    else if(parseFloat(total) > 0){
                        totalavailableqnt = `${numformat(parseFloat(total).toFixed(2))} ${uom}`;
                    }
                    $('#avbalanceval').html(totalavailableqnt);
                    $('#delbalanceval').html(`${numformat(parseFloat(quantityondel || 0).toFixed(2))} ${uom}`);
                    var maximum = 0;
                    var maxreturn = '';
                    var balance = totalallbalance > 0 ? totalallbalance : 0;
                    var minumumstock = wholemax > 0 ? wholemax : 0;
                    var pendingquantity = total_pending > 0 ? total_pending : 0;

                    if(parseFloat(minumumstock) > 0){
                        var maxc = parseFloat(balance) - parseFloat(minumumstock) - parseFloat(pendingquantity);
                        maximum = maxc > 0 ? maxc : 0;
                        maxreturn = maximum >= wholemin ? maximum : 0;
                    }

                    // $.each(columns, function(idx) {
                    //     var storebalanceqnt = api
                    //     .cells( function ( index, data, node ) {
                    //         return api.row( index ).data().UserIds>0 ?
                    //             true : false;
                    //     }, 3 )
                    //     .data()
                    //     .reduce( function (a, b) {
                    //         return parseInt(a) + parseInt(b);
                    //     }, 0);

                    //     var pendingqnt = api
                    //     .cells( function ( index, data, node ) {
                    //         return api.row( index ).data().UserIds>0 ?
                    //             true : false;
                    //     }, 5 )
                    //     .data()
                    //     .reduce( function (a, b) {
                    //         return parseInt(a) + parseInt(b);
                    //     }, 0);

                    //     var totalallbalance = api
                    //         .column(3)
                    //         .data()
                    //         .reduce(function (a, b) {
                    //                 var cur_index = api.column(3).data().indexOf(b);
                    //                 if (api.column(4).data()[cur_index]>0) {
                    //                 return parseInt(a) + parseInt(b);
                    //             }
                    //             else { return parseInt(a); }
                    //         }, 0);  

                    //     var quantityondel = api
                    //         .column(9)
                    //         .data()
                    //         .reduce(function (a, b) {
                    //                 var cur_index = api.column(9).data().indexOf(b);
                    //                 if (api.column(4).data()[cur_index]>0) {
                    //                 return parseInt(a) + parseInt(b);
                    //             }
                    //             else { return parseInt(a); }
                    //         }, 0);  
                            
                    //     var total = parseFloat(storebalanceqnt)-parseFloat(total_pending); 
                    //     if(parseFloat(total||0) <= 0){
                    //         totalavailableqnt = `<h3><p style='font-weight:bold;'>0 ${uom}</p></h3>`;
                    //     }
                    //     else if(parseFloat(total||0) > 0){
                    //         totalavailableqnt = `<h3><p style='font-weight:bold;'>${numformat(total||0)} ${uom}</p></h3>`;
                    //     }
                    //     $('#avbalanceval').html(totalavailableqnt);
                    //     $('#delbalanceval').html(`<h3><p style='font-weight:bold;'>${numformat(quantityondel||0)} ${uom}</p></h3>`);
                    //     var maximum = 0;
                    //     var maxreturn = '';
                    //     var balance = totalallbalance > 0 ? totalallbalance : 0;
                    //     var minumumstock = wholemax > 0 ? wholemax : 0;
                    //     var pendingquantity = total_pending > 0 ? total_pending : 0;
                    //     if(minumumstock > 0){
                    //         var maxc = parseFloat(balance)-parseFloat(minumumstock)-parseFloat(pendingquantity);
                    //         maximum = maxc > 0 ? maxc : 0;
                    //         maxreturn = maximum >= wholemin ? maximum : 0;
                    //     }
                    // });
                },
                "initComplete": function(settings, json) {
                    unblockPage(cardSection);
                },
            });

            if(parseInt(batch_serial_fl) == 1){
                // batch_serial_btn = `<a 
                //     class="viewsernum btn btn-outline-secondary btn-sm" 
                //     href="javascript:void(0)" 
                //     onclick="viewBatchSerialExpireFn(${id})" 
                //     data-id="viewsernum${id}" 
                //     id="viewsernum${id}" 
                //     title="View batch number, serial number, expiry date!">
                //     View Batch Details
                // </a>`;

                batch_serial_btn = `<button type="button" class="btn btn-outline-secondary" aria-haspopup="true" aria-expanded="false" onclick="viewBatchSerialExpireFn(${id})" >
                    <i class="fas fa-eye fa-xl"></i><span class="btn-text">&nbsp View Batch Details</span>
                </button>`;
            }

            $('.batch-serial-btn').empty().append(batch_serial_btn);
        }

        //-------------------Start batch serial-----------------
        function viewBatchSerialExpireFn(item_id){
            var str_id = null;
            var itm_id = null;
            $.ajax({
                url: '/fetchItemAndStore', 
                type: 'POST',
                data:{
                    itm_id: item_id,
                },
                beforeSend: function() {
                    blockPage(cardSection, 'Fetching batch and/or serial numbers data...');
                },
                success: async function(data) {
                    $('.batch_serial_item_header_info').html(`Item Code: <b>${data.item_code}</b>, Item Name: <b>${data.item_name}</b>`);
                    await getItemBatchSerialNumFn(item_id);
                },
                error: function () {
                    unblockPage(cardSection);
                }
            });

            $(".batch_serial_collapse").collapse('hide');
            $('#serialBatchModal').modal('show'); 
        }

        function getItemBatchSerialNumFn(item_id){
            batchSerialIndex = -1;
            var str_id = null;
            var itm_id = null;
            var warning_date = 30;
            var visibility_flag = true;
            var column_index = [];
            var is_batch_req = $(".is_batch_req").text().trim();
            var is_exp_date_req = $(".is_expiry_date_req").text().trim();
            var is_serial_num_req = $(".is_serial_req").text().trim();
            var item_name = $("#batch_item_name").text().trim();
            $('#docBatchSerialInfoItem > thead').hide();
            
            if(is_batch_req == "No"){
                column_index.push(3);
                visibility_flag = false;
            }
            if(is_exp_date_req == "No"){
                column_index.push(7,8);
                visibility_flag = false;
            }
            if(is_serial_num_req == "No"){
                column_index.push(4);
                visibility_flag = false;
            }
            
            var batch_table = $('#docBatchSerialInfoItem').DataTable({
                destroy:true,
                processing: true,
                serverSide: false,
                paging: false,
                info:false,
                searchHighlight: true,
                searching: true,
                "order": [[ 1, "asc" ],[ 8, "asc" ]],
                language: { 
                    search: '', 
                    searchPlaceholder: "Search here"
                },
                autoWidth: false,
                deferRender: true,
                dom: "<'row'<'col-sm-4 col-md-2 col-5 ml-0'f><'col-sm-8 col-md-10 col-7 mt-1 d-flex justify-content-end stbalance-print-export'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-4 col-md-4 col-4'l><'col-sm-4 col-md-4 col-4 d-flex justify-content-center'i><'col-sm-4 col-md-4 col-4 d-flex justify-content-end'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/fetchBatchSerialData',
                    type: 'POST',
                    data:{
                        itm_id: item_id,
                    },
                    complete: function () { 
                        $('#docBatchSerialInfoItem > thead').hide();
                        setFocusInfoTable('#docBatchSerialInfoItem');
                    },
                },
                columns: [{
                        data:'DT_RowIndex',
                        width:'3%',
                    },
                    {
                        data: 'station_name',
                        name: 'station_name',
                        width:'10%',
                    },
                    {
                        data: 'brand_name',
                        name: 'brand_name',
                        width:'10%',
                    },
                    {
                        data: 'model_name',
                        name: 'model_name',
                        width:'10%',
                    },
                    {
                        data: 'batch_number',
                        name: 'batch_number',
                        width:'12%',
                    },
                    {
                        data: 'serial_numbers',
                        name: 'serial_numbers',
                        width:'21%',
                    },
                    {
                        data: 'available_qty',
                        name: 'available_qty',
                        width:'8%',
                        render: $.fn.dataTable.render.number(',', '.',0, '')
                    },   
                    {
                        data: 'manufacturing_date',
                        name: 'manufacturing_date',
                        width:'10%',
                    },
                    {
                        data: 'expiry_date',
                        name: 'expiry_date',
                        width:'8%',
                    },
                    {
                        data: 'remaining_day',
                        name: 'remaining_day',
                        width:'8%',
                        render: $.fn.dataTable.render.number(',', '.',0, '')
                    }, 
                ],
                "columnDefs": [{
                    "targets": column_index,
                    "visible": visibility_flag,
                }],
                rowGroup: {
                    startRender: function (rows,group){
                        var color = 'style="color:black;font-weight:bold;background:#f2f3f4;"';
                        var header_group = `
                            <tr>
                                <th colspan="10" class="merged-header" style="text-align:center;">${group}</th>
                            </tr>
                            <tr>
                                <th style="width: 3%">#</th>
                                <th style="width: 10%">Station</th>
                                <th style="width: 10%"><i class="fas fa-info-circle" title="Country, manufacturer, brand"></i> Brand</th>
                                <th style="width: 10%">Generic/ Model</th>
                                <th style="width: 12%" title="Batch Number">Batch No.</th>
                                <th style="width: 21%" title="Serial Number">Serial No.</th>
                                <th style="width: 8%" title="Available Quantity">Available Qty.</th>
                                <th style="width: 10%">Manufacturing Date</th>
                                <th style="width: 8%">Expiry Date</th>
                                <th style="width: 8%">Remaining Day</th>
                            </tr>`;

                        return $(header_group)
                    },
                    endRender: function ( rows, group ) {
                        var intVal = function ( i ) {
                            return typeof i === 'string' ?
                                i.replace(/[\$,]/g, '')*1 :
                                typeof i === 'number' ?
                                        i : 0;
                        };

                        var available_qty = rows
                            .data()
                            .pluck('available_qty')
                            .reduce(function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0); 

                        var color = 'style="color:black;font-weight:bold;background:#f2f3f4;"';
                        var total_merged_row = `<tr><td colspan="6" style="text-align:right" class="report-total-footer">Total of ${group}</td><td class="report-total-footer" style="text-align:left">${numformat(parseFloat(available_qty).toFixed(0))}</td><td class="report-total-footer" colspan="3"></td></tr>`;
                        return $(total_merged_row);     
                    },  
                    dataSrc: 'station_name'
                },
                "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    var remaining_date = aData.remaining_day;
                    if(parseInt(remaining_date) < 0) {
                        for(var i = 0;i <= 9;i++){
                            $(nRow).find(`td:eq(${i})`).css({"color":"#ea5455"});
                        }
                    } 
                    else if(parseInt(remaining_date) >= 0 && parseInt(remaining_date) <= 30){
                        for(var i = 0;i <= 9;i++){
                            $(nRow).find(`td:eq(${i})`).css({"color":"#ff9f43"});
                        }
                    }
                    else if(parseInt(remaining_date) > 30){
                        for(var i = 0;i <= 9;i++){
                            $(nRow).find(`td:eq(${i})`).css({"color":"#28c76f"});
                        }
                    }
                },
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(),data;
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    var total = api
                        .column(6)
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    $('#total_lbl').html(`Total of ${item_name}`);
                    $('#total_avialable_qty').html(`${numformat(parseFloat(total || 0))}`);
                },
                "initComplete": function(settings, json) {
                    unblockPage(cardSection);
                },
                drawCallback: function(settings) {
                    var api = this.api();
                    var currentIndex = 1;
                    var currentGroup = null;
                    api.rows({ page: 'current', search: 'applied' }).every(function() {
                        var rowData = this.data();
                        if (rowData) {
                            var group = rowData['station_name'];
                            if (group !== currentGroup) {
                                currentIndex = 1; // Reset index for a new group
                                currentGroup = group;
                            }
                            $(this.node()).find('td:first').text(currentIndex++);
                        }
                    });   
                },
            });

            var print_export_btn = $(`
                <div class="btn-group dropdown" style="height:38px !important;">
                    <button type="button" class="btn btn-outline-secondary btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa-sharp fa-solid fa-caret-down fa-xl"></i><span class="btn-text">&nbsp Print & Export</span>
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item printBatchSerial" data-id="printBatchSerial" id="printBatchSerial" title="Print Batch and/or Serial Number">
                                <span><i class="fas fa-print"></i> Print</span>  
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item exportExcelBatchSerial" data-id="exportExcelBatchSerial" id="exportExcelBatchSerial" title="Export Batch and/or Serial Number to Excel">
                                <span><i class="fas fa-file-excel"></i> Export to Excel</span>  
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item exportPdfBatchSerial" data-id="exportPdfBatchSerial" id="exportPdfBatchSerial" title="Export Batch and/or Serial Number to PDF">
                                <span><i class="fas fa-file-pdf"></i> Export to PDF</span>  
                            </a>
                        </li>
                    </ul>
                </div>
            `);

            $('.stbalance-print-export').empty().append(print_export_btn);
        }

        $('#docBatchSerialInfoItem tbody').on('click', 'tr', function () {
            $('#docBatchSerialInfoItem tbody > tr').removeClass('selected');
            $(this).addClass('selected');
            batchSerialIndex = $(this).index();
        });

        function setFocusInfoTable(targetTable) {
            $($(targetTable + ' tbody > tr')[batchSerialIndex]).addClass('selected');
        }
        //-------------------End batch serial-------------------

        //-----------------Start Print & Export-----------------
        $(document).on('click', '#exportExcelBatchSerial', function() {
            var item_code = $("#batch_item_code").text().trim();
            var item_name = $("#batch_item_name").text().trim();
            var barcode = $("#batch_item_barcode").text().trim();
            var category = $("#batch_item_category").text().trim();
            var uom = $("#batch_item_uom").text().trim();
            var station = $("#batch_station").text().trim();

            var is_batch_req = $("#batch_is_batch_req").text().trim();
            var is_serial_req = $("#batch_is_serial_req").text().trim();
            var is_expiry_req = $("#batch_is_expiry_date_req").text().trim();
            var page_title = "Batch, Serial & Expiry Report";

            if(is_batch_req == "Yes" && is_serial_req == "Yes" && is_expiry_req == "Yes"){
                page_title = "Batch, Serial & Expiry Report";
            }
            else if(is_batch_req == "Yes" && is_serial_req == "Yes" && is_expiry_req == "No"){
                page_title = "Batch & Serial Report";
            }
            else if(is_batch_req == "Yes" && is_serial_req == "No" && is_expiry_req == "No"){
                page_title = "Batch Report";
            }
            else if(is_batch_req == "Yes" && is_serial_req == "No" && is_expiry_req == "Yes"){
                page_title = "Batch & Expiry Report";
            }
            else if(is_batch_req == "No" && is_serial_req == "Yes" && is_expiry_req == "Yes"){
                page_title = "Serial & Expiry Report";
            }
            else if(is_batch_req == "No" && is_serial_req == "No" && is_expiry_req == "Yes"){
                page_title = "Expiry Report";
            }
            else if(is_batch_req == "No" && is_serial_req == "Yes" && is_expiry_req == "No"){
                page_title = "Serial Report";
            }

            var table = document.getElementById("docBatchSerialInfoItem");
            var workbook = new ExcelJS.Workbook();
            var worksheet = workbook.addWorksheet("Item");

            let mergeCells = [];
            let maxColumnWidths = {}; // Store max column widths

            let titleRow = worksheet.addRow([page_title]);
            titleRow.font = { bold: true, size: 16, color: { argb: "000000" } };
            titleRow.alignment = { horizontal: "center", vertical: "middle" };
            

            worksheet.mergeCells(1, 1, 1, 10); // 🔹 Merge across all columns
            // **🔹 Leave an empty row below the title**
            worksheet.addRow([]);
            worksheet.mergeCells(2, 1, 2, 3); 
            worksheet.mergeCells(2, 4, 2, 5); 
            worksheet.mergeCells(2, 6, 2, 7); 
            worksheet.mergeCells(2, 8, 2, 10); 

            worksheet.addRow([]);
            worksheet.mergeCells(3, 1, 3, 3); 
            worksheet.mergeCells(3, 4, 3, 5); 
            worksheet.mergeCells(3, 6, 3, 7); 
            worksheet.mergeCells(3, 8, 3, 10); 

            const item_code_title = worksheet.getCell(2, 3);
            const item_code_value = worksheet.getCell(2, 5);
            const item_name_title = worksheet.getCell(3, 3);
            const item_name_value = worksheet.getCell(3, 5);

            const barcode_title = worksheet.getCell(2, 7);
            const barcode_value = worksheet.getCell(2, 10);
            const category_title = worksheet.getCell(3, 7);
            const category_value = worksheet.getCell(3, 10);

            item_code_title.value = "Item Code";
            item_code_title.alignment = { horizontal: "right", vertical: "middle" };

            item_code_value.value = item_code;
            item_code_value.alignment = { horizontal: "left", vertical: "middle" };
            item_code_value.font = { bold: true};

            item_name_title.value = "Item Name";
            item_name_title.alignment = { horizontal: "right", vertical: "middle" };
            item_name_value.value = item_name;
            item_name_value.alignment = { horizontal: "left", vertical: "middle" };
            item_name_value.font = { bold: true};

            barcode_title.value = "Barcode No.";
            barcode_title.alignment = { horizontal: "right", vertical: "middle" };
            barcode_value.value = barcode;
            barcode_value.alignment = { horizontal: "left", vertical: "middle" };
            barcode_value.font = { bold: true};

            category_title.value = "Category";
            category_title.alignment = { horizontal: "right", vertical: "middle" };
            category_value.value = category;
            category_value.alignment = { horizontal: "left", vertical: "middle" };
            category_value.font = { bold: true};
            
            worksheet.addRow([]);
            worksheet.mergeCells(4, 1, 4, 10); 

            function processTableRows(tableSection, startRow, isHeader = false) {
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
                                end: { row: excelRowIndex + rowspan - 1, col: colIndex + colspan - 1 }
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

                    row.eachCell((cell, cellIndex) => {
                        // Track current position in the original HTML cells
                        let currentColIndex = 0;
                        let foundOriginalCell = null;
                        let originalCells = $(this).find("th, td");
                        
                        // Find which original cell this Excel column belongs to
                        for (let i = 0; i < originalCells.length; i++) {
                            let originalCell = $(originalCells[i]);
                            let colspan = parseInt(originalCell.attr("colspan") || 1);
                            
                            // Check if the current Excel column falls within this original cell's colspan range
                            if (cellIndex > currentColIndex && cellIndex <= currentColIndex + colspan) {
                                foundOriginalCell = originalCell;
                                break;
                            }
                            currentColIndex += colspan;
                        }
                        
                        if (foundOriginalCell) {
                            let isTh = foundOriginalCell.is("th");
                            let isTd = foundOriginalCell.is("td");
                            let colspan = parseInt(foundOriginalCell.attr("colspan") || 1);
                            
                            // Make <th> cells bold
                            if (isTh) {
                                cell.font = { bold: true, size: 12, color: { argb: "000000" } };
                                cell.fill = { type: "pattern", pattern: "solid", fgColor: { argb: "F3F4F6"}};
                            }
                            
                            // Apply header styling if this is a header row
                            if (isHeader) {
                                cell.font = { bold: true, size: 12, color: { argb: "FFFFFF" } };
                                cell.fill = { type: "pattern", pattern: "solid", fgColor: { argb: "00cfe8" } };
                                if (colspan === 1) {
                                    cell.alignment = { horizontal: "center", vertical: "middle" };
                                }
                            }
                            
                            // If no alignment was set, default to center
                            if (!cell.alignment) {
                                cell.alignment = { horizontal: "center", vertical: "middle" };
                            }
                            // Handle colspan alignment to the right
                            if (colspan > 1 && isTd) {
                                cell.style = {
                                    alignment: { horizontal: "right", vertical: "middle" },
                                    font: { bold: true, size: 12 },
                                    fill: { type: "pattern", pattern: "solid", fgColor: { argb: "F9FAFB" }}
                                };
                            }
                        } 
                        else {
                            // Default alignment if no original cell found
                            cell.alignment = { horizontal: "center", vertical: "middle" };
                        }
                    });
                    excelRowIndex++;
                });

                return excelRowIndex;
            }

            let lastRow = processTableRows($(table).find("tbody"), 5);
            processTableRows($(table).find("tfoot"), lastRow, false, true); // Handle footer

            mergeCells.forEach((cell) => {
                worksheet.mergeCells(
                    cell.start.row,
                    cell.start.col,
                    cell.end.row,
                    cell.end.col
                );
            });

            worksheet.eachRow((row) => {
                const value = row.getCell(10).value;
                var textColor = "";
                if(parseInt(value) < 0){
                    textColor = "ea5455";
                }
                else if(parseInt(value) >= 0 && parseInt(value) <= 30) {
                    textColor = "ff9f43";
                }
                else if(parseInt(value) > 30) {
                    textColor = "28c76f";
                }
                else{
                    textColor = "000000";
                }

                row.eachCell((cell) => {
                    cell.border = {
                        top: { style: "thin" },
                        left: { style: "thin" },
                        bottom: { style: "thin" },
                        right: { style: "thin" },
                    };
                    cell.font = {
                        color: { argb: textColor },
                    };
                    //cell.alignment = { horizontal: "center", vertical: "middle" };
                });
            });

            worksheet.columns.forEach((column, i) => {
                column.width = maxColumnWidths[i + 1] || 5; // **Set a default min width of 10**
            });

            workbook.xlsx.writeBuffer().then((data) => {
                var blob = new Blob([data], {
                    type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
                });
                saveAs(blob,`${page_title}_of(${item_name}).xlsx`);
            });
        });

        $(document).on('click', '#printBatchSerial', function() { 
            try {
                // Get filter values
                var item_code = $("#batch_item_code").text().trim();
                var item_name = $("#batch_item_name").text().trim();
                var barcode = $("#batch_item_barcode").text().trim();
                var category = $("#batch_item_category").text().trim();
                var uom = $("#batch_item_uom").text().trim();
                var station = $("#batch_station").text().trim();

                var is_batch_req = $("#batch_is_batch_req").text().trim();
                var is_serial_req = $("#batch_is_serial_req").text().trim();
                var is_expiry_req = $("#batch_is_expiry_date_req").text().trim();
                var page_title = "Batch, Serial & Expiry Report";

                if(is_batch_req == "Yes" && is_serial_req == "Yes" && is_expiry_req == "Yes"){
                    page_title = "Batch, Serial & Expiry Report";
                }
                else if(is_batch_req == "Yes" && is_serial_req == "Yes" && is_expiry_req == "No"){
                    page_title = "Batch & Serial Report";
                }
                else if(is_batch_req == "Yes" && is_serial_req == "No" && is_expiry_req == "No"){
                    page_title = "Batch Report";
                }
                else if(is_batch_req == "Yes" && is_serial_req == "No" && is_expiry_req == "Yes"){
                    page_title = "Batch & Expiry Report";
                }
                else if(is_batch_req == "No" && is_serial_req == "Yes" && is_expiry_req == "Yes"){
                    page_title = "Serial & Expiry Report";
                }
                else if(is_batch_req == "No" && is_serial_req == "No" && is_expiry_req == "Yes"){
                    page_title = "Expiry Report";
                }
                else if(is_batch_req == "No" && is_serial_req == "Yes" && is_expiry_req == "No"){
                    page_title = "Serial Report";
                }

                const { jsPDF } = window.jspdf;
                const doc = new jsPDF();

                const company_name = $("#info_company_name").val();
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
                });

                const companyTableEndY = doc.lastAutoTable.finalY + 1;
                const pageWidth = doc.internal.pageSize.getWidth();
                doc.line(0, companyTableEndY, pageWidth , companyTableEndY);

                const totalPagesExp = "{total_pages_count_string}";
                
                let bodyData = [];
                let colspanMap = []; // Store colspan information with column positions
                let cellStyles = []; // Store cell styling information

                // Process body data and build colspan map and styles
                $("#docBatchSerialInfoItem tbody tr").each(function (rowIndex) {
                    let rowData = [];
                    let rowColspanInfo = [];
                    let rowCellStyles = [];
                    let currentCol = 0;
                    
                    $(this).find("td, th").each(function () {
                        let text = $(this).text().trim();
                        let colspan = parseInt($(this).attr("colspan")) || 1;
                        let isTh = $(this).is("th");
                        
                        rowData.push(text);
                        
                        // Store colspan information with actual column positions
                        rowColspanInfo.push({
                            startCol: currentCol,
                            endCol: currentCol + colspan - 1,
                            colspan: colspan,
                            text: text,
                            isTh: isTh
                        });
                        
                        // Store styling information
                        rowCellStyles.push({
                            startCol: currentCol,
                            endCol: currentCol + colspan - 1,
                            colspan: colspan,
                            isTh: isTh,
                            text: text
                        });
                        
                        // Add empty cells for colspan
                        for (let i = 1; i < colspan; i++) {
                            rowData.push("");
                        }
                        
                        currentCol += colspan;
                    });
            
                    if (rowData.length > 0) {
                        bodyData.push(rowData);
                        colspanMap.push(rowColspanInfo);
                        cellStyles.push(rowCellStyles);
                    }
                });

                // Check if there's actual data
                if (bodyData.length === 0) {
                    toastrMessage('error', "No data available for the selected criteria", "Error");
                    return;
                }

                // Add title
                doc.setFontSize(14);
                doc.setFont("helvetica", "bold");
                doc.text(page_title, doc.internal.pageSize.width / 2, 35, { align: "center" });

                // Add metadata in two columns
                doc.setFontSize(8);
                let yPosition = 40;

                // Left column
                if (item_code) {
                    doc.setFont("helvetica", "normal");
                    doc.text("Item Code: ", 14, yPosition);
                    doc.setFont("helvetica", "bold");
                    doc.text(item_code, 14 + doc.getTextWidth("Item Code: "), yPosition);
                }
                yPosition += 5;

                doc.setFont("helvetica", "normal");
                doc.text("Item Name: ", 14, yPosition);
                doc.setFont("helvetica", "bold");
                doc.text(`${item_name}`, 14 + doc.getTextWidth("Item Name: "), yPosition);

                // Right column
                let rightX = doc.internal.pageSize.width - 70;
                let rightY = 40;

                if (barcode) {
                    doc.setFont("helvetica", "normal");
                    doc.text("Barcode No.: ", rightX, rightY);
                    doc.setFont("helvetica", "bold");
                    doc.text(barcode, rightX + doc.getTextWidth("Barcode No.: "), rightY);
                    rightY += 5;
                }

                if (category) {
                    doc.setFont("helvetica", "normal");
                    doc.text("Category: ", rightX, rightY);
                    doc.setFont("helvetica", "bold");
                    doc.text(category, rightX + doc.getTextWidth("Category: "), rightY);
                }

                // Set yPosition for table after both columns
                let finalYPosition = Math.max(yPosition, rightY) + 5;

                // Generate table with colspan handling and styling
                doc.autoTable({
                    body: bodyData,
                    theme: "grid",
                    startY: yPosition + 2,
                    styles: {
                        fontSize: 8,
                        cellPadding: 1.5,
                        overflow: "linebreak",
                        valign: "middle",
                        halign: "center",
                        lineWidth: 0.1,
                        lineColor: [0, 0, 0], // Black border
                        textColor: [0, 0, 0], // Black font
                        fillColor: [255, 255, 255], // White background
                    },
                    margin: { top: 1, left: 1, right: 1, bottom: 8},
                    didParseCell: function (data) {
                        // Handle colspan and styling
                        if (data.row.section === 'body' && cellStyles[data.row.index]) {
                            const value = parseFloat(data.row.raw[9]);

                            if(value < 0) {
                                data.cell.styles.textColor = hexToRgbFn('#ea5455');
                            }
                            else if(value >= 0 && value <= 30) {
                                data.cell.styles.textColor = hexToRgbFn('#ff9f43');
                            }
                            else if(value > 30) {
                                data.cell.styles.textColor = hexToRgbFn('#28c76f');
                            }

                            for (let i = 0; i < cellStyles[data.row.index].length; i++) {
                                let cellInfo = cellStyles[data.row.index][i];
                                
                                // Check if this column is the start of a merged cell
                                if (data.column.index === cellInfo.startCol) {
                                    // Apply colspan if greater than 1
                                    if (cellInfo.colspan > 1) {
                                        data.cell.colSpan = cellInfo.colspan;
                                    }
                                    
                                    // Apply styling based on cell type
                                    if (cellInfo.isTh) {
                                        if(cellInfo.colspan > 1){
                                            data.cell.styles.fontSize = 10;
                                        }
                                        else{
                                            data.cell.styles.fontSize = 8;
                                        }
                                        data.cell.styles.fontStyle = 'bold';
                                        data.cell.styles.halign = 'center';
                                        data.cell.styles.fillColor = [243, 244, 246];
                                    }
                                    
                                    // Right align for cells with colspan > 1
                                    if (cellInfo.colspan > 1 && !cellInfo.isTh) {
                                        data.cell.styles.fontSize = 9;
                                        data.cell.styles.fontStyle = 'bold';
                                        data.cell.styles.halign = 'right';
                                        data.cell.styles.fillColor = [249, 250, 251];
                                    }                                    
                                    break;
                                }
                            }
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

                if (typeof doc.putTotalPages === 'function') {
                    doc.putTotalPages(totalPagesExp);
                }

                const blob = doc.output("blob");
                const blobUrl = URL.createObjectURL(blob);

                // Open blank popup first
                const printWindow = window.open('about:blank', '_blank', 'width=1400,height=800,top=100,left=100');

                if (printWindow) {
                    // Create iframe inside the blank popup
                    printWindow.document.write(`<iframe style="width:100%;height:100%;" src="${blobUrl}"></iframe>`);
                    printWindow.document.close();
                    
                    // Auto-print when iframe loads
                    printWindow.onload = function() {
                        setTimeout(function() {
                            const iframe = printWindow.document.querySelector('iframe');
                            if (iframe) {
                                iframe.onload = function() {
                                    setTimeout(function() {
                                        iframe.contentWindow.print();
                                    }, 500);
                                };
                            }
                        }, 500);
                    };
                    
                    // Clean up
                    setTimeout(function() {
                        URL.revokeObjectURL(blobUrl);
                    }, 10000);
                } else {
                    toastrMessage('error', "Please allow popups!", "Error");
                }
                
            } catch (error) {
                console.error("PDF Generation Error:", error);
                toastrMessage('error', "Error generating PDF: " + error.message, "Error");
            }
        });

        $(document).on('click', '#exportPdfBatchSerial', function() { 
            try {
                // Get filter values
                var item_code = $("#batch_item_code").text().trim();
                var item_name = $("#batch_item_name").text().trim();
                var barcode = $("#batch_item_barcode").text().trim();
                var category = $("#batch_item_category").text().trim();
                var uom = $("#batch_item_uom").text().trim();
                var station = $("#batch_station").text().trim();

                var is_batch_req = $("#batch_is_batch_req").text().trim();
                var is_serial_req = $("#batch_is_serial_req").text().trim();
                var is_expiry_req = $("#batch_is_expiry_date_req").text().trim();
                var page_title = "Batch, Serial & Expiry Report";

                if(is_batch_req == "Yes" && is_serial_req == "Yes" && is_expiry_req == "Yes"){
                    page_title = "Batch, Serial & Expiry Report";
                }
                else if(is_batch_req == "Yes" && is_serial_req == "Yes" && is_expiry_req == "No"){
                    page_title = "Batch & Serial Report";
                }
                else if(is_batch_req == "Yes" && is_serial_req == "No" && is_expiry_req == "No"){
                    page_title = "Batch Report";
                }
                else if(is_batch_req == "Yes" && is_serial_req == "No" && is_expiry_req == "Yes"){
                    page_title = "Batch & Expiry Report";
                }
                else if(is_batch_req == "No" && is_serial_req == "Yes" && is_expiry_req == "Yes"){
                    page_title = "Serial & Expiry Report";
                }
                else if(is_batch_req == "No" && is_serial_req == "No" && is_expiry_req == "Yes"){
                    page_title = "Expiry Report";
                }
                else if(is_batch_req == "No" && is_serial_req == "Yes" && is_expiry_req == "No"){
                    page_title = "Serial Report";
                }

                const { jsPDF } = window.jspdf;
                const doc = new jsPDF();

                const company_name = $("#info_company_name").val();
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
                });

                const companyTableEndY = doc.lastAutoTable.finalY + 1;
                const pageWidth = doc.internal.pageSize.getWidth();
                doc.line(0, companyTableEndY, pageWidth , companyTableEndY);

                const totalPagesExp = "{total_pages_count_string}";
                
                let bodyData = [];
                let colspanMap = []; // Store colspan information with column positions
                let cellStyles = []; // Store cell styling information

                // Process body data and build colspan map and styles
                $("#docBatchSerialInfoItem tbody tr").each(function (rowIndex) {
                    let rowData = [];
                    let rowColspanInfo = [];
                    let rowCellStyles = [];
                    let currentCol = 0;
                    
                    $(this).find("td, th").each(function () {
                        let text = $(this).text().trim();
                        let colspan = parseInt($(this).attr("colspan")) || 1;
                        let isTh = $(this).is("th");
                        
                        rowData.push(text);
                        
                        // Store colspan information with actual column positions
                        rowColspanInfo.push({
                            startCol: currentCol,
                            endCol: currentCol + colspan - 1,
                            colspan: colspan,
                            text: text,
                            isTh: isTh
                        });
                        
                        // Store styling information
                        rowCellStyles.push({
                            startCol: currentCol,
                            endCol: currentCol + colspan - 1,
                            colspan: colspan,
                            isTh: isTh,
                            text: text
                        });
                        
                        // Add empty cells for colspan
                        for (let i = 1; i < colspan; i++) {
                            rowData.push("");
                        }
                        
                        currentCol += colspan;
                    });
            
                    if (rowData.length > 0) {
                        bodyData.push(rowData);
                        colspanMap.push(rowColspanInfo);
                        cellStyles.push(rowCellStyles);
                    }
                });

                // Check if there's actual data
                if (bodyData.length === 0) {
                    toastrMessage('error', "No data available for the selected criteria", "Error");
                    return;
                }

                // Add title
                doc.setFontSize(14);
                doc.setFont("helvetica", "bold");
                doc.text(page_title, doc.internal.pageSize.width / 2, 35, { align: "center" });

                // Add metadata in two columns
                doc.setFontSize(8);
                let yPosition = 40;

                // Left column
                if (item_code) {
                    doc.setFont("helvetica", "normal");
                    doc.text("Item Code: ", 14, yPosition);
                    doc.setFont("helvetica", "bold");
                    doc.text(item_code, 14 + doc.getTextWidth("Item Code: "), yPosition);
                }
                yPosition += 5;

                doc.setFont("helvetica", "normal");
                doc.text("Item Name: ", 14, yPosition);
                doc.setFont("helvetica", "bold");
                doc.text(`${item_name}`, 14 + doc.getTextWidth("Item Name: "), yPosition);

                // Right column
                let rightX = doc.internal.pageSize.width - 70;
                let rightY = 40;

                if (barcode) {
                    doc.setFont("helvetica", "normal");
                    doc.text("Barcode No.: ", rightX, rightY);
                    doc.setFont("helvetica", "bold");
                    doc.text(barcode, rightX + doc.getTextWidth("Barcode No.: "), rightY);
                    rightY += 5;
                }

                if (category) {
                    doc.setFont("helvetica", "normal");
                    doc.text("Category: ", rightX, rightY);
                    doc.setFont("helvetica", "bold");
                    doc.text(category, rightX + doc.getTextWidth("Category: "), rightY);
                }

                // Set yPosition for table after both columns
                let finalYPosition = Math.max(yPosition, rightY) + 5;

                // Generate table with colspan handling and styling
                doc.autoTable({
                    body: bodyData,
                    theme: "grid",
                    startY: yPosition + 2,
                    styles: {
                        fontSize: 8,
                        cellPadding: 1.5,
                        overflow: "linebreak",
                        valign: "middle",
                        halign: "center",
                        lineWidth: 0.1,
                        lineColor: [0, 0, 0], // Black border
                        textColor: [0, 0, 0], // Black font
                        fillColor: [255, 255, 255], // White background
                    },
                    margin: { top: 1, left: 1, right: 1, bottom: 8},
                    didParseCell: function (data) {
                        // Handle colspan and styling
                        if (data.row.section === 'body' && cellStyles[data.row.index]) {
                            const value = parseFloat(data.row.raw[9]);

                            if(value < 0) {
                                data.cell.styles.textColor = hexToRgbFn('#ea5455');
                            }
                            else if(value >= 0 && value <= 30) {
                                data.cell.styles.textColor = hexToRgbFn('#ff9f43');
                            }
                            else if(value > 30) {
                                data.cell.styles.textColor = hexToRgbFn('#28c76f');
                            }

                            for (let i = 0; i < cellStyles[data.row.index].length; i++) {
                                let cellInfo = cellStyles[data.row.index][i];
                                
                                // Check if this column is the start of a merged cell
                                if (data.column.index === cellInfo.startCol) {
                                    // Apply colspan if greater than 1
                                    if (cellInfo.colspan > 1) {
                                        data.cell.colSpan = cellInfo.colspan;
                                    }
                                    
                                    // Apply styling based on cell type
                                    if (cellInfo.isTh) {
                                        if(cellInfo.colspan > 1){
                                            data.cell.styles.fontSize = 10;
                                        }
                                        else{
                                            data.cell.styles.fontSize = 8;
                                        }
                                        data.cell.styles.fontStyle = 'bold';
                                        data.cell.styles.halign = 'center';
                                        data.cell.styles.fillColor = [243, 244, 246];
                                    }
                                    
                                    // Right align for cells with colspan > 1
                                    if (cellInfo.colspan > 1 && !cellInfo.isTh) {
                                        data.cell.styles.fontSize = 9;
                                        data.cell.styles.fontStyle = 'bold';
                                        data.cell.styles.halign = 'right';
                                        data.cell.styles.fillColor = [249, 250, 251];
                                    }                                    
                                    break;
                                }
                            }
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

                // Save PDF
                doc.save(`${page_title}_of(${item_name}).pdf`);
                
            } catch (error) {
                console.error("PDF Generation Error:", error);
                toastrMessage('error', "Error generating PDF: " + error.message, "Error");
            }
        });

        function hexToRgbFn(hex) {
            hex = hex.replace('#', '');
            const r = parseInt(hex.substring(0, 2), 16);
            const g = parseInt(hex.substring(2, 4), 16);
            const b = parseInt(hex.substring(4, 6), 16);
            return [r, g, b];
        }
        //-----------------End Print & Export-----------------

        function refreshtbl(){
            stockbaltable.ajax.reload(function() {
                unblockPage(cardSection);
            }, false); 
        }

        function closeInfoModal(){
            //var tabletr = $('#stockbalancedatatable').DataTable(); tabletr.search('');
            var oTable = $('#stockbalancedatatable').dataTable(); 
            oTable.fnDraw(false);
        }

        function numformat(val){
            while (/(\d+)(\d{3})/.test(val.toString())){
                val = val.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
            }
            return val;
        }

        function opendetailmod(itemid,storeid,qtydel){
            if(parseFloat(qtydel) <= 0){
                toastrMessage('error',"There is no quantity on delivery","Error");
            }
            else if(parseFloat(qtydel) > 0){
                var uom = $('#uom_shipping').val();
                $('#quantityondeliverytbl').DataTable({
                    destroy: true,
                    processing: true,
                    serverSide: true,
                    searchHighlight: true,
                    "order": [[ 1, "asc" ]],
                    "pagingType": "simple",
                    language: { 
                        search: '', 
                        searchPlaceholder: "Search here"
                    },
                    deferRender: true,
                    autoWidth: false,
                    info: false,
                    length: false,
                    paging: false,
                    dom: "<'row'<'col-sm-3 col-md-2 col-4 pr-0 mr-0'f><'col-sm-4 col-md-2 col-4 mt-1 pr-0 mr-0'><'col-sm-4 col-md-2 col-4 mt-1'>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-4 col-md-4 col-4'l><'col-sm-4 col-md-4 col-4 d-flex justify-content-center'i><'col-sm-4 col-md-4 col-4 d-flex justify-content-end'p>>",
                    ajax: {
                        headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '/showdeliveredqty/'+itemid+'/'+storeid,
                        type: 'DELETE',
                        dataType: "json",
                    },
                    columns: [
                        { data: 'DT_RowIndex',width:"3%"},
                        { data: 'SourceStoreName', name: 'SourceStoreName',width:"14%"},
                        { data: 'StoreName', name: 'StoreName',width:"14%"},
                        { data: 'DocumentNumber', name: 'DocumentNumber',
                            "render": function ( data, type, row, meta ) {
                                return `<a style="text-decoration:underline;color:blue;" onclick=opentrdoc("${row.TransferId}")>${data}</a>`;
                            },
                            width:"15%" 
                        },
                        { data: 'IssueDoc', name: 'IssueDoc',
                            "render": function ( data, type, row, meta ) {
                                return `<a style="text-decoration:underline;color:blue;" onclick=openissdoc("${row.IssuesIds}")>${data}</a>`;
                            },
                            width:"15%" 
                        },
                        { data: 'DeliveredBy', name: 'DeliveredBy',width:"13%"},
                        { data: 'DeliveredDate', name: 'DeliveredDate',width:"13%"},
                        { data: 'ShipmentQuantity', name: 'ShipmentQuantity',
                            "render": function ( data, type, row, meta ) {
                                return `${data} ${uom}`;
                            },
                            width:"13%"
                        },
                        { data: 'ShipmentQuantity', name: 'ShipmentQuantity','visible': false},
                        { data: 'IssuesIds', name: 'IssuesIds','visible': false},
                        { data: 'TransferId', name: 'TransferId','visible': false},
                    ],
                    "footerCallback": function (row,data,start,end,display) {
                        var api = this.api(),data;
                        var intVal = function ( i ) {
                            return typeof i === 'string' ?
                                i.replace(/[\$,]/g, '')*1 :
                                typeof i === 'number' ?
                                    i : 0;
                        };
                        var totaldelonqty = api
                            .column(7)
                            .data()
                            .reduce( function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0 );
                            $('#totaldeliveredqty').html(`${totaldelonqty === 0 ? '' : numformat(parseFloat(totaldelonqty))} ${uom}`);
                    },
                });
                $('#deliveryqtymodal').modal('show'); 
                $(".infoshipping").collapse('show');
            }
            else{
                toastrMessage('error',"There is no quantity on delivery","Error");
            }
        }

        $(document).on('show.bs.collapse hide.bs.collapse', '.stbalance', function (e) {
            e.stopPropagation();
            const collapse = $(this);
            const container = collapse.closest('.card, .modal-content, .row');
            const infoTarget = container.find('.stockbalance_header_info');
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
                const item_code = container.find('.itemcodeval').text().trim();
                const item_name = container.find('.itemnameval').text().trim();
                const summaryHtml = `
                    Item Code: <b>${item_code}</b>,
                    Item Name: <b>${item_name}</b>`;
                infoTarget.html(summaryHtml);
            }
        });

        $(document).on('show.bs.collapse hide.bs.collapse', '.stbalance-shipping', function (e) {
            e.stopPropagation();
            const collapse = $(this);
            const container = collapse.closest('.card, .modal-content, .row');
            const infoTarget = container.find('.shipping_header_info');
            const collapseId = collapse.attr('id');
            const trigger = $(`[data-target="#${collapseId}"], [data-bs-target="#${collapseId}"]`);

            const isOpening = e.type === 'show';

            $('.toggle-text-label-shipping').html(isOpening ? 'Collapse' : 'Expand');
            $('.collapse-icon-shipping').html(isOpening ? '<i class="fas text-secondary fa-minus-circle"></i>' : '<i class="fas text-secondary fa-plus-circle"></i>');

            if (isOpening) {
                const originalHeader = `<i class="far fa-info-circle"></i> Basic Information`;
                infoTarget.html(originalHeader);
            } 
            else {
                // Section is COLLAPSING: Show the data summary
                const item_code = container.find('.itemcodeval').text().trim();
                const item_name = container.find('.itemnameval').text().trim();
                const summaryHtml = `
                    Item Code: <b>${item_code}</b>,
                    Item Name: <b>${item_name}</b>`;
                infoTarget.html(summaryHtml);
            }
        });

        $(document).on('show.bs.collapse hide.bs.collapse', '.batch_coll', function (e) {
            e.stopPropagation();
            const collapse = $(this);
            const container = collapse.closest('.card, .modal-content, .row');
            const infoTarget = container.find('.batch_serial_item_header_info');
            const collapseId = collapse.attr('id');
            const trigger = $(`[data-target="#${collapseId}"], [data-bs-target="#${collapseId}"]`);

            const isOpening = e.type === 'show';

            $('.toggle-text-label').html(isOpening ? 'Collapse' : 'Expand');
            $('.collapse-icon').html(isOpening ? '<i class="fas text-secondary fa-minus-circle"></i>' : '<i class="fas text-secondary fa-plus-circle"></i>');

            if(isOpening) {
                const originalHeader = `<i class="far fa-info-circle"></i> Basic Information`;
                infoTarget.html(originalHeader);
            } 
            else{
                // Section is COLLAPSING: Show the data summary
                const item_code = container.find('.itemcodeval').text().trim();
                const item_name = container.find('.itemnameval').text().trim();
                const summaryHtml = `
                    Item Code: <b>${item_code}</b>,
                    Item Name: <b>${item_name}</b>`;
                infoTarget.html(summaryHtml);
            }
        });

        function opentrdoc(trid){
            var link = "/tr/" + trid;
            window.open(link, 'Transfer', 'width=1200,height=800,scrollbars=yes');
        }

        function openissdoc(issid){
            var link = "/isstr/" + issid;
            window.open(link, 'Issue', 'width=1200,height=800,scrollbars=yes');
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