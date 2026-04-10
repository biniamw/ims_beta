@extends('layout.app1')
@section('title')
@endsection
@section('content')
    @can('DS-Balance-View')
        <div class="app-content content">
            <section id="responsive-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-bottom fit-content mb-0 pb-0">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align: left !important;align-items: center;padding: 10px 5px;">
                                            <h3 class="card-title form_title">Direct Stock Balance</h3>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align: right !important;align-items: center;padding: 10px 5px;">
                                            <button type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm" onclick="refreshDSBalanceFn()"><i class="fas fa-sync-alt"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-datatable">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="row main_datatable fit-content" id="dsbalance_tbl">
                                        <div style="width:99%; margin-left:0.5%;"> 
                                            <table id="laravel-datatable-crud" class="display table-bordered table-striped table-hover defaultdatatable mb-0 mobile-dt" style="width: 100%">
                                                <thead>
                                                    <tr>
                                                        <th style="display: none;"></th>
                                                        <th style="width: 3%;">#</th>
                                                        <th style="width: 9%;">Item Type</th>
                                                        <th style="width: 9%;">Item Code</th>
                                                        <th style="width: 20%;">Item Name</th>
                                                        <th style="width: 14%;" title="Barcode Number">Barcode No.</th>
                                                        <th style="width: 11%;">Category</th>
                                                        <th style="width: 8%;" title="Unit of Measurement">UOM</th>
                                                        <th style="width: 11%;">Selling Price</th>
                                                        <th style="width: 11%;" title="Available Quantity">Available Qty.</th>
                                                        <th style="width: 4%;">Action</th>
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
        </div>
    @endcan

    <!--Start Info Modal -->
    <div class="modal fade text-left fit-content" id="dsBalanceInfoModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style=" overflow-y: scroll;">
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
                                            <h5 class="mb-0 form_title dstockbalance_header_info"><i class="far fa-info-circle"></i> Basic Information</h5>
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
                                                                    <td><label class="info_lbl itemnameval" id="main_itemname" style="font-weight: bold;"></label></td>
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
                                                                    <td><label class="info_lbl">Selling Price</label></td>
                                                                    <td><label class="info_lbl sellingpricecls" id="selling_price_inp" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl" title="Minimum Cost">Min Cost</label></td>
                                                                    <td><label class="info_lbl minimumcostcls" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl" title="Average Cost">Average Cost</label></td>
                                                                    <td><label class="info_lbl averagecostcls" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl" title="Maximum Cost">Max Cost</label></td>
                                                                    <td><label class="info_lbl maxcostcls" style="font-weight: bold;"></label></td>
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
                                                <table id="dsBalanceDatatable" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable mb-0" style="width: 100%;">
                                                    <thead>
                                                        <th style="width: 3%">#</th>
                                                        <th style="width: 35%">Station</th>
                                                        <th style="width: 30%" title="Available Quantity">Available Qty.</th>
                                                        <th style="width: 32%" title="Allocated Quantity">Allocated Qty.</th>
                                                    </thead>
                                                    <tbody class="table table-sm"></tbody>
                                                    <tfoot class="table table-sm">
                                                        <td style="text-align: right;font-size: 12px;font-weight:bold;" colspan="2">
                                                            <label id="avlbl" style="font-size: 12px;">Total</label>
                                                        </td>
                                                        <td>
                                                            <label id="total_available_qty" style="font-size: 12px;font-weight: bold;"></label>
                                                        </td>
                                                        <td>
                                                            <label id="total_allocated_qty" style="font-size: 12px;font-weight: bold;"></label>
                                                        </td>
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
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align:left">
                                    <div class="btn-group dropup">
                                        <button type="button" class="btn btn-outline-info dropdown-toggle hide-arrow action-btn form_btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa-sharp fa-solid fa-caret-up fa-xl"></i><span class="btn-text">&nbsp Actions</span>
                                        </button>
                                        <ul class="dropdown-menu" id="dstockbalance_action_ul"></ul>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align:right">
                                    <input type="hidden" class="form-control" name="uom_inp" id="uom_inp" readonly="true">
                                    <button id="closebuttonk" type="button" class="btn btn-danger form_btn" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Info -->

    <!--Start allocation modal -->
    <div class="modal modal-slide-in event-sidebar fade fit-content" id="allocationmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <form id="allocationform">
        @csrf
            <div class="modal-dialog modal-xl" role="document" style="width: 96%;">
                <div class="modal-content p-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #ea5455 !important;font-weight:bold;">x</button>
                    <div class="modal-header mb-1">
                        <h4 class="modal-title form_title">Allocation Information</h4>
                    </div>
                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3 scrdivhor scrollhor">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <section id="alloc_item_info">
                                        <div class="d-flex justify-content-between align-items-center cursor-pointer border-bottom" data-toggle="collapse" data-target=".infoalloc" aria-expanded="true">
                                            <h5 class="mb-0 form_title alloc_header_info"><i class="far fa-info-circle"></i> Basic Information</h5>
                                            <div class="d-flex align-items-center header-tab">
                                                <span class="text-uppercase font-weight-bold mr-50 toggle-text-label-alloc tab-text">Collapse</span>
                                                <div class="collapse-icon-alloc">
                                                    <i class="fas text-secondary fa-minus-circle"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="collapse stbalance-alloc show infoalloc shadow pl-1 pr-1">
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
                                                                    <td><label class="info_lbl uomval" id="uom_alloc" style="font-weight: bold;"></label></td>
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
                                                                    <td><label class="info_lbl">Selling Price</label></td>
                                                                    <td><label class="info_lbl sellingpricecls" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl" title="Minimum Cost">Min Cost</label></td>
                                                                    <td><label class="info_lbl minimumcostcls" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl" title="Average Cost">Average Cost</label></td>
                                                                    <td><label class="info_lbl averagecostcls" style="font-weight: bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl" title="Maximum Cost">Max Cost</label></td>
                                                                    <td><label class="info_lbl maxcostcls" style="font-weight: bold;"></label></td>
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
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="alloc_item_div">
                                                <table id="allocationdetailtbl" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable mb-0" style="width:100%;">
                                                    <thead>
                                                        <th style="width: 3%">#</th>
                                                        <th style="width: 12%">Record Type</th>
                                                        <th style="width: 12%" title="Direct Stock Type">DS Type</th>
                                                        <th style="width: 14%">Source Station</th>
                                                        <th style="width: 14%">Destination Station</th>
                                                        <th style="width: 14%" title="Document Number">Document No.</th>
                                                        <th style="width: 10%">Date</th>
                                                        <th style="width: 10%">Quantity</th>
                                                        <th style="width: 10%">Status</th>
                                                    </thead>
                                                    <tbody class="table table-sm"></tbody>
                                                    <tfoot class="table table-sm">
                                                        <td colspan="7" style="padding-right: 2px !important;text-align:right;font-weight: bold;">Total</td>
                                                        <td><label id="total_allocated_qty_detail" style="font-weight: bold;"></label></td>
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
                        <button id="closebuttonalloc" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- End allocation modal -->

    <!--Start selling price modal -->
    <div class="modal fade text-left fit-content" id="sellingPrModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel34" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title form_title">Edit Selling Price</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="Register">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                <table class="infotbl" style="width:100%;font-size:12px;">
                                    <tr>
                                        <td><label class="info_lbl">Current Selling Price</label></td>
                                        <td><label class="info_lbl sellingpricecls" style="font-weight: bold;"></label></td>
                                    </tr>
                                    <tr>
                                        <td><label class="info_lbl" title="Minimum Cost">Min Cost</label></td>
                                        <td><label class="info_lbl minimumcostcls" style="font-weight: bold;"></label></td>
                                    </tr>
                                    <tr>
                                        <td><label class="info_lbl" title="Average Cost">Average Cost</label></td>
                                        <td><label class="info_lbl averagecostcls" style="font-weight: bold;"></label></td>
                                    </tr>
                                    <tr>
                                        <td><label class="info_lbl" title="Maximum Cost">Max Cost</label></td>
                                        <td><label class="info_lbl maxcostcls" style="font-weight: bold;"></label></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <hr class="my-50">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                <label class="form_lbl">Selling Price<b style="color: red; font-size:16px;">*</b></label>
                                <input type="text" placeholder="Write selling price here..." class="form-control reg_form" name="SellingPrice" id="SellingPrice" onkeyup="sellingPriceFn()"/>
                                <span class="text-danger">
                                    <strong class="errordatalabel" id="price-error"></strong>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control reg_form" name="itemId" id="itemId">
                        <button id="updatebtn" type="button" class="btn btn-info form_btn">Update</button>
                        <button id="closebutton_selling_pr" type="button" class="btn btn-danger form_btn" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End selling price modal -->

    @include('layout.universal-component')

    <script  type="text/javascript">
        var errorcolor = "#ffcccc";
        $(function () {
            cardSection = $('#page-block');
        });

        var table = "";
        var globalIndex = -1;

        $(document).ready(function() {
            $('.main_datatable').hide(); 
            fetchDSBalanceDataFn();
            appendDStockBalanceFilterFn();
        });

        function fetchDSBalanceDataFn(){
            table = $('#laravel-datatable-crud').DataTable({
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
                dom: "<'row'<'col-sm-3 col-md-2 col-6'f><'col-sm-3 col-md-2 col-6 mt-1 dsbcustom-1'><'col-sm-3 col-md-2 col-6 mt-1 dsbcustom-2'><'col-sm-3 col-md-2 col-6 mt-1 dsbcustom-3'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-4 col-md-4 col-4'l><'col-sm-4 col-md-4 col-4 d-flex justify-content-center'i><'col-sm-4 col-md-4 col-4 d-flex justify-content-end'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/getDSBalanceData',
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
                        data: 'Type',
                        name: 'Type',
                        width:"9%"
                    },
                    {
                        data: 'ItemCode',
                        name: 'ItemCode',
                        width:"9%"
                    },
                    {
                        data: 'ItemName',
                        name: 'ItemName',
                        width:"20%"
                    },
                    {
                        data: 'SKUNumber',
                        name: 'SKUNumber',
                        width:"14%"
                    },
                    {
                        data: 'Category',
                        name: 'Category',
                        width:"11%"
                    },
                    {
                        data: 'UOM',
                        name: 'UOM',
                        width:"8%"
                    },
                    {
                        data: 'SellingPrice',
                        name: 'SellingPrice',
                        render: $.fn.dataTable.render.number(',','.',0,''),
                        width:"11%"
                    },
                    {
                        data: 'NetBalance',
                        name: 'NetBalance',
                        render: $.fn.dataTable.render.number(',','.',0,''),
                        width:"11%"
                    },
                    { 
                        data: 'action', 
                        name: 'action',
                        "render": function ( data, type, row, meta ) {
                            return `<div class="text-center"><a class="dsBalanceInfo" href="javascript:void(0)" onclick="dsBalanceInfoFn(${row.id})" data-id="dstockbalanceInfo${row.id}" id="dstockbalanceInfo${row.id}" title="Open information form"><i class="fa-sharp fa-regular fa-circle-info fa-xl" style="color: #00cfe8;"></i></a></div>`;
                        },
                        width:"4%",
                    }
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
                    $('#dsbalance_tbl').show();
                    $('#laravel-datatable-crud').DataTable().columns.adjust();
                },
                fixedHeader: {
                    header: true,
                    headerOffset: $('.header-navbar').outerHeight(),
                },
            });
        }

        function appendDStockBalanceFilterFn(){
            var stock_balance_type_filter = $(`
                <select class="selectpicker form-control dropdownclass" id="dsb_type_filter" name="dsb_type_filter[]" title="Select type here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" data-actions-box="true" multiple data-selected-text-format="count" data-count-selected-text="Item Type ({0})">
                    <option selected value="Consumption">Consumption</option>
                    <option selected value="Finished Goods">Finished Goods</option>
                    <option selected value="Fixed Asset">Fixed Asset</option>
                    <option selected value="Goods">Goods</option>
                    <option selected value="Raw Material">Raw Material</option>
                    <option selected value="Service">Service</option>
                </select>`);

            $('.dsbcustom-1').html(stock_balance_type_filter);
            $('#dsb_type_filter')
            .selectpicker()
            .off('changed.bs.select') 
            .on('changed.bs.select', function () {  
                var selected = $('#dsb_type_filter option:selected');
                var search = [];

                // Collect selected option values
                $.each(selected, function() {
                    search.push($(this).val());
                });

                if (search.length === 0) {
                    // No option selected: force DataTable to return no data
                    table.column(2).search('^$', true, false).draw(); // Match an impossible pattern
                } else {
                    // Options selected: build regex for filtering
                    var searchRegex = '^(' + search.join('|') + ')$'; // More precise regex pattern
                    table.column(2).search(searchRegex, true, false).draw();
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

        function dsBalanceInfoFn(recordId){
            createDSBalanceInfoFn(recordId);
            $('#dsBalanceInfoModal').modal('show');
        }

        function createDSBalanceInfoFn(recordId){
            var action_log = "";
            var action_links = "";
            var lidata = "";
            $.ajax({
                type: "GET",
                url: "{{ url('showItemData') }}/"+recordId,
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
                    fetchDetailDatatable(recordId);
                },
                success: function(data) {
                    $.each(data.item, function (index, value) { 
                        $("#itemid").html(recordId);
                        $(".itemtypeval").html(value.Type);
                        $(".itemcodeval").html(value.Code);
                        $(".itemnameval").html(value.Name);
                        $(".skunumberval").html(value.SKUNumber);
                        $(".sellingpricecls").html(value.DeadStockPrice);
                        $(".maxcostcls").html(value.dsmaxcost);
                        $(".categoryval").html(value.category_name);
                        $(".uomval").html(value.uom_name);
                        $("#uom_inp").val(value.uom_name);
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
                            <a class="dropdown-item viewBalanceAction" onclick="viewBalanceFn(${recordId})" data-id="view_balance${recordId}" id="view_balance${recordId}" title="View user log">
                            <span><i class="fa-solid fa-eye"></i> View User Log</span>  
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        @can("DS-Balance-Edit-Selling-Price")
                        <li>
                            <a class="dropdown-item selling_pr_edit" onclick="sellingPriceEditFn(${recordId})" data-id="selling_pr${recordId}" id="selling_pr${recordId}" title="Open selling price edit form">
                            <span><i class="fa-solid fa-pencil"></i> Edit Selling Price</span>  
                            </a>
                        </li>
                        @endcan`;

                    $("#dstockbalance_action_ul").empty().append(action_links);
                }
            });

            $(".infoscl").collapse('show');
            $("#stockbalance_item_div").show();
        }

        function viewBalanceFn(recordId){
            $("#action-log-title").html("User Log Information");
            $("#action-log-universal-modal").modal('show');
        }

        function fetchDetailDatatable(recordId){
            var uom = $('#uom_inp').val();
            $('#dsBalanceDatatable').DataTable({
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
                    url: '/showDStockDetail/'+recordId,
                    type: 'POST',
                    dataType: "json",
                },
                columns: [
                    { data: 'DT_RowIndex',width:"3%"},
                    { data: 'StationName', name: 'StationName',width:"35%"},
                    { data: 'NetBalance', name: 'NetBalance',
                        "render": function ( data, type, row, meta ) {
                            return `${data === 0 ? '' : numformat(parseFloat(data))+" "+uom}`;
                        },
                        width:"30%"
                    },
                    { data: 'AllocatedBalance', name: 'AllocatedBalance',
                        "render": function ( data, type, row, meta ) {
                            var calc_data = `<a style="text-decoration:underline;color:blue;" onclick=allocDataFn("${row.store_id}","${row.ItemId}")>${numformat(parseFloat(data))} ${uom}</a>`;
                            return `${data === 0 ? '' : calc_data}`;
                        },
                        width:"32%"
                    },
                ],
                "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    for(var i = 0;i <= 2;i++){
                        $(nRow).find('td:eq('+i+')').css({"color":"#28c76f","font-weight":"bold"});
                    }
                },
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api();
                    var columns = [0];
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    var total_qty = api
                        .column(2)
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    var total_alloc = api
                        .column(3)
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    $('#total_available_qty').html(`${total_qty === 0 ? '' : numformat(parseFloat(total_qty))+" "+uom}`);
                    $('#total_allocated_qty').html(`${total_alloc === 0 ? '' : numformat(parseFloat(total_alloc))+" "+uom}`);
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
                    $("#stockbalance_tbl").show();
                },
            });
        }

        function allocDataFn(str_id,item_id){
            fetchAllocationDataFn(str_id,item_id);
            $(".infoalloc").collapse('show');
            $('#allocationmodal').modal('show');
        }

        function fetchAllocationDataFn(str_id,itm_id){
            var uom = $('#uom_inp').val();
            var store_id;
            var item_id;

            $('#allocationdetailtbl').DataTable({
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
                    url: '/showAllocationData',
                    type: 'POST',
                    data:{
                        store_id: str_id,
                        item_id: itm_id,
                    },
                },
                columns: [
                    { data: 'DT_RowIndex',width:"3%"},
                    { data: 'ds_type', name: 'ds_type',width:"12%"},
                    { data: 'rec_type', name: 'rec_type',width:"12%"},
                    { data: 'src_station', name: 'src_station',width:"14%"},
                    { data: 'destination_station', name: 'destination_station',width:"14%"},
                    { data: 'DocumentNumber', name: 'DocumentNumber',
                        "render": function ( data, type, row, meta ) {
                            return `<a style="text-decoration:underline;color:blue;" class="printdsattachment" id="ds_rec${row.ds_type}_${row.rec_id}" data-link="${row.ds_type == 'Stock-IN' ? '/dshi/' + row.rec_id : '/dspo/' + row.rec_id}">${data}</a>`;
                        },
                        width:"14%"
                    },
                    { data: 'TransactionDate', name: 'TransactionDate',width:"10%"},
                    { data: 'Quantity', name: 'Quantity',
                        "render": function ( data, type, row, meta ) {
                            return `${data === 0 ? '' : numformat(parseFloat(data))} ${uom}`;
                        },
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
                            else{
                                return `<span class="badge bg-danger bg-glow">${data}</span>`;
                            }
                        },
                        width:"10%"
                    },
                ],
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api();
                    var columns = [0];
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    var total_alloc = api
                        .column(7)
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    $('#total_allocated_qty_detail').html(`${total_alloc === 0 ? '' : numformat(parseFloat(total_alloc))+" "+uom}`);
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
                    $("#stockbalance_tbl").show();
                },
            });
        }

        function sellingPriceEditFn(recordId){
            resetSellingPriceFormFn();
            $("#itemId").val(recordId);
            $('#sellingPrModal').modal('show');
        }

        $('#updatebtn').on('click', function() {
            var recordId = $("#recId").val();
            var formData = $("#Register").serialize();
            $.ajax({
                url: '/updateItemPrice',
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
                    $('#updatebtn').prop('disabled', true);
                    $('#updatebtn').text('Updating...');
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
                        if (data.errors.SellingPrice) {
                            $('#price-error').html(data.errors.SellingPrice[0]);
                        }
                        $('#updatebtn').text('Update');
                        $('#updatebtn').prop("disabled", false);
                        toastrMessage('error',"Please check your input","Error");
                    }
                    else if (data.dberrors) {
                        $('#updatebtn').text('Update');
                        $('#updatebtn').prop("disabled", false);
                        toastrMessage('error',"Please contact the administrator","Error");
                    }
                    else if(data.success){
                        createDSBalanceInfoFn(data.rec_id);
                        toastrMessage('success',"Successful","Success");
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                        $("#sellingPrModal").modal('hide');
                    }
                }
            });
        });

        $(document).on('show.bs.collapse hide.bs.collapse', '.stbalance', function (e) {
            e.stopPropagation();
            const collapse = $(this);
            const container = collapse.closest('.card, .modal-content, .row');
            const infoTarget = container.find('.dstockbalance_header_info');
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

        $(document).on('show.bs.collapse hide.bs.collapse', '.stbalance-alloc', function (e) {
            e.stopPropagation();
            const collapse = $(this);
            const container = collapse.closest('.card, .modal-content, .row');
            const infoTarget = container.find('.alloc_header_info');
            const collapseId = collapse.attr('id');
            const trigger = $(`[data-target="#${collapseId}"], [data-bs-target="#${collapseId}"]`);

            const isOpening = e.type === 'show';

            $('.toggle-text-label-alloc').html(isOpening ? 'Collapse' : 'Expand');
            $('.collapse-icon-alloc').html(isOpening ? '<i class="fas text-secondary fa-minus-circle"></i>' : '<i class="fas text-secondary fa-plus-circle"></i>');

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

        function refreshDSBalanceFn(){
            var blTable = $('#laravel-datatable-crud').dataTable();
            blTable.fnDraw(false);
        }

        $('body').on('click', '.printdsattachment', function() {
            var id = $(this).data('id');
            var link = $(this).data('link');
            window.open(link, 'Stock-Out', 'width=1200,height=800,scrollbars=yes');
        });
        
        function resetSellingPriceFormFn(){
            $('.reg_form').val("");
            $('.errordatalabel').html("");
            var item_name = $('#main_itemname').text();
            var selling_price = $('#selling_price_inp').text();
            $("#selling_price_form_title").html(`Edit Selling Price`);
            $("#SellingPrice").val(selling_price);
            $('#updatebtn').text('Update');
            $('#updatebtn').prop("disabled",false);
        }

        function sellingPriceFn(){
            $('#price-error').html("");
        }

        function numformat(val){
            while (/(\d+)(\d{3})/.test(val.toString())){
            val = val.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
            }
            return val;
        }

    </script>
@endsection