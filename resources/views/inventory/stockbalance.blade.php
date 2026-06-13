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
                                                        <th style="width: 29%">Waiting for Delivery</th>
                                                        <th style="width: 3%"></th>
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
                                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mt-1 mb-1">
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
                                                                </table>
                                                            </div>
                                                            <div class="col-xl-6 col-lg-6 col-md-5 col-sm-5 col-12">
                                                                <table class="infotbl mb-0" style="width:100%;font-size:12px;">
                                                                    <tr>
                                                                        <td><label class="info_lbl">Category</label></td>
                                                                        <td><label class="info_lbl categoryval" style="font-weight: bold;"></label></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label class="info_lbl" title="Unit of Measurement">UOM</label></td>
                                                                        <td><label class="info_lbl uomval" id="uom_lbl" style="font-weight: bold;"></label></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label class="info_lbl" title="Is Batch Number Required">Is Batch No. Req.</label></td>
                                                                        <td><label class="info_lbl is_batch_req" id="is_batch_req" style="font-weight: bold;"></label></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label class="info_lbl" title="Is Serial Number Required">Is Serial No. Req.</label></td>
                                                                        <td><label class="info_lbl is_serial_req" id="is_serial_req" style="font-weight: bold;"></label></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label class="info_lbl" title="Is Expiry Date Required">Is Expiry Date Req.</label></td>
                                                                        <td><label class="info_lbl is_expiry_date_req" id="is_expiry_date_req" style="font-weight: bold;"></label></td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mt-1 mb-1">
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

                                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mt-1 mb-1">
                                                <div class="card shadow-none border m-0">
                                                    <div class="card-body">
                                                        <h6 class="card-title mb-0"><i class="fas fa-tags"></i> Others</h6>
                                                        <hr class="my-50">
                                                        <table class="infotbl" style="width:100%;font-size:12px;">
                                                            <tr>
                                                                <td><label class="info_lbl">Station</label></td>
                                                                <td><label class="info_lbl station_lbl" style="font-weight: bold;"></label></td>
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
                                    <table id="docBatchSerialInfoItem" class="display table-bordered table-striped dt-responsive defaultdatatable mb-0 info_datatable receiving_item_dt" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th style="width: 3%">#</th>
                                                <th style="width: 15%"><i class="fas fa-info-circle" title="Country, manufacturer, brand"></i> Brand</th>
                                                <th style="width: 12%">Generic/ Model</th>
                                                <th style="width: 12%" title="Batch Number">Batch No.</th>
                                                <th style="width: 20%" title="Serial Number">Serial No.</th>
                                                <th style="width: 8%" title="Available Quantity">Available Qty.</th>
                                                <th style="width: 10%">Manufacturing Date</th>
                                                <th style="width: 10%">Expiry Date</th>
                                                <th style="width: 10%">Remaining Day</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table table-sm"></tbody>
                                        <tfoot class="table table-sm">
                                            <th colspan="5" style="text-align: right">Total</th>
                                            <th id="total_avialable_qty"></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="closebuttonserial" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!--End batch serial modal -->

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
                    var allblance = parseFloat(balance)-parseFloat(pendingbalance);
                    if(parseFloat(minstock) > 0){
                        var maxc = parseFloat(allblance)-parseFloat(minstock);
                        maximum = maxc >= 0 ? maxc : 0;
                    }
                    var minimumstock = aData.MinimumStock > 0 ? aData.MinimumStock : 0;    
                    var avquantity = aData.AvailableQuantity > 0 ? aData.AvailableQuantity : 0;  
                    var wholesalefeaturetable = $('#wholesalefeaturetable').val();

                    if(wholesalefeaturetable == 0){
                        api.column(8).visible(false);
                        api.column(9).visible(false);
                        api.column(10).visible(false);
                        if (parseFloat(allblance) <= 0 || parseFloat(avquantity) <= 0) {
                            $(nRow).find('td:eq(6)').css({"text-decoration": "line-through","text-decoration-color": "red"});
                        }

                        if (aData.StockPr == 1 && aData.StockAv == 1) {
                            $(nRow).find('td:eq(7)').css({"font-weight": "bold"});
                        } 
                        else if (aData.StockPr == 0 && aData.StockAv == 1) {
                            $(nRow).find('td:eq(7)').css({"font-weight": "bold"});
                        }
                        else if (aData.StockPr == 0 && aData.StockAv == 0) {
                            $(nRow).find('td:eq(7)').css({"font-weight": "bold"});
                        }  
                    }
                    if(wholesalefeaturetable == 1){
                        api.column(8).visible(true);
                        api.column(9).visible(true);
                        api.column(10).visible(true);

                        if(parseFloat(allblance) < parseFloat(minimumstock) || parseFloat(maximum)<parseFloat(minamount)|| parseFloat(allblance)<=0 ||parseFloat(maximum)<=0|| parseFloat(allblance)<parseFloat(minamount)){
                            
                            $(nRow).find('td:eq(8)').css({"text-decoration": "line-through","text-decoration-color": "red"});
                            $(nRow).find('td:eq(9)').css({"text-decoration": "line-through","text-decoration-color": "red"});
                            $(nRow).find('td:eq(10)').css({"text-decoration": "line-through","text-decoration-color": "red"});
                        }
                        if (aData.StockPr == 1 && aData.StockAv == 1) {
                            $(nRow).find('td:eq(10)').css({"font-weight": "bold"});
                        } 
                        else if (aData.StockPr == 0 && aData.StockAv == 1) {
                            $(nRow).find('td:eq(10)').css({"font-weight": "bold"});
                        }
                        else if (aData.StockPr == 0 && aData.StockAv == 0) {
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
                dom: "<'row'<'col-sm-3 col-md-2 col-4 pr-0 mr-0'f><'col-sm-4 col-md-2 col-4 mt-1 pr-0 mr-0'><'col-sm-4 col-md-2 col-4 mt-1'>>" +
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
                    { data: null,
                        "render": function (data, type, row, meta) {
                            if(parseInt(batch_serial_fl) == 1){
                                return `<div class="text-center">
                                            <a 
                                                class="viewsernum" 
                                                href="javascript:void(0)" 
                                                onclick="viewBatchSerialExpireFn(${row.StoreId},${row.ItemId})" 
                                                data-id="viewsernum${row.StoreId}" 
                                                id="viewsernum${row.StoreId}" 
                                                title="View batch number, serial number, expiry date for ${row.ItemName} item!">
                                                <i class="fa-sharp fa-regular fa-circle-info fa-xl" style="color: #00cfe8;"></i>
                                            </a>
                                        </div>`;
                            }
                            else{
                                return "";
                            }
                        },
                        width:"3%"
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

                    if(minumumstock > 0){
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
        }

        //-------------------Start batch serial-----------------
        function viewBatchSerialExpireFn(store_id,item_id){
            var str_id = null;
            var itm_id = null;
            $.ajax({
                url: '/fetchItemAndStore', 
                type: 'POST',
                data:{
                    str_id: store_id,
                    itm_id: item_id,
                },
                beforeSend: function() {
                    blockPage(cardSection, 'Fetching batch and/or serial numbers data...');
                },
                success: async function(data) {
                    $('.batch_serial_item_header_info').html(`Item Code: <b>${data.item_code}</b>, Item Name: <b>${data.item_name}</b>, Station: <b>${data.store_name}</b>`);
                    $(".station_lbl").text(data.store_name);
                    await getItemBatchSerialNumFn(store_id,item_id);
                },
                error: function () {
                    unblockPage(cardSection);
                }
            });

            $(".batch_serial_collapse").collapse('hide');
            $('#serialBatchModal').modal('show'); 
        }

        function getItemBatchSerialNumFn(store_id,item_id){
            batchSerialIndex = -1;
            var str_id = null;
            var itm_id = null;
            var warning_date = 30;
            var visibility_flag = true;
            var column_index = [];
            var is_batch_req = $(".is_batch_req").text().trim();
            var is_exp_date_req = $(".is_expiry_date_req").text().trim();
            var is_serial_num_req = $(".is_serial_req").text().trim();
            
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
                "order": [[ 7, "asc" ]],
                language: { 
                    search: '', 
                    searchPlaceholder: "Search here"
                },
                autoWidth: false,
                deferRender: true,
                dom: "<'row'<'col-sm-6 col-md-6 col-6 ml-0'f><'col-sm-6 col-md-6 col-6 mt-2 d-flex justify-content-end'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-4 col-md-4 col-4'l><'col-sm-4 col-md-4 col-4 d-flex justify-content-center'i><'col-sm-4 col-md-4 col-4 d-flex justify-content-end'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/fetchBatchSerialData',
                    type: 'POST',
                    data:{
                        str_id: store_id,
                        itm_id: item_id,
                    },
                    complete: function () { 
                        setFocusInfoTable('#docBatchSerialInfoItem');
                    },
                },
                columns: [{
                        data:'DT_RowIndex',
                        width:'3%',
                    },
                    {
                        data: 'brand_name',
                        name: 'brand_name',
                        width:'15%',
                    },
                    {
                        data: 'model_name',
                        name: 'model_name',
                        width:'12%',
                    },
                    {
                        data: 'batch_number',
                        name: 'batch_number',
                        width:'12%',
                    },
                    {
                        data: 'serial_numbers',
                        name: 'serial_numbers',
                        width:'20%',
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
                        width:'10%',
                    },
                    {
                        data: 'remaining_day',
                        name: 'remaining_day',
                        width:'10%',
                        render: $.fn.dataTable.render.number(',', '.',0, '')
                    }, 
                ],
                "columnDefs": [{
                    "targets": column_index,
                    "visible": visibility_flag,
                }],
                "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    var remaining_date = aData.remaining_day;
                    if(parseInt(remaining_date) < 0) {
                        for(var i = 0;i <= 8;i++){
                            $(nRow).find(`td:eq(${i})`).css({"color":"#ea5455"});
                        }
                    } 
                    else if(parseInt(remaining_date) >= 0 && parseInt(remaining_date) <= 30){
                        for(var i = 0;i <= 8;i++){
                            $(nRow).find(`td:eq(${i})`).css({"color":"#ff9f43"});
                        }
                    }
                    else if(parseInt(remaining_date) > 30){
                        for(var i = 0;i <= 8;i++){
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
                        .column(5)
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    $('#total_avialable_qty').html(`${numformat(parseFloat(total || 0))}`);
                },
                "initComplete": function(settings, json) {
                    unblockPage(cardSection);
                },
            });
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
                const station_name = container.find('.station_lbl').text().trim();
                const summaryHtml = `
                    Item Code: <b>${item_code}</b>,
                    Item Name: <b>${item_name}</b>
                    Station: <b>${station_name}</b>`;
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
    </script>   
@endsection