@extends('layout.app1')
@section('title')
@endsection
@section('styles')
<link rel="stylesheet" href="{{ asset('fontawesome6/pro/css/all.min.css') }}">
@endsection
@section('content')
<div class="app-content content">
    <div class="row">
        <div class="col-12">
            <div class="card card-app-design">
                <div class="card-body">
                    <div class="col-xl-12 col-lg-12">
                        
                            <div class="row">
                                <div class="col-xl-3 col-lg-12">
                                        <h4 class="card-title">Purchase Order(PO)
                                        <button type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm" onclick="refreshmaintables()"><i data-feather="refresh-cw"></i></button>
                                        <input type="hidden" name="currentdate" id="currentdate" class="form-control" value="{{ $todayDate }}" readonly>
                                        <input type="hidden" class="form-control" name="technicalviewpermission" id="technicalviewpermission" value="{{ auth()->user()->can('TE-View') ? 1 : 0 }}" readonly/>
                                        <input type="hidden" class="form-control" name="purchasevualationviewpermission" id="purchasevualationviewpermission" value="{{ auth()->user()->can('PE-View') ? 1 : 0 }}" readonly/>
                                        <input type="hidden" class="form-control" name="financialviewpermission" id="financialviewpermission" value="{{ auth()->user()->can('FE-View') ? 1 : 0 }}" readonly/>
                                        <input type="hidden" class="form-control" name="financialprogresspermission" id="financialprogresspermission" value="{{ auth()->user()->can('TE-Progress') ? 1 : 0 }}" readonly/>
                                    </h4>
                                </div>
                                <div class="col-xl-2 col-lg-12">
                                        <label strong style="font-size: 12px;font-weight:bold;">Fiscal Year</label>
                                        <select class="select2 form-control" name="fiscalyear" id="fiscalyear">
                                            @foreach ($fiscalyears as $fiscalyears)
                                                <option value="{{ $fiscalyears->FiscalYear }}">{{ $fiscalyears->Monthrange }}</option>
                                            @endforeach 
                                        </select>
                                </div>
                                <div class="col-xl-2 col-lg-12">
                                    <label strong style="font-size: 12px;font-weight:bold;">Item Type</label>
                                    <select data-column="2" class="selectpicker form-control itemfilter-select" data-live-search="true" data-selected-text-format="count" data-actions-box="true" data-count-selected-text="PE ({0})" data-live-search-placeholder="search item type" title="Select item type" multiple>
                                            <option  value="Goods">Goods</option>
                                            <option  value="Commodity">Commodity</option>
                                            
                                    </select>
                                </div>
                                <div class="col-xl-2 col-lg-12">
                                    <label strong style="font-size: 12px;font-weight:bold;">Filter By</label>
                                    <select data-column="8" class="selectpicker form-control filter-select" data-live-search="true" data-selected-text-format="count" data-actions-box="true" data-count-selected-text="PE ({0})" data-live-search-placeholder="search Filter" title="Select Filter" multiple>
                                            <option  value="0">Draft</option>
                                            <option  value="1">Pending</option>
                                            <option  value="2">Verify</option>
                                            <option  value="3">Approved</option>
                                            <option  value="4">Void</option>
                                            <option  value="5">Rejected</option>
                                            <option  value="6">Review</option>
                                            <option  value="7">Reviewed</option>
                                    </select>
                                </div>
                                <div class="col-xl-2 col-lg-12">
                                    <b>Review:</b>
                                    <label strong style="font-size: 12px;font-weight:bold;" id="budgetapprovalcount"></label>
                                    <span strong style="font-weight:bold;font-size:12px;text-decoration:underline;color:blue;" onclick="listreviewbudget()">View</span>
                                </div>
                            </div>
                        </div> 
                   
                        <div class="col-xl-12 col-lg-12">
                            <div class="card-datatable">
                                <div style="width:98%; margin-left:1%" class="" id="table-block">
                                    <table id="purchaordetables" class="display table-bordered table-striped table-hover dt-responsive mb-0" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th rowspan="2">#</th>
                                                <th rowspan="2" style="text-align: center;">PO#</th>
                                                <th rowspan="2" style="text-align: center;">Item Type</th>
                                                <th colspan="2" style="text-align: center;">Reference</th>
                                                <th colspan="2" style="text-align: center;">Supplier</th>
                                                <th colspan="2" style="text-align: center;">Date</th>
                                                <th rowspan="2">Net Pay</th>
                                                <th rowspan="2">Status</th>
                                                <th rowspan="2">Action</th>
                                                <th rowspan="2"></th>
                                            </tr>
                                            <tr style="text-align: center;">
                                                <th>Type</th>
                                                <th>Number</th>
                                                <th>Name</th>
                                                <th>TIN</th>
                                                <th>Order</th>
                                                <th>Deliver</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    
                </div>
            </div>
        </div>
    </div>
</div> 
<div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitleadd" data-backdrop="static" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitleadd">Purchase Order</h5>
                    <div class="row">
                        <div style="text-align: right;" id="statusdisplay"></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <div class="modal-body" id="card-block">
                    <form id="purchaseorderegisterform">
                        {{ csrf_field() }}
                        <div class="col-xl-12">
                            <div class="row">
                                <div class="col-xl-6 col-lg-12">
                                    <fieldset class="fset">
                                        <legend>Basic Information</legend>
                                            <div class="row">
                                                <div class="col-xl-4 col-md-6 col-sm-12 mb-2 errorclear">
                                                    <label strong style="font-size: 14px;">Item Type <b style="color:red;">*</b></label>
                                                    <select class="select2 form-control form-control-lg" name="purchaseordertype" id="purchaseordertype" data-placeholder="Select Type">
                                                        <option selected disabled  value=""></option>
                                                            <option value="Goods">Goods</option>  
                                                            <option value="Commodity">Commodity</option>
                                                        </select>
                                                    <span class="text-danger">
                                                        <strong id="purchaseordertype-error" class="rmerror"></strong>
                                                    </span>
                                                </div>
                                                <div class="col-xl-4 col-md-6 col-sm-12 mb-2 errorclear">
                                                    <label strong style="font-size: 14px;">Reference <b style="color:red;">*</b></label>
                                                    <select class="select2 form-control form-control-lg" name="reference" id="reference" data-placeholder="Select Reference">
                                                        <option selected disabled  value=""></option>  
                                                        <option value="Direct">Direct</option>
                                                        <option value="PE">PE</option>
                                                        
                                                    </select>
                                                    <span class="text-danger">
                                                        <strong id="reference-error" class="rmerror"></strong>
                                                    </span>
                                                </div>
                                                
                                                <div class="col-xl-4 col-md-6 col-sm-12 mb-2 errorclear" id="pediv">
                                                    <label strong style="font-size: 14px;">Reference No<b style="color:red;">*</b></label>
                                                    <select class="select2 form-control form-control-lg selectclass" name="purchasevaulation_id" id="pe" data-placeholder="Select Reference#">
                                                        <option ></option>
                                                        @foreach ($pe as $key)
                                                            <option value="{{ $key->id }}">{{ $key->documentumber }},{{ $key->Name }},{{ $key->TinNumber }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="text-danger">
                                                        <strong id="pe-error" class="rmerror"></strong>
                                                    </span>
                                                </div>

                                                    <div class="col-xl-4 col-md-6 col-sm-12 mb-2 errorclear" id="commoditytypediv">
                                                            <label strong style="font-size: 14px;">Commodity Type  <b style="color:red;">*</b></label>
                                                            <select class="select2 form-control form-control-lg selectclass" name="commoditytype" id="commoditytype" data-placeholder="Select Commodity Type">
                                                                <option selected disabled  value=""></option>  
                                                                <option value="Coffee">Coffee</option>
                                                                <option value="Sesame Seeds">Sesame Seeds</option>
                                                                <option value="White PeaBeans">White PeaBeans</option>
                                                                <option value="Live Animals">Live Animals</option>
                                                                <option value="Soya Beans">Soya Beans</option>
                                                                <option value="Green Mung">Green Mung</option>
                                                                <option value="Red Kidney Bean">Red Kidney Bean</option>
                                                                <option value="Pinto Bean">Pinto Bean</option>
                                                                <option value="White/Bulla Pea Beans">White/Bulla Pea Beans</option>
                                                                <option value="Sprilinked Kidney Beans">Sprilinked Kidney Beans</option>
                                                                <option value="Pigeon pea beans">Pigeon pea beans</option>
                                                            </select>
                                                            <span class="text-danger">
                                                                <strong id="commoditytype-error" class="rmerror"></strong>
                                                            </span>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-12 errorclear" id="coffeesourcediv">
                                                        <label strong style="font-size: 14px;" id="docfslabel">Commodity Source <b style="color:red;">*</b></label>
                                                        <select class="select2 form-control sr" name="coffeesource" id="coffeesource" data-placeholder="Commodity Source">
                                                                <option selected disabled  value=""></option>
                                                                <option value="Commercial">Commercial</option>
                                                                <option value="Horizontol">Horizontol</option>
                                                                <option value="ECX">ECX</option>
                                                                <option value="Grower">Grower</option>
                                                                <option value="Vertical">Vertical</option>
                                                                <option value="Union">Union</option>
                                                                <option value="Farmer">Farmer</option>
                                                                <option value="Value-Added">Value Added</option>
                                                        </select>
                                                        <span class="text-danger">
                                                            <strong id="coffeesource-error" class="rmerror"></strong>
                                                        </span>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-12 errorclear" id="coffestatusdiv">
                                                        <label strong style="font-size: 14px;" id="docfslabel">Commodity Status <b style="color:red;">*</b></label>
                                                        <select class="select2 form-control sr" name="coffestatus" id="coffestatus" data-placeholder="Commodity Status">
                                                                <option selected disabled  value=""></option>
                                                                <option value="Green Bean">Green Bean</option>
                                                                <option value="Roast and Grind">Roast and Grind</option>
                                                                <option value="Other">Other</option>
                                                        </select>
                                                        <span class="text-danger">
                                                            <strong id="coffestatus-error" class="rmerror"></strong>
                                                        </span>
                                                    </div>
                                                    <div class="col-xl-4 col-md-6 col-sm-12 mb-2 errorclear">
                                                            <label strong style="font-size: 14px;">Station <b style="color:red;">*</b></label>
                                                                <select class="select2 form-control form-control-lg selectclass" name="directwarehouse" id="directwarehouse" data-placeholder="Select station" >
                                                                    <option selected disabled  value=""></option>  
                                                                    @foreach ($stores as $key )
                                                                        <option  value="{{ $key->id }}">{{ $key->Name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            <span class="text-danger">
                                                                <strong id="directwarehouse-error" class="rmerror"></strong>
                                                            </span>
                                                    </div>
                                                    <div class="col-xl-4 col-md-6 col-sm-12 mb-2 errorclear" id="supplierduv">
                                                        <label strong style="font-size: 14px;">Supplier <b style="color:red;">*</b></label>
                                                        <select class="select2 form-control form-control-lg selectclass" name="supplier" id="supplier" data-placeholder="Select Supplier">
                                                            <option ></option>
                                                            @foreach ($customer as $key)
                                                                <option value="{{ $key->id }}">{{ $key->Name }},{{ $key->TinNumber }},{{ $key->PhoneNumber }}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger">
                                                            <strong id="supplier-error" class="rmerror"></strong>
                                                        </span>
                                                    </div>
                                            </div>
                                    </fieldset>
                                    
                                    <!-- start of item Row -->
                                    
                                </div>
                                <div class="col-xl-6 col-lg-12">
                                        <fieldset class="fset">
                                        <legend>Other Information</legend>
                                            <div class="row">
                                                
                                                <div class="col-xl-4 col-md-6 col-sm-12 mb-2" style="display: none;">
                                                    <label strong style="font-size: 14px;">continue<b style="color:red;">*</b></label>
                                                    <select class="select2 form-control form-control-lg selectclass" name="continue" id="continue" data-placeholder="select continue">
                                                        <option value="" selected disabled></option>
                                                        <option value="Confirm" >Confirm</option>
                                                        <option value="Cancel" >Cancel</option>
                                                    </select>
                                                    <span class="text-danger">
                                                        <strong id="continue-error" class="rmerror"></strong>
                                                    </span>
                                                </div>
                                                    
                                                    <div class="col-xl-4 col-md-6 col-sm-12 mb-2 errorclear">
                                                                <label strong style="font-size: 14px;">Order Date <b style="color:red;">*</b></label>
                                                                    <div class="input-group input-group-merge">
                                                                        <input type="text" name="directorderdate" id="directorderdate" class="form-control" placeholder="YYYY-MM-DD"/>
                                                                        
                                                                    </div>
                                                                    <span class="text-danger">
                                                                        <strong id="directorderdate-error" class="rmerror"></strong>
                                                                    </span>
                                                    </div>
                                                    
                                                        <div class="col-xl-4 col-md-6 col-sm-12 mb-2 errorclear">
                                                            <label strong style="font-size: 14px;">Delivery Date <b style="color:red;">*</b></label>
                                                                <div class="input-group input-group-merge">
                                                                    <input type="text"  name="directdeliverydate" id="directdeliverydate" class="form-control dr" placeholder="YYYY-MM-DD"/>
                                                                </div>
                                                                <span class="text-danger">
                                                                    <strong id="directdeliverydate-error" class="rmerror"></strong>
                                                                </span>
                                                        </div>
                                                        
                                                        <div class="col-xl-4 col-md-6 col-sm-12 mb-2 errorclear">
                                                                <label strong style="font-size: 14px;">Payment Term <b style="color:red;">*</b></label>
                                                                    <select class="select2 form-control form-control-lg selectclass" name="directpaymenterm" id="directpaymenterm" data-placeholder="Select Payment Term" >
                                                                        <option selected disabled  value=""></option>  
                                                                        <option  value="After Delivery">After Delivery</option>
                                                                        <option  value="Next 7 days"> Next 7 days</option>
                                                                        <option  value="Next 15 days"> Next 15 days</option>
                                                                        <option  value="Next 30 days"> Next 30 days</option>
                                                                    </select>
                                                                <span class="text-danger">
                                                                    <strong id="directpaymenterm-error" class="rmerror"></strong>
                                                                </span>
                                                        </div>
                                                <div class="col-xl-6 col-md-6 col-sm-12 mb-2 errorclear">
                                                    <label strong style="font-size: 14px;">Memo</label>
                                                    <div class="input-group input-group-merge">
                                                        <textarea  class="form-control" id="memo" placeholder="Write memo here" name="memo" ></textarea>
                                                    </div>
                                                    <span class="text-danger">
                                                        <strong id="memo-error"></strong>
                                                    </span>
                                                </div>
                                                <div class="col-xl-3 col-lg-12" style="display:none;">
                                                    <label strong style="font-size: 14px;" id="docfslabel">Commodity <b style="color:red;">*</b></label>
                                                    <select class="select2 form-control" name="hiddencommudity" id="hiddencommudity">
                                                        <option selected disabled  value=""></option>
                                                        @foreach ($woreda as $key)
                                                        <option title="{{$key->id}}" value="{{$key->id}}">{{$key->Rgn_Name}}, {{$key->Zone_Name}}, {{$key->Woreda_Name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-xl-3 col-lg-12" style="display: none;">
                                                    <label strong style="font-size: 14px;" id="docfslabel">Item <b style="color:red;">*</b></label>
                                                    <select class="select2 form-control" name="hiddenitem" id="hiddenitem">
                                                            <option selected disabled  value=""></option>
                                                                @foreach ($item as $key)
                                                                <option title="{{$key->Type}}" value="{{$key->id}}">{{$key->Code}}  ,  {{$key->Name}} ,   {{$key->SKUNumber}} </option>
                                                                @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-xl-4 col-md-6 col-sm-12 mb-2" style="display: none;">
                                                    <label strong style="font-size: 14px;">UOM<b style="color:red;">*</b></label>
                                                    <select class="select2 form-control form-control-lg selectclass" name="uom" id="uom" data-placeholder="select uom">
                                                        <option value="" selected disabled></option>
                                                        @foreach ($uom as $key)
                                                            <option value="{{ $key->id }}" bagwieght={{ $key->bagweight }} title="{{ $key->uomamount }}">{{ $key->Name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="text-danger">
                                                        <strong id="uom-error" class="rmerror"></strong>
                                                    </span>
                                                </div>
                                                <div class="col-xl-3 col-lg-12" style="display: none;">
                                                    <label strong style="font-size: 14px;" id="docfslabel">UOM <b style="color:red;">*</b></label>
                                                    <select class="select2 form-control" name="hiddenuom" id="hiddenuom">
                                                            <option selected disabled  value=""></option>
                                                                @foreach ($uom as $key)
                                                                <option title="{{$key->Name}}" value="{{$key->id}}">{{$key->Name}} </option>
                                                                @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-xl-3 col-lg-12" style="display:none;">
                                                    <label strong style="font-size: 14px;" id="docfslabel">Preparation</label>
                                                    <select class="select2 form-control" name="coffeeproccesstype" id="coffeeproccesstype" data-placeholder="Proccess type">
                                                            <option selected disabled  value=""></option>
                                                            
                                                            @foreach ($proccesstype as $key )
                                                                <option  value="{{ $key->ProcessTypeValue }}">{{ $key->ProcessType }}</option>
                                                            @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-xl-3 col-lg-12" id="cropYeardiv" style="display: none;">
                                                    <label strong style="font-size: 14px;" id="docfslabel">Crop Year<b style="color:red;">*</b></label>
                                                    <select class="select2 form-control sr" name="cropYear" id="cropYear" data-placeholder="crop year">
                                                            <option selected disabled  value=""></option>
                                                            @foreach ($cropyear as $key )
                                                                <option  value="{{ $key->CropYear }}">{{ $key->CropYear }}</option>
                                                            @endforeach
                                                    </select>
                                                    <span class="text-danger">
                                                        <strong id="year-error" class="rmerror"></strong>
                                                    </span>
                                                </div>
                                                <div class="col-xl-3 col-lg-12" style="display:none;">
                                                    <label strong style="font-size: 14px;" id="docfslabel">Coffee Grade </label>
                                                    <select class="select2 form-control" name="coffeegrade" id="coffeegrade" data-placeholder="coffee type">
                                                            <option selected disabled  value=""></option>
                                                                @foreach ($grade as $key )
                                                                    <option  value="{{ $key->GradeValue }}">{{ $key->Grade }}</option>
                                                                @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-xl-3 col-lg-12" style="display:none;">
                                                    <label strong style="font-size: 14px;" id="docfslabel">PE Commodity </label>
                                                    <select class="select2 form-control" name="pecommodity" id="pecommodity" data-placeholder="Commodity">
                                                        
                                                    </select>
                                                </div>
                                            </div>
                                        </fieldset>
                                </div>
                            </div>
                                <div class="row" id="itemrow">
                                        <div class="col-xl-12 col-lg-12" id="productdiv">
                                            <div class="divider divider-info">
                                                    <div class="divider-text" id="dividertext">Commodity</div>
                                                </div>
                                            <div style="width:98%; margin-left:1%;">
                                                <div class="table-responsive scroll scrdiv">
                                                    <div id="itemsdatablediv" class="scroll scrdiv">
                                                        <table id="itemsdocInfoItem" class="display table-bordered table-striped table-hover dt-responsive mb-0">
                                                            <thead>
                                                                <th>#</th>
                                                                <th>Code</th>
                                                                <th>Name</th>
                                                                <th>SKU#</th>
                                                                <th>Qty</th>
                                                                <th>Price</th>
                                                                <th>Total</th>
                                                                <th>Remark</th>
                                                            </thead>
                                                        <tbody></tbody>
                                                        <tfoot>
                                                        
                                                        </tfoot>
                                                        </table>
                                                    </div>
                                                    <div id="commuditylistdatablediv" class="scroll scrdiv">
                                                        <table id="comuditydocaddItem" class="display table-bordered table-striped table-hover dt-responsive mb-0">
                                                            <thead>
                                                                <th>#</th>
                                                                <th>supplier ID</th>
                                                                <th>Suppliers ss </th>
                                                                <th>Submit Date</th>
                                                                <th>Commodity</th>
                                                                <th>Crop Year</th>
                                                                <th>Unit Price</th>
                                                                <th>Rank</th>
                                                                <th>dense_rank</th>
                                                                <th>Row Rank</th>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <table id="directdynamicTablecommdity" class="rtable mb-1" width="100%">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Commodity</th>
                                                                    <th>Crop year</th>
                                                                    <th>Preparation</th>
                                                                    <th>Grade</th>
                                                                    <th>UOM/Bag</th>
                                                                    <th>No of Bag</th>
                                                                    <th>Bag Weight Kg</th>
                                                                    <th>Total Kg</th>
                                                                    <th>Net Kg</th>
                                                                    <th>TON</th>
                                                                    <th>Feresula</th>
                                                                    <th>Unit Price</th>
                                                                    <th>Total</th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody></tbody>
                                                            <tfoot>
                                                            <tr>
                                                                <th class="tdcolspan" id="tdcolspan" colspan="3" style="text-align:left;background-color: #FFFFFF;border:none;padding:0px;">
                                                                    <button type="button" name="adds" id="adds" class="btn btn-success btn-sm"><i data-feather='plus'></i>Add</button>
                                                                </th>
                                                                <th colspan="3" style="text-align: right;">Total</th>
                                                                <th id="nofbagtotal"></th>
                                                                <th id="bagweighttotal"></th>
                                                                <th id="kgtotal"></th>
                                                                <th id="netkgtotal"></th>
                                                                <th id="tontotal"></th>
                                                                <th id="priceferesula"></th>
                                                                <th id="pricetotal"></th>
                                                                <th id="totalpricetotal"></th>
                                                                <th></th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                    <table id="goodsdynamictables" class="rtable mb-1" width="100%">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Item Name</th>
                                                                    <th>UOM</th>
                                                                    <th>Qty</th>
                                                                    <th>Unit Price</th>    
                                                                    <th>Total Price</th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody></tbody>
                                                            <tfoot>
                                                            <tr>
                                                                <th colspan="2" style="text-align:left;background-color: #FFFFFF;border:none;padding:0px;">
                                                                    <button type="button" name="goodadds" id="goodadds" class="btn btn-success btn-sm"><i data-feather='plus'></i>Add</button>
                                                                </th>
                                                                <th colspan="1" style="text-align: right;">Total</th>
                                                                <th id="qtytotal"></th>
                                                                <th id="unitpricetotal"></th>
                                                                <th id="goodpricetotal"></th>
                                                                <th></th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end of Item Row -->
                                    <div class="row">
                                            <div class="col-xl-9 col-lg-12">
                                            </div>
                                            <div class="col-xl-3 col-lg-12">
                                                <table style="width:100%;" id="directpricetable" class="rtable">
                                                    
                                                    <tr>
                                                        <td style="text-align: right; width:50%;"><label strong style="font-size: 16px;">Sub Total</label></td>
                                                        <td style="text-align: center; width:50%;"><label id="directsubtotalLbl" class="lbl" strong style="font-size: 16px; font-weight: bold;"></label></td>
                                                    </tr>
                                                    <tr id="directtaxtr" style="display: visible;">
                                                        <td style="text-align: right;"><label strong style="font-size: 16px;">Tax(15%)</label></td>
                                                        <td style="text-align: center;"><label id="directtaxLbl" strong style="font-size: 16px; font-weight: bold;" class="lbl"></label></td>
                                                        
                                                    </tr>
                                                    <tr id="directgrandtotaltr" style="display: visible;">
                                                        <td style="text-align: right;"><label strong style="font-size: 16px;">Grand Total</label></td>
                                                        <td style="text-align: center;"><label id="directgrandtotalLbl" strong style="font-size: 16px; font-weight: bold;" class="lbl"></label></td>
                                                        
                                                    </tr>
                                                    <tr id="directwitholdingTr" style="display: visible;">
                                                        <td style="text-align: right;"><label id="directwithodingTitleLbl" strong style="font-size: 16px;">Withold(2%)</label></td>
                                                        <td style="text-align: center;">
                                                            <label id="directwitholdingAmntLbl" class="formattedNum lbl" strong style="font-size: 16px; font-weight: bold;"></label>
                                                        </td>
                                                    </tr>
                                                    <tr id="directvatTr" style="display: visible;">
                                                        <td style="text-align: right;"><label id="vatTitleLbl" strong style="font-size: 16px;">Vat</label></td>
                                                        <td style="text-align: center;">
                                                            <label id="vatAmntLbl" class="formattedNum lbl" strong style="font-size: 16px; font-weight: bold;"></label>
                                                        </td>
                                                    </tr>
                                                    <tr id="directnetpayTr" style="display: visible;">
                                                        <td style="text-align: right;"><label strong style="font-size: 16px;">Net Pay</label></td>
                                                        <td style="text-align: center;">
                                                            <label id="directnetpayLbl" class="formattedNum lbl" strong style="font-size: 16px; font-weight: bold;"></label>
                                                            
                                                        </td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td style="text-align: right;"><label strong style="font-size: 16px;">No. of Items</label></td>
                                                        <td style="text-align: center;"><label id="directnumberofItemsLbl" strong style="font-size: 16px; font-weight: bold;">0</label></td>
                                                    
                                                    </tr>
                                                    <tr id="hidewitholdTr">
                                                        <td colspan="3" style="text-align: center;">
                                                            <div class="demo-inline-spacing">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="directcustomCheck1" />
                                                                    <label class="custom-control-label" for="directcustomCheck1">Taxable</label>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                        </div>
                                    </div>
                        </div>  
                        <input type="hidden" placeholder="porderid" class="form-control" name="porderid" id="porderid" readonly/> 
                        <input type="hidden" placeholder="documentnumber" class="form-control" name="documentnumber" id="documentnumber" readonly/> 
                        <input type="hidden" placeholder="sub total" class="form-control" name="directsubtotali" id="directsubtotali" readonly/>
                        <input type="hidden" placeholder="tax" class="form-control" name="directtaxi" id="directtaxi" readonly/>
                        <input type="hidden" placeholder="grand Total" class="form-control" name="directgrandtotali" id="directgrandtotali" readonly/>
                        <input type="hidden" placeholder="withold" class="form-control" name="directwitholdingAmntin" id="directwitholdingAmntin" readonly/>
                        <input type="hidden" placeholder="Vat" class="form-control" name="directvatAmntin" id="directvatAmntin" readonly/>
                        <input type="hidden" placeholder="net pay" class="form-control" name="directnetpayin" id="directnetpayin" readonly/>
                        <input type="hidden" placeholder="is taxable" class="form-control" name="directistaxable" id="directistaxable" readonly/>
                        
                    </form>
                </div>
            <div class="modal-footer">
                @can('PE-Add')
                    <button id="savebutton" type="button" class="btn btn-outline-dark"><i id="savedicon" class="fa-sharp fa-solid fa-floppy-disk"></i> <span>Save</span></button>
                @endcan
                <button id="closebutton" type="button"  class="btn btn-outline-danger" data-dismiss="modal"><i class="fa-regular fa-xmark"></i> Close</button>
            </div>
        </div>
        </div>
    </div>
    <div class="modal fade" id="docInfoModal" tabindex="-1" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" data-backdrop="static" style="display: none;">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalScrollableTitle">Purchase Order Information</h5>
                <div class="row">
                    <div style="text-align: right;" id="infoStatus"></div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="refreshmaintables();">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
            </div>
            <div class="modal-body scroll scrdiv">
                <form id="holdInfo">
                @csrf
                <div class="col-xl-12" id="docinfo-block">
                    <div class="card collapse-icon">
                            <div class="collapse-default" id="accordionExample">
                                <div class="card">
                                    <div class="card-header" id="headingOne" data-toggle="collapse" role="button" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                        <span class="lead collapse-title">Purchase order Details</span>
                                        <span id="" style="font-size:16px;"></span>
                                    </div>
                                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-xl-3 col-lg-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h6 class="card-title">Puchase order information</h6>
                                                        </div>
                                                        <div class="card-body">
                                                            <table class="table-responsive">
                                                                <tr>
                                                                    <td><label strong style="font-size: 12px;">Reference: </label></td>
                                                                    <td><b><label id="inforefernce" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                <tr class="infopetr">
                                                                    <td><label strong style="font-size: 12px;">Reference#: </label></td>
                                                                    <td><b><label id="infope" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label strong style="font-size: 12px;">Purchase Order No: </label></td>
                                                                    <td><b><label id="infopo" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label strong style="font-size: 12px;">Purchase Order Type: </label></td>
                                                                    <td><b><label id="infopotype" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                <tr class="cmdtyclass">
                                                                    <td><label strong style="font-size: 12px;">Commodity Type: </label></td>
                                                                    <td><b><label id="infocommoditype" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                <tr class="cmdtyclass">
                                                                    <td><label strong style="font-size: 12px;">Commodity Source: </label></td>
                                                                    <td><b><label id="infocommoditysource" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                <tr class="cmdtyclass">
                                                                    <td><label strong style="font-size: 12px;">Commodity Status: </label></td>
                                                                    <td><b><label id="infocommoditystatus" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label strong style="font-size: 12px;">Prepare Date: </label></td>
                                                                    <td><b><label id="infodocumentdate" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                <tr class="infodirect">
                                                                    <td><label strong style="font-size: 12px;">Order Date: </label></td>
                                                                    <td><b><label id="inforderdate" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                <tr class="infodirect">
                                                                    <td><label strong style="font-size: 12px;">Deliver Date: </label></td>
                                                                    <td><b><label id="infodeliverdate" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                <tr class="infodirect">
                                                                    <td><label strong style="font-size: 12px;">Station: </label></td>
                                                                    <td><b><label id="infowarehouse" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                <tr class="infodirect">
                                                                    <td><label strong style="font-size: 12px;">Payment Term: </label></td>
                                                                    <td><b><label id="infopaymenterm" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-3 col-lg-12" id="directsupplyinformationdiv" >
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h6 class="card-title">Supplier Information</h6>
                                                        </div>
                                                        <div class="card-body">
                                                            <table class="table-responsive">
                                                                <tr>
                                                                    <td><label strong style="font-size: 12px;">ID: </label></td>
                                                                    <td><b><label id="infosuppid" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label strong style="font-size: 12px;">Name: </label></td>
                                                                    <td><b><label id="infsupname" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label strong style="font-size: 12px;">TIN: </label></td>
                                                                    <td><b><label id="infosupptin" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                            
                                                            </table>
                                                            <div class="divider divider-secondary">
                                                                    <div class="divider-text"><b>Memo</b></div>
                                                            </div>

                                                                <table class="table-responsive">
                                                                    
                                                                    <tr>
                                                                        <td><label id="purchaseorderinfomemo" class="purchaseorderinfomemo" strong style="font-size: 12px;"></label></td>
                                                                    </tr>
                                                                    
                                                                </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-3 col-lg-12">
                                                </div>
                                                <div class="col-xl-6 col-lg-12" id="supplyinformationdiv" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;display:visible;">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h6 class="card-title">Evaluation Result</h6>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="scroll scrdiv" style="overflow-y:scroll;height:25rem;">
                                                                <table id="comuditydocInfoItem" class="display table-bordered table-striped table-hover dt-responsive mb-0" style="width: 100%;">
                                                                    <thead>
                                                                        <th>#</th>
                                                                            <th>Supplier ID</th>
                                                                            <th>Suppliers</th>
                                                                            <th>Submit Date</th>
                                                                            <th>Supply Region-Zone-Woreda</th>
                                                                            <th>Crop Year</th>
                                                                            <th>Price</th>
                                                                            <th>Rank</th>
                                                                            <th>dense_rank</th>
                                                                            <th>Row Rank</th>
                                                                    </thead>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                {{-- <div class="col-xl-3 col-lg-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h6 class="card-title">Action</h6>
                                                        </div>
                                                        <div class="card-body scroll scrdiv">
                                                            <ul class="timeline" id="ulist" style="height:25rem;">
                                                                
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div> --}}
                                                <div class="col-xl-3 col-lg-3" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;height:20rem">
                                                    <h5>Actions</h5>
                                                    <div class="scroll scrdiv">
                                                        <ul class="timeline" id="ulist" style="height:20rem;">
                                                                
                                                        </ul>
                                                        <ul class="timeline" id="ulistsupplier" style="height:25rem;">
                                                            
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
            <div class="divider divider-info">
                <div class="divider-text directdivider">Supplier Purchase order list</div>
            </div>
                <div class="col-xl-12 col-lg-12">
                    <div class="table-responsive">
                        <div id="itemsdatabledivinfo" class="scroll scrdiv">
                            <table id="itemsdocInfoItem" class="display table-bordered table-striped table-hover dt-responsive mb-0">
                            <thead>
                                <th>#</th>
                                <th>Customer</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th>SKU#</th>
                                <th>Description</th>
                                <th>sample Amount(QTY)</th>
                                <th>Remark</th>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                            </tfoot>
                            </table>
                        </div>
                        <div id="commuditylistdatabledivinfo" class="scroll scrdiv">
                                <div class="row">
                                    <div class="col-xl-3 col-md-3 col-sm-3">
                                            <div class="row">
                                                    <div class="col-xl-10 col-md-10 col-sm-10">
                                                        <input type="text" class="form-control" id="searchsupplier" placeholder="Search here...">
                                                    </div>
                                                    <div class="col-xl-2 col-md-2 col-sm-2">
                                                            <button type="button" class="btn btn-light btn-sm" id="clearsupplsearch"><i class="fa-sharp fa-solid fa-x"></i></button>
                                                    </div>
                                            </div>
                                            <section id="carddatacanvas" style="margin-top:2rem">
                                            </section>
                                    </div>
                                <div class="col-xl-9 col-md-9 col-sm-9">
                                        <table class="rtable" width="100%">
                                            <tr>
                                                <th>Doc #</th>
                                                <th>Prepare Date</th>
                                                <th>Order Date</th>
                                                <th>Delivery Date</th>
                                                <th>Warehouse</th>
                                                <th>Payment Term</th>
                                            </tr>
                                            <tr>
                                                <td id="infodocumentno" style="text-align: center;"></td>
                                                <td id="infopreparedate" style="text-align: center;"></td>
                                                <td id="infoorderdate" style="text-align: center;"></td>
                                                <td id="infodeliverydate" style="text-align: center;"></td>
                                                <td id="infopewarehouse" style="text-align: center;"></td>
                                                <td id="infopepaymenterm" style="text-align: center;"></td>
                                            </tr>
                                        </table>
                                    <table id="infofinancailevdynamicTablecommdity" class="rtable mb-0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Region-Zone-Woreda</th>
                                                <th>Crop year</th>
                                                <th>Preparation</th>
                                                <th>UOM</th>
                                                <th>Qty</th>
                                                <th>Total(KG)</th>
                                                <th>Feresula</th>
                                                <th>Price</th>
                                                <th>Total</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                    <div class="row">
                                        <div class="col-xl-9 col-lg-12">
                                        </div>
                                        <div class="col-xl-3 col-lg-12">
                                            <table style="width:100%;" id="supplierinfopricetable" class="rtable">
                                                <tr>
                                                    <td style="text-align: right; width:50%;"><label strong style="font-size: 16px;">Sub Total</label></td>
                                                    <td style="text-align: center; width:50%;"><label id="supplierinfosubtotalLbl" strong style="font-size: 16px; font-weight: bold;"></label></td>
                                                    
                                                </tr>
                                                <tr id="individualsupplierinfotaxtr" style="display: none;">
                                                    <td style="text-align: right;"><label strong style="font-size: 16px;">Tax(15%)</label></td>
                                                    <td style="text-align: center;"><label id="supplierinfotaxLbl" strong style="font-size: 16px; font-weight: bold;"></label></td>
                                                
                                                </tr>
                                                <tr id="individualsupplierinforandtotaltr" style="display: none;">
                                                    <td style="text-align: right;"><label strong style="font-size: 16px;">Grand Total</label></td>
                                                    <td style="text-align: center;"><label id="supplierinfograndtotalLbl" strong style="font-size: 16px; font-weight: bold;" ></label></td>
                                                    
                                                </tr>
                                                <tr id="supplierinfowitholdingTr" style="display: none;">
                                                    <td style="text-align: right;"><label id="withodingTitleLbl" strong style="font-size: 16px;">Withold(2%)</label></td>
                                                    <td style="text-align: center;">
                                                        <label id="supplierinfowitholdingAmntLbl" class="formattedNum" strong style="font-size: 16px; font-weight: bold;"></label>
                                                        
                                                    </td>
                                                </tr>
                                                <tr id="supplierinfovatTr" style="display: none;">
                                                    <td style="text-align: right;"><label id="supplierinfovatTitleLbl" strong style="font-size: 16px;">Vat</label></td>
                                                    <td style="text-align: center;">
                                                        <label id="supplierinfovatAmntLbl" class="formattedNum" strong style="font-size: 16px; font-weight: bold;"></label>
                                                        
                                                    </td>
                                                </tr>
                                                <tr id="supplierinfonetpayTr" style="display: none;">
                                                    <td style="text-align: right;"><label strong style="font-size: 16px;">Net Pay</label></td>
                                                    <td style="text-align: center;">
                                                        <label id="supplierinfonetpayLbl" class="formattedNum" strong style="font-size: 16px; font-weight: bold;" class="lbl"></label>
                                                        
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td style="text-align: right;"><label strong style="font-size: 16px;">No. of Items</label></td>
                                                    <td style="text-align: center;"><label id="supplierinfonumberofItemsLbl" strong style="font-size: 16px; font-weight: bold;">0</label></td>
                                                </tr>
                                                <tr id="supplierinfohidewitholdTr" style="display: none;">
                                                    <td colspan="3" style="text-align: center;">
                                                        <div class="demo-inline-spacing">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="supplierinfocustomCheck1" />
                                                                <label class="custom-control-label" for="supplierinfocustomCheck1">Taxable</label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div id="directcommuditylistdatabledivinfo" class="scroll scrdiv">
                            
                                <div class="directcommudityinfodatatablesdiv">
                                        <table id="directcommudityinfodatatables" class="display table-bordered table-striped table-hover dt-responsive mb-0">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Commodity</th>
                                                    <th>Grade</th>
                                                    <th>Preparation</th>
                                                    <th>Crop Year</th>
                                                    <th>UOM/Bag</th>
                                                    <th>No. of Bag</th>
                                                    <th>Bag Weight Kg</th>
                                                    <th>Total Kg</th>
                                                    <th>Net Kg</th>
                                                    <th>TON</th>
                                                    <th>Feresula</th>
                                                    <th>Unit Price</th>
                                                    <th>Total</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                    <tr>
                                                    <td class="tdcolspan" id="tdcolspan" colspan="4" style="text-align:left;background-color: #FFFFFF;border:none;padding:0px;"></td>
                                                    <th colspan="2" style="text-align: right;">Total</th>
                                                    <th id="infonofbagtotal"></th>
                                                    <th id="infobagweighttotal"></th>
                                                    <th id="infokgtotal"></th>
                                                    <th id="infonetkgtotal"></th>
                                                    <th id="infotontotal"></th>
                                                    <th id="infopriceferesula"></th>
                                                    <th id="infopricetotal"></th>
                                                    <th id="infototalpricetotal"></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                </div>
                                <div class="directgoodsinfodatatablesdiv">
                                        <table id="directgoodsinfodatatables" class="display table-bordered table-striped table-hover dt-responsive mb-0">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Item Code</th>
                                                    <th>Item Name</th>
                                                    <th>Barcode</th>
                                                    <th>UOM</th>
                                                    <th>QTY.</th>
                                                    <th>Unit Price</th>
                                                    <th>Total</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                    <tr>
                                                        <th colspan="5" style="text-align: right;">Total</th>
                                                        <th id="infoqtytotal"></th>
                                                        <th id="infounitpreicetotal"></th>
                                                        <th id="infototal"></th>
                                                        <th></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                </div> 
                            <div class="row">
                                <div class="col-xl-9 col-lg-12"></div>
                                <div class="col-xl-3 col-lg-12 mt-1">
                                    <table style="width:100%;" id="directinfopricetable" class="rtable">
                                        <tr>
                                            <td style="text-align: right; width:50%;"><label strong style="font-size: 16px;">Sub Total</label></td>
                                            <td style="text-align: center; width:50%;"><label id="directinfosubtotalLbl" strong style="font-size: 16px; font-weight: bold;"></label></td>
                                            
                                        </tr>
                                        <tr id="supplierinfotaxtr" style="display: visible;">
                                            <td style="text-align: right;"><label strong style="font-size: 16px;">Tax(15%)</label></td>
                                            <td style="text-align: center;"><label id="directinfotaxLbl" strong style="font-size: 16px; font-weight: bold;"></label></td>
                                        
                                        </tr>
                                        <tr id="supplierinforandtotaltr" style="display: visible;">
                                            <td style="text-align: right;"><label strong style="font-size: 16px;">Grand Total</label></td>
                                            <td style="text-align: center;"><label id="directinfograndtotalLbl" strong style="font-size: 16px; font-weight: bold;" ></label></td>
                                            
                                        </tr>
                                        <tr id="visibleinfowitholdingTr" style="display: visible;">
                                            <td style="text-align: right;"><label id="withodingTitleLbl" strong style="font-size: 16px;">Withold(2%)</label></td>
                                            <td style="text-align: center;">
                                                <label id="directinfowitholdingAmntLbl" class="formattedNum" strong style="font-size: 16px; font-weight: bold;"></label>
                                                
                                            </td>
                                        </tr>
                                        <tr id="directinfovatTr" style="display: none;">
                                            <td style="text-align: right;"><label id="supplierinfovatTitleLbl" strong style="font-size: 16px;">Vat</label></td>
                                            <td style="text-align: center;">
                                                <label id="directinfovatAmntLbl" class="formattedNum" strong style="font-size: 16px; font-weight: bold;"></label>
                                            
                                            </td>
                                        </tr>
                                        <tr id="directinfonetpayTr" style="display: none;">
                                            <td style="text-align: right;"><label strong style="font-size: 16px;">Net Pay</label></td>
                                            <td style="text-align: center;">
                                                <label id="directinfonetpayLbl" class="formattedNum" strong style="font-size: 16px; font-weight: bold;" class="lbl"></label>
                                                
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <td style="text-align: right;"><label strong style="font-size: 16px;">No. of Items</label></td>
                                            <td style="text-align: center;"><label id="directinfonumberofItemsLbl" strong style="font-size: 16px; font-weight: bold;">0</label></td>
                                            
                                        </tr>
                                        
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>   
            </div>
            <div class="modal-footer">
                    <div class="col-xl-12 col-lg-12" id="directfooter">
                            <div class="row">
                                        <input type="hidden" placeholder="" class="form-control" name="recordIds" id="recordIds" readonly="true"/>
                                        <input type="hidden" placeholder="" class="form-control" name="evelautestatus" id="evelautestatus" readonly="true"/>
                                    <div class="col-xl-6 col-lg-12">
                                        @can('PE-Edit')
                                            <button type="button" id="poeditbutton" class="btn btn-outline-dark"><i class="fa-sharp fa-solid fa-pen"></i> Edit</button>
                                        @endcan
                                        @can('PE-Void')
                                            <button type="button" id="povoidbuttoninfo" class="btn btn-outline-dark"><i class="fa-solid fa-trash-xmark"></i> Void</button>
                                            <button type="button" id="poundovoidbuttoninfo" class="btn btn-outline-dark"><i class="fa-solid fa-trash-undo"></i> Undo Void</button>
                                        @endcan
                                        @can('PE-Reject')
                                            <button type="button" id="poundorejectbuttoninfo" class="btn btn-outline-dark"><i class="fa-solid fa-trash-undo"></i> Undo Reject</button>
                                            <button type="button" id="porejectbuttoninfo" class="btn btn-outline-dark"><i class="fa-solid fa-trash-xmark"></i> Reject</button>
                                        @endcan
                                        <button type="button" id="poprintbutton" class="btn btn-outline-dark"><i data-feather="printer" class="mr-25"></i>Print</button>
                                    </div>        
                                    <div class="col-xl-6 col-lg-12" style="text-align:right;">
                                        @can('PO-Pending')
                                            <button type="button" id="pobacktodraft" class="btn btn-outline-dark"><i class="fa-solid fa-badge-check"></i>Back To Draft</button>
                                            <button type="button" id="popending" class="btn btn-outline-dark"><i class="fa-solid fa-badge-check"></i>Chage To Pending</button>
                                        @endcan
                                        @can('PO-Verify')
                                            <button type="button" id="pobacktopending" class="btn btn-outline-dark"><i class="fa-solid fa-badge-check"></i>Back To Pending</button>
                                            <button type="button" id="poverify" class="btn btn-outline-dark"><i class="fa-solid fa-badge-check"></i>Verify</button>
                                        @endcan
                                        @can('PO-Review')
                                            <button type="button" id="undoporeview" class="btn btn-outline-dark"><i class="fa-solid fa-badge-check"></i>Undo Review</button>
                                            <button type="button" id="poreview" class="btn btn-outline-dark"><i class="fa-solid fa-badge-check"></i>Review</button>
                                        @endcan
                                        @can('PO-Approve')
                                            <button type="button" id="poapproved" class="btn btn-outline-dark"><i class="fa-solid fa-badge-check"></i>Approve</button>
                                        @endcan
                                        <button id="closebutton" type="button" class="btn btn-outline-danger" data-dismiss="modal" onclick="refreshmaintables();"><i class="fa-regular fa-xmark"></i> Close</button>
                                    </div> 
                                </div>
                    </div>
                    <div class="col-xl-12 col-lg-12" id="pefooter">
                            <div class="row">
                                        <input type="hidden" placeholder="" class="form-control" name="supplierrecordIds" id="supplierrecordIds" readonly="true"/>
                                        <input type="hidden" placeholder="" class="form-control" name="supplierevelautestatus" id="supplierevelautestatus" readonly="true"/>
                                        <input type="hidden" placeholder="" class="form-control" name="suppliername" id="suppliername" readonly="true"/>
                                        <input type="hidden" placeholder="" class="form-control" name="storehidden" id="storehidden" readonly="true"/>
                                    <div class="col-xl-6 col-lg-12">
                                            <button style="display: none;" type="button" id="poaddorderbutton" class="btn btn-outline-dark"><i class="fa-sharp fa-solid fa-plus"></i> Add</button>
                                            <button type="button" id="supplierpoverifypoeditbutton" class="btn btn-outline-dark"><i id="iconsupplierpoverifypoeditbutton" class="fa-sharp fa-solid fa-pen"></i> <span></span></button>
                                            <button type="button" id="supplierpoverifypovoidbuttoninfo" class="btn btn-outline-dark"><i class="fa-solid fa-trash-xmark"></i> Void</button>
                                            <button type="button" id="supplierpoundovoidbuttoninfo" class="btn btn-outline-dark"><i class="fa-solid fa-trash-undo"></i> Undo Void</button>
                                            <button type="button" id="supplierpoprintbutton" class="btn btn-outline-dark"><i data-feather="printer" class="mr-25"></i>Print</button>
                                    </div>        
                                    <div class="col-xl-6 col-lg-12" style="text-align:right;">
                                        <button type="button" id="supplierbacktopending" class="btn btn-outline-dark"><i class="fa-solid fa-badge-check"></i>Back To Pending </button>
                                        <button type="button" id="supplierbacktoverify" class="btn btn-outline-dark"><i class="fa-solid fa-badge-check"></i>Back To Verify </button>
                                        <button type="button" id="supplierpoverifypopending" class="btn btn-outline-dark"><i class="fa-solid fa-badge-check"></i>Pending</button>
                                        <button type="button" id="supplierpoverify" class="btn btn-outline-dark"><i class="fa-solid fa-badge-check"></i> Verify</button>
                                        <button type="button" id="supplierpoverifypoapproved" class="btn btn-outline-dark"><i class="fa-solid fa-badge-check"></i>Approved</button>
                                        <button type="button" id="supplierbacktodraft" class="btn btn-outline-dark"><i class="fa-solid fa-badge-check"></i>Back To Draft </button>
                                        <button id="closebutton" type="button" class="btn btn-outline-danger" data-dismiss="modal"><i class="fa-regular fa-xmark"></i> Close</button>
                                    </div> 
                                </div>
                </div>
            </div>
        </div>
        </div>
    </div> 

    <div class="modal modal-slide-in event-sidebar fade" id="informationordermodals" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y:scroll;">
            <div class="modal-dialog modal-dialog-scrollable sidebar-xl" style="width: 98%;">
                <div class="modal-content p-0">

                    <div class="modal-header mb-1">
                        <h5 class="modal-title">Orders information</h5>
                        <div class="row">
                            <div style="text-align: right;" id="supplierinfoStatus"></div>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                        </div>
                    </div>
                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12">
                                <div style="width:98%; margin-left:1%;">
                                    <div class="table-responsive scroll scrdiv">
                                        <fieldset class="fset"><legend id="infolegendid"> </legend>
                                                <div class="row">
                                                    <div class="col-xl-12 col-lg-12">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-xl-3 col-lg-3" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;height:20rem">
                                                                        
                                                                        <table class="table-responsive">
                                                                            <tr> 
                                                                                <td colspan="2"><b>Purchase Order Information</b></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><label strong style="font-size: 12px;">Reference: </label></td>
                                                                                <td><b><label id="infosupprefernce" strong style="font-size: 12px;"></label></b></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><label strong style="font-size: 12px;">PE#: </label></td>
                                                                                <td><b><label id="infosupppe" strong style="font-size: 12px;"></label></b></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><label strong style="font-size: 12px;">Purchase Order No: </label></td>
                                                                                <td><b><label id="infosupppo" strong style="font-size: 12px;"></label></b></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><label strong style="font-size: 12px;">Prepare Date: </label></td>
                                                                                <td><b><label id="infosuppdocumentdate" strong style="font-size: 12px;"></label></b></td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>
                                                                    <div class="col-xl-3 col-lg-3" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;height:20rem">
                                                                        <table class="table-responsive">
                                                                            <tr> 
                                                                                <td colspan="2"><b>Supplier Information</b></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><label strong style="font-size: 12px;">ID: </label></td>
                                                                                <td><b><label id="infosupplierid" strong style="font-size: 12px;"></label></b></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><label strong style="font-size: 12px;">Name: </label></td>
                                                                                <td><b><label id="infosuppliername" strong style="font-size: 12px;"></label></b></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><label strong style="font-size: 12px;">TIN#: </label></td>
                                                                                <td><b><label id="infosuppliertin" strong style="font-size: 12px;"></label></b></td>
                                                                            </tr>
                                                                            
                                                                        </table>
                                                                    </div>
                                                                    <div class="col-xl-3 col-lg-3" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;height:20rem">
                                                                        <table id="allpurchaseordertables" class="table rtable mb-0" width="100%">
                                                                            <thead>
                                                                                <tr> 
                                                                                <th colspan="2"><b>PO History</b></th>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th>#</th>
                                                                                    <th>PO#</th>
                                                                                </tr>
                                                                                </thead>
                                                                            </table>
                                                                    </div>
                                                                    <div class="col-xl-3 col-lg-3" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;height:20rem">
                                                                        <h5>Actions</h5>
                                                                        <div class="scroll scrdiv">
                                                                            <ul class="timeline" id="ulistsupplierss" style="height:19rem;">
                                                                                
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                <div class="col-xl-12 col-lg-12">
                                                        <table id="infofinancailevdynamicTable" class="table rtable mb-0" width="100%">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th class="infofinancailevreqtables">Request Item</th>
                                                                    <th>Name</th>
                                                                    <th>Description</th>
                                                                    <th>Financail Approval</th>
                                                                    <th>Customer price</th>
                                                                    <th>Proposed Price</th>
                                                                    <th>Final Uprice</th>
                                                                    <th></th>
                                                                </tr>
                                                                </thead>
                                                                <tbody></tbody>
                                                            </table>
                                                </div>
                                            </div>
                                    </fieldset>
                                    </div>
                                </div>
                            </div>
                            
                    </div>
                    </div>
                    <div class="modal-footer">
                        
                    </div>
                </div>
            </div>
        </div>

    <div class="modal modal-slide-in event-sidebar fade" id="giveordermodals" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y:scroll;">
            <div class="modal-dialog modal-dialog-scrollable sidebar-xl" style="width: 70%;">
                <div class="modal-content p-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                    <div class="modal-header mb-1">
                        <h5 class="modal-title">Orders</h5>
                    </div>
                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12">
                                <div style="width:98%; margin-left:1%;">
                                    <div class="table-responsive scroll scrdiv">
                                        <fieldset class="fset"><legend id="legendid"> </legend>
                                            <form id="posupplieradd" >
                                                {{ csrf_field() }}
                                            <div class="row">
                                                    <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                                        <label strong style="font-size: 14px;">Prepare Date <b style="color:red;">*</b></label>
                                                            <div class="input-group input-group-merge">
                                                                <input type="text"  name="preparedate" id="preparedate" class="form-control flatpickr-basic dr" placeholder="YYYY-MM-DD"/>
                                                            </div>
                                                            <span class="text-danger">
                                                                <strong id="preparedate-error" class="rmerror"></strong>
                                                            </span>
                                                    </div> 
                                                    <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                                        <label strong style="font-size: 14px;">Order Date <b style="color:red;">*</b></label>
                                                            <div class="input-group input-group-merge">
                                                                <input type="text"  name="orderdate" id="orderdate" class="form-control flatpickr-basic dr" placeholder="YYYY-MM-DD"/>
                                                            </div>
                                                            <span class="text-danger">
                                                                <strong id="orderdate-error" class="rmerror"></strong>
                                                            </span>
                                                    </div>
                                                    <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                                        <label strong style="font-size: 14px;">Delivery Date <b style="color:red;">*</b></label>
                                                            <div class="input-group input-group-merge">
                                                                <input type="text"  name="deliverydate" id="deliverydate" class="form-control flatpickr-basic dr" placeholder="YYYY-MM-DD"/>
                                                            </div>
                                                            <span class="text-danger">
                                                                <strong id="deliverydate-error" class="rmerror"></strong>
                                                            </span>
                                                    </div>
                                                <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                                        <label strong style="font-size: 14px;">Warehouse <b style="color:red;">*</b></label>
                                                            <select class="select2 form-control form-control-lg sr" name="warehouse" id="warehouse" data-placeholder="Select station" >
                                                                <option selected disabled  value=""></option>  
                                                                @foreach ($stores as $key )
                                                                    <option  value="{{ $key->id }}">{{ $key->Name }}</option>
                                                                @endforeach
                                                            </select>
                                                        <span class="text-danger">
                                                            <strong id="warehouse-error" class="rmerror"></strong>
                                                        </span>
                                                </div>

                                                <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                                        <label strong style="font-size: 14px;">Payment Term <b style="color:red;">*</b></label>
                                                            <select class="select2 form-control form-control-lg sr" name="paymenterm" id="paymenterm" data-placeholder="Select paymenterm" >
                                                                <option selected disabled  value=""></option>  
                                                                <option  value="Next 7 days"> Next 7 days</option>
                                                                <option  value="Next 15 days"> Next 15 days</option>
                                                                <option  value="Next 30 days"> Next 30 days</option>
                                                            </select>
                                                        <span class="text-danger">
                                                            <strong id="paymenterm-error" class="rmerror"></strong>
                                                        </span>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-xl-12 col-lg-12">
                                                        <table id="financailevdynamicTable" class="table rtable mb-0" width="100%">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th class="financailevreqtables">Request Item</th>
                                                                    <th>Name</th>
                                                                    <th>Description</th>
                                                                    <th>Financail Approval</th>
                                                                    <th>Customer price</th>
                                                                    <th>Proposed Price</th>
                                                                    <th>Final Uprice</th>
                                                                    <th></th>
                                                                </tr>
                                                                </thead>
                                                                <tbody></tbody>
                                                            </table>
                                                        <table id="financailevdynamicTablecommdity" class="rtable mb-0" width="100%">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Commodity</th>
                                                                    <th>Crop year</th>
                                                                    <th>Preparation</th>
                                                                    <th>Grade</th>
                                                                    <th>UOM</th>
                                                                    <th>Qty</th>
                                                                    <th>KG</th>
                                                                    <th>Ton</th>
                                                                    <th>Feresula</th>
                                                                    <th>Price</th>
                                                                    <th>Total</th>
                                                                    <th>Status</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody></tbody>
                                                    </table>
                                                    <table>
                                                        <tr>
                                                            <td><button type="button" name="supplieradds" id="supplieradds" class="btn btn-success btn-sm"><i data-feather='plus'></i>Add</button></td>
                                                        </tr>
                                                    </table>
                                                    <div class="row">
                                                        <div class="col-xl-9 col-lg-12">
                                                        </div>
                                                        <div class="col-xl-3 col-lg-12">
                                                            <table style="width:100%;" id="pricetable" class="rtable">
                                                                <tr>
                                                                    <td style="text-align: right; width:50%;"><label strong style="font-size: 16px;">Sub Total</label></td>
                                                                    <td style="text-align: center; width:50%;"><label id="subtotalLbl" class="lbl" strong style="font-size: 16px; font-weight: bold;"></label></td>
                                                                    
                                                                </tr>
                                                                <tr id="taxtr" style="display: none;">
                                                                    <td style="text-align: right;"><label strong style="font-size: 16px;">Tax(15%)</label></td>
                                                                    <td style="text-align: center;"><label id="taxLbl" strong style="font-size: 16px; font-weight: bold;" class="lbl"></label></td>
                                                                    
                                                                </tr>
                                                                <tr id="grandtotaltr" style="display: none;">
                                                                    <td style="text-align: right;"><label strong style="font-size: 16px;">Grand Total</label></td>
                                                                    <td style="text-align: center;"><label id="grandtotalLbl" strong style="font-size: 16px; font-weight: bold;" class="lbl"></label></td>
                                                                    
                                                                </tr>
                                                                <tr id="witholdingTr" style="display: none;">
                                                                    <td style="text-align: right;"><label id="withodingTitleLbl" strong style="font-size: 16px;">Withold(2%)</label></td>
                                                                    <td style="text-align: center;">
                                                                        <label id="witholdingAmntLbl" class="formattedNum lbl" strong style="font-size: 16px; font-weight: bold;"></label>
                                                                        
                                                                    </td>
                                                                </tr>
                                                                <tr id="vatTr" style="display: none;">
                                                                    <td style="text-align: right;"><label id="vatTitleLbl" strong style="font-size: 16px;">Vat</label></td>
                                                                    <td style="text-align: center;">
                                                                        <label id="vatAmntLbl" class="formattedNum lbl" strong style="font-size: 16px; font-weight: bold;"></label>
                                                                        
                                                                    </td>
                                                                </tr>
                                                                <tr id="netpayTr" style="display: none;">
                                                                    <td style="text-align: right;"><label strong style="font-size: 16px;">Net Pay</label></td>
                                                                    <td style="text-align: center;">
                                                                        <label id="netpayLbl" class="formattedNum lbl" strong style="font-size: 16px; font-weight: bold;"></label>
                                                                    
                                                                    </td>
                                                                </tr>
                                                                
                                                                <tr>
                                                                    <td style="text-align: right;"><label strong style="font-size: 16px;">No. of Items</label></td>
                                                                    <td style="text-align: center;"><label id="numberofItemsLbl" strong style="font-size: 16px; font-weight: bold;">0</label></td>
                                                                    
                                                                </tr>
                                                                <tr id="hidewitholdTr">
                                                                    <td colspan="3" style="text-align: center;">
                                                                        <div class="demo-inline-spacing">
                                                                            <div class="custom-control custom-checkbox">
                                                                                <input type="checkbox" class="custom-control-input" id="customCheck1" />
                                                                                <label class="custom-control-label" for="customCheck1">Taxable</label>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                    </div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            
                                            <input type="hidden" class="form-control" name="poid" id="poid" readonly />
                                            <input type="hidden" class="form-control" name="posupplierid" id="posupplierid" readonly />
                                            <input type="hidden" class="form-control" name="iswhere" id="iswhere" readonly />
                                            <input type="hidden" class="form-control" name="type"  id="potype" value="Commodity" readonly />
                                            <input type="hidden" placeholder="" class="form-control" name="subtotali" id="subtotali" readonly="true" value="0"/>
                                            <input type="hidden" placeholder="" class="form-control" name="taxi" id="taxi" readonly="true" value="0"/>
                                            <input type="hidden" placeholder="" class="form-control" name="grandtotali" id="grandtotali" readonly="true" value="0"/>
                                            <input type="hidden" placeholder="" class="form-control" name="witholdingAmntin" id="witholdingAmntin" readonly="true" value="0"/>
                                            <input type="hidden" placeholder="" class="form-control" name="vatAmntin" id="vatAmntin" readonly="true" value="0"/>
                                            <input type="hidden" placeholder="" class="form-control" name="netpayin" id="netpayin" readonly="true" value="0"/>
                                            <input type="hidden" placeholder="" class="form-control" name="istaxable" id="istaxable" readonly="true" value="0"/>
                                        </form>
                                    </fieldset>
                                    
                                    </div>
                                </div>
                            </div>
                            
                    </div>
                    </div>
                    <div class="modal-footer">
                        <button id="posuppliersavebutton" type="button" class="btn btn-outline-dark"><i id="posuppliersavedicon" class="fa-sharp fa-solid fa-floppy-disk"></i><span>Save</span></button>
                        <button type="button"  class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade text-left" id="pocancelmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="purchasevoidform" >
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="hidden" placeholder="" class="form-control" name="cancelstatus" id="cancelstatus" readonly>
                                <input type="hidden" placeholder="" class="form-control" name="elementid" id="elementid" readonly>
                                <input type="hidden" placeholder="" class="form-control" name="voidtype" id="voidtype" readonly>
                            </div>
                        </div>
                        <div class="col-xl-12 col-md-6 col-sm-12 mb-2">
                                        <textarea  class="form-control" id="cancelreason" placeholder="Write Reason here" name="cancelreason" onkeyup="clearvoiderror();"></textarea>
                                        <span class="text-danger">
                                            <strong id="cancelreason-error"></strong>
                                        </span>
                                </div>
                        <div class="modal-footer">
                            <button id="pocancelledbutton" type="button" class="btn btn-outline-dark"><i class="fa-solid fa-trash"></i> <span>Cancel</span></button>
                            <button id="reasonclosebutton" type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
    </div>
    <!-- start of void modals  -->
    <div class="modal fade text-left" id="povoidmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="povoidform" >
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" placeholder="" class="form-control" name="povoidid" id="povoidid" readonly="true">
                            <input type="hidden" placeholder="" class="form-control" name="voidtype" id="povoidtype" readonly="true">
                        </div>
                    </div>
                    <div class="col-xl-12 col-md-6 col-sm-12 mb-2">
                                    <textarea  class="form-control" id="voidreason" placeholder="Write Reason here" name="Reason" onkeyup="clearvoiderror();"></textarea>
                                    <span class="text-danger">
                                        <strong id="voidreason-error"></strong>
                                    </span>
                            </div>
                    <div class="modal-footer">
                        <button id="povoidbutton" type="button" class="btn btn-outline-dark"><i class="fa-solid fa-trash"></i> <span>Void</span></button>
                        <button id="closebutton" type="button" class="btn btn-outline-danger" data-dismiss="modal" onclick="clearvoiderror();"><i class="fa-regular fa-xmark"></i> Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end of void modals  -->
    <!-- start of void modals  -->
    <div class="modal fade text-left" id="supplierpovoidmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="supplierpovoidform" >
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" placeholder="" class="form-control" name="supplierpovoidid" id="supplierpovoidid" readonly="true">
                            <input type="hidden" placeholder="" class="form-control" name="supplierdetailsid" id="supplierdetailsid" readonly="true">
                            <input type="hidden" placeholder="" class="form-control" name="suppliervoidtype" id="supplierpovoidtype" readonly="true">
                        </div>
                    </div>
                    <div class="col-xl-12 col-md-6 col-sm-12 mb-2">
                                    <textarea  class="form-control" id="suppliervoidreason" placeholder="Write Reason here" name="Reason" onkeyup="clearvoiderror();"></textarea>
                                    <span class="text-danger">
                                        <strong id="suppliervoidreason-error"></strong>
                                    </span>
                            </div>
                    <div class="modal-footer">
                        <button id="supplierpovoidbutton" type="button" class="btn btn-outline-dark"><i class="fa-solid fa-trash"></i> <span>Void</span></button>
                        <button id="closebutton" type="button" class="btn btn-outline-danger" data-dismiss="modal" onclick="clearvoiderror();"><i class="fa-regular fa-xmark"></i> Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end of void modals  -->
    {{-- start pe info modal --}}
    <div class="modal modal-slide-in event-sidebar fade" id="" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y:scroll;">
        <div class="modal-dialog modal-dialog-scrollable sidebar-xl" style="width: 90%;">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalScrollableTitle">Purchase Evaluation Information</h5>
                
            </div>
            <div class="modal-body scroll scrdiv">
                <form id="holdInfo">
                @csrf
                
            </form>   
            </div>
            <div class="modal-footer">
                    
            </div>
        </div>
        </div>
    </div> 
    
    <div class="modal modal-slide-in event-sidebar fade" id="pevualtiondocInfoModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y:scroll;">
            <div class="modal-dialog modal-dialog-scrollable sidebar-xl" style="width: 90%;">
                <div class="modal-content p-0">
                    
                    <div class="modal-header">
                        <h5 class="modal-title">Purchase Evaluation Information</h5>
                        <div class="row">
                            <div style="text-align: right;" id="peinfoStatus"></div>
                            {{-- <button type="button" class="close" onclick="pocollapseshow();" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                            </button> --}}
                        </div>
                    </div>
                    
                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                        <div>
                            <div class="row">
                                    <div class="col-xl-12" id="docinfo-block">
                                        <div class="card collapse-icon">
                                                <div class="collapse-default" id="accordionExample">
                                                    <div class="card">
                                                        <div class="card-header" id="headingOne" data-toggle="collapse" role="button" data-target="#pevualtioncollapseOne" aria-expanded="false" aria-controls="pevualtioncollapseOne">
                                                            <span class="lead collapse-title">Purchase Evaluation Details</span>
                                                            <span id="" style="font-size:16px;"></span>
                                                        </div>
                                                        <div id="pevualtioncollapseOne" class="collapse" aria-labelledby="pevualtioncollapseOne" data-parent="#accordionExample">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-xl-3 col-lg-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                                        <div class="card">
                                                                            <div class="card-header">
                                                                                <h6 class="card-title">Puchase Evaluation Information</h6>
                                                                            </div>
                                                                            <div class="card-body">
                                                                                <table class="table-responsive">
                                                                                    <tr>
                                                                                        <td><label strong style="font-size: 12px;">DOC#: </label></td>
                                                                                        <td><b><label id="peinfope" strong style="font-size: 12px;"></label></b></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><label strong style="font-size: 12px;">Reference: </label></td>
                                                                                        <td><b><label id="peinforefernce" strong style="font-size: 12px;"></label></b></td>
                                                                                    </tr>
                                                                                    <tr id="trinforfq">
                                                                                        <td><label strong style="font-size: 12px;">Reference#: </label></td>
                                                                                        <td><b><label id="peinforfq" strong style="font-size: 12px;"></label></b></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><label strong style="font-size: 12px;">Product Type: </label></td>
                                                                                        <td><b><label id="peinfotype" strong style="font-size: 12px;"></label></b></td>
                                                                                    </tr>
                                                                                    
                                                                                    <tr>
                                                                                        <td><label strong style="font-size: 12px;">Commodity Type: </label></td>
                                                                                        <td><b><label id="peinfocommoditype" strong style="font-size: 12px;"></label></b></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><label strong style="font-size: 12px;">Commodity Source: </label></td>
                                                                                        <td><b><label id="peinfocommoditysource" strong style="font-size: 12px;"></label></b></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><label strong style="font-size: 12px;">Commodity Status: </label></td>
                                                                                        <td><b><label id="peinfocommoditystatus" strong style="font-size: 12px;"></label></b></td>
                                                                                    </tr>
                                                                                    
                                                                                    <tr>
                                                                                        <td><label strong style="font-size: 12px;">Request Date: </label></td>
                                                                                        <td><b><label id="peinfodocumentdate" strong style="font-size: 12px;"></label></b></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><label strong style="font-size: 12px;">Request Station: </label></td>
                                                                                        <td><b><label id="peinfostation" strong style="font-size: 12px;"></label></b></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><label strong style="font-size: 12px;">Priority: </label></td>
                                                                                        <td><b><label id="peinfopriority" strong style="font-size: 12px;"></label></b></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><label strong style="font-size: 12px;">Sample: </label></td>
                                                                                        <td><b><label id="peinfosample" strong style="font-size: 12px;"></label></b></td>
                                                                                    </tr>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="col-xl-5 col-lg-12" id="requesteditemdiv">
                                                                        <div class="card">
                                                                            <div class="card-header">
                                                                                <h6 class="card-title" id="requesteditemlabel"></h6>
                                                                            </div>
                                                                            <div class="card-body">
                                                                                <div class="scroll scrdiv" style="overflow-y:scroll;height:25rem;">
                                                                                    <table id="perequesteditemdatatablesoninfo" class="display table-bordered table-striped table-hover dt-responsive mb-0" style="width: 100%">
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th>#</th>
                                                                                                <th class="reqtabl1">col1</th>
                                                                                                <th class="reqtabl2">col2</th>
                                                                                                <th class="reqtabl3">col3</th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-4 col-lg-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                                        <div class="card">
                                                                            <div class="card-header">
                                                                                <h6 class="card-title">Action</h6>
                                                                            </div>
                                                                            <div class="card-body scroll scrdiv">
                                                                                <ul class="timeline" id="peulist" style="height:25rem;">
                                                                                
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                            <div class="divider divider-info">
                                                <div class="divider-text">Commodity Details</div>
                                            </div>
                                        <div class="col-xl-12 col-lg-12">
                                            <div class="table-responsive">
                                                
                                                <div id="pecommuditylistdatablediv" class="scroll scrdiv">
                                                    <div class="row">
                                                            <div class="col-xl-2 col-md-2 col-sm-2" id="pesupllierlistdiv">
                                                                <div class="row">
                                                                        <div class="col-xl-12 col-md-12 col-sm-12">
                                                                            <table style="width: 100%;">
                                                                                <tr>
                                                                                    <td style="width:80%;">
                                                                                        <input type="text" class="form-control" id="pesearchsupplier" placeholder="Search here...">
                                                                                    </td>
                                                                                    <td style="width: 20%;">
                                                                                        <button type="button" class="btn btn-outline-dark" id="peclearsupplsearch"><i class="fa-duotone fa-circle-xmark"></i></button>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </div>
                                                                </div>
                                                                <div class="scroll scrdiv">
                                                                    <section id="pecarddatacanvas" style="margin-top:2rem;height:10rem">
                                                                    </section>
                                                                </div>  
                                                            </div> 
                                                            <div class="col-xl-10 col-md-10 col-sm-10" id="pecommoditylistdiv">
                                                                    
                                                                    <div id="pecomuditydocInfoItemdiv">
                                                                            <ul class="nav nav-tabs nav-justified" id="infoapptabs" role="tablist">
                                                                                @can('PE-View')
                                                                                    <li class="nav-item" id="initation">
                                                                                        <a class="nav-link active" id="initationview-tab" data-toggle="tab" href="#initationview" aria-controls="initationview" role="tab" aria-selected="true" onclick="infopelistbytab('peview');"><i data-feather="home"></i>Evaluation Initation</a>
                                                                                    </li>
                                                                                @endcan
                                                                                @can('TE-View')
                                                                                    <li class="nav-item" id="tectnicaltab">
                                                                                        <a class="nav-link" id="technicalview-tab" data-toggle="tab" href="#technicalview" aria-controls="technicalview" role="tab" aria-selected="false" onclick="infopelistbytab('teview');"><i data-feather="tool"></i>Technical Evaluation</a>
                                                                                    </li>
                                                                                @endcan
                                                                                @can('FE-View')
                                                                                    <li class="nav-item" id="financialtab">
                                                                                        <a class="nav-link" id="financialview-tab" data-toggle="tab" href="#financialview" aria-controls="financialview" role="tab" aria-selected="false" onclick="infopelistbytab('feview');"><i data-feather="codepen"></i>Financial Evaluation</a>
                                                                                    </li>
                                                                                @endcan
                                                                                
                                                                            </ul>
                                                                            <div class="tab-content">
                                                                                    <div class="tab-pane active" id="initationview" aria-labelledby="initationview-tab" role="tabpanel">
                                                                                        <table id="pecomuditydocInfoItem" class="display table-bordered table-striped table-hover dt-responsive mb-0" style="width: 100%;">
                                                                                            <thead>
                                                                                                <th>#</th>
                                                                                                <th>Customer</th>
                                                                                                <th>Requested Commodity</th>
                                                                                                <th>Supply Commodity</th>
                                                                                                <th>Crop Year</th>
                                                                                                <th>Preparation</th>
                                                                                                <th>Sample(KG)</th>
                                                                                                <th>Remark</th>
                                                                                            </thead>
                                                                                            <tbody></tbody>
                                                                                                <tfoot>
                                                                                                </tfoot>
                                                                                        </table>
                                                                                </div>
                                                                                <div class="tab-pane" id="technicalview" aria-labelledby="technicalview-tab" role="tabpanel">
                                                                                    <table id="petechnicalcomuditydocInfoItem" class="display table-bordered table-striped table-hover dt-responsive mb-0" style="width: 100%;">
                                                                                            <thead>
                                                                                                <th>#</th>
                                                                                                <th>Customer</th>
                                                                                                <th>Requested Commodity</th>
                                                                                                <th>Supply Commodity</th>
                                                                                                <th>Crop Year</th>
                                                                                                <th>Preparation</th>
                                                                                                <th>Sample(KG)</th>
                                                                                                <th>Moisture</th>
                                                                                                <th>Grade</th>
                                                                                                <th>Sieve Size</th>
                                                                                                <th>Cup Value</th>
                                                                                                <th>Row Value</th>
                                                                                                <th>Score</th>
                                                                                                <th>Status</th>
                                                                                                <th>Remark</th>
                                                                                            </thead>
                                                                                            <tbody class="table table-sm"></tbody>
                                                                                                <tfoot>
                                                                                                </tfoot>
                                                                                        </table>
                                                                                </div>
                                                                                <div class="tab-pane" id="financialview" aria-labelledby="financialview-tab" role="tabpanel">
                                                                                            <table id="pefinancailcomuditydocInfoItem" class="display table-bordered table-striped table-hover dt-responsive mb-0" style="width: 100%;">
                                                                                                <thead>
                                                                                                    <th>#</th>
                                                                                                    <th>Customer</th>
                                                                                                    <th>Requested Commodity</th>
                                                                                                    <th>Supply Commodity</th>
                                                                                                    <th>Crop Year</th>
                                                                                                    <th>Preparation</th>
                                                                                                    <th>Grade</th>
                                                                                                    <th>Feresula</th>
                                                                                                    <th>Customer Price</th>
                                                                                                    <th>Proposed Price</th>
                                                                                                    <th>Final Price</th>
                                                                                                    <th>Rank</th>
                                                                                                    <th>Remark</th>
                                                                                                </thead>
                                                                                                <tbody></tbody>
                                                                                                    <tfoot>
                                                                                                    </tfoot>
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
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" placeholder="" class="form-control" name="perecordIds" id="perecordIds" readonly="true"/>
                        <input type="hidden" placeholder="" class="form-control" name="peevelautestatus" id="peevelautestatus" readonly="true"/>
                        <input type="hidden" placeholder="" class="form-control" name="peevalsupplierid" id="peevalsupplierid" readonly="true"/>
                        <input type="hidden" placeholder="" class="form-control" name="peevalstatus" id="peevalstatus" readonly="true"/>
                            <button id="closebutton" type="button" class="btn btn-outline-danger" onclick="pocollapseshow();" data-dismiss="modal"><i class="fa-regular fa-xmark"></i> Close</button>
                    </div>
                </div>
            </div>
        </div>
    {{-- end info pe --}}
    <div class="modal modal-slide-in event-sidebar fade" id="approvedmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y:scroll;">
            <div class="modal-dialog modal-dialog-scrollable sidebar-xl" style="width: 90%;">
                <div class="modal-content p-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                    <div class="modal-header mb-1">
                        <h5 class="modal-title">Review Purchase Orders</h5>
                    </div>
                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                        <div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="table-responsive scroll scrdiv">
                                        <table id="approvedtablelist" class="display table-bordered table-striped table-hover dt-responsive mb-0" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th rowspan="2">
                                                        <div class="custom-control custom-control-primary custom-checkbox" id="waitedselectalldiv">
                                                            <input type="checkbox" class="custom-control-input waitedselectall" id="waitedselectall" onclick="waitedselectallcheck()"/>
                                                            <label class="custom-control-label" for="waitedselectall"></label>
                                                        </div>  
                                                    </th>
                                                    <th rowspan="2">#</th>
                                                    <th rowspan="2">Doc#</th>
                                                    <th colspan="2" style="text-align: center;">Reference</th>
                                                    <th colspan="2" style="text-align: center;">Supplier</th>
                                                    <th colspan="2" style="text-align: center;">Date</th>
                                                    <th rowspan="2">Status</th>
                                                    <th rowspan="2"></th>
                                                    <th rowspan="2"></th>
                                                </tr>
                                                <tr style="text-align: center;">
                                                    <th>Type</th>
                                                    <th>Number</th>
                                                    <th>Name</th>
                                                    <th>TIN</th>
                                                    <th>Order</th>
                                                    <th>Deliver</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                                <div class="alert alert-success" role="alert" id="reviewdiv">
                                    <h4 class="alert-heading" id="reviewtitle"> </h4>
                                    <div class="alert-body" id="reviewbody">
                                    
                                    </div>
                                </div>
                            <button id="undoreview" type="button" class="btn btn-info" style="display:none;"> Undo Review</button>
                            <button id="permit" type="button" class="btn btn-info" style="display:none;">Review</button>
                        <button id="" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="myPopoverContent" style="display:none">
                <div class='row'>
                    <div class='col-xl-6 col-lg-12' id="popoveretailpricediv"><b><u>RT Price BV</u></b><div id="popoveretailprice"></div></div>
                    <div class='col-xl-6 col-lg-12' id="popoveretailpriceavdiv"><b><u>RT Price AV</u></b><div id="popoveretailpriceav"></div></div>
                    <div class='col-xl-6 col-lg-12' id="popoverwholesalepricediv"><b><u>WS Price BV</u></b><div id="popoverwholesaleprice"></div></div>
                    <div class='col-xl-6 col-lg-12' id="popoverwholesalepriceavdiv"><b><u>WS Price Av</u></b><div id="popoverwholesalepriceav"></div></div>
                </div>
                <div class="row">
                    <div class='col-xl-6 col-lg-12' id='popovereminqtydiv'><b><u>Min Qty</u></b><div id="popovereminqty"></div></div>
                    <div class='col-xl-6 col-lg-12' id='popoveremaxqtydiv'><b><u>Max Qty</u></b><div id="popoveremaxqty"></div></div>
                </div>
        </div>

    
    <script type="text/javascript">
    
        var m=0;
        var mm=0;
        var j=0;
        var jj=0;
        var i=0;
        var pordertables='';
        var maingblIndex=0;
        var errorcolor="#ffcccc";
        
        $(document).ready(function () {
            $('#commoditytypediv').hide();
            $('#coffeesourcediv').hide();
            $('#coffestatusdiv').hide();

        $('#directorderdate').daterangepicker({ 
                singleDatePicker: true,
                showDropdowns: true,
                autoApply:true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });

            $('#directdeliverydate').daterangepicker({ 
                singleDatePicker: true,
                showDropdowns: true,
                autoApply:true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });

            checkreview();
            orderlist();
        });

        function checkreview() {
            $.ajax({
                type: "GET",
                url: "{{ url('poreviewlist') }}",
                success: function (response) {
                    $('#budgetapprovalcount').html(response.reviewsales);
                }
            });
        }
        function listreviewbudget() {
        //$('.waitedselectall').prop('checked', false);
        var fyear = $('#fiscalyear').val()||0;
        $('#approvedtablelist').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        searchHighlight: true,
        destroy:true,
        lengthMenu: [[50, 100], [50, 100]],
        "pagingType": "simple",
            language: { search: '', searchPlaceholder: "Search here"},
            dom: "<'row'<'col-lg-2 col-md-10 col-xs-2'f><'col-lg-2 col-md-2 col-xs-12'>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-4'i><'col-sm-12 col-md-6'><'col-sm-12 col-md-2'p>>",
        ajax: {
        url: '{{ url("poreviewlisting") }}/',
        type: 'GET',
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
            $('#approvedmodal').modal('show');
        },
        },
        columns: [
            { data: 'id', name: 'id',orderable: false },
            { data:'DT_RowIndex'},
            { data: 'porderno', name: 'porderno' },
            { data: 'type', name: 'type' },
            { data: 'documentumber', name: 'documentumber' },
            { data: 'supllier', name: 'supllier' },
            { data: 'TIN', name: 'TIN' },
            { data: 'orderdate', name: 'orderdate' },
            { data: 'deliverydate', name: 'deliverydate' },
            { data: 'status', name: 'status' },
            { data: 'peid', name: 'peid',visible:false },
            { data: 'isreviewed', name: 'isreviewed',visible:true },
        ],
            columnDefs: [{
                targets: 0,
                render: function(data, type, row, meta){
                    switch (row.isreviewed) {
                        case '1':
                            var xc='<div class="custom-control custom-control-danger custom-checkbox">'+
                                    '<input type="checkbox" value="'+data+'" name="reviewaitedsalesid[]" class="custom-control-input waitedcheckboxpermitted" id="colorCheck'+row.id+'" onclick="checkallitemswaitedundoreview();"/>'+
                                    '<label class="custom-control-label" for="colorCheck'+row.id+'"></label>'+
                                    '</div>';
                            return xc;        
                            break;
                        default:
                                var xc='<div class="custom-control custom-control-success custom-checkbox">'+
                                    '<input type="checkbox" value="'+data+'" name="waitedsalesid[]" class="custom-control-input waitedcheckbox" id="check'+row.id+'" onclick="checkallitemswaited();"/>'+
                                    '<label class="custom-control-label" for="check'+row.id+'"></label>'+
                                    '</div>';
                            return xc; 
                            
                            break;
                    }
                }
            },
            {
                targets:2,
                render:function (data,type,row,meta) {
                    var anchor='<a class="enVoice" href="javascript:void(0)" data-link="/prattachemnt/'+row.id+'"  data-id="'+row.id+'" data-original-title="" title="Check purchase" style="text-decoration:underline;"><span>'+data+'</span></a>';
                    return anchor;
                }
            },
            {
                targets:9,
                render:function(data,type,row,meta){
                    switch (data) {
                        case 7:
                            return 'Reviewed';
                            break;
                            case 6:
                                return 'Review';
                                break;
                            case 3: 
                            return 'Low';
                            break;    
                        default:
                            return '---';
                            break;
                    }
                }
            },
            
            ],
        });
    }   
    function checkallitemswaitedundoreview(){
            $('.waitedcheckbox').prop('checked', false); //uncheck review
            $('#undoreview').show();
            $('#permit').hide();
            var masterCheck = $("#waitedselectall");
            var numberOfChecked = $('.waitedcheckboxpermitted').filter(':checked').length ;
            var totalCheckboxes=$("input[name='reviewaitedsalesid[]']").length;
            if((parseFloat(totalCheckboxes)==parseFloat(numberOfChecked))){
                masterCheck.prop("indeterminate", false);
                masterCheck.prop("checked", true);
            } else{
                masterCheck.prop("indeterminate", true);
            }
            assigncheckboxstatus('danger');
            reviewdivassignclass('danger');
        }
        function checkallitemswaited(){
            $('.waitedcheckboxpermitted').prop('checked', false); //uncheck undoreview
            $('#undoreview').hide();
            $('#permit').show();
            var unchecked=0;
            var masterCheck = $("#waitedselectall");
            var numberOfChecked = $('.waitedcheckbox').filter(':checked').length ;
            var totalCheckboxes=$("input[name='waitedsalesid[]']").length;
            if((parseFloat(totalCheckboxes)==parseFloat(numberOfChecked))){
                masterCheck.prop("indeterminate", false);
                masterCheck.prop("checked", true);
            } else{
                masterCheck.prop("indeterminate", true);
            }
            assigncheckboxstatus('success');
            reviewdivassignclass('success');
        }
        function reviewdivassignclass(type){
            var reviewcheck = $('.waitedcheckbox').filter(':checked').length;
            var undoreviewcheck = $('.waitedcheckboxpermitted').filter(':checked').length;
            switch (type) {
                case 'danger':
                    $('#reviewtitle').text('Undo-Review');
                    $('#reviewdiv').removeClass('alert alert-success');
                    $('#reviewdiv').addClass('alert alert-danger');
                    $('#reviewbody').text('You have selected '+undoreviewcheck+' Purchase Order');
                    break;
                default:
                    $('#reviewtitle').text('Review');
                    $('#reviewdiv').removeClass('alert alert-danger');
                    $('#reviewdiv').addClass('alert alert-success');
                    $('#reviewbody').text('You have selected '+reviewcheck+' Purchase Order');
                    break;
            }
            $('#reviewdiv').show();
        }
        function assigncheckboxstatus(status){
            $('#waitedselectalldiv').removeClass('custom-control custom-control-danger custom-checkbox');
            $('#waitedselectalldiv').removeClass('custom-control custom-control-success custom-checkbox');
            $('#waitedselectalldiv').removeClass('custom-control custom-control-primary custom-checkbox');
            $('#waitedselectalldiv').addClass('custom-control custom-control-'+status+' custom-checkbox');
        }
        function checkallitems(subtotal){
            var unchecked=0;
            var masterCheck = $("#selectall");
            var numberOfChecked = $('.recieptcheckbox').filter(':checked').length ;
            var totalCheckboxes=$("input[name='saleid[]']").length;
            $("#collapseExample").collapse('hide');
            $("#witholdwitholdReciept-error").html('');
            $("#witholvatReciept-error").html('');
            $("#witholdwitholdReciept").val('');
            $("#witholvatReciept").val('');
            if((parseFloat(totalCheckboxes)==parseFloat(numberOfChecked))){
                masterCheck.prop("indeterminate", false);
                masterCheck.prop("checked", true);
                
            }
            else{
                masterCheck.prop("indeterminate", true);
            }
        }
        function waitedselectallcheck(){
            var reviewcheck = $('.waitedcheckbox').filter(':checked').length;
            var undoreviewcheck = $('.waitedcheckboxpermitted').filter(':checked').length;
            
            if( $('#waitedselectall').is(':checked') ){
                checkBoxSelection(reviewcheck,undoreviewcheck);
            } 
            else{
                checkBoxUnSelection(reviewcheck,undoreviewcheck);
            }
            
        }
        function checkBoxSelection(reviewcheck,undoreviewcheck){
            if(parseFloat(reviewcheck)==0 && parseFloat(undoreviewcheck)==0){
                toastrMessage('error','Please select at least one checkbok','Error');
                $('.waitedselectall').prop('checked', false); 
            } 
            else if(parseFloat(reviewcheck)>0){
                $('.waitedcheckbox').prop('checked', true);
                assigncheckboxstatus('success');
                reviewdivassignclass('success');
            }
            else if(parseFloat(undoreviewcheck)>0){
                $('.waitedcheckboxpermitted').prop('checked', true);
                assigncheckboxstatus('danger');
                reviewdivassignclass('danger');
            }
        }
        $("#undoreview").click(function(){
            var numberOfChecked = $('.waitedcheckboxpermitted').filter(':checked').length;
            switch (numberOfChecked) {
                case 0:
                    toastrMessage('error','Please select the sales record','Undo-review');
                    break;
            
                default:
                    var checkid=$('.waitedcheckboxpermitted:checked').map(function(){
                            return $(this).val()
                            }).get().join(",");
                            reviewconfirmessages(checkid);
                    break;
            }
        });
        function reviewconfirmessages(checkid){
            var undoreviewcheck = $('.waitedcheckboxpermitted').filter(':checked').length;
            swal.fire({
                title: "Notice",
                icon: 'warning',
                html: "Are you sure do you to undo-review  "+undoreviewcheck+" selected purhase",
                type: "warning",
                showCancelButton: !0,
                allowOutsideClick: false,
                cancelButtonText: "Cancel",
                confirmButtonClass: "btn-info",
                cancelButtonClass: "btn-danger",
                confirmButtonText: "Ok",
                }).then(function (e) {
                if (e.value === true) {
                    undoprpermit(checkid);
                } else {
                    e.dismiss;
                    
                }
            }, function (dismiss) {
                return false;
            })
        }
        $("#permit").click(function(){
                var numberOfChecked = $('.waitedcheckbox').filter(':checked').length;
                switch (numberOfChecked) {
                    case 0:
                        toastrMessage('error','Please select the sales record','Permit');
                        break;
                    default:
                        var checkid=$('.waitedcheckbox:checked').map(function(){
                            return $(this).val()
                            }).get().join(",");
                            permitconfirmessages(checkid);
                        break;
                }
        });
        function permitconfirmessages(checkid){
                var reviewcheck = $('.waitedcheckbox').filter(':checked').length;
                swal.fire({
                    title: "Notice",
                    icon: 'warning',
                    html: "Are you sure do you to review "+reviewcheck +" selected purchase",
                    type: "warning",
                    showCancelButton: !0,
                    allowOutsideClick: false,
                    cancelButtonText: "Cancel",
                    confirmButtonClass: "btn-info",
                    cancelButtonClass: "btn-danger",
                    confirmButtonText: "Ok",
                    }).then(function (e) {
                    if (e.value === true) {
                        prpermit(checkid);
                    } else {
                        e.dismiss;
                        
                    }
                }, function (dismiss) {
                    return false;
                })
        }
        function prpermit(checkid){
            $.ajax({
                type: "GET",
                url: "{{ url('poprpermit') }}/"+checkid,
                beforeSend: function () {
                    cardSection.block({
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
                success: function (response) {
                    switch (response.success) {
                        case 200:
                            toastrMessage('success','The purchase data is successfully permitted','Permit');
                            $('#approvedmodal').modal('hide');
                            $('.waitedselectall').prop('checked', false); 
                            assigncheckboxstatus('primary');
                            refreshmaintables();
                            break;
                        default:
                            toastrMessage('error','There is error please contact the support team','Permit');
                            break;
                    }
                }
            });
        }

        function undoprpermit(checkid){
            $.ajax({
                type: "GET",
                url: "{{ url('poundoprpermit') }}/"+checkid,
                beforeSend: function () {
                    cardSection.block({
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
                success: function (response) {
                    switch (response.success) {
                        case 200:
                            toastrMessage('success','The purchase data is successfully undo reviewed','Undo-review');
                            $('#approvedmodal').modal('hide');
                            $('.waitedselectall').prop('checked', false); 
                            
                            assigncheckboxstatus('primary');
                            refreshmaintables();
                            break;
                        default:
                            toastrMessage('error','There is error please contact the support team','Undo-Review');
                            break;
                    }
                }
            });
        }
        function pocollapseshow() {
            $("#collapseOne").collapse('show');
        }
        $('body').on('click', '.addbutton', function () {
            setvaluestoempty();
        });
        
        function setvaluestoempty() {
    // Show modal and set title
        $("#exampleModalScrollable").modal('show');
        $('#exampleModalScrollableTitleadd').html('Add Purchase Order');
            $("#savedicon").removeClass("fa-sharp fa-solid fa-floppy-disk");
            $("#savedicon").removeClass("fa-duotone fa-pen");
            $("#savedicon").addClass("fa-duotone fa-pen");
            $("#savebutton").find('span').text("Save");
    // Hide unnecessary elements
    hideElements();

    // Reset Select2 dropdowns
    resetSelect2Dropdowns();

    // Clear input fields
    clearInputFields();

    // Reset UI elements
    resetUI();

    // Enable all options in dropdowns
    enableDropdownOptions();

    // Clear status display
    $('#statusdisplay').html('');
}

function hideElements() {
    $('#itemsdatablediv').hide();
    $('#commuditylistdatablediv').hide();
    $('#directdynamicTablecommdity').hide();
    $('#goodsdynamictables').hide();
    $('#supplierduv').show();
    $('#pediv').hide();
    $('#directgrandtotaltr').hide();
    $('#directtaxtr').hide();
    $('#directwitholdingTr').hide();
    $('#directnetpayTr').hide();
    $('.directclass').hide();
}

function resetSelect2Dropdowns() {
    const dropdowns = [
        '#reference',
        '#pe',
        '#supplier',
        '#purchaseordertype',
        '#commoditytype',
        '#coffeesource',
        '#coffestatus',
        '#directwarehouse',
        '#directpaymenterm'
    ];

    dropdowns.forEach(dropdown => {
        $(dropdown).select2('destroy').val(null).select2();
    });
}

function clearInputFields() {
    const fields = [
        '#porderid',
        '#documentnumber',
        '#directdeliverydate',
        '#directorderdate',
        '#date',
        '#directistaxable'
    ];

    fields.forEach(field => {
        $(field).val('');
    });

    // Set date to current date
    const currentdate = $('#currentdate').val();
    $("#date").val(currentdate);

    // Clear error messages
    $('.rmerror').html('');

    // Uncheck checkbox
    $('#directcustomCheck1').prop('checked', false);
}

function resetUI() {
    // Clear tables
    $("#goodsdynamictables > tbody").empty();
    $("#directdynamicTablecommdity > tbody").empty();

    // Reset labels and totals
    $('.lbl').html('0.00');
    $('#directnumberofItemsLbl').html('0');
    $('#directpricetable').hide();
}

function enableDropdownOptions() {
    const dropdownOptions = [
        '#purchaseordertype option',
        '#reference option',
        '#peoption option',
        '#commoditytype option',
        '#coffeesource option',
        '#coffestatus option',
        '#directwarehouse option',
        '#supplier option',
        '#pe option'
    ];

    dropdownOptions.forEach(option => {
        $(option).prop('disabled', false);
    });
}
        function refreshmaintables(){
                var oTable = $('#purchaordetables').dataTable(); 
                oTable.fnDraw(false);
        }
        $("#pocancelledbutton").on('click', function() {
            var inputVar=$('#cancelreason').val();
            var idval=$('#elementid').val();
            var reason = (inputVar === undefined || inputVar === null || inputVar === '') ? 'EMPTY' : inputVar;
            switch (reason) {
                case 'EMPTY':
                    $('#cancelreason-error').html('reason is required');
                    break;
                default:
                    $('#pocancelmodal').modal('hide');
                    $('#cancelreason').val('');
                    $('#reason'+idval).val(reason);
                    CalculateGrandTotal();
                    break;
            }

        });
        $("#reasonclosebutton").on('click', function() {
            var idval=$('#elementid').val();
            $('#continue'+idval).select2('destroy');
            $('#continue'+idval).val('Confirm').select2();
            $('#cancelreason-error').html('');
            $('#cancelreason').val('');
            
        });
        
        function clearvoiderror() {
            $('#cancelreason-error').html('');
            $('#voidreason-error').html('');
            $('#suppliervoidreason-error').html('');
        }

        $(document).on('change', '.form-control', function() {
            const errorElement = $(this).closest('.errorclear').find('.text-danger strong');
            errorElement.text('');
        });

        $('#purchaseordertype').on('change', function() {
            // Get the selected value
            $("#goodsdynamictables > tbody").empty();
            $("#directdynamicTablecommdity > tbody").empty();
            $('#directpricetable').show();
            $('#reference').select2('destroy');
            $('#reference').val(null).select2();
            var selectedValue = $(this).val();
                // Log the selected value to the console
            showandhidependontype(selectedValue);
        }); 
        $('#reference').on('change', function () {
            $('#reference-error').html('');
            $('#pe').select2('destroy');
            $('#pe').val(null).select2();
            $('#supplier').select2('destroy');
            $('#supplier').val(null).select2();
            $('#commoditytype').select2('destroy');
            $('#commoditytype').val(null).select2();
            $('#coffeesource').select2('destroy');
            $('#coffeesource').val(null).select2();
            $('#coffestatus').select2('destroy');
            $('#coffestatus').val(null).select2();
            $('#directwarehouse').select2('destroy');
            $('#directwarehouse').val(null).select2();
            $('#directpaymenterm').select2('destroy');
            $('#directpaymenterm').val(null).select2();
            $('#directorderdate').val('');
            $('#directdeliverydate').val('');
            var reference=$('#reference').val();
            const purchaseordertype=$('#purchaseordertype').val();
            $('#nofbagtotal').html('');
            $('#bagweighttotal').html('');
            $('#kgtotal').html('');
            $('#tontotal').html('');
            $('#priceferesula').html('');
            $('#pricetotal').html('');
            $('#totalpricetotal').html('');
            $('#netkgtotal').html('');
            
                switch (purchaseordertype) {
                    case 'Goods':

                        break;
                
                    default:
                            switch (reference) {
                                case 'Direct':
                                    $('#supplierduv').show();
                                    $('#pediv').hide();
                                    $('#directdynamicTablecommdity').show();
                                    $('#directpricetable').show();
                                    $('.directclass').show();
                                    $('#pe').select2('destroy');
                                    $('#pe').val('').select2();
                                    $('#commoditytype option').prop('disabled', false);
                                    $('#coffeesource option').prop('disabled', false);
                                    $('#coffestatus option').prop('disabled', false);
                                    $('#supplier option').prop('disabled', false);
                                    $('#directwarehouse option').prop('disabled', false);
                                    break;
                                    
                                default:
                                    $('#supplierduv').show();
                                    $('#pediv').show();
                                    $('#directdynamicTablecommdity').show();
                                    $('#directpricetable').show();
                                    $('.directclass').show();
                                    break;
                            }
                        break;
                }
            
        });
        $('#pe').on('change', function () {
                $('#pe-error').html('');
                var pe =$('#pe').val();
                var option='<option value=""></option>';

                $.ajax({
                    type: "GET",
                    url: "{{ url('getpassedpev') }}/"+pe,
                    dataType: "json",
                    success: function (response) {
                        $.each(response.supplier, function (index, value) { 
                            $('#supplier').select2('destroy');
                            $('#supplier').val(value.customerid).select2();
                            $('#supplier option').each(function() {
                                $(this).prop('disabled', !$(this).is(':selected')); // Disable option if it is not selected
                            });
                            $('#supplier').select2();
                        });
                        $.each(response.pev, function (index, value) { 
                            $('#commoditytype').select2('destroy');
                            $('#commoditytype').val(value.commudtytype).select2();

                            $('#coffeesource').select2('destroy');
                            $('#coffeesource').val(value.coffeesource).select2();

                            $('#coffestatus').select2('destroy');
                            $('#coffestatus').val(value.coffestat).select2();

                            $('#directwarehouse').select2('destroy');
                            $('#directwarehouse').val(value.store_id).select2();

                            $('#commoditytype option').each(function() {
                                $(this).prop('disabled', !$(this).is(':selected')); // Disable option if it is not selected
                            });
                            $('#coffeesource option').each(function() {
                                $(this).prop('disabled', !$(this).is(':selected')); // Disable option if it is not selected
                            });
                            $('#coffestatus option').each(function() {
                                $(this).prop('disabled', !$(this).is(':selected')); // Disable option if it is not selected
                            });
                            $('#directwarehouse option').each(function() {
                                $(this).prop('disabled', !$(this).is(':selected')); // Disable option if it is not selected
                            });
                            $('#commoditytype').select2();
                            $('#coffeesource').select2();
                            $('#coffestatus').select2();
                            $('#directwarehouse').select2();

                        });
                        switch (response.type) {
                            case 'Goods':
                                $('#itemsdatablediv').show();
                                $('#commuditylistdatablediv').hide();
                                break;
                            
                            default:
                                $('#itemsdatablediv').hide();
                                $('#commuditylistdatablediv').hide();
                                var table='comuditydocaddItem';
                                appendoecommodtyforaddandedit(response.comiditylist);
                                peappendcommoditylist(response.comiditylist);
                                break;
                        }
                    }
                });
            });
            function appendoecommodtyforaddandedit(params) {
                $('#pecommodity').empty
                var optiondefault="<option selected disabled value=''></option>";
                $('#pecommodity').append(optiondefault);
                $.each(params, function (index, value) { 
                    var commselected='<option value="'+value.woredaid+'">'+value.supplyorigin+'</option>';
                    $('#pecommodity').append(commselected);
                    $('#pecommodity').select2();
                });

            }
    $("#adds").on('click', function() {
        ++jj;
        ++mm;
        appendtable(jj,mm);
        renumberRows('Commodity');
    });

    $("#goodadds").on('click', function() {
        var tdValue=-1; 
        var inputValue=-1;
        const lastRowValues = [];
        const lastRow = $('#goodsdynamictables > tbody tr:last');
        lastRow.find('td').each(function () { // Get the value of the <td> element
                tdValue = $(this).text().trim(); // For text content
                inputValue = $(this).find('input, select').val();// If the <td> contains an input, select, or other form element, get its value instead
                lastRowValues.push(inputValue || tdValue); // Push the value to the array
            });
            if(inputValue!=-1){
                
                var itemids=$('#itemNameSl'+inputValue).val()||0;
                    if(itemids==0){
                        $('#select2-itemNameSl'+inputValue+'-container').parent().css('background-color',errorcolor);
                        toastrMessage('error', 'Please select item from highlighted field', 'Error');
                    } else{
                        appendynamictables();
                    }
            } else{
                appendynamictables();
            }
    });

    function appendynamictables() {
            ++jj;
            ++mm;
            goodsappendtable(jj,mm);
            renumberRows('Goods');
            for (let k = 1; k <= mm; k++) {
                const selectedVal = $('#itemNameSl' + k).val();
                if (selectedVal) {
                    $('#itemNameSl' + mm + " option[value='" + selectedVal + "']").remove();
                }
            }
    }

    $(document).on('click', '.remove-tr', function(){
        $(this).parents('tr').remove();
        directCalculateGrandTotal();
        renumberRows('Commodity');
    });

    $(document).on('click', '.goodsremove-tr', function(){
        $(this).parents('tr').remove();
        goodCalculateGrandTotal();
        renumberRows('Goods');
    });


    function renumberRows(type) {
        var ind;
        switch (type) {
            case 'Goods':
                    $('#goodsdynamictables > tbody > tr').each(function(index, el){
                        $(this).children('td').first().text(++index);
                        $('#directnumberofItemsLbl').html(index);
                        ind=index;
                        jj=ind;
                    });
                break;
        
            default:
                    $('#directdynamicTablecommdity > tbody > tr').each(function(index, el){
                        $(this).children('td').first().text(++index);
                        $('#directnumberofItemsLbl').html(index);
                        ind=index;
                        jj=ind;
                    });
                break;
        }
        
    }

    function goodsappendtable(jj,mm){
                const tables = `<tr id="row${jj}">
                        <td style="text-align:center;">${jj}</td>
                        <td><select id="itemNameSl${mm}" class="select2 form-control form-control-lg eName" onchange="goodchanges(this)" name="row[${mm}][itemid]"></select></td>
                        <td><select id="uom${mm}" class="select2 form-control uom" onchange="goodchanges(this)" name="row[${mm}][uom]"></select></td>
                        <td><input type="text" name="row[${mm}][qauntity]" placeholder="Quantity" id="goodqty${mm}" class="goodqty form-control" onkeyup="goodCalculateTotal(this)" onkeypress="return ValidateNum(event);"/></td>
                        <td><input type="text" name="row[${mm}][unitprice]" placeholder="Price" id="goodprice${mm}" class="goodprice form-control" onkeyup="goodCalculateTotal(this)" onkeypress="return ValidateNum(event);"/></td>
                        <td><input type="text" name="row[${mm}][total]" placeholder="Total" id="goodtotal${mm}" class="goodtotal form-control" onkeypress="return ValidateNum(event);" readonly/></td>
                        <td style="text-align:center;background-color:#efefef;">
                            <a type="button"><i class="fa fa-info-circle text-primary viewiteminfo" title="Item Information"></i></a>
                            <button type="button" class="btn btn-lignt btn-sm goodsremove-tr"><i class="fa-sharp fa-solid fa-x" style="color: #f03000;"></i></button>
                            </td>
                        <td style="display:none;"><input type="text" name="row[${mm}][vals]" id="directvals${mm}" class="goodsdirectvals form-control" readonly="true" style="font-weight:bold;" value="${mm}"/></td>
                    </tr>`;
            $("#goodsdynamictables > tbody").append(tables);
            const itemoption=$("#hiddenitem > option").clone();
            $(`#itemNameSl${mm}`).append(itemoption);
            $(`#itemNameSl${mm}`).select2({placeholder: "Select Goods"});
            
            const uomoption=$("#hiddenuom > option").clone();
            $(`#uom${mm}`).append(uomoption);
            $(`#uom${mm}`).select2({placeholder: "Select UOM"});
            
    }

    function goodchanges(ele) {
        var itemid = $(ele).closest('tr').find('.eName').val();
        const idval = $(ele).closest('tr').find('.goodsdirectvals').val();
        $('#select2-itemNameSl'+idval+'-container').parent().css('background-color',"white");
        $.ajax({
            type: "GET",
            url: "{{ url('goodsuom') }}/"+itemid, 
            success: function (response) {
                $(`#uom${idval}`).select2('destroy');
                $(`#uom${idval}`).val(response.uomid).select2();
                $(`#uom${idval} option`).each(function() {
                    $(this).prop('disabled', !$(this).is(':selected')); // Disable option if it is not selected
                });
                $(`#uom${idval}`).select2({placeholder: "Select Measurement"});
            }
        });
    }
    function appendtable(jj,mm) {
            console.log('this is add');
            var reference=$('#reference').val();
            var tables='<tr id="row'+jj+'" class="financialevdynamic-commudity">'+
                '<td style="text-align:center;">'+jj+'</td>'+
                '<td><select id="itemNameSl'+mm+'" class="select2 form-control form-control-lg eName" onchange="directsourceVal(this)" name="fevrow['+mm+'][evItemId]"></select></td>'+
                '<td><select id="cropyear'+mm+'" class="select2 form-control cropyear" onchange="directsourceVal(this)" name="fevrow['+mm+'][evcropyear]"></select></td>'+
                '<td><select id="coffeproccesstype'+mm+'" class="select2 form-control coffeproccesstype" onchange="directsourceVal(this)" name="fevrow['+mm+'][coffeproccesstype]"></select></td>'+
                '<td style="width:6%;"><select id="directgrade'+mm+'" class="select2 form-control directgrade" onchange="directsourceVal(this)" name="fevrow['+mm+'][directgrade]"></select></td>'+
                '<td><select id="uom'+mm+'" class="select2 form-control directuom" onchange="directuomval(this)" name="fevrow['+mm+'][uom]"></select></td>'+
                '<td><input type="text" name="fevrow['+mm+'][qauntity]" placeholder="Enter quantity" id="directfevqauntity'+mm+'" class="directfevqauntity form-control" onkeyup="directCalculateTotal(this)" onkeypress="return ValidateNum(event);"/></td>'+
                '<td><input type="text" name="fevrow['+mm+'][bagweight]" placeholder="Bag Weight" id="bagweight'+mm+'"  class="bagweight form-control" onkeypress="return ValidateNum(event);" readonly/></td>'+
                '<td><input type="text" name="fevrow['+mm+'][totalkg]" placeholder="Total kg" id="totalkg'+mm+'"  class="totalkg form-control" onkeypress="return ValidateNum(event);" readonly/></td>'+
                '<td><input type="text" name="fevrow['+mm+'][netkg]" placeholder="Net Kg" id="netkg'+mm+'"  class="directnetkg form-control" onkeypress="return ValidateNum(event);" readonly/></td>'+
                '<td><input type="text" name="fevrow['+mm+'][ton]" placeholder="TON" id="directton'+mm+'"  class="directton form-control" onkeypress="return ValidateNum(event);" readonly/></td>'+
                '<td><input type="text" name="fevrow['+mm+'][feresula]" placeholder="Feresula" id="feresula'+mm+'" class="directferesula form-control" onkeypress="return ValidateNum(event);" readonly/></td>'+
                '<td><input type="text" name="fevrow['+mm+'][finalprice]" placeholder="Price" id="directfinalprice'+mm+'" ondblclick="calculateaftervat(this)"; class="directfinalprice form-control"onkeyup="directCalculateTotal(this)" onkeypress="return ValidateNum(event);" /></td>'+
                '<td><input type="text" name="fevrow['+mm+'][Total]" placeholder="Total" id="fevtotal'+mm+'" class="directfevtotal form-control" onkeypress="return ValidateNum(event);" readonly/></td>'+
                '<td style="width:3%;text-align:center;background-color:#efefef;"><a type="button"><i class="fa fa-info-circle text-primary info-icon viewcommodityinfo" title="Price Information" style="cursor: pointer;"></i></a><button type="button" class="btn btn-lignt btn-sm remove-tr"><i class="fa-sharp fa-solid fa-x" style="color: #f03000;"></i></button></td>'+
                '<td style="display:none;"><input type="hidden" name="fevrow['+mm+'][vals]" id="directvals'+mm+'" class="directvals form-control" readonly="true" style="font-weight:bold;" value="'+mm+'"/></td>'+
                '<td style="display:none;"><input type="hidden" name="fevrow['+mm+'][pdetid]" id="pdetid'+mm+'" class="pdetid form-control" readonly="true" style="font-weight:bold;"/></td>'+
            '</tr>';
            $("#directdynamicTablecommdity > tbody").append(tables);
                switch (reference) {
                    case 'PE':
                        var options = $("#pecommodity > option").clone();
                        break;
                
                    default:
                            var options = $("#hiddencommudity > option").clone();
                        break;
                }
                
                var proccesstypeoption=$("#coffeeproccesstype > option").clone();
                var cropyearoption=$("#cropYear > option").clone();
                var uomoption=$("#uom > option").clone();
                var gradeoption=$("#coffeegrade > option").clone();
                $('#itemNameSl'+mm).append(options);
                $('#coffeproccesstype'+mm).append(proccesstypeoption);
                $('#cropyear'+mm).append(cropyearoption);
                $('#uom'+mm).append(uomoption);
                $('#directgrade'+mm).append(gradeoption);
                $('#itemNameSl'+mm).select2({placeholder: "Select products"});
                $('#coffeproccesstype'+mm).select2({placeholder: "Select proccess type"});
                $('#cropyear'+mm).select2({placeholder: "Select crop year"});
                $('#uom'+mm).select2({placeholder: "Select uom"});
                $('#directgrade'+mm).select2({placeholder: "Select grade"});
                
    }
    function directappendgoodlist(params) {
        let jj=0;
        const $tbody = $("#goodsdynamictables > tbody");
        $tbody.empty(); // Clear the table body
        $.each(params, function (index, value) {
            ++jj;
            ++mm;
            // Generate and append the table row
            const tableRow = generateTableRow(jj, mm, value);
            $tbody.append(tableRow);
            // Populate and configure the item dropdown
            configureItemDropdown(mm, value);
            // Populate and configure the UOM dropdown
            configureUomDropdown(mm, value);
        });
        // Update UI and calculate totals
        updateUI();
}

function generateTableRow(jj, mm, value) {
    return `
        <tr id="row${jj}">
            <td style="text-align:center;">${jj}</td>
            <td><select id="itemNameSl${mm}" class="select2 form-control form-control-lg eName" onchange="goodchanges(this)" name="row[${mm}][itemid]"></select></td>
            <td><select id="uom${mm}" class="select2 form-control uom" onchange="goodchanges(this)" name="row[${mm}][uom]"></select></td>
            <td><input type="text" name="row[${mm}][qauntity]" placeholder="Quantity" id="goodqty${mm}" value="${value.qty}" class="goodqty form-control" onkeyup="goodCalculateTotal(this)" onkeypress="return ValidateNum(event);"/></td>
            <td><input type="text" name="row[${mm}][unitprice]" placeholder="Price" id="goodprice${mm}" value="${value.price}" class="goodprice form-control" onkeyup="goodCalculateTotal(this)" onkeypress="return ValidateNum(event);"/></td>
            <td><input type="text" name="row[${mm}][total]" placeholder="Total" id="goodtotal${mm}" value="${value.Total}" class="goodtotal form-control" onkeypress="return ValidateNum(event);" readonly/></td>
            <td style="text-align:center;background-color:#efefef;">
                <a type="button"><i class="fa fa-info-circle text-primary viewiteminfo" title="Item Information"></i></a>
                <button type="button" class="btn btn-lignt btn-sm goodsremove-tr">
                    <i class="fa-sharp fa-solid fa-x" style="color: #f03000;"></i>
                </button>
            </td>
            <td style="display:none;">
                <input type="text" name="row[${mm}][vals]" id="directvals${mm}" class="goodsdirectvals form-control" readonly="true" style="font-weight:bold;" value="${mm}"/>
            </td>
        </tr>
    `;
}

function configureItemDropdown(mm, value) {
    const $itemDropdown = $(`#itemNameSl${mm}`);
    const options = $("#hiddenitem > option").clone(); // Clone hidden options
    const selectedOption = `<option selected value="${value.itemid}">${value.item}</option>`; // Create selected option
    // Append options, remove the selected one (if it exists), and re-append it as selected
    $itemDropdown.append(options);
    $(`#itemNameSl${mm} option[value='${value.itemid}']`).remove();
    $itemDropdown.append(selectedOption).select2();
}

function configureUomDropdown(mm, value) {
    const $uomDropdown = $(`#uom${mm}`);
    const uomOptions = $("#hiddenuom > option").clone(); // Clone hidden UOM options
    const selectedUom = `<option selected value="${value.uomid}">${value.uomname}</option>`; // Create selected UOM option
    // Append UOM options, remove the selected one (if it exists), and re-append it as selected
    $uomDropdown.append(uomOptions);
    $(`#uom${mm} option[value='${value.uomid}']`).remove();
    $uomDropdown.append(selectedUom).select2();
    // Disable all options except the selected one
    $uomDropdown.find('option').not(':selected').prop('disabled', true);
    // Prevent dropdown from opening if no other options are enabled
    $uomDropdown.on('select2:opening', function (e) {
        if ($(this).find('option:enabled').length <= 1) {
            e.preventDefault();
        }
    });
}

function updateUI() {
    const count = $("#goodsdynamictables > tbody tr").length;
    $('#directpricetable').show();
    $('#directnumberofItemsLbl').html(count);
    goodCalculateGrandTotal(); // Recalculate totals
}
    function directappendcommoditylist(params) {
        var jj=0;
        var reference=$('#reference').val();
        $("#directdynamicTablecommdity > tbody").empty();
        var readonly='';
        $.each(params, function (index, value) { 
            ++jj;
            ++mm;
            switch (reference) {
                case 'Direct':
                    readonly='';
                    break;
            
                default:
                        readonly='readonly';
                    break;
            }
            var tables='<tr id="row'+jj+'" class="financialevdynamic-commudity">'+
                '<td style="text-align:center;">'+jj+'</td>'+
                '<td><select id="itemNameSl'+mm+'" class="select2 form-control form-control-lg eName" onchange="directsourceVal(this)" name="fevrow['+mm+'][evItemId]"></select></td>'+
                '<td><select id="cropyear'+mm+'" class="select2 form-control cropyear" onchange="directsourceVal(this)" name="fevrow['+mm+'][evcropyear]"></select></td>'+
                '<td><select id="coffeproccesstype'+mm+'" class="select2 form-control coffeproccesstype" onchange="directsourceVal(this)" name="fevrow['+mm+'][coffeproccesstype]"></select></td>'+
                '<td style="width:6%;"><select id="directgrade'+mm+'" class="select2 form-control directgrade" onchange="directsourceVal(this)" name="fevrow['+mm+'][directgrade]"></select></td>'+
                '<td><select id="uom'+mm+'" class="select2 form-control directuom" onchange="directuomval(this)" name="fevrow['+mm+'][uom]"></select></td>'+
                '<td><input type="text" name="fevrow['+mm+'][qauntity]" placeholder="Enter quantity" id="directfevqauntity'+mm+'" value="'+value.qty+'" class="directfevqauntity form-control" onkeyup="directCalculateTotal(this)" onkeypress="return ValidateNum(event);"/></td>'+
                '<td><input type="text" name="fevrow['+mm+'][bagweight]" placeholder="Bag Weight" id="bagweight'+mm+'" value="'+value.bagweight+'"  class="bagweight form-control" onkeypress="return ValidateNum(event);" readonly/></td>'+
                '<td><input type="text" name="fevrow['+mm+'][totalkg]" placeholder="Total kg" id="totalkg'+mm+'" value="'+value.totalKg+'"  class="totalkg form-control" onkeypress="return ValidateNum(event);" readonly/></td>'+
                '<td><input type="text" name="fevrow['+mm+'][netkg]" placeholder="Net Kg" id="netkg'+mm+'" value="'+value.netkg+'" class="directnetkg form-control" onkeypress="return ValidateNum(event);" readonly/></td>'+
                '<td><input type="text" name="fevrow['+mm+'][ton]" placeholder="TOn" id="directon'+mm+'" value="'+value.ton+'" class="directon form-control" onkeypress="return ValidateNum(event);" readonly/></td>'+
                '<td><input type="text" name="fevrow['+mm+'][feresula]" placeholder="feresula" id="feresula'+mm+'" value="'+value.feresula+'" class="directferesula form-control" onkeypress="return ValidateNum(event);" readonly/></td>'+
                '<td><input type="text" name="fevrow['+mm+'][finalprice]" placeholder="price" id="directfinalprice'+mm+'" ondblclick="calculateaftervat(this)"; value="'+value.price+'" class="directfinalprice form-control"onkeyup="directCalculateTotal(this)" onkeypress="return ValidateNum(event);" '+readonly+'/></td>'+
                '<td><input type="text" name="fevrow['+mm+'][Total]" placeholder="Total" id="fevtotal'+mm+'" value="'+value.Total+'" class="directfevtotal form-control" onkeypress="return ValidateNum(event);" readonly/></td>'+
                '<td style="width:3%;text-align:center;background-color:#efefef;"><a type="button"><i class="fa fa-info-circle text-primary info-icon viewcommodityinfo" title="Price Information"></i></a><button type="button" class="btn btn-lignt btn-sm remove-tr"><i class="fa-sharp fa-solid fa-x" style="color: #f03000;"></i></button></td>'+
                '<td style="display:none;"><input type="hidden" name="fevrow['+mm+'][vals]" id="directvals'+mm+'" class="directvals form-control" readonly="true" style="font-weight:bold;" value="'+mm+'"/></td>'+
                '<td style="display:none;"><input type="hidden" name="fevrow['+mm+'][pdetid]" id="pdetid'+mm+'" value="'+value.id+'" class="pdetid form-control" readonly="true" style="font-weight:bold;"/></td>'+
            '</tr>';
            $("#directdynamicTablecommdity > tbody").append(tables);
            var options = $("#hiddencommudity > option").clone();
            var proccesstypeoption=$("#coffeeproccesstype > option").clone();
            var gradeoption=$("#coffeegrade > option").clone();
            var cropyearoption=$("#cropYear > option").clone();
            var uomoption=$("#uom > option").clone();
            var itemoptionsselected='<option selected value="'+value.supplyworeda+'">'+value.origin+'</option>';
            var cropyearselected='<option selected value="'+value.cropyear+'">'+value.cropyear+'</option>';
            var proccesstypeselected='<option selected value="'+value.proccesstype+'">'+value.proccesstype+'</option>';
            var uomselected='<option selected value="'+value.uomid+'" bagwieght="'+value.uombagweight+'" title="'+value.uomamount+'">'+value.uomname+'</option>';
            var gardeselected='<option selected value="'+value.grade+'">'+value.grade+'</option>';
            switch (reference) {
                case 'Direct':
                        $('#itemNameSl'+mm).append(options);
                        $("#itemNameSl"+mm+" option[value='"+value.supplyworeda+"']").remove();

                        $('#cropyear'+mm).append(cropyearoption);
                        $("#cropyear"+mm+" option[value='"+value.cropyear+"']").remove();

                        $('#directgrade'+mm).append(gradeoption);
                        $("#directgrade"+mm+" option[value='"+value.grade+"']").remove();

                        $('#coffeproccesstype'+mm).append(proccesstypeoption);
                        $("#coffeproccesstype"+mm+" option[value='"+value.proccesstype+"']").remove();
                    break;
            
                default:

                    break;
            }
            
            $('#itemNameSl'+mm).append(itemoptionsselected);
            $('#itemNameSl'+mm).select2();
            
            $('#cropyear'+mm).append(cropyearselected);
            $('#cropyear'+mm).select2();

            $('#directgrade'+mm).append(gardeselected);
            $('#directgrade'+mm).select2();

            $('#coffeproccesstype'+mm).append(proccesstypeselected);
            $('#coffeproccesstype'+mm).select2();

            $('#uom'+mm).append(uomoption);
            $("#uom"+mm+" option[value='"+value.uomid+"']").remove();
            $('#uom'+mm).append(uomselected);
            $('#uom'+mm).select2();
            $('#select2-directgrade'+mm+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
        });
        directCalculateGrandTotal();
        $('#directdynamicTablecommdity').show();
        var count=$("#directdynamicTablecommdity > tbody tr").length;
        $('#directpricetable').show();
        $('#directnumberofItemsLbl').html(count);
    }

    $(document).on('click', '.viewiteminfo, .goodsinfo', function () {
    const $icon = $(this);
    const itemId = $icon.hasClass('viewiteminfo') 
        ? $icon.closest('tr').find('.eName').val() || 0 
        : $icon.data('itemid');
    const store = $icon.hasClass('viewiteminfo') 
        ? $('#directwarehouse').val() || 0 
        : $('#storehidden').val() || 0;
    
    blockUI(cardSection, 'Loading Please Wait...');
    
    $.ajax({
        type: "GET",
        url: `{{ url('getgoodstorebalance') }}/${itemId}/${store}`,
        dataType: "json",
        complete: () => unblockUI(cardSection),
        success: function (response) {
            if (response.success) {
                const content = `
                    <strong>All Station:</strong> ${response.getAllQuantity}<br>
                    <strong>Selected Station:</strong> ${response.getQuantity}<br>
                `;
                
                if (!$icon.data('bs.popover')) {
                    $icon.popover({
                        html: true,
                        content: content,
                        trigger: 'manual',
                        placement: 'top',
                        container: 'body',
                    }).popover('show');
                } else {
                    $icon.popover('toggle');
                }
            }
        },
        error: function (xhr, status, error) {
            console.error('Error fetching item details:', error);
            toastrMessage('error', 'Failed to fetch item details. Please try again. ' + error, 'Error!');
        }
    });
});

// Hide popover when clicking outside
$(document).on('click', function (e) {
    if (!$(e.target).closest('.viewiteminfo, .goodsinfo').length) {
        $('.viewiteminfo, .goodsinfo').popover('hide');
    }
});

    // Clean up popovers on mouseleave
    $(document).on('mouseleave', '.info-icon', function () {
        $(this).popover('dispose');
    });

        $(document).on('mouseenter', '.viewcommodityinfo', function () {
        const $icon = $(this);
            var totalprice=$($icon).closest('tr').find('.directfevtotal').val()||0;
            var netkg=$($icon).closest('tr').find('.directnetkg').val()||0;
            var priceperkg=parseFloat(totalprice)/parseFloat(netkg);
            var calculatedtotalprice=parseFloat(priceperkg)*parseFloat(netkg);
            priceperkg=Number(priceperkg.toFixed(2));
            calculatedtotalprice=Number(calculatedtotalprice.toFixed(2));
            const formattedPricePerKg = priceperkg.toLocaleString(); // Format price per kg
            const formattedNetKg = netkg.toLocaleString(); // Format net kg
            const formattedTotalPrice = calculatedtotalprice.toLocaleString(); // Format total price
        // Check if the popover is already initialized
        if (!$icon.data('bs.popover')) {
            // Generate the dynamic popover content
            // const content = `
            //     <strong> ${priceperkg}<br>
            // `;
            const content = `
                    <strong>Price per kg:</strong> ${formattedPricePerKg}<br>
                    <strong>Net kg:</strong> ${formattedNetKg}<br>
                    <strong>Total Price:</strong> ${formattedTotalPrice}
                `;
            // Initialize the popover
            $icon.popover({
                html: true,
                content: content,
                trigger: 'manual', // Manual control
                placement: 'top',
                container: 'body',
            }).popover('show');
        }

    });

    // Handle mouseleave to hide the popover
    $(document).on('mouseleave', '.viewcommodityinfo', function () {
        $(this).popover('dispose'); // Completely remove the popover
    });

    function peappendcommoditylist(params) {
        var jj=0;
        $("#directdynamicTablecommdity > tbody").empty();
        $.each(params, function (index, value) { 
            ++jj;
            ++mm;
            var tables='<tr id="row'+jj+'" class="financialevdynamic-commudity">'+
                '<td style="text-align:center;">'+jj+'</td>'+
                '<td><select id="itemNameSl'+mm+'" class="select2 form-control form-control-lg eName" onchange="directsourceVal(this)" name="fevrow['+mm+'][evItemId]"></select></td>'+
                '<td><select id="cropyear'+mm+'" class="select2 form-control cropyear" onchange="directsourceVal(this)" name="fevrow['+mm+'][evcropyear]"></select></td>'+
                '<td><select id="coffeproccesstype'+mm+'" class="select2 form-control coffeproccesstype" onchange="directsourceVal(this)" name="fevrow['+mm+'][coffeproccesstype]"></select></td>'+
                '<td><select id="directgrade'+mm+'" class="select2 form-control directgrade" onchange="directsourceVal(this)" name="fevrow['+mm+'][directgrade]"></select></td>'+
                '<td><select id="uom'+mm+'" class="select2 form-control directuom" onchange="directuomval(this)" name="fevrow['+mm+'][uom]"></select></td>'+
                '<td><input type="text" name="fevrow['+mm+'][qauntity]" placeholder="Enter quantity" id="directfevqauntity'+mm+'" class="directfevqauntity form-control" onkeyup="directCalculateTotal(this)" onkeypress="return ValidateNum(event);"/></td>'+
                '<td><input type="text" name="fevrow['+mm+'][bagweight]" placeholder="Bag Weight" id="bagweight'+mm+'"  class="bagweight form-control" onkeypress="return ValidateNum(event);" readonly/></td>'+
                '<td><input type="text" name="fevrow['+mm+'][totalkg]" placeholder="Total kg" id="totalkg'+mm+'"  class="totalkg form-control" onkeypress="return ValidateNum(event);" readonly/></td>'+
                '<td><input type="text" name="fevrow['+mm+'][netkg]" placeholder="Net Kg" id="netkg'+mm+'"  class="directnetkg form-control" onkeypress="return ValidateNum(event);" readonly/></td>'+
                '<td><input type="text" name="fevrow['+mm+'][ton]" placeholder="TON" id="directon'+mm+'" class="directon form-control" onkeypress="return ValidateNum(event);" readonly/></td>'+
                '<td><input type="text" name="fevrow['+mm+'][feresula]" placeholder="feresula" id="feresula'+mm+'"  class="directferesula form-control" onkeypress="return ValidateNum(event);" readonly/></td>'+
                '<td><input type="text" name="fevrow['+mm+'][finalprice]" placeholder="price" id="directfinalprice'+mm+'" value="'+value.finalprice+'" ondblclick="calculateaftervat(this)"; class="directfinalprice form-control"onkeyup="directCalculateTotal(this)" onkeypress="return ValidateNum(event);" readonly/></td>'+
                '<td><input type="text" name="fevrow['+mm+'][Total]" placeholder="Total" id="fevtotal'+mm+'"  class="directfevtotal form-control" onkeypress="return ValidateNum(event);" readonly/></td>'+
                '<td style="width:3%;text-align:center;background-color:#efefef;"><a type="button"><i class="fa fa-info-circle text-primary info-icon viewcommodityinfo" title="Price Information" style="cursor: pointer;"></i></a><button type="button" class="btn btn-lignt btn-sm remove-tr"><i class="fa-sharp fa-solid fa-x" style="color: #f03000;"></i></button></td>'+
                '<td style="display:none;"><input type="hidden" name="fevrow['+mm+'][vals]" id="directvals'+mm+'" class="directvals form-control" readonly="true" style="font-weight:bold;" value="'+mm+'"/></td>'+
                '<td style="display:none;"><input type="hidden" name="fevrow['+mm+'][pdetid]" id="pdetid'+mm+'"  class="pdetid form-control" readonly="true" style="font-weight:bold;"/></td>'+
            '</tr>';

            $("#directdynamicTablecommdity > tbody").append(tables);
            var options = $("#hiddencommudity > option").clone();
            var proccesstypeoption=$("#coffeeproccesstype > option").clone();
            var gradeoption=$("#coffeegrade > option").clone();
            var cropyearoption=$("#cropYear > option").clone();
            var uomoption=$("#uom > option").clone();
            var itemoptionsselected='<option selected value="'+value.woredaid+'">'+value.supplyorigin+'</option>';
            var cropyearselected='<option selected value="'+value.cropyear+'">'+value.cropyear+'</option>';
            var proccesstypeselected='<option selected value="'+value.proccesstype+'">'+value.proccesstype+'</option>';
            var uomselected='<option selected value="'+value.uomid+'" title="'+value.uomamount+'">'+value.uomname+'</option>';
            var gardeselected='<option selected value="'+value.qualitygrade+'">'+value.qualitygrade+'</option>';
            // $('#itemNameSl'+mm).append(options);
            // $("#itemNameSl"+mm+" option[value='"+value.woredaid+"']").remove();
            $('#itemNameSl'+mm).append(itemoptionsselected);
            $('#itemNameSl'+mm).select2();
            
            // $('#cropyear'+mm).append(cropyearoption);
            // $("#cropyear"+mm+" option[value='"+value.cropyear+"']").remove();
            $('#cropyear'+mm).append(cropyearselected);
            $('#cropyear'+mm).select2();

            // $('#directgrade'+mm).append(gradeoption);
            // $("#directgrade"+mm+" option[value='"+value.qualitygrade+"']").remove();
            $('#directgrade'+mm).append(gardeselected);
            $('#directgrade'+mm).select2();

            // $('#coffeproccesstype'+mm).append(proccesstypeoption);
            // $("#coffeproccesstype"+mm+" option[value='"+value.proccesstype+"']").remove();
            $('#coffeproccesstype'+mm).append(proccesstypeselected);
            $('#coffeproccesstype'+mm).select2();
            
            $('#uom'+mm).append(uomoption);
            // $("#uom"+mm+" option[value='"+value.uomid+"']").remove();
            // $('#uom'+mm).append(uomselected);
            $('#uom'+mm).select2();
            $('#uom'+mm).select2({placeholder: "Select uom"});
            
        });
        
        $('#directdynamicTablecommdity').show();
        var count=$("#directdynamicTablecommdity > tbody tr").length;
        $('#directpricetable').show();
        $('#directnumberofItemsLbl').html(count);
    }

    function calculateaftervat(ele) {
    var value = $(ele).closest('tr').find('.directvals').val() || 0;

    $('#directfinalprice'+value).prop('readonly', true);
    // Initialize the popover
    $('#directfinalprice' + value).popover({
        trigger: "manual", // Manual trigger to control popover programmatically
        title: 'Unit Price With Vat',
        container: "body",
        sanitize: false, // Allow HTML in the popover content
        html: true,
        content: function () {
            return '<div>' +
                '<label for="vatInput' + value + '">Enter Price</label>' +
                '<input type="number" id="vatInput' + value + '" class="form-control" placeholder="Enter Price">' +
                '<button class="btn btn-primary btn-sm mt-2 applyVatBtn" data-value="' + value + '">Apply</button>' +
                '<button class="btn btn-danger btn-sm mt-2 cancelVatBtn" data-value="' + value + '">Cancel</button>' +
                '</div>';
        }
    });

    // Toggle popover visibility on double-click
    $('#directfinalprice' + value).on('dblclick', function () {
        const $this = $(this);
        const popoverVisible = $this.next('.popover').is(':visible'); // Check visibility

        if (popoverVisible) {
            $this.popover('hide'); // Hide the popover if visible
        } else {
            $this.popover('show'); // Show the popover otherwise

            // Focus the input field inside the popover after it's shown
            setTimeout(function () {
                $('#vatInput' + value).focus();
            }, 100); // Timeout to ensure the popover is fully rendered
        }
    });

    // Handle the "Apply" button click inside the popover
    $(document).off('click', '.applyVatBtn').on('click', '.applyVatBtn', function () {
        const button = $(this);
        const value = button.data('value'); // Get the unique value associated with the button
        const vatValue = $('#vatInput' + value).val(); // Get the value of the input field


        handleApply(vatValue,value);
        // Assign the VAT value to other fields (replace field IDs as needed)

    });

    // Handle the "Cancel" button click
    $(document).off('click', '.cancelVatBtn').on('click', '.cancelVatBtn', function () {
        const button = $(this);
        const value = button.data('value'); // Get the unique value associated with the button

        // Hide the popover
        $('#directfinalprice' + value).popover('hide');
        $('#directfinalprice'+value).prop('readonly', false);
    });

    $(document).off('keydown', '#vatInput' + value).on('keydown', '#vatInput' + value, function (e) {
         const vatValue = $('#vatInput' + value).val(); // Get the value of the input field
        if (e.key === 'Enter') {
            handleApply(vatValue,value);
        }
    });

    // Optional: Hide the popover when clicking outside the popover or input element
    $(document).on('click', function (e) {
        if (!$(e.target).closest('#directfinalprice' + value).length && !$(e.target).closest('.popover').length) {
            $('#directfinalprice' + value).popover('hide');
            $('#directfinalprice'+value).prop('readonly', false);
        }
    });
}

    function handleApply(vatValue,value){

                // Validate input to ensure it's a valid number
            if (!vatValue || isNaN(vatValue)) {
                toastrMessage('error','Please enter a valid number','Error!');
                return;
            } else
                {
                var feresula=$('#feresula'+value).val()||0;
                var aftervat=parseFloat(vatValue)/1.15;
                    aftervat=Number(aftervat.toFixed(2));
                    var total=parseFloat(aftervat)*parseFloat(feresula);
                    total=Number(total.toFixed(2));
                    $('#directfinalprice'+value).val(aftervat);
                    $('#fevtotal'+value).val(total);
                    directCalculateGrandTotal();
                    // Hide the popover after applying the value
                    $('#directfinalprice' + value).popover('hide');
                    $('#directfinalprice'+value).prop('readonly', false);
            }
    }

    function directsourceVal(ele) {
            var idval = $(ele).closest('tr').find('.directvals').val();
            var inputid = ele.getAttribute('id');
            var cropyear=$(ele).closest('tr').find('.cropyear').val();
            var proccestype=$(ele).closest('tr').find('.coffeproccesstype').val();
            var item = $(ele).closest('tr').find('.eName').val();
            var grade=$(ele).closest('tr').find('.directgrade').val();
            var commuditycnt=0;
            switch (inputid) {
                    case 'itemNameSl'+idval:
                        for(var k=1;k<=mm;k++){
                            if(($('#itemNameSl'+k).val())!=undefined){
                                if((parseInt($('#itemNameSl'+k).val()) == parseInt(item)) && (parseInt($('#cropyear'+k).val()) == parseInt(cropyear))  && ($('#coffeproccesstype'+k).val()==proccestype) && ($('#directgrade'+k).val()==grade)){
                                    commuditycnt+=1;
                                }
                            }
                        }
                        if(parseInt(commuditycnt)<=1){
                                $('#select2-itemNameSl'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
                            }
                        else if(parseInt(commuditycnt)>1){
                                $('#itemNameSl'+idval).val('').trigger('change').select2
                                ({
                                    placeholder: "Select proccess type",
                                });
                                $('#select2-itemNameSl'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                                toastrMessage('error',"Commodity type selected with all property","Error");
                            }
                    break;
                            
                    case 'cropyear'+idval:
                            for(var k=1;k<=mm;k++){
                                if(($('#cropyear'+k).val())!=undefined){
                                    if((parseInt($('#itemNameSl'+k).val()) == parseInt(item)) && (parseInt($('#cropyear'+k).val()) == parseInt(cropyear))  && ($('#coffeproccesstype'+k).val()==proccestype) && ($('#directgrade'+k).val()==grade)){
                                        commuditycnt+=1;
                                    }
                                }
                            }
                            if(parseInt(commuditycnt)<=1){
                                    $('#select2-cropyear'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
                                }
                            else if(parseInt(commuditycnt)>1){
                                    $('#cropyear'+idval).val('').trigger('change').select2
                                    ({
                                        placeholder: "Select proccess type",
                                    });
                                    $('#select2-cropyear'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                                    toastrMessage('error',"Crop year selected with all property","Error");
                                }
                    break;
                    case 'coffeproccesstype'+idval:
                            for(var k=1;k<=mm;k++){
                                if(($('#coffeproccesstype'+k).val())!=undefined){
                                    if((parseInt($('#itemNameSl'+k).val()) == parseInt(item)) && (parseInt($('#cropyear'+k).val()) == parseInt(cropyear))  && ($('#coffeproccesstype'+k).val()==proccestype) && ($('#directgrade'+k).val()==grade)){
                                        commuditycnt+=1;
                                    }
                                }
                            }
                            if(parseInt(commuditycnt)<=1){
                                    $('#select2-coffeproccesstype'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
                                }
                            else if(parseInt(commuditycnt)>1){
                                    $('#coffeproccesstype'+idval).val('').trigger('change').select2
                                    ({
                                        placeholder: "Select proccess type",
                                    });
                                    $('#select2-coffeproccesstype'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                                    toastrMessage('error',"Proccess type selected with all property","Error");
                                }
                    break;
                    
                    case 'directgrade'+idval:
                                for(var k=1;k<=mm;k++){
                                    if(($('#coffeproccesstype'+k).val())!=undefined){
                                        if((parseInt($('#itemNameSl'+k).val()) == parseInt(item)) && (parseInt($('#cropyear'+k).val()) == parseInt(cropyear))  && ($('#coffeproccesstype'+k).val()==proccestype) && ($('#directgrade'+k).val()==grade)){
                                            commuditycnt+=1;
                                            }
                                        }
                                    }
                                    if(parseInt(commuditycnt)<=1){
                                            $('#select2-directgrade'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
                                        }
                                    else if(parseInt(commuditycnt)>1){
                                            $('#directgrade'+idval).val('').trigger('change').select2
                                            ({
                                                placeholder: "Select Grade",
                                            });
                                            $('#select2-directgrade'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                                            toastrMessage('error',"Proccess type selected with all property","Error");
                                        }
                    break;
                default:
                    break;
            }
    }

        function commoditylist(pe,tables) {
        $('#'+tables).DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: false,
            paging: false,
            ordering:false,
            info: false,
            searchHighlight: true,
            destroy:true,
            autoWidth:false,
            
            "pagingType": "simple",
            order: [[ 0, "desc" ]],
            language: { search: '', searchPlaceholder: "Search here"},
            "dom": "<'row'<'col-lg-6 col-md-10 col-xs-8'f><'col-lg-1 col-md-2 col-xs-8'>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
            ajax: {
                url: "{{ url('getpordersupplierdatas') }}/"+pe,                   
                type: 'GET',
            },
            columns: [
                {data:'DT_RowIndex',width:'2%'},
                {data: 'supplierid',name: 'supplierid','visible':false,width:'3%'},
                {data: 'customername',name: 'customername','visible':true,width:'15%'},
                {data: 'recievedate',name: 'recievedate',width:'10%'},
                {data: 'supplyorigin',name: 'supplyorigin', 'visible':false,width:'17%'},
                {data: 'cropyear',name: 'cropyear',width:'5%',visible:false},
                {data: 'finalprice',name: 'finalprice',width:'3%'},
                {data: 'rank',name: 'rank',width:'3%'},
                {data: 'dense_rank',name: 'dense_rank',width:'3%',visible:false},
                {data: 'row_number',name: 'row_number',width:'3%',visible:false},
            ],
            
            rowGroup: {
                startRender: function ( rows, group,level) {
                        var color = 'style="color:black;font-weight:bold;"';
                        if(level===0){
                            
                            return $('<tr ' + color + '/>')
                            .append('<th colspan="15" style="text-align:left;solid;background:#ccc; font-size:12px;">Commodity:'+group+'</th>')
                        }
                        else{
                            return $('<tr ' + color + '/>')
                            .append('<th colspan="9" style="text-align:left;solid;background:#f2f3f4;font-size:12px;">Customer: ' + group + '</th>')
                        }
                    },
                dataSrc: 'supplyorigin'
                },
                drawCallback: function(settings) {
                var api = this.api();
                var currentIndex = 1;
                var currentGroup = null;
                api.rows({ page: 'current', search: 'applied' }).every(function() {
                    var rowData = this.data();
                    if (rowData) {
                        var group = rowData['supplyorigin']; // Assuming 'group_column' is the name of the column used for grouping
                        if (group !== currentGroup) {
                            currentIndex = 1; // Reset index for a new group
                            currentGroup = group;
                        }
                        $(this.node()).find('td:first').text(currentIndex++);
                    }
                });
            }
        });
        }
        function orderlist() {
            pordertables=$('#purchaordetables').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                fixedHeader: true,
                searchHighlight: true,
                destroy:true,
                autoWidth:false,
                lengthMenu: [[50, 100], [50, 100]],
                "pagingType": "simple",
                language: { search: '', searchPlaceholder: "Search here"},
                dom:'<"row mt-75"' +
                '<"col-lg-12 col-xl-6" f>' +
                '<"col-lg-12 col-xl-6 pl-xl-75 pl-0"<"dt-action-buttons text-xl-right text-lg-left text-md-right text-left d-flex align-items-center justify-content-lg-end align-items-center flex-sm-nowrap flex-wrap mr-1 mt-2"<"mr-1">B>>' +
                '>t' +
                '<"d-flex justify-content-between mx-2 row mb-1"' +
                '<"col-sm-12 col-md-3"i>' +'<"col-sm-12 col-md-6">' +
                '<"col-sm-12 col-md-3"p>' +
                '>',
                
                buttons : [
                        {
                                text: '<i data-feather="plus"></i> Add',
                                className: 'btn btn-gradient-info btn-sm addbutton',
                                action: function (e, dt, node, config) {
                                    // Button action
                                },
                                init: function (api, node, config) {
                                    // Remove default classes if permission is not granted
                                    // if (!@json(auth()->user()->can('PO-Add'))) {
                                    //     $(node).hide();
                                    // }
                                }
                        }
                    ],
                ajax: {
                url: "{{ url('purchaseordelist') }}",
                type: 'GET',
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
                    setFocus();
                },
                },
                columns: [
                    { data:'DT_RowIndex'},
                    { data: 'porderno', name: 'porderno' },
                    { data: 'purchaseordertype', name: 'purchaseordertype' },
                    { data: 'type', name: 'type' },
                    { data: 'documentumber', name: 'documentumber' },
                    { data: 'supllier', name: 'supllier' },
                    { data: 'TIN', name: 'TIN' },
                    { data: 'orderdate', name: 'orderdate' },
                    { data: 'deliverydate', name: 'deliverydate' },
                    { data: 'netpay', name: 'netpay',render: $.fn.dataTable.render.number(',', '.', 2, '')},
                    { data: 'status', name: 'status' },
                    { data: 'id', name: 'id',orderable: false,'width': '3%' },
                    { data: 'peid', name: 'peid',visible:false },
                ],
                columnDefs: [
                                {
                                    targets: 4,
                                    render: function ( data, type, row, meta ) {
                                        switch (row.type) {
                                            case 'Direct':
                                                return '';
                                                break;
                                        
                                            default: 
                                                var peviewpermit= $('#purchasevualationviewpermission').val();
                                                var links='';
                                                
                                                switch (peviewpermit) {
                                                    case '1':
                                                        links = '<a href="#" onclick="viewpeinformation('+row.peid+');"><u>'+data+'</u></a>';
                                                        
                                                        break;
                                                
                                                    default: 
                                                        return data;
                                                        break;
                                                }
                                                return links
                                                break;
                                        }
                                    }
                                },
                                {
                                    targets: 10,
                                    render: function ( data, type, row, meta ) {
                                        switch (data) {
                                                case 0:
                                                    return '<span class="text-secondary font-weight-medium"><b>Draft</b></span>';
                                                    break;
                                                case 1:
                                                        return '<span class="text-warning font-weight-medium"><b>Pending</b></span>';
                                                    break;
                                                case 2:
                                                        return '<span class="text-primary font-weight-medium"><b>Verified</b></span>';
                                                    break;
                                                case 3:
                                                        return '<span class="text-success font-weight-medium"><b>Approved</b></span>';
                                                    break;
                                                case 4:
                                                        return '<span class="text-danger font-weight-medium"><b>Void</b></span>';
                                                    break;
                                                case 5:
                                                        return '<span class="text-danger font-weight-medium"><b>Rejected</b></span>';
                                                break;
                                                case 6:
                                                        return '<span class="text-danger font-weight-medium"><b>Review</b></span>';
                                                break;
                                                case 7:
                                                        return '<span class="text-primary font-weight-medium"><b>Reviewed</b></span>';
                                                break;
                                            default:
                                                    return '--';
                                                break;
                                        }
                                        
                                    }
                                },
                                {
                                    targets: 11,
                                    render: function ( data, type, row, meta ) {
                                        var anchor='<a class="DocPrInfo" href="javascript:void(0)" data-id='+data+' title="View sales"><i class="fa-sharp fa-regular fa-circle-info fa-xl" style="color: #00cfe8;"></i></a>';
                                        return anchor;
                                    }
                                },
                        ],
                });
        }
        
        $('.filter-select').change(function(){
                var search = [];
                $.each($('.filter-select option:selected'), function(){
                    search.push($(this).val());
                    });
                search = search.join('|');
                pordertables.column(8).search(search, true, false).draw(); 
        });
        $('.itemfilter-select').change(function(){
                var search = [];
                $.each($('.itemfilter-select option:selected'), function(){
                    search.push($(this).val());
                    });
                search = search.join('|');
                pordertables.column(2).search(search, true, false).draw(); 
        });

        function setFocus(){ 
            $($('#purchaordetables tbody > tr')[maingblIndex]).addClass('selected');  
        }
    $('#purchaordetables tbody').on('click', 'tr', function () {
            $('#purchaordetables tbody > tr').removeClass('selected');
            $(this).addClass('selected');
            maingblIndex = $(this).index();
    });

        $('#poprintbutton').click(function(){
            var id=$('#recordIds').val();
            var link="/directpoattachemnt/"+id;
            window.open(link, 'Purchase Order', 'width=1200,height=800,scrollbars=yes');
        });

        $('#supplierpoprintbutton').click(function(){
            var headerid=$('#recordIds').val();
            var supplierid=$('#supplierrecordIds').val();
            var link="/suppliierdirectpoattachemnt/"+headerid+"/"+supplierid;
            window.open(link, 'Purchase Order', 'width=1200,height=800,scrollbars=yes');
        });

        $('#popending').click(function(){
            var id=$('#recordIds').val();
            confirmAction(id,1);
        });
        $('#poverify').click(function(){
            var id=$('#recordIds').val();
            confirmAction(id,2);
        });
        $('#poapproved').click(function(){
            var id=$('#recordIds').val();
            confirmAction(id,3);
        });
        $('#poundovoidbuttoninfo').click(function(){
            var id=$('#recordIds').val();
            confirmAction(id,4);
        });

        $('#poundorejectbuttoninfo').click(function(){
            var id=$('#recordIds').val();
            confirmAction(id,5);
        });

        $('#poreview').click(function(){
            var id=$('#recordIds').val();
            confirmAction(id,6);
        });
        $('#undoporeview').click(function(){
            var id=$('#recordIds').val();
            confirmAction(id,7);
        });
        function confirmAction(id,status) {
        var msg='--';
        var title='--';
        var buttontext='--';
        switch (status) {
                case 1:
                    msg='Are you sure do you want to pending';
                    title='Confirmation';
                    buttontext='Pending';
                break;
                case 2:
                    msg='Are you sure do you want to verify';
                    title='Confirmation';
                    buttontext='Verify';
                break;
                case 3:
                    msg='Are you sure do you want to approve';
                    title='Confirmation';
                    buttontext='Approve';
                break;
                case 4:
                    msg='Are you sure do you want to undo void';
                    title='Confirmation';
                    buttontext='Undo void';
                break;
                case 5:
                    msg='Are you sure do you want to undo reject';
                    title='Confirmation';
                    buttontext='Undo Reject';
                break;
                case 6:
                    msg='Are you sure do you review';
                    title='Confirmation';
                    buttontext='Review';
                break;
                case 7:
                    msg='Are you sure do you undo review';
                    title='Confirmation';
                    buttontext='Undo Review';
                break;
            default:
                msg='whoops';
                title='whoops';
                buttontext='whoops';
                break;
        }
            swal.fire({
                title: title,
                icon: 'question',
                html: msg,
                showCancelButton: !0,
                allowOutsideClick: false,
                confirmButtonClass: "btn-info",
                confirmButtonText: buttontext,
                cancelButtonText: "Cancel",
                cancelButtonClass: "btn-danger",
                reverseButtons: !0
        }).then(function (e) {
            if (e.value === true) {
                let token = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        type: 'GET',
                        url:  "{{url('podirectaction')}}/" + id+'/'+status,
                        data: {_token: token},
                        success: function (resp) {
                            switch (resp.success) {
                                case 200:
                                    toastrMessage('success',resp.message,'success');
                                    showbuttondependonstat(resp.pno,resp.status,'Direct');
                                    setminilog(resp.actions);
                                    switch (resp.status) {
                                        case 3:
                                            modalhider();
                                            break;
                                            default:
                                            
                                            break;
                                        }
                                    break;
                                    case 201:
                                        toastrMessage('error','Please fill all the technical feild evaluatins','Error');
                                    break;
                                default:
                                        swal.fire("Whoops!", 'Something went wrong please contact support team.', "error");
                                    break;
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
    function modalhider() {
        var oTable = $('#purchaordetables').dataTable(); 
        oTable.fnDraw(false);
        $('#docInfoModal').modal('hide');
    }
        $('body').on('click', '.DocPrInfo', function () {
                var recordId = $(this).data('id');
                $('#recordIds').val(recordId);
                poinformations(recordId);
        });
    function poinformations(recordId) {
            var status='';
            var type='';
            var purchaseordertype='';
            var poid='';
            var pono='';
            var peno='';
            var peid='';
            $.ajax({
            type: "GET",
            url: "{{ url('poinfo') }}/"+recordId,
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
                        $("#collapseOne").collapse('show');
                        $('#docInfoModal').modal('show');
                    },
            success: function (response) {
                    peno=response.pedocno;
                    
                    $('#infodocumentdate').html(response.createdAtInAddisAbaba);
                    $.each(response.po, function (index, value) { 
                        $('#inforefernce').html(value.type);
                        $('#infopo').html(value.porderno);
                        $('#infopotype').html(value.purchaseordertype);
                        $('#inforderdate').html(value.orderdate);
                        $('#infodeliverdate').html(value.deliverydate);
                        $('#infopaymenterm').html(value.paymenterm);
                        $('#directinfosubtotalLbl').html(numformat(value.subtotal));
                        $('#directinfotaxLbl').html(numformat(value.tax));
                        $('#directinfograndtotalLbl').html(numformat(value.grandtotal));
                        $('#directinfowitholdingAmntLbl').html(numformat(value.withold));
                        $('#directinfovatAmntLbl').html(value.withold);
                        $('#directinfonetpayLbl').html(numformat(value.netpay));
                        $('#infocommoditype').html(value.commudtytype);
                        $('#infocommoditysource').html(value.commudtysource);
                        $('#infocommoditystatus').html(value.commudtystatus);
                        $('#purchaseorderinfomemo').html(value.memo);
                        $('#storehidden').val(value.store);
                        
                        status=value.status;
                        type=value.type;
                        purchaseordertype=value.purchaseordertype;
                        poid=value.id;
                        pono=value.porderno;
                        peid=value.purchasevaulation_id;
                        switch (value.istaxable) {
                            case 1:
                                $('#supplierinfotaxtr').show();
                                $('#supplierinforandtotaltr').show();
                                break;
                            default:
                                $('#supplierinfotaxtr').hide();
                                $('#supplierinforandtotaltr').hide();
                                break;
                        }
                        if(parseFloat(value.subtotal)>=10000){
                            $('#visibleinfowitholdingTr').show();
                            $('#directinfonetpayTr').show();
                        }
                        else{
                            $('#visibleinfowitholdingTr').hide();
                            $('#directinfonetpayTr').hide();
                        }
                    });
                    $.each(response.customer, function (index, value) { 
                        $('#infosuppid').html(value.Code);
                        $('#infsupname').html(value.Name);
                        $('#infosupptin').html(value.TinNumber);
                    });
                    
                    switch (type) {
                    case 'Direct':
                    case 'PE':
                            peno = (peno === undefined || peno === null || peno === '' || peno === '--') ? 'EMPTY' : peno;
                            switch (peno) {
                                case 'EMPTY':
                                    $('.infopetr').hide();
                                    break;
                                default:
                                    var peviewpermit= $('#purchasevualationviewpermission').val();
                                    var links='';
                                    $('.infopetr').show();
                                    switch (peviewpermit) {
                                        case '1':
                                            links = '<a href="#" onclick="viewpeinformation('+peid+');"><u>'+peno+'</u></a>';
                                            break;

                                        default: 
                                            links=peno;
                                            break;
                                    }
                                    
                                    $('#infope').html(links);
                                    ;
                                    break;
                            }
                            $('#directcommuditylistdatabledivinfo').show();
                            $('#directsupplyinformationdiv').show();
                            $('.infodirect').show();
                            $('#directfooter').show();
                            $('#ulist').show();
                            $('#ulistsupplier').hide();
                            $('#pefooter').hide();
                            $('#commuditylistdatabledivinfo').hide();
                            $('#supplyinformationdiv').hide();
                            $('#itemsdatabledivinfo').hide();
                            $('#infowarehouse').html(response.storename);
                            switch (purchaseordertype) {
                                case 'Goods':
                                        $('.directdivider').html('Item List');
                                        $('.directcommudityinfodatatablesdiv').hide();
                                        $('.cmdtyclass').hide();
                                        $('.directgoodsinfodatatablesdiv').show();
                                        directgoodlist(poid);
                                    break;
                            
                                default:
                                        $('.directdivider').html('Commodity List');
                                        $('.directgoodsinfodatatablesdiv').hide();
                                        $('.cmdtyclass').show();
                                        $('.directcommudityinfodatatablesdiv').show();
                                        directcommoditylist(poid);
                                    break;
                            }
                        break;
                        
                    default: 
                        $('.directdivider').html('Supplier Purchase order list');
                        $('#supplyinformationdiv').show();
                        $('#pefooter').show();
                        $('.infopetr').show();
                        $('#ulistsupplier').show();
                        $('#ulist').hide();
                        $('.infodirect').hide();
                        $('#directfooter').hide();
                        $('#directsupplyinformationdiv').hide();
                    switch (type) {
                                case "Goods":
                                    console.log('goods');
                                        $('.directgoodsinfodatatablesdiv').show();
                                        $('.directcommudityinfodatatablesdiv').hide();
                                    break;
                            
                                default: 
                                    console.log('Commodity');
                                    
                                    $('.directgoodsinfodatatablesdiv').hide();
                                    $('.commuditylistdatabledivinfodiv').show();
                                    var tables='comuditydocInfoItem';
                                    directcommoditylist(poid);
                                    break;
                            }
                            $('#directcommuditylistdatabledivinfo').hide();
                        break;
                }
                
                showbuttondependonstat(pono,status,type);
                setminilog(response.actions);
            }
        });
    }
    function viewpeinformation(id) {
            var prstatus=0;
            var peid=0;
            var documentumber='';
            var status='';
            var petype='';
            $.ajax({
            type: "GET",
            url: "{{ url('peinfo') }}/"+id,
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
                        
                        $("#pevualtioncollapseOne").collapse('show');
                        $('#pevualtiondocInfoModal').modal('show');
                        
                    },
            success: function (response) {
                    $('#peinfostation').html(response.storename);
                $.each(response.pr, function (indexInArray, valueOfElement) { 
                    peid=valueOfElement.id;
                    $('#perecordIds').val(valueOfElement.id);
                    $('#peevelautestatus').val(valueOfElement.status);
                    $('#peinfope').html(valueOfElement.documentumber);
                    $('#peinforefernce').html(valueOfElement.petype);
                    $('#peinfotype').html(valueOfElement.type);
                    $('#peinfodocumentdate').html(valueOfElement.date);
                    $('#peinfocommoditype').html(valueOfElement.commudtytype);
                    $('#peinfocommoditysource').html(valueOfElement.coffeesource);
                    $('#peinfocommoditystatus').html(valueOfElement.coffestat);
                    $('#peinfosample').html(valueOfElement.samplerequire);
                    $('#peinfoStatus').html('<span class="text-success font-weight-medium"><b> '+valueOfElement.documentumber+' Approved </b>');
                    switch (valueOfElement.priority) {
                        case 1:
                            $('#peinfopriority').html('High');
                            break;
                        case 2:
                            $('#peinfopriority').html('Medium');
                            break;
                        default:
                            $('#peinfopriority').html('Low');
                            break;
                    }
                    prstatus=valueOfElement.status;
                    switch (valueOfElement.petype) {
                        case 'Direct':
                                $('#preditbutton').hide();
                                $('#trinforfq').hide();
                                setrequesteditemlabel(valueOfElement.id,valueOfElement.type,valueOfElement.petype);
                                switch (valueOfElement.type) {
                                    case 'Goods':
                                        $('#itemsdatablediv').show();
                                        $('#commuditylistdatablediv').hide();
                                        
                                        break;
                                    default:
                                        $('#itemsdatablediv').hide();
                                        $('#commuditylistdatablediv').show();
                                    break;
                                }
                            break;
                        default:
                            $('#trinforfq').show();
                            var tables='#perequesteditemdatatablesoninfo';
                            getrequesteditem(tables,valueOfElement.id,valueOfElement.type,valueOfElement.petype);
                                switch (valueOfElement.type) {
                                    case 'Goods':
                                        $('#itemsdatablediv').show();
                                        $('#commuditylistdatablediv').hide();
                                        
                                        break;
                                    default:
                                        $('#itemsdatablediv').hide();
                                        $('#commuditylistdatablediv').show();
                                        break;
                                }
                            break;
                    }
                    showsupplier(valueOfElement.id);
                    documentumber=valueOfElement.documentumber;
                    status=valueOfElement.status;
                    petype=valueOfElement.petype;
                });
                $('#inforfq').html(response.rfq);
                if (response.supplier.length === 0) {
                    initationcommuditylist(peid);
                }
                else{
                    setsupplierbytab(response.supplier,prstatus);
                    showdataonthestatus(prstatus);
                }
                pesetminilog(response.actions);
            }
        });
    }
    function infopelistbytab(params) {
            var headerid=$('#perecordIds').val();
            var id=$('#peevalsupplierid').val();
            var status=$('#peevalstatus').val();
            switch (params) {
                case 'peview':
                    break;
                    case 'teview':
                        commuditylistoftechnicalview(headerid,id);
                    break;
                default:    
                        commuditylistoffinancialview(headerid,id);
                        console.log('status='+status);
                    break;
            }
        }
    function pesetminilog(actions) {
        var list='';
        var icons=''
        var reason='';
        var addedclass='';
        $('#peulist').empty();
        $.each(actions, function (index, value) { 
            switch (value.status) {
                case 'Pending':
                        icons='warning timeline-point';
                        addedclass='text-warning';
                        switch (value.action) {
                            case 'Back to pending':
                                reason='<p class="text-muted"><b><u>Reason:</u></b>'+value.reason+'.</p>';
                                break;
                            default:
                                reason='';
                                break;
                        }
                break;
                case 'Draft':
                        icons='secondary timeline-point';
                        addedclass='text-secondary';
                        switch (value.action) {
                            case 'Back To Draft':
                                reason='<p class="text-muted"><b><u>Reason:</u></b>'+value.reason+'.</p>';
                                break;
                        
                            default:
                                reason='';
                                break;
                        }
                break;
                case 'Approved':
                        icons='success timeline-point';
                        addedclass='text-success';
                break;
                case 'Confirm':
                        icons='success timeline-point';
                        addedclass='text-success';
                break;
                case 'Change To TE':
                        icons='primary timeline-point';
                        addedclass='text-primary';
                break;
                case 'Change To FE':
                        icons='warning timeline-point';
                        addedclass='text-warning';
                break;
                case 'Back To FE':
                        icons='warning timeline-point';
                        addedclass='text-warning';
                        reason='<p class="text-muted"><b><u>Reason:</u></b>'+value.reason+'.</p>';
                break;
                case 'Back To TE':
                        icons='warning timeline-point';
                        addedclass='text-warning';
                        reason='<p class="text-muted"><b><u>Reason:</u></b>'+value.reason+'.</p>';
                break;
                case 'TE Inserted':
                        icons='warning timeline-point';
                        addedclass='text-warning';
                break;
                
                case 'Edited':
                        icons='warning timeline-point';
                        addedclass='text-warning';
                break;
                case 'Verify':
                    icons='primary timeline-point';
                    addedclass='text-primary';
                    switch (value.action) {
                        case 'Back To Verify':
                            reason='<p class="text-muted"><b><u>Reason:</u></b>'+value.reason+'.</p>';
                            break;
                    
                        default:
                            reason='';
                            break;
                    }
                    
                    
                break;
                case 'Back To TE':
                case 'Back To FE':
                case 'Changed To TE':
                case 'Changed To FE':
                    icons='warning timeline-point';
                    addedclass='text-warning';
                    reason='';
                break;
                case 'Approve':
                    icons='success timeline-point';
                    addedclass='text-success';
                    reason='';
                    break;
                case 'Authorize':
                    icons='success timeline-point';
                    addedclass='text-success';
                    reason='';
                break;
                case 'Finished TE':
                case 'Finished FE':
                    icons='primary timeline-point';
                    addedclass='text-primary';
                    reason='';
                break;
                
                case 'Void':
                    icons='danger timeline-point';
                    addedclass='text-danger';
                    reason='<p class="text-muted"><b><u>Reason:</u></b>'+value.reason+'.</p>';
                    break;
                case 'Rejected':
                    icons='danger timeline-point';
                    addedclass='text-danger';
                    reason='<p class="text-muted"><b><u>Reason:</u></b>'+value.reason+'.</p>';
                break;
                default:
                    icons='danger timeline-point';
                    addedclass='text-danger';
                    reason='';
                    break;
            }
            list+='<li class="timeline-item"><span class="timeline-point timeline-point-'+icons+' timeline-point-indicator"></span><div class="timeline-header mb-sm-0 mb-0"><h6 class="mb-0 '+addedclass+'">'+value.action+'</h6><span class="text-muted"><i class="fa-regular fa-user"></i>'+value.user+'</span></br><span class="text-muted"><i class="fa-regular fa-clock"></i> '+value.time+'</span>'+reason+'</div></li>';
        });
        $('#peulist').append(list);
    }
    
    function setrequesteditemlabel(peid, type,reference) {
        var tables='#perequesteditemdatatablesoninfo';
        switch (reference) {
            case 'Direct':
                    switch (type) {
                    case 'Goods':
                        $('#requesteditemlabel').html('Requested item');
                        getrequesteditem(tables,peid,type,reference);
                        break;
                    default:
                        $('#requesteditemlabel').html('Requested Commodity');
                        getrequesteditem(tables,peid,type,reference);
                        break;
                }
                break;
            default:
                switch (type) {
                    case 'Goods':
                        $('#requesteditemlabel').html('Requested item');
                        getrequesteditem(tables,peid,type,reference);
                        break;
                    default:
                        $('#requesteditemlabel').html('Requested Commodity');
                        getrequesteditem(tables,peid,type,reference);
                        break;
                }
                break;
        }
    }
    function getrequesteditem(tables,peid,type,reference) {
        switch (reference) {
            case 'Direct':
                    switch (type) {
                        case 'Goods':  
                                $('#requesteditemlabeladd').html('Requested Goods');
                            break;
                        
                        default:
                                $('#requesteditemlabeladd').html('Requested Commodity');
                                
                            break;
                    }
                    setableslabel(type,reference);
                break;
            default:
                    setableslabel(type,reference);
                break;
        }
        $(tables).DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: true,
            paging: false,
            ordering:false,
            info: false,
            searchHighlight: true,
            destroy:true,
            autoWidth:false,
            "pagingType": "simple",
            order: [[ 0, "desc" ]],
            language: { search: '', searchPlaceholder: "Search here"},
            "dom": "<'row'<'col-lg-6 col-md-10 col-xs-4'f><'col-lg-2 col-md-2 col-xs-8'>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
            ajax: {
                url: "{{ url('requesteditems') }}/"+peid+"/"+reference+"/"+type,                   
                type: 'GET',
            },
            columns: [
                {data:'DT_RowIndex',"width": "1%"},
                {data: 'col1',name: 'col1',"width": "30%"},
                {data: 'col2',name: 'col2','width':'10%'},
                {data: 'col3',name: 'col3',"width": "10%"},
            ],
        });
    }
    function setableslabel(type,reference) {
            switch (reference) {
                case 'Direct':
                        switch (type) {
                            case 'Goods':
                                $('#requesteditemlabeladd').html('Requested Goods');
                                $('#evrequesteditemlabeladd').html('Requested Goods');
                                $('.reqtabl1').text('Code-Name');
                                $('.reqtabl2').text('SKU');
                                $('.reqtabl3').text('QTY');
                                
                                break;
                            default:
                                $('#requesteditemlabeladd').html('Requested Commodity');
                                $('#evrequesteditemlabeladd').html('Requested Commodity');
                                $('.reqtabl1').text('Commodity');
                                $('.reqtabl2').text('Crop year');
                                $('.reqtabl3').text('Process Type');
                                break;
                        }
                    break;
                default: 
                        switch (type) {
                            case 'Goods':
                                $('#requesteditemlabeladd').html('Requested Goods');
                                $('#evrequesteditemlabeladd').html('Requested Goods');
                                $('.reqtabl1').text('Code-Name');
                                $('.reqtabl2').text('SKU');
                                $('.reqtabl3').text('QTY');
                                break;
                        
                            default:
                                $('#requesteditemlabeladd').html('Requested Commodity');
                                $('#evrequesteditemlabeladd').html('Requested Commodity');
                                $('#requesteditemlabel').html('Requested Commodity');
                                $('.reqtabl1').text('Commodity');
                                $('.reqtabl2').text('Crop year');
                                $('.reqtabl3').text('Process Type');
                                break;
                        }
                    break;
            }
    }
    function showdataonthestatus(status) {
        var headerid=$('#perecordIds').val();
        var id=$('#peevalsupplierid').val();
        $('#peevalstatus').val(status);

        var technicalpermit=$('#technicalviewpermission').val();
        var financalpremit=$('#financialviewpermission').val();
        var feprogresspermit=$('#financialprogresspermission').val();

        switch (status) {
                        case 0:
                        case 1:
                        case 2:
                            $('#initation').show();
                            $('#tectnicaltab').hide();
                            $('#financialtab').hide();
                            $('#initationview-tab').removeClass('active');
                            $('#technicalview-tab').removeClass('active');
                            $('#financialview-tab').removeClass('active');
                            $('#initationview-tab').addClass('active');

                            $('#initationview').removeClass('active');
                            $('#technicalview').removeClass('active');
                            $('#financialview').removeClass('active');
                            $('#initationview').addClass('active');

                        break;
                        
                        case 3:
                        case 4:
                            switch (technicalpermit) {
                                case '1':
                                        $('#initation').show();
                                        $('#tectnicaltab').show();
                                        $('#financialtab').hide();

                                        $('#initationview-tab').removeClass('active');
                                        $('#technicalview-tab').removeClass('active');
                                        $('#financialview-tab').removeClass('active');
                                        $('#technicalview-tab').addClass('active');

                                        $('#initationview').removeClass('active');
                                        $('#technicalview').removeClass('active');
                                        $('#financialview').removeClass('active');
                                        $('#technicalview').addClass('active');

                                        commuditylistoftechnicalview(headerid,id);
                                    break;
                            
                                default:
                                        $('#initation').show();
                                        $('#tectnicaltab').hide();
                                        $('#financialtab').hide();
                                        $('#initationview-tab').removeClass('active');
                                        $('#technicalview-tab').removeClass('active');
                                        $('#financialview-tab').removeClass('active');
                                        $('#initationview-tab').addClass('active');

                                        $('#initationview').removeClass('active');
                                        $('#technicalview').removeClass('active');
                                        $('#financialview').removeClass('active');
                                        $('#initationview').addClass('active');

                                    break;
                            }
                            
                        break;
                        case 8:
                        case 9:
                        case 10:
                        case 11:
                            switch (financalpremit) {
                                case '1':
                                        $('#initation').show();
                                        $('#tectnicaltab').show();
                                        $('#financialtab').show();
                                        $('#initationview-tab').removeClass('active');
                                        $('#technicalview-tab').removeClass('active');
                                        $('#financialview-tab').removeClass('active');
                                        $('#financialview-tab').addClass('active');

                                        $('#initationview').removeClass('active');
                                        $('#technicalview').removeClass('active');
                                        $('#financialview').removeClass('active');
                                        $('#financialview').addClass('active');

                                        commuditylistoffinancialview(headerid,id);
                                    break;
                            
                                default:
                                    break;
                            }
                            
                        break;
                        default:
                            break;
                    }

    }

    function commuditylistoftechnicalview(headerid,id) {
        var comudtable=$('#petechnicalcomuditydocInfoItem').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: true,
            paging: false,
            ordering:false,
            info: false,
            searchHighlight: true,
            destroy:true,
            autoWidth:false,
            "pagingType": "simple",
            order: [[ 0, "desc" ]],
            language: { search: '', searchPlaceholder: "Search here"},
            "dom": "<'row'<'col-lg-2 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
            ajax: {
                url: "{{ url('getpebysupplier') }}/"+headerid+'/'+id,           
                type: 'GET',
            },
            columns: [
                {data:'DT_RowIndex',"width": "1%"},
                {data: 'customername',name: 'customername','visible':false},
                {data: 'requestedorigin',name: 'requestedorigin',width:'20%'},
                {data: 'supplyorigin',name: 'supplyorigin', width:'20%'},
                {data: 'cropyear',name: 'cropyear',width:'10%'},
                {data: 'proccesstype',name: 'proccesstype',width:'10%'},
                {data: 'sampleamount',name: 'sampleamount',width:'10%'},
                {data: 'qualitygrade',name: 'qualitygrade'},
                {data: 'screensieve',name: 'screensieve'},
                {data: 'evmoisture',name: 'evmoisture'},
                {data: 'evcupvalue',name: 'evcupvalue'},
                {data: 'rowvalue',name: 'rowvalue'},
                {data: 'evscore',name: 'evscore'},
                {data: 'evstatus',name: 'evstatus'},
                {data: 'tecremark',name: 'tecremark', width:'30%'},
            ],
            columnDefs: [   
                        
                        {
                            targets: 14,
                            render: function ( data, type, row, meta ) {
                                var remark = (data === undefined || data === null || data === '') ? 'EMPTY' : data;
                                switch (remark) {
                                    case 'EMPTY':
                                        return '';
                                        break;
                                    
                                    default:
                                        switch (type) {
                                                case 'display':
                                                    return data.length > 40 ?'<div class="text-ellipsis" title="' + data + '">' + data.substr(0, 50) + '…</div>' :data;
                                                    break;
                                            
                                                default:
                                                    return '--';
                                                    break;
                                            }
                                        break;
                                }
                            }
                        }

                ]
        });
    }

    function commuditylistoffinancialview(headerid,id) {
        var comudtable=$('#pefinancailcomuditydocInfoItem').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: true,
            paging: false,
            ordering:false,
            info: false,
            searchHighlight: true,
            destroy:true,
            autoWidth:false,
            "pagingType": "simple",
            order: [[ 0, "desc" ]],
            language: { search: '', searchPlaceholder: "Search here"},
            "dom": "<'row'<'col-lg-2 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
            ajax: {
                url: "{{ url('getpebysupplier') }}/"+headerid+'/'+id,           
                type: 'GET',
            },
            columns: [
                {data:'DT_RowIndex',"width": "1%"},
                {data: 'customername',name: 'customername','visible':false},
                {data: 'requestedorigin',name: 'requestedorigin',width:'10%'},
                {data: 'supplyorigin',name: 'supplyorigin', width:'10%'},

                {data: 'cropyear',name: 'cropyear',width:'5%'},
                {data: 'proccesstype',name: 'proccesstype',width:'5%'},
                {data: 'qualitygrade',name: 'qualitygrade'},
                {data: 'bagamount',name: 'bagamount'},
                {data: 'customerprice',name: 'customerprice'},
                {data: 'proposedprice',name: 'proposedprice'},
                {data: 'finalprice',name: 'finalprice'},
                {data: 'rank',name: 'rank',width:'2%'},
                {data: 'fevremark',name: 'fevremark'},
            ],
            columnDefs: [   
                        {
                            targets: 11,
                            render: function ( data, type, row, meta ) {
                                switch (data) {
                                    case 0:
                                        return '';
                                        break;
                                    default:
                                        return data;
                                        break;
                                }
                            }
                        },
                        {
                            targets: 12,
                            render: function ( data, type, row, meta ) {
                                var remark = (data === undefined || data === null || data === '') ? 'EMPTY' : data;
                                switch (remark) {
                                    case 'EMPTY':
                                        return '';
                                        break;
                                    
                                    default:
                                        switch (type) {
                                                case 'display':
                                                    return data.length > 40 ?'<div class="text-ellipsis" title="' + data + '">' + data.substr(0, 50) + '…</div>' :data;
                                                    break;
                                            
                                                default:
                                                    return '--';
                                                    break;
                                            }
                                        break;
                                }
                            }
                        }
                ],
            
        });
    }
    function directgoodlist(id) {
    const tableId = '#directgoodsinfodatatables';
    const cardSection = $(tableId).closest('.card'); // Assuming the table is inside a card
    const renderNumber = $.fn.dataTable.render.number(',', '.', 2, '').display;
    const suptables = $(tableId).DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        searching: true,
        paging: false,
        ordering: false,
        info: false,
        searchHighlight: true,
        destroy: true,
        autoWidth: true, // Enable autoWidth
        pagingType: "simple",
        language: { search: '', searchPlaceholder: "Search here" },
        dom: "<'row'<'col-lg-5 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-5'>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
        ajax: {
            url: `{{ url('directgoodlist') }}/${id}`,
            type: 'GET',
            beforeSend: () => blockUI(cardSection, 'Loading Please Wait...'),
            complete: () => unblockUI(cardSection),
        },
        columns: [
            { data: 'DT_RowIndex' },
            { data: 'Code', name: 'Code' },
            { data: 'Name', name: 'Name' },
            { data: 'SKUNumber', name: 'SKUNumber' },
            { data: 'uomname', name: 'uomname' },
            { data: 'qty', name: 'qty', render: renderNumber },
            { data: 'price', name: 'price', render: renderNumber },
            { data: 'Total', name: 'Total', render: renderNumber },
            { data: 'goodid', name: 'goodid' },
        ],
        columnDefs: [
                {
                    targets: 8,
                    render: function ( data, type, row, meta ) {
                        return `
                            <i class="fa fa-info-circle text-primary goodsinfo" 
                            data-itemid="${data}" 
                            title="Item Information">
                            </i>
                        `;
                    }
                },
            ],
        initComplete: function (settings, json) {
            const totalRows = suptables.rows().count();
            $('#directinfonumberofItemsLbl').html(totalRows);
        },
        footerCallback: function (row, data, start, end, display) {
            const api = this.api();
            const intVal = (i) => typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
            const qty = api.column(5).data().reduce((a, b) => intVal(a) + intVal(b), 0);
            const unitprice = api.column(6).data().reduce((a, b) => intVal(a) + intVal(b), 0);
            const total = api.column(7).data().reduce((a, b) => intVal(a) + intVal(b), 0);
            $('#infoqtytotal').html(formatFooterValue(qty));
            $('#infounitpreicetotal').html(formatFooterValue(unitprice));
            $('#infototal').html(formatFooterValue(total));
        },
    });
}

// Helper function to block UI
function blockUI(element, message) {
    element.block({
        message: `<div class="d-flex justify-content-center align-items-center">
                    <p class="mr-50 mb-50">${message}</p>
                    <div class="spinner-grow spinner-grow-sm text-white" role="status"></div>
                </div>`,
        css: { backgroundColor: 'transparent', color: '#fff', border: '0' },
        overlayCSS: { opacity: 0.5 },
    });
}

// Helper function to unblock UI
function unblockUI(element) {
    element.unblock();
}

// Helper function to format footer values
function formatFooterValue(value) {
    const renderNumber = $.fn.dataTable.render.number(',', '.', 2, '').display;
    return `<h6 style="font-size:13px;color:black;font-weight:bold;">${renderNumber(value)}</h6>`;
}
    
    function directcommoditylist(id) {
        var suptables=$('#directcommudityinfodatatables').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: true,
            paging: false,
            ordering:false,
            info: false,
            searchHighlight: true,
            destroy:true,
            autoWidth:false,
            "pagingType": "simple",
            order: [[ 0, "desc" ]],
            language: { search: '', searchPlaceholder: "Search here"},
            "dom": "<'row'<'col-lg-5 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-5'>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
            ajax: {
                url: "{{ url('directcommoditylist') }}/"+id,                   
                type: 'GET',
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
            columns: [
                {data:'DT_RowIndex'},
                {data: 'origin',name: 'origin'},
                {data: 'grade',name: 'grade'},
                {data: 'proccesstype',name: 'proccesstype'},
                {data: 'cropyear',name: 'cropyear'},
                {data: 'uomname',name: 'uomname'},
                {data: 'qty',name: 'qty',render: $.fn.dataTable.render.number(',', '.', 2, '')},
                {data: 'bagweight',name: 'bagweight',render: $.fn.dataTable.render.number(',', '.', 2, '')},
                {data: 'totalKg',name: 'totalKg',render: $.fn.dataTable.render.number(',', '.', 2, '')},
                {data: 'netkg',name: 'netkg',render: $.fn.dataTable.render.number(',', '.', 2, '')},
                {data: 'ton',name: 'ton',render: $.fn.dataTable.render.number(',', '.', 2, '')},
                {data: 'feresula',name: 'feresula',render: $.fn.dataTable.render.number(',', '.', 2, '')},
                {data: 'price',name: 'price',render: $.fn.dataTable.render.number(',', '.', 2, '')},
                {data: 'Total',name: 'Total',render: $.fn.dataTable.render.number(',', '.', 2, '')},
                {data: 'pdetailid',name: 'pdetailid'},
            ],
            columnDefs: [
                {
                    targets: 14,
                    render: function ( data, type, row, meta ) {
                        return `
                            <i class="info-icon fa fa-info-circle text-primary" 
                            data-netkg="${row.netkg}" 
                            data-totalprice="${row.Total}" 
                            title="Price Information">
                            </i>
                        `;
                    }
                },
            ],
            "initComplete": function(settings, json) {
                var totalRows = suptables.rows().count();
                $('#directinfonumberofItemsLbl').html(totalRows);
            },
            "footerCallback": function (row, data, start, end, display) {
                    var api = this.api();
                    // Helper function to parse integer from strings
                    var intVal = function (i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :  // Remove commas and convert to int
                            typeof i === 'number' ?
                                i : 0;
                    };
                        
                            var totalnofbag = api
                                .column(6) // Adjust to your column index
                                .data()
                                .reduce(function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0);

                                var bagweight = api
                                .column(7) // Adjust to your column index
                                .data()
                                .reduce(function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0);

                                var totalkg = api
                                .column(8) // Adjust to your column index
                                .data()
                                .reduce(function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0);

                                var netkg = api
                                .column(9) // Adjust to your column index
                                .data()
                                .reduce(function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0);

                                var ton = api
                                .column(10) // Adjust to your column index
                                .data()
                                .reduce(function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0);

                                var feresula = api
                                .column(11) // Adjust to your column index
                                .data()
                                .reduce(function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0);

                                var price = api
                                .column(12) // Adjust to your column index
                                .data()
                                .reduce(function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0);

                                var totalprice = api
                                .column(13) // Adjust to your column index
                                .data()
                                .reduce(function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0);
                                
                        var numberendering = $.fn.dataTable.render.number( ',', '.', 2, ).display;
                        $('#infonofbagtotal').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>"+numberendering(totalnofbag)+"</h6>");
                        $('#infobagweighttotal').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>"+numberendering(bagweight)+"</h6>");
                        $('#infokgtotal').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>"+numberendering(totalkg)+"</h6>");
                        $('#infonetkgtotal').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>"+numberendering(netkg)+"</h6>");
                        $('#infotontotal').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>"+numberendering(ton)+"</h6>");
                        $('#infopriceferesula').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>"+numberendering(feresula)+"</h6>");
                        $('#infopricetotal').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>"+numberendering(price)+"</h6>");
                        $('#infototalpricetotal').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>"+numberendering(totalprice)+"</h6>");
                },
        });
    }

    $(document).on('mouseenter', '.info-icon', function () {
        var $icon = $(this);
        // Check if popover is already initialized
        if (!$icon.data('bs.popover')) {
            // Extract row data from attributes
            var totalprice = $icon.data('totalprice');
            var netkg = $icon.data('netkg');
                //Create dynamic content
            var priceperkg=parseFloat(totalprice)/parseFloat(netkg);
            //var formattedTotalPrice = new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(totalprice);
            var calculatedtotalprice=parseFloat(priceperkg)*parseFloat(netkg);
            priceperkg=Number(priceperkg.toFixed(2));
            calculatedtotalprice=Number(calculatedtotalprice.toFixed(2));
            
            const formattedPricePerKg = priceperkg.toLocaleString(); // Format price per kg
            const formattedNetKg = netkg.toLocaleString(); // Format net kg
            const formattedTotalPrice = calculatedtotalprice.toLocaleString(); // Format total price
            const content = `
                    <strong>Price per kg:</strong> ${formattedPricePerKg}<br>
                    <strong>Net kg:</strong> ${formattedNetKg}<br>
                    <strong>Total Price:</strong> ${formattedTotalPrice}
                `;
            // Initialize the popover
            $icon.popover({
                html: true,
                content: content,
                trigger: 'hover',
                placement: 'top',
                container: 'body'
            }).popover('show');
        }
    });

    // Clean up popovers on mouseleave
    $(document).on('mouseleave', '.info-icon', function () {
        $(this).popover('dispose');
    });

    function setsupplierbytab(supplier) {
        var carddata='';
        var backcolor="";
        var forecolor="";
        var status='';
        var jj=0;
        var stitles='';
        var firstsupplierid=0;
        var sumbitdate='';
        var supplycode='';
        var sec=0;
        $.each(supplier, function (index, value) { 
            ++jj;
            switch (index) {
                case 0:
                    pefetchorders(value.id,1);
                    firstsupplierid=value.id;
                    break;
            
                default:
                    break;
            }
            stitles="Name:"+value.Name+" "+value.TinNumber;
            supplycode="Code:"+value.pecode;
            sumbitdate="Submit Date:"+value.recievedate;
            carddata+="<div id='commcard"+value.id+"' class='card supcard commcardcls"+value.id+"' data-title='"+stitles+"' style='margin-top:-1.75rem;border:0.5px solid #FFFFFF' onclick='fetchorders("+value.id+","+sec+")'><div class='card-header' style='margin-top:-1rem;margin-left:-1rem;margin-right:-1rem'><span class='badge badge-center rounded-pill bg-secondary'>"+jj+"</span> <span><b>"+supplycode+"</b></span><div id='targetspandiv"+value.id+"'><span style='background-color:"+backcolor+";color:"+forecolor+";padding:3px 5px;font-size:11px;'><b>"+status+"</b></span></div></div><div class='card-body pb-0' style='margin-top:-1.2rem'><div class='row mt-0'><div class='col-xl-12 col-md-12 col-lg-12 p-0'><b>@can('Supplier-View')"+stitles+"@endcan</b></div><div class='col-xl-12 col-md-12 col-lg-12 p-0'><b>@can('Supplier-View')"+sumbitdate+"@endcan</b></div></div></div></div>";
        });
        $('#pecarddatacanvas').empty();
        $('#pecarddatacanvas').html(carddata);
        $('.commcardcls'+firstsupplierid).addClass('supplierselected');
    }
    $('#searchsupplier').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        $('#carddatacanvas .card').filter(function() {
            $(this).toggleClass('hidden', $(this).data('title').toLowerCase().indexOf(value) === -1);
            
        });
    });
    
    $('#clearsupplsearch').on('click', function(){
        var value = '';
        $('#carddatacanvas .card').filter(function() {
            $(this).toggleClass('hidden', $(this).data('title').toLowerCase().indexOf(value) === -1);
        });
        $('#searchsupplier').val('');
    });
    function pefetchorders(id,isfirst) {
            console.log('suplier id='+id);
            var headerid=$('#perecordIds').val();
            $('#peevalsupplierid').val(id);
            $('.supcard').removeClass('supplierselected');
            $('.commcardcls'+id).addClass('supplierselected');

            switch (isfirst) {
                case 1:
                    commuditylist(headerid,id);
                    break;
                default:
                    var activeTab = $("#infoapptabs .nav-item .active").attr("href");
                    switch (activeTab) {
                        case '#initationview':
                                commuditylist(headerid,id);
                            break;
                        case '#technicalview':
                                commuditylistoftechnicalview(headerid,id);
                        break;
                        default:
                                commuditylistoffinancialview(headerid,id);
                            break;
                    }
                    break;
            }
    }
    function commuditylist(headerid,id) {

            $('#initiationcomuditydocInfoItemdiv').hide();
            $('#comuditydocInfoItemdiv').show();
            $("#supllierlistdiv").show();
            var status=$('#peevelautestatus').val();
            switch (status) {
                case '0':
                case '1':
                    $("#pecommoditylistdiv").removeClass("col-xl-12 col-md-12 col-sm-12");
                    $("#pecommoditylistdiv").removeClass("col-xl-10 col-md-10 col-sm-10");
                    $("#pecommoditylistdiv").removeClass("col-xl-9 col-md-9 col-sm-9");
                    $("#pecommoditylistdiv").removeClass("col-xl-8 col-md-8 col-sm-8");

                    $("#pesupllierlistdiv").removeClass("col-xl-3 col-md-2 col-sm-2");
                    $("#pesupllierlistdiv").removeClass("col-xl-4 col-md-4 col-sm-4");

                    $("#pecommoditylistdiv").addClass("col-xl-8 col-md-8 col-sm-8");
                    $("#pesupllierlistdiv").addClass("col-xl-4 col-md-4 col-sm-4");
                    break;
                default:
                    $("#pecommoditylistdiv").removeClass("col-xl-12 col-md-12 col-sm-12");
                    $("#pecommoditylistdiv").removeClass("col-xl-10 col-md-10 col-sm-10");
                    $("#pecommoditylistdiv").removeClass("col-xl-9 col-md-9 col-sm-9");
                    $("#pecommoditylistdiv").removeClass("col-xl-8 col-md-8 col-sm-8");

                    $("#pesupllierlistdiv").removeClass("col-xl-3 col-md-3 col-sm-3");
                    $("#pesupllierlistdiv").removeClass("col-xl-4 col-md-4 col-sm-4");

                    $("#pecommoditylistdiv").addClass("col-xl-9 col-md-9 col-sm-9");
                    $("#pesupllierlistdiv").addClass("col-xl-3 col-md-3 col-sm-3");

                    break;
            }
            var title='---';
            var comudtable=$('#pecomuditydocInfoItem').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: true,
            paging: false,
            ordering:false,
            info: false,
            searchHighlight: true,
            destroy:true,
            autoWidth:false,
            "pagingType": "simple",
            order: [[ 0, "desc" ]],
            language: { search: '', searchPlaceholder: "Search here"},
            "dom": "<'row'<'col-lg-2 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
            ajax: {
                url: "{{ url('getpebysupplier') }}/"+headerid+'/'+id,           
                type: 'GET',
            },
            columns: [
                {data:'DT_RowIndex',"width": "1%"},
                {data: 'customername',name: 'customername','visible':false},
                {data: 'requestedorigin',name: 'requestedorigin',width:'20%'},
                {data: 'supplyorigin',name: 'supplyorigin', width:'20%'},
                {data: 'cropyear',name: 'cropyear',width:'10%'},
                {data: 'proccesstype',name: 'proccesstype',width:'10%'},
                {data: 'sampleamount',name: 'sampleamount',width:'5%'},
                {data: 'remark',name: 'remark'},
                
            ],
            columnDefs: [   
                        {
                            targets: 6,
                            render: function ( data, type, row, meta ) {
                                switch (data) {
                                    case 0:
                                        return '';
                                        break;
                                    default:
                                        return data;
                                        break;
                                }
                            }
                        },

                        {
                            targets: 7,
                            render: function ( data, type, row, meta ) {
                                var remark = (data === undefined || data === null || data === '') ? 'EMPTY' : data;
                                switch (remark) {
                                    case 'EMPTY':
                                        return '';
                                        break;
                                    
                                    default:
                                        switch (type) {
                                                case 'display':
                                                    return data.length > 40 ?'<div class="text-ellipsis" title="' + data + '">' + data.substr(0, 50) + '…</div>' :data;
                                                    break;
                                            
                                                default:
                                                    return '--';
                                                    break;
                                            }
                                        break;
                                }
                                
                            }
                        }

                ]
        });
        
    }
    function fetchorders(id) {
        var headerid=$('#recordIds').val();
        $('#supplierrecordIds').val(id);
        $('.supcard').removeClass('supplierselected');
        $('.commcardcls'+id).addClass('supplierselected');
        $.ajax({
            type: "GET",
            url: "{{ url('infogetwineditems') }}/"+headerid+"/"+id,
            dataType: "json",
            success: function (response) {
                $.each(response.supplinfo, function (index, value) { 
                    $('#supplierinfosubtotalLbl').html(value.subtotal);
                    $('#supplierinfotaxLbl').html(value.tax);
                    $('#supplierinfograndtotalLbl').html(value.grandtotal);
                    $('#supplierinfowitholdingAmntLbl').html(value.withold);
                    $('#supplierinfonetpayLbl').html(value.netpay);

                    $('#infodocumentno').html(value.docno);
                    $('#infopreparedate').html(value.preparedate);
                    $('#infoorderdate').html(value.orderdate);
                    $('#infodeliverydate').html(value.deliverydate);
                    
                    $('#infopepaymenterm').html(value.paymenterm);

                    istaxable=value.istaxable;
                    // $('#supplierinfovatTitleLbl').html(value.subtotal);
                    if(parseFloat(value.subtotal)>=10000){
                            $('#supplierinfowitholdingTr').show();
                            $('#supplierinfonetpayTr').show();
                    } else{
                        $('#supplierinfowitholdingTr').hide();
                        $('#supplierinfonetpayTr').hide();
                    }
                    showbuttondependonsupplierstat(id,value.status);
                });
                switch (istaxable) {
                            case 0:
                                $('#individualsupplierinfotaxtr').hide();
                                $('#individualsupplierinforandtotaltr').hide();
                                $('#supplierinfocustomCheck1').prop('checked', false);
                                break;
                            
                            default:
                                $('#individualsupplierinfotaxtr').show();
                                $('#individualsupplierinforandtotaltr').show();
                                $('#supplierinfocustomCheck1').prop('checked', true);
                                break;
                        }
                switch (response.headerexist) {
                        case true:
                            $("#iconsupplierpoverifypoeditbutton").removeClass("fa-sharp fa-solid fa-plus");
                            $("#iconsupplierpoverifypoeditbutton").removeClass("fa-duotone fa-pen");
                            $("#iconsupplierpoverifypoeditbutton").addClass("fa-duotone fa-pen");
                            $("#supplierpoverifypoeditbutton").find('span').text("Edit");
                            break;

                        default:
                            $("#iconsupplierpoverifypoeditbutton").removeClass("fa-sharp fa-solid fa-plus");
                            $("#iconsupplierpoverifypoeditbutton").removeClass("fa-duotone fa-pen");
                            $("#iconsupplierpoverifypoeditbutton").addClass("fa-sharp fa-solid fa-plus");
                            $("#supplierpoverifypoeditbutton").find('span').text("Add");
                            break;
                    }
                    suppliersetminilog(response.actions);
                    $('#infopewarehouse').html(response.storename);
            }
            
        });
        infocommodotylist(headerid,id)
        
    }
    $('body').on('click', '.enVoiceinformation', function () {
            var porderid=$('#recordIds').val();
            var id = $(this).data('id');
            var name=$(this).data('name');
            var istaxable=0;
            $('#infolegendid').html('Purchase information for '+name);
            $('#supplierrecordIds').val(id);
            $('#suppliername').val(name);
            $('#informationordermodals').modal('show');
            $.ajax({
                type: "GET",
                url: "{{ url('infogetwineditems') }}/"+porderid+"/"+id,
                success: function (response) {
                        $('#infosupppe').html(response.pedocno);
                        $.each(response.orderinfo, function (index, value) { 
                            $('#infosupprefernce').html(value.type);
                            $('#infosupppo').html(value.porderno);
                            $('#infosuppdocumentdate').html(value.date);
                        });
                        $.each(response.customer, function (index, value) { 
                            $('#infosupplierid').html(value.Code);
                            $('#infosuppliername').html(value.Name);
                            $('#infosuppliertin').html(value.TinNumber);
                        });
                        $.each(response.supplinfo, function (index, value) { 
                            $('#supplierinfosubtotalLbl').html(value.subtotal);
                            $('#supplierinfotaxLbl').html(value.tax);
                            $('#supplierinfograndtotalLbl').html(value.grandtotal);
                            $('#supplierinfowitholdingAmntLbl').html(value.withold);
                            $('#supplierinfonetpayLbl').html(value.netpay);
                            istaxable=value.istaxable;
                            // $('#supplierinfovatTitleLbl').html(value.subtotal);
                            if(parseFloat(value.subtotal)>=10000){
                                    $('#supplierinfowitholdingTr').show();
                                    $('#supplierinfonetpayTr').show();
                            } else{
                                $('#supplierinfowitholdingTr').hide();
                                $('#supplierinfonetpayTr').hide();
                            }
                            showbuttondependonsupplierstat(id,value.status);
                        });
                        switch (istaxable) {
                            case 0:
                                $('#individualsupplierinfotaxtr').hide();
                                $('#individualsupplierinforandtotaltr').hide();
                                $('#supplierinfocustomCheck1').prop('checked', false);
                                break;
                            
                            default:
                                $('#individualsupplierinfotaxtr').show();
                                $('#individualsupplierinforandtotaltr').show();
                                $('#supplierinfocustomCheck1').prop('checked', true);
                                break;
                        }
                    switch (response.type) {
                        case 'Goods':
                            $('#infofinancailevdynamicTable').show();
                            $('#infofinancailevdynamicTablecommdity').hide();
                            break;
                        default:
                            $('#infofinancailevdynamicTable').hide();
                            $('#infofinancailevdynamicTablecommdity').show();
                            infocommodotylist(porderid,id);
                            getpurchaselogs(id);
                            break;
                    }
                    switch (response.headerexist) {
                        case true:
                            $("#iconsupplierpoverifypoeditbutton").removeClass("fa-sharp fa-solid fa-plus");
                            $("#iconsupplierpoverifypoeditbutton").removeClass("fa-duotone fa-pen");
                            $("#iconsupplierpoverifypoeditbutton").addClass("fa-duotone fa-pen");
                            $("#supplierpoverifypoeditbutton").find('span').text("Edit");
                            break;
                    
                        default:
                            $("#iconsupplierpoverifypoeditbutton").removeClass("fa-sharp fa-solid fa-plus");
                            $("#iconsupplierpoverifypoeditbutton").removeClass("fa-duotone fa-pen");
                            $("#iconsupplierpoverifypoeditbutton").addClass("fa-sharp fa-solid fa-plus");
                            $("#supplierpoverifypoeditbutton").find('span').text("Add");
                            break;
                    }
                    suppliersetminilog(response.actions);
                }
            });
    });

    function showsupplier(peid) {
        var suptables=$('#supplierdatatables').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: true,
            paging: false,
            ordering:false,
            info: false,
            searchHighlight: true,
            destroy:true,
            autoWidth:false,
            "pagingType": "simple",
            order: [[ 0, "desc" ]],
            language: { search: '', searchPlaceholder: "Search here"},
            "dom": "<'row'<'col-lg-5 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-5'>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
            ajax: {
                url: "{{ url('showsupplierpo') }}/"+peid,                   
                type: 'GET',
            },
            columns: [
                {data:'DT_RowIndex'},
                {data: 'docno',name: 'docno'},
                {data: 'Name',name: 'Name'},
                {data: 'TinNumber',name: 'TinNumber'},
                {data: 'orderdate',name: 'orderdate'},
                {data: 'deliverydate',name: 'deliverydate'},
                {data: 'status',name: 'status'},
                {data: 'id',name: 'id',width:'3%'},
            ],
            columnDefs: [{
                targets:6,
                render:function (data,type,row,meta) {
                    switch (data) {
                            case 1:
                                return '<p style="color:#F1941D;font-weight:bold;text-shadow:1px 1px 10px #F1941D;">Draft</p>';
                            break;
                            case 2:
                                return '<p style="color:#F1941D;font-weight:bold;text-shadow:1px 1px 10px #F1941D;">Pending</p>';
                            break;
                            case 3:
                                return '<p style="color:#4e73df;font-weight:bold;text-shadow:1px 1px 10px #4e73df;">Verify</p>';
                            break;
                            case 4:
                                return '<p style="color:#1cc88a;font-weight:bold;text-shadow:1px 1px 10px #1cc88a;">Approved</p>';
                            break;
                            case 5:
                                return '<p style="color:#e74a3b;font-weight:bold;text-shadow:1px 1px 10px #e74a3b;">Void</p>';
                            break;
                            
                            case 6:
                                return '<p style="color:#e74a3b;font-weight:bold;text-shadow:1px 1px 10px #e74a3b;">Reject</p>';
                            break;
                            default:
                                return '';
                            break;
                        }
                }
            },{
                targets:7,
                render:function (data,type,row,meta) {
                        var anchor='<a class="enVoiceinformation" href="javascript:void(0)" data-id='+data+' data-name="'+row.Name+'" title="Initate order"><i class="fa-sharp fa-regular fa-circle-info fa-xl" style="color: #00cfe8;"></i></a>';
                        return anchor;
                }
            }
        ],
            
        });
    }
    
    $('#supplieradds').click(function(){
        var supplierid=$('#supplierrecordIds').val();
        var headerid=$('#recordIds').val();
        addorderdata(headerid,supplierid);
    });
    $('#poaddorderbutton').click(function(){
        var supplierid=$('#supplierrecordIds').val();
        var headerid=$('#recordIds').val();
        $('.dr').val('');
        $('.sr').val('');
        $('.lbl').html('0.00');
        addorderdata(headerid,supplierid);
    });
    $('#supplierpoverifypoeditbutton').click(function(){
        $('.rmerror').html('');
        var headerid=$('#recordIds').val();
        var supplierid=$('#supplierrecordIds').val();
        getorderdata(headerid,supplierid);
    });
    function showbuttondependonsupplierstat(id,status) {
        var stringstatus='';
        var backcolor='';
        var forecolor='';
        var span='';
        $('#targetspandiv'+id).html('');
        switch (status) {
            case 1:
                stringstatus='Draft';
                backcolor="#fff1e3 !important";
                forecolor="#ff9f43 !important";
                span="<span style='background-color:"+backcolor+";color:"+forecolor+";padding:3px 5px;font-size:11px;'><b>"+stringstatus+"</b></span>";
                $('#targetspandiv'+id).html(span);
                $('#supplierpoverifypopending').show();
                $('#supplierpoverifypovoidbuttoninfo').show();
                $('#supplierpoverifypoeditbutton').show();
                $('#supplierpoverify').hide();
                $('#supplierbacktopending').hide();
                $('#supplierbacktoverify').hide();
                $('#supplierpoverifypoapproved').hide();
                $('#supplierpoundovoidbuttoninfo').hide();
                $('#supplierpoprintbutton').hide();
                $('#supplierbacktodraft').hide();
                $('#pobacktodraft').hide();
                $('#supplierinfoStatus').html('<span style="color:#f6c23e;font-weight:bold;text-shadow;1px 1px 10px #f6c23e">Draft</span>');
            break;
            case 2:
                stringstatus='Pending';
                backcolor="#fff1e3 !important";
                forecolor="#ff9f43 !important";
                span="<span style='background-color:"+backcolor+";color:"+forecolor+";padding:3px 5px;font-size:11px;'><b>"+stringstatus+"</b></span>";
                $('#targetspandiv'+id).html(span);
                $('#supplierpoverifypovoidbuttoninfo').show();
                $('#supplierpoverify').show();
                $('#supplierpoverifypoeditbutton').show();
                $('#supplierbacktodraft').show();
                $('#pobacktodraft').show();
                $('#supplierbacktoverify').hide();
                $('#supplierpoverifypopending').hide();
                $('#supplierpoverifypoapproved').hide();
                $('#supplierpoundovoidbuttoninfo').hide();
                $('#supplierpoprintbutton').hide();
                $('#supplierbacktopending').hide();
                $('#supplierinfoStatus').html('<span style="color:#f6c23e;font-weight:bold;text-shadow;1px 1px 10px #f6c23e">Pending</span>');
            break;
            case 3:
                stringstatus='Verify';
                backcolor="#eae8fd !important";
                forecolor="#7367f0 !important";
                span="<span style='background-color:"+backcolor+";color:"+forecolor+";padding:3px 5px;font-size:11px;'><b>"+stringstatus+"</b></span>";
                $('#targetspandiv'+id).html(span);
                $('#supplierpoverifypovoidbuttoninfo').show();
                $('#supplierpoverifypoapproved').show();
                $('#supplierpoverifypoeditbutton').show();
                $('#supplierbacktoverify').hide();
                $('#supplierbacktopending').show();
                $('#supplierpoverify').hide();
                $('#supplierpoverifypopending').hide();
                $('#supplierpoundovoidbuttoninfo').hide();
                $('#supplierpoprintbutton').hide();
                $('#supplierbacktodraft').hide();
                $('#supplierpoverify').hide();
                $('#pobacktodraft').hide();
                $('#supplierinfoStatus').html('<span style="color:#4e73df;font-weight:bold;text-shadow;1px 1px 10px #4e73df">Verified</span>');
            break;
            case 4:
                stringstatus='Approved';
                backcolor="#dff7e9 !important";
                forecolor="#28c76f !important";
                span="<span style='background-color:"+backcolor+";color:"+forecolor+";padding:3px 5px;font-size:11px;'><b>"+stringstatus+"</b></span>";
                $('#targetspandiv'+id).html(span);
                $('#supplierpoverifypovoidbuttoninfo').show();
                $('#supplierbacktodraft').hide();
                $('#supplierpoprintbutton').show();
                $('#supplierbacktoverify').hide();
                $('#supplierpoverifypoeditbutton').show();
                $('#supplierpoverifypoapproved').hide();
                $('#supplierpoverify').hide();
                $('#supplierpoverifypopending').hide();
                $('#supplierpoundovoidbuttoninfo').hide();
                $('#supplierbacktopending').hide();
                $('#supplierinfoStatus').html('<span style="color:#4e73df;font-weight:bold;text-shadow;1px 1px 10px #4e73df">Approved</span>');
            break;
            case 5:
                stringstatus='Void';
                backcolor="#eae8fd !important";
                forecolor="#7367f0 !important";
                span="<span style='background-color:"+backcolor+";color:"+forecolor+";padding:3px 5px;font-size:11px;'><b>"+stringstatus+"</b></span>";
                $('#targetspandiv'+id).html(span);
                $('#supplierpoundovoidbuttoninfo').show();
                $('#supplierpoverifypovoidbuttoninfo').hide();
                $('#supplierpoverify').hide();
                $('#supplierpoverifypopending').hide(); 
                $('#supplierpoverifypoapproved').hide();
                $('#supplierpoprintbutton').hide();
                $('#supplierbacktodraft').hide();
                $('#supplierpoverifypoeditbutton').hide();
                $('#supplierbacktoverify').hide();
                $('#supplierbacktopending').hide();
                $('#supplierinfoStatus').html('<span style="color:#4e73df;font-weight:bold;text-shadow;1px 1px 10px #4e73df">Void</span>');
            break;
            case 6:
                stringstatus='Void';
                backcolor="#fff1e3 !important";
                forecolor="#ff9f43 !important";
                span="<span style='background-color:"+backcolor+";color:"+forecolor+";padding:3px 5px;font-size:11px;'><b>"+stringstatus+"</b></span>";
                $('#targetspandiv'+id).html(span);
                $('#supplierpoundovoidbuttoninfo').show();
                $('#supplierpoverifypovoidbuttoninfo').hide();
                $('#supplierpoverify').hide();
                $('#supplierpoverifypopending').hide(); 
                $('#supplierpoverifypoapproved').hide();
                $('#supplierpoprintbutton').hide();
                $('#supplierbacktodraft').hide();
                $('#supplierpoverifypoeditbutton').hide();
                $('#supplierbacktoverify').hide();
                $('#supplierbacktopending').hide();
                $('#supplierinfoStatus').html('<span style="color:#4e73df;font-weight:bold;text-shadow;1px 1px 10px #4e73df">Reject</span>');
            break;
            default:
                $('#supplierpoverifypovoidbuttoninfo').hide();
                $('#supplierpoverify').hide();
                $('#supplierpoverifypopending').hide();
                $('#supplierpoverifypoapproved').hide();
                $('#supplierpoundovoidbuttoninfo').hide();
                $('#poprintbutton').hide();
                $('#supplierbacktodraft').hide();
                $('#supplierbacktoverify').hide();
                $('#supplierbacktopending').hide();
                $('#supplierpoprintbutton').hide();
                break;
        }
    }

    $('#povoidbutton').click(function(){
        var form = $("#povoidform");
        var formData = form.serialize();
        $.ajax({
            type: "POST",
            url: "{{ url('povoid') }}",
            data: formData,
            dataType: "json",
            success: function (response) {

                switch (response.success) {
                    case 300:
                            toastrMessage('error','It is impossible to perform the operation because this purchase order already exists in the receiving process','Error');
                        break;
                
                    default:
                            if(response.errors){
                                if(response.errors.Reason){
                                    $('#voidreason-error').html( response.errors.Reason[0]);
                                }
                            }
                            else if(response.dberrors){
                                toastrMessage('error',response.dberrors,'Error!');
                            } 
                            else if(response.success){
                                toastrMessage('success','Succeesfully Saved','Success');
                                $('#povoidmodal').modal('hide');
                                setminilog(response.actions);
                                modalhider();
                            }
                        break;
                }
            }
        });
    });
    $('#supplierpovoidbutton').click(function(){
        var form = $("#supplierpovoidform");
        var formData = form.serialize();
        $.ajax({
            type: "POST",
            url: "{{ url('supplierpovoid') }}",
            data: formData,
            dataType: "json",
            success: function (response) {
                if(response.errors){
                    if(response.errors.Reason){
                        $('#suppliervoidreason-error').html( response.errors.Reason[0]);
                    }
                }
                else if(response.dberrors){
                    toastrMessage('error',response.dberrors,'Error!');
                } 
                else if(response.success){
                    toastrMessage('success','Succeesfully Saved','Success');
                    $('#supplierpovoidmodal').modal('hide');
                    showbuttondependonsupplierstat(response.status);
                    suppliersetminilog(response.actions);
                    var oTable = $('#supplierdatatables').dataTable();
                        oTable.fnDraw(false);
                }
            }
        });
    });
    $('#povoidbuttoninfo').click(function(){
            var id=$('#recordIds').val();
            $('#povoidid').val(id);
            $('#povoidtype').val('Void');
            $("#voidreason").val('');
            $("#povoidbutton").find('span').text("Void");
            $('#povoidmodal').modal('show');
        });
        $('#porejectbuttoninfo').click(function(){
            var id=$('#recordIds').val();
            $('#povoidid').val(id);
            $('#povoidtype').val('Reject');
            $("#voidreason").val('');
            $("#povoidbutton").find('span').text("Reject");
            $('#povoidmodal').modal('show');
        });

        $('#pobacktopending').click(function(){
            var id=$('#recordIds').val();
            $('#povoidid').val(id);
            $('#povoidtype').val('Pending');
            $("#voidreason").val('');
            $("#povoidbutton").find('span').text("Back To Pending");
            $('#povoidmodal').modal('show');
        });

        $('#pobacktodraft').click(function(){
            var id=$('#recordIds').val();
            $('#povoidid').val(id);
            $('#povoidtype').val('Draft');
            $("#voidreason").val('');
            $("#povoidbutton").find('span').text("Back To Draft");
            $('#povoidmodal').modal('show');
        });

    $('#supplierpoverifypovoidbuttoninfo').click(function(){
        var id=$('#recordIds').val();
        var supid=$('#supplierrecordIds').val();
        $('#supplierpovoidid').val(id);
        $('#supplierdetailsid').val(supid);
        $('#supplierpovoidtype').val('Void');
        $("#suppliervoidreason").val('');
        $("#supplierpovoidbutton").find('span').text("Void");
        $('#supplierpovoidmodal').modal('show');
    });

    $('#supplierpoverifypopending').click(function(){
        var id=$('#supplierrecordIds').val();
        supplierconfirmAction(id,2);
    });

    $('#supplierpoverify').click(function(){
        var id=$('#supplierrecordIds').val();
        supplierconfirmAction(id,3);
    });
    $('#supplierpoverifypoapproved').click(function(){
        var id=$('#supplierrecordIds').val();
        supplierconfirmAction(id,4);
    });
    $('#supplierpoundovoidbuttoninfo').click(function(){
        var id=$('#supplierrecordIds').val();
        supplierconfirmAction(id,5);
    });
    $('#supplierbacktodraft').click(function(){
        var id=$('#supplierrecordIds').val();
        supplierconfirmAction(id,7);
    });

    $('#supplierbacktopending').click(function(){
        var id=$('#supplierrecordIds').val();
        supplierconfirmAction(id,8);
    });
    $('#supplierbacktoverify').click(function(){
        var id=$('#supplierrecordIds').val();
        supplierconfirmAction(id,9);
    });

        function supplierconfirmAction(id,status) {
            var headerid=$('#recordIds').val();
            var msg='--';
            var title='--';
            var buttontext='--';
        switch (status) {
            case 0:
                    msg='Are you sure do you want to back to pending this purchase evaluation';
                    title='Back';
                    buttontext='Back to pending';
                break;
                case 2:
                    msg='Are you sure do you want to change to pending';
                    title='Confirmation';
                    buttontext='Pending';
                break;
                case 3:
                    msg='Are you sure do you want verify';
                    title='Confirmation';
                    buttontext='Verify';
                break;
                
                case 4:
                    msg='Are you want to approve ';
                    title='Confirmation';
                    buttontext='Approve';
                break;
                
                case 5:
                    msg='Are you sure do you want to undo void';
                    title='Confirmation';
                    buttontext='Undo Void';
                break;

                case 7:
                    msg='Are you sure do you want to back to draft';
                    title='Confirmation';
                    buttontext='Back To Draft';
                break;
                case 8:
                    msg='Are you sure do you want to back to pending';
                    title='Confirmation';
                    buttontext='Back To Pending';
                break;
                case 9:
                    msg='Are you sure do you want to back to verify';
                    title='Confirmation';
                    buttontext='Back To Verify';
                break;
            default:
                msg='whoops';
                title='whoops';
                buttontext='whoops';
                break;
        }
            swal.fire({
                title: title,
                icon: 'question',
                html: msg,
                showCancelButton: !0,
                allowOutsideClick: false,
                confirmButtonClass: "btn-info",
                confirmButtonText: buttontext,
                cancelButtonText: "Cancel",
                cancelButtonClass: "btn-danger",
                reverseButtons: !0
        }).then(function (e) {
            if (e.value === true) {
                let token = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        type: 'GET',
                        url:  "{{url('supplieraction')}}/"+headerid+"/"+id+'/'+status,
                        data: {_token: token},
                        success: function (resp) {
                            switch (resp.success) {
                                case 200:
                                    toastrMessage('success',resp.message,'success');
                                    showbuttondependonsupplierstat(id,resp.status);
                                    suppliersetminilog(resp.actions);
                                    var oTable = $('#supplierdatatables').dataTable();
                                        oTable.fnDraw(false);
                                    break;
                                    case 201:
                                        toastrMessage('error','Please fill all the technical feild evaluatins','Error');
                                    break;
                                default:
                                        swal.fire("Whoops!", 'Something went wrong please contact support team.', "error");
                                        // var oTable = $('#proformatable').dataTable();
                                        // oTable.fnDraw(false);
                                    break;
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
    function getpurchaselogs(id) {
        $('#allpurchaseordertables').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: true,
            paging: false,
            ordering:false,
            info: false,
            searchHighlight: true,
            destroy:true,
            autoWidth:false,
            "pagingType": "simple",
            order: [[ 0, "desc" ]],
            language: { search: '', searchPlaceholder: "Search here"},
            "dom": "<'row'<'col-lg-5 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-5'>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
            ajax: {
                url: "{{ url('listallpologs') }}/"+id,                   
                type: 'GET',
            },
            columns: [
                {data:'DT_RowIndex',width:'2%'},
                {data: 'docno',name: 'docno'},
            ],
        });
    }
    function infocommodotylist(headerid,id) {

        var suptables=$('#infofinancailevdynamicTablecommdity').DataTable({ 
            responsive: true,
            processing: true,
            serverSide: true,
            searching: true,
            paging: false,
            ordering:false,
            info: false,
            searchHighlight: true,
            destroy:true,
            autoWidth:false,
            "pagingType": "simple",
            order: [[ 0, "desc" ]],
            language: { search: '', searchPlaceholder: "Search here"},
            "dom": "<'row'<'col-lg-5 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-5'>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
            ajax: {
                url: "{{ url('suppliercommodity') }}/"+headerid+"/"+id,                   
                type: 'GET',
            },
            columns: [
                {data:'DT_RowIndex'},
                {data: 'origin',name: 'origin'},
                {data: 'cropyear',name: 'cropyear'},
                {data: 'proccesstype',name: 'proccesstype'},
                {data: 'uomname',name: 'uomname'},
                {data: 'qty',name: 'qty'},
                {data: 'totalKg',name: 'totalKg'},
                {data: 'feresula',name: 'feresula'},
                {data: 'price',name: 'price'},
                {data: 'Total',name: 'Total'},
                {data: 'status',name: 'status'},
            ],
            
            "initComplete": function(settings, json) {
                updateRowCounts(suptables);
            }
        });
    }

    function updateRowCounts(table) {
        var totalRows = table.data().count();
        $('#supplierinfonumberofItemsLbl').html(totalRows);
    }
    function addorderdata(headerid,supplierid) {
        var supp=$('#infosuppname').text();
        var porderid=$('#recordIds').val();
        var currentdate=$('#currentdate').val();
        $('#supplieradds').prop('disabled', false);
        $('#poid').val(porderid);
        $('.lbl').html('0.00');
        $('.prinput   ').val('0.00');
        
        $('#legendid').html('Purchase information for '+supp);
        $.ajax({
            type: "GET",
            url: "{{ url('addorderdata') }}/"+headerid+"/"+supplierid,
            data: "",
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
                    $('#giveordermodals').modal('show');
                },
                error: function (jqXHR, textStatus, errorThrown) {
                switch (textStatus) {
                    case 'timeout':
                        toastrMessage('error','The request timed out. Please try again later','Error');
                        break;
                    case 'error':
                        toastrMessage('error','An error occurred:'+errorThrown,'Error');
                    break;
                    case 'abort':
                        toastrMessage('error','The request was aborted.','Error');
                    break;
                    case 'parsererror':
                        toastrMessage('error','Parsing JSON request failed.','Error');
                    break;
                    default:
                            toastrMessage('error','AJAX Error: '+textStatus+','+errorThrown,'Error');
                        break;
                }
            
            },
            success: function (response) {
                $('#iswhere').val('Evaluation');
                $('#posupplierid').val(response.id);
                    var arrayData=response.comiditylist;
                    if (Array.isArray(arrayData) && arrayData.length === 0) {
                        
                    console.log('The array is empty.');
                    $('#supplieradds').prop('disabled', false);
                    } else if (Array.isArray(arrayData)) {
                        
                        console.log('The array is not empty. Length: ' + arrayData.length);
                        $('#supplieradds').prop('disabled', true);
                    } else {
                        
                        console.log('The response does not contain an array');
                    }
                switch (response.type) {
                    case 'Goods':
                            $('#financailevdynamicTable').show();
                            $('#financailevdynamicTablecommdity').hide();
                        break;
                    default:
                            $('#financailevdynamicTable').hide();
                            $('#financailevdynamicTablecommdity').show();
                            appendcommodity(response.comiditylist,addorderdata);
                        break;
                }
            }
        });
    }
    function getorderdata(headerid,supplierid) {
        $('.lbl').html('0.00');
        $('.prinput').val('0.00');
        $('#supplieradds').prop('disabled', false);
        var porderid=$('#recordIds').val();
        var name=$('#suppliername').val();
        $('#posupplierid').val(supplierid);
        $('#poid').val(porderid);
        $('#legendid').html('Purchase Order for '+name);
        var currentdate=$('#currentdate').val();
        $.ajax({
            type: "GET",
            url: "{{ url('getwineditems') }}/"+headerid+"/"+supplierid,
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
                    $('#financailevdynamicTable').hide();
                    $('#financailevdynamicTablecommdity').show();
                },
            success: function (response) {
                $('#iswhere').val(response.from);
                if(response.success){

                        $.each(response.supplinfo, function (index, value) { 
                            $('#istaxable').val(value.istaxable);
                            flatpickr('#orderdate', { dateFormat: 'Y-m-d',clickOpens:true,maxDate:currentdate});
                            flatpickr('#deliverydate', { dateFormat: 'Y-m-d',clickOpens:true,minDate:currentdate});
                            flatpickr('#preparedate', { dateFormat: 'Y-m-d',clickOpens:false,maxDate:currentdate});

                            var preparedate=value.preparedate;
                            preparedate=(preparedate === undefined || preparedate === null || preparedate === '') ? 'EMPTY' : preparedate;
                            switch (preparedate) {
                                case 'EMPTY':
                                    $('#preparedate').val(currentdate);
                                    break;
                                default:
                                    $('#preparedate').val(value.preparedate);
                                    break;
                            }
                            
                            $('#orderdate').val(value.orderdate);
                            $('#deliverydate').val(value.deliverydate);
                            $('#warehouse').select2('destroy');
                            $('#warehouse').val(value.store).select2();
                            $('#paymenterm').select2('destroy');
                            $('#paymenterm').val(value.paymenterm).select2();
                            switch (value.istaxable) {
                                case 1:
                                    $('#customCheck1').prop('checked', true);
                                    break;
                                default:
                                    $('#customCheck1').prop('checked', false);
                                    break;
                            }
                        });
                        switch (response.from) {
                            case 'orders':
                                appendcommodityorders(response.comiditylist);
                                break;
                            
                            default:
                                appendcommodity(response.comiditylist,'getorderdata');
                                break;
                        }
                        switch (response.rank) {
                            case 1:
                                $('#supplieradds').hide();
                            break;
                            case 0:
                                $('#supplieradds').hide();
                            break;
                            default:
                                $('#supplieradds').show();
                            break;
                        }
                        $('.fset').show();
                        $('#giveordermodals').modal('show');
                }
            }
        });
    }
    
    function setminilog(actions) {
        var list='';
        var icons=''
        var reason='';
        var addedclass='';
        $('#ulist').empty();
        $.each(actions, function (index, value) { 
            switch (value.status) {
                case 'Pending':
                        icons='warning timeline-point';
                        addedclass='text-warning';
                        switch (value.action) {
                            case 'Back To pending':
                                reason='<p class="text-muted"><b><u>Reason:</u></b>'+value.reason+'.</p>';
                                break;
                            default:
                                reason='';
                                break;
                        }
                break;
                case 'Draft':
                        icons='secondary timeline-point';
                        addedclass='text-secondary';
                        switch (value.action) {
                            case 'Back To Draft':
                                reason='<p class="text-muted"><b><u>Reason:</u></b>'+value.reason+'.</p>';
                                
                                break;
                            default:
                                reason='';
                                break;
                        }
                        break;
                case 'Approve':
                        icons='success timeline-point';
                        addedclass='text-success';
                        reason='';
                break;
                case 'Reviewed':
                        icons='primary timeline-point';
                        addedclass='text-primary';
                        reason='';
                break;
                case 'Created':
                        icons='secondary timeline-point';
                        addedclass='text-secondary';
                        switch (value.action) {
                            case 'Back To Draft':
                                reason='<p class="text-muted"><b><u>Reason:</u></b>'+value.reason+'.</p>';
                                
                                break;
                            default:
                                reason='';
                                break;
                        }
                break;
                case 'Edited':
                        icons='warning timeline-point';
                        addedclass='text-warning';
                        reason='';
                break;

                case 'Undo Review':
                        icons='warning timeline-point';
                        addedclass='text-warning';
                        reason='';
                break;
                
                case 'Verify':
                    icons='primary timeline-point';
                    addedclass='text-primary';
                    reason='';
                break;
                
                case 'Void':
                    icons='danger timeline-point';
                    addedclass='text-danger';
                    reason='<p class="text-muted"><b><u>Reason:</u></b>'+value.reason+'.</p>';
                    break;
                case 'Rejected':
                    icons='danger timeline-point';
                    addedclass='text-danger';
                    reason='<p class="text-muted"><b><u>Reason:</u></b>'+value.reason+'.</p>';
                break;
                default:
                    icons='danger timeline-point';
                    addedclass='text-danger';
                    reason='';
                    break;
            }
            list+='<li class="timeline-item"><span class="timeline-point timeline-point-'+icons+' timeline-point-indicator"></span><div class="timeline-header mb-sm-0 mb-0"><h6 class="mb-0 '+addedclass+'">'+value.action+'</h6><span class="text-muted"><i class="fa-regular fa-user"></i>'+value.user+'</span></br><span class="text-muted"><i class="fa-regular fa-clock"></i> '+value.time+'</span>'+reason+'</div></li>';
        });
        $('#ulist').append(list);
    }
    function suppliersetminilog(actions) {
        var list='';
        var icons=''
        var reason='';
        var addedclass='';
        $('#ulistsupplier').empty();
        $.each(actions, function (index, value) {
            var reason=''; 
            switch (value.status) {
                case 'Void':
                        icons='danger timeline-point';
                        addedclass='text-danger';
                        reason='<div class="divider divider-secondary"><div class="divider-text text-muted">Reason</div></div><p class="text-muted">'+value.reason+'.</p>';
                break;
                case 'Approve':
                        icons='success timeline-point';
                        addedclass='text-success';
                        
                break;
                case 'Verify':
                        icons='secondary timeline-point';
                        addedclass='text-secondary';
                break;

                case 'Edited':
                        icons='warning timeline-point';
                        addedclass='text-warning';
                break;
                case 'Draft':
                        icons='warning timeline-point';
                        addedclass='text-warning';
                break;
                case 'Pending':
                        icons='warning timeline-point';
                        addedclass='text-warning';
                break;
                case 'Created':
                        icons='warning timeline-point';
                        addedclass='text-warning';
                break;
                
                default:
                    icons='danger timeline-point';
                    addedclass='text-danger';
                    reason='';
                    break;
            }
            list+='<li class="timeline-item"><span class="timeline-point timeline-point-'+icons+' timeline-point-indicator"></span><div class="timeline-header mb-sm-0 mb-0"><h6 class="mb-0 '+addedclass+'">'+value.action+'</h6><span class="text-muted"><i class="fa-regular fa-user"></i>'+value.user+'</span></br><span class="text-muted"><i class="fa-regular fa-clock"></i> '+value.time+'</span>'+reason+'</div></li>';
        });
        $('#ulistsupplier').append(list);
    }
    function appendcommodityorders(product) {
        var tables='';
        var j=0;
        $("#financailevdynamicTablecommdity > tbody").empty();
        $.each(product, function (index, value) { 
                ++j;
                ++m;
                supplyid=value.supplyworeda;
                supploption=value.origin;
                tables='<tr id="row'+j+'" class="financialevdynamic-commudity financialevsupp">'+
                '<td style="text-align:center;">'+j+'</td>'+
                '<td><select id="evitemNameSl'+m+'" class="select2 form-control form-control-lg eName" name="fevrow['+m+'][evItemId]"></select></td>'+
                '<td><select id="evcropyear'+m+'" class="select2 form-control evcropyear" onchange="sourceVal(this)" name="fevrow['+m+'][evcropyear]"></select></td>'+
                '<td><select id="evcoffeproccesstype'+m+'" class="select2 form-control evcoffeproccesstype" onchange="sourceVal(this)" name="fevrow['+m+'][evproccesstype]"></select></td>'+
                '<td><select id="grade'+m+'" class="select2 form-control uom" onchange="sourceVal(this)" name="fevrow['+m+'][grade]"></select></td>'+
                '<td><select id="uom'+m+'" class="select2 form-control uompe" onchange="sourceVal(this)" name="fevrow['+m+'][uom]"></select></td>'+
                '<td><input type="text" name="fevrow['+m+'][qauntity]" placeholder="Enter quantity" id="fevqauntity'+m+'" value="'+value.qty+'" class="fevqauntity form-control" onkeyup="CalculateTotal(this)" onkeypress="return ValidateNum(event);"/></td>'+
                '<td><input type="text" name="fevrow['+m+'][netkg]" placeholder="QTY(KG)" id="netkg'+m+'" value="'+value.totalKg+'" class="netkg form-control" onkeypress="return ValidateNum(event);" readonly/></td>'+
                '<td><input type="text" name="fevrow['+m+'][ton]" placeholder="TON" id="ton'+m+'" value="'+value.ton+'" class="ton form-control" onkeypress="return ValidateNum(event);" readonly/></td>'+
                '<td><input type="text" name="fevrow['+m+'][feresula]" placeholder="feresula" id="feresula'+m+'" value="'+value.feresula+'" class="feresula form-control" onkeypress="return ValidateNum(event);" readonly/></td>'+
                '<td><input type="text" name="fevrow['+m+'][finalprice]" placeholder="final price" id="finalprice'+m+'"  value="'+value.price+'" class="finalprice form-control" onkeypress="return ValidateNum(event);" readonly/></td>'+
                '<td><input type="text" name="fevrow['+m+'][Total]" placeholder="Total" id="fevtotal'+m+'" value="'+value.Total+'" class="fevtotal form-control" onkeypress="return ValidateNum(event);" readonly/></td>'+
                '<td><select id="continue'+m+'" class="select2 form-control continue" onchange="sourceVal(this)" name="fevrow['+m+'][continue]"></select></td>'+
                '<td style="display:none;"><input type="hidden" name="fevrow['+m+'][pdetid]" id="pdetid'+m+'" value="'+value.id+'" class="pdetid form-control" readonly="true" style="font-weight:bold;"/></td>'+
                '<td style="display:none;"><input type="hidden" name="fevrow['+m+'][rank]" id="rank'+m+'" value="'+value.rank+'" class="rank form-control" readonly="true" style="font-weight:bold;"/></td>'+
                '<td style="display:none;"><input type="hidden" name="fevrow['+m+'][reason]" id="reason'+m+'" class="reason form-control" readonly="true" style="font-weight:bold;" /></td>'+
                '<td style="display:none;"><input type="hidden" name="fevrow['+m+'][vals]" id="evvals'+m+'" class="vals form-control" readonly="true" style="font-weight:bold;" value="'+m+'"/></td>'+
            '</tr>';
            $("#financailevdynamicTablecommdity > tbody").append(tables);
            var options2 = '<option selected value="'+supplyid+'">'+supploption+'</option>';
            var proccesstypeoption2='<option selected value="'+value.proccesstype+'">'+value.proccesstype+'</option>';
            var cropyearoption2='<option selected value="'+value.cropyear+'">'+value.cropyear+'</option>';
            var uomoptions='<option selected value="'+value.uomid+'" title="'+value.uomamount+'">'+value.uomname+'</option>';
            var continoptions='<option selected value="'+value.status+'">'+value.status+'</option>';
            var uopeyonappedn=$("#uom > option").clone();
            var contin=$("#continue > option").clone();
            var gradeoption=$("#coffeegrade > option").clone();
            var gradeoption2='<option selected value="'+value.grade+'">'+value.grade+'</option>';

            $('#evitemNameSl'+m).empty();
            $('#evitemNameSl'+m).append(options2);
            $('#evitemNameSl'+m).select2();

            $('#evcoffeproccesstype'+m).append(proccesstypeoption2);
            $('#evcoffeproccesstype'+m).select2({placeholder: "Select proccess type"});

            $('#evcropyear'+m).append(cropyearoption2);
            $('#evcropyear'+m).select2({placeholder: "Select crop year"});

            $('#grade'+m).append(gradeoption);
            $("#grade"+m+" option[value='"+value.grade+"']").remove();
            $('#grade'+m).append(gradeoption2);
            $('#grade'+m).select2({placeholder: "Select grade"});

            $('#uom'+m).append(uopeyonappedn);
            $("#uom"+m+" option[value='"+value.uomid+"']").remove();
            $('#uom'+m).append(uomoptions);
            $('#uom'+m).select2({placeholder: "Select unit measurement"});
            
            $('#continue'+m).append(contin);
            $("#continue"+m+" option[value='"+value.status+"']").remove();
            $('#continue'+m).append(continoptions);
            $('#continue'+m).select2({placeholder: "Select status"});

        });
        var count=$("#financailevdynamicTablecommdity > tbody tr").length;
        $('#numberofItemsLbl').html(count);
        CalculateGrandTotal();
    }

    function appendcommodity(product,getoradd) {
        var tables='';
        var j=0;
        switch (getoradd) {
            case 'getorderdata':
                    $("#financailevdynamicTablecommdity > tbody").empty();
                break;
        
            default:

                break;
        }
        
        $.each(product, function (index, value) { 
                ++j;
                ++m;
                supplyid=value.supplyworeda;
                supploption=value.supplyorigin;
                tables='<tr id="row'+j+'" class="financialevdynamic-commudity financialevsupp">'+
                '<td style="text-align:center;">'+j+'</td>'+
                '<td><select id="evitemNameSl'+m+'" class="select2 form-control form-control-lg eName" name="fevrow['+m+'][evItemId]"></select></td>'+
                '<td><select id="evcropyear'+m+'" class="select2 form-control evcropyear" onchange="sourceVal(this)" name="fevrow['+m+'][evcropyear]"></select></td>'+
                '<td><select id="evcoffeproccesstype'+m+'" class="select2 form-control evcoffeproccesstype" onchange="sourceVal(this)" name="fevrow['+m+'][evproccesstype]"></select></td>'+
                '<td><select id="grade'+m+'" class="select2 form-control grade" onchange="sourceVal(this)" name="fevrow['+m+'][grade]"></select></td>'+
                '<td><select id="uom'+m+'" class="select2 form-control uompe" onchange="sourceVal(this)" name="fevrow['+m+'][uom]"></select></td>'+
                '<td><input type="text" name="fevrow['+m+'][qauntity]" placeholder="Enter quantity" id="fevqauntity'+m+'" class="fevqauntity form-control" onkeyup="CalculateTotal(this)" onkeypress="return ValidateNum(event);"/></td>'+
                '<td><input type="text" name="fevrow['+m+'][netkg]" placeholder="QTY(KG)" id="netkg'+m+'" class="netkg form-control" onkeypress="return ValidateNum(event);" readonly/></td>'+
                '<td><input type="text" name="fevrow['+m+'][ton]" placeholder="TON" id="ton'+m+'" class="ton form-control" onkeypress="return ValidateNum(event);" readonly/></td>'+
                '<td><input type="text" name="fevrow['+m+'][feresula]" placeholder="feresula" id="feresula'+m+'"  class="feresula form-control" onkeypress="return ValidateNum(event);" readonly/></td>'+
                '<td><input type="text" name="fevrow['+m+'][finalprice]" placeholder="final price" id="finalprice'+m+'" value="'+value.finalprice+'" class="finalprice form-control" onkeypress="return ValidateNum(event);" readonly/></td>'+
                '<td><input type="text" name="fevrow['+m+'][Total]" placeholder="Total" id="fevtotal'+m+'" class="fevtotal form-control" onkeypress="return ValidateNum(event);" readonly/></td>'+
                '<td><select id="continue'+m+'" class="select2 form-control continue" onchange="sourceVal(this)" name="fevrow['+m+'][continue]"></select></td>'+
                '<td style="display:none;"><input type="hidden" name="fevrow['+m+'][reason]" id="reason'+m+'" class="reason form-control" readonly="true" style="font-weight:bold;" /></td>'+
                '<td style="display:none;"><input type="hidden" name="fevrow['+m+'][rank]" id="rank'+m+'" class="rank form-control" readonly="true" style="font-weight:bold;" value="'+value.rank+'"/></td>'+
                '<td style="display:none;"><input type="hidden" name="fevrow['+m+'][pdetid]" id="pdetid'+m+'" class="pdetid form-control" readonly="true" style="font-weight:bold;"/></td>'+
                '<td style="display:none;"><input type="hidden" name="fevrow['+m+'][vals]" id="evvals'+m+'" class="vals form-control" readonly="true" style="font-weight:bold;" value="'+m+'"/></td>'+
            '</tr>';
            $("#financailevdynamicTablecommdity > tbody").append(tables);
            var options2 = '<option selected value="'+supplyid+'">'+supploption+'</option>';
            var proccesstypeoption2='<option selected value="'+value.proccesstype+'">'+value.proccesstype+'</option>';
            var cropyearoption2='<option selected value="'+value.cropyear+'">'+value.cropyear+'</option>';
            var uomoptions='<option selected value="'+value.uomid+'">'+value.uomname+'</option>';
            var continoptions='<option selected value="Confirm">Confirm</option>';
            var uopeyonappedn=$("#uom > option").clone();
            var contin=$("#continue > option").clone();
            var gradeoption=$("#coffeegrade > option").clone();
            var gradeoption2='<option selected value="'+value.grade+'">'+value.grade+'</option>';
            $('#evitemNameSl'+m).empty();
            $('#evitemNameSl'+m).append(options2);
            $('#evitemNameSl'+m).select2();

            $('#evcoffeproccesstype'+m).append(proccesstypeoption2);
            $('#evcoffeproccesstype'+m).select2({placeholder: "Select proccess type"});

            $('#evcropyear'+m).append(cropyearoption2);
            $('#evcropyear'+m).select2({placeholder: "Select crop year"});

            $('#uom'+m).append(uopeyonappedn);
            $("#uom"+m+" option[value='"+uomoptions+"']").remove();
            $('#uom'+m).append(uomoptions);
            $('#uom'+m).select2({placeholder: "Select unit measurement"});

            $('#grade'+m).append(gradeoption);
            $("#grade"+m+" option[value='"+value.grade+"']").remove();
            $('#grade'+m).append(gradeoption2);
            $('#grade'+m).select2({placeholder: "Select grade"});
            
            $('#continue'+m).append(contin);
            $("#continue"+m+" option[value='Confirm']").remove();
            $('#continue'+m).append(continoptions);
            $('#continue'+m).select2({placeholder: "Select SSStatus"});
        });
        var count=$("#financailevdynamicTablecommdity > tbody tr").length;
        $('#numberofItemsLbl').html(count);
    }
    
    function sourceVal(ele){
        var idval = $(ele).closest('tr').find('.vals').val();
        var inputid = ele.getAttribute('id');
        switch (inputid) {
            case 'uom'+idval:
                var quantity = $(ele).closest('tr').find('.fevqauntity').val()||0;
                var prcie = $(ele).closest('tr').find('.finalprice').val()||0; 
                var uom= $(ele).closest('tr').find('.uom').val()||0; 
                var uomount = $('#uom'+idval+' option[value='+uom+']').attr('title');
                var totalkg=(parseFloat(quantity)*parseFloat(uomount)).toFixed(2);
                var feresula=(parseFloat(totalkg)/17).toFixed(2);
                var total=(parseFloat(prcie)*parseFloat(feresula)).toFixed(2);
                $(ele).closest('tr').find('.fevtotal').val(total);
                $(ele).closest('tr').find('.netkg ').val(totalkg);
                $(ele).closest('tr').find('.feresula').val(feresula);
                CalculateGrandTotal();
                break;
                case 'continue'+idval:
                    var status=$(ele).closest('tr').find('.continue').val();
                    var itemid=$(ele).closest('tr').find('.eName').val();
                    var headerid=$('#poid').val();
                    switch (status) {
                        case 'Cancel':
                            requireconfirmation(idval,status);
                            break;
                        
                        default:
                            checkfordupplication(headerid,itemid,idval,status);
                            break;
                    }
                break;
                
            default:
                break;
        }
    }
    function requireconfirmation(idval,status) {
        $('#cancelstatus').val(status);
        $('#elementid').val(idval);
        $('#pocancelmodal').modal('show');
    }
    function checkfordupplication(headerid,itemid,idval,status) {
        var supplierid=$('#posupplierid').val();
        $.ajax({
            type: "GET",
            url: "{{ url('checkfordupplication') }}/"+headerid+'/'+itemid+'/'+supplierid,
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
                error: function (jqXHR, textStatus, errorThrown) {
                switch (textStatus) {
                    case 'timeout':
                        toastrMessage('error','The request timed out. Please try again later','Error');
                        break;
                    case 'error':
                        toastrMessage('error','An error occurred:'+errorThrown,'Error');
                    break;
                    case 'abort':
                        toastrMessage('error','The request was aborted.','Error');
                    break;
                    case 'parsererror':
                        toastrMessage('error','Parsing JSON request failed.','Error');
                    break;
                    default:
                            toastrMessage('error','AJAX Error: '+textStatus+','+errorThrown,'Error');
                        break;
                }
            
            },
            success: function (response) {
                switch (response.exist) {
                    case true:
                        $('#continue'+idval).select2('destroy');
                        $('#continue'+idval).val('Cancel').select2();
                        toastrMessage('error','This product has been winned by other suppliers','errors')
                        break;
                    default:
                        CalculateGrandTotal();
                        break;
                }
            }
        });
    }
    function directuomval(ele) {
        var reference=$('#reference').val();
        var idval = $(ele).closest('tr').find('.directvals').val();
        var quantity = $(ele).closest('tr').find('.directfevqauntity').val()||0;
        var prcie = $(ele).closest('tr').find('.directfinalprice').val()||0; 
        var uom= $(ele).closest('tr').find('.directuom').val()||0; 
        var uomount = $('#uom'+idval+' option[value='+uom+']').attr('title')||0;
        var bagwieght=$('#uom'+idval+' option[value='+uom+']').attr('bagwieght')||0;
        var totabagweight=(parseFloat(bagwieght)*parseFloat(quantity)).toFixed(2);

        var totalkg=(parseFloat(quantity)*parseFloat(uomount)).toFixed(2);
        var netkg=(parseFloat(totalkg)-parseFloat(totabagweight)).toFixed(2);
        var ton=(parseFloat(netkg)/1000).toFixed(2);
        var feresula=parseFloat(netkg)/17;
            feresula = Number(feresula).toFixed(2);
        var total=parseFloat(prcie)*parseFloat(feresula);
        
        $(ele).closest('tr').find('.directon').val(ton);
        $(ele).closest('tr').find('.directfevtotal').val(total);
        $(ele).closest('tr').find('.totalkg').val(totalkg);
        $(ele).closest('tr').find('.directferesula').val(feresula);
        $(ele).closest('tr').find('.directnetkg').val(netkg);
        $(ele).closest('tr').find('.bagweight').val(totabagweight);
        $('#select2-uom'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
            directCalculateGrandTotal();
    }
    function goodCalculateTotal(ele) {
        const $row = $(ele).closest('tr');
        const itemId = $row.find('.eName').val();
        const idVal = $row.find('.goodsdirectvals').val();
        const qty = $row.find('.goodqty').val()||0;
        const unitprice = $row.find('.goodprice').val()||0;

        let total=parseFloat(qty)*parseFloat(unitprice)
            total = Number(total).toFixed(2);
            $row.find('.goodtotal ').val(total);
            goodCalculateGrandTotal();
    }
    function directCalculateTotal(ele) {
        var reference=$('#reference').val();
        var idval = $(ele).closest('tr').find('.directvals').val();
        var quantity = $(ele).closest('tr').find('.directfevqauntity').val()||0;
        var prcie = $(ele).closest('tr').find('.directfinalprice').val()||0;
        var uom= $(ele).closest('tr').find('.directuom').val()||0;
        var uomount = $('#uom'+idval+' option[value='+uom+']').attr('title')||0;
        var bagwieght=$('#uom'+idval+' option[value='+uom+']').attr('bagwieght')||0;

        var totabagweight=(parseFloat(bagwieght)*parseFloat(quantity));
            totabagweight = Number(totabagweight).toFixed(2);
        var totalkg=(parseFloat(quantity)*parseFloat(uomount));
            totalkg = Number(totalkg).toFixed(2);
        var netkg=(parseFloat(totalkg)-parseFloat(totabagweight));
            netkg = Number(netkg).toFixed(2);
        var feresula=(parseFloat(netkg)/17);
            feresula = Number(feresula).toFixed(2);
        var ton=(parseFloat(netkg)/1000);
            ton = Number(ton).toFixed(2);
        var total=(parseFloat(prcie)*parseFloat(feresula));
            total = Number(total).toFixed(2);
        $(ele).closest('tr').find('.bagweight').val(totabagweight);
        $(ele).closest('tr').find('.directfevtotal').val(total);
        $(ele).closest('tr').find('.totalkg').val(totalkg);
        $(ele).closest('tr').find('.directnetkg').val(netkg);
        switch (reference) {
            case 'Direct':
                $(ele).closest('tr').find('.directton').val(ton);
                break;
            default:
                $('#directon'+idval).val(ton);
                break;
        }
        $(ele).closest('tr').find('.directferesula').val(feresula);
        // $('#directfinalprice'+idval).css("background", "white");
        $('#directfevqauntity'+idval).css("background", "white");
        directCalculateGrandTotal();
    }
    function CalculateTotal(ele) {
        var idval = $(ele).closest('tr').find('.vals').val();
        var quantity = $(ele).closest('tr').find('.fevqauntity').val()||0;
        var prcie=$(ele).closest('tr').find('.finalprice').val()||0;
        var uom= $(ele).closest('tr').find('.uompe').val()||0;

        console.log('uomid='+uom);
        var uomount = $('#uom'+idval+' option[value='+uom+']').attr('title');
        console.log('uom='+uom);
        console.log('uomamount='+uomount);

        var totalkg=(parseFloat(quantity)*parseFloat(uomount)).toFixed(2);
        var ton=(parseFloat(totalkg)*1000).toFixed(2);

        var feresula=(parseFloat(totalkg)/17).toFixed(2);
        var total=(parseFloat(prcie)*parseFloat(feresula)).toFixed(2);
        $(ele).closest('tr').find('.fevtotal').val(total);
        $(ele).closest('tr').find('.netkg ').val(totalkg);
        $(ele).closest('tr').find('.ton').val(ton);
        $(ele).closest('tr').find('.feresula').val(feresula);
        $('#fevqauntity'+idval).css("background", "white");
        CalculateGrandTotal();
    }
    function goodCalculateGrandTotal(){
            var subtotal=0;
            var tax=0;
            var grandTotal=0;
            var vat=0;
            var withold=0;
            var aftertax=0;
            var netpay=0;
            var qty=0;
            var unitprice=0;
            
            $("#goodsdynamictables > tbody tr").each(function(i, val){
                subtotal += parseFloat($(this).find('td').eq(5).find('input').val()||0);
                unitprice += parseFloat($(this).find('td').eq(4).find('input').val()||0);
                qty += parseFloat($(this).find('td').eq(3).find('input').val()||0);
            });
                if ($('#directcustomCheck1').is(':checked')) {
                    var percentoadd=parseFloat(15/100)+1;
                    aftertax=parseFloat(subtotal) * parseFloat(percentoadd);
                    $('#directtaxtr').show();
                    $('#directgrandtotaltr').show();
                    tax=parseFloat(aftertax)-parseFloat(subtotal);  //recently addedd comment uplad
                    // subtotal=parseFloat(subtotal)-parseFloat(tax);
                } else {
                    $('#directtaxtr').hide();
                    $('#directgrandtotaltr').hide();
                }
                if(parseFloat(subtotal)>=10000){
                    withold=(parseFloat(subtotal)*2)/100;
                    $('#directwitholdingTr').show();
                    $('#directnetpayTr').show();
                    $('#directvatTr').hide();
                } 
                else{
                    $('#directwitholdingTr').hide();
                    $('#directnetpayTr').hide();
                    $('#directvatTr').hide();
                    
                }
                grandTotal=parseFloat(subtotal)+parseFloat(tax);
                netpay=parseFloat(grandTotal)-parseFloat(withold);
                $('#directsubtotalLbl').html(numformat(subtotal.toFixed(2)));
                $('#directtaxLbl').html(numformat(tax.toFixed(2)));
                $('#directgrandtotalLbl').html(numformat(grandTotal.toFixed(2)));
                $('#directwitholdingAmntLbl').html(numformat(withold.toFixed(2)));
                $('#directvatAmntLbl').html(numformat(vat.toFixed(2)));
                $('#directnetpayLbl').html(numformat(netpay.toFixed(2)));
                $('#directsubtotali').val(subtotal.toFixed(2));
                $('#directtaxi').val(tax.toFixed(2));
                $('#directgrandtotali').val(grandTotal.toFixed(2));
                $('#directwitholdingAmntin').val(withold.toFixed(2));
                $('#directvatAmntin').val(vat.toFixed(2));
                $('#directnetpayin').val(netpay.toFixed(2));
                $('#qtytotal').html(numformat(qty.toFixed(2)));
                $('#unitpricetotal').html(numformat(unitprice.toFixed(2)));
                $('#goodpricetotal').html(numformat(subtotal.toFixed(2)));
        }
    function directCalculateGrandTotal() {
        var subtotal=0;
        var tax=0;
        var grandTotal=0;
        var vat=0;
        var withold=0;
        var aftertax=0;
        var netpay=0;
        var nofbagtotal=0;
        var bagweighttotal=0;
        var totalkgtotal=0;
        var netkgtotal=0;
        var tontotal=0;
        var feresulatotal=0;
        var totalprice=0;
        var total=0;
        $("#directdynamicTablecommdity > tbody tr").each(function(i, val){
            subtotal += parseFloat($(this).find('td').eq(13).find('input').val()||0);
            nofbagtotal += parseFloat($(this).find('td').eq(6).find('input').val()||0);
            bagweighttotal += parseFloat($(this).find('td').eq(7).find('input').val()||0);
            totalkgtotal += parseFloat($(this).find('td').eq(8).find('input').val()||0);
            netkgtotal += parseFloat($(this).find('td').eq(9).find('input').val()||0);
            tontotal += parseFloat($(this).find('td').eq(10).find('input').val()||0);
            feresulatotal += parseFloat($(this).find('td').eq(11).find('input').val()||0);
            totalprice += parseFloat($(this).find('td').eq(12).find('input').val()||0);
            total += parseFloat($(this).find('td').eq(13).find('input').val()||0);
        });

        if ($('#directcustomCheck1').is(':checked')) {
            var percentoadd=parseFloat(15/100)+1;
            aftertax=parseFloat(subtotal) * parseFloat(percentoadd);
            $('#directtaxtr').show();
            $('#directgrandtotaltr').show();
            tax=parseFloat(aftertax)-parseFloat(subtotal);  //recently addedd comment uplad
            // subtotal=parseFloat(subtotal)-parseFloat(tax);
        } else {
            $('#directtaxtr').hide();
            $('#directgrandtotaltr').hide();
        }
        if(parseFloat(subtotal)>=10000){
            withold=(parseFloat(subtotal)*2)/100;
            $('#directwitholdingTr').show();
            $('#directnetpayTr').show();
            $('#directvatTr').hide();
        } 
        else{
            $('#directwitholdingTr').hide();
            $('#directnetpayTr').hide();
            $('#directvatTr').hide();
            
        }
        grandTotal=parseFloat(subtotal)+parseFloat(tax);
        netpay=parseFloat(grandTotal)-parseFloat(withold);
        $('#directsubtotalLbl').html(numformat(subtotal.toFixed(2)));
        $('#directtaxLbl').html(numformat(tax.toFixed(2)));
        $('#directgrandtotalLbl').html(numformat(grandTotal.toFixed(2)));
        $('#directwitholdingAmntLbl').html(numformat(withold.toFixed(2)));
        $('#directvatAmntLbl').html(numformat(vat.toFixed(2)));
        $('#directnetpayLbl').html(numformat(netpay.toFixed(2)));

        $('#directsubtotali').val(subtotal.toFixed(2));
        $('#directtaxi').val(tax.toFixed(2));
        $('#directgrandtotali').val(grandTotal.toFixed(2));
        $('#directwitholdingAmntin').val(withold.toFixed(2));
        $('#directvatAmntin').val(vat.toFixed(2));
        $('#directnetpayin').val(netpay.toFixed(2));

        $('#nofbagtotal').html(numformat(nofbagtotal.toFixed(2)));
        $('#bagweighttotal').html(numformat(bagweighttotal.toFixed(2)));
        $('#kgtotal').html(numformat(totalkgtotal.toFixed(2)));
        $('#netkgtotal').html(numformat(netkgtotal.toFixed(2)));
        $('#tontotal').html(numformat(tontotal.toFixed(2)));
        $('#priceferesula').html(numformat(feresulatotal.toFixed(2)));
        $('#pricetotal').html(numformat(totalprice.toFixed(2)));
        $('#totalpricetotal').html(numformat(total.toFixed(2)));

    }
    function CalculateGrandTotal() {
        var subtotal=0;
        var tax=0;
        var grandTotal=0;
        var vat=0;
        var withold=0;
        var netpay=0;
        $("#financailevdynamicTablecommdity > tbody tr").each(function(i, val){
            var status=$(this).find('td').eq(12).find('select').val();
            switch (status) {
                case 'Confirm':
                    subtotal += parseFloat($(this).find('td').eq(11).find('input').val()||0);
                    break;
                default:
                    break;
            }
        });
        if ($('#customCheck1').is(':checked')) {
            aftertax=parseFloat(subtotal) / (1 + (15 / 100));
            tax=parseFloat(subtotal)-parseFloat(aftertax);
            subtotal=parseFloat(subtotal)-parseFloat(tax);
            $('#taxtr').show();
            $('#grandtotaltr').show();
        } else {
            $('#taxtr').hide();
            $('#grandtotaltr').hide();
        }
        if(parseFloat(subtotal)>=10000){
            withold=(parseFloat(subtotal)*2)/100;
            $('#witholdingTr').show();
            $('#netpayTr').show();
        } 
        else{
            $('#witholdingTr').hide();
            $('#netpayTr').hide();
        }
        grandTotal=parseFloat(subtotal)+parseFloat(tax);
        netpay=parseFloat(grandTotal)-parseFloat(vat)-parseFloat(withold);
        $('#subtotali').val(subtotal.toFixed(2));
        $('#taxi').val(tax.toFixed(2));
        $('#grandtotali').val(grandTotal.toFixed(2));
        $('#witholdingAmntin').val(withold.toFixed(2));
        $('#vatAmntin').val(vat.toFixed(2));
        $('#netpayin').val(netpay.toFixed(2));

        $('#subtotalLbl').html(numformat(subtotal.toFixed(2)));
        $('#taxLbl').html(numformat(tax.toFixed(2)));
        $('#grandtotalLbl').html(numformat(grandTotal.toFixed(2)));
        $('#witholdingAmntLbl').html(numformat(withold.toFixed(2)));
        $('#vatAmntLbl').html(numformat(vat.toFixed(2)));
        $('#netpayLbl').html(numformat(netpay.toFixed(2)));
        
    }
    $('#customCheck1').click(function(){
        if ($('#customCheck1').is(':checked')) {
            $('#istaxable').val('1');
        } else{
            $('#istaxable').val('0');
        }
        CalculateGrandTotal();
    });
    $('#directcustomCheck1').click(function(){
        if ($('#directcustomCheck1').is(':checked')) {
            $('#directistaxable').val('1');
        } else{
            $('#directistaxable').val('0');
        }
        var type=$('#purchaseordertype').val()||0;
        switch (type) {
            case 'Goods':
                goodCalculateGrandTotal();
                break;
            default:
                directCalculateGrandTotal();
                break;
        }
        
    });

    function calculatetaxableforeeach() {
            var percentoadd=parseFloat(15/100)+1;
            $('#directdynamicTablecommdity > tbody > tr').each(function() {
                        var price = $(this).find('td').eq(12).find('input').val()||0;
                        var feresula=$(this).find('td').eq(11).find('input').val()||0;
                        price=parseFloat(price)/parseFloat(percentoadd);
                        total=parseFloat(price)*parseFloat(feresula);
                        total = Number(total).toFixed(2);
                        $(this).find('td').eq(12).find('input').val(price);
                        $(this).find('td').eq(13).find('input').val(total);
                        
                    });
        }
        
        function undocalculatetaxableforeeach() {
            var percentoadd=parseFloat(15/100)+1;
            $('#directdynamicTablecommdity > tbody > tr').each(function() {
                    var price = $(this).find('td').eq(12).find('input').val()||0;
                    var feresula=$(this).find('td').eq(11).find('input').val()||0;
                        price=(parseFloat(price) * parseFloat(percentoadd)).toFixed(2);
                        total=(parseFloat(price)*parseFloat(feresula)).toFixed(2);
                        $(this).find('td').eq(12).find('input').val(price);
                        $(this).find('td').eq(13).find('input').val(total);
                    });
        }

    function numformat(val){
        while (/(\d+)(\d{3})/.test(val.toString())){
        val = val.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
        }
        return val;
    }
    $('#savebutton').click(function(){
        var reference=$('#reference').val();
        switch (reference) {
            case 'Direct':
                    const purchaseType = $('#purchaseordertype').val() || 0;
                    const $tbody = getTbodyBasedOnPurchaseType(purchaseType);
                    if (isTableEmpty($tbody)) {
                        showToastrMessage('error', 'Please add atleast first commodity', 'Error!');
                    } else{
                        savederaftdata();
                    }
                    
                break;
            default:
                savederaftdata();
                break;
        }
        
    });

    $('#posuppliersavebutton').click(function() {
        const purchaseType = $('#purchaseordertype').val() || 0;
        const $tbody = getTbodyBasedOnPurchaseType(purchaseType);
        if ($tbody.is(':empty')) {
            showToastrMessage('error', 'The supplier does not win any Bid', 'Error!');
        } else {
            pordersave();
        }
    });

function getTbodyBasedOnPurchaseType(purchaseType) {
    switch (purchaseType) {
        case 'Goods':
            return $('#financailevdynamicTablecommdity  > tbody tr');
        default:
            return $('#goodsdynamictables  > tbody tr');
    }
}
function isTableEmpty($tbody) {

    const purchaseType = $('#purchaseordertype').val() || 0;
    switch (purchaseType) {
        case "Goods":
                return $("#goodsdynamictables > tbody tr").length === 0;
            break;
    
        default:
                return $("#directdynamicTablecommdity > tbody tr").length === 0;
            break;
    }
    
}
function showToastrMessage(type, message, title) {
    toastrMessage(type, message, title);
}

    function savederaftdata() {
        const registerForm = $("#purchaseorderegisterform");
        const formdata = registerForm.serialize();
        const id = $('#porderid').val() || 0;
            $.ajax({
                type: "POST",
                url: "{{ url('posavedraftdata') }}",
                data: formdata,
                dataType: "json",
                beforeSend: showLoadingSpinner,
                complete: hideLoadingSpinner,
                error: handleAjaxError,
                success: handleAjaxSuccess
            });
    }
    function showLoadingSpinner() {
        cardSection.block({
            message: `
                <div class="d-flex justify-content-center align-items-center">
                    <p class="mr-50 mb-50">Loading Please Wait...</p>
                    <div class="spinner-grow spinner-grow-sm text-white" role="status"></div>
                </div>`,
            css: {
                backgroundColor: 'transparent',
                color: '#fff',
                border: '0'
            },
            overlayCSS: {
                opacity: 0.5
            }
        });
    }

    function hideLoadingSpinner() {
        cardSection.block({
            message: '',
            timeout: 1,
            css: {
                backgroundColor: '',
                color: '',
                border: ''
            }
        });
    }

    function handleAjaxError(jqXHR, textStatus, errorThrown) {
        const errorMessages = {
            timeout: 'The request timed out. Please try again later',
            error: `An error occurred: ${errorThrown}`,
            abort: 'The request was aborted.',
            parsererror: 'Parsing JSON request failed.',
            default: `AJAX Error: ${textStatus}, ${errorThrown}`
        };
        toastrMessage('error', errorMessages[textStatus] || errorMessages.default, 'Error');
    }

    function handleAjaxSuccess(response) {
        if (response.success) {
            handleSuccessResponse(response);
        } else if (response.errors) {
            handleValidationErrors(response.errors);
        } else if (response.errorv2) {
            const ptype = $('#purchaseordertype').val()||0;
            switch (ptype) {
                case 'Goods':
                    handleGoodsDynamicValidationErrors();
                    break;
                default:
                    handleDynamicValidationErrors();
                    break;
            }
        }
    }

    function handleSuccessResponse(response) {
        var id=$('#porderid').val()||0;
        toastrMessage('success', 'Successfully saved messages', 'Save');
        $('#exampleModalScrollable').modal('hide');
        maingblIndex = id === 0 ? 0 : maingblIndex;
        const oTable = $('#purchaordetables').dataTable();
        oTable.fnDraw(false);
    }

    function handleValidationErrors(errors) {
        const errorMapping = {
            purchaseordertype: '#purchaseordertype-error',
            reference: '#reference-error',
            purchasevaulation_id: { selector: '#pe-error', replace: { from: "purchasevaulation id", to: "Evalualtion" } },
            date: '#date-error',
            commoditytype: '#commoditytype-error',
            coffeesource: '#coffeesource-error',
            coffestatus: '#coffestatus-error',
            supplier: '#supplier-error',
            directorderdate: { selector: '#directorderdate-error', replace: { from: "directorderdate", to: "order date" } },
            directdeliverydate: { selector: '#directdeliverydate-error', replace: { from: "directdeliverydate", to: "delivery date" } },
            directwarehouse: { selector: '#directwarehouse-error', replace: { from: "directwarehouse", to: "warehouse" } },
            directpaymenterm: { selector: '#directpaymenterm-error', replace: { from: "directpaymenterm", to: "payment term" } }
        };

        for (const [key, config] of Object.entries(errorMapping)) {
            if (errors[key]) {
                const errorMessage = config.replace ? errors[key][0].replace(config.replace.from, config.replace.to) : errors[key][0];
                $(config.selector || config).html(errorMessage);
            }
        }
    }

    function handleGoodsDynamicValidationErrors() {
        console.log('Good Logic');
        for (let k = 1; k <= mm; k++) {
            const quantity = parseFloat($('#goodqty' + k).val()) || 0;
            const itmid = parseFloat($('#itemNameSl' + k).val()) || 0;
            const uom = parseFloat($('#uom' + k).val()) || 0;
            const unitprice = parseFloat($('#goodprice' + k).val()) || 0;
            highlightErrorField('#select2-itemNameSl' + k + '-container', itmid === 0);
            highlightErrorField('#select2-uom' + k + '-container', uom === 0);
            highlightErrorField('#goodqty' + k, quantity === 0);
            highlightErrorField('#goodprice' + k, unitprice === 0);
        }
    }

    function handleDynamicValidationErrors() {
        console.log('commodity Logic');
        for (let k = 1; k <= mm; k++) {
            const quantity = parseFloat($('#directfevqauntity' + k).val()) || 0;
            const cropyear = parseFloat($('#cropyear' + k).val()) || 0;
            const proccesstype = parseFloat($('#coffeproccesstype' + k).val()) || 0;
            const itmid = parseFloat($('#itemNameSl' + k).val()) || 0;
            const uom = parseFloat($('#uom' + k).val()) || 0;
            const finalprice = parseFloat($('#directfinalprice' + k).val()) || 0;
            highlightErrorField('#select2-itemNameSl' + k + '-container', itmid === 0);
            highlightErrorField('#select2-coffeproccesstype' + k + '-container', proccesstype === 0);
            highlightErrorField('#select2-cropyear' + k + '-container', cropyear === 0);
            highlightErrorField('#select2-uom' + k + '-container', uom === 0);
            highlightErrorField('#directfevqauntity' + k, quantity === 0);
            highlightErrorField('#directfinalprice' + k, finalprice === 0);
        }
    }

    function highlightErrorField(selector, condition) {
        if (condition) {
            $(selector).parent().css('background-color', errorcolor);
        }
    }


    function pordersave() {
        var registerForm = $("#posupplieradd");
        var formdata = registerForm.serialize();
        $.ajax({
            type: "POST",
            url: "{{ url('posuppliersave') }}",
            data: formdata,
            dataType: "json",
            success: function (response) {
                if(response.errors){
                    if(response.errors.preparedate){
                        $('#preparedate-error').html(response.errors.preparedate[0]);
                    }
                    if(response.errors.orderdate){
                        $('#orderdate-error').html(response.errors.orderdate[0]);
                    }
                    if(response.errors.deliverydate){
                        $('#deliverydate-error').html(response.errors.deliverydate[0]);
                    }
                    if(response.errors.warehouse){
                        $('#warehouse-error').html(response.errors.warehouse[0]);
                    }
                    if(response.errors.paymenterm){
                        $('#paymenterm-error').html(response.errors.paymenterm[0]);
                    }
                }
                if(response.success){
                    toastrMessage('success','Successfully saved orders','Save');
                    $('#giveordermodals').modal('hide');
                        var oTable = $('#supplierdatatables').dataTable(); 
                        oTable.fnDraw(false);
                        var oTable = $('#infofinancailevdynamicTablecommdity').dataTable(); 
                        oTable.fnDraw(false);
                            $('#supplierinfonumberofItemsLbl').html(response.noiftems);
                            $("#iconsupplierpoverifypoeditbutton").removeClass("fa-sharp fa-solid fa-plus");
                            $("#iconsupplierpoverifypoeditbutton").removeClass("fa-duotone fa-pen");
                            $("#iconsupplierpoverifypoeditbutton").addClass("fa-duotone fa-pen");
                            $("#supplierpoverifypoeditbutton").find('span').text("Edit");
                        $.each(response.sumation, function (index, value) { 
                            $('#supplierinfosubtotalLbl').html(value.subtotal);
                            $('#supplierinfotaxLbl').html(value.tax);
                            $('#supplierinfograndtotalLbl').html(value.grandtotal);
                            $('#supplierinfowitholdingAmntLbl').html(value.withold);
                            $('#supplierinfonetpayLbl').html(value.netpay);
                            if(parseFloat(value.subtotal)>=10000){
                                    $('#supplierinfowitholdingTr').show();
                                    $('#supplierinfonetpayTr').show();
                                    
                            } else{
                                $('#supplierinfowitholdingTr').hide();
                                $('#supplierinfonetpayTr').hide();
                            }
                            
                            switch (value.istaxable) {
                                case 0:
                                    $('#individualsupplierinfotaxtr').hide();
                                    $('#individualsupplierinforandtotaltr').hide();
                                    
                                    break;
                                
                                default:
                                    $('#individualsupplierinfotaxtr').show();
                                    $('#individualsupplierinforandtotaltr').show();
                                    break;
                            }
                        });
                    suppliersetminilog(response.actions);
                    showbuttondependonsupplierstat(response.id,response.stat);
                }
                if(response.errorv2){
                    for(var k=1;k<=m;k++){
                        if(($('#fevqauntity'+k).val())!=undefined){
                            var quantity=$('#fevqauntity'+k).val();
                            if(isNaN(parseFloat(quantity))||parseFloat(quantity)==0){
                                $('#fevqauntity'+k).css("background", errorcolor);
                            }
                        }
                    }
                }
            }
        });
    }

    $('#poeditbutton').click(function () {
        const id = $('#recordIds').val();
        $('#porderid').val(id);
        $('#directdynamicTablecommdity').hide();
        $('#directpricetable').hide();
        const currentdate = $('#currentdate').val();
        let type = '';
        let potype='';
        // Enable all options in select2 dropdowns
        $(`#purchaseordertype option,#reference option, #directpaymenterm option
            #commoditytype option,#coffeesource option,#coffestatus option,
            #directwarehouse option, #supplier option, #pe option`).prop(`disabled`, false);

            $("#savedicon").removeClass("fa-sharp fa-solid fa-floppy-disk");
            $("#savedicon").removeClass("fa-duotone fa-pen");
            $("#savedicon").addClass("fa-duotone fa-pen");
            $("#savebutton").find('span').text("Update");

        $('#exampleModalScrollableTitleadd').html('Edit Purchase Order');
        $.ajax({
            type: 'GET',
            url: `{{ url('poedit') }}/${id}`,
            dataType: 'json',
            beforeSend: () => blockUI(cardSection, 'Loading Please Wait...'),
            complete: () => {
                unblockUI(cardSection);
                $('#exampleModalScrollable').modal('show');
                $('#docInfoModal').modal('hide');
            },
            error: handleAjaxError,
            success: function (response) {
                populateForm(response);
            },
        });
});

// Helper function to handle AJAX errors
function handleAjaxError(jqXHR, textStatus, errorThrown) {
    let errorMessage = 'An error occurred. Please try again later.';
    switch (textStatus) {
        case 'timeout':
            errorMessage = 'The request timed out. Please try again later.';
            break;
        case 'error':
            errorMessage = `An error occurred: ${errorThrown}`;
            break;
        case 'abort':
            errorMessage = 'The request was aborted.';
            break;
        case 'parsererror':
            errorMessage = 'Parsing JSON request failed.';
            break;
    }
    toastrMessage('error', errorMessage, 'Error');
}

// Helper function to populate form fields
function populateForm(response) {
    $.each(response.po, function (index, value) {
        // Update select2 dropdowns
        updateSelect2('#purchaseordertype', value.purchaseordertype, true);
        updateSelect2('#reference', value.type, true);
        updateSelect2('#supplier', value.customers_id, true);
        updateSelect2('#directwarehouse', value.store, true);
        updateSelect2('#directpaymenterm', value.paymenterm, false);
        updateSelect2('#commoditytype', value.commudtytype, true);
        updateSelect2('#coffeesource', value.commudtysource, true);
        updateSelect2('#coffestatus', value.commudtystatus, true);
        // Update date fields
        flatpickr('#date', { dateFormat: 'Y-m-d', clickOpens: false, minDate: $('#currentdate').val() });
        $('#date').val(value.date);
        $('#documentnumber').val(value.porderno);
        $('#directorderdate').val(value.orderdate);
        $('#directdeliverydate').val(value.deliverydate);
        $('#directistaxable').val(value.istaxable);
        // Update status display
        updateStatusDisplay(value.status, value.porderno);
        // Update taxable checkbox
        $('#directcustomCheck1').prop('checked', value.istaxable === 1);
        type = value.type;
        potype=value.purchaseordertype;
    });
        handleTypeSpecificLogic(response, type,potype);
        showandhidependontype(potype);
}
function showandhidependontype(selectedValue) {
    switch (selectedValue) {
        case 'Goods':
            $('#commoditytypediv').hide();
            $('#coffeesourcediv').hide();
            $('#coffestatusdiv').hide();
            $('#goodsdynamictables').show();
            $('#directdynamicTablecommdity').hide();
            $('#dividertext').html('Goods');
            break;
        default:
            $('#commoditytypediv').show();
            $('#coffeesourcediv').show();
            $('#coffestatusdiv').show();
            $('#goodsdynamictables').hide();
            $('#directdynamicTablecommdity').show();
            $('#dividertext').html('Commodity');
            break;
    }
}
// Helper function to update select2 dropdowns
function updateSelect2(selector, value, disableOtherOptions = false) {
    $(selector).select2('destroy').val(value).select2();
    if (disableOtherOptions) {
        $(`${selector} option[value!="${value}"]`).prop('disabled', true);
    }
}

// Helper function to update status display
function updateStatusDisplay(status, porderno) {
    let statusHtml = '';
    switch (status) {
        case 0:
            statusHtml = `<span class="text-secondary font-weight-medium"><b>${porderno} Draft</b></span>`;
            break;
        case 1:
            statusHtml = `<span class="text-warning font-weight-medium"><b>${porderno} Pending</b></span>`;
            break;
        default:
            statusHtml = `<span class="text-primary font-weight-medium"><b>${porderno} Verify</b></span>`;
            break;
    }
    $('#statusdisplay').html(statusHtml);
}

// Helper function to handle type-specific logic
function handleTypeSpecificLogic(response, type, potype) {
    switch (type) {
        case 'Direct':
            $('#pediv').hide();
            updateSelect2('#pe', '', true);
            $('#supplier option, #directwarehouse option, #commoditytype option, #coffeesource option, #coffestatus option').prop('disabled', false);
            break;
        default:
            $('#pe').find(`option[value="${response.peid}"]`).remove();
            $('#pe').append(`<option selected value="${response.peid}">${response.pedocno}</option>`);
            updateSelect2('#pe', response.peid, true);
            $('#supplier option, #commoditytype option, #coffeesource option, #coffestatus option').prop('disabled', true);
            $('#pediv').show();
            break;
    }

    switch (type) {
        case 'Direct':
        case 'PE':
            switch (potype) {
                case "Goods":
                        directappendgoodlist(response.commoditylist);
                    break;
            
                default:
                        directappendcommoditylist(response.commoditylist);
                    break;
            }
            $('#itemsdatablediv').hide();
            $('#commuditylistdatablediv').hide();
            $('#supplierduv').show();
            $('.directclass').show();
            break;
        default:
            console.log('logic 2');
            $('#supplierduv').hide();
            $('.directclass').hide();
            if (response.type === 'Goods') {
                $('#itemsdatablediv').show();
                $('#commuditylistdatablediv').hide();
            } else {
                $('#itemsdatablediv').hide();
                $('#commuditylistdatablediv').show();
                commoditylist(response.peid, 'comuditydocaddItem');
            }
            break;
    }
}
    
    function showbuttondependonstat(pe,status,type) {
        switch (status) {
                    case 0:
                        $('#popending').show();
                        $('#poeditbutton').show();
                        $('#povoidbuttoninfo').show();
                        $('#porejectbuttoninfo').show();
                        $('#poprintbutton').hide();
                        $('#poundorejectbuttoninfo').hide();
                        $('#poundovoidbuttoninfo').hide();
                        $('#poverify').hide();
                        $('#poapproved').hide();
                        $('#pobacktodraft').hide();
                        $('#pobacktopending').hide();
                        $('#poreview').hide();
                        $('#undoporeview').hide();
                        $('#infoStatus').html('<span class="text-secondary font-weight-medium"><b> '+pe+' Draft</b>');
                        break;
                        case 1:
                            $('#poverify').show();
                            $('#poeditbutton').show();
                            $('#povoidbuttoninfo').show();
                            $('#porejectbuttoninfo').show();
                            $('#pobacktodraft').show();
                            $('#poprintbutton').hide();
                            $('#poundorejectbuttoninfo').hide();
                            $('#poundovoidbuttoninfo').hide();
                            $('#popending').hide();
                            $('#poapproved').hide();
                            $('#pobacktopending').hide();
                            $('#poreview').hide();
                            $('#undoporeview').hide();
                            $('#infoStatus').html('<span class="text-warning font-weight-medium"><b> '+pe+' Pending</b>');
                        break;
                        case 2:
                            $('#poapproved').show();
                            $('#poeditbutton').show();
                            $('#povoidbuttoninfo').show();
                            $('#porejectbuttoninfo').show();
                            $('#pobacktopending').show();
                            $('#poprintbutton').hide();
                            $('#poverify').hide();
                            $('#poundorejectbuttoninfo').hide();
                            $('#poundovoidbuttoninfo').hide();
                            $('#popending').hide();
                            $('#pobacktodraft').hide();
                            $('#poreview').hide();
                            $('#undoporeview').hide();
                            $('#infoStatus').html('<span class="text-primary font-weight-medium"><b> '+pe+' Verified</b>');
                        break;
                        case 7:
                            $('#poapproved').show();
                            $('#undoporeview').show();
                            $('#pobacktopending').show();
                            $('#poeditbutton').hide();
                            $('#povoidbuttoninfo').show();
                            $('#porejectbuttoninfo').show();
                            $('#pobacktopending').show();
                            $('#poprintbutton').hide();
                            $('#poverify').hide();
                            $('#poundorejectbuttoninfo').hide();
                            $('#poundovoidbuttoninfo').hide();
                            $('#popending').hide();
                            $('#pobacktodraft').hide();
                            $('#poreview').hide();
                            $('#infoStatus').html('<span class="text-primary font-weight-medium"><b> '+pe+' Reviewed</b>');
                        break;
                        case 3:
                            $('#povoidbuttoninfo').show();
                            $('#porejectbuttoninfo').show();
                            $('#poprintbutton').show();
                            $('#poeditbutton').hide();
                            $('#poverify').hide();
                            $('#poundorejectbuttoninfo').hide();
                            $('#poundovoidbuttoninfo').hide();
                            $('#popending').hide();
                            $('#poapproved').hide();
                            $('#pobacktopending').hide();
                            $('#poreview').hide();
                            $('#undoporeview').hide();
                            $('#infoStatus').html('<span class="text-success font-weight-medium"><b> '+pe+' Approved</b>');
                        break;
                        case 4:
                            $('#poundovoidbuttoninfo').show();
                            $('#poeditbutton').hide();
                            $('#povoidbuttoninfo').hide();
                            $('#porejectbuttoninfo').hide();
                            $('#poprintbutton').hide();
                            $('#poverify').hide();
                            $('#poundorejectbuttoninfo').hide();
                            $('#popending').hide();
                            $('#poapproved').hide();
                            $('#pobacktopending').hide();
                            $('#poreview').hide();
                            $('#undoporeview').hide();
                            $('#infoStatus').html('<span class="text-void font-weight-medium"><b> '+pe+' Void</b>');
                        break;
                        case 5:  
                            $('#poundorejectbuttoninfo').show();
                            $('#poundovoidbuttoninfo').hide();
                            $('#poeditbutton').hide();
                            $('#povoidbuttoninfo').hide();
                            $('#porejectbuttoninfo').hide();
                            $('#poprintbutton').hide();
                            $('#poverify').hide();
                            $('#popending').hide();
                            $('#poapproved').hide();
                            $('#pobacktopending').hide();
                            $('#poreview').hide();
                            $('#undoporeview').hide();
                            $('#infoStatus').html('<span class="text-danger font-weight-medium"><b> '+pe+' Rejected</b>');
                        break;
                        
                        case 6:
                            $('#poreview').show();
                            $('#pobacktopending').show();
                            $('#povoidbuttoninfo').show();
                            $('#porejectbuttoninfo').show();
                            $('#poundorejectbuttoninfo').hide();
                            $('#poundovoidbuttoninfo').hide();
                            $('#poeditbutton').show();
                            $('#poprintbutton').hide();
                            $('#poverify').hide();
                            $('#popending').hide();
                            $('#poapproved').hide();
                            $('#pobacktodraft').hide();
                            $('#undoporeview').hide();
                            $('#infoStatus').html('<span class="text-danger font-weight-medium"><b> '+pe+' Review</b>');
                        break;
                    default:
                            
                        break;
                }
    }
    </script>
@endsection