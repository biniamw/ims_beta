@extends('layout.app1')
@section('title')
@endsection
@section('styles')
<link rel="stylesheet" href="{{ asset('fontawesome6/pro/css/all.min.css') }}">
@endsection
@section('content')
    <div class="app-content content ">
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
    <div class="modal fade show" id="addItemForm" tabindex="-1" aria-labelledby="exampleModalScrollableTitle" style="display: none;" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Register Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModalWithClearValidation()">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="RegisterItem" enctype="multipart/form-data" class="mt-2">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <!-- Input Mask start -->
                        <section id="section-block">
                            <div class="row">
                                <div class="col-md-9" id="itemsdiv">
                                    <div class="row" id="headerblock">
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2" id="withDiv">
                                            <label strong style="font-size: 14px;">Type </label>
                                            <input type="hidden" placeholder="Item ID" class="form-control" name="id" id="ids" />
                                            <input type="hidden" class="form-control" name="notifiablemaxcostid" id="notifiablemaxcostid" />
                                            <input type="hidden" class="form-control" name="notifiablereailerpriceid" id="notifiablereailerpriceid" />
                                            <input type="hidden" class="form-control" name="notifiablewholesellerpriceid" id="notifiablewholesellerpriceid" />
                                            <input type="hidden" class="form-control" name="itmcodetype" id="itmcodetype" />
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
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2" id="GroupDiv">
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
                                            <span class="text-danger">
                                                <strong id="group-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2" id="codeDiv">
                                            <label strong style="font-size: 14px;">Code</label><label style="color: red; font-size:16px;">*</label><button type="button" class="btn btn-flat-success btn-sm" id="newcodegenerate" onclick="generatecode()">Get new code</button>
                                            <div id="codeblock">
                                                <input type="text" placeholder="Code" class="form-control" name="code" id="code" onkeyup="removeCodeValidation()" ondblclick="codeActive()" onkeypress="return ValidateCode(event);" />
                                            </div>
                                                <span class="text-danger">
                                                    <strong id="code-error"></strong>
                                                </span>
                                        </div>
                                        <div class="col-xl-4 col-md-6 col-sm-12 mb-2" id="nameDiv">
                                            <label strong style="font-size: 14px;">Name</label><label style="color: red; font-size:16px;">*</label>
                                            <div id="nameblock" ondblclick="openHeader();">
                                                <input type="text" placeholder="Enter item name" class="form-control" name="name" id="name" onkeypress="removeNameValidation()" autofocus />
                                            </div>
                                                <span class="text-danger">
                                                    <strong id="name-error"></strong>
                                                </span>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2" id="uomDiv">
                                            <label strong style="font-size: 14px;">UOM</label><label style="color: red; font-size:16px;">*</label>
                                            <div>
                                                <div id="uomblock">
                                                    <select class="select2 form-control" data-placeholder="Select uom" name="Uom" id="Uom" onchange="uomValidation()">
                                                        <option value="" disabled selected></option>
                                                        @foreach ($uom as $um)
                                                            <option value="{{ $um->id }}">{{ $um->Name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <span class="text-danger">
                                                <strong id="uom-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-3 col-md-6 col-sm-12 mb-2" id="categoryDiv">
                                            <label strong style="font-size: 14px;">Category</label><label style="color: red; font-size:16px;">*</label>
                                            <div>
                                                <div id="categoryblock">
                                                    <select class="select2 form-control" data-placeholder="Select category" name="Category" id="Category" onchange="categoryValidation()">
                                                        <option value="" disabled selected></option>
                                                        @foreach ($category as $cat)
                                                            <option value="{{ $cat->id }}">{{ $cat->Name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                
                                            </div>
                                            <span class="text-danger">
                                                <strong id="category-error"></strong>
                                            </span>
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
                                        
                                            <div class="col-xl-2 col-md-6 col-sm-12 mb-2" id="lowStockDiv">
                                                <label strong style="font-size: 14px;">Reorder Point</label>
                                                <input type="number" placeholder="Reorder Point" class="form-control" name="lowStock" id="lowStock" onkeyup="lowStockValidation()" onkeypress="return ValidateNum(event);" />
                                                <span class="text-danger">
                                                    <strong id="lowStock-error"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-2 col-md-6 col-sm-12 mb-2" id="taxtypeDiv">
                                                <label strong style="font-size: 14px;">Tax Type</label>
                                                <div>
                                                    <select class="select2 form-control" name="TaxType" id="TaxType" onchange="taxTypeValidation()">
                                                        @foreach ($taxtypes as $tx)
                                                            <option value="{{ $tx->Value }}">{{ $tx->Name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <span class="text-danger">
                                                    <strong id="taxType-error"></strong>
                                                </span>
                                            </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2" id="serialNumDiv">
                                            <label strong style="font-size: 14px;"> Serial Number</label>
                                            <div class="input-group input-group-merge">
                                                <select class="form-control" name="ReqSerialNumber" id="ReqSerialNumber" onchange="reqSerialNumValidation()">
                                                    <option value="Not-Require">Not-Require</option>
                                                    <option value="Required">Requires</option>
                                                </select>
                                            </div>
                                            <span class="text-danger">
                                                <strong id="requireSerialNumber-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-3 col-md-6 col-sm-12 mb-2" id="expireDateDiv">
                                            <label strong style="font-size: 14px;"> Expire Date|Batch Number </label>
                                            <div class="input-group input-group-merge">
                                                <select class="form-control" name="ReqExpireDate" id="ReqExpireDate" onchange="reqExpDateValidation()">
                                                    <option value="Not-Require">Not-Require</option>
                                                    <option value="Require-ExpireDate">Require-ExpireDate</option>
                                                    <option value="Require-BatchNumber">Require-BatchNumber</option>
                                                    <option value="Require-Both">Require-Both</option>
                                                </select>
                                            </div>
                                            <span class="text-danger">
                                                <strong id="requireExpireDate-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2" id="partNumDiv">
                                            <label strong style="font-size: 14px;">Part Number</label>
                                            <input type="text" placeholder="Part Number" class="form-control" name="partNumber" id="partNumber" onkeypress="partNumberValidation()"/>
                                            <span class="text-danger">
                                                <strong id="partNumber-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2" id="factorDiv">
                                            <label style="font-size: 14px; font-weight: bold;">Factor</label>
                                            <div>
                                                <input type="number"
                                                    step="any"
                                                    placeholder="e.g. 1.23456789"
                                                    class="form-control"
                                                    name="factor"
                                                    id="factor"
                                                    onkeyup="calculateCostsWithFactor()"
                                                    onkeypress="return ValidateFactorNum(event, this);"
                                                    style="color:black; font-weight:bold; border-style:solid;" />
                                            </div>
                                            <span class="text-danger">
                                                <strong id="factor-error"></strong>
                                            </span>
                                        </div>
                                        
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2" id="statusDiv">
                                            <label strong style="font-size: 14px;">Status</label>
                                            <select class="select2 form-control" name="status" id="status"  onchange="removeStatusValidation()">
                                            </select>
                                            <span class="text-danger">
                                                <strong id="activeStatus-error"></strong>
                                            </span>
                                        </div>  
                                        @php
                                            $sk = $setings->prefix . $setings->skunumber;
                                        @endphp
                                        <div class="col-xl-4 col-md-6 col-sm-12 mb-2" id="descriptionDiv">
                                            <label strong style="font-size: 14px;"> Description </label>
                                            <textarea type="text" placeholder="Write Description here..." class="form-control" rows="3" name="description" id="description"> </textarea>
                                            <span class="text-danger">
                                                <strong id="description-error"></strong>
                                            </span>
                                        </div>
                                    </div> <!-- end row-->
                                </div>
                                <div class="col-md-3"  id="purchasediv">
                                    <section id="card-demo-example">
                                        <div class="row match-height">
                                            <div class="col-md-12 col-lg-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h4 class="card-title">Product-Purchase Cost</h4>
                                                        <div class="table-responsive">
                                                            <table style="width: 100%;" class="table table-bordered">
                                                                <tr class="table-secondary">
                                                                    <td style="width: 33%"><b>Cost</b></td>
                                                                    <td style="width: 34%"><b>Before VAT</b></td>
                                                                    <td style="width: 33%"><b>After VAT</b></td>
                                                                </tr>
                                                                <tr class="table-default">
                                                                    <td>Min Cost</td>
                                                                        <td><b><span id="mincostbvlbl"></span></b></td>
                                                                        <td><b><span id="mincostlbl"></span></b></td>
                                                                </tr>
                                                                <tr id="averagecostabletr">
                                                                    <td>Avg Cost</td>
                                                                    <td><b><span id="averagecostbvlbl"></span></b></td>
                                                                    <td><b><span id="averagecostlbl"></span></b></td>
                                                                </tr>
                                                                <tr id="maxcostabletr">
                                                                    <td>Max Cost</td>
                                                                    <td><b><span id="maxcostbvlbl"></span></b></td>
                                                                    <td><b><span id="maxcostlbl"></span></b></td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-lg-12" id="skuNumberDiv">
                                                <label strong style="font-size: 14px;">Barcode(SKU#)<button type="button" class="btn btn-flat-success btn-sm" id="readBtn" onclick="ReadBarcode()">R</button>
                                                <button type="button" class="btn btn-flat-success btn-sm" id="generateBtn" onclick="GenerateBarcode()">G</button>
                                                <button type="button" class="btn btn-flat-danger btn-sm" id="closeGenBtn" onclick="closeBarcode()">C</button></label>
                                                <input type="hidden" class="form-control" name="skupdate" id="skupdate" value="" />
                                                <input type="hidden" class="form-control" name="skuNumberupdate" id="skuNumberupdate"/>
                                                <input type="hidden" class="form-control" name="skuNumberupdatehidden" id="skuNumberupdatehidden"/>
                                                <input type="text" placeholder="SKU Number" class="form-control" name="skuNumber" id="skuNumber" onkeyup="removeSknumbervalidation()" />
                                                <input type="hidden" class="form-control" name="BarcodeTypes" id="BarcodeTypes" value="None" />
                                                <input type="hidden" class="form-control" name="BarcodeTypesupdate" id="BarcodeTypesupdate" value="None" />
                                                <input type="hidden" class="form-control" name="skgenerate" id="skgenerate" />
                                                <input type="hidden" class="form-control" name="lastbarcode" id="lastbarcode" value="" />
                                                <input type="hidden" class="form-control" name="barcoderequire" id="barcoderequire" value="{{ $setings->BarcodeRequire }}" readonly/>
                                                <span class="text-danger">
                                                    <strong id="skuNumber-error"></strong>
                                                </span>
                                            </div>
                                            <div class="col-md-12 col-lg-12">
                                                <div id="barcodeDiv">
                                                    <div style="" class="text-center">
                                                        <b><label id="barcodeCode"></label></b>
                                                    </div>
                                                    <!-- barcodec images -->
                                                    <div id="barcodeimages" class="text-center" style="display: none;">
                                                    </div>
                                                    <div id="barcodeimagesupdate" class="text-center" style="display: none;">
                                                    </div>
                                                    <div class="form-check form-check-inline" id="printbardiv">
                                                        <label class="form-check-label" for="printbar">Print Barcode : </label>
                                                        <input class="form-check-input" name="printBar" type="checkbox" id="printBar" />
                                                        <input type="hidden" class="form-control" name="checkboxVali" id="checkboxVali" readonly/>
                                                    </div>
                                                    <div style="padding-left: 20%">
                                                        <b><label id="barcodeNumberss"></label></b>
                                                        <b><label id="barcodeNumber"></label></b>
                                                    </div>
                                            </div>
                                        </div>
                                        </div>
                                    </section>
                                </div>
                        </section>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" placeholder="max cost" class="form-control" name="maxcosti" id="maxcosti" />
                        <input type="hidden" placeholder="" class="form-control" name="pmwholesalehidden" id="pmwholesalehidden" readonly/>
                        <input type="hidden" placeholder="" class="form-control" name="pmretailhidden" id="pmretailhidden" readonly/>
                        <input type="hidden" placeholder="" class="form-control" name="retailPricehidden" id="retailPricehidden" readonly/>
                        <input type="hidden" placeholder="" class="form-control" name="wholeSellerPricehidden" id="wholeSellerPricehidden" readonly/>
                    </div>
                </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="savebutton" class="btn btn-info waves-effect waves-float waves-light">
                            <span id="saveloadid"></span>
                            <span id="savesaveid">Save</span>
                        </button>
                        <button id="closebutton1" type="button" class="btn btn-danger" onclick="closeModalWithClearValidation()" data-dismiss="modal">Close</button>
                </div>
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
                                <input type="hidden" placeholder="" class="form-control" name="itemtype" id="itemtype" readonly="true">
                                <input type="hidden" placeholder="" class="form-control" name="wholesalemax" id="wholesalemax" readonly="true">
                                <input type="hidden" placeholder="" class="form-control" name="pendingdata" id="pendingdata" readonly="true">
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
            sectionBlock=$('#section-block');
            pageSection = $('#page-block');
            tableSection=$('.tableSection');
            headerSection=$('#headerblock');
            withDivSection=$('#typeblock');
            GroupDivSection=$('#groupblock');
            codeDivSection=$('#codeblock');
            nameDivSection=$('#nameblock');
            uomDivSection=$('#uomblock');
            categoryDivSection=$('#categoryblock');
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
            $("#skuNumber").attr("readonly", true);
            $("#barcodeDiv").hide();
            $("#imagepreview").hide();
            var weight = window.innerHeight;
            var itcodetype= $('#ItemCodeType').val();
            if(parseFloat(itcodetype)==1){
                $('#code').prop('readonly', true);
            }
            else{
                $('#code').prop('readonly', false);
            }
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
            var itcodetype=null;
            $.get("getitemcodes",function (data, textStatus, jqXHR) {
                    $.each(data.setings, function (index, value) {
                        
                        itcodetype=value.ItemCodeType;
                    });
                    //console.log('doc='+data.docNumber+'ff='+itcodetype);
                    if(parseFloat(itcodetype)==1){
                        $('#code').val(data.docNumber);
                        $('#code').prop('readonly', true);
                    }
                    else{
                        //$('#code').val('');
                        $('#code').prop('readonly', false);
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
        $('body').on('click', '.addbutton', function() {
                var itcodetype=null;
                var wholesalefeature=null;
                var priceupdate=$('#priceupdate').val();
                var importcostpermission=$('#importcost').val();
                var localcostpermission=$('#localcost').val();
                removeAverageCostColor();
                removeMaxCostColor();
                $('#myModalLabel333').html("Add Item");
                var type=$('#TypeId').val();
                $('#pmretail').prop('readonly', true);
                $('#pmwholesale').prop('readonly', true);
                $('#purchasediv').removeClass('col-md-3');
                $('#purchasediv').removeClass('col-md-0');
                $('#itemsdiv').removeClass('col-md-9');
                $('#itemsdiv').removeClass('col-md-12');
                $('#purchasediv').addClass('col-md-3');
                $('#itemsdiv').addClass('col-md-9');
                $('#purchasediv').show();
                $('#minimumstockdiv').hide();
                $('#pmretail').show();
                $('#pmretaillbl').show();
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
                $.get("getitemcodes",function (data, textStatus, jqXHR) {
                    $.each(data.setings, function (index, value) {
                        itcodetype=value.ItemCodeType;
                        $('#itmcodetype').val(itcodetype);
                    });
                    if(parseFloat(itcodetype)==1){
                        $('#code').val(data.docNumber);
                        $('#code').prop('readonly', true);
                    }
                    else{
                        $('#code').prop('readonly', false);
                    }
                });
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
            $('#ids').val('');
            $('#BarcodeTypesupdate').val('');
            $('#notifiablemaxcostid').val('');
            $('#notifiablereailerpriceid').val('');
            $('#notifiablewholesellerpriceid').val('');
            $("#RegisterItem")[0].reset();
            $('#lblretailprice').html('Retail Price');
            $("#addItemForm").modal('show');
            $("#savebutton").show();
            $('#closeGenBtn').hide();
            $("#itemupdatebutton").hide();
            $('#barcodeNumberss').show();
            $('#barcodeNumber').hide();
            $("#imageloads").hide();
            $("#barcodeDiv").hide();
            $("#imageresetbutton").hide();
            $("#wholeSellerMinAmount").prop("readonly", true);
            $('#skuNumber').val('');
            $("#checkboxVali").val('0');
            $('#igroup').select2('destroy');
            $('#igroup').val('').select2();
            $('#status').empty();
            $('#status').append('<option value="Active">Active</option><option value="Inactive">Inactive</option>');
            $('#status').select2();
        });
        
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
        $(function () {
            cardSection = $('#card-block');
        });
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
            $('#code-error').html("");
            var code = $('#code').val();
            $('#barcodeCode').html(code);
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
            var max=$('#wholeSellerMaxAmount').val()||0;
            var alablestock=$('#balance').val()||0;
            var minstock=parseFloat(alablestock)-parseFloat(max);
            minstock=minstock>0?minstock:0;
            $('#minimumstock').val(minstock);
            $("#minimumstock").prop("readonly", false);
        }
        function wholeSellerMinAmountValidation() {
            $('#wholeSellerMinAmount-error').html("");
        }
        function taxTypeValidation() {
            $('#taxType-error').html("");
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
        function skuValidation() {
            $('#skuNumber-error').html("");
        }
        function removeStatusValidation() {
            $('#activeStatus-error').html("");
        }
        function removeSknumbervalidation() {
            $('#skuNumber-error').html("");
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
            $("#skuNumber").attr("readonly", true); //disable sku number
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
            var itcodetype= $('#ItemCodeType').val();
            if(parseFloat(itcodetype)==1){
                $('#code').prop('readonly', true);
            }
            else{
                $('#code').prop('readonly', false);
            }
        }
        //End Close modal with clear validations
        //Start Generate barcode
        function GenerateBarcode() {
            var id=$('#ids').val()||0;
            var barcode=$('#BarcodeTypesupdate').val()||0;
            $("#skuNumber").attr("readonly", true); //enable sku number
            $('#skuNumber-error').html("");
            if ($('#code').val().length === 0) {
                $('#code-error').html("Code is required");
                toastrMessage('error','Code is required','Error');
            } else {
                if(barcode=="Read"||barcode==0){
                        $('#BarcodeTypes').val("Generate");
                        $('#barcodeimages').show();
                        $('#barcodeimagesupdate').hide();
                        $.get("/getsknumber", function(data) {
                        if(data.maxerror){
                            toastrMessage('error',data.maxerror,"Error");
                        }
                        else if(data.minierror){
                            toastrMessage('error',data.minierror,"Error");
                        }
                        else if(data.systemerror){
                            toastrMessage('error',data.minierror,"Error");
                        }
                        else if(data.success) {
                            $("#skupdate").val(data.setting.skunumber);
                            $("#skuNumber").val(data.setting.prefix + data.numberpaddging);
                            $.get("/getgeneratebarcode", function(data) {
                                $("#barcodeimages").html(data.generated_barcodeimage);
                            });
                        }
                    });
                }
                else{
                    $('#BarcodeTypes').val("Generate");
                    $('#barcodeimages').hide();
                    $('#barcodeimagesupdate').show();
                    var sknumber=$('#skuNumberupdate').val();
                    $('#skuNumber').val(sknumber);
                    $.ajax({
                        type: "GET",
                        url: "{{ url('getoldsknumber') }}/"+sknumber,
                        success: function (response) {
                            $("#barcodeimagesupdate").html(response.generated_barcodeimage);
                        }
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
        //Start Read barcode
        function ReadBarcode() {
            $("#skuNumber").val('');
            $("#skuNumber").focus();
            $('#barcodeDiv').hide();
            $("#skuNumber").attr("readonly", false); //enable sku number
            $('#BarcodeTypes').val("Read");
            $('#closeGenBtn').show();
            $('#generateBtn').hide();
            $('#readBtn').hide();
        }
        //End read barcode
        //Start barcode close
        function closeBarcode() {
            $('#barcodeDiv').hide();
            $("#skuNumber").attr("readonly", true); //disable sku number
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