@extends('layout.app1')
@section('title')
@endsection
@section('content')
    <div class="app-content content">
        <section id="responsive-datatable">
            <div class="row">
                <div class="col-12">
                    <!-- Tabs with Icon starts -->
                        <div class="col-xl-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="row">
                                            <div class="col-xl-2 col-lg-12">
                                                <h4 class="card-title">Items / Service
                                                    <button type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm" onclick="refreshtbl()"><i data-feather='refresh-ccw'></i></button>
                                                </h4>
                                            </div>
                                            <div class="col-xl-3 col-lg-12">
                                                <label strong style="font-size: 12px;font-weight:bold;">Item Group</label>
                                                    <select data-column="4" class="selectpicker form-control filter-select" data-live-search="true" data-selected-text-format="count" data-actions-box="true" data-count-selected-text="Group ({0})" data-live-search-placeholder="search group" title="Select group" multiple>
                                                                <option value="Local">Local</option>
                                                                <option value="Imported">Imported</option>
                                                    </select>
                                            </div>
                                            <div class="col-xl-6 col-lg-12">
                                            </div>
                                            <div class="col-xl-1 col-lg-12">
                                                <div class="btn-group">
                                                    @can('Item-Add')
                                                    <button type="button" class="btn btn-info btn-sm waves-effect waves-float waves-light addbutton">Add</button>
                                                    @endcan
                                                    @if(auth()->user()->can('Multiple-Price-Update-Local')||auth()->user()->can('Multpile-Price-Update-Import'))
                                                        <button type="button" class="btn btn-info btn-sm dropdown-toggle dropdown-toggle-split waves-effect waves-float waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <span class="sr-only">Toggle Dropdown</span>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right" style="">
                                                            <a class="dropdown-item batchupdate">Multiple price update</a>
                                                        </div>
                                                        @endif
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
                                </div>
                                <div class="card-body">
                                    <ul class="nav nav-tabs nav-justified" id="apptabs" role="tablist">
                                        <li class="nav-item" id="allitemstab">
                                            <a class="nav-link active" id="homeIcon-tab" data-toggle="tab" href="#homeIcon" aria-controls="home" role="tab" aria-selected="true" onclick="itemslistbytab('all');"><i data-feather="home"></i> All Items</a>
                                        </li>
                                        <li class="nav-item" id="goodstab">
                                            <a class="nav-link" id="goods-tab" data-toggle="tab" href="#goods" aria-controls="goods" role="tab" aria-selected="false" onclick="itemslistbytab('allgoods');"><i data-feather="tool"></i>Goods</a>
                                        </li>
                                        <li class="nav-item" id="consumptiontab">
                                            <a class="nav-link" id="consumption-tab" data-toggle="tab" href="#consumption" aria-controls="consumption" role="tab" aria-selected="false" onclick="itemslistbytab('consumption');"><i data-feather="codepen"></i> Consumption</a>
                                        </li>
                                        <li class="nav-item" id="fixedassetab">
                                            <a class="nav-link" id="fixedAsset-tab" data-toggle="tab" href="#fixedAsset" aria-controls="fixedasset" role="tab" aria-selected="false" onclick="itemslistbytab('fixedasset');" ><i data-feather="activity"></i> Fixed Asset</a>
                                        </li>
                                        <li class="nav-item" id="servicetab">
                                            <a class="nav-link" id="service-tab" data-toggle="tab" href="#service" aria-controls="service" role="tab" aria-selected="false" onclick="itemslistbytab('service');"><i data-feather="stop-circle"></i> Service</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="homeIcon" aria-labelledby="homeIcon-tab" role="tabpanel">
                                                <div class="card-datatable" id="table-block">
                                                    @can('Item-View')
                                                    <div style="width:98%; margin-left:1%" class="tableSection">
                                                        <table id="itemdataables" class="display table-bordered table-striped table-hover dt-responsive mb-0" style="width: 100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th>id</th>
                                                                    <th>#</th>
                                                                    <th>Code</th>
                                                                    <th>Name</th>
                                                                    <th>SKU #</th>                                              
                                                                    <th>Group</th>
                                                                    <th>Category</th>
                                                                    <th>UOM</th>
                                                                    <th>RT Price</th>
                                                                    <th>WS Price</th>
                                                                    <th>WS Min Qty</th>
                                                                    <th>WS Max Qty</th>
                                                                    <th>Balance</th>
                                                                    <th>Pending</th>
                                                                    <th>Status</th>
                                                                    <th>Action</th>
                                                                    <th></th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                        </div>
                                                    @endcan
                                                </div>
                                        </div>
                                        <div class="tab-pane" id="goods" aria-labelledby="goods-tab" role="tabpanel">
                                            <div class="card-datatable" id="table-block">
                                                    @can('Item-View')
                                                    <div style="width:98%; margin-left:1%" class="tableSection">
                                                        <table id="goodsitemdataables" class="display table-bordered table-striped table-hover dt-responsive mb-0" style="width: 100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th>id</th>
                                                                    <th>#</th>
                                                                    <th>Code</th>
                                                                    <th>Name</th>
                                                                    <th>SKU #</th>                                              
                                                                    <th>Group</th>
                                                                    <th>Category</th>
                                                                    <th>UOM</th>
                                                                    <th>RT Price</th>
                                                                    <th>WS Price</th>
                                                                    <th>WS Min Qty</th>
                                                                    <th>WS Max Qty</th>
                                                                    <th>Balance</th>
                                                                    <th>Pending</th>
                                                                    <th>Status</th>
                                                                    <th>Action</th>
                                                                    <th></th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                        </div>
                                                    @endcan
                                                </div>
                                        </div>
                                        <div class="tab-pane" id="fixedAsset" aria-labelledby="fixedAsset-tab" role="tabpanel">
                                                <div class="card-datatable" id="table-block">
                                                    @can('Item-View')
                                                    <div style="width:98%; margin-left:1%" class="tableSection">
                                                        <table id="fixedassetitemdataables" class="display table-bordered table-striped table-hover dt-responsive mb-0" style="width: 100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th>id</th>
                                                                    <th>#</th>
                                                                    <th>Code</th>
                                                                    <th>Name</th>
                                                                    <th>SKU #</th>                                              
                                                                    <th>Group</th>
                                                                    <th>Category</th>
                                                                    <th>UOM</th>
                                                                    <th>RT Price</th>
                                                                    <th>WS Price</th>
                                                                    <th>WS Min Qty</th>
                                                                    <th>WS Max Qty</th>
                                                                    <th>Balance</th>
                                                                    <th>Pending</th>
                                                                    <th>Status</th>
                                                                    <th>Action</th>
                                                                    <th></th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                        </div>
                                                    @endcan
                                                </div>
                                        </div>
                                        <div class="tab-pane" id="service" aria-labelledby="service-tab" role="tabpanel">
                                            <div class="card-datatable" id="table-block">
                                                    @can('Item-View')
                                                    <div style="width:98%; margin-left:1%" class="tableSection">
                                                        <table id="serviceitemdataables" class="display table-bordered table-striped table-hover dt-responsive mb-0" style="width: 100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th>id</th>
                                                                    <th>#</th>
                                                                    <th>Code</th>
                                                                    <th>Name</th>
                                                                    <th>SKU #</th>                                              
                                                                    <th>Group</th>
                                                                    <th>Category</th>
                                                                    <th>UOM</th>
                                                                    <th>RT Price</th>
                                                                    <th>WS Price</th>
                                                                    <th>WS Min Qty</th>
                                                                    <th>WS Max Qty</th>
                                                                    <th>Balance</th>
                                                                    <th>Pending</th>
                                                                    <th>Status</th>
                                                                    <th>Action</th>
                                                                    <th></th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                        </div>
                                                    @endcan
                                                </div>
                                        </div>
                                        <div class="tab-pane" id="consumption" aria-labelledby="consumption-tab" role="tabpanel">
                                            <div class="card-datatable" id="table-block">
                                                    @can('Item-View')
                                                    <div style="width:98%; margin-left:1%" class="tableSection">
                                                        <table id="consumptionitemdataables" class="display table-bordered table-striped table-hover dt-responsive mb-0" style="width: 100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th>id</th>
                                                                    <th>#</th>
                                                                    <th>Code</th>
                                                                    <th>Name</th>
                                                                    <th>SKU #</th>                                              
                                                                    <th>Group</th>
                                                                    <th>Category</th>
                                                                    <th>UOM</th>
                                                                    <th>RT Price</th>
                                                                    <th>WS Price</th>
                                                                    <th>WS Min Qty</th>
                                                                    <th>WS Max Qty</th>
                                                                    <th>Balance</th>
                                                                    <th>Pending</th>
                                                                    <th>Status</th>
                                                                    <th>Action</th>
                                                                    <th></th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                        </div>
                                                    @endcan
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </section>
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
                                                <div class="demo-inline-spacing pl-1">
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
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-1" id="product_code_div">
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

                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-1">
                                                        <label class="form_lbl">Product Name<b style="color: red; font-size:16px;">*</b></label>
                                                        <input type="text" name="name" id="name" placeholder="Enter product name here" class="form-control mainforminp" onkeyup="removeNameValidation()"/>
                                                        <span class="text-danger">
                                                            <strong id="name-error" class="errordatalabel general_error"></strong>
                                                        </span>
                                                    </div>

                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-1 non_service_div" id="skuNumberDiv">
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

                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-1" id="uomDiv">
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

                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-1" id="categoryDiv">
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
                                                                <input type="checkbox" class="custom-control-input item_type non_service_checkbox" id="item_type{{$itemtype_data->id}}" name="item_type_name[]" value="{{$itemtype_data->id}}"/>
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
                                            <div class="col-xl-2 col-lg-4 col-md-4 col-sm-12 col-12 mb-1 non_service_div" id="partNumDiv">
                                                <label class="form_lbl" title="Unique identifier assigned to this product for tracking and reference.">Part No.</label>
                                                <input type="text" placeholder="Enter part number here" class="form-control mainforminp non_service_input" name="partNumber" id="partNumber" onkeypress="partNumberValidation()"/>
                                                <span class="text-danger">
                                                    <strong id="partNumber-error" class="errordatalabel basic_error non_service_error"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-2 col-lg-4 col-md-4 col-sm-12 col-12 mb-1 non_service_div" id="lowStockDiv">
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
                                                <input type="number" placeholder="Enter factor here" class="form-control mainforminp non_service_input" name="factor" id="factor" onkeyup="calculateCostsWithFactor()" onkeypress="return ValidateFactorNum(event,this);" />
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
                                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-12 col-12 mb-1 non_service_div" id="serialNumDiv">
                                                <label class="form_lbl" title="Is Serial Number Requires">Is Serial No. Req.</label>
                                                <select class="select2 form-control" name="ReqSerialNumber" id="ReqSerialNumber" onchange="reqSerialNumValidation()">
                                                    <option value="Not-Require">Not-Require</option>
                                                    <option value="Required">Requires</option>
                                                </select>
                                                <span class="text-danger">
                                                    <strong id="requireSerialNumber-error" class="errordatalabel inventory_error non_service_error"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-12 col-12 mb-1 non_service_div" id="expireDateDiv">
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
                                            <div class="col-xl-2 col-lg-4 col-md-4 col-sm-12 col-12 mb-1 non_service_div">
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
                                                    <span class="text-danger">
                                                        <strong id="group-error"></strong>
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
                                                                            <th class="form_lbl" style="width:25%;">Supplier Name<b style="color:red;">*</b></th>
                                                                            <th class="form_lbl" style="width:10%;">UOM<b style="color:red;">*</b></th>
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
                                                                            <strong id="min_selling_price_bt_error" class="errordatalabel sales_error flexible_error"></strong>
                                                                        </span>
                                                                    </div>
                                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                        <label class="form_lbl">After Tax<b style="color: red; font-size:16px;">*</b></label>
                                                                        <input type="number" name="MinSellingPriceAfterTax" id="MinSellingPriceAfterTax" step="any" placeholder="Enter min price (after tax) here" class="form-control mainforminp flexible_input" onkeyup="minSellingPriceAfterTaxFn()" onkeypress="return ValidateNum(event);" onblur="minVerifyPriceAfterTaxFn()"/>
                                                                        <span class="text-danger">
                                                                            <strong id="min_selling_price_at_error" class="errordatalabel sales_error flexible_error"></strong>
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
                                                                            <strong id="selling_price_bt_error" class="errordatalabel sales_error"></strong>
                                                                        </span>
                                                                    </div>
                                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                        <label class="form_lbl">After Tax<b style="color: red; font-size:16px;">*</b></label>
                                                                        <input type="number" name="SellingPriceAfterTax" id="SellingPriceAfterTax" step="any" placeholder="Enter default price (after tax) here" class="form-control mainforminp" onkeyup="sellingPriceAfterTaxFn()" onkeypress="return ValidateNum(event);" onblur="defaultVerifyPriceAfterTaxFn()"/>
                                                                        <span class="text-danger">
                                                                            <strong id="selling_price_at_error" class="errordatalabel sales_error"></strong>
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
                                                                            <strong id="max_selling_price_bt_error" class="errordatalabel sales_error flexible_error"></strong>
                                                                        </span>
                                                                    </div>
                                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                        <label class="form_lbl">After Tax<b style="color: red; font-size:16px;">*</b></label>
                                                                        <input type="number" name="MaxSellingPriceAfterTax" id="MaxSellingPriceAfterTax" step="any" placeholder="Enter max price (after tax) here" class="form-control mainforminp flexible_input" onkeyup="maxSellingPriceAfterTaxFn()" onkeypress="return ValidateNum(event);" onblur="maxVerifyPriceAfterTaxFn()"/>
                                                                        <span class="text-danger">
                                                                            <strong id="max_selling_price_at_error" class="errordatalabel sales_error flexible_error"></strong>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </fieldset>
                                                        </div>

                                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12 mb-1 non_service_div" style="text-align: right;">
                                                            <table style="width: 100%;font-size:12px;" class="rtable text-center">
                                                                <tr>
                                                                    <td colspan="3">
                                                                        <label class="info_lbl" style="font-weight: bold;">Product Purchase Cost</label>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label class="info_lbl" style="font-weight: bold;">Cost</label></td>
                                                                    <td><label class="info_lbl" style="font-weight: bold;">Before Tax</label></td>
                                                                    <td><label class="info_lbl" style="font-weight: bold;">After Tax</label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td title="Minimum Cost"><label class="info_lbl">Min. Cost</label></td>
                                                                    <td><label class="info_lbl" id="mincostbvlbl"></label></td>
                                                                    <td><label class="info_lbl" id="mincostlbl"></label></td>
                                                                </tr>
                                                                <tr id="averagecostabletr">
                                                                    <td title="Average Cost"><label class="info_lbl">Avg. Cost</label></td>
                                                                    <td><label class="info_lbl" id="averagecostbvlbl"></label></td>
                                                                    <td><label class="info_lbl" id="averagecostlbl"></label></td>
                                                                </tr>
                                                                <tr id="maxcostabletr">
                                                                    <td title="Maximum Cost"><label class="info_lbl">Max. Cost</label></td>
                                                                    <td><label class="info_lbl" id="maxcostbvlbl"></label></td>
                                                                    <td><label class="info_lbl" id="maxcostlbl"></label></td>
                                                                </tr>
                                                            </table>
                                                            
                                                        </div>

                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-xl-3 col-lg-9 col-md-9 col-sm-9 col-12 mb-1">
                                                <label class="form_lbl">Compatible Products</label>
                                                <select class="select2 form-control" name="CompatibleProducts" id="CompatibleProducts" multiple onchange="compatibleProductFn()">

                                                </select>
                                                <span class="text-danger">
                                                    <strong id="compatible_products-error" class="errordatalabel sales_error"></strong>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane item-views tab-view" id="item-others-view" aria-labelledby="item-others-view" role="tabpanel">
                                        <div class="row mr-1 ml-1 mt-1">
                                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-12 col-12 mb-1 non_service_div" id="barcode_div">
                                                <label class="form_lbl">Barcode</label>
                                                <div id="barcodeDiv">
                                                    <div class="text-center">
                                                        <b><label id="barcodeCode"></label></b>
                                                    </div>
                                                    <div id="barcodeimages" class="text-center" style="display: none;"></div>
                                                    <div id="barcodeimagesupdate" class="text-center" style="display: none;"></div>
                                                    <div class="custom-control custom-control-primary custom-checkbox mt-1" id="printbardiv">
                                                        <input type="checkbox" class="custom-control-input item_group_class non_service_checkbox" id="printBar" name="printBar"/>
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
                                            <input type="hidden" placeholder="Item ID" class="form-control" name="id" id="ids" />
                                            <input type="hidden" class="form-control" name="notifiablemaxcostid" id="notifiablemaxcostid" />
                                            <input type="hidden" class="form-control" name="notifiablereailerpriceid" id="notifiablereailerpriceid" />
                                            <input type="hidden" class="form-control" name="notifiablewholesellerpriceid" id="notifiablewholesellerpriceid" />
                                            
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
                        
                            <input type="hidden" class="form-control" name="codeHidden" id="codeHidden" value="" />
                            <input type="hidden" class="form-control" name="skuNumberHidden" id="skuNumberHidden" value="" />
                            <input type="hidden" class="form-control" name="BarcodeTypes" id="BarcodeTypes" value="None" />
                            <input type="hidden" class="form-control mainforminp" name="BarcodeTypesupdate" id="BarcodeTypesupdate" value="None" />
                            <input type="hidden" class="form-control" name="skgenerate" id="skgenerate" />
                            <input type="hidden" class="form-control" name="lastbarcode" id="lastbarcode" value="" />
                            <input type="hidden" class="form-control" name="barcoderequire" id="barcoderequire" value="{{ $setings->BarcodeRequire }}" readonly/>
                            <input type="hidden" placeholder="max cost" class="form-control" name="maxcosti" id="maxcosti" />
                            <input type="hidden" class="form-control" name="pmwholesalehidden" id="pmwholesalehidden" readonly/>
                            <input type="hidden" class="form-control" name="pmretailhidden" id="pmretailhidden" readonly/>
                            <input type="hidden" class="form-control" name="retailPricehidden" id="retailPricehidden" readonly/>
                            <input type="hidden" class="form-control" name="wholeSellerPricehidden" id="wholeSellerPricehidden" readonly/>
                        </div>
                        <button type="button" id="savebutton" class="btn btn-info waves-effect waves-float waves-light">Save</button>
                        <button id="closebuttonitem" type="button" class="btn btn-danger" onclick="closeModalWithClearValidation()" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- end of item Register --}}

    <div class="modal fade" id="docInfoModal" tabindex="-1" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" data-backdrop="static" style="display: none;">
    <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalScrollableTitle">Item information</h5>
                <div class="row">
                    <div style="text-align: right;" id="dividertext"></div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="refreshtbl1()">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
            </div>
            <div class="modal-body">
                <form id="holdInfo">
                @csrf
                    <div class="col-xl-12">
                            <div class="row">
                                <div class="col-xl-4 col-lg-12" id="iteminfo">
                                    <div class="card" style="height: 55rem;">
                                        <div class="card-header">
                                            <h6 class="card-title">Item Info</h6>
                                        </div>
                                        <div class="card-body" id="itemInfoCardDiv">
                                            <table class="table-responsive">
                                                <tr>
                                                    <td><label strong style="font-size: 12px;">Item Code: </label></td>
                                                    <td><b><label id="itemcodeInfoLbl" strong style="font-size: 12px;"></label></b></td>
                                                </tr>
                                                <tr>
                                                    <td><label strong style="font-size: 12px;">Item Type: </label></td>
                                                    <td><b><label id="itemtypeInfoLbl" strong style="font-size: 12px;"></label></b></td>
                                                </tr>
                                                <tr>
                                                    <td><label strong style="font-size: 12px;">Item Group: </label></td>
                                                    <td><b><label id="itemgroupInfoLbl" strong style="font-size: 12px;"></label></b></td>
                                                </tr>
                                                <tr>
                                                    <td><label strong style="font-size: 12px;">Item Name: </label></td>
                                                    <td><b><label id="itemInfoLbl" strong style="font-size: 12px;"></label></b></td>
                                                </tr>
                                                <tr>
                                                    <td><label strong style="font-size: 12px;">UOM: </label></td>
                                                    <td><b><label id="uomInfoLbl" strong style="font-size: 12px;"></label></b></td>
                                                </tr>
                                                <tr>
                                                    <td><label strong style="font-size: 12px;">Category: </label></td>
                                                    <td><b><label id="itemCategoryInfoLbl" strong style="font-size: 12px;"></label></b></td>
                                                </tr>
                                                <tr>
                                                    <td><label strong style="font-size: 12px;">Tax: </label></td>
                                                    <td><b><label id="taxInfoLbl" strong style="font-size: 12px;"></label></b></td>
                                                </tr>
                                                <tr>
                                                    <td><label strong style="font-size: 12px;">Barcode(SKU#): </label></td>
                                                    <td><b><label id="skuInfoLbl" strong style="font-size: 12px;"></label></b></td>
                                                </tr>
                                                <tr>
                                                    <td><label strong style="font-size: 12px;">Reorder Value: </label></td>
                                                    <td><b><label id="reorderInfoLbl" strong style="font-size: 12px;"></label></b></td>
                                                </tr>
                                                <tr>
                                                    <td><label strong style="font-size: 12px;">Part Number: </label></td>
                                                    <td><b><label id="partnumberInfoLbl" strong style="font-size: 12px;"></label></b></td>
                                                </tr>
                                                
                                                 <tr>
                                                    <td><label strong style="font-size: 12px;">Factor: </label></td>
                                                    <td><b><label id="factorInfoLbl" strong style="font-size: 12px;"></label></b></td>
                                                </tr>
                                            </table>
                                            <div class="divider divider-info">
                                                <div class="divider-text">Item Description</div>
                                            </div>
                                            <div style="overflow-y:scroll;height:20rem;">
                                                <label id="imagedescription" style="font-size: 12px;"></label>
                                            </div>
                                            <div class="row" style="color:white;">-</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-12" id="barcodeimage">
                                    <div class="card" style="height:55rem;">
                                        <div class="card-body" id="priceInfoCardDiv">
                                            <div class="table-responsive" style="height:20rem;">
                                                <table style="width: 100%;" class="table table-bordered table-sm">
                                                <tr class="table-default">
                                                    <td colspan="4" style="text-align: center;"><b>Selling Price</b></td>
                                                </tr>
                                                <tr class="table-secondary">
                                                    <td style="width: 30%"><b>Price</b></td>
                                                    <td style="width: 30%"><b>Before VAT</b></td>
                                                    <td style="width: 30%"><b>After VAT</b></td>
                                                    <td style="width: 10%"><b>PM %</b></td>
                                                </tr>
                                                    <tr>
                                                        <td>Reatil</td>
                                                        <td><b><label id="rpInfoLblbv" strong style="font-size: 12px;"></label></b></td>
                                                        <td><b><label id="rpInfoLblav" strong style="font-size: 12px;"></label></b></td>
                                                        <td><b><label id="rppmInfoLbl" strong style="font-size: 12px;"></label></b></td>
                                                    </tr>
                                                    <tr  class="table-default">
                                                        <td>Wholesale</td>
                                                        <td><b><label id="wsInfoLblbv" strong style="font-size: 12px;"></label></b></td>
                                                        <td><b><label id="wsInfoLblav" strong style="font-size: 12px;"></label></b></td>
                                                        <td><b><label id="wspmInfoLbl" strong style="font-size: 12px;"></label></b></td>
                                                    </tr>
                                            </table>
                                            <table class="table-responsive" id="costables">
                                                @if($setings->wholesalefeature==1)
                                                    
                                                        <tr>
                                                            <td><label strong style="font-size: 12px;">Wholesale Min Qty:</label></td>
                                                            <td><b><label id="wsminInfoLbl" strong style="font-size: 12px;"></label></b></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label strong style="font-size: 12px;">Wholesale Max Qty:</label></td>
                                                            <td><b><label id="wsmaxInfoLbl" strong style="font-size: 12px;"></label></b></td>
                                                        </tr>
                                                    
                                                @endif
                                            </table>
                                            </div>
                                            <div class="divider divider-info">
                                                <div class="divider-text">Barcode(SKU#)</div>
                                            </div>
                                            <div id="barcodeinfo" class="text-center" style="height:25rem;">
                                                <b><label id="barcodeinfocode"></label></b>
                                                <div id="barcodeinfoimages">
                                                </div>
                                                <b><label id="barcodeskuNumber"></label></b>
                                                <input type="hidden" name="printid" id="printid" />
                                                <button id="printbutton" type="button" class="btn btn-info">Print</button>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-12" id="productimage">
                                    <div class="card" style="height: 55rem;">
                                        <div class="card-body" id="itemInfoCardDiv">
                                            <div class="table-responsive" style="height:20rem;">
                                            <table style="width: 100%;" class="table table-bordered table-sm">
                                                    <tr class="table-default">
                                                        <td colspan="3" style="text-align: center;"><b>Product-Purchase Cost</b></td>
                                                    </tr>
                                                    <tr class="table-secondary">
                                                        <td style="width: 29%"><b>Cost</b></td>
                                                        <td style="width: 36%"><b>Before VAT</b></td>
                                                        <td style="width: 35%"><b>After VAT</b></td>
                                                    </tr>
                                                        <tr>
                                                            <td>Min</td>
                                                            <td><b><label id="mincostInfoLblbv" strong style="font-size: 12px;"></label></b></td>
                                                            <td><b><label id="mincostInfoLblav" strong style="font-size: 12px;"></label></b></td>
                                                        </tr>
                                                        <tr id="averagecosttr" class=''>
                                                            <td>Avg</td>
                                                            <td><b><label id="averageInfoLblbv" strong style="font-size: 12px;"></label></b></td>
                                                            <td><b><label id="averageInfoLblav" strong style="font-size: 12px;"></label></b></td>
                                                        </tr>
                                                        <tr id="maxcosttr" class=''>
                                                            <td>Max</td>
                                                            <td><b><label id="maxcostInfoLblbv" strong style="font-size: 12px;"></label></b></td>
                                                            <td><b><label id="maxcostInfoLblav" strong style="font-size: 12px;"></label></b></td>
                                                        </tr>
                                                </table>
                                            </div>
                                            <div class="divider divider-info">
                                                <div class="divider-text">Item Images</div>
                                            </div>
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12 main">
                                                        <div id="carouselExampleFade"></div>
                                                        <div id="img-container">
                                                            <img id=featured src="" width="500px;" height="300px;">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-sm-12 scroll scrdiv">
                                                        <div class="card">
                                                            <div class="card-body ">
                                                                <div class="row sideImage" >
                                                                
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
    </form>   
    </div>
        <div class="modal-footer">
            <div class="col-xl-12 col-lg-12">
                    <div class="row">
                            <div class="col-xl-10 col-lg-12">
                                <input type="hidden" class="form-control" name="itemtype" id="itemtype" readonly="true">
                                <input type="hidden" class="form-control" name="wholesalemax" id="wholesalemax" readonly="true">
                                <input type="hidden" class="form-control" name="pendingdata" id="pendingdata" readonly="true">
                                <button type="button" id="itemeditbutton" class="btn btn-outline-dark"><i class="fa-sharp fa-solid fa-pen"></i>Edit</button>
                                @can("Item-Delete")
                                <button type="button" id="itemdeletebutton" class="btn btn-outline-danger"><i class="fa-solid fa-trash-xmark"></i>Delete</button>
                                @endcan
                                <button type="button" id="imageuploadbutton" class="btn btn-outline-dark"><i class="fa-regular fa-cloud-arrow-up"></i>Image Upload</button>
                            </div>        
                            
                            <div class="col-xl-2 col-lg-12" style="text-align:right;">
                                <button id="closebutton" type="button" class="btn btn-relief-danger" data-dismiss="modal" onclick="refreshtbl1()">Close</button>
                            </div> 
                        </div>
                    </div>
        </div>
    </div>
    </div>
</div>
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

    <script type="text/javascript">
        var gblIndex = 0;
        var itemtable = '';
        var focustables = '';
        var errorcolor = "#ffcccc";
        var j = 0;
        var i = 0;
        var m = 0;
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

        function refreshtbl(){
            var tabletr = $(focustables).DataTable(); 
            tabletr.search('');
            var oTable = $(focustables).dataTable(); 
            oTable.fnDraw(false);
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

        $(document).ready(function() {
            $("#newcodegenerate").hide();
            $("#barcodeDiv").hide();
            $("#imagepreview").hide();
            var weight = window.innerHeight;

            $(".selectpicker").selectpicker({
                noneSelectedText: ''
            });
            focustables='#itemdataables';
            itemdatalist('#itemdataables','All');
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

        function itemdatalist(tables,type){
                itemtable=$(tables).DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                deferRender:true,
                destroy:true,
                searchHighlight: true,
                scrollY:'60vh',
                scrollX: true,
                scrollCollapse: true,
                "pagingType": "simple",
                "lengthMenu": [[50, 100], [50, 100]],
                language: {
                    search: '',
                    searchPlaceholder: "Search here",
                },
                    "dom": "<'row'<'col-lg-10 col-md-10 col-xs-1'f><'col-lg-2 col-md-2 col-xs-8'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-5'><'col-sm-12 col-md-2'p>>",
                    "order": [[0, "desc"]],
                    ajax: {
                        url: "{{ url('itemdata') }}/"+type,
                        type: 'DELETE',
                        beforeSend: function () {
                            tableSection.block({
                                message:
                                '<div class="d-flex justify-content-center align-items-center"><p class="mr-50 mb-50">Loading Please wait...</p><div class="spinner-grow spinner-grow-sm text-white" role="status"></div> </div>',
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
                        tableSection.block({
                            message:'',
                                timeout: 1,
                                css: {
                                backgroundColor: '',
                                color: '',
                                border: ''
                                },
                    });
                    setFocus();
                    },
                    },
                    
                columns: [
                    {data:'id',visible:false},
                    { data:'DT_RowIndex'   },
                    {data: 'Code',  name: 'Code' },
                    {data: 'Name',   name: 'Name' },
                    {data: 'SKUNumber', name: 'SKUNumber'},
                    {data: 'itemGroup',   name: 'itemGroup'},
                    {data: 'Category',   name: 'Category'},
                    {data: 'UOM',name: 'UOM' },
                    {data: 'RetailerPrice',  name: 'RetailerPrice'},
                    {data: 'WholesellerPrice', name: 'WholesellerPrice'},
                    {data: 'wholeSellerMinAmount', name: 'wholeSellerMinAmount' },
                    {data: 'MinimumStock', name: 'MinimumStock'},
                    {data: 'Balance', name: 'Balance', 'visible': false},
                    {data: 'PendingQuantity',name: 'PendingQuantity','visible': false},
                    {data: 'ActiveStatus',name: 'ActiveStatus' },
                    {data: 'id', name: 'id'},
                    {data: 'MaxCost',name: 'MaxCost','visible': false},
                    {data: 'averageCost',name: 'averageCost','visible': false}
                ],
                
                columnDefs: [
                        {
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
                    targets: 14,
                    render: function ( data, type, row, meta ) {
                        if(data=="Active"){
                        var x="<span style='color:#4CAF50;font-weight:bold;text-shadow:1px 1px 10px #4CAF50'>"+data+ "</span>"
                            return x;
                            
                        }
                        else{
                            var y="<span style='color:#f44336;font-weight:bold;text-shadow:1px 1px 10px #f44336'>"+data+ "</span>"
                            return y;
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
                                anchor='<a class="showItem" href="javascript:void(0)"  data-id="'+data+'" data-category="'+row.Category+'" data-uom="'+row.UOM+'" data-max="'+maxreturn+'" data-pending="'+pendingquantity+'" data-balance="'+balance+'" data-minstock="'+minimumstock+'" data-minamount="'+minamount+'" data-maxicost="'+maxcost+'" data-averagecost="'+averagcostcost+'" title="view items"><i class="fa-sharp fa-regular fa-circle-info fa-xl" style="color: #00cfe8;"></i></a>';
                            return anchor;
                    }
                },
                ],
                });
                $(focustables+' tbody').on('click', 'tr', function () {
                    $(focustables+' tbody > tr').removeClass('selected');
                    $(this).addClass('selected');
                    gblIndex = $(this).index();    
                });
        }

        function setFocus(){ 
            $($(focustables+' tbody > tr')[gblIndex]).addClass('selected');  
        }

        function showitemInformation(itemid,uom,category,maxicost,averagecost){
            var localpriceupdate=$('#localitempriceupdate').val();
            var importpriceupdate=$('#importitempriceupdate').val();
            var costtype=$('#costtype').val();
            var maximumqty=0;
            $('.sideImage').html('');
            $('#carouselExampleFade').html('');
            $.ajax({
                    type: "GET",
                    url: "{{ url('showitem') }}/"+itemid,
                    beforeSend: function () {
                        pageSection.block({
                                message:
                                '<div class="d-flex justify-content-center align-items-center"><p class="mr-50 mb-50">Loading Please wait...</p><div class="spinner-grow spinner-grow-sm text-white" role="status"></div></div>',
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
                            message:'',
                                timeout: 1,
                                css: {
                                backgroundColor: '',
                                color: '',
                                border: ''
                                },
                            
                    });
                    $('#docInfoModal').modal('show');
                    },
                    success: function (response) {
                        $.each(response.item, function (index, value) { 
                            $('#ids').val(value.id);
                            $('#itemtypeInfoLbl').text(value.Type);
                            $('#itemgroupInfoLbl').text(value.itemGroup);
                            $('#itemtype').val(value.itemGroup);
                            $('#itemInfoLbl').text(value.Name);
                            $('#itemcodeInfoLbl').text(value.Code);
                            $('#itemCategoryInfoLbl').text(category);
                            $('#uomInfoLbl').text(uom);
                            $('#taxInfoLbl').text(value.TaxTypeId);
                            $('#partnumberInfoLbl').text(value.PartNumber);
                            $('#factorInfoLbl').text(value.standard_factor);
                            
                            $('#reorderInfoLbl').text(value.LowStock);
                            $('#skuInfoLbl').text(value.SKUNumber);
                            $('#barcodeinfocode').text(value.Code);
                            var itemdescription = value.Description;
                            var img='<img class="card-img-top" src="'+value.imageName+'" alt="barcode not found"  />';
                            $("#barcodeinfoimages").html(img);
                            $('#imagedescription').html(itemdescription);
                            var bt = value.BarcodeType;
                            var itemgrioup = value.itemGroup;
                            var retailprice=value.RetailerPrice>0?value.RetailerPrice:'';
                            var wholesaleprice=value.WholesellerPrice>0?value.WholesellerPrice:'';
                            var wholesaleminamount=value.wholeSellerMinAmount>0?value.wholeSellerMinAmount:'';
                            var maxcost=value.MaxCost>0?value.MaxCost:'';
                            var avgcost=value.averageCost>0?value.averageCost:'';
                            var mincost=value.minCost>0?value.minCost:'';
                            var pendingqty=value.PendingQuantity||0;
                            var balance=value.AvailableQuantity||0;
                            var minstock=value.MinimumStock;
                            var rpm=value.pmretail;
                            var wspm=value.pmwholesale;
                            var retailpricebv=parseFloat(retailprice/1.15).toFixed(2);
                            var wholesalepricebv=parseFloat(wholesaleprice/1.15).toFixed(2);
                            var maxcostbv=parseFloat(maxcost/1.15).toFixed(2);
                            var avgcostbv=parseFloat(avgcost/1.15).toFixed(2);
                            var mincostbv=parseFloat(mincost/1.15).toFixed(2);
                            retailpricebv=retailpricebv>0?retailpricebv:'';
                            wholesalepricebv=wholesalepricebv>0?wholesalepricebv:'';
                            maxcostbv=maxcostbv>0?maxcostbv:'';
                            avgcostbv=avgcostbv>0?avgcostbv:'';
                            mincostbv=mincostbv>0?mincostbv:'';
                            maximumqty=parseFloat(value.AvailableQuantity)-parseFloat(value.PendingQuantity)-parseFloat(value.MinimumStock);
                            $('#wholesalemax').val(maximumqty);
                            $('#pendingdata').val(value.PendingQuantity);
                            setItemPrice(retailprice,wholesaleprice,retailpricebv,wholesalepricebv,maximumqty,pendingqty,minstock,balance,wholesaleminamount,maxcost);
                            if (itemgrioup == "Local") {
                                
                                var localitemstoreminquantity=$('#localitemstoreminquantity').val();
                                var localcostpermission=$('#localcost').val();
                                var localitemeditpermission=$('#localitemeditpermission').val();
                                $('#printbutton').show();
                                switch (localitemstoreminquantity) {
                                    case '1':
                                        $('#costables').show();
                                        break;
                                    
                                    default:
                                        $('#costables').hide();
                                        break;
                                }
                                switch (localitemeditpermission) {
                                    case '1':
                                        $('#itemeditbutton').show();
                                        break;
                                
                                    default:
                                        $('#itemeditbutton').hide();
                                        break;
                                }
                                switch (localcostpermission) {
                                    case '1':
                                        setPriceInformation(mincostbv,mincost,avgcostbv,avgcost,maxcostbv,maxcost,rpm,wspm,retailprice,wholesaleprice);
                                        removeColorAccessDeniedinformation();
                                        switch (costtype) {
                                            case '1':
                                                if(parseFloat(avgcost)>0){
                                                    setAverageCostColor();
                                                } else{
                                                    removeAverageCostColor();
                                                }
                                                
                                                break;
                                            case '0':
                                                if(parseFloat(maxcost)>0){
                                                    setMaxCostColor();
                                                } else{
                                                    removeMaxCostColor();
                                                }
                                                
                                            break;
                                            default:
                                                break;
                                        }
                                        break;                                
                                    default:
                                        setAccessDeniedinformation();
                                        removeAverageCostColor();
                                        removeMaxCostColor();
                                        break;
                                }
                            }
                            if (itemgrioup == "Imported") {
                                var importcostpermission=$('#importcost').val();
                                var importitemeditpermission=$('#importitemeditpermission').val();
                                var importitemstoreminquantity=$('#importitemstoreminquantity').val();
                                $('#printbutton').show();
                                switch (importitemstoreminquantity) {
                                    case '1':
                                        $('#costables').show();
                                        break;
                                    default:
                                        $('#costables').hide();
                                        break;
                                }
                                switch (importitemeditpermission) {
                                    case '1':
                                        $('#itemeditbutton').show();
                                        break;
                                    default: 
                                    $('#itemeditbutton').hide();
                                        break;
                                }
                                switch (importcostpermission) {
                                    case '1':
                                        setPriceInformation(mincostbv,mincost,avgcostbv,avgcost,maxcostbv,maxcost,rpm,wspm,retailprice,wholesaleprice);
                                        removeColorAccessDeniedinformation();
                                        switch (costtype) {
                                            case '1':
                                                if(parseFloat(avgcost)>0){
                                                    setAverageCostColor();
                                                    } else{
                                                        removeAverageCostColor();
                                                    }
                                                
                                                break;
                                            case '0':
                                                if(parseFloat(maxcost)>0){
                                                    setMaxCostColor();
                                                } else{
                                                    removeMaxCostColor();
                                                }
                                            break;
                                            default:
                                                break;
                                        }
                                        break;
                                    default:
                                        setAccessDeniedinformation();
                                        removeAverageCostColor();
                                        removeMaxCostColor();
                                        break;
                                }
                            }
                            if (bt == "Generate") {
                                $('#barcodeDiv').show();
                            } else {
                                $('#barcodeDiv').hide();
                            }
                        });
                        // show ite images
                        switch (response.success) {
                            case 1:
                                    $('#img-container').show();
                                    setitemimages(response.itemimage);
                                break;
                            default:
                                shownoimages();
                                $('#img-container').hide();
                                break;
                        }
                    }
                });
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
            `<section id="alerts-closable"><div class="row">
                        <div class="col-md-12">
                        <div class="card">
                                    <div class="card-body">
                                        <p class="card-text">
                                            </p>
                                                <div class="demo-spacing-0">
                                                <div class="alert alert-info alert-dismissible fade show" role="alert">
                                                    <div class="alert-body">
                                                        There is no image to show related to this item.
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
            $.get("getitemcodes",function (data, textStatus, jqXHR) {
                $.each(data.setings, function (index, value) {
                    itcodetype = value.ItemCodeType;
                });

                if(parseInt(itcodetype) == 1){
                    $('#code').val(data.docNumber);
                }
            });
            $("#generate_item_code").hide();
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
        
        $('body').on('click', '.addbutton', function() {

            resetItemFormFn();
            managePriceFn();
            manageProductCodeFn();

            $("#item_form_title").html('Add Product');
            $('#savebutton').text('Save');
            $('#savebutton').prop("disabled",false);
            $("#addItemForm").modal('show');

            // var itcodetype=null;
            // var wholesalefeature=null;
            
            // var importcostpermission=$('#importcost').val();
            // var localcostpermission=$('#localcost').val();
            // removeAverageCostColor();
            // removeMaxCostColor();
            // $('#myModalLabel333').html("Add Item");
            // var type=$('#TypeId').val();
            // $('#pmretail').prop('readonly', true);
            // $('#pmwholesale').prop('readonly', true);
            // $('#purchasediv').removeClass('col-md-3');
            // $('#purchasediv').removeClass('col-md-0');
            // $('#itemsdiv').removeClass('col-md-9');
            // $('#itemsdiv').removeClass('col-md-12');
            // $('#purchasediv').addClass('col-md-3');
            // $('#itemsdiv').addClass('col-md-9');
            // $('#purchasediv').show();
            // $('#minimumstockdiv').hide();
            // $('#pmretail').show();
            // $('#pmretaillbl').show();

            

            // $.get("getitemcodes",function (data, textStatus, jqXHR) {
            //     $.each(data.setings, function (index, value) {
            //         itcodetype=value.ItemCodeType;
            //         $('#itmcodetype').val(itcodetype);
            //     });
            //     if(parseFloat(itcodetype)==1){
            //         $('#code').val(data.docNumber);
            //     }
            //     else{
            //         $('#code').prop('readonly', false);
            //     }
            // });
               

            // $('#ids').val('');
            // $('#BarcodeTypesupdate').val('');
            // $('#notifiablemaxcostid').val('');
            // $('#notifiablereailerpriceid').val('');
            // $('#notifiablewholesellerpriceid').val('');
            // $("#RegisterItem")[0].reset();
            // $('#lblretailprice').html('Retail Price');
            // $("#addItemForm").modal('show');
            // $("#savebutton").show();
            // $('#closeGenBtn').hide();
            // $("#itemupdatebutton").hide();
            // $('#barcodeNumberss').show();
            // $('#barcodeNumber').hide();
            // $("#imageloads").hide();
            // $("#barcodeDiv").hide();
            // $("#imageresetbutton").hide();
            // $("#wholeSellerMinAmount").prop("readonly", true);
            // $('#skuNumber').val('');
            // $("#checkboxVali").val('0');
            // $('#igroup').select2('destroy');
            // $('#igroup').val('').select2();
            // $('#status').empty();
            // $('#status').append('<option value="Active">Active</option><option value="Inactive">Inactive</option>');
            // $('#status').select2();
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
            $('input[name="item_type_name"]').prop('checked', false);

            $('input[name="price_type"]').prop('checked', false);
            $('input[id="price_type1"]').prop('checked', true);

            manageProductClassFn();
            managePricingFn();
            itemTabMgtFn();

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
            $('#generate_item_code').hide();
        }

        function getItemCodeFn(data){
            $("#code").val(data.docNumber);
            $("#codeHidden").val(data.docNumber);
        }

        function generateItemCodeFn(){
            blockPage(productCodeSection,"Generating code...");
            var code_hidden = $("#codeHidden").val();
            $("#code").val(code_hidden);
            $('#generate_item_code').hide();
            unblockPage(productCodeSection);
        }

        $('input[name="product_class"]').on('change', function() {
            var prd_class = $(this).val();
            manageProductClassFn();
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
        
        function itemTabMgtFn(){
            $(".tab-title").removeClass("active");
            $(".tab-view").removeClass("active");
            
            $(".active-tab-title").addClass("active");
            $(".active-tab-view").addClass("active");
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
            $(`#uom${cid}`).css("background", "white");
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
            $('#taxType-error').html("");
        }

        function minSellingPriceBeforeTaxFn(){
            calculateAllPricingFn("min","before");
            $('#min_selling_price_bt_error').html("");
        }

        function minSellingPriceAfterTaxFn(){
            calculateAllPricingFn("min","after");
            $('#min_selling_price_at_error').html("");
        }

        function sellingPriceBeforeTaxFn(){
            calculateAllPricingFn("default","before");
            $('#selling_price_bt_error').html("");
        }

        function sellingPriceAfterTaxFn(){
            calculateAllPricingFn("default","after");
            $('#selling_price_at_error').html("");
        }

        function maxSellingPriceBeforeTaxFn(){
            calculateAllPricingFn("max","before");
            $('#max_selling_price_bt_error').html("");
        }

        function maxSellingPriceAfterTaxFn(){
            calculateAllPricingFn("max","after");
            $('#max_selling_price_at_error').html("");
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

        $('#itemeditbutton').click(function(){
            var id=$('#ids').val();
            edititems(id);
        });

        function edititems(id){
            var wholesalefeaturetable=$('#wholesalefeaturetable').val();
            var importcostpermission=$('#importcost').val();
            var localcostpermission=$('#localcost').val();
            var localpriceupdate=$('#localitempriceupdate').val();
            var importpriceupdate=$('#importitempriceupdate').val();
            var costtype=$('#costtype').val();
            var ItemType = $('#itemtype').val();
            var wsalemax =$('#wholesalemax').val()||0;
            var pending=$('#pendingdata').val()||0;
            $.ajax({
                type: "GET",
                url: "{{ url('itemedit') }}/"+id,
                data: "",
                dataType: "",
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
                        $('#docInfoModal').modal('hide');
                        $('#addItemForm').modal('show');
                        $("#imagepreview").hide();
                        $("#imageresetbutton").show();
                        $('#closeGenBtn').hide();
                        $("#imageload").show();
                        $("#imageloads").show();
                        $("#savebutton").show(); // hide save buttoon
                        $('#itemupdatebutton').show();
                        $('#barcodeNumberss').hide();
                        $('#barcodeNumber').show();
                        $("#checkboxVali").val('0');
                        $('#barcodeDiv').show();
                        $('#printbardiv').show();
                        $('#barcodeimagesupdate').show();
                        $("#barcodeimages").hide();
                        $('#myModalLabel333').html("Update Item");
                    },
                success: function (response) {
                    var transaction=response.transaction;
                    $.each(response.item, function (index, value) { 
                        var mxnc=value.MaxCost>0?value.MaxCost:'';
                        var mnc=value.minCost>0?value.minCost:'';
                        var avc=value.averageCost>0?value.averageCost:'';
                        var max = value.MaxCost||0;
                        var avalableqty=value.AvailableQuantity||0;
                        var minstock=value.MinimumStock||0;
                        var wsmin=value.wholeSellerMinAmount||0;
                        var maxws=parseFloat(avalableqty)-parseFloat(minstock);
                        maxws=maxws>0?maxws:0;
                        var mresult = (parseFloat(max) / 1.15).toFixed(2);
                        var mincostbv=(value.minCost/1.15).toFixed(2);
                        var avresult=(parseFloat(value.averageCost)/1.15).toFixed(2);
                        mresult=mresult>0?mresult:'';
                        avresult=avresult>0?avresult:'';
                        mresult=mresult>0?mresult:'';
                        mincostbv=mincostbv>0?mincostbv:'';
                        var itemdescription = value.Description;
                        var bt = value.BarcodeType;
                        var balance=parseFloat(value.AvailableQuantity)-parseFloat(pending);
                        var img='<img class="card-img-top" src="'+value.imageName+'" alt="barcode  image not found"  />';
                        switch(minstock){
                            case 0:
                            wsalemax='';
                            break;
                            default:
                                if(parseFloat(wsalemax)>0){
                                    wsalemax=wsalemax;
                                } else{
                                    wsalemax=0;
                                }
                            break;
                        }
                        $('#ids').val(value.id);
                        $('#name').val(value.Name);
                        $('#igroup').select2('destroy');
                        $('#igroup').val(value.itemGroup).select2();
                        $('#code').val(value.Code);
                        $('#Category').val(value.CategoryId).trigger('change');
                        $('#Uom').val(value.MeasurementId).trigger('change');
                        $('#TaxType').val(value.TaxTypeId);
                        $('#ReqSerialNumber').val(value.RequireSerialNumber);
                        $('#ReqExpireDate').val(value.RequireExpireDate);
                        $('#partNumber').val(value.PartNumber);
                        $('#lowStock').val(value.LowStock);
                        $('#skuNumber').val(value.SKUNumber);
                        $('#skuNumberupdate').val(value.oldSKUNumber);
                        $('#skuNumberupdatehidden').val(value.SKUNumber);
                        $('#maxcost').val(mxnc);
                        $('#mincost').val(mnc);
                        $('#averagecost').val(avc);
                         $('#factor').val(value.standard_factor);
                        
                        $('#maxcosti').val(value.MaxCost);
                        $('#notifiablemaxcostid').val(value.MaxCost);
                        $('#itemimageupdate').val(value.path);
                        $('#barcodeCode').html(value.Code);
                        $('#BarcodeTypes').val(value.BarcodeType);
                        $('#BarcodeTypesupdate').val(value.BarcodeType);
                        $('#lastbarcode').val(value.id);
                        $('#description').val(value.Description);
                        $('#pmwholesale').val(value.pmwholesale);
                        $('#pmretail').val(value.pmretail);
                        $('#balance').val(balance);
                        $('#wholeSellerMaxAmount').val(wsalemax);
                        $('#maxcostbv').val(mresult);
                        $('#averagecostbv').val(avresult);
                        $('#mincostbv').val(mincostbv);
                        $("#barcodeimagesupdate").html(img);
                        $('#BarcodeTypes').val(bt);
                                switch (costtype) {
                                case '1': // average cost vlaues
                                    if(value.averageCost>0){
                                        $('#pmretail').prop('readonly', false);
                                        $('#pmwholesale').prop('readonly', false);
                                    } else{
                                        $('#pmretail').prop('readonly', true);
                                        $('#pmwholesale').prop('readonly', true);
                                    }
                                    break;
                                case '0': // maximum cost value
                                    if(value.MaxCost>0){
                                        $('#pmretail').prop('readonly', false);
                                        $('#pmwholesale').prop('readonly', false);
                                    } else{
                                        $('#pmretail').prop('readonly', true);
                                        $('#pmwholesale').prop('readonly', true);
                                    }
                                    break;
                                default:
                                    break;
                            }
                            switch(value.ActiveStatus){
                            case "Active":
                                $('#status').empty();
                                $('#status').append('<option selected value="Active">Active</option>@can("Status-change")<option value="Inactive">Inactive</option>@endcan');
                                $('#status').select2();
                                break;
                            default:
                                $('#status').empty();
                                $('#status').append('<option selected value="Inactive">Inactive</option>@can("Status-change")<option value="Active">Active</option>@endcan');
                                $('#status').select2();
                        }
                        
                        switch(value.RetailerPrice){
                            case 0:
                                $('#retailPrice').val('');
                                $('#retailPricehidden').val('');
                                $('#notifiablereailerpriceid').val('');
                                $('#retailPricebv').val('');
                                
                            break;
                            default:
                                var retailPricebeforeVat = (parseFloat(value.RetailerPrice) / 1.15).toFixed(2);
                                $('#retailPrice').val(value.RetailerPrice);
                                $('#retailPricehidden').val(value.RetailerPrice);
                                $('#notifiablereailerpriceid').val(value.RetailerPrice);
                                $('#retailPricebv').val(retailPricebeforeVat);
                        }
                        switch(value.WholesellerPrice){
                            case 0:
                                $('#wholeSellerPrice').val('');
                                $('#wholeSellerPricehidden').val('');
                                $('#wholeSellerPricebv').val('');
                                $('#notifiablewholesellerpriceid').val('');
                                $("#wholeSellerMinAmount").prop("readonly", true);
                                
                            break;
                            default:
                                var wholesalePricebeforeVat = (parseFloat(value.WholesellerPrice) / 1.15).toFixed(2);
                                $('#wholeSellerPrice').val(value.WholesellerPrice);
                                $('#wholeSellerPricehidden').val(value.WholesellerPrice);
                                $('#notifiablewholesellerpriceid').val(value.WholesellerPrice);
                                $('#wholeSellerPricebv').val(wholesalePricebeforeVat);
                                $("#wholeSellerMinAmount").prop("readonly", false);
                        }
                        switch(value.MinimumStock){
                            case 0:
                                $('#minimumstock').val('');
                            break;
                            default:
                                $('#minimumstock').val(value.MinimumStock);
                        }
                        switch(value.wholeSellerMinAmount){
                            case 0:
                            $('#wholeSellerMinAmount').val('');
                            break;
                            default:
                            $('#wholeSellerMinAmount').val(value.wholeSellerMinAmount);
                        }
                        
                        switch (value.itemGroup) {
                            case 'Imported':
                                switch (importpriceupdate) {
                                    case '1':
                                            $('#retailPricebv').prop('readonly', false);
                                            $('#retailPrice').prop('readonly', false);
                                            $('#wholeSellerPricebv').prop('readonly', false);
                                            $('#wholeSellerPrice').prop('readonly', false);
                                            $('#wholeSellerMinAmount').prop('readonly', false);
                                            $('#pmwholesale').prop('readonly', false);
                                            $('#pmretail').prop('readonly', false);
                                        break;
                                    default:
                                            $('#retailPricebv').prop('readonly', true);
                                            $('#retailPrice').prop('readonly', true);
                                            $('#wholeSellerPricebv').prop('readonly', true);
                                            $('#wholeSellerPrice').prop('readonly', true);
                                            $('#wholeSellerMinAmount').prop('readonly', true);
                                            $('#pmwholesale').prop('readonly', true);
                                            $('#pmretail').prop('readonly', true);
                                        break;
                                }
                                if(max!=0){
                                    if(importcostpermission==1){
                                    $('#mincostbvlbl').html(mincostbv);  
                                    $('#averagecostbvlbl').html(avresult); 
                                    $('#maxcostbvlbl').html(mresult);
                                    $('#mincostlbl').html(mnc);
                                    $('#averagecostlbl').html(avc);
                                    $('#maxcostlbl').html(mxnc);
                                    costTablesetColor(costtype);
                                    removeclassfromcost();
                                }
                                else{
                                    addclasstocost(value.pmwholesale,value.pmretail);
                                    removeAverageCostColor();
                                    removeMaxCostColor();
                                }
                                }else{
                                    $('#mincostbvlbl').html(mincostbv);  
                                    $('#averagecostbvlbl').html(avresult); 
                                    $('#maxcostbvlbl').html(mresult);
                                    $('#mincostlbl').html(mnc);
                                    $('#averagecostlbl').html(avc);
                                    $('#maxcostlbl').html(mxnc);
                                    removeAverageCostColor();
                                    removeMaxCostColor();
                                }
                            
                                break;
                            default:
                                switch (localpriceupdate) {
                                    case '1':
                                        $('#retailPricebv').prop('readonly', false);
                                        $('#retailPrice').prop('readonly', false);
                                        $('#wholeSellerPricebv').prop('readonly', false);
                                        $('#wholeSellerPrice').prop('readonly', false);
                                        $('#wholeSellerMinAmount').prop('readonly', false);
                                        $('#pmwholesale').prop('readonly', false);
                                        $('#pmretail').prop('readonly', false);
                                        break;
                                    default:
                                        $('#retailPricebv').prop('readonly', true);
                                        $('#retailPrice').prop('readonly', true);
                                        $('#wholeSellerPricebv').prop('readonly', true);
                                        $('#wholeSellerPrice').prop('readonly', true);
                                        $('#wholeSellerMinAmount').prop('readonly', true);
                                        $('#pmwholesale').prop('readonly', true);
                                        $('#pmretail').prop('readonly', true);
                                        break;
                                }
                                if(max!=0){
                                    if(localcostpermission==1){
                                        $('#mincostbvlbl').html(mincostbv);  
                                        $('#averagecostbvlbl').html(avresult); 
                                        $('#maxcostbvlbl').html(mresult);
                                        $('#mincostlbl').html(mnc);
                                        $('#averagecostlbl').html(avc);
                                        $('#maxcostlbl').html(mxnc);
                                        removeclassfromcost();
                                        costTablesetColor(costtype);
                                        
                                        switch (value.pmretail) {
                                            case 0:
                                                $('#pmretail').val('');
                                                break;
                                            default:
                                                $('#pmretail').val(value.pmretail);
                                                break;
                                        }
                                        switch (value.pmwholesale) {
                                            case 0:
                                                $('#pmwholesale').val('');
                                                break;
                                            default:
                                                $('#pmwholesale').val(value.pmwholesale);
                                                break;
                                        }
                                        
                                        }
                                    else{
                                        addclasstocost(value.pmwholesale,value.pmretail);
                                        removeAverageCostColor();
                                        removeMaxCostColor();
                                    }
                                }else{
                                    removeAverageCostColor();
                                    removeMaxCostColor();
                                    $('#mincostbvlbl').html(mincostbv);  
                                    $('#averagecostbvlbl').html(avresult); 
                                    $('#maxcostbvlbl').html(mresult);
                                    $('#mincostlbl').html(mnc);
                                    $('#averagecostlbl').html(avc);
                                    $('#maxcostlbl').html(mxnc);
                                }
                                break;
                        }
                            somedivhideandshow(value.Type);
                            checkminstockpermission(value.itemGroup);
                            editransaction(transaction);
                    });
                }
            });
        }

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
        $('#savebutton').click(function(){
            var id=$('#ids').val()||0;
            var wholesalVal = parseFloat($('#wholeSellerPrice').val()||0);
            var wholesalMinVal = parseFloat($('#wholeSellerMinAmount').val());
            var maxCostValue = parseFloat($('#maxcosti').val());
            var averagcost=parseFloat($('#averagecost').val());
            var retailval = parseFloat($('#retailPrice').val()||0);
            var costType=$('#costtype').val();
            maxCostVal = costType == 0 ? maxCostValue: averagcost;
            var msgretail=costType == 0 ? 'The retail price is less than max cost': 'The retail price is less than average cost';
            var msgwholesale=costType == 0 ? 'The whole sale price is less than max cost': 'The whole sale price is less than average cost';
            var msgforboth=costType == 0 ? 'The retail and whole sale price is less than max cost': 'The retail and whole sale price is less than average cost';
            if((maxCostVal != '' && retailval!=0 && retailval < maxCostVal) &&  (maxCostVal != '' && wholesalVal!=0 && wholesalVal < maxCostVal)){
                toastrMessage('error',msgforboth,'Error');
            }
            else if ((maxCostVal != '' && retailval!=0 && retailval < maxCostVal)) {
                    toastrMessage('error',msgretail,'Error');
            }
            else if((maxCostVal != '' && wholesalVal!=0 && wholesalVal < maxCostVal)){
                toastrMessage('error',msgwholesale,'Error');
            }
            else{
                var registerForm = $("#RegisterItem");
                var formData = registerForm.serialize();
                $.ajax({
                    type: "POST",
                    url: "{{ url('saveitems') }}",
                    data: formData,
                    dataType: "json",
                    beforeSend: function () {
                        $('#savebutton').prop('disabled',true);
                        $('#saveloadid').addClass('spinner-border spinner-border-sm');
                        $('#savesaveid').addClass('sml-25 align-middle').text('Please wait...');
                        sectionBlock.block({
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
                        $('#savebutton').prop('disabled',false);
                        $('#saveloadid').removeClass('spinner-border spinner-border-sm');
                        $('#savesaveid').text('Save');
                            sectionBlock.block({
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
                        if(data.errors){
                            if(data.errors.group){
                                $('#group-error').html(data.errors.group[0]);
                            }
                            if (data.errors.name) {
                                $('#name-error').html(data.errors.name[0]);
                            }
                            if (data.errors.code) {
                                $('#code-error').html(data.errors.code[0]);
                                var itmcodetype=$('#itmcodetype').val();
                                if(parseFloat(itmcodetype)==1){
                                    $("#newcodegenerate").show();
                                }
                                else{
                                    $("#newcodegenerate").hide();
                                }
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
                            if (data.errors.wholeSellerPrice) {
                                var text=data.errors.wholeSellerPrice[0];
                                text = text.replace("whole seller", "Whole sale");
                                $('#wholeSellerPrice-error').html(text);
                            }
                            if (data.errors.wholeSellerMinAmount) {
                                $('#wholeSellerMinAmount-error').html(data.errors.wholeSellerMinAmount[0]);
                            }
                            if(data.errors.retailPrice){
                                $('#retailPrice-error').html(data.errors.retailPrice[0]);
                            }
                        }
                        if(data.success){
                            toastrMessage('success','Item Saved Successfully','Success');
                            $("#addItemForm").modal('hide');
                            $("#RegisterItem")[0].reset();
                            $('#Category').val(null).trigger('change');
                            $('#Uom').val(null).trigger('change');
                            switch (id) {
                                case 0:
                                    gblIndex+=1;
                                    break;
                                default:
                                    gblIndex= gblIndex;
                                    break;
                            }
                            var oTable = $(focustables).dataTable();
                            oTable.fnDraw(false);
                            closeModalWithClearValidation();
                        
                        }
                    }
                });
            }
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
                    $('#generate_item_code').hide();
                }
                else if(code != code_hidden){
                    $('#generate_item_code').show();
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