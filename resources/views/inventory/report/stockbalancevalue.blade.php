@extends('layout.app1')
@section('title')
@endsection
@section('content')
@can('Good-Receiving-View')
    <div class="app-content content">
        <form id="stockbalancereportform">
        @csrf
            <section id="responsive-header">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h3 class="card-title">Stock Balance Report</h3>
                            </div>
                            <div class="card-datatable">
                                <div style="width:100%;">
                                    <div style="width:98%; margin-left:1%; margin-top:1%;">
                                        <div class="row">
                                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 mb-1">
                                                <label style="font-size: 14px;color">Fiscal Year</label>
                                                <select class="selectpicker form-control errorerase" id="fiscalyear" name="fiscalyear" title="Select fiscal year here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true">
                                                @foreach ($fiscalyear as $fiscalyear)
                                                    <option selected value="{{ $fiscalyear->FiscalYear }}">{{ $fiscalyear->Monthrange }}</option>
                                                @endforeach
                                                </select>
                                                <span class="text-danger">
                                                    <strong id="fiscalyear-error" class="errorclass"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 mb-1">
                                                <label style="font-size: 14px;color">Select Date Range</label>
                                                
                                                <div class="input-group">   
                                                    <input type="text" id="startdate" placeholder="M D, Y" class="form-control col-5" readonly>
                                                    <span class="form-control col-1">-</span>
                                                    <input type="text" id="daterange" name="daterange" placeholder="Select end date here" class="form-control col-6" style="background-color: #FFFFFF" readonly>          
                                                </div>
                                                <span class="text-danger">
                                                    <strong id="daterange-error" class="errorclass"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 mb-1">
                                                <label style="font-size: 14px;color">Company Type</label>
                                                <select class="selectpicker form-control dropdownclass errorerase" id="companytype" name="companytype" title="Select company type here..." data-style="btn btn-outline-secondary waves-effect" multiple="multiple" data-actions-box="true"></select>
                                                <span class="text-danger">
                                                    <strong id="companytype-error" class="errorclass"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 mb-1">
                                                <label style="font-size: 14px;color">Owner or Customer Name</label>
                                                <select class="selectpicker form-control dropdownclass errorerase" id="CustomerOrOwner" name="CustomerOrOwner" title="Select customer or owner here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" multiple="multiple" data-actions-box="true" data-selected-text-format="count" data-count-selected-text="Customer ({0})"></select>
                                                <span class="text-danger">
                                                    <strong id="customerown-error" class="errorclass"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 mb-1">
                                                <label style="font-size: 14px;color">Store/Station</label>
                                                <select class="selectpicker form-control dropdownclass errorerase" id="store" name="store" title="Select store/station here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" multiple="multiple" data-actions-box="true" data-selected-text-format="count" data-count-selected-text="Store/Station ({0})"></select>
                                                <span class="text-danger">
                                                    <strong id="store-error" class="errorclass"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 mb-1">
                                                <label style="font-size: 14px;color">Product Type</label>
                                                <select class="selectpicker form-control dropdownclass errorerase" id="producttype" name="producttype" title="Select product type here..." data-style="btn btn-outline-secondary waves-effect" multiple="multiple" data-actions-box="true"></select>
                                                <span class="text-danger">
                                                    <strong id="producttype-error" class="errorclass"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 mb-1">
                                                <label style="font-size: 14px;color">Transaction Type</label>
                                                <select class="selectpicker form-control dropdownclass errorerase" id="transactiontype" name="transactiontype" title="Select transaction type here..." data-style="btn btn-outline-secondary waves-effect" multiple="multiple" data-actions-box="true"></select>
                                                <span class="text-danger">
                                                    <strong id="trtype-error" class="errorclass"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 mb-1">
                                                <label style="font-size: 14px;color">Reference</label>
                                                <select class="selectpicker form-control dropdownclass errorerase" id="reference" name="reference" title="Select reference here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" multiple="multiple" data-actions-box="true" data-selected-text-format="count" data-count-selected-text="Reference ({0})"></select>
                                                <span class="text-danger">
                                                    <strong id="reference-error" class="errorclass"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 mb-1">
                                                <label style="font-size: 14px;color">Commodity Type</label>
                                                <select class="selectpicker form-control dropdownclass errorerase" id="commoditytype" name="commoditytype" title="Select commodity type here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" multiple="multiple" data-actions-box="true" data-selected-text-format="count" data-count-selected-text="Commodity Type ({0})"></select>
                                                <span class="text-danger">
                                                    <strong id="commoditytype-error" class="errorclass"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 mb-1">
                                                <label style="font-size: 14px;color">Commodity</label>
                                                <select class="selectpicker form-control dropdownclass errorerase" id="commodity" name="commodity" title="Select commodity here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" multiple="multiple" data-actions-box="true" data-selected-text-format="count" data-count-selected-text="Commodity ({0})"></select>
                                                <span class="text-danger">
                                                    <strong id="commodity-error" class="errorclass"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 mb-1">
                                                <label style="font-size: 14px;color">Grade</label>
                                                <select class="selectpicker form-control dropdownclass errorerase" id="grade" name="grade" title="Select grade here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" multiple="multiple" data-actions-box="true" data-selected-text-format="count" data-count-selected-text="Grade ({0})"></select>
                                                <span class="text-danger">
                                                    <strong id="grade-error" class="errorclass"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 mb-1">
                                                <label style="font-size: 14px;color">Process Type</label>
                                                <select class="selectpicker form-control dropdownclass errorerase" id="processtype" name="processtype" title="Select process type here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" multiple="multiple" data-actions-box="true" data-selected-text-format="count" data-count-selected-text="Process Type ({0})"></select>
                                                <span class="text-danger">
                                                    <strong id="processtype-error" class="errorclass"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 mb-1">
                                                <label style="font-size: 14px;color">Crop Year</label>
                                                <select class="selectpicker form-control dropdownclass errorerase" id="cropyear" name="cropyear" title="Select crop year here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" multiple="multiple" data-actions-box="true" data-selected-text-format="count" data-count-selected-text="Crop Year ({0})"></select>
                                                <span class="text-danger">
                                                    <strong id="cropyear-error" class="errorclass"></strong>
                                                </span>
                                            </div>
                                        </div> 
                                        <hr class="m-1">
                                        <div class="row">
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 mb-1" style="text-align: right;">
                                                
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 mb-1">
                                                <table style="width: 100%">
                                                    <tr>
                                                        <td style="width: 33%;">
                                                            <div class="custom-control custom-control-primary custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input timetable" id="selectallfilter" name="selectallfilter">
                                                                <label class="custom-control-label" for="selectallfilter">Select all filters</label>                                                
                                                            </div>
                                                        </td>
                                                        <td style="width: 20%;">
                                                            <button id="reportbutton" type="button" class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i>    View</button>
                                                        </td>
                                                        <td style="width: 47%;text-align:left;">
                                                            <div class="btn-group dropdown" id="exportdiv" style="display: none;">
                                                                <button type="button" class="btn btn-info dropdown-toggle hide-arrow btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <span>Print / Export </span><i class="fa fa-caret-down"></i>
                                                                </button>
                                                                <div class="dropdown-menu">
                                                                    <button id="printtable" type="button" class="dropdown-item"><i class="fa fa-print" aria-hidden="true"></i>  Print</button>
                                                                    <button id="downloatoexcel" type="button"  class="dropdown-item"><i class="fa fa-file-excel" aria-hidden="true"></i> To Excel</button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 mb-1">

                                            </div>
                                        </div>

                                        <div class="row" style="display: none;">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                <input type="text" id="currentdateval" name="currentdateval" class="form-control" value="{{$currentdate}}" readonly="true"/>
                                                <select class="selectpicker form-control" id="companytypedefault" name="companytypedefault" title="Select company type here..." data-style="btn btn-outline-secondary waves-effect">
                                                    @foreach ($comptype as $comptype)
                                                        <option value="{{ $comptype->CompanyTypeValue }}" title="{{$comptype->DataProp}}">{{ $comptype->CompanyType }}</option>
                                                    @endforeach
                                                </select>
                                                <select class="selectpicker form-control" id="CustomerOrOwnerDefault" name="CustomerOrOwnerDefault" title="Select customer or owner here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true">
                                                    @foreach ($customerowner as $customerowner)
                                                        <option value="{{ $customerowner->customers_id }}" title="{{$customerowner->DataProp}}">{{ $customerowner->CustomerName }}</option>
                                                    @endforeach    
                                                </select>
                                                <select class="selectpicker form-control" id="storedefault" name="storedefault" title="Select store/station here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true">
                                                    @foreach ($store as $store)
                                                        <option value="{{ $store->StoreId }}" title="{{$store->DataProp}}">{{ $store->StoreName }}</option>
                                                    @endforeach    
                                                </select>
                                                <select class="selectpicker form-control" id="producttypedefault" name="producttypedefault" title="Select product type here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true">
                                                    @foreach ($producttype as $producttype)
                                                        <option value="{{ $producttype->ProductType }}" title="{{$producttype->DataProp}}">{{ $producttype->ProductType }}</option>
                                                    @endforeach    
                                                </select>
                                                <select class="selectpicker form-control" id="transactiontypedefault" name="transactiontypedefault" title="Select transaction type here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true">
                                                    @foreach ($transactiontype as $transactiontype)
                                                        <option value="{{ $transactiontype->TransactionsType }}" title="{{$transactiontype->DataProp }}">{{ $transactiontype->TransactionsType }}</option>
                                                    @endforeach    
                                                </select>
                                                <select class="selectpicker form-control" id="referencedefault" name="referencedefault" title="Select reference here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true">
                                                    @foreach ($referece as $referece)
                                                        <option value="{{ $referece->HeaderId }}" title="{{$referece->DataProp }}">{{ $referece->ReferenceNo }}</option>
                                                    @endforeach    
                                                </select>
                                                <select class="selectpicker form-control" id="commoditytypedefault" name="commoditytypedefault" title="Select commodity type here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" data-selected-text-format="count" data-count-selected-text="Commodity ({0})">
                                                    @foreach ($commoditytype as $commoditytype)
                                                        <option value="{{ $commoditytype->CommodityType }}" title="{{$commoditytype->DataProp}}">{{ $commoditytype->CommodityTypeName }}</option>
                                                    @endforeach    
                                                </select>
                                                <select class="selectpicker form-control" id="commoditydefault" name="commoditydefault" title="Select commodity number here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" data-selected-text-format="count" data-count-selected-text="Commodity ({0})">
                                                    @foreach ($commodity as $commodity)
                                                        <option value="{{ $commodity->CommodityId }}" title="{{$commodity->DataProp}}">{{ $commodity->Origin }}</option>
                                                    @endforeach    
                                                </select>
                                                <select class="selectpicker form-control" id="gradedefault" name="gradedefault" title="Select grade here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" data-selected-text-format="count" data-count-selected-text="Grade ({0})">
                                                    @foreach ($grade as $grade)
                                                        <option value="{{ $grade->GradeValue }}" title="{{$grade->DataProp}}">{{ $grade->Grade }}</option>
                                                    @endforeach    
                                                </select>
                                                <select class="selectpicker form-control" id="processtypedefault" name="processtypedefault" title="Select process type here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" data-selected-text-format="count" data-count-selected-text="Process Type ({0})">
                                                    @foreach ($processtype as $processtype)
                                                        <option value="{{ $processtype->ProcessType }}" title="{{$processtype->DataProp}}">{{ $processtype->ProcessType }}</option>
                                                    @endforeach    
                                                </select>
                                                <select class="selectpicker form-control" id="cropyeardefault" name="cropyeardefault" title="Select crop year here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" data-selected-text-format="count" data-count-selected-text="Crop Year ({0})">
                                                    @foreach ($cropyear as $cropyear)
                                                        <option value="{{ $cropyear->CropYearValue }}" title="{{$cropyear->DataProp}}">{{ $cropyear->CropYear }}</option>
                                                    @endforeach    
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>   
            </section>
        </form>

        <section id="responsive-datatable" style="display: none;">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-datatable">
                            <div style="width:100%;">
                                <div class="row" id="printable">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                        <div style="width: 100%;">
                                            <div class="table-responsive">
                                                <table id="receivingreporttable" class="display table-bordered defaultdatatable nowrap" style="text-align:left;width: 100%">
                                                    <thead>
                                                        <tr style="display: none;" id="compinfotr">
                                                            <th colspan="20">
                                                                <table id="headertables" class="headerTable" style="border-bottom: 1px solid black; margin-top:-60px;width:100%;"></table>
                                                            </th>
                                                        </tr>
                                                        <tr id="titletr" style="display: none;">
                                                            <th colspan="20">
                                                                <h4><p style="text-align:center; margin:top:-10px;color:#00cfe8;font-family: 'Segoe UI', Verdana, Helvetica, Sans-Serif;"><b>Good Receiving Report</b></p></h4>
                                                            </th>
                                                        </tr>
                                                        <tr style="color:white; border: 0.1px solid black;">
                                                            <th style="width:2%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="No.">#</th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Floor Map">Floor Map</th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Commodity Type">Commodity Type</th>
                                                            <th style="width:8%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Commodity">Commodity</th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Grade">Grade</th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Crop Year">Crop Year</th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Process Type">Process Type</th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="UOM/ Bag">UOM/ Bag</th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Number of Bag">No. of Bag</th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Bag Weight by KG">Bag Weight</th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Total KG">Total KG</th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="TON">TON</th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Feresula">Feresula</th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Net KG">Net KG</th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Unit Cost">Unit Cost  <label id="unitcostdesc" style="color: #FFFFFF" title="Per Net KG"><i class="fa-solid fa-circle-info"></i></label></th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Total Cost">Total Cost  <label id="totalcostdisc" style="color: #FFFFFF" title="Total Cost= Unit Cost * Net KG"><i class="fa-solid fa-circle-info"></i></label></th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Variance Shortage">Variance Shortage</th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Variance Overage">Variance Overage</th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Remark">Remark</th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Receiving Status">Receiving Status</th>
                                                            <th style="color:white; border: 0.1px solid white;background-color:#00cfe8;width:0%;display:none;"></th>
                                                            <th style="color:white; border: 0.1px solid white;background-color:#00cfe8;width:0%;display:none;"></th>
                                                            <th style="color:white; border: 0.1px solid white;background-color:#00cfe8;width:0%;display:none;"></th>
                                                            <th style="color:white; border: 0.1px solid white;background-color:#00cfe8;width:0%;display:none;"></th>
                                                            <th style="color:white; border: 0.1px solid white;background-color:#00cfe8;width:0%;display:none;"></th>
                                                            <th style="color:white; border: 0.1px solid white;background-color:#00cfe8;width:0%;display:none;"></th>
                                                            <th style="color:white; border: 0.1px solid white;background-color:#00cfe8;width:0%;display:none;"></th>
                                                            <th style="color:white; border: 0.1px solid white;background-color:#00cfe8;width:0%;display:none;"></th>
                                                            <th style="color:white; border: 0.1px solid white;background-color:#00cfe8;width:0%;display:none;"></th>
                                                            <th style="color:white; border: 0.1px solid white;background-color:#00cfe8;width:0%;display:none;"></th>
                                                            <th style="color:white; border: 0.1px solid white;background-color:#00cfe8;width:0%;display:none;"></th>
                                                            <th style="color:white; border: 0.1px solid white;background-color:#00cfe8;width:0%;display:none;"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="table table-sm"></tbody>
                                                    <tfoot style="font-size: 13px;background-color:#ccc;color:#000000">
                                                        <tr>
                                                            <th colspan="8" style="text-align: right;border: 1px solid black;">Grand Total</th>
                                                            <th id="totalnumberofbag" style="text-align:left;padding-left:6px;border: 1px solid black;"></th>
                                                            <th id="totalbagweight" style="text-align:left;padding-left:6px;border: 1px solid black;"></th>
                                                            <th id="totaltotalkg" style="text-align:left;padding-left:6px;border: 1px solid black;"></th>
                                                            <th id="totalton" style="text-align:left;padding-left:6px;border: 1px solid black;"></th>
                                                            <th id="totalferesula" style="text-align:left;padding-left:6px;border: 1px solid black;"></th>
                                                            <th id="totalnetkg" style="text-align:left;padding-left:6px;border: 1px solid black;"></th>
                                                            <th id="totalunitcost" style="text-align:left;padding-left:6px;border: 1px solid black;"></th>
                                                            <th id="totaltotalcost" style="text-align:left;padding-left:6px;border: 1px solid black;"></th>
                                                            <th id="totalvarianceshortage" style="text-align:left;padding-left:6px;border: 1px solid black;"></th>
                                                            <th id="totalvarianceoverage" style="text-align:left;padding-left:6px;border: 1px solid black;"></th>
                                                            <th id="remarkfooter" style="text-align:left;padding-left:6px;border: 1px solid black;"></th>
                                                            <th id="receivingstatusfooter" style="text-align:left;padding-left:6px;border: 1px solid black;"></th>
                                                        </tr>
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
        </section>
    </div>
@endcan

    <!--Start Information Modal -->
    <div class="modal modal-slide-in event-sidebar fade" id="docInfoModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel35" aria-hidden="true" style="overflow-y: scroll;">
        <form id="RecivingFormInformation">
        {{ csrf_field() }}
            <div class="modal-dialog sidebar-xl" style="width:98%;">
                <div class="modal-content p-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #ea5455 !important;font-weight:bold;">x</button>
                    <div class="modal-header">
                        <h4 class="modal-title" id="receivinginfomodaltitle"></h4>
                        <div style="text-align: center;padding-right:30px;" id="statustitles"></div>
                    </div>
                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                        <div class="col-lg-12 col-md-6 col-12">
                            <div class="row mt-1">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <section id="collapsible">
                                        <div class="card collapse-icon">
                                            <div class="collapse-default">
                                                <div class="card">
                                                    <div id="headingCollapse2" class="card-header" data-toggle="collapse" role="button" data-target=".infoscl" aria-expanded="false" aria-controls="collapse1">
                                                        <span class="lead collapse-title" id="productioncomm"></span>
                                                        
                                                    </div>
                                                    <div id="collapse1" role="tabpanel" aria-labelledby="headingCollapse2" class="collapse infoscl">
                                                        <div class="card-body">
                                                            <div class="row">

                                                                <div class="col-lg-4 col-md-6 col-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            <h6 class="card-title">Basic Information</h6>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <div class="row">
                                                                                <table style="width: 100%">
                                                                                    <tr style="display: none;">
                                                                                        <td style="width: 40%"><label style="font-size: 14px;">Document No.</label></td>
                                                                                        <td style="width: 60%"><label class="font-weight-bolder infolbls" id="infoDocDocNo" style="font-size: 14px;"></label></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td style="width: 40%"><label style="font-size: 14px;">Reference</label></td>
                                                                                        <td style="width: 60%"><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="referenceLbl"></label></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><label style="font-size: 14px;">Reference No.</label></td>
                                                                                        <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="purchaseOrdLbl"></label></td>
                                                                                    </tr>
                                                                                    <tr style="display: none;" id="commoditySrcRow">
                                                                                        <td><label style="font-size: 14px;">Commodity Source</label></td>
                                                                                        <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="commoditySrcLbl"></label></td>
                                                                                    </tr>
                                                                                    <tr style="display: none;" id="commodityTypeRow">
                                                                                        <td><label style="font-size: 14px;">Commodity Type</label></td>
                                                                                        <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="commodityTypeLbl"></label></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><label style="font-size: 14px;">Product Type</label></td>
                                                                                        <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="productTypeLbl"></label></td>
                                                                                    </tr>
                                                                                    <tr style="display: none;">
                                                                                        <td><label style="font-size: 14px;">Supplier Category</label></td>
                                                                                        <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="infoDocCustomerCategory"></label></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><label style="font-size: 14px;">Supplier Name</label></td>
                                                                                        <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="infoDocCustomerName"></label></td>
                                                                                    </tr>
                                                                                    <tr style="display: none;">
                                                                                        <td><label style="font-size: 14px;">TIN</label></td>
                                                                                        <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="infotinnumberlbl"></label></td>
                                                                                    </tr>
                                                                                    <tr style="display: none;">
                                                                                        <td><label style="font-size: 14px;">VAT #</label></td>
                                                                                        <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="infovatnumberlbl"></label></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><label style="font-size: 14px;">Company Type</label></td>
                                                                                        <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="companyTypeLbl"></label></td>
                                                                                    </tr>
                                                                                    <tr style="display: none;" id="customerOwnerRec">
                                                                                        <td><label style="font-size: 14px;">Customer</label></td>
                                                                                        <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="customerOrOwnerLbl"></label></td>
                                                                                    </tr>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-5 col-md-6 col-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            <h6 class="card-title">Delivery, Receiving & Other Information</h6>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <table style="width: 100%">
                                                                                <tr>
                                                                                    <td style="width:27%;"><label style="font-size: 14px;">Delivery Order No.</label></td>
                                                                                    <td style="width:73%;"><label class="font-weight-bolder infolbls" id="deliveryOrderLbl" style="font-size: 14px;"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;">Dispatch Station</label></td>
                                                                                    <td><label class="font-weight-bolder infolbls" id="dispatchStationLbl" style="font-size: 14px;"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;">Receiving Station</label></td>
                                                                                    <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="infoDocReceivingStore"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;">Received By</label></td>
                                                                                    <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="receivedByLbl"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;">Driver Name</label></td>
                                                                                    <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="driverNameLbl"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;">Plate No.</label></td>
                                                                                    <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="plateNumberLbl"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;">Driver Phone No.</label></td>
                                                                                    <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="driverPhoneLbl"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;">Delivered By</label></td>
                                                                                    <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="deliveredByLbl"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;">Received Date</label></td>
                                                                                    <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="receivedDateLbl"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;">Document Upload</label></td>
                                                                                    <td><a style="text-decoration:underline;color:blue;" onclick="grvFileDownload()" id="infodocumentuploadlinkbtn"></a></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;">Invoice Status</label></td>
                                                                                    <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="invoiceStatusLbl"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;">Return Status</label></td>
                                                                                    <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="returnStatusLbl"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;">Remark</label></td>
                                                                                    <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="remarkLbl"></label></td>
                                                                                </tr>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3 col-md-6 col-12">
                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            <h6 class="card-title">Action Information</h6>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <div class="row">
                                                                                <div class="col-lg-12 col-md-12 col-sm-12 scrdivhor scrollhor" style="overflow-y: scroll;height:20rem">
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
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                    <ul class="nav nav-tabs nav-fill" role="tablist" style="border:1px solid #D3D3D3">
                                        <li class="nav-item">
                                            <a class="nav-link propdtable active" id="purchasedtab" data-toggle="tab" aria-controls="purchasedtab" href="#purchasedtabBody" role="tab" aria-selected="true">Purchased Commodity</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link propdtable" id="returnedtab" data-toggle="tab" aria-controls="returnedtab" href="#returnedtabBody" role="tab" aria-selected="true">Returned Commodity</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane propdtableBody active" id="purchasedtabBody" role="tabpanel" aria-labelledby="purchasedtabBody">
                                            <div class="row">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                    <div class="table-responsive scroll scrdiv">
                                                        <div class="datatableinfocls" id="infoGoodsDatatable">
                                                            <div class="row">
                                                                <div class="col-xl-12 col-lg-12">
                                                                    <table id="docInfoItem" class="display table-bordered table-striped table-hover dt-responsive">
                                                                        <thead>
                                                                            <th>id</th>
                                                                            <th>#</th>
                                                                            <th>Item Code</th>
                                                                            <th>Item Name</th>
                                                                            <th>SKU Number</th>
                                                                            <th>UOM</th>
                                                                            <th>Quantity</th>
                                                                            <th>Unit Cost</th>
                                                                            <th>Before Tax</th>
                                                                            <th>Tax Amount</th>
                                                                            <th>Total Cost</th>
                                                                        </thead>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                        <div class="datatableinfocls" id="infoCommDatatable">
                                                            <div class="row">
                                                                <div class="col-xl-12 col-lg-12">
                                                                    <table id="origindetailtable" class="display table-bordered table-striped table-hover dt-responsive mb-0 infodatatbl" style="width: 100%">
                                                                        <thead> 
                                                                            <tr>
                                                                                <th style="width:2%;">#</th>
                                                                                <th style="width:6%;">Floor Map</th>
                                                                                <th style="width:6%;">Type</th>
                                                                                <th style="width:8%">Commodity</th>
                                                                                <th style="width:6%">Grade</th>
                                                                                <th style="width:6%">Process Type</th>
                                                                                <th style="width:6%">Crop Year</th>
                                                                                <th style="width:6%">UOM/ Bag</th>
                                                                                <th style="width:6%">No. of Bag</th>
                                                                                <th style="width:6%">Bag Weight by KG</th>
                                                                                <th style="width:6%">Total KG</th>
                                                                                <th style="width:6%">Net KG</th>
                                                                                <th style="width:6%">Feresula<label id="feresulainfolbl" title="Feresula= Net KG / 17"><i class="fa-solid fa-circle-info"></i></label></th>
                                                                                <th style="width:6%">TON<label id="feresulainfolbl" title="TON= Net KG / 1000"><i class="fa-solid fa-circle-info"></i></label></th>
                                                                                <th style="width:6%">Variance Shortage by KG</th>
                                                                                <th style="width:6%">Variance Overage by KG</th>
                                                                                <th style="width:6%">Remark</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody class="table table-sm"></tbody>
                                                                        <tfoot>
                                                                            <th colspan="8" style="font-size:16px;text-align: right;padding-right:7px;">Total</th>
                                                                            <th style="font-size: 14px;" id="totalbag"></th>
                                                                            <th style="font-size: 14px;" id="totalbagweight"></th>
                                                                            <th style="font-size: 14px;" id="totalgrosskg"></th>
                                                                            <th style="font-size: 14px;" id="totalkg"></th>
                                                                            <th style="font-size: 14px;" id="totalferesula"></th>
                                                                            <th style="font-size: 14px;" id="totalton"></th>
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
                                            </div>
                                        </div>

                                        <div class="tab-pane propdtableBody" id="returnedtabBody" role="tabpanel" aria-labelledby="returnedtabBody">
                                            <div class="row">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                    <div class="table-responsive scroll scrdiv">
                                                        <table id="commdatatable" class="display table-bordered table-striped table-hover dt-responsive mb-0 infodatatbl" style="width: 100%">
                                                            <thead> 
                                                                <tr>
                                                                    <th style="width:2%;">#</th>
                                                                    <th style="width:8%">Requisition Doc. No.</th>
                                                                    <th style="width:5%">Type</th>
                                                                    <th style="width:8%">Commodity</th>
                                                                    <th style="width:5%">Grade</th>
                                                                    <th style="width:5%">Process Type</th>
                                                                    <th style="width:5%">Crop Year</th>
                                                                    <th style="width:5%">UOM/ Bag</th>
                                                                    <th style="width:5%">No. of Bag</th>
                                                                    <th style="width:5%">Bag Weight by KG</th>
                                                                    <th style="width:5%">Total KG</th>
                                                                    <th style="width:5%">Net KG</th>
                                                                    <th style="width:5%">TON<label id="feresulainfolbl" title="TON= Net KG / 1000"><i class="fa-solid fa-circle-info"></i></label></th>
                                                                    <th style="width:5%">Feresula<label id="feresulainfolbl" title="Feresula= Net KG / 17"><i class="fa-solid fa-circle-info"></i></label></th>
                                                                    <th style="width:6%">Variance Shortage by KG</th>
                                                                    <th style="width:6%">Variance Overage by KG</th>
                                                                    <th style="width:10%">Remark</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="table table-sm"></tbody>
                                                            <tfoot>
                                                                <th colspan="8" style="font-size:16px;text-align: right;padding-right:7px;">Total</th>
                                                                <th style="font-size: 14px;" id="totalbagRet"></th>
                                                                <th style="font-size: 14px;" id="totalbagweightRet"></th>
                                                                <th style="font-size: 14px;" id="totalgrosskgRet"></th>
                                                                <th style="font-size: 14px;" id="totalkgRet"></th>
                                                                <th style="font-size: 14px;" id="totaltonRet"></th>
                                                                <th style="font-size: 14px;" id="totalferesulaRet"></th>
                                                                <th style="font-size: 14px;" id="totalvarshortageRet"></th>
                                                                <th style="font-size: 14px;" id="totalvarovrageRet"></th>
                                                                <th></th>
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
                    <div class="modal-footer">
                        <div class="col-xl-12 col-lg-12">
                            <div class="row">
                                <div class="col-xl-8 col-lg-8" style="text-align: left">
                                    <input type="hidden" class="form-control" name="recrecordIds" id="recrecordIds" readonly="true" value="76">
                                    <button type="button" id="recprintbutton" class="btn btn-outline-dark waves-effect"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
                                </div>
                                <div class="col-xl-4 col-lg-8" style="text-align:right;">
                                    <button id="closebuttonreceiving" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!--End Information Modal -->

@endsection

@section('scripts')
    <script type="text/javascript">

        var daterg="";
        $(function () {
            cardSection = $('#page-block');
        });

        $(document).ready(function() {
            $('#fiscalyear').each(function() {
                $(this).val($(this).find('option:first').val()).change(); // Set the value and trigger the change event
            });
            $('#exportdiv').hide();
            $('#responsive-datatable').hide();
            $('#selectallfilter').prop('checked',false); 
        });

        $("#downloatoexcel").click(function(){
            $("#headertables").empty();
            let daterange=$('#daterange').val();
            let spliteddate = daterange.split(' - ');
            let fromdate=moment(spliteddate[0], 'MMMM DD, YYYY').format('YYYY-MM-DD');
            let todate=moment(spliteddate[1], 'MMMM DD, YYYY').format('YYYY-MM-DD');
            let tbl = document.getElementById('receivingreporttable');
            let footer = tbl.getElementsByTagName('tfoot')[0];
            footer.style.display = 'table-row-group';
            tbl.removeChild(footer);
            tbl.appendChild(footer);
            $("#receivingreporttable").table2excel({
                name: "Worksheet Name",
                filename: "GoodReceivingReport "+fromdate+' to '+todate, //do not include extension
                fileext: ".xls" // file extension
            });
        });

        $('#printtable').click(function(){
            var tr='<tr>'+
                    '<td colspan="6" class="headerTitles" style="text-align:center;font-size:1.7rem;"><b>{{$compInfo->Name}}</b></td>'+
                    '<td rowspan="4" style="float:right;width:150px;height:120px;"></td>'+
                    '</tr>'+
                    '<tr><td style="width:15%"><b>Tel:</b></td>'+
                    '<td style="width:35%" colspan="2">{{$compInfo->Phone}},{{$compInfo->OfficePhone}}</td>'+
                    '<td style="width:15%"><b>Website:</b></td>'+
                    '<td style="width:35%" colspan="2">{{$compInfo->Website}}</td>'+
                    '</tr>'+
                    '<tr><td><b>Email:</b></td>'+
                    '<td colspan="2">{{$compInfo->Email}}</td>'+
                    '<td><b>Address:</b></td>'+
                    '<td colspan="2">{{$compInfo->Address}}</td>'+
                    '</tr>'+
                    '<tr><td style="width:15%"><b>TIN:</b></td>'+
                    '<td colspan="2">{{$compInfo->TIN}}</td>'+
                    '<td><b>VAT No:</b></td>'+
                    '<td colspan="2">{{$compInfo->VATReg}}</td>'+
                '</tr>';
            $("#headertables").append(tr);
            $('#titletr').show();
            $('#compinfotr').show();

            let tbl = document.getElementById('receivingreporttable');
            let footer = tbl.getElementsByTagName('tfoot')[0];
            footer.style.display = 'table-row-group';
            let header = tbl.getElementsByTagName('thead')[0];
            header.style.display = 'table-row-group';
            tbl.removeChild(footer);
            tbl.appendChild(footer);
        
            var divToPrint=document.getElementById("receivingreporttable");
            var htmlToPrint = '' +
                '<style type="text/css">' +
                'table th, table td {' +
                'border:1px solid #000;' +
                'padding:0.5em;' +
                '}' +
                '</style>';
                htmlToPrint += divToPrint.outerHTML;
                newWin= window.open("");
                newWin.document.write(divToPrint.outerHTML);
                newWin.print();
                newWin.close();
                
            $('#compinfotr').hide();
            $('#titletr').hide();
            $("#headertables").empty();
        });

        $(document).on('change', '.errorerase', function() {
            $(this).parent().find('span .errorclass').html(''); // Clears span within the parent
            $('#selectallfilter').prop('checked',false);
        });

        $(document).on('keyup', '.dropdown-class', function() {
            $(this).siblings('span').text(''); // Clears sibling span text on keyup
        });  

        function getDateRange(startdaterange,enddaterange){
            $('#daterange').daterangepicker({
                singleDatePicker: true,
                showDropdowns:true, 
                showCustomRangeLabel: false,
                autoUpdateInput: false,
                minDate: moment(startdaterange,'YYYY-MM-DD'),
                maxDate: moment(enddaterange,'YYYY-MM-DD'),   
                ranges: {},
                locale: {
                    format: 'MMMM DD, YYYY',
                    cancelLabel: 'Cancel'
                },
            });  
            $('#startdate').val(moment(startdaterange,'YYYY-MM-DD').format('MMMM DD, YYYY'));
            $('#daterange').val("");
            $('#daterange').attr('placeholder', 'Select end date here');
        }

        function dateRangeChange(end){
            var startdate = moment($('#startdate').val(),'MMMM DD, YYYY').format('YYYY-MM-DD');
            var enddate = moment(end,'YYYY-MM-DD').format('YYYY-MM-DD');

            $('#companytype').empty(); 
            var companytypeoptions = $("#companytypedefault > option").clone();
            $('#companytype').append(companytypeoptions); 
            var companyTypeArr = [];
            var ownercomptype=0;
            var customrecomptype=0;
            var seen = {};
            $('#companytype option').each(function () {
                var optionDate = $(this).attr('title'); 
                var value =  $(this).val();

                if (optionDate < startdate || optionDate > enddate) {
                    $(this).remove(); 
                }
                if($(this).val()==null || $(this).val()=="" || $(this).val()===""){
                    $(this).remove(); 
                }
                $(this).removeAttr('title');
            });

            $('#companytype option').each(function () {
                var value =  $(this).val();
                if (seen[value]) {
                    $(this).remove(); 
                } else {
                    seen[value] = true; 
                }
            });

            $('#selectallfilter').prop('checked',false);
            $('#companytype').selectpicker('refresh');
            $('#daterange-error').html("");
        }

        function getCustomer(compvalue){
            let fiscalyear=$('#fiscalyear').val(); 
            const allCombinations = [];
            var seen = {};

            compvalue.forEach(a1 => {
                allCombinations.push(fiscalyear + a1);
            });

            $('#CustomerOrOwner').empty(); 
            var customerowner = $("#CustomerOrOwnerDefault > option").clone();
            $('#CustomerOrOwner').append(customerowner); 
            $('#CustomerOrOwner option').each(function () { 
                var optionTitle = $(this).attr('title'); 
                if (!allCombinations.includes(optionTitle)) {
                    $(this).remove(); 
                }
                if($(this).val()==null || $(this).val()=="" || $(this).val()===""){
                    $(this).remove(); 
                }
                $(this).removeAttr('title');
            });

            $('#CustomerOrOwner option').each(function () {
                var value =  $(this).val();
                if (seen[value]) {
                    $(this).remove(); 
                } else {
                    seen[value] = true; 
                }
            });

            $('#CustomerOrOwner').selectpicker({
                dropdownAlign: 'left' // Aligns the dropdown to the left
            });
            $('#CustomerOrOwner').selectpicker('refresh');
        }

        function getStore(cusowner){
            let fiscalyear=$('#fiscalyear').val(); 
            const allCombinations = [];
            var seen = {};

            cusowner.forEach(a1 => {
                allCombinations.push(fiscalyear + a1);
            });

            $('#store').empty(); 
            var stores = $("#storedefault > option").clone();
            $('#store').append(stores); 
            $('#store option').each(function () { 
                var optionTitle = $(this).attr('title'); 
                if (!allCombinations.includes(optionTitle)) {
                    $(this).remove(); 
                }
                if($(this).val()==null || $(this).val()=="" || $(this).val()===""){
                    $(this).remove(); 
                }
                $(this).removeAttr('title');
            });

            $('#store option').each(function () {
                var value =  $(this).val();
                if (seen[value]) {
                    $(this).remove(); 
                } else {
                    seen[value] = true; 
                }
            });

            $('#store').selectpicker('refresh');
        }

        function getProductType(storeid){
            let fiscalyear=$('#fiscalyear').val(); 
            let cusowner=$('#CustomerOrOwner').val(); 
            const allCombinations = [];
            var seen = {};

            cusowner.forEach(a1 => {
                storeid.forEach(a2 => {
                    allCombinations.push(fiscalyear + a1 + a2);
                });
            });

            $('#producttype').empty(); 
            var producttypeoption = $("#producttypedefault > option").clone();
            $('#producttype').append(producttypeoption); 
            $('#producttype option').each(function () { 
                var optionTitle = $(this).attr('title'); 
                if (!allCombinations.includes(optionTitle)) {
                    $(this).remove(); 
                }
                if($(this).val()==null || $(this).val()=="" || $(this).val()===""){
                    $(this).remove(); 
                }
                $(this).removeAttr('title');
            });

            $('#producttype option').each(function () {
                var value =  $(this).val();
                if (seen[value]) {
                    $(this).remove(); 
                } else {
                    seen[value] = true; 
                }
            });
            $('#producttype').selectpicker('refresh');
        }

        function getTransactionType(prdtype){
            let fiscalyear=$('#fiscalyear').val(); 
            let cusowner=$('#CustomerOrOwner').val(); 
            let storeid=$('#store').val();
            const allCombinations = [];
            var seen = {};

            cusowner.forEach(a1 => {
                storeid.forEach(a2 => {
                    prdtype.forEach(a3 => { 
                        allCombinations.push(fiscalyear + a1 + a2 + a3);
                    });
                });
            });

            $('#transactiontype').empty(); 
            var transactiontypeoption = $("#transactiontypedefault > option").clone();
            $('#transactiontype').append(transactiontypeoption); 
            $('#transactiontype option').each(function () { 
                var optionTitle = $(this).attr('title'); 
                if (!allCombinations.includes(optionTitle)) {
                    $(this).remove(); 
                }
                if($(this).val()==null || $(this).val()=="" || $(this).val()===""){
                    $(this).remove(); 
                }
                $(this).removeAttr('title');
            });

            $('#transactiontype option').each(function () {
                var value =  $(this).val();
                if (seen[value]) {
                    $(this).remove(); 
                } else {
                    seen[value] = true; 
                }
            });
            $('#transactiontype').selectpicker('refresh');
        }

        function getReference(trtype){
            let fiscalyear=$('#fiscalyear').val(); 
            let cusowner=$('#CustomerOrOwner').val(); 
            let storeid=$('#store').val();
            let prdtype=$('#producttype').val();
            const allCombinations = [];
            var seen = {};

            cusowner.forEach(a1 => {
                storeid.forEach(a2 => {
                    prdtype.forEach(a3 => { 
                        trtype.forEach(a4 => { 
                            allCombinations.push(fiscalyear + a1 + a2 + a3 + a4);
                        });
                    });
                });
            });

            $('#reference').empty(); 
            var referenceoption = $("#referencedefault > option").clone();
            $('#reference').append(referenceoption); 
            $('#reference option').each(function () { 
                var optionTitle = $(this).attr('title'); 
                if (!allCombinations.includes(optionTitle)) {
                    $(this).remove(); 
                }
                if($(this).val()==null || $(this).val()=="" || $(this).val()===""){
                    $(this).remove(); 
                }
                $(this).removeAttr('title');
            });

            $('#reference option').each(function () {
                var value =  $(this).val();
                if (seen[value]) {
                    $(this).remove(); 
                } else {
                    seen[value] = true; 
                }
            });
            $('#reference').selectpicker('refresh');
        }

        function getCommodityType(referenceid){
            let fiscalyear=$('#fiscalyear').val(); 
            let cusowner=$('#CustomerOrOwner').val(); 
            let storeid=$('#store').val();
            let prdtype=$('#producttype').val();
            let trtype=$('#transactiontype').val();
            const allCombinations = [];
            var seen = {};

            cusowner.forEach(a1 => {
                storeid.forEach(a2 => {
                    prdtype.forEach(a3 => { 
                        trtype.forEach(a4 => { 
                            referenceid.forEach(a5 => { 
                                allCombinations.push(fiscalyear + a1 + a2 + a3 + a4 + a5);
                            });
                        });
                    });
                });
            });

            $('#commoditytype').empty(); 
            var commoditytypeoption = $("#commoditytypedefault > option").clone();
            $('#commoditytype').append(commoditytypeoption); 
            $('#commoditytype option').each(function () { 
                var optionTitle = $(this).attr('title'); 
                if (!allCombinations.includes(optionTitle)) {
                    $(this).remove(); 
                }
                if($(this).val()==null || $(this).val()=="" || $(this).val()==="" || parseInt($(this).val())==7){
                    $(this).remove(); 
                }
                $(this).removeAttr('title');
            });

            $('#commoditytype option').each(function () {
                var value =  $(this).val();
                if (seen[value]) {
                    $(this).remove(); 
                } else {
                    seen[value] = true; 
                }
            });
            $('#commoditytype').selectpicker('refresh');
        }

        function getCommodity(commoditytype){
            let fiscalyear=$('#fiscalyear').val(); 
            let cusowner=$('#CustomerOrOwner').val(); 
            let storeid=$('#store').val();
            let prdtype=$('#producttype').val();
            let trtype=$('#transactiontype').val();
            let referenceid=$('#reference').val();
            const allCombinations = [];
            var seen = {};

            cusowner.forEach(a1 => {
                storeid.forEach(a2 => {
                    prdtype.forEach(a3 => { 
                        trtype.forEach(a4 => { 
                            commoditytype.forEach(a5 => { 
                                allCombinations.push(fiscalyear + a1 + a2 + a3 + a4 + a5);
                            });
                        });
                    });
                });
            });

            $('#commodity').empty(); 
            var commodityoption = $("#commoditydefault > option").clone();
            $('#commodity').append(commodityoption); 
            $('#commodity option').each(function () { 
                var optionTitle = $(this).attr('title'); 

                if (!allCombinations.includes(optionTitle)) {
                    $(this).remove(); 
                }
                if($(this).val()==null || $(this).val()=="" || $(this).val()===""){
                    $(this).remove(); 
                }
                $(this).removeAttr('title');
            });

            $('#commodity option').each(function () {
                var value =  $(this).val();
                if (seen[value]) {
                    $(this).remove(); 
                } else {
                    seen[value] = true; 
                }
            });
            $('#commodity').selectpicker('refresh');
        }

        function getGrade(commodity){
            let fiscalyear=$('#fiscalyear').val(); 
            let cusowner=$('#CustomerOrOwner').val(); 
            let storeid=$('#store').val();
            let prdtype=$('#producttype').val();
            let trtype=$('#transactiontype').val();
            let referenceid=$('#reference').val();
            let commoditytype=$('#commoditytype').val();
            const allCombinations = [];
            var seen = {};

            cusowner.forEach(a1 => {
                storeid.forEach(a2 => {
                    prdtype.forEach(a3 => { 
                        trtype.forEach(a4 => { 
                            commoditytype.forEach(a5 => { 
                                commodity.forEach(a6 => {
                                    allCombinations.push(fiscalyear + a1 + a2 + a3 + a4 + a5 + a6);
                                });
                            });
                        });
                    });
                });
            });

            $('#grade').empty(); 
            var gradeoption = $("#gradedefault > option").clone();
            $('#grade').append(gradeoption); 
            $('#grade option').each(function () { 
                var optionTitle = $(this).attr('title'); 

                if (!allCombinations.includes(optionTitle)) {
                    $(this).remove(); 
                }
                if($(this).val()==null || $(this).val()=="" || $(this).val()===""){
                    $(this).remove(); 
                }
                $(this).removeAttr('title');
            });

            $('#grade option').each(function () {
                var value =  $(this).val();
                if (seen[value]) {
                    $(this).remove(); 
                } else {
                    seen[value] = true; 
                }
            });
            $('#grade').selectpicker('refresh');
        }

        function getProcessType(grade){
            let fiscalyear=$('#fiscalyear').val(); 
            let cusowner=$('#CustomerOrOwner').val(); 
            let storeid=$('#store').val();
            let prdtype=$('#producttype').val();
            let trtype=$('#transactiontype').val();
            let referenceid=$('#reference').val();
            let commoditytype=$('#commoditytype').val();
            let commodity=$('#commodity').val();
            const allCombinations = [];
            var seen = {};

            cusowner.forEach(a1 => {
                storeid.forEach(a2 => {
                    prdtype.forEach(a3 => { 
                        trtype.forEach(a4 => { 
                            commoditytype.forEach(a5 => { 
                                commodity.forEach(a6 => {
                                    grade.forEach(a7 => {
                                        allCombinations.push(fiscalyear + a1 + a2 + a3 + a4 + a5 + a6 + a7);
                                    });
                                });
                            });
                        });
                    });
                });
            });

            $('#processtype').empty(); 
            var processtypeoption = $("#processtypedefault > option").clone();
            $('#processtype').append(processtypeoption); 
            $('#processtype option').each(function () { 
                var optionTitle = $(this).attr('title'); 

                if (!allCombinations.includes(optionTitle)) {
                    $(this).remove(); 
                }
                if($(this).val()==null || $(this).val()=="" || $(this).val()===""){
                    $(this).remove(); 
                }
                $(this).removeAttr('title');
            });

            $('#processtype option').each(function () {
                var value =  $(this).val();
                if (seen[value]) {
                    $(this).remove(); 
                } else {
                    seen[value] = true; 
                }
            });
            $('#processtype').selectpicker('refresh');
        }

        function getCropYear(processtype){
            let fiscalyear=$('#fiscalyear').val(); 
            let cusowner=$('#CustomerOrOwner').val(); 
            let storeid=$('#store').val();
            let prdtype=$('#producttype').val();
            let trtype=$('#transactiontype').val();
            let referenceid=$('#reference').val();
            let commoditytype=$('#commoditytype').val();
            let commodity=$('#commodity').val();
            let grade=$('#grade').val();
            const allCombinations = [];
            var seen = {};

            cusowner.forEach(a1 => {
                storeid.forEach(a2 => {
                    prdtype.forEach(a3 => { 
                        trtype.forEach(a4 => { 
                            commoditytype.forEach(a5 => { 
                                commodity.forEach(a6 => {
                                    grade.forEach(a7 => {
                                        processtype.forEach(a8 => {
                                            allCombinations.push(fiscalyear + a1 + a2 + a3 + a4 + a5 + a6 + a7 + a8);
                                        });
                                    });
                                });
                            });
                        });
                    });
                });
            });

            $('#cropyear').empty(); 
            var cropyearoption = $("#cropyeardefault > option").clone();
            $('#cropyear').append(cropyearoption); 
            $('#cropyear option').each(function () { 
                var optionTitle = $(this).attr('title'); 

                if (!allCombinations.includes(optionTitle)) {
                    $(this).remove(); 
                }
                if($(this).val()==null || $(this).val()=="" || $(this).val()===""){
                    $(this).remove(); 
                }
                $(this).removeAttr('title');
            });

            $('#cropyear option').each(function () {
                var value =  $(this).val();
                if (seen[value]) {
                    $(this).remove(); 
                } else {
                    seen[value] = true; 
                }
            });
            $('#cropyear').selectpicker('refresh');
        }

        function emptyDropDown(){
            $('.dropdownclass').each(function () {
                $(this).find('option').remove(); 
                $(this).selectpicker('refresh'); 
            });
        }

        $('#fiscalyear').change(function() {
            var fy=$(this).val();
            var nextfy=parseInt(fy)+1;
            var startdaterange=fy+"-07-08";
            var enddaterange=nextfy+"-07-07";
            var currdate=$('#currentdateval').val();
            getDateRange(startdaterange,enddaterange,currdate);
            $('#daterange').val("");
        });

        $('#daterange').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.endDate.format('MMMM DD, YYYY'));
            var startdate = moment($('#startdate').val(),'MMMM DD, YYYY').format('YYYY-MM-DD');
            var enddate = picker.endDate.format('YYYY-MM-DD');

            $('#companytype').empty(); 
            var companytypeoptions = $("#companytypedefault > option").clone();
            $('#companytype').append(companytypeoptions); 
            var seen = {};

            $('#companytype option').each(function () {
                var optionDate = $(this).attr('title'); 
                var value =  $(this).val();

                if (optionDate < startdate || optionDate > enddate) {
                    $(this).remove(); 
                }
                if($(this).val()==null || $(this).val()=="" || $(this).val()===""){
                    $(this).remove(); 
                }
                $(this).removeAttr('title');
            });

            $('#companytype option').each(function () {
                var value =  $(this).val();
                if (seen[value]) {
                    $(this).remove(); 
                } else {
                    seen[value] = true; 
                }
            });
            
            $('#selectallfilter').prop('checked',false);
            $('#companytype').selectpicker('refresh');
            $('#daterange-error').html("");
        });

        $('#companytype').change(function() { 
            var compvalue = $(this).val();
            getCustomer(compvalue);
        });

        $('#CustomerOrOwner').change(function() { 
            var cusowner = $(this).val();
            getStore(cusowner);
        });

        $('#store').change(function() { 
            var storeid = $(this).val();
            getProductType(storeid);
        });

        $('#producttype').change(function() { 
            var prdtype = $(this).val();
            getTransactionType(prdtype);
        });

        $('#transactiontype').change(function() { 
            var trtype = $(this).val();
            getReference(trtype);
        });

        $('#reference').change(function() { 
            var referenceid = $(this).val();
            getCommodityType(referenceid);
        });

        $('#commoditytype').change(function() { 
            var commoditytype = $(this).val();
            getCommodity(commoditytype);
        });

        $('#commodity').change(function() { 
            var commodity = $(this).val();
            getGrade(commodity);
        });

        $('#grade').change(function() { 
            var grade = $(this).val();
            getProcessType(grade);
        });

        $('#processtype').change(function() { 
            var processtype = $(this).val();
            getCropYear(processtype);
        });

        $('#selectallfilter').on('change',async function() { 
            var selectAllFilter = $(this).prop('checked');
            var selectedValues = [];
            var fyear=$('#fiscalyear').val();

            try{
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

                if(selectAllFilter==true){
                    var nextfy=parseInt(fyear)+1;
                    var startdaterange=fyear+"-07-08";
                    var enddaterange=nextfy+"-07-07";

                    $(".errorclass").html("");
                    if(isNaN(parseInt(fyear))){
                        $('#fiscalyear-error').html('The fiscal year field is required.');
                        toastrMessage('error',"Please fill all required fields","Error");
                        $('#selectallfilter').prop('checked',false); 
                    }

                    else if(!isNaN(parseInt(fyear))){
                        getDateRange(startdaterange,enddaterange);
                        dateRangeChange(enddaterange);
                        $('#daterange').val(moment(enddaterange,'YYYY-MM-DD').format('MMMM DD, YYYY'));

                        $('#companytype').find('option').prop('selected', true);
                        var comptype=$('#companytype').val();
                        getCustomer(comptype);

                        $('#CustomerOrOwner').find('option').prop('selected', true);
                        var cusowner = $('#CustomerOrOwner').val();
                        getStore(cusowner);

                        $('#store').find('option').prop('selected', true);
                        var storeid = $('#store').val();
                        getProductType(storeid);

                        $('#producttype').find('option').prop('selected', true);
                        var prdtype = $('#producttype').val();
                        getTransactionType(prdtype);

                        $('#transactiontype').find('option').prop('selected', true);
                        var trtype = $('#transactiontype').val();
                        getReference(trtype);

                        $('#reference').find('option').prop('selected', true);
                        var referenceid = $('#reference').val();
                        getCommodityType(referenceid);

                        $('#commoditytype').find('option').prop('selected', true);
                        var commoditytype = $('#commoditytype').val();
                        getCommodity(commoditytype);

                        $('#commodity').find('option').prop('selected', true);
                        var commodity = $('#commodity').val();
                        getGrade(commodity);

                        $('#grade').find('option').prop('selected', true);
                        var grade = $('#grade').val();
                        getProcessType(grade);

                        $('#processtype').find('option').prop('selected', true);
                        var processtype = $('#processtype').val();
                        getCropYear(processtype);

                        $('.dropdownclass').selectpicker('refresh');
                        $('#selectallfilter').prop('checked',true);
                    }
                }
                else if(selectAllFilter==false){
                    $('#daterange').val("");
                    emptyDropDown();
                }
            }
            finally {
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
            }
        });


        $('#reportbutton').on('click', function() {
            alert($('#daterange').val());
        });

    </script>
@endsection