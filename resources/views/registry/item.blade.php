@extends('layout.app1')
@section('title')
@endsection
@section('content')
    @can('Item-View')
    <div class="app-content content">
        <section id="responsive-datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom fit-content mb-0 pb-0">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align: left !important;align-items: center;padding: 10px 5px;">
                                        <h3 class="card-title form_title">Products</h3>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align: right !important;align-items: center;padding: 10px 5px;">
                                        <button type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm" onclick="refreshtbl()"><i class="fas fa-sync-alt"></i></button>
                                        <div class="btn-group">
                                            @can('Item-Add')
                                                <button type="button" class="btn btn-gradient-info btn-sm header-prop addbutton" id="addbutton"><i class="fas fa-plus"></i><span class="header-text">&nbsp Add</span></button>
                                            @endcan
                                            @if(auth()->user()->can('Multiple-Price-Update-Local')||auth()->user()->can('Multpile-Price-Update-Import'))
                                                <button type="button" class="btn btn-info btn-sm dropdown-toggle dropdown-toggle-split waves-effect waves-float waves-light header-prop" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item batchupdate">Multiple price update</a>
                                                </div>
                                            @endif
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-datatable fit-content">
                            <div style="width:99%; margin-left:0.5%;" id="table-block">
                                <table id="itemdataables" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable mb-0 mobile-dt" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th style="display: none;"></th>
                                            <th style="width:3%;">#</th>
                                            <th style="width:10%;">Code</th>
                                            <th style="width:10%;">Name</th>
                                            <th style="width:10%;">Barcode No.</th>
                                            <th style="width:6%;">Group</th>
                                            <th style="width:6%;">Category</th>
                                            <th style="width:6%;" title="Unit of Measurement">UOM</th>
                                            <th style="width:9%;">RT Price</th>
                                            <th style="width:9%;">WS Price</th>
                                            <th style="width:9%;">WS Min Qty</th>
                                            <th style="width:10%;">WS Max Qty</th>
                                            <th style="display:none;"></th>
                                            <th style="display:none;"></th>
                                            <th style="width:8%;">Status</th>
                                            <th style="width:4%;">Action</th>
                                            <th style="display:none;"></th>
                                            <th style="display:none;"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="table table-sm"></tbody>
                                </table>
                            </div>
                            <input type="hidden" class="form-control" name="wholesalefeaturetable" id="wholesalefeaturetable" value="{{ $setings->wholesalefeature }}" readonly/>
                            <input type="hidden" class="form-control" name="costtype" id="costtype" value="{{ $setings->costType }}" readonly/>
                            <input type="hidden" class="form-control" name="ItemCodeType" id="ItemCodeType" value="{{ $setings->ItemCodeType }}" readonly/>
                            <input type="hidden" class="form-control" name="transactionEdit" id="transactionEdit" value="{{ auth()->user()->can('Transaction-Edit') ? 1 : 0 }}" readonly/>
                            <input type="hidden" class="form-control" name="localcost" id="localcost" value="{{ auth()->user()->can('Local-item-cost-view') ? 1 : 0 }}" readonly/>
                            <input type="hidden" class="form-control" name="importcost" id="importcost" value="{{ auth()->user()->can('Import-item-cost-view') ? 1 : 0 }}" readonly/>
                            <input type="hidden" class="form-control" name="localitemeditpermission" id="localitemeditpermission" value="{{ auth()->user()->can('Local-item-edit') ? 1 : 0 }}" readonly/>
                            <input type="hidden" class="form-control" name="importitemeditpermission" id="importitemeditpermission" value="{{ auth()->user()->can('Import-item-edit') ? 1 : 0 }}" readonly/>
                            <input type="hidden" class="form-control" name="importitemstoreminquantity" id="importitemstoreminquantity" value="{{ auth()->user()->can('Import-Item-Store-Min-Quantity') ? 1 : 0 }}" readonly/>
                            <input type="hidden" class="form-control" name="localitemstoreminquantity" id="localitemstoreminquantity" value="{{ auth()->user()->can('Local-Item-Store-Min-Quantity') ? 1 : 0 }}" readonly/>
                            <input type="hidden" class="form-control" name="localitempriceupdate" id="localitempriceupdate" value="{{ auth()->user()->can('Local-Item-Selling-Price-update') ? 1 : 0 }}" readonly/>
                            <input type="hidden" class="form-control" name="importitempriceupdate" id="importitempriceupdate" value="{{ auth()->user()->can('Import-Item-Selling-Price-update') ? 1 : 0 }}" readonly/>
                            <input type="hidden" class="form-control" name="itmcodetype" id="itmcodetype" />
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @endcan

    <div class="modal fade text-left fit-content" id="docInfoModal" tabindex="-1" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" data-backdrop="static" style="display: none;">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title form_title">Product Information</h4>
                    <div class="row">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                </div>
                <form id="itemInfoForm">
                    {{ csrf_field() }}
                    <div class="modal-body">    
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                <ul class="nav nav-tabs info-note" role="tablist">
                                    <li class="nav-item genformnavcon">
                                        <a class="nav-link genformnav disabled" id="Info-general-tab" data-toggle="tab" href="#infogeneralview" aria-controls="Info-general-tab" role="tab" aria-selected="false" title="General Information"><i class="fas fa-database"></i><span class="tab-text">General Information</span></a>
                                    </li>
                                </ul>
                                <div class="tab-content genformtabcon" style="border: 0.1px solid #d9d7ce;margin-top:-14px;">
                                    <div class="tab-pane genformtab active" id="infogeneralview" aria-labelledby="infogeneralview" role="tabpanel">
                                        <div class="row m-1">
                                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                                <table class="infotbl" style="width:100%;font-size:12px;">
                                                    <tr>
                                                        <td><label class="info_lbl">Class</label></td>
                                                        <td><label class="info_lbl" id="product_class_lbl" style="font-weight:bold;"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label class="info_lbl">Code</label></td>
                                                        <td><label class="info_lbl" id="itemcodeInfoLbl" style="font-weight:bold;"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label class="info_lbl">Name</label></td>
                                                        <td><label class="info_lbl" id="itemInfoLbl" style="font-weight:bold;"></label></td>
                                                    </tr>
                                                    <tr class="non_service_info">
                                                        <td><label class="info_lbl" title="Barcode Number">Barcode No.</label></td>
                                                        <td><label class="info_lbl" id="skuInfoLbl" style="font-weight:bold;"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label class="info_lbl" title="Unit of Measurement">UOM</label></td>
                                                        <td><label class="info_lbl" id="uomInfoLbl" style="font-weight:bold;"></label></td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                                <table class="infotbl" style="width:100%;font-size:12px;">
                                                    <tr>
                                                        <td><label class="info_lbl">Category</label></td>
                                                        <td><label class="info_lbl" id="itemCategoryInfoLbl" style="font-weight:bold;"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label class="info_lbl">Tax Type</label></td>
                                                        <td><label class="info_lbl" id="taxInfoLbl" style="font-weight:bold;"></label></td>
                                                    </tr>
                                                    <tr class="non_service_info">
                                                        <td><label class="info_lbl">Product Type</label></td>
                                                        <td><label class="info_lbl" id="product_type_lbl" style="font-weight:bold;"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label class="info_lbl">Description</label></td>
                                                        <td><label class="info_lbl" id="imagedescription" style="font-weight:bold;"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label class="info_lbl">Status</label></td>
                                                        <td><label class="info_lbl" id="status_lbl" style="font-weight:bold;"></label></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                <ul class="nav nav-tabs nav-fill" role="tablist">
                                    <li class="nav-item formnavitm note">
                                        <a class="nav-link active item-info-tabs info-tab-title" id="item-info-basic-tab" data-toggle="tab" href="#item-info-basic-view" aria-controls="item-info-basic-tab" role="tab" aria-selected="true" title="Basic"><i class="fas fa-bars"></i><span class="tab-text">Basic</span></a>                                
                                    </li>
                                    <li class="nav-item formnavitm note">
                                        <a class="nav-link item-info-tabs info-tab-title" id="item-info-inventory-tab" data-toggle="tab" href="#item-info-inventory-view" aria-controls="item-info-inventory-tab" role="tab" aria-selected="true" title="Inventory"><i class="fas fa-boxes"></i><span class="tab-text">Inventory</span></a>                                
                                    </li>
                                    <li class="nav-item formnavitm note">
                                        <a class="nav-link item-info-tabs info-tab-title" id="item-info-purchase-tab" data-toggle="tab" href="#item-info-purchase-view" aria-controls="item-info-purchase-tab" role="tab" aria-selected="true" title="Purchase"><i class="fas fa-cart-plus"></i><span class="tab-text">Purchase</span></a>                                
                                    </li>
                                    <li class="nav-item formnavitm note">
                                        <a class="nav-link item-info-tabs info-tab-title" id="item-info-sales-tab" data-toggle="tab" href="#item-info-sales-view" aria-controls="item-info-sales-tab" role="tab" aria-selected="true" title="Sales"><i class="fas fa-cash-register"></i><span class="tab-text">Sales</span></a>                                
                                    </li>
                                    <li class="nav-item formnavitm note">
                                        <a class="nav-link item-info-tabs info-tab-title" id="item-info-others-tab" data-toggle="tab" href="#item-info-others-view" aria-controls="item-info-others-tab" role="tab" aria-selected="true" title="Others"><i class="fas fa-circle-check"></i><span class="tab-text">Others</span></a>                                
                                    </li>
                                </ul>
                                <div class="tab-content formtabcon item-content-view" style="border: 0.1px solid #d9d7ce;margin-top:-14px;">
                                    <div class="tab-pane item-info-views active info-tab-view" id="item-info-basic-view" aria-labelledby="item-info-basic-view" role="tabpanel">
                                        <div class="row m-1">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pl-1 pr-1 section-path">
                                                <div class="breadcrumb-path">
                                                    <div class="crumb active"><a>Basic</a></div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 non_service_info">
                                                <table class="infotbl" style="width:100%;font-size:12px;">
                                                    <tr>
                                                        <td><label class="info_lbl" title="Unique identifier assigned to this product for tracking and reference.">Part No.</label></td>
                                                        <td><label class="info_lbl" id="partnumberInfoLbl" style="font-weight:bold;"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label class="info_lbl" title="The minimum stock level that triggers a replenishment order to avoid stockouts.">Reorder Point</label></td>
                                                        <td><label class="info_lbl" id="reorderInfoLbl" style="font-weight:bold;"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label class="info_lbl" title="Identifies the specific lot or shelf location where this product is stored.">Lot Description</label></td>
                                                        <td><label class="info_lbl" id="lot_description_lbl" style="font-weight:bold;"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label class="info_lbl" title="A multiplier used to convert or scale quantities in calculations. (For manufacturing)">Factor</label></td>
                                                        <td><label class="info_lbl" id="factorInfoLbl" style="font-weight:bold;"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label class="info_lbl" title="Number of pieces contained in a single carton or box.">Cartoon Size</label></td>
                                                        <td><label class="info_lbl" id="cartoon_size_lbl" style="font-weight:bold;"></label></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane item-info-views info-tab-view" id="item-info-inventory-view" aria-labelledby="item-info-inventory-view" role="tabpanel">
                                        <div class="row m-1">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pl-1 pr-1 section-path">
                                                <div class="breadcrumb-path">
                                                    <div class="crumb active"><a>Inventory</a></div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 non_service_info">
                                                <table class="infotbl" style="width:100%;font-size:12px;">
                                                    <tr>
                                                        <td><label class="info_lbl" title="Is Serial Number Required">Is Serial No. Req.</label></td>
                                                        <td><label class="info_lbl" id="is_serial_no_req_lbl" style="font-weight:bold;"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label class="info_lbl" title="Is Batch Number | Expiry Date Required">Is Batch No. | Expiry Date Req.</label></td>
                                                        <td><label class="info_lbl" id="is_batch_no_req_lbl" style="font-weight:bold;"></label></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane item-info-views info-tab-view" id="item-info-purchase-view" aria-labelledby="item-info-purchase-view" role="tabpanel">
                                        <div class="row m-1">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pl-1 pr-1 section-path">
                                                <div class="breadcrumb-path">
                                                    <div class="crumb active"><a>Purchase</a></div>
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-lg-12 col-md-12 col-sm-12 col-12 mb-1 non_service_info">
                                                <table class="infotbl" style="width:100%;font-size:12px;">
                                                    <tr>
                                                        <td><label class="info_lbl">Group</label></td>
                                                        <td><label class="info_lbl" id="itemgroupInfoLbl" style="font-weight:bold;"></label></td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-xl-10 col-lg-12 col-md-12 col-sm-12 col-12 border-left non_service_info">
                                                <table id="info-supplier-datatable" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable mb-0 info_datatable" style="width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="7" class="text-center">Supplier Information</th>
                                                        </tr>
                                                        <tr>
                                                            <th style="width:3%;">#</th>
                                                            <th style="width:40%;">Supplier <i class="fas fa-info-circle" style="color: #82868b;" title="Code, Name, TIN"></i></th>
                                                            <th style="width:10%;">UOM</th>
                                                            <th style="width:10%;">Quantity</th>
                                                            <th style="width:10%;">Price</th>
                                                            <th style="width:10%;">Availablity</th>
                                                            <th style="width:17%;">Remark</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="table table-sm"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane item-info-views info-tab-view" id="item-info-sales-view" aria-labelledby="item-info-sales-view" role="tabpanel">
                                        <div class="row mt-1 mr-1 ml-1">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pl-1 pr-1 section-path">
                                                <div class="breadcrumb-path">
                                                    <div class="crumb active"><a>Sales</a></div>
                                                </div>
                                            </div>
                                            <div class="col-xl-9 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                                <fieldset class="fset">
                                                    <legend class="mb-0">
                                                        <div class="row">
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">Pricing</div>
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align: right">
                                                                <label class="info_lbl" id="price_type_lbl" style="font-weight:400;"></label>
                                                            </div>
                                                        </div>
                                                    </legend>
                                                    <div class="row">
                                                        <div class="col-xl-3 col-lg-9 col-md-9 col-sm-9 col-12 mb-1 flexible_class_info">
                                                            <fieldset class="fset2">
                                                                <legend class="mb-0">Minimum Price</legend>
                                                                <div class="row">
                                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                        <table class="infotbl" style="width:100%;font-size:12px;">
                                                                            <tr>
                                                                                <td><label class="info_lbl">Before Tax</label></td>
                                                                                <td><label class="info_lbl" id="min_bt_lbl" style="font-weight:bold;"></label></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><label class="info_lbl">After Tax</label></td>
                                                                                <td><label class="info_lbl" id="min_at_lbl" style="font-weight:bold;"></label></td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                        <div class="col-xl-3 col-lg-9 col-md-9 col-sm-9 col-12 mb-1">
                                                            <fieldset class="fset2">
                                                                <legend class="mb-0">Default Price</legend>
                                                                <div class="row">
                                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                        <table class="infotbl" style="width:100%;font-size:12px;">
                                                                            <tr>
                                                                                <td><label class="info_lbl">Before Tax</label></td>
                                                                                <td><label class="info_lbl" id="default_bt_lbl" style="font-weight:bold;"></label></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><label class="info_lbl">After Tax</label></td>
                                                                                <td><label class="info_lbl" id="default_at_lbl" style="font-weight:bold;"></label></td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                        <div class="col-xl-3 col-lg-9 col-md-9 col-sm-9 col-12 mb-1 flexible_class_info">
                                                            <fieldset class="fset2">
                                                                <legend class="mb-0">Maximum Price</legend>
                                                                <div class="row">
                                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                        <table class="infotbl" style="width:100%;font-size:12px;">
                                                                            <tr>
                                                                                <td><label class="info_lbl">Before Tax</label></td>
                                                                                <td><label class="info_lbl" id="max_bt_lbl" style="font-weight:bold;"></label></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><label class="info_lbl">After Tax</label></td>
                                                                                <td><label class="info_lbl" id="max_at_lbl" style="font-weight:bold;"></label></td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                        <div class="col-xl-3 col-lg-9 col-md-9 col-sm-9 col-12 mb-1 non_service_info">
                                                            <table style="width: 100%;font-size:12px;" class="rtable text-center">
                                                                <tr>
                                                                    <td colspan="3">
                                                                        <label class="info_lbl" style="font-weight: bold;">Product Cost</label>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl" style="font-weight: bold;">Cost Type</label></td>
                                                                    <td><label class="info_lbl" style="font-weight: bold;">Before Tax</label></td>
                                                                    <td><label class="info_lbl" style="font-weight: bold;">After Tax</label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td title="Minimum Cost"><label class="info_lbl">Min. Cost</label></td>
                                                                    <td><label class="info_lbl product_cost_lbl min_cost_bt_lbl" id="mincostInfoLblbv"></label></td>
                                                                    <td><label class="info_lbl product_cost_lbl min_cost_at_lbl" id="mincostInfoLblav"></label></td>
                                                                </tr>
                                                                <tr id="averagecosttr">
                                                                    <td title="Average Cost"><label class="info_lbl">Avg. Cost</label></td>
                                                                    <td><label class="info_lbl product_cost_lbl avg_cost_bt_lbl" id="averageInfoLblbv"></label></td>
                                                                    <td><label class="info_lbl product_cost_lbl avg_cost_at_lbl" id="averageInfoLblav"></label></td>
                                                                </tr>
                                                                <tr id="maxcosttr">
                                                                    <td title="Maximum Cost"><label class="info_lbl">Max. Cost</label></td>
                                                                    <td><label class="info_lbl product_cost_lbl max_cost_bt_lbl" id="maxcostInfoLblbv"></label></td>
                                                                    <td><label class="info_lbl product_cost_lbl max_cost_at_lbl" id="maxcostInfoLblav"></label></td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-xl-3 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                                <table id="info-compatible-datatable" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable mb-0 info_datatable" style="width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:3%;">#</th>
                                                            <th style="width:97%;">Compatible Products <i class="fas fa-info-circle" style="color: #82868b;" title="Code, Name, Barcode Number"></i></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="table table-sm"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane item-info-views info-tab-view" id="item-info-others-view" aria-labelledby="item-info-others-view" role="tabpanel">
                                        <div class="row mt-1 ml-1">
                                            <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-1 non_service_info">
                                                <!-- Tab navs -->
                                                <div class="nav flex-column nav-tabs text-left" id="v-tabs-modules" role="tablist" aria-orientation="vertical">
                                                    <a class="nav-link mod-vertical-tab active verticalinfo info-tab-title ver-cus-tab" id="info-v-image-tab" data-toggle="tab" href="#info-v-image-view" role="tab" aria-controls="info-general-tab" aria-selected="true" title="Images"><i class="fas fa-images"></i><span class="tab-text">Images</span></a>
                                                    <a class="nav-link mod-vertical-tab verticalinfo mod info-tab-title ver-cus-tab" id="info-document-tab" data-mod="hr" data-toggle="tab" href="#info-document-view" role="tab" aria-controls="info-hr-tab" aria-selected="false" title="Documents"><i class="fas fa-books"></i><span class="tab-text">Documents</span></a>
                                                </div>
                                                <!-- Tab navs -->
                                            </div>
                                            <div class="col-xl-11 col-lg-11 col-md-11 col-sm-11 col-11 non_service_info" style="margin-right: -5rem;padding-right: -5rem !important;">
                                                <div class="tab-content" id="v-tabs-tabContent" style="border: 0.1px solid #d9d7ce;">
                                                    <div class="tab-pane active verticalviewinfo info-tab-view" id="info-v-image-view" role="tabpanel" aria-labelledby="info-v-image-view">
                                                        <div class="row">
                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1 section-path">
                                                                <div class="breadcrumb-path">
                                                                    <div class="crumb"><a>Oters</a></div>
                                                                    <div class="crumb active"><a>Images</a></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mb-1">
                                                                <div class="row">
                                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 main">
                                                                        <div id="carouselExampleFade"></div>
                                                                        <div id="img-container">
                                                                            <img id=featured src="" width="500px;" height="300px;">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 scroll scrdiv">
                                                                        <div class="card">
                                                                            <div class="card-body ">
                                                                                <div class="row sideImage"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mb-1">
                                                                <div id="barcodeinfo" class="text-center" style="height:25rem;">
                                                                    <b><label id="barcodeinfocode"></label></b>
                                                                    <div id="barcodeinfoimages"></div>
                                                                    <b><label id="barcodeskuNumber"></label></b>
                                                                    <input type="hidden" name="printid" id="printid" />
                                                                    <button id="printbutton" type="button" class="btn btn-outline-info btn-sm header-prop"><i class="fas fa-print"></i><span class="header-text">&nbsp Print</span></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane verticalviewinfo info-tab-view" id="info-document-view" role="tabpanel" aria-labelledby="info-document-view">
                                                        <div class="row m-1">
                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1 section-path">
                                                                <div class="breadcrumb-path">
                                                                    <div class="crumb"><a>Oters</a></div>
                                                                    <div class="crumb active"><a>Documents</a></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                <table id="info-document-datatable" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable mb-0 info_datatable mr-1" style="width: 100%;">
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
                                        <ul class="dropdown-menu" id="item_action_ul"></ul>
                                    </div>
                                </div>        
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align:right">
                                    <input type="hidden" class="form-control" name="itemtype" id="itemtype" readonly="true">
                                    <input type="hidden" class="form-control" name="wholesalemax" id="wholesalemax" readonly="true">
                                    <input type="hidden" class="form-control" name="pendingdata" id="pendingdata" readonly="true">
                                    <button id="closebutton" type="button" class="btn btn-danger form_btn" data-dismiss="modal" onclick="refreshtbl1()">Close</button>
                                </div> 
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade text-left" id="batchupdateformodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Multiple price update </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closebatchModalWithClearValidation()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="batchupdateform">
                    {{ csrf_field() }}
                    <div class="modal-body">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                        <label strong style="font-size: 14px;">Group <b style="color:red;">*</b> </label>
                                            <select class="selectpicker form-control" name="itemGroup[]" id="batchgroup" multiple data-live-search="true" title="Select item group" data-style="btn btn-outline-secondary waves-effect">
                                                @can('Multiple-Price-Update-Local')
                                                <option value='Local'>Local</option>
                                                @endcan
                                                @can('Multpile-Price-Update-Import')
                                                <option value='Imported'>Imported</option>
                                                @endcan
                                            </select>
                                        <span class="text-danger">
                                            <strong id="batchgroup-error"></strong>
                                        </span>
                                    </div>
                                    <div class="col-xl-2 col-md-6 col-sm-12 mb-2" id="">
                                        <label strong style="font-size: 14px;">Category <b style="color:red;">*</b> </label>
                                                <select class="selectpicker form-control" name="category[]" id="batchcategory" multiple data-live-search="true" title="Select category" data-style="btn btn-outline-secondary waves-effect" data-actions-box="true" data-selected-text-format="count" data-count-selected-text="Selected category ({0})">
                                                @foreach ($category as $cat)
                                                    <option value="{{ $cat->id }}">{{ $cat->Name }}</option>
                                                @endforeach
                                            </select>
                                        
                                        <span class="text-danger">
                                            <strong id="batchcategory-error"></strong>
                                        </span>
                                    </div>
                                    <div class="col-xl-3 col-md-6 col-sm-12 mb-2" id="">
                                        <label strong style="font-size: 14px;">Item <b style="color:red;">*</b> </label>
                                        <select class="selectpicker form-control" name="item[]" id="batchitem" multiple data-actions-box="true" data-live-search="true"  title="Select items" data-style="btn btn-outline-secondary waves-effect" data-selected-text-format="count" data-count-selected-text="Selected items ({0})">
                                            </select>
                                        <span class="text-danger">
                                            <strong id="batchitem-error"></strong>
                                        </span>
                                    </div>
                                    <div class="col-xl-2 col-md-12 col-sm-12 mb-2" id="">
                                        <label strong style="font-size: 14px;">Plus/Minus <b style="color:red;">*</b></label>
                                        <select class="selectpicker  form-control" name="increaseDescrease" id="increaseDescrease" title="Select values" data-style="btn btn-outline-secondary waves-effect" data-live-search="true" data-show-subtext="true" >
                                            <option value="1" data-content="<i class='fa fa-plus'></i> Plus">Plus</option>
                                            <option value="2" data-content="<i class='fa fa-minus'></i> Minus">Minus</option>
                                            
                                        </select>
                                        <span class="text-danger">
                                            <strong id="increaseDescrease-error"></strong>
                                        </span>
                                    </div>
                                    <div class="col-xl-1 col-md-12 col-sm-12 mb-2" id="">
                                        <label strong style="font-size: 14px;">%<b style="color:red;">*</b></label>
                                        <input type="number" placeholder="Enter percent to discount" class="form-control" name="percent" id="percent" onkeypress="clearpercernterror()"  autofocus />
                                        <span class="text-danger">
                                            <strong id="batchpercent-error"></strong>
                                        </span>
                                    </div>
                                    <div class="col-xl-2 col-md-12 col-sm-12 mb-2" id="">
                                        <div class="demo-inline-spacing">
                                            <button type="button" id="batchupadtepreviewbutton" class="btn btn-info btn-sm waves-effect waves-float waves-light">
                                                <i data-feather='eye'></i>
                                                <span id="loadid"></span>
                                                <span id="saveid">View</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="card-block">
                                    <div class="col-xl-12 col-md-12 col-sm-12" id="dividerdiv">
                                        <div class="divider">
                                            <div class="divider-text">Selection item list </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive" id="batchupdatedatablediv">
                                            <table id="batchupdatedatable" class="display table-bordered table-striped table-hover dt-responsive mb-0"
                                                style="width: 100%">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Group</th>
                                                        <th>Code</th>
                                                        <th>Name</th>
                                                        <th>SKU #</th>                                              
                                                        <th>Category</th>
                                                        <th>UOM</th>
                                                        <th>Cost</th>
                                                        <th>Ret Price</th>
                                                        <th>Ws Price</th>
                                                        <th>New Ret price</th>
                                                        <th>New Ws Price</th>
                                                    </tr>
                                                </thead>
                                                
                                            </table>
                                        
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button id="batchupadtesavebutton" type="button" class="btn btn-info">Save</button>
                        <button id="closebutton1" type="button" class="btn btn-danger" data-dismiss="modal" onclick="closebatchModalWithClearValidation()">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- //  item register modal-body --}}
    <div class="modal fade text-left fit-content" id="addItemForm" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="docInfoModal" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="item_form_title">Add Product</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form id="RegisterItem" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row mb-1">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <ul class="nav nav-tabs one-note" role="tablist">
                                    <li class="nav-item genformnavcon">
                                        <a class="nav-link genformnav disabled one-tab-prop" id="General-tab" data-toggle="tab" href="#generalinformationview" aria-controls="generalinformationview" role="tab" aria-selected="false" title="General"><i class="fas fa-database"></i><span class="tab-text">General</span></a>
                                    </li>
                                </ul>
                                <div class="tab-content genformtabcon general-view" style="border: 0.1px solid #d9d7ce;margin-top:-14px;">
                                    <div class="tab-pane active" id="generalinformationview" aria-labelledby="generalinformationview" role="tabpanel">
                                        <div class="row">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-0 mb-1 pt-1">
                                                <div class="demo-inline-spacing pl-1 non_editable_containers">
                                                    <div class="custom-control custom-radio mt-0">
                                                        <input type="radio" id="product_class1" name="product_class" class="custom-control-input" value="Goods"/>
                                                        <label class="custom-control-label form_lbl" for="product_class1">Goods</label>
                                                    </div>
                                                    <div class="custom-control custom-radio mt-0">
                                                        <input type="radio" id="product_class2" name="product_class" class="custom-control-input" value="Commodity"/>
                                                        <label class="custom-control-label form_lbl" for="product_class2">Commodity</label>
                                                    </div>
                                                    <div class="custom-control custom-radio mt-0">
                                                        <input type="radio" id="product_class3" name="product_class" class="custom-control-input" value="Service"/>
                                                        <label class="custom-control-label form_lbl" for="product_class3">Service</label>
                                                    </div>
                                                </div>
                                                <span class="text-danger">
                                                    <strong id="product_class_error" class="errordatalabel"></strong>
                                                </span>
                                            </div>  
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-8 col-lg-8 col-md-9 col-sm-9 col-12">
                                                <div class="row pl-1">
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-1 non_editable_containers" id="product_code_div">
                                                        <div class="row">
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-8 mr-0 pr-0">
                                                                <label class="form_lbl">Product Code<b style="color: red; font-size:16px;">*</b></label>
                                                            </div>
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-4 pr-2" style="text-align:right;">
                                                                <a 
                                                                    class="generate_item_code" 
                                                                    href="javascript:void(0)" 
                                                                    onclick="generateItemCodeFn()" 
                                                                    id="generate_item_code" 
                                                                    title="Generate product code">
                                                                    <i class="fas fa-g fa-xl" style="color:#00cfe8;"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                <input type="text" name="code" id="code" placeholder="Enter product code here" class="form-control mainforminp" onkeyup="removeCodeValidation()"/>
                                                                <span class="text-danger">
                                                                    <strong id="code-error" class="errordatalabel general_error"></strong>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-1 non_editable_containers">
                                                        <label class="form_lbl">Product Name<b style="color: red; font-size:16px;">*</b></label>
                                                        <input type="text" name="name" id="name" placeholder="Enter product name here" class="form-control mainforminp" onkeyup="removeNameValidation()"/>
                                                        <span class="text-danger">
                                                            <strong id="name-error" class="errordatalabel general_error"></strong>
                                                        </span>
                                                    </div>

                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-1 non_editable_containers non_service_div" id="skuNumberDiv">
                                                        <div class="row">
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-8 mr-0 pr-0">
                                                                <label class="form_lbl" title="Barcode Number">Barcode No.</label>
                                                            </div>
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-4 pr-2" style="text-align:right;">
                                                                <a 
                                                                    class="generateBtn" 
                                                                    href="javascript:void(0)" 
                                                                    onclick="GenerateBarcode()" 
                                                                    id="generateBtn" 
                                                                    title="Generate barcode">
                                                                    <i class="fas fa-g fa-xl" style="color:#00cfe8"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                <input type="text" name="skuNumber" id="skuNumber" placeholder="Enter barcode number or click [G] button to generate" class="form-control mainforminp non_service_input" onkeyup="removeSknumbervalidation()"/>
                                                                <span class="text-danger">
                                                                    <strong id="skuNumber-error" class="errordatalabel general_error non_service_error"></strong>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-1 non_editable_containers" id="uomDiv">
                                                        <label class="form_lbl" title="Unit of Measurement">UOM<b style="color: red; font-size:16px;">*</b></label>
                                                        <select class="select2 form-control" name="Uom" id="Uom" onchange="uomValidation()">
                                                            @foreach ($uom as $um)
                                                                <option value="{{ $um->id }}">{{ $um->Name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger">
                                                            <strong id="uom-error" class="errordatalabel general_error"></strong>
                                                        </span>
                                                    </div>

                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-1 non_editable_containers" id="categoryDiv">
                                                        <label class="form_lbl">Category<b style="color: red; font-size:16px;">*</b></label>
                                                        <select class="select2 form-control" name="Category" id="Category" onchange="categoryValidation()">
                                                            @foreach ($category as $cat)
                                                                <option value="{{ $cat->id }}">{{ $cat->Name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger">
                                                            <strong id="category-error" class="errordatalabel general_error"></strong>
                                                        </span>
                                                    </div>

                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-1" id="taxtypeDiv">
                                                        <label class="form_lbl">Tax Type<b style="color: red; font-size:16px;">*</b></label>
                                                        <select class="select2 form-control" name="TaxType" id="TaxType" onchange="taxTypeValidation()">
                                                            @foreach ($taxtypes as $tx)
                                                                <option value="{{ $tx->Value }}">{{ $tx->Name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger">
                                                            <strong id="taxType-error" class="errordatalabel general_error"></strong>
                                                        </span>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="col-xl-4 col-lg-4 col-md-3 col-sm-3 col-12 mb-1 pr-1">
                                                <div class="row non_service_div">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <label class="form_lbl">Product Type<b style="color: red; font-size:16px;">*</b></label>
                                                    </div>
                                                    @foreach ($itemtypes as $itemtype_data)
                                                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                                            <div class="custom-control custom-control-primary custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input item_type non_service_checkbox" id="item_type{{$itemtype_data->id}}" name="item_type[]" value="{{$itemtype_data->id}}"/>
                                                                <label class="custom-control-label" for="item_type{{$itemtype_data->id}}">{{$itemtype_data->type}}</label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    <span class="text-danger ml-1">
                                                        <strong id="product_type-error" class="errordatalabel general_error non_service_error"></strong>
                                                    </span>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-7 col-lg-4 col-md-4 col-sm-12 col-12 mt-1">
                                                        <label class="form_lbl">Description</label>
                                                        <textarea type="text" name="description" id="description" placeholder="Enter description here" class="form-control mainforminp" rows="1"></textarea>
                                                        <span class="text-danger">
                                                            <strong id="description-error" class="errordatalabel general_error"></strong>
                                                        </span>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mt-1 pr-1" id="statusDiv">
                                                        <label class="form_lbl">Status<b style="color: red; font-size:16px;">*</b></label>
                                                        <select class="select2 form-control" name="status" id="status" onchange="removeStatusValidation()">
                                                            <option value="Active">Active</option>
                                                            <option value="Inactive">Inactive</option>
                                                        </select>
                                                        <span class="text-danger">
                                                            <strong id="activeStatus-error" class="errordatalabel general_error"></strong>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <ul class="nav nav-tabs nav-fill" role="tablist">
                                    <li class="nav-item formnavitm note">
                                        <a class="nav-link active item-tabs tab-title active-tab-title" id="item-basic-tab" data-toggle="tab" href="#item-basic-view" aria-controls="item-basic-tab" role="tab" aria-selected="true" title="Basic"><i class="fas fa-bars"></i><span class="tab-text">Basic</span></a>                                
                                    </li>
                                    <li class="nav-item formnavitm note">
                                        <a class="nav-link item-tabs tab-title" id="item-inventory-tab" data-toggle="tab" href="#item-inventory-view" aria-controls="item-inventory-tab" role="tab" aria-selected="true" title="Inventory"><i class="fas fa-boxes"></i><span class="tab-text">Inventory</span></a>                                
                                    </li>
                                    <li class="nav-item formnavitm note">
                                        <a class="nav-link item-tabs tab-title" id="item-purchase-tab" data-toggle="tab" href="#item-purchase-view" aria-controls="item-purchase-tab" role="tab" aria-selected="true" title="Purchase"><i class="fas fa-cart-plus"></i><span class="tab-text">Purchase</span></a>                                
                                    </li>
                                    <li class="nav-item formnavitm note">
                                        <a class="nav-link item-tabs tab-title" id="item-sales-tab" data-toggle="tab" href="#item-sales-view" aria-controls="item-sales-tab" role="tab" aria-selected="true" title="Sales"><i class="fas fa-cash-register"></i><span class="tab-text">Sales</span></a>                                
                                    </li>
                                    <li class="nav-item formnavitm note">
                                        <a class="nav-link item-tabs tab-title" id="item-others-tab" data-toggle="tab" href="#item-others-view" aria-controls="item-others-tab" role="tab" aria-selected="true" title="Others"><i class="fas fa-circle-check"></i><span class="tab-text">Others</span></a>                                
                                    </li>
                                </ul>
                                <div class="tab-content formtabcon item-content-view" style="border: 0.1px solid #d9d7ce;margin-top:-14px;">
                                    <div class="tab-pane item-views active tab-view active-tab-view" id="item-basic-view" aria-labelledby="item-basic-view" role="tabpanel">
                                        <div class="row mr-1 ml-1 mt-1">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pl-1 pr-1 section-path">
                                                <div class="breadcrumb-path">
                                                    <div class="crumb active"><a>Basic</a></div>
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-lg-4 col-md-4 col-sm-12 col-12 mb-1 non_service_div">
                                                <label class="form_lbl" title="Unique identifier assigned to this product for tracking and reference.">Part No.</label>
                                                <input type="text" placeholder="Enter part number here" class="form-control mainforminp non_service_input" name="partNumber" id="partNumber" onkeypress="partNumberValidation()"/>
                                                <span class="text-danger">
                                                    <strong id="partNumber-error" class="errordatalabel basic_error non_service_error"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-2 col-lg-4 col-md-4 col-sm-12 col-12 mb-1 non_service_div">
                                                <label class="form_lbl" title="The minimum stock level that triggers a replenishment order to avoid stockouts.">Reorder Point</label>
                                                <input type="number" placeholder="Enter reorder point here" class="form-control mainforminp non_service_input" name="lowStock" id="lowStock" onkeyup="lowStockValidation()" onkeypress="return ValidateNum(event);" />
                                                <span class="text-danger">
                                                    <strong id="lowStock-error" class="errordatalabel basic_error non_service_error"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-2 col-lg-4 col-md-4 col-sm-12 col-12 mb-1 non_service_div">
                                                <label class="form_lbl" title="Identifies the specific lot or shelf location where this product is stored.">Lot Description</label>
                                                <textarea type="text" name="lotDescription" id="lotDescription" placeholder="Enter lot description here" class="form-control mainforminp non_service_input" rows="1" onkeyup="lotDescriptionFn()"></textarea>
                                                <span class="text-danger">
                                                    <strong id="lot_description-error" class="errordatalabel basic_error non_service_error"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-2 col-lg-4 col-md-4 col-sm-12 col-12 mb-1 non_service_div">
                                                <label class="form_lbl" title="A multiplier used to convert or scale quantities in calculations. (For manufacturing)">Factor</label>
                                                <input type="number" placeholder="Enter factor here" class="form-control mainforminp non_service_input" name="factor" id="factor" onkeyup="factorFn()" onkeypress="return ValidateFactorNum(event,this);" />
                                                <span class="text-danger">
                                                    <strong id="factor-error" class="errordatalabel basic_error non_service_error"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-2 col-lg-4 col-md-4 col-sm-12 col-12 mb-1 non_service_div">
                                                <label class="form_lbl" title="Number of pieces contained in a single carton or box.">Cartoon Size</label>
                                                <input type="number" placeholder="Enter cartoon size here" class="form-control mainforminp non_service_input" name="cartoonSize" id="cartoonSize" onkeyup="cartoonSizeFn()" onkeypress="return ValidateNum(event);" />
                                                <span class="text-danger">
                                                    <strong id="cartoon_size-error" class="errordatalabel basic_error non_service_error"></strong>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane item-views tab-view" id="item-inventory-view" aria-labelledby="item-inventory-view" role="tabpanel">
                                        <div class="row mr-1 ml-1 mt-1">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pl-1 pr-1 section-path">
                                                <div class="breadcrumb-path">
                                                    <div class="crumb active"><a>Inventory</a></div>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-12 col-12 mb-1 non_service_div">
                                                <label class="form_lbl" title="Is Serial Number Requires">Is Serial No. Req.</label>
                                                <select class="select2 form-control" name="ReqSerialNumber" id="ReqSerialNumber" onchange="reqSerialNumValidation()">
                                                    <option value="Not-Require">Not-Require</option>
                                                    <option value="Required">Requires</option>
                                                </select>
                                                <span class="text-danger">
                                                    <strong id="requireSerialNumber-error" class="errordatalabel inventory_error non_service_error"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-12 col-12 mb-1 non_service_div">
                                                <label class="form_lbl" title="Is Batch Number or/and Expiry Date Requires">Is Batch No. | Expiry Date Req.</label>
                                                <select class="select2 form-control" name="ReqExpireDate" id="ReqExpireDate" onchange="reqExpDateValidation()">
                                                    <option value="Not-Require">Not-Require</option>
                                                    <option value="Require-ExpireDate">Require-ExpireDate</option>
                                                    <option value="Require-BatchNumber">Require-BatchNumber</option>
                                                    <option value="Require-Both">Require-Both</option>
                                                </select>
                                                <span class="text-danger">
                                                    <strong id="requireExpireDate-error" class="errordatalabel inventory_error non_service_error"></strong>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane item-views tab-view" id="item-purchase-view" aria-labelledby="item-purchase-view" role="tabpanel">
                                        <div class="row mr-1 ml-1 mt-1">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pl-1 pr-1 section-path">
                                                <div class="breadcrumb-path">
                                                    <div class="crumb active"><a>Purchase</a></div>
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-lg-4 col-md-4 col-sm-12 col-12 mb-1 non_service_div non_editable_containers">
                                                <label class="form_lbl">Group</label>
                                                <div class="row">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input item_group_class non_service_checkbox" id="item_group_local" name="item_group[]" value="Local"/>
                                                            <label class="custom-control-label" for="item_group_local">Local</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input item_group_class non_service_checkbox" id="item_group_imported" name="item_group[]" value="Imported"/>
                                                            <label class="custom-control-label" for="item_group_imported">Imported</label>
                                                        </div>
                                                    </div>
                                                    <span class="text-danger ml-1">
                                                        <strong id="group-error" class="errordatalabel non_service_error"></strong>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-xl-10 col-lg-4 col-md-4 col-sm-12 col-12 mb-1 non_service_div">
                                                <fieldset class="fset">
                                                    <legend class="mb-0">Supplier</legend>
                                                    <div class="row">
                                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                            <div class="table-responsive pr-0 pl-0" style="width: 100%;overflow-x: auto;-webkit-overflow-scrolling: touch;margin: 0 0rem;padding: 0 1rem;">
                                                                <table id="dynamicTable" class="mb-0 rtable form_dynamic_table fit-content" style="width:100%;min-width: 900px;">  
                                                                    <thead>
                                                                        <tr>
                                                                            <th class="form_lbl" style="width:3%;">#</th>
                                                                            <th class="form_lbl" style="width:25%;" title="Code, Name, TIN">Supplier<b style="color:red;">*</b></th>
                                                                            <th class="form_lbl" style="width:10%;" title="Unit of Measurement">UOM<b style="color:red;">*</b></th>
                                                                            <th class="form_lbl" style="width:12%;">Quantity<b style="color:red;">*</b></th>
                                                                            <th class="form_lbl" style="width:12%;">Price</th>
                                                                            <th class="form_lbl" style="width:15%;">Availability<b style="color:red;">*</b></th>
                                                                            <th class="form_lbl" style="width:20%;">Remark</th>
                                                                            <th class="form_lbl" style="width:3%;"></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody></tbody>
                                                                    <tfoot>
                                                                        <tr>
                                                                            <td colspan="5" style="text-align: left !important;border: none;">
                                                                                <button type="button" name="adds" id="adds" class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i> Add New</button>
                                                                            </td>
                                                                        </tr>
                                                                    </tfoot>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane item-views tab-view" id="item-sales-view" aria-labelledby="item-sales-view" role="tabpanel">
                                        <div class="row mr-1 ml-1 mt-1">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pl-1 pr-1 section-path">
                                                <div class="breadcrumb-path">
                                                    <div class="crumb active"><a>Sales</a></div>
                                                </div>
                                            </div>
                                            <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9 col-12 mb-1">
                                                <fieldset class="fset">
                                                    <legend class="mb-0">
                                                        <div class="row">
                                                            <div class="col-xl-6 col-lg-9 col-md-9 col-sm-9 col-12">Pricing</div>
                                                            <div class="col-xl-6 col-lg-9 col-md-9 col-sm-9 col-12" style="text-align: right">
                                                                <div class="demo-inline-spacing" style="justify-content:flex-end;font-weight:400;">
                                                                    <div class="custom-control custom-radio mt-0">
                                                                        <input type="radio" id="price_type1" name="price_type" class="custom-control-input" value="Flexible"/>
                                                                        <label class="custom-control-label form_lbl" for="price_type1">Flexible</label>
                                                                    </div>
                                                                    <div class="custom-control custom-radio mt-0 mr-0">
                                                                        <input type="radio" id="price_type2" name="price_type" class="custom-control-input" value="Fixed"/>
                                                                        <label class="custom-control-label form_lbl" for="price_type2">Fixed</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </legend>
                                                    <div class="row">
                                                        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-12 col-12 mb-1 flexible_attribute">
                                                            <fieldset class="fset2">
                                                                <legend class="mb-0">Minimum Price</legend>
                                                                <div class="row">
                                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                                                        <label class="form_lbl">Before Tax<b style="color: red; font-size:16px;">*</b></label>
                                                                        <input type="number" name="MinSellingPriceBeforeTax" id="MinSellingPriceBeforeTax" step="any" placeholder="Enter min price (before tax) here" class="form-control mainforminp flexible_input" onkeyup="minSellingPriceBeforeTaxFn()" onkeypress="return ValidateNum(event);" onblur="minVerifyPriceBeforeTaxFn()"/>
                                                                        <span class="text-danger">
                                                                            <strong id="min_selling_price_bt_error" class="errordatalabel sales_error flexible_error minimum_price_error"></strong>
                                                                        </span>
                                                                    </div>
                                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                        <label class="form_lbl">After Tax<b style="color: red; font-size:16px;">*</b></label>
                                                                        <input type="number" name="MinSellingPriceAfterTax" id="MinSellingPriceAfterTax" step="any" placeholder="Enter min price (after tax) here" class="form-control mainforminp flexible_input" onkeyup="minSellingPriceAfterTaxFn()" onkeypress="return ValidateNum(event);" onblur="minVerifyPriceAfterTaxFn()"/>
                                                                        <span class="text-danger">
                                                                            <strong id="min_selling_price_at_error" class="errordatalabel sales_error flexible_error minimum_price_error"></strong>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-12 col-12 mb-1">
                                                            <fieldset class="fset2">
                                                                <legend class="mb-0">Default Price</legend>
                                                                <div class="row">
                                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                                                        <label class="form_lbl">Before Tax<b style="color: red; font-size:16px;">*</b></label>
                                                                        <input type="number" name="SellingPriceBeforeTax" id="SellingPriceBeforeTax" step="any" placeholder="Enter default price (before tax) here" class="form-control mainforminp" onkeyup="sellingPriceBeforeTaxFn()" onkeypress="return ValidateNum(event);" onblur="defaultVerifyPriceBeforeTaxFn()"/>
                                                                        <span class="text-danger">
                                                                            <strong id="selling_price_bt_error" class="errordatalabel sales_error default_price_error"></strong>
                                                                        </span>
                                                                    </div>
                                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                        <label class="form_lbl">After Tax<b style="color: red; font-size:16px;">*</b></label>
                                                                        <input type="number" name="SellingPriceAfterTax" id="SellingPriceAfterTax" step="any" placeholder="Enter default price (after tax) here" class="form-control mainforminp" onkeyup="sellingPriceAfterTaxFn()" onkeypress="return ValidateNum(event);" onblur="defaultVerifyPriceAfterTaxFn()"/>
                                                                        <span class="text-danger">
                                                                            <strong id="selling_price_at_error" class="errordatalabel sales_error default_price_error"></strong>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-12 col-12 mb-1 flexible_attribute">
                                                            <fieldset class="fset2">
                                                                <legend class="mb-0">Maximum Price</legend>
                                                                <div class="row">
                                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                                                        <label class="form_lbl">Before Tax<b style="color: red; font-size:16px;">*</b></label>
                                                                        <input type="number" name="MaxSellingPriceBeforeTax" id="MaxSellingPriceBeforeTax" step="any" placeholder="Enter max price (before tax) here" class="form-control mainforminp flexible_input" onkeyup="maxSellingPriceBeforeTaxFn()" onkeypress="return ValidateNum(event);" onblur="maxVerifyPriceBeforeTaxFn()"/>
                                                                        <span class="text-danger">
                                                                            <strong id="max_selling_price_bt_error" class="errordatalabel sales_error flexible_error maximum_price_error"></strong>
                                                                        </span>
                                                                    </div>
                                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                        <label class="form_lbl">After Tax<b style="color: red; font-size:16px;">*</b></label>
                                                                        <input type="number" name="MaxSellingPriceAfterTax" id="MaxSellingPriceAfterTax" step="any" placeholder="Enter max price (after tax) here" class="form-control mainforminp flexible_input" onkeyup="maxSellingPriceAfterTaxFn()" onkeypress="return ValidateNum(event);" onblur="maxVerifyPriceAfterTaxFn()"/>
                                                                        <span class="text-danger">
                                                                            <strong id="max_selling_price_at_error" class="errordatalabel sales_error flexible_error maximum_price_error"></strong>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </fieldset>
                                                        </div>

                                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12 mb-1 non_service_div" style="text-align: right;">
                                                            <table style="width: 100%;font-size:12px;" class="rtable text-center">
                                                                <tr>
                                                                    <td colspan="3">
                                                                        <label class="info_lbl" style="font-weight: bold;">Product Cost</label>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl" style="font-weight: bold;">Cost Type</label></td>
                                                                    <td><label class="info_lbl" style="font-weight: bold;">Before Tax</label></td>
                                                                    <td><label class="info_lbl" style="font-weight: bold;">After Tax</label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td title="Minimum Cost"><label class="info_lbl">Min. Cost</label></td>
                                                                    <td><label class="info_lbl min_cost_bt_lbl" id="mincostbvlbl"></label></td>
                                                                    <td><label class="info_lbl min_cost_at_lbl" id="mincostlbl"></label></td>
                                                                </tr>
                                                                <tr id="averagecostabletr">
                                                                    <td title="Average Cost"><label class="info_lbl">Avg. Cost</label></td>
                                                                    <td><label class="info_lbl avg_cost_bt_lbl" id="averagecostbvlbl"></label></td>
                                                                    <td><label class="info_lbl avg_cost_at_lbl" id="averagecostlbl"></label></td>
                                                                </tr>
                                                                <tr id="maxcostabletr">
                                                                    <td title="Maximum Cost"><label class="info_lbl">Max. Cost</label></td>
                                                                    <td><label class="info_lbl max_cost_bt_lbl" id="maxcostbvlbl"></label></td>
                                                                    <td><label class="info_lbl max_cost_at_lbl" id="maxcostlbl"></label></td>
                                                                </tr>
                                                            </table>
                                                            
                                                        </div>

                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-xl-3 col-lg-9 col-md-9 col-sm-9 col-12 mb-1">
                                                <label class="form_lbl">Compatible Products</label>
                                                <select class="select2 form-control" name="CompatibleProducts[]" id="CompatibleProducts" multiple onchange="compatibleProductFn()"></select>
                                                <span class="text-danger">
                                                    <strong id="compatible_products-error" class="errordatalabel sales_error"></strong>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane item-views tab-view" id="item-others-view" aria-labelledby="item-others-view" role="tabpanel">
                                        <div class="row mr-1 ml-1 mt-1">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pl-1 pr-1 section-path">
                                                <div class="breadcrumb-path">
                                                    <div class="crumb active"><a>Others</a></div>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-12 col-12 mb-1 non_service_div" id="barcode_div">
                                                <label class="form_lbl">Barcode</label>
                                                <div id="barcodeDiv">
                                                    <div class="text-center">
                                                        <b><label id="barcodeCode"></label></b>
                                                    </div>
                                                    <div id="barcodeimages" class="text-center" style="display: none;"></div>
                                                    <div id="barcodeimagesupdate" class="text-center" style="display: none;"></div>
                                                    <div class="custom-control custom-control-primary custom-checkbox mt-1" id="printbardiv">
                                                        <input type="checkbox" class="custom-control-input non_service_checkbox" id="printBar" name="printBar"/>
                                                        <label class="custom-control-label" for="printBar">Print Barcode</label>
                                                        <input type="hidden" class="form-control" name="checkboxVali" id="checkboxVali" readonly/>
                                                    </div>

                                                    <div style="padding-left: 20%">
                                                        <b><label id="barcodeNumberss"></label></b>
                                                        <b><label id="barcodeNumber"></label></b>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <section id="section-block" style="display:none;">
                            <div class="row">
                                <div class="col-md-9" id="itemsdiv">
                                    <div class="row" id="headerblock">
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2" id="withDiv" style="display: none;">
                                            <label strong style="font-size: 14px;">Type </label>

                                            
                                            
                                            <div class="" id='typeblock'>
                                                <select class="select2 form-control" name="TypeId" id="TypeId">
                                                    <option value="Goods">Goods</option>
                                                    <option value="Consumption">Consumption</option>
                                                    <option value="Fixed Asset">Fixed Asset</option>
                                                    <option value="Service">Service</option>
                                                </select>
                                            </div>
                                            <span class="text-danger">
                                                <strong id="type-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2" id="GroupDiv" style="display: none;">
                                            <label strong style="font-size: 14px;">Group </label>
                                            <div class="" id="groupblock">
                                                <select class="select2 form-control" data-placeholder="select item group" name="group" id="igroup" onchange="cleargroupvalidation()">
                                                    <option value="" selected disabled></option>
                                                    @can('Local-item-edit')
                                                    <option value="Local">Local</option>
                                                    @endcan
                                                    @can('Import-item-edit')
                                                    <option value="Imported">Imported</option>
                                                    @endcan
                                                </select>
                                            </div>

                                        </div>
                                        
                                    

                                        

                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2 costdiv" style="display: none;">
                                            <label strong style="font-size: 14px;text-align:center;" id="mincostlabel">Min Cost</label>
                                            <div class="input-group">
                                                <input type="number" step="any" placeholder="Before VAT" class="form-control" name="mincostbv" id="mincostbv" onkeyup="copyMinCostBv()" onkeypress="return ValidateNum(event);" style="color:black;font-weight:bold; border-style:solid;" readonly />
                                                <input type="number" step="any" placeholder="After VAT" class="form-control" name="mincost" id="mincost" onkeyup="copyMinCost()" onkeypress="return ValidateNum(event);" readonly/>
                                            </div>
                                            <span class="text-danger">
                                                <strong id="maxcost-error"></strong>
                                            </span>
                                        </div>

                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2 costdiv"  style="display: none;">
                                            <label strong style="font-size: 14px;text-align:center;" id="averagecostlabel">Average Cost</label>
                                            <div class="input-group">
                                                <input type="number" step="any" placeholder="Before VAT" class="form-control" name="averagecostbv" id="averagecostbv" onkeyup="copyAverageCostBv()" onkeypress="return ValidateNum(event);"  @if($setings->costType==1) style="color:green;font-weight:bold; border-style:solid;border-color:green;" @else style="color:black;font-weight:bold; border-style:solid;" @endif  readonly/>
                                                <input type="number" step="any" placeholder="After VAT" class="form-control" name="averagecost" id="averagecost" onkeyup="copyAverageCost()" onkeypress="return ValidateNum(event);" @if($setings->costType==1) style="color:green;border-color:green;" @endif  readonly/>
                                            </div>
                                            <span class="text-danger">
                                                <strong id="maxcost-error"></strong>
                                            </span>
                                        </div>
                                            <div class="col-xl-2 col-md-6 col-sm-12 mb-2 costdiv" style="display: none;">
                                                <label strong style="font-size: 14px;text-align:center;" id="maxcostlabel">Max Cost</label>
                                                <div class="input-group">
                                                    <input type="number" step="any" placeholder="Before VAT" class="form-control" name="maxcostbv" id="maxcostbv" onkeyup="copyMaxCostBv()" onkeypress="return ValidateNum(event);"  @if($setings->costType==0) style="color:green;font-weight:bold; border-style:solid;border-color:green" @else style="color:black;font-weight:bold; border-style:solid;" @endif  readonly />
                                                    <input type="number" step="any" placeholder="After VAT" class="form-control" name="maxcost" id="maxcost" onkeyup="copyMaxCost()" onkeypress="return ValidateNum(event);" @if($setings->costType==0) style="color:green;border-color:green" @endif readonly/>
                                                </div>
                                                <span class="text-danger">
                                                    <strong id="maxcost-error"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-3 col-md-6 col-sm-12 mb-2" id="retailerDiv">
                                                <table style="width: 100%">
                                                    <tr>
                                                        <td><label strong style="font-size: 14px;" id="pmretaillbl">PM %</label></td>
                                                        <td style="width: 50%;"><label strong style="font-size: 14px;" id="lblretailprice">Retail Price</label></td>
                                                        
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <div class="input-group">
                                                            
                                                                <input type="text" step="any" placeholder="PM+%" class="form-control" name="pmretail" id="pmretail" onkeypress="return ValidateNum(event);" onkeyup="calculateretailpercent()" />
                                                                <input type="number" step="any" placeholder="Before VAT" class="form-control" name="retailPricebv" id="retailPricebv" onkeyup="retailerPriceValidationbv()" onkeypress="return ValidateNum(event);" style="color:black;font-weight:bold; border-style:solid;" />
                                                                <input type="number" step="any" placeholder="After VAT" class="form-control" name="retailPrice" id="retailPrice"  onkeyup="retailerPriceValidation()" onkeypress="return ValidateNum(event);" />
                                                            </div>
                                                        </td> 
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <span class="text-danger">
                                                                <strong id="retailPrice-error"></strong>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>

                                            @if($setings->wholesalefeature==1)
                                            <div class="col-xl-6 col-md-6 col-sm-12 mb-2" id="wholesellerDiv">
                                                <table style="width: 100%">
                                                    <tr>
                                                        <td><label strong style="font-size: 14px;">PM %</label></td>
                                                        <td style="width: 50%;"><label strong style="font-size: 14px;">Wholesale Price</label></td>
                                                        <td><label strong style="font-size: 14px;">Min</label></td>
                                                        <td><label strong style="font-size: 14px;">Max</label></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4">
                                                            <div class="input-group">
                                                                <input type="text" step="any" placeholder="PM+%" class="form-control" name="pmwholesale" id="pmwholesale" onkeypress="return ValidateNum(event);" onkeyup="calculatewholesalepercent()" />
                                                                <input type="number" step="any" placeholder="Before VAT" class="form-control" name="wholeSellerPricebv" id="wholeSellerPricebv" onkeyup="wholesellerPriceValidationBv()" onkeypress="return ValidateNum(event);" style="color:black;font-weight:bold; border-style:solid;" />
                                                                <input type="number" step="any" placeholder="After VAT" class="form-control" name="wholeSellerPrice" id="wholeSellerPrice" onkeyup="wholesellerPriceValidation()" onkeypress="return ValidateNum(event);" />
                                                                <input type="number" step="any" placeholder="Min qty" class="form-control" name="wholeSellerMinAmount" id="wholeSellerMinAmount" onkeyup="wholeSellerMinAmountValidation()" onkeypress="return ValidateNum(event);" readonly />
                                                                <input type="number" step="any" placeholder="Max qty" class="form-control" name="wholeSellerMaxAmount" id="wholeSellerMaxAmount" onkeyup="wholeSellerMaxAmountValidation()" onkeypress="return ValidateNum(event);" readonly />
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <span class="text-danger">
                                                                <strong id="wholeSellerPrice-error"></strong>
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="text-danger">
                                                                <strong id="wholeSellerMinAmount-error"></strong>
                                                            </span>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                </table>                                              
                                            </div>
                                            @endif
                                            
                                        @if($setings->wholesalefeature==1)
                                            <div class="col-xl-3 col-md-6 col-sm-12 mb-2" id="minimumstockdiv">
                                                <table style="width: 100%">
                                                    <tr>
                                                        <td>
                                                            <label strong style="font-size: 14px;">Avalibale Stock</label>
                                                        </td>
                                                        <td>
                                                            <label strong style="font-size: 14px;">Minimum Stock</label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <div class="input-group">
                                                                <input type="number" step="any" placeholder="Avaliable Stock" class="form-control" name="balance" id="balance" onkeyup="minimumstockValidation()" onkeypress="return ValidateNum(event);" readonly />
                                                                <input type="number" step="any" placeholder="Minimum Stock" class="form-control" name="minimumstock" id="minimumstock" onkeyup="minimumstockValidation()" onkeypress="return ValidateNum(event);" />
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>
                                                            <span class="text-danger">
                                                                <strong id="minimumstock-error"></strong>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                            @endif
                                        
                                            
                                            
                                       
                                        
                                        
                                        
                                        
                                        @php
                                            $sk = $setings->prefix . $setings->skunumber;
                                        @endphp
                                       
                                    </div> <!-- end row-->
                                </div>
                                <div class="col-md-3"  id="purchasedi" style="display: none;">
                                    <section id="card-demo-example">
                                        <div class="row match-height">
                                            <div class="col-md-12 col-lg-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h4 class="card-title">Product-Purchase Cost</h4>
                                                        <div class="table-responsive">
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-12 col-lg-12">
                                                
                                            </div>
                                        </div>
                                    </section>
                                </div>
                        </section>



                    </div>
                    <div class="modal-footer">
                        <div style="display: none;">
                            <select class="select2 form-control" name="supplier_default" id="supplier_default">
                                <option selected disabled value=""></option>
                                @foreach ($supplier_data as $s_data)
                                    <option value="{{ $s_data->id }}">{{ $s_data->customer}}</option>
                                @endforeach
                            </select>

                            <select class="select2 form-control" name="uom_default" id="uom_default">
                                <option selected disabled value=""></option>
                                @foreach ($uom as $u_data)
                                    <option value="{{ $u_data->id }}">{{ $u_data->Name }}</option>
                                @endforeach
                            </select>

                            <select class="select2 form-control" name="item_default" id="item_default">
                                <option selected disabled value=""></option>
                                @foreach ($item_data as $i_data)
                                    <option data-type="{{$i_data->Type}}" value="{{ $i_data->id }}">{{ $i_data->Name }}</option>
                                @endforeach
                            </select>

                            <input type="hidden" class="form-control mainforminp" name="id" id="ids" value=""/>
                            <input type="hidden" class="form-control" name="notifiablemaxcostid" id="notifiablemaxcostid" />
                            <input type="hidden" class="form-control" name="notifiablereailerpriceid" id="notifiablereailerpriceid" />
                            <input type="hidden" class="form-control" name="notifiablewholesellerpriceid" id="notifiablewholesellerpriceid" />
                            <input type="hidden" class="form-control" name="operationType" id="operationType" value="1"/>
                            <input type="hidden" class="form-control" name="IsNewItemCode" id="IsNewItemCode" value=""/>
                            <input type="hidden" class="form-control" name="OldItemCode" id="OldItemCode" value=""/>
                            <input type="hidden" class="form-control" name="ItemCodeMode" id="ItemCodeMode" value=""/>
                            <input type="hidden" class="form-control" name="codeHidden" id="codeHidden" value=""/>
                            <input type="hidden" class="form-control" name="skuNumberHidden" id="skuNumberHidden" value="" />
                            <input type="hidden" class="form-control" name="BarcodeTypes" id="BarcodeTypes" value="None" />
                            <input type="hidden" class="form-control mainforminp" name="BarcodeTypesupdate" id="BarcodeTypesupdate" value="None" />
                            <input type="hidden" class="form-control" name="skgenerate" id="skgenerate" />
                            <input type="hidden" class="form-control" name="lastbarcode" id="lastbarcode" value="" />
                            <input type="hidden" class="form-control" name="barcoderequire" id="barcoderequire" value="{{ $setings->BarcodeRequire }}" readonly/>
                            <input type="hidden" class="form-control" placeholder="max cost" name="maxcosti" id="maxcosti" />
                            <input type="hidden" class="form-control" placeholder="max cost" name="averageCostInp" id="averageCostInp" />
                            <input type="hidden" class="form-control" placeholder="max cost" name="minCostInp" id="minCostInp" />
                            <input type="hidden" class="form-control" name="pmwholesalehidden" id="pmwholesalehidden" readonly/>
                            <input type="hidden" class="form-control" name="pmretailhidden" id="pmretailhidden" readonly/>
                            <input type="hidden" class="form-control" name="retailPricehidden" id="retailPricehidden" readonly/>
                            <input type="hidden" class="form-control" name="wholeSellerPricehidden" id="wholeSellerPricehidden" readonly/>
                        </div>
                        <button id="savebutton" type="button" class="btn btn-info waves-effect waves-float waves-light">Save</button>
                        <button id="closebuttonitem" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- end of item Register --}}




<div class="modal fade text-left" id="deleteitem" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Item Delete </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                    onclick="closeModalWithClearValidation()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="itemdeleteform">
                @csrf
                <div class="modal-body">
                    <label strong style="font-size: 16px;">Are you sure you want to delete</label>
                    <div class="form-group">
                        <input type="hidden" placeholder="id" class="form-control" name="did" id="did">
                        <span class="text-danger">
                            <strong id="uname-error"></strong>
                        </span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="deletebtnitem" type="button" class="btn btn-info">Delete</button>
                    <button id="closebutton" type="button" class="btn btn-danger"
                        onclick="closeModalWithClearValidation()" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
    <!--Begin upload image -->
    <div class="modal modal-slide-in event-sidebar fade" id="imageuploadmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y:scroll;">
            <div class="modal-dialog modal-dialog-scrollable sidebar-xl" style="width: 90%;">
                <div class="modal-content p-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="checkforefresh()">×</button>
                    <div class="modal-header mb-1">
                        <h5 class="modal-title">Upload multiple images</h5>
                    </div>
                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                        <form action="{{ route('dropzone.upload') }}" class="dropzone dropzone-area" id="dropzoneForm">
                            <div class="dz-message">Drop files here or click to upload.
                            </div>
                            <input type="hidden" name="regitemsid" id="regitemsid">
                        </form>
                        <div class="card" id="imagePanel">
                            <h4 class="card-title">Uploaded images</h4>
                            <div class="card-body">
                                <div class="row" id="appimages">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col-xl-12 col-lg-12">
                            <div class="row">
                                <div class="col-xl-8 col-lg-12">
                                    <button type="button" id="submit-all" class="btn btn-outline-dark"><i class="fa-regular fa-cloud-arrow-up"></i>Upload</button>
                                </div>
                                <div class="col-xl-4 col-lg-12" style="text-align:right;">
                                    <button  type="button" class="btn btn-danger" data-dismiss="modal" onclick="checkforefresh()">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!--End upload image -->

    @include('layout.universal-component')

    <script type="text/javascript">
        var gblIndex = 0;
        var itemtable = '';
        var focustables = '';
        var errorcolor = "#ffcccc";
        var j = 0;
        var i = 0;
        var m = 0;
        var can_change_prd_class = true;
        var product_class_global_var = "";
        var options1 = {
            width: 500,
            zoomWidth: 500,
            offset: {vertical: 0, horizontal: 10},"zoomPosition":"left"
        };

        // If the width and height of the image are not known or to adjust the image to the container of it
        var options2 = {
            fillContainer: true,
            offset: {vertical: 0, horizontal: 10,"zoomPosition":"left","scale":"2"}
        };
        new ImageZoom(document.getElementById("img-container"), options2);

        //start checkbox change function
        Dropzone.options.dropzoneForm = {
            autoProcessQueue: false,
            acceptedFiles: ".png,.jpg,.gif,.bmp,.jpeg",
            addRemoveLinks: true,
            init: function() {
                var submitButton = document.querySelector("#submit-all");
                myDropzone = this;
                submitButton.addEventListener('click', function() {
                    myDropzone.processQueue();
                    var id = $('#regitemsid').val();
                    load_images(id);
                    $('#imagePanel').show();
                });
                this.on("complete", function() {
                    if (this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0) {
                        var _this = this;
                        _this.removeAllFiles();
                    }
                    var id = $('#regitemsid').val();
                    load_images(id);
                });
            }
        };
        
        function ValidateFactorNum(evt, element) {
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            // Allow numbers (0-9)
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                // Allow a single decimal point (.)
                if (charCode === 46) {
                    // If a decimal point already exists in the input field value, block the second one
                    if (element.value.indexOf('.') !== -1) {
                        return false;
                    }
                    return true;
                }
                return false;
            }
            return true;
        }
        
        $('.filter-select').change(function(){
            var activetab = $('ul#apptabs li a.active').closest('li').attr('id')
            var search = [];
            $.each($('.filter-select option:selected'), function(){
                search.push($(this).val());
            });
            search = search.join('|');
            itemtable.column(5).search(search, true, false).draw();
        });

        $(function() {
            tableSection = $('#table-block');
            sectionBlock = $('#section-block');
            pageSection = $('#page-blocks');
            tableSection = $('.tableSection');
            headerSection = $('#headerblock');
            withDivSection = $('#typeblock');
            GroupDivSection = $('#groupblock');
            codeDivSection = $('#codeblock');
            nameDivSection = $('#nameblock');
            uomDivSection = $('#uomblock');
            categoryDivSection = $('#categoryblock');
            productCodeSection = $('#product_code_div');
            $("#printBar").click(function() {
                if ($(this).is(":checked")) {
                    $('#checkboxVali').val('1');
                } else {
                    $('#checkboxVali').val('0');
                }
            });
        });
        // Multiple Files
        $('#multipleimageuploadbutton').click(function(){
            var id=$('#regitemsid').val();
            load_images(id);
        });
        $('#imageuploadbutton').click(function(){
            var id=$('#ids').val();
            $('#itemsid').val(id);
            $('#regitemsid').val(id);
            $('#imageuploadmodal').modal('show');
            load_images(id);
        });

        $(document).on('click', '.remove-wishlist', function() {
            var name = $(this).attr('id');
            removeitemimages(name);
        });

        function load_images(id) {
            $.ajax({
                type: "GET",
                url: "dropzone/fetch/" + id,
                beforeSend: function () {
                        pageSection.block({
                        message:
                        '<div class="d-flex justify-content-center align-items-center"><p class="mr-50 mt-0">Loading Please wait...</p><div class="spinner-grow spinner-grow-sm text-white" role="status"></div> </div>',
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
                        pageSection.block({
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
                success: function(response) {
                    $("#appimages").empty();
                    switch (response.success) {
                        case 1:
                            $.each(response.images, function (indexInArray, valueOfElement) { 
                                $("#appimages").append('<div class="col-md-3"><img src="itemimage/'+valueOfElement.imagename+'" class="w-100" style="width:200px; height:200px;" /><div class="item-options text-center"><a href="#" class="btn btn-light btn-wishlist remove-wishlist" id="'+valueOfElement.id+'">Remove</a></div></div>');
                            });
                            $('#imagePanel').show();
                            break;
                        default:
                            $('#imagePanel').hide();
                            break;
                    }
                }
            })
        }

        function removeitemimages(params) {
                swal.fire({
                    title: 'Notice!',
                    icon: 'question',
                    html: "Are you sure do you want to remove this picture",
                    showCancelButton: !0,
                    allowOutsideClick: false,
                    confirmButtonClass: "btn-info",
                    confirmButtonText: "Remove",
                    cancelButtonText: "Cancel",
                    cancelButtonClass: "btn-danger",
                    reverseButtons: !0
            }).then(function (e) {
                if (e.value === true) {
                    let token = $('meta[name="csrf-token"]').attr('content');
                        $.ajax({
                            type: 'GET',
                            url: "{{ route('dropzone.delete') }}",
                                data: {
                                name: params
                            },
                            success: function (resp) {
                                if (resp.success) {
                                    toastrMessage('success',resp.success,'success');
                                    var id=$('#regitemsid').val();
                                    load_images(id);
                                } else {
                                    swal.fire("Whoops!", 'Something went wrong please contact support team.', "error");
                            
                                }
                            },
                            error: function (resp) {
                                swal.fire("Error!", 'Something went wrong.', "error");
                            }
                        });
                } else {
                    e.dismiss;
                }
            }, function (dismiss) {
                return false;
            })
        }

        function refreshtbl1(){
            var oTable = $(focustables).dataTable(); 
            oTable.fnDraw(false);
        }

        function clearpercernterror(){
            $('#batchpercent-error').html('');
            $('#batchupadtepreviewbutton').show();
        }

        $('#batchgroup').on ('change', function () {
            $('#batchgroup-error').html('');
            $("#batchcategory").attr('disabled',false);
            $('#batchcategory').selectpicker('refresh');
        });

        $('#batchitem').on ('change', function () {
            $('#batchitem-error').html('');
            $('#increaseDescrease').attr("disabled", false);
            $('#increaseDescrease').selectpicker('refresh'); 
        });

        $('#increaseDescrease').on ('change', function () {
            $('#increaseDescrease-error').html('');
            $('#percent').attr("disabled", false);
            var incr=$('#increaseDescrease').val()||0;
            if(incr==1){
                $("#percent").attr({ style: "color:green;font-weight:bold;border-style:solid;border-color:green;" });
            }
            else if(incr==2){
                $("#percent").attr({ style: "color:#ff9f43;font-weight:bold;border-style:solid;border-color:#ff9f43;" });
            }
        });

        $('#batchcategory').on ('change', function () {
            $('#batchcategory-error').html('');
            $("#batchitem").attr('disabled',false);
            $('#batchitem').selectpicker('refresh');
            var cate=$('#batchcategory').val()||0;
            $('#batchitem').empty();
            var registerForm = $("#batchupdateform");
            var formData = registerForm.serialize();
            if(cate!=0){
                $.ajax({
                    type: "POST",
                    url: "getbatchitem",
                    data: formData,
                    dataType: "json",
                    success: function (response) {
                        if(response.errors){
                            if(response.errors.itemGroup){
                                $('#batchgroup-error').html(response.errors.itemGroup[0]);
                                $('#batchcategory').val(null).trigger('change');
                            }
                        }else{
                            $.each(response.items, function (index, value) { 
                            var optionedit = "<option value='"+value.id+"'>"+value.Code+","+value.Name+","+value.SKUNumber+"</option>";
                            $("#batchitem").append(optionedit);
                        });
                        $('#batchitem').selectpicker('refresh');
                        }
                    }
                });
            }
        });

        function itemslistbytab(params) {
            switch (params) {
                case 'all':
                    focustables='#itemdataables';
                    itemdatalist('#itemdataables','All');
                    break;
                case 'allgoods':
                    focustables='#goodsitemdataables';
                    itemdatalist('#goodsitemdataables','Goods');
                    break;
                    case 'fixedasset':
                    focustables='#fixedassetitemdataables';
                    itemdatalist('#fixedassetitemdataables','fixedasset');
                    break;
                    case 'service':
                        focustables='#serviceitemdataables';
                        itemdatalist('#serviceitemdataables','service');
                    break;
                default:
                    focustables='#consumptionitemdataables';
                    itemdatalist('#consumptionitemdataables','consumption');
                    break;
            }
        }

        function setFocus(){ 
            $($(focustables+' tbody > tr')[gblIndex]).addClass('selected');  
        }

        function checkforefresh(){
            $('.sideImage').html('');
            $('#carouselExampleFade').html('');
            var id=$('#regitemsid').val();
            $.ajax({
                type: "GET",
                url: "{{ url('checkitemimage') }}/"+id,
                success: function (response) {
                    switch (response.success) {
                        case 1:
                            $('#img-container').show();
                            setitemimages(response.images);
                            break;
                        default:
                            shownoimages();
                            $('#img-container').hide();
                            break;
                    }
                }
            });
        }

        function setitemimages(images) {
            $.each(images, function (indexInArray, valueOfElement) { 
                if(parseInt(indexInArray) == 0){
                    $('#featured').attr('src','itemimage/'+valueOfElement.imagename);
                }
                $('.sideImage').append('<div class="col-md-3 imageforhover"><img src="itemimage/'+valueOfElement.imagename+'" class="w-100" style="width:70px; height:70px;"></div>');
            });
        }

        $(document).on('mousedown', '.imageforhover img', function() {
            var path = $(this).attr('src');
            $('#featured').attr('src', path);
        });

        function shownoimages() {
            $('#carouselExampleFade').append(
            `<section id="alerts-closable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <p class="card-text"></p>
                                <div class="demo-spacing-0">
                                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                                        <div class="alert-body">
                                            There is no image to show related to this product.
                                        </div>
                                    </div>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>`);
        }

        function setItemPrice(retailprice,wholesaleprice,retailpricebv,wholesalepricebv,maxreturn,pendingqty,minstock,balance,minamount,maxcost){
                balance=parseFloat(balance)-parseFloat(pendingqty);
                
            if(parseFloat(maxcost)>parseFloat(retailprice)){
                    var unc= '<span class="badge badge-light-danger">unc</span>';
                    $('#rpInfoLblav').html(unc);
                    $('#rpInfoLblbv').html(unc);
            } else{
                if(balance<=0){
                retailprice="<p style='text-decoration:line-through;text-decoration-color:red;'>"+retailprice+"</p>"; 
                retailpricebv="<p style='text-decoration:line-through;text-decoration-color:red;'>"+retailpricebv+"</p>";
                $('#rpInfoLblav').html(retailprice);
                $('#rpInfoLblbv').html(retailpricebv);
                } else{
                    $('#rpInfoLblav').html(numformat(retailprice));
                    $('#rpInfoLblbv').html(numformat(retailpricebv));
                }
            }
            if(parseFloat(maxcost)>parseFloat(wholesaleprice)){
                var unc= '<span class="badge badge-light-danger">unc</span>';
                    $('#wsInfoLblav').html(unc);
                    $('#wsInfoLblbv').html(unc);
            } else{
                    if(parseFloat(balance)<=0 || parseFloat(balance)<parseFloat(minstock) || parseFloat(balance)<parseFloat(minamount) || parseFloat(maxreturn)<parseFloat(minamount)){
                            switch (minstock) {
                                case 0:
                                    maxreturn='';
                                    break;
                                default:
                                    if(parseFloat(maxreturn)<=0){
                                            maxreturn='';
                                        } else{
                                            maxreturn=maxreturn;     
                                        }
                                    break;
                            }
                        var wsbv="<p style='text-decoration:line-through;text-decoration-color:red;'>"+wholesalepricebv+"</p>";
                        var ws="<p style='text-decoration:line-through;text-decoration-color:red;'>"+wholesaleprice+"</p>"; 
                        minamount="<p style='text-decoration:line-through;text-decoration-color:red;'>"+minamount+"</p>";
                        maxreturn="<p style='text-decoration:line-through;text-decoration-color:red;'>"+maxreturn+"</p>";
                        $('#wsInfoLblav').html(ws);
                        $('#wsInfoLblbv').html(wsbv);
                        $('#wsminInfoLbl').html(minamount);
                        $('#wsmaxInfoLbl').html(maxreturn);
                } else{  
                    switch (minstock) {
                        case 0:
                            maxreturn='';
                            break;
                        default:
                            if(parseFloat(maxreturn)<=0){
                                    maxreturn='';
                                } else{
                                    maxreturn=maxreturn;     
                                }
                            break;
                    }    
                    $('#wsInfoLblav').html(wholesaleprice);
                    $('#wsInfoLblbv').html(wholesalepricebv);
                    $('#wsminInfoLbl').html(minamount);
                    if(parseFloat(maxreturn)<parseFloat(minamount)){
                        $('#wsmaxInfoLbl').html('');
                    } else{
                        $('#wsmaxInfoLbl').html(maxreturn);
                    }
                }
            }
            
        }

        function setAccessDeniedItemPrice(){
        
        }

        function setPriceInformation(mincostbv,mincost,avgcostbv,avgcost,maxcostbv,maxcost,rpm,wspm,retailprice,wholesaleprice){
            $('#mincostInfoLblbv').text(numformat(mincostbv));
            $('#mincostInfoLblav').text(numformat(mincost));
            $('#averageInfoLblbv').text(numformat(avgcostbv));
            $('#averageInfoLblav').text(numformat(avgcost));
            $('#maxcostInfoLblbv').text(numformat(maxcostbv));
            $('#maxcostInfoLblav').text(numformat(maxcost));
            if(retailprice==''){
                $('#rppmInfoLbl').text('');
            } else{
                if(rpm==null){
                    $('#rppmInfoLbl').text('');
                } else{
                    $('#rppmInfoLbl').text(rpm+' %');
                    }
            }
            if(wholesaleprice==''){
                $('#wspmInfoLbl').text('');
            } else{
                if(wspm==null){
                $('#wspmInfoLbl').text('');
                } else{
                    $('#wspmInfoLbl').text(wspm+' %');
                }
            }
        }

        function setAccessDeniedinformation(){
            $('#mincostInfoLblbv').html('Access Denied!');
            $('#mincostInfoLblav').html('Access Denied!');
            $('#averageInfoLblbv').html('Access Denied!');
            $('#averageInfoLblav').html('Access Denied!');
            $('#maxcostInfoLblbv').html('Access Denied!');
            $('#maxcostInfoLblav').html('Access Denied!');
            $('#wspmInfoLbl').html('Access Denied!');
            $('#rppmInfoLbl').html('Access Denied!');

            $("#mincostInfoLblbv").addClass("badge badge-pill badge-light-danger mr-1");
            $("#mincostInfoLblav").addClass("badge badge-pill badge-light-danger mr-1");
            $('#averageInfoLblbv').addClass('badge badge-pill badge-light-danger mr-1');
            $("#averageInfoLblav").addClass("badge badge-pill badge-light-danger mr-1");
            $("#maxcostInfoLblbv").addClass("badge badge-pill badge-light-danger mr-1");
            $('#maxcostInfoLblav').addClass('badge badge-pill badge-light-danger mr-1');
            
            $('#rppmInfoLbl').addClass('badge badge-pill badge-light-danger mr-1');
            $('#wspmInfoLbl').addClass('badge badge-pill badge-light-danger mr-1');
            
        }

        function removeColorAccessDeniedinformation(){
            $("#mincostInfoLblbv").removeClass("badge badge-pill badge-light-danger mr-1");
            $("#mincostInfoLblav").removeClass("badge badge-pill badge-light-danger mr-1");
            $('#averageInfoLblbv').removeClass('badge badge-pill badge-light-danger mr-1');
            $("#averageInfoLblav").removeClass("badge badge-pill badge-light-danger mr-1");
            $("#maxcostInfoLblbv").removeClass("badge badge-pill badge-light-danger mr-1");
            $('#maxcostInfoLblav').removeClass('badge badge-pill badge-light-danger mr-1');

            $('#rppmInfoLbl').removeClass('badge badge-pill badge-light-danger mr-1');
            $('#wspmInfoLbl').removeClass('badge badge-pill badge-light-danger mr-1');
        }

        function codeActive(){
            $('#code').prop('readonly', false);
        }

        function generatecode(){
            var itcodetype = null;
            $("#generate_item_code").hide();
            $.get("getitemcodes",function (data, textStatus, jqXHR) {
                $.each(data.setings, function (index, value) {
                    itcodetype = value.ItemCodeType;
                });

                if(parseInt(itcodetype) == 1){
                    $('#code').val(data.docNumber);
                    $("#generate_item_code").show();
                }
            });
            
            $("#newcodegenerate").hide();
            $('#code-error').html('');
        }
        
        $('body').on('click', '.batchupdate', function() {
            $("#batchupdateformodal").modal('show');
            $('#batchcategory').attr("disabled", true); 
            $('#batchcategory').selectpicker('refresh');
            $('#increaseDescrease').attr("disabled", true); 
            $('#increaseDescrease').selectpicker("refresh");
            $('#percent').attr("disabled", true); 
            $('#batchitem').attr("disabled", true); 
            $('#batchitem').selectpicker('refresh');
            $('#batchupadtepreviewbutton').hide();
            $('#batchupdatedatablediv').hide();
            $('#dividerdiv').hide();
            $('#batchupadtesavebutton').hide();
        });


        //****************************************
        //****************************************
        //****************************************
        //****************************************
        //****************************************
        //Starting a new modification.......

        $(document).ready(async function(){
            $("#newcodegenerate").hide();
            $("#barcodeDiv").hide();
            $("#imagepreview").hide();
            var weight = window.innerHeight;
            await itemdatalist('#itemdataables','All');
        });

        function itemdatalist(tables,type){
            itemtable = $('#itemdataables').DataTable({
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
                //scrollY:'100%',
                scrollY:'65vh',
                scrollX: true,
                scrollCollapse: true, 
                deferRender: true,
                fixedHeader:true,
                dom: "<'row'<'col-sm-3 col-md-2 col-6'f><'col-sm-3 col-md-2 col-6 mt-1'><'col-sm-3 col-md-2 col-6 mt-1'><'col-sm-3 col-md-2 col-6 mt-1'><'col-sm-3 col-md-2 col-6 mt-1 custom-4'><'col-sm-3 col-md-2 col-6 mt-1'>>" +
                    "<'row'<'col-sm-12 margin_top_class'tr>>" +
                    "<'row'<'col-sm-4 col-md-4 col-4'l><'col-sm-4 col-md-4 col-4 d-flex justify-content-center'i><'col-sm-4 col-md-4 col-4 d-flex justify-content-end'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ url('itemdata') }}/"+type,
                    type: 'DELETE',
                    beforeSend: function() {
                       blockPage(cardSection,'Loading products...');
                    },
                    complete: function () { 
                        setFocus('#itemdataables');
                        $('#itemdataables').DataTable().columns.adjust();
                    },
                    error: function () { 
                        unblockPage(cardSection);
                    },
                },                    
                columns: [
                    {data:'id',visible:false},
                    {data:'DT_RowIndex',width:"3%"},
                    {data: 'Code',name: 'Code',width:"10%"},
                    {data: 'Name',name: 'Name',width:"10%"},
                    {data: 'SKUNumber',name:'SKUNumber',width:"10%"},
                    {data: 'itemGroup',name:'itemGroup',width:"6%"},
                    {data: 'Category',name: 'Category',width:"6%"},
                    {data: 'UOM',name: 'UOM',width:"6%"},
                    {data: 'RetailerPrice',name:'RetailerPrice',width:"9%"},
                    {data: 'WholesellerPrice',name:'WholesellerPrice',width:"9%"},
                    {data: 'wholeSellerMinAmount',name:'wholeSellerMinAmount',width:"9%"},
                    {data: 'MinimumStock',name:'MinimumStock',width:"10%"},
                    {data: 'Balance', name: 'Balance', 'visible': false},
                    {data: 'PendingQuantity',name: 'PendingQuantity','visible': false},
                    {data: 'ActiveStatus',name: 'ActiveStatus',
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
                        width:"8%"
                    },
                    {data:'id', name: 'id',width:"4%"},
                    {data: 'MaxCost',name: 'MaxCost','visible': false},
                    {data: 'averageCost',name: 'averageCost','visible': false}
                ],
                columnDefs: [{
                    targets:8,
                    render: function(data,type,row,meta){
                        var numberendering = $.fn.dataTable.render.number( ',', '.', 2,).display;
                        var maximum=0;
                        var balance=row.Balance||0;
                        var pending=row.PendingQuantity;
                        var minstock=row.MinimumStock||0;
                        var maxc=parseFloat(balance)-parseFloat(minstock);
                        maximum=maxc>=0?maxc:0;
                        var minimumstock= row.MinimumStock||0;
                        var allBalance=parseFloat(balance)-parseFloat(pending);
                        var wholesalefeaturetable=$('#wholesalefeaturetable').val();
                        var costType=$('#costtype').val();
                        var maxCostVal = costType == 0 ? row.MaxCost: row.averageCost;
                        switch(data){
                            case 0:
                                return '';
                                break; 
                            default:
                                if(parseFloat(data)<parseFloat(maxCostVal)){
                                return '<span class="badge badge-light-danger">unc</span>';
                                }
                                else{
                                    if(allBalance<=0){
                                        return "<p style='text-decoration:line-through;text-decoration-color:red;'>"+data+"</p>";  
                                    } else{
                                        return numberendering(data);
                                    }
                                }
                        }
                    } 
                },
                {
                    targets:9,
                    render: function(data,type,row,meta){
                        var numberendering = $.fn.dataTable.render.number( ',', '.', 2, ).display;
                        var maximum=0;
                        var balance=row.Balance||0;
                        var pending=row.PendingQuantity;
                        var minstock=row.MinimumStock||0;
                        var wholesaleminamount=row.wholeSellerMinAmount||0;
                        var maxc=parseFloat(balance)-parseFloat(minstock);
                        maximum=maxc>=0?maxc:0;
                        var minimumstock= row.MinimumStock||0;
                        var allBalance=parseFloat(balance)-parseFloat(pending);
                        var wholesalefeaturetable=$('#wholesalefeaturetable').val();
                        var costType=$('#costtype').val();
                        var maxCostVal = costType == 0 ? row.MaxCost: row.averageCost;
                        switch(data){
                            case 0:
                                return '';
                                break;
                            default:
                                if(parseFloat(data)<parseFloat(maxCostVal)){
                                    return '<span class="badge badge-light-danger">unc</span>';
                                }
                                else{
                                    if(parseFloat(allBalance)<=0 || parseFloat(allBalance)<parseFloat(minimumstock) || parseFloat(allBalance)<parseFloat(wholesaleminamount) || parseFloat(allBalance)-parseFloat(minimumstock)<parseFloat(wholesaleminamount) || parseFloat(allBalance)-parseFloat(minimumstock)<=0 || parseFloat(maximum)< parseFloat(wholesaleminamount)  ){
                                        return "<p style='text-decoration:line-through;text-decoration-color:red;'>"+data+"</p>";
                                    }
                                    else{
                                        return numberendering(data);
                                    }
                                }
                        }
                    } 
                },
                {
                    targets:10,
                    render: function (data,type,row,meta){
                        var maximum=0;
                        var balance=row.Balance||0;
                        var pending=row.PendingQuantity;
                        var minstock=row.MinimumStock||0;
                        var wholesaleminamount=row.wholeSellerMinAmount||0;
                        var maxc=parseFloat(balance)-parseFloat(minstock);
                        maximum=maxc>=0?maxc:0;
                        var minimumstock= row.MinimumStock||0;
                        var allBalance=parseFloat(balance)-parseFloat(pending);
                        var numberendering = $.fn.dataTable.render.number( ',', '.', 2, ).display;
                        switch(data){
                            case 0:
                                return '';
                                break;
                            default:
                                if(parseFloat(allBalance)<=0 || parseFloat(allBalance)<parseFloat(minimumstock) || parseFloat(allBalance)<parseFloat(wholesaleminamount) || parseFloat(allBalance)-parseFloat(minimumstock)<parseFloat(wholesaleminamount) || parseFloat(allBalance)-parseFloat(minimumstock)<=0 || parseFloat(maximum)< parseFloat(wholesaleminamount)  ){
                                    return "<p style='text-decoration:line-through;text-decoration-color:red;'>"+data+"</p>";
                                }
                                else{
                                    return data;
                                }
                        }
                    } 
                },
                {
                    targets:11,
                    render: function ( data, type, row, meta ) {
                        var maximum=0;
                        var maxreturn='';
                        var balance=row.Balance||0;
                        var pending=row.PendingQuantity;
                        var minimumstock=row.MinimumStock||0;
                        var wholesaleminamount=row.wholeSellerMinAmount||0;
                        var allBalance=parseFloat(balance)-parseFloat(pending);
                        var numberendering = $.fn.dataTable.render.number( ',', '.', 2, ).display;
                            if(parseFloat(minimumstock)>0){
                                var maxc=parseFloat(balance)-parseFloat(minimumstock)-parseFloat(pending);
                                maximum=maxc>0?maxc:0;
                                maxreturn=maximum>=row.wholeSellerMinAmount?maximum:0;
                            }
                        switch(row.wholeSellerMinAmount){
                            case 0:
                                return '';
                            break;
                            default:
                                if(parseFloat(allBalance)<=0 || parseFloat(allBalance)<parseFloat(minimumstock) || parseFloat(allBalance)<parseFloat(wholesaleminamount) || parseFloat(allBalance)-parseFloat(minimumstock)<parseFloat(wholesaleminamount) || parseFloat(allBalance)-parseFloat(minimumstock)<=0 || parseFloat(maxreturn)< parseFloat(wholesaleminamount)){
                                return "<p style='text-decoration:line-through;text-decoration-color:red;'>"+maxreturn+"</p>";
                                }
                                else{
                                    return maxreturn;
                                }
                        }
                    }
                },
                {
                    targets: 15,
                    render: function ( data, type, row, meta ) {
                        var anchor='';
                        var maxreturn='';
                        var balance=row.Balance||0;
                        var minimumstock=row.MinimumStock||0;
                        var pendingquantity=row.PendingQuantity||0;
                        var minamount=row.wholeSellerMinAmount||0;
                        var maxcost=row.MaxCost||0;
                        var averagcostcost=row.averageCost||0;
                            if(parseFloat(minimumstock)>0){
                                var maxc=parseFloat(balance)-parseFloat(minimumstock)-parseFloat(pendingquantity);
                                maxreturn=maxc>=0?maxc:0;
                                maxreturn=maxreturn>=row.wholeSellerMinAmount?maxreturn:0;
                            }
                            anchor='<div class="text-center"><a class="showItem" href="javascript:void(0)"  data-id="'+data+'" data-category="'+row.Category+'" data-uom="'+row.UOM+'" data-max="'+maxreturn+'" data-pending="'+pendingquantity+'" data-balance="'+balance+'" data-minstock="'+minimumstock+'" data-minamount="'+minamount+'" data-maxicost="'+maxcost+'" data-averagecost="'+averagcostcost+'" title="view items"><i class="fa-sharp fa-regular fa-circle-info fa-xl" style="color: #00cfe8;"></i></a></div>';
                        return anchor;
                    }
                }],
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
                    $(tables).DataTable().columns.adjust();
                    unblockPage(cardSection);
                },     
                fixedHeader: {
                    header: true,
                    headerOffset: $('.header-navbar').outerHeight(),
                },
            });

            $('#itemdataables tbody').on('click', 'tr', function () {
                $('#itemdataables tbody > tr').removeClass('selected');
                $(this).addClass('selected');
                gblIndex = $(this).index();    
            });
        }
        
        $("#addbutton").click(function() {
            resetItemFormFn();
            managePriceFn();
            manageProductCodeFn();

            $('#operationType').val(1);
            $("#item_form_title").html('Add Product');
            $('#savebutton').text('Save');
            $('#savebutton').prop("disabled",false);
            $("#addItemForm").modal('show');
        });

        function resetItemFormFn(){
            $('#Uom').val(null).select2({
                placeholder: "Select uom here",
            });

            $('#Category').val(null).select2({
                placeholder: "Select category here",
            });

            $('#TaxType').val(15).select2({
                placeholder: "Select tax type here",
                minimumResultsForSearch: -1
            });

            $('#status').val("Active").select2({
                placeholder: "Select status here",
                minimumResultsForSearch: -1
            });

            $('#ReqSerialNumber').val("Not-Require").select2({
                placeholder: "Select value here",
                minimumResultsForSearch: -1
            });

            $('#ReqExpireDate').val("Not-Require").select2({
                placeholder: "Select value here",
                minimumResultsForSearch: -1
            });

            $('#CompatibleProducts').val(null).select2({
                placeholder: "Select compatible product here",
            });

            $('#dynamicTable > tbody').empty();

            $('input[name="product_class"]').prop('checked', false);
            $('input[id="product_class1"]').prop('checked', true);
            $('input[name="item_type[]"]').prop('checked', false);
            $('input[name="item_group[]"]').prop('checked', false);

            $('input[name="price_type"]').prop('checked', false);
            $('input[id="price_type1"]').prop('checked', true);

            manageProductClassFn();
            managePricingFn();
            manageCompatibleItemFn();
            itemTabMgtFn();
            unlockContainerFn();

            can_change_prd_class = true;
            product_class_global_var = "";

            $('.mainforminp').val("");
            $('.errordatalabel').html("");
        }

        function managePriceFn(){
            var priceupdate = $('#priceupdate').val();
            switch (priceupdate) {
                case '1':
                    $('#retailPricebv').prop('readonly', false);
                    $('#retailPrice').prop('readonly', false);
                    $('#wholeSellerPricebv').prop('readonly', false);
                    $('#wholeSellerPrice').prop('readonly', false);
                    
                    break;
                default:
                    $('#retailPricebv').prop('readonly', true);
                    $('#retailPrice').prop('readonly', true);
                    $('#wholeSellerPricebv').prop('readonly', true);
                    $('#wholeSellerPrice').prop('readonly', true);
                    
                    break;
            }
        }

        function manageProductCodeFn(){
            var item_code_type = $('#ItemCodeType').val();
            if(parseInt(item_code_type) == 1){
                $.ajax({
                    url: '/getitemcodes',
                    type: 'GET',
                    beforeSend: function() { 
                        blockPage(productCodeSection,"");
                    },
                    success: async function(data) {
                        await getItemCodeFn(data);
                        unblockPage(productCodeSection);
                    },
                    error: function () { 
                        unblockPage(productCodeSection);
                    },
                });                
            }
            else{

            }
            //$('#generate_item_code').hide();
        }

        function getItemCodeFn(data){
            $("#code").val(data.docNumber);
            $("#codeHidden").val("");
            //$("#codeHidden").val(data.docNumber);
            $("#ItemCodeMode").val("Generated");
        }

        function generateItemCodeFn(){
            var code_hidden = $("#codeHidden").val();
            if(code_hidden == ""){
                manageProductCodeFn();
            }
            else{
                $("#code").val(code_hidden);
            }
            $('#code-error').html("");
            //$('#generate_item_code').hide();
        }

        $('#savebutton').click(function(){
            var registerForm = $("#RegisterItem");
            var formData = registerForm.serialize();
            var optype = $("#operationType").val();
            var progress_text = "";
            $.ajax({
                type: "POST",
                url: "{{ url('saveitems') }}",
                data: formData,
                dataType: "json",
                beforeSend: function() { 
                    if(parseInt(optype) == 1){
                        $('#savebutton').text('Saving...');
                        $('#savebutton').prop("disabled", true);
                        progress_text = "Saving product...";
                    }
                    else if(parseInt(optype) == 2){
                        $('#savebutton').text('Updating...');
                        $('#savebutton').prop("disabled", true);
                        progress_text = "Updating product...";
                    }

                    blockPage(cardSection,progress_text);
                },
                success: async function(data) {
                    await saveItemFn(data);
                },
                error: function () { 
                    unblockPage(cardSection);     
                },
            });
        });

        function saveItemFn(data){
            var optype = $("#operationType").val();
            if(data.errors){
                if(data.errors.product_class){
                    $('#product_class_error').html(data.errors.product_class[0]);
                }
                if (data.errors.name) {
                    $('#name-error').html(data.errors.name[0]);
                }
                if (data.errors.code) {
                    $('#code-error').html(data.errors.code[0]);
                }
                if (data.errors.Category) {
                    $('#category-error').html(data.errors.Category[0]);
                }
                if (data.errors.Uom) {
                    $('#uom-error').html(data.errors.Uom[0]);
                }
                if (data.errors.skuNumber) {
                    $('#skuNumber-error').html(data.errors.skuNumber[0]);
                }
                if (data.errors.item_type) {
                    var text = data.errors.item_type[0];
                    text = text.replace("item type", "product type");
                    $('#product_type-error').html(text);
                }

                //start sales tab
                if (data.errors.MinSellingPriceBeforeTax) {
                    $('#min_selling_price_bt_error').html(data.errors.MinSellingPriceBeforeTax[0]);
                    tabMgtSalesFn();
                }
                if (data.errors.MinSellingPriceAfterTax) {
                    $('#min_selling_price_at_error').html(data.errors.MinSellingPriceAfterTax[0]);
                    tabMgtSalesFn();
                }
                if (data.errors.SellingPriceBeforeTax) {
                    $('#selling_price_bt_error').html(data.errors.SellingPriceBeforeTax[0]);
                    tabMgtSalesFn();
                }
                if (data.errors.SellingPriceAfterTax) {
                    $('#selling_price_at_error').html(data.errors.SellingPriceAfterTax[0]);
                    tabMgtSalesFn();
                }
                if (data.errors.MaxSellingPriceBeforeTax) {
                    $('#max_selling_price_bt_error').html(data.errors.MaxSellingPriceBeforeTax[0]);
                    tabMgtSalesFn();
                }
                if (data.errors.MaxSellingPriceAfterTax) {
                    $('#max_selling_price_at_error').html(data.errors.MaxSellingPriceAfterTax[0]);
                    tabMgtSalesFn();
                }
                if (data.errors.CompatibleProducts) {
                    $('#compatible_products-error').html(data.errors.CompatibleProducts[0]);
                    tabMgtSalesFn();
                }

                //start purchase tab
                if (data.errors.item_group) {
                    var text = data.errors.item_group[0];
                    text = text.replace("item group", "product group");
                    $('#group-error').html(text);
                    tabMgtPurchaseFn();
                }
                const supplierErrorsExist = Object.keys(data.errors).some(key => key.startsWith('row.'));
                if (supplierErrorsExist) {
                    $('#dynamicTable > tbody > tr').each(function (index) {
                        let indx = $(this).find('.vals').val();
                        var supplier = $(`#supplier${indx}`).val();
                        var uom = $(`#uom${indx}`).val();
                        var qty = $(`#quantity${indx}`).val();
                        var price = $(`#price${indx}`).val();
                        var availablity = $(`#availablity${indx}`).val();
                        if(isNaN(parseInt(supplier)) || parseInt(supplier) == 0){
                            $(`#select2-supplier${indx}-container`).parent().css('background-color',errorcolor);
                        }
                        if(isNaN(parseInt(uom)) || parseInt(uom) == 0){
                            $(`#select2-uom${indx}-container`).parent().css('background-color',errorcolor);
                        }
                        if(isNaN(parseInt(qty))){
                            $(`#quantity${indx}`).css("background", errorcolor);
                        }
                        if(isNaN(parseInt(price))){
                            $(`#price${indx}`).css("background", errorcolor);
                        }
                        if(availablity == ""){
                            $(`#select2-availablity${indx}-container`).parent().css('background-color',errorcolor);
                        }
                    });
                    tabMgtPurchaseFn();
                }

                //start inventory tab
                if (data.errors.ReqSerialNumber) {
                    $('#requireSerialNumber-error').html(data.errors.ReqSerialNumber[0]);
                    tabMgtInventoryFn();
                }
                if (data.errors.ReqExpireDate) {
                    $('#requireExpireDate-error').html(data.errors.ReqExpireDate[0]);
                    tabMgtInventoryFn();
                }

                //start basic tab
                if (data.errors.partNumber) {
                    $('#partNumber-error').html(data.errors.partNumber[0]);
                    tabMgtBasicFn();
                }
                if (data.errors.lowStock) {
                    var text = data.errors.lowStock[0];
                    text = text.replace("low stock", "reorder point");
                    $('#lowStock-error').html(text);
                    tabMgtBasicFn();
                }
                if (data.errors.lotDescription) {
                    $('#lot_description-error').html(data.errors.lotDescription[0]);
                    tabMgtBasicFn();
                }
                if (data.errors.factor) {
                    $('#factor-error').html(data.errors.factor[0]);
                    tabMgtBasicFn();
                }
                if (data.errors.cartoonSize) {
                    $('#cartoon_size-error').html(data.errors.cartoonSize[0]);
                    tabMgtBasicFn();
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
            else if(data.dberrors) {
                toastrMessage('error',"Please contact administrator","Error");
                unblockPage(cardSection);
            }
            else if(data.success){
                toastrMessage('success','Successful','Success');
                
                if(parseInt(optype) == 1){
                    refreshtbl();
                }
                else if(parseInt(optype) == 2){
                    createItemInfoFn(data.latest,0,0);
                    refreshMainDatatbleFn();
                }
                $("#addItemForm").modal('hide');
            }
        }

        function showitemInformation(itemid,uom,category,maxicost,averagecost){
            createItemInfoFn(itemid,maxicost,averagecost);
            $('#docInfoModal').modal('show');
        }

        function createItemInfoFn(itemid,maxicost,averagecost){
            var localpriceupdate = $('#localitempriceupdate').val();
            var importpriceupdate = $('#importitempriceupdate').val();
            var maximumqty = 0;
            $('.sideImage').html('');
            $('#carouselExampleFade').html('');

            $.ajax({
                type: "get",
                url: "{{url('showitem')}}"+'/'+itemid,
                dataType: "json",
                beforeSend: function() {
                    blockPage(cardSection, 'Fetching product data...');
                },
                success: async function(data) {
                    await getItemDataFn(data);
                },
                error: function () {
                    unblockPage(cardSection);
                }
            });
        }

        function getItemDataFn(data){
            var recordId = data.item_id;
            var costtype = $('#costtype').val();
            var action_log = "";
            var action_links = "";
            var lidata = "";
            var upload_image_link = "";
            var upload_doc_link = "";
            $.each(data.item, function (index, value) { 
                var product_class = value.Type;
                $('#ids').val(value.id);
                $('#product_class_lbl').text(product_class);
                $('#itemcodeInfoLbl').text(value.Code);
                $('#itemInfoLbl').text(value.Name);
                $('#skuInfoLbl').text(value.SKUNumber);
                $('#uomInfoLbl').text(value.uom_name);
                $('#itemCategoryInfoLbl').text(value.category_name);
                $('#taxInfoLbl').text(`${value.TaxTypeId} %`);
                $('#product_type_lbl').text(value.product_type);
                $('#imagedescription').html(value.Description);
                $('#status_lbl').html(value.ActiveStatus == "Active" ? 
                    `<span style='color:#1cc88a;font-weight:bold;text-shadow;1px 1px 10px #1cc88a;font-size:12px;'>${value.ActiveStatus}</span>` :
                    `<span style='color:#e74a3b;font-weight:bold;text-shadow;1px 1px 10px #e74a3b;font-size:12px;'>${value.ActiveStatus}</span>`
                );

                $('#partnumberInfoLbl').text(value.PartNumber);
                $('#reorderInfoLbl').text(value.LowStock);
                $('#lot_description_lbl').text(value.lot_description);
                $('#factorInfoLbl').text(value.standard_factor);
                $('#cartoon_size_lbl').text(value.cartoon_size == null ? "" : value.cartoon_size);

                $('#is_serial_no_req_lbl').html(value.RequireSerialNumber);
                $('#is_batch_no_req_lbl').html(value.RequireExpireDate);
                
                $('#itemgroupInfoLbl').text(value.itemGroup);

                $('#price_type_lbl').html(`Price Type: <b>${value.price_type}</b>`);

                $('#min_bt_lbl').text(numformat(parseFloat(value.min_price_bt).toFixed(2)));
                $('#min_at_lbl').text(numformat(parseFloat(value.min_price_at).toFixed(2)));

                $('#default_bt_lbl').text(numformat(parseFloat(value.default_price_bt).toFixed(2)));
                $('#default_at_lbl').text(numformat(parseFloat(value.default_price_at).toFixed(2)));

                $('#max_bt_lbl').text(numformat(parseFloat(value.max_price_bt).toFixed(2)));
                $('#max_at_lbl').text(numformat(parseFloat(value.max_price_at).toFixed(2)));
               
                $('#itemtype').val(value.itemGroup);
                
                $('#barcodeinfocode').text(value.Code);
                var itemdescription = value.Description;
                var img = '<img class="card-img-top" src="'+value.imageName+'" alt="barcode not found"/>';
                $("#barcodeinfoimages").html(img);

                $('#product_cost_lbl').html("");

                productClassMgtFn(product_class);
                priceTypeMgtFn(value.price_type);

                if(product_class == "Goods" || product_class == "Commodity"){
                    upload_image_link = `
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" id="imageuploadbutton" onclick="openImageUploadFn(${recordId})" title="Open image upload form">
                            <span><i class="fa-regular fa-cloud-arrow-up"></i> Image Upload</span>
                            </a>
                        </li>`;

                    upload_doc_link = `
                        <li>
                            <a class="dropdown-item" id="documentuploadbutton" onclick="openDocumentUploadFn(${recordId})" title="Open document upload form">
                            <span><i class="fa-regular fa-cloud-arrow-up"></i> Document Upload</span>
                            </a>
                        </li>`;
                }
                else if(product_class == "Service"){
                    upload_image_link = "";
                    upload_doc_link = "";
                }

                
                
                
                // var bt = value.BarcodeType;
                // var itemgrioup = value.itemGroup;
                // var retailprice=value.RetailerPrice>0?value.RetailerPrice:'';
                // var wholesaleprice=value.WholesellerPrice>0?value.WholesellerPrice:'';
                // var wholesaleminamount=value.wholeSellerMinAmount>0?value.wholeSellerMinAmount:'';
                // var maxcost=value.MaxCost>0?value.MaxCost:'';
                // var avgcost=value.averageCost>0?value.averageCost:'';
                // var mincost=value.minCost>0?value.minCost:'';
                // var pendingqty=value.PendingQuantity||0;
                // var balance=value.AvailableQuantity||0;
                // var minstock=value.MinimumStock;
                // var rpm=value.pmretail;
                // var wspm=value.pmwholesale;
                // var retailpricebv=parseFloat(retailprice/1.15).toFixed(2);
                // var wholesalepricebv=parseFloat(wholesaleprice/1.15).toFixed(2);
                // var maxcostbv=parseFloat(maxcost/1.15).toFixed(2);
                // var avgcostbv=parseFloat(avgcost/1.15).toFixed(2);
                // var mincostbv=parseFloat(mincost/1.15).toFixed(2);
                // retailpricebv=retailpricebv>0?retailpricebv:'';
                // wholesalepricebv=wholesalepricebv>0?wholesalepricebv:'';
                // maxcostbv=maxcostbv>0?maxcostbv:'';
                // avgcostbv=avgcostbv>0?avgcostbv:'';
                // mincostbv=mincostbv>0?mincostbv:'';
                // maximumqty=parseFloat(value.AvailableQuantity)-parseFloat(value.PendingQuantity)-parseFloat(value.MinimumStock);
                // $('#wholesalemax').val(maximumqty);
                // $('#pendingdata').val(value.PendingQuantity);
                // setItemPrice(retailprice,wholesaleprice,retailpricebv,wholesalepricebv,maximumqty,pendingqty,minstock,balance,wholesaleminamount,maxcost);
                
                // if (itemgrioup == "Local") {
                                
                //     var localitemstoreminquantity=$('#localitemstoreminquantity').val();
                //     var localcostpermission=$('#localcost').val();
                //     var localitemeditpermission=$('#localitemeditpermission').val();
                //     $('#printbutton').show();
                //     switch (localitemstoreminquantity) {
                //         case '1':
                //             $('#costables').show();
                //             break;
                        
                //         default:
                //             $('#costables').hide();
                //             break;
                //     }
                //     switch (localitemeditpermission) {
                //         case '1':
                //             $('#itemeditbutton').show();
                //             break;
                    
                //         default:
                //             $('#itemeditbutton').hide();
                //             break;
                //     }
                //     switch (localcostpermission) {
                //         case '1':
                //             setPriceInformation(mincostbv,mincost,avgcostbv,avgcost,maxcostbv,maxcost,rpm,wspm,retailprice,wholesaleprice);
                //             removeColorAccessDeniedinformation();
                //             switch (costtype) {
                //                 case '1':
                //                     if(parseFloat(avgcost)>0){
                //                         setAverageCostColor();
                //                     } else{
                //                         removeAverageCostColor();
                //                     }
                                    
                //                     break;
                //                 case '0':
                //                     if(parseFloat(maxcost)>0){
                //                         setMaxCostColor();
                //                     } else{
                //                         removeMaxCostColor();
                //                     }
                                    
                //                 break;
                //                 default:
                //                     break;
                //             }
                //             break;                                
                //         default:
                //             setAccessDeniedinformation();
                //             removeAverageCostColor();
                //             removeMaxCostColor();
                //             break;
                //     }
                // }
                // if (itemgrioup == "Imported") {
                //     var importcostpermission=$('#importcost').val();
                //     var importitemeditpermission=$('#importitemeditpermission').val();
                //     var importitemstoreminquantity=$('#importitemstoreminquantity').val();
                //     $('#printbutton').show();
                //     switch (importitemstoreminquantity) {
                //         case '1':
                //             $('#costables').show();
                //             break;
                //         default:
                //             $('#costables').hide();
                //             break;
                //     }
                //     switch (importitemeditpermission) {
                //         case '1':
                //             $('#itemeditbutton').show();
                //             break;
                //         default: 
                //         $('#itemeditbutton').hide();
                //             break;
                //     }
                //     switch (importcostpermission) {
                //         case '1':
                //             setPriceInformation(mincostbv,mincost,avgcostbv,avgcost,maxcostbv,maxcost,rpm,wspm,retailprice,wholesaleprice);
                //             removeColorAccessDeniedinformation();
                //             switch (costtype) {
                //                 case '1':
                //                     if(parseFloat(avgcost)>0){
                //                         setAverageCostColor();
                //                         } else{
                //                             removeAverageCostColor();
                //                         }
                                    
                //                     break;
                //                 case '0':
                //                     if(parseFloat(maxcost)>0){
                //                         setMaxCostColor();
                //                     } else{
                //                         removeMaxCostColor();
                //                     }
                //                 break;
                //                 default:
                //                     break;
                //             }
                //             break;
                //         default:
                //             setAccessDeniedinformation();
                //             removeAverageCostColor();
                //             removeMaxCostColor();
                //             break;
                //     }
                // }
                // if (bt == "Generate") {
                //     $('#barcodeDiv').show();
                // } else {
                //     $('#barcodeDiv').hide();
                // }

                costTablesetColor(costtype);
                manageProductPurchaseCostTableFn(value.minCost,value.averageCost,value.MaxCost,value.TaxTypeId);
            });
            // show ite images

            $.each(data.activitydata, function(key, value) {
                var classes = "";
                if(value.action == "Edited"){
                    classes = "warning";
                }
                else if(value.action == "Created"){
                    classes = "success";
                }
                else{
                    classes = "secondary";
                }
                lidata += `<li class="timeline-item"><span class="timeline-point timeline-point-${classes} timeline-point-indicator"></span><div class="timeline-header mb-sm-0 mb-0"><h6 class="mb-0">${value.action}</h6><span class="text-muted"><i class="fa-regular fa-user"></i> ${value.FullName}</span></br><span class="text-muted"><i class="fa-regular fa-clock"></i> ${value.time}</span></div></li>`;
            });

            $("#universal-action-log-canvas").empty().append(lidata);

            switch (data.success) {
                case 1:
                        $('#img-container').show();
                        setitemimages(data.itemimage);
                    break;
                default:
                    shownoimages();
                    $('#img-container').hide();
                    break;
            }

            action_links = `
                <li>
                    <a class="dropdown-item viewItemAction" onclick="viewItemFn(${recordId})" data-id="viewactionbtn${recordId}" id="viewactionbtn${recordId}" title="View user log">
                    <span><i class="fa-solid fa-eye"></i> View User Log</span>  
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                @if(auth()->user()->can("Local-item-edit") || auth()->user()->can("Import-item-edit"))
                <li>
                    <a class="dropdown-item itemEdit" onclick="itemEditFn(${recordId})" data-id="itemeditbutton${recordId}" id="itemeditbutton" title="Open product edit page">
                    <span><i class="fa-solid fa-pencil"></i> Edit</span>  
                    </a>
                </li>
                @endif
                @can("Item-Delete")
                <li>
                    <a class="dropdown-item itemDelete" onclick="itemDeleteFn(${recordId})" data-id="itemdeletebutton${recordId}" id="itemdeletebutton" title="Open product delete confirmation">
                    <span><i class="fa-solid fa-xmark"></i> Delete</span>  
                    </a>
                </li>
                @endcan
                ${upload_image_link}
                ${upload_doc_link}`;

            $("#item_action_ul").empty().append(action_links);

            itemInfoTabMgtFn();
            fetchItemDynamicDataFn(recordId);
        }

        function fetchItemDynamicDataFn(recordId){
            $('#info-supplier-datatable').DataTable({
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
                dom: "<'row'<'col-sm-6 col-md-6 col-6 ml-0'f><'col-sm-6 col-md-6 col-6 mt-2 d-flex justify-content-end'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-4 col-md-4 col-4'l><'col-sm-4 col-md-4 col-4 d-flex justify-content-center'i><'col-sm-4 col-md-4 col-4 d-flex justify-content-end'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/showSupplierData/' + recordId,
                    type: 'POST',
                },
                columns: [{
                        data:'DT_RowIndex',
                        width:'3%',
                    },
                    {
                        data: 'supplier',
                        name: 'supplier',
                        width:'40%',
                    },
                    {
                        data: 'uom_name',
                        name: 'uom_name',
                        width:'10%',
                    },
                    {
                        data: 'quantity',
                        name: 'quantity',
                        width:'10%',
                        render: $.fn.dataTable.render.number(',', '.',0, '')
                    },
                    {
                        data: 'price',
                        name: 'price',
                        width:'10%',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'availability',
                        name: 'availability',
                        width:'10%',
                    },
                    {
                        data: 'remark',
                        name: 'remark',
                        width:'17%',
                    },
                ],
            });

            $('#info-compatible-datatable').DataTable({
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
                dom: "<'row'<'col-sm-6 col-md-6 col-6 ml-0'f><'col-sm-6 col-md-6 col-6 mt-2 d-flex justify-content-end'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-4 col-md-4 col-4'l><'col-sm-4 col-md-4 col-4 d-flex justify-content-center'i><'col-sm-4 col-md-4 col-4 d-flex justify-content-end'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/showCompatibleData/' + recordId,
                    type: 'POST',
                },
                columns: [{
                        data:'DT_RowIndex',
                        width:'3%',
                    },
                    {
                        data: 'comp_items',
                        name: 'comp_items',
                        width:'97%',
                    },
                ],
                "initComplete": function(settings, json) {
                    unblockPage(cardSection);
                },
            });
        }

        function viewItemFn(recordId){
            $("#action-log-title").html("User Log Information");
            $("#action-log-universal-modal").modal('show');
        }

        function itemEditFn(id){
            resetItemFormFn();
            $.ajax({
                type: "GET",
                url: "{{ url('itemedit') }}/"+id,
                data: "",
                dataType: "",
                beforeSend: function() {
                    blockPage(cardSection, 'Fetching product data...');
                },
                success:async function (response) {
                    await getItemEditDataFn(response);
                    unblockPage(cardSection);
                },
                error: function () {
                    unblockPage(cardSection);
                }
            });

            $('#ids').val(id);
            $('#operationType').val(2);
            $("#item_form_title").html('Edit Product');
            $('#savebutton').text('Update');
            $('#savebutton').prop("disabled",false);
            $('#printOrderReq').prop('checked', false);
            $("#addItemForm").modal('show');
        }

        function getItemEditDataFn(response){
            var wholesalefeaturetable = $('#wholesalefeaturetable').val();
            var importcostpermission = $('#importcost').val();
            var localcostpermission = $('#localcost').val();
            var localpriceupdate = $('#localitempriceupdate').val();
            var importpriceupdate = $('#importitempriceupdate').val();
            var costtype = $('#costtype').val();
            var ItemType = $('#itemtype').val();
            var wsalemax = $('#wholesalemax').val()||0;
            var pending = $('#pendingdata').val()||0;

            var compatible_prd = "";

            var transaction = response.transaction;
            if(parseInt(transaction) == 0 || isNaN(parseInt(transaction))){
                can_change_prd_class = true;
                unlockContainerFn();
            }
            else if(parseInt(transaction) > 0){
                can_change_prd_class = false;
                lockContainerFn();
            }

            $.each(response.item, function (index, value) { 
                var mxnc = value.MaxCost > 0 ? value.MaxCost : '';
                var mnc = value.minCost > 0 ? value.minCost : '';
                var avc = value.averageCost > 0 ? value.averageCost : '';
                var max = value.MaxCost||0;
                var avalableqty = value.AvailableQuantity||0;
                var minstock = value.MinimumStock||0;
                var wsmin = value.wholeSellerMinAmount||0;
                var maxws = parseFloat(avalableqty) - parseFloat(minstock);
                maxws = maxws > 0 ? maxws : 0;
                var mresult = (parseFloat(max) / 1.15).toFixed(2);
                var mincostbv = (parseFloat(value.minCost) / 1.15).toFixed(2);
                var avresult = (parseFloat(value.averageCost) / 1.15).toFixed(2);
                mresult = mresult > 0 ? mresult : '';
                avresult = avresult > 0 ? avresult : '';
                mresult = mresult > 0 ? mresult : '';
                mincostbv = mincostbv > 0 ? mincostbv : '';
                var itemdescription = value.Description;
                var bt = value.BarcodeType;
                var balance = parseFloat(value.AvailableQuantity) - parseFloat(pending);
                var img = `<img class="card-img-top" src="${value.imageName}" alt="barcode  image not found"  />`;
                var prd_class = value.Type;
                product_class_global_var = value.Type;
                var pr_type = value.price_type;
                var product_group = value.itemGroup;
                
                // switch(minstock){
                //     case 0:
                //     wsalemax='';
                //     break;
                //     default:
                //         if(parseFloat(wsalemax)>0){
                //             wsalemax=wsalemax;
                //         } else{
                //             wsalemax=0;
                //         }
                //     break;
                // }

                $(`input[name="product_class"][value="${prd_class}"]`).prop('checked',true);
                $('#code').val(value.Code);
                $('#name').val(value.Name);
                $('#skuNumber').val(value.SKUNumber);
                $('#skuNumberupdate').val(value.oldSKUNumber);
                $('#skuNumberupdatehidden').val(value.SKUNumber);

                $('#minCostInp').val(value.minCost);
                $('#averageCostInp').val(value.averageCost);
                $('#maxcosti').val(value.MaxCost);

                $('#Uom').val(value.MeasurementId).select2();
                $('#Category').val(value.CategoryId).select2();
                $('#TaxType').val(value.TaxTypeId).select2();

                $.each(response.product_type_ids, function(index, prd_type_val) {
                    $(`input[name="item_type[]"][value="${prd_type_val}"]`).prop('checked', true);
                });

                $('#description').val(value.Description);
                $('#status').val(value.ActiveStatus).select2({minimumResultsForSearch: -1});

                $('#partNumber').val(value.PartNumber);
                $('#lowStock').val(value.LowStock);
                $('#lotDescription').val(value.lot_description);
                $('#factor').val(value.standard_factor);
                $('#cartoonSize').val(value.cartoon_size);

                $('#ReqSerialNumber').val(value.RequireSerialNumber).select2({minimumResultsForSearch: -1});
                $('#ReqExpireDate').val(value.RequireExpireDate).select2({minimumResultsForSearch: -1});

                if(prd_class == "Goods" || prd_class == "Commodity"){
                    var productGroupArray = product_group.split(',').map(function(prd_grp) {
                        return prd_grp.trim();
                    });
                }
                
                $.each(productGroupArray, function(idx, prd_grp_val) {
                    $(`input[name="item_group[]"][value="${prd_grp_val}"]`).prop('checked', true);
                });

                $(`input[name="price_type"][value="${value.price_type}"]`).prop('checked',true);

                $('#MinSellingPriceBeforeTax').val(value.min_price_bt);
                $('#MinSellingPriceAfterTax').val(value.min_price_at);

                $('#SellingPriceBeforeTax').val(value.default_price_bt);
                $('#SellingPriceAfterTax').val(value.default_price_at);

                $('#MaxSellingPriceBeforeTax').val(value.max_price_bt);
                $('#MaxSellingPriceAfterTax').val(value.max_price_at);
                
                $('#maxcost').val(mxnc);
                $('#mincost').val(mnc);
                $('#averagecost').val(avc);

                $('#maxcosti').val(value.MaxCost);
                $('#notifiablemaxcostid').val(value.MaxCost);
                $('#itemimageupdate').val(value.path);
                $('#barcodeCode').html(value.Code);
                $('#BarcodeTypes').val(value.BarcodeType);
                $('#BarcodeTypesupdate').val(value.BarcodeType);
                $('#lastbarcode').val(value.id);
                
                $('#pmwholesale').val(value.pmwholesale);
                $('#pmretail').val(value.pmretail);
                $('#balance').val(balance);
                $('#wholeSellerMaxAmount').val(wsalemax);
                $('#maxcostbv').val(mresult);
                $('#averagecostbv').val(avresult);
                $('#mincostbv').val(mincostbv);
                $("#barcodeimagesupdate").html(img);
                $('#BarcodeTypes').val(bt);

                if(prd_class == "Goods" || prd_class == "Commodity"){
                    $('.non_service_div').show();
                    $('#generateBtn').show();
                    $('#barcodeDiv').hide();
                }
                if(prd_class == "Service"){
                    $('.non_service_div').hide();
                    $('.non_service_input').val("");
                    $('.non_service_error').html("");
                    $('.non_service_checkbox').prop('checked', false);
                }

                if(pr_type == "Flexible"){
                    $('.flexible_attribute').show();
                }
                if(pr_type == "Fixed"){
                    $('.flexible_attribute').hide();
                }

                manageCompatibleItemFn();
                manageProductPurchaseCostTableFn(value.minCost,value.averageCost,value.MaxCost,value.TaxTypeId);

                $('#ItemCodeMode').val(value.item_code_mode);
                $('#codeHidden').val(value.old_item_code);

                // switch (costtype) {
                //     case '1': // average cost vlaues
                //         if(value.averageCost>0){
                //             $('#pmretail').prop('readonly', false);
                //             $('#pmwholesale').prop('readonly', false);
                //         } else{
                //             $('#pmretail').prop('readonly', true);
                //             $('#pmwholesale').prop('readonly', true);
                //         }
                //         break;
                //     case '0': // maximum cost value
                //         if(value.MaxCost>0){
                //             $('#pmretail').prop('readonly', false);
                //             $('#pmwholesale').prop('readonly', false);
                //         } else{
                //             $('#pmretail').prop('readonly', true);
                //             $('#pmwholesale').prop('readonly', true);
                //         }
                //         break;
                //     default:
                //         break;
                // }
                
                // switch(value.RetailerPrice){
                //     case 0:
                //         $('#retailPrice').val('');
                //         $('#retailPricehidden').val('');
                //         $('#notifiablereailerpriceid').val('');
                //         $('#retailPricebv').val('');
                        
                //     break;
                //     default:
                //         var retailPricebeforeVat = (parseFloat(value.RetailerPrice) / 1.15).toFixed(2);
                //         $('#retailPrice').val(value.RetailerPrice);
                //         $('#retailPricehidden').val(value.RetailerPrice);
                //         $('#notifiablereailerpriceid').val(value.RetailerPrice);
                //         $('#retailPricebv').val(retailPricebeforeVat);
                // }

                // switch(value.WholesellerPrice){
                //     case 0:
                //         $('#wholeSellerPrice').val('');
                //         $('#wholeSellerPricehidden').val('');
                //         $('#wholeSellerPricebv').val('');
                //         $('#notifiablewholesellerpriceid').val('');
                //         $("#wholeSellerMinAmount").prop("readonly", true);
                        
                //     break;
                //     default:
                //         var wholesalePricebeforeVat = (parseFloat(value.WholesellerPrice) / 1.15).toFixed(2);
                //         $('#wholeSellerPrice').val(value.WholesellerPrice);
                //         $('#wholeSellerPricehidden').val(value.WholesellerPrice);
                //         $('#notifiablewholesellerpriceid').val(value.WholesellerPrice);
                //         $('#wholeSellerPricebv').val(wholesalePricebeforeVat);
                //         $("#wholeSellerMinAmount").prop("readonly", false);
                // }

                // switch(value.MinimumStock){
                //     case 0:
                //         $('#minimumstock').val('');
                //     break;
                //     default:
                //         $('#minimumstock').val(value.MinimumStock);
                // }

                // switch(value.wholeSellerMinAmount){
                //     case 0:
                //     $('#wholeSellerMinAmount').val('');
                //     break;
                //     default:
                //     $('#wholeSellerMinAmount').val(value.wholeSellerMinAmount);
                // }
                
                // switch (value.itemGroup) {
                //     case 'Imported':
                //         switch (importpriceupdate) {
                //             case '1':
                //                     $('#retailPricebv').prop('readonly', false);
                //                     $('#retailPrice').prop('readonly', false);
                //                     $('#wholeSellerPricebv').prop('readonly', false);
                //                     $('#wholeSellerPrice').prop('readonly', false);
                //                     $('#wholeSellerMinAmount').prop('readonly', false);
                //                     $('#pmwholesale').prop('readonly', false);
                //                     $('#pmretail').prop('readonly', false);
                //                 break;
                //             default:
                //                     $('#retailPricebv').prop('readonly', true);
                //                     $('#retailPrice').prop('readonly', true);
                //                     $('#wholeSellerPricebv').prop('readonly', true);
                //                     $('#wholeSellerPrice').prop('readonly', true);
                //                     $('#wholeSellerMinAmount').prop('readonly', true);
                //                     $('#pmwholesale').prop('readonly', true);
                //                     $('#pmretail').prop('readonly', true);
                //                 break;
                //         }
                //         if(max!=0){
                //             if(importcostpermission==1){
                //             $('#mincostbvlbl').html(mincostbv);  
                //             $('#averagecostbvlbl').html(avresult); 
                //             $('#maxcostbvlbl').html(mresult);
                //             $('#mincostlbl').html(mnc);
                //             $('#averagecostlbl').html(avc);
                //             $('#maxcostlbl').html(mxnc);
                //             costTablesetColor(costtype);
                //             removeclassfromcost();
                //         }
                //         else{
                //             addclasstocost(value.pmwholesale,value.pmretail);
                //             removeAverageCostColor();
                //             removeMaxCostColor();
                //         }
                //         }else{
                //             $('#mincostbvlbl').html(mincostbv);  
                //             $('#averagecostbvlbl').html(avresult); 
                //             $('#maxcostbvlbl').html(mresult);
                //             $('#mincostlbl').html(mnc);
                //             $('#averagecostlbl').html(avc);
                //             $('#maxcostlbl').html(mxnc);
                //             removeAverageCostColor();
                //             removeMaxCostColor();
                //         }
                    
                //         break;
                //     default:
                //         switch (localpriceupdate) {
                //             case '1':
                //                 $('#retailPricebv').prop('readonly', false);
                //                 $('#retailPrice').prop('readonly', false);
                //                 $('#wholeSellerPricebv').prop('readonly', false);
                //                 $('#wholeSellerPrice').prop('readonly', false);
                //                 $('#wholeSellerMinAmount').prop('readonly', false);
                //                 $('#pmwholesale').prop('readonly', false);
                //                 $('#pmretail').prop('readonly', false);
                //                 break;
                //             default:
                //                 $('#retailPricebv').prop('readonly', true);
                //                 $('#retailPrice').prop('readonly', true);
                //                 $('#wholeSellerPricebv').prop('readonly', true);
                //                 $('#wholeSellerPrice').prop('readonly', true);
                //                 $('#wholeSellerMinAmount').prop('readonly', true);
                //                 $('#pmwholesale').prop('readonly', true);
                //                 $('#pmretail').prop('readonly', true);
                //                 break;
                //         }
                //         if(max!=0){
                //             if(localcostpermission==1){
                //                 $('#mincostbvlbl').html(mincostbv);  
                //                 $('#averagecostbvlbl').html(avresult); 
                //                 $('#maxcostbvlbl').html(mresult);
                //                 $('#mincostlbl').html(mnc);
                //                 $('#averagecostlbl').html(avc);
                //                 $('#maxcostlbl').html(mxnc);
                //                 removeclassfromcost();
                //                 costTablesetColor(costtype);
                                
                //                 switch (value.pmretail) {
                //                     case 0:
                //                         $('#pmretail').val('');
                //                         break;
                //                     default:
                //                         $('#pmretail').val(value.pmretail);
                //                         break;
                //                 }
                //                 switch (value.pmwholesale) {
                //                     case 0:
                //                         $('#pmwholesale').val('');
                //                         break;
                //                     default:
                //                         $('#pmwholesale').val(value.pmwholesale);
                //                         break;
                //                 }
                                
                //                 }
                //             else{
                //                 addclasstocost(value.pmwholesale,value.pmretail);
                //                 removeAverageCostColor();
                //                 removeMaxCostColor();
                //             }
                //         }else{
                //             removeAverageCostColor();
                //             removeMaxCostColor();
                //             $('#mincostbvlbl').html(mincostbv);  
                //             $('#averagecostbvlbl').html(avresult); 
                //             $('#maxcostbvlbl').html(mresult);
                //             $('#mincostlbl').html(mnc);
                //             $('#averagecostlbl').html(avc);
                //             $('#maxcostlbl').html(mxnc);
                //         }
                //         break;
                // }

                somedivhideandshow(value.Type);
                checkminstockpermission(value.itemGroup);
                editransaction(transaction);
            });

            $.each(response.compatible_data, function (index, value) {
                compatible_prd += `<option selected value='${value.compatible_item_id}'>${value.comp_items}</option>`;
            });

            $(`#CompatibleProducts option[value="${response.item_id}"]`).remove();
            $('#CompatibleProducts').append(compatible_prd);

            $.each(response.supplier_data, function (index, value) {
                ++i;
                ++m;
                ++j;

                $("#dynamicTable > tbody").append(`<tr id="rowind${m}">
                    <td style="font-weight:bold;width:3%;text-align:center;">${j}</td>
                    <td style="display:none;"><input type="hidden" name="row[${m}][vals]" id="vals${m}" class="vals form-control" readonly="true" style="font-weight:bold;" value="${m}"/></td>
                    <td style="width:25%;"><select id="supplier${m}" class="select2 form-control supplier" onchange="supplierFn(this)" name="row[${m}][supplier]"></select></td>
                    <td style="width:10%;"><select id="uom${m}" class="select2 form-control uom" onchange="uomFn(this)" name="row[${m}][uom]"></select></td>
                    <td style="width:12%;"><input type="number" name="row[${m}][quantity]" placeholder="Enter quantity here" id="quantity${m}" class="quantity form-control numeral-mask" onkeyup="quantityFn(this)" onkeypress="return ValidateNum(event);" value="${value.quantity}"/></td>
                    <td style="width:12%;"><input type="number" name="row[${m}][price]" placeholder="Enter price here" id="price${m}" class="price form-control numeral-mask" onkeyup="priceFn(this)" onkeypress="return ValidateNum(event);" value="${value.price}"/></td>
                    <td style="width:15%;"><select id="availablity${m}" class="select2 form-control availablity" name="row[${m}][availablity]" onchange="availablityFn(this)"></select></td>
                    <td style="width:20%;"><input type="text" name="row[${m}][remark]" placeholder="Enter remark here" id="remark${m}" class="remark form-control" onkeyup="remarkFn(this)" value="${value.remark}"/></td>
                    <td style="width:3%;text-align:center;"><button type="button" id="removebtn${m}" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>
                </tr>`);

                var default_supplier = `<option selected value='${value.supplier_id}'>${value.supplier}</option>`;
                var default_uom = `<option selected value='${value.uom_id}'>${value.uom_name}</option>`;
                var default_av_status = `<option selected value='${value.availability}'>${value.availability}</option>`;

                $('#dynamicTable > tbody > tr').each(function(index, tr) {
                    let supp_id = $(this).find('.supplier').val();
                    $(`#supplier${m} option[value="${value.supplier_id}"]`).remove(); 
                });
                $(`#supplier${m} option[value="${value.supplier_id}"]`).remove();
                $(`#supplier${m}`).append(default_supplier).select2();

                $(`#uom${m} option[value="${value.uom_id}"]`).remove();
                $(`#uom${m}`).append(default_uom).select2();

                var availablity_status = '<option value="Available">Available</option><option value="Not-Available">Not-Available</option>';
                $(`#availablity${m}`).append(availablity_status);
                $(`#availablity${m} option[value="${value.availability}"]`).remove(); 
                $(`#availablity${m}`).append(default_av_status).select2({minimumResultsForSearch: -1});

                $(`#select2-supplier${m}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                $(`#select2-uom${m}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                $(`#select2-availablity${m}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
            });
            renumberRows();
        }

        function lockContainerFn() {
            $('.non_editable_containers').css({
                'pointer-events': 'none',
                'opacity': '0.7',
                'background-color': '#f8f9fa',
                'border': '1px solid #ffcdd2 ',
                'user-select': 'none'
            });

            var $overlay = $('<div class="container_lock_overlay"></div>').css({
                'position': 'absolute',
                'top': '0',
                'left': '0',
                'width': '100%',
                'height': '100%',
                'z-index': '10',
                'pointer-events': 'auto',     // This allows events
                'background': 'transparent'
            });

            $('.non_editable_containers').append($overlay);
        }

        function unlockContainerFn() {
            $('.non_editable_containers').css({
                'pointer-events': 'auto',
                'opacity': '1',
                'background-color': 'transparent',
                'border': '1px solid transparent',
                'user-select': 'auto'
            });

            $('.container_lock_overlay').remove();
        }

        $(document).on('dblclick', '.container_lock_overlay', function() {
            var have_permission = $('#transactionEdit').val();
            if(!have_permission){
                unlockContainerFn();
            }
        });
        
        

        function manageProductPurchaseCostTableFn(min_cost,avg_cost,max_cost,tax_type){
            //var tax_type = $('#TaxType').val();
            
            tax_type = tax_type == '' ? 0 : tax_type;
            var tax_quotient = (parseFloat(tax_type) / 100) + parseInt(1);

            min_cost = min_cost == '' ? 0 : min_cost;
            avg_cost = avg_cost == '' ? 0 : avg_cost;
            max_cost = max_cost == '' ? 0 : max_cost;

            var min_cost_at = parseFloat(min_cost) * parseFloat(tax_quotient);
            var avg_cost_at = parseFloat(avg_cost) * parseFloat(tax_quotient);
            var max_cost_at = parseFloat(max_cost) * parseFloat(tax_quotient);

            $('.min_cost_bt_lbl').text(numformat(parseFloat(min_cost).toFixed(2)));
            $('.min_cost_at_lbl').text(numformat(parseFloat(min_cost_at).toFixed(2)));

            $('.avg_cost_bt_lbl').text(numformat(parseFloat(avg_cost).toFixed(2)));
            $('.avg_cost_at_lbl').text(numformat(parseFloat(avg_cost_at).toFixed(2)));

            $('.max_cost_bt_lbl').text(numformat(parseFloat(max_cost).toFixed(2)));
            $('.max_cost_at_lbl').text(numformat(parseFloat(max_cost_at).toFixed(2)));
        }

        function manageProductPurchaseCostFormFn(){
            var tax_type = $('#TaxType').val();
            var min_cost = $('#minCostInp').val();
            var avg_cost = $('#averageCostInp').val();
            var max_cost = $('#maxcosti').val();
            
            tax_type = tax_type == '' ? 0 : tax_type;
            var tax_quotient = (parseFloat(tax_type) / 100) + parseInt(1);

            min_cost = min_cost == '' ? 0 : min_cost;
            avg_cost = avg_cost == '' ? 0 : avg_cost;
            max_cost = max_cost == '' ? 0 : max_cost;

            var min_cost_at = parseFloat(min_cost) * parseFloat(tax_quotient);
            var avg_cost_at = parseFloat(avg_cost) * parseFloat(tax_quotient);
            var max_cost_at = parseFloat(max_cost) * parseFloat(tax_quotient);

            //$('#mincostbvlbl').text(numformat(parseFloat(min_cost).toFixed(2)));
            $('#mincostlbl').text(numformat(parseFloat(min_cost_at).toFixed(2)));

            //$('#averagecostbvlbl').text(numformat(parseFloat(avg_cost).toFixed(2)));
            $('#averagecostlbl').text(numformat(parseFloat(avg_cost_at).toFixed(2)));

            //$('#maxcostbvlbl').text(numformat(parseFloat(max_cost).toFixed(2)));
            $('#maxcostlbl').text(numformat(parseFloat(max_cost_at).toFixed(2)));
        }

        $('input[name="product_class"]').on('change', function() {
            if(can_change_prd_class){
                var prd_class = $(this).val();
                $('#product_class_error').html("");
                manageProductClassFn();
                manageCompatibleItemFn();
            }
            else{
                $(`input[name="product_class"][value="${product_class_global_var}"]`).prop('checked', true);
                toastrMessage('error',"You can not change product class, because there is a transaction linked with this product.","Error");
            }
        });

        function manageProductClassFn(){
            var prd_class = $('input[name="product_class"]:checked').val();
            if(prd_class == "Goods" || prd_class == "Commodity"){
                $('.non_service_div').show();
                $('#generateBtn').show();
                $('#barcodeDiv').hide();
            }
            else if(prd_class == "Service"){
                $('.non_service_div').hide();
                $('.non_service_input').val("");
                $('.non_service_error').html("");
                $('.non_service_checkbox').prop('checked', false);

                $('#ReqSerialNumber').val("Not-Require").select2({
                    placeholder: "Select value here",
                    minimumResultsForSearch: -1
                });

                $('#ReqExpireDate').val("Not-Require").select2({
                    placeholder: "Select value here",
                    minimumResultsForSearch: -1
                });

                $('#CompatibleProducts').val(null).select2({
                    placeholder: "Select compatible product here",
                });

                $('#dynamicTable > tbody').empty();

                $('#barcodeimages').empty();
            }
        }

        $('input[name="price_type"]').on('change', function() {
            var price_type = $(this).val();
            managePricingFn();
        });

        $(document).on('change', '.item_type', function() {
            $('#product_type-error').html("");
        });

        $(document).on('change', '.item_group_class', function() {
            $('#group-error').html("");
        });

        function managePricingFn(){
            var price_type = $('input[name="price_type"]:checked').val();
            if(price_type == "Flexible"){
                $('.flexible_attribute').show();
            }
            else if(price_type == "Fixed"){
                $('.flexible_attribute').hide();
                $('.flexible_input').val("");
                $('.flexible_error').html("");
            }
        }

        function manageCompatibleItemFn(){
            var product_class = $('input[name="product_class"]:checked').val();
            var item_options = $("#item_default");

            $('#CompatibleProducts').empty().append(item_options.find(`option[data-type="${product_class}"]`).clone());
            $('#CompatibleProducts').val(null).select2({
                placeholder: "Select compatible product here",
            });
        }
        
        $("#adds").click(function() {
            ++i;
            ++m;
            ++j;
            var lastrowcount = $('#dynamicTable > tbody > tr:last').find('td').eq(1).find('input').val();
            var supplier = $(`#supplier${lastrowcount}`).val();
            var supplier_option;
            var uom_option;
            var default_option = `<option selected disabled value=""></option>`;

            if(supplier !== undefined && isNaN(parseInt(supplier))){
                $(`#select2-supplier${lastrowcount}-container`).parent().css('background-color',errorcolor);
                toastrMessage('error',"Please insert valid data on highlighted field","Error");
            }
            else{
                $("#dynamicTable > tbody").append(`<tr id="rowind${m}">
                    <td style="font-weight:bold;width:3%;text-align:center;">${j}</td>
                    <td style="display:none;"><input type="hidden" name="row[${m}][vals]" id="vals${m}" class="vals form-control" readonly="true" style="font-weight:bold;" value="${m}"/></td>
                    <td style="width:25%;"><select id="supplier${m}" class="select2 form-control supplier" onchange="supplierFn(this)" name="row[${m}][supplier]"></select></td>
                    <td style="width:10%;"><select id="uom${m}" class="select2 form-control uom" onchange="uomFn(this)" name="row[${m}][uom]"></select></td>
                    <td style="width:12%;"><input type="number" name="row[${m}][quantity]" placeholder="Enter quantity here" id="quantity${m}" class="quantity form-control numeral-mask" onkeyup="quantityFn(this)" onkeypress="return ValidateNum(event);"/></td>
                    <td style="width:12%;"><input type="number" name="row[${m}][price]" placeholder="Enter price here" id="price${m}" class="price form-control numeral-mask" onkeyup="priceFn(this)" onkeypress="return ValidateNum(event);"/></td>
                    <td style="width:15%;"><select id="availablity${m}" class="select2 form-control availablity" name="row[${m}][availablity]" onchange="availablityFn(this)"></select></td>
                    <td style="width:20%;"><input type="text" name="row[${m}][remark]" placeholder="Enter remark here" id="remark${m}" class="remark form-control" onkeyup="remarkFn(this)"/></td>
                    <td style="width:3%;text-align:center;"><button type="button" id="removebtn${m}" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>
                </tr>`);

                supplier_option = $("#supplier_default > option").clone();
                $(`#supplier${m}`).append(supplier_option);

                uom_option = $("#uom_default > option").clone();
                $(`#uom${m}`).append(uom_option);

                $('#dynamicTable > tbody > tr').each(function(index, tr) {
                    let supp_id = $(this).find('.supplier').val();
                    $(`#supplier${m} option[value="${supp_id}"]`).remove(); 
                });

                $(`#supplier${m}`).append(default_option).select2({
                    placeholder: "Select supplier here",
                });

                $(`#uom${m}`).append(default_option).select2({
                    placeholder: "Select UOM here",
                });

                var availablity_status = '<option value="Available">Available</option><option value="Not-Available">Not-Available</option>';
                $(`#availablity${m}`).append(availablity_status).select2
                ({
                    placeholder: "Select availablity here",
                    minimumResultsForSearch: -1
                });

                $(`#select2-supplier${m}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                $(`#select2-uom${m}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                $(`#select2-availablity${m}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});

                renumberRows();
            }
        });

        $(document).on('click', '.remove-tr', function() {
            $(this).parents('tr').remove();
            renumberRows();
            --i;
        });

        function renumberRows() {
            var ind;
            $('#dynamicTable > tbody > tr').each(function(index,el) {
                $(this).children('td').first().text(index+=1);
            });
        }

        function supplierFn(ele) {
            var cid = $(ele).closest('tr').find('.vals').val();
            $(`#select2-supplier${cid}-container`).parent().css({"background":"white","position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
        }

        function uomFn(ele) {
            var cid = $(ele).closest('tr').find('.vals').val();
            $(`#select2-uom${cid}-container`).parent().css({"background":"white","position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
        }

        function quantityFn(ele) {
            var cid = $(ele).closest('tr').find('.vals').val();
            $(`#quantity${cid}`).css("background", "white");
        }

        function priceFn(ele) {
            var cid = $(ele).closest('tr').find('.vals').val();
            $(`#price${cid}`).css("background", "white");
        }

        function availablityFn(ele) {
            var cid = $(ele).closest('tr').find('.vals').val();
            $(`#select2-availablity${cid}-container`).parent().css({"background":"white","position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
        }

        function remarkFn(ele) {
            var cid = $(ele).closest('tr').find('.vals').val();
            $(`#remark${cid}`).css("background", "white");
        }

        function taxTypeValidation() {
            calculateTaxPricingFn();
            manageProductPurchaseCostFormFn();
            $('#taxType-error').html("");
        }

        function minSellingPriceBeforeTaxFn(){
            calculateAllPricingFn("min","before");
            $('.minimum_price_error').html("");
            //$('#min_selling_price_bt_error').html("");
        }

        function minSellingPriceAfterTaxFn(){
            calculateAllPricingFn("min","after");
            $('.minimum_price_error').html("");
            //$('#min_selling_price_at_error').html("");
        }

        function sellingPriceBeforeTaxFn(){
            calculateAllPricingFn("default","before");
            $('.default_price_error').html("");
            //$('#selling_price_bt_error').html("");
        }

        function sellingPriceAfterTaxFn(){
            calculateAllPricingFn("default","after");
            $('.default_price_error').html("");
            //$('#selling_price_at_error').html("");
        }

        function maxSellingPriceBeforeTaxFn(){
            calculateAllPricingFn("max","before");
            $('.maximum_price_error').html("");
            //$('#max_selling_price_bt_error').html("");
        }

        function maxSellingPriceAfterTaxFn(){
            calculateAllPricingFn("max","after");
            $('.maximum_price_error').html("");
            //$('#max_selling_price_at_error').html("");
        }

        function minVerifyPriceBeforeTaxFn(){
            var price_type = $('input[name="price_type"]:checked').val();
            var min_before_tax = $('#MinSellingPriceBeforeTax').val();
            min_before_tax = min_before_tax == '' ? 0 : min_before_tax;
            if(price_type == "Flexible" && parseFloat(min_before_tax) > 0){
                var default_before_tax = $('#SellingPriceBeforeTax').val();
                var max_before_tax = $('#MaxSellingPriceBeforeTax').val();

                default_before_tax = default_before_tax == '' ? 0 : default_before_tax;
                max_before_tax = max_before_tax == '' ? 0 : max_before_tax;

                if(parseFloat(min_before_tax) >= parseFloat(default_before_tax) && parseFloat(default_before_tax) > 0){
                    $('#min_selling_price_bt_error').html("Minimum price cannot be greater or equal to default price");
                    $('#MinSellingPriceBeforeTax').val("");
                    $('#MinSellingPriceAfterTax').val("");
                    toastrMessage("error","Please enter a valid data on the field","Error");
                }
                if(parseFloat(min_before_tax) >= parseFloat(max_before_tax) && parseFloat(max_before_tax) > 0){
                    $('#min_selling_price_bt_error').html("Minimum price cannot be greater or equal to maximum price");
                    $('#MinSellingPriceBeforeTax').val("");
                    $('#MinSellingPriceAfterTax').val("");
                    toastrMessage("error","Please enter a valid data on the field","Error");
                }
            }
        }

        function minVerifyPriceAfterTaxFn(){
            var price_type = $('input[name="price_type"]:checked').val();
            var max_after_tax = $('#MaxSellingPriceAfterTax').val();
            max_after_tax = max_after_tax == '' ? 0 : max_after_tax;
            if(price_type == "Flexible" && parseFloat(max_after_tax) > 0){
                var min_after_tax = $('#MinSellingPriceAfterTax').val();
                var default_after_tax = $('#SellingPriceAfterTax').val();
                
                min_after_tax = min_after_tax == '' ? 0 : min_after_tax;
                default_after_tax = default_after_tax == '' ? 0 : default_after_tax;
                
                if(parseFloat(min_after_tax) >= parseFloat(default_after_tax) && parseFloat(default_after_tax) > 0){
                    $('#min_selling_price_at_error').html("Minimum price cannot be greater or equal to default price");
                    $('#MinSellingPriceBeforeTax').val("");
                    $('#MinSellingPriceAfterTax').val("");
                    toastrMessage("error","Please enter a valid data on the field","Error");
                }
                if(parseFloat(min_after_tax) >= parseFloat(max_after_tax) && parseFloat(max_after_tax) > 0){
                    $('#min_selling_price_at_error').html("Minimum price cannot be greater or equal to default price");
                    $('#MinSellingPriceBeforeTax').val("");
                    $('#MinSellingPriceAfterTax').val("");
                    toastrMessage("error","Please enter a valid data on the field","Error");
                }
            }
        }

        function defaultVerifyPriceBeforeTaxFn(){
            var price_type = $('input[name="price_type"]:checked').val();
            var default_before_tax = $('#SellingPriceBeforeTax').val();
            default_before_tax = default_before_tax == '' ? 0 : default_before_tax;
            if(price_type == "Flexible" && parseFloat(default_before_tax) > 0){
                var min_before_tax = $('#MinSellingPriceBeforeTax').val();
                var max_before_tax = $('#MaxSellingPriceBeforeTax').val();

                min_before_tax = min_before_tax == '' ? 0 : min_before_tax;
                max_before_tax = max_before_tax == '' ? 0 : max_before_tax;

                if(parseFloat(default_before_tax) <= parseFloat(min_before_tax) && parseFloat(min_before_tax) > 0){
                    $('#selling_price_bt_error').html("Default price cannot be less or equal to minimum price");
                    $('#SellingPriceBeforeTax').val("");
                    $('#SellingPriceAfterTax').val("");
                    toastrMessage("error","Please enter a valid data on the field","Error");
                }
                if(parseFloat(default_before_tax) >= parseFloat(max_before_tax) && parseFloat(max_before_tax) > 0){
                    $('#selling_price_bt_error').html("Default price cannot be greater or equal to maximum price");
                    $('#SellingPriceBeforeTax').val("");
                    $('#SellingPriceAfterTax').val("");
                    toastrMessage("error","Please enter a valid data on the field","Error");
                }
            }
        }

        function defaultVerifyPriceAfterTaxFn(){
            var price_type = $('input[name="price_type"]:checked').val();
            var default_after_tax = $('#SellingPriceAfterTax').val();
            default_after_tax = default_after_tax == '' ? 0 : default_after_tax;

            if(price_type == "Flexible" && parseFloat(default_after_tax) > 0){
                var min_after_tax = $('#MinSellingPriceAfterTax').val();
                var max_after_tax = $('#MaxSellingPriceAfterTax').val();

                min_after_tax = min_after_tax == '' ? 0 : min_after_tax;
                max_after_tax = max_after_tax == '' ? 0 : max_after_tax;

                if(parseFloat(default_after_tax) <= parseFloat(min_after_tax) && parseFloat(min_after_tax) > 0){
                    $('#selling_price_at_error').html("Default price cannot be less or equal to minimum price");
                    $('#SellingPriceBeforeTax').val("");
                    $('#SellingPriceAfterTax').val("");
                    toastrMessage("error","Please enter a valid data on the field","Error");
                }
                if(parseFloat(default_after_tax) >= parseFloat(max_after_tax) && parseFloat(max_after_tax) > 0){
                    $('#selling_price_at_error').html("Default price cannot be greater or equal to maximum price");
                    $('#SellingPriceBeforeTax').val("");
                    $('#SellingPriceAfterTax').val("");
                    toastrMessage("error","Please enter a valid data on the field","Error");
                }
            }
        }

        function maxVerifyPriceBeforeTaxFn(){
            var price_type = $('input[name="price_type"]:checked').val();
            var max_before_tax = $('#MaxSellingPriceBeforeTax').val();
            max_before_tax = max_before_tax == '' ? 0 : max_before_tax;

            if(price_type == "Flexible" && parseFloat(max_before_tax) > 0){
                var min_before_tax = $('#MinSellingPriceBeforeTax').val();
                var default_before_tax = $('#SellingPriceBeforeTax').val();
                
                min_before_tax = min_before_tax == '' ? 0 : min_before_tax;
                default_before_tax = default_before_tax == '' ? 0 : default_before_tax;
                
                if(parseFloat(max_before_tax) <= parseFloat(default_before_tax) && parseFloat(default_before_tax) > 0){
                    $('#max_selling_price_bt_error').html("Maximum price cannot be less or equal to default price");
                    $('#MaxSellingPriceBeforeTax').val("");
                    $('#MaxSellingPriceAfterTax').val("");
                    toastrMessage("error","Please enter a valid data on the field","Error");
                }
                if(parseFloat(max_before_tax) <= parseFloat(min_before_tax) && parseFloat(min_before_tax) > 0){
                    $('#max_selling_price_bt_error').html("Maximum price cannot be less or equal to minimum price");
                    $('#MaxSellingPriceBeforeTax').val("");
                    $('#MaxSellingPriceAfterTax').val("");
                    toastrMessage("error","Please enter a valid data on the field","Error");
                }
            }
        }

        function maxVerifyPriceAfterTaxFn(){
            var price_type = $('input[name="price_type"]:checked').val();
            var max_after_tax = $('#MaxSellingPriceAfterTax').val();
            max_after_tax = max_after_tax == '' ? 0 : max_after_tax;

            if(price_type == "Flexible" && parseFloat(max_after_tax) > 0){
                var min_after_tax = $('#MinSellingPriceAfterTax').val();
                var default_after_tax = $('#SellingPriceAfterTax').val();
                
                min_after_tax = min_after_tax == '' ? 0 : min_after_tax;
                default_after_tax = default_after_tax == '' ? 0 : default_after_tax;
                
                if(parseFloat(max_after_tax) <= parseFloat(default_after_tax) && parseFloat(default_after_tax) > 0){
                    $('#max_selling_price_at_error').html("Maximum price cannot be less or equal to default price");
                    $('#MaxSellingPriceBeforeTax').val("");
                    $('#MaxSellingPriceAfterTax').val("");
                    toastrMessage("error","Please enter a valid data on the field","Error");
                }
                if(parseFloat(max_after_tax) <= parseFloat(min_after_tax) && parseFloat(min_after_tax) > 0){
                    $('#max_selling_price_at_error').html("Maximum price cannot be less or equal to mimimum price");
                    $('#MaxSellingPriceBeforeTax').val("");
                    $('#MaxSellingPriceAfterTax').val("");
                    toastrMessage("error","Please enter a valid data on the field","Error");
                }
            }
        }

        function calculateAllPricingFn(price_mode,tax_status){
            var tax_type = $('#TaxType').val();
            var tax_quotient = (parseFloat(tax_type) / 100) + parseInt(1);

            if(price_mode == "min"){
                var min_before_tax = $('#MinSellingPriceBeforeTax').val();
                var min_after_tax = $('#MinSellingPriceAfterTax').val();
                min_before_tax = min_before_tax == '' ? 0 : min_before_tax;
                min_after_tax = min_after_tax == '' ? 0 : min_after_tax;

                if(tax_status == "before"){
                    var after_tax_price = parseFloat(min_before_tax) * parseFloat(tax_quotient);
                    $('#MinSellingPriceAfterTax').val(parseFloat(after_tax_price).toFixed(2));
                }
                else if(tax_status == "after"){
                    var before_tax_price = parseFloat(min_after_tax) / parseFloat(tax_quotient);
                    $('#MinSellingPriceBeforeTax').val(parseFloat(before_tax_price).toFixed(2));
                }
            }

            if(price_mode == "default"){
                var default_before_tax = $('#SellingPriceBeforeTax').val();
                var default_after_tax = $('#SellingPriceAfterTax').val();
                default_before_tax = default_before_tax == '' ? 0 : default_before_tax;
                default_after_tax = default_after_tax == '' ? 0 : default_after_tax;

                if(tax_status == "before"){
                    var after_tax_price = parseFloat(default_before_tax) * parseFloat(tax_quotient);
                    $('#SellingPriceAfterTax').val(parseFloat(after_tax_price).toFixed(2));
                }
                else if(tax_status == "after"){
                    var before_tax_price = parseFloat(default_after_tax) / parseFloat(tax_quotient);
                    $('#SellingPriceBeforeTax').val(parseFloat(before_tax_price).toFixed(2));
                }
            }

            if(price_mode == "max"){
                var max_before_tax = $('#MaxSellingPriceBeforeTax').val();
                var max_after_tax = $('#MaxSellingPriceAfterTax').val();
                max_before_tax = max_before_tax == '' ? 0 : max_before_tax;
                max_after_tax = max_after_tax == '' ? 0 : max_after_tax;

                if(tax_status == "before"){
                    var after_tax_price = parseFloat(max_before_tax) * parseFloat(tax_quotient);
                    $('#MaxSellingPriceAfterTax').val(parseFloat(after_tax_price).toFixed(2));
                }
                else if(tax_status == "after"){
                    var before_tax_price = parseFloat(max_after_tax) / parseFloat(tax_quotient);
                    $('#MaxSellingPriceBeforeTax').val(parseFloat(before_tax_price).toFixed(2));
                }
            }
        }

        function calculateTaxPricingFn(){
            var tax_type = $('#TaxType').val();
            var tax_quotient = (parseFloat(tax_type) / 100) + parseInt(1);
            var min_before_tax = $('#MinSellingPriceBeforeTax').val();
            var min_after_tax = $('#MinSellingPriceAfterTax').val();

            var default_before_tax = $('#SellingPriceBeforeTax').val();
            var default_after_tax = $('#SellingPriceAfterTax').val();

            var max_before_tax = $('#MaxSellingPriceBeforeTax').val();
            var max_after_tax = $('#MaxSellingPriceAfterTax').val();

            tax_type = tax_type == '' ? 0 : tax_type;
            min_before_tax = min_before_tax == '' ? 0 : min_before_tax;
            min_after_tax = min_after_tax == '' ? 0 : min_after_tax;
            default_before_tax = default_before_tax == '' ? 0 : default_before_tax;
            default_after_tax = default_after_tax == '' ? 0 : default_after_tax;
            max_before_tax = max_before_tax == '' ? 0 : max_before_tax;
            max_after_tax = max_after_tax == '' ? 0 : max_after_tax;

            if(parseFloat(min_before_tax) > 0 && parseFloat(min_after_tax) >= 0){
                var after_tax_price = parseFloat(min_before_tax) * parseFloat(tax_quotient);
                $('#MinSellingPriceAfterTax').val(parseFloat(after_tax_price).toFixed(2));
            }
            if(parseFloat(min_before_tax) == 0 && parseFloat(min_after_tax) > 0){
                var before_tax_price = parseFloat(min_after_tax) / parseFloat(tax_quotient);
                $('#MinSellingPriceBeforeTax').val(parseFloat(before_tax_price).toFixed(2));
            }

            if(parseFloat(default_before_tax) > 0 && parseFloat(default_after_tax) >= 0){
                var after_tax_price = parseFloat(default_before_tax) * parseFloat(tax_quotient);
                $('#SellingPriceAfterTax').val(parseFloat(after_tax_price).toFixed(2));
            }
            if(parseFloat(default_before_tax) == 0 && parseFloat(default_after_tax) > 0){
                var before_tax_price = parseFloat(default_after_tax) / parseFloat(tax_quotient);
                $('#SellingPriceBeforeTax').val(parseFloat(before_tax_price).toFixed(2));
            }

            if(parseFloat(max_before_tax) > 0 && parseFloat(max_after_tax) >= 0){
                var after_tax_price = parseFloat(max_before_tax) * parseFloat(tax_quotient);
                $('#MaxSellingPriceAfterTax').val(parseFloat(after_tax_price).toFixed(2));
            }
            if(parseFloat(max_before_tax) == 0 && parseFloat(max_after_tax) > 0){
                var before_tax_price = parseFloat(max_after_tax) / parseFloat(tax_quotient);
                $('#MaxSellingPriceBeforeTax').val(parseFloat(before_tax_price).toFixed(2));
            }
        }

        function itemTabMgtFn(){
            $(".tab-title").removeClass("active");
            $(".tab-view").removeClass("active");
            
            $(".active-tab-title").addClass("active");
            $(".active-tab-view").addClass("active");
        }

        function itemInfoTabMgtFn(){
            $(".info-tab-title").removeClass("active");
            $(".info-tab-view").removeClass("active");
            
            $("#item-info-basic-tab").addClass("active");
            $("#item-info-basic-view").addClass("active");

            $("#info-v-image-tab").addClass("active");
            $("#info-v-image-view").addClass("active");
        }

        function tabMgtBasicFn(){
            $(".tab-title").removeClass("active");
            $(".tab-view").removeClass("active");
            $("#item-basic-tab").addClass("active");
            $("#item-basic-view").addClass("active");
        }

        function tabMgtInventoryFn(){
            $(".tab-title").removeClass("active");
            $(".tab-view").removeClass("active");
            $("#item-inventory-tab").addClass("active");
            $("#item-inventory-view").addClass("active");
        }

        function tabMgtPurchaseFn(){
            $(".tab-title").removeClass("active");
            $(".tab-view").removeClass("active");
            $("#item-purchase-tab").addClass("active");
            $("#item-purchase-view").addClass("active");
        }

        function tabMgtSalesFn(){
            $(".tab-title").removeClass("active");
            $(".tab-view").removeClass("active");
            $("#item-sales-tab").addClass("active");
            $("#item-sales-view").addClass("active");
        }

        function tabMgtOthersFn(){
            $(".tab-title").removeClass("active");
            $(".tab-view").removeClass("active");
            $("#item-others-tab").addClass("active");
            $("#item-others-view").addClass("active");
        }

        function productClassMgtFn(type){
            if(type == "Service"){
                $(".non_service_info").hide();
            }
            else{
                $(".non_service_info").show();
            }
        }

        function priceTypeMgtFn(pr_type){
            if(pr_type == "Fixed"){
                $(".flexible_class_info").hide();
            }
            else{
                $(".flexible_class_info").show();
            }
        }

        function costTablesetColor(costtype){
            switch (costtype) {
                case '1':
                    setAverageCostColor();
                    break;
                case '0':
                    setMaxCostColor();
                break;
                default:
                    break;
            }
        }

        function setAverageCostColor(){
            $("#averagecosttr").addClass("table-success");
            $("#averagecostabletr").addClass("table-success");
        }

        function setMaxCostColor(){
            $("#maxcosttr").addClass("table-success");
            $("#maxcostabletr").addClass("table-success");
        }

        function removeAverageCostColor(){
            $("#averagecosttr").removeClass("table-success");
            $("#averagecostabletr").removeClass("table-success");
        }

        function removeMaxCostColor(){
            $("#maxcostabletr").removeClass("table-success");
            $("#maxcosttr").removeClass("table-success");
        }


        function refreshtbl(){
            itemtable.ajax.reload(function() {
                unblockPage(cardSection);
            }, false); 
        }

        function refreshMainDatatbleFn(){
            var oTable = $('#itemdataables').dataTable(); 
            oTable.fnDraw(false);
        }

        //****************************************
        //****************************************
        //****************************************
        //****************************************
        //****************************************
        //Ending a new modification.......

        function openHeader(){
            var transaction=$('#transactionEdit').val();
            switch(transaction){
                case '1':
                    withDivSection.block({
                        message:
                        '',
                        timeout: 1,
                        css: {
                        backgroundColor: '',
                        color: '',
                        border: ''
                        },
                    });
                    GroupDivSection.block({
                        message:
                        '',
                        timeout: 1,
                        css: {
                        backgroundColor: '',
                        color: '',
                        border: ''
                        },
                    });
                    nameDivSection.block({
                        message:
                        '',
                        timeout: 1,
                        css: {
                        backgroundColor: '',
                        color: '',
                        border: ''
                        },
                    });
                    uomDivSection.block({
                        message:
                        '',
                        timeout: 1,
                        css: {
                        backgroundColor: '',
                        color: '',
                        border: ''
                        },
                    });
                    codeDivSection.block({
                        message:
                        '',
                        timeout: 1,
                        css: {
                        backgroundColor: '',
                        color: '',
                        border: ''
                        },
                    });
                    categoryDivSection.block({
                        message:
                        '',
                        timeout: 1,
                        css: {
                        backgroundColor: '',
                        color: '',
                        border: ''
                        },
                    });
                    break;
                default:
                    toastrMessage('error','Access Deneid!','Error'); 
                    $('#name-error').html('Access Denied!');
            }
        }

        $('body').on('click', '.showItem', function() {
            var item_id = $(this).data('id');
            var uom = $(this).data('uom');
            var category = $(this).data('category');
            var max=$(this).data('max');
            var pendingqty=$(this).data('pending');
            var minstock=$(this).data('minstock');
            var balance=$(this).data('balance');
            var minamount=$(this).data('minamount');
            var maxicost=$(this).data('maxicost');
            var averagecost=$(this).data('averagecost');   
            showitemInformation(item_id,uom,category,max,pendingqty,minstock,balance,minamount,maxicost,averagecost);
        });
        
        $('#itemdeletebutton').click(function(){
            var id=$('#ids').val();
            $('#did').val(id);
            $('#deleteitem').modal('show');
        });

        

        function checkminstockpermission(group) {
            switch (group) {
                case 'Imported':
                    var importitemstoreminquantity=$('#importitemstoreminquantity').val();
                        switch (importitemstoreminquantity) {
                            case '1':
                                    $('#minimumstockdiv').show();
                                break;
                            default:
                                    console.log('not active');
                                    $('#minimumstockdiv').hide();
                                break;
                        }
                    break;
                default:
                        var localitemstoreminquantity=$('#localitemstoreminquantity').val();
                        switch (localitemstoreminquantity) {
                            case '1':
                                    $('#minimumstockdiv').show();
                                break;
                            default:
                                    $('#minimumstockdiv').hide();
                                break;
                        }
                    break;
            }
        }

        function somedivhideandshow(type) {
            switch (type) {
                case 'Service':
                        $('#lblretailprice').html('Price');
                        $('#TypeId').select2('destroy');
                        $('#TypeId').val(type).select2();
                        $('#serialNumDiv').hide();
                        $('#expireDateDiv').hide();
                        $('#partNumDiv').hide();
                        $('#lowStockDiv').hide();
                        $('#skuNumberDiv').hide();
                        $('#pmretail').hide();
                        $('#pmretaillbl').hide();
                        $('#GroupDiv').hide();
                        $('#wholesellerDiv').hide();
                        $('#wholesellerMinAmounDiv').hide();
                        $("#ReqSerialNumber").val("Not-Require");
                        $("#ReqExpireDate").val("Not-Require");
                        $("#partNumber").val("");
                        $("#lowStock").val("");
                        $("#skuNumber").val("");
                        $('#requireSerialNumber-error').html("");
                        $('#requireExpireDate-error').html("");
                        $('#partNumber-error').html("");
                        $('#lowStock-error').html("");
                        $('#skuNumber-error').html("");
                        $('#purchasediv').hide();
                        $('#purchasediv').removeClass('col-md-3');
                        $('#purchasediv').removeClass('col-md-0');
                        $('#itemsdiv').removeClass('col-md-9');
                        $('#itemsdiv').removeClass('col-md-12');
                        $('#purchasediv').addClass('col-md-0');
                        $('#itemsdiv').addClass('col-md-12');
                    break;
                case 'Goods':
                        $('#TypeId').select2('destroy');
                        $('#TypeId').val(type).select2();
                        $('#lblretailprice').html('Retail Price');
                        $('#nameDiv').show();
                        $('#codeDiv').show();
                        $('#GroupDiv').show();
                        $('#categoryDiv').show();
                        $('#uomDiv').show();
                        $('#retailerDiv').show();
                        $('#wholesellerDiv').show();
                        $('#wholesellerMinAmounDiv').show();
                        $('#minimumstockdiv').show();
                        $('#taxtypeDiv').show();
                        $('#serialNumDiv').show();
                        $('#expireDateDiv').show();
                        $('#partNumDiv').show();
                        $('#lowStockDiv').show();
                        $('#skuNumberDiv').show();
                        $('#statusDiv').show();
                        $('#purchasediv').show();
                        $('#pmretail').show();
                        $('#pmretaillbl').show();
                        $('#purchasediv').removeClass('col-md-3');
                        $('#purchasediv').removeClass('col-md-0');
                        $('#itemsdiv').removeClass('col-md-9');
                        $('#itemsdiv').removeClass('col-md-12');
                        $('#purchasediv').addClass('col-md-3');
                        $('#itemsdiv').addClass('col-md-9');
                        break;
                default:
                    $('#TypeId').select2('destroy');
                    $('#TypeId').val(type).select2();
                    $('#retailerDiv').hide();
                    $('#wholesellerDiv').hide();
                    $('#wholesellerMinAmounDiv').hide();
                    $('#minimumstockdiv').hide();
                    $('#taxtypeDiv').hide();
                    $('#serialNumDiv').show();
                    $('#expireDateDiv').show();
                    $('#partNumDiv').show();
                    $('#lowStockDiv').show();
                    $('#skuNumberDiv').show();
                    $('#purchasediv').show();
                    $('#pmretail').show();
                    $('#pmretaillbl').show();
                    $('#GroupDiv').show();
                    $('#purchasediv').removeClass('col-md-3');
                    $('#purchasediv').removeClass('col-md-0');
                    $('#itemsdiv').removeClass('col-md-9');
                    $('#itemsdiv').removeClass('col-md-12');
                    $('#purchasediv').addClass('col-md-3');
                    $('#itemsdiv').addClass('col-md-9');
                    break;
            }
        }

        function editransaction(transaction){
                switch(transaction){
                        case 0:
                            withDivSection.block({
                                message:
                                '',
                                timeout: 1,
                                css: {
                                backgroundColor: '',
                                color: '',
                                border: ''
                                },
                            });
                            GroupDivSection.block({
                                message:
                                '',
                                timeout: 1,
                                css: {
                                backgroundColor: '',
                                color: '',
                                border: ''
                                },
                            });
                            nameDivSection.block({
                                message:
                                '',
                                timeout: 1,
                                css: {
                                backgroundColor: '',
                                color: '',
                                border: ''
                                },
                            });
                            uomDivSection.block({
                                message:
                                '',
                                timeout: 1,
                                css: {
                                backgroundColor: '',
                                color: '',
                                border: ''
                                },
                            });
                            categoryDivSection.block({
                                message:
                                '',
                                timeout: 1,
                                css: {
                                backgroundColor: '',
                                color: '',
                                border: ''
                                },
                            });
                            codeDivSection.block({
                                message:
                                '',
                                timeout: 1,
                                css: {
                                backgroundColor: '',
                                color: '',
                                border: ''
                                },
                            });
                            break;
                        default:
                            withDivSection.block({
                                message:
                                '<div class="d-flex justify-content-center align-items-center"><p class="mr-50 mb-50" style="color:red;"><b></b></p><div class="" role="status"></div> </div>',
                                css: {
                                backgroundColor: 'transparent',
                                color: '#fff',
                                border: '0'
                                },
                                overlayCSS: {
                                opacity: 0.3
                                }
                            });
                            GroupDivSection.block({
                                message:
                                '<div class="d-flex justify-content-center align-items-center"><p class="mr-50 mb-50" style="color:red;"><b></b></p><div class="" role="status"></div> </div>',
                                css: {
                                backgroundColor: 'transparent',
                                color: '#fff',
                                border: '0'
                                },
                                overlayCSS: {
                                opacity: 0.3
                                }
                            });
                            nameDivSection.block({
                                message:
                                '<div class="d-flex justify-content-center align-items-center"><p class="mr-50 mb-50" style="color:red;"><b></b></p><div class="" role="status"></div> </div>',
                                css: {
                                backgroundColor: 'transparent',
                                color: '#fff',
                                border: '0'
                                },
                                overlayCSS: {
                                opacity: 0.3
                                }
                            });
                            uomDivSection.block({
                                message:
                                '<div class="d-flex justify-content-center align-items-center"><p class="mr-50 mb-50" style="color:red;"><b></b></p><div class="" role="status"></div> </div>',
                                css: {
                                backgroundColor: 'transparent',
                                color: '#fff',
                                border: '0'
                                },
                                overlayCSS: {
                                opacity: 0.3
                                }
                            });
                            categoryDivSection.block({
                                message:
                                '<div class="d-flex justify-content-center align-items-center"><p class="mr-50 mb-50" style="color:red;"><b></b></p><div class="" role="status"></div> </div>',
                                css: {
                                backgroundColor: 'transparent',
                                color: '#fff',
                                border: '0'
                                },
                                overlayCSS: {
                                opacity: 0.3
                                }
                            });
                            codeDivSection.block({
                                message:
                                '<div class="d-flex justify-content-center align-items-center"><p class="mr-50 mb-50" style="color:red;"><b></b></p><div class="" role="status"></div> </div>',
                                css: {
                                backgroundColor: 'transparent',
                                color: '#fff',
                                border: '0'
                                },
                                overlayCSS: {
                                opacity: 0.3
                                }
                            });
                            
                    }
        }

        function addclasstocost(pmwholesale,pmretail){
            $('#mincostbvlbl').html('Access Denied!');  
            $('#averagecostbvlbl').html('Access Denied!'); 
            $('#maxcostbvlbl').html('Access Denied!');
            $('#mincostlbl').html('Access Denied!');
            $('#averagecostlbl').html('Access Denied!');
            $('#maxcostlbl').html('Access Denied!');
            $('#pmwholesale').val('AD');
            $('#pmretail').val('AD');
            $('#pmwholesale').prop('readonly', true);
            $('#pmretail').prop('readonly', true);
            $('#pmwholesalehidden').val(pmwholesale);
            $('#pmretailhidden').val(pmretail);
            $("#mincostlbl").addClass("badge badge-pill badge-light-danger mr-1");
            $("#averagecostlbl").addClass("badge badge-pill badge-light-danger mr-1");
            $('#maxcostlbl').addClass('badge badge-pill badge-light-danger mr-1');
            $("#mincostbvlbl").addClass("badge badge-pill badge-light-danger mr-1");
            $("#averagecostbvlbl").addClass("badge badge-pill badge-light-danger mr-1");
            $('#maxcostbvlbl').addClass('badge badge-pill badge-light-danger mr-1');
        }

        function removeclassfromcost(){
            $("#mincostlbl").removeClass("badge badge-pill badge-light-danger mr-1");
            $("#averagecostlbl").removeClass("badge badge-pill badge-light-danger mr-1");
            $('#maxcostlbl').removeClass('badge badge-pill badge-light-danger mr-1');
            $("#mincostbvlbl").removeClass("badge badge-pill badge-light-danger mr-1");
            $("#averagecostbvlbl").removeClass("badge badge-pill badge-light-danger mr-1");
            $('#maxcostbvlbl').removeClass('badge badge-pill badge-light-danger mr-1');
        }

        $('#printbutton').click(function() {
            var cid = $('#ids').val();
            console.log('print id=' + cid);
            var link = '/printbarcodes/' + cid;
            window.open(link, 'Barcodes', 'width=1200,height=800,scrollbars=yes');
        });

        $('#deletebtnitem').click(function() {
            var cid = document.forms['itemdeleteform'].elements['did'].value;
            var registerForm = $("#itemdeleteform");
            var formData = registerForm.serialize();
            console.log('ccid==' + cid)
            $.ajax({
                url: '/itemdelete/' + cid,
                type: 'DELETE',
                data: formData,
                beforeSend: function() {
                    $('#deletebtnitem').text('Deleting Item...');
                },
                success: function(data) {
                    if (data.success) {
                        toastrMessage('success',data.success,'Delete');
                        $('#deletebtnitem').text('Delete');
                        $('#deleteitem').modal('hide');
                        $('#deletebtnconversion').text('Delete');
                        var oTable = $('#itemdataables').dataTable();
                        oTable.fnDraw(false);
                    }
                    if (data.deleteErrors) {
                        toastrMessage('error','This Item Can not be Deleted, There is data with these items on other tables','Error');
                        $('#deletebtnitem').text('Delete');
                        $('#deleteitem').modal('hide');
                        $('#deletebtnconversion').text('Delete');
                        var oTable = $('#itemdataables').dataTable();
                        oTable.fnDraw(false);
                    }
                    if(data.errors){
                        toastrMessage('error',data.errors,'Error');
                        $('#deletebtnitem').text('Delete');
                        $('#deleteitem').modal('hide');
                        var oTable = $('#itemdataables').dataTable();
                        oTable.fnDraw(false);
                    }
                }
            })
        });
        
        function makebatchupdaterequest(){
            var registerForm = $("#batchupdateform");
            var formData = registerForm.serialize();
            return $.ajax({
                type: "POST",
                url: "batchupdate",
                data: formData,
                dataType: "json",
                beforeSend: function() {
                    $('#batchupadtesavebutton').text('Saving...');
                    $('#batchupadtesavebutton').prop('disabled',true);
            },
                
            });
        }

        $('#batchupadtesavebutton').click(function() {
            $.when(makebatchupdaterequest()).then(function successHandler(response){
                if(response.errors){
                        if(response.errors.category){
                            $('#batchcategory-error').html(response.errors.category[0]);
                        }
                        if(response.errors.itemGroup){
                            $('#batchgroup-error').html(response.errors.itemGroup[0]);
                        }
                        if(response.errors.percent){
                            $('#batchpercent-error').html(response.errors.percent[0]);
                        }
                        if(response.errors.item){
                            $('#batchitem-error').html(response.errors.item[0]);
                        }
                        if(response.errors.increaseDescrease){
                            var text=response.errors.increaseDescrease[0];
                                text = text.replace("increase descrease", "plus or minus");
                                $('#increaseDescrease-error').html(text);
                        }
                    }
                    if(response.success){
                        $('#batchupadtesavebutton').text('Save');
                        $('#batchupadtesavebutton').prop('disabled',false);  
                        toastrMessage('success','Successfully update the price','Multiple price update')
                    $("#batchupdateformodal").modal('hide');
                    $("#batchupdateform")[0].reset();
                    var oTable = $('#itemdataables').dataTable();
                        oTable.fnDraw(false);
                    closebatchModalWithClearValidation();
                    }
                
            },function errorHandler(){
                console.log('error occured');
                toastrMessage('error','Error is occured','Error');
            })
            
            return false;
        });
        // $(function () {
        //     cardSection = $('#card-block');
        // });
        $('#batchupadtepreviewbutton').click(function() {
            $('#batchupdatedatablediv').show();
            $('#dividerdiv').show();
            $('#batchupadtesavebutton').show();
            var registerForm = $("#batchupdateform");
            var formData = registerForm.serialize();
            var item=$('#batchitem').val();
                    var itemtable=$('#batchupdatedatable').DataTable({
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    destroy:true,
                    "lengthMenu": [[50, 100], [50, 100]],
                    language: {
                        search: '',
                        searchPlaceholder: "Search here",
                    },
                    "dom": "<'row'<'col-lg-10 col-md-10 col-xs-1'f><'col-lg-2 col-md-2 col-xs-8'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-3'i><'col-sm-12 col-md-5'p>>",
                            ajax: {
                            async:true,
                            url: "{{ url('batchupdatepreview') }}/"+item,
                            type: 'DELETE',
                        
                            beforeSend: function () {
                            $('#batchupadtepreviewbutton').prop('disabled',true);
                            $('#loadid').addClass('spinner-border spinner-border-sm');
                            $('#saveid').addClass('sml-25 align-middle').text('Please wait...');
                            cardSection.block({
                                message:
                                '<div class="d-flex justify-content-center align-items-center"><p class="mr-50 mb-50">Loading Please wait...</p><div class="spinner-grow spinner-grow-sm text-white" role="status"></div> </div>',
                                //timeout: 1000,
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
                        $('#batchupadtepreviewbutton').prop('disabled',false);
                        $('#loadid').removeClass('spinner-border spinner-border-sm');
                        $('#saveid').text('View');
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
                    },
                columns: [
                    {data:'DT_RowIndex'},
                    {data: 'itemGroup', name: 'itemGroup'},
                    {data: 'Code', name: 'Code' },
                    {data: 'Name',name: 'Name'},
                    {data: 'SKUNumber',name: 'SKUNumber' },
                    {data: 'category',name: 'category'},
                    {data: 'UOM',name: 'UOM'},
                    {data: 'MaxCost', render: $.fn.dataTable.render.number( ',', '.', 2) },
                    {data: 'RetailerPrice',name: 'RetailerPrice',render: $.fn.dataTable.render.number( ',', '.', 2) },
                    {data: 'WholesellerPrice',name: 'WholesellerPrice', render: $.fn.dataTable.render.number( ',', '.', 2) },
                    {data: 'id',name: 'id'},
                    {data: 'id',name: 'id' },
                ],
                columnDefs: [ {
                    targets: 10,
                    render: function ( data, type, row, meta ) {
                        var percent =$('#percent').val();
                        var incrdecr=$('#increaseDescrease').val();
                        var percentoadd=parseFloat(percent/100)+1;
                        
                        if(incrdecr==1){
                            var newprice=row.RetailerPrice*percentoadd;
                            var num = $.fn.dataTable.render.number(',', '.', 2).display(newprice);
                            return "<span class='badge badge-light-success'>"+num+"</span>";
                        }
                        else if(incrdecr==2){
                            var newprice=row.RetailerPrice/percentoadd;
                            if(newprice>row.MaxCost){
                                var num = $.fn.dataTable.render.number(',', '.', 2).display(newprice);
                                return "<span class='badge badge-light-warning'>"+num+"</span>";
                            }
                            else{
                                var num = $.fn.dataTable.render.number(',', '.', 2).display(row.RetailerPrice);
                                return "<span class='badge badge-light-danger'>"+num+"</span>";
                            }
                        }
                    }
                },{
                    targets: 11,
                    render: function ( data, type, row, meta ) {
                        var percent =$('#percent').val();
                        var incrdecr=$('#increaseDescrease').val();
                        var percentoadd=parseFloat(percent/100)+1;
                        if(incrdecr==1){
                            var newprice=row.WholesellerPrice*percentoadd;
                            var num = $.fn.dataTable.render.number(',', '.', 2).display(newprice);
                            return "<span class='badge badge-light-success'>"+num+"</span>";
                        }
                        else if(incrdecr==2){
                            var newprice=row.WholesellerPrice/percentoadd;
                            var retprice=row.RetailerPrice/percentoadd;
                            if(retprice>row.MaxCost){
                                var num = $.fn.dataTable.render.number(',', '.', 2).display(newprice);
                                return "<span class='badge badge-light-warning'>"+num+"</span>";
                            }
                            else{
                                var num = $.fn.dataTable.render.number(',', '.', 2).display(row.WholesellerPrice);
                                return "<span class='badge badge-light-danger'>"+num+"</span>";
                            }
                        }
                }
            }
            ]
            });
        });
        
        function copyAverageCostBv(){
            var averagcost=$('#averagecostbv').val();
            var result=parseFloat(averagcost)*1.15;
            $('#averagecost').val(result.toFixed(2));
            $('#averagecostlbl').html(result.toFixed(2));
        }

        function copyAverageCost(){
            var averagcost=$('#averagecost').val();
            var result=parseFloat(averagcost)/1.15;
            $('#averagecostbv').val(result.toFixed(2));
            $('#averagecostbvlbl').html(result.toFixed(2));
        }

        function copyMaxCost() {
            var mx = $('#maxcost').val();
            $('#maxcosti').val(mx);
            var max = $('#maxcost').val();
            var result = parseFloat(max) / 1.15;
            $('#maxcostbv').val(result.toFixed(2));
            $('#maxcostbvlbl').html(result.toFixed(2));
        }

        function copyMaxCostBv() {
            var maxc = $('#maxcostbv').val();
            var result = parseFloat(maxc) * 1.15;
            $('#maxcost').val(result.toFixed(2));
            $('#maxcosti').val(result.toFixed(2));
            $('#maxcostlbl').html(result.toFixed(2));
        }
        function removeNameValidation() {
            $('#name-error').html("");
        }

        function removeCodeValidation() {
            var item_code_type = $('#ItemCodeType').val();
            var code = $('#code').val();
            if(parseInt(item_code_type) == 1){
                var code_hidden = $('#codeHidden').val();

                if(code == code_hidden){
                    $('#generate_item_code').show();
                    $("#ItemCodeMode").val("Generated");
                }
                else if(code != code_hidden){
                    $('#generate_item_code').show();
                    $("#ItemCodeMode").val("Manual");
                }
            }
            
            $('#barcodeCode').html(code);
            $('#code-error').html("");
        }

        function categoryValidation() {
            $('#category-error').html("");
        }
        function uomValidation() {
            $('#uom-error').html("");
        }
        function cleargroupvalidation(){
            $('#group-error').html("");
        }
        
        function calculateretailpercent(){
            if ( $('#pmretail').is('[readonly]') ) {
                toastrMessage('error','Access Denied!','Error!');
            }else{
                var pmretail=$('#pmretail').val();
                var costtype=parseFloat($('#costtype').val());
                var averageCost=$('#averagecostbv').val()||0;
                var maxCost=$('#maxcostbv').val()||0;
                var cost=costtype==1?averageCost:maxCost;
                var percent=(parseFloat(pmretail)/100)+1;
                var profit=parseFloat(cost)*parseFloat(percent);
                var retailpricebeorevat=parseFloat(cost)+parseFloat(profit);
                var retailpriceaftervat=parseFloat(profit)*1.15;
                $('#retailPricebv').val(profit.toFixed(2));
                $('#retailPrice').val(retailpriceaftervat.toFixed(2));
            }
        }
        function calculatewholesalepercent(){
            if ( $('#pmwholesale').is('[readonly]') ) {
                toastrMessage('error','Access Denied!','Error!');
            }
            else{
                var pmwholesale=$('#pmwholesale').val();
                var costtype=parseFloat($('#costtype').val());
                var averageCost=$('#averagecostbv').val()||0;
                var maxCost=$('#maxcostbv').val()||0;
                var cost=costtype==1?averageCost:maxCost;
                var percent=(parseFloat(pmwholesale)/100)+1;
                var profit=parseFloat(cost)*parseFloat(percent);
                var wholesalepriceaftervat=parseFloat(profit)*1.15;
                $('#wholeSellerPricebv').val(profit.toFixed(2));
                $('#wholeSellerPrice').val(wholesalepriceaftervat.toFixed(2));
            }
        }
        function retailerPriceValidation() {
            $('#retailPrice-error').html("");
            var itemgroup=$('#igroup').val();
            switch (itemgroup) {
                case 'Local':
                    var localitempriceupdate=$('#localitempriceupdate').val();
                    switch (localitempriceupdate) {
                        case '1':
                            checkretailpermissionaftervat();
                            break;
                        default: 
                        toastrMessage('error','Access Denied','ERROR!');
                            break;
                    }
                    break;
            
                default:
                    var importitempriceupdate=$('#importitempriceupdate').val();
                    switch (importitempriceupdate) {
                    case '1':
                        checkretailpermissionaftervat();
                        break;
                    
                    default:
                        break;
                    }
                    break;
            }
            
        }
        function checkretailpermissionaftervat() {
            var id=$('#ids').val()||0;
            var retail = $('#retailPrice').val()||0;
            var result = parseFloat(retail) / 1.15;
            var percentage='';
            if(result==0){
                $('#retailPricebv').val('');
                $('#pmretail').val('');
            } else{
                $('#retailPricebv').val(result.toFixed(2));
                    if(parseFloat(id)!=0){
                    var group=$('#igroup').val();
                    var importcostpermission=$('#importcost').val();
                    var localcostpermission=$('#localcost').val();
                    var costtype=parseFloat($('#costtype').val());
                    var averageCost=$('#averagecost').val()||0;
                    var maxCost=$('#maxcost').val()||0;
                    var cost=costtype==1?averageCost:maxCost;
                    var variance=parseFloat(retail)-parseFloat(cost); //(newvalue-originalvalue/originalvalue)*100
                    switch (cost) {
                        case 0:
                            percentage='';
                            break;
                    
                        default:
                            percentage=((parseFloat(variance)/cost)*100).toFixed(2);
                            break;
                    }
        
                            if(group=="Local"){
                        if(localcostpermission==1){
                            $('#pmretail').val(percentage);
                        } else{
                            // access denied
                            $('#pmretailhidden').val(percentage);
                        }
                    } 
                    else if(group=="Imported"){
                        if(importcostpermission==1){
                            $('#pmretail').val(percentage);
                        }else{
                            // access denied
                            $('#pmretailhidden').val(percentage);
                        }
                    }else{
                        // not both
                    }
                }
            }
        }
        function retailerPriceValidationbv() {
            var itemgroup=$('#igroup').val();
            switch (itemgroup) {
                case 'Local':
                    var localitempriceupdate=$('#localitempriceupdate').val();
                    switch (localitempriceupdate) {
                        case '1':
                            checkretailpricepermission();
                            break;
                        default:
                            toastrMessage('error','Access Denied!','Error!');
                            break;
                    }
                    break;
                default:
                    var importitempriceupdate=$('#importitempriceupdate').val();
                        switch (importitempriceupdate) {
                            case '1':
                                checkretailpricepermission();
                                break;
                        
                            default:
                                toastrMessage('error','Access Denied!','Error!');
                                break;
                        }
                    break;
            }
        } 
        function checkretailpricepermission() {
                var id=$('#ids').val()||0;
                var retail = $('#retailPricebv').val()||0;
                var result = parseFloat(retail) * 1.15;
                var percentage='';
                if(result==0){
                    $('#retailPrice').val('');
                    $('#pmretail').val('');
                } else{
                    $('#retailPrice').val(result.toFixed(2));
                    if(parseFloat(id)!=0){
                    var group=$('#igroup').val();
                    var importcostpermission=$('#importcost').val();
                    var localcostpermission=$('#localcost').val();
                    var costtype=parseFloat($('#costtype').val());
                    var averageCost=$('#averagecostbv').val()||0;
                    var maxCost=$('#maxcostbv').val()||0;
                    var cost=costtype==1?averageCost:maxCost;
                    var variance=parseFloat(retail)-parseFloat(cost); //(newvalue-originalvalue/originalvalue)*100
                    switch (cost) {
                        case 0:
                            percentage='';
                            break;
                            default:
                            percentage=((parseFloat(variance)/cost)*100).toFixed(2);
                            break;
                        }
                            if(group=="Local"){
                            if(localcostpermission==1){
                                $('#pmretail').val(percentage);
                            } else{
                                // access denied
                                $('#pmretailhidden').val(percentage);
                            }
                        } 
                        else if(group=="Imported"){
                            if(importcostpermission==1){
                                $('#pmretail').val(percentage);
                            }else{
                                // access denied
                                $('#pmretailhidden').val(percentage);
                            }
                        }else{
                        }
                }
                }
        }
        function wholesellerPriceValidation() {
            $('#wholeSellerPrice-error').html("");
            var group=$('#igroup').val();
            switch (group) {
                case 'Local':
                        var priceupdate=$('#localitempriceupdate').val();
                        wholesalepricevaliadte(priceupdate);
                    break;
                
                default:
                        var priceupdate=$('#importitempriceupdate').val();
                        wholesalepricevaliadte(priceupdate);
                    break;
            }
        }
        function wholesalepricevaliadte(priceupdate) {
            switch (priceupdate) {
                case '1':
                    var id=$('#ids').val()||0;
                    var wholesell = $('#wholeSellerPrice').val()||0;
                    var result = parseFloat(wholesell) / 1.15;
                    var percentage='';
                    if(result==0){
                            $('#wholeSellerMinAmount').val('');
                            $('#wholeSellerMaxAmount').val('');
                            $('#minimumstock').val('');
                            $('#wholeSellerPricebv').val('');
                            $('#pmwholesale').val('');
                    }
                    else{
                        $('#wholeSellerPricebv').val(result.toFixed(2));
                        $("#wholeSellerMinAmount").prop("readonly", false);
                        if(id!=0){
                            var group=$('#igroup').val();
                            var importcostpermission=$('#importcost').val();
                            var localcostpermission=$('#localcost').val();
                            var costtype=parseFloat($('#costtype').val());
                            var averageCost=$('#averagecost').val()||0;
                            var maxCost=$('#maxcost').val()||0;
                            var cost=costtype==1?averageCost:maxCost;
                            var variance=parseFloat(wholesell)-parseFloat(cost); //(newvalue-originalvalue/originalvalue)*100
                            switch (cost) {
                                case 0:
                                    percentage='';
                                    break;
                            
                                default:
                                    percentage=((parseFloat(variance)/cost)*100).toFixed(2);
                                    
                                    break;
                            }
                            
                                if(group=="Local"){
                                if(localcostpermission==1){
                                        $('#pmwholesale').val(percentage);
                                    } else{
                                        // access denied
                                        $('#pmwholesalehidden').val(percentage);
                                    }
                                } 
                                else if(group=="Imported"){
                                    if(importcostpermission==1){
                                        $('#pmwholesale').val(percentage);
                                    }else{
                                        // access denied
                                        $('#pmwholesalehidden').val(percentage);
                                    }
                                }else{
                                    // not both
                                }
                        }
                    }
                    break;
                default:
                    toastrMessage('error','Access Denied!','Error!');
                    break;
            }
        }
        function wholesellerPriceValidationBv() {
            $('#wholeSellerPrice-error').html("");
            var itemgroup=$('#group').val();
            switch (itemgroup) {
                case 'Local':
                    var localitempriceupdate=$('#localitempriceupdate').val();
                    switch (localitempriceupdate) {
                        case '1':
                            checkwholesalepricebeforevatpermsion();
                            break;
                        default:
                                toastrMessage('error','Access Denied!','Error!');
                            break;
                    }
                    break;
                default:
                    var importitempriceupdate=$('#importitempriceupdate').val();
                    switch (importitempriceupdate) {
                        case '1':
                            checkwholesalepricebeforevatpermsion();
                            break;
                        default:
                                toastrMessage('error','Access Denied!','Error!');
                            break;
                    }
                    break;
            }
        }
        function checkwholesalepricebeforevatpermsion() {
            var id=$('#ids').val()||0;
            var wholesell = $('#wholeSellerPricebv').val()||0;
            var result = parseFloat(wholesell) * 1.15;
            var percentage='';
            if(result==0){
                    $('#wholeSellerMinAmount').val('');
                    $('#wholeSellerMaxAmount').val('');
                    $('#minimumstock').val('');
                    $('#wholeSellerPrice').val('');
                    $('#pmwholesale').val('');
            }
            else{
                $('#wholeSellerPrice').val(result.toFixed(2));
                $("#wholeSellerMinAmount").prop("readonly", false);
                if(id!=0){
                    var group=$('#igroup').val();
                    var importcostpermission=$('#importcost').val();
                    var localcostpermission=$('#localcost').val();
                    var costtype=parseFloat($('#costtype').val());
                    var averageCost=$('#averagecostbv').val()||0;
                    var maxCost=$('#maxcostbv').val()||0;
                    var cost=costtype==1?averageCost:maxCost;
                    var variance=parseFloat(wholesell)-parseFloat(cost); //(newvalue-originalvalue/originalvalue)*100
                    switch (cost) {
                        case 0:
                            percentage='';
                            break;
                    
                        default:
                            percentage=(parseFloat(variance)/cost)*100;
                            percentage=percentage.toFixed(2);
                            break;
                    }
                    
                        if(group=="Local"){
                            if(localcostpermission==1){
                                    $('#pmwholesale').val(percentage);
                                } else{
                                    // access denied
                                    $('#pmwholesalehidden').val(percentage);
                                }
                            } 
                            else if(group=="Imported"){
                                if(importcostpermission==1){
                                    $('#pmwholesale').val(percentage);
                                }else{
                                    // access denied
                                    $('#pmwholesalehidden').val(percentage);
                                }
                            }else{
                                // not both
                            }
                }
            }
        }
        function wholeSellerMaxAmountValidation() {
            var max = $('#wholeSellerMaxAmount').val()||0;
            var alablestock = $('#balance').val()||0;
            var minstock = parseFloat(alablestock) - parseFloat(max);
            minstock = minstock > 0 ? minstock : 0;
            $('#minimumstock').val(minstock);
            $("#minimumstock").prop("readonly", false);
        }

        function wholeSellerMinAmountValidation() {
            $('#wholeSellerMinAmount-error').html("");
        }

        function priceTypeFn() {
            $('#price_type-error').html("");
        }

        function compatibleProductFn() {
            $('#compatible_products-error').html("");
        }

        function reqSerialNumValidation() {
            $('#requireSerialNumber-error').html("");
        }

        function reqExpDateValidation() {
            $('#requireExpireDate-error').html("");
        }

        function partNumberValidation() {
            $('#partNumber-error').html("");
        }

        function lowStockValidation() {
            $('#lowStock-error').html("");
        }

        function lotDescriptionFn() {
            $('#lot_description-error').html("");
        }

        function factorFn() {
            $('#factor-error').html("");
        }

        function cartoonSizeFn() {
            $('#cartoon_size-error').html("");
        }

        function skuValidation() {
            $('#skuNumber-error').html("");
        }

        function removeStatusValidation() {
            $('#activeStatus-error').html("");
        }

        function removeSknumbervalidation() {
            compareBarcodeNoFn();
            $('#skuNumber-error').html("");
        }

        function compareBarcodeNoFn(){
            var current_barcode_no = $('#skuNumber').val();
            var hidden_barcode_no = $('#skuNumberHidden').val();

            if(current_barcode_no == hidden_barcode_no){
                $("#generateBtn").hide();
                $("#barcode_div").show();
                $('#BarcodeTypes').val("Generate");
            }
            else{
                $("#generateBtn").show();
                $("#barcode_div").hide();
                $('#BarcodeTypes').val("Read");
            }
        }

        function descriptionValidation() {
            $('#description-error').html("");
        }
        // end of show items

        //Start dropdown features
        $(function() {
            $('#TypeId').change(function() {
                var id=$('#ids').val()||0;
                var skuNumberupdate=$('#skuNumberupdatehidden').val()||0;
                var barcodetype=$('#BarcodeTypes').val()||0;
                $('#type-error').html("");
                if ($(this).val() == "Goods") {
                    $('#lblretailprice').html('Retail Price');
                    $('#retailPrice').val('');
                    $('#nameDiv').show();
                    $('#codeDiv').show();
                    $('#GroupDiv').show();
                    $('#categoryDiv').show();
                    $('#uomDiv').show();
                    $('#retailerDiv').show();
                    $('#wholesellerDiv').show();
                    $('#wholesellerMinAmounDiv').show();
                    $('#taxtypeDiv').show();
                    $('#serialNumDiv').show();
                    $('#expireDateDiv').show();
                    $('#partNumDiv').show();
                    $('#lowStockDiv').show();
                    $('#skuNumberDiv').show();
                    $('#statusDiv').show();
                    $('#purchasediv').show();
                    $('#pmretail').show();
                    $('#pmretaillbl').show();
                    $('#purchasediv').removeClass('col-md-3');
                    $('#purchasediv').removeClass('col-md-0');
                    $('#itemsdiv').removeClass('col-md-9');
                    $('#itemsdiv').removeClass('col-md-12');
                    $('#purchasediv').addClass('col-md-3');
                    $('#itemsdiv').addClass('col-md-9');
                    switch (id) {
                        case 0:
                            $('#minimumstockdiv').hide();
                            $('#barcodeimagesupdate').hide();
                            break;
                        default:
                            var retailprice=$('#retailPricehidden').val()||0;
                            var wholesaleprice=$('#wholeSellerPricehidden').val()||0;
                            
                            $('#minimumstockdiv').show();
                            $('#skuNumber').val(skuNumberupdate);
                            switch (retailprice) {
                                case 0:
                                    $('#retailPrice').val('');
                                    $('#retailPricebv').val('');
                                    break;
                            
                                default:
                                    var retailPricebeforeVat = (parseFloat(retailprice) / 1.15).toFixed(2);
                                    $('#retailPrice').val(retailprice);
                                    $('#retailPricebv').val(retailPricebeforeVat);
                                    break;
                            }
                            switch (wholesaleprice) {
                                case 0:
                                    $('#wholeSellerPrice').val('');
                                    $('#wholeSellerPricebv').val('');
                                    break;
                            
                                default:
                                    var wholesalePricebeforeVat= (parseFloat(wholesaleprice) / 1.15).toFixed(2);
                                    $('#wholeSellerPrice').val(wholesaleprice);
                                    $('#wholeSellerPricebv').val(wholesalePricebeforeVat);
                                    break;
                            }
                            
                            break;
                    }
                    switch (barcodetype) {
                        case 'Read':
                            $('#printbardiv').hide();
                            $('#barcodeimagesupdate').hide();
                            break;
                        case 'Generate':
                            $('#printbardiv').show();
                            $('#barcodeimagesupdate').show();
                            break;
                        default:
                            break;
                    }
                } else if ($(this).val() == "Consumption") {
                    $('#retailPrice').val('');
                    $('#wholeSellerPrice').val('');
                    $('#retailerDiv').hide();
                    $('#wholesellerDiv').hide();
                    $('#wholesellerMinAmounDiv').hide();
                    $('#taxtypeDiv').hide();
                    $('#serialNumDiv').show();
                    $('#expireDateDiv').show();
                    $('#GroupDiv').show();
                    $('#pmretail').show();
                    $('#pmretaillbl').show();
                    $('#purchasediv').show();
                    $('#partNumDiv').show();
                    $('#lowStockDiv').show();
                    $('#skuNumberDiv').show();
                    $('#barcodeDiv').show();
                    $('#generateBtn').show();
                    $('#readBtn').show();
                    $('#closeGenBtn').hide();
                    $('#minimumstockdiv').hide();
                    $('#purchasediv').removeClass('col-md-3');
                    $('#purchasediv').removeClass('col-md-0');
                    $('#itemsdiv').removeClass('col-md-9');
                    $('#itemsdiv').removeClass('col-md-12');
                    $('#purchasediv').addClass('col-md-3');
                    $('#itemsdiv').addClass('col-md-9');
                    switch (id) {
                        case 0:
                            $('#barcodeimagesupdate').hide();
                            break;
                        default:
                            $('#skuNumber').val(skuNumberupdate);
                            break;
                    }
                    switch (barcodetype) {
                        case 'Read':
                            $('#printbardiv').hide();
                            $('#barcodeimagesupdate').hide();
                            break;
                        case 'Generate':
                            $('#printbardiv').show();
                            $('#barcodeimagesupdate').show();
                            break;
                        default:
                            break;
                    }
                } else {
                    $('#lblretailprice').html('Price');
                    $('#retailerDiv').show();
                    $('#wholesellerDiv').hide();
                    $('#purchasediv').hide();
                    $('#minimumstockdiv').hide();
                    $('#GroupDiv').hide();
                    $('#wholesellerMinAmounDiv').hide();
                    $('#serialNumDiv').hide();
                    $('#expireDateDiv').hide();
                    $('#pmretail').hide();
                    $('#pmretaillbl').hide();
                    $('#partNumDiv').hide();
                    $('#lowStockDiv').hide();
                    $('#skuNumberDiv').hide();
                    $("#ReqSerialNumber").val("Not-Require");
                    $("#ReqExpireDate").val("Not-Require");
                    $("#partNumber").val("");
                    $("#lowStock").val("");
                    $("#skuNumber").val("");
                    $('#requireSerialNumber-error').html("");
                    $('#requireExpireDate-error').html("");
                    $('#partNumber-error').html("");
                    $('#lowStock-error').html("");
                    $('#skuNumber-error').html("");
                    $('#purchasediv').removeClass('col-md-3');
                    $('#purchasediv').removeClass('col-md-0');
                    $('#itemsdiv').removeClass('col-md-9');
                    $('#itemsdiv').removeClass('col-md-12');
                    $('#purchasediv').addClass('col-md-0');
                    $('#itemsdiv').addClass('col-md-12');
                    switch (id) {
                        case 0:
                            break;
                        default:
                            var retailprice=$('#retailPricehidden').val()||0;
                            switch (retailprice) {
                                case 0:
                                    $('#retailPrice').val('');
                                    $('#retailPricebv').val('');
                                    break;
                                default:
                                    var retailPricebeforeVat = (parseFloat(retailprice) / 1.15).toFixed(2);
                                    $('#retailPrice').val(retailprice);
                                    $('#retailPricebv').val(retailPricebeforeVat);
                                    break;
                            }
                            break;
                    }
                }
            });
        });
        //End dropdown features

        //Start Close modal with clear validations
        function closebatchModalWithClearValidation(){
            $('#batchcategory-error').html('');
            $('#batchgroup-error').html('');
            $('#batchpercent-error').html('');
            $('#batchitem-error').html('');
            $('#increaseDescrease-error').html('');
            $('#batchgroup').val(null).trigger('change');
            $('#batchcategory').val(null).trigger('change');
            $('#batchitem').val(null).trigger('change');
            $('#increaseDescrease').val(null).trigger('change');
            $("#batchupdateform")[0].reset();
            $("#percent").attr({ style: "" });
        }

        function closeModalWithClearValidation() {
            $("#RegisterItem")[0].reset();
            $('#nameDiv').show();
            $('#codeDiv').show();
            $('#categoryDiv').show();
            $('#uomDiv').show();
            $('#retailerDiv').show();
            $('#wholesellerDiv').show();
            $('#wholesellerMinAmounDiv').show();
            $('#taxtypeDiv').show();
            $('#serialNumDiv').show();
            $('#expireDateDiv').show();
            $('#partNumDiv').show();
            $('#lowStockDiv').show();
            $('#skuNumberDiv').show();
            $('#statusDiv').show();
            $('#Category').val(null).trigger('change');
            $('#Uom').val(null).trigger('change');
            $('#name-error').html("");
            $('#code-error').html("");
            $('#category-error').html("");
            $('#uom-error').html("");
            $('#retailPrice-error').html("");
            $('#wholeSellerPrice-error').html("");
            $('#wholeSellerMinAmount-error').html("");
            $('#taxType-error').html("");
            $('#requireSerialNumber-error').html("");
            $('#requireExpireDate-error').html("");
            $('#partNumber-error').html("");
            $('#lowStock-error').html("");
            $('#skuNumber-error').html("");
            $('#activeStatus-error').html("");
            $('#description-error').html("");
            $('#image-error').html("");
            $('#barcodeDiv').hide();
            $('#BarcodeTypes').val("None");
            $('#closeGenBtn').hide();
            $('#generateBtn').show();
            $('#readBtn').show();
            $('#retailPricebv').val("");
            $('#wholeSellerPricebv').val("");
            $('#maxcostbv').val("");
            $('#maxcostbvlbl').html("");
            $('#maxcostlbl').html("");
            $('#averagecostlbl').html("");
            $('#averagecostbvlbl').html("");
            $('#mincostlbl').html("");
            $('#mincostbvlbl').html("");
            $("#newcodegenerate").hide();
            var itcodetype = $('#ItemCodeType').val();

            if(parseFloat(itcodetype)==1){
            }
            else{
                $('#code').prop('readonly', false);
            }
        }
        //End Close modal with clear validations

        //Start Generate barcode
        function GenerateBarcode() {
            var id = $('#ids').val()||0;
            var barcode = $('#BarcodeTypesupdate').val()||0;
            $('#skuNumber-error').html("");
            if($('#code').val().length === 0) {
                $('#code-error').html("Code is required");
                toastrMessage('error','Code is required','Error');
            } 
            else{
                if(barcode == "Read" || barcode == 0){
                    $('#BarcodeTypes').val("Generate");
                    $('#barcodeimages').show();
                    $('#barcodeimagesupdate').hide();

                    $.ajax({
                        url: '/getsknumber',
                        type: 'GET',
                        beforeSend: function() { 
                           blockPage(customPageSection,"Generating barcode...");
                        },
                        success: async function(data) {
                            await getBarcodeImageFn(data);
                        },
                        error: function () { 
                            unblockPage(customPageSection);
                        },
                    });
                }
                else{
                    $('#BarcodeTypes').val("Generate");
                    $('#barcodeimages').hide();
                    $('#barcodeimagesupdate').show();
                    var sknumber = $('#skuNumberupdate').val();
                    $('#skuNumber').val(sknumber);

                    $.ajax({
                        type: "GET",
                        url: "{{ url('getoldsknumber') }}/"+sknumber,
                        beforeSend: function() { 
                            blockPage(customPageSection,"Generating barcode...");
                        },
                        success:async function(response) {
                            await getBarcodeImageFn2(response);
                            unblockPage(customPageSection); 
                        },
                        error: function () { 
                            unblockPage(customPageSection);     
                        },
                    });

                }
                var skupdate = $("#skupdate").val();
                var barCodeCodeTxt = $("#code");
                var barCodeCodeLbl = $("#barcodeCode");
                $('#closeGenBtn').show();
                $('#generateBtn').hide();
                $('#readBtn').hide();
                barCodeCodeLbl.html(barCodeCodeTxt.val());
                $("#barcodeDiv").show();
            }
        }
        //End Generate barcode

        function getBarcodeImageFn(data){
            if(data.maxerror){
                toastrMessage('error',data.maxerror,"Error");
                unblockPage(customPageSection);  
            }
            else if(data.minierror){
                toastrMessage('error',data.minierror,"Error");
                unblockPage(customPageSection);  
            }
            else if(data.systemerror){
                toastrMessage('error',data.minierror,"Error");
                unblockPage(customPageSection);  
            }
            else if(data.success) {
                $("#skupdate").val(data.setting.skunumber);
                $("#skuNumber").val(data.setting.prefix + data.numberpaddging);
                $("#skuNumberHidden").val(data.setting.prefix + data.numberpaddging);

                $.ajax({
                    url: '/getgeneratebarcode',
                    type: 'GET',
                    beforeSend: function() { 
                        blockPage(customPageSection,"Generating barcode...");
                    },
                    success: async function(data) {
                        await getBarcodeImageFn3(data);
                        unblockPage(customPageSection); 
                    },
                    error: function () { 
                        unblockPage(customPageSection);     
                    },
                });
            }
        }

        function getBarcodeImageFn2(response){
            $("#barcodeimagesupdate").html(response.generated_barcodeimage);
        }

        function getBarcodeImageFn3(data){
            $("#barcodeimages").html(data.generated_barcodeimage);
            compareBarcodeNoFn();
            toastrMessage("info","Barcode is generated!</br>You can find in Others tab","Info");
        }

        //Start Read barcode
        function ReadBarcode() {
            $("#skuNumber").val('');
            $("#skuNumber").focus();
            $('#barcodeDiv').hide();
            $('#BarcodeTypes').val("Read");
            $('#closeGenBtn').show();
            $('#generateBtn').hide();
            $('#readBtn').hide();
        }
        //End read barcode

        //Start barcode close
        function closeBarcode() {
            $('#barcodeDiv').hide();
            $('#BarcodeTypes').val("None");
            $('#closeGenBtn').hide();
            $('#generateBtn').show();
            $('#readBtn').show();
            $("#skuNumber").val('');
        }
        //End barcode close
        function minimumstockValidation() {
            var minstock = $("#minimumstock").val()||0;
            var alablestock=$('#balance').val()||0;
            var maxvalue=parseFloat(alablestock)-parseFloat(minstock);
            maxvalue=maxvalue>0?maxvalue:0;
            $('#wholeSellerMaxAmount').val(maxvalue);
        }
        function numformat(val){
        while (/(\d+)(\d{3})/.test(val.toString())){
        val = val.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
        }
        return val;
    }
    </script>
@endsection