@extends('layout.app1')
@section('title')
@endsection
@section('content')
    @can('Adjustment-View')
        <div class="app-content content">
            <section id="responsive-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <div style="width:22%;">
                                    <h3 class="card-title">Stock Adjustment</h3>
                                    <label style="font-size: 10px;"></label>
                                    <div class="form-group">
                                        <label style="font-size: 12px;font-weight:bold;">Fiscal Year</label>
                                        <div>
                                            <select class="select2 form-control" name="fiscalyear[]" id="fiscalyear">
                                            @foreach ($fiscalyears as $fiscalyears)
                                                <option value="{{ $fiscalyears->FiscalYear }}">{{ $fiscalyears->Monthrange }}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <ul class="nav nav-tabs justify-content-center" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="owner-tab" data-toggle="tab" href="#ownertab" aria-controls="ownertab" role="tab" aria-selected="true" onclick="tableReloadFn(1)">Owner</a>                                
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="customer-tab" data-toggle="tab" href="#customertab" aria-controls="customertab" role="tab" aria-selected="false" onclick="tableReloadFn(2)">Customers</a>
                                    </li>
                                </ul>
                                <div style="text-align: right;"> 
                                @can('Adjustment-Add')
                                    <button type="button" class="btn btn-gradient-info btn-sm addadjustment" data-toggle="modal">Add</button>
                                @endcan
                                </div>
                            </div>
                            <div class="card-datatable">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="ownertab" aria-labelledby="ownertab" role="tabpanel">
                                        <div style="width:99%; margin-left:0.5%;">
                                            <div>
                                                <table id="laravel-datatable-crud" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable" style="width: 100%">
                                                    <thead>
                                                        <tr>
                                                            <th style="display: none;"></th>
                                                            <th style="width:3%;">#</th>
                                                            <th style="width:17%;">Document No.</th>
                                                            <th style="width:16%;">Adjustment Type</th>
                                                            <th style="width:15%;">Product Type</th>
                                                            <th style="width:15%;">Store/ Station</th>
                                                            <th style="width:15%;">Date</th>
                                                            <th style="width:15%;">Status</th>
                                                            <th style="width:4%;">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="table table-sm"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="customertab" aria-labelledby="customertab" role="tabpanel">
                                        <div style="width:99%; margin-left:0.5%;">
                                            <div>
                                                <table id="customer-crud" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable" style="width: 100%">
                                                    <thead>
                                                        <tr>
                                                            <th style="display: none;"></th>
                                                            <th style="width:3%;">#</th>
                                                            <th style="width:11%;">Document No.</th>
                                                            <th style="width:11%;">Adjustment Type</th>
                                                            <th style="width:10%;">Product Type</th>
                                                            <th style="width:10%;">Customer Code</th>
                                                            <th style="width:11%;">Customer Name</th>
                                                            <th style="width:10%;">Customer TIN</th>
                                                            <th style="width:10%;">Store/ Station</th>
                                                            <th style="width:10%;">Date</th>
                                                            <th style="width:10%;">Status</th>
                                                            <th style="width:4%;">Action</th>
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
            </section>
        </div>
    @endcan

    <!--Registration Modal -->
    <div class="modal fade" id="inlineForm" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="adjustmenttitle">Adjustment Form</h4>
                    <div class="row">
                        <div style="text-align: right;" id="statusdisplay"></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModalWithClearValidation()"><span aria-hidden="true">&times;</span></button>
                    </div>  
                </div>
                <form id="Register">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <section id="input-mask-wrapper">
                            <div class="col-xl-12">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-1">
                                                <fieldset class="fset">
                                                    <legend>Basic Information</legend>
                                                    <div class="row">
                                                        <div class="col-xl-4 col-md-4 col-sm-6 mb-1">
                                                            <label style="font-size: 14px;">Product Type</label><label style="color: red; font-size:16px;">*</label>
                                                            <select class="select2 form-control" name="ProductType" id="ProductType" onchange="prTypeFn()">
                                                                <option selected disabled value=""></option>
                                                                @foreach ($prdtypedata as $prdtypedata)
                                                                <option value="{{$prdtypedata->ProductTypeValue}}">{{$prdtypedata->ProductType}}</option>
                                                                @endforeach
                                                            </select>
                                                            <span class="text-danger">
                                                                <strong id="prdtype-error" class="errordatalabel"></strong>
                                                            </span>
                                                        </div>
                                                        
                                                        <div class="col-xl-4 col-md-4 col-sm-12 mb-1">
                                                            <label style="font-size: 14px;">Company Type</label><label style="color: red; font-size:16px;">*</label>
                                                            <select class="select2 form-control" name="CompanyType" id="CompanyType" onchange="compTypeFn()">
                                                                <option selected value=""></option>
                                                                @foreach ($comptypedata as $comptypedata)
                                                                <option value="{{$comptypedata->CompanyTypeValue}}">{{$comptypedata->CompanyType}}</option>
                                                                @endforeach
                                                            </select>
                                                            <span class="text-danger">
                                                                <strong id="comptype-error" class="errordatalabel"></strong>
                                                            </span>
                                                        </div>
                                                        <div class="col-xl-4 col-md-4 col-sm-12 mb-1 commproperty">
                                                            <label style="font-size: 14px;">Adjustment Type</label><label style="color: red; font-size:16px;">*</label>
                                                            <div>
                                                                <select class="select2 form-control" name="AdjustmentType" id="AdjustmentType" onchange="adjustmentTypeFn()">
                                                                    <option selected disabled value=""></option>
                                                                    <option value="Increase" data-icon="fa fa-plus">Increase</option>
                                                                    <option value="Decrease" data-icon="fa fa-minus">Decrease</option>
                                                                </select>
                                                            </div>
                                                            <span class="text-danger">
                                                                <strong id="adjustmenttype-error" class="errordatalabel"></strong>
                                                            </span>
                                                        </div>
                                                        <div class="col-xl-4 col-md-4 col-sm-6 mb-1 commproperty customerdiv">
                                                            <label style="font-size: 14px;" id="customerlbl">Customer</label><label style="color: red; font-size:16px;">*</label>
                                                            <select class="select2 form-control" name="Customer" id="Customer" onchange="customerFn()">
                                                                <option selected disabled value=""></option>
                                                                @foreach ($customerdatasrc as $customerdatasrc)
                                                                <option value="{{$customerdatasrc->id}}">{{$customerdatasrc->Code}} , {{$customerdatasrc->Name}} , {{$customerdatasrc->TinNumber}}</option>
                                                                @endforeach
                                                            </select>
                                                            <span class="text-danger">
                                                                <strong id="customer-error" class="errordatalabel cusreprerr"></strong>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                                <fieldset class="fset">
                                                    <legend>Others Information</legend>
                                                    <div class="row">
                                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-1" id="sourceDiv">
                                                            <label style="font-size: 14px;">Store/ Station</label><label style="color: red; font-size:16px;">*</label>
                                                            <div>
                                                                <select class="select2 form-control" name="Store" id="sstore" onchange="sourcestoreVal()">
                                                                    <option selected disabled value=""></option>
                                                                    @foreach ($storeSrc as $storeSrc)
                                                                        <option value="{{ $storeSrc->StoreId }}">{{ $storeSrc->StoreName }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <span class="text-danger">
                                                                <strong id="sourcestore-error" class="errordatalabel"></strong>
                                                            </span>
                                                        </div>
                                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                                                            <label style="font-size: 14px;">Date</label>
                                                            <div class="input-group input-group-merge">
                                                                <input type="text" id="date" name="date" class="form-control" placeholder="YYYY-MM-DD" onchange="dateVal()" readonly="true" />
                                                            </div>
                                                            <span class="text-danger">
                                                                <strong id="date-error" class="errordatalabel"></strong>
                                                            </span>
                                                        </div>
                                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                                                            <label style="font-size: 14px;">Memo</label>
                                                            <div class="input-group input-group-merge">
                                                                <textarea type="text" placeholder="Write memo here..."
                                                                    class="form-control" rows="2" name="Purpose" id="Purpose"
                                                                    onkeyup="reqReqpurposeVal()"></textarea>
                                                            </div>
                                                            <span class="text-danger">
                                                                <strong id="purpose-error" class="errordatalabel"></strong>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-12 col-lg-12" style="display: none;">
                                        <div class="row">
                                            <div class="col-xl-2 col-md-6 col-sm-12" id="destinationDiv" style="display: none;">
                                                <label style="font-size: 14px;">Destination Store</label>
                                                <div>
                                                    <select class="selectpicker form-control" name="DestinationStore" id="dstore" onchange="destinationstoreVal()">
                                                        <option selected disabled value=""></option>
                                                        @foreach ($desStoreSrc as $desStoreSrc)
                                                            <option value="{{ $desStoreSrc->StoreId }}">{{ $desStoreSrc->StoreName }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <span class="text-danger">
                                                    <strong id="destinationstore-error" class="errordatalabel"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-3 col-md-6 col-sm-12" id="sourceEditDiv">
                                                <label style="font-size: 14px;">Source Store/Shop</label>
                                                <div>
                                                    <input type="text" class="form-control" name="soustoredis" id="soustoredis" readonly="true" /></label>
                                                </div>
                                                <span class="text-danger">
                                                    <strong id="destinationstore-error" class="errordatalabel"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-2 col-md-6 col-sm-12" id="desEditDiv">
                                                <label style="font-size: 14px;">Destination Store</label>
                                                <div>
                                                    <input type="text" class="form-control" name="desstoredis" id="desstoredis" readonly="true" /></label>
                                                </div>
                                                <span class="text-danger">
                                                    <strong id="destinationstore-error" class="errordatalabel"></strong>
                                                </span>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                <hr class="m-1">
                                        
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 productcls" id="goodsdiv">
                                        <span id="dynamic-error"></span>
                                        <table id="dynamicTable" class="mb-0 rtable" style="width:100%;">
                                            <thead>
                                                <th style="width:3%;">#</th>
                                                <th style="width:27%;">Item Name</th>
                                                <th style="display: none;">Code</th>
                                                <th style="width:11%;">UOM</th>
                                                <th style="width:15%;">Qty. On Hand</th>
                                                <th style="width:15%;">Quantity</th>
                                                <th style="width:26%;">Remark</th>
                                                <th style="width:3%;"></th>
                                            </thead>
                                        </table>
                                        <table id="editReqItem" class="display table-bordered table-striped table-hover dt-responsive" style="width:100%;display:none;">
                                            <thead>
                                                <tr>
                                                    <th>id</th>
                                                    <th>HeaderId</th>
                                                    <th>ItemId</th>
                                                    <th>#</th>
                                                    <th style="width:20%;">Item Name</th>
                                                    <th style="width:15%;">Item Code</th>
                                                    <th style="width:15%;">UOM</th>
                                                    <th style="width:10%;">Quantity</th>
                                                    <th style="width:30%;">Remark</th>
                                                    <th style="width:10%;">Action</th>
                                                </tr>
                                            </thead>
                                        </table>
                                        <table style="width:100%">
                                            <tr>
                                                <td>
                                                    <button type="button" name="adds" id="adds" class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i> Add New</button>
                                                    <button type="button" name="addnew" id="addnew" class="btn btn-success btn-sm" style="display: none;" data-toggle="modal" data-target="#newreqmodal" onclick="getheaderId();"><i data-feather="plus"></i> Add New</button>
                                                <td>
                                            </tr>
                                            <tr style="display:none;" class="totalrownumber">
                                                <td colspan="2" style="text-align: right;"></td>
                                            </tr>
                                            <tr style="display:none;" class="totalrownumber">
                                                <td style="text-align: right;"><label style="font-size: 16px;">No. of Items:</label></td>
                                                <td style="text-align: right; width:5%"><label id="numberofItemsLbl" style="font-size: 16px; font-weight: bold;">0</label></td>
                                            </tr>
                                        </table>
                                        <div class="divider infoCommentCardDiv">
                                            <div class="divider-text">-</div>
                                        </div>
                                        
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12" id="commoditydiv">
                                        <div class="row">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                <div class="table-responsive">
                                                    <table id="commDynamicTable" class="mb-0 cbegtable" style="width:100%;">
                                                        <tbody></tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9" style="text-align: left;">
                                                <table class="mb-0">
                                                    <tr>
                                                        <td>
                                                            <button type="button" name="commadds" id="commadds" class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i>  Add New</button>
                                                        <td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 mt-1" style="text-align: right;">
                                                <table style="width: 100%" class="rtable" id="commTotalTable">
                                                    <tr style="background-color: #f8f9fa;">
                                                        <td style="text-align: right;width:60%"><label id="totalnumofbag" style="font-size: 14px;">Total Number of Bag</label></td>
                                                        <td style="text-align: center;width:40%">
                                                            <label id="totalnumberofbag" class="formattedNum" style="font-size: 14px; font-weight: bold;"></label>
                                                        </td>
                                                    </tr>
                                                    <tr style="background-color: #FFFFFF;">
                                                        <td><label id="totalweightkg" style="font-size: 14px;">Total Bag Weight by KG</label></td>
                                                        <td style="text-align: center;">
                                                            <label id="totalbagweightbykg" class="formattedNum" style="font-size: 14px; font-weight: bold;"></label>
                                                        </td>
                                                    </tr>
                                                    <tr style="background-color: #f8f9fa;">
                                                        <td style="text-align: right;"><label id="totalbykg" style="font-size: 14px;">Total Net KG</label></td>
                                                        <td style="text-align: center;">
                                                            <label id="totalnetkg" class="formattedNum" style="font-size: 14px; font-weight: bold;"></label>
                                                        </td>
                                                    </tr>
                                                    <tr style="background-color: #FFFFFF;">
                                                        <td><label id="totalvarinceshortage" style="font-size: 14px;">Total Variance Shortage by KG</label></td>
                                                        <td style="text-align: center;">
                                                            <label id="totalvarianceshortage" class="formattedNum" style="font-size: 14px; font-weight: bold;"></label>
                                                        </td>
                                                    </tr>
                                                    <tr style="background-color: #f8f9fa;">
                                                        <td><label id="totalvarinceoverage" style="font-size: 14px;">Total Variance Overage by KG</label></td>
                                                        <td style="text-align: center;">
                                                            <label id="totalvarianceoverage" class="formattedNum" style="font-size: 14px; font-weight: bold;"></label>
                                                        </td>
                                                    </tr>
                                                    <tr style="background-color: #FFFFFF;">
                                                        <td><label id="totalbyferesula" style="font-size: 14px;">Total by Feresula</label></td>
                                                        <td style="text-align: center;">
                                                            <label id="totalbalanceferesula" class="formattedNum" style="font-size: 14px; font-weight: bold;"></label>
                                                        </td>
                                                    </tr>
                                                    <tr style="background-color: #f8f9fa;">
                                                        <td><label id="totaltonlbl" style="font-size: 14px;">Total by TON</label></td>
                                                        <td style="text-align: center;">
                                                            <label id="totalbalanceton" class="formattedNum" style="font-size: 14px; font-weight: bold;"></label>
                                                        </td>
                                                    </tr>
                                                    <tr style="background-color: #FFFFFF;">
                                                        <td colspan="2" style="text-align: center;">
                                                            <label class="formattedNum" style="font-size: 14px; font-weight: bold;">-</label>
                                                        </td>
                                                    </tr>
                                                    <tr style="background-color: #f8f9fa;">
                                                        <td><label id="totalcostlbl" class="total_cost_price_cls" style="font-size: 14px;">Total Cost</label></td>
                                                        <td style="text-align: center;">
                                                            <label id="totalcostvaluelbl" class="formattedNum" style="font-size: 14px; font-weight: bold;"></label>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-3 col-lg-12">
                                        <div class="card infoCommentCardDiv" id="infoCommentCardDiv">
                                            <div class="card-header">
                                                <h6 class="card-title">Comment</h6>
                                                <a data-action="reload"><i data-feather="rotate-cw"></i></a>
                                            </div>
                                            <div class="card-body">
                                                <label style="font-size: 16px;" id="commentlbl"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="modal-footer">
                        <div style="display:none;">
                            <select class="select2 form-control allitems" name="allitems" id="allitems">
                                    <option selected disabled value=""></option>
                                    <option selected disabled value=""></option>
                                    @foreach ($storelists as $storelists)
                                        <option title="{{ $storelists->id }}" value=""></option>
                                    @endforeach
                                    {{-- @foreach ($itemSrc as $itemSrc)
                                        <option tabindex="{{ $itemSrc->Balance }}" class="{{ $itemSrc->Balance }}" title="{{ $itemSrc->StoreId }}" value="{{ $itemSrc->ItemId }}">{{ $itemSrc->Code }}   ,   {{ $itemSrc->ItemName }}   ,   {{ $itemSrc->SKUNumber }}</option>
                                    @endforeach  --}}
                            </select>

                            <select class="select2 form-control" name="commtypedefault" id="commtypedefault">
                                <option selected disabled value=""></option>
                                @foreach ($commtype as $commtype)
                                    <option value="{{ $commtype->CommodityTypeValue }}">{{$commtype->CommodityType}}</option>
                                @endforeach
                            </select>
                            <select class="select2 form-control" name="locationdefault" id="locationdefault">
                                <option selected disabled value=""></option>
                                @foreach ($locationdata as $locationdata)
                                    <option title="{{$locationdata->StoreId}}" value="{{ $locationdata->id }}">{{ $locationdata->Name }}</option>
                                @endforeach
                            </select>
                            <select class="select2 form-control" name="productionorderdefault" id="productionorderdefault">
                                <option selected disabled value=""></option>
                                @foreach ($prdorderdata as $prdorderdata)
                                    <option label="{{$prdorderdata->ProductionNumber}}" title="{{$prdorderdata->customers_id}}" value="{{ $prdorderdata->ProductionNumber }}">{{ $prdorderdata->ProductionNumberName }}</option>
                                @endforeach
                            </select>
                            <select class="select2 form-control" name="certNumberdefault" id="certNumberdefault">
                                <option selected disabled value=""></option>
                                @foreach ($prdordercertdata as $prdordercertdata)
                                    <option title="{{$prdordercertdata->ProductionNumber}}" value="{{ $prdordercertdata->CertNumber }}">{{ $prdordercertdata->CertNumber }}</option>
                                @endforeach
                            </select>
                            <select class="select2 form-control" name="originexpdefault" id="originexpdefault">
                                <option selected disabled value=""></option>
                                @foreach ($prdorderexporigin as $prdorderexporigin)
                                    <option label="{{$prdorderexporigin->CommType}}" title="{{$prdorderexporigin->MergedData}}" value="{{ $prdorderexporigin->woredaId }}">{{ $prdorderexporigin->Origin }}</option>
                                @endforeach
                            </select>
                            <select class="select2 form-control" name="rejoriginexpdefault" id="rejoriginexpdefault">
                                <option selected disabled value=""></option>
                                @foreach ($rejprdorderexporigin as $rejprdorderexporigin)
                                    <option title="{{$rejprdorderexporigin->MergedData}}" value="{{ $rejprdorderexporigin->woredaId }}">{{ $rejprdorderexporigin->Origin }}</option>
                                @endforeach
                            </select>
                            <select class="select2 form-control" name="supplierdefault" id="supplierdefault">
                                <option selected disabled value=""></option>
                                @foreach ($prdSupplierDataSrc as $prdSupplierDataSrc)
                                    <option title="{{$prdSupplierDataSrc->MergedData}}" value="{{ $prdSupplierDataSrc->id }}">{{ $prdSupplierDataSrc->Code }}       ,       {{ $prdSupplierDataSrc->Name }}       ,       {{ $prdSupplierDataSrc->TinNumber }}</option>
                                @endforeach
                            </select>
                            <select class="select2 form-control" name="grndefault" id="grndefault">
                                <option selected disabled value=""></option>
                                @foreach ($grndata as $grndata)
                                    <option title="{{$grndata->SupplierId}}" value="{{ $grndata->GrnNumber }}">{{ $grndata->GrnNumber }}</option>
                                @endforeach
                            </select>
                            <select class="select2 form-control" name="grncommoditydefault" id="grncommoditydefault">
                                <option selected disabled value=""></option>
                                @foreach ($grncommodity as $grncommodity)
                                    <option title="{{$grncommodity->GrnNumber}}" value="{{ $grncommodity->woredaId }}">{{ $grncommodity->Origin }}</option>
                                @endforeach
                            </select>
                            <select class="select2 form-control" name="uomdefault" id="uomdefault">
                                <option selected disabled value=""></option>
                                @foreach ($uomdata as $uomdata)
                                    <option title="{{$uomdata->uomamount}}" label="{{$uomdata->bagweight}}" class="{{$uomdata->MergedData}}" value="{{ $uomdata->uomId }}">{{ $uomdata->UOM }}</option>
                                @endforeach
                            </select>
                            <select class="select2 form-control" name="gradedefault" id="gradedefault">
                                <option selected disabled value=""></option>
                                @foreach ($gradedata as $gradedata)
                                    <option title="{{$gradedata->MergedData}}" value="{{ $gradedata->Grade }}">{{ $gradedata->GradeName }}</option>
                                @endforeach
                            </select>
                            <select class="select2 form-control" name="processtypedefault" id="processtypedefault">
                                <option selected disabled value=""></option>
                                @foreach ($processtypedata as $processtypedata)
                                    <option title="{{$processtypedata->MergedData}}" value="{{ $processtypedata->ProcessType }}">{{ $processtypedata->ProcessType }}</option>
                                @endforeach
                            </select>
                            <select class="select2 form-control" name="cropyeardefault" id="cropyeardefault">
                                <option selected disabled value=""></option>
                                @foreach ($cropyeardata as $cropyeardata)
                                    <option title="{{$cropyeardata->MergedData}}" value="{{ $cropyeardata->CropYear }}">{{ $cropyeardata->CropYears }}</option>
                                @endforeach
                            </select>

                            <select class="select2 form-control" name="rejgradedefault" id="rejgradedefault">
                                <option selected disabled value=""></option>
                                @foreach ($rejgradedata as $rejgradedata)
                                    <option title="{{$rejgradedata->MergedData}}" value="{{ $rejgradedata->Grade }}">{{ $rejgradedata->GradeName }}</option>
                                @endforeach
                            </select>
                            <select class="select2 form-control" name="rejprocesstypedefault" id="rejprocesstypedefault">
                                <option selected disabled value=""></option>
                                @foreach ($rejprocesstypedata as $rejprocesstypedata)
                                    <option title="{{$rejprocesstypedata->MergedData}}" value="{{ $rejprocesstypedata->ProcessType }}">{{ $rejprocesstypedata->ProcessType }}</option>
                                @endforeach
                            </select>
                            <select class="select2 form-control" name="rejcropyeardefault" id="rejcropyeardefault">
                                <option selected disabled value=""></option>
                                @foreach ($rejcropyeardata as $rejcropyeardata)
                                    <option title="{{$rejcropyeardata->MergedData}}" value="{{ $rejcropyeardata->CropYear }}">{{ $rejcropyeardata->CropYears }}</option>
                                @endforeach
                            </select>
                            <select class="select2 form-control" name="rejuomdefault" id="rejuomdefault">
                                <option selected disabled value=""></option>
                                @foreach ($rejuomdata as $rejuomdata)
                                    <option title="{{$rejuomdata->uomamount}}" label="{{$rejuomdata->bagweight}}" class="{{$rejuomdata->MergedData}}" value="{{ $rejuomdata->uomId }}">{{ $rejuomdata->UOM }}</option>
                                @endforeach
                            </select>
                            <select class="select2 form-control" name="reasondefault" id="reasondefault">
                                <option selected disabled value=""></option>
                                <option data-type="dec" value="Counting-Error">Counting-Error</option>
                                <option data-type="dec" value="Missing-Commodity">Missing-Commodity</option>
                                <option data-type="dec" value="Weight-Loss">Weight-Loss</option>
                                <option data-type="dec" value="Patchment">Patchment</option>
                                <option data-type="inc" value="Found-New-Commodity">Found-New-Commodity</option>
                                <option data-type="inc" value="Counting-Error">Counting-Error</option>
                            </select>
                        </div>
                        <input type="hidden" class="form-control" name="hiddenstoreval" id="hiddenstoreval" readonly="true"/>
                        <input type="hidden" class="form-control" name="operationtypes" id="operationtypes" readonly="true" value="1"/>
                        <input type="hidden" class="form-control" name="cdate" id="cdate" readonly="true" value="{{ $curdate }}"/>
                        <input type="hidden" class="form-control" name="uname" id="uname" readonly="true" value="{{ $user }}"/>
                        <input type="hidden" class="form-control" name="tid" id="tid" readonly="true"/>
                        <input type="hidden" class="form-control" name="adjustmentId" id="adjustmentId" readonly="true"/>
                        <input type="hidden" class="form-control" name="commonVal" id="commonVal" readonly="true" /></label>
                        <input type="hidden" class="form-control" name="reqnumberi" id="reqnumberi" readonly="true" value=""/>
                        <input type="hidden" class="form-control" name="numberofItems" id="numberofItems" readonly="true" value=""/>
                        <input type="hidden" class="form-control" name="commenttype" id="commenttype" readonly="true" value=""/>
                        <button id="savebutton" type="button" class="btn btn-info">Save</button>
                        <button id="closebuttona" type="button" class="btn btn-danger closebutton" onclick="closeModalWithClearValidation()" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End Registation Modal -->

    <!--Start add new hold modal -->
    <div class="modal fade text-left" id="newreqmodal" data-keyboard="false" data-backdrop="static" tabindex="-1"
        role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">New Item</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onclick="closeReqAddModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="newreqform">
                    @csrf
                    <div>
                        <div class="modal-body">
                            <div class="col-xl-12">
                                <div class="row">
                                    <table style="width: 100%;">
                                        <tr>
                                            <td>
                                                <label style="font-size: 14px;">Item Name</label>
                                            </td>
                                            <td>
                                                <label style="font-size: 14px;">Code</label>
                                            </td>
                                            <td>
                                                <label style="font-size: 14px;">UOM</label>
                                            </td>
                                            <td>
                                                <label style="font-size: 14px;">Qty. On Hand</label>
                                            </td>
                                            <td>
                                                <label style="font-size: 14px;">Quantity</label>
                                            </td>
                                            <td>
                                                <label style="font-size: 14px;">Remark</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 20%">
                                                <select class="selectpicker form-control itemNames" data-live-search="true"
                                                    data-style="btn btn-outline-secondary waves-effect" name="itemNames"
                                                    id="reqItemname">
                                                    <option selected disabled value=""></option>
                                                    {{-- @foreach ($itemSrcEd as $itemSrcEd)
                                                        <option value="{{ $itemSrcEd->ItemId }}">{{ $itemSrcEd->Code }} ,
                                                            {{ $itemSrcEd->ItemName }} , {{ $itemSrcEd->SKUNumber }}
                                                        </option>
                                                    @endforeach --}}
                                                </select>
                                                <input type="hidden" class="form-control" name="itid" id="itid" readonly="true" />
                                                <input type="hidden" class="form-control" name="receivingidinput" id="receivingidinput" readonly="true" />
                                                <input type="hidden" class="form-control" name="receIds" id="receIds" readonly="true" />
                                                <input type="hidden" class="form-control" name="recId" id="recId" readonly="true" />
                                                <input type="hidden" class="form-control" name="requisitionsid" id="requisitionsid" readonly="true" />
                                                <input type="hidden" class="form-control" name="stId" id="stId" readonly="true" />
                                                <input type="hidden" class="form-control" name="desstId" id="desstId" readonly="true" />
                                                <input type="hidden" class="form-control" name="receivingstoreid" id="receivingstoreid" readonly="true" />
                                                <input type="hidden" class="form-control" name="editVal" id="editVal" value="0" readonly="true" />
                                                <input type="hidden" class="form-control" name="reqEditMaxCost" id="reqEditMaxCost" readonly="true" />
                                            </td>
                                            <td style="width: 15%">
                                                <input type="text" name="PartNumber" id="reqpartnumber" readonly="true" class="reqpartnumber form-control" />
                                            </td>
                                            <td style="width: 15%">
                                                <input type="text" name="UOM" placeholder="UOM" id="requom" class="requom form-control" readonly="true" />
                                            </td>
                                            <td style="width: 15%">
                                                <input type="number" class="form-control" name="itemquantity" id="itemquantity" value="" readonly="true" />
                                            </td>
                                            <td style="width: 15%">
                                                <input type="number" name="Quantity" placeholder="Quantity" id="reqquantity"
                                                    class="reqquantity form-control" onkeypress="return ValidateNum(event);"
                                                    onkeyup="findQuantitys(this)" ondrop="return false;"
                                                    onpaste="return false;" />
                                            </td>
                                            <td style="width: 30%">
                                                <textarea type="text" placeholder="Write Remark here..."
                                                    class="reqmemo form-control" rows="2" name="reqmemo" id="reqmemo"
                                                    onkeyup="cusReasonV()"></textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="text-danger">
                                                    <strong id="newitemname-error"></strong>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="text-danger">
                                                    <strong id="newpartnumber-error"></strong>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="text-danger">
                                                    <strong id="newuom-error"></strong>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="text-danger">
                                                    <strong id="newquantity-error"></strong>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="text-danger">
                                                    <strong id="newmemo-error"></strong>
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="savenewreq" type="button" class="btn btn-info">Save</button>
                        <button id="closebuttonb" type="button" class="btn btn-danger" onclick="closeReqAddModal()"
                            data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End add new hold Modal -->

    <!--Start Receiving Item Delete modal -->
    <div class="modal fade text-left" id="reqremovemodal" data-keyboard="false" data-backdrop="static" tabindex="-1"
        role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="deletereqitemform">
                    @csrf
                    <div class="modal-body">
                        <label style="font-size: 16px;font-weight:bold;">Do you really want to delete?</label>
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="reqremoveid" id="reqremoveid"
                                readonly="true">
                            <input type="hidden" class="form-control" name="reqremoveheaderid"
                                id="reqremoveheaderid" readonly="true">
                            <input type="hidden" class="form-control" name="numofitemi" id="numofitemi"
                                readonly="true">
                            <span class="text-danger">
                                <strong id="uname-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="deletereqbtn" type="button" class="btn btn-info">Delete</button>
                        <button id="closebuttonc" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Receiving Item Delete Modal -->

    <!--Start Void Modal -->
    <div class="modal fade text-left" id="adjvoidmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="adjustmentvoidform">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label style="font-size: 16px;font-weight:bold;">Do you really want to void adjustment?</label>
                        </div>
                        <div class="divider">
                            <div class="divider-text">Reason</div>
                        </div>
                        <label style="font-size: 16px;"></label>
                        <textarea type="text" placeholder="Write Reason here..." class="form-control Reason" rows="3" name="Reason" id="Reason" onkeyup="voidReason()"></textarea>
                        <span class="text-danger">
                            <strong id="void-error"></strong>
                        </span>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control" name="adjvoidid" id="adjvoidid" readonly="true">
                        <button id="voidadjbtn" type="button" class="btn btn-info">Void</button>
                        <button id="closebuttonad" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Modal Modal -->

    <!--Start undo void modal -->
    <div class="modal fade text-left" id="undovoidmodal" data-keyboard="false" data-backdrop="static" tabindex="-1"
        role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="undovoidform">
                    @csrf
                    <div class="modal-body" style="background-color:#f6c23e">
                        <label strong style="font-size: 16px;font-weight:bold;">Do you really want to undo void adjustment?</label>
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="undovoidid" id="undovoidid" readonly="true">
                            <input type="hidden" class="form-control" name="ustatus" id="ustatus" readonly="true">
                            <input type="hidden" class="form-control" name="oldstatus" id="oldstatus" readonly="true">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="undovoidbtn" type="button" class="btn btn-info">Undo Void</button>
                        <button id="closebuttonj" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End undo void modal -->

    <!--Start Info Modal -->
    <div class="modal fade text-left" id="infomodal" data-keyboard="false" data-backdrop="static" tabindex="-1"
        role="dialog" aria-labelledby="adjustmentinfolbl" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="adjustmentinfolbl">Stock Adjustment Information</h4>
                    <div class="row">
                        <div style="text-align: right" id="statustitles"></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                </div>
                <form id="adjInfoform">
                    @csrf
                    <div class="modal-body">
                        <div class="col-xl-12">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <section id="collapsible">
                                        <div class="card collapse-icon">
                                            <div class="collapse-default">
                                                <div class="card">
                                                    <div id="headingCollapse1" class="card-header" data-toggle="collapse" role="button" data-target=".infoscl" aria-expanded="false" aria-controls="collapse1">
                                                        <span class="lead collapse-title">Adjustment Basic & Action Information</span>
                                                        <div id="statustitlesA"></div>
                                                    </div>
                                                    <div id="collapse1" role="tabpanel" aria-labelledby="headingCollapse1" class="collapse infoscl">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-lg-9 col-md-6 col-sm-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            <h6 class="card-title">Basic Information</h6>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <div class="row">
                                                                                <div class=" col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                                                                    <table id="adjustment_header_tbl" style="width: 100%">
                                                                                        <tbody class="table table-borderless table-sm">
                                                                                            <tr>
                                                                                                <td style="width:30%"><label style="font-size: 14px;">Product Type</label></td>
                                                                                                <td style="width:70%"><label id="infoproducttype" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label style="font-size: 14px;">Company Type</label></td>
                                                                                                <td><label id="infocompanytype" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label style="font-size: 14px;">Adjustment Type</label></td>
                                                                                                <td><label id="infoadjustmenttype" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                            </tr>
                                                                                            <tr id="customer_row" style="display: none;">
                                                                                                <td><label style="font-size: 14px;">Customer</label></td>
                                                                                                <td><label id="infocustomer" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label style="font-size: 14px;">Store/ Station</label></td>
                                                                                                <td><label id="infostore" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label style="font-size: 14px;">Date</label></td>
                                                                                                <td><label id="infodate" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label style="font-size: 14px;">Memo</label></td>
                                                                                                <td><label id="infomemo" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                                <div class="col-lg-6 col-md-12 col-12">
                                                                                    
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                         
                                                                <div class="col-lg-3 col-md-6 col-sm-12">
                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            <h6 class="card-title">Action Information</h6>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <div class="row">
                                                                                <div class="col-lg-12 col-md-12 col-12 scrdivhor scrollhor" style="overflow-y: scroll;height:12rem">
                                                                                    <ul id="actiondiv" class="timeline mb-0 mt-0"></ul>
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
                                    </section>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="table-responsive scroll scrdiv" id="adj_detail_div" style="display:none;">
                                        <table id="commdatatable" class="display table-bordered table-striped table-hover dt-responsive mb-0 infodatatbl" style="width: 100%">
                                            <thead> 
                                                <tr>
                                                    <th style="width:2%;">#</th>
                                                    <th style="width:4%;">Reason</th>
                                                    <th style="width:4%;text-align:left;">Floor Map</th>
                                                    <th style="width:4%">Type</th>
                                                    <th style="width:5%">Supplier</th>
                                                    <th style="width:5%" title="GRN Number">GRN No.</th>
                                                    <th style="width:5%" title="Production Order Number">Production Order No.</th>
                                                    <th style="width:5%" title="Certificate Number">Certificate No.</th>
                                                    <th style="width:6%">Commodity</th>
                                                    <th style="width:4%">Grade</th>
                                                    <th style="width:4%">Process Type</th>
                                                    <th style="width:4%">Crop Year</th>
                                                    <th style="width:4%">UOM/ Bag</th>
                                                    <th style="width:4%">No. of Bag</th>
                                                    <th style="width:4%">Bag Weight by KG</th>
                                                    <th style="width:4%">Total KG</th>
                                                    <th style="width:4%">Net KG</th>
                                                    <th style="width:4%">TON<label id="feresulainfolbl" title="TON= Net KG / 1000"><i class="fa-solid fa-circle-info"></i></label></th>
                                                    <th style="width:4%">Feresula<label id="feresulainfolbl" title="Feresula= Net KG / 17"><i class="fa-solid fa-circle-info"></i></label></th>
                                                    <th style="width:4%" id="unit_cp"></th>
                                                    <th style="width:4%" id="total_cp"></th>
                                                    <th style="width:4%">Variance Shortage by KG</th>
                                                    <th style="width:4%">Variance Overage by KG</th>
                                                    <th style="width:4%">Remark</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table table-sm"></tbody>
                                            <tfoot>
                                                <th colspan="13" style="font-size:16px;text-align: right;padding-right:7px;">Total</th>
                                                <th style="font-size: 14px;" id="totalbag"></th>
                                                <th style="font-size: 14px;" id="totalbagweight"></th>
                                                <th style="font-size: 14px;" id="totalgrosskg"></th>
                                                <th style="font-size: 14px;" id="totalkg"></th>
                                                <th style="font-size: 14px;" id="totalton"></th>
                                                <th style="font-size: 14px;" id="totalferesula"></th>
                                                <th style="font-size: 14px;"></th>
                                                <th style="font-size: 14px;" id="info_total_cost_price"></th>
                                                <th style="font-size: 14px;" id="totalvarshortage"></th>
                                                <th style="font-size: 14px;" id="totalvarovrage"></th>
                                                <th></th>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control" name="itemid" id="itemid" readonly="true">
                        <input type="hidden" class="form-control" name="adjId" id="adjId" readonly="true">
                        <input type="hidden" class="form-control" name="statusi" id="statusi" readonly="true">
                        <input type="hidden" class="form-control" name="statusid" id="statusid" readonly="true">
                        <input type="hidden" class="form-control" name="currentStatus" id="currentStatus" readonly="true">
                        <input type="hidden" class="form-control" name="usernamelbl" id="usernamelbl" readonly="true" value="{{$user}}">
                        @can('Adjustment-Change-to-Pending')
                        <button id="changetopending" type="button" onclick="forwardActionFn()" class="btn btn-info actionpropbtn">Change to Pending</button>
                        <button id="backtodraft" type="button" class="btn btn-info backwardbtn actionpropbtn">Back to Draft</button>
                        @endcan
                        @can('Adjustment-Check')
                        <button id="verifybtn" type="button" onclick="forwardActionFn()" class="btn btn-info actionpropbtn">Verify Adjustment</button>
                        <button id="backtopending" type="button" class="btn btn-info backwardbtn actionpropbtn">Back to Pending</button>
                        @endcan
                        @can('Adjustment-Confirm')
                        <button id="approvebtn" type="button" onclick="forwardActionFn()" class="btn btn-info actionpropbtn">Approve Adjustment</button>
                        {{-- <button id="backtoverify" type="button" class="btn btn-info backwardbtn actionpropbtn">Back to Verify</button> --}}
                        {{-- <button id="rejectbtn" type="button" class="btn btn-info backwardbtn actionpropbtn">Reject</button> --}}
                        @endcan
                        <button id="closebuttone" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Info -->

    <!--Start forward action modal -->
    <div class="modal fade text-left" id="forwardActionModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="forwardActionForm">
                    @csrf
                    <div class="modal-body" id="modalBodyId">
                        <label style="font-size: 16px;font-weight:bold;" id="forwardActionLabel"></label>
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="forwardReqId" id="forwardReqId" readonly="true">
                            <input type="hidden" class="form-control" name="newForwardStatusValue" id="newForwardStatusValue" readonly="true">
                            <input type="hidden" class="form-control" name="forwarkBtnTextValue" id="forwarkBtnTextValue" readonly="true">
                            <input type="hidden" class="form-control" name="forwardActionValue" id="forwardActionValue" readonly="true">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="forwardActionBtn" type="button" class="btn btn-info"></button>
                        <button id="closebuttonforwardAction" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End forward action modal -->

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
                            <textarea type="text" placeholder="Write Comment/Reason here..." class="form-control" rows="3" name="CommentOrReason" id="CommentOrReason" onkeyup="commentValFn()"></textarea>
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

    <script type="text/javascript">
        var errorcolor="#ffcccc";
        var fyears = $('#fiscalyear').val();
        var j = 0;
        var i = 0;
        var m = 0;

        var j2 = 0;
        var i2 = 0;
        var m2 = 0;

        var j3 = 0;
        var i3 = 0;
        var m3 = 0;

        var j4 = 0;
        var i4 = 0;
        var m4 = 0;

        function formatText (icon) {
            return $('<span><i class="fas ' + $(icon.element).data('icon') + '"></i> ' + icon.text + '</span>');
        };

        var defaultrejtype=3;

        var statusTransitions = {
            'Draft': {
                forward: {
                    status: 'Pending',
                    text: 'Change to Pending',
                    action: 'Change to Pending',
                    message: 'Do you really want to change adjustment to pending?',
                    forecolor: '#6e6b7b',
                    backcolor: '#f6c23e'
                }
            },
            'Pending': {
                forward: {
                    status: 'Verified',
                    text: 'Verify',
                    action: 'Verified',
                    message: 'Do you really want to verify adjustment?',
                    forecolor: '#6e6b7b',
                    backcolor: '#f6c23e'
                },
                backward: {
                    status: 'Draft',
                    text: 'Back to Draft',
                    action: 'Back to Draft',
                    message: 'Comment'
                }
            },
            'Verified': {
                forward: {
                    status: 'Approved',
                    text: 'Approve',
                    action: 'Approved',
                    message: 'Do you really want to approve adjustment?',
                    forecolor: '#FFFFFF',
                    backcolor: '#28c76f'
                },
                backward: {
                    status: 'Pending',
                    text: 'Back to Pending',
                    action: 'Back to Pending',
                    message: 'Comment'
                },
                reject: {
                    status: 'Rejected',
                    text: 'Reject',
                    action: 'Rejected',
                    message: 'Reason'
                }
            },
            'Approved': {
                backward: {
                    status: 'Verified',
                    text: 'Back to Verify',
                    action: 'Back to Verify',
                    message: 'Comment'
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
                    message: 'Do you really want to approve adjustment?',
                    forecolor: '#FFFFFF',
                    backcolor: '#28c76f'
                }
            },
        };


        $(function () {
            cardSection = $('#page-block');
        });

        function getAdjustmentListFn(fyears){
            var ctable=$('#laravel-datatable-crud').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                searchHighlight: true,
                "order": [[0, "desc" ]],
                "pagingType": "simple",
                language: { search: '', searchPlaceholder: "Search here"},
                "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/commadjlist/'+fyears,
                    type: 'DELETE',
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
                },
                columns: [
                    { data: 'id', name: 'id', 'visible': false},
                    { data: 'DT_RowIndex',width:"3%"},
                    { data: 'DocumentNumber', name: 'DocumentNumber',width:"17%"},
                    { data: 'Type', name: 'Type',width:"16%"},
                    { data: 'ProductType', name: 'ProductType',width:"15%"},
                    { data: 'StoreName', name: 'StoreName',width:"15%"},
                    { data: 'AdjustedDate', name: 'AdjustedDate',width:"15%"},
                    { data: 'Status', name: 'Status',
                        "render": function ( data, type, row, meta ) {
                            if(data == "Draft"){
                                return '<span class="badge bg-secondary bg-glow">'+data+'</span>';
                            }
                            else if(data == "Pending"){
                                return '<span class="badge bg-warning bg-glow">'+data+'</span>';
                            }
                            else if(data == "Verified"){
                                return '<span class="badge bg-info bg-glow">'+data+'</span>';
                            }
                            else if(data == "Checked" || data == "Issued" || data == "Reviewed"){
                                return '<span class="badge bg-primary bg-glow">'+data+'</span>';
                            }
                            else if(data == "Approved"){
                                return '<span class="badge bg-success bg-glow">'+data+'</span>';
                            }
                            else if(data == "Void" || data == "Void(Draft)" || data == "Void(Pending)" || data == "Void(Approved)" || data == "Void(Issued)"){
                                return '<span class="badge bg-danger bg-glow">'+data+'</span>';
                            }
                            else{
                                return '<span class="badge bg-dark bg-glow">'+data+'</span>';
                            }
                        },
                        width:"15%"},
                    { data: 'action', name: 'action',width:"4%"}
                ],
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
                },
            });

            var customertbl=$('#customer-crud').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                searchHighlight: true,
                "order": [[0, "desc" ]],
                "pagingType": "simple",
                language: { search: '', searchPlaceholder: "Search here"},
                "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/cuscommadjlist/'+fyears,
                    type: 'DELETE',
                },
                columns: [
                    { data: 'id', name: 'id','visible': false},
                    { data:'DT_RowIndex',width:"3%"},
                    { data: 'DocumentNumber', name: 'DocumentNumber',width:"11%"},
                    { data: 'Type', name: 'Type',width:"11%"},
                    { data: 'ProductType', name: 'ProductType',width:"10%"},
                    { data: 'Code', name: 'Code',width:"10%"},
                    { data: 'CustomerName', name: 'CustomerName',width:"11%"},
                    { data: 'TinNumber', name: 'TinNumber',width:"10%"},
                    { data: 'StoreName', name: 'StoreName',width:"10%"},
                    { data: 'Date', name: 'Date',width:"10%"},
                    { data: 'Status', name: 'Status',
                        "render": function ( data, type, row, meta ) {
                            if(data == "Draft"){
                                return '<span class="badge bg-secondary bg-glow">'+data+'</span>';
                            }
                            else if(data == "Pending"){
                                return '<span class="badge bg-warning bg-glow">'+data+'</span>';
                            }
                            else if(data == "Verified"){
                                return '<span class="badge bg-info bg-glow">'+data+'</span>';
                            }
                            else if(data == "Checked" || data == "Issued" || data == "Reviewed"){
                                return '<span class="badge bg-primary bg-glow">'+data+'</span>';
                            }
                            else if(data == "Approved"){
                                return '<span class="badge bg-success bg-glow">'+data+'</span>';
                            }
                            else if(data == "Void" || data == "Void(Draft)" || data == "Void(Pending)" || data == "Void(Approved)" || data == "Void(Issued)"){
                                return '<span class="badge bg-danger bg-glow">'+data+'</span>';
                            }
                            else{
                                return '<span class="badge bg-dark bg-glow">'+data+'</span>';
                            }
                        },
                        width:"10%"},
                    { data: 'action', name: 'action',width:"4%"}
                ],
            });
        }
        
        //Start page load event
        $(document).ready(function() {
            $('#fiscalyear').select2();
            getAdjustmentListFn(fyears);
            var today = new Date();
            var currentdate=moment(today,"YYYY-MM-DD").format('YYYY-MM-DD');
            var dd = today.getDate();
            var mm = ((today.getMonth().length + 1) === 1) ? (today.getMonth() + 1) : '0' + (today.getMonth() + 1);
            var yyyy = today.getFullYear();
            var formatedCurrentDate = yyyy + "-" + mm + "-" + dd;
            $('#date').val(currentdate);
            
            $("#dynamicTable").show();
            $("#editReqItem").hide();
            $("#addhold").hide();

            $('#destinationDiv').hide();
            $('#sourceDiv').show();
            $('#typeDiv').hide();
            $('#sourceEditDiv').hide();
            $('#desEditDiv').hide();
            $('#typeEditDiv').hide();
            $('.infoCommentCardDiv').hide();
        });
        //End page load event

        function getCustomerData(fyears){
            $('#customer-crud').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                responsive: true,
                searchHighlight: true,
                "order": [[0, "desc"]],
                "pagingType": "simple",
                "lengthMenu": [50,100],
                language: {
                    search: '',
                    searchPlaceholder: "Search here"
                },
                scrollY:'55vh',
                scrollX: true,
                scrollCollapse: true,
                "dom": "<'row'<'col-lg-3 col-md-10 col-xs-1'f><'col-lg-2 col-md-2 col-xs-12'>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-4'i><'col-sm-12 col-md-5'><'col-sm-12 col-md-3'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/requisitiondata/2/'+fyears,
                    type: 'DELETE',
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
                        width:"8%"
                    },
                    {
                        data: 'Reference',
                        name: 'Reference',
                        width:"8%"
                    },
                    {
                        data: 'ProductType',
                        name: 'ProductType',
                        width:"8%"
                    },
                    {
                        data: 'Code',
                        name: 'Code',
                        width:"8%"
                    },
                    {
                        data: 'CustomerName',
                        name: 'CustomerName',
                        width:"8%"
                    },
                    {
                        data: 'TinNumber',
                        name: 'TinNumber',
                        width:"8%"
                    },
                    {
                        data: 'SourceStore',
                        name: 'SourceStore',
                        width:"7%"
                    },
                    {
                        data: 'RequestReason',
                        name: 'RequestReason',
                        width:"8%"
                    },
                    {
                        data: 'AdjustedDate',
                        name: 'AdjustedDate',
                        width:"7%"
                    },
                    {
                        data: 'RequestedBy',
                        name: 'RequestedBy',
                        width:"7%"
                    },
                    {
                        data: 'Status',
                        name: 'Status',
                        "render": function ( data, type, row, meta ) {
                            if(data == "Draft"){
                                return '<span class="badge bg-secondary bg-glow">'+data+'</span>';
                            }
                            else if(data == "Pending"){
                                return '<span class="badge bg-warning bg-glow">'+data+'</span>';
                            }
                            else if(data == "Verified"){
                                return '<span class="badge bg-info bg-glow">'+data+'</span>';
                            }
                            else if(data == "Checked" || data == "Issued" || data == "Reviewed"){
                                return '<span class="badge bg-primary bg-glow">'+data+'</span>';
                            }
                            else if(data == "Approved"){
                                return '<span class="badge bg-success bg-glow">'+data+'</span>';
                            }
                            else if(data == "Rejected" || data == "Void" || data == "Void(Draft)" || data == "Void(Pending)" || data == "Void(Approved)" || data == "Void(Issued)"){
                                return '<span class="badge bg-danger bg-glow">'+data+'</span>';
                            }
                            else{
                                return '<span class="badge bg-dark bg-glow">'+data+'</span>';
                            }
                        },
                        width:"8%"
                    },
                    {
                        data: 'DispatchStatus',
                        name: 'DispatchStatus',
                        "render": function ( data, type, row, meta ) {
                            if(data == "Partially-Dispatched"){
                                return '<span class="badge bg-warning bg-glow">'+data+'</span>';
                            }
                            else if(data == "Fully-Dispatched"){
                                return '<span class="badge bg-success bg-glow">'+data+'</span>';
                            }
                            else{
                                return data;
                            }
                        },
                        width:"8%"
                    },
                    {
                        data: 'action',
                        name: 'action',
                        width:"4%"
                    }
                ],
               
                fixedHeader: {
                    header: true,
                    headerOffset: $('.header-navbar').outerHeight(),
                },
            });
            $.fn.dataTable.ext.errMode = 'throw';
        }


        $('#laravel-datatable-crud tbody').on('click', 'tr', function () {
            if($(this).hasClass('selected') ) {
                $(this).removeClass('selected');
            }
            else {
                $('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        });

        $(".addadjustment").click(function() {
            $('#operationtypes').val("1");
            $('#hiddenstoreval').val("");
            $('#adjustmentId').val("");
            
            $('#ProductType').val(null).select2
            ({
                placeholder: "Select Product type first",
                minimumResultsForSearch: -1
            });

            $('#CompanyType').val(null).select2
            ({
                placeholder: "Select Company type here",
                minimumResultsForSearch: -1
            });

            $('#AdjustmentType').val(null).select2
            ({
                placeholder: "Select Adjustment type here",
                templateSelection: formatText,
                templateResult: formatText,
                minimumResultsForSearch: -1
            });

            $('#CustomerReceiver').val(null).select2
            ({
                placeholder: "Select Buyer here"
            });

            $('#sstore').val(null).select2
            ({
                placeholder: "Select Store/ Station here",
            });

            $('#RequestedBy').select2();
            var currentdate=$("#cdate").val();
            flatpickr('#date',{dateFormat: 'Y-m-d',clickOpens:true,maxDate:currentdate});
            $('#date').val(currentdate);
            $("#dynamicTable").show();
            $("#adds").show();
            $("#editReqItem").hide();
            $("#addnew").hide();
            $('#destinationDiv').hide();
            $('#sourceDiv').show();
            $('.infoCommentCardDiv').hide();
            $(".commprop").hide();
            $(".customerdiv").hide();
            $("#Purpose").val("");
            $(".errordatalabel").html("");
            $(".cusreprerr").html("");
            $('.productcls').hide();
            $('#customerlbl').html('Customer');
            $('.recustomerdiv').hide();
            $('.bookingnumdiv').hide();
            $('.referencediv').hide();
            $('.lablocdiv').hide();
            $("#statusdisplay").html("");
            $("#requistionId").val("");
            $('#tid').val("");
            $("#commDynamicTable > tbody").empty();
            CalculateCommTotal();
            $('#savebutton').text('Save');
            $('#savebutton').prop("disabled", false);
            $("#adjustmenttitle").html('Add Stock Adjustment');
            $("#inlineForm").modal('show');
        });

        //Start type change
        $('#sstore').on('change', function() {
            var sid = $('#supplier').val();
            var storeidvar = $('#sstore').val();
            var registerForm = $("#Register");
            var formData = registerForm.serialize();
            $.ajax({
                url: '/syncDynamicTable',
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
                    var q=0;
                    var itemprop="";
                    var totalrow=$('#numberofItemsLbl').text();
                    $('.AvQuantity').val("0");
                    $.each(data.bal, function(key, value) {
                        ++q;
                        var itemids=$('#dynamicTable tr:eq('+q+')').find('td').eq(1).find('select').val();
                        if(itemids==value.ItemId){
                            var reqbalance=value.ReqBalance;
                            var trnbalance=value.TrnBalance;
                            var salesbl=value.SalesBalance;
                            var balances=value.Balance;
                            var qtyonhand=0;
                            var consolidatebal=parseFloat(value.Balance)-parseFloat(value.TrnBalance)-parseFloat(value.ReqBalance);
                            if(parseFloat(consolidatebal)<=0){
                                qtyonhand=0;
                            }
                            else if(parseFloat(consolidatebal)>0){
                                qtyonhand=consolidatebal;
                            }
                            
                            var qty=$('#dynamicTable tr:eq('+q+')').find('td').eq(5).find('input').val();
                            $('#dynamicTable tr:eq('+q+')').find('td').eq(4).find('input').val(qtyonhand);
                            if(parseFloat(qtyonhand)<parseFloat(qty) || parseFloat(qtyonhand)==0){
                                $('#dynamicTable tr:eq('+q+')').find('td').eq(5).find('input').val("");
                            }
                            if(parseFloat(reqbalance)>0||parseFloat(trnbalance)>0||parseFloat(salesbl)>0){
                                itemprop+=value.ItemName+"<br>Pending Sales: "+salesbl+"<br>Pending Transfer: "+trnbalance+"<br>Pending Requisition: "+reqbalance+"<br>---------------<br>";
                            }
                            
                        }
                    });

                    for(var y=1;y<=m;y++){
                        var qtyonhand=($('#AvQuantity'+y)).val()||0;
                        var qty=($('#quantity'+y)).val()||0;
                        if(parseFloat(qtyonhand)<parseFloat(qty)|| parseFloat(qtyonhand)==0){
                            ($('#quantity'+y)).val("");
                        }
                    }

                    if(itemprop!=''){
                        //toastrMessage('info',itemprop,"Info");
                    }
                }
            });
        });
        //End Type change

        //Start type change
        $(document).ready(function() {
           
        });
        //End Type change

        //Start destination store change
        $(document).ready(function() {
            $('#dstore').on('change', function() {

                var destore = $('#dstore').val();
                $('.desstoreid').val(destore);
            });
        });
        //End destination store change

        //Start save requistion
        $('#savebutton').click(function() {
            var optype=$('#operationtypes').val();
            var numofitems = $('#numberofItems').val();
            var registerForm = $("#Register");
            var formData = registerForm.serialize();
            $.ajax({
                url: '/storeadj',
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
                    if(parseFloat(optype)==1){
                        $('#savebutton').text('Saving...');
                        $('#savebutton').prop("disabled", true);
                    }
                    else if(parseFloat(optype)==2){
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
                    if (data.errors) {
                        if (data.errors.ProductType) {
                            $('#prdtype-error').html(data.errors.ProductType[0]);
                        }
                        if (data.errors.CompanyType) {
                            $('#comptype-error').html(data.errors.CompanyType[0]);
                        }
                        if (data.errors.AdjustmentType) {
                            $('#adjustmenttype-error').html(data.errors.CompanyType[0]);
                        }
                        if (data.errors.Customer) {
                            var text=data.errors.Customer[0];
                            text = text.replace("2", "customer");
                            $('#customer-error').html(text);
                        }
                        if (data.errors.Store) {
                            var text=data.errors.Store[0];
                            text = text.replace("store", "store/ station");
                            $('#sourcestore-error').html(text);
                        }
                        if (data.errors.date) {
                            $('#date-error').html(data.errors.date[0]);
                        }
                        if (data.errors.Purpose) {
                            $('#purpose-error').html("The memo field is required.");
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
                    else if (data.errorv2) {
                        var cusid=$('#customers_id').val();
                        for(var k=1;k<=m2;k++){
                            var reason=$('#Reason'+k).val();
                            var floormap=$('#FloorMap'+k).val();
                            var commtype=$('#CommType'+k).val();
                            var origin=$('#Origin'+k).val();
                            var grade=$('#Grade'+k).val();
                            var processtype=$('#ProcessType'+k).val();
                            var cropyear=$('#CropYear'+k).val();
                            
                            var numofbag=$('#NumOfBag'+k).val();
                            var totalkg=$('#TotalKg'+k).val();
                            var uoms=$('#Uom'+k).val();

                            var commtype=$('#CommType'+k).val();
                            var supplier=$('#Supplier'+k).val();
                            var grnnum=$('#GrnNumber'+k).val();
                            var prdnum=$('#ProductionNum'+k).val();
                            var cernum=$('#CertificateNum'+k).val();
                            var unitcostprice=$('#UnitCost'+k).val();

                            if(($('#Reason'+k).val())!=undefined){
                                if(reason==""||reason==null){
                                    $('#select2-Reason'+k+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                                }
                            }
                            if(($('#FloorMap'+k).val())!=undefined){
                                if(floormap==""||floormap==null){
                                    $('#select2-FloorMap'+k+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                                }
                            }
                            if(($('#CommType'+k).val())!=undefined){
                                if(commtype==""||commtype==null){
                                    $('#select2-CommType'+k+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                                }
                            }
                            
                            if(($('#Origin'+k).val())!=undefined){
                                if(origin==""||origin==null){
                                    $('#select2-Origin'+k+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                                }
                            }
                            
                            if(($('#Grade'+k).val())!=undefined){
                                if(grade==""||grade==null){
                                    $('#select2-Grade'+k+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                                }
                            }
                            if(($('#ProcessType'+k).val())!=undefined){
                                if(processtype==""||processtype==null){
                                    $('#select2-ProcessType'+k+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                                }
                            }
                            if(($('#CropYear'+k).val())!=undefined){
                                if(cropyear==""||cropyear==null){
                                    $('#select2-CropYear'+k+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                                }
                            }
                            if(($('#Uom'+k).val())!=undefined){
                                if(uoms==""||uoms==null){
                                    $('#select2-Uom'+k+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                                }
                            }
                            // if(($('#NumOfBag'+k).val())!=undefined){
                            //     if(numofbag==""||numofbag==null){
                            //         $('#NumOfBag'+k).css("background", errorcolor);
                            //     }
                            // }
                            if(($('#TotalKg'+k).val())!=undefined){
                                if(totalkg==""||totalkg==null){
                                    $('#TotalKg'+k).css("background", errorcolor);
                                }
                            }
                            if(($('#UnitCost'+k).val())!=undefined){
                                if((unitcostprice==""||unitcostprice==null) && (parseInt(commtype)==1)){
                                    $('#UnitCost'+k).css("background", errorcolor);
                                }
                            }
                            if(($('#Supplier'+k).val())!=undefined){
                                if((supplier==""||supplier==null) && (parseInt(commtype)==1)){
                                    $('#select2-Supplier'+k+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                                }
                            }
                            if(($('#GrnNumber'+k).val())!=undefined){
                                if((grnnum==""||grnnum==null) && (parseInt(commtype)==1)){
                                    $('#select2-GrnNumber'+k+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                                }
                            }
                            if(($('#ProductionNum'+k).val())!=undefined){
                                if((prdnum==""||prdnum==null) && (parseInt(commtype)==2 || parseInt(commtype)==3 || parseInt(commtype)==4 || parseInt(commtype)==5 || parseInt(commtype)==6)){
                                    $('#select2-ProductionNum'+k+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                                }
                            }
                            if(($('#CertificateNum'+k).val())!=undefined){
                                if((cernum==""||cernum==null) && (parseInt(commtype)==2 || parseInt(commtype)==3 || parseInt(commtype)==4 || parseInt(commtype)==5 || parseInt(commtype)==6)){
                                    $('#select2-CertificateNum'+k+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                                }
                            }
                        }
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                        toastrMessage('error',"Please insert valid data on highlighted fields","Error");
                    }
                    else if (data.dberrors) {
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if(data.emptyerror){
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                        toastrMessage('error',"Please add atleast one item or commodity","Error");
                    } 
                    else if (data.success) {
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                        toastrMessage('success',"Successful","Success");
                        $('#laravel-datatable-crud').DataTable().ajax.reload();
                        $("#inlineForm").modal('hide');
                    }
                },
            });
            
        });
        //End save requistion

        //Start get hold number value
        $('body').on('click', '#getReqDocNum', function() {
            $.get("/getreqnumber", function(data) {
                $('#reqnumberi').val(data.reqnum);
                $("#myToast").toast('hide');
            });
        });
        //End get hold number value

        //start close modal function
        function closeModalWithClearValidation() {
            var uname = $("#uname").val();
            $("#Register")[0].reset();
            $('#type-error').html("");
            $('#sourcestore-error').html("");
            $('#destinationstore-error').html("");
            $('#date-error').html("");
            $('#purpose-error').html("");
            $('#destinationDiv').hide();
            $('#sstore').val(null).select2();
            $('#dstore').val(null).select2();
            var today = new Date();
            var currentdate=moment(today,"YYYY-MM-DD").format('YYYY-MM-DD');
            var dd = today.getDate();
            var mm = ((today.getMonth().length + 1) === 1) ? (today.getMonth() + 1) : '0' + (today.getMonth() + 1);
            var yyyy = today.getFullYear();
            var formatedCurrentDate = yyyy + "-" + mm + "-" + dd;
            $('#date').val(currentdate);
            $('#destinationDiv').hide();
            $('#sourceDiv').show();
            $('#typeDiv').hide();
            $('#sourceEditDiv').hide();
            $('#desEditDiv').hide();
            $('#typeEditDiv').hide();
            $('.infoCommentCardDiv').hide();
            $(".commprop").hide();
            $(".customerdiv").hide();
            $(".errordatalabel").html("");
            $(".cusreprerr").html("");
            $('.productcls').hide();
            $('.totalrownumber').hide();
            $('.recustomerdiv').hide();
            $('.bookingnumdiv').hide();
            $('.referencediv').hide();
            $('.lablocdiv').hide();
        }
        //End close modal function

        //Start save new hold record
        $('body').on('click', '#savenewreq', function() {
            var registerForm = $('#newreqform');
            var formData = registerForm.serialize();
            $.ajax({
                url: '/savenewReqItem',
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('#savenewreq').text('Saving...');
                    $('#savenewreq').prop("disabled", true);
                },
                success: function(data) {
                    if (data.errors) {
                        if (data.errors.itemName) {
                            $('#newitemname-error').html(data.errors.itemName[0]);
                        }
                        if (data.errors.Quantity) {
                            $('#newquantity-error').html(data.errors.Quantity[0]);
                        }
                        $('#savenewreq').text('Save');
                        $('#savenewreq').prop("disabled", false);
                        toastrMessage('error',"Check your inputs","Error");
                    }
                    if (data.dberrors) {
                        $('#newitemname-error').html("The item has already been taken.");
                        $('#savenewreq').text('Save');
                        $('#savenewreq').prop("disabled", false);
                        toastrMessage('error',"Check your inputs","Error");
                    }
                    if (data.success) {
                        $('#savenewreq').text('Save');
                        toastrMessage('success',"Successful","Success");
                        $("#newreqmodal").modal('hide');
                        // var oTable = $('#editReqItem').dataTable();
                        // oTable.fnDraw(false);
                        // $('#editReqItem').DataTable().ajax.reload();
                        $('#editVal').val("0");
                        $('#numberofItems').val(data.Totalcount);
                        closeReqAddModal();
                        $('#savenewreq').prop("disabled", false);
                    }
                },
            });
        });
        //Ends save new hold record

        //Open Delete Modal With Value Starts
        $('#reqremovemodal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id');
            var hid = button.data('hid');
            var modal = $(this);
            modal.find('.modal-body #reqremoveid').val(id);
            modal.find('.modal-body #reqremoveheaderid').val(hid);
        });
        //Open Delete Modal With Value Ends

        //Delete requisition Item Records Starts
        $('#deletereqbtn').click(function() {
            var numofitem = $("#numberofItems").val();
            $("#numofitemi").val(numofitem);
            if (parseFloat(numofitem) == 1) {
                toastrMessage('error',"You cant remove all items","Error");
            } else if (parseFloat(numofitem) >= 2) {
                var delid = document.forms['deletereqitemform'].elements['reqremoveid'].value;
                var deleteForm = $("#deletereqitemform");
                var formData = deleteForm.serialize();
                $.ajax({
                    url: '/deleteReqItem/' + delid,
                    type: 'DELETE',
                    data: formData,
                    beforeSend: function() {
                        $('#deletereqbtn').text('Deleting...');
                        $('#deletereqbtn').prop("disabled", true);
                    },
                    success: function(data) {
                        $('#deletereqbtn').text('Delete');
                        toastrMessage('success',"Deleted","Success");
                        // $('#editReqItem').DataTable().ajax.reload();
                        $("#reqremovemodal").modal('hide');
                        $('#numberofItems').val(data.Totalcount);
                        $('#deletereqbtn').prop("disabled", false);
                    }
                });
            }
        });
        //Delete requisition Item Records Ends

        //Open Delete Modal With Value Ends
        function voidreqdata(recordId){
            var fysetting="";
            var fyearstr="";
            $('#delidi').val(recordId);
            $('.Reason').val("");
            $.get("/requisitionedit" + '/' + recordId, function(data) {
                var statusvals = data.recData.Status;
                var fiscalyrreq = data.recData.fiscalyear;
                fysetting=data.fyear;
                fyearstr=data.fyearstr;
                // if(parseFloat(fiscalyrreq)!=parseFloat(fyearstr)){
                //     toastrMessage('error',"You cant void a closed fiscal year transaction","Error");
                // }
                if (statusvals === "Draft"||statusvals === "Pending"||statusvals === "Approved"||statusvals === "Issued") {
                    $("#deletereq").modal('show');
                } else {
                    toastrMessage('error',"You cant void on this status","Error");
                    var oTable = $('#laravel-datatable-crud').dataTable();
                    oTable.fnDraw(false);
                }
            });
        }

        //Start append item dynamically 
        $("#adds").click(function() {
            var it=0;
            var storeidvar = $('#sstore').val();
            var desstoreidvar = $('#dstore').val();
            var lastrowcount=$('#dynamicTable tr:last').find('td').eq(13).find('input').val();
            var itemids=$('#itemNameSl'+lastrowcount).val();
            if(isNaN(parseFloat(storeidvar))||storeidvar==null){
                toastrMessage('error',"Please select source store/shop first","Error");
                $('#sourcestore-error').html("The source store field is required.");
            }
            else if(itemids!==undefined && itemids===null){
                $('#select2-itemNameSl'+lastrowcount+'-container').parent().css('background-color',errorcolor);
                toastrMessage('error',"Please select item from highlighted field","Error");
            }
            else{
                ++i;
                j += 1;
                ++m;
                $("#dynamicTable").append('<tr><td style="font-weight:bold;width:3%;text-align:center;">'+j+'</td>'+
                    '<td style="width:27%;"><select id="itemNameSl'+m+'" onchange="itemVal(this)" class="select2 form-control form-control-lg itemName" name="row['+m+'][ItemId]"></select></td>'+
                    '<td style="width:12%;display:none;"><input type="text" name="row['+m+'][Code]" placeholder="Code" id="Code'+m+'" class="Code form-control" readonly="true"/></td>'+
                    '<td style="width:11%;"><input type="text" name="row['+m+'][UOM]" placeholder="UOM" id="uom'+m+'" class="uom form-control" readonly="true"/></td>'+
                    '<td style="width:15%;"><input type="text" name="row['+m+'][AvQuantity]" placeholder="Quantity On Hand" id="AvQuantity'+m+'" class="AvQuantity form-control" readonly="true"/></td>'+
                    '<td style="width:15%;"><input type="number" name="row['+m+'][Quantity]" onkeyup="checkQ(this)" ondrop="return false;" onpaste="return false;" placeholder="Quantity" id="quantity'+m+'" class="quantity form-control numeral-mask"/></td>'+
                    '<td style="width:26%;"><input type="text" name="row['+m+'][Memo]" id="Memo'+m+'" class="Memo form-control"/></td>'+
                    '<td style="width:3%;text-align:center;"><button type="button" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button><input type="hidden" name="row['+m+'][Common]" id="common'+m+'" class="common form-control" readonly="true" style="font-weight:bold;"/><input type="hidden" name="row['+m+'][StoreId]" id="storeid'+m+'" class="storeid form-control" readonly="true" style="font-weight:bold;"/></td>'+
                    '<td style="display:none;></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][ItemType]" id="ItemType'+m+'" class="ItemType form-control" readonly="true" style="font-weight:bold;"/></td>'+
                    '<td style="display:none;></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][DestStoreId]" id="desstoreid'+m+'" class="desstoreid form-control" readonly="true" style="font-weight:bold;" value="1"/></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][PartNumber]" placeholder="Part No." id="PartNumber'+m+'" class="PartNumber form-control" readonly="true"/></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][TransactionType]" id="TransactionType'+m+'" class="TransactionType form-control" readonly="true" value="Requisition" style="font-weight:bold;"/></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][UnitCost]" id="UnitCost'+m+'" class="UnitCost form-control" readonly="true" style="font-weight:bold;"/></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][idvals]" id="idval'+m+'" class="idval form-control" readonly="true" style="font-weight:bold;" value="'+m+'"/></td>'+
                '</tr>');

                renumberRows();
                var rnum = $('#commonVal').val();
                $('.common').val(rnum);
                $('.storeid').val(storeidvar);
                var opt = '<option selected disabled value=""></option>';
                var options = $("#allitems > option").clone();
                $('#itemNameSl'+m).append(options); 
                $("#itemNameSl"+m+" option[title!='"+storeidvar+"']").remove();
                $("itemNameSl"+m+" option[tabindex!='"+it+"']").remove();
                for(var k=1;k<=m;k++){
                    if(($('#itemNameSl'+k).val())!=undefined){
                        var selectedval=$('#itemNameSl'+k).val();
                        $("#itemNameSl"+m+" option[value='"+selectedval+"']").remove();   
                    }
                }
                $('#itemNameSl'+m).append(opt);
                $('#itemNameSl'+m).select2
                ({
                    placeholder: "Select item here",
                });
                $('#select2-itemNameSl'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
            }
        });
        //End append item dynamically

        //Start commodity append table
        $("#commadds").click(function() {
            var storeid=$('#sstore').val(); 
            var comptype=$('#CompanyType').val();
            var adjtype=$('#AdjustmentType').val();
            var customer=$('#Customer').val();
            var rectype=$('#ReceivingType').val();
            var lastrowcount=$('#commDynamicTable tr:last').find('td').eq(1).find('input').val();
            var floormap=$('#FloorMap'+lastrowcount).val();
            var commtype=$('#CommType'+lastrowcount).val();
            var origin=$('#Origin'+lastrowcount).val();
            var grade=$('#Grade'+lastrowcount).val();
            var processtype=$('#ProcessType'+lastrowcount).val();
            var cropyear=$('#CropYear'+lastrowcount).val();
            var valuesToKeep = [2,3];
            var borcolor="";
            if(isNaN(parseInt(storeid)) || isNaN(parseInt(comptype)) || adjtype == "" || (parseInt(comptype)==2 && isNaN(parseInt(customer))) ){
                if(isNaN(parseInt(storeid))){
                    $('#sourcestore-error').html("Station is required"); 
                }
                if(isNaN(parseInt(comptype))){
                    $('#comptype-error').html("Company type is required"); 
                }
                if(adjtype == ""){
                    $('#adjustmenttype-error').html("Adjustment type is required"); 
                }
                if (parseInt(comptype)==2 && isNaN(parseInt(customer))){
                    $('#customer-error').html("Customer is required"); 
                }
                toastrMessage('error',"Please fill all required fields","Error");
            }
            else if((floormap!==undefined && isNaN(parseFloat(floormap))) || (commtype!==undefined && isNaN(parseFloat(commtype))) || (origin!==undefined && isNaN(parseFloat(origin))) || (grade!==undefined && isNaN(parseFloat(grade))) || (processtype!==undefined && processtype=="") || (cropyear!==undefined && isNaN(parseFloat(cropyear)))){
                if(floormap!==undefined && isNaN(parseFloat(floormap))){
                    $('#select2-FloorMap'+lastrowcount+'-container').parent().css('background-color',errorcolor);
                }
                if(commtype!==undefined && isNaN(parseFloat(commtype))){
                    $('#select2-CommType'+lastrowcount+'-container').parent().css('background-color',errorcolor);
                }
                if(origin!==undefined && isNaN(parseFloat(origin))){
                    $('#select2-Origin'+lastrowcount+'-container').parent().css('background-color',errorcolor);
                }
                if(grade!==undefined && isNaN(parseFloat(grade))){
                    $('#select2-Grade'+lastrowcount+'-container').parent().css('background-color',errorcolor);
                }
                if(processtype!==undefined && processtype==""){
                    $('#select2-ProcessType'+lastrowcount+'-container').parent().css('background-color',errorcolor);
                }
                if(cropyear!==undefined && isNaN(parseFloat(cropyear))){
                    $('#select2-CropYear'+lastrowcount+'-container').parent().css('background-color',errorcolor);
                }
                toastrMessage('error',"Please fill all required fields","Error");
            }
            else{
                ++i2;
                ++m2;
                ++j2;

                if(parseInt(j2) % 2 === 0){
                    borcolor="#F8F9FA";
                }
                else{
                    borcolor="#FFFFFF";
                }

                $("#commDynamicTable > tbody").append('<tr id="rowind'+m2+'" class="mb-1" style="background-color:'+borcolor+';"><td style="width:2%;text-align:left;vertical-align: top;">'+
                    '<span class="badge badge-center rounded-pill bg-secondary">'+j2+'</span>'+
                '</td>'+
                '<td style="display:none;"><input type="hidden" name="row['+m2+'][vals]" id="vals'+m2+'" class="vals form-control" readonly="true" style="font-weight:bold;" value="'+m2+'"/></td>'+
                '<td style="width:96%;">'+
                    '<div class="row">'+
                        '<div class="col-xl-7 col-md-6 col-lg-6" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">'+
                            '<div class="row">'+
                                '<div class="col-xl-2 col-md-4 col-lg-3 mb-1">'+
                                    '<label style="font-size: 12px;">Reason</label><label style="color: red; font-size:16px;">*</label>'+
                                    '<select id="Reason'+m2+'" class="select2 form-control Reason" onchange="reasonFn(this)" name="row['+m2+'][Reason]"></select>'+
                                '</div>'+
                                '<div class="col-xl-2 col-md-4 col-lg-3 mb-1">'+
                                    '<label style="font-size: 12px;">Floor Map</label><label style="color: red; font-size:16px;">*</label>'+
                                    '<select id="FloorMap'+m2+'" class="select2 form-control FloorMap" onchange="FloorMapFn(this)" name="row['+m2+'][FloorMap]"></select>'+
                                '</div>'+
                                '<div class="col-xl-3 col-md-4 col-lg-3 mb-1">'+
                                    '<label style="font-size: 12px;">Type</label><label style="color: red; font-size:16px;">*</label>'+
                                    '<select id="CommType'+m2+'" class="select2 form-control CommType" onchange="CommTypeFn(this)" name="row['+m2+'][CommType]"></select>'+
                                '</div>'+
                                '<div class="col-xl-3 col-md-4 col-lg-4 mb-1 typedt typeprop'+m2+'" id="supplierdiv'+m2+'" style="display:none;">'+
                                    '<label style="font-size: 12px;">Supplier</label><label style="color: red; font-size:16px;">*</label>'+
                                    '<select id="Supplier'+m2+'" class="select2 form-control Supplier" onchange="SupplierFn(this)" name="row['+m2+'][Supplier]"></select>'+
                                '</div>'+
                                '<div class="col-xl-2 col-md-4 col-lg-4 mb-1 typedt typeprop'+m2+'" id="grndiv'+m2+'" style="display:none;">'+
                                    '<label style="font-size: 12px;">GRN No.</label><label style="color: red; font-size:16px;">*</label>'+
                                    '<select id="GrnNumber'+m2+'" class="select2 form-control GrnNumber" onchange="GrnNumberFn(this)" name="row['+m2+'][GrnNumber]"></select>'+
                                '</div>'+
                                '<div class="col-xl-3 col-md-4 col-lg-4 mb-1 typedt typeprop'+m2+'" id="productiondiv'+m2+'" style="display:none;">'+
                                    '<label style="font-size: 12px;">Production Order , Cert No.</label><label style="color: red; font-size:16px;">*</label>'+
                                    '<select id="ProductionNum'+m2+'" class="select2 form-control ProductionNum" onchange="ProductionNumFn(this)" name="row['+m2+'][ProductionNum]"></select>'+
                                '</div>'+
                                '<div class="col-xl-2 col-md-4 col-lg-4 mb-1 typedt typeprop'+m2+'" id="cernumdiv'+m2+'" style="display:none;">'+
                                    '<label style="font-size: 12px;">Certificate No.</label><label style="color: red; font-size:16px;">*</label>'+
                                    '<select id="CertificateNum'+m2+'" class="select2 form-control CertificateNum" onchange="CertificateNumFn(this)" name="row['+m2+'][CertificateNum]"></select>'+
                                '</div>'+
                                '<div class="col-xl-2 col-md-4 col-lg-4 mb-1 expcertcls exptypeprop'+m2+'" id="expcernumdiv'+m2+'" style="display:none;">'+
                                    '<label style="font-size: 12px;">Export Certificate No.</label>'+
                                    '<input type="number" name="row['+m2+'][ExpCertificateNum]" placeholder="Write Export Certificate Number here" id="ExpCertificateNum'+m2+'" class="ExpCertificateNum form-control commnuminp" onkeyup="ExpCertificateNumFn(this)" onblur="ExpCertificateNumBlFn(this)" onkeypress="return ValidateOnlyNum(event);"/>'+
                                '</div>'+
                            '</div>'+
                            '<div class="row">'+
                                '<div class="col-xl-3 col-md-4 col-lg-4 mb-1">'+
                                    '<label style="font-size: 12px;">Commodity</label><label style="color: red; font-size:16px;">*</label>'+
                                    '<select id="Origin'+m2+'" class="select2 form-control Origin" onchange="OriginFn(this)" name="row['+m2+'][Origin]"></select>'+
                                '</div>'+

                                '<div class="col-xl-2 col-md-4 col-lg-4 mb-1">'+
                                    '<label style="font-size: 12px;">Grade</label><label style="color: red; font-size:16px;">*</label>'+
                                    '<select id="Grade'+m2+'" class="select2 form-control Grade" onchange="GradeFn(this)" name="row['+m2+'][Grade]"></select>'+
                                '</div>'+
                            
                                '<div class="col-xl-2 col-md-4 col-lg-4 mb-1">'+
                                    '<label style="font-size: 12px;">Process Type</label><label style="color: red; font-size:16px;">*</label>'+
                                    '<select id="ProcessType'+m2+'" class="select2 form-control ProcessType" onchange="ProcessTypeFn(this)" name="row['+m2+'][ProcessType]"></select>'+
                                '</div>'+
                                '<div class="col-xl-2 col-md-4 col-lg-4 mb-1">'+
                                    '<label style="font-size: 12px;">Crop Year</label><label style="color: red; font-size:16px;">*</label>'+
                                    '<select id="CropYear'+m2+'" class="select2 form-control CropYear" onchange="CropYearFn(this)" name="row['+m2+'][CropYear]"></select>'+
                                '</div>'+
                                '<div class="col-xl-3 col-md-4 col-lg-4 mb-1">'+
                                    '<label style="font-size: 12px;">Remark</label>'+
                                    '<textarea type="text" placeholder="Write Remark here..." class="Remark form-control mainforminp" rows="1" name="row['+m2+'][Remark]" id="Remark'+m2+'"></textarea>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-xl-5 col-md-6 col-lg-6">'+
                            '<div class="row">'+
                                '<div class="col-xl-3 col-md-4 col-lg-4 mb-1">'+
                                    '<label style="font-size: 12px;">UOM/Bag</label><label style="color: red; font-size:16px;">*</label>'+
                                    '<select id="Uom'+m2+'" class="select2 form-control Uom" onchange="UomFn(this)" name="row['+m2+'][Uom]"></select>'+
                                '</div>'+
                                '<div class="col-xl-2 col-md-4 col-lg-4 mb-0">'+
                                    '<label style="font-size: 12px;">No. of Bag</label><label style="color: red; font-size:16px;">*</label>'+
                                    '<input type="number" name="row['+m2+'][NumOfBag]" placeholder="Write Number of bag here" id="NumOfBag'+m2+'" class="NumOfBag form-control numeral-mask commnuminp" onkeyup="NumOfBagFn(this)" step="any" onkeypress="return ValidateOnlyNum(event);"/>'+
                                '</div>'+
                                '<div class="col-xl-3 col-md-4 col-lg-4 mb-0">'+
                                    '<label style="font-size: 12px;">Bag Weight by KG</label><label style="color: red; font-size:16px;">*</label>'+
                                    '<input type="number" name="row['+m2+'][TotalBagWeight]" placeholder="Bag weight" id="TotalBagWeight'+m2+'" class="TotalBagWeight form-control numeral-mask commnuminp" onkeyup="BagWeightFn(this)" step="any" readonly onkeypress="return ValidateNum(event);" style="font-weight:bold;"/>'+
                                '</div>'+
                                '<div class="col-xl-4 col-md-4 col-lg-4 mb-1">'+
                                    '<label style="font-size: 12px;" class="qtyonhandcls">Qty. on Hand</label>'+
                                    '<div class="row qtyonhandcls" style="border: 0.1px solid #d9d7ce;">'+
                                        '<div class="col-xl-6 col-md-6 col-lg-6">'+
                                            '<label style="font-size: 11px;">No. of Bag</label>'+
                                        '</div>'+
                                        '<div class="col-xl-6 col-md-6 col-lg-6">'+
                                            '<b><label id="avqtybyuom'+m2+'" class="qtydata" style="font-size: 11px;"></label></b>'+
                                        '</div>'+
                                        '<div class="col-xl-6 col-md-6 col-lg-6">'+
                                            '<label style="font-size: 11px;">Weight by KG</label>'+
                                        '</div>'+
                                        '<div class="col-xl-6 col-md-6 col-lg-6">'+
                                            '<b><label id="avqtybykg'+m2+'" class="qtydata" style="font-size: 11px;"></label></b>'+
                                        '</div>'+
                                        '<div class="col-xl-6 col-md-6 col-lg-6 mb-0" style="text-align:left;">'+
                                            '<label style="font-size: 11px;" id="reqferesulalbl'+m2+'">Feresula</label>'+
                                        '</div>'+ 
                                        '<div class="col-xl-6 col-md-6 col-lg-6 mb-0" style="text-align:left;">'+
                                            '<label style="font-size: 11px;font-weight:bold;" id="reqferesula'+m2+'" class="qtydata"></label>'+
                                        '</div>'+ 
                                    '</div>'+
                                '</div>'+

                                '<div class="col-xl-3 col-md-3 col-lg-3">'+
                                    '<label style="font-size: 12px;">Total KG</label><label style="color: red; font-size:16px;">*</label>'+
                                    '<input type="number" name="row['+m2+'][TotalKg]" placeholder="Write total kg here..." id="TotalKg'+m2+'" class="TotalKg form-control numeral-mask commnuminp" onkeyup="TotalKgFn(this)" onkeypress="return ValidateNum(event);" step="any"/>'+
                                '</div>'+
                                '<div class="col-xl-3 col-md-3 col-lg-3">'+
                                    '<label style="font-size: 12px;">Net KG</label><label style="color: red; font-size:16px;">*</label>'+
                                    '<input type="number" name="row['+m2+'][NetKg]" placeholder="Write Net KG here..." id="NetKg'+m2+'" class="NetKg form-control numeral-mask commnuminp" onkeyup="NetKgFn(this)" onkeypress="return ValidateNum(event);" step="any"/>'+
                                '</div>'+
                                '<div class="col-xl-2 col-md-2 col-lg-2">'+
                                    '<label style="font-size: 12px;">Feresula<i class="fa-solid fa-circle-info" title="Net KG / 17"></i></label>'+
                                    '<input type="number" name="row['+m2+'][Feresula]" placeholder="Write Feresula here..." id="Feresula'+m2+'" class="Feresula form-control numeral-mask commnuminp" onkeypress="return ValidateNum(event);" step="any"/>'+
                                '</div>'+
                                '<div class="col-xl-4 col-md-4 col-lg-4">'+
                                    '<label style="font-size: 12px;" class="unit_cost_price_cls">Unit Cost</label>'+
                                    '<input type="number" name="row['+m2+'][UnitCost]" placeholder="Write here..." id="UnitCost'+m2+'" class="UnitCost form-control numeral-mask commnuminp" onkeyup="unitCostFn(this)" onkeypress="return ValidateNum(event);" step="any"/>'+
                                '</div>'+
                                
                                '<div class="col-xl-3 col-md-3 col-lg-3 mb-0"></div>'+
                                '<div class="col-xl-5 col-md-5 col-lg-5 mb-0">'+
                                    '<label style="font-size: 12px;font-weight:bold;" class="variancecls" id="varianceLbl'+m2+'"></label>'+
                                '</div>'+
                                '<div class="col-xl-4 col-md-4 col-lg-4 mb-0">'+
                                    '<label style="font-size: 12px;font-weight:bold;" class="totalcostcls" id="totalcostLbl'+m2+'"></label>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                '</td>'+
                '<td style="width:2%;text-align:right;vertical-align: top;">'+
                    '<button type="button" id="commremovebtn'+m2+'" class="btn btn-light btn-sm commremove-tr" style="color:#ea5455;background-color:'+borcolor+';border-color:'+borcolor+';padding: 4px 5px;"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button>'+
                '</td>'+
                '<td style="display:none;"><input type="number" name="row['+m2+'][TotalCost]" placeholder="Total Cost" id="TotalCost'+m2+'" class="TotalCost form-control numeral-mask commnuminp" readonly onkeypress="return ValidateNum(event);" style="font-weight:bold;"/></td>'+
                '<td style="display:none;"><input type="number" name="row['+m2+'][QtyOnHand]" placeholder="Quantity on Hand" id="QtyOnHand'+m2+'" class="QtyOnHand form-control numeral-mask commnuminp" readonly onkeypress="return ValidateNum(event);" style="font-weight:bold;"/></td>'+
                '<td style="display:none;"><input type="number" name="row['+m2+'][QtyOnHandByKg]" placeholder="Quantity on Hand" id="QtyOnHandByKg'+m2+'" class="QtyOnHandByKg form-control numeral-mask commnuminp" readonly onkeypress="return ValidateNum(event);" style="font-weight:bold;"/></td>'+
                '<td style="display:none;"><input type="number" name="row['+m2+'][remBagNum]" id="remBagNum'+m2+'" class="remBagNum form-control numeral-mask" style="font-weight:bold;" step="any" readonly/></td>'+
                '<td style="display:none;"><input type="number" name="row['+m2+'][remKg]" id="remKg'+m2+'" class="remKg form-control numeral-mask" style="font-weight:bold;" step="any" readonly/></td>'+
                '<td style="display:none;"><input type="number" name="row['+m2+'][bagWeight]" id="bagWeight'+m2+'" class="bagWeight form-control numeral-mask" style="font-weight:bold;" step="any" readonly/></td>'+
                '<td style="display:none;"><input type="number" name="row['+m2+'][uomFactor]" id="uomFactor'+m2+'" class="uomFactor form-control numeral-mask" style="font-weight:bold;" step="any" readonly/></td>'+
                '<td style="display:none;"><input type="number" name="row['+m2+'][varianceshortage]" id="varianceshortage'+m2+'" class="varianceshortage form-control numeral-mask" style="font-weight:bold;" step="any" readonly/></td>'+
                '<td style="display:none;"><input type="number" name="row['+m2+'][varianceoverage]" id="varianceoverage'+m2+'" class="varianceoverage form-control numeral-mask" style="font-weight:bold;" step="any" readonly/></td>'+
                '<td style="display:none;"><input type="hidden" name="row['+m2+'][id]" id="id'+m2+'" class="id form-control" readonly="true" style="font-weight:bold;"/></td>'+
                '</tr>');
                
                var defaultoption = '<option selected value=""></option>';
                var commtypeoptions = $("#commtypedefault > option").clone();
                var resoption = "";
                $('#CommType'+m2).append(commtypeoptions);
                
                $('#CommType'+m2).append(defaultoption);
                $('#CommType'+m2).select2
                ({
                    placeholder: "Select here",
                    dropdownCssClass : 'cusmidprp',
                });         
                
                $('#Grade'+m2).select2
                ({
                    placeholder: "Select Commodity first",
                    dropdownCssClass : 'cusprop',
                    minimumResultsForSearch: -1
                });

                $('#ProcessType'+m2).select2
                ({
                    placeholder: "Select Process type here",
                    dropdownCssClass : 'cusprop',
                    minimumResultsForSearch: -1
                });

                $('#CropYear'+m2).select2
                ({
                    placeholder: "Select Crop year here",
                    dropdownCssClass : 'cusprop',
                    minimumResultsForSearch: -1
                });
            
                $('#Uom'+m2).select2
                ({
                    placeholder: "Select UOM/Bag here",
                    dropdownCssClass : 'cusprop',
                    minimumResultsForSearch: -1
                });

                if(adjtype == "Increase"){
                    $('.qtyonhandcls').hide();
                    resoption = "inc";
                    $('.UnitCost').prop("readonly",false);
                    $('.unit_cost_price_cls').html("Unit Price");
                    $('.total_cost_price_cls').html("Total Price");
                }
                if(adjtype == "Decrease"){
                    $('.qtyonhandcls').show();
                    resoption = "dec";
                    $('.UnitCost').prop("readonly",true);
                    $('.unit_cost_price_cls').html("Unit Cost");
                    $('.total_cost_price_cls').html("Total Cost");
                }

                var reasonopt = $("#reasondefault > option").clone();
                $('#Reason'+m2).append(reasonopt);

                $("#Reason"+m2+" option[data-type!="+resoption+"]").remove(); 
                $('#Reason'+m2).append(defaultoption);
                $('#Reason'+m2).select2
                ({
                    placeholder: "Select reason here",
                    dropdownCssClass : 'cusprop',
                });

                var floormapopt = $("#locationdefault > option").clone();
                $('#FloorMap'+m2).append(floormapopt);
                $("#FloorMap"+m2+" option[title!="+storeid+"]").remove(); 
                $('#FloorMap'+m2).append(defaultoption);
                $('#FloorMap'+m2).select2
                ({
                    placeholder: "Select Floor map here",
                    dropdownCssClass : 'cusprop',
                });

               
                $('#Origin'+m2).select2
                ({
                    placeholder: "Select Type here",
                    minimumResultsForSearch: -1
                });

                $('#CertificateNum'+m2).select2
                ({
                    placeholder: "Select Certificate number here",
                    minimumResultsForSearch: -1
                });

                $('#GrnNumber'+m2).select2
                ({
                    placeholder: "Select Supplier first",
                    minimumResultsForSearch: -1
                });
                
                if(parseInt(rectype)==1){
                    $('#podatatbl'+m2).hide();
                }
                else if(parseInt(rectype)==2){
                    $('#podatatbl'+m2).show();
                }

                $('#Feresula'+m2).prop("readonly",true);
                $('#NumOfBag'+m2).prop("readonly",true);
                $('#NetKg'+m2).prop("readonly",false);
                CalculateCommTotal();
                commRenumberRows();
                $('#select2-FloorMap'+m2+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                $('#select2-CommType'+m2+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                $('#select2-Origin'+m2+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                $('#select2-Grade'+m2+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                $('#select2-ProcessType'+m2+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                $('#select2-CropYear'+m2+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                $('#select2-Uom'+m2+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
            }
        });  
        //End commodity append table

        $(document).on('click', '.commremove-tr', function() {
            $(this).parents('tr').remove();
            CalculateCommTotal();
            commRenumberRows();
            --i2;
        });

        function commRenumberRows() {
            var ind=0;
            $('#commDynamicTable > tbody > tr').each(function(index, el) {
                $(this).children('td').first().html('<span class="badge badge-center rounded-pill bg-secondary">'+(++index)+'</span>');
                ind = index;
            });
            if (ind == 0) {
               $('#commTotalTable').hide();
            } else {
                $('#commTotalTable').show();
            }
            $('#commadds').show();
        }

        function reasonFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            $('#select2-Reason'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
        }

        function FloorMapFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            var floormap=$('#FloorMap'+idval).val();
            var commtype=$('#CommType'+idval).val()||0;
            var supplierdata=$('#Supplier'+idval).val();
            var grndata=$('#GrnNumber'+idval).val();
            var productionnum=$('#ProductionNum'+idval).val();
            var certnumdata=$('#CertificateNum'+idval).val();
            var origin=$('#Origin'+idval).val()||0;
            var grade=$('#Grade'+idval).val()||0;
            var processtype=$('#ProcessType'+idval).val();
            var cropyear=$('#CropYear'+idval).val()||0;
            var uomid=$('#Uom'+idval).val();
            var expcertnum=$('#ExpCertificateNum'+idval).val();
            
            var floormapcnt=0;
            var floormapcntB=0;
            var rejcnt=0;
            for(var k=1;k<=m2;k++){
                if(($('#FloorMap'+k).val())!=undefined){
                    if((parseInt($('#CommType'+k).val()) == parseInt(commtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && (parseInt($('#Uom'+k).val()) == parseInt(uomid)) && ($('#Supplier'+k).val() == parseInt(supplierdata)) && ($('#GrnNumber'+k).val() == grndata) && (!isNaN(parseInt($('#Supplier'+k).val()))) && ($('#GrnNumber'+k).val() != null)){
                        floormapcnt+=1;
                    }
                    if((parseInt($('#CommType'+k).val()) == parseInt(commtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && (parseInt($('#Uom'+k).val()) == parseInt(uomid)) && ($('#CertificateNum'+k).val() == certnumdata) && ($('#CertificateNum'+k).val() != "") && ($('#ProductionNum'+k).val() == productionnum) && ($('#ProductionNum'+k).val() != "") && (expcertnum!="" && $('#ExpCertificateNum'+k).val() == expcertnum)){
                        floormapcntB+=1;
                    }
                    if((parseInt($('#CommType'+k).val()) == parseInt(defaultrejtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && (parseInt($('#Uom'+k).val()) == parseInt(uomid))){
                        rejcnt+=1;
                    }
                }
            }

            if(parseInt(floormapcnt)<=1 && parseInt(floormapcntB)<=1 && parseInt(rejcnt)<=1){
                $('#select2-FloorMap'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
            }
            else if(parseInt(floormapcnt)>1 || parseInt(floormapcntB)>1 || parseInt(rejcnt)>1){
                $('#FloorMap'+idval).val(null).trigger('change').select2
                ({
                    placeholder: "Select Floor map here",
                });
                $('#select2-FloorMap'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                toastrMessage('error',"Floor map is selected with all property","Error");
            }

            if(parseInt(commtype)==1){
                if(parseInt(floormap)>0 && parseInt(commtype)>0 && parseInt(origin)>0 && grade!="" && processtype!="" && cropyear!="" && parseInt(uomid)>0 && parseInt(supplierdata)>0 && grndata!=""){
                    calcQtyOnHand(idval);
                }
            }
            else if(parseInt(commtype)==2 || parseInt(commtype)==4 || parseInt(commtype)==5 || parseInt(commtype)==6){
                if(parseInt(floormap)>0 && parseInt(commtype)>0 && parseInt(origin)>0 && grade!="" && processtype!="" && cropyear!="" && parseInt(uomid)>0 && certnumdata!="" && productionnum!=""){
                    calcQtyOnHand(idval);
                }
            }
            else if(parseInt(commtype)==3){
                if(parseInt(floormap)>0 && parseInt(commtype)>0 && parseInt(origin)>0 && grade!="" && processtype!="" && cropyear!="" && parseInt(uomid)>0){
                    calcQtyOnHand(idval);
                }
            }
        }

        function CommTypeFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            var reqreason=$('#RequestReason').val();
            var floormap=$('#FloorMap'+idval).val();
            var commtype=$('#CommType'+idval).val()||0;
            var supplierdata=$('#Supplier'+idval).val();
            var grndata=$('#GrnNumber'+idval).val();
            var productionnum=$('#ProductionNum'+idval).val();
            var certnumdata=$('#CertificateNum'+idval).val();
            var origin=$('#Origin'+idval).val()||0;
            var grade=$('#Grade'+idval).val()||0;
            var processtype=$('#ProcessType'+idval).val();
            var cropyear=$('#CropYear'+idval).val()||0;
            var uomid=$('#Uom'+idval).val();
            var expcertnum=$('#ExpCertificateNum'+idval).val();
            var originoptions="";
            $('#expcernumdiv'+idval).hide();
            $('#ExpCertificateNum'+idval).val("");
            var cusorowner=0;
            var compType=$('#CompanyType').val();
            if(parseInt(compType)==1){
                customersId=1;
                cusorowner=1;
            }
            else if(parseInt(compType)==2){
                cusorowner=$('#Customer').val();
            }
            var mergeddata=commtype+""+cusorowner;
            
            var commtypecnt=0;
            var commtypecntB=0;
            var rejcnt=0;

            for(var k=1;k<=m2;k++){
                if(($('#CommType'+k).val())!=undefined){
                    if((parseInt($('#CommType'+k).val()) == parseInt(commtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && (parseInt($('#Uom'+k).val()) == parseInt(uomid)) && ($('#Supplier'+k).val() == parseInt(supplierdata)) && ($('#GrnNumber'+k).val() == grndata) && (!isNaN(parseInt($('#Supplier'+k).val()))) && ($('#GrnNumber'+k).val() != null)){
                        commtypecnt+=1;
                    }
                    if((parseInt($('#CommType'+k).val()) == parseInt(commtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && (parseInt($('#Uom'+k).val()) == parseInt(uomid)) && ($('#CertificateNum'+k).val() == certnumdata) && ($('#CertificateNum'+k).val() != "") && ($('#ProductionNum'+k).val() == productionnum) && ($('#ProductionNum'+k).val() != "") && (expcertnum!="" && $('#ExpCertificateNum'+k).val() == expcertnum)){
                        commtypecntB+=1;
                    }
                    if((parseInt($('#CommType'+k).val()) == parseInt(defaultrejtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && (parseInt($('#Uom'+k).val()) == parseInt(uomid))){
                        rejcnt+=1;
                    }
                }
            }

            if(parseInt(commtypecnt)<=1 && parseInt(commtypecntB)<=1 && parseInt(rejcnt)<=1){
                var defaultoption = '<option selected value=""></option>';
                $('#Origin'+idval).empty();
                if(parseInt(commtype)==3){
                    originoptions = $("#rejoriginexpdefault > option").clone();
                }
                else{
                    originoptions = $("#originexpdefault > option").clone();
                }
                $('#Origin'+idval).append(originoptions);
                $('.typeprop'+idval).hide();

                var supplierdata = $("#supplierdefault > option").clone();
                $('#CertificateNum'+idval).empty();
                $('#ProductionNum'+idval).empty();
                if(parseInt(commtype)==1){
                    $('#supplierdiv'+idval).show();
                    $('#grndiv'+idval).show();
                    $('#CertificateNum'+idval).val("");
                    $('#CertificateNum'+idval).css("background","white");
                    $('#ProductionNum'+idval).val("");
                    $('#ProductionNum'+idval).css("background","white");
                    $("#Origin"+idval+" option[title!=1]").remove(); 
                    $('#Supplier'+idval).empty();
                    $('#Supplier'+idval).append(supplierdata);
                    $("#Supplier"+idval+" option[title!="+mergeddata+"]").remove(); 
                    $('#Supplier'+idval).append(defaultoption);
                    $('#Supplier'+idval).select2
                    ({
                        placeholder: "Select Supplier here",
                        dropdownCssClass : 'cusmidprp',
                    });
                    if(parseInt(reqreason)==3){
                        $('#expcernumdiv'+idval).show();
                    }
                }
                else if(parseInt(commtype)==2 || parseInt(commtype)==4 || parseInt(commtype)==5 || parseInt(commtype)==6){
                    $('#cernumdiv'+idval).show();
                    $('#productiondiv'+idval).show();
                    $('#Supplier'+idval).val(null).select2({
                        placeholder:"Select Supplier here",
                        dropdownCssClass : 'commprp',
                    });
                    $('#GrnNumber'+idval).val("");
                    $('#GrnNumber'+idval).css("background","white");
                    $('#select2-Supplier'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
                    $("#Origin"+idval+" option[title!=2]").remove(); 
                    $('#Supplier'+idval).append(supplierdata);
                    $("#Supplier"+idval+" option[title!="+mergeddata+"]").remove(); 
                    $('#Supplier'+idval).append(defaultoption);
                    $('#Supplier'+idval).select2
                    ({
                        placeholder: "Select Supplier here",
                        dropdownCssClass : 'cusmidprp',
                    });
                    
                    if(parseInt(reqreason)==3){
                        $('#expcernumdiv'+idval).show();
                    }
                }
                else if(parseInt(commtype)==3){
                    $('#CertificateNum'+idval).empty();
                    $('#ProductionNum'+idval).empty();
                    $('#cernumdiv'+idval).hide();
                    $('#productiondiv'+idval).hide();
                    $('#Supplier'+idval).val(null).select2({
                        placeholder:"Select Supplier here",
                        dropdownCssClass : 'commprp',
                    });
                    $('#GrnNumber'+idval).val("");
                    $('#GrnNumber'+idval).css("background","white");
                    $('#select2-Supplier'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
                    $("#Origin"+idval+" option[title!=3]").remove(); 
                    if(parseInt(reqreason)==3){
                        $('#expcernumdiv'+idval).show();
                    }
                }

                $('#Origin'+idval).append(defaultoption);
                $('#Origin'+idval).select2
                ({
                    placeholder: "Select Commodity here",
                    dropdownCssClass : 'commprp',
                });

                $('#ProductionNum'+idval).empty();
                var prdorderopt = $("#productionorderdefault > option").clone();
                $('#ProductionNum'+idval).append(prdorderopt);
                $("#ProductionNum"+idval+" option[title!="+cusorowner+"]").remove(); 
                $('#ProductionNum'+idval).append(defaultoption);
                $('#ProductionNum'+idval).select2
                ({
                    placeholder: "Select Production order number here",
                    dropdownCssClass : 'cusprop',                    
                });

                $('#select2-CommType'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
                $('#select2-Grade'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
                $('#select2-ProcessType'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
                $('#select2-CropYear'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
            }
            else if(parseInt(commtypecnt)>1 || parseInt(commtypecntB)>1 || parseInt(rejcnt)>1){
                $('#CommType'+idval).val(null).trigger('change').select2
                ({
                    placeholder: "Select here...",
                    minimumResultsForSearch: -1
                });
                $('#select2-CommType'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                toastrMessage('error',"Commodity Type is selected with all property","Error");
            }

            if(parseInt(commtype)==1){
                if(parseInt(floormap)>0 && parseInt(commtype)>0 && parseInt(origin)>0 && grade!="" && processtype!="" && cropyear!="" && parseInt(uomid)>0 && parseInt(supplierdata)>0 && grndata!=""){
                    calcQtyOnHand(idval);
                }
            }
            else if(parseInt(commtype)==2 || parseInt(commtype)==4 || parseInt(commtype)==5 || parseInt(commtype)==6){
                if(parseInt(floormap)>0 && parseInt(commtype)>0 && parseInt(origin)>0 && grade!="" && processtype!="" && cropyear!="" && parseInt(uomid)>0 && certnumdata!="" && productionnum!=""){
                    calcQtyOnHand(idval);
                }
            }
            else if(parseInt(commtype)==3){
                if(parseInt(floormap)>0 && parseInt(commtype)>0 && parseInt(origin)>0 && grade!="" && processtype!="" && cropyear!="" && parseInt(uomid)>0){
                    calcQtyOnHand(idval);
                }
            }
        }

        function ProductionNumFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            var floormap=$('#FloorMap'+idval).val();
            var commtype=$('#CommType'+idval).val()||0;
            var supplierdata=$('#Supplier'+idval).val();
            var grndata=$('#GrnNumber'+idval).val();
            var productionnum=$('#ProductionNum'+idval).val();
            var certnumdata=$('#CertificateNum'+idval).val();
            var origin=$('#Origin'+idval).val()||0;
            var grade=$('#Grade'+idval).val()||0;
            var processtype=$('#ProcessType'+idval).val();
            var cropyear=$('#CropYear'+idval).val()||0;
            var uomid=$('#Uom'+idval).val();
            var expcertnum=$('#ExpCertificateNum'+idval).val();

            var prddoc="";
            var mergeddata="";
            var prdnumbercnt=0;
            var prdnumbercntB=0;
            var origindata="";
            for(var k=1;k<=m2;k++){
                if(($('#ProductionNum'+k).val())!=undefined){
                    if((parseInt($('#CommType'+k).val()) == parseInt(commtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && (parseInt($('#Uom'+k).val()) == parseInt(uomid)) && ($('#Supplier'+k).val() == parseInt(supplierdata)) && ($('#GrnNumber'+k).val() == grndata) && (!isNaN(parseInt($('#Supplier'+k).val()))) && ($('#GrnNumber'+k).val() != null)){
                        prdnumbercnt+=1;
                    }
                    if((parseInt($('#CommType'+k).val()) == parseInt(commtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && (parseInt($('#Uom'+k).val()) == parseInt(uomid)) && ($('#CertificateNum'+k).val() == certnumdata) && ($('#CertificateNum'+k).val() != "") && ($('#ProductionNum'+k).val() == productionnum) && ($('#ProductionNum'+k).val() != "") && (expcertnum!="" && $('#ExpCertificateNum'+k).val() == expcertnum)){
                        prdnumbercntB+=1;
                    }
                }
            }
            if(parseInt(prdnumbercnt)<=1 && parseInt(prdnumbercntB)<=1){
                var defaultoption = '<option selected value=""></option>';
                var emptycertnum = '<option value="-">-</option>';
                $('#select2-ProductionNum'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
                
                $('#CertificateNum'+idval).empty();
                var certnumberdata = $("#certNumberdefault > option").clone();
                prddoc = $('#ProductionNum'+idval+' option[value="' + productionnum + '"]').attr('label');
                $('#CertificateNum'+idval).append(certnumberdata);
                $("#CertificateNum"+idval+" option[title!='"+prddoc+"']").remove(); 
                $('#CertificateNum'+idval).append(emptycertnum);
                $('#CertificateNum'+idval).append(defaultoption);
                $('#CertificateNum'+idval).select2
                ({
                    placeholder: "Select Certificate number here",
                });
                $('#ExpCertificateNum'+idval).val("");

                mergeddata=commtype+prddoc;
                $('#Origin'+idval).empty();
                origindata = $("#originexpdefault > option").clone();
                $('#Origin'+idval).append(origindata);
                $("#Origin"+idval+" option[title!='"+mergeddata+"']").remove(); 
                $('#Origin'+idval).append(defaultoption);
                $('#Origin'+idval).select2
                ({
                    placeholder: "Select Commodity here",
                });

                resetNumbers(idval);
                $('#select2-CertificateNum'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
                $('#select2-Origin'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
            }
            else if(parseInt(prdnumbercnt)>1 || parseInt(prdnumbercntB)>1){
                $('#ProductionNum'+idval).val(null).trigger('change').select2
                ({
                    placeholder: "Select Production Number here",
                    dropdownCssClass : 'commprp',
                });
                $('#select2-ProductionNum'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                toastrMessage('error',"Production Number is selected with all property","Error");
            }

            if(parseInt(commtype)==1){
                if(parseInt(floormap)>0 && parseInt(commtype)>0 && parseInt(origin)>0 && grade!="" && processtype!="" && cropyear!="" && parseInt(uomid)>0 && parseInt(supplierdata)>0 && grndata!=""){
                    calcQtyOnHand(idval);
                }
            }
            else if(parseInt(commtype)==2 || parseInt(commtype)==3 || parseInt(commtype)==4 || parseInt(commtype)==5 || parseInt(commtype)==6){
                if(parseInt(floormap)>0 && parseInt(commtype)>0 && parseInt(origin)>0 && grade!="" && processtype!="" && cropyear!="" && parseInt(uomid)>0 && certnumdata!="" && productionnum!=""){
                    calcQtyOnHand(idval);
                }
            }
        }

        function CertificateNumFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            var reqreason=$('#RequestReason').val();
            var floormap=$('#FloorMap'+idval).val();
            var commtype=$('#CommType'+idval).val()||0;
            var supplierdata=$('#Supplier'+idval).val();
            var grndata=$('#GrnNumber'+idval).val();
            var productionnum=$('#ProductionNum'+idval).val();
            var certnumdata=$('#CertificateNum'+idval).val();
            var origin=$('#Origin'+idval).val()||0;
            var grade=$('#Grade'+idval).val()||0;
            var processtype=$('#ProcessType'+idval).val();
            var cropyear=$('#CropYear'+idval).val()||0;
            var uomid=$('#Uom'+idval).val();
            var expcertnum=$('#ExpCertificateNum'+idval).val();
            var certnumbercnt=0;
            var certnumbercntB=0;
            for(var k=1;k<=m2;k++){
                if(($('#CertificateNum'+k).val())!=undefined){
                    if((parseInt($('#CommType'+k).val()) == parseInt(commtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && (parseInt($('#Uom'+k).val()) == parseInt(uomid)) && ($('#Supplier'+k).val() == parseInt(supplierdata)) && ($('#GrnNumber'+k).val() == grndata) && (!isNaN(parseInt($('#Supplier'+k).val()))) && ($('#GrnNumber'+k).val() != null)){
                        certnumbercnt+=1;
                    }
                    if((parseInt($('#CommType'+k).val()) == parseInt(commtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && (parseInt($('#Uom'+k).val()) == parseInt(uomid)) && ($('#CertificateNum'+k).val() == certnumdata) && ($('#CertificateNum'+k).val() != "") && ($('#ProductionNum'+k).val() == productionnum) && ($('#ProductionNum'+k).val() != "") && (expcertnum!="" && $('#ExpCertificateNum'+k).val() == expcertnum)){
                        certnumbercntB+=1;
                    }
                }
            }
            if(parseInt(certnumbercnt)<=1 && parseInt(certnumbercntB)<=1){
                $('#ExpCertificateNum'+idval).val("");
                if(parseInt(reqreason)==3 && certnumdata!=""){
                    $('#ExpCertificateNum'+idval).val(certnumdata);
                }
                $('#select2-CertificateNum'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
            }
            else if(parseInt(certnumbercnt)>1 || parseInt(certnumbercntB)>1){
                $('#CertificateNum'+idval).val(null).trigger('change').select2
                ({
                    placeholder: "Select Certificate number here",
                    dropdownCssClass : 'commprp',
                });
                $('#select2-CertificateNum'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                toastrMessage('error',"Certificate Number is selected with all property","Error");
            }

            if(parseInt(commtype)==1){
                if(parseInt(floormap)>0 && parseInt(commtype)>0 && parseInt(origin)>0 && grade!="" && processtype!="" && cropyear!="" && parseInt(uomid)>0 && parseInt(supplierdata)>0 && grndata!=""){
                    calcQtyOnHand(idval);
                }
            }
            else if(parseInt(commtype)==2 || parseInt(commtype)==3 || parseInt(commtype)==4 || parseInt(commtype)==5 || parseInt(commtype)==6){
                if(parseInt(floormap)>0 && parseInt(commtype)>0 && parseInt(origin)>0 && grade!="" && processtype!="" && cropyear!="" && parseInt(uomid)>0 && certnumdata!="" && productionnum!=""){
                    calcQtyOnHand(idval);
                }
            }
        }

        function getCertNumberListFn(rowid){
            var origin=$('#Origin'+rowid).val()||0;
            var commtype=$('#CommType'+rowid).val()||0;
            var grade=$('#Grade'+rowid).val()||0;
            var processtype=$('#ProcessType'+rowid).val();
            var cropyear=$('#CropYear'+rowid).val()||0;
            var prdnum=$('#ProductionNum'+rowid).val()||0;
            var customerid=$('#ratioCustomerId').val()||0;
            var mergedData=origin+grade+processtype+cropyear+customerid+commtype+prdnum;

            $('#CertificateNum'+rowid).empty();
            var certnumberdata = $("#certNumberdefault > option").clone();
            var defstore = '<option selected value=""></option>';
            $('#CertificateNum'+rowid).append(certnumberdata);
            $("#CertificateNum"+rowid+" option[title!="+mergedData+"]").remove(); 
            $('#CertificateNum'+rowid).append(defstore);
            $('#CertificateNum'+rowid).select2
            ({
                placeholder: "Select Certificate number here",
                dropdownCssClass : 'cusmidprp',
            });
            $('#select2-CertificateNum'+rowid+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});

        }

        function SupplierFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            var floormap=$('#FloorMap'+idval).val();
            var commtype=$('#CommType'+idval).val()||0;
            var supplierdata=$('#Supplier'+idval).val();
            var grndata=$('#GrnNumber'+idval).val();
            var productionnum=$('#ProductionNum'+idval).val();
            var certnumdata=$('#CertificateNum'+idval).val();
            var origin=$('#Origin'+idval).val()||0;
            var grade=$('#Grade'+idval).val()||0;
            var processtype=$('#ProcessType'+idval).val();
            var cropyear=$('#CropYear'+idval).val()||0;
            var uomid=$('#Uom'+idval).val();
            var expcertnum=$('#ExpCertificateNum'+idval).val();
            var suppliercnt=0;
            var suppliercntB=0;
            for(var k=1;k<=m2;k++){
                if(($('#Supplier'+k).val())!=undefined){
                    if((parseInt($('#CommType'+k).val()) == parseInt(commtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && (parseInt($('#Uom'+k).val()) == parseInt(uomid)) && ($('#Supplier'+k).val() == parseInt(supplierdata)) && ($('#GrnNumber'+k).val() == grndata) && (!isNaN(parseInt($('#Supplier'+k).val()))) && ($('#GrnNumber'+k).val() != null)){
                        suppliercnt+=1;
                    }
                    if((parseInt($('#CommType'+k).val()) == parseInt(commtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && (parseInt($('#Uom'+k).val()) == parseInt(uomid)) && ($('#CertificateNum'+k).val() == certnumdata) && ($('#CertificateNum'+k).val() != "") && ($('#ProductionNum'+k).val() == productionnum) && ($('#ProductionNum'+k).val() != "") && (expcertnum!="" && $('#ExpCertificateNum'+k).val() == expcertnum)){
                        suppliercntB+=1;
                    }
                }
            }
            if(parseInt(suppliercnt)<=1 && parseInt(suppliercntB)<=1){
                var defaultoption = '<option selected value=""></option>';
                $('#GrnNumber'+idval).empty();
                var grnoption = $("#grndefault > option").clone();
                $('#GrnNumber'+idval).append(grnoption);
                $("#GrnNumber"+idval+" option[title!='"+supplierdata+"']").remove(); 
                $('#GrnNumber'+idval).append(defaultoption);
                $('#GrnNumber'+idval).select2
                ({
                    placeholder: "Select GRN number here",
                    dropdownCssClass : 'cusprop',
                });

                $('#select2-Supplier'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
                $('#select2-GrnNumber'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
            }
            else if(parseInt(suppliercnt)>1 || parseInt(suppliercntB)>1){
                $('#Supplier'+idval).val(null).trigger('change').select2
                ({
                    placeholder: "Select Supplier here",
                    dropdownCssClass : 'commprp',
                });
                $('#select2-Supplier'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                toastrMessage('error',"Supplier is selected with all property","Error");
            }

            if(parseInt(commtype)==1){
                if(parseInt(floormap)>0 && parseInt(commtype)>0 && parseInt(origin)>0 && grade!="" && processtype!="" && cropyear!="" && parseInt(uomid)>0 && parseInt(supplierdata)>0 && grndata!=""){
                    calcQtyOnHand(idval);
                }
            }
            else if(parseInt(commtype)==2 || parseInt(commtype)==3 || parseInt(commtype)==4 || parseInt(commtype)==5 || parseInt(commtype)==6){
                if(parseInt(floormap)>0 && parseInt(commtype)>0 && parseInt(origin)>0 && grade!="" && processtype!="" && cropyear!="" && parseInt(uomid)>0 && certnumdata!="" && productionnum!=""){
                    calcQtyOnHand(idval);
                }
            }
        }

        function GrnNumberFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            var floormap=$('#FloorMap'+idval).val();
            var commtype=$('#CommType'+idval).val()||0;
            var supplierdata=$('#Supplier'+idval).val();
            var grndata=$('#GrnNumber'+idval).val();
            var productionnum=$('#ProductionNum'+idval).val();
            var certnumdata=$('#CertificateNum'+idval).val();
            var origin=$('#Origin'+idval).val()||0;
            var grade=$('#Grade'+idval).val()||0;
            var processtype=$('#ProcessType'+idval).val();
            var cropyear=$('#CropYear'+idval).val()||0;
            var uomid=$('#Uom'+idval).val();
            var expcertnum=$('#ExpCertificateNum'+idval).val();
            var grnnumbercnt=0;
            var grnnumbercntB=0;
            for(var k=1;k<=m2;k++){
                if(($('#GrnNumber'+k).val())!=undefined){
                    if((parseInt($('#CommType'+k).val()) == parseInt(commtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && (parseInt($('#Uom'+k).val()) == parseInt(uomid)) && ($('#Supplier'+k).val() == parseInt(supplierdata)) && ($('#GrnNumber'+k).val() == grndata) && (!isNaN(parseInt($('#Supplier'+k).val()))) && ($('#GrnNumber'+k).val() != null)){
                        grnnumbercnt+=1;
                    }
                    if((parseInt($('#CommType'+k).val()) == parseInt(commtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && (parseInt($('#Uom'+k).val()) == parseInt(uomid)) && ($('#CertificateNum'+k).val() == certnumdata) && ($('#CertificateNum'+k).val() != "") && ($('#ProductionNum'+k).val() == productionnum) && ($('#ProductionNum'+k).val() != "") && (expcertnum!="" && $('#ExpCertificateNum'+k).val() == expcertnum)){
                        grnnumbercntB+=1;
                    }
                }
            }
            if(parseInt(grnnumbercnt)<=1 && parseInt(grnnumbercntB)<=1){
                var defaultoption = '<option selected value=""></option>';
                $('#Origin'+idval).empty();
                origindata = $("#grncommoditydefault > option").clone();
                $('#Origin'+idval).append(origindata);
                $("#Origin"+idval+" option[title!='"+grndata+"']").remove(); 
                $('#Origin'+idval).append(defaultoption);
                $('#Origin'+idval).select2
                ({
                    placeholder: "Select Commodity here",
                    dropdownCssClass : 'commprp',
                });

                resetNumbers(idval);
                $('#select2-GrnNumber'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
            }
            else if(parseInt(grnnumbercnt)>1 || parseInt(grnnumbercntB)>1){
                $('#GrnNumber'+idval).val(null).trigger('change').select2
                ({
                    placeholder: "Select GRN Number here",
                    dropdownCssClass : 'commprp',
                });
                $('#select2-GrnNumber'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                toastrMessage('error',"GRN Number is selected with all property","Error");
            }

            if(parseInt(commtype)==1){
                if(parseInt(floormap)>0 && parseInt(commtype)>0 && parseInt(origin)>0 && grade!="" && processtype!="" && cropyear!="" && parseInt(uomid)>0 && parseInt(supplierdata)>0 && grndata!=""){
                    calcQtyOnHand(idval);
                }
            }
            else if(parseInt(commtype)==2 || parseInt(commtype)==3 || parseInt(commtype)==4 || parseInt(commtype)==5 || parseInt(commtype)==6){
                if(parseInt(floormap)>0 && parseInt(commtype)>0 && parseInt(origin)>0 && grade!="" && processtype!="" && cropyear!="" && parseInt(uomid)>0 && certnumdata!="" && productionnum!=""){
                    calcQtyOnHand(idval);
                }
            }
        }

        function OriginFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            var floormap=$('#FloorMap'+idval).val();
            var commtype=$('#CommType'+idval).val()||0;
            var supplierdata=$('#Supplier'+idval).val();
            var grndata=$('#GrnNumber'+idval).val();
            var productionnum=$('#ProductionNum'+idval).val();
            var certnumdata=$('#CertificateNum'+idval).val();
            var origin=$('#Origin'+idval).val()||0;
            var grade=$('#Grade'+idval).val()||0;
            var processtype=$('#ProcessType'+idval).val();
            var cropyear=$('#CropYear'+idval).val()||0;
            var uomid=$('#Uom'+idval).val();
            var expcertnum=$('#ExpCertificateNum'+idval).val();
            var gradeoption="";
            var processtypeoption="";
            var cropyearoption="";
            var uomoptions="";
            var origincnt=0;
            var origincntB=0;
            var rejcnt=0;

            var megeddata="";
            if(parseInt(commtype)==1){
                megeddata=origin+""+supplierdata+""+grndata;
            }
            else if(parseInt(commtype)==2 || parseInt(commtype)==4 || parseInt(commtype)==5 || parseInt(commtype)==6){
                megeddata=origin+""+productionnum+""+certnumdata;
            }
            else if(parseInt(commtype)==3){
                megeddata=commtype;
            }

            for(var k=1;k<=m2;k++){
                if(($('#Origin'+k).val())!=undefined){
                    if((parseInt($('#CommType'+k).val()) == parseInt(commtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && (parseInt($('#Uom'+k).val()) == parseInt(uomid)) && ($('#Supplier'+k).val() == parseInt(supplierdata)) && ($('#GrnNumber'+k).val() == grndata) && (!isNaN(parseInt($('#Supplier'+k).val()))) && ($('#GrnNumber'+k).val() != null)){
                        origincnt+=1;
                    }
                    if((parseInt($('#CommType'+k).val()) == parseInt(commtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && (parseInt($('#Uom'+k).val()) == parseInt(uomid)) && ($('#CertificateNum'+k).val() == certnumdata) && ($('#CertificateNum'+k).val() != "") && ($('#ProductionNum'+k).val() == productionnum) && ($('#ProductionNum'+k).val() != "") && (expcertnum!="" && $('#ExpCertificateNum'+k).val() == expcertnum)){
                        origincntB+=1;
                    }
                    if((parseInt($('#CommType'+k).val()) == parseInt(defaultrejtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && (parseInt($('#Uom'+k).val()) == parseInt(uomid))){
                        rejcnt+=1;
                    }
                }
            }

            if(parseInt(origincnt)<=1 && parseInt(origincntB)<=1 && parseInt(rejcnt)<=1){
                var defaultoption = '<option selected value=""></option>';
                if(parseInt(commtype)==3){
                    gradeoption = $("#rejgradedefault > option").clone();
                    processtypeoption = $("#rejprocesstypedefault > option").clone();
                    cropyearoption = $("#rejcropyeardefault > option").clone();
                    uomoptions = $("#rejuomdefault > option").clone();
                }
                else{
                    gradeoption = $("#gradedefault > option").clone();
                    processtypeoption = $("#processtypedefault > option").clone();
                    cropyearoption = $("#cropyeardefault > option").clone();
                    uomoptions = $("#uomdefault > option").clone();
                }
                
                $('#Grade'+idval).empty();
                $('#Grade'+idval).append(gradeoption);
                $("#Grade"+idval+" option[title!='"+megeddata+"']").remove(); 
                $('#Grade'+idval).append(defaultoption);
                $('#Grade'+idval).select2
                ({
                    placeholder: "Select Grade here",
                    dropdownCssClass : 'cusprop',
                });

                
                $('#ProcessType'+idval).empty();
                $('#ProcessType'+idval).append(processtypeoption);
                $("#ProcessType"+idval+" option[title!='"+megeddata+"']").remove(); 
                $('#ProcessType'+idval).append(defaultoption);
                $('#ProcessType'+idval).select2
                ({
                    placeholder: "Select Process type here",
                    dropdownCssClass : 'cusprop',
                });

                
                $('#CropYear'+idval).empty();
                $('#CropYear'+idval).append(cropyearoption);
                $("#CropYear"+idval+" option[title!='"+megeddata+"']").remove(); 
                $('#CropYear'+idval).append(defaultoption);
                $('#CropYear'+idval).select2
                ({
                    placeholder: "Select Crop year here",
                    dropdownCssClass : 'cusprop',
                });

                
                $('#Uom'+idval).empty();
                $('#Uom'+idval).append(uomoptions);
                $("#Uom"+idval+" option[class!='"+megeddata+"']").remove(); 
                $('#Uom'+idval).append(defaultoption);
                $('#Uom'+idval).select2
                ({
                    placeholder: "Select UOM/Bag here",
                    dropdownCssClass : 'cusprop',
                });

                $('#select2-Origin'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
                $('#select2-Grade'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
                $('#select2-ProcessType'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
                $('#select2-CropYear'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
                $('#select2-Uom'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
            }
            else if(parseInt(origincnt)>1 || parseInt(origincntB)>1 || parseInt(rejcnt)>1){
                $('#Origin'+idval).val(null).trigger('change').select2
                ({
                    placeholder: "Select Origin here",
                    dropdownCssClass : 'commprp',
                });
                $('#select2-Origin'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                toastrMessage('error',"Origin is selected with all property","Error");
            }

            if(parseInt(commtype)==1){
                if(parseInt(floormap)>0 && parseInt(commtype)>0 && parseInt(origin)>0 && grade!="" && processtype!="" && cropyear!="" && parseInt(uomid)>0 && parseInt(supplierdata)>0 && grndata!=""){
                    calcQtyOnHand(idval);
                }
            }
            else if(parseInt(commtype)==2 || parseInt(commtype)==4 || parseInt(commtype)==5 || parseInt(commtype)==6){
                if(parseInt(floormap)>0 && parseInt(commtype)>0 && parseInt(origin)>0 && grade!="" && processtype!="" && cropyear!="" && parseInt(uomid)>0 && certnumdata!="" && productionnum!=""){
                    calcQtyOnHand(idval);
                }
            }
            else if(parseInt(commtype)==3){
                if(parseInt(floormap)>0 && parseInt(commtype)>0 && parseInt(origin)>0 && grade!="" && processtype!="" && cropyear!="" && parseInt(uomid)>0){
                    calcQtyOnHand(idval);
                }
            }
        }

        function GradeFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            var floormap=$('#FloorMap'+idval).val();
            var commtype=$('#CommType'+idval).val()||0;
            var supplierdata=$('#Supplier'+idval).val();
            var grndata=$('#GrnNumber'+idval).val();
            var productionnum=$('#ProductionNum'+idval).val();
            var certnumdata=$('#CertificateNum'+idval).val();
            var origin=$('#Origin'+idval).val()||0;
            var grade=$('#Grade'+idval).val()||0;
            var processtype=$('#ProcessType'+idval).val();
            var cropyear=$('#CropYear'+idval).val()||0;
            var uomid=$('#Uom'+idval).val();
            var expcertnum=$('#ExpCertificateNum'+idval).val();
            var gradecnt=0;
            var gradecntB=0;
            var rejcnt=0;
            for(var k=1;k<=m2;k++){
                if(($('#Origin'+k).val())!=undefined){
                    if((parseInt($('#CommType'+k).val()) == parseInt(commtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && (parseInt($('#Uom'+k).val()) == parseInt(uomid)) && ($('#Supplier'+k).val() == parseInt(supplierdata)) && ($('#GrnNumber'+k).val() == grndata) && (!isNaN(parseInt($('#Supplier'+k).val()))) && ($('#GrnNumber'+k).val() != null)){
                        gradecnt+=1;
                    }
                    if((parseInt($('#CommType'+k).val()) == parseInt(commtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && (parseInt($('#Uom'+k).val()) == parseInt(uomid)) && ($('#CertificateNum'+k).val() == certnumdata) && ($('#CertificateNum'+k).val() != "") && ($('#ProductionNum'+k).val() == productionnum) && ($('#ProductionNum'+k).val() != "") && (expcertnum!="" && $('#ExpCertificateNum'+k).val() == expcertnum)){
                        gradecntB+=1;
                    }
                    if((parseInt($('#CommType'+k).val()) == parseInt(defaultrejtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && (parseInt($('#Uom'+k).val()) == parseInt(uomid))){
                        rejcnt+=1;
                    }
                }
            }

            if(parseInt(gradecnt)<=1 && parseInt(gradecntB)<=1 && parseInt(rejcnt)<=1){
                $('#select2-Grade'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
            }
            else if(parseInt(gradecnt)>1 || parseInt(gradecntB)>1 || parseInt(rejcnt)>1){
                $('#Grade'+idval).val(null).trigger('change').select2
                ({
                    placeholder: "Select Grade here...",
                    minimumResultsForSearch: -1
                });
                $('#select2-Grade'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                toastrMessage('error',"Grade is selected with all property","Error");
            }

            if(parseInt(commtype)==1){
                if(parseInt(floormap)>0 && parseInt(commtype)>0 && parseInt(origin)>0 && grade!="" && processtype!="" && cropyear!="" && parseInt(uomid)>0 && parseInt(supplierdata)>0 && grndata!=""){
                    calcQtyOnHand(idval);
                }
            }
            else if(parseInt(commtype)==2 || parseInt(commtype)==4 || parseInt(commtype)==5 || parseInt(commtype)==6){
                if(parseInt(floormap)>0 && parseInt(commtype)>0 && parseInt(origin)>0 && grade!="" && processtype!="" && cropyear!="" && parseInt(uomid)>0 && certnumdata!="" && productionnum!=""){
                    calcQtyOnHand(idval);
                }
            }
            else if(parseInt(commtype)==3){
                if(parseInt(floormap)>0 && parseInt(commtype)>0 && parseInt(origin)>0 && grade!="" && processtype!="" && cropyear!="" && parseInt(uomid)>0){
                    calcQtyOnHand(idval);
                }
            }
        }

        function ProcessTypeFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            var floormap=$('#FloorMap'+idval).val();
            var commtype=$('#CommType'+idval).val()||0;
            var supplierdata=$('#Supplier'+idval).val();
            var grndata=$('#GrnNumber'+idval).val();
            var productionnum=$('#ProductionNum'+idval).val();
            var certnumdata=$('#CertificateNum'+idval).val();
            var origin=$('#Origin'+idval).val()||0;
            var grade=$('#Grade'+idval).val()||0;
            var processtype=$('#ProcessType'+idval).val();
            var cropyear=$('#CropYear'+idval).val()||0;
            var uomid=$('#Uom'+idval).val();
            var expcertnum=$('#ExpCertificateNum'+idval).val();
            var processtypecnt=0;
            var processtypecntB=0;
            var rejcnt=0;
            for(var k=1;k<=m2;k++){
                if(($('#ProcessType'+k).val())!=undefined){
                    if((parseInt($('#CommType'+k).val()) == parseInt(commtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && (parseInt($('#Uom'+k).val()) == parseInt(uomid)) && ($('#Supplier'+k).val() == parseInt(supplierdata)) && ($('#GrnNumber'+k).val() == grndata) && (!isNaN(parseInt($('#Supplier'+k).val()))) && ($('#GrnNumber'+k).val() != null)){
                        processtypecnt+=1;
                    }
                    if((parseInt($('#CommType'+k).val()) == parseInt(commtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && (parseInt($('#Uom'+k).val()) == parseInt(uomid)) && ($('#CertificateNum'+k).val() == certnumdata) && ($('#CertificateNum'+k).val() != "") && ($('#ProductionNum'+k).val() == productionnum) && ($('#ProductionNum'+k).val() != "") && (expcertnum!="" && $('#ExpCertificateNum'+k).val() == expcertnum)){
                        processtypecntB+=1;
                    }
                    if((parseInt($('#CommType'+k).val()) == parseInt(defaultrejtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && (parseInt($('#Uom'+k).val()) == parseInt(uomid))){
                        rejcnt+=1;
                    }
                }
            }

            if(parseInt(processtypecnt)<=1 && parseInt(processtypecntB)<=1 && parseInt(rejcnt)<=1){
                $('#select2-ProcessType'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
            }
            else if(parseInt(processtypecnt)>1 || parseInt(processtypecntB)>1 || parseInt(rejcnt)>1){
                $('#ProcessType'+idval).val(null).trigger('change').select2
                ({
                    placeholder: "Select Process type here...",
                    minimumResultsForSearch: -1
                });
                $('#select2-ProcessType'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                toastrMessage('error',"Process type is selected with all property","Error");
            }

            if(parseInt(commtype)==1){
                if(parseInt(floormap)>0 && parseInt(commtype)>0 && parseInt(origin)>0 && grade!="" && processtype!="" && cropyear!="" && parseInt(uomid)>0 && parseInt(supplierdata)>0 && grndata!=""){
                    calcQtyOnHand(idval);
                }
            }
            else if(parseInt(commtype)==2 || parseInt(commtype)==4 || parseInt(commtype)==5 || parseInt(commtype)==6){
                if(parseInt(floormap)>0 && parseInt(commtype)>0 && parseInt(origin)>0 && grade!="" && processtype!="" && cropyear!="" && parseInt(uomid)>0 && certnumdata!="" && productionnum!=""){
                    calcQtyOnHand(idval);
                }
            }
            else if(parseInt(commtype)==3){
                if(parseInt(floormap)>0 && parseInt(commtype)>0 && parseInt(origin)>0 && grade!="" && processtype!="" && cropyear!="" && parseInt(uomid)>0){
                    calcQtyOnHand(idval);
                }
            }
        }

        function CropYearFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            var floormap=$('#FloorMap'+idval).val();
            var commtype=$('#CommType'+idval).val()||0;
            var supplierdata=$('#Supplier'+idval).val();
            var grndata=$('#GrnNumber'+idval).val();
            var productionnum=$('#ProductionNum'+idval).val();
            var certnumdata=$('#CertificateNum'+idval).val();
            var origin=$('#Origin'+idval).val()||0;
            var grade=$('#Grade'+idval).val()||0;
            var processtype=$('#ProcessType'+idval).val();
            var cropyear=$('#CropYear'+idval).val()||0;
            var uomid=$('#Uom'+idval).val();
            var expcertnum=$('#ExpCertificateNum'+idval).val();
            var cropyearcnt=0;
            var cropyearcntB=0;
            var rejcnt=0;
            for(var k=1;k<=m2;k++){ 
                if(($('#CropYear'+k).val())!=undefined){
                    if((parseInt($('#CommType'+k).val()) == parseInt(commtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && (parseInt($('#Uom'+k).val()) == parseInt(uomid)) && ($('#Supplier'+k).val() == parseInt(supplierdata)) && ($('#GrnNumber'+k).val() == grndata) && (!isNaN(parseInt($('#Supplier'+k).val()))) && ($('#GrnNumber'+k).val() != null)){
                        cropyearcnt+=1;
                    }
                    if((parseInt($('#CommType'+k).val()) == parseInt(commtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && (parseInt($('#Uom'+k).val()) == parseInt(uomid)) && ($('#CertificateNum'+k).val() == certnumdata) && ($('#CertificateNum'+k).val() != "") && ($('#ProductionNum'+k).val() == productionnum) && ($('#ProductionNum'+k).val() != "") && (expcertnum!="" && $('#ExpCertificateNum'+k).val() == expcertnum)){
                        cropyearcntB+=1;
                    }
                    if((parseInt($('#CommType'+k).val()) == parseInt(defaultrejtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && (parseInt($('#Uom'+k).val()) == parseInt(uomid))){
                        rejcnt+=1;
                    }
                }
            }

            if(parseInt(cropyearcnt)<=1 && parseInt(cropyearcntB)<=1 && parseInt(rejcnt)<=1){
                $('#select2-CropYear'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
            }
            else if(parseInt(cropyearcnt)>1 || parseInt(cropyearcntB)>1 || parseInt(rejcnt)>1){
                $('#CropYear'+idval).val(null).trigger('change').select2
                ({
                    placeholder: "Select Crop year here...",
                    minimumResultsForSearch: -1
                });
                $('#select2-CropYear'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                toastrMessage('error',"Crop year is selected with all property","Error");
            }

            if(parseInt(commtype)==1){
                if(parseInt(floormap)>0 && parseInt(commtype)>0 && parseInt(origin)>0 && grade!="" && processtype!="" && cropyear!="" && parseInt(uomid)>0 && parseInt(supplierdata)>0 && grndata!=""){
                    calcQtyOnHand(idval);
                }
            }
            else if(parseInt(commtype)==2 || parseInt(commtype)==4 || parseInt(commtype)==5 || parseInt(commtype)==6){
                if(parseInt(floormap)>0 && parseInt(commtype)>0 && parseInt(origin)>0 && grade!="" && processtype!="" && cropyear!="" && parseInt(uomid)>0 && certnumdata!="" && productionnum!=""){
                    calcQtyOnHand(idval);
                }
            }
            else if(parseInt(commtype)==3){
                if(parseInt(floormap)>0 && parseInt(commtype)>0 && parseInt(origin)>0 && grade!="" && processtype!="" && cropyear!="" && parseInt(uomid)>0){
                    calcQtyOnHand(idval);
                }
            }
        }

        function UomFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            var floormap=$('#FloorMap'+idval).val();
            var commtype=$('#CommType'+idval).val()||0;
            var supplierdata=$('#Supplier'+idval).val();
            var grndata=$('#GrnNumber'+idval).val();
            var productionnum=$('#ProductionNum'+idval).val();
            var certnumdata=$('#CertificateNum'+idval).val();
            var origin=$('#Origin'+idval).val()||0;
            var grade=$('#Grade'+idval).val()||0;
            var processtype=$('#ProcessType'+idval).val();
            var cropyear=$('#CropYear'+idval).val()||0;
            var uomid=$('#Uom'+idval).val();
            var expcertnum=$('#ExpCertificateNum'+idval).val();
            var numofbag=$('#NumOfBag'+idval).val()||0;
            var uomopt = $('#uomdefault').find('option[value="' +uomid+ '"]');
            var uomfactor=uomopt.attr('title');
            var uombagweight=uomopt.attr('label');
            var totalbagweight=parseFloat(uombagweight)*parseFloat(numofbag);
            var uomcount=0;
            var uomcountB=0;
            var rejcnt=0;
            for(var k=1;k<=m2;k++){ 
                if(($('#CropYear'+k).val())!=undefined){
                    if((parseInt($('#CommType'+k).val()) == parseInt(commtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && (parseInt($('#Uom'+k).val()) == parseInt(uomid)) && ($('#Supplier'+k).val() == parseInt(supplierdata)) && ($('#GrnNumber'+k).val() == grndata) && (!isNaN(parseInt($('#Supplier'+k).val()))) && ($('#GrnNumber'+k).val() != null)){
                        uomcount+=1;
                    }
                    if((parseInt($('#CommType'+k).val()) == parseInt(commtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && (parseInt($('#Uom'+k).val()) == parseInt(uomid)) && ($('#CertificateNum'+k).val() == certnumdata) && ($('#CertificateNum'+k).val() != "") && ($('#ProductionNum'+k).val() == productionnum) && ($('#ProductionNum'+k).val() != "") && (expcertnum!="" && $('#ExpCertificateNum'+k).val() == expcertnum)){
                        uomcountB+=1;
                    }
                    if((parseInt($('#CommType'+k).val()) == parseInt(defaultrejtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && (parseInt($('#Uom'+k).val()) == parseInt(uomid))){
                        rejcnt+=1;
                    }
                }
            }
            
            if(parseInt(uomcount)<=1 && parseInt(uomcountB)<=1 && parseInt(rejcnt)<=1){
                $('#uomFactor'+idval).val(uomfactor);
                $('#bagWeight'+idval).val(uombagweight);
                $('#TotalBagWeight'+idval).val(totalbagweight == 0 ? '' : totalbagweight.toFixed(2));
                $('#NumOfBag'+idval).prop("readonly",false);
                $('#NetKg'+idval).val("");
                $('#select2-Uom'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
            }
            else if(parseInt(uomcount)>1 || parseInt(uomcountB)>1 || parseInt(rejcnt)>1){
                $('#TotalBagWeight'+idval).val("");
                $('#uomFactor'+idval).val("");
                $('#bagWeight'+idval).val("");
                $('#NumOfBag'+idval).prop("readonly",true);
                $('#NetKg'+idval).prop("readonly",true);
                $('#NetKg'+idval).val("");
                $('#TotalBagWeight'+idval).css("background","#efefef");
                $('#Uom'+idval).val(null).trigger('change').select2
                ({
                    placeholder: "Select UOM/Bag here",
                });
                $('#select2-Uom'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                toastrMessage('error',"UOM/Bag is selected with all property","Error");
            }

            if(parseInt(commtype)==1){
                if(parseInt(floormap)>0 && parseInt(commtype)>0 && parseInt(origin)>0 && grade!="" && processtype!="" && cropyear!="" && parseInt(uomid)>0 && parseInt(supplierdata)>0 && grndata!=""){
                    calcQtyOnHand(idval);
                }
            }
            else if(parseInt(commtype)==2 || parseInt(commtype)==4 || parseInt(commtype)==5 || parseInt(commtype)==6){
                if(parseInt(floormap)>0 && parseInt(commtype)>0 && parseInt(origin)>0 && grade!="" && processtype!="" && cropyear!="" && parseInt(uomid)>0 && certnumdata!="" && productionnum!=""){
                    calcQtyOnHand(idval);
                }
            }
            else if(parseInt(commtype)==3){
                if(parseInt(floormap)>0 && parseInt(commtype)>0 && parseInt(origin)>0 && grade!="" && processtype!="" && cropyear!="" && parseInt(uomid)>0){
                    calcQtyOnHand(idval);
                }
            }
        }

        function unitCostFn(ele){
            var idval = $(ele).closest('tr').find('.vals').val();
            $('#UnitCost'+idval).css("background","white");
            calcTotalCostFn(idval);
        }

        function calcTotalCostFn(idval){
            var net_kg = $('#NetKg'+idval).val()||0;
            var unit_cost = $('#UnitCost'+idval).val()||0;
            unit_cost = unit_cost == '' ? 0 : unit_cost;
            var total_cost = parseFloat(unit_cost) * parseFloat(net_kg);

            var adjtype = $('#AdjustmentType').val();
            var totalcost_price = "";
            if(adjtype == "Increase"){
                totalcost_price = "Total Price";
            }
            if(adjtype == "Decrease"){
                totalcost_price = "Total Cost";
            }

            $('#totalcostLbl'+idval).html(`<label class="total_cost_price_cls">${totalcost_price}</label>: ${numformat(parseFloat(total_cost).toFixed(2))}`);
            $('#TotalCost'+idval).val(parseFloat(total_cost).toFixed(2));

            CalculateCommTotal();
        }

        function iterateTable(){
            var adjtype = $('#AdjustmentType').val();
            
            $('#commDynamicTable > tbody > tr').each(function(index) {
                let rowind = $(this).find('.vals').val();
                calcQtyOnHand(rowind);
                
                let no_of_bag = $(`#NumOfBag${rowind}`).val();
                let net_kg = $(`#NetKg${rowind}`).val();

                let no_of_bag_balance = $(`#QtyOnHand${rowind}`).val();
                let net_kg_balance = $(`#QtyOnHandByKg${rowind}`).val();

                no_of_bag = no_of_bag == '' ? 0 : no_of_bag;
                net_kg = net_kg == '' ? 0 : net_kg;
                no_of_bag_balance = no_of_bag_balance == '' ? 0 : no_of_bag_balance;
                net_kg_balance = net_kg_balance == '' ? 0 : net_kg_balance;

                if(parseFloat(no_of_bag) > parseFloat(no_of_bag_balance)){
                    $(`#NumOfBag${rowind}`).val("");
                    $(`#TotalBagWeight${rowind}`).val("");
                }
                if(parseFloat(net_kg) > parseFloat(net_kg_balance)){
                    $(`#TotalKg${rowind}`).val("");
                    $(`#NetKg${rowind}`).val("");
                    $(`#Feresula${rowind}`).val("");
                }   
            });

            var defaultoption = '<option selected value=""></option>';
            $('.Reason').empty();
            var reasonopt = $("#reasondefault > option").clone();
            $('.Reason').append(reasonopt);

            if(adjtype == "Increase"){
                $('.UnitCost').prop("readonly",false);
                $('.UnitCost').css("background","white");
                $('.unit_cost_price_cls').html("Unit Price");
                $('.total_cost_price_cls').html("Total Price");
                $(".Reason option[data-type!='inc']").remove(); 
            }
            else if(adjtype == "Decrease"){
                $('.UnitCost').prop("readonly",true);
                $('.UnitCost').css("background","#efefef");
                $('.unit_cost_price_cls').html("Unit Cost");
                $('.total_cost_price_cls').html("Total Cost");
                $(".Reason option[data-type!='dec']").remove(); 
            }
            $('.Reason').append(defaultoption);
            $('.Reason').select2
            ({
                placeholder: "Select reason here",
                dropdownCssClass : 'cusprop',
            });
            CalculateCommTotal();
        }

        function ExpCertificateNumFn(ele){
            var idval = $(ele).closest('tr').find('.vals').val();
            $('#ExpCertificateNum'+idval).css("background","white");
        }

        function ExpCertificateNumBlFn(ele){
            var idval = $(ele).closest('tr').find('.vals').val();
            var floormap=$('#FloorMap'+idval).val();
            var commtype=$('#CommType'+idval).val()||0;
            var supplierdata=$('#Supplier'+idval).val();
            var grndata=$('#GrnNumber'+idval).val();
            var productionnum=$('#ProductionNum'+idval).val();
            var certnumdata=$('#CertificateNum'+idval).val();
            var origin=$('#Origin'+idval).val()||0;
            var grade=$('#Grade'+idval).val()||0;
            var processtype=$('#ProcessType'+idval).val();
            var cropyear=$('#CropYear'+idval).val()||0;
            var uomid=$('#Uom'+idval).val();
            var expcertnum=$('#ExpCertificateNum'+idval).val();
            var expcertnumcnt=0;
            var expcertnumcntB=0;
            for(var k=1;k<=m2;k++){
                if(($('#ProcessType'+k).val())!=undefined){
                    if((parseInt($('#CommType'+k).val()) == parseInt(commtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && (parseInt($('#Uom'+k).val()) == parseInt(uomid)) && ($('#Supplier'+k).val() == parseInt(supplierdata)) && ($('#GrnNumber'+k).val() == grndata) && (!isNaN(parseInt($('#Supplier'+k).val()))) && ($('#GrnNumber'+k).val() != null)){
                        expcertnumcnt+=1;
                    }
                    if((parseInt($('#CommType'+k).val()) == parseInt(commtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && (parseInt($('#Uom'+k).val()) == parseInt(uomid)) && ($('#CertificateNum'+k).val() == certnumdata) && ($('#CertificateNum'+k).val() != "") && ($('#ProductionNum'+k).val() == productionnum) && ($('#ProductionNum'+k).val() != "") && (expcertnum!="" && $('#ExpCertificateNum'+k).val() == expcertnum)){
                        expcertnumcntB+=1;
                    }
                }
            }

            if(parseInt(expcertnumcnt)<=1 && parseInt(expcertnumcntB)<=1){
                $('#ExpCertificateNum'+idval).css("background","white");
            }
            else if(parseInt(expcertnumcnt)>1 || parseInt(expcertnumcntB)>1){
                $('#ExpCertificateNum'+idval).val("");
                $('#ExpCertificateNum'+idval).css("background",errorcolor);
                toastrMessage('error',"Export certificate number is assigned with all property","Error");
            }
        }

        function checkBalanceBlFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            var floormap=$('#FloorMap'+idval).val();
            var commtype=$('#CommType'+idval).val()||0;
            var supplierdata=$('#Supplier'+idval).val();
            var grndata=$('#GrnNumber'+idval).val();
            var productionnum=$('#ProductionNum'+idval).val();
            var certnumdata=$('#CertificateNum'+idval).val();
            var origin=$('#Origin'+idval).val()||0;
            var grade=$('#Grade'+idval).val()||0;
            var processtype=$('#ProcessType'+idval).val();
            var cropyear=$('#CropYear'+idval).val()||0;
            var uomid=$('#Uom'+idval).val();
            var expcertnum=$('#ExpCertificateNum'+idval).val();

            if(parseInt(commtype)==1){
                if(parseInt(floormap)>0 && parseInt(commtype)>0 && parseInt(origin)>0 && grade!="" && processtype!="" && cropyear!="" && parseInt(uomid)>0 && parseInt(supplierdata)>0 && grndata!=""){
                    calcQtyOnHand(idval);
                }
            }
            else if(parseInt(commtype)==2 || parseInt(commtype)==4 || parseInt(commtype)==5 || parseInt(commtype)==6){
                if(parseInt(floormap)>0 && parseInt(commtype)>0 && parseInt(origin)>0 && grade!="" && processtype!="" && cropyear!="" && parseInt(uomid)>0 && certnumdata!="" && productionnum!=""){
                    calcQtyOnHand(idval);
                }
            }
            else if(parseInt(commtype)==3){
                if(parseInt(floormap)>0 && parseInt(commtype)>0 && parseInt(origin)>0 && grade!="" && processtype!="" && cropyear!="" && parseInt(uomid)>0){
                    calcQtyOnHand(idval);
                }
            }
        }        

        function calcQtyOnHand(rowid){
            var commtype="";
            var origin="";
            var grade="";
            var processtype="";
            var cropyear="";
            var storeval="";
            var uom="";
            var supplierid="";
            var grnnumber="";
            var prdordernumber="";
            var certnumber="";
            var expcertnumber="";
            var quantity=0;
            var floormap="";
            var quantitykg=0;
            
            var cusOrOwner=0;
            var baseRecordId=0;
            var totalbalnce=0;
            var totalbalancekg=0;
            var customersId=1;
            var feresula=0;
            var otherskg=0;
            var othersbagnum=0;
            var adjtype = $('#AdjustmentType').val();
            var compType=$('#CompanyType').val();
            if(parseInt(compType)==1){
                customersId=1;
            }
            else if(parseInt(compType)==2){
                customersId=$('#Customer').val();
            }
            
            $.ajax({
                url: '/calcAdjBalance', 
                type: 'POST',
                data:{
                    baseRecordId:$('#adjustmentId').val(),
                    storeval:$('#sstore').val(),
                    cusOrOwner:customersId,
                    floormap:$('#FloorMap'+rowid).val(),
                    commtype:$('#CommType'+rowid).val(),
                    supplierid:$('#Supplier'+rowid).val(),
                    grnnumber:$('#GrnNumber'+rowid).val(),
                    prdordernumber:$('#ProductionNum'+rowid).val(),
                    certnumber:$('#CertificateNum'+rowid).val(),
                    expcertnumber:$('#ExpCertificateNum'+rowid).val(),
                    origin:$('#Origin'+rowid).val(),
                    grade:$('#Grade'+rowid).val(),
                    processtype:$('#ProcessType'+rowid).val(),
                    cropyear:$('#CropYear'+rowid).val(),
                    uom:$('#Uom'+rowid).val(),
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
                    otherskg=calcOthersKgFn(rowid);
                    othersbagnum=calcOthersBagNoFn(rowid);
                    
                    quantitykg=$('#NetKg'+rowid).val()||0;
                    quantity=$('#Quantity'+rowid).val()||0;
                    totalbalnce=((parseFloat(data.avbalancebag)-parseFloat(data.avothbalancebag)-parseFloat(data.prdnumofbag)-parseFloat(othersbagnum))+parseFloat(0));
                    totalbalancekg=((parseFloat(data.avbalancekg)-parseFloat(data.avothbalancekg)-parseFloat(data.prdbalancekg)-parseFloat(otherskg))+parseFloat(0));
                    feresula=parseFloat(totalbalancekg)/17;
                    $('#uomfactor'+rowid).val(data.uomfactor);

                    if(parseFloat(totalbalancekg) < parseFloat(quantitykg) && adjtype == "Decrease"){
                        $('#QtyOnHand'+rowid).val("");
                        $('#QtyConverted'+rowid).val(""); 
                        $('#QtyOnHandByKg'+rowid).val(""); 
                        $('#UnitCost'+rowid).val("");
                        $('#TotalPrice'+rowid).val(""); 
                        $('#NumOfBag'+rowid).val(""); 
                        $('#TotalBagWeight'+rowid).val(""); 
                        $('#TotalKg'+rowid).val(""); 
                        $('#NetKg'+rowid).val(""); 
                        $('#Feresula'+rowid).val(""); 
                        $('#Quantity'+rowid).val(""); 
                        $('#avqtybyuom'+rowid).html(""); 
                        $('#avqtybykg'+rowid).html("");
                        $('#reqferesula'+rowid).html("");
                        $('#varianceLbl'+rowid).html("");
                        $('#varianceoverage'+rowid).val(""); 
                        $('#varianceshortage'+rowid).val(""); 
                        toastrMessage('error',"Insufficent quantity","Error");
                    }
                    // else if(parseFloat(totalbalancekg)>=parseFloat(quantitykg)){
                    //     $('#UnitPrice'+rowid).val(data.avcost);
                    //     var conquantity=parseFloat(data.uomfactor)*parseFloat(quantity);
                    //     $('#QtyOnHand'+rowid).val(totalbalnce);
                    //     $('#QtyOnHandByKg'+rowid).val(totalbalancekg);
                    //     $('#avqtybyuom'+rowid).html(numformat(parseFloat(totalbalnce))+" "+data.uomname);
                    //     $('#avqtybykg'+rowid).html(numformat(parseFloat(totalbalancekg).toFixed(2))+" KG");
                    //     $('#reqferesula'+rowid).html(numformat(parseFloat(feresula).toFixed(2)));
                    // }

                    if(adjtype == "Increase"){
                        //$('#UnitCost'+rowid).val("");
                        $('.unit_cost_price_cls').html("Unit Price");
                        $('.total_cost_price_cls').html("Total Price");
                    }
                    if(adjtype == "Decrease"){
                        $('#UnitCost'+rowid).val(data.avcost);
                        $('.unit_cost_price_cls').html("Unit Cost");
                        $('.total_cost_price_cls').html("Total Cost");
                    }
                    var conquantity=parseFloat(data.uomfactor)*parseFloat(quantity);
                    $('#QtyOnHand'+rowid).val(totalbalnce);
                    $('#QtyOnHandByKg'+rowid).val(totalbalancekg);
                    $('#avqtybyuom'+rowid).html(numformat(parseFloat(totalbalnce))+" "+data.uomname);
                    $('#avqtybykg'+rowid).html(numformat(parseFloat(totalbalancekg).toFixed(2))+" KG");
                    $('#reqferesula'+rowid).html(numformat(parseFloat(feresula).toFixed(2)));
                    calcTotalCostFn(rowid);
                }
            });
        }

        function calcOthersKgFn(rid){
            var idval=0;
            var floormap="";
            var commtype="";
            var supplierid="";
            var grnnumber="";
            var prdordernumber="";
            var certnumber="";
            var origin="";
            var grade="";
            var processtype="";
            var cropyear="";
            var uom="";

            var flrmp=$('#FloorMap'+rid).val();
            var cmtype=$('#CommType'+rid).val();
            var spl=$('#Supplier'+rid).val();
            var grn=$('#GrnNumber'+rid).val();
            var prd=$('#ProductionNum'+rid).val();
            var cern=$('#CertificateNum'+rid).val();
            var org=$('#Origin'+rid).val();
            var grd=$('#Grade'+rid).val();
            var prtype=$('#ProcessType'+rid).val();
            var crpyr=$('#CropYear'+rid).val();
            var um=$('#Uom'+rid).val();
        
            var netkgval=0;
            
            $('#commDynamicTable > tbody  > tr').each(function() { 
                idval = $(this).find('.vals').val();
                floormap = $(this).find('.FloorMap').val();
                commtype = $(this).find('.CommType').val();
                supplierid = $(this).find('.Supplier').val();
                grnnumber = $(this).find('.GrnNumber').val();
                prdordernumber = $(this).find('.ProductionNum').val();
                certnumber = $(this).find('.CertificateNum').val();
                origin = $(this).find('.Origin').val();
                grade = $(this).find('.Grade').val();
                processtype = $(this).find('.ProcessType').val();
                cropyear = $(this).find('.CropYear').val();
                uom = $(this).find('.Uom').val();

                if(parseInt(rid)!=parseInt(idval)){//different from current row!
                    if(parseInt(commtype)==1){
                        if(parseInt(floormap)==parseInt(flrmp) && parseInt(commtype)==parseInt(cmtype) && parseInt(origin)==parseInt(org) && parseInt(grade)==parseInt(grd) && processtype==prtype && cropyear==crpyr && parseInt(uom)==parseInt(um) && parseInt(supplierid)==parseInt(spl) && grnnumber==grn){
                            if ($(this).find('.NetKg').val() != '' && !isNaN($(this).find('.NetKg').val())) {
                                netkgval += parseFloat($(this).find('.NetKg').val());
                            }
                        }
                    }
                    else if(parseInt(commtype)==2 || parseInt(commtype)==4 || parseInt(commtype)==5 || parseInt(commtype)==6){
                        if(parseInt(floormap)==parseInt(flrmp) && parseInt(commtype)==parseInt(cmtype) && parseInt(origin)==parseInt(org) && parseInt(grade)==parseInt(grd) && processtype==prtype && cropyear==crpyr && parseInt(uom)==parseInt(um) && prdordernumber==prd && certnumber==cern){
                            if ($(this).find('.NetKg').val() != '' && !isNaN($(this).find('.NetKg').val())) {
                                netkgval += parseFloat($(this).find('.NetKg').val());
                            }
                        }
                    }
                    else if(parseInt(commtype)==3){
                        if(parseInt(floormap)==parseInt(flrmp) && parseInt(commtype)==parseInt(cmtype) && parseInt(origin)==parseInt(org) && parseInt(grade)==parseInt(grd) && processtype==prtype && cropyear==crpyr && parseInt(uom)==parseInt(um)){
                            if ($(this).find('.NetKg').val() != '' && !isNaN($(this).find('.NetKg').val())) {
                                netkgval += parseFloat($(this).find('.NetKg').val());
                            }
                        }
                    }
                }
            });           
             
            return netkgval;
        }

        function calcOthersBagNoFn(rid){
            var idval=0;
            var floormap="";
            var commtype="";
            var supplierid="";
            var grnnumber="";
            var prdordernumber="";
            var certnumber="";
            var origin="";
            var grade="";
            var processtype="";
            var cropyear="";
            var uom="";

            var flrmp=$('#FloorMap'+rid).val();
            var cmtype=$('#CommType'+rid).val();
            var spl=$('#Supplier'+rid).val();
            var grn=$('#GrnNumber'+rid).val();
            var prd=$('#ProductionNum'+rid).val();
            var cern=$('#CertificateNum'+rid).val();
            var org=$('#Origin'+rid).val();
            var grd=$('#Grade'+rid).val();
            var prtype=$('#ProcessType'+rid).val();
            var crpyr=$('#CropYear'+rid).val();
            var um=$('#Uom'+rid).val();
        
            var numofbag=0;
            
            $('#commDynamicTable > tbody  > tr').each(function() { 
                idval = $(this).find('.vals').val();
                floormap = $(this).find('.FloorMap').val();
                commtype = $(this).find('.CommType').val();
                supplierid = $(this).find('.Supplier').val();
                grnnumber = $(this).find('.GrnNumber').val();
                prdordernumber = $(this).find('.ProductionNum').val();
                certnumber = $(this).find('.CertificateNum').val();
                origin = $(this).find('.Origin').val();
                grade = $(this).find('.Grade').val();
                processtype = $(this).find('.ProcessType').val();
                cropyear = $(this).find('.CropYear').val();
                uom = $(this).find('.Uom').val();

                if(parseInt(rid)!=parseInt(idval)){//different from current row!
                    if(parseInt(commtype)==1){
                        if(parseInt(floormap)==parseInt(flrmp) && parseInt(commtype)==parseInt(cmtype) && parseInt(origin)==parseInt(org) && parseInt(grade)==parseInt(grd) && processtype==prtype && cropyear==crpyr && parseInt(uom)==parseInt(um) && parseInt(supplierid)==parseInt(spl) && grnnumber==grn){
                            if ($(this).find('.NumOfBag').val() != '' && !isNaN($(this).find('.NumOfBag').val())) {
                                numofbag += parseFloat($(this).find('.NumOfBag').val());
                            }
                        }
                    }
                    else if(parseInt(commtype)==2 || parseInt(commtype)==4 || parseInt(commtype)==5 || parseInt(commtype)==6){
                        if(parseInt(floormap)==parseInt(flrmp) && parseInt(commtype)==parseInt(cmtype) && parseInt(origin)==parseInt(org) && parseInt(grade)==parseInt(grd) && processtype==prtype && cropyear==crpyr && parseInt(uom)==parseInt(um) && prdordernumber==prd && certnumber==cern){
                            if ($(this).find('.NumOfBag').val() != '' && !isNaN($(this).find('.NumOfBag').val())) {
                                numofbag += parseFloat($(this).find('.NumOfBag').val());
                            }
                        }
                    }
                    else if(parseInt(commtype)==3){
                        if(parseInt(floormap)==parseInt(flrmp) && parseInt(commtype)==parseInt(cmtype) && parseInt(origin)==parseInt(org) && parseInt(grade)==parseInt(grd) && processtype==prtype && cropyear==crpyr && parseInt(uom)==parseInt(um)){
                            if ($(this).find('.NumOfBag').val() != '' && !isNaN($(this).find('.NumOfBag').val())) {
                                numofbag += parseFloat($(this).find('.NumOfBag').val());
                            }
                        }
                    }
                }
            });           
             
            return numofbag;
        }

        function resetNumbers(rowid){

            $('#Grade'+rowid).empty();
            $('#Grade'+rowid).select2
            ({
                placeholder: "Select Commodity first",
                dropdownCssClass : 'cusprop',
                minimumResultsForSearch: -1
            });

            $('#ProcessType'+rowid).empty();
            $('#ProcessType'+rowid).select2
            ({
                placeholder: "Select Process type here",
                dropdownCssClass : 'cusprop',
                minimumResultsForSearch: -1
            });

            $('#CropYear'+rowid).empty();
            $('#CropYear'+rowid).select2
            ({
                placeholder: "Select Crop year here",
                dropdownCssClass : 'cusprop',
                minimumResultsForSearch: -1
            });
        
            $('#Uom'+rowid).empty();
            $('#Uom'+rowid).select2
            ({
                placeholder: "Select UOM/Bag here",
                dropdownCssClass : 'cusprop',
                minimumResultsForSearch: -1
            });

            $('#NumOfBag'+rowid).val("");
            $('#TotalBagWeight'+rowid).val("");
            $('#TotalKg'+rowid).val("");
            $('#NetKg'+rowid).val("");
            $('#Feresula'+rowid).val("");
            $('#NetKg'+rowid).val("");
            $('#varianceshortage'+rowid).val("");
            $('#varianceoverage'+rowid).val("");

            $('#avqtybyuom'+rowid).html("");
            $('#avqtybykg'+rowid).html("");
            $('#reqferesula'+rowid).html("");
            $('#varianceLbl'+rowid).html("");

            $('#QtyOnHand'+rowid).val("");
            $('#QtyOnHandByKg'+rowid).val("");
            CalculateCommTotal();
        }

        function NumOfBagFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            var quantity=$('#NumOfBag'+idval).val()||0;
            var bagweight=$('#bagWeight'+idval).val()||0;
            var rembag=$('#remBagNum'+idval).val()||0;
            var remkg=$('#remKg'+idval).val()||0;
            var qtyonhand=$('#QtyOnHand'+idval).val()||0;
            var totalkg=$('#TotalKg'+idval).val()||0;
            var netkg=$('#NetKg'+idval).val()||0;
            var adjtype = $('#AdjustmentType').val();
            var feresulafac=17;
            var result=0;
            var selecteduom="";
            var variance=0

            var uomfactor=0;
            var conqty=0;
            var totalqnt=0;
            var totalnumbag=0;
            var totalbagweight=0;
            var calcshortageacc=0;
            var calcoverageacc=0;
            
            if(parseFloat(qtyonhand) < parseFloat(quantity) && adjtype == "Decrease"){
                $('#NumOfBag'+idval).val("");
                $('#NumOfBag'+idval).css("background",errorcolor);
                $('#TotalBagWeight'+idval).prop("readonly",true);
                $('#TotalBagWeight'+idval).val("");
                $('#TotalBagWeight'+idval).css("background","#efefef");
                toastrMessage('error',"The maximum allowed quantity is "+qtyonhand,"Error");
            }
            else if(parseFloat(qtyonhand)>=parseFloat(quantity) || adjtype == "Increase"){
                uomfactor=$('#uomFactor'+idval).val()||0;
                conqty=0;
                quantity = quantity == '' ? 0 : quantity;
                uomfactor = uomfactor == '' ? 0 : uomfactor;
                totalkg = totalkg == '' ? 0 : totalkg;
                netkg = netkg == '' ? 0 : netkg;
                bagweight = bagweight == '' ? 0 : bagweight;
                conqty=parseFloat(quantity)*parseFloat(uomfactor);
                totalbagweight=parseFloat(quantity)*parseFloat(bagweight);
                $('#TotalBagWeight'+idval).val(parseFloat(totalbagweight).toFixed(2));
                $('#NumOfBag'+idval).css("background","white");
                $('#NetKg'+idval).val(parseFloat(totalkg).toFixed(2));
                $('#varianceoverage'+idval).val("");
                $('#varianceshortage'+idval).val("");
                $('#varianceLbl'+idval).html("");
                if(parseFloat(totalkg)>0 && parseFloat(quantity)>0){
                    var netkgval=parseFloat(totalkg)-parseFloat(bagweight);
                    $('#NetKg'+idval).val(parseFloat(netkgval).toFixed(2));
                }
                else if(parseFloat(netkg)>0 && parseFloat(quantity)>0){
                    var totalkgval=parseFloat(netkg)+parseFloat(bagweight);
                    $('#TotalKg'+idval).val(parseFloat(totalkgval).toFixed(2));
                }
                netkg=$('#NetKg'+idval).val()||0;
                totalkg=$('#TotalKg'+idval).val()||0;
                totalkg = totalkg == '' ? 0 : totalkg;
                netkg = netkg == '' ? 0 : netkg;

                if(parseFloat(netkg)>parseFloat(totalkg) && parseFloat(quantity)>0){
                    variance=parseFloat(netkg)-parseFloat(totalkg);
                    $('#varianceoverage'+idval).val(variance.toFixed(2));
                    $('#varianceshortage'+idval).val("");
                    $('#varianceLbl'+idval).html("Variance Overage: "+ numformat(variance.toFixed(2))+" KG");
                }
                if(parseFloat(totalkg)>parseFloat(netkg) && parseFloat(quantity)>0){
                    variance=parseFloat(totalkg)-parseFloat(netkg);
                    $('#varianceshortage'+idval).val(variance.toFixed(2));
                    $('#varianceoverage'+idval).val("");
                    $('#varianceLbl'+idval).html("Variance Shortage: "+ numformat(variance.toFixed(2))+" KG");
                }
                result=parseFloat(netkg)/parseFloat(feresulafac);
                $('#Feresula'+idval).val(parseFloat(result).toFixed(2));
                $('#Feresula'+idval).css("background","#efefef");
            }
            calcTotalCostFn(idval);
            CalculateCommTotal();
        }

        function TotalKgFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            var totalkgval=$('#TotalKg'+idval).val()||0;
            var balance=$('#NetKg'+idval).val()||0;
            var numofbag=$('#NumOfBag'+idval).val()||0;
            var uomfactor=$('#uomFactor'+idval).val()||0;
            var bagweight=$('#TotalBagWeight'+idval).val()||0;
            var rembag=$('#remBagNum'+idval).val()||0;
            var remkg=$('#remKg'+idval).val()||0;
            var qtyonhand=$('#QtyOnHand'+idval).val()||0;
            var qtyonhandkg=$('#QtyOnHandByKg'+idval).val()||0;
            var adjtype = $('#AdjustmentType').val();
            var netkg=parseFloat(totalkgval)-parseFloat(bagweight);
            var feresulafac=17;
            var result=parseFloat(netkg)/parseFloat(feresulafac);
            var totalkg=parseFloat(numofbag)*parseFloat(uomfactor);
            var variance=0;
            var maxvalqnt=parseFloat(qtyonhandkg)+parseFloat(bagweight);

            $('#varianceoverage'+idval).val("");
            $('#varianceshortage'+idval).val("");
            $('#varianceLbl'+idval).html("");

            uomfactor = uomfactor == '' ? 0 : uomfactor;
            totalkgval = totalkgval == '' ? 0 : totalkgval;
            numofbag = numofbag == '' ? 0 : numofbag;

            // if(parseFloat(totalkgval)==0){
            //     $('#NetKg'+idval).val("");
            //     $('#Feresula'+idval).val("");
            //     $('#varianceoverage'+idval).val("");
            //     $('#varianceshortage'+idval).val("");
            //     $('#varianceLbl'+idval).html("");
            //     toastrMessage('error',"Zero(0) is invalid input","Error");
            // }
            if(parseFloat(totalkgval) > parseFloat(uomfactor) && parseFloat(numofbag)==0 && adjtype == "Decrease"){
                $('#TotalKg'+idval).val("");
                $('#NetKg'+idval).val("");
                $('#Feresula'+idval).val("");
                $('#Feresula'+idval).css("background","#efefef");
                $('#TotalKg'+idval).css("background",errorcolor);
                toastrMessage('error',"The maximum allowed quantity is "+parseFloat(uomfactor).toFixed(2)+" when number of bag is zero","Error");
            }
            else if(parseFloat(qtyonhandkg) < parseFloat(netkg) && adjtype == "Decrease"){
                $('#TotalKg'+idval).val("");
                $('#NetKg'+idval).val("");
                $('#Feresula'+idval).val("");
                $('#Feresula'+idval).css("background","#efefef");
                $('#TotalKg'+idval).css("background",errorcolor);
                toastrMessage('error',"The maximum allowed quantity is "+parseFloat(maxvalqnt).toFixed(2),"Error");
            }
            else if(parseFloat(qtyonhandkg) >= parseFloat(netkg) || adjtype == "Increase"){
                $('#NetKg'+idval).val(parseFloat(netkg).toFixed(2));
                $('#Feresula'+idval).val(parseFloat(result).toFixed(2));
                $('#Feresula'+idval).css("background","#efefef");
                $('#TotalKg'+idval).css("background","white");
                $('#NetKg'+idval).css("background","white");

                $('#varianceoverage'+idval).val("");
                $('#varianceshortage'+idval).val("");
                $('#varianceLbl'+idval).html("");

                if(parseFloat(netkg) > parseFloat(totalkg) && parseFloat(numofbag)>0){
                    variance=parseFloat(netkg)-parseFloat(totalkg);
                    $('#varianceoverage'+idval).val(variance.toFixed(2));
                    $('#varianceshortage'+idval).val("");
                    $('#varianceLbl'+idval).html("Variance Overage: "+ numformat(variance.toFixed(2))+" KG");
                }
                else if(parseFloat(totalkg) > parseFloat(netkg) && parseFloat(numofbag)>0){
                    variance=parseFloat(totalkg)-parseFloat(netkg);
                    $('#varianceshortage'+idval).val(variance.toFixed(2));
                    $('#varianceoverage'+idval).val("");
                    $('#varianceLbl'+idval).html("Variance Shortage: "+ numformat(variance.toFixed(2))+" KG");
                }
            }
            calcTotalCostFn(idval);
            CalculateCommTotal();
        }

        function NetKgFn(ele){
            var idval = $(ele).closest('tr').find('.vals').val();
            var totalkgval=$('#TotalKg'+idval).val()||0;
            var balance=$('#NetKg'+idval).val()||0;
            var netkg=$('#NetKg'+idval).val()||0;
            var numofbag=$('#NumOfBag'+idval).val()||0;
            var uomfactor=$('#uomFactor'+idval).val()||0;
            var bagweight=$('#TotalBagWeight'+idval).val()||0;
            var rembag=$('#remBagNum'+idval).val()||0;
            var remkg=$('#remKg'+idval).val()||0;
            var qtyonhand=$('#QtyOnHand'+idval).val()||0;
            var qtyonhandkg=$('#QtyOnHandByKg'+idval).val()||0;
            //var netkg=parseFloat(totalkgval)-parseFloat(bagweight);
            totalkgval=parseFloat(netkg)+parseFloat(bagweight);
            var adjtype = $('#AdjustmentType').val();
            var feresulafac=17;
            var result=parseFloat(netkg)/parseFloat(feresulafac);
            var totalkg=parseFloat(numofbag)*parseFloat(uomfactor);
            var variance=0;

            $('#varianceoverage'+idval).val("");
            $('#varianceshortage'+idval).val("");
            $('#varianceLbl'+idval).html("");

            // if(parseFloat(netkg)==0){
            //     $('#NetKg'+idval).val("");
            //     $('#Feresula'+idval).val("");
            //     $('#NetKg'+idval).css("background",errorcolor);
            //     $('#varianceoverage'+idval).val("");
            //     $('#varianceshortage'+idval).val("");
            //     $('#varianceLbl'+idval).html("");
            //     toastrMessage('error',"Zero(0) is invalid input","Error");
            // }
            if(parseFloat(totalkgval) > parseFloat(uomfactor) && parseFloat(numofbag)==0 && adjtype == "Decrease"){
                $('#TotalKg'+idval).val("");
                $('#NetKg'+idval).val("");
                $('#Feresula'+idval).val("");
                $('#Feresula'+idval).css("background","#efefef");
                $('#NetKg'+idval).css("background",errorcolor);
                toastrMessage('error',"The maximum allowed quantity is "+parseFloat(uomfactor).toFixed(2)+" when number of bag is zero","Error");
            }
            else if(parseFloat(qtyonhandkg) < parseFloat(netkg) && adjtype == "Decrease"){
                $('#TotalKg'+idval).val("");
                $('#NetKg'+idval).val("");
                $('#Feresula'+idval).val("");
                $('#Feresula'+idval).css("background","#efefef");
                $('#NetKg'+idval).css("background",errorcolor);
                toastrMessage('error',"The maximum allowed quantity is "+parseFloat(qtyonhandkg).toFixed(2),"Error");
            }
            else if(parseFloat(qtyonhandkg) >= parseFloat(netkg) || adjtype == "Increase"){
                $('#TotalKg'+idval).val(parseFloat(totalkgval).toFixed(2));
                $('#Feresula'+idval).val(parseFloat(result).toFixed(2));
                $('#Feresula'+idval).css("background","#efefef");
                $('#NetKg'+idval).css("background","white");

                $('#varianceoverage'+idval).val("");
                $('#varianceshortage'+idval).val("");
                $('#varianceLbl'+idval).html("");

                if(parseFloat(netkg) > parseFloat(totalkg) && parseFloat(numofbag) > 0){
                    variance=parseFloat(netkg)-parseFloat(totalkg);
                    $('#varianceoverage'+idval).val(variance.toFixed(2));
                    $('#varianceshortage'+idval).val("");
                    $('#varianceLbl'+idval).html("Variance Overage: "+ numformat(variance.toFixed(2))+" KG");
                }
                else if(parseFloat(totalkg) > parseFloat(netkg) && parseFloat(numofbag) > 0){
                    variance=parseFloat(totalkg)-parseFloat(netkg);
                    $('#varianceshortage'+idval).val(variance.toFixed(2));
                    $('#varianceoverage'+idval).val("");
                    $('#varianceLbl'+idval).html("Variance Shortage: "+ numformat(variance.toFixed(2))+" KG");
                }
            }
            calcTotalCostFn(idval);
            CalculateCommTotal();
        }

        function CalculateCommTotal(){
            var numberofbag=0;
            var totalbagweight=0;
            var totalnetkg=0;
            var totalferesula=0;
            var totalvarianceshortage=0;
            var totalvarianceoverage=0;
            var totalton=0;
            var totalcost=0;

            $.each($('#commDynamicTable').find('.NumOfBag'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    numberofbag += parseFloat($(this).val());
                }
            });

            $.each($('#commDynamicTable').find('.TotalBagWeight'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    totalbagweight += parseFloat($(this).val());
                }
            });

            $.each($('#commDynamicTable').find('.NetKg'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    totalnetkg += parseFloat($(this).val());
                }
            });

            $.each($('#commDynamicTable').find('.Feresula'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    totalferesula += parseFloat($(this).val());
                }
            });

            $.each($('#commDynamicTable').find('.varianceshortage'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    totalvarianceshortage += parseFloat($(this).val());
                }
            });

            $.each($('#commDynamicTable').find('.varianceoverage'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    totalvarianceoverage += parseFloat($(this).val());
                }
            });

            $.each($('#commDynamicTable').find('.TotalCost'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    totalcost += parseFloat($(this).val());
                }
            });

            totalton=parseFloat(totalnetkg)/1000;
            $('#totalnumberofbag').html(numformat(numberofbag.toFixed(2)));
            $('#totalbagweightbykg').html(numformat(totalbagweight.toFixed(2)));
            $('#totalnetkg').html(numformat(totalnetkg.toFixed(2)));
            $('#totalbalanceferesula').html(numformat(totalferesula.toFixed(2)));
            $('#totalvarianceshortage').html(numformat(totalvarianceshortage.toFixed(2)));
            $('#totalvarianceoverage').html(numformat(totalvarianceoverage.toFixed(2)));
            $('#totalbalanceton').html(numformat(totalton.toFixed(2)));
            $('#totalcostvaluelbl').html(numformat(parseFloat(totalcost).toFixed(2)));
            $('#commTotalTable').show();
        }

        function adjVoidFn(recordId){
            var fysetting="";
            var fyearstr="";
            $('#adjvoidid').val(recordId);
            $('.Reason').val("");
            $('#void-error').html("");

            $.ajax({
                url: '/showAdjData'+'/'+recordId,
                type: 'GET',
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
                    $.each(data.adjustmentdata, function(key, value) {
                        if(value.Status == "Draft" || value.Status == "Pending" || value.Status == "Verified"){
                            $("#adjvoidmodal").modal('show');
                        }
                        else{
                            toastrMessage('error',"You cant void on this status","Error");
                        }
                    });
                }
            });
        }

        //Void adjustment starts
        $('#voidadjbtn').click(function() {
            var deleteForm = $("#adjustmentvoidform");
            var formData = deleteForm.serialize();
            $.ajax({
                url: '/voidCommAdj',
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
                    $('#voidadjbtn').text('Voiding...');
                    $('#voidadjbtn').prop("disabled", true);
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
                        if (data.errors.Reason) {
                            $('#void-error').html(data.errors.Reason[0]);
                        }
                        $('#voidadjbtn').text('Void');
                        $('#voidadjbtn').prop("disabled", false);
                        toastrMessage('error',"Check your inputs","Error");
                    }
                    else if (data.dberrors) {
                        $('#voidadjbtn').text('Void');
                        $('#voidadjbtn').prop("disabled",false);
                        $("#adjvoidmodal").modal('hide');
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if (data.success) {
                        $('#voidadjbtn').text('Void');
                        toastrMessage('success',"Successful","Success");
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                        $("#adjvoidmodal").modal('hide');
                        $('#voidadjbtn').prop("disabled", false);
                    }
                }
            });
        });
        //Void adjustment ends

        function adjUndoVoidFn(recordId) { 
            var settcnt=0;
            var detcnt=0;
            $('#undovoidid').val(recordId);

            $.ajax({
                url: '/showAdjData'+'/'+recordId,
                type: 'GET',
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
                    $.each(data.adjustmentdata, function(key, value) {
                        if(value.Status == "Void" || value.Status == "Void(Draft)" || value.Status == "Void(Pending)" || value.Status == "Void(Verified)"){
                            $("#undovoidmodal").modal('show');
                        }
                        else{
                            toastrMessage('error',"You cant undo void on this status","Error");
                        }
                    });
                }
            });
        }

        //Undo void adjustment starts
        $('#undovoidbtn').click(function() {
            var deleteForm = $("#undovoidform");
            var formData = deleteForm.serialize();
            $.ajax({
                url: '/undoVoidCommAdj',
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
                    $('#undovoidbtn').text('Changing...');
                    $('#undovoidbtn').prop("disabled", true);
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
                        $('#undovoidbtn').text('Undo Void');
                        $('#undovoidbtn').prop("disabled",false);
                        $("#undovoidmodal").modal('hide');
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if (data.success) {
                        $('#undovoidbtn').text('Undo Void');
                        toastrMessage('success',"Successful","Success");
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                        $("#undovoidmodal").modal('hide');
                        $('#undovoidbtn').prop("disabled", false);
                    }
                }
            });
        });
        //Undo void adjustment ends

        function forwardActionFn() {
            const requestId = $('#adjId').val();
            const currentStatus = $('#currentStatus').val();
            const transition = statusTransitions[currentStatus].forward;

            $('#forwardReqId').val(requestId);
            $('#newForwardStatusValue').val(transition.status);
            $('#forwardActionLabel').html(transition.message);
            $('#forwarkBtnTextValue').val(transition.text);
            $('#forwardActionBtn').text(transition.text);
            $('#forwardActionValue').val(transition.action);
            $("#modalBodyId").css({"background-color":transition.backcolor});
            $("#forwardActionLabel").css({'color':transition.forecolor});
            $('#forwardActionModal').modal('show');
        }

        $('.backwardbtn').click(function(){
            const requestId = $('#adjId').val();
            const currentStatus = $('#currentStatus').val();

            const transition = $(this).attr('id') == "rejectbtn" ? statusTransitions[currentStatus].reject : statusTransitions[currentStatus].backward;

            $('#backwardReqId').val(requestId);
            $('#newBackwardStatusValue').val(transition.status);
            $('#backwardActionLabel').html(transition.message);
            $('#backwardBtnTextValue').val(transition.text);
            $('#backwardActionBtn').text(transition.text);
            $('#backwardActionValue').val(transition.action);
            $('#CommentOrReason').val("");
            $('#commentres-error').html("");
            $('#backwardActionModal').modal('show');
        });

        $('#forwardActionBtn').click(function() {
            var forwardForm = $("#forwardActionForm");
            var formData = forwardForm.serialize();
            var btntxt = $('#forwarkBtnTextValue').val();
            $.ajax({
                url: '/adjForwardAction',
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
                    $('#forwardActionBtn').text('Changing...');
                    $('#forwardActionBtn').prop("disabled", true);
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
                    $('#forwardActionBtn').text(btntxt);
                    $('#forwardActionBtn').prop("disabled",false);
                },
                success: function(data) {
                    if (data.dberrors) {
                        $('#forwardActionBtn').text(btntxt);
                        $('#forwardActionBtn').prop("disabled",false);
                        $("#forwardActionModal").modal('hide');
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if (data.success) {
                        toastrMessage('success',"Successful","Success");
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                        $("#forwardActionModal").modal('hide');
                        $("#infomodal").modal('hide');
                    }
                }
            });
        });

        $("#backwardActionBtn").click(function() {
            var registerForm = $("#backwardActionForm");
            var formData = registerForm.serialize();
            var btntxt = $('#backwardBtnTextValue').val();

            $.ajax({
                url: '/adjBackwardAction',
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
                            $('#commentres-error').html(data.errors.CommentOrReason[0]);
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
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                        $('#backwardActionModal').modal('hide');
                        $('#infomodal').modal('hide');
                    }
                }
            });
        });

        //Start Print Attachment
        function commAdjAttFn(recId){
            var link="/adjcomm/"+recId;
            window.open(link, 'Adjustment', 'width=1200,height=800,scrollbars=yes');
        }

        $('body').on('click', '.printAdjustmentAttachments', function() {
            var id = $(this).data('id');
            var link="/adjcomm/"+id;
            window.open(link, 'Adjustment', 'width=1200,height=800,scrollbars=yes');
        });
        //End Print Attachment

        //start select item
        function itemVal(ele) {
            var stid = $(ele).closest('tr').find('.storeid').val();
            var itid = $(ele).closest('tr').find('.itemName').val();
            var idval = $(ele).closest('tr').find('.idval').val();
            var arr = [];
            var found = 0;
            var storeidvar = $('#sstore').val();
            var registerForm = $("#Register");
            var formData = registerForm.serialize();
            $('.itemName').each (function() 
            { 
                var name=$(this).val();
                if(arr.includes(name))
                found++;
                else
                arr.push(name);
            });
            if(found) 
            {
                toastrMessage('error',"Item already exist","Error"); 
                $(ele).closest('tr').find('.itemName').val("0").trigger('change');
                $(ele).closest('tr').find('.PartNumber').val("");
                $(ele).closest('tr').find('.Code').val("");
                $(ele).closest('tr').find('.uom').val("");
                $(ele).closest('tr').find('.UnitCost').val("");
                $(ele).closest('tr').find('.quantity').val("");
                $(ele).closest('tr').find('.AvQuantity').val("");
                $('#select2-itemNameSl'+idval+'-container').parent().css('background-color',errorcolor);
            }
            else{
                $.ajax({
                    url: 'getItemBalance/' + itid,
                    type: 'DELETE',
                    data: formData,
                    success: function(data) {
                        if (data.sid) {
                            var len = data['sid'].length;
                            for (var i = 0; i <= len; i++) {
                                var quantitys = (data['sid'][i].AvailableQuantity);
                                var salesqty = (data['salesqnt'][i].TotalSalesQuantity);
                                var transferqty = (data['trnqnt'][i].TotalTrnQuantity);
                                var requistionqty = (data['reqqnt'][i].TotalReqQuantity);
                                var totalquantity=parseFloat(quantitys)-parseFloat(salesqty)-parseFloat(transferqty)-parseFloat(requistionqty);
                                var partnum = (data['itinfo'][i].PartNumber);
                                var uoms = (data['itinfo'][i].UOM);
                                var codes = (data['itinfo'][i].Code);
                                var itemname = (data['itinfo'][i].Name);
                                var maxcost = (data['getCost'][i].UnitCost);
                                $(ele).closest('tr').find('.PartNumber').val(partnum);
                                $(ele).closest('tr').find('.Code').val(codes);
                                $(ele).closest('tr').find('.uom').val(uoms);
                                $(ele).closest('tr').find('.UnitCost').val(maxcost);
                                $(ele).closest('tr').find('.quantity').val("");
                                if (parseFloat(totalquantity) == null||parseFloat(totalquantity)<=0) {
                                    $(ele).closest('tr').find('.AvQuantity').val("0");
                                }
                                else if (parseFloat(totalquantity)>0) {
                                    $(ele).closest('tr').find('.AvQuantity').val(totalquantity);
                                }

                                if(parseFloat(salesqty)>0||parseFloat(transferqty)>0||parseFloat(requistionqty)>0){
                                    //toastrMessage('info',itemname+"<br>Pending Sales: "+salesqty+"<br>Pending Transfer: "+transferqty+"<br>Pending Requisition: "+requistionqty,"Info");
                                }
                            }
                        }
                    },
                });
                $('#select2-itemNameSl'+idval+'-container').parent().css('background-color',"white");
            }
        }
        //end select type

        //start quantity check
        function checkQ(ele) {
            var availableq = $(ele).closest('tr').find('.AvQuantity').val()||0;
            var quantity = $(ele).closest('tr').find('.quantity').val();
            if (parseFloat(quantity) > parseFloat(availableq)) {
                toastrMessage('error',"There is no available quantity","Error");
                $(ele).closest('tr').find('.quantity').val("");
            }
            if (parseFloat(quantity) == 0) {
                $(ele).closest('tr').find('.quantity').val("");
            }
            $(ele).closest('tr').find('.quantity').css("background","white");
        }
        //end quantity check

        //start quantity check
        function findQuantitys(ele) {
            var availableq = $('#itemquantity').val();
            var quantity = $('#reqquantity').val();
            if (parseFloat(quantity) > parseFloat(availableq)) {
                toastrMessage('error',"There is no available quantity","Error");
                $('#reqquantity').val("");
            }
            if (parseFloat(quantity) == 0) {
                $('#reqquantity').val("");
            }
            $('#newquantity-error').html("");
        }
        //end quantity check

        //Start remove item dynamically
        $(document).on('click', '.remove-tr', function() {
            $(this).parents('tr').remove();
            renumberRows();
            --i;
        });
        //End remove item dynamically

        //Start reorder number
        function renumberRows() {
            var ind;
            $('#dynamicTable tr').each(function(index, el) {
                $(this).children('td').first().text(index++);
                $('#numberofItems').val(index - 1);
                $('#numberofItemsLbl').text(index - 1);
                ind = index - 1;
            });
            if (ind == 0) {
                $('.totalrownumber').hide();
            }
            else{
                $('.totalrownumber').show();
            }
        }
        //End reorder table

        //edit modal open
        function adjEditFn(recordId) {
            $('.select2').select2();
            $('#operationtypes').val("2");
            $('#adjustmentId').val(recordId);
            $(".productcls").hide();
            $("#commDynamicTable > tbody").empty();
            var sourcestr="";
            var cmnt;
            var statusvals;
            var reqreason="";
            var backcolor = "";
            j=0;
            j2=0;

            $.ajax({
                url: '/showAdjData'+'/'+recordId,
                type: 'GET',
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
                    $.each(data.adjustmentdata, function(key, value) {
                        $('#ProductType').val(value.product_type).select2({minimumResultsForSearch: -1});
                        $('#CompanyType').val(value.company_type).select2({minimumResultsForSearch: -1});
                        $('#AdjustmentType').val(value.Type).select2({minimumResultsForSearch: -1});
                        $('#Customer').val(value.customers_id).select2({dropdownCssClass:'commprp'});

                        $('#sstore').val(value.StoreId).select2();
                        $('#date').val(value.AdjustedDate);
                        $('#Purpose').val(value.Memo);

                        if(parseInt(value.company_type) == 1){
                            $(".customerdiv").hide();
                        }
                        else if(parseInt(value.company_type) == 2){
                            $(".customerdiv").show();
                        }

                        if(value.Status=="Draft"){
                            $("#statusdisplay").html("<span style='color:#A8AAAE;font-weight:bold;font-size:16px;text-align:right;'>"+value.DocumentNumber+" , "+value.Status+"</span>");
                        }
                        else if(value.Status=="Pending"){
                            $("#statusdisplay").html("<span style='color:#f6c23e;font-weight:bold;font-size:16px;text-align:right;'>"+value.DocumentNumber+" , "+value.Status+"</span>");
                        }
                        else if(value.Status=="Verified"){
                            $("#statusdisplay").html("<span style='color:#00CFE8;font-weight:bold;font-size:16px;text-align:right;'>"+value.DocumentNumber+" , "+value.Status+"</span>");
                        }
                        else if(value.Status=="Approved"){
                            $("#statusdisplay").html("<span style='color:#1cc88a;font-weight:bold;font-size:16px;text-align:right;'>"+value.DocumentNumber+" , "+value.Status+"</span>");
                        }
                        else if(value.Status=="Void"||value.Status=="Void(Pending)"||value.Status=="Void(Approved)")
                        {
                            $("#statusdisplay").html("<span style='color:#e74a3b;font-weight:bold;font-size:16px;text-align:right;'>"+value.DocumentNumber+" , "+value.Status+"</span>");
                        }
                        else{
                            $("#statusdisplay").html("<span style='color:#e74a3b;font-weight:bold;font-size:16px;text-align:right;'>"+value.DocumentNumber+" , "+value.Status+"</span>");
                        }
                    });

                    $.each(data.adjustmentdetaildata, function(key, value) {
                        ++i2;
                        ++m2;
                        ++j2;

                        if(parseInt(j2) % 2 === 0){
                            backcolor = "#f8f9fa";
                        }
                        else{
                            backcolor = "#FFFFFF";
                        } 

                        $("#commDynamicTable > tbody").append('<tr id="rowind'+m2+'" class="mb-1" style="background-color:'+backcolor+';"><td style="width:2%;text-align:left;vertical-align: top;">'+
                                '<span class="badge badge-center rounded-pill bg-secondary">'+j2+'</span>'+
                            '</td>'+
                            '<td style="display:none;"><input type="hidden" name="row['+m2+'][vals]" id="vals'+m2+'" class="vals form-control" readonly="true" style="font-weight:bold;" value="'+m2+'"/></td>'+
                            '<td style="width:96%;">'+
                                '<div class="row">'+
                                    '<div class="col-xl-7 col-md-6 col-lg-6" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">'+
                                        '<div class="row">'+
                                            '<div class="col-xl-2 col-md-4 col-lg-3 mb-1">'+
                                                '<label style="font-size: 12px;">Reason</label><label style="color: red; font-size:16px;">*</label>'+
                                                '<select id="Reason'+m2+'" class="select2 form-control Reason" onchange="reasonFn(this)" name="row['+m2+'][Reason]"></select>'+
                                            '</div>'+
                                            '<div class="col-xl-2 col-md-4 col-lg-3 mb-1">'+
                                                '<label style="font-size: 12px;">Floor Map</label><label style="color: red; font-size:16px;">*</label>'+
                                                '<select id="FloorMap'+m2+'" class="select2 form-control FloorMap" onchange="FloorMapFn(this)" name="row['+m2+'][FloorMap]"></select>'+
                                            '</div>'+
                                            '<div class="col-xl-3 col-md-4 col-lg-3 mb-1">'+
                                                '<label style="font-size: 12px;">Type</label><label style="color: red; font-size:16px;">*</label>'+
                                                '<select id="CommType'+m2+'" class="select2 form-control CommType" onchange="CommTypeFn(this)" name="row['+m2+'][CommType]"></select>'+
                                            '</div>'+
                                            '<div class="col-xl-3 col-md-4 col-lg-4 mb-1 typedt typeprop'+m2+'" id="supplierdiv'+m2+'" style="display:none;">'+
                                                '<label style="font-size: 12px;">Supplier</label><label style="color: red; font-size:16px;">*</label>'+
                                                '<select id="Supplier'+m2+'" class="select2 form-control Supplier" onchange="SupplierFn(this)" name="row['+m2+'][Supplier]"></select>'+
                                            '</div>'+
                                            '<div class="col-xl-2 col-md-4 col-lg-4 mb-1 typedt typeprop'+m2+'" id="grndiv'+m2+'" style="display:none;">'+
                                                '<label style="font-size: 12px;">GRN No.</label><label style="color: red; font-size:16px;">*</label>'+
                                                '<select id="GrnNumber'+m2+'" class="select2 form-control GrnNumber" onchange="GrnNumberFn(this)" name="row['+m2+'][GrnNumber]"></select>'+
                                            '</div>'+
                                            '<div class="col-xl-3 col-md-4 col-lg-4 mb-1 typedt typeprop'+m2+'" id="productiondiv'+m2+'" style="display:none;">'+
                                                '<label style="font-size: 12px;">Production Order , Cert No.</label><label style="color: red; font-size:16px;">*</label>'+
                                                '<select id="ProductionNum'+m2+'" class="select2 form-control ProductionNum" onchange="ProductionNumFn(this)" name="row['+m2+'][ProductionNum]"></select>'+
                                            '</div>'+
                                            '<div class="col-xl-2 col-md-4 col-lg-4 mb-1 typedt typeprop'+m2+'" id="cernumdiv'+m2+'" style="display:none;">'+
                                                '<label style="font-size: 12px;">Certificate No.</label><label style="color: red; font-size:16px;">*</label>'+
                                                '<select id="CertificateNum'+m2+'" class="select2 form-control CertificateNum" onchange="CertificateNumFn(this)" name="row['+m2+'][CertificateNum]"></select>'+
                                            '</div>'+
                                            '<div class="col-xl-2 col-md-4 col-lg-4 mb-1 expcertcls exptypeprop'+m2+'" id="expcernumdiv'+m2+'" style="display:none;">'+
                                                '<label style="font-size: 12px;">Export Certificate No.</label>'+
                                                '<input type="number" name="row['+m2+'][ExpCertificateNum]" placeholder="Write Export Certificate Number here" id="ExpCertificateNum'+m2+'" class="ExpCertificateNum form-control commnuminp" onkeyup="ExpCertificateNumFn(this)" onblur="ExpCertificateNumBlFn(this)" onkeypress="return ValidateOnlyNum(event);"/>'+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="row">'+
                                            '<div class="col-xl-3 col-md-4 col-lg-4 mb-1">'+
                                                '<label style="font-size: 12px;">Commodity</label><label style="color: red; font-size:16px;">*</label>'+
                                                '<select id="Origin'+m2+'" class="select2 form-control Origin" onchange="OriginFn(this)" name="row['+m2+'][Origin]"></select>'+
                                            '</div>'+

                                            '<div class="col-xl-2 col-md-4 col-lg-4 mb-1">'+
                                                '<label style="font-size: 12px;">Grade</label><label style="color: red; font-size:16px;">*</label>'+
                                                '<select id="Grade'+m2+'" class="select2 form-control Grade" onchange="GradeFn(this)" name="row['+m2+'][Grade]"></select>'+
                                            '</div>'+
                                        
                                            '<div class="col-xl-2 col-md-4 col-lg-4 mb-1">'+
                                                '<label style="font-size: 12px;">Process Type</label><label style="color: red; font-size:16px;">*</label>'+
                                                '<select id="ProcessType'+m2+'" class="select2 form-control ProcessType" onchange="ProcessTypeFn(this)" name="row['+m2+'][ProcessType]"></select>'+
                                            '</div>'+
                                            '<div class="col-xl-2 col-md-4 col-lg-4 mb-1">'+
                                                '<label style="font-size: 12px;">Crop Year</label><label style="color: red; font-size:16px;">*</label>'+
                                                '<select id="CropYear'+m2+'" class="select2 form-control CropYear" onchange="CropYearFn(this)" name="row['+m2+'][CropYear]"></select>'+
                                            '</div>'+
                                            '<div class="col-xl-3 col-md-4 col-lg-4 mb-1">'+
                                                '<label style="font-size: 12px;">Remark</label>'+
                                                '<textarea type="text" placeholder="Write Remark here..." class="Remark form-control mainforminp" rows="1" name="row['+m2+'][Remark]" id="Remark'+m2+'"></textarea>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="col-xl-5 col-md-6 col-lg-6">'+
                                        '<div class="row">'+
                                            '<div class="col-xl-3 col-md-4 col-lg-4 mb-1">'+
                                                '<label style="font-size: 12px;">UOM/Bag</label><label style="color: red; font-size:16px;">*</label>'+
                                                '<select id="Uom'+m2+'" class="select2 form-control Uom" onchange="UomFn(this)" name="row['+m2+'][Uom]"></select>'+
                                            '</div>'+
                                            '<div class="col-xl-2 col-md-4 col-lg-4 mb-0">'+
                                                '<label style="font-size: 12px;">No. of Bag</label><label style="color: red; font-size:16px;">*</label>'+
                                                '<input type="number" name="row['+m2+'][NumOfBag]" placeholder="Write Number of bag here" id="NumOfBag'+m2+'" class="NumOfBag form-control numeral-mask commnuminp" onkeyup="NumOfBagFn(this)" step="any" value="'+value.NumOfBag+'" onkeypress="return ValidateOnlyNum(event);"/>'+
                                            '</div>'+
                                            '<div class="col-xl-3 col-md-4 col-lg-4 mb-0">'+
                                                '<label style="font-size: 12px;">Bag Weight by KG</label><label style="color: red; font-size:16px;">*</label>'+
                                                '<input type="number" name="row['+m2+'][TotalBagWeight]" placeholder="Bag weight" id="TotalBagWeight'+m2+'" class="TotalBagWeight form-control numeral-mask commnuminp" onkeyup="BagWeightFn(this)" step="any" value="'+value.BagWeight+'" readonly onkeypress="return ValidateNum(event);" style="font-weight:bold;"/>'+
                                            '</div>'+
                                            '<div class="col-xl-4 col-md-4 col-lg-4 mb-1">'+
                                                '<label style="font-size: 12px;" class="qtyonhandcls">Qty. on Hand</label>'+
                                                '<div class="row qtyonhandcls" style="border: 0.1px solid #d9d7ce;">'+
                                                    '<div class="col-xl-6 col-md-6 col-lg-6">'+
                                                        '<label style="font-size: 11px;">No. of Bag</label>'+
                                                    '</div>'+
                                                    '<div class="col-xl-6 col-md-6 col-lg-6">'+
                                                        '<b><label id="avqtybyuom'+m2+'" class="qtydata" style="font-size: 11px;"></label></b>'+
                                                    '</div>'+
                                                    '<div class="col-xl-6 col-md-6 col-lg-6">'+
                                                        '<label style="font-size: 11px;">Weight by KG</label>'+
                                                    '</div>'+
                                                    '<div class="col-xl-6 col-md-6 col-lg-6">'+
                                                        '<b><label id="avqtybykg'+m2+'" class="qtydata" style="font-size: 11px;"></label></b>'+
                                                    '</div>'+
                                                    '<div class="col-xl-6 col-md-6 col-lg-6 mb-0" style="text-align:left;">'+
                                                        '<label style="font-size: 11px;" id="reqferesulalbl'+m2+'">Feresula</label>'+
                                                    '</div>'+ 
                                                    '<div class="col-xl-6 col-md-6 col-lg-6 mb-0" style="text-align:left;">'+
                                                        '<label style="font-size: 11px;font-weight:bold;" id="reqferesula'+m2+'" class="qtydata"></label>'+
                                                    '</div>'+ 
                                                '</div>'+
                                            '</div>'+

                                            '<div class="col-xl-3 col-md-3 col-lg-3">'+
                                                '<label style="font-size: 12px;">Total KG</label><label style="color: red; font-size:16px;">*</label>'+
                                                '<input type="number" name="row['+m2+'][TotalKg]" placeholder="Write total kg here..." id="TotalKg'+m2+'" class="TotalKg form-control numeral-mask commnuminp" onkeyup="TotalKgFn(this)" onkeypress="return ValidateNum(event);" value="'+value.TotalKg+'" step="any"/>'+
                                            '</div>'+
                                            '<div class="col-xl-3 col-md-3 col-lg-3">'+
                                                '<label style="font-size: 12px;">Net KG</label><label style="color: red; font-size:16px;">*</label>'+
                                                '<input type="number" name="row['+m2+'][NetKg]" placeholder="Write Net KG here..." id="NetKg'+m2+'" class="NetKg form-control numeral-mask commnuminp" onkeyup="NetKgFn(this)" onkeypress="return ValidateNum(event);" step="any" value="'+value.NetKg+'"/>'+
                                            '</div>'+
                                            '<div class="col-xl-2 col-md-2 col-lg-2">'+
                                                '<label style="font-size: 12px;">Feresula<i class="fa-solid fa-circle-info" title="Net KG / 17"></i></label>'+
                                                '<input type="number" name="row['+m2+'][Feresula]" placeholder="Write Feresula here..." id="Feresula'+m2+'" class="Feresula form-control numeral-mask commnuminp" onkeypress="return ValidateNum(event);" step="any" value="'+value.Feresula+'"/>'+
                                            '</div>'+
                                            '<div class="col-xl-4 col-md-4 col-lg-4">'+
                                                '<label style="font-size: 12px;" class="unit_cost_price_cls">Unit Cost</label>'+
                                                '<input type="number" name="row['+m2+'][UnitCost]" placeholder="Write here..." id="UnitCost'+m2+'" class="UnitCost form-control numeral-mask commnuminp" onkeyup="unitCostFn(this)" onkeypress="return ValidateNum(event);" value="'+value.unit_cost_or_price+'" step="any"/>'+
                                            '</div>'+
                                            
                                            '<div class="col-xl-3 col-md-3 col-lg-3 mb-0"></div>'+
                                            '<div class="col-xl-5 col-md-5 col-lg-5 mb-0">'+
                                                '<label style="font-size: 12px;font-weight:bold;" class="variancecls" id="varianceLbl'+m2+'"></label>'+
                                            '</div>'+
                                            '<div class="col-xl-4 col-md-4 col-lg-4 mb-0">'+
                                                '<label style="font-size: 12px;font-weight:bold;" class="totalcostcls" id="totalcostLbl'+m2+'"></label>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</td>'+
                            '<td style="width:2%;text-align:right;vertical-align: top;">'+
                                '<button type="button" id="commremovebtn'+m2+'" class="btn btn-light btn-sm commremove-tr" style="color:#ea5455;background-color:'+backcolor+';border-color:'+backcolor+';padding: 4px 5px;"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button>'+
                            '</td>'+
                            '<td style="display:none;"><input type="number" name="row['+m2+'][TotalCost]" placeholder="Total Cost" id="TotalCost'+m2+'" class="TotalCost form-control numeral-mask commnuminp" readonly onkeypress="return ValidateNum(event);" style="font-weight:bold;"/></td>'+
                            '<td style="display:none;"><input type="number" name="row['+m2+'][QtyOnHand]" placeholder="Quantity on Hand" id="QtyOnHand'+m2+'" class="QtyOnHand form-control numeral-mask commnuminp" readonly onkeypress="return ValidateNum(event);" style="font-weight:bold;"/></td>'+
                            '<td style="display:none;"><input type="number" name="row['+m2+'][QtyOnHandByKg]" placeholder="Quantity on Hand" id="QtyOnHandByKg'+m2+'" class="QtyOnHandByKg form-control numeral-mask commnuminp" readonly onkeypress="return ValidateNum(event);" style="font-weight:bold;"/></td>'+
                            '<td style="display:none;"><input type="number" name="row['+m2+'][remBagNum]" id="remBagNum'+m2+'" class="remBagNum form-control numeral-mask" style="font-weight:bold;" step="any" readonly/></td>'+
                            '<td style="display:none;"><input type="number" name="row['+m2+'][remKg]" id="remKg'+m2+'" class="remKg form-control numeral-mask" style="font-weight:bold;" step="any" readonly/></td>'+
                            '<td style="display:none;"><input type="number" name="row['+m2+'][bagWeight]" id="bagWeight'+m2+'" class="bagWeight form-control numeral-mask" style="font-weight:bold;" step="any" readonly/></td>'+
                            '<td style="display:none;"><input type="number" name="row['+m2+'][uomFactor]" id="uomFactor'+m2+'" class="uomFactor form-control numeral-mask" style="font-weight:bold;" step="any" readonly/></td>'+
                            '<td style="display:none;"><input type="number" name="row['+m2+'][varianceshortage]" id="varianceshortage'+m2+'" class="varianceshortage form-control numeral-mask" style="font-weight:bold;" step="any" readonly/></td>'+
                            '<td style="display:none;"><input type="number" name="row['+m2+'][varianceoverage]" id="varianceoverage'+m2+'" class="varianceoverage form-control numeral-mask" style="font-weight:bold;" step="any" readonly/></td>'+
                            '<td style="display:none;"><input type="hidden" name="row['+m2+'][id]" id="id'+m2+'" class="id form-control" readonly="true" style="font-weight:bold;"/></td>'+
                        '</tr>');

                        var commtypename="";
                        var mergeddata="";
                        var originmergeddata="";
                        var resoption="";
                        var defaultreason='<option selected value='+value.Reason+'>'+value.Reason+'</option>';
                        var defaultfloormap='<option selected value='+value.LocationId+'>'+value.LocationName+'</option>';
                        var defaultcommodity='<option selected value='+value.woredas_id+'>'+value.Origin+'</option>';
                        var defaultcommoditytype='<option selected value='+value.CommTypeId+'>'+value.CommType+'</option>';
                        var defaultgrade='<option selected value='+value.Grade+'>'+value.GradeName+'</option>';
                        var defaultcropyear='<option selected value='+value.CropYear+'>'+value.CropYearData+'</option>';
                        var defaultprocesstype='<option selected value='+value.ProcessType+'>'+value.ProcessType+'</option>';
                        var defaultuom='<option selected value='+value.uoms_id+'>'+value.UomName+'</option>';
                        var defaultsupplier = '<option selected value='+value.SupplierId+'>'+value.SupplierCode+'   ,   '+value.SupplierName+'   ,   '+value.SupplierTIN+'</option>';
                        var defaultgrndata='<option selected value='+value.GrnNumber+'>'+value.GrnNumber+'</option>';
                        var defaultprdorder='<option selected value='+value.ProductionNumber+'>'+value.ProductionNumber+'   ,   '+value.CertNumber+'</option>';
                        var defaultcertdata='<option selected value='+value.CertNumber+'>'+value.CertNumber+'</option>';
                        
                        var prddoc = $('#ProductionNum'+m2+' option[value="' + value.ProductionNumber + '"]').attr('label');

                        if(value.AdjustmentType == "Increase"){
                            $('.qtyonhandcls').hide();
                            resoption = "inc";
                            $('.UnitCost').prop("readonly",false);
                            $('.unit_cost_price_cls').html("Unit Price");
                            $('.total_cost_price_cls').html("Total Price");
                        }
                        if(value.AdjustmentType == "Decrease"){
                            $('.qtyonhandcls').show();
                            resoption = "dec";
                            $('.UnitCost').prop("readonly",true);
                            $('.unit_cost_price_cls').html("Unit Cost");
                            $('.total_cost_price_cls').html("Total Cost");
                        }

                        var reasonopt = $("#reasondefault > option").clone();
                        $('#Reason'+m2).append(reasonopt);

                        $("#Reason"+m2+" option[data-type!="+resoption+"]").remove(); 
                        $("#Reason"+m2+" option[value="+value.Reason+"]").remove(); 
                        $('#Reason'+m2).append(defaultreason);
                        $('#Reason'+m2).select2
                        ({
                            placeholder: "Select reason here",
                            dropdownCssClass : 'cusprop',
                        });

                        var floormapopt = $("#locationdefault > option").clone();
                        $('#FloorMap'+m2).append(floormapopt);
                        $("#FloorMap"+m2+" option[title!="+value.StoreId+"]").remove(); 
                        $("#FloorMap"+m2+" option[value="+value.LocationId+"]").remove(); 
                        $('#FloorMap'+m2).append(defaultfloormap);
                        $('#FloorMap'+m2).select2
                        ({
                            placeholder: "Select Floor map here",
                            dropdownCssClass : 'cusprop',
                        });

                        $('.typeprop'+m2).hide();
                        if (parseInt(value.CommTypeId)==1){
                            commtypename="Arrival";
                            $('#supplierdiv'+m2).show();
                            $('#grndiv'+m2).show();
                            mergeddata=value.GrnNumber;
                            originmergeddata=value.CommodityId+""+value.SupplierId+""+value.GrnNumber;
                        }
                        else if (parseInt(value.CommTypeId)==2){
                            commtypename="Export";
                            $('#cernumdiv'+m2).show();
                            $('#productiondiv'+m2).show();
                            mergeddata=value.CommTypeId+""+prddoc;
                            originmergeddata=value.CommodityId+""+value.ProductionOrderNo+""+value.CertNumber;
                        }
                        else if (parseInt(value.CommTypeId)==3){
                            commtypename="Reject";
                            $('#cernumdiv'+m2).hide();
                            $('#productiondiv'+m2).hide();
                            mergeddata=value.CommTypeId+""+prddoc;
                            originmergeddata=value.CommodityId+""+value.ProductionOrderNo+""+value.CertNumber;
                        }
                        else if (parseInt(value.CommTypeId)==4){
                            commtypename="Others(Pre-Clean)";
                            $('#supplierdiv'+m2).show();
                            $('#grndiv'+m2).show();
                            mergeddata=value.GrnNumber;
                            originmergeddata=value.CommodityId+""+value.ProductionOrderNo+""+value.CertNumber;
                        }
                        else if (parseInt(value.CommTypeId)==5){
                            commtypename="Others(Export-Excess)";
                            $('#cernumdiv'+m2).show();
                            $('#productiondiv'+m2).show();
                            mergeddata=value.CommTypeId+""+prddoc;
                            originmergeddata=value.CommodityId+""+value.ProductionOrderNo+""+value.CertNumber;
                        }
                        else if (parseInt(value.CommTypeId)==6){
                            commtypename="Others(Cancelled-Export)";
                            $('#cernumdiv'+m2).show();
                            $('#productiondiv'+m2).show();
                            mergeddata=value.CommTypeId+""+prddoc;
                            originmergeddata=value.CommodityId+""+value.ProductionOrderNo+""+value.CertNumber;
                        }

                        var commtypeoptions = $("#commtypedefault > option").clone();
                        $('#CommType'+m2).append(commtypeoptions);

                        if(parseInt(value.RequestReason)==9){
                            $('#CommType'+m2+' option').each(function() {
                                var optionValue = $(this).val();
                                if(parseInt(optionValue)!=1){
                                    $(this).remove();
                                }
                            });
                        }

                        $("#CommType"+m2+" option[value='"+value.CommTypeId+"']").remove(); 
                        $('#CommType'+m2).append(defaultcommoditytype);
                        $('#CommType'+m2).select2
                        ({
                            placeholder: "Select here",
                            dropdownCssClass : 'cusmidprp',
                        });

                        var supplieropt = $("#supplierdefault > option").clone();
                        $('#Supplier'+m2).append(supplieropt);
                        $("#Supplier"+m2+" option[value='"+value.SupplierId+"']").remove(); 
                        $('#Supplier'+m2).append(defaultsupplier);
                        $('#Supplier'+m2).select2
                        ({
                            placeholder: "Select Supplier here",
                            dropdownCssClass : 'commprp',
                        });

                        var grnoption = $("#grndefault > option").clone();
                        $('#GrnNumber'+m2).append(grnoption);
                        $("#GrnNumber"+m2+" option[title!='"+value.SupplierId+"']").remove(); 
                        $("#GrnNumber"+m2+" option[value='"+value.GrnNumber+"']").remove(); 
                        $('#GrnNumber'+m2).append(defaultgrndata);
                        $('#GrnNumber'+m2).select2
                        ({
                            placeholder: "Select GRN number here",
                        });

                        var prdorderopt = $("#productionorderdefault > option").clone();
                        $('#ProductionNum'+m2).append(prdorderopt);
                        $("#ProductionNum"+m2+" option[title!="+value.CustomerOrOwner+"]").remove(); 
                        $("#ProductionNum"+m2+" option[value='"+value.ProductionOrderNo+"']").remove(); 
                        $('#ProductionNum'+m2).append(defaultprdorder);
                        $('#ProductionNum'+m2).select2
                        ({
                            placeholder: "Select Production order number here",
                            dropdownCssClass : 'cusprop', 
                        });

                        var certnumberdata = $("#certNumberdefault > option").clone();
                        
                        $('#CertificateNum'+m2).append(certnumberdata);
                        $("#CertificateNum"+m2+" option[title!='"+prddoc+"']").remove(); 
                        $("#CertificateNum"+m2+" option[value='"+value.CertNumber+"']").remove();
                        $('#CertificateNum'+m2).append(defaultcertdata);
                        $('#CertificateNum'+m2).select2
                        ({
                            placeholder: "Select Certificate number here",
                        });

                        var originoptions = $("#origindefault > option").clone();
                        $('#Origin'+m2).append(originoptions);
                        $("#Origin"+m2+" option[title!='"+mergeddata+"']").remove(); 
                        $("#Origin"+m2+" option[value='"+value.CommodityId+"']").remove(); 
                        $('#Origin'+m2).append(defaultcommodity);
                        $('#Origin'+m2).select2
                        ({
                            placeholder: "Select Commodity here",
                            dropdownCssClass : 'commprp',
                        });

                        var gradeoption = $("#gradedefault > option").clone();
                        $('#Grade'+m2).append(gradeoption);
                        $("#Grade"+m2+" option[title!='"+originmergeddata+"']").remove(); 
                        $("#Grade"+m2+" option[value='"+value.Grade+"']").remove(); 
                        $('#Grade'+m2).append(defaultgrade);
                        $('#Grade'+m2).select2
                        ({
                            placeholder: "Select Grade here",
                            dropdownCssClass : 'cusprop',
                        });

                        var processtypeoption = $("#processtypedefault > option").clone();
                        $('#ProcessType'+m2).append(processtypeoption);
                        $("#ProcessType"+m2+" option[title!='"+originmergeddata+"']").remove(); 
                        $("#ProcessType"+m2+" option[value='"+value.ProcessType+"']").remove(); 
                        $('#ProcessType'+m2).append(defaultprocesstype);
                        $('#ProcessType'+m2).select2
                        ({
                            placeholder: "Select Process type here",
                            dropdownCssClass : 'cusprop',
                        });

                        var cropyearoption = $("#cropyeardefault > option").clone();
                        $('#CropYear'+m2).append(cropyearoption);
                        $("#CropYear"+m2+" option[title!='"+originmergeddata+"']").remove(); 
                        $("#CropYear"+m2+" option[value='"+value.CropYear+"']").remove(); 
                        $('#CropYear'+m2).append(defaultcropyear);
                        $('#CropYear'+m2).select2
                        ({
                            placeholder: "Select Crop year here",
                            dropdownCssClass : 'cusprop',
                        });

                        var uomoptions = $("#uomdefault > option").clone();
                        $('#Uom'+m2).append(uomoptions);
                        $("#Uom"+m2+" option[class!='"+originmergeddata+"']").remove(); 
                        $("#Uom"+m2+" option[value='"+value.DefaultUOMId+"']").remove(); 
                        $('#Uom'+m2).append(defaultuom);
                        $('#Uom'+m2).select2
                        ({
                            placeholder: "Select UOM/Bag here",
                            dropdownCssClass : 'cusprop',
                        });

                        if(parseInt(reqreason)==3){
                            $('#expcernumdiv'+m2).show();
                        }

                        if(parseFloat(value.VarianceShortage)>0){
                            $('#varianceLbl'+m2).html("Variance Shortage: "+numformat(value.VarianceShortage)+" KG");
                            $('#varianceshortage'+m2).val(parseFloat(value.VarianceShortage));
                        }
                        else if(parseFloat(value.VarianceOverage)>0){
                            $('#varianceLbl'+m2).html("Variance Overage: "+numformat(value.VarianceOverage)+" KG");
                            $('#varianceoverage'+m2).val(parseFloat(value.VarianceOverage));
                        }
                        else if(parseFloat(value.VarianceShortage)==0 || isNaN(parseFloat(value.VarianceShortage)) && parseFloat(value.VarianceOverage)==0 || isNaN(parseFloat(value.VarianceOverage))){
                            $('#varianceLbl'+m2).html("");
                        }
                        $('#Feresula'+m2).prop("readonly",true);
                        $('#TotalBagWeight'+m2).prop("readonly",true);
                        $('#NetKg'+m2).prop("readonly",false);
                        calcQtyOnHand(m2); 
                        commRenumberRows();
                        $('#select2-FloorMap'+m2+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                        $('#select2-CommType'+m2+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                        $('#select2-Origin'+m2+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                        $('#select2-Grade'+m2+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                        $('#select2-ProcessType'+m2+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                        $('#select2-CropYear'+m2+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                        $('#select2-Uom'+m2+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});

                    });
                    CalculateCommTotal();
                },
            });
            
            $('.totalrownumber').show();
            $("#adjustmenttitle").html('Edit Stock Adjustment');
            $('#savebutton').text('Update');
            $('#savebutton').prop("disabled", false);
            $("#inlineForm").modal('show');
        }
        //end edit modal open

        function resetDispatchForm(){
            $('#dispatchOperationtypes').val(1);
            $('#DispatchMode').val(null).select2({
                placeholder:"Select Dispatch mode here",
                minimumResultsForSearch: -1
            });
            $('#dispatchCurrRecId').val("");
            $('.mainprop').hide();
            $('.mainforminp').val("");
            $('.errordatalabel').html("");
			$("#dispDynamicTable > tbody").empty();
            CalculateTotalDispatch();
        }

        function manageDispatchFn(recordId){
            var recId="";
            var carddata="";
            j4=0;
            $('#dispatchRecId').val(recordId);
            $('#dispatchOperationtypes').val(1);
            $('#DispatchMode').val(null).select2({
                placeholder:"Select Dispatch mode here",
                minimumResultsForSearch: -1
            });
            $('.mainprop').hide();
            $('#dispatchCurrRecId').val("");

            $.ajax({
                url: '/fetchDispatchInfo',
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
                
                success: function(data) {
                    $.each(data.requistiondata, function(key, value) { 
                        if(value.Status=="Draft"){
                            $("#dispatchstatustitle").html("<span style='color:#A8AAAE;font-weight:bold;font-size:16px;text-align:right;'>"+value.DocumentNumber+" | "+value.Status+"</span>");
                        }
                        else if(value.Status=="Pending"){
                            $("#dispatchstatustitle").html("<span style='color:#f6c23e;font-weight:bold;font-size:16px;text-align:right;'>"+value.DocumentNumber+" | "+value.Status+"</span>");
                        }
                        else if(value.Status=="Issued"){
                            $("#dispatchstatustitle").html("<span style='color:#4e73df;font-weight:bold;font-size:16px;text-align:right;'>"+value.DocumentNumber+" | "+value.Status+"</span>");
                        }
                        else if(value.Status=="Approved"){
                            $("#dispatchstatustitle").html("<span style='color:#1cc88a;font-weight:bold;font-size:16px;text-align:right;'>"+value.DocumentNumber+" | "+value.Status+"</span>");
                        }
                        else if(value.Status=="Commented"){
                            $("#dispatchstatustitle").html("<span style='color:#rgb(133 135 150);font-weight:bold;font-size:16px;text-align:right;'>"+value.DocumentNumber+" | "+value.Status+"</span>");
                        }
                        else if(value.Status=="Corrected"){
                            $("#dispatchstatustitle").html("<span style='color:#5bc0de;font-weight:bold;font-size:16px;text-align:right;'>"+value.DocumentNumber+" | "+value.Status+"</span>");
                        }
                        else if(value.Status=="Rejected"){
                            $("#dispatchstatustitle").html("<span style='color:#e74a3b;font-weight:bold;font-size:16px;text-align:right;'>"+value.DocumentNumber+" | "+value.Status+"</span>");
                        }
                        else if(value.Status=="Void"||value.Status=="Void(Pending)"||value.Status=="Void(Approved)"){
                            $("#dispatchstatustitle").html("<span style='color:#e74a3b;font-weight:bold;font-size:16px;text-align:right;'>"+value.DocumentNumber+" | "+value.Status+"</span>");
                        }
                        else{
                            $("#dispatchstatustitle").html("<span style='color:#e74a3b;font-weight:bold;font-size:16px;text-align:right;'>"+value.DocumentNumber+" | "+value.Status+"</span>");
                        }
                    });

                    $.each(data.reqdetaildata, function(key, value) { 
                        ++i3;
                        ++m3;
                        ++j3;

                        var commtypename="";
                        var backcolor="";
                        var forecolor="";
                        if (parseInt(value.CommodityType)==1){
                            commtypename="Arrival";
                            backcolor="#eae8fd !important";
                            forecolor="#7367f0 !important";
                        }
                        else if (parseInt(value.CommodityType)==2){
                            commtypename="Export";
                            backcolor="#dff7e9 !important";
                            forecolor="#28c76f !important";
                        }
                        else if (parseInt(value.CommodityType)==3){
                            commtypename="Reject";
                            backcolor="#fff1e3 !important";
                            forecolor="#ff9f43 !important";
                        }
                        else if (parseInt(value.CommodityType)==4){
                            commtypename="Others(Pre-Clean)";
                            backcolor="#d9f8fc !important";
                            forecolor="#00cfe8 !important";
                        }
                        else if (parseInt(value.CommodityType)==5){
                            commtypename="Others(Export-EXcess)";
                            backcolor="#dff7e9 !important";
                            forecolor="#28c76f !important";
                        }
                        else if (parseInt(value.CommodityType)==6){
                            commtypename="Others(Export-Cancel)";
                            backcolor="#e4e4e4 !important";
                            forecolor="#4b4b4b !important";
                        }
                        
                        //carddata+="<div id='commcard"+value.id+"' class='card commcardcls' style='margin-top:0rem;border:0.5px solid #FFFFFF' onclick='fetchPrdDetailRecFn("+m3+","+value.id+")'><div class='card-header' style='margin-top:-1rem;margin-left:-1rem;margin-right:-1rem'><span class='badge badge-center rounded-pill bg-secondary'>"+j3+"</span> <span style='background-color:"+backcolor+";color:"+forecolor+";padding:3px 5px;font-size:11px;'><b>"+commtypename+"</b></span></div><div class='card-body pb-0' style='margin-top:-1.2rem'><div class='row mt-0'><div class='col-xl-12 col-md-12 col-lg-12 p-0'><b>"+value.id+"</b></div></div></div></div>";
                    });
                    //$('#carddatacanvas').html(carddata);
                }
            });

            $('#dispatchdatatbl').DataTable({
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
                "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/showDispatchData/' + recordId,
                    type: 'DELETE',
                },
                columns: [
                    { data: 'id', name: 'id', 'visible': false},
                    {
                        data:'DT_RowIndex',
                        width:"3%"
                    },
                    {
                        data: 'DispatchDocNo',
                        name: 'DispatchDocNo',
                        width:"8%"
                    },
                    {
                        data: 'DispatchModeName',
                        name: 'DispatchModeName',
                        width:"8%"
                    },
                    {
                        data: 'DriverName',
                        name: 'DriverName',
                        width:"8%"
                    },
                    {
                        data: 'DriverLicenseNo',
                        name: 'DriverLicenseNo',
                        width:"8%"
                    },
                    {
                        data: 'DriverPhoneNo',
                        name: 'DriverPhoneNo',
                        width:"8%"
                    },
                    {
                        data: 'PlateNumber',
                        name: 'PlateNumber',
                        width:"8%"
                    },
                    {
                        data: 'ContainerNumber',
                        name: 'ContainerNumber',
                        width:"8%"
                    },
                    {
                        data: 'SealNumber',
                        name: 'SealNumber',
                        width:"8%"
                    },
                    {
                        data: 'PersonName',
                        name: 'PersonName',
                        width:"7%"
                    },
                    {
                        data: 'PersonPhoneNo',
                        name: 'PersonPhoneNo',
                        width:"7%"
                    },
                    {
                        data: 'Date',
                        name: 'Date',
                        width:"7%"
                    },
                    {
                        data: 'Status',
                        name: 'Status',
                        "render": function ( data, type, row, meta ) {
                            if(data == "Pending"){
                                return '<span class="badge bg-warning bg-glow">'+data+'</span>';
                            }
                            else if(data == "Verified"){
                                return '<span class="badge bg-info bg-glow">'+data+'</span>';
                            }
                            else if(data == "Approved"){
                                return '<span class="badge bg-success bg-glow">'+data+'</span>';
                            }
                            else if(data == "Void"){
                                return '<span class="badge bg-danger bg-glow">'+data+'</span>';
                            }
                            else{
                                return '<span class="badge bg-danger bg-glow">'+data+'</span>';
                            }
                        },
                        width:"7%"
                    },
                    { 
                        data: 'action', 
                        name: 'action',
                        width:"4%",
                    }
                ],
                createdRow: function(row, data, dataIndex) {
                    $('td', row).each(function() {
                        // If the cell's text is "0", set it to an empty string
                        if ($(this).text() == "0.00" || $(this).text() == "0" || $(this).text() == "NULL" || $(this).text() === "NULL") {
                            $(this).text('');
                        }
                    });
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
                },
            });

            $('#closeupdatedispatchbtn').hide();
            $('#savebuttondispatch').text('Save');
            $('#savebuttondispatch').prop("disabled",false);
            $("#dispatchinfomodal").modal('show');
        }

        $("#dispadds").click(function() {
            var recId=$('#dispatchRecId').val();
            var lastrowcount=$('#dispDynamicTable > tbody tr:last').find('td').eq(1).find('input').val();
            var origin=$('#dispOrigin'+lastrowcount).val();
            var concatdata=$('#concatData'+lastrowcount).val();
            var borcolor="";
            if((origin!==undefined && isNaN(parseFloat(origin))) || (concatdata!==undefined && isNaN(parseFloat(concatdata)))){
                if(origin!==undefined && isNaN(parseFloat(origin))){
                    $('#select2-dispOrigin'+lastrowcount+'-container').parent().css('background-color',errorcolor);
                }
                if(concatdata!==undefined && isNaN(parseFloat(concatdata))){
                    $('#select2-concatData'+lastrowcount+'-container').parent().css('background-color',errorcolor);
                }
                toastrMessage('error',"Please fill all required fields","Error");
            }
            else{
                ++i4;
                ++m4;
                ++j4;
                $("#dispDynamicTable > tbody").append('<tr><td style="font-weight:bold;width:3%;text-align:center;">'+j4+'</td>'+
                    '<td style="display:none;"><input type="hidden" name="disprow['+m4+'][dispvals]" id="dispvals'+m4+'" class="dispvals form-control" readonly="true" style="font-weight:bold;" value="'+m4+'"/></td>'+
                    '<td style="width:12%;"><select name="disprow['+m4+'][dispOrigin]" id="dispOrigin'+m4+'" class="select2 form-control dispOrigin" onchange="dispOriginFn(this)"></select></td>'+
                    '<td style="width:30%;"><select name="disprow['+m4+'][concatData]" id="concatData'+m4+'" class="select2 form-control concatData" onchange="concatDataFn(this)"></select></td>'+
                    '<td style="width:7%;"><input type="text" name="disprow['+m4+'][RemNumOfBag]" id="RemNumOfBag'+m4+'" class="RemNumOfBag form-control" placeholder="Remaining No. of Bag" readonly="true" style="font-weight:bold;"/></td>'+
                    '<td style="width:7%;"><input type="text" name="disprow['+m4+'][RemTotalKg]" id="RemTotalKg'+m4+'" class="RemTotalKg form-control" placeholder="Remaining Total KG" readonly="true" style="font-weight:bold;"/></td>'+
                    '<td style="width:6%;"><input type="text" name="disprow['+m4+'][RemNetKg]" id="RemNetKg'+m4+'" class="RemNetKg form-control" placeholder="Remaining Net KG" readonly="true" style="font-weight:bold;"/></td>'+
                    '<td style="width:7%;"><input type="number" name="disprow['+m4+'][NumOfBagVal]" id="NumOfBagVal'+m4+'" class="NumOfBagVal form-control" placeholder="Write No. of Bag" onkeypress="return ValidateOnlyNum(event);" step="any" onkeyup="dispNumofBagFn(this)" style="text-align:center;"/></td>'+
                    '<td style="width:7%;"><input type="number" name="disprow['+m4+'][TotalKgVal]" id="TotalKgVal'+m4+'" class="TotalKgVal form-control" placeholder="Write Total KG" onkeypress="return ValidateNum(event);" step="any" onkeyup="dispTotalKgFn(this)" style="text-align:center;"/></td>'+
                    '<td style="width:6%;"><input type="number" name="disprow['+m4+'][NetKgVal]" id="NetKgVal'+m4+'" class="NetKgVal form-control" placeholder="Write Net KG" onkeypress="return ValidateNum(event);" step="any" onkeyup="dispNetKgFn(this)" style="text-align:center;"/></td>'+
                    '<td style="width:12%;"><input type="text" name="disprow['+m4+'][RemRemark]" id="RemRemark'+m4+'" class="RemRemark form-control" placeholder="Write Remark here"/></td>'+
                    '<td style="width:3%;text-align:center;"><button type="button" class="btn btn-light btn-sm dispremove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>'+
                    '<td style="display:none;"><input type="hidden" name="disprow['+m4+'][dispId]" id="dispId'+m4+'" class="dispId form-control" readonly/></td>'+
                    '<td style="display:none;"><input type="hidden" name="disprow['+m4+'][dispUomAmount]" id="dispUomAmount'+m4+'" value="0" class="dispUomAmount form-control" readonly/></td>'+
                    '<td style="display:none;"><input type="hidden" name="disprow['+m4+'][dispBagWeight]" id="dispBagWeight'+m4+'" value="0" class="dispBagWeight form-control" readonly/></td>'+
                '</tr>');

                var defaultoption = '<option selected value=""></option>';
                var commdata = $("#reqcommoditydefault > option").clone();
                $('#dispOrigin'+m4).append(commdata);
                $("#dispOrigin"+m4+" option[title!="+recId+"]").remove(); 
                $('#dispOrigin'+m4).append(defaultoption);
                $('#dispOrigin'+m4).select2
                ({
                    placeholder: "Select Commodity here",
                    dropdownCssClass : 'cusprop',
                });

                $('#concatData'+m4).select2
                ({
                    placeholder: "Select here",
                    minimumResultsForSearch: -1
                });

                dispRenumberRows();
                $('#select2-dispOrigin'+m4+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
                $('#select2-concatData'+m4+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
            }
        });

        $(document).on('click', '.dispremove-tr', function() {
            $(this).parents('tr').remove();
            CalculateTotalDispatch();
            dispRenumberRows();
            --i4;
        });

        function dispRenumberRows() {
            var ind;
            $('#dispDynamicTable > tbody > tr').each(function(index, el) {
                $(this).children('td').first().text(++index);
                ind = index - 1;
            });
        }

        function dispOriginFn(ele) {
            var recId=$('#dispatchRecId').val();
            var idval = $(ele).closest('tr').find('.dispvals').val();
            var origin=$('#dispOrigin'+idval).val()||0;
            var concatdataval=$('#concatData'+idval).val()||0;
            var defaultoption = '<option selected value=""></option>';
            var concatdata = $("#concatdatadefault > option").clone();

            var dupcount=0;
            for(var k=1;k<=m4;k++){
                if(($('#dispOrigin'+k).val())!=undefined){
                    if((parseInt($('#dispOrigin'+k).val()) == parseInt(origin)) && (parseInt($('#concatData'+k).val()) == parseInt(concatdataval))){
                        dupcount+=1;
                    }
                }
            }

            if(parseInt(dupcount)<=1){
                $('#concatData'+idval).append(concatdata);
                $("#concatData"+idval+" option[title!="+origin+"]").remove(); 
                $("#concatData"+idval+" option[label!="+recId+"]").remove(); 
                $('#concatData'+idval).append(defaultoption);
                $('#concatData'+idval).select2
                ({
                    placeholder: "Select here",
                });
                $('#select2-dispOrigin'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
                $('#select2-concatData'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
            }
            else if(parseInt(dupcount)>1){
                $('#dispOrigin'+idval).val(null).trigger('change').select2
                ({
                    placeholder: "Select Commodity here",
                });

                $('#concatData'+idval).empty();
                $('#concatData'+idval).select2
                ({
                    placeholder: "Select here",
                    minimumResultsForSearch: -1
                });
                $('#select2-dispOrigin'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                $('#select2-concatData'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
                toastrMessage('error',"Commodity is selected with all property","Error");
            }
        }

        function concatDataFn(ele) {
            var recId=$('#dispatchRecId').val();
            var idval = $(ele).closest('tr').find('.dispvals').val();
            var origin=$('#dispOrigin'+idval).val()||0;
            var concatdataval=$('#concatData'+idval).val()||0;
            var defaultoption = '<option selected value=""></option>';
            var concatdata = $("#concatdatadefault > option").clone();

            var dupcount=0;
            for(var k=1;k<=m4;k++){
                if(($('#concatData'+k).val())!=undefined){
                    if((parseInt($('#dispOrigin'+k).val()) == parseInt(origin)) && (parseInt($('#concatData'+k).val()) == parseInt(concatdataval))){
                        dupcount+=1;
                    }
                }
            }

            if(parseInt(dupcount)<=1){
                $('#select2-concatData'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
                calcRemainingAmount(idval);
            }
            else if(parseInt(dupcount)>1){
                $('#concatData'+idval).val(null).trigger('change').select2
                ({
                    placeholder: "Select here",
                });
                $('#select2-concatData'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                toastrMessage('error',"Selected with all property","Error");
            }
        }

        function calcRemainingAmount(rowid){
            var origin="";
            var concatdata="";
            var reqid="";
            var dispchid="";
            var currRowId="";

            $.ajax({
                url: '/calcRemAmnt',
                type: 'POST',
                data:{
                    origin:$('#dispOrigin'+rowid).val(),
                    concatdata:$('#concatData'+rowid).val(),
                    reqid:$('#dispatchRecId').val(),
                    dispchid:$('#dispatchCurrRecId').val(),
                    currRowId:$('#dispId'+rowid).val(),
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
                    $.each(data.reqdetaildata, function(key, value) {
                        $('#RemNumOfBag'+rowid).val(parseFloat(data.remnumofbag) <= 0 ? 0 : parseFloat(data.remnumofbag));
                        $('#RemTotalKg'+rowid).val(parseFloat(data.remtotalkg) <= 0 ? 0 : parseFloat(data.remtotalkg));
                        $('#RemNetKg'+rowid).val(parseFloat(data.remnetkg) <= 0 ? 0 : parseFloat(data.remnetkg));
                        $('#dispUomAmount'+rowid).val(value.uomamount);
                        $('#dispBagWeight'+rowid).val(value.bagweight);
                    });
                }
            });
        }

        function dispNumofBagFn(ele){
            var idval = $(ele).closest('tr').find('.dispvals').val();
            var remnumofbag=$('#RemNumOfBag'+idval).val();
            var numofbag=$('#NumOfBagVal'+idval).val();
            var totalkg=$('#TotalKgVal'+idval).val();
            var netkg=$('#NetKgVal'+idval).val();
            $('#NumOfBagVal'+idval).css("background","white");
            remnumofbag = remnumofbag == '' ? 0 : remnumofbag;
            numofbag = numofbag == '' ? 0 : numofbag;
            totalkg = totalkg == '' ? 0 : totalkg;
            netkg = netkg == '' ? 0 : netkg;

            if(parseFloat(numofbag)>parseFloat(remnumofbag)){
                $('#NumOfBagVal'+idval).val("");
                $('#NumOfBagVal'+idval).css("background",errorcolor);
                toastrMessage('error',"Maximum allowed quantity is "+remnumofbag,"Error");
            }
            else{
                if((parseFloat(netkg)==0 && parseFloat(totalkg)>0) || (parseFloat(netkg)>0 && parseFloat(totalkg)>0)){
                    CalculateKGS(1);
                }
                else if(parseFloat(netkg)>0 && parseFloat(totalkg)==0){
                    CalculateKGS(2);
                }
                else{
                    CalculateKGS(1);
                }
            }
        }

        function dispTotalKgFn(ele){
            var idval = $(ele).closest('tr').find('.dispvals').val();
            var remtotalkg=$('#RemTotalKg'+idval).val();
            var totalkg=$('#TotalKgVal'+idval).val();
            $('#TotalKgVal'+idval).css("background","white");
            remtotalkg = remtotalkg == '' ? 0 : remtotalkg;
            totalkg = totalkg == '' ? 0 : totalkg;
            
            if(parseFloat(totalkg)>parseFloat(remtotalkg)){
                $('#TotalKgVal'+idval).val("");
                $('#TotalKgVal'+idval).css("background",errorcolor);
                toastrMessage('error',"Maximum allowed quantity is "+parseFloat(remtotalkg).toFixed(2),"Error");
            }
            CalculateKGS(1);
        }

        function dispNetKgFn(ele){
            var idval = $(ele).closest('tr').find('.dispvals').val();
            var remnetkg=$('#RemNetKg'+idval).val();
            var netkg=$('#NetKgVal'+idval).val();
            $('#NetKgVal'+idval).css("background","white");
            remnetkg = remnetkg == '' ? 0 : remnetkg;
            netkg = netkg == '' ? 0 : netkg;

            if(parseFloat(netkg)>parseFloat(remnetkg)){
                $('#NetKgVal'+idval).val("");
                $('#NetKgVal'+idval).css("background",errorcolor);
                toastrMessage('error',"Maximum allowed quantity is "+parseFloat(remnetkg).toFixed(2),"Error");
            }
            CalculateKGS(2);
        }

        function CalculateKGS(param){
            var idval=0;
            var numofbag=0;
            var totalkg=0;
            var netkg=0;
            var uomamounts=0;
            var bagweight=0;
            var totalbagweight=0;
            var netkgval=0;
            var totalkgval=0;

            var totalnumofbagamnt=0;
            var totalkgamnt=0;
            var totalnetkgamnt=0;

            var nbg=0;
            var tkg=0;
            var nkg=0;

            $('#dispDynamicTable > tbody  > tr').each(function() { 
                idval = $(this).find('.dispvals').val();
                numofbag = $(this).find('.NumOfBagVal').val();
                totalkg = $(this).find('.TotalKgVal').val();
                netkg = $(this).find('.NetKgVal').val();
                uomamounts = $(this).find('.dispUomAmount').val();
                bagweight = $(this).find('.dispBagWeight').val();

                numofbag = numofbag == '' ? 0 : numofbag;
                totalkg = totalkg == '' ? 0 : totalkg;
                netkg = netkg == '' ? 0 : netkg;
                uomamounts = uomamounts == '' ? 0 : uomamounts;
                bagweight = bagweight == '' ? 0 : bagweight;
                totalbagweight = totalbagweight == '' ? 0 : totalbagweight;

                totalbagweight=parseFloat(numofbag)*parseFloat(bagweight);
                if(parseInt(param)==1){
                    netkgval=parseFloat(totalkg)-parseFloat(totalbagweight);
                    $('#NetKgVal'+idval).val(parseFloat(netkgval) <= 0 ? '' : parseFloat(netkgval).toFixed(2));
                    $('#NetKgVal'+idval).css("background","white");
                }
                else{
                    totalkgval=parseFloat(netkg)+parseFloat(totalbagweight);
                    $('#TotalKgVal'+idval).val(parseFloat(totalkgval) <= 0 ? '' : parseFloat(totalkgval).toFixed(2));
                    $('#TotalKgVal'+idval).css("background","white");
                }
            });
            CalculateTotalDispatch();
        }

        function CalculateTotalDispatch(){
            var totalnumofbagamnt=0;
            var totalkgamnt=0;
            var totalnetkgamnt=0;

            var nbg=0;
            var tkg=0;
            var nkg=0;

            $('#dispDynamicTable > tbody  > tr').each(function() { 
                nbg = $(this).find('.NumOfBagVal').val();
                tkg = $(this).find('.TotalKgVal').val();
                nkg = $(this).find('.NetKgVal').val();

                nbg = nbg == '' ? 0 : nbg;
                tkg = tkg == '' ? 0 : tkg;
                nkg = nkg == '' ? 0 : nkg;

                totalnumofbagamnt+=parseFloat(nbg);
                totalkgamnt+=parseFloat(tkg);
                totalnetkgamnt+=parseFloat(nkg);
            });

            $('#disptotalnumofbag').html(parseInt(totalnumofbagamnt) <= 0 ? '' : numformat(parseInt(totalnumofbagamnt)));
            $('#disptotalkg').html(parseFloat(totalkgamnt) <= 0 ? '' : numformat(parseFloat(totalkgamnt).toFixed(2)));
            $('#disptotalnetkg').html(parseFloat(totalnetkgamnt) <= 0 ? '' : numformat(parseFloat(totalnetkgamnt).toFixed(2)));
        }

        $("#savebuttondispatch").click(function() {
            var registerForm = $("#DispatchForm");
            var formData = registerForm.serialize();
            var optype=$("#dispatchOperationtypes").val();
            $.ajax({ 
                url: '/saveDispatchData',
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
                    if(parseInt(optype)==1){
                        $('#savebuttondispatch').text('Saving...');
                        $('#savebuttondispatch').prop("disabled", true);
                    }
                    else if(parseInt(optype)==2){
                        $('#savebuttondispatch').text('Updating...');
                        $('#savebuttondispatch').prop("disabled", true);
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
                    if(data.errors){
                        if (data.errors.DispatchMode) {
                            $('#dispatchmode-error').html(data.errors.DispatchMode[0]);
                        }
                        if (data.errors.DriverName) {
                            var text=data.errors.DriverName[0];
                            text = text.replace("1", "vehicle");
                            $('#drivername-error').html(text);
                        }
                        if (data.errors.DriverLicenseNo) {
                            var text=data.errors.DriverLicenseNo[0];
                            text = text.replace("1", "vehicle");
                            $('#driverlic-error').html(text);
                        }
                        if (data.errors.DriverPhoneNo) {
                            var text=data.errors.DriverPhoneNo[0];
                            text = text.replace("1", "vehicle");
                            $('#driverphone-error').html(text);
                        }
                        if (data.errors.PlateNumber) {
                            var text=data.errors.PlateNumber[0];
                            text = text.replace("1", "vehicle");
                            $('#platenum-error').html(text);
                        }
                        if (data.errors.ContainerNumber) {
                            var text=data.errors.ContainerNumber[0];
                            text = text.replace("1", "vehicle");
                            $('#containernumber-error').html(text);
                        }
                        if (data.errors.PersonName) {
                            var text=data.errors.PersonName[0];
                            text = text.replace("2", "person");
                            $('#personname-error').html(text);
                        }
                        if (data.errors.PersonPhoneNo) {
                            var text=data.errors.PersonPhoneNo[0];
                            text = text.replace("2", "person");
                            $('#personphone-error').html(text);
                        }
                        if (data.errors.Remark) {
                            $('#remark-error').html(data.errors.Remark[0]);
                        }

                        if(parseFloat(optype)==1){
                            $('#savebuttondispatch').text('Save');
                            $('#savebuttondispatch').prop("disabled", false);
                        }
                        if(parseFloat(optype)==2){
                            $('#savebuttondispatch').text('Update');
                            $('#savebuttondispatch').prop("disabled", false);
                        }  
                        toastrMessage('error',"Please check your input","Error");
                    }
                    else if (data.emptyerror) {
                        if(parseFloat(optype)==1){
                            $('#savebuttondispatch').text('Save');
                            $('#savebuttondispatch').prop("disabled",false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebuttondispatch').text('Update');
                            $('#savebuttondispatch').prop("disabled",false);
                        }
                        toastrMessage('error',"You should add atleast one commodity","Error");
                    }
                    else if (data.errorv2) {
                        for(var k=1;k<=m4;k++){
                            var origin=$('#dispOrigin'+k).val();
                            var concdata=$('#concatData'+k).val();
                            var numofbag=$('#NumOfBagVal'+k).val();
                            var totalkg=$('#TotalKgVal'+k).val();
                            var netkg=$('#NetKgVal'+k).val();

                            if(($('#dispOrigin'+k).val())!=undefined){
                                if(origin==""||origin==null){
                                    $('#select2-dispOrigin'+k+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                                }
                            }
                            if(($('#concatData'+k).val())!=undefined){
                                if(concdata==""||concdata==null){
                                    $('#select2-concatData'+k+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                                }
                            }
                            if(($('#NumOfBagVal'+k).val())!=undefined){
                                if(numofbag==""||numofbag==null){
                                    $('#NumOfBagVal'+k).css("background", errorcolor);
                                }
                            }
                            if(($('#TotalKgVal'+k).val())!=undefined){
                                if(totalkg==""||totalkg==null){
                                    $('#TotalKgVal'+k).css("background", errorcolor);
                                }
                            }
                            if(($('#NetKgVal'+k).val())!=undefined){
                                if(netkg==""||netkg==null){
                                    $('#NetKgVal'+k).css("background", errorcolor);
                                }
                            }
                        }
                        if(parseFloat(optype)==1){
                            $('#savebuttondispatch').text('Save');
                            $('#savebuttondispatch').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebuttondispatch').text('Update');
                            $('#savebuttondispatch').prop("disabled", false);
                        }
                        toastrMessage('error',"Please insert valid data on highlighted fields","Error");
                    }
                    else if (data.dberrors) {
                        if(parseFloat(optype)==1){
                            $('#savebuttondispatch').text('Save');
                            $('#savebuttondispatch').prop("disabled",false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebuttondispatch').text('Update');
                            $('#savebuttondispatch').prop("disabled",false);
                        }
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if(data.success){
                        if(parseFloat(optype)==1){
                            $('#savebuttondispatch').text('Save');
                            $('#savebuttondispatch').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebuttondispatch').text('Update');
                            $('#savebuttondispatch').prop("disabled", false);
                        }
                        resetDispatchForm();
                        var oTable = $('#dispatchdatatbl').dataTable();
                        oTable.fnDraw(false);

                        var iTable = $('#laravel-datatable-crud').dataTable();
                        iTable.fnDraw(false);

                        var jTable = $('#customer-crud').dataTable();
                        jTable.fnDraw(false);
                        $('#closeupdatedispatchbtn').hide();
                        $('#dispatchOperationtypes').val(1);
                        $('#savebuttondispatch').text('Save');
                        $('#savebuttondispatch').prop("disabled",false);
                        toastrMessage('success',"Successful","Success");
                    }
                }
            });
        });

        function dispatchModeFn(){
            var dispmode=$('#DispatchMode').val();
            $('.mainprop').hide();
            $('.mainforminp').val("");
            $('.errordatalabel').html("");
            if(parseInt(dispmode)==1){
                $('.vech').show();
            }
            else if(parseInt(dispmode)==2){
                $('.per').show();
            }
        }

        function editDispatchFn(recordId){
            var recId="";
            var recIdVal=$('#dispatchRecId').val();
            $('#dispatchCurrRecId').val(recordId);
            $('.mainprop').hide();
            $("#dispDynamicTable > tbody").empty();
            var commdata = $("#reqcommoditydefault > option").clone();
            var concatdata = $("#concatdatadefault > option").clone();
            j4=0;
            $.ajax({
                url: '/fetchDispatchData',
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
                    $.each(data.disparentdata,function(key,value) { 
                        $('#DispatchMode').val(value.DispatchMode).select2({minimumResultsForSearch:-1});
                        $('#DriverName').val(value.DriverName);
                        $('#DriverLicenseNo').val(value.DriverLicenseNo);
                        $('#DriverPhoneNo').val(value.DriverPhoneNo);
                        $('#PlateNumber').val(value.PlateNumber);
                        $('#ContainerNumber').val(value.ContainerNumber);
                        $('#SealNumber').val(value.SealNumber);
                        $('#PersonName').val(value.PersonName);
                        $('#PersonPhoneNo').val(value.PersonPhoneNo);
                        $('#Remark').val(value.Remark);
                        
                        if(parseInt(value.DispatchMode)==1){
                            $('.vech').show();
                        }
                        if(parseInt(value.DispatchMode)==2){
                            $('.per').show();
                        }
                    });

                    $.each(data.dispchilddata,function(key,value) { 
                        ++i4;
                        ++m4;
                        ++j4;
                        $("#dispDynamicTable > tbody").append('<tr><td style="font-weight:bold;width:3%;text-align:center;">'+j4+'</td>'+
                            '<td style="display:none;"><input type="hidden" name="disprow['+m4+'][dispvals]" id="dispvals'+m4+'" class="dispvals form-control" readonly="true" style="font-weight:bold;" value="'+m4+'"/></td>'+
                            '<td style="width:12%;"><select name="disprow['+m4+'][dispOrigin]" id="dispOrigin'+m4+'" class="select2 form-control dispOrigin" onchange="dispOriginFn(this)"></select></td>'+
                            '<td style="width:30%;"><select name="disprow['+m4+'][concatData]" id="concatData'+m4+'" class="select2 form-control concatData" onchange="concatDataFn(this)"></select></td>'+
                            '<td style="width:7%;"><input type="text" name="disprow['+m4+'][RemNumOfBag]" id="RemNumOfBag'+m4+'" class="RemNumOfBag form-control" placeholder="Remaining No. of Bag" readonly="true" style="font-weight:bold;"/></td>'+
                            '<td style="width:7%;"><input type="text" name="disprow['+m4+'][RemTotalKg]" id="RemTotalKg'+m4+'" class="RemTotalKg form-control" placeholder="Remaining Total KG" readonly="true" style="font-weight:bold;"/></td>'+
                            '<td style="width:6%;"><input type="text" name="disprow['+m4+'][RemNetKg]" id="RemNetKg'+m4+'" class="RemNetKg form-control" placeholder="Remaining Net KG" readonly="true" style="font-weight:bold;"/></td>'+
                            '<td style="width:7%;"><input type="number" name="disprow['+m4+'][NumOfBagVal]" id="NumOfBagVal'+m4+'" class="NumOfBagVal form-control" placeholder="Write No. of Bag" onkeypress="return ValidateOnlyNum(event);" value="'+value.NumOfBag+'" step="any" onkeyup="dispNumofBagFn(this)" style="text-align:center;"/></td>'+
                            '<td style="width:7%;"><input type="number" name="disprow['+m4+'][TotalKgVal]" id="TotalKgVal'+m4+'" class="TotalKgVal form-control" placeholder="Write Total KG" onkeypress="return ValidateNum(event);" value="'+value.TotalKG+'" step="any" onkeyup="dispTotalKgFn(this)" style="text-align:center;"/></td>'+
                            '<td style="width:6%;"><input type="number" name="disprow['+m4+'][NetKgVal]" id="NetKgVal'+m4+'" class="NetKgVal form-control" placeholder="Write Net KG" onkeypress="return ValidateNum(event);" value="'+value.NetKG+'" step="any" onkeyup="dispNetKgFn(this)" style="text-align:center;"/></td>'+
                            '<td style="width:12%;"><input type="text" name="disprow['+m4+'][RemRemark]" id="RemRemark'+m4+'" class="RemRemark form-control" value="'+value.Remark+'" placeholder="Write Remark here"/></td>'+
                            '<td style="width:3%;text-align:center;"><button type="button" class="btn btn-light btn-sm dispremove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>'+
                            '<td style="display:none;"><input type="hidden" name="disprow['+m4+'][dispId]" id="dispId'+m4+'" class="dispId form-control" value="'+value.id+'" readonly/></td>'+
                            '<td style="display:none;"><input type="hidden" name="disprow['+m4+'][dispUomAmount]" id="dispUomAmount'+m4+'" value="'+value.uomamount+'" class="dispUomAmount form-control" readonly/></td>'+
                            '<td style="display:none;"><input type="hidden" name="disprow['+m4+'][dispBagWeight]" id="dispBagWeight'+m4+'" value="'+value.bagweight+'" class="dispBagWeight form-control" readonly/></td>'+
                        '</tr>');

                        var defaultcommodity='<option selected value='+value.CommodityId+'>'+value.Origin+'</option>';
                        var defaultconc='<option selected value='+value.ReqDetailId+'>'+value.ConcatData+'</option>';

                        $('#dispOrigin'+m4).append(commdata);
                        $("#dispOrigin"+m4+" option[title!="+recIdVal+"]").remove(); 
                        $("#dispOrigin"+m4+" option[value="+value.CommodityId+"]").remove(); 
                        $('#dispOrigin'+m4).append(defaultcommodity);
                        $('#dispOrigin'+m4).select2
                        ({
                            placeholder: "Select Commodity here",
                            dropdownCssClass : 'cusprop',
                        });

                        $('#concatData'+m4).append(concatdata);
                        $("#concatData"+m4+" option[title!="+value.CommodityId+"]").remove(); 
                        $("#concatData"+m4+" option[label!="+recIdVal+"]").remove(); 
                        $("#concatData"+m4+" option[value="+value.ReqDetailId+"]").remove(); 
                        $('#concatData'+m4).append(defaultconc);
                        $('#concatData'+m4).select2
                        ({
                            placeholder: "Select here",
                        });
                        calcRemainingAmount(m4);

                        $('#select2-dispOrigin'+m4+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
                        $('#select2-concatData'+m4+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
                    });
                    dispRenumberRows();
                    CalculateTotalDispatch();
                },
                
            });
            $('#closeupdatedispatchbtn').show();
            $('#dispatchOperationtypes').val(2);
            $('#savebuttondispatch').text('Update');
            $('#savebuttondispatch').prop("disabled",false);
        }

        function infoDispatchFn(recordId,flg){
            var recId="";
            $('.allinfo').hide();
            $('.dispbtnprop').hide();
            $('.infodispfooter').html("");
            $('#dispatchinfoid').val(recordId);
            $.ajax({
                url: '/fetchDispatchData',
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
                
                success: function(data) {
                    $.each(data.disparentdata,function(key,value) { 
                        $('#infoReqDocNoLbl').html(value.DocumentNumber);
                        $('#infoDispatchModeLbl').html(value.DispatchModeName);
                        $('#infoDriverNameLbl').html(value.DriverName);
                        $('#infoDriverLiceNoLbl').html(value.DriverLicenseNo);
                        $('#infoDriverPhoneNoLbl').html(value.DriverPhoneNo);
                        $('#infoPlateNoLbl').html(value.PlateNumber);
                        $('#infoContainerNoLbl').html(value.ContainerNumber);
                        $('#infoSealNoLbl').html(value.SealNumber);
                        $('#infoPersonNameLbl').html(value.PersonName);
                        $('#infoPersonPhoneLbl').html(value.PersonPhoneNo);
                        $('#infoRemark').html(value.Remark);
                        
                        if(parseInt(value.DispatchMode)==1){
                            $('.vehinfo').show();
                        }
                        if(parseInt(value.DispatchMode)==2){
                            $('.perinfo').show();
                        }

                        if(parseInt(flg)==1){
                            if(value.Status=="Pending"){
                                $('#changetoverifiedbtn').show();
                                $("#dispatchinformationtitle").html("<span style='color:#f6c23e;font-weight:bold;text-shadow;1px 1px 10px #f6c23e;font-size:16px;'>"+value.DispatchDocNo+" | "+value.Status+"</span>");
                            }
                            else if(value.Status=="Verified"){
                                $('#changetobackbtn').show();
                                $('#changetoapprovebtn').show();
                                $("#dispatchinformationtitle").html("<span style='color:#00cfe8;font-weight:bold;font-size:16px;text-align:right;'>"+value.DispatchDocNo+" | "+value.Status+"</span>");
                            }
                            else if(value.Status=="Approved"){
                                $("#dispatchinformationtitle").html("<span style='color:#1cc88a;font-weight:bold;font-size:16px;text-align:right;'>"+value.DispatchDocNo+" | "+value.Status+"</span>");
                            }
                            else{
                                $("#dispatchinformationtitle").html("<span style='color:#e74a3b;font-weight:bold;font-size:16px;text-align:right;'>"+value.DispatchDocNo+" | "+value.Status+"</span>");
                            }
                        }
                        else if(parseInt(flg)==2){
                            if(value.Status=="Pending"){
                                $("#dispatchinformationtitle").html("<span style='color:#f6c23e;font-weight:bold;text-shadow;1px 1px 10px #f6c23e;font-size:16px;'>"+value.DispatchDocNo+" | "+value.Status+"</span>");
                            }
                            else if(value.Status=="Verified"){
                                $("#dispatchinformationtitle").html("<span style='color:#00cfe8;font-weight:bold;font-size:16px;text-align:right;'>"+value.DispatchDocNo+" | "+value.Status+"</span>");
                            }
                            else if(value.Status=="Approved"){
                                $("#dispatchinformationtitle").html("<span style='color:#1cc88a;font-weight:bold;font-size:16px;text-align:right;'>"+value.DispatchDocNo+" | "+value.Status+"</span>");
                            }
                            else{
                                $("#dispatchinformationtitle").html("<span style='color:#e74a3b;font-weight:bold;font-size:16px;text-align:right;'>"+value.DispatchDocNo+" | "+value.Status+"</span>");
                            }
                        }
                    });
                }
            });

            $('#dispatchinfodatatbl').DataTable({
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
                "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/showDispatchDetailData/' + recordId,
                    type: 'DELETE',
                },
                columns: [
                    {
                        data:'DT_RowIndex',
                        width:"3%"
                    },
                    {
                        data: 'Origin',
                        name: 'Origin',
                        width:"9%"
                    },
                    {
                        data: 'SupplierName',
                        name: 'SupplierName',
                        width:"9%"
                    },
                    {
                        data: 'GrnNumber',
                        name: 'GrnNumber',
                        width:"9%"
                    },
                    {
                        data: 'ProductionOrderNo',
                        name: 'ProductionOrderNo',
                        width:"9%"
                    },
                    {
                        data: 'CertNumber',
                        name: 'CertNumber',
                        width:"11%"
                    },
                    {
                        data: 'ExportCertNumber',
                        name: 'ExportCertNumber',
                        width:"9%"
                    },
                    {
                        data: 'UOM',
                        name: 'UOM',
                        width:"9%"
                    },
                    {
                        data: 'NumOfBag',
                        name: 'NumOfBag',
                        render: $.fn.dataTable.render.number(',', '.',0, ''),
                        width:"7%"
                    },
                    {
                        data: 'TotalKG',
                        name: 'TotalKG',
                        render: $.fn.dataTable.render.number(',', '.',2, ''),
                        width:"8%"
                    },
                    {
                        data: 'NetKG',
                        name: 'NetKG',
                        render: $.fn.dataTable.render.number(',', '.',2, ''),
                        width:"7%"
                    },
                    {
                        data: 'Remark',
                        name: 'Remark',
                        width:"10%"
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
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(),data;
                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    var totalbag = api
                    .column(8)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totalkg = api
                    .column(9)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var netkg = api
                    .column(10)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );


                    $('#infodisptotalbag').html(parseFloat(totalbag) === 0 ? '' : numformat(parseFloat(totalbag)));
                    $('#infodisptotalkg').html(parseFloat(totalkg) === 0 ? '' : numformat(parseFloat(totalkg).toFixed(2)));
                    $('#infodispnetkg').html(parseFloat(netkg) === 0 ? '' : numformat(parseFloat(netkg).toFixed(2)));
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
                },
            });
            $(".infodoc").collapse('show');
            $('#dispatchinformationmodal').modal('show');
        }

        function voidDispatchFn(recordId){
            $('#voiddispid').val(recordId);
            $('#DispatchReason').val("");
            $('#dispvoid-error').html("");
            $('#voiddispatchbtn').text('Void');
            $('#voiddispatchbtn').prop("disabled", false);
            $('#voiddispatchmodal').modal('show');
        }

        $("#voiddispatchbtn").click(function() {
            var registerForm = $("#voiddispatchform");
            var formData = registerForm.serialize();
            $.ajax({
                url: '/voidDispatchData',
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
                    $('#voiddispatchbtn').text('Voiding...');
                    $('#voiddispatchbtn').prop("disabled", true);
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
                        if (data.errors.DispatchReason) {
                            $('#dispvoid-error').html(data.errors.DispatchReason[0]);
                        }
                        $('#voiddispatchbtn').text('Void');
                        $('#voiddispatchbtn').prop("disabled", false);
                    }
                    else if(data.statuserror){
                        $('#voiddispatchbtn').text('Void');
                        $('#voiddispatchbtn').prop("disabled", false);
                        $('#voiddispatchmodal').modal('hide');
                        toastrMessage('error',"Dispatch status should be on Active","Error");
                    }
                    else if (data.dberrors) {
                        $('#voiddispatchbtn').text('Void');
                        $('#voiddispatchbtn').prop("disabled", false);
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if(data.success){
                        var oTable = $('#dispatchdatatbl').dataTable();
                        oTable.fnDraw(false);
                        var iTable = $('#laravel-datatable-crud').dataTable();
                        iTable.fnDraw(false);
                        $('#voiddispatchmodal').modal('hide');
                        toastrMessage('success',"Successful","Success");
                    }
                }
            });
        });

        function undoVoidDispatchFn(recordId){
            $('#dispundovoidid').val(recordId);
            $('#dispundovoidbtn').text('Undo Void');
            $('#dispundovoidbtn').prop("disabled", false);
            $('#dispundovoidmodal').modal('show');
        }

        $("#dispundovoidbtn").click(function() {
            var registerForm = $("#dispundovoidform");
            var formData = registerForm.serialize();
            $.ajax({
                url: '/undoVoidDispatchData',
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
                    $('#dispundovoidbtn').text('Changing...');
                    $('#dispundovoidbtn').prop("disabled", true);
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
                    if(data.discerror){
                        $('#dispundovoidbtn').text('Undo Void');
                        $('#dispundovoidbtn').prop("disabled", false);
                        $('#dispundovoidmodal').modal('hide');
                        toastrMessage('error',"All requested amount is allocated.","Error");
                    }
                    else if (data.dberrors) {
                        $('#dispundovoidbtn').text('Undo Void');
                        $('#dispundovoidbtn').prop("disabled", false);
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if(data.success){
                        var oTable = $('#dispatchdatatbl').dataTable();
                        oTable.fnDraw(false);

                        var iTable = $('#laravel-datatable-crud').dataTable();
                        iTable.fnDraw(false);
                        $('#dispundovoidmodal').modal('hide');
                        toastrMessage('success',"Successful","Success");
                    }
                }
            });
        });

        function changeToVerifiedFn(){
            var recordId=$('#dispatchinfoid').val();
            $('#dispverifiedid').val(recordId);
            $('#dispverifiedbtn').text('Verify');
            $('#dispverifiedbtn').prop("disabled", false);
            $('#dispverifiedmodal').modal('show');
        }

        $("#dispverifiedbtn").click(function() {
            var registerForm = $("#dispverifiedform");
            var formData = registerForm.serialize();
            $.ajax({
                url: '/verifyDispatch',
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
                    $('#dispverifiedbtn').text('Verifying...');
                    $('#dispverifiedbtn').prop("disabled", true);
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
                    if(data.statuserror){
                        $('#dispverifiedbtn').text('Verify');
                        $('#dispverifiedbtn').prop("disabled", false);
                        $('#dispverifiedmodal').modal('hide');
                        toastrMessage('error',"Dispatch status should be on Pending","Error");
                    }
                    else if (data.dberrors) {
                        $('#dispverifiedbtn').text('Verify');
                        $('#dispverifiedbtn').prop("disabled", false);
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if(data.success){
                        var oTable = $('#dispatchdatatbl').dataTable();
                        oTable.fnDraw(false);
                        $('#dispverifiedmodal').modal('hide');
                        $('#dispatchinformationmodal').modal('hide');
                        toastrMessage('success',"Successful","Success");
                    }
                }
            });
        });

        function changeToPendingFn(){
            var recordId=$('#dispatchinfoid').val();
            $('#backtopendingidval').val(recordId);
            $('#BackToPendingReason').val("");
            $('#dispbacktopending-error').html("");
            $('#dispbacktopendingbtn').text('Back to Pending');
            $('#dispbacktopendingbtn').prop("disabled", false);
            $('#dispbacktopendingmodal').modal('show');
        }

        $("#dispbacktopendingbtn").click(function() {
            var registerForm = $("#dispbacktopendingform");
            var formData = registerForm.serialize();
            $.ajax({
                url: '/BacktoPendingDispatch',
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
                    $('#dispbacktopendingbtn').text('Backing...');
                    $('#dispbacktopendingbtn').prop("disabled", true);
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
                        if (data.errors.BackToPendingReason) {
                            $('#dispbacktopending-error').html(data.errors.BackToPendingReason[0]);
                        }
                        $('#dispbacktopendingbtn').text('Back to Pending');
                        $('#dispbacktopendingbtn').prop("disabled", false);
                    }
                    else if(data.statuserror){
                        $('#dispbacktopendingbtn').text('Back to Pending');
                        $('#dispbacktopendingbtn').prop("disabled", false);
                        $('#dispbacktopendingmodal').modal('hide');
                        toastrMessage('error',"Dispatch status should be on Active","Error");
                    }
                    else if (data.dberrors) {
                        $('#dispbacktopendingbtn').text('Back to Pending');
                        $('#dispbacktopendingbtn').prop("disabled", false);
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if(data.success){
                        var oTable = $('#dispatchdatatbl').dataTable();
                        oTable.fnDraw(false);
                        $('#dispbacktopendingmodal').modal('hide');
                        $('#dispatchinformationmodal').modal('hide');
                        toastrMessage('success',"Successful","Success");
                    }
                }
            });
        });

        function changeToApprovedFn(){
            var recordId=$('#dispatchinfoid').val();
            $('#dispapproveid').val(recordId);
            $('#dispapprovebtn').text('Approve');
            $('#dispapprovebtn').prop("disabled", false);
            $('#dispapprovemodal').modal('show');
        }

        $("#dispapprovebtn").click(function() {
            var registerForm = $("#dispapproveform");
            var formData = registerForm.serialize();
            $.ajax({
                url: '/approveDispatch',
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
                    $('#dispapprovebtn').text('Approving...');
                    $('#dispapprovebtn').prop("disabled", true);
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
                    if(data.statuserror){
                        $('#dispapprovebtn').text('Approve');
                        $('#dispapprovebtn').prop("disabled", false);
                        $('#dispapprovemodal').modal('hide');
                        toastrMessage('error',"Dispatch status should be on Pending","Error");
                    }
                    else if (data.dberrors) {
                        $('#dispapprovebtn').text('Approve');
                        $('#dispapprovebtn').prop("disabled", false);
                        $('#dispapprovemodal').modal('hide');
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if(data.success){
                        var oTable = $('#dispatchdatatbl').dataTable();
                        oTable.fnDraw(false);
                        $('#dispapprovemodal').modal('hide');
                        $('#dispatchinformationmodal').modal('hide');
                        toastrMessage('success',"Successful","Success");
                    }
                }
            });
        });

        function closeDispatchFn(){
            $('.mainforminp').val("");
            $('.errordatalabel').html("");
            $("#dispDynamicTable > tbody").empty();
            CalculateTotalDispatch();
        }

        function closeDispatchUpdateFn(){
            $('.mainforminp').val("");
            $('.errordatalabel').html("");
            $("#dispDynamicTable > tbody").empty();
            $('#dispatchOperationtypes').val(1);
            $('#DispatchMode').val(null).select2({
                placeholder:"Select Dispatch mode here",
                minimumResultsForSearch: -1
            });
            $('.mainprop').hide();
            $('#closeupdatedispatchbtn').hide();
            $('#dispatchCurrRecId').val("");
            $('#Remark').val("");
            $('#savebuttondispatch').text('Save');
            $('#savebuttondispatch').prop("disabled",false);
            CalculateTotalDispatch();
        }

        function voidDispReason(){
            $('#dispvoid-error').html("");
        }

        function backToPendingDispFn(){
            $('#dispbacktopending-error').html("");
        }

        //start get header data
        function getheaderId() {
            var hid = $('#requistionId').val();
            var sstr = $('#sstore').val();
            var dstr = $('#dstore').val();
            $('#receIds').val(hid);
            $('#receivingstoreid').val(sstr);
            $('#desstId').val(dstr);
            $('#requisitionsid').val("");
            $('#reqItemname').selectpicker(null).trigger('change');
           
        }
        //end get header data

        //Start Print Attachment
        $('body').on('click', '.printReqAttachment', function() {
            var id = $(this).data('id');
            var link="/reqcomm/"+id;
            window.open(link, 'Requisition', 'width=1200,height=800,scrollbars=yes');
        });
        //End Print Attachment

        //Start Print Dispatch Attachment
        $('body').on('click', '.printDispatchAttachment', function() {
            var id = $(this).data('id');
            var link="/dispcomm/"+id;
            window.open(link, 'Dispatch', 'width=1200,height=800,scrollbars=yes');
        });
        //End Print Dispatch Attachment

        //Start show adjustment doc info
        function adjInfoFn(recordId){
            var comments;
            var issstore;
            var appstore;
            var statusvals;
            var lidata="";
            var forecolor="";

            $("#statusid").val(recordId);
            $("#adjId").val(recordId);
            $('.actionpropbtn').hide();
            $('#customer_row').hide();
            $('#adj_detail_div').hide();

            $.ajax({
               url: '/showAdjData'+'/'+recordId,
                type: 'GET',
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
                
                success: function(data) {
                    $.each(data.adjustmentdata, function(key, value) {
                        $('#infoproducttype').html(value.ProductType);
                        $('#infocompanytype').html(value.CompanyType);
                        $('#infoadjustmenttype').html(value.Type == "Increase" ? `${value.Type} (<i class="fas fa-plus"></i>)` : `${value.Type} (<i class="fas fa-minus"></i>)`);

                        $('#infocustomer').html(value.CustomerName);
                        $('#infostore').html(value.StoreName);
                        $('#infodate').html(value.AdjustedDate);
                        $('#infomemo').html(value.Memo);
                        $("#statusi").val(value.Status);
                        $('#infostatus').text(value.Status);
                        $("#currentStatus").val(value.Status);

                        if(parseInt(value.customers_id) == 1){
                            $('#customer_row').hide();
                        }
                        else if(parseInt(value.customers_id) > 1){
                            $('#customer_row').show();
                        }

                        if(value.Type == "Increase"){
                            $("#unit_cp").html("Unit Price");
                            $("#total_cp").html("Total Price");
                        }
                        else if(value.Type == "Decrease"){
                            $("#unit_cp").html("Unit Cost");
                            $("#total_cp").html("Total Cost");
                        }

                        if(value.Status == "Draft"){
                            $("#changetopending").show();
                            forecolor = "#82868b";
                        }
                        else if(value.Status == "Pending"){
                            $("#backtodraft").show();
                            $("#verifybtn").show();
                            forecolor = "#ff9f43";
                        }
                        else if(value.Status == "Verified"){
                            $("#approvebtn").show();
                            $("#backtopending").show();
                            $("#rejectbtn").show();
                            forecolor = "#7367f0";
                        }
                        else if(value.Status == "Approved"){
                            //$("#backtoverify").show();
                            forecolor = "#28c76f";
                        }
                        else if(value.Status == "Void" || value.Status == "Void(Draft)" || value.Status == "Void(Pending)" || value.Status == "Void(Verified)" || value.Status == "Void(Approved)"){
                            $(".actionpropbtn").hide();
                            forecolor = "#ea5455";
                        }
                        else{
                            $(".actionpropbtn").hide();
                            forecolor = "#ea5455";
                        }
                        $("#statustitles").html(`<span style='color:${forecolor};font-weight:bold;font-size:16px;text-align:right;'>${value.DocumentNumber}, ${value.Status}</span>`);
                    });

                    $.each(data.activitydata, function(key, value) {
                        var classes="";
                        var reasonbody="";
                        if(value.action == "Edited" || value.action == "Change to Pending" || value.action == "Back to Pending" || value.action == "Edited (Dispatch)" || value.action == "Back to Pending (Dispatch)"){
                            classes="warning";
                        }
                        else if(value.action == "Verified" ){
                            classes="info";
                        }
                        else if(value.action == "Change to Counting" || value.action == "Verified (Dispatch)"){
                            classes="primary";
                        }
                        else if(value.action == "Created" || value.action == "Back to Draft" || value.action == "Back to Verify" || value.action == "Back to Review" || value.action == "Undo Void" || value.action == "Created (Dispatch)" || value.action == "Undo Void (Dispatch)"){
                            classes="secondary";
                        }
                        else if(value.action == "Approved" || value.action == "Received" || value.action == "Approved (Dispatch)"){
                            classes="success";
                        }
                        else if(value.action == "Void" || value.action=="Void(Draft)" || value.action=="Void(Pending)" || value.action=="Void(Approved)" || value.action=="Void(Reviewed)" || value.action=="Rejected" || value.action=="Void (Dispatch)"){
                            classes="danger";
                        }

                        if(value.reason!=null && value.reason!=""){
                            reasonbody='</br><span class="text-muted"><b>Reason:</b> '+value.reason+'</span>';
                        }
                        else{
                            reasonbody="";
                        }
                        lidata+='<li class="timeline-item"><span class="timeline-point timeline-point-'+classes+' timeline-point-indicator"></span><div class="timeline-header mb-sm-0 mb-0"><h6 class="mb-0">'+value.action+'</h6><span class="text-muted"><i class="fa-regular fa-user"></i> '+value.FullName+'</span>'+reasonbody+'</br><span class="text-muted"><i class="fa-regular fa-clock"></i> '+value.time+'</span></div></li>';
                    });
                    $("#actiondiv").empty();
                    $('#actiondiv').append(lidata);
                },
            });

            $('#commdatatable').DataTable({
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
                "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/showAdjDetailData/' + recordId,
                    type: 'DELETE',
                },
                columns: [
                    {
                        data:'DT_RowIndex',
                        width:"2%"
                    },
                    {
                        data: 'Reason',
                        name: 'Reason',
                        width:"4%"
                    },
                    {
                        data: 'LocationName',
                        name: 'LocationName',
                        width:"4%"
                    },
                    {
                        data: 'CommType',
                        name: 'CommType',
                        width:"4%"
                    },
                    {
                        data: 'SupplierName',
                        name: 'SupplierName',
                        width:"5%"
                    },
                    {
                        data: 'GrnNumber',
                        name: 'GrnNumber',
                        width:"5%"
                    },
                    {
                        data: 'ProductionNumber',
                        name: 'ProductionNumber',
                        width:"5%"
                    },
                    {
                        data: 'CertNumber',
                        name: 'CertNumber',
                        width:"5%"
                    },
                    {
                        data: 'Origin',
                        name: 'Origin',
                        width:"6%"
                    },
                    {
                        data: 'GradeName',
                        name: 'GradeName',
                        width:"4%"
                    },
                    {
                        data: 'ProcessType',
                        name: 'ProcessType',
                        width:"4%"
                    },
                    {
                        data: 'CropYear',
                        name: 'CropYear',
                        width:"4%"
                    },
                    {
                        data: 'UomName',
                        name: 'UomName',
                        width:"4%"
                    },
                    {
                        data: 'NumOfBag',
                        name: 'NumOfBag',
                        render: $.fn.dataTable.render.number(',', '.',0, ''),
                        width:"4%"
                    },
                    {
                        data: 'BagWeight',
                        name: 'BagWeight',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"4%"
                    },
                    {
                        data: 'TotalKg',
                        name: 'TotalKg',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"4%"
                    },
                    {
                        data: 'NetKg',
                        name: 'NetKg',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"4%"
                    },
                    {
                        data: 'WeightByTon',
                        name: 'WeightByTon',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"4%"
                    },
                    {
                        data: 'Feresula',
                        name: 'Feresula',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"4%"
                    },
                    {
                        data: 'unit_cost_or_price',
                        name: 'unit_cost_or_price',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"4%"
                    },
                    {
                        data: 'total_cost_or_price',
                        name: 'total_cost_or_price',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"4%"
                    },
                    {
                        data: 'VarianceShortage',
                        name: 'VarianceShortage',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"4%"
                    },
                    {
                        data: 'VarianceOverage',
                        name: 'VarianceOverage',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"4%"
                    },
                    {
                        data: 'Memo',
                        name: 'Memo',
                        width:"4%"
                    },
                ],
                createdRow: function(row, data, dataIndex) {
                    $('td', row).each(function() {
                        // If the cell's text is "0", set it to an empty string
                        if ($(this).text() == "0.00" || $(this).text() == "0") {
                            $(this).text('');
                        }
                    });
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

                    var totalbagvar = api
                    .column(13)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totalbagweight = api
                    .column(14)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totalgrosskg = api
                    .column(15)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totalkgvar = api
                    .column(16)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totaltonvar = api
                    .column(17)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totalferesulavar = api
                    .column(18)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totalcostprice = api
                    .column(20)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totalvarianceshr = api
                    .column(21)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totalvarianceov = api
                    .column(22)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
                    
                    $('#totalbag').html(totalbagvar === 0 ? '' : numformat(totalbagvar));
                    $('#totalbagweight').html(totalbagweight === 0 ? '' : numformat(parseFloat(totalbagweight).toFixed(2)));
                    $('#totalgrosskg').html(totalgrosskg === 0 ? '' : numformat(parseFloat(totalgrosskg).toFixed(2)));
                    $('#totalkg').html(totalkgvar === 0 ? '' : numformat(parseFloat(totalkgvar).toFixed(2)));
                    $('#totalton').html(totaltonvar === 0 ? '' : numformat(parseFloat(totaltonvar).toFixed(2)));
                    $('#totalferesula').html(totalferesulavar === 0 ? '' : numformat(parseFloat(totalferesulavar).toFixed(2)));
                    $('#info_total_cost_price').html(totalcostprice === 0 ? '' : numformat(parseFloat(totalcostprice).toFixed(2)));
                    $('#totalvarshortage').html(totalvarianceshr === 0 ? '' : numformat(parseFloat(totalvarianceshr).toFixed(2)));
                    $('#totalvarovrage').html(totalvarianceov === 0 ? '' : numformat(parseFloat(totalvarianceov).toFixed(2)));
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
                    $('#adj_detail_div').show();
                    $(".infoscl").collapse('show');
                    $("#infomodal").modal('show');
                }
            });
        }
        //End show requisition doc info

        //end info modal
        function appendTable() {
            $("#dynamicTable").empty();
            $("#dynamicTable").append('<tr><th style="width:3%;">#</th><th style="width:27%;">Item Name</th><th style="display:none;">Code</th><th style="width:11%;">UOM</th><th style="width:15%;">Qty. On Hand</th><th style="width:15%;">Quantity</th><th style="width:26%;">Remark</th><th style="width:3%;"></th>');
        }

        function closeReqAddModal() {
            $("#newreqform")[0].reset();
            $('#newquantity-error').html("");
            $('#newitemname-error').html("");
        }

        function reqTypeVal() {
            $('#type-error').html("");
        }

        function sourcestoreVal() {
            var storeid=$('#sstore').val();
            var defaultoption = '<option selected value=""></option>';
            var floormapopt = $("#locationdefault > option").clone();
            $('.FloorMap').empty();
            $('.FloorMap').append(floormapopt);
            $(".FloorMap option[title!="+storeid+"]").remove(); 
            $('.FloorMap').append(defaultoption);
            $('.FloorMap').select2
            ({
                placeholder: "Select Floor map here",
            });
            $('.select2-selection__rendered').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
            resetQtyProp();
            $('#sourcestore-error').html("");
        }

        function destinationstoreVal() {
            $('#destinationstore-error').html("");
        }

        function dateVal() {
            $('#date-error').html("");
        }

        function reqReqpurposeVal() {
            $('#purpose-error').html("");
        }

        function requestedByVal() {
            $('#requestedby-error').html("");
        }

        $(function () {
            cardSection = $('#page-block');
        });

        $('#fiscalyear').on('change', function() {
            var fyear = $(this).val();
            getAdjustmentListFn(fyear);
        });

        function verifyFn(){
            var rid=$('#reqId').val();
            $('#verifyId').val(rid);
            $('#verifyreqmodal').modal('show');
            $('#converifybtn').text("Verify");
            $('#converifybtn').prop( "disabled", false );
        }

        function getApproveInfo(){
            var rid=$('#reqId').val();
            $('#appId').val(rid);
            $('#approveconmodal').modal('show');
            $('#conapprovebtn').text("Approve");
            $('#conapprovebtn').prop( "disabled", false );
        }

        function getCommentInfo(){
            var status=$('#statusi').val();
            var rid=$('#reqId').val();
            $('#commentid').val(rid);
            $('#commentstatus').val(status);
            $('#commentModal').modal('show');
            $("#Comment").focus();
            $('#concommentbtn').text("Comment");
            $('#concommentbtn').prop( "disabled", false );
        }

        function getRejectInfo(){
            var status=$('#statusi').val();
            var rid=$('#reqId').val();
            $('#rejId').val(rid);
            $('#rejstatus').val(status);
            $('#rejectconmodal').modal('show');
            $('#conrejectbtn').text("Reject");
            $('#conrejectbtn').prop( "disabled", false );
        }

        function getIssueInfo(){
            var rid=$('#reqId').val();
            $('#issueId').val(rid);
            $('#issueconmodal').modal('show');
            $('#conissuebtn').text("Issue");
            $('#conissuebtn').prop( "disabled", false );
        }

        function getPendingInfoConf() {
            var stid = $('#statusid').val();
            $('#pendingid').val(stid);
            $('#pendingconfmodal').modal('show');
            $('#pendingbtn').prop("disabled", false);
        }

        function reviewFn() {
            var rid=$('#reqId').val();
            $('#reviewid').val(rid);
            $('#reviewmodal').modal('show');
            $('#reviewbtn').text("Change to Review");
            $('#reviewbtn').prop("disabled", false);
        }

        $("#reviewbtn").click(function() {
            var registerForm = $("#reviewform");
            var formData = registerForm.serialize();
            $.ajax({
                url: '/reqChangeToReview',
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

                    $('#reviewbtn').text('Reviewing...');
                    $('#reviewbtn').prop("disabled", true);
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
                    if(data.statuserror){
                        $('#reviewbtn').text('Change to Review');
                        $('#reviewbtn').prop("disabled",false);
                        $('#reviewmodal').modal('hide');
                        toastrMessage('error',"Requisition status should be on Verified","Error");
                    }
                    else if (data.dberrors) {
                        $('#reviewbtn').text('Change to Review');
                        $('#reviewbtn').prop("disabled",false);
                        $('#reviewmodal').modal('hide');
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if(data.success){
                        $('#reviewmodal').modal('hide');
                        $('#reqInfoModal').modal('hide');
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                        toastrMessage('success',"Successful","Success");
                    }
                }
            });
        });

        //Start change to pending
        $('#pendingbtn').click(function(){  
            var recordId = $('#pendingid').val();
            $.get("/showReqData" + '/' + recordId, function(data) {
                var dc = data;
                var len = data.reqHeader.length;
                for (var i = 0; i <= len; i++) {
                    var st = data.reqHeader[i].Status;
                    var stold = data.reqHeader[i].StatusOld;
                    if (st === "Confirmed") {
                        toastrMessage('error',"Requisition already confirmed","Error");
                        $("#pendingconfmodal").modal('hide');
                        $("#reqInfoModal").modal('hide');
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                    } else if (st === "Void") {
                        toastrMessage('error',"Requisition already voided","Error");
                        $("#pendingconfmodal").modal('hide');
                        $("#reqInfoModal").modal('hide');
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                    } else if (st === "Pending") {
                        toastrMessage('error',"Requisition already pending status","Error");
                        $("#pendingconfmodal").modal('hide');
                        $("#reqInfoModal").modal('hide');
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                    } else if (st === "Draft") {
                        var registerForm = $("#pendingreceivingform");
                        var formData = registerForm.serialize();
                        $.ajax({
                            url: '/pendingReqStatus',
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
                                $('#pendingbtn').text('Changing...');
                                $('#pendingbtn').prop("disabled", true);
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
                                if (data.success) {
                                    $('#pendingbtn').text('Change to Pending');
                                    toastrMessage('success',"Successful","Success");
                                    $("#pendingconfmodal").modal('hide');
                                    $("#reqInfoModal").modal('hide');
                                    var oTable = $('#laravel-datatable-crud').dataTable();
                                    oTable.fnDraw(false);
                                }
                            },
                        });
                    }
                }
            });
        });
        //End change to pending

        function backToDraftFn() {
            var stid = $('#statusid').val();
            $('#draftid').val(stid);
            $('#BackToDraftComment').val("");
            $('#backtodraft-error').html("");
            $('#backtodraftmodal').modal('show');
            $('#backtodraftbtn').text("Back to Draft");
            $('#backtodraftbtn').prop("disabled", false);
        }

        function backToPendingFn(){
            var stid = $('#statusid').val();
            $('#backtopendingid').val(stid);
            $('#BackToPendingComment').val("");
            $('#backtopending-error').html("");
            $('#backtopendingmodal').modal('show');
            $('#backtopendingbtn').text("Back to Pending");
            $('#backtopendingbtn').prop("disabled", false);
        }

        function backToVerifyFn(){
            var stid = $('#statusid').val();
            $('#backtoverifyid').val(stid);
            $('#BackToVerifyComment').val("");
            $('#backtoverify-error').html("");
            $('#backtoverifybutton').text("Back to Verify");
            $('#backtoverifybutton').prop("disabled", false);
            $('#backtoverifymodal').modal('show');
        }

        function backToPenValFn() {
            $('#backtopending-error').html("");
        }

        function backToVerifyValFn() {
            $('#backtoverify-error').html("");
        }

        function backToReviewFn(){
            var stid = $('#statusid').val();
            $('#backtoreviewid').val(stid);
            $('#BackToReviewComment').val("");
            $('#backtoreview-error').html("");
            $('#backtoreviewbutton').text("Back to Review");
            $('#backtoreviewbutton').prop("disabled", false);
            $('#backtoreviewmodal').modal('show');
        }

        function backToReviewValFn() {
            $('#backtoreview-error').html("");
        }

        $("#backtoreviewbutton").click(function() {
            var registerForm = $("#backtoreviewform");
            var formData = registerForm.serialize();
            $.ajax({
                url: '/backToReviewReq',
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

                    $('#backtoreviewbutton').text('Changing...');
                    $('#backtoreviewbutton').prop("disabled", true);
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
                        if (data.errors.BackToReviewComment) {
                            $('#backtoreview-error').html(data.errors.BackToReviewComment[0]);
                        }
                        $('#backtoreviewbutton').text('Back to Review');
                        $('#backtoreviewbutton').prop("disabled",false);
                        toastrMessage('error',"Please check your input","Error");
                    }
                    else if (data.dberrors) {
                        $('#backtoreviewbutton').text('Back to Review');
                        $('#backtoreviewbutton').prop("disabled",false);
                        $('#backtoreviewmodal').modal('hide');
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if(data.statuserror){
                        $('#backtoreviewbutton').text('Back to Review');
                        $('#backtoreviewbutton').prop("disabled",false);
                        $('#backtoreviewmodal').modal('hide');
                        toastrMessage('error',"Requisition status should be on Approved","Error");
                    }
                    else if(data.success){
                        $('#backtoreviewmodal').modal('hide');
                        $('#reqInfoModal').modal('hide');
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                        toastrMessage('success',"Successful","Success");
                    }
                }
            });
        });

        $("#backtoverifybutton").click(function() {
            var registerForm = $("#backtoverifyform");
            var formData = registerForm.serialize();
            $.ajax({
                url: '/backToVerifyReq',
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

                    $('#backtoverifybutton').text('Changing...');
                    $('#backtoverifybutton').prop("disabled", true);
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
                        if (data.errors.BackToVerifyComment) {
                            $('#backtoverify-error').html(data.errors.BackToVerifyComment[0]);
                        }
                        $('#backtoverifybutton').text('Back to Verify');
                        $('#backtoverifybutton').prop("disabled",false);
                        toastrMessage('error',"Please check your input","Error");
                    }
                    else if (data.dberrors) {
                        $('#backtoverifybutton').text('Back to Verify');
                        $('#backtoverifybutton').prop("disabled",false);
                        $('#backtoverifymodal').modal('hide');
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if(data.statuserror){
                        $('#backtoverifybutton').text('Back to Verify');
                        $('#backtoverifybutton').prop("disabled",false);
                        $('#backtoverifymodal').modal('hide');
                        toastrMessage('error',"Requisition status should be on Review","Error");
                    }
                    else if(data.success){
                        $('#backtoverifymodal').modal('hide');
                        $('#reqInfoModal').modal('hide');
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                        toastrMessage('success',"Successful","Success");
                    }
                }
            });
        });

        $("#backtodraftbtn").click(function() {
            var registerForm = $("#backtodraftform");
            var formData = registerForm.serialize();
            $.ajax({
                url: '/backToDraftReq',
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

                    $('#backtodraftbtn').text('Changing...');
                    $('#backtodraftbtn').prop("disabled", true);
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
                        if (data.errors.BackToDraftComment) {
                            $('#backtodraft-error').html(data.errors.BackToDraftComment[0]);
                        }
                        $('#backtodraftbtn').text('Back to Draft');
                        $('#backtodraftbtn').prop("disabled",false);
                        toastrMessage('error',"Please check your input","Error");
                    }
                    else if (data.dberrors) {
                        $('#backtodraftbtn').text('Back to Draft');
                        $('#backtodraftbtn').prop("disabled",false);
                        $('#backtodraftmodal').modal('hide');
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if(data.statuserror){
                        $('#backtodraftbtn').text('Back to Draft');
                        $('#backtodraftbtn').prop("disabled",false);
                        $('#backtodraftmodal').modal('hide');
                        toastrMessage('error',"Requisition status should be on Pending","Error");
                    }
                    else if(data.success){
                        $('#backtodraftmodal').modal('hide');
                        $('#reqInfoModal').modal('hide');
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                        toastrMessage('success',"Successful","Success");
                    }
                }
            });
        });

        //Start Verify here
        $("#converifybtn").click(function() {
            var registerForm = $("#verifyform");
            var formData = registerForm.serialize();
            $.ajax({
            url:'/verifyCommReq',
                type:'POST',
                data:formData,
                beforeSend:function(){
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
                    $('#converifybtn').text('Verifying...');
                    $('#converifybtn').prop( "disabled", true );
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
                success:function(data){
                    if (data.dberrors) {
                        $('#converifybtn').text('Verify');
                        $('#converifybtn').prop("disabled",false);
                        $('#verifyreqmodal').modal('hide');
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if(data.statuserror){
                        $('#converifybtn').text('Verify');
                        $('#converifybtn').prop("disabled",false);
                        $('#verifyreqmodal').modal('hide');
                        toastrMessage('error',"Requisition status should be on Pending","Error");
                    }
                    else if(data.success){
                        $('#converifybtn').text('Verify');
                        toastrMessage('success',"Successful","Success");
                        $("#verifyreqmodal").modal('hide')
                        $("#reqInfoModal").modal('hide');
                        var oTable = $('#laravel-datatable-crud').dataTable(); 
                        oTable.fnDraw(false);
                    }
                },
            });
        });
        //End Verify here

        //Start approve here
        $("#conapprovebtn").click(function() {
            var registerForm = $("#approveform");
            var formData = registerForm.serialize();
            $.ajax({
            url:'/approveCommReq',
                type:'POST',
                data:formData,
                beforeSend:function(){
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
                    $('#conapprovebtn').text('Approving...');
                    $('#conapprovebtn').prop( "disabled", true );
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
                success:function(data){
                    if(data.referenceerr){
                        $('#conapprovebtn').text('Approve');
                        $('#conapprovebtn').prop("disabled", false);
                        $('#approveconmodal').modal('hide');
                        toastrMessage('error',"Please insert reference number","Error");
                    }
                    else if(data.bookingerr){
                        $('#conapprovebtn').text('Approve');
                        $('#conapprovebtn').prop("disabled", false);
                        $('#approveconmodal').modal('hide');
                        toastrMessage('error',"Please insert booking number","Error");
                    }
                    else if(data.cusreqerr){
                        $('#conapprovebtn').text('Approve');
                        $('#conapprovebtn').prop("disabled", false);
                        $('#approveconmodal').modal('hide');
                        toastrMessage('error',"Please select Buyer","Error");
                    }
                    else if(data.success){
                        $('#conapprovebtn').text('Approve');
                        toastrMessage('success',"Successful","Success");
                        $("#approveconmodal").modal('hide')
                        $("#reqInfoModal").modal('hide');
                        var oTable = $('#laravel-datatable-crud').dataTable(); 
                        oTable.fnDraw(false);
                    }
                },
            });
        });
        //End Approve

        $("#backtopendingbtn").click(function() {
            var registerForm = $("#backtopendingform");
            var formData = registerForm.serialize();
            $.ajax({
                url: '/reqBackToPending',
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

                    $('#backtopendingbtn').text('Changing...');
                    $('#backtopendingbtn').prop("disabled", true);
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
                        if (data.errors.BackToPendingComment) {
                            $('#backtopending-error').html(data.errors.BackToPendingComment[0]);
                        }
                        $('#backtopendingbtn').text('Back to Pending');
                        $('#backtopendingbtn').prop("disabled",false);
                        toastrMessage('error',"Check your input","Error");
                    }
                    else if (data.dberrors) {
                        $('#backtopendingbtn').text('Back to Pending');
                        $('#backtopendingbtn').prop("disabled",false);
                        $('#backtopendingmodal').modal('hide');
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if(data.statuserror){
                        $('#backtopendingbtn').text('Back to Pending');
                        $('#backtopendingbtn').prop("disabled",false);
                        $('#backtopendingmodal').modal('hide');
                        toastrMessage('error',"Requisition status should be on Verified","Error");
                    }
                    else if(data.success){
                        $('#backtopendingmodal').modal('hide');
                        $('#reqInfoModal').modal('hide');
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                        toastrMessage('success',"Successful","Success");
                    }
                }
            });
        });

        //Start Comment
        $('body').on('click', '#concommentbtn', function()
        {
            var statusVal = $("#commentstatus").val();
            if(statusVal=="Approved"||statusVal=="Issued")
            {
                toastrMessage('error',"You cant Comment on this status","Error");
            }
            else if(statusVal=="Pending"||statusVal=="Rejected")
            {
                var registerForm = $("#commentform");
                var formData = registerForm.serialize();
                $.ajax({
                url:'/commentReq',
                    type:'POST',
                    data:formData,
                    beforeSend:function(){
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
                        $('#concommentbtn').text('Commenting...');
                        $('#concommentbtn').prop( "disabled", true );
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
                    success:function(data) {
                        if(data.errors) 
                        {
                            if(data.errors.Comment){
                                $('#comment-error' ).html( data.errors.Comment[0] );
                            }
                            $('#concommentbtn').text('Comment');
                            $('#concommentbtn').prop( "disabled",false);
                            toastrMessage('error',"Check your inputs","Error"); 
                        }
                        if(data.success) {
                            $('#concommentbtn').text('Comment');
                            $('#concommentbtn').prop("disabled",false);
                            toastrMessage('success',"Successful","Success");
                            $("#commentModal").modal('hide');
                            $("#reqInfoModal").modal('hide');
                            var oTable = $('#laravel-datatable-crud').dataTable(); 
                            oTable.fnDraw(false);
                            $("#commentform")[0].reset();
                        }
                    },
                });
            }
        });
        //End Comment

        //Start Rejection
        $("#conrejectbtn").click(function() {
            var statusVal = $("#rejstatus").val();
            if(statusVal=="Issued"||statusVal=="Rejected")
            {
                toastrMessage('error',"You cant Reject on this status","Error");
            }
            else if(statusVal=="Pending"||statusVal=="Commented"||statusVal=="Approved")
            {
                var registerForm = $("#rejectform");
                var formData = registerForm.serialize();
                $.ajax({
                url:'/reqRejectComm',
                    type:'POST',
                    data:formData,
                    beforeSend:function(){
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
                        $('#conrejectbtn').text('Rejecting...');
                        $('#conrejectbtn').prop( "disabled", true );
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
                    success:function(data) {
                        if(data.success) {
                            $('#conrejectbtn').text('Reject');
                            toastrMessage('success',"Successful","Success");
                            $("#rejectconmodal").modal('hide');
                            $("#reqInfoModal").modal('hide');
                            var oTable = $('#laravel-datatable-crud').dataTable(); 
                            oTable.fnDraw(false);
                            $("#rejectform")[0].reset();
                        }
                    },
                });
            }
        });
        //End Rejection

        //Start issue here
        $("#conissuebtn").click(function() {
            var recordId=$("#issueId").val();
            $.get("/showReqDataapproving" +'/' + recordId , function (data) 
            {     
                var dc=data;
                var len=data.reqHeader.length;
                for(var i=0;i<=len;i++) 
                {  
                    var stval=data.reqHeader[i].Status;
                    if(stval=="Issued")
                    {
                        $("#issueconmodal").modal('hide');
                        $("#reqInfoModal").modal('hide');
                        var rTable = $('#laravel-datatable-crud').dataTable(); 
                        rTable.fnDraw(false);
                        toastrMessage('error',"Requisition is already Issued","Error");
                    }
                    else
                    {
                        var registerForm = $("#issueform");
                        var formData = registerForm.serialize();
                        $.ajax({
                        url:'/issReqComm',
                            type:'POST',
                            data:formData,
                            beforeSend:function(){
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
                                $('#conissuebtn').text('Issuing...');
                                $('#conissuebtn').prop( "disabled", true );
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
                            success:function(data) {
                                if(data.valerror)
                                {
                                    var singleVal='';
                                    var commname='';
                                    var len=data['valerror'].length;

                                    $.each(data.getcommlist, function(key, value) {
                                        commname+= key+". "+value.Origin+"</br>________________________________</br>";
                                    });

                                    toastrMessage('error',"There is no available amount for the following commodity"+commname,"Error");
                                    $('#conissuebtn').text('Issue');
                                    $('#conissuebtn').prop( "disabled",false);
                                    $("#issueconmodal").modal('hide');

                                    // for(var i=0;i<=len;i++) 
                                    // {  
                                    //     var count=data.countedval;
                                    //     var inc=i+1;
                                    //     singleVal=(data['countItems'][i].Name);
                                    //     loopedVal=loopedVal+"</br>"+inc+" ) "+singleVal;
                                    //     $('#conissuebtn').text('Issue');
                                    //     $('#conissuebtn').prop( "disabled",false);
                                    //     toastrMessage('error',"There is no available quantity for "+count+"  Commodity"+loopedVal,"Error");
                                    //     $("#issueconmodal").modal('hide');
                                    //     $("#issueform")[0].reset();
                                    //     var oTable = $('#laravel-datatable-crud').dataTable();
                                    //     oTable.fnDraw(false);
                                    // }    
                                }
                                
                                else if(data.success){
                                    $('#conissuebtn').text('Issue');
                                    $('#conissuebtn').prop( "disabled", false );
                                    toastrMessage('success',"Successful","Success");
                                    $("#issueconmodal").modal('hide');
                                    $("#reqInfoModal").modal('hide');
                                    $.fn.dataTable.ext.errMode = 'throw';
                                    var oTable = $('#laravel-datatable-crud').dataTable();
                                    oTable.fnDraw(false);
                                    $('#IssuedByUser').val(null).trigger('change');
                                    $("#issueform")[0].reset();
                                    var link="/reqcomm/"+data.recdata;
                                    window.open(link, 'Requisition', 'width=1200,height=800,scrollbars=yes');
                                }
                            },
                        });
                    }
                }    
            });
        });
        //End issue

        //Start Print Attachment
        $('body').on('click', '.printSIVAttachment', function () 
        {
            var id = $(this).data('id');
            var link=$(this).data('link');
            window.open(link, 'Issue', 'width=1200,height=800,scrollbars=yes');
        });
        //End Print Attachment

        function voidReason()
        {
            $('#void-error').html("");
        }

        //Start undo void Modal With Value 
        // $('#undovoidmodal').on('show.bs.modal', function(event) {
        //     var button = $(event.relatedTarget);
        //     var id = button.data('id');
        //     var status = button.data('status');
        //     var ostatus = button.data('ostatus');
        //     var modal = $(this);
        //     modal.find('.modal-body #undovoidid').val(id);
        //     modal.find('.modal-body #ustatus').val(status);
        //     modal.find('.modal-body #oldstatus').val(ostatus);
        //     $('#undovoidbtn').prop("disabled", false);
        // });
        //End undo void Modal With Value 

        function undovoidreqdata(recordId){
            $.get("/showReqData" + '/' + recordId, function(data) {
                var dc = data;
                var len = data.reqHeader.length;
                for (var i = 0; i <= len; i++) {
                    var undvoidid = data.reqHeader[i].id;
                    var st = data.reqHeader[i].Status;
                    var stold = data.reqHeader[i].StatusOld;
                    var fyears=data.fyear;
                    var fyearstrs=data.fyearstr;
                    var fiscalyears = data.reqHeader[i].fiscalyear;
                    // if(parseFloat(fyearstrs)!=parseFloat(fiscalyears)){
                    //     toastrMessage('error',"You cant void a closed fiscal year transaction","Error");
                    // }
                    if (st == "Void"||st == "Void(Draft)"||st == "Void(Pending)"||st == "Void(Approved)"||st == "Void(Issued)") {
                        $("#undovoidid").val(undvoidid);
                        $("#ustatus").val(st);
                        $("#oldstatus").val(stold);
                        $('#undovoidbtn').prop("disabled", false);
                        $('#undovoidbtn').text("Undo Void");
                        $("#undovoidmodal").modal('show');
                    }
                    else{
                        toastrMessage('error',"Transaction should be a void transaction","Error");
                    }
                }
            });
        }

        function prTypeFn() {
            var productType=$('#ProductType').val();
            $('.commprop').hide();
            $('#CommoditySource').empty();
            $('#dynamicTable > tbody').empty();
            $('#commDynamicTable > tbody').empty();
            $('.productcls').hide(); 
            $('.customerdiv').hide();
            $('.recustomerdiv').hide();   
            $('.referencediv').hide();
            $('.bookingnumdiv').hide();
            $('#Customer').val(null).select2({
                placeholder:"Select Customer here",
                dropdownCssClass : 'commprp',
            });  

            $('#CustomerReceiver').val(null).select2({
                placeholder:"Select Buyer here",
                dropdownCssClass : 'commprp',
            });     

            if(productType==1){
                $('.commprop').show();
                $('.referencediv').show();
                $('.bookingnumdiv').hide();
                $('#commoditydiv').show(); 
            }
            else if(productType==2){
                $('.commprop').hide();
                $('#goodsdiv').show();
            }
            $('#prdtype-error').html("");
        }

        function reqReasonFn() {
            var reqReason=$('#RequestReason').val(); 
            var comtype=$('#CompanyType').val();
            $('#customerlbl').html('Customer');
            $('.recustomerdiv').hide();
            $('.bookingnumdiv').hide();
            $('.lablocdiv').hide();
            $('.typedt').hide();
            $('#BookingNumber').val("");

            $('#CustomerReceiver').val(null).select2
            ({
                placeholder: "Select Buyer here",
                dropdownCssClass : 'commprp',
            });

            $('#LabratoryLocation').val(null).select2
            ({
                placeholder: "Select Labratory location here",
            });

            $('.Supplier').empty();
            $('.Supplier').select2
            ({
                placeholder: "Select Customer first",
                dropdownCssClass : 'cusmidprp',
                minimumResultsForSearch: -1
            });

            $('.GrnNumber').empty();
            $('.GrnNumber').select2
            ({
                placeholder: "Select Supplier first",
                minimumResultsForSearch: -1
            });

            $('.ProductionNum').empty();
            $('.ProductionNum').select2
            ({
                placeholder: "Select Production order number here",
                minimumResultsForSearch: -1
            });

            $('.CertificateNum').empty();
            $('.CertificateNum').select2
            ({
                placeholder: "Select Production order first",
                minimumResultsForSearch: -1
            });

            $('.Origin').empty();
            $('.Origin').select2
            ({
                placeholder: "Select Commodity here",
                minimumResultsForSearch: -1
            });

            resetQtyProp();

            var defaultoption = '<option selected value=""></option>';
            var commtypeoptions = $("#commtypedefault > option").clone();
            $('.CommType').empty();
            $('.CommType').append(commtypeoptions);

            if(parseInt(reqReason)==1){
                $('#customerlbl').html('Customer');
            }
            else if(parseInt(reqReason)==3 && parseInt(comtype)==2){
                $('.bookingnumdiv').show();
            }
            else if(parseInt(reqReason)==3 && parseInt(comtype)==1){
                $('.recustomerdiv').show();
                $('.bookingnumdiv').show();
            }
            else if(parseInt(reqReason)==5){
                $('.lablocdiv').show();
            }
            $('.expcertcls').hide();
            $('.ExpCertificateNum').val("");

            if(parseInt(reqReason)==9){
                $('.CommType option').each(function() {
                    var optionValue = $(this).val();
                    if(parseInt(optionValue)!=1){
                        $(this).remove();
                    }
                });
            }

            $('.CommType').append(defaultoption);
            $('.CommType').select2
            ({
                placeholder: "Select here",
                dropdownCssClass : 'cusmidprp',
            }); 
            
            $('#bookingnum-error').html("");
            $('#reference-error').html("");
            $('#labloc-error').html("");
            $('#recustomer-error').html("");
            $('#reqreason-error').html("");
        }

        function adjustmentTypeFn() {
            var adjtype = $('#AdjustmentType').val();
            $('.qtyonhandcls').hide();
            
            if(adjtype == "Decrease"){
                $('.qtyonhandcls').show();
            }

            iterateTable();
            $('#adjustmenttype-error').html("");
        }

        function compTypeFn() {
            var comtype=$('#CompanyType').val();
            var customersId=1;
            var valuesToHide = [1,4];
            valuesToHide.forEach(function(value) {
                $('#RequestReason option[value="' + value + '"]').remove();
            });

            $('.Supplier').empty();
            $('.Supplier').select2
            ({
                placeholder: "Select Customer first",
                dropdownCssClass : 'cusmidprp',
                minimumResultsForSearch: -1
            });

            $('.GrnNumber').empty();
            $('.GrnNumber').select2
            ({
                placeholder: "Select Supplier first",
                minimumResultsForSearch: -1
            });

            $('.ProductionNum').empty();
            $('.ProductionNum').select2
            ({
                placeholder: "Select Production order number here",
                minimumResultsForSearch: -1
            });

            $('.CertificateNum').empty();
            $('.CertificateNum').select2
            ({
                placeholder: "Select Production order first",
                minimumResultsForSearch: -1
            });

            $('.Origin').empty();
            $('.Origin').select2
            ({
                placeholder: "Select Commodity here",
                minimumResultsForSearch: -1
            });

            resetQtyProp();
            var defaultoption = '<option selected value=""></option>';
            var supplierdata = $("#supplierdefault > option").clone();
            if(parseInt(comtype)==1){
                mergeddata=1+""+customersId;

                $('.customerdiv').hide();
                $('#RequestReason').val(null).select2
                ({
                    placeholder: "Select Request reason here"
                });
                $('#Customer').val(1).select2({
                    placeholder:"Select Customer here",
                    dropdownCssClass : 'commprp',
                });
                $('.Supplier').append(supplierdata);
                $(".Supplier option[title!="+mergeddata+"]").remove(); 
                $('.Supplier').append(defaultoption);
                $('.Supplier').select2
                ({
                    placeholder: "Select Supplier here",
                    dropdownCssClass : 'cusmidprp',
                });
            }
            else if(parseInt(comtype)==2){
                customersId=$('#Customer').val();
                mergeddata=1+""+customersId;
                $('.customerdiv').show();
                var cusopt='<option value=1>Sales-Customer</option><option value=4>Sample-Customer</option>';
                $('#RequestReason').append(cusopt);
                $('#RequestReason').val(null).select2
                ({
                    placeholder: "Select Request reason here"
                });

                $('#Customer').val(null).select2({
                    placeholder:"Select Customer here",
                    dropdownCssClass : 'commprp',
                });
            }

            $('.cusrepr').val("");
            $('.cusreprerr').html("");
            $('#comptype-error').html('');
        }

        function customerFn() {
            var cusorowner=$('#Customer').val();
			var mergeddata="1"+cusorowner;
            var defaultoption = '<option selected value=""></option>';
            var supplierdata = $("#supplierdefault > option").clone();
            $('.Supplier').empty();
            $('.Supplier').append(supplierdata);
            $(".Supplier option[title!="+mergeddata+"]").remove();
            $('.Supplier').append(defaultoption);
            $('.Supplier').select2
            ({
                placeholder: "Select Supplier here",
                dropdownCssClass : 'cusmidprp',
            });

            $('.GrnNumber').empty();
            $('.GrnNumber').select2
            ({
                placeholder: "Select Supplier first",
                minimumResultsForSearch: -1
            });

            $('.ProductionNum').empty();
            $('.ProductionNum').select2
            ({
                placeholder: "Select Production order number here",
                minimumResultsForSearch: -1
            });

            $('.CertificateNum').empty();
            $('.CertificateNum').select2
            ({
                placeholder: "Select Production order first",
                minimumResultsForSearch: -1
            });

            $('.Origin').empty();
            $('.Origin').select2
            ({
                placeholder: "Select Commodity here",
                minimumResultsForSearch: -1
            });

            resetQtyProp();
            $('#customer-error').html("");
        }

        function recustomerFn() {
            $('#recustomer-error').html("");
        }

        function bookingNumFn() {
            $('#bookingnum-error').html("");
        }

        function referenceFn() {
            $('#reference-error').html("");
        }

        function labLocationFn() {
            $('#labloc-error').html("");
        }

        function closeInfoModal(){
            var oTable = $('#laravel-datatable-crud').dataTable(); 
            oTable.fnDraw(false);
        }

        function tableReloadFn(flg) {
            var oTable = $('#laravel-datatable-crud').dataTable(); 
            oTable.fnDraw(false);
            var iTable = $('#customer-crud').dataTable(); 
            iTable.fnDraw(false);
            $('#customer-crud').DataTable().columns.adjust().draw();
        }

        function driverNameFn() {
            $('#drivername-error').html("");
        }

        function driverLicFn() {
            $('#driverlic-error').html("");
        }

        function driverPhoneFn() {
            $('#driverphone-error').html("");
        }

        function plateNumFn() {
            $('#platenum-error').html("");
        }

        function containerNumFn() {
            $('#containernumber-error').html("");
        }

        function sealNumFn() {
            $('#sealnumber-error').html("");
        }

        function personNameFn() {
            $('#personname-error').html("");
        }

        function personPhoneFn() {
            $('#personphone-error').html("");
        }

        function commentValFn() {
            $('#commentres-error').html("");
        }

        function resetQtyProp(){
            $('.qtydata').html("");
            $('.QtyOnHand').val("");
            $('.QtyOnHandByKg').val("");
            $('.NumOfBag').val("");
            $('.TotalBagWeight').val("");
            $('.TotalKg').val("");
            $('.NetKg').val("");
            $('.Feresula').val("");
            $('.variancecls').html("");
            $('.varianceshortage').val("");
            $('.varianceoverage').val("");
            CalculateCommTotal();
        }

        function numformat(val) {
            while (/(\d+)(\d{3})/.test(val.toString())) {
                val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
            }
            return val;
        }
    </script>
@endsection
