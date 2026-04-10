@extends('layout.app1')
@section('title')
@endsection
@section('content')
@can('Good-Receiving-View')
    <div class="app-content content">
        <form id="receivingreportform">
        @csrf
            <section id="responsive-header">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h3 class="card-title">Good Receiving Report</h3>
                            </div>
                            <div class="card-datatable">
                                <div style="width:100%;">
                                    <div style="width:98%; margin-left:1%; margin-top:1%;">
                                        <div class="row">
                                            <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 mb-1">
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
                                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 mb-1">
                                                <label style="font-size: 14px;color">Select Date Range</label>
                                                <div class="input-group input-group-merge">
                                                    <span class="input-group-text" id="calendaricon" style="border-right-color: #FFFFFF;"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                                    <input type="text" id="daterange" name="daterange" class="form-control" aria-describedby="calendaricon" placeholder="Select fiscal year first" style="background-color: #FFFFFF" readonly/>
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
                                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 mb-1">
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
                                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 mb-1">
                                                <label style="font-size: 14px;color">Supplier <i>(Supplier Name , TIN)</i></label>
                                                <select class="selectpicker form-control dropdownclass errorerase" id="supplier" name="supplier" title="Select supplier here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" multiple="multiple" data-actions-box="true" data-selected-text-format="count" data-count-selected-text="Supplier ({0})"></select>
                                                <span class="text-danger">
                                                    <strong id="supplier-error" class="errorclass"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 mb-1">
                                                <label style="font-size: 14px;color">Reference</label>
                                                <select class="selectpicker form-control dropdownclass errorerase" id="reference" name="reference" title="Select reference here..." data-style="btn btn-outline-secondary waves-effect" multiple="multiple" data-actions-box="true"></select>
                                                <span class="text-danger">
                                                    <strong id="reference-error" class="errorclass"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 mb-1">
                                                <label style="font-size: 14px;color">Receiving/ GRV No.</label>
                                                <select class="selectpicker form-control dropdownclass errorerase" id="receivingno" name="receivingno" title="Select receiving number here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" multiple="multiple" data-actions-box="true" data-selected-text-format="count" data-count-selected-text="Receiving/ GRV No. ({0})"></select>
                                                <span class="text-danger">
                                                    <strong id="receiving-error" class="errorclass"></strong>
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
                                            <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 mb-1">
                                                <label style="font-size: 14px;color">Receiving Status</label>
                                                <select class="selectpicker form-control dropdownclass errorerase" id="status" name="status" title="Select status here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" multiple="multiple" data-actions-box="true" data-selected-text-format="count" data-count-selected-text="Status ({0})"></select>
                                                <span class="text-danger">
                                                    <strong id="status-error" class="errorclass"></strong>
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
                                                <label style="font-size: 14px;color">Commodity Source</label>
                                                <select class="selectpicker form-control dropdownclass errorerase" id="commoditysource" name="commoditysource" title="Select commodity source here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" multiple="multiple" data-actions-box="true" data-selected-text-format="count" data-count-selected-text="Commodity Source ({0})"></select>
                                                <span class="text-danger">
                                                    <strong id="commoditysource-error" class="errorclass"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 mb-1">
                                                <label style="font-size: 14px;color">Commodity Status</label>
                                                <select class="selectpicker form-control dropdownclass errorerase" id="commoditystatus" name="commoditystatus" title="Select commodity status here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" multiple="multiple" data-actions-box="true" data-selected-text-format="count" data-count-selected-text="Commodity Status ({0})"></select>
                                                <span class="text-danger">
                                                    <strong id="commoditystatus-error" class="errorclass"></strong>
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
                                                                    <li> <a id="downloatoexcel" class="dropdown-item" href="javascript:void(0);"><i class="fa-solid fa-file-excel"></i> To Excel</a></li>
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
                                                <select class="selectpicker form-control" id="companytypedefault" name="companytypedefault" title="Select company type here..." data-style="btn btn-outline-secondary waves-effect">
                                                    @foreach ($comptype as $comptype)
                                                        <option value="{{ $comptype->CompanyTypeValue }}" title="{{$comptype->ReceivedDate}}" data-content="{{$comptype->CompanyType}}">{{ $comptype->CompanyType }}</option>
                                                    @endforeach
                                                </select>
                                                <select class="selectpicker form-control" id="storedefault" name="storedefault" title="Select store/station here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true">
                                                    @foreach ($store as $store)
                                                        <option value="{{ $store->StoreId }}" title="{{$store->CompanyType}}">{{ $store->Name }}</option>
                                                    @endforeach    
                                                </select>
                                                <select class="selectpicker form-control" id="producttypedefault" name="producttypedefault" title="Select product type here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true">
                                                    @foreach ($producttype as $producttype)
                                                        <option value="{{ $producttype->ProductType }}" title="{{$producttype->StoreId}}">{{ $producttype->ProductType }}</option>
                                                    @endforeach    
                                                </select>
                                                <select class="selectpicker form-control" id="supplierdefault" name="supplierdefault" title="Select supplier here..." multiple="multiple" data-style="btn btn-outline-secondary waves-effect" data-live-search="true" data-selected-text-format="count" data-count-selected-text="Supplier(s) ({0})">
                                                    @foreach ($supplier as $supplier)
                                                        <option value="{{ $supplier->CustomerId }}" title="{{ $supplier->DataProp}}">{{ $supplier->SupplierName }}</option>
                                                    @endforeach    
                                                </select>
                                                <select class="selectpicker form-control" id="referencedefault" name="referencedefault" title="Select reference here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true">
                                                    @foreach ($referece as $referece)
                                                        <option value="{{ $referece->ReceivingTypeValue }}" title="{{$referece->DataProp }}">{{ $referece->ReceivingType }}</option>
                                                    @endforeach    
                                                </select>
                                                <select class="selectpicker form-control" id="receivingnodefault" name="receivingnodefault" title="Select receiving number here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" data-selected-text-format="count" data-count-selected-text="Receiving No. ({0})">
                                                    @foreach ($receivingnum as $receivingnum)
                                                        <option value="{{ $receivingnum->id }}" title="{{$receivingnum->DataProp}}">{{ $receivingnum->DocumentNumber }}</option>
                                                    @endforeach    
                                                </select>
                                                <select class="selectpicker form-control" id="commoditydefault" name="commoditydefault" title="Select commodity number here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" data-selected-text-format="count" data-count-selected-text="Commodity ({0})">
                                                    @foreach ($commodity as $commodity)
                                                        <option value="{{ $commodity->CommodityId }}" title="{{$commodity->HeaderId}}">{{ $commodity->Origin }}</option>
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
                                                <select class="selectpicker form-control" id="statusdefault" name="statusdefault" title="Select status here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" data-selected-text-format="count" data-count-selected-text="Status ({0})">
                                                    @foreach ($status as $status)
                                                        <option value="{{ $status->StatusVal }}" title="{{$status->id}}">{{ $status->Status }}</option>
                                                    @endforeach    
                                                </select>
                                                <select class="selectpicker form-control" id="commoditytypedefault" name="commoditytypedefault" title="Select commodity type here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" data-selected-text-format="count" data-count-selected-text="Commodity Type ({0})">
                                                    @foreach ($commtype as $commtype)
                                                        <option value="{{ $commtype->CommodityType }}" title="{{$commtype->DataProp}}">{{ $commtype->CommodityType }}</option>
                                                    @endforeach    
                                                </select>
                                                <select class="selectpicker form-control" id="commoditysourcedefault" name="commoditysourcedefault" title="Select commodity source here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" data-selected-text-format="count" data-count-selected-text="Commodity Type ({0})">
                                                    @foreach ($commsource as $commsource)
                                                        <option value="{{ $commsource->CommoditySource }}" title="{{$commsource->DataProp}}">{{ $commsource->CommoditySource }}</option>
                                                    @endforeach    
                                                </select>
                                                <select class="selectpicker form-control" id="commoditystatusdefault" name="commoditystatusdefault" title="Select commodity status here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" data-selected-text-format="count" data-count-selected-text="Commodity Type ({0})">
                                                    @foreach ($commstatus as $commstatus)
                                                        <option value="{{ $commstatus->CommodityStatus }}" title="{{$commstatus->DataProp}}">{{ $commstatus->CommodityStatus }}</option>
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
                                                <table id="receivingreporttable" class="display table-bordered defaultdatatable nowrap" style="text-align:left;width: 100%">
                                                    <thead>
                                                        <tr style="color:white; border: 0.1px solid black;">
                                                            <th style="width:2%;color:white; border: 0.1px solid white;background-color:#00cfe8;border-left:1px solid black" title="No.">#</th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Store/ Station">Store/ Station</th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Floor Map">Floor Map</th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Commodity Type">Commodity Type</th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Commodity">Commodity</th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Grade">Grade</th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Crop Year">Crop Year</th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Process Type">Process Type</th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="UOM/ Bag">UOM/ Bag</th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Number of Bag">No. of Bag</th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Bag Weight by KG">Bag Weight</th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Total KG">Total KG</th>
                                                            <th style="width:4%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="TON">TON</th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Feresula">Feresula</th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Net KG">Net KG</th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Unit Cost">Unit Cost <label id="unitcostdesc" style="color: #FFFFFF" title="Per Net KG"><i class="fa-solid fa-circle-info"></i></label></th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Total Cost">Total Cost <label id="totalcostdisc" style="color: #FFFFFF" title="Total Cost= Unit Cost * Net KG"><i class="fa-solid fa-circle-info"></i></label></th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Variance Shortage">Variance Shortage</th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Variance Overage">Variance Overage</th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Remark">Remark</th>
                                                            <th style="width:4%;color:white; border: 0.1px solid white;background-color:#00cfe8;border-right:1px solid black" title="Receiving Status">Receiving Status</th>
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
                                                            <th colspan="9" style="text-align: right;border: 1px solid black;">Grand Total</th>
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
            var divToPrintBody = document.getElementById("receivingreporttable");
            var htmlToPrint = `<html>
                <head>
                    <title>Good Receiving Report</title>
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
                                        <h3><p style="color:#00cfe8;padding-top:8px;"><b>Good Receiving Report</b></p></h3>
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
            let daterange=$('#daterange').val();
            let spliteddate = daterange.split(' - ');
            let fromdate=moment(spliteddate[0], 'MMMM DD, YYYY').format('YYYY-MM-DD');
            let todate=moment(spliteddate[1], 'MMMM DD, YYYY').format('YYYY-MM-DD');

            var table = document.getElementById("receivingreporttable");
            var workbook = new ExcelJS.Workbook();
            var worksheet = workbook.addWorksheet("Good_Receiving_Report");

            let mergeCells = [];
            let maxColumnWidths = {}; // Store max column widths

            let titleRow = worksheet.addRow(["Good Receiving Report ("+fromdate+" to "+todate+")"]);
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
                saveAs(blob,"Good_Receiving_Report_from_"+fromdate+"_to_"+todate+".xlsx");
            });
        });

        $("#downloadtopdf").click(function () {
            let daterange=$('#daterange').val();
            let spliteddate = daterange.split(' - ');
            let fromdate=moment(spliteddate[0], 'MMMM DD, YYYY').format('YYYY-MM-DD');
            let todate=moment(spliteddate[1], 'MMMM DD, YYYY').format('YYYY-MM-DD');

            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            let headers = [];
            let bodyData = [];
            let mergeCells = [];

            // Get headers (handling colspan for headers)
            $("#receivingreporttable thead tr").each(function () {
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
            $("#receivingreporttable tbody tr").each(function (rowIndex) {
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

            $("#receivingreporttable tfoot tr").each(function (rowIndex) {
                let rowData = [];
                let colIndexOffset = 0;

                $(this).find("th").each(function (colIndex) {
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
            const titleText = "Good Receiving Report ("+fromdate+" to "+todate+")";
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

            doc.save("Good_Receiving_Report_from_"+fromdate+"_to_"+todate+".pdf");
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
                minDate: moment(startdaterange,'YYYY-MM-DD'),
                maxDate: moment(enddaterange,'YYYY-MM-DD'),   
                showDropdowns:true, 
                linkedCalendars:true,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                    'Last 6 months': [moment().subtract(179, 'days'), moment()],
                    'Last 9 months': [moment().subtract(270, 'days'), moment()],
                    'This Year': [moment().startOf('year'), moment().endOf('year')],
                    'Selected Fiscal Year': [moment(startdaterange,'YYYY-MM-DD'), moment(enddaterange,'YYYY-MM-DD')]
                },
                locale: {
                    format: 'MMMM DD, YYYY',
                    cancelLabel: 'Clear'
                }
            }, function(start, end, label) { 
                dateRangeChange(start,end);
            });  
            $('#daterange').val("");
            $('#daterange').attr('placeholder', 'Select date range here');
        }

        function dateRangeChange(start,end){
            var startdate = moment(start,'YYYY-MM-DD').format('YYYY-MM-DD');
            var enddate = moment(end,'YYYY-MM-DD').format('YYYY-MM-DD');
            var defaultoption = '<option selected disabled value=""></option>';
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

        function getStore(compvalue){
            const comptypearr=[];
            var storeValueArr = [];
            $('#store').empty(); 
            comptypearr.push(compvalue);

            var storeoption = $("#storedefault > option").clone();
            $('#store').append(storeoption); 
            $('#store option').each(function () {
                var optionTitle = $(this).attr('title'); 
                var value = $(this).val();
                var duplicates = $('#store option[value="' + value + '"]');
                
                if (!comptypearr.includes(optionTitle)) {
                    $(this).remove(); 
                }
                if (storeValueArr.includes($(this).val())) {
                    $(this).remove(); 
                }
                if($(this).val()==null || $(this).val()=="" || $(this).val()===""){
                    $(this).remove(); 
                }
                $(this).removeAttr('title');

                if (comptypearr.includes(optionTitle)) {
                    storeValueArr.push($(this).val()); 
                }
            });
            $('#store').selectpicker('refresh');
        }

        function getProductType(storevalue){
            var storevaluearr=JSON.stringify(storevalue);
            var productTypeValueArr = [];
            $('#producttype').empty(); 
            var producttypeoption = $("#producttypedefault > option").clone();
            $('#producttype').append(producttypeoption); 
            $('#producttype option').each(function () { 
                var optionTitle = $(this).attr('title'); 
                var value = $(this).val();
                
                if (!storevaluearr.includes(optionTitle)) {
                   $(this).remove(); 
                }
                if (productTypeValueArr.includes($(this).val())) {
                    $(this).remove(); 
                }
                if($(this).val()==null || $(this).val()=="" || $(this).val()===""){
                    $(this).remove(); 
                }
                $(this).removeAttr('title');

                if (storevaluearr.includes(optionTitle)) {
                    productTypeValueArr.push($(this).val()); 
                }
            });
            $('#producttype').selectpicker('refresh');
        }

        function getSupplier(producttypeval){
            let compvalue=$('#companytype').val(); 
            const companytypeval=[];
            companytypeval.push(compvalue);
            let storeval=$('#store').val(); 
            const allCombinations = [];
            var supplierValueArr = [];

            companytypeval.forEach(a1 => {
                storeval.forEach(a2 => {
                    producttypeval.forEach(a3 => {
                        allCombinations.push(a1 + a2 + a3);
                    });
                });
            });
            
            $('#supplier').empty(); 
            var supplierdata = $("#supplierdefault > option").clone();
            $('#supplier').append(supplierdata); 
            $('#supplier option').each(function () {
                var optionTitle = $(this).attr('title'); 
                var value = $(this).val();

                if (!allCombinations.includes(optionTitle)) {
                    $(this).remove(); 
                }
                if (supplierValueArr.includes($(this).val())) {
                    $(this).remove(); 
                }
                if($(this).val()==null || $(this).val()=="" || $(this).val()===""){
                    $(this).remove(); 
                }
                $(this).removeAttr('title');

                if (allCombinations.includes(optionTitle)) {
                    supplierValueArr.push($(this).val()); 
                }
            });
            $('#supplier').selectpicker('refresh');
        }

        function getReference(supplierval){
            let producttypeval=$('#producttype').val();
            let compvalue=$('#companytype').val(); 
            const companytypeval=[];
            companytypeval.push(compvalue);
            let storeval=$('#store').val(); 
            const allCombinations = [];
            var refernceValueArr = [];

            companytypeval.forEach(a1 => {
                storeval.forEach(a2 => {
                    producttypeval.forEach(a3 => {
                        supplierval.forEach(a4 => {
                            allCombinations.push(a1 + a2 + a3 + a4);
                        });
                    });
                });
            });
            $('#reference').empty(); 
            var referencedata = $("#referencedefault > option").clone();
            $('#reference').append(referencedata); 
            $('#reference option').each(function () {
                var optionTitle = $(this).attr('title'); 
                var value = $(this).val();

                if (!allCombinations.includes(optionTitle)) {
                    $(this).remove(); 
                }
                if (refernceValueArr.includes($(this).val())) {
                    $(this).remove(); 
                }
                if($(this).val()==null || $(this).val()=="" || $(this).val()===""){
                    $(this).remove(); 
                }
                $(this).removeAttr('title');

                if (allCombinations.includes(optionTitle)) {
                    refernceValueArr.push($(this).val()); 
                }
            });
            $('#reference').selectpicker('refresh');
        }

        function getReceivingNo(referenceval){
            let supplierval=$('#supplier').val();
            let producttypeval=$('#producttype').val();
            let compvalue=$('#companytype').val(); 
            const companytypeval=[];
            companytypeval.push(compvalue);
            let storeval=$('#store').val(); 
            const allCombinations = [];
            var receivingnoValueArr = [];

            companytypeval.forEach(a1 => {
                storeval.forEach(a2 => {
                    producttypeval.forEach(a3 => {
                        supplierval.forEach(a4 => {
                            referenceval.forEach(a5 => {
                                allCombinations.push(a1 + a2 + a3 + a4 + a5);
                            });
                        });
                    });
                });
            });

            $('#receivingno').empty(); 
            var receivingoptiondata = $("#receivingnodefault > option").clone();
            $('#receivingno').append(receivingoptiondata); 
            $('#receivingno option').each(function () {
                var optionTitle = $(this).attr('title'); 
                var value = $(this).val();

                if (!allCombinations.includes(optionTitle)) {
                    $(this).remove(); 
                }
                if (receivingnoValueArr.includes($(this).val())) {
                    $(this).remove(); 
                }
                if($(this).val()==null || $(this).val()=="" || $(this).val()===""){
                    $(this).remove(); 
                }
                $(this).removeAttr('title');

                if (allCombinations.includes(optionTitle)) {
                    receivingnoValueArr.push($(this).val()); 
                }
            });
            $('#receivingno').selectpicker('refresh');

        }

        function getReceivingData(receivingnoval){
            let referenceval = $('#reference').val();
            const allCombinations = [];
            const allRecCombinations = [];
            var commodityValueArr = [];
            var statusValueArr = [];
            var commtypeValueArr = [];
            var commsrcValueArr = [];
            var commstatusValueArr = [];

            receivingnoval.forEach(a1 => { 
                allCombinations.push(a1);
            });

            receivingnoval.forEach(b1 => { 
                referenceval.forEach(b2 => { 
                    allRecCombinations.push(b1 + b2);
                });
            });

            $('#commodity').empty(); 
            var commodityoptiondata = $("#commoditydefault > option").clone();
            $('#commodity').append(commodityoptiondata); 
            $('#commodity option').each(function () {
                var optionTitle = $(this).attr('title'); 
                var value = $(this).val();

                if (!allCombinations.includes(optionTitle)) {
                    $(this).remove(); 
                }
                if (commodityValueArr.includes($(this).val())) {
                    $(this).remove(); 
                }
                if($(this).val()==null || $(this).val()=="" || $(this).val()===""){
                    $(this).remove(); 
                }
                $(this).removeAttr('title');

                if (allCombinations.includes(optionTitle)) {
                    commodityValueArr.push($(this).val()); 
                }
            });

            $('#status').empty(); 
            var statusoptiondata = $("#statusdefault > option").clone();
            $('#status').append(statusoptiondata);
            $('#status option').each(function () {
                var statusOptionTitle = $(this).attr('title'); 
                var value = $(this).val();

                if (!allCombinations.includes(statusOptionTitle)) {
                    $(this).remove(); 
                }
                if (statusValueArr.includes($(this).val())) {
                    $(this).remove(); 
                }
                if($(this).val()==null || $(this).val()=="" || $(this).val()===""){
                    $(this).remove(); 
                }
                $(this).removeAttr('title');

                if (allCombinations.includes(statusOptionTitle)) {
                    statusValueArr.push($(this).val()); 
                }
            });

            $('#commoditytype').empty(); 
            var commoditytypeoptiondata = $("#commoditytypedefault > option").clone();
            $('#commoditytype').append(commoditytypeoptiondata);
            $('#commoditytype option').each(function () {
                var commOptionTitle = $(this).attr('title'); 
                var value = $(this).val();

                if (!allRecCombinations.includes(commOptionTitle)) {
                    $(this).remove(); 
                }
                if (commtypeValueArr.includes($(this).val())) {
                    $(this).remove(); 
                }
                if($(this).val()==null || $(this).val()=="" || $(this).val()===""){
                    $(this).remove(); 
                }
                $(this).removeAttr('title');

                if (allRecCombinations.includes(commOptionTitle)) {
                    commtypeValueArr.push($(this).val()); 
                }
            });

            $('#commoditysource').empty(); 
            var commoditysourceoptiondata = $("#commoditysourcedefault > option").clone();
            $('#commoditysource').append(commoditysourceoptiondata);
            $('#commoditysource option').each(function () {
                var commsrcOptionTitle = $(this).attr('title'); 
                var value = $(this).val();

                if (!allRecCombinations.includes(commsrcOptionTitle)) {
                    $(this).remove(); 
                }
                if (commsrcValueArr.includes($(this).val())) {
                    $(this).remove(); 
                }
                if($(this).val()==null || $(this).val()=="" || $(this).val()===""){
                    $(this).remove(); 
                }
                $(this).removeAttr('title');

                if (allRecCombinations.includes(commsrcOptionTitle)) {
                    commsrcValueArr.push($(this).val()); 
                }
            });

            $('#commoditystatus').empty();
            var commoditystatusoptiondata = $("#commoditystatusdefault > option").clone();
            $('#commoditystatus').append(commoditystatusoptiondata);
            $('#commoditystatus option').each(function () {
                var commstatusOptionTitle = $(this).attr('title'); 
                var value = $(this).val();

                if (!allRecCombinations.includes(commstatusOptionTitle)) {
                    $(this).remove(); 
                }
                if (commstatusValueArr.includes($(this).val())) {
                    $(this).remove(); 
                }
                if($(this).val()==null || $(this).val()=="" || $(this).val()===""){
                    $(this).remove(); 
                }
                $(this).removeAttr('title');

                if (allRecCombinations.includes(commstatusOptionTitle)) {
                    commstatusValueArr.push($(this).val()); 
                }
            });

            $('#commodity').selectpicker('refresh');
            $('#status').selectpicker('refresh');
            $('#commoditytype').selectpicker('refresh');
            $('#commoditysource').selectpicker('refresh');
            $('#commoditystatus').selectpicker('refresh');
        }

        function getGradeData(commodityval){
            let receivingnoval = $('#receivingno').val();
            const allCombinations = [];
            var gradeValueArr = [];

            receivingnoval.forEach(a1 => { 
                commodityval.forEach(a2 => {
                    allCombinations.push(a1 + a2);
                });
            });

            $('#grade').empty(); 
            var gradeoptiondata = $("#gradedefault > option").clone();
            $('#grade').append(gradeoptiondata); 
            $('#grade option').each(function () { 
                var optionTitle = $(this).attr('title'); 
                var value = $(this).val();

                if (!allCombinations.includes(optionTitle)) {
                    $(this).remove(); 
                }
                if (gradeValueArr.includes($(this).val())) {
                    $(this).remove(); 
                }
                if($(this).val()==null || $(this).val()=="" || $(this).val()===""){
                    $(this).remove(); 
                }
                $(this).removeAttr('title');

                if (allCombinations.includes(optionTitle)) {
                    gradeValueArr.push($(this).val()); 
                }
            });
            $('#grade').selectpicker('refresh');
        }

        function getProcessType(gradeval){
            let commodityval = $('#commodity').val();
            let receivingnoval = $('#receivingno').val();
            const allCombinations = [];
            var processValueArr = [];

            receivingnoval.forEach(a1 => { 
                commodityval.forEach(a2 => {
                    gradeval.forEach(a3 => {
                        allCombinations.push(a1 + a2 + a3);
                    });
                });
            });

            $('#processtype').empty(); 
            var processtypeoptiondata = $("#processtypedefault > option").clone();
            $('#processtype').append(processtypeoptiondata); 
            $('#processtype option').each(function () { 
                var optionTitle = $(this).attr('title'); 
                var value = $(this).val();

                if (!allCombinations.includes(optionTitle)) {
                    $(this).remove(); 
                }
                if (processValueArr.includes($(this).val())) {
                    $(this).remove(); 
                }
                if($(this).val()==null || $(this).val()=="" || $(this).val()===""){
                    $(this).remove(); 
                }
                $(this).removeAttr('title');

                if (allCombinations.includes(optionTitle)) {
                    processValueArr.push($(this).val()); 
                }
            });
            $('#processtype').selectpicker('refresh');
        }

        function getCropYear(processtypeval){
            let gradeval = $('#grade').val();
            let commodityval = $('#commodity').val();
            let receivingnoval = $('#receivingno').val();
            const allCombinations = [];
            var cropyearValueArr = [];

            receivingnoval.forEach(a1 => { 
                commodityval.forEach(a2 => {
                    gradeval.forEach(a3 => {
                        processtypeval.forEach(a4 => {
                            allCombinations.push(a1 + a2 + a3 + a4);
                        });
                    });
                });
            });

            $('#cropyear').empty(); 
            var cropyearoptiondata = $("#cropyeardefault > option").clone();
            $('#cropyear').append(cropyearoptiondata); 
            $('#cropyear option').each(function () { 
                var optionTitle = $(this).attr('title'); 
                var value = $(this).val();

                if (!allCombinations.includes(optionTitle)) {
                    $(this).remove(); 
                }
                if (cropyearValueArr.includes($(this).val())) {
                    $(this).remove(); 
                }
                if($(this).val()==null || $(this).val()=="" || $(this).val()===""){
                    $(this).remove(); 
                }
                $(this).removeAttr('title');

                if (allCombinations.includes(optionTitle)) {
                    cropyearValueArr.push($(this).val()); 
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
            var flg=1;
            getDateRange(startdaterange,enddaterange);
        });

        $('#companytype').change(function() { 
            var compvalue = $(this).val();
            getStore(compvalue);
        });

        $('#store').change(function() { 
            var storevalue = $(this).val();
            getProductType(storevalue);
        });

        $('#producttype').change(function() { 
            let producttypeval = $(this).val();
            getSupplier(producttypeval);
        });

        $('#supplier').change(function() { 
            let supplier = $(this).val();
            getReference(supplier);
        });

        $('#reference').change(function() { 
            let referenceval = $(this).val();
            getReceivingNo(referenceval);
        });

        $('#receivingno').change(function() { 
            let receivingnoval = $(this).val();
            getReceivingData(receivingnoval);
        });

        $('#commodity').change(function() { 
            let commodityval = $(this).val();
            getGradeData(commodityval);
        });

        $('#grade').change(function() { 
            let gradeval = $(this).val();
            getProcessType(gradeval);
        });

        $('#processtype').change(function() { 
            let processtypeval = $(this).val();
            getCropYear(processtypeval);
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
                        dateRangeChange(startdaterange,enddaterange);
                        $('#daterange').val(moment(startdaterange,'YYYY-MM-DD').format('MMMM DD, YYYY') + ' - ' + moment(enddaterange,'YYYY-MM-DD').format('MMMM DD, YYYY'));
                        $('#companytype').find('option').prop('selected', true);
                        
                        $("#companytype option[value=1]").remove(); 
                        var defaultcomptypeopt = '<option selected value=1>Owner</option>';
                        $('#companytype').append(defaultcomptypeopt); 
                        
                        var comptype=$('#companytype').val();
                        getStore(comptype);

                        $('#store').find('option').prop('selected', true);
                        var stores=$('#store').val();
                        getProductType(stores);

                        $('#producttype').find('option').prop('selected', true);
                        var producttype=$('#producttype').val();
                        getSupplier(producttype);

                        $('#supplier').find('option').prop('selected', true);
                        var supplier=$('#supplier').val();
                        getReference(supplier);

                        $('#reference').find('option').prop('selected', true);
                        var reference=$('#reference').val();
                        getReceivingNo(reference);

                        $('#receivingno').find('option').prop('selected', true);
                        var receivingno=$('#receivingno').val();
                        getReceivingData(receivingno);

                        $('#commodity').find('option').prop('selected', true);
                        var commodity=$('#commodity').val();
                        getGradeData(commodity);

                        $('#grade').find('option').prop('selected', true);
                        var grade=$('#grade').val();
                        getProcessType(grade);

                        $('#processtype').find('option').prop('selected', true);
                        var processtype=$('#processtype').val();
                        getCropYear(processtype);

                        $('#cropyear').find('option').prop('selected', true);
                        
                        $('#status').find('option').prop('selected', true);
                        $('#commoditytype').find('option').prop('selected', true);
                        $('#commoditysource').find('option').prop('selected', true);
                        $('#commoditystatus').find('option').prop('selected', true);
                        
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
            var registerForm = $('#receivingreportform');
            var formData = registerForm.serialize();

            $.ajax({ 
                url: "{{url('receivingReport')}}",
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
                    if(data.errors)
                    {
                        if (data.errors.fiscalyear) {
                            var text=data.errors.fiscalyear[0];
                            text = text.replace("fiscalyear", "fiscal year");
                            $('#fiscalyear-error').html(text);
                        }
                        if (data.errors.daterange) {
                            var text=data.errors.daterange[0];
                            text = text.replace("daterange", "date range");
                            $('#daterange-error').html(text);
                        }
                        if (data.errors.companytype) {
                            var text=data.errors.companytype[0];
                            text = text.replace("companytype", "company type");
                            $('#companytype-error').html(text);
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
                        if (data.errors.supplier) {
                            $('#supplier-error').html(data.errors.supplier[0]);
                        }
                        if (data.errors.reference) {
                            $('#reference-error').html(data.errors.reference[0]);
                        }
                        if (data.errors.receivingno) {
                            var text=data.errors.receivingno[0];
                            text = text.replace("receivingno", "receiving/ grv no.");
                            $('#receiving-error').html(text);
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
                        if (data.errors.status) {
                            var text=data.errors.status[0];
                            text = text.replace("status", "receiving status");
                            $('#status-error').html(text);
                        }
                        if (data.errors.commoditytype) {
                            var text=data.errors.commoditytype[0];
                            text = text.replace("commoditytype", "commodity type");
                            $('#commoditytype-error').html(text);
                        }
                        if (data.errors.commoditysource) {
                            var text=data.errors.commoditysource[0];
                            text = text.replace("commoditysource", "commodity source");
                            $('#commoditysource-error').html(text);
                        }
                        if (data.errors.commoditystatus) {
                            var text=data.errors.commoditystatus[0];
                            text = text.replace("commoditystatus", "commodity status");
                            $('#commoditystatus-error').html(text);
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
                        let daterange=$('#daterange').val();
                        let spliteddate = daterange.split(' - ');
                        let fromdate=moment(spliteddate[0], 'MMMM DD, YYYY').format('YYYY-MM-DD');
                        let todate=moment(spliteddate[1], 'MMMM DD, YYYY').format('YYYY-MM-DD');

                        var fiscalyearpost="";
                        var startdatepost="";
                        var enddatepost="";
                        var companytypepost="";
                        var storepost="";

                        var producttypepost="";
                        var supplierpost="";
                        var referencepost="";
                        var receivingpost="";

                        var commoditypost="";
                        var gradepost="";
                        var processtypepost="";
                        var cropyearpost="";

                        var receivingstatuspost="";
                        var commoditytypepost="";
                        var commoditysourcepost="";
                        var commoditystatuspost="";

                        var table = $("#receivingreporttable").DataTable({ 
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
                                url: "{{url('receivingDataFetch')}}",
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
                                    storepost: $('#store').val(),
                                    producttypepost: $('#producttype').val(),
                                    supplierpost: $('#supplier').val(),
                                    referencepost: $('#reference').val(),
                                    receivingpost: $('#receivingno').val(),
                                    commoditypost: $('#commodity').val(),
                                    gradepost: $('#grade').val(),
                                    processtypepost: $('#processtype').val(),
                                    cropyearpost: $('#cropyear').val(),
                                    receivingstatuspost: $('#status').val(),
                                    commoditytypepost: $('#commoditytype').val(),
                                    commoditysourcepost: $('#commoditysource').val(),
                                    commoditystatuspost: $('#commoditystatus').val(),
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
                                    data: 'CommType',
                                    name: 'CommType',
                                    width:"5%"
                                },
                                {
                                    data: 'Commodity',
                                    name: 'Commodity',
                                    width:"5%"
                                },
                                {
                                    data: 'Grade',
                                    name: 'Grade',
                                    width:"5%"
                                },
                                {
                                    data: 'CropYear',
                                    name: 'CropYear',
                                    width:"5%"
                                },
                                {
                                    data: 'ProcessType',
                                    name: 'ProcessType',
                                    width:"5%"
                                },
                                {
                                    data: 'UOM',
                                    name: 'UOM',
                                    width:"5%"
                                },
                                {
                                    data: 'NumOfBag',
                                    name: 'NumOfBag',
                                    render: $.fn.dataTable.render.number(',', '.',0, ''),
                                    width:"5%" //9
                                },
                                {
                                    data: 'BagWeight',
                                    name: 'BagWeight',
                                    render: $.fn.dataTable.render.number(',', '.',2, ''),
                                    width:"5%" //10
                                },
                                {
                                    data: 'TotalKg',
                                    name: 'TotalKg',
                                    render: $.fn.dataTable.render.number(',', '.',2, ''),
                                    width:"5%" //11
                                },
                                {
                                    data: 'TON',
                                    name: 'TON',
                                    render: $.fn.dataTable.render.number(',', '.',2, ''),
                                    width:"4%" //12
                                },
                                {
                                    data: 'Feresula',
                                    name: 'Feresula',
                                    render: $.fn.dataTable.render.number(',', '.',2, ''),
                                    width:"5%" //13
                                },
                                {
                                    data: 'NetKg',
                                    name: 'NetKg',
                                    render: $.fn.dataTable.render.number(',', '.',2, ''),
                                    width:"5%" //14
                                },
                                {
                                    data: 'UnitCost',
                                    name: 'UnitCost',
                                    render: $.fn.dataTable.render.number(',', '.',2, ''),
                                    "render": function ( data, type, row, meta ) {
                                        return "@if (auth()->user()->can('PO-View') && auth()->user()->can('PIV-View'))"+numformat(parseFloat(data).toFixed(2))+"@endcan";
                                    },
                                    width:"5%" //15
                                },
                                {
                                    data: 'TotalCost',
                                    name: 'TotalCost',
                                    render: $.fn.dataTable.render.number(',', '.',2, ''),
                                    "render": function ( data, type, row, meta ) {
                                        return "@if (auth()->user()->can('PO-View') && auth()->user()->can('PIV-View'))"+numformat(parseFloat(data).toFixed(2))+"@endcan";
                                    },
                                    width:"5%" //16
                                },
                                {
                                    data: 'VarianceShortage',
                                    name: 'VarianceShortage',
                                    render: $.fn.dataTable.render.number(',', '.',2, ''),
                                    width:"5%" //17
                                },
                                {
                                    data: 'VarianceOverage',
                                    name: 'VarianceOverage',
                                    render: $.fn.dataTable.render.number(',', '.',2, ''),
                                    width:"5%" //18
                                },
                                {
                                    data: 'Remark',
                                    name: 'Remark',
                                    width:"5%"
                                },
                                {
                                    data: 'RecStatus',
                                    name: 'RecStatus',
                                    "render": function ( data, type, row, meta ) {
                                        if(data=="Confirmed"){
                                            return '<a style="font-size:11px;color:#28c76f;"><b>'+data+'</b></a>';
                                        }
                                        if(data=="Returned"){
                                            return '<a style="font-size:11px;color:#ff9f43;"><b>'+data+'</b></a>';
                                        }
                                        if(data=="Void"){
                                            return '<a style="font-size:11px;color:#ea5455;"><b>'+data+'</b></a>';
                                        }
                                    },
                                    width:"4%"
                                },
                                {
                                    data: 'CompanyType',
                                    name: 'CompanyType',
                                    'visible': false //21
                                },
                                {
                                    data: 'ReferenceProp',
                                    name: 'ReferenceProp',
                                    'visible': false  //22
                                },
                                {
                                    data: 'CommodityProp',
                                    name: 'CommodityProp',
                                    'visible': false  //23
                                },
                                {
                                    data: 'DocumentNumber',
                                    name: 'DocumentNumber',
                                    'visible': false, //24
                                },
                                {
                                    data: 'PurchaseInvoiceNo',
                                    name: 'PurchaseInvoiceNo',
                                    'visible': false //25
                                },
                                {
                                    data: 'Supplier',
                                    name: 'Supplier',
                                    'visible': false //26
                                },
                                {
                                    data: 'SupplierTIN',
                                    name: 'SupplierTIN',
                                    'visible': false //27
                                },
                                {
                                    data: 'PONumber',
                                    name: 'PONumber',
                                    'visible': false //28
                                },
                                {
                                    data: 'Date',
                                    name: 'Date',
                                    'visible': false //29
                                },
                                {
                                    data: 'recid',
                                    name: 'recid',
                                    'visible': false //30
                                },
                                {
                                    data: 'PoId',
                                    name: 'PoId',
                                    'visible': false //31
                                },
                                {
                                    data: 'PIVId',
                                    name: 'PIVId',
                                    'visible': false //32
                                },
                            ],
                            "order": [[21, "desc"],[26, "asc"],[22, "asc"],[23, "asc"]],
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
                                    var colorA = 'style="color:black;font-weight:bold;background:#cccccc;"';
                                    
                                    if(level===0){
                                        return $('<tr style="font-weight:bold;font-size:13px;color:#000000;background:#ccc;"><td colspan="21" style="text-align:left;border:0.1px solid black;"><b>Company Type: '+group+'</b></td></tr>');
                                    } 
                                    if(level===1){
                                        return $('<tr style="font-weight:bold;font-size:13px;color:#000000;background:#f2f3f4;"><td colspan="21" style="text-align:center;border:0.1px solid black;"><b>Supplier: '+group+'</b></td></tr>');
                                    } 
                                    if(level===2){
                                        var ponumner = rows
                                        .data()
                                        .pluck('PONumber')
                                        .toArray();

                                        var poid = rows
                                        .data() 
                                        .pluck('PoId')
                                        .toArray();

                                        ponumner = ponumner.filter((value, index, self) => self.indexOf(value) === index);
                                        poid = poid.filter((value, index, self) => self.indexOf(value) === index);

                                        var thirdgroupdata="";
                                        thirdgroupdata = group.replace(ponumner, '<a @can("PO-View")style="text-decoration:underline;color:blue;" onclick=purchaseOrderDocFn("'+poid+'")@endcan>'+ponumner+'</a>');

                                        return $('<tr style="font-weight:bold;font-size:13px;color:#000000;background:#f2f3f4;"><td colspan="21" style="text-align:left;border:0.1px solid black;"><b>Reference: '+thirdgroupdata+'</b></td></tr>');
                                    } 
                                    if(level===3){
                                        var pivnumber = rows
                                        .data()
                                        .pluck('PurchaseInvoiceNo')
                                        .toArray();

                                        var pivid = rows
                                        .data() 
                                        .pluck('PIVId')
                                        .toArray();

                                        var grvnumber = rows
                                        .data() 
                                        .pluck('DocumentNumber') 
                                        .toArray();

                                        var recid = rows
                                        .data() 
                                        .pluck('recid') 
                                        .toArray();

                                        pivnumber = pivnumber.filter((value, index, self) => self.indexOf(value) === index);
                                        pivid = pivid.filter((value, index, self) => self.indexOf(value) === index);
                                        grvnumber = grvnumber.filter((value, index, self) => self.indexOf(value) === index);
                                        recid = recid.filter((value, index, self) => self.indexOf(value) === index);

                                        var fourthgroupdata=""
                                        fourthgroupdata = group.replace(grvnumber, '<a @can("Receiving-View")style="text-decoration:underline;color:blue;" onclick=receivingDocFn("'+recid+'")@endcan>'+grvnumber+'</a>');
                                        fourthgroupdata = fourthgroupdata.replace(pivnumber, '<a @can("PIV-View")style="text-decoration:underline;color:blue;" onclick=purchaseInvDocFn("'+pivid+'")@endcan>'+pivnumber+'</a>');

                                        return $('<tr style="font-weight:bold;font-size:13px;color:#000000;background:#f2f3f4;"><td colspan="21" style="text-align:center;border:0.1px solid black;"><b>'+fourthgroupdata+'</b></td></tr>');
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

                                    var bagweight = rows
                                    .data()
                                    .pluck('BagWeight')
                                    .reduce(function (a, b) {
                                        return intVal(a) + intVal(b);
                                    }, 0);

                                    var totalkg = rows
                                    .data()
                                    .pluck('TotalKg')
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

                                    var netkg = rows
                                    .data()
                                    .pluck('NetKg')
                                    .reduce(function (a, b) {
                                        return intVal(a) + intVal(b);
                                    }, 0);

                                    var totalcost = rows
                                    .data()
                                    .pluck('TotalCost')
                                    .reduce(function (a, b) {
                                        return intVal(a) + intVal(b);
                                    }, 0);

                                    var varianceshortage = rows
                                    .data()
                                    .pluck('VarianceShortage')
                                    .reduce(function (a, b) {
                                        return intVal(a) + intVal(b);
                                    }, 0);

                                    var varianceoverage = rows
                                    .data()
                                    .pluck('VarianceOverage')
                                    .reduce(function (a, b) {
                                        return intVal(a) + intVal(b);
                                    }, 0);

                                    if(level===0){
                                        return $('<tr style="color:#000000;background:#ccc">')
                                            .append('<td colspan="9" style="text-align:right;border:0.1px solid;"><b>Total of : ' + group+ '</b></td>') 
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(numofbag).toFixed(0))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(bagweight).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(totalkg).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(ton).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(feresula).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(netkg).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;"></td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">@if (auth()->user()->can("PO-View") && auth()->user()->can("PIV-View"))'+ numformat(parseFloat(totalcost).toFixed(2))+'@endcan</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(varianceshortage).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(varianceoverage).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;"></td>')
                                            .append('<td style="text-align:left;border:0.1px solid;"></td>')
                                            .append('</tr>'); 
                                    }
                                    if(level===1){
                                        return $('<tr style="color:#000000;background:#f2f3f4">')
                                            .append('<td colspan="9" style="text-align:right;border:0.1px solid;"><b>Total of : ' + group+ '</b></td>') 
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(numofbag).toFixed(0))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(bagweight).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(totalkg).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(ton).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(feresula).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(netkg).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;"></td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">@if (auth()->user()->can("PO-View") && auth()->user()->can("PIV-View"))'+ numformat(parseFloat(totalcost).toFixed(2))+'@endcan</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(varianceshortage).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(varianceoverage).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;"></td>')
                                            .append('<td style="text-align:left;border:0.1px solid;"></td>')
                                            .append('</tr>'); 
                                    }
                                    if(level===2){
                                        var ponumner = rows
                                        .data()
                                        .pluck('PONumber')
                                        .toArray();

                                        var poid = rows
                                        .data() 
                                        .pluck('PoId')
                                        .toArray();

                                        ponumner = ponumner.filter((value, index, self) => self.indexOf(value) === index);
                                        poid = poid.filter((value, index, self) => self.indexOf(value) === index);

                                        var thirdgroupdata="";
                                        thirdgroupdata = group.replace(ponumner, '<a @can("PO-View")style="text-decoration:underline;color:blue;" onclick=purchaseOrderDocFn("'+poid+'")@endcan>'+ponumner+'</a>');

                                        return $('<tr style="color:#000000;background:#f2f3f4">')
                                            .append('<td colspan="9" style="text-align:right;border:0.1px solid;"><b>Total of Reference: ' + thirdgroupdata+ '</b></td>') 
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(numofbag).toFixed(0))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(bagweight).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(totalkg).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(ton).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(feresula).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(netkg).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;"></td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">@if (auth()->user()->can("PO-View") && auth()->user()->can("PIV-View"))'+ numformat(parseFloat(totalcost).toFixed(2))+'@endcan</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(varianceshortage).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(varianceoverage).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;"></td>')
                                            .append('<td style="text-align:left;border:0.1px solid;"></td>')
                                            .append('</tr>'); 
                                    }
                                    if(level===3){
                                        var grvnumber = rows
                                        .data() 
                                        .pluck('DocumentNumber') 
                                        .toArray();

                                        var recid = rows
                                        .data() 
                                        .pluck('recid') 
                                        .toArray();

                                        grvnumber = grvnumber.filter((value, index, self) => self.indexOf(value) === index);
                                        recid = recid.filter((value, index, self) => self.indexOf(value) === index);

                                        var fourthgroupdata=""
                                        fourthgroupdata = '<a @can("Receiving-View")style="text-decoration:underline;color:blue;" onclick=receivingDocFn("'+recid+'")@endcan>'+grvnumber+'</a>';

                                        return $('<tr style="color:#000000;background:#f2f3f4">')
                                            .append('<td colspan="9" style="text-align:right;border:0.1px solid;"><b>Total of Receiving No.: ' + fourthgroupdata+ '</b></td>') 
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(numofbag).toFixed(0))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(bagweight).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(totalkg).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(ton).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(feresula).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(netkg).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;"></td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">@if (auth()->user()->can("PO-View") && auth()->user()->can("PIV-View"))'+ numformat(parseFloat(totalcost).toFixed(2))+'@endcan</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(varianceshortage).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(varianceoverage).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;"></td>')
                                            .append('<td style="text-align:left;border:0.1px solid;"></td>')
                                            .append('</tr>'); 
                                    }
                                },
                                dataSrc: ['CompanyType','Supplier','ReferenceProp','CommodityProp']
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

                                var totalbagweight = api
                                .column(10, { filter: 'applied' })
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );

                                var totalkg = api
                                .column(11, { filter: 'applied' })
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );

                                var totalnetkg = api
                                .column(12, { filter: 'applied' })
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );

                                var totalton = api
                                .column(13, { filter: 'applied' })
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );

                                var totalferesula = api
                                .column(14, { filter: 'applied' })
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );

                                var totalcost = api
                                .column(16, { filter: 'applied' })
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );

                                var totalvarianceshortage = api
                                .column(17, { filter: 'applied' })
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );

                                var totalvarianceoverage = api
                                .column(18, { filter: 'applied' })
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );

                                $('#totalnumberofbag').html(totalnumofbag === 0 ? '' : numformat(parseFloat(totalnumofbag).toFixed(0)));
                                $('#totalbagweight').html(totalnumofbag === 0 ? '' : numformat(parseFloat(totalnumofbag).toFixed(2)));
                                $('#totaltotalkg').html(totalkg === 0 ? '' : numformat(parseFloat(totalkg).toFixed(2)));
                                $('#totalnetkg').html(totalnetkg === 0 ? '' : numformat(parseFloat(totalnetkg).toFixed(2)));
                                $('#totalton').html(totalton === 0 ? '' : numformat(parseFloat(totalton).toFixed(2)));
                                $('#totalferesula').html(totalferesula === 0 ? '' : numformat(parseFloat(totalferesula).toFixed(2)));
                                $('#totaltotalcost').html("@if (auth()->user()->can('PO-View') && auth()->user()->can('PIV-View'))"+totalcost === 0 ? '' : numformat(parseFloat(totalcost).toFixed(2))+"@endcan");
                                $('#totalvarianceshortage').html(totalvarianceshortage === 0 ? '' : numformat(parseFloat(totalvarianceshortage).toFixed(2)));
                                $('#totalvarianceoverage').html(totalvarianceoverage === 0 ? '' : numformat(parseFloat(totalvarianceoverage).toFixed(2)));
                            
                                $(api.column(9).footer()).html(totalnumofbag.toLocaleString());
                                $(api.column(10).footer()).html(totalbagweight.toLocaleString());
                                $(api.column(11).footer()).html(totalkg.toLocaleString());
                                $(api.column(12).footer()).html(totalnetkg.toLocaleString());
                                $(api.column(13).footer()).html(totalton.toLocaleString());
                                $(api.column(14).footer()).html(totalferesula.toLocaleString());
                                $(api.column(16).footer()).html(totalcost.toLocaleString());
                                $(api.column(17).footer()).html(totalvarianceshortage.toLocaleString());
                                $(api.column(18).footer()).html(totalvarianceoverage.toLocaleString());
                            },
                            drawCallback: function(settings) {
                                var api = this.api();
                                var currentIndex = 1;
                                var currentGroup = null;
                                api.rows({ page: 'current', search: 'applied' }).every(function() {
                                    var rowData = this.data();
                                    if (rowData) {
                                        var group = rowData['CompanyType','Supplier','ReferenceProp','CommodityProp']; // Assuming 'group_column' is the name of the column used for grouping
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
        
        function numformat(val){
            while (/(\d+)(\d{3})/.test(val.toString())){
                val = val.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
            }
            return val;
        }

    </script>
@endsection