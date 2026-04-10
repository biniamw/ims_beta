@extends('layout.app1')
@section('title')
@endsection
@section('content')
@can('Cost-History-View')
    <div class="app-content content">
        <form id="stockcosthistoryreportform">
        @csrf
            <section id="responsive-header">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h3 class="card-title">Cost History Report</h3>
                            </div>
                            <div class="card-datatable">
                                <div style="width:100%;">
                                    <div style="width:98%; margin-left:1%; margin-top:1%;">
                                        <div class="row">
                                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 mb-1">
                                                <label style="font-size: 14px;color">Fiscal Year</label>
                                                <select class="select2 form-control errorerase" id="fiscalyear" name="fiscalyear" title="Select fiscal year here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true">
                                                @foreach ($fiscalyear as $fiscalyear)
                                                    <option value="{{ $fiscalyear->FiscalYear }}">{{ $fiscalyear->Monthrange }}</option>
                                                @endforeach
                                                </select>
                                                <span class="text-danger">
                                                    <strong id="fiscalyear-error" class="errorclass"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 mb-1" style="text-align:right;">
                                                <label style="font-size: 14px;color">Select End Date</label>
                                                <div class="input-group">   
                                                    <input type="text" id="startdate" placeholder="M D, Y" class="form-control col-5" readonly>
                                                    <span class="form-control col-1">-</span>
                                                    <input type="text" id="daterange" name="daterange" placeholder="Select end date here" class="form-control col-6" style="background-color: #FFFFFF" readonly>          
                                                </div>
                                                <span class="text-danger">
                                                    <strong id="daterange-error" class="errorclass"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 mb-1">
                                                <label style="font-size: 14px;color">Company Type</label>
                                                <select class="selectpicker form-control dropdownclass errorerase" id="companytype" name="companytype" title="Select company type here..." data-style="btn btn-outline-secondary waves-effect"></select>
                                                <span class="text-danger">
                                                    <strong id="companytype-error" class="errorclass"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 mb-1">
                                                <label style="font-size: 14px;color">Owner or Customer Name</label>
                                                <select class="selectpicker form-control dropdownclass errorerase" id="CustomerOrOwner" name="CustomerOrOwner" title="Select customer or owner here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" multiple="multiple" data-actions-box="true" data-selected-text-format="count" data-count-selected-text="Customer ({0})"></select>
                                                <span class="text-danger">
                                                    <strong id="customerown-error" class="errorclass"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 mb-1">
                                                <label style="font-size: 14px;color">Store/Station</label>
                                                <select class="selectpicker form-control dropdownclass errorerase" id="store" name="store" title="Select store/station here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" multiple="multiple" data-actions-box="true" data-selected-text-format="count" data-count-selected-text="Store/Station ({0})"></select>
                                                <span class="text-danger">
                                                    <strong id="store-error" class="errorclass"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 mb-1">
                                                <label style="font-size: 14px;color">Product Type</label>
                                                <select class="selectpicker form-control dropdownclass errorerase" id="producttype" name="producttype" title="Select product type here..." data-style="btn btn-outline-secondary waves-effect" multiple="multiple" data-actions-box="true"></select>
                                                <span class="text-danger">
                                                    <strong id="producttype-error" class="errorclass"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 mb-1">
                                                <label style="font-size: 14px;color">Commodity Type</label>
                                                <select class="selectpicker form-control dropdownclass errorerase" id="commoditytype" name="commoditytype" title="Select commodity type here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" multiple="multiple" data-actions-box="true" data-selected-text-format="count" data-count-selected-text="Commodity Type ({0})"></select>
                                                <span class="text-danger">
                                                    <strong id="commoditytype-error" class="errorclass"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 mb-1">
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
                                                                    <li><a id="printtable" class="dropdown-item" href="javascript:void(0);"><i class="fa-solid fa-print"></i>  Print</a></li>
                                                                    <li><hr class="dropdown-divider"></li>
                                                                    <li><a id="downloatoexcel" class="dropdown-item" href="javascript:void(0);"><i class="fa-solid fa-file-excel"></i> To Excel</a></li>
                                                                    <li><a id="downloadtopdf" class="dropdown-item" href="javascript:void(0);"><i class="fa-solid fa-file-pdf"></i> To Pdf</a></li>
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
                                        <div style="width: 99%;margin-left:0.5%; margin-top:0.5%;">
                                            <div class="table-responsive">
                                                <table id="stockcosthistoryreporttable" class="display table-bordered defaultdatatable nowrap" style="text-align:left;width: 100%">
                                                    <thead>
                                                        <tr style="color:white; border: 0.1px solid black;">
                                                            <th style="width:2%;color:white; border: 0.1px solid white;background-color:#00cfe8;border-left:1px solid black" title="No.">#</th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Floor Map">Store/ Station</th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Floor Map">Floor Map</th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Commodity Type">Commodity Type</th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Commodity">Commodity</th>
                                                            <th style="width:4%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Grade">Grade</th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Crop Year">Crop Year</th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Process Type">Process Type</th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="UOM/ Bag">UOM/ Bag</th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Number of Bag">No. of Bag</th>
                                                            <th style="width:4%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="TON">TON</th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Feresula">Feresula</th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Net KG">Net KG</th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Unit Cost">Unit Cost <label id="unitcostdesc" style="color: #FFFFFF" title="Per Net KG"><i class="fa-solid fa-circle-info"></i></label></th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Total Cost">Total Cost  <label id="totalcostdisc" style="color: #FFFFFF" title="Total Cost= Unit Cost * Net KG"><i class="fa-solid fa-circle-info"></i></label></th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Running Average Cost">Running Average Cost</th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Transaction Type">Transaction Type</th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Transaction Type Document Number">Document No.</th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Purchase Order Number">PO No.</th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Purchase Invoice Number">PIV No.</th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;border-right:1px solid black" title="Transaction Date">Date</th>
                                                            <th style="color:white; border: 0.1px solid white;background-color:#00cfe8;width:0%;display:none;"></th>
                                                            <th style="color:white; border: 0.1px solid white;background-color:#00cfe8;width:0%;display:none;"></th>
                                                            <th style="color:white; border: 0.1px solid white;background-color:#00cfe8;width:0%;display:none;"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="table table-sm"></tbody>
                                                    <tfoot style="font-size: 13px;background-color:#ccc;color:#000000">
                                                        <tr>
                                                            <th colspan="9" style="text-align: right;border: 1px solid black;">Grand Total</th>
                                                            <th id="reptotalnumberofbag" style="text-align:left;padding-left:6px;border: 1px solid black;"></th>
                                                            <th id="reptotalton" style="text-align:left;padding-left:6px;border: 1px solid black;"></th>
                                                            <th id="reptotalferesula" style="text-align:left;padding-left:6px;border: 1px solid black;"></th>
                                                            <th id="reptotalnetkg" style="text-align:left;padding-left:6px;border: 1px solid black;"></th>
                                                            <th id="repunitcost" style="text-align:left;padding-left:6px;border: 1px solid black;"></th>
                                                            <th id="reptotalcost" style="text-align:left;padding-left:6px;border: 1px solid black;"></th>
                                                            <th style="text-align:left;padding-left:6px;border: 1px solid black;"></th>
                                                            <th style="text-align:left;padding-left:6px;border: 1px solid black;"></th>
                                                            <th style="text-align:left;padding-left:6px;border: 1px solid black;"></th>
                                                            <th style="text-align:left;padding-left:6px;border: 1px solid black;"></th>
                                                            <th style="text-align:left;padding-left:6px;border: 1px solid black;"></th>
                                                            <th style="text-align:left;padding-left:6px;border: 1px solid black;"></th>
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
    <div class="modal modal-slide-in event-sidebar fade" id="allocationmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel35" aria-hidden="true" style="overflow-y: scroll;">
        <form id="AllocationInformationForm">
        {{ csrf_field() }}
            <div class="modal-dialog sidebar-xl" style="width:98%;">
                <div class="modal-content p-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #ea5455 !important;font-weight:bold;">x</button>
                    <div class="modal-header">
                        <h4 class="modal-title" id="detailinfomodaltitle"></h4>
                        <div style="text-align: right" id="statusdisplay"></div>
                    </div>
                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                        <div class="col-lg-12 col-md-6 col-12">
                            <div class="row mt-1">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <section id="collapsible">
                                        <div class="card collapse-icon">
                                            <div class="collapse-default">
                                                <div class="card">
                                                    <div id="headingCollapse2" class="card-header" data-toggle="collapse" role="button" data-target=".infoprd" aria-expanded="false" aria-controls="collapse1">
                                                        <span class="lead collapse-title">Commodity & Company Information</span>
                                                        
                                                    </div>
                                                    <div id="collapse1" role="tabpanel" aria-labelledby="headingCollapse2" class="collapse infoprd">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-lg-6 col-md-6 col-6" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                                    <table style="width: 100%;">
                                                                        <tr>
                                                                            <td colspan="2" style="text-align: left;font-size:16px"><b>Commodity Information</b></td>
                                                                        </tr>
                                                                        <tr><td colspan="2"></td></tr>
                                                                        <tr>
                                                                            <td style="width: 25%;"><label style="font-size: 14px;">Commodity</label></td>
                                                                            <td style="width: 75%;"><label id="prdorigininfolbl" style="font-size:14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label style="font-size: 14px;"></label></td>
                                                                            <td><label id="prduominfolbl" style="font-size:14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                                <div class="col-lg-6 col-md-6 col-6">
                                                                    <table id="customerinfotbl" class="customerinfotbl" style="width: 100%;">
                                                                        <tr>
                                                                            <td colspan="2" style="text-align: left;font-size:16px"><b>Customer Information</b></td>
                                                                        </tr>
                                                                        <tr><td colspan="2"></td></tr>
                                                                        <tr>
                                                                            <td style="width: 25%"><label style="font-size: 14px;">Customer Code</label></td>
                                                                            <td style="width: 75%"><label id="prdinfocustomercode" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label style="font-size: 14px;">Customer Name</label></td>
                                                                            <td><label id="prdinfocustomername" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label style="font-size: 14px;">Customer TIN</label></td>
                                                                            <td><label id="prdinfocustomertin" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label style="font-size: 14px;">Customer Phone</label></td>
                                                                            <td><label id="prdinfocustomerphone" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label style="font-size: 14px;">Customer Email</label></td>
                                                                            <td><label id="prdinfocustomeremail" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                        </tr>
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
                            </div>
                            
                            <div class="row detailscls" id="productiondiv" style="display: none;">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <table id="prdcomstockbalancetbl" class="display table-bordered table-striped table-hover dt-responsive mb-0 infodatatbl" style="width: 100%">
                                        <thead>         
                                            <tr>
                                                <th rowspan="2" style="width:3%;">#</th>
                                                <th rowspan="2" style="width:10%">Document No.</th>
                                                <th rowspan="2" style="width:10%">Store</th>
                                                <th rowspan="2" style="width:9%">Commodity Type</th>
                                                <th rowspan="2" style="width:9%">Grade</th>
                                                <th rowspan="2" style="width:9%">Process Type</th>
                                                <th rowspan="2" style="width:9%">Crop Year</th>
                                                <th rowspan="2" style="width:9%">UOM/Bag</th>
                                                <th colspan="4" style="width:32%;text-align:center;" title="Amount">Amount</th>
                                                <th rowspan="2"></th>
                                                <th rowspan="2"></th>
                                            </tr>
                                            <tr>
                                                <th>By Bag</th>
                                                <th>By KG</th>
                                                <th>By TON</th>
                                                <th>By Feresula</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table table-sm"></tbody>
                                        <tfoot>
                                            <tr>
                                                <th style="text-align: center;" colspan="14">-</th>
                                            </tr>
                                            <tr style="background-color: #cccccc;color:#000000;font-size:16px;">
                                                <th colspan="8" style="text-align: right;">Total</th>
                                                <th id="prdtotalbagnumber" style="text-align: left"></th>
                                                <th id="prdtotalbalanceinfo" style="text-align: left"></th>
                                                <th id="prdtotalbalancetoninfo" style="text-align: left"></th>
                                                <th id="prdtotalbalanceferesulainfo" style="text-align: left"></th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="row detailscls" id="dispatchdiv" style="display: none;">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <table id="dispatchdetailtbl" class="display table-bordered table-striped table-hover dt-responsive mb-0 infodatatbl" style="width: 100%">
                                        <thead>         
                                            <tr>
                                                <th rowspan="2" style="width:3%;">#</th>
                                                <th rowspan="2" style="width:7%">Document No.</th>
                                                <th rowspan="2" style="width:5%">Store</th>
                                                <th rowspan="2" style="width:5%">Commodity Type</th>
                                                <th rowspan="2" style="width:5%">Grade</th>
                                                <th rowspan="2" style="width:5%">Process Type</th>
                                                <th rowspan="2" style="width:5%">Crop Year</th>
                                                <th rowspan="2" style="width:5%">UOM/Bag</th>
                                                <th colspan="4" style="width:20%;text-align:center;" title="Requested Amount">Requested Amount</th>
                                                <th colspan="4" style="width:20%;text-align:center;" title="Dispatched Amount">Dispatched Amount</th>
                                                <th colspan="4" style="width:20%;text-align:center;" title="Remaining Amount">Remaining Amount</th>
                                            </tr>
                                            <tr>
                                                <th>By Bag</th>
                                                <th>By KG</th>
                                                <th>By TON</th>
                                                <th>By Feresula</th>
                                                <th>By Bag</th>
                                                <th>By KG</th>
                                                <th>By TON</th>
                                                <th>By Feresula</th>
                                                <th>By Bag</th>
                                                <th>By KG</th>
                                                <th>By TON</th>
                                                <th>By Feresula</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table table-sm"></tbody>
                                        <tfoot>
                                            <tr>
                                                <th style="text-align: center;" colspan="20">-</th>
                                            </tr>
                                            <tr style="background-color: #cccccc;color:#000000;font-size:16px;">
                                                <th colspan="8" style="text-align: right;">Total</th>
                                                <th id="reqtotalbag" style="text-align: left"></th>
                                                <th id="reqtotalkg" style="text-align: left"></th>
                                                <th id="reqtotalton" style="text-align: left"></th>
                                                <th id="reqtotalferesula" style="text-align: left"></th>
                                                <th id="distotalbag" style="text-align: left"></th>
                                                <th id="distotalkg" style="text-align: left"></th>
                                                <th id="distotalton" style="text-align: left"></th>
                                                <th id="distotalferesula" style="text-align: left"></th>
                                                <th id="remtotalbag" style="text-align: left"></th>
                                                <th id="remtotalkg" style="text-align: left"></th>
                                                <th id="remtotalton" style="text-align: left"></th>
                                                <th id="remtotalferesula" style="text-align: left"></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control" name="recPrdInfoId" id="recPrdInfoId" readonly="true" value=""/> 
                        <button id="closebuttonprd" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                    
                </div>
            </div>
        </form>
    </div>
    <!--End Information Modal -->

    <!--Start Beginning Information Modal -->
    <div class="modal modal-slide-in event-sidebar fade" id="beginningmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel35" aria-hidden="true" style="overflow-y: scroll;">
        <form id="BeginningInformationForm">
        {{ csrf_field() }}
            <div class="modal-dialog sidebar-xl" style="width:98%;">
                <div class="modal-content p-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #ea5455 !important;font-weight:bold;">x</button>
                    <div class="modal-header">
                        <h4 class="modal-title">Beginning Information</h4>
                        <div style="text-align: center;padding-right:30px;" id="beginningstatusdisplay"></div>
                    </div>
                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                        <div class="col-lg-12 col-md-6 col-12">
                            <div class="row mt-1">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <section id="collapsible">
                                        <div class="card collapse-icon">
                                            <div class="collapse-default">
                                                <div class="card">
                                                    <div id="headingCollapse3" class="card-header" data-toggle="collapse" role="button" data-target=".infocommbeg" aria-expanded="false" aria-controls="collapse3">
                                                        <span class="lead collapse-title">Beginning & Other Information</span>
                                                        
                                                    </div>
                                                    <div id="collapse3" role="tabpanel" aria-labelledby="headingCollapse3" class="collapse infocommbeg">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-lg-8 col-md-6 col-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            <h6 class="card-title">Basic Information</h6>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <div class="row">
                                                                                <div class="col-lg-6 col-md-12 col-sm-12">
                                                                                    <table style="width: 100%;">
                                                                                        <tr style="display: none;">
                                                                                            <td style="width: 30%"><label style="font-size: 14px;">Beginning Doc. No.</label></td>
                                                                                            <td style="width: 70%"><label id="infobeginningdocnum" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr style="display: none;">
                                                                                            <td><label style="font-size: 14px;">Ending Doc. No.</label></td>
                                                                                            <td><label id="infoendingdocnum" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td style="width: 30%"><label style="font-size: 14px;">Store/ Station</label></td>
                                                                                            <td style="width: 70%"><label id="infostorename" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Fiscal Year</label></td>
                                                                                            <td><label id="infofiscalyear" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Remark</label></td>
                                                                                            <td><label id="inforemark" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </div>
                                                                                <div class="col-lg-6 col-md-12 col-sm-12">
                                                                                    <table id="begcustomerinfotbl" style="width: 100%;">
                                                                                        <tr>
                                                                                            <td style="width: 30%"><label style="font-size: 14px;">Customer Code</label></td>
                                                                                            <td style="width: 70%"><label id="infocustomercode" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Customer Name</label></td>
                                                                                            <td><label id="infocustomername" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Customer TIN</label></td>
                                                                                            <td><label id="infocustomertin" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Customer Phone</label></td>
                                                                                            <td><label id="infocustomerphone" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Customer Email</label></td>
                                                                                            <td><label id="infocustomeremail" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4 col-md-6 col-12">
                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            <h6 class="card-title">Action Information</h6>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <div class="row">
                                                                                <div class="col-lg-12 col-md-12 col-sm-12 scrdivhor scrollhor" style="overflow-y: scroll;height:15rem">
                                                                                    <ul id="begactiondiv" class="timeline mb-0 mt-0"></ul>
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
                                <div class="col-xl-12 col-md-12 col-lg-12">
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12 col-lg-12">
                                            <div class="table-responsive scroll scrdiv">
                                                <table id="begorigindetailtable" class="display table-bordered table-striped table-hover dt-responsive mb-0 infodatatbl" style="width: 100%">
                                                    <thead> 
                                                        <tr>
                                                            <th style="width:2%;">#</th>
                                                            <th style="width:4%;text-align:left;">Floor Map</th>
                                                            <th style="width:4%;text-align:left;" title="Arrival Date">Arrival Date</th>
                                                            <th style="width:4%">Type</th>
                                                            <th style="width:5%">Supplier</th>
                                                            <th style="width:4%" title="GRN Number">GRN No.</th>
                                                            <th style="width:5%" title="Production Order Number">Production Order No.</th>
                                                            <th style="width:4%" title="Certificate Number">Certificate No.</th>
                                                            <th style="width:5%">Commodity</th>
                                                            <th style="width:4%">Grade</th>
                                                            <th style="width:5%">Process Type</th>
                                                            <th style="width:4%">Crop Year</th>
                                                            <th style="width:4%">UOM/ Bag</th>
                                                            <th style="width:5%">No. of Bag</th>
                                                            <th style="width:4%">Bag Weight by KG</th>
                                                            <th style="width:4%">Total KG</th>
                                                            <th style="width:4%">Net KG</th>
                                                            <th style="width:4%">TON<label id="feresulainfolbl" title="TON= Net KG / 1000"><i class="fa-solid fa-circle-info"></i></label></th>
                                                            <th style="width:4%">Feresula<label id="feresulainfolbl" title="Feresula= Net KG / 17"><i class="fa-solid fa-circle-info"></i></label></th>
                                                            <th style="width:4%">Unit Cost<i class="fa-solid fa-circle-info" title="Before VAT"></i></th>
                                                            <th style="width:4%">Total Cost<label id="feresulainfolbl" title="Total Cost= Net KG * Unit Cost"><i class="fa-solid fa-circle-info"></i></label></th>
                                                            <th style="width:4%">Variance Shortage by KG</th>
                                                            <th style="width:4%">Variance Overage by KG</th>
                                                            <th style="width:5%">Remark</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="table table-sm"></tbody>
                                                    <tfoot>
                                                        <th colspan="13" style="font-size:16px;text-align: right;padding-right:7px;">Total</th>
                                                        <th style="font-size: 14px;" id="begtotalbag"></th>
                                                        <th style="font-size: 14px;" id="begtotalbagweight"></th>
                                                        <th style="font-size: 14px;" id="begtotalgrosskg"></th>
                                                        <th style="font-size: 14px;" id="begtotalkg"></th>
                                                        <th style="font-size: 14px;" id="begtotalton"></th>
                                                        <th style="font-size: 14px;" id="begtotalferesula"></th>
                                                        <th style="font-size: 14px;" id="totalunitcost"></th>
                                                        <th style="font-size: 14px;" class="totalvaluedata"></th>
                                                        <th style="font-size: 14px;" id="begtotalvarshortage"></th>
                                                        <th style="font-size: 14px;" id="begtotalvarovrage"></th>
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
                    <div class="modal-footer">
                        <div class="col-xl-12 col-lg-12">
                            <div class="row">
                                <div class="col-xl-8 col-lg-8" style="text-align: left">
                                    <input type="hidden" class="form-control" name="begInfoId" id="begInfoId" readonly="true"/> 
                                    <button type="button" id="beginningprintbtn" class="btn btn-outline-dark waves-effect"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
                                </div>
                                <div class="col-xl-4 col-lg-8" style="text-align:right;">
                                    <button id="closebuttonbeginnig" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!--End Beginning Information Modal -->

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
                                                        <span class="lead collapse-title">Basic, Delivery & Other Information</span>
                                                        
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

    <!-- Modal to  of po srtart-->
    <div class="modal modal-slide-in event-sidebar fade" id="modals-slide-in" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y:scroll;">
        <div class="modal-dialog modal-dialog-scrollable sidebar-xl" style="width: 98%;">
            <div class="modal-content p-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #ea5455 !important;font-weight:bold;">x</button>
                <div class="modal-header mb-1">
                    <h4 class="modal-title">Purchase Order Information</h4>
                    <div style="text-align: center;padding-right:30px;" id="infoStatus"></div>
                </div>
                <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                    <div class="col-xl-12" id="docinfo-block">
                            <div class="card collapse-icon">
                                <div class="collapse-default" id="accordionExample">
                                    <div class="card">
                                        <div class="card-header" id="headingOne" data-toggle="collapse" role="button" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                            <span class="lead collapse-title">Purchase order Details</span>
                                            
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
                                                                        <td><label strong style="font-size: 12px;">Commodity Type: </label></td>
                                                                        <td><b><label id="infocommoditype" strong style="font-size: 12px;"></label></b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label strong style="font-size: 12px;">Commodity Source: </label></td>
                                                                        <td><b><label id="infocommoditysource" strong style="font-size: 12px;"></label></b></td>
                                                                    </tr>
                                                                    <tr>
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
                                                    <div class="col-xl-6 col-lg-12" id="directsupplyinformationdiv" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;display:visible;">
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
                    </div>
                    <div class="divider divider-info">
                        <div class="divider-text directdivider">Commodity</div>
                    </div>
                    <div id="directcommuditylistdatabledivinfo" class="scroll scrdiv">
                        <table id="directcommudityinfodatatables" class="display table-bordered table-striped table-hover dt-responsive mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Commodity</th>
                                    <th>Grade</th>
                                    <th>Proccess Type</th>
                                    <th>Crop Year</th>
                                    <th>UOM/Bag</th>
                                    <th>No.of Bag</th>
                                    <th>Bag Weight(Kg)</th>
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
                <div class="modal-footer">
                    <div class="col-xl-12 col-lg-12">
                        <div class="row">
                            <div class="col-xl-8 col-lg-12">
                                <input type="hidden" placeholder="" class="form-control" name="porecordIds" id="porecordIds" readonly="true"/>
                                <button type="button" id="poprintbutton" class="btn btn-outline-dark"><i data-feather="printer" class="mr-25"></i>Print</button>
                            </div>
                            <div class="col-xl-4 col-lg-12" style="text-align:right;">
                                <button  type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal of po Ends-->

    <!-- Modal of Purchase Invoice Starts-->
    <div class="modal modal-slide-in event-sidebar fade" id="purchaseinvoiceinfomodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y:scroll;">
        <div class="modal-dialog modal-dialog-scrollable sidebar-xl" style="width: 98%;">
            <div class="modal-content p-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #ea5455 !important;font-weight:bold;">x</button>
                <div class="modal-header mb-1">
                    <h4 class="modal-title">Purchase Invoice Information</h4>
                    <div style="text-align: center;padding-right:30px;" id="pivinfoStatus"></div>
                </div>
                <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12">
                                <div class="card collapse-icon">
                                        <div class="collapse-default" id="accordionExample">
                                            <div class="card">
                                                <div class="card-header" id="headingOne" data-toggle="collapse" role="button" data-target="#pivcollapseOne" aria-expanded="true" aria-controls="pivcollapseOne">
                                                    <span class="lead collapse-title">Payment Invoice Details</span>
                                                    <span id="" style="font-size:16px;"></span>
                                                </div>
                                                <div id="pivcollapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-xl-3 col-lg-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                                <div class="card">
                                                                    <div class="card-header">
                                                                        <h6 class="card-title">Purchase Invoice Information</h6>
                                                                    </div>
                                                                    <div class="card-body scroll scrdiv" style="height:18rem;">
                                                                        <table class="table-responsive">
                                                                            <tr>
                                                                                <td><label strong style="font-size: 12px;">Purchase Invoice#: </label></td>
                                                                                <td><b><label id="pivdocno" strong style="font-size: 12px;"></label></b></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><label strong style="font-size: 12px;">Reference: </label></td>
                                                                                <td><b><label id="pivinforefernce" strong style="font-size: 12px;"></label></b></td>
                                                                            </tr>
                                                                            <tr class="infopetrpo">
                                                                                <td><label strong style="font-size: 12px;">Purchase Order#: </label></td>
                                                                                <td><b><label id="pivinfopo" class="pivinfopo" strong style="font-size: 12px;"></label></b></td>
                                                                            </tr>
                                                                            
                                                                            <tr>
                                                                                <td><label strong style="font-size: 12px;">Commodity Type: </label></td>
                                                                                <td><b><label id="pivinfocommoditype" strong style="font-size: 12px;"></label></b></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><label strong style="font-size: 12px;">Commodity Source: </label></td>
                                                                                <td><b><label id="pivinfocommoditysource" strong style="font-size: 12px;"></label></b></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><label strong style="font-size: 12px;">Commodity Status: </label></td>
                                                                                <td><b><label id="pivinfocommoditystatus" strong style="font-size: 12px;"></label></b></td>
                                                                            </tr>
                                                                            
                                                                            <tr>
                                                                                <td><label strong style="font-size: 12px;">Prepare Date: </label></td>
                                                                                <td><b><label id="pivinfodocumentdate" strong style="font-size: 12px;"></label></b></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><label strong style="font-size: 12px;">Payment Type: </label></td>
                                                                                <td><b><label id="pivinfopaymentype" strong style="font-size: 12px;"></label></b></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><label strong style="font-size: 12px;">Reciept Type: </label></td>
                                                                                <td><b><label id="pivinforecieptype" strong style="font-size: 12px;"></label></b></td>
                                                                            </tr>
                                                                            <tr id="payrinfomrcnotr">
                                                                                <td><label strong style="font-size: 12px;">MRC NO: </label></td>
                                                                                <td><b><label id="pivinfomrcno" strong style="font-size: 12px;"></label></b></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><label strong style="font-size: 12px;">Invoice/Ref#: </label></td>
                                                                                <td><b><label id="pivinfoinvoice" strong style="font-size: 12px;"></label></b></td>
                                                                            </tr>
                                                                            
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-3 col-lg-12" id="directsupplyinformationdiv" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;display:visible;">
                                                                <div class="card">
                                                                    <div class="card-header">
                                                                        <h6 class="card-title">Supplier Information</h6>
                                                                    </div>
                                                                    <div class="card-body scroll scrdiv" style="height:18rem;">
                                                                        
                                                                        <table style="width: 100%">
                                                                            <tr>
                                                                                <td><label strong style="font-size: 12px;">ID: </label></td>
                                                                                <td><b><label id="pivinfosuppid" strong style="font-size: 12px;"></label></b></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><label strong style="font-size: 12px;">Name: </label></td>
                                                                                <td><b><label id="pivinfsupname" strong style="font-size: 12px;"></label></b></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><label strong style="font-size: 12px;">TIN: </label></td>
                                                                                <td><b><label id="pivinfosupptin" strong style="font-size: 12px;"></label></b></td>
                                                                            </tr>
                                                                            
                                                                        </table>
                                                                            <div class="divider divider-secondary">
                                                                                <div class="divider-text"><b>Memo</b></div>
                                                                            </div>
                                                                            <table class="table-responsive">
                                                                                
                                                                                <tr>
                                                                                    <td><label id="paymentrequestinfomemo" class="paymentrequestinfopurpose" strong style="font-size: 12px;"></label></td>
                                                                                </tr>
                                                                                
                                                                            </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-4 col-lg-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                                <div class="card">
                                                                    <div class="card-header">
                                                                        <h6 class="card-title">Attached Document</h6>
                                                                    </div>
                                                                    <div class="card-body scroll scrdiv" style="height:18rem;">
                                                                        <iframe src="" id="purchaseinvoicepdfviewer" width="100%" height="400px"></iframe>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-2 col-lg-3" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;height:20rem">
                                                                <h5>Actions</h5>
                                                                <div class="scroll scrdiv">
                                                                    <ul class="timeline" id="paymentinvoiceulist" style="height:18rem;">
                                                                            
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                    <div class="divider divider-secondary" id="dividerinfo">
                                        <div class="divider-text directdivider">Commodity</div>
                                    </div>
                            </div>
                                
                        </div>
                        <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="table-responsive scroll scrdiv">
                                        <table id="pivtable" class="display table-bordered table-striped table-hover dt-responsive mb-1">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>GRN</th>
                                                    <th>Commodity</th>
                                                    <th>Crop Year</th>
                                                    <th>Preparation</th>
                                                    <th>Grade</th>
                                                    <th>UOM/Bag</th>
                                                    <th>No. of Bag</th>
                                                    <th>NET KG</th>
                                                    <th>TON</th>
                                                    <th>Feresula</th>
                                                    <th>Price</th>
                                                    <th>Total</th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="5" style="text-align:left;background-color: #FFFFFF;border:none;padding:0px;"></td>
                                                    <th colspan="2" style="text-align: right;">Total</th>
                                                    <th id="pinfonofbagtotal"></th>
                                                    <th id="pinfokgtotal"></th>
                                                    <th id="pinfotontotal"></th>
                                                    <th id="pinfopriceferesula"></th>
                                                    <th id="pinfopricetotal"></th>
                                                    <th id="pinfototalpricetotal"></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-xl-9 col-lg-12">
                                            
                                            <div class="row">
                                                <div class="col-xl-8 col-lg-12">
                                                    
                                            </div>

                                            <div class="col-xl-4 col-lg-12 mt-1">
                                                <label id="grvhistory">GRv</label>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-12 mt-1">
                                            <table style="width:100%;" id="pivinfodirectinfopricetable" class="rtable">
                                                <tr>
                                                    <td style="text-align: right; width:50%;"><label strong style="font-size: 16px;">Sub Total</label></td>
                                                    <td style="text-align: center; width:50%;"><label id="pivinfodirectinfosubtotalLbl" strong style="font-size: 16px; font-weight: bold;"></label></td>
                                                    
                                                </tr>
                                                <tr id="pivinfosupplierinfotaxtr" style="display: visible;">
                                                    <td style="text-align: right;"><label strong style="font-size: 16px;">Tax(15%)</label></td>
                                                    <td style="text-align: center;"><label id="pivinfodirectinfotaxLbl" strong style="font-size: 16px; font-weight: bold;"></label></td>
                                                
                                                </tr>
                                                <tr id="pivinfosupplierinforandtotaltr" style="display: visible;">
                                                    <td style="text-align: right;"><label strong style="font-size: 16px;">Grand Total</label></td>
                                                    <td style="text-align: center;"><label id="pivinfodirectinfograndtotalLbl" strong style="font-size: 16px; font-weight: bold;" ></label></td>
                                                    
                                                </tr>
                                                <tr id="pivinfovisibleinfowitholdingTr" style="display: visible;">
                                                    <td style="text-align: right;"><label id="withodingTitleLbl" strong style="font-size: 16px;">Withold(2%)</label></td>
                                                    <td style="text-align: center;">
                                                        <label id="pivinfodirectinfowitholdingAmntLbl" class="formattedNum" strong style="font-size: 16px; font-weight: bold;"></label>
                                                        
                                                    </td>
                                                </tr>
                                                
                                                <tr id="pivinfodirectinfonetpayTr" style="display: visible;">
                                                    <td style="text-align: right;"><label strong style="font-size: 16px;">Net Pay</label></td>
                                                    <td style="text-align: center;">
                                                        <label id="pivinfodirectinfonetpayLbl" class="formattedNum" strong style="font-size: 16px; font-weight: bold;" class="lbl"></label>
                                                        
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td style="text-align: right;"><label strong style="font-size: 16px;">No. of Items</label></td>
                                                    <td style="text-align: center;"><label id="pivinfodirectinfonumberofItemsLbl" strong style="font-size: 16px; font-weight: bold;">0</label></td>
                                                    
                                                </tr>
                                                
                                            </table>
                                        </div>
                                        
                                    </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">    
                    <button id="" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal of Purchase Invoice Ends-->

    <!-- Modal of Purchase Invoice History Start-->
    <div class="modal modal-slide-in event-sidebar fade" id="purchaseinvloicehistorymodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y:scroll;">
        <div class="modal-dialog modal-dialog-scrollable sidebar-xl" style="width: 80%;">
            <div class="modal-content p-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #ea5455 !important;font-weight:bold;">x</button>
                <div class="modal-header mb-1">
                    <h4 class="modal-title" id="paymentinvoicehistorystatus"></h4>
                </div>
                <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                    <div>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12">
                                <div class="table-responsive scroll scrdiv">
                                    <table id="historpurchaseinvoicetables" class="display table-bordered table-striped table-hover dt-responsive mb-0" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>GRV#</th>
                                                <th>PIV#</th>
                                                <th>Invoice Date</th>
                                                <th>Voucher Type </th>
                                                <th>Payment Type</th>
                                                <th>MRC</th>
                                                <th>Doc/FS#</th>
                                                <th>Invoice/Ref#</th>
                                                <th>Status</th>
                                                
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
                    <button id="" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal of Purchase Invoice History End-->

    <!--Start Production Information Modal -->
    <div class="modal modal-slide-in event-sidebar fade" id="informationmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel35" aria-hidden="true" style="overflow-y: scroll;">
        <form id="InformationForm">
        {{ csrf_field() }}
            <div class="modal-dialog sidebar-xl" style="width:98%;">
                <div class="modal-content p-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #ea5455 !important;font-weight:bold;">x</button>
                    <div class="modal-header">
                        <h4 class="modal-title">Production Order Information</h4>
                        <div style="text-align: center;padding-right:30px;" id="prdstatustitles"></div>
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
                                                        <span class="lead collapse-title">Company, Production & Other Information</span>
                                                        
                                                    </div>
                                                    <div id="collapse1" role="tabpanel" aria-labelledby="headingCollapse2" class="collapse infoscl">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-lg-12 col-md-12 col-sm-12 col-12" style="background-color: #FFFFFF;">
                                                                    <ul class="nav nav-tabs nav-fill" role="tablist" style="border:1px solid #D3D3D3">
                                                                        <li class="nav-item">
                                                                            <a class="nav-link prinfotab active" id="basicprinfotab" data-toggle="tab" aria-controls="basicprinfotab" href="#basicprinfotabBody" role="tab" aria-selected="true" onclick="infoPrdFn(1)">Basic</a>
                                                                        </li>
                                                                        <li class="nav-item">
                                                                            <a class="nav-link prinfotab" id="certprinfotab" data-toggle="tab" aria-controls="certprinfotab" href="#certprinfotabaBody" role="tab" aria-selected="true" onclick="infoPrdFn(2)">Instruction & Others</a>
                                                                        </li>
                                                                        
                                                                    </ul>
                                                                    <div class="tab-content">
                                                                        <div class="tab-pane prinfotabBody active" id="basicprinfotabBody" role="tabpanel" aria-labelledby="basicprinfotabBody">
                                                                            <div class="row">
                                                                                
                                                                                <div class="col-lg-3 col-md-6 col-sm-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                                                    <table style="width: 100%;">
                                                                                        <tr>
                                                                                            <td colspan="2" style="text-align: left;">
                                                                                                <label style="font-size: 17px;font-weight:bold;color:#5E5873;">Company Information</label>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr><td colspan="2"></td></tr>
                                                                                        <tr>
                                                                                            <td style="width: 50%;"><label style="font-size: 14px;">Company Type</label></td>
                                                                                            <td style="width: 50%;"><label id="infocompanytypelbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Customer Code</label></td>
                                                                                            <td><label id="infocustomercodelbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Customer Name</label></td>
                                                                                            <td><label id="infocustomerlbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Customer TIN</label></td>
                                                                                            <td><label id="infocustomertinlbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Customer Phone</label></td>
                                                                                            <td><label id="infocustomerphonelbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Customer Email</label></td>
                                                                                            <td><label id="infocustomeremaillbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Representative Name</label></td>
                                                                                            <td><label id="inforepnamelbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Representative Phone</label></td>
                                                                                            <td><label id="inforrepphonelbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </div>
                                                                                <div class="col-lg-3 col-md-6 col-sm-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                                                    <table style="width: 100%;">
                                                                                        <tr>
                                                                                            <td colspan="2" style="text-align: left;">
                                                                                                <label style="font-size: 17px;font-weight:bold;color:#5E5873;">Production Information</label>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr><td colspan="2"></td></tr>
                                                                                        <tr>
                                                                                            <td style="width: 45%;"><label style="font-size: 14px;">Output Type</label></td>
                                                                                            <td style="width: 55%;"><label id="infooutputtypelbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Production Type</label></td>
                                                                                            <td><label id="infoproductiontype" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Bill of Material <i>(BOM)</i></label></td>
                                                                                            <td><label id="infobomlbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Commodity</label></td>
                                                                                            <td><label id="infocommoditylbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Grade</label></td>
                                                                                            <td><label id="infogradelbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Process Type</label></td>
                                                                                            <td><label id="infoprocesstypelbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Symbol</label></td>
                                                                                            <td><label id="infosymbollbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Production Store</label></td>
                                                                                            <td><label id="infoproductionstorelbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </div>
                                                                                <div class="col-lg-6 col-md-12 col-sm-12">
                                                                                    <table style="width: 100%;">
                                                                                        <tr>
                                                                                            <td colspan="3" style="text-align: left;">
                                                                                                <label style="font-size: 17px;font-weight:bold;color:#5E5873;">Date, Contract No. & Certificate No. Information</label>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td colspan="3"></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td style="width: 25%;"><label style="font-size: 14px;">Order Date</label></td>
                                                                                            <td style="width: 25%;"><label id="infoorderdatelbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                            <td style="width: 50%" rowspan="3" id="infocertificatenumberlbl"></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Shipping Date</label></td>
                                                                                            <td><label id="infodeadlinelbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Production Start Date</label></td>
                                                                                            <td><label id="infoproductionstdatelbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Production End Date</label></td>
                                                                                            <td><label id="infoproductionendatelbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Contract Number</label></td>
                                                                                            <td><label id="infocontractnumlbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Expected Amount</label></td>
                                                                                            <td><label id="infoexpectedamountlbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr style="display: none;">
                                                                                            <td><label style="font-size: 14px;">Grain Pro</label></td>
                                                                                            <td><label id="infograinprolbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="tab-pane prinfotabBody" id="certprinfotabaBody" role="tabpanel" aria-labelledby="certprinfotabaBody">
                                                                            <div class="row">
                                                                                <div class="col-lg-5 col-md-12 col-sm-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                                                    <table style="width: 100%;">
                                                                                        <tr>
                                                                                            <td colspan="2" style="text-align: left;">
                                                                                                <label style="font-size: 17px;font-weight:bold;color:#5E5873;">Instructions Information</label>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr><td colspan="2"></td></tr>
                                                                                        <tr>
                                                                                            <td style="width: 32%;"><label style="font-size: 14px;">Sieve Size</label></td>
                                                                                            <td style="width: 68%;"><label id="infosievesizelbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">C Grade</label></td>
                                                                                            <td><label id="infocgradelbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Thick Coffee</label></td>
                                                                                            <td><label id="infothickcoffeelbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Moisture</label></td>
                                                                                            <td><label id="infomoisturelbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Water Activity</label></td>
                                                                                            <td><label id="infowateractivitylbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Defect Count</label></td>
                                                                                            <td><label id="infodefectcountlbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Front Side Bag Label</label></td>
                                                                                            <td><label id="infofrontsidebaglabellbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Back Side Bag Label</label></td>
                                                                                            <td><label id="infobacksidebaglabellbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Additional Instruction</label></td>
                                                                                            <td><label id="infoadditionalinstructionlbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </div>
                                                                                <div class="col-lg-4 col-md-6 col-sm-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                                                    <table style="width: 100%;">
                                                                                        <tr>
                                                                                            <td colspan="2" style="text-align: left;">
                                                                                                <label style="font-size: 17px;font-weight:bold;color:#5E5873;">Miscellaneous Information</label>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr><td colspan="2"></td></tr>
                                                                                        <tr>
                                                                                            <td style="width:45%;"><label style="font-size: 14px;">Assigned Personnel to Follow-Up</label></td>
                                                                                            <td style="width:55%;"><label id="infoassignedpersonnellbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Additional File</label></td>
                                                                                            <td>
                                                                                                <a style="text-decoration:underline;color:blue;" onclick="addFileDownload()" id="infoadditionalfilelbl"></a>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Remark</label></td>
                                                                                            <td><label id="inforemarklbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </div>
                                                                                <div class="col-lg-3 col-md-6 col-sm-12">
                                                                                    <table style="width: 100%;">
                                                                                        <tr>
                                                                                            <td colspan="2" style="text-align: left;">
                                                                                                <label style="font-size: 17px;font-weight:bold;color:#5E5873;">Action Information</label>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr><td colspan="2"></td></tr>
                                                                                        <tr>
                                                                                            <td colspan="2">
                                                                                                <div class="col-lg-12 col-md-12 col-sm-12 scrdivhor scrollhor" style="overflow-y: scroll;height:15rem">
                                                                                                    <ul id="actiondiv" class="timeline mb-0 mt-0"></ul>
                                                                                                </div>
                                                                                            </td>
                                                                                        </tr>
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
                                    </section>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-lg-12" style="background-color: #FFFFFF;">
                                    <ul class="nav nav-tabs nav-fill" role="tablist" style="border:1px solid #D3D3D3">
                                        <li class="nav-item">
                                            <a class="nav-link prdtab active" id="bomratio" data-toggle="tab" aria-controls="bomratio" href="#bomratiotab" role="tab" aria-selected="true" onclick="infoPrdFn(1)">BOM / Ratio</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link prdtab" id="prdprocess" data-toggle="tab" aria-controls="prdprocess" href="#prdprocesstab" role="tab" aria-selected="true" onclick="infoPrdFn(2)">Production Input</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link prdtab" id="prdprocessoutput" data-toggle="tab" aria-controls="prdprocessoutput" href="#prdoutputtab" role="tab" aria-selected="true" onclick="infoPrdFn(3)">Production Output</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">

                                        <div class="tab-pane prdtabcon active" id="bomratiotab" role="tabpanel" aria-labelledby="bomratiotab">
                                            <div class="row">
                                                
                                                <div class="col-xl-12 col-md-12 col-lg-12 scrdivhor scrollhor" style="overflow-y: auto;height:30rem;">
                                                    <table id="commodityinfotbl" class="display table-bordered table-striped table-hover dt-responsive mb-0 infodatatbl" style="width:100%;">
                                                        <thead>
                                                            <tr>
                                                                <th style="width:2%;">#</th>
                                                                <th style="width:5%;">Type</th>
                                                                <th style="width:5%;">Commodity</th>
                                                                <th style="width:5%;">Grade</th>
                                                                <th style="width:5%;">Process Type</th>
                                                                <th style="width:5%;">Crop Year</th>
                                                                <th style="width:5%;">Symbol</th>
                                                                <th style="width:5%;">Supplier</th>
                                                                <th style="width:5%;">GRN No.</th>
                                                                <th style="width:5%;">Production Order No.</th>
                                                                <th style="width:5%;">Certificate No.</th>
                                                                <th style="width:5%;">Store</th>
                                                                <th style="width:4%;">Floor Map</th>
                                                                <th style="width:4%;">UOM/Bag</th>
                                                                <th style="width:5%;" title="Quantity by UOM/Bag or Weight by UOM/Bag">No. of Bag</th>
                                                                <th style="width:5%;" title="Weight by KG">Weight by KG</th>
                                                                <th style="width:5%;">Unit Cost</th>
                                                                <th style="width:5%;">Total Cost  <i class="fa-solid fa-circle-info" title="Weight by KG * Unit Cost"></i></th>
                                                                <th style="width:5%;">Variance Shortage by KG</th>
                                                                <th style="width:5%;">Variance Overage by KG</th>
                                                                <th style="width:5%;">Remark</th>
                                                            </tr>
                                                        <thead>
                                                        <tbody class="table table-sm"></tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th colspan="14" style="font-size: 16px;text-align: right;padding-right:7px;">Total</th>
                                                                <th>
                                                                    <label style="font-size: 14px;font-weight:bold;" class="infototalbag" id="infototalbag"></label>
                                                                </th>
                                                                <th>
                                                                    <label style="font-size: 14px;font-weight:bold;" class="infototalkg" id="infototalkg"></label>
                                                                </th>
                                                                <th></th>
                                                                <th>
                                                                    <label style="font-size: 14px;font-weight:bold;" class="infototalcost" id="infototalcost"></label>
                                                                </th>
                                                                <th>
                                                                    <label style="font-size: 14px;font-weight:bold;" class="infototalvarshortage" id="infototalvarshortage"></label>
                                                                </th>
                                                                <th>
                                                                    <label style="font-size: 14px;font-weight:bold;" class="infototalvaroverage" id="infototalvaroverage"></label>
                                                                </th>
                                                                <th></th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane prdtabcon" id="prdprocesstab" role="tabpanel" aria-labelledby="prdprocesstab">
                                            <div class="col-xl-12 col-md-12 col-lg-12">
                                                <div class="row">
                                                    <div class="col-xl-2 col-md-2 col-lg-2" style="border:1px solid #D3D3D3">
                                                        <!-- Tab navs -->
                                                        <div class="nav flex-column nav-tabs text-center" id="v-tabs-tab" role="tablist" aria-orientation="vertical">
                                                            <a class="nav-link active prdprcinfo" id="prddetailtab" data-toggle="tab" href="#prddetailtabBody" role="tab" aria-controls="prddetailtab" aria-selected="true">Production Detail</a>
                                                            <a class="nav-link prdprcinfo" id="prddurationtab" data-toggle="tab" href="#prddurationtabBody" role="tab" aria-controls="prddurationtabBody" aria-selected="false">Duration</a>
                                                        </div>
                                                        <!-- Tab navs -->
                                                    </div>
                                                    <div class="col-xl-10 col-md-10 col-lg-10 p-1 scrdivhor scrollhor" style="overflow-y: auto;height:30rem;">
                                                        <div class="tab-content" id="v-tabs-tabContent">
                                                            <div class="tab-pane active prdprcinfobody" id="prddetailtabBody" role="tabpanel" aria-labelledby="prddetailtabBody"> 
                                                                <table id="prdprocesstbl" class="table-bordered table-striped table-hover dt-responsive table table-sm display mb-0" style="text-align:center;width:98%;">
                                                                    {{-- <thead>
                                                                        <tr>
                                                                            <th style="width:3%;background-color:#FFFFFF;text-transform: none;">#</th>
                                                                            <th style="width:0%;display:none;"></th>
                                                                            <th style="width:0%;display:none;"></th>
                                                                            <th style="width:16%;background-color:#FFFFFF;text-transform: none;">Date</th>
                                                                            <th style="width:16%;background-color:#FFFFFF;text-transform: none;">Floor Map</th>
                                                                            <th style="width:16%;background-color:#FFFFFF;text-transform: none;">UOM/ Bag</th>
                                                                            <th style="width:16%;background-color:#FFFFFF;text-transform: none;">Qty. by UOM/ Bag</th>
                                                                            <th style="width:16%;background-color:#FFFFFF;text-transform: none;">Qty. by KG</th>
                                                                            <th style="width:17%;background-color:#FFFFFF;text-transform: none;">Remark</th>
                                                                        </tr>
                                                                    <thead> --}}
                                                                    <tbody></tbody>
                                                                    <tfoot class="table table-sm">
                                                                        <tr>
                                                                            <td colspan="9" style="text-align: right;">
                                                                                Grand Total
                                                                            </td>
                                                                            <td colspan="2">
                                                                                <table id="infograndtotal" class="mb-0 mt-1 table table-sm" style="width:100%;padding:0px;">
                                                                                    <tr style="text-align: center;display:none;">
                                                                                        <td style="width:50%;">Moisture %</td>
                                                                                        <td style="width:50%;">
                                                                                            <b><label style="font-size: 14px;" class="infograndTotalLblCls" id="infoMoisturePercentTotalLbl"></label></b>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr style="text-align: center;">
                                                                                        <td style="width:50%;">No. of Bag</td>
                                                                                        <td style="width:50%;">
                                                                                            <b><label style="font-size: 14px;" class="infograndTotalLblCls" id="infoNoOfBagLbl"></label></b>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr style="text-align: center;padding:0px;">
                                                                                        <td>Weight by KG</td>
                                                                                        <td>
                                                                                            <b><label style="font-size: 14px;" class="infograndTotalLblCls" id="infoWeightinKGLbl"></label></b>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr style="text-align: center;padding:0px;">
                                                                                        <td>Variance Shortage by KG</td>
                                                                                        <td>
                                                                                            <b><label style="font-size: 14px;" class="infograndTotalLblCls" id="infoVarianceShortage"></label></b>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr style="text-align: center;padding:0px;">
                                                                                        <td>Variance Overage by KG</td>
                                                                                        <td>
                                                                                            <b><label style="font-size: 14px;" class="infograndTotalLblCls" id="infoVarianceOverage"></label></b>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr style="text-align: center;display:none;">
                                                                                        <td>Bag Weight by KG</td>
                                                                                        <td>
                                                                                            <b><label style="font-size: 14px;" class="infograndTotalLblCls" id="infoBagWeightLbl"></label></b>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr style="text-align: center;display:none;">
                                                                                        <td>Adjustment</td>
                                                                                        <td>
                                                                                            <b><label style="font-size: 14px;" class="infograndTotalLblCls" id="infoAdjustmentLbl"></label></b>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr style="text-align: center;display:none;">
                                                                                        <td>Net Weight by KG</td>
                                                                                        <td>
                                                                                            <b><label style="font-size: 14px;" class="infograndTotalLblCls" id="infoNetWeightLbl"></label></b>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </tfoot>
                                                                </table>
                                                            </div>
                                                            <div class="tab-pane prdprcinfobody" id="prddurationtabBody" role="tabpanel" aria-labelledby="prddurationtabBody">
                                                                <table id="prdprocessdurationtbl" class="display table-bordered table-striped table-hover dt-responsive table table-sm mb-0" style="text-align:center;width:100%;">
                                                                    <thead>
                                                                        <tr>
                                                                            <th style="width:3%;background-color:#FFFFFF;text-transform: none;">#</th>
                                                                            <th style="width:33%;background-color:#FFFFFF;text-transform: none;">Start Time</th>
                                                                            <th style="width:34%;background-color:#FFFFFF;text-transform: none;">End Time</th>
                                                                            <th style="width:30%;background-color:#FFFFFF;text-transform: none;">Duration</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody></tbody>
                                                                    <tfoot>
                                                                        <tr>
                                                                            <th colspan="3" style="text-align: right;background-color:#FFFFFF;text-transform: none;">Total</th>
                                                                            <th id="totaldurationlbl" style="text-align:center;background-color:#FFFFFF;text-transform: none;"></th>
                                                                        </tr>
                                                                    </tfoot>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane prdtabcon" id="prdoutputtab" role="tabpanel" aria-labelledby="prdoutputtab">
                                            <div class="col-xl-12 col-md-12 col-lg-12">
                                                <div class="row">
                                                    <div class="col-xl-2 col-md-2 col-lg-2" style="border:1px solid #D3D3D3">
                                                        <!-- Tab navs -->
                                                        <div class="nav flex-column nav-tabs text-center" id="v-outputtabs-tab" role="tablist" aria-orientation="vertical">
                                                            <a class="nav-link active prdoutputinfo" id="prdoutputexptab" data-toggle="tab" href="#prdoutputexpbody" role="tab" aria-controls="prdoutputexptab" aria-selected="true" onclick="prdOUtputFn(1)">Clean / Refined</a>
                                                            <a class="nav-link prdoutputinfo" id="prdoutputrejtab" data-toggle="tab" href="#prdoutputrejbody" role="tab" aria-controls="prdoutputrejtab" aria-selected="false" onclick="prdOUtputFn(2)">Reject</a>
                                                            <a class="nav-link prdoutputinfo" id="prdoutputwastab" data-toggle="tab" href="#prdoutputwasbody" role="tab" aria-controls="prdoutputwastab" aria-selected="false" onclick="prdOUtputFn(3)">Wastage & Stubble</a>
                                                            <a class="nav-link prdoutputinfo" id="prdoutputsummarytab" data-toggle="tab" href="#prdoutputsummarybody" role="tab" aria-controls="prdoutputsummarytab" aria-selected="false" onclick="prdOUtputFn(4)">Summary</a>
                                                        </div>
                                                        <!-- Tab navs -->
                                                    </div>
                                                    <div class="col-xl-10 col-md-10 col-lg-10 scrdivhor scrollhor" style="overflow-y: auto;height:30rem;">
                                                        <div class="tab-content" id="v-tabs-tabOutputContent">
                                                            <div class="tab-pane active prdoutputinfotabbody" id="prdoutputexpbody" role="tabpanel" aria-labelledby="prdoutputexpbody"> 
                                                                <div class="row">
                                                                    <div class="col-xl-12 col-md-12 col-lg-12">
                                                                        <table id="exportoutputtbl" class="display table-bordered table-striped table-hover dt-responsive mb-0 defaultdatatable" style="width:100%;">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th colspan="13" style="text-align: center;font-size:16px;">Clean / Refined</th>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th rowspan="2" style="width: 3%;">#</th>
                                                                                    <th rowspan="2" style="width: 8%;">Floor Map</th>
                                                                                    <th rowspan="2" style="width: 8%;">Type</th>
                                                                                    <th rowspan="2" style="width: 8%;">Certificate No.</th>
                                                                                    <th rowspan="2" style="width: 8%;">UOM/Bag</th>
                                                                                    <th rowspan="2" style="width: 8%;">No. of Bag</th>
                                                                                    <th rowspan="2" style="width: 8%;">Bag Weight by KG</th>    
                                                                                    <th rowspan="2" style="width: 8%;">Total KG</th>
                                                                                    <th rowspan="2" style="width: 8%;">Net KG</th>
                                                                                    <th rowspan="2" style="width: 8%;">Feresula</th>
                                                                                    <th colspan="2" style="width: 12%">Variance by KG</th>
                                                                                    <th rowspan="2" style="width: 13%;">Inspection</th>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th style="width: 6%;">Shortage</th>
                                                                                    <th style="width: 6%;">Overage</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody class="table table-sm"></tbody>
                                                                            <tfoot>
                                                                                <tr>
                                                                                    <th colspan="5" style="text-align: right;">Total</th>
                                                                                    
                                                                                    <th id="exptotnumofbag" style="text-align:left;padding-left:6px;"></th>
                                                                                    <th id="exptotbagweight" style="text-align:left;padding-left:6px;"></th>
                                                                                    <th id="exptotalkg" style="text-align:left;padding-left:6px;"></th>
                                                                                    <th id="expnetkg" style="text-align:left;padding-left:6px;"></th>
                                                                                    <th id="exptotferesula" style="text-align:left;padding-left:6px;"></th>
                                                                                    <th id="exptotshortage" style="text-align:left;padding-left:6px;"></th>
                                                                                    <th id="exptotoverage" style="text-align:left;padding-left:6px;"></th>
                                                                                    <th id="expinsp" style="text-align:left;padding-left:6px;"></th>
                                                                                </tr>
                                                                            </tfoot>
                                                                        </table>
                                                                        <table class="rtable mt-2" style="width: 100%">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th style="text-align: left;background-color: #FFFFFF">Remark</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr style="padding: 1px 1px 1px 1px;">
                                                                                    <td style="text-align: left;padding-left:5px;">
                                                                                        <label style="font-size: 14px;" id="exportinforemark"></label>
                                                                                    </td>
                                                                                </tr>
                                                                            <tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tab-pane prdoutputinfotabbody" id="prdoutputrejbody" role="tabpanel" aria-labelledby="prdoutputrejbody">
                                                                <div class="row">
                                                                    <div class="col-xl-12 col-md-12 col-lg-12">
                                                                        <table id="rejectoutputtbl" class="display table-bordered table-striped table-hover dt-responsive mb-0 defaultdatatable" style="width:100%;">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th colspan="14" style="text-align: center;font-size:16px;">Reject</th>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th rowspan="2" style="width: 3%;">#</th>
                                                                                    <th rowspan="2" style="width: 7%;">Floor Map</th>
                                                                                    <th rowspan="2" style="width: 7%;"></th>
                                                                                    <th rowspan="2" style="width: 7%;">Reject Type</th>
                                                                                    <th rowspan="2" style="width: 7%;">Certificate No.</th>
                                                                                    <th rowspan="2" style="width: 7%;">UOM/Bag</th>
                                                                                    <th rowspan="2" style="width: 7%;">No. of Bag</th>
                                                                                    <th rowspan="2" style="width: 7%;">Bag Weight by KG</th>    
                                                                                    <th rowspan="2" style="width: 7%;">Total KG</th>
                                                                                    <th rowspan="2" style="width: 7%;">Net KG</th>
                                                                                    <th rowspan="2" style="width: 7%;">Feresula</th>
                                                                                    <th colspan="2" style="width: 14%">Variance by KG</th>
                                                                                    <th rowspan="2" style="width: 13%;">Inspection</th>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th style="width: 7%;">Shortage</th>
                                                                                    <th style="width: 7%;">Overage</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody class="table table-sm"></tbody>
                                                                            <tfoot>
                                                                                <tr>
                                                                                    <th colspan="6" style="text-align: right;">Total</th>
                                                                                    <th id="rejtotnumofbag" style="text-align:left;padding-left:6px;"></th>
                                                                                    <th id="rejtotbagwgt" style="text-align:left;padding-left:6px;"></th>
                                                                                    <th id="rejtotkg" style="text-align:left;padding-left:6px;"></th>
                                                                                    <th id="rejtotnetkg" style="text-align:left;padding-left:6px;"></th>
                                                                                    <th id="rejtotferesula" style="text-align:left;padding-left:6px;"></th>
                                                                                    <th id="rejtotshortage" style="text-align:left;padding-left:6px;"></th>
                                                                                    <th id="rejtotoverage" style="text-align:left;padding-left:6px;"></th>
                                                                                    <th id="rejins" style="text-align:left"></th>
                                                                                </tr>
                                                                            </tfoot>
                                                                        </table>
                                                                    </div>
                                                                    <div class="col-xl-3 col-md-8 col-lg-6" style="display: none;">
                                                                        <table class="rtable mt-2" style="width: 100%">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th style="text-align: left;background-color: #FFFFFF">Floor Map</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td style="text-align: left;padding-left:5px;">
                                                                                        <label style="font-size: 14px;" id="rejfloormaplbl"></label>
                                                                                    </td>
                                                                                </tr>
                                                                            <tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="col-xl-12 col-md-12 col-lg-12 col-sm-12">
                                                                        <table class="rtable mt-2" style="width: 100%">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th style="text-align: left;background-color: #FFFFFF">Remark</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td style="text-align: left;padding-left:5px;">
                                                                                        <label style="font-size: 14px;" id="rejectinforemark"></label>
                                                                                    </td>
                                                                                </tr>
                                                                            <tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tab-pane prdoutputinfotabbody" id="prdoutputwasbody" role="tabpanel" aria-labelledby="prdoutputwasbody">
                                                                <div class="row">
                                                                    <div class="col-xl-12 col-md-12 col-lg-12">
                                                                        <table id="wastageoutputtbl" class="display table-bordered table-striped table-hover dt-responsive mb-0 defaultdatatable" style="width:100%;">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th colspan="13" style="text-align: center;font-size:16px;">Wastage & Stubble</th>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th rowspan="2" style="width: 3%;">#</th>
                                                                                    <th rowspan="2" style="width: 8%;">Wastage Type</th>
                                                                                    <th rowspan="2" style="width: 8%;">Floor Map</th>
                                                                                    <th rowspan="2" style="width: 8%;">Certificate No.</th>
                                                                                    <th rowspan="2" style="width: 8%;">UOM/Bag</th>
                                                                                    <th rowspan="2" style="width: 8%;">No. of Bag</th>
                                                                                    <th rowspan="2" style="width: 8%;">Bag Weight by KG</th>    
                                                                                    <th rowspan="2" style="width: 8%;">Total KG</th>
                                                                                    <th rowspan="2" style="width: 7%;">Net KG</th>
                                                                                    <th rowspan="2" style="width: 7%;">Feresula</th>
                                                                                    <th colspan="2" style="width: 14%">Variance by KG</th>
                                                                                    <th rowspan="2" style="width: 13%;">Inspection</th>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th style="width: 7%;">Shortage</th>
                                                                                    <th style="width: 7%;">Overage</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody class="table table-sm"></tbody>
                                                                            <tfoot>
                                                                                <tr>
                                                                                    <th colspan="5" style="text-align: right;">Total</th>
                                                                                    <th id="wastotnumofbag" style="text-align:left;padding-left:6px;"></th>
                                                                                    <th id="wastotbagwgt" style="text-align:left;padding-left:6px;"></th>
                                                                                    <th id="wastotkg" style="text-align:left;padding-left:6px;"></th>
                                                                                    <th id="wastotnetkg" style="text-align:left;padding-left:6px;"></th>
                                                                                    <th id="wastotferesula" style="text-align:left;padding-left:6px;"></th>
                                                                                    <th id="wastotshortage" style="text-align:left;padding-left:6px;"></th>
                                                                                    <th id="wastotoverage" style="text-align:left;padding-left:6px;"></th>
                                                                                    <th id="wasins" style="text-align:left"></th>
                                                                                </tr>
                                                                            </tfoot>
                                                                        </table>
                                                                    </div>
                                                                    <div class="col-xl-3 col-md-8 col-lg-6" style="display:none;">
                                                                        <table class="rtable mt-2" style="width: 100%">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th style="text-align: left;background-color: #FFFFFF">Floor Map</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td style="text-align: left;padding-left:5px;">
                                                                                        <label style="font-size: 14px;" id="wastagefloormaplbl"></label>
                                                                                    </td>
                                                                                </tr>
                                                                            <tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="col-xl-12 col-md-12 col-lg-12 col-sm-12">
                                                                        <table class="rtable mt-2" style="width: 100%">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th style="text-align: left;background-color: #FFFFFF">Remark</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td style="text-align: left;padding-left:5px;">
                                                                                        <label style="font-size: 14px;" id="wastageinforemark"></label>
                                                                                    </td>
                                                                                </tr>
                                                                            <tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tab-pane prdoutputinfotabbody" id="prdoutputsummarybody" role="tabpanel" aria-labelledby="prdoutputsummarybody">
                                                                <div class="row">
                                                                    <div class="col-xl-12 col-md-12 col-lg-12">
                                                                        <table id="infoSummaryTable" class="rtable" style="width: 100%">
                                                                            <thead style="text-align:center;background-color:#FFFFFF;">
                                                                                <tr>
                                                                                    <th colspan="10" style="text-align: center;background-color:#FFFFFF;">
                                                                                        <label style="font-size: 18px;">Summary</label>
                                                                                    </th>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th rowspan="2" style="width: 3%;background-color:#FFFFFF;">#</th>
                                                                                    <th rowspan="2" style="width: 17%;background-color:#FFFFFF;">Production Output Type</th>
                                                                                    <th rowspan="2" style="width: 10%;background-color:#FFFFFF;">No. of Bag</th>
                                                                                    <th rowspan="2" style="width: 10%;background-color:#FFFFFF;">Net KG</th>
                                                                                    <th rowspan="2" style="width: 10%;background-color:#FFFFFF;">Percentage(%)  <label title="Percentage = (Net KG / Total of Production Input) * 100"><i class="fa-solid fa-circle-info"></i></label></th>
                                                                                    <th rowspan="2" style="width: 10%;background-color:#FFFFFF;">Unit Cost</th>
                                                                                    <th rowspan="2" style="width: 10%;background-color:#FFFFFF;">Total Cost  <label title="Total Cost = Net KG  * Unit Cost"><i class="fa-solid fa-circle-info"></i></label></th>
                                                                                    <th colspan="2" style="width: 15%;background-color:#FFFFFF;">Variance by KG</th>
                                                                                    <th rowspan="2" style="width: 15%;background-color:#FFFFFF;">Remark</th>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th style="width: 8%;background-color:#FFFFFF;">Shortage</th>
                                                                                    <th style="width: 7%;background-color:#FFFFFF;">Overage</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody style="text-align: center; padding:1px 1px 1px 1px;">
                                                                                <tr>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;">1</label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;">Export</label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;" class="infosummarytabledata" id="infosumexpnumofbag"></label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;" class="infosummarytabledata" id="infosumexpweightbykg"></label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;" class="infosummarytabledata" id="infosumexppercentage"></label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;" class="infosummarytabledata" id="infosumexpunitcost"></label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;" class="infosummarytabledata" id="infosumexptotalcost"></label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;" class="infosummarytabledata" id="infosummexpshortage"></label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;" class="infosummarytabledata" id="infosummexpoverage"></label>
                                                                                    </td>
                                                                                    <td rowspan="4">
                                                                                        <label style="font-size: 14px;" class="infosummarytabledata" id="infosumexpremark"></label>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;">2</label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;">Others(Export-Excess)</label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;" class="infosummarytabledata" id="infosummexpexcessbag"></label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;" class="infosummarytabledata" id="infosummexpexcesskg"></label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;" class="infosummarytabledata" id="infosumexpexcpercentage"></label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;" class="infosummarytabledata" id="infosummexpexcessunitcost"></label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;" class="infosummarytabledata" id="infosummexpexcesstotalcost"></label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;" class="infosummarytabledata" id="infosummexcshortage"></label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;" class="infosummarytabledata" id="infosummexcoverage"></label>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;">3</label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;">Others(Cancelled-Export)</label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;" class="infosummarytabledata" id="infosummcanexpbag"></label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;" class="infosummarytabledata" id="infosummcanexpkg"></label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;" class="infosummarytabledata" id="infosumexpcanpercentage"></label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;" class="infosummarytabledata" id="infosummcanexpunitcost"></label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;" class="infosummarytabledata" id="infosummcanexptotalcost"></label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;" class="infosummarytabledata" id="infosummcanshortage"></label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;" class="infosummarytabledata" id="infosummcanoverage"></label>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;">4</label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;">Others(Pre-Clean)</label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;" class="infosummarytabledata" id="infosummprecleanbag"></label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;" class="infosummarytabledata" id="infosummprecleankg"></label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;" class="infosummarytabledata" id="infosumexpprepercentage"></label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;" class="infosummarytabledata" id="infosummprecleanunitcost"></label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;" class="infosummarytabledata" id="infosummprecleantotalcost"></label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;" class="infosummarytabledata" id="infosummpreshortage"></label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;" class="infosummarytabledata" id="infosummpreoverage"></label>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;">5</label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;">Reject</label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;" class="infosummarytabledata" id="infosumrejnumofbag"></label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;" class="infosummarytabledata" id="infosumrejweightbykg"></label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;" class="infosummarytabledata" id="infosumexprejpercentage"></label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;" class="infosummarytabledata" id="infosumrejunitcost"></label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;" class="infosummarytabledata" id="infosumrejtotalcost"></label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;" class="infosummarytabledata" id="infosummrejshortage"></label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;" class="infosummarytabledata" id="infosummrejoverage"></label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;" class="infosummarytabledata" id="infosumrejremark"></label>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;">6</label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;">Wastage</label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;" class="infosummarytabledata" id="infosumwesnumofbag"></label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;" class="infosummarytabledata" id="infosumwesweightbykg"></label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;" class="infosummarytabledata" id="infosumexpwaspercentage"></label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;" class="infosummarytabledata" id="infosumwesunitcost"></label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;" class="infosummarytabledata" id="infosumwestotalcost"></label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;" class="infosummarytabledata" id="infosummwasshortage"></label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;" class="infosummarytabledata" id="infosummwasoverage"></label>
                                                                                    </td>
                                                                                    <td rowspan="2">
                                                                                        <label style="font-size: 14px;" class="infosummarytabledata" id="infosumwesremark"></label>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;">7</label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;">Stubble</label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;" class="infosummarytabledata" id="infosumstubblenumofbag"></label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;" class="infosummarytabledata" id="infosumstubbleweightbykg"></label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;" class="infosummarytabledata" id="infosumexpstbpercentage"></label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;" class="infosummarytabledata" id="infosumstubbleunitcost"></label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;" class="infosummarytabledata" id="infosumstubbletotalcost"></label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;" class="infosummarytabledata" id="infosummstubshortage"></label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 14px;" class="infosummarytabledata" id="infosummstuboverage"></label>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                            <tfoot style="text-align: center;">
                                                                                <tr>
                                                                                    <th colspan="2" style="text-align: right;background-color:#FFFFFF;">Total of Production Output</th>
                                                                                    <td>
                                                                                        <label style="font-size: 16px;font-weight:bold;" class="infosummarytabledata" id="infosumtotalnumofbag"></label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 16px;font-weight:bold;" class="infosummarytabledata" id="infosumtotalweightbykg"></label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 16px;font-weight:bold;" class="infosummarytabledata" id="infosumtotalpercentage"></label>
                                                                                    </td>
                                                                                    <td></td>
                                                                                    <td>
                                                                                        <label style="font-size: 16px;font-weight:bold;" class="infosummarytabledata" id="infosumtotalcost"></label>
                                                                                    </td>
                                                                                    <td></td>
                                                                                    <td></td>
                                                                                    <td></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th colspan="2" style="text-align: right;background-color:#FFFFFF;">Total of Production Input</th>
                                                                                    <td>
                                                                                        <label style="font-size: 16px;font-weight:bold;" class="infosummarytabledata" id="infosumtotalprdnumofbag"></label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 16px;font-weight:bold;" class="infosummarytabledata" id="infosumtotalprdweightbykg"></label>
                                                                                    </td>
                                                                                    <td></td>
                                                                                    <td></td>
                                                                                    <td></td>
                                                                                    <td></td>
                                                                                    <td></td>
                                                                                    <td></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th colspan="2" style="text-align: right;background-color:#FFFFFF;" id="infovariancelbl">Variance</th>
                                                                                    <td>
                                                                                        <label style="font-size: 16px;font-weight:bold;" class="infosummarytabledata" id="infosumtotalvarnumofbag"></label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <label style="font-size: 16px;font-weight:bold;" class="infosummarytabledata" id="infosumtotalvarweightbykg"></label>
                                                                                    </td>
                                                                                    <td></td>
                                                                                    <td></td>
                                                                                    <td></td>
                                                                                    <td></td>
                                                                                    <td></td>
                                                                                    <td></td>
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
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col-xl-12 col-lg-12">
                            <div class="row">
                                <div class="col-xl-8 col-lg-8" style="text-align: left">
                                    <input type="hidden" class="form-control" name="prdrecordIds" id="prdrecordIds" readonly="true" value="76">
                                    
                                </div>
                                <div class="col-xl-4 col-lg-8" style="text-align:right;">
                                    <button id="closebuttonprd" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!--End Production Information Modal -->

@endsection

@section('scripts')
    <script type="text/javascript">

        var daterg="";
        
        $(function () {
            cardSection = $('#page-block');
        });

        $(document).ready(function() {
            $('#fiscalyear').val($('#fiscalyear option:first').val()).trigger('change');
            $('#fiscalyear').select2({
                placeholder: "Select Fiscal Year here",
            });
            $('#exportdiv').hide();
            $('#responsive-datatable').hide();
            $('#selectallfilter').prop('checked',false); 
        });

        $('#printtable').click(function(){
            var divToPrintBody = document.getElementById("stockcosthistoryreporttable");
            var htmlToPrint = `<html>
                <head>
                    <title>Cost History Report</title>
                    <style>
                        body {
                            margin: 20px;
                            overflow: visible;
                            font-family: "Montserrat", Helvetica, Arial, serif !important;
                        }
                        table {
                            border-collapse: collapse;
                            width: 100%;
                            max-width: none;
                            table-layout: fixed;
                            word-wrap: break-word;
                        }
                        th, td {
                            border: 1px solid black;
                            padding: 8px;
                            text-align: left;
                            word-wrap: break-word;
                            height: 15px !important; /* Ensure auto height */
                        }
                        .dataTables_sizing{
                            height:auto !important; /* Ensure auto height */
                            overflow:visible !important;
                            padding-left:5px !important;
                            text-align: left !important;
                        }
                        @media print {
                            body {
                                margin: 0;
                                overflow: visible;
                            }
                            table {
                                width: 100%;
                                max-width: none;
                            }
                        }
                    </style>
                </head>
                <body>
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <table class="table table-sm" style="width:100%;border: none !important;">
                                <tr>
                                    <td colspan="6" class="headerTitles" style="text-align:center;font-size:1.7rem;border: none !important;"><b>{{$compInfo->Name}}</b></td>
                                    <td rowspan="4" style="float:right;width:150px;height:120px;border: none !important;"></td>
                                </tr>
                                <tr>
                                    <td style="width:8%;border: none !important;"><b>Tel:</b></td>
                                    <td style="width:42%;border: none !important;" colspan="2">{{$compInfo->Phone}},{{$compInfo->OfficePhone}}</td>
                                    <td style="width:10%;border: none !important;"><b>Website:</b></td>
                                    <td style="width:40%;border: none !important;" colspan="2">{{$compInfo->Website}}</td>
                                </tr>
                                <tr>
                                    <td style="border: none !important;"><b>Email:</b></td>
                                    <td style="border: none !important;" colspan="2">{{$compInfo->Email}}</td>
                                    <td style="border: none !important;"><b>Address:</b></td>
                                    <td style="border: none !important;" colspan="2">{{$compInfo->Address}}</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #000000;">
                                    <td style="border: none !important;"><b>TIN:</b></td>
                                    <td style="border: none !important;" colspan="2">{{$compInfo->TIN}}</td>
                                    <td style="border: none !important;"><b>VAT No:</b></td>
                                    <td style="border: none !important;" colspan="2">{{$compInfo->VATReg}}</td>
                                </tr>
                                <tr>
                                    <td colspan="7" style="text-align:center;vertical-align: middle;border: none !important;padding:2px;">
                                        <h3><p style="color:#00cfe8;padding-top:8px;"><b>Cost History Report</b></p></h3>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            ${divToPrintBody.outerHTML}
                        </div>
                    </div>
                </body>
                </html>`;

           
            var newWin = window.open("", "", "width=1200,height=800");
            newWin.document.open();
            newWin.document.write(htmlToPrint);
            newWin.document.close();
            newWin.print();
            newWin.close();
        });

        $("#downloatoexcel").click(function () {
            let startdate=$('#startdate').val();
            let enddate=$('#daterange').val();
            let fromdate=moment(startdate, 'MMMM DD, YYYY').format('YYYY-MM-DD');
            let todate=moment(enddate, 'MMMM DD, YYYY').format('YYYY-MM-DD');

            var table = document.getElementById("stockcosthistoryreporttable");
            var workbook = new ExcelJS.Workbook();
            var worksheet = workbook.addWorksheet("Cost_History_Report");

            let mergeCells = [];
            let maxColumnWidths = {}; // Store max column widths

            let titleRow = worksheet.addRow(["Cost History Report ("+fromdate+" to "+todate+")"]);
            titleRow.font = { bold: true, size: 16, color: { argb: "000000" } };
            titleRow.alignment = { horizontal: "center", vertical: "middle" };

            worksheet.mergeCells(1, 1, 1, 21); // 🔹 Merge across all columns

            // **🔹 Leave an empty row below the title**
            worksheet.addRow([]);

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

                    if (isHeader) {
                        row.eachCell((cell) => {
                            cell.font = { bold: true, size: 12, color: { argb: "FFFFFF" } };
                            cell.fill = { type: "pattern", pattern: "solid", fgColor: { argb: "00cfe8" } };
                            cell.alignment = { horizontal: "center", vertical: "middle" };
                        });
                    }

                    excelRowIndex++;
                });

                return excelRowIndex;
            }

            let lastRow = processTableRows($(table).find("thead"), 3, true);
            lastRow = processTableRows($(table).find("tbody"), lastRow);
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
                row.eachCell((cell) => {
                    cell.border = {
                        top: { style: "thin" },
                        left: { style: "thin" },
                        bottom: { style: "thin" },
                        right: { style: "thin" },
                    };
                    cell.alignment = { horizontal: "center", vertical: "middle" };
                });
            });

            worksheet.columns.forEach((column, i) => {
                column.width = maxColumnWidths[i + 1] || 5; // **Set a default min width of 10**
            });

            workbook.xlsx.writeBuffer().then((data) => {
                var blob = new Blob([data], {
                    type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
                });
                saveAs(blob,"Cost_History_Report_from_"+fromdate+"_to_"+todate+".xlsx");
            });
        });

        $("#downloadtopdf").click(function () {
            let startdate=$('#startdate').val();
            let enddate=$('#daterange').val();
            let fromdate=moment(startdate, 'MMMM DD, YYYY').format('YYYY-MM-DD');
            let todate=moment(enddate, 'MMMM DD, YYYY').format('YYYY-MM-DD');

            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            let headers = [];
            let bodyData = [];
            let mergeCells = [];

            // Get headers (handling colspan for headers)
            $("#stockcosthistoryreporttable thead tr").each(function () {
                let rowData = [];
                let headerMerge = []; // Store merge info for headers

                $(this).find("th").each(function (colIndex) {
                    let colspan = parseInt($(this).attr("colspan")) || 1;
                    let text = $(this).text().trim();

                    rowData.push({ content: text, colSpan: colspan }); // Use colSpan key

                    if (colspan > 1) {
                        headerMerge.push({
                            col: colIndex,
                            colspan: colspan,
                        });
                    }
                });
                headers.push(rowData);
            });


            // Get body data (handling colspan)
            $("#stockcosthistoryreporttable tbody tr").each(function (rowIndex) {
                let rowData = [];
                let colIndexOffset = 0;

                $(this).find("td").each(function (colIndex) {
                    let colspan = parseInt($(this).attr("colspan")) || 1;
                    let text = $(this).text().trim();

                    rowData.push(text);

                    if (colspan > 1) {
                        mergeCells.push({
                            row: bodyData.length, // Corrected row index
                            col: colIndex + colIndexOffset,
                            colspan: colspan,
                        });

                        for (let i = 1; i < colspan; i++) {
                            rowData.push("");
                        }

                        colIndexOffset += colspan - 1;
                    }
                });

                bodyData.push(rowData);
            });

            $("#stockcosthistoryreporttable tfoot tr").each(function (rowIndex) {
                let rowData = [];
                let colIndexOffset = 0;

                $(this).find("td").each(function (colIndex) {
                    let colspan = parseInt($(this).attr("colspan")) || 1;
                    let text = $(this).text().trim();

                    rowData.push(text);

                    if (colspan > 1) {
                        mergeCells.push({
                            row: bodyData.length, // Corrected row index
                            col: colIndex + colIndexOffset,
                            colspan: colspan,
                        });

                        for (let i = 1; i < colspan; i++) {
                            rowData.push("");
                        }

                        colIndexOffset += colspan - 1;
                    }
                });

                bodyData.push(rowData);
            });

            doc.setFontSize(12);  // Title font size
            doc.setFont("Montserrat, Helvetica, Arial, serif", "bold");
            doc.setTextColor(0, 0, 0);  
            
            const pageWidth = doc.internal.pageSize.width;
            const titleText = "Cost History Report ("+fromdate+" to "+todate+")";
            const textWidth = doc.getStringUnitWidth(titleText) * doc.internal.getFontSize() / doc.internal.scaleFactor;
            const xCoordinate = (pageWidth - textWidth) / 2;  // Centering the text

            doc.text(titleText, xCoordinate, 10);  

            doc.autoTable({
                head: headers,  // Correctly formatted headers
                body: bodyData,
                theme: "grid",
                styles: {
                    fontSize: 5,
                    cellPadding: 0.3,
                    overflow: "linebreak",
                    valign: "middle",
                    halign: "center",
                },
                headStyles: {
                    fillColor: [0, 207, 232], // Light blue (#00cfe8)
                    textColor: [255, 255, 255], // White text
                    lineWidth: 0.1, // Border thickness
                    lineColor: [0, 0, 0], // White border
                    fontStyle: "bold",
                },
                
                margin: { top: 12, left: 1, right: 1 },
                didParseCell: function (data) {
                    if (data.row.section === "body"){
                        mergeCells.forEach(function (merge) {
                            if (data.row.index === merge.row && data.column.index === merge.col) {
                                data.cell.colSpan = merge.colspan;
                                data.cell.styles.fontStyle = 'bold';
                            }
                            if(parseInt(data.cell.colSpan)==9){
                                data.cell.styles.halign = "right";
                            }
                        });

                        data.cell.styles.lineWidth = 0.1;  // Thickness of the border
                        data.cell.styles.lineColor = [0, 0, 0];  // Black border color
                    }
                },
            });

            doc.save("Cost_History_Report_from_"+fromdate+"_to_"+todate+".pdf");
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

            allCombinations.push(fiscalyear + compvalue);

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

        function getCommodityType(prdtype){
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
            const allCombinations = [];
            var seen = {};

            cusowner.forEach(a1 => {
                storeid.forEach(a2 => {
                    prdtype.forEach(a3 => { 
                        commoditytype.forEach(a4 => { 
                            allCombinations.push(fiscalyear + a1 + a2 + a3 + a4);
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
            let commoditytype=$('#commoditytype').val();
            const allCombinations = [];
            var seen = {};

            cusowner.forEach(a1 => {
                storeid.forEach(a2 => {
                    prdtype.forEach(a3 => { 
                        commoditytype.forEach(a4 => { 
                            commodity.forEach(a5 => {
                                allCombinations.push(fiscalyear + a1 + a2 + a3 + a4 + a5);
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
            let commoditytype=$('#commoditytype').val();
            let commodity=$('#commodity').val();
            const allCombinations = [];
            var seen = {};

            cusowner.forEach(a1 => {
                storeid.forEach(a2 => {
                    prdtype.forEach(a3 => { 
                        commoditytype.forEach(a4 => { 
                            commodity.forEach(a5 => {
                                grade.forEach(a6 => {
                                    allCombinations.push(fiscalyear + a1 + a2 + a3 + a4 + a5 + a6);
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
            let commoditytype=$('#commoditytype').val();
            let commodity=$('#commodity').val();
            let grade=$('#grade').val();
            const allCombinations = [];
            var seen = {};

            cusowner.forEach(a1 => {
                storeid.forEach(a2 => {
                    prdtype.forEach(a3 => { 
                        commoditytype.forEach(a4 => { 
                            commodity.forEach(a5 => {
                                grade.forEach(a6 => {
                                    processtype.forEach(a7 => {
                                        allCombinations.push(fiscalyear + a1 + a2 + a3 + a4 + a5 + a6 + a7);
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
            getCommodityType(prdtype);
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
                        //getDateRange(startdaterange,enddaterange);
                        dateRangeChange(enddaterange);
                        $('#daterange').val(moment(enddaterange,'YYYY-MM-DD').format('MMMM DD, YYYY'));

                        $("#companytype option[value=1]").remove();
                        var defaultcomptypeopt = '<option selected value=1>Owner</option>';
                        $('#companytype').append(defaultcomptypeopt); 

                        // $('#companytype').find('option').prop('selected', true);
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
                        getCommodityType(prdtype);

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

                        $('#cropyear').find('option').prop('selected', true);

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
            var registerForm = $('#stockcosthistoryreportform');
            var formData = registerForm.serialize();
            var flag=1;

            $.ajax({ 
                url: "{{url('stockCostHistoryReport')}}",
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
                    $('#responsive-datatable').hide();
                    $('#exportdiv').hide();
                },

                success: function(data) {
                    if(data.errors){
                        if (data.errors.fiscalyear) {
                            var text=data.errors.fiscalyear[0];
                            text = text.replace("fiscalyear", "fiscal year");
                            $('#fiscalyear-error').html(text);
                        }
                        if (data.errors.daterange) {
                            var text=data.errors.daterange[0];
                            text = text.replace("daterange", "end date");
                            $('#daterange-error').html(text);
                        }
                        if (data.errors.companytype) {
                            var text=data.errors.companytype[0];
                            text = text.replace("companytype", "company type");
                            $('#companytype-error').html(text);
                        }
                        if (data.errors.CustomerOrOwner) {
                            $('#customerown-error').html(data.errors.CustomerOrOwner[0]);
                        }
                        if (data.errors.store) {
                            var text=data.errors.store[0];
                            text = text.replace("store", "store/ station");
                            $('#store-error').html(text);
                        }
                        if (data.errors.producttype) {
                            var text=data.errors.producttype[0];
                            text = text.replace("producttype", "product type");
                            $('#producttype-error').html(text);
                        }
                        if (data.errors.commoditytype) {
                            var text=data.errors.commoditytype[0];
                            text = text.replace("commodity type", "commodity type");
                            $('#commoditytype-error').html(text);
                        }
                        if (data.errors.commodity) {
                            $('#commodity-error').html(data.errors.commodity[0]);
                        }
                        if (data.errors.grade) {
                            $('#grade-error').html(data.errors.grade[0]);
                        }
                        if (data.errors.processtype) {
                            var text=data.errors.processtype[0];
                            text = text.replace("processtype", "process type");
                            $('#processtype-error').html(text);
                        }
                        if (data.errors.cropyear) {
                            var text=data.errors.cropyear[0];
                            text = text.replace("cropyear", "crop year");
                            $('#cropyear-error').html(text);
                        }

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
                    if(data.success) {
                        let startdate=$('#startdate').val();
                        let enddate=$('#daterange').val();
                        let fromdate=moment(startdate, 'MMMM DD, YYYY').format('YYYY-MM-DD');
                        let todate=moment(enddate, 'MMMM DD, YYYY').format('YYYY-MM-DD');

                        var fiscalyearpost="";
                        var startdatepost="";
                        var enddatepost="";
                        var companytypepost="";
                        var customerorownerpost="";

                        var storepost="";
                        var producttypepost="";
                        var transactiontypepost="";
                        var referencepost="";

                        var commoditytypepost="";
                        var commoditypost="";
                        var gradepost="";
                        var processtypepost="";
                        var cropyearpost="";
                        var flg="";

                        var table = $("#stockcosthistoryreporttable").DataTable({ 
                            destroy: true,
                            processing: true,
                            serverSide: true,
                            paging: false,
                            searching: true,
                            info: true,
                            fixedHeader: true,
                            searchHighlight: true,
                            responsive:true,
                            deferRender: true,
                            ordering: false,
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
                                url: "{{url('stockCostHistoryDataFetch')}}",
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
                                data:{
                                    fiscalyearpost: $('#fiscalyear').val(),
                                    startdatepost: fromdate,
                                    enddatepost: todate,
                                    companytypepost: $('#companytype').val(),
                                    customerorownerpost: $('#CustomerOrOwner').val(),
                                    storepost: $('#store').val(),
                                    producttypepost: $('#producttype').val(),
                                    commoditytypepost: $('#commoditytype').val(),
                                    commoditypost: $('#commodity').val(),
                                    gradepost: $('#grade').val(),
                                    processtypepost: $('#processtype').val(),
                                    cropyearpost: $('#cropyear').val(),
                                    flg:flag,
                                },
                                dataType: "json",
                            },
                            columns: [
                                {
                                    data:'DT_RowIndex',
                                    width:"2%"
                                },
                                {
                                    data: 'StoreName',
                                    name: 'StoreName',
                                    width:"5%"
                                },
                                {
                                    data: 'FloorMap',
                                    name: 'FloorMap',
                                    width:"5%"
                                },
                                {
                                    data: 'CommodityType',
                                    name: 'CommodityType',
                                    width:"5%" //3
                                },
                                {
                                    data: 'Commodity',
                                    name: 'Commodity',
                                    width:"5%"
                                },
                                {
                                    data: 'GradeName',
                                    name: 'GradeName',
                                    width:"4%"
                                },
                                {
                                    data: 'CropYearName',
                                    name: 'CropYearName',
                                    width:"5%"
                                },
                                {
                                    data: 'ProcessType',
                                    name: 'ProcessType',
                                    width:"5%"
                                },
                                {
                                    data: 'UomName',
                                    name: 'UomName',
                                    width:"5%"
                                },
                                {
                                    data: 'NumOfBag',
                                    name: 'NumOfBag',
                                    render: $.fn.dataTable.render.number(',', '.',0, ''),
                                    width:"5%"
                                },
                                {
                                    data: 'TON',
                                    name: 'TON',
                                    render: $.fn.dataTable.render.number(',', '.',2, ''),
                                    width:"4%"
                                },
                                {
                                    data: 'Feresula',
                                    name: 'Feresula',
                                    render: $.fn.dataTable.render.number(',', '.',2, ''),
                                    width:"5%"
                                },
                                {
                                    data: 'StockIn',
                                    name: 'StockIn',
                                    render: $.fn.dataTable.render.number(',', '.',2, ''),
                                    width:"5%"
                                },
                                {
                                    data: 'UnitCost',
                                    name: 'UnitCost',
                                    render: $.fn.dataTable.render.number(',', '.',2, ''),
                                    width:"5%"
                                },
                                {
                                    data: 'TotalCost',
                                    name: 'TotalCost',
                                    render: $.fn.dataTable.render.number(',', '.',2, ''),
                                    width:"5%"
                                },
                                {
                                    data: 'RunningAverageCost',
                                    name: 'RunningAverageCost',
                                    render: $.fn.dataTable.render.number(',', '.',2, ''),
                                    width:"5%"
                                },
                                {
                                    data: 'TransactionsType',
                                    name: 'TransactionsType',
                                    width:"5%"
                                },
                                {
                                    data: 'DocumentNumber',
                                    name: 'DocumentNumber',
                                    "render": function ( data, type, row, meta ) {
                                        if(data == null || data === null || data == "" || data === ""){
                                            return '';
                                        }
                                        else{
                                            if(row.TransactionsType=="Receiving" || row.TransactionsType==="Receiving"){
                                                return '<a @can("Receiving-View")style="text-decoration:underline;color:blue;" onclick=receivingDocFn("'+row.HeaderId+'")@endcan>'+data+'</a>';
                                            }
                                            if(row.TransactionsType=="Beginning" || row.TransactionsType==="Beginning"){
                                                return '<a @can("Commodity-Beginning-View")style="text-decoration:underline;color:blue;" onclick=commInfoFn("'+row.HeaderId+'")@endcan>'+data+'</a>';
                                            }
                                            if(row.TransactionsType=="Production" || row.TransactionsType==="Production"){
                                                return '<a @can("Production-Order-View")style="text-decoration:underline;color:blue;" onclick=productionDocFn("'+row.HeaderId+'")@endcan>'+data+'</a>';
                                            }
                                        }
                                    },
                                    width:"5%"
                                },
                                {
                                    data: 'PONumber',
                                    name: 'PONumber',
                                    "render": function ( data, type, row, meta ) {
                                        if(data == null || data === null || data == "" || data === ""){
                                            return '';
                                        }
                                        else{
                                            return '<a @can("PO-View")style="text-decoration:underline;color:blue;" onclick=purchaseOrderDocFn("'+row.POrdId+'")@endcan>'+data+'</a>';
                                        }
                                    },
                                    width:"5%"
                                },
                                {
                                    data: 'PINVNumber',
                                    name: 'PINVNumber',
                                    "render": function ( data, type, row, meta ) {
                                        if(data == null || data === null || data == "" || data === ""){
                                            return '';
                                        }
                                        else{
                                            return '<a @can("PIV-View")style="text-decoration:underline;color:blue;" onclick=purchaseInvDocFn("'+row.PIVId+'")@endcan>'+data+'</a>';
                                        }
                                    },
                                    width:"5%"
                                },
                                {
                                    data: 'Date',
                                    name: 'Date',
                                    width:"5%"
                                },
                                {
                                    data: 'CustomerOwner',
                                    name: 'CustomerOwner',
                                    'visible': false //21
                                },
                                {
                                    data: 'CommodityProperty',
                                    name: 'CommodityProperty',
                                    'visible': false //22
                                },
                                {
                                    data: 'customers_id',
                                    name: 'customers_id',
                                    'visible': false //23
                                },
                            ],
                            "order": [[21, "asc"],[22, "asc"]],
                            columnDefs: [  
                                {
                                    "width": "100%",
                                    targets: "_all",
                                    createdCell: function (td, cellData, rowData, row, col){
                                        $(td).css('border', '0.1px solid black');
                                        $(td).css('color', 'black');
                                    } 
                                }
                            ],
                            fixedHeader: {
                                header: true,
                                headerOffset: $('.header-navbar').outerHeight(),
                                footer: true
                            },
                            scrollY: false, 
                            scrollCollapse: false, 
                            paging: false,
                            rowGroup: {
                                startRender: function ( rows, group,level ) {
                                    if(level===0){
                                        var cusorowner="";
                                        if(group==="Owner"){
                                            cusorowner="";
                                        }
                                        else{
                                            cusorowner="Customer: ";
                                        }
                                        return $('<tr style="font-weight:bold;font-size:13px;color:#000000;background:#ccc;"><td colspan="21" style="text-align:left;border:0.1px solid black;"><b>'+cusorowner+group+'</b></td></tr>');
                                    } 
                                    if(level===1){
                                        return $('<tr style="font-weight:bold;font-size:13px;color:#000000;background:#f2f3f4;"><td colspan="21" style="text-align:center;border:0.1px solid black;"><b>'+group+'</b></td></tr>');
                                    } 
                                },
                                endRender: function ( rows, group,level ) {
                                    var intVal = function ( i ) {
                                        return typeof i === 'string' ?
                                            i.replace(/[\$,]/g, '')*1 :
                                            typeof i === 'number' ?
                                                    i : 0;
                                    };

                                    var numofbag = rows
                                    .data()
                                    .pluck('NumOfBag')
                                    .reduce(function (a, b) {
                                        return intVal(a) + intVal(b);
                                    }, 0);

                                    var ton = rows
                                    .data()
                                    .pluck('TON')
                                    .reduce(function (a, b) {
                                        return intVal(a) + intVal(b);
                                    }, 0);

                                    var feresula = rows
                                    .data()
                                    .pluck('Feresula')
                                    .reduce(function (a, b) {
                                        return intVal(a) + intVal(b);
                                    }, 0);

                                    var stockin = rows
                                    .data()
                                    .pluck('StockIn')
                                    .reduce(function (a, b) {
                                        return intVal(a) + intVal(b);
                                    }, 0);

                                    var totalcost = rows
                                    .data()
                                    .pluck('TotalCost')
                                    .reduce(function (a, b) {
                                        return intVal(a) + intVal(b);
                                    }, 0);

                                    if(level===0){
                                        var cusorowner="";
                                        if(group==="Owner"){
                                            cusorowner="Total of: "+group;
                                        }
                                        else{
                                            cusorowner="Total of: "+group+" Customer";
                                        }
                                        return $('<tr style="color:#000000;background:#ccc;">')
                                            .append('<td colspan="9" style="text-align:right;border:0.1px solid;"><b>'+cusorowner + '</b></td>') 
                                            .append('<td style="text-align:left;border:0.1px solid;"><b>'+ numformat(parseFloat(numofbag).toFixed(0))+'</b></td>')
                                            .append('<td style="text-align:left;border:0.1px solid;"><b>'+ numformat(parseFloat(ton).toFixed(2))+'</b></td>')
                                            .append('<td style="text-align:left;border:0.1px solid;"><b>'+ numformat(parseFloat(feresula).toFixed(2))+'</b></td>')
                                            .append('<td style="text-align:left;border:0.1px solid;"><b>'+ numformat(parseFloat(stockin).toFixed(2))+'</b></td>')
                                            .append('<td style="text-align:left;border:0.1px solid;"></td>')
                                            .append('<td style="text-align:left;border:0.1px solid;"><b>'+ numformat(parseFloat(totalcost).toFixed(2))+'</b></td>')
                                            .append('<td style="text-align:left;border:0.1px solid;"></td>')
                                            .append('<td style="text-align:left;border:0.1px solid;"></td>')
                                            .append('<td style="text-align:left;border:0.1px solid;"></td>')
                                            .append('<td style="text-align:left;border:0.1px solid;"></td>')
                                            .append('<td style="text-align:left;border:0.1px solid;"></td>')
                                            .append('<td style="text-align:left;border:0.1px solid;"></td>')
                                            .append('</tr>'); 
                                    }
                                    if(level===1){
                                        return $('<tr style="color:#000000;background:#f2f3f4">')
                                            .append('<td colspan="9" style="text-align:right;border:0.1px solid;"><b>Total</b></td>') 
                                            .append('<td style="text-align:left;border:0.1px solid;"><b>'+ numformat(parseFloat(numofbag).toFixed(0))+'</b></td>')
                                            .append('<td style="text-align:left;border:0.1px solid;"><b>'+ numformat(parseFloat(ton).toFixed(2))+'</b></td>')
                                            .append('<td style="text-align:left;border:0.1px solid;"><b>'+ numformat(parseFloat(feresula).toFixed(2))+'</b></td>')
                                            .append('<td style="text-align:left;border:0.1px solid;"><b>'+ numformat(parseFloat(stockin).toFixed(2))+'</b></td>')
                                            .append('<td style="text-align:left;border:0.1px solid;"></td>')
                                            .append('<td style="text-align:left;border:0.1px solid;"><b>'+ numformat(parseFloat(totalcost).toFixed(2))+'</b></td>')
                                            .append('<td style="text-align:left;border:0.1px solid;"></td>')
                                            .append('<td style="text-align:left;border:0.1px solid;"></td>')
                                            .append('<td style="text-align:left;border:0.1px solid;"></td>')
                                            .append('<td style="text-align:left;border:0.1px solid;"></td>')
                                            .append('<td style="text-align:left;border:0.1px solid;"></td>')
                                            .append('<td style="text-align:left;border:0.1px solid;"></td>')
                                            .append('</tr>'); 
                                    }
                                },
                                dataSrc: ['CustomerOwner','CommodityProperty']
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

                                var totalnumofbag = api
                                .column(9, { filter: 'applied' })
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );

                                var totalton = api
                                .column(10, { filter: 'applied' })
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );

                                var totalferesula = api
                                .column(11, { filter: 'applied' })
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );

                                var totalstockin = api
                                .column(12, { filter: 'applied' })
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );

                                var totalvaluefooter = api
                                .column(14, { filter: 'applied' })
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );


                                $('#reptotalnumberofbag').html(totalnumofbag === 0 ? '' : numformat(parseFloat(totalnumofbag).toFixed(0)));
                                $('#reptotalton').html(totalton === 0 ? '' : numformat(parseFloat(totalton).toFixed(2)));
                                $('#reptotalferesula').html(totalferesula === 0 ? '' : numformat(parseFloat(totalferesula).toFixed(2)));
                                $('#reptotalnetkg').html(totalstockin === 0 ? '' : numformat(parseFloat(totalstockin).toFixed(2)));
                                $('#reptotalcost').html(totalvaluefooter === 0 ? '' : numformat(parseFloat(totalvaluefooter).toFixed(2)));
                            
                                $(api.column(9).footer()).html(totalnumofbag.toLocaleString());
                                $(api.column(10).footer()).html(totalton.toLocaleString());
                                $(api.column(11).footer()).html(totalferesula.toLocaleString());
                                $(api.column(12).footer()).html(totalstockin.toLocaleString());
                                $(api.column(14).footer()).html(totalvaluefooter.toLocaleString());
                            },
                            drawCallback: function(settings) {
                                var api = this.api();
                                var currentIndex = 1;
                                var currentGroup = null;
                                api.rows({ page: 'current', search: 'applied' }).every(function() {
                                    var rowData = this.data();
                                    if (rowData) {
                                        var group = rowData['CustomerOwner','CommodityProperty']; // Assuming 'group_column' is the name of the column used for grouping
                                        if (group !== currentGroup) {
                                            currentIndex = 1; // Reset index for a new group
                                            currentGroup = group;
                                        }
                                        $(this.node()).find('td:first').text(currentIndex++);
                                    }
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
                                $('#responsive-datatable').show();
                                $('#exportdiv').show();
                            },
                        });
                    }
                }
            });
        });

        //Start Beginning Info
        function commInfoFn(recordId) { 
            $("#begInfoId").val(recordId);
            $("#begcustomerinfotbl").hide();
            var lidata="";
            $.ajax({
                url: '/showCommBeg'+'/'+recordId,
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
                    $.each(data.commbegdata, function(key, value) {
                        $("#infobeginningdocnum").html(value.DocumentNumber);
                        $("#infoendingdocnum").html(value.EndingDocumentNumber);
                        $("#infostorename").html(value.StoreName);
                        $("#infocustomercode").html(value.CustomerCode);
                        $("#infocustomername").html(value.CustomerName);
                        $("#infocustomertin").html(value.TinNumber);
                        $("#infocustomerphone").html(value.PhoneNumber+"   ,   "+value.OfficePhone);
                        $("#infocustomeremail").html(value.EmailAddress);
                        $("#infofiscalyear").html(value.Monthrange);
                        $("#inforemark").html(value.Remark);
                        //$(".totalvaluedata").html(numformat(value.TotalPrice.toFixed(2)));
                        $('.totalvaluedata').html(value.TotalPrice === 0 ? '' : numformat(value.TotalPrice.toFixed(2)));

                        //$(".totalvaluedataheader").html("Total Value : "+numformat(value.TotalPrice.toFixed(2)));
                        
                        if(parseInt(value.customers_id)==1){
                            $("#begcustomerinfotbl").hide();
                        }
                        else if(parseInt(value.customers_id)>1){
                            $("#begcustomerinfotbl").show();
                        }

                        if (value.Status == "Ready") 
                        {
                            $("#beginningstatusdisplay").html("<span style='color:#f6c23e;font-weight:bold;font-size:16px;'>"+value.DocumentNumber+" ,  "+value.Status+"</span>");
                        }
                        else if (value.Status == "Counting") 
                        {
                            $("#beginningstatusdisplay").html("<span style='color:#4e73df;font-weight:bold;font-size:16px;'>"+value.DocumentNumber+" ,  "+value.Status+"</span>");
                        }
                        else if (value.Status == "Posted") 
                        {
                            $("#beginningstatusdisplay").html("<span style='color:#1cc88a;font-weight:bold;font-size:16px;'>"+value.DocumentNumber+" ,  "+value.Status+"</span>");
                        }
                        else if (value.Status == "Finish-Counting") 
                        {
                            $("#beginningstatusdisplay").html("<span style='color:#858796;font-weight:bold;font-size:16px;'>"+value.DocumentNumber+" ,  "+value.Status+"</span>");
                        }
                        else if (value.Status == "Verified") 
                        {
                            $("#beginningstatusdisplay").html("<span style='color:#5bc0de;font-weight:bold;font-size:16px;'>"+value.DocumentNumber+" ,  "+value.Status+"</span>");
                        }
                        else if (value.Status == "Rejected") 
                        {
                            $("#beginningstatusdisplay").html("<span style='color:#e74a3b;font-weight:bold;font-size:16px;'>"+value.DocumentNumber+" ,  "+value.Status+"</span>");
                        }
                    });

                    $.each(data.activitydata, function(key, value) {
                        var classes="";
                        var reasonbody="";
                        if(value.action == "Edited / Counting" || value.action == "Created / Counting"){
                            classes="warning";
                        }
                        else if(value.action == "Finish-Counting" || value.action == "Verified" || value.action == "Change to Counting"){
                            classes="primary";
                        }
                        else if(value.action == "Posted"){
                            classes="success";
                        }

                        if(value.reason!=null && value.reason!=""){
                            reasonbody='</br><span class="text-muted"><i class="fa-solid fa-file"></i> '+value.reason+'</span>';
                        }
                        else{
                            reasonbody="";
                        }
                        lidata+='<li class="timeline-item"><span class="timeline-point timeline-point-'+classes+' timeline-point-indicator"></span><div class="timeline-header mb-sm-0 mb-0"><h6 class="mb-0">'+value.action+'</h6><span class="text-muted"><i class="fa-regular fa-user"></i> '+value.FullName+'</span>'+reasonbody+'</br><span class="text-muted"><i class="fa-regular fa-clock"></i> '+value.time+'</span></div></li>';
                    });
                    $("#begactiondiv").empty();
                    $('#begactiondiv').append(lidata);
                }
            });

            $('#begorigindetailtable').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                paging: false,
                searching: true,
                info: false,
                searchHighlight: true,
                "order": [
                    [2, "asc"]
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
                    url: '/showOriginData/' + recordId,
                    type: 'DELETE',
                },
                columns: [
                    {
                        data:'DT_RowIndex',
                        width:"2%"
                    },
                    {
                        data: 'LocationName',
                        name: 'LocationName',
                        width:"4%"
                    },
                    {
                        data: 'ArrivalDate',
                        name: 'ArrivalDate',
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
                        width:"4%"
                    },
                    {
                        data: 'ProductionNumber',
                        name: 'ProductionNumber',
                        width:"5%"
                    },
                    {
                        data: 'CertNumber',
                        name: 'CertNumber',
                        width:"4%"
                    },
                    {
                        data: 'Origin',
                        name: 'Origin',
                        width:"5%"
                    },
                    {
                        data: 'GradeName',
                        name: 'GradeName',
                        width:"4%"
                    },
                    {
                        data: 'ProcessType',
                        name: 'ProcessType',
                        width:"5%"
                    },
                    {
                        data: 'CropYearData',
                        name: 'CropYearData',
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
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"5%"
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
                        data: 'Balance',
                        name: 'Balance',
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
                        data: 'UnitPrice',
                        name: 'UnitPrice',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"4%"
                    },
                    {
                        data: 'TotalPrice',
                        name: 'TotalPrice',
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
                        data: 'Remark',
                        name: 'Remark',
                        width:"5%"
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
                    
                    $('#begtotalbag').html(totalbagvar === 0 ? '' : numformat(parseFloat(totalbagvar).toFixed(2)));
                    $('#begtotalbagweight').html(totalbagweight === 0 ? '' : numformat(parseFloat(totalbagweight).toFixed(2)));
                    $('#begtotalgrosskg').html(totalgrosskg === 0 ? '' : numformat(parseFloat(totalgrosskg).toFixed(2)));
                    $('#begtotalkg').html(totalkgvar === 0 ? '' : numformat(parseFloat(totalkgvar).toFixed(2)));
                    $('#begtotalton').html(totaltonvar === 0 ? '' : numformat(parseFloat(totaltonvar).toFixed(2)));
                    $('#begtotalferesula').html(totalferesulavar === 0 ? '' : numformat(parseFloat(totalferesulavar).toFixed(2)));
                    $('#begtotalvarshortage').html(totalvarianceshr === 0 ? '' : numformat(parseFloat(totalvarianceshr).toFixed(2)));
                    $('#begtotalvarovrage').html(totalvarianceov === 0 ? '' : numformat(parseFloat(totalvarianceov).toFixed(2)));
                },
            });

            $(".infocommbeg").collapse('show');
            $("#beginningmodal").modal('show');
        }
        //End Beginning Info

        //Start Beginning Print Attachment
        $('#beginningprintbtn').on('click', function() {
            var id = $('#begInfoId').val();
            var link = "/commbegnote/"+id;
            window.open(link, 'Commodity Beginning Note', 'width=1200,height=800,scrollbars=yes');
        });
        //End Beginning Print Attachment

        //Start show receiving doc info      
        function receivingDocFn(recordId){
            $('#receivinginfomodaltitle').html("Receiving Information");
            $("#statusid").val(recordId);
            $('#recrecordIds').val(recordId);
            $('.datatableinfocls').hide();
            $('.recpropbtn').hide();
            var visibilitymode=false;
            var lidata="";
            
            $.ajax({
                url: '/showRecDataRec'+'/'+recordId,
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
                    $.each(data.holdHeader, function(key, value) {
                        $('#infoDocType').text(value.Type);
                        $('#infoDocDocNo').text(value.DocumentNumber);
                        $('#referenceLbl').text(value.RecType);
                        $('#purchaseOrdLbl').text(value.porderno);
                        $('#commoditySrcLbl').text(value.CommoditySource);
                        $('#commodityTypeLbl').text(value.CommodityType);
                        $('#productTypeLbl').text(value.ProductType);
                        $('#companyTypeLbl').text(value.CompanyTypeLbl);
                        $('#infoDocCustomerName').text(value.CustomerName);
                        $('#customerOrOwnerLbl').text(value.CustomerOrOwner);
                        
                        $('#deliveryOrderLbl').text(value.DeliveryOrderNo);
                        $('#dispatchStationLbl').text(value.DispatchStation);
                        $('#infoDocReceivingStore').text(value.StoreName);
                        $('#receivedByLbl').text(value.ReceivedBy);
                        $('#driverNameLbl').text(value.DriverName);
                        $('#plateNumberLbl').text(value.TruckPlateNo);
                        $('#driverPhoneLbl').text(value.DriverPhoneNo);
                        $('#deliveredByLbl').text(value.DeliveredBy);
                        $('#receivedDateLbl').text(value.ReceivedDate);
                        $('#infodocumentuploadlinkbtn').text(value.FileName);
                        $('#infogrvfilename').val(value.FileName);
                        $('#remarkLbl').text(value.Memo);

                        $("#statusIds").val(value.Status);
                        var statusvals=value.Status;
                        var statusvalsold=value.StatusOld;
                        if(parseInt(value.CompanyType)==1){
                            $("#customerOwnerRec").hide();
                        }
                        else if(parseInt(value.CompanyType)==2){
                            $("#customerOwnerRec").show();
                        }

                        if(value.ProductType=="Commodity"){
                            $("#commoditySrcRow").show();
                            $("#commodityTypeRow").show();
                            $("#infoCommDatatable").show();
                        }
                        else if(value.ProductType=="Goods"){
                            $("#commoditySrcRow").hide();
                            $("#commodityTypeRow").hide();
                            $("#infoGoodsDatatable").show();
                        }

                        if(parseInt(value.InvoiceStatus)==0){
                            $("#invoiceStatusLbl").html("Waiting");
                        }
                        else if(parseInt(value.InvoiceStatus)==1){
                            $("#invoiceStatusLbl").html("Partially-Received");
                        }
                        else if(parseInt(value.InvoiceStatus)==2){
                            $("#invoiceStatusLbl").html("Fully-Received");
                        }

                        if(parseInt(value.ReturnStatus)==0){
                            $("#returnStatusLbl").html("Not-Returned");
                        }
                        else if(parseInt(value.ReturnStatus)==1){
                            $("#returnStatusLbl").html("Partially-Returned");
                        }
                        else if(parseInt(value.ReturnStatus)==2){
                            $("#returnStatusLbl").html("Fully-Returned");
                        }

                        if(statusvals==="Draft"){
                            $("#changetopending").show();
                            $("#statustitles").html("<span style='color:#A8AAAE;font-weight:bold;text-shadow;1px 1px 10px #A8AAAE;font-size:16px;'>"+value.DocumentNumber+"     |     "+statusvals+"</span>");
                        }
                        else if(statusvals==="Pending"){
                            $("#backtodraft").show();
                            $("#checkreceiving").show();
                            $("#statustitles").html("<span style='color:#f6c23e;font-weight:bold;text-shadow;1px 1px 10px #f6c23e;font-size:16px;'>"+value.DocumentNumber+"     |     "+statusvals+"</span>");
                        }
                        else if(statusvals==="Verified"){
                            $("#confirmreceiving").show();
                            $("#backtopending").show();
                            $("#statustitles").html("<span style='color:#7367F0;font-weight:bold;text-shadow;1px 1px 10px #7367F0;font-size:16px;'>"+value.DocumentNumber+"     |     "+statusvals+"</span>");
                        }
                        else if(statusvals==="Confirmed" || statusvals==="Partially-Received" || statusvals==="Fully-Received"){
                            $("#changetopending").hide();
                            $("#checkadjustment").hide();
                            $("#confirmadjustment").hide();
                            $("#statustitles").html("<span style='color:#1cc88a;font-weight:bold;text-shadow;1px 1px 10px #1cc88a;font-size:16px;'>"+value.DocumentNumber+"     |     "+statusvals+"</span>");
                        }
                        else{
                            $("#changetopending").hide();
                            $("#checkadjustment").hide();
                            $("#confirmadjustment").hide();
                            $("#statustitles").html("<span style='color:#e74a3b;font-weight:bold;text-shadow;1px 1px 10px #e74a3b;font-size:16px;'>"+value.DocumentNumber+"     |     "+statusvals+"("+statusvalsold+")</span>");
                        }

                    });

                    $.each(data.activitydata, function(key, value) {
                        var classes="";
                        var reasonbody="";
                        if(value.action == "Edited" || value.action == "Change to Pending" || value.action == "Back to Pending"){
                            classes="warning";
                        }
                        else if(value.action == "Verified" || value.action == "Change to Counting"){
                            classes="primary";
                        }
                        else if(value.action == "Created" || value.action == "Back to Draft" || value.action == "Undo Void"){
                            classes="secondary";
                        }
                        else if(value.action == "Confirmed" || value.action == "Received"){
                            classes="success";
                        }
                        else if(value.action == "Void"){
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

            $('#checkbyth').show();
            $('#checkdateth').show();
            $('#confirmbyth').show();
            $('#confirmdateth').show();
            $('#changetopendingth').show();
            $('#changetopendingdateth').show();
            $('#statusth').show();
            $('#infocheckbytd').show();
            $('#infocheckeddatetd').show();
            $('#infoconfirmbytd').show();
            $('#infoconfirmeddatetd').show();
            $('#infoconchangetopendingtd').show();
            $('#infochangetopendingdatetd').show();
            $('#infostatustd').show();

            $('#docRecInfoItem').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                paging: false,
                searching: true,
                info: false,
                searchHighlight: true,
                "order": [
                    [0, "asc"]
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
                    url: '/showrecDetail/' + recordId,
                    type: 'DELETE',
                },
                columns: [{
                        data: 'id',
                        name: 'id',
                        'visible': false
                    },
                    {
                        data:'DT_RowIndex'
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
                            if(row.RequireSerialNumber=="Not-Require" && row.RequireExpireDate=="Not-Require"){
                                return '<div>'+data+'</div>'
                            }
                            else{
                                return '<div><u>'+data+'</u><br/><table><tr><td>Batch#</td><td>Serial#</td><td>ExpiredDate</td><td>ManfacDate</td></tr><tr><td>'+row.BatchNumber+'</td><td>'+row.SerialNumber+'</td><td>'+row.ExpireDate+'</td><td>'+row.ManufactureDate+'</td></tr></table></div>'
                            }
                        } 
                    },
                    {
                        data: 'SKUNumber',
                        name: 'SKUNumber',
                        width:'17%',
                    },
                    {
                        data: 'UOM',
                        name: 'UOM',
                        width:'5%',
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
                        width:'10%',
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
                    { data: 'BatchNumber', name: 'BatchNumber','visible': false },
                    { data: 'SerialNumber', name: 'SerialNumber','visible': false },
                    { data: 'ExpireDate', name: 'ExpireDate','visible': false },
                    { data: 'ManufactureDate', name: 'ManufactureDate','visible': false },
                    { data: 'RequireSerialNumber', name: 'RequireSerialNumber','visible': false },  
                    { data: 'RequireExpireDate', name: 'RequireExpireDate','visible': false },           
                ],
                "columnDefs": [
                    {
                        "targets": [8,9],
                        "visible": visibilitymode,
                    },
                ]
            });

            $('#origindetailtable').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                paging: false,
                searching: true,
                info: false,
                searchHighlight: true,
                "order": [
                    [2, "asc"]
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
                    url: '/showRecCommodity/' + recordId,
                    type: 'DELETE',
                },
                columns: [
                    {
                        data:'DT_RowIndex',
                        width:"2%"
                    },
                    {
                        data: 'LocationName',
                        name: 'LocationName',
                        width:"6%"
                    },
                    {
                        data: 'CommType',
                        name: 'CommType',
                        width:"6%"
                    },
                    {
                        data: 'Origin',
                        name: 'Origin',
                        width:"8%"
                    },
                    {
                        data: 'GradeName',
                        name: 'GradeName',
                        width:"6%"
                    },
                    {
                        data: 'ProcessType',
                        name: 'ProcessType',
                        width:"6%"
                    },
                    {
                        data: 'CropYearData',
                        name: 'CropYearData',
                        width:"6%"
                    },
                    {
                        data: 'UomName',
                        name: 'UomName',
                        width:"6%"
                    },
                    {
                        data: 'NumOfBag',
                        name: 'NumOfBag',
                        render: $.fn.dataTable.render.number(',', '.',0, ''),
                        width:"6%"
                    },
                    {
                        data: 'BagWeight',
                        name: 'BagWeight',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"6%"
                    },
                    {
                        data: 'TotalKg',
                        name: 'TotalKg',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"6%"
                    },
                    {
                        data: 'NetKg',
                        name: 'NetKg',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"6%"
                    },
                    {
                        data: 'Feresula',
                        name: 'Feresula',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"6%"
                    },
                    {
                        data: 'WeightByTon',
                        name: 'WeightByTon',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"6%"
                    },
                    {
                        data: 'VarianceShortage',
                        name: 'VarianceShortage',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"6%"
                    },
                    {
                        data: 'VarianceOverage',
                        name: 'VarianceOverage',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"6%"
                    },
                    {
                        data: 'Remark',
                        name: 'Remark',
                        width:"6%"
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
                    .column(8)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totalbagweight = api
                    .column(9)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totalgrosskg = api
                    .column(10)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totalkgvar = api
                    .column(11)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totalferesulavar = api
                    .column(12)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totaltonvar = api
                    .column(13)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totalvarianceshr = api
                    .column(14)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totalvarianceov = api
                    .column(15)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
                    
                    $('#totalbag').html(totalbagvar === 0 ? '' : numformat(totalbagvar));
                    $('#totalbagweight').html(totalbagweight === 0 ? '' : numformat(totalbagweight.toFixed(2)));
                    $('#totalgrosskg').html(totalgrosskg === 0 ? '' : numformat(totalgrosskg.toFixed(2)));
                    $('#totalkg').html(totalkgvar === 0 ? '' : numformat(totalkgvar.toFixed(2)));
                    $('#totalton').html(totaltonvar === 0 ? '' : numformat(totaltonvar.toFixed(2)));
                    $('#totalferesula').html(totalferesulavar === 0 ? '' : numformat(totalferesulavar.toFixed(2)));
                    $('#totalvarshortage').html(totalvarianceshr === 0 ? '' : numformat(totalvarianceshr.toFixed(2)));
                    $('#totalvarovrage').html(totalvarianceov === 0 ? '' : numformat(totalvarianceov.toFixed(2)));
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
                    url: '/showReturnedCommodity/' + recordId,
                    type: 'DELETE',
                },
                columns: [
                    {
                        data:'DT_RowIndex',
                        width:"2%"
                    },
                    {
                        data: 'DocumentNumber',
                        name: 'DocumentNumber',
                        width:"8%"
                    },
                    {
                        data: 'CommType',
                        name: 'CommType',
                        width:"5%"
                    },
                    {
                        data: 'Origin',
                        name: 'Origin',
                        width:"8%"
                    },
                    {
                        data: 'GradeName',
                        name: 'GradeName',
                        width:"5%"
                    },
                    {
                        data: 'ProcessType',
                        name: 'ProcessType',
                        width:"5%"
                    },
                    {
                        data: 'CropYear',
                        name: 'CropYear',
                        width:"5%"
                    },
                    {
                        data: 'UomName',
                        name: 'UomName',
                        width:"5%"
                    },
                    {
                        data: 'NumOfBag',
                        name: 'NumOfBag',
                        render: $.fn.dataTable.render.number(',', '.',0, ''),
                        width:"5%"
                    },
                    {
                        data: 'BagWeight',
                        name: 'BagWeight',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"5%"
                    },
                    {
                        data: 'TotalKg',
                        name: 'TotalKg',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"5%"
                    },
                    {
                        data: 'NetKg',
                        name: 'NetKg',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"5%"
                    },
                    {
                        data: 'WeightByTon',
                        name: 'WeightByTon',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"5%"
                    },
                    {
                        data: 'Feresula',
                        name: 'Feresula',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"5%"
                    },
                    {
                        data: 'VarianceShortage',
                        name: 'VarianceShortage',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"6%"
                    },
                    {
                        data: 'VarianceOverage',
                        name: 'VarianceOverage',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"6%"
                    },
                    {
                        data: 'Memo',
                        name: 'Memo',
                        width:"10%"
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
                    .column(8)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totalbagweight = api
                    .column(9)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totalgrosskg = api
                    .column(10)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totalkgvar = api
                    .column(11)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totaltonvar = api
                    .column(12)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );


                    var totalferesulavar = api
                    .column(13)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totalvarianceshr = api
                    .column(14)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totalvarianceov = api
                    .column(15)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
                    
                    $('#totalbagRet').html(totalbagvar === 0 ? '' : numformat(totalbagvar));
                    $('#totalbagweightRet').html(totalbagweight === 0 ? '' : numformat(parseFloat(totalbagweight).toFixed(2)));
                    $('#totalgrosskgRet').html(totalgrosskg === 0 ? '' : numformat(parseFloat(totalgrosskg).toFixed(2)));
                    $('#totalkgRet').html(totalkgvar === 0 ? '' : numformat(parseFloat(totalkgvar).toFixed(2)));
                    $('#totaltonRet').html(totaltonvar === 0 ? '' : numformat(parseFloat(totaltonvar).toFixed(2)));
                    $('#totalferesulaRet').html(totalferesulavar === 0 ? '' : numformat(parseFloat(totalferesulavar).toFixed(2)));
                    $('#totalvarshortageRet').html(totalvarianceshr === 0 ? '' : numformat(parseFloat(totalvarianceshr).toFixed(2)));
                    $('#totalvarovrageRet').html(totalvarianceov === 0 ? '' : numformat(parseFloat(totalvarianceov).toFixed(2)));
                },
            });

            $(".propdtable").removeClass("active");
            $(".propdtableBody").removeClass("active");
            $("#purchasedtab").addClass("active");
            $("#purchasedtabBody").addClass("active");
            $(".infoscl").collapse('show');
            $("#docInfoModal").modal('show');
            $("#docRecInfoItem").show();
            $("#infoRecDiv").show();
            $("#docInfoItem").hide();
            $("#infoHoldDiv").hide();
        }
        //End show receiving doc info

        //Start Receiving Print Attachment
        $('#recprintbutton').on('click', function() {
            var id = $('#recrecordIds').val();
            var link = "/grvComm/"+id;
            window.open(link, 'GRV', 'width=1200,height=800,scrollbars=yes');
        });
        //End Receiving Print Attachment

        function purchaseOrderDocFn(recordId) {
            var status = '';
            var type = '';
            var poid = '';
            var pono = '';
            var peno = '';
            var peid = '';
            
            $('#porecordIds').val(recordId);
            
            $.ajax({
                type: "GET",
                url: "{{ url('poinfo') }}/" + recordId,
                beforeSend: function () {
                    cardSection.block({
                        message:
                            '<div class="d-flex justify-content-center align-items-center">' +
                            '<p class="mr-50 mb-50">Loading Please Wait...</p>' +
                            '<div class="spinner-grow spinner-grow-sm text-white" role="status"></div>' +
                            '</div>',
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
                        message: '',
                        timeout: 1,
                        css: {
                            backgroundColor: '',
                            color: '',
                            border: ''
                        }
                    });
                    
                    $("#collapseOne").collapse('show');
                    $('#modals-slide-in').modal('show');
                },
                success: function (response) {
                    peno = response.pedocno;
                    
                    $('#infodocumentdate').html(response.createdAtInAddisAbaba);
                    
                    $.each(response.po, function (index, value) {
                        $('#inforefernce').html(value.type);
                        $('#infopo').html(value.porderno);
                        $('#inforderdate').html(value.orderdate);
                        $('#infodeliverdate').html(value.deliverydate);
                        $('#infopaymenterm').html(value.paymenterm);
                        $('#directinfosubtotalLbl').html(numformat(value.subtotal.toFixed(2)));
                        $('#directinfotaxLbl').html(numformat(value.tax));
                        $('#directinfograndtotalLbl').html(numformat(value.grandtotal));
                        $('#directinfowitholdingAmntLbl').html(numformat(value.withold));
                        $('#directinfovatAmntLbl').html(value.withold);
                        $('#directinfonetpayLbl').html(numformat(value.netpay));
                        $('#infocommoditype').html(value.commudtytype);
                        $('#infocommoditysource').html(value.commudtysource);
                        $('#infocommoditystatus').html(value.commudtystatus);
                        
                        status = value.status;
                        type = value.type;
                        poid = value.id;
                        pono = value.porderno;
                        peid = value.purchasevaulation_id;
                        
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
                        
                        if (parseFloat(value.subtotal) >= 10000) {
                            $('#visibleinfowitholdingTr').show();
                            $('#directinfonetpayTr').show();
                        } else {
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
                                    var peviewpermit = $('#purchasevualationviewpermission').val();
                                    var links = '';
                                    $('.infopetr').show();
                                    switch (peviewpermit) {
                                        case '1':
                                            links = '<a href="#" onclick="viewpeinformation(' + peid + ');"><u>' + peno + '</u></a>';
                                            break;
                                        default:
                                            links = peno;
                                            break;
                                    }
                                    $('#infope').html(links);
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
                            directcommoditylist(poid);
                            $('.directdivider').html('Commodity List');
                            $('#infowarehouse').html(response.storename);
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
                            
                            switch (response.type) {
                                case "Goods":
                                    break;
                                default:
                                    $('#itemsdatabledivinfo').hide();
                                    $('#commuditylistdatabledivinfo').show();
                                    var tables = 'comuditydocInfoItem';
                                    directcommoditylist(poid);
                                    break;
                            }
                            
                            $('#directcommuditylistdatabledivinfo').hide();
                            break;
                    }
                    
                    showbuttondependonstat(pono, status, type);
                    setminilog(response.actions);
                }
            });
        }

        function showbuttondependonstat(pe, status, type) {
            switch (status) {
                case 0:
                    $('#infoStatus').html('<span class="text-secondary font-weight-medium"><b> ' + pe + ' Draft</b>');
                    break;
                case 1:
                    $('#infoStatus').html('<span class="text-warning font-weight-medium"><b> ' + pe + ' Pending</b>');
                    break;
                case 2:
                    $('#infoStatus').html('<span class="text-primary font-weight-medium"><b> ' + pe + ' Verified</b>');
                    break;
                case 7:
                    $('#infoStatus').html('<span class="text-primary font-weight-medium"><b> ' + pe + ' Reviewed</b>');
                    break;
                case 3:
                    $('#infoStatus').html('<span class="text-success font-weight-medium"><b> ' + pe + ' Approved</b>');
                    break;
                case 4:
                    $('#infoStatus').html('<span class="text-void font-weight-medium"><b> ' + pe + ' Void</b>');
                    break;
                case 5:
                    $('#infoStatus').html('<span class="text-danger font-weight-medium"><b> ' + pe + ' Rejected</b>');
                    break;
                case 6:
                    $('#infoStatus').html('<span class="text-warning font-weight-medium"><b> ' + pe + ' Review</b>');
                    break;
                default:
                    break;
            }
        }

        function setminilog(actions) {
            var list = '';
            var icons = '';
            var reason = '';
            var addedclass = '';

            $('#ulist').empty();

            $.each(actions, function (index, value) {
                switch (value.status) {
                    case 'Pending':
                        icons = 'warning timeline-point';
                        addedclass = 'text-warning';
                        switch (value.action) {
                            case 'Back To pending':
                                reason = '<p class="text-muted"><b><u>Reason:</u></b>' + value.reason + '.</p>';
                                break;
                            default:
                                reason = '';
                                break;
                        }
                        break;

                    case 'Draft':
                        icons = 'secondary timeline-point';
                        addedclass = 'text-secondary';
                        switch (value.action) {
                            case 'Back To Draft':
                                reason = '<p class="text-muted"><b><u>Reason:</u></b>' + value.reason + '.</p>';
                                break;
                            default:
                                reason = '';
                                break;
                        }
                        break;

                    case 'Approve':
                        icons = 'success timeline-point';
                        addedclass = 'text-success';
                        reason = '';
                        break;

                    case 'Reviewed':
                        icons = 'primary timeline-point';
                        addedclass = 'text-primary';
                        reason = '';
                        break;

                    case 'Created':
                        icons = 'secondary timeline-point';
                        addedclass = 'text-secondary';
                        switch (value.action) {
                            case 'Back To Draft':
                                reason = '<p class="text-muted"><b><u>Reason:</u></b>' + value.reason + '.</p>';
                                break;
                            default:
                                reason = '';
                                break;
                        }
                        break;

                    case 'Edited':
                        icons = 'warning timeline-point';
                        addedclass = 'text-warning';
                        reason = '';
                        break;

                    case 'Undo Review':
                        icons = 'warning timeline-point';
                        addedclass = 'text-warning';
                        reason = '';
                        break;

                    case 'Verify':
                        icons = 'primary timeline-point';
                        addedclass = 'text-primary';
                        reason = '';
                        break;

                    case 'Void':
                        icons = 'danger timeline-point';
                        addedclass = 'text-danger';
                        reason = '<p class="text-muted"><b><u>Reason:</u></b>' + value.reason + '.</p>';
                        break;

                    case 'Rejected':
                        icons = 'danger timeline-point';
                        addedclass = 'text-danger';
                        reason = '<p class="text-muted"><b><u>Reason:</u></b>' + value.reason + '.</p>';
                        break;

                    default:
                        icons = 'danger timeline-point';
                        addedclass = 'text-danger';
                        reason = '';
                        break;
                }

                list += '<li class="timeline-item">' +
                    '<span class="timeline-point timeline-point-' + icons + ' timeline-point-indicator"></span>' +
                    '<div class="timeline-header mb-sm-0 mb-0">' +
                    '<h6 class="mb-0 ' + addedclass + '">' + value.action + '</h6>' +
                    '<span class="text-muted"><i class="fa-regular fa-user"></i>' + value.user + '</span></br>' +
                    '<span class="text-muted"><i class="fa-regular fa-clock"></i> ' + value.time + '</span>' +
                    reason +
                    '</div>' +
                    '</li>';
            });

            $('#ulist').append(list);
        }

        function directcommoditylist(id) {
            var suptables = $('#directcommudityinfodatatables').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                searching: true,
                paging: false,
                ordering: false,
                info: false,
                searchHighlight: true,
                destroy: true,
                autoWidth: false,
                "pagingType": "simple",
                order: [[0, "desc"]],
                language: { search: '', searchPlaceholder: "Search here" },
                "dom": "<'row'<'col-lg-5 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-5'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
                ajax: {
                    url: "{{ url('directcommoditylist') }}/" + id,
                    type: 'GET',
                },
                columns: [
                    { data: 'DT_RowIndex' },
                    { data: 'origin', name: 'origin' },
                    { data: 'grade', name: 'grade' },
                    { data: 'proccesstype', name: 'proccesstype' },
                    { data: 'cropyear', name: 'cropyear' },
                    { data: 'uomname', name: 'uomname' },
                    { data: 'qty', name: 'qty', render: $.fn.dataTable.render.number(',', '.', 2, '') },
                    { data: 'bagweight', name: 'bagweight', render: $.fn.dataTable.render.number(',', '.', 2, '') },
                    { data: 'totalKg', name: 'totalKg', render: $.fn.dataTable.render.number(',', '.', 2, '') },
                    { data: 'netkg', name: 'netkg', render: $.fn.dataTable.render.number(',', '.', 2, '') },
                    { data: 'ton', name: 'ton', render: $.fn.dataTable.render.number(',', '.', 2, '') },
                    { data: 'feresula', name: 'feresula', render: $.fn.dataTable.render.number(',', '.', 2, '') },
                    { data: 'price', name: 'price' },
                    { data: 'Total', name: 'Total', render: $.fn.dataTable.render.number(',', '.', 2, '') },
                    { data: 'price', name: 'price' },
                ],
                columnDefs: [
                    {
                        targets: 14,
                        render: function (data, type, row, meta) {
                            return `<i class="info-icon fa fa-info-circle text-primary" 
                                        data-id="${data}" 
                                        data-price="${data}" 
                                        title="Price/Kg">
                                    </i>`;
                        }
                    },
                ],
                "initComplete": function (settings, json) {
                    var totalRows = suptables.rows().count();
                    $('#directinfonumberofItemsLbl').html(totalRows);
                },
                "footerCallback": function (row, data, start, end, display) {
                    var api = this.api();
                    var intVal = function (i) {
                        return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ? i : 0;
                    };
                    var totalbag = api.column(6).data().reduce((a, b) => intVal(a) + intVal(b), 0);
                    var totalbagweiht = api.column(7).data().reduce((a, b) => intVal(a) + intVal(b), 0);
                    var totalkg = api.column(8).data().reduce((a, b) => intVal(a) + intVal(b), 0);
                    var totalnet = api.column(9).data().reduce((a, b) => intVal(a) + intVal(b), 0);
                    var totalton = api.column(10).data().reduce((a, b) => intVal(a) + intVal(b), 0);
                    var totalferesula = api.column(11).data().reduce((a, b) => intVal(a) + intVal(b), 0);
                    var totalprice = api.column(12).data().reduce((a, b) => intVal(a) + intVal(b), 0);
                    var totaltotal = api.column(13).data().reduce((a, b) => intVal(a) + intVal(b), 0);

                    var numberendering = $.fn.dataTable.render.number(',', '.', 2).display;
                    $('#infonofbagtotal').html(`<h6 style='font-size:13px;color:black;font-weight:bold;'>${numberendering(totalbag)}</h6>`);
                    $('#infobagweighttotal').html(`<h6 style='font-size:13px;color:black;font-weight:bold;'>${numberendering(totalbagweiht)}</h6>`);
                    $('#infokgtotal').html(`<h6 style='font-size:13px;color:black;font-weight:bold;'>${numberendering(totalkg)}</h6>`);
                    $('#infonetkgtotal').html(`<h6 style='font-size:13px;color:black;font-weight:bold;'>${numberendering(totalnet)}</h6>`);
                    $('#infotontotal').html(`<h6 style='font-size:13px;color:black;font-weight:bold;'>${numberendering(totalton)}</h6>`);
                    $('#infopriceferesula').html(`<h6 style='font-size:13px;color:black;font-weight:bold;'>${numberendering(totalferesula)}</h6>`);
                    $('#infopricetotal').html(`<h6 style='font-size:13px;color:black;font-weight:bold;'>${numberendering(totalprice)}</h6>`);
                    $('#infototalpricetotal').html(`<h6 style='font-size:13px;color:black;font-weight:bold;'>${numberendering(totaltotal)}</h6>`);
                }
            });
        }
        
        $('#poprintbutton').click(function(){
            var id=$('#porecordIds').val();
            var link="/directpoattachemnt/"+id;
            window.open(link, 'Purchase Order', 'width=1200,height=800,scrollbars=yes');
        });

        function purchaseInvDocFn(recordId) {
            var reference='';
            var poid=0;
            var path='';
            var paidamount=0.00;
            var popaidamount=0.00;
            var remaining=0.00;
            var poremaining=0.00;

            $.ajax({
                type: "GET",
                url: "{{ url('purinvoinfo') }}/"+recordId,
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
                        $("#pivcollapseOne").collapse('show');
                        $('#purchaseinvoiceinfomodal').modal('show');
                    },
                success: function (response) {
                        paidamount=response.paidamount;
                        popaidamount=response.popaidamount;
                    $.each(response.supplier, function (index, value) { 
                        $('#pivinfosuppid').html(value.Code);
                        $('#pivinfsupname').html(value.Name);
                        $('#pivinfosupptin').html(value.TinNumber);
                    });
                    
                    $.each(response.payrninfo, function (index, value) { 
                            switch (value.reference) {
                                case 'PO':
                                        var links='<b><u>'+value.porderno+'</u></b>';
                                        var glinks = '<a href="#" onclick="infoviewpurchaseivoicehistory('+value.poid+');"><u><b>View Recieving History</b></u></a>';
                                        $('#grvhistory').html(glinks);
                                        $('.pivinfopo').html(links); 
                                        $('.infopetr').show();
                                        $('#pivinforefernce').html('Purchase Order');
                                    break;
                                
                                default:
                                    $('.infopetr').hide();
                                    $('#pivinforefernce').html(value.reference);
                                    $('#grvhistory').html('');
                                    break;
                            }
                        $('#pivdocno').html(value.docno);
                        $('#pivinfoStatus').html('<span class="text-success font-weight-medium"><b> '+value.docno+' Confirm</b>');
                        $('#pivinfocommoditype').html(value.commoditype);
                        $('#pivinfocommoditysource').html(value.commoditysource);
                        $('#pivinfocommoditystatus').html(value.commoditystatus);
                        $('#pivinfopaymentmode').html(value.paymentmode);
                        $('#pivinfodocumentdate').html(value.invoicedate);
                        $('#pivinfopaymentype').html(value.paymentype);
                        $('#pivinforecieptype').html(value.invoicetype);
                        $('#pivinfomrcno').html(value.mrc);
                        $('#pivinfoinvoice').html(value.voucherno);
                        switch (value.invoicetype) {
                            case 'Manual':
                                $('#payrinfomrcnotr').hide();
                                break;
                        
                            default:
                                    $('#payrinfomrcnotr').show();
                                break;
                        }
                        $('#pivinfodirectinfosubtotalLbl').html(numformat(value.subtotal.toFixed(2)));
                        $('#pivinfodirectinfotaxLbl').html(numformat(value.tax));
                        $('#pivinfodirectinfograndtotalLbl').html(numformat(value.grandtotal));
                        $('#pivinfodirectinfowitholdingAmntLbl').html(numformat(value.withold));
                        $('#pivinfodirectinfonetpayLbl').html(numformat(value.netpay));
                        $('.popayrinfopar').html(value.docno);
                        $('#payrinforemainamount').html(numformat(remaining.toFixed(2)));
                        var links = '<a href="#" onclick="infoviewpaymenthistory('+value.poid+');"><u>View Payment History</u></a>';
                        
                        $('#pivinfoviewpaymenthistory').html(links);
                        $('.paymentrequestinfopurpose').html(value.purpose);
                        
                        $('#pivmentrequestinfomemo').html(value.memo);
                        
                        reference=value.reference;
                        poid=value.poid;
                        path=value.path;
                        
                        switch (value.istaxable) {
                            case 0:
                                $('#pivinfodirecttaxtr').hide();
                                $('#pivinfosupplierinfotaxtr').hide();
                                $('#pivinfosupplierinforandtotaltr').hide();
                                
                                break;
                        
                            default:
                                $('#pivinfodirecttaxtr').show();
                                $('#pivinfosupplierinfotaxtr').show();
                                $('#pivinfosupplierinforandtotaltr').show();
                                break;
                        }
                        switch (value.reference) {
                            case 'PO':
                                $('#pivdividerinfo').show();

                                $('#pivpaymentinfordirectprice').hide();
                                
                                break;
                            default:
                                $('#pivpaymentinfordirectprice').show();
                                
                                $('#pivdividerinfo').hide();
                                $('#ppivinfopaymentreference').html('Direct');
                                break;
                        }
                        path = (path === undefined || path === null || path === '') ? 'EMPTY' : path;
                        switch (path) {
                            case 'EMPTY':
                                var iframe = $('#purchaseinvoicepdfviewer')[0];
                                var doc = iframe.contentDocument || iframe.contentWindow.document;
                                doc.open();
                                // Write a simple HTML structure with the text
                                var text="No Document Attached";
                                doc.write('<html><body><h1>' + text + '</h1></body></html>');
                                // Close the document to apply changes
                                doc.close();
                                break;
                            default:
                                purchaseinvoiceviewdocuments(recordId);
                                break;
                        }
                    });
                    showpurchaseinvloicecommodity(recordId);
                    setpurchaseinvoiceminilog(response.actions);
                }
            });    
        }

        function showpurchaseinvloicecommodity(recordId) {
            var someCondition = true;
            var reference=$('#pivinforefernce').html();
            switch (reference) {
                case 'Direct':
                    someCondition=false;
                    break;
                
                default:
                        someCondition=true;
                    break;
            }
            var suptables=$('#pivtable').DataTable({
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
                url: "{{ url('purcachaseinvloicecommoditylist') }}/"+recordId,                   
                type: 'GET',
            },
            columns: [
                    {data:'DT_RowIndex'},
                    {data: 'docno',name: 'docno',width:'11%', visible: false},
                    {data: 'origin',name: 'origin',width:'15%'},
                    {data: 'cropyear',name: 'cropyear'},
                    {data: 'proccesstype',name: 'proccesstype'},
                    {data: 'grade',name: 'grade'},
                    {data: 'uomname',name: 'uomname'},
                    {data: 'nofbag',name: 'nofbag'},
                    {data: 'netkg',name: 'netkg'},
                    {data: 'ton',name: 'ton'},
                    {data: 'feresula',name: 'feresula',render: $.fn.dataTable.render.number(',', '.', 2, '')},
                    {data: 'price',name: 'price',render: $.fn.dataTable.render.number(',', '.', 2, '')},
                    {data: 'total',name: 'total',render: $.fn.dataTable.render.number(',', '.', 2, '')},
                    {data: 'price',name: 'price'},
                    {data: 'recid',name: 'recid', visible:false},
            ],
            columnDefs: [
                                {
                                    targets:1,
                                    render:function(data,type,row,meta){
                                        
                                        return '<a href="#" onclick="viewrecievinginformation('+row.recid+');"><u>'+data+'</u></a>';
                                    }
                            },
                            {
                                targets: 13,
                                render: function ( data, type, row, meta ) {
                                    return `
                                            <i class="info-icon fa fa-info-circle text-primary" 
                                            data-netkg="${row.netkg}" 
                                            data-totalprice="${row.total}" 
                                            title="Price Per Kg">
                                            </i>
                                        `;
                                }
                            }
            ],
            rowGroup: {
                        startRender: function ( rows, group,level) {
                            var color = '';
                            var gr='--';
                            switch (someCondition) {
                                case true:
                                        var reid =  []
                                        var groupedData = rows.data(); 
                                        groupedData.each(function(rowData) {
                                            reid.push(rowData.recid);          // Collect names
                                        });
                                        var uniqueArray = [];
                                        reid.forEach(function(item) {
                                            // If the item is not already in the uniqueArray, add it
                                            if (!uniqueArray.includes(item)) {
                                                uniqueArray.push(item);
                                            }
                                        });
                                        // console.log('reid='+reid);
                                        // console.log('uniqueArray='+uniqueArray);
                                        if(level===0){
                                                var grp='<b><u>'+group+'</u></b>';
                                                return $('<tr ' + color + '/>')
                                                .append('<th colspan="12" style="text-align:left;background:#ccc; font-size:12px;">' + grp + ' </th>')
                                            }
                                            else{
                                                return $('<tr ' + color + '/>')
                                                .append('<th colspan="5" style="text-align:left;border:1px solid;background:#f2f3f4;font-size:12px;">Customer: ' + group + '</th>')
                                            }
                                    break;
                                        
                                default:
                                    break;
                            }
                            
                        },
                        dataSrc: ['docno']
                    },
                
            "initComplete": function(settings, json) {
                var totalRows = suptables.rows().count();
                $('#pivinfodirectinfonumberofItemsLbl').html(totalRows);

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

                var totalbag = api
                .column(7)  // The column index where the numeric data is
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

                var totalnet = api
                .column(8)  // The column index where the numeric data is
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

                var totalton = api
                .column(9)  // The column index where the numeric data is
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

                var totalferesula = api
                .column(10)  // The column index where the numeric data is
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                    var totalprice = api
                    .column(11)  // The column index where the numeric data is
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                    var totaltotal = api
                    .column(12)  // The column index where the numeric data is
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                    
                        var numberendering = $.fn.dataTable.render.number( ',', '.', 2, ).display;
                        $('#pinfonofbagtotal').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>"+numberendering(totalbag)+"</h6>");
                        $('#pinfokgtotal').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>"+numberendering(totalnet)+"</h6>");
                        $('#pinfotontotal').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>"+numberendering(totalton)+"</h6>");
                        $('#pinfopriceferesula').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>"+numberendering(totalferesula)+"</h6>");
                        $('#pinfopricetotal').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>"+numberendering(totalprice)+"</h6>");
                        $('#pinfototalpricetotal').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>"+numberendering(totaltotal)+"</h6>");

                }
            });
        }

        function setpurchaseinvoiceminilog(actions) {
            var list='';
            var icons=''
            var reason='';
            var addedclass='';
            $('#paymentinvoiceulist').empty();
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
                    case 'Confirmed':
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
                    case 'Refund':
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
            $('#paymentinvoiceulist').append(list);
        }

        function purchaseinvoiceviewdocuments(id) {
            $.ajax({
                type: "GET",
                url: "{{url('downloadpaymentinvoice') }}/" + id,
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
                xhrFields: {
                        responseType: 'blob' // important for handling binary data
                    },
                success: function (response) {
                    var blobUrl = URL.createObjectURL(response);
                    $('#purchaseinvoicepdfviewer').attr('src', blobUrl);
                },
                error: function(xhr) {
                        
                        toastrMessage('error','An error occurred while loading the PDF.','Error!');
                    }
            });
        }

        function infoviewpurchaseivoicehistory(id){
            var cname=$('#pivinfsupname').text()||0;
            var tin=$('#pivinfosupptin').text()||0;
            var customertile=cname+' '+tin;
            $('#paymentinvoicehistorystatus').html('History Of '+customertile);
            $('#historpurchaseinvoicetables').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                fixedHeader: true,
                searchHighlight: true,
                destroy:true,
                paging: false,
                ordering:false,
                info: false,    
                lengthMenu: [[50, 100], [50, 100]],
                "pagingType": "simple",
                language: { search: '', searchPlaceholder: "Search here"},
                "dom": "<'row'<'col-lg-5 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-5'>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
                ajax: {
                    url: "{{ url('pihistorypaymentrequestlist') }}/"+id,
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
                        $('#purchaseinvloicehistorymodal').modal('show');
                    },
                },
                columns: [
                    { data:'DT_RowIndex'},
                    { data: 'grv', name: 'grv','visible': true },
                    { data: 'piv', name: 'piv' },
                    { data: 'invoicedate', name: 'invoicedate' },
                    { data: 'paymentype', name: 'paymentype' },
                    { data: 'invoicetype', name: 'invoicetype' },
                    { data: 'mrc', name: 'mrc' },
                    { data: 'voucherno', name: 'voucherno' },
                    { data: 'invoiceno', name: 'invoiceno' },
                    { data: 'status', name: 'status' },
                ],
                columnDefs: [   
                {
                    targets: 9,
                    render: function ( data, type, row, meta ) {
                        switch (data) {
                            case '0':
                                return '<span class="text-secondary font-weight-medium"><b>Draft</b></span>';
                                break;
                            case '1':
                                return '<span class="text-warning font-weight-medium"><b>Pending</b></span>';
                            break;
                            case '2':
                                return '<span class="text-primary font-weight-medium"><b>Verify</b></span>';
                            break;
                            case '3':
                                return '<span class="text-success font-weight-medium"><b>Confirmed</b></span>';
                            break;
                            case '4':
                                return '<span class="text-danger font-weight-danger"><b>Void</b></span>';
                            break;
                            case '5':
                                return '<span class="text-danger font-weight-danger"><b>Refund</b></span>';
                            break;
                            default:
                                return data;
                                break;
                        }
                    }
                },],
            });
        }

        //Start Production Modal
        function productionDocFn(recordId) { 
            $("#recInfoId").val(recordId);
            var certificatenumber="";
            var lidata="";
            var totalnumofbag=0;
            var totalweightofkg=0;
            var variance=0;
            var expectedkg=0;
            var expton=0;
            var rejshortage=0;
            var rejoverage=0;
            var rejnumofbag=0;
            var rejnetkg=0;
            var stubnumofbag=0;
            var stubnetkg=0;
            var stubshortage=0;
            var stuboverage=0;
            var expshortage=0;
            var expoverage=0;
            var preshortage=0;
            var preoverage=0;
            var excshortage=0;
            var excoverage=0;
            var cancshortage=0;
            var cancoverage=0;
            var exportsnumofbag=0;
            var expnetkg=0;
            var excnumofbag=0;
            var excnetkg=0;
            var cannumofbag=0;
            var cannetkg=0;
            var prenumofbag=0;
            var prenetkg=0;
            var wasnumofbag=0;
            var wasnetkg=0;
            var wasshortage=0;
            var wasoverage=0;
            var prdprcnumofbag=0;
            var prdprcnetkg=0;
            var prdoutputnumofbag=0;
            var prdoutputnetkg=0;

            var infoexpunitcost=0;
            var infoexptotalcost=0;

            var infoexcunitcost=0;
            var infoexctotalcost=0;

            var infocanunitcost=0;
            var infocantotalcost=0;

            var infopreunitcost=0;
            var infopretotalcost=0;

            var inforejunitcost=0;
            var inforejtotalcost=0;

            var infowasunitcost=0;
            var infowastotalcost=0;

            var infostbunitcost=0;
            var infostbtotalcost=0;

            var infototalcosts=0;

            var infoexpper=0;
            var infoexcper=0;
            var infocanper=0;
            var infopreper=0;
            var inforejper=0;
            var infowasper=0;
            var infostbper=0;
            var infototalper=0;

            $.ajax({
                url: '/showPrdOrder'+'/'+recordId,
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
                    $.each(data.prdorders, function(key, value) {
                        $("#infocompanytypelbl").html(value.CompanyTypes);
                        $("#infocustomercodelbl").html(value.CustomerCode);
                        $("#infocustomerlbl").html(value.CustomerName);
                        $("#infocustomertinlbl").html(value.TinNumber);
                        $("#infocustomerphonelbl").html(value.PhoneNumber+",    "+value.OfficePhone);
                        $("#infocustomeremaillbl").html(value.EmailAddress);
                        $("#inforepnamelbl").html(value.RepName);
                        $("#inforrepphonelbl").html(value.RepPhone);
                        expton=value.ExpectedAmount||0;
                        expectedkg=parseFloat(expton)*1000;

                        $("#infoproductiontype").html(value.ProductionTypeName);
                        $("#infooutputtypelbl").html(value.OutputType);
                        $("#infobomlbl").html(value.BomChildName);
                        $("#infoexpectedamountlbl").html(expton+" TON      |      "+ numformat(expectedkg.toFixed(2))+" KG");
                        $("#infocommoditylbl").html(value.Commodities);
                        $("#infogradelbl").html(value.Grades);
                        $("#infoprocesstypelbl").html(value.ProcessType);
                        $("#infosymbollbl").html(value.Symbol);
                        $("#infoproductionstorelbl").html(value.ProductionStore);

                        $("#infoorderdatelbl").html(value.OrderDate);
                        $("#infodeadlinelbl").html(value.Deadline);
                        $("#infoproductionstdatelbl").html(value.ProductionStartDate);
                        $("#infoproductionendatelbl").html(value.ProductionEndDate);
                        $("#infograinprolbl").html(value.GrainPros);
                        $("#infocontractnumlbl").html(value.ContractNumber);

                        $("#infosievesizelbl").html(value.SieveSize);
                        $("#infocgradelbl").html(value.CGrade);
                        $("#infothickcoffeelbl").html(value.ThickCoffee);
                        $("#infomoisturelbl").html(value.Moisture);
                        $("#infowateractivitylbl").html(value.WaterActivity);
                        $("#infodefectcountlbl").html(value.DefectCount);
                        $("#infofrontsidebaglabellbl").html(value.FrontSideBagLabel);
                        $("#infobacksidebaglabellbl").html(value.BackSideBagLabel);
                        $("#infoadditionalinstructionlbl").html(value.AdditionalInstruction);

                        $("#infoassignedpersonnellbl").html(value.FullName);
                        $("#infoadditionalfilelbl").text(value.AdditionalFile);
                        $("#inforemarklbl").html(value.Remark);
                        $("#infoFileName").val(value.AdditionalFile);

                        $("#infoMoisturePercentTotalLbl").html(value.MoisturePercent === 0 ? '' : numformat(value.MoisturePercent||0).toFixed(2));
                        $("#infoWeightinKGLbl").html(value.PrdWeightByKg === 0 ? '' : numformat(value.PrdWeightByKg||0));
                        $("#infoNoOfBagLbl").html(value.PrdNumofBag === 0 ? '' : numformat(parseFloat(value.PrdNumofBag).toFixed(2)));
                        $("#infoVarianceShortage").html(value.VarianceShortagePr === 0 ? '' : numformat(parseFloat(value.VarianceShortagePr).toFixed(2)));
                        $("#infoVarianceOverage").html(value.VarianceOveragePr === 0 ? '' : numformat(parseFloat(value.VarianceOveragePr).toFixed(2)));
                        $("#infoBagWeightLbl").html(value.PrdBagByKg === 0 ? '' : numformat(parseFloat(value.PrdBagByKg).toFixed(2)));
                        $("#infoAdjustmentLbl").html(value.PrdAdjustment === 0 ? '' : numformat(parseFloat(value.PrdAdjustment).toFixed(2)));
                        $("#infoNetWeightLbl").html(value.PrdNetWeight === 0 ? '' : numformat(parseFloat(value.PrdNetWeight).toFixed(2)));

                        $("#infosumexpremark").html(value.ExportRemark === 'NULL' || value.ExportRemark === 'null' ? '' : value.ExportRemark);

                        $("#infosumrejremark").html(value.RejectRemark === 'NULL' || value.RejectRemark === 'null' ? '' : value.RejectRemark);

                        $("#infosumwesremark").html(value.WastageRemark === 'NULL' || value.WastageRemark === 'null' ? '' : value.WastageRemark);

                        $("#infosumstubbleremark").html(value.WastageRemark === 'NULL' || value.WastageRemark === 'null' ? '' : value.WastageRemark);

                        prdprcnumofbag=value.PrdNumofBag;
                        prdprcnetkg=value.PrdWeightByKg;

                        $("#exportinforemark").html(value.ExportRemark);
                        $("#rejectinforemark").html(value.RejectRemark);
                        $("#wastageinforemark").html(value.WastageRemark);

                        $("#infoStatusVal").val(value.Status);

                        if(value.Status=="Draft"){
                            $("#prdstatustitles").html("<span style='color:#4B4B4B;font-weight:bold;text-shadow;1px 1px 10px #4B4B4B;font-size:16px;'>"+value.ProductionOrderNumber+"   ,   "+value.Status+"</span>");
                        }
                        else if(value.Status=="Pending"){
                            $("#prdstatustitles").html("<span style='color:#f6c23e;font-weight:bold;text-shadow;1px 1px 10px #f6c23e;font-size:16px;'>"+value.ProductionOrderNumber+"   ,   "+value.Status+"</span>");
                        }
                        else if(value.Status=="Ready"){
                            $("#prdstatustitles").html("<span style='color:#1cc88a;font-weight:bold;text-shadow;1px 1px 10px #1cc88a;font-size:16px;'>"+value.ProductionOrderNumber+"   ,   "+value.Status+"</span>");
                        }
                        else if(value.Status=="Reviewed"){
                            $("#prdstatustitles").html("<span style='color:#7367f0;font-weight:bold;text-shadow;1px 1px 10px #1cc88a;font-size:16px;'>"+value.ProductionOrderNumber+"   ,   "+value.Status+"</span>");
                        }
                        else if(value.Status=="On-Production"){
                            $("#prdstatustitles").html("<span style='color:#00cfe8;font-weight:bold;text-shadow;1px 1px 10px #00cfe8;font-size:16px;'>"+value.ProductionOrderNumber+"   ,   "+value.Status+"</span>");
                        }
                        else if(value.Status=="Void" || value.Status=="Void(Draft)" || value.Status=="Void(Pending)" || value.Status=="Void(Ready)" || value.Status=="Aborted"){
                            
                            $("#prdstatustitles").html("<span style='color:#e74a3b;font-weight:bold;text-shadow;1px 1px 10px #e74a3b;font-size:16px;'>"+value.ProductionOrderNumber+"   ,   "+value.Status+"</span>");
                        }
                        else if(value.Status=="Process-Finished"){
                            
                            $("#prdstatustitles").html("<span style='color:#1cc88a;font-weight:bold;text-shadow;1px 1px 10px #1cc88a;font-size:16px;'>"+value.ProductionOrderNumber+"   ,   "+value.Status+"</span>");
                        }
                        else if(value.Status=="Production-Closed"){
                            
                            $("#prdstatustitles").html("<span style='color:#1cc88a;font-weight:bold;text-shadow;1px 1px 10px #1cc88a;font-size:16px;'> "+value.ProductionOrderNumber+"   ,   "+value.Status+"</span>");
                        }
                        else if(value.Status=="Verified"){
                            
                            $("#prdstatustitles").html("<span style='color:#7367f0;font-weight:bold;text-shadow;1px 1px 10px #7367f0;font-size:16px;'> "+value.ProductionOrderNumber+"   ,   "+value.Status+"</span>");
                        }
                        else if(value.Status=="Approved"){
                            
                            $("#prdstatustitles").html("<span style='color:#1cc88a;font-weight:bold;text-shadow;1px 1px 10px #7367f0;font-size:16px;'> "+value.ProductionOrderNumber+"   ,   "+value.Status+"</span>");
                        }
                        else if(value.Status=="Completed"){
                            
                            $("#prdstatustitles").html("<span style='color:#1cc88a;font-weight:bold;text-shadow;1px 1px 10px #1cc88a;font-size:16px;'> "+value.ProductionOrderNumber+"   ,   "+value.Status+"</span>");
                        }
                        else{
                            
                            $("#prdstatustitles").html("<span style='color:#ea5455;font-weight:bold;text-shadow;1px 1px 10px #ea5455;font-size:16px;'> "+value.ProductionOrderNumber+"   ,   "+value.Status+"</span>");
                        }
                    });

                    $.each(data.prdoutputs, function(key, value) {
                        if(parseInt(value.OutputType)==1){
                            if(parseInt(value.CleanProductType)==2){
                                expshortage += parseFloat(value.VarianceShortage === '' ? 0 : value.VarianceShortage);
                                expoverage += parseFloat(value.VarianceOverage === '' ? 0 : value.VarianceOverage);

                                exportsnumofbag += parseFloat(value.FullNumofBag === '' ? 0 : value.FullNumofBag);
                                expnetkg += parseFloat(value.NetKg === '' ? 0 : value.NetKg);

                                infoexpper += parseFloat(value.Percentage === '' ? 0 : value.Percentage);

                                infoexpunitcost = parseFloat(value.UnitCost === '' ? 0 : value.UnitCost);
                                infoexptotalcost += parseFloat(value.TotalCost === '' ? 0 : value.TotalCost);

                                $('#infosumexpnumofbag').html(exportsnumofbag <= 0 ? '' : numformat(parseFloat(exportsnumofbag).toFixed(2)));
                                $('#infosumexpweightbykg').html(expnetkg <= 0 ? '' : numformat(parseFloat(expnetkg).toFixed(2)));

                                $('#infosumexppercentage').html(infoexpper <= 0 ? '' : numformat(parseFloat(infoexpper).toFixed(2)));

                                $('#infosumexpunitcost').html(infoexpunitcost <= 0 ? '' : numformat(parseFloat(infoexpunitcost).toFixed(2)));
                                $('#infosumexptotalcost').html(infoexptotalcost <= 0 ? '' : numformat(parseFloat(infoexptotalcost).toFixed(2)));

                                $('#infosummexpshortage').html(expshortage <= 0 ? '' : numformat(parseFloat(expshortage).toFixed(2)));
                                $('#infosummexpoverage').html(expoverage <= 0 ? '' : numformat(parseFloat(expoverage).toFixed(2)));
                            }
                            if(parseInt(value.CleanProductType)==4){
                                preshortage += parseFloat(value.VarianceShortage === '' ? 0 : value.VarianceShortage);
                                preoverage += parseFloat(value.VarianceOverage === '' ? 0 : value.VarianceOverage);
                                $('#infosummpreshortage').html(preshortage <= 0 ? '' : numformat(parseFloat(preshortage).toFixed(2)));
                                $('#infosummpreoverage').html(preoverage <= 0 ? '' : numformat(parseFloat(preoverage).toFixed(2)));

                                prenumofbag += parseFloat(value.FullNumofBag === '' ? 0 : value.FullNumofBag);
                                prenetkg += parseFloat(value.NetKg === '' ? 0 : value.NetKg);

                                infopreper += parseFloat(value.Percentage === '' ? 0 : value.Percentage);

                                $('#infosumexpprepercentage').html(infopreper <= 0 ? '' : numformat(parseFloat(infopreper).toFixed(2)));

                                $('#infosummprecleanbag').html(prenumofbag <= 0 ? '' : numformat(parseFloat(prenumofbag).toFixed(2)));
                                $('#infosummprecleankg').html(prenetkg <= 0 ? '' : numformat(parseFloat(prenetkg).toFixed(2)));

                                infopreunitcost = parseFloat(value.UnitCost === '' ? 0 : value.UnitCost);
                                infopretotalcost += parseFloat(value.TotalCost === '' ? 0 : value.TotalCost);

                                $('#infosummprecleanunitcost').html(infopreunitcost <= 0 ? '' : numformat(parseFloat(infopreunitcost).toFixed(2)));
                                $('#infosummprecleantotalcost').html(infopretotalcost <= 0 ? '' : numformat(parseFloat(infopretotalcost).toFixed(2)));
                            }
                            if(parseInt(value.CleanProductType)==5){
                                excshortage += parseFloat(value.VarianceShortage === '' ? 0 : value.VarianceShortage);
                                excoverage += parseFloat(value.VarianceOverage === '' ? 0 : value.VarianceOverage);
                                $('#infosummexcshortage').html(excshortage <= 0 ? '' : numformat(parseFloat(excshortage).toFixed(2)));
                                $('#infosummexcoverage').html(excoverage <= 0 ? '' : numformat(parseFloat(excoverage).toFixed(2)));

                                excnumofbag += parseFloat(value.FullNumofBag === '' ? 0 : value.FullNumofBag);
                                excnetkg += parseFloat(value.NetKg === '' ? 0 : value.NetKg);

                                infoexcper += parseFloat(value.Percentage === '' ? 0 : value.Percentage);

                                $('#infosumexpexcpercentage').html(infoexcper <= 0 ? '' : numformat(parseFloat(infoexcper).toFixed(2)));

                                $('#infosummexpexcessbag').html(excnumofbag <= 0 ? '' : numformat(parseFloat(excnumofbag).toFixed(2)));
                                $('#infosummexpexcesskg').html(excnetkg <= 0 ? '' : numformat(parseFloat(excnetkg).toFixed(2)));

                                infoexcunitcost = parseFloat(value.UnitCost === '' ? 0 : value.UnitCost);
                                infoexctotalcost += parseFloat(value.TotalCost === '' ? 0 : value.TotalCost);

                                $('#infosummexpexcessunitcost').html(infoexcunitcost <= 0 ? '' : numformat(parseFloat(infoexcunitcost).toFixed(2)));
                                $('#infosummexpexcesstotalcost').html(infoexctotalcost <= 0 ? '' : numformat(parseFloat(infoexctotalcost).toFixed(2)));
                            }
                            if(parseInt(value.CleanProductType)==6){
                                cancshortage += parseFloat(value.VarianceShortage === '' ? 0 : value.VarianceShortage);
                                cancoverage += parseFloat(value.VarianceOverage === '' ? 0 : value.VarianceOverage);
                                $('#infosummcanshortage').html(cancshortage <= 0 ? '' : numformat(parseFloat(cancshortage).toFixed(2)));
                                $('#infosummcanoverage').html(cancoverage <= 0 ? '' : numformat(parseFloat(cancoverage).toFixed(2)));
                                
                                cannumofbag += parseFloat(value.FullNumofBag === '' ? 0 : value.FullNumofBag);
                                cannetkg += parseFloat(value.NetKg === '' ? 0 : value.NetKg);

                                infocanper += parseFloat(value.Percentage === '' ? 0 : value.Percentage);

                                $('#infosumexpcanpercentage').html(infocanper <= 0 ? '' : numformat(parseFloat(infocanper).toFixed(2)));

                                $('#infosummcanexpbag').html(cannumofbag <= 0 ? '' : numformat(parseFloat(cannumofbag).toFixed(2)));
                                $('#infosummcanexpkg').html(cannetkg <= 0 ? '' : numformat(parseFloat(cannetkg).toFixed(2)));
                            
                                infocanunitcost = parseFloat(value.UnitCost === '' ? 0 : value.UnitCost);
                                infocantotalcost += parseFloat(value.TotalCost === '' ? 0 : value.TotalCost);

                                $('#infosummcanexpunitcost').html(infocanunitcost <= 0 ? '' : numformat(parseFloat(infocanunitcost).toFixed(2)));
                                $('#infosummcanexptotalcost').html(infocantotalcost <= 0 ? '' : numformat(parseFloat(infocantotalcost).toFixed(2)));
                            }
                        }
                        
                        if(parseInt(value.OutputType)==2){
                            rejshortage += parseFloat(value.VarianceShortage === '' ? 0 : value.VarianceShortage);
                            rejoverage += parseFloat(value.VarianceOverage === '' ? 0 : value.VarianceOverage);
                            $('#infosummrejshortage').html(rejshortage <= 0 ? '' : numformat(parseFloat(rejshortage).toFixed(2)));
                            $('#infosummrejoverage').html(rejoverage <= 0 ? '' : numformat(parseFloat(rejoverage).toFixed(2)));

                            rejnumofbag += parseFloat(value.FullNumofBag === '' ? 0 : value.FullNumofBag);
                            rejnetkg += parseFloat(value.NetKg === '' ? 0 : value.NetKg);

                            inforejper += parseFloat(value.Percentage === '' ? 0 : value.Percentage);
                            $('#infosumexprejpercentage').html(inforejper <= 0 ? '' : numformat(parseFloat(inforejper).toFixed(2)));

                            $('#infosumrejnumofbag').html(rejnumofbag <= 0 ? '' : numformat(rejnumofbag.toFixed(2)));
                            $('#infosumrejweightbykg').html(rejnetkg <= 0 ? '' : numformat(rejnetkg.toFixed(2)));

                            inforejunitcost = parseFloat(value.UnitCost === '' ? 0 : value.UnitCost);
                            inforejtotalcost += parseFloat(value.TotalCost === '' ? 0 : value.TotalCost);

                            $('#infosumrejunitcost').html(inforejunitcost <= 0 ? '' : numformat(parseFloat(inforejunitcost).toFixed(2)));
                            $('#infosumrejtotalcost').html(inforejtotalcost <= 0 ? '' : numformat(parseFloat(inforejtotalcost).toFixed(2)));
                        }
                        if(parseInt(value.OutputType)==3){
                            if(parseInt(value.BiProductId)==3){
                                stubshortage += parseFloat(value.VarianceShortage === '' ? 0 : value.VarianceShortage);
                                stuboverage += parseFloat(value.VarianceOverage === '' ? 0 : value.VarianceOverage);
                                $('#infosummstubshortage').html(stubshortage <= 0 ? '' : numformat(parseFloat(stubshortage).toFixed(2)));
                                $('#infosummstuboverage').html(stuboverage <= 0 ? '' : numformat(parseFloat(stuboverage).toFixed(2)));
                            
                                stubnumofbag += parseFloat(value.FullNumofBag === '' ? 0 : value.FullNumofBag);
                                stubnetkg += parseFloat(value.NetKg === '' ? 0 : value.NetKg);

                                infostbper += parseFloat(value.Percentage === '' ? 0 : value.Percentage);
                                $('#infosumexpstbpercentage').html(infostbper <= 0 ? '' : numformat(parseFloat(infostbper).toFixed(2)));

                                $('#infosumstubblenumofbag').html(stubnumofbag <= 0 ? '' : numformat(parseFloat(stubnumofbag).toFixed(2)));
                                $('#infosumstubbleweightbykg').html(stubnetkg <= 0 ? '' : numformat(parseFloat(stubnetkg).toFixed(2)));

                                infostbunitcost = parseFloat(value.UnitCost === '' ? 0 : value.UnitCost);
                                infostbtotalcost += parseFloat(value.TotalCost === '' ? 0 : value.TotalCost);

                                $('#infosumstubbleunitcost').html(infostbunitcost <= 0 ? '' : numformat(parseFloat(infostbunitcost).toFixed(2)));
                                $('#infosumstubbletotalcost').html(infostbtotalcost <= 0 ? '' : numformat(parseFloat(infostbtotalcost).toFixed(2)));

                            }
                            if(parseInt(value.BiProductId)!=3){
                                wasshortage += parseFloat(value.VarianceShortage === '' ? 0 : value.VarianceShortage);
                                wasoverage += parseFloat(value.VarianceOverage === '' ? 0 : value.VarianceOverage);
                                $('#infosummwasshortage').html(wasshortage <= 0 ? '' : numformat(parseFloat(wasshortage).toFixed(2)));
                                $('#infosummwasoverage').html(wasoverage <= 0 ? '' : numformat(parseFloat(wasoverage).toFixed(2)));
                            
                                wasnumofbag += parseFloat(value.FullNumofBag === '' ? 0 : value.FullNumofBag);
                                wasnetkg += parseFloat(value.NetKg === '' ? 0 : value.NetKg);

                                infowasper += parseFloat(value.Percentage === '' ? 0 : value.Percentage);
                                $('#infosumexpwaspercentage').html(infowasper <= 0 ? '' : numformat(parseFloat(infowasper).toFixed(2)));

                                $('#infosumwesnumofbag').html(wasnumofbag <= 0 ? '' : numformat(parseFloat(wasnumofbag).toFixed(2)));
                                $('#infosumwesweightbykg').html(wasnetkg <= 0 ? '' : numformat(parseFloat(wasnetkg).toFixed(2)));
                            
                                infowasunitcost = parseFloat(value.UnitCost === '' ? 0 : value.UnitCost);
                                infowastotalcost += parseFloat(value.TotalCost === '' ? 0 : value.TotalCost);

                                $('#infosumwesunitcost').html(infowasunitcost <= 0 ? '' : numformat(parseFloat(infowasunitcost).toFixed(2)));
                                $('#infosumwestotalcost').html(infowastotalcost <= 0 ? '' : numformat(parseFloat(infowastotalcost).toFixed(2)));
                            }
                        }
                    });

                    prdoutputnumofbag=parseFloat(exportsnumofbag)+parseFloat(prenumofbag)+parseFloat(excnumofbag)+parseFloat(cannumofbag)+parseFloat(rejnumofbag)+parseFloat(stubnumofbag)+parseFloat(wasnumofbag);
                    prdoutputnetkg=parseFloat(expnetkg)+parseFloat(prenetkg)+parseFloat(excnetkg)+parseFloat(cannetkg)+parseFloat(rejnetkg)+parseFloat(stubnetkg)+parseFloat(wasnetkg);
                    infototalcosts=parseFloat(infoexptotalcost)+parseFloat(infoexctotalcost)+parseFloat(infocantotalcost)+parseFloat(infopretotalcost)+parseFloat(inforejtotalcost)+parseFloat(infowastotalcost)+parseFloat(infostbtotalcost);
                    infototalper=parseFloat(infoexpper)+parseFloat(infopreper)+parseFloat(infoexcper)+parseFloat(infocanper)+parseFloat(inforejper)+parseFloat(infostbper)+parseFloat(infowasper);
                    variance=parseFloat(prdprcnetkg||0)-parseFloat(prdoutputnetkg||0);

                    $("#infosumtotalnumofbag").html(prdoutputnumofbag === 0 ? '' : numformat(parseFloat(prdoutputnumofbag).toFixed(2)));
                    $("#infosumtotalweightbykg").html(prdoutputnetkg === 0 ? '' : numformat(parseFloat(prdoutputnetkg).toFixed(2)));

                    $("#infosumtotalprdnumofbag").html(prdprcnumofbag === 0 ? '' : numformat(parseFloat(prdprcnumofbag).toFixed(2)));
                    $("#infosumtotalprdweightbykg").html(prdprcnetkg === 0 ? '' : numformat(parseFloat(prdprcnetkg).toFixed(2)));
                    $('#infosumtotalcost').html(infototalcosts <= 0 ? '' : numformat(parseFloat(infototalcosts).toFixed(2)));
                    $('#infosumtotalpercentage').html(infototalper <= 0 ? '' : numformat(parseFloat(infototalper).toFixed(1)));

                    if(parseFloat(variance)<0){
                        variance=variance*(-1);
                        $('#infosumtotalvarweightbykg').html(variance === 0 ? '' : numformat(parseFloat(variance).toFixed(2)));
                        $("#infovariancelbl").html("Variance Overage");	
                    }
                    else if(parseFloat(variance)>0){
                        $('#infosumtotalvarweightbykg').html(variance === 0 ? '' : numformat(parseFloat(variance).toFixed(2)));
                        $("#infovariancelbl").html("Variance Shortage");	
                    }
                    else if(parseFloat(variance)==0){
                        $('#infosumtotalvarweightbykg').html(variance === 0 ? '' : numformat(parseFloat(variance).toFixed(2)));
                        $("#infovariancelbl").html("Variance");	
                    }

                    certificatenumber="<table class='rtable mb-1' style='font-size:10px;text-align:center;width:100%;'><thead><tr><th colspan='4' style='text-align:left;'>Production Certificate Number</th></tr><tr><th>Certificate No.</th><th>UOM/Bag</th><th>No. of Bag</th><th>Grain Pro</th></thead><tbody>"
                    $.each(data.prdcerorder, function(key, value) {
                        certificatenumber+="<tr><td>"+value.CertificateNumber+"</td><td>"+value.UomName+"</td><td>"+value.NumofBag+"</td><td>"+value.GrainPros+"</td></tr>";
                    });
                    certificatenumber+="</tbody></table>";
                    $("#infocertificatenumberlbl").html(certificatenumber);

                    $.each(data.activitydata, function(key, value) {
                        var classes="";
                        var reasonbody="";
                        if(value.action == "Edited" || value.action=="Change to Pending" || value.action == "Production Input Edited" || value.action == "Ratio-Edited"){
                            classes="warning";
                        }
                        else if(value.action == "Created" || value.action == "Approved" || value.action == "Change to Ready" || value.action == "Process-Finished" || value.action == "Production-Closed" || value.action == "Ratio-Created"){
                            classes="success";
                        }
                        else if(value.action == "Reviewed" || value.action == "Verified"){
                            classes="primary";
                        }
                        else if(value.action == "Back to Draft" || value.action=="Undo Void" || value.action=="Undo Abort" || value.action=="Back to Production" || value.action=="Back to Pending" || value.action=="Back to Process" || value.action=="Back to Ready" || value.action=="Back to Verify"){
                            classes="secondary";
                        }

                        else if(value.action == "Production Input Started" || value.action == "Export-Submitted" || value.action == "Reject-Submitted" || value.action == "Wastage-Submitted"){
                            classes="info";
                        }
                        else if(value.action == "Void" || value.action == "Aborted"){
                            classes="danger";
                        }

                        if(value.reason!=null && value.reason!=""){
                            reasonbody='</br><span class="text-muted"><b>Reason: </b> <i>'+value.reason+'</i></span>';
                        }
                        else{
                            reasonbody="";
                        }
                        lidata+='<li class="timeline-item"><span class="timeline-point timeline-point-'+classes+' timeline-point-indicator"></span><div class="timeline-header mb-sm-0 mb-0"><h6 class="mb-0">'+value.action+'</h6><span class="text-muted"><i class="fa-regular fa-user"></i> '+value.FullName+'</span>'+reasonbody+'</br><span class="text-muted" style="font-size:12px;"><i class="fa-regular fa-clock"></i> '+value.time+'</span></div></li>';
                    });
                    $("#actiondiv").empty();
                    $('#actiondiv').append(lidata);
                }
            });

            $('#commodityinfotbl').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                paging: false,
                searching: true,
                info: false,
                searchHighlight: true,
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
                    url: '/showPrdOrderDetail/' + recordId,
                    type: 'DELETE',
                },
                columns: [
                    {
                        data:'DT_RowIndex',
                        width:"2%"
                    },
                    {
                        data: 'CommType',
                        name: 'CommType',
                        width:"5%"
                    },
                    {
                        data: 'Origin',
                        name: 'Origin',
                        width:"5%"
                    },
                    {
                        data: 'Grade',
                        name: 'Grade',
                        width:"5%"
                    },
                    {
                        data: 'ProcessType',
                        name: 'ProcessType',
                        width:"5%"
                    },
                    {
                        data: 'CropYear',
                        name: 'CropYear',
                        width:"5%"
                    },
                    {
                        data: 'Symbol',
                        name: 'Symbol',
                        width:"5%"
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
                        data: 'StoreName',
                        name: 'StoreName',
                        width:"5%"
                    },
                    {
                        data: 'LocationName',
                        name: 'LocationName',
                        width:"4%"
                    },
                    {
                        data: 'UomName',
                        name: 'UomName',
                        width:"4%"
                    },
                    {
                        data: 'Quantity',
                        name: 'Quantity',
                        render: $.fn.dataTable.render.number(',', '.',0, ''),
                        width:"5%"
                    },
                    {
                        data: 'QuantityInKG',
                        name: 'QuantityInKG',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"5%"
                    },
                    {
                        data: 'UnitCost',
                        name: 'UnitCost',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"5%"
                    },
                    {
                        data: 'TotalCost',
                        name: 'TotalCost',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"5%"
                    },
                    {
                        data: 'RatioVarianceShortage',
                        name: 'RatioVarianceShortage',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"5%"
                    },
                    {
                        data: 'RatioVarianceOverage',
                        name: 'RatioVarianceOverage',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"5%"
                    },
                    {
                        data: 'Remark',
                        name: 'Remark',
                        width:"5%"
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

                    var totalbag = api
                    .column(14)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totalkg = api
                    .column(15)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totalcost = api
                    .column(17)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var varshortage = api
                    .column(18)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var varoverage = api
                    .column(19)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    $('#infototalbag').html(totalbag === 0 ? '' : numformat(parseInt(totalbag)));
                    $('#infototalkg').html(totalkg === 0 ? '' : numformat(parseFloat(totalkg).toFixed(2)));
                    $('#infototalcost').html(totalcost === 0 ? '' : numformat(parseFloat(totalcost).toFixed(2)));
                    $('#infototalvarshortage').html(varshortage === 0 ? '' : numformat(parseFloat(varshortage).toFixed(2)));
                    $('#infototalvaroverage').html(varoverage === 0 ? '' : numformat(parseFloat(varoverage).toFixed(2)));
                },
            });

            $('#prdprocesstbl').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                paging: false,
                searching: true,
                info: false,
                searchHighlight: true,
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
                    url: '/showPrdProcess/' + recordId,
                    type: 'DELETE',
                },
                columns: [
                    {
                        data:'DT_RowIndex',
                        width:"3%"
                    },
                    {
                        data: 'prd_order_details_id',
                        name: 'prd_order_details_id',
                        'visible': false,
                        width:"0%"
                    },
                    {
                        data: 'AllRatioData',
                        name: 'AllRatioData',
                        'visible': false,
                        width:"0%"
                    },
                    {
                        data: 'Date',
                        name: 'Date',
                        width:"12%"
                    },
                    {
                        data: 'LocationName',
                        name: 'LocationName',
                        width:"12%"
                    },
                    {
                        data: 'ProcUomName',
                        name: 'ProcUomName',
                        width:"12%"
                    },
                    {
                        data: 'QuantityByUom',
                        name: 'QuantityByUom',
                        render: $.fn.dataTable.render.number(',', '.',0, ''),
                        width:"12%"
                    },
                    {
                        data: 'QuantityByKg',
                        name: 'QuantityByKg',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"12%"
                    },
                    {
                        data: 'VarianceShortageProc',
                        name: 'VarianceShortageProc',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"12%"
                    },
                    {
                        data: 'VarianceOverageProc',
                        name: 'VarianceOverageProc',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"12%"
                    },
                    {
                        data: 'Remark',
                        name: 'Remark',
                        width:"13%"
                    },
                ],
                order: [[1,'asc']],
                createdRow: function(row, data, dataIndex) {
                    $('td', row).each(function() {
                        // If the cell's text is "0", set it to an empty string
                        if ($(this).text() == "0.00" || $(this).text() == "0") {
                            $(this).text('');
                        }
                    });
                },
                rowGroup: {
                    startRender: function ( rows, group,level ) {
                        var colorA = 'style="color:black;font-weight:bold;background:#cccccc;"';
                        if(level===0){
                            //return $('<tr ' + colorA + '>').append('<td colspan="7" style="text-align:left;"><b>' + group + ' </b></td></tr>');
                            return $('<tr style="font-weight:bold;font-size:14px;background:#e6e6e6;"><td colspan="9" style="text-align:left;"><b>'+group+'</b></td></tr><tr style="font-weight:bold;font-size:14px;background:#cccccc;"><td>#</td><td>Date</td><td>Floor Map</td><td>UOM/ Bag</td><td>No. of Bag</td><td>Weight by KG</td><td>Variance Shortage</td><td>Variance Overage</td><td>Remark</td></tr>');
                        }                        
                    },
                    endRender: function ( rows, group,level ) {
                        var firstRow = rows.data()[0];
                        var intVal = function ( i ) {
                            return typeof i === 'string' ? i.replace(/[\$,]/g, '')*1 : typeof i === 'number' ? i : 0;
                        };
                        var moisturepercent = firstRow.MoisturePercent||0;
                        var weightbykg = firstRow.PrdWeightByKg||0;
                        var nofbag = firstRow.PrdNumofBag||0;
                        var bagweightbykg = firstRow.PrdBagByKg||0;
                        var adjustment = firstRow.PrdAdjustment||0;
                        var netweightbykg = firstRow.PrdNetWeight||0; 
                        var varshortage = firstRow.VarianceShortage||0; 
                        var varoverage = firstRow.VarianceOverage||0; 
                        var symbol=firstRow.Symbol;
                        
                        if(level===0){
                            return $('<tr>')
                            .append('<td colspan="7" style="text-align:right;">Total of: <b>'+symbol+'</b></td>')
                            .append('<td colspan="2" style="text-align:left;"><table class="table-sm rtable mb-1" style="width:100%;text-align:center;"><tr><td style="width:50%;">Moisture %</td><td style="width:50%"><b>'+ moisturepercent +'</b></td></tr><tr><td>No. of Bag</td><td><b>'+ numformat(nofbag.toFixed(2)) +'</b></td></tr> <tr><td>Weight by KG</td><td><b>'+ numformat(weightbykg.toFixed(2)) +'</b></td></tr> <tr><td>Variance Shortage by KG</td><td><b>'+ numformat(varshortage.toFixed(2)) +'</b></td></tr> <tr><td>Variance Overage by KG</td><td><b>'+ numformat(varoverage.toFixed(2)) +'</b></td></tr> <tr style="display:none;"><td>Bag Weight by KG</td><td><b>'+ numformat(bagweightbykg.toFixed(2)) +'</b></td></tr><tr style="display:none;"><td>Adjustment</td><td><b>'+ numformat(adjustment.toFixed(2)) +'</b></td></tr><tr style="display:none;"><td>Net Weight by KG</td><td><b>'+ numformat(netweightbykg.toFixed(2)) +'</b></td></tr></table></td></tr>');
                        }
                    },
                    dataSrc: ['AllRatioData']
                },
                drawCallback: function(settings) {
                    var api = this.api();
                    var currentIndex = 1;
                    var currentGroup = null;
                    api.rows({ page: 'current', search: 'applied' }).every(function() {
                        var rowData = this.data();
                        if (rowData) {
                            var group = rowData['AllRatioData']; // Assuming 'group_column' is the name of the column used for grouping
                            if (group !== currentGroup) {
                                currentIndex = 1; // Reset index for a new group
                                currentGroup = group;
                            }
                            $(this.node()).find('td:first').text(currentIndex++);
                        }
                    });
                },
            });

            $('#prdprocesstbl thead').remove();

            $('#prdprocessdurationtbl').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                paging: false,
                searching: true,
                info: false,
                searchHighlight: true,
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
                    url: '/showPrdDuration/' + recordId,
                    type: 'DELETE',
                },
                columns: [
                    {
                        data:'DT_RowIndex',
                        width:"3%"
                    },
                    {
                        data: 'StartTime',
                        name: 'StartTime',
                        width:"33%"
                    },
                    {
                        data: 'EndTime',
                        name: 'EndTime',
                        width:"34%"
                    },
                    {
                        data: 'Duration',
                        name: 'Duration',
                        "render": function ( data, type, row, meta ) {
                            if(isNaN(parseFloat(data))){
                                return "";
                            }
                            else if(parseFloat(data)>=0){
                                return numformat(data)+" Minute";
                            }
                        }, 
                        width:"30%"
                    },
                ],
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(),data;
                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    var totalminute = api
                    .column(3)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var minutes = parseInt(totalminute);

                    var hours = Math.floor(minutes / 60);

                    var remMin = minutes % 60;

                    $('#totaldurationlbl').html(numformat(totalminute.toFixed(2))+' Minute ('+hours+' Hour(s) and '+remMin+' Minute(s))');
                },
            });

            $('#exportoutputtbl').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                paging: false,
                searching: true,
                info: false,
                searchHighlight: true,
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
                    url: '/showExportData/' + recordId,
                    type: 'DELETE',
                },
                columns: [
                    {
                        data:'DT_RowIndex',
                        width:"3%"
                    },
                    {
                        data: 'LocationName',
                        name: 'LocationName',
                        width:"8%"
                    },
                    {
                        data: 'CommodityType',
                        name: 'CommodityType',
                        width:"8%"
                    },
                    {
                        data: 'CertificateNumber',
                        name: 'CertificateNumber',
                        width:"8%"
                    },
                    {
                        data: 'FullUomName',
                        name: 'FullUomName',
                        width:"8%"
                    },
                    {
                        data: 'FullNumofBag',
                        name: 'FullNumofBag',
                        render: $.fn.dataTable.render.number(',', '.',2, ''),
                        width:"8%"
                    },
                    {
                        data: 'BagWeight',
                        name: 'BagWeight',
                        render: $.fn.dataTable.render.number(',', '.',2, ''),
                        width:"8%"
                    },
                    {
                        data: 'FullWeightbyKg',
                        name: 'FullWeightbyKg',
                        render: $.fn.dataTable.render.number(',', '.',2, ''),
                        width:"8%"
                    },
                    {
                        data: 'NetKg',
                        name: 'NetKg',
                        render: $.fn.dataTable.render.number(',', '.',2, ''),
                        width:"8%"
                    },
                    {
                        data: 'Feresula',
                        name: 'Feresula',
                        width:"8%"
                    },
                     {
                        data: 'VarianceShortage',
                        name: 'VarianceShortage',
                        render: $.fn.dataTable.render.number(',', '.',2, ''),
                        width:"6%"
                    },
                     {
                        data: 'VarianceOverage',
                        name: 'VarianceOverage',
                        render: $.fn.dataTable.render.number(',', '.',2, ''),
                        width:"6%"
                    },
                    {
                        data: 'InspectionData',
                        name: 'InspectionData',
                        width:"13%"
                    },
                ],
                createdRow: function(row, data, dataIndex) {
                    // Loop through each cell in the row
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

                    var totalbagnum = api
                    .column(5)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totalbagwgt = api
                    .column(6)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totalkg = api
                    .column(7)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totalnetkg = api
                    .column(8)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totalferesula = api
                    .column(9)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totalshortage = api
                    .column(10)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totaloverage = api
                    .column(11)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    $('#exptotnumofbag').html(totalbagnum === 0 ? '' : numformat(totalbagnum.toFixed(2)));
                    $('#exptotbagweight').html(totalbagwgt === 0 ? '' : numformat(totalbagwgt.toFixed(2)));
                    $('#exptotalkg').html(totalkg === 0 ? '' : numformat(totalkg.toFixed(2)));
                    $('#expnetkg').html(totalnetkg === 0 ? '' : numformat(totalnetkg.toFixed(2)));
                    $('#exptotferesula').html(totalferesula === 0 ? '' : numformat(totalferesula.toFixed(2)));
                    $('#exptotshortage').html(totalshortage === 0 ? '' : numformat(totalshortage.toFixed(2)));
                    $('#exptotoverage').html(totaloverage === 0 ? '' : numformat(totaloverage.toFixed(2)));
                },
            });

            $('#rejectoutputtbl').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                paging: false,
                searching: true,
                info: false,
                searchHighlight: true,
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
                    url: '/showRejectData/' + recordId,
                    type: 'DELETE',
                },
                columns: [
                    {
                        data:'DT_RowIndex',
                        width:"3%"
                    },
                    {
                        data: 'LocationName',
                        name: 'LocationName',
                        width:"7%"
                    },
                    {
                        data: 'Types',
                        name: 'Types',
                        width:"7%"
                    },
                    {
                        data: 'BiProductName',
                        name: 'BiProductName',
                        width:"7%"
                    },
                    {
                        data: 'CertificateNumber',
                        name: 'CertificateNumber',
                        width:"7%"
                    },
                    {
                        data: 'FullUomName',
                        name: 'FullUomName',
                        width:"7%"
                    },
                    {
                        data: 'FullNumofBag',
                        name: 'FullNumofBag',
                        render: $.fn.dataTable.render.number(',', '.',2, ''),
                        width:"7%"
                    },
                    {
                        data: 'BagWeight',
                        name: 'BagWeight',
                        render: $.fn.dataTable.render.number(',', '.',2, ''),
                        width:"7%"
                    },
                    {
                        data: 'FullWeightbyKg',
                        name: 'FullWeightbyKg',
                        render: $.fn.dataTable.render.number(',', '.',2, ''),
                        width:"7%"
                    },
                    {
                        data: 'NetKg',
                        name: 'NetKg',
                        render: $.fn.dataTable.render.number(',', '.',2, ''),
                        width:"7%"
                    },
                    {
                        data: 'Feresula',
                        name: 'Feresula',
                        width:"7%"
                    },
                     {
                        data: 'VarianceShortage',
                        name: 'VarianceShortage',
                        render: $.fn.dataTable.render.number(',', '.',2, ''),
                        width:"7%"
                    },
                     {
                        data: 'VarianceOverage',
                        name: 'VarianceOverage',
                        render: $.fn.dataTable.render.number(',', '.',2, ''),
                        width:"7%"
                    },
                    {
                        data: 'InspectionData',
                        name: 'InspectionData',
                        width:"13%"
                    },
                ],
                createdRow: function(row, data, dataIndex) {
                    // Loop through each cell in the row
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

                    var totalbagnum = api
                    .column(6)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totalbagwgt = api
                    .column(7)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totalkg = api
                    .column(8)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totalnetkg = api
                    .column(9)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totalferesula = api
                    .column(10)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totalshortage = api
                    .column(11)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totaloverage = api
                    .column(12)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    $('#rejtotnumofbag').html(totalbagnum === 0 ? '' : numformat(totalbagnum.toFixed(2)));
                    $('#rejtotbagwgt').html(totalbagwgt === 0 ? '' : numformat(totalbagwgt.toFixed(2)));
                    $('#rejtotkg').html(totalkg === 0 ? '' : numformat(totalkg.toFixed(2)));
                    $('#rejtotnetkg').html(totalnetkg === 0 ? '' : numformat(totalnetkg.toFixed(2)));
                    $('#rejtotferesula').html(totalferesula === 0 ? '' : numformat(totalferesula.toFixed(2)));
                    $('#rejtotshortage').html(totalshortage === 0 ? '' : numformat(totalshortage.toFixed(2)));
                    $('#rejtotoverage').html(totaloverage === 0 ? '' : numformat(totaloverage.toFixed(2)));
                },
            });

            $('#wastageoutputtbl').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                paging: false,
                searching: true,
                info: false,
                searchHighlight: true,
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
                    url: '/showWastageData/' + recordId,
                    type: 'DELETE',
                },
                columns: [
                    {
                        data:'DT_RowIndex',
                        width:"3%"
                    },
                    {
                        data: 'BiProductName',
                        name: 'BiProductName',
                        width:"8%"
                    },
                    {
                        data: 'LocationName',
                        name: 'LocationName',
                        width:"8%"
                    },
                    {
                        data: 'CertificateNumber',
                        name: 'CertificateNumber',
                        width:"8%"
                    },
                    {
                        data: 'FullUomName',
                        name: 'FullUomName',
                        width:"8%"
                    },
                    {
                        data: 'FullNumofBag',
                        name: 'FullNumofBag',
                        render: $.fn.dataTable.render.number(',', '.',2, ''),
                        width:"8%"
                    },
                    {
                        data: 'BagWeight',
                        name: 'BagWeight',
                        render: $.fn.dataTable.render.number(',', '.',2, ''),
                        width:"8%"
                    },
                    {
                        data: 'FullWeightbyKg',
                        name: 'FullWeightbyKg',
                        render: $.fn.dataTable.render.number(',', '.',2, ''),
                        width:"8%"
                    },
                    {
                        data: 'NetKg',
                        name: 'NetKg',
                        render: $.fn.dataTable.render.number(',', '.',2, ''),
                        width:"7%"
                    },
                    {
                        data: 'Feresula',
                        name: 'Feresula',
                        width:"7%"
                    },
                     {
                        data: 'VarianceShortage',
                        name: 'VarianceShortage',
                        render: $.fn.dataTable.render.number(',', '.',2, ''),
                        width:"7%"
                    },
                     {
                        data: 'VarianceOverage',
                        name: 'VarianceOverage',
                        render: $.fn.dataTable.render.number(',', '.',2, ''),
                        width:"7%"
                    },
                    {
                        data: 'InspectionData',
                        name: 'InspectionData',
                        width:"13%"
                    },
                ],
                createdRow: function(row, data, dataIndex) {
                    // Loop through each cell in the row
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

                    var totalbagnum = api
                    .column(5)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totalbagwgt = api
                    .column(6)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totalkg = api
                    .column(7)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totalnetkg = api
                    .column(8)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totalferesula = api
                    .column(9)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totalshortage = api
                    .column(10)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totaloverage = api
                    .column(11)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    $('#wastotnumofbag').html(totalbagnum === 0 ? '' : numformat(totalbagnum.toFixed(2)));
                    $('#wastotbagwgt').html(totalbagwgt === 0 ? '' : numformat(totalbagwgt.toFixed(2)));
                    $('#wastotkg').html(totalkg === 0 ? '' : numformat(totalkg.toFixed(2)));
                    $('#wastotnetkg').html(totalnetkg === 0 ? '' : numformat(totalnetkg.toFixed(2)));
                    $('#wastotferesula').html(totalferesula === 0 ? '' : numformat(totalferesula.toFixed(2)));
                    $('#wastotshortage').html(totalshortage === 0 ? '' : numformat(totalshortage.toFixed(2)));
                    $('#wastotoverage').html(totaloverage === 0 ? '' : numformat(totaloverage.toFixed(2)));
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

            $(".infoscl").collapse('show');
            $("#informationmodal").modal('show');
        }
        //End Production Modal

        function openAllocModalFn(comm,str,flrmap,commtype,grade,prctype,crpyr,uomid,cusid){
            var commodityidpost="";
            var storeidpost="";
            var locationidpost="";
            var commoditytypepost="";

            var gradepost="";
            var processtypepost="";
            var cropyearpost="";
            var uomidpost="";

            var customeridpost="";
            var customtrtypepost="";
            var grnpost="";
            var prdnumpost="";
            var certnumpost="";

            if(parseInt(cusid)==1){
                $('.customerinfotbl').hide();
                $('#commoditycustitle').html("Commodity Basic Information");
            }
            else if(parseInt(cusid)>1){
                $('.customerinfotbl').show();
                $('#commoditycustitle').html("Commodity Basic & Customer Information");
            }

            $.ajax({
                url: '/showComStockBalance'+'/'+comm+'/'+cusid,
                type: 'GET',
                success: function(data) {
                    $.each(data.orgdata, function(key, value) {
                        $('#origininfolbl').html(value.Origin);
                        $('#prdorigininfolbl').html(value.Origin);
                        $('#uominfolbl').html("");
                    });

                    $.each(data.customerdata, function(key, value) {
                        $('#infocustomercode').html(value.CustomerCode);
                        $('#infocustomername').html(value.CustomerName);
                        $('#infocustomertin').html(value.TinNumber);
                        $('#infocustomerphone').html(value.PhoneNumber+",    "+value.OfficePhone);
                        $('#infocustomeremail').html(value.EmailAddress);

                        $('#prdinfocustomercode').html(value.CustomerCode);
                        $('#prdinfocustomername').html(value.CustomerName);
                        $('#prdinfocustomertin').html(value.TinNumber);
                        $('#prdinfocustomerphone').html(value.PhoneNumber+",    "+value.OfficePhone);
                        $('#prdinfocustomeremail').html(value.EmailAddress);
                    });
                },
            });

            $(".detailscls").hide();
            $("#prdcomstockbalancetbl").hide();
            $('#prdcomstockbalancetbl').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                paging: false,
                searching: true,
                info: false,
                searchHighlight: true,
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
                    url: "{{url('fetchValueAllocData')}}",
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
                    data:{
                        commodityidpost:comm,
                        storeidpost:str,
                        locationidpost:flrmap,
                        commoditytypepost:commtype,

                        gradepost:grade,
                        processtypepost:prctype,
                        cropyearpost:crpyr,
                        uomidpost:uomid,

                        customeridpost:cusid,
                    },
                    dataType: "json",
                },
                columns: [
                    {
                        data:'DT_RowIndex',
                        width:"3%"
                    },
                    {
                        data: 'DocumentNumber',
                        name: 'DocumentNumber',
                        width:"10%"
                    },
                    {
                        data: 'StoreName',
                        name: 'StoreName',
                        width:"10%"
                    },
                    {
                        data: 'CommodityType',
                        name: 'CommodityType',
                        width:"9%"
                    },
                    {
                        data: 'Grade',
                        name: 'Grade',
                        width:"9%"
                    },
                    {
                        data: 'ProcessType',
                        name: 'ProcessType',
                        width:"9%"
                    },
                    {
                        data: 'CropYear',
                        name: 'CropYear',
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
                        width:"8%"
                    },
                    {
                        data: 'NetKg',
                        name: 'NetKg',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"8%"
                    },
                    {
                        data: 'TON',
                        name: 'TON',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"8%"
                    },
                    {
                        data: 'Feresula',
                        name: 'Feresula',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"8%"
                    },
                    {
                        data: 'RecType',
                        name: 'RecType',
                        'visible': false
                    }, 
                    {
                        data: 'Ord',
                        name: 'Ord',
                        'visible': false
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
                rowGroup: {
                    startRender: function ( rows, group,level ) {
                        var colorA = 'style="color:black;font-weight:bold;background:#cccccc;"';
                        if(level===0){
                            return $('<tr ' + colorA + '>')
                            .append('<td colspan="12" style="text-align:left;"><b>' + group + ' </b></td></tr>')
                        }
                                                
                    },
                    endRender: function ( rows, group,level ) {
                        var colorA = 'style="color:black;font-weight:bold;background:#cccccc;"';
                        var intVal = function ( i ) {
                            return typeof i === 'string' ?
                                i.replace(/[\$,]/g, '')*1 :
                                typeof i === 'number' ?
                                        i : 0;
                        };

                        var totalnumofbag = rows
                            .data()
                            .pluck('NumOfBag')
                            .reduce(function (a, b) {
                                return intVal(a) + intVal(b);
                        }, 0);

                        var totalnetkg = rows
                            .data()
                            .pluck('NetKg')
                            .reduce(function (a, b) {
                                return intVal(a) + intVal(b);
                        }, 0);

                        var totalton = rows
                            .data()
                            .pluck('TON')
                            .reduce(function (a, b) {
                                return intVal(a) + intVal(b);
                        }, 0);

                        var totalferesula = rows
                            .data()
                            .pluck('Feresula')
                            .reduce(function (a, b) {
                                return intVal(a) + intVal(b);
                        }, 0);

                        totalnumofbag=totalnumofbag === 0 ? '' : numformat(parseFloat(totalnumofbag));
                        totalnetkg=totalnetkg === 0 ? '' : numformat(parseFloat(totalnetkg).toFixed(2));
                        totalton=totalton === 0 ? '' : numformat(parseFloat(totalton).toFixed(2));
                        totalferesula=totalferesula === 0 ? '' : numformat(parseFloat(totalferesula).toFixed(2));

                        if(level===0){
                            return $('<tr ' + colorA + '>')
                                .append('<td colspan="8" style="text-align:right;"><b>Total of: ' + group + ' </b></td>')
                                .append('<td style="text-align:left;">'+ totalnumofbag+'</td>')
                                .append('<td style="text-align:left;">'+ totalnetkg+'</td>')
                                .append('<td style="text-align:left;">'+totalton+'</td>')
                                .append('<td style="text-align:left;">'+totalferesula+'</td></tr>');
                        }
                    },
                    dataSrc: ['RecType']
                },
                drawCallback: function(settings) {
                    var api = this.api();
                    var currentIndex = 1;
                    var currentGroup = null;
                    api.rows({ page: 'current', search: 'applied' }).every(function() {
                        var rowData = this.data();
                        if (rowData) {
                            var group = rowData['RecType']; // Assuming 'group_column' is the name of the column used for grouping
                            if (group !== currentGroup) {
                                currentIndex = 1; // Reset index for a new group
                                currentGroup = group;
                            }
                            $(this.node()).find('td:first').text(currentIndex++);
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

                    var totalbagnumber = api
                    .column(8)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totalavailablebal = api
                    .column(9)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totalavailableton = api
                    .column(10)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totalavailableferesula = api
                    .column(11)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    $('#prdtotalbagnumber').html(totalbagnumber=totalbagnumber === 0 ? '' : numformat(parseInt(totalbagnumber)));
                    $('#prdtotalbalanceinfo').html(totalavailablebal=totalavailablebal === 0 ? '' : numformat(parseFloat(totalavailablebal).toFixed(2)));
                    $('#prdtotalbalancetoninfo').html(totalavailableton=totalavailableton === 0 ? '' : numformat(parseFloat(totalavailableton).toFixed(2)));
                    $('#prdtotalbalanceferesulainfo').html(totalavailableferesula=totalavailableferesula === 0 ? '' : numformat(parseFloat(totalavailableferesula).toFixed(2)));
                },
                drawCallback: function() {
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
                    $("#prdcomstockbalancetbl").show();
                },
            });
            $("#detailinfomodaltitle").html("Allocated Amount Information");
            $("#productiondiv").show();
            
            
            $(".infoprd").collapse('show');
            $("#allocationmodal").modal('show');
        }

        function numformat(val){
            while (/(\d+)(\d{3})/.test(val.toString())){
                val = val.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
            }
            return val;
        }

    </script>
@endsection