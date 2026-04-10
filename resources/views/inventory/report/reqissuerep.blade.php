@extends('layout.app1')
@section('title')
@endsection
@section('content')
@can('Requisition-&-Issue-View')
    <div class="app-content content">
        <form id="requisitionissueform">
        @csrf
            <section id="responsive-header">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h3 class="card-title">Requisition & Issue Report</h3>
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
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 mb-1">
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
                                                <label style="font-size: 14px;color">Request Reason</label>
                                                <select class="selectpicker form-control dropdownclass errorerase" id="requestreason" name="requestreason" title="Select request reason here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" multiple="multiple" data-actions-box="true" data-selected-text-format="count" data-count-selected-text="Request Reason ({0})"></select>
                                                <span class="text-danger">
                                                    <strong id="requestreason-error" class="errorclass"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 mb-1">
                                                <label style="font-size: 14px;color">Transaction Type</label>
                                                <select class="selectpicker form-control dropdownclass errorerase" id="transactiontype" name="transactiontype" title="Select transaction type here..." data-style="btn btn-outline-secondary waves-effect" multiple="multiple" data-actions-box="true" data-selected-text-format="count" data-count-selected-text="Transaction Type ({0})"></select>
                                                <span class="text-danger">
                                                    <strong id="trtype-error" class="errorclass"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 mb-1">
                                                <label style="font-size: 14px;color">Requisition & Issue No.</label>
                                                <select class="selectpicker form-control dropdownclass errorerase" id="reqissuenum" name="reqissuenum" title="Select requistion & issue no. here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" multiple="multiple" data-actions-box="true" data-selected-text-format="count" data-count-selected-text="Requistion & Issue No.({0})"></select>
                                                <span class="text-danger">
                                                    <strong id="reqissue-error" class="errorclass"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 mb-1">
                                                <label style="font-size: 14px;color">Buyer, Booking No.,Reference</label>
                                                <select class="selectpicker form-control dropdownclass errorerase" id="reference" name="reference" title="Select reference here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" multiple="multiple" data-actions-box="true" data-selected-text-format="count" data-count-selected-text="Buyer, Booking No.,Ref.({0})"></select>
                                                <span class="text-danger">
                                                    <strong id="reference-error" class="errorclass"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 mb-1">
                                                <label style="font-size: 14px;color" title="Supplier Name, GRV, Production, Certificate, Export Certificate Number">Supplier, GRV, Prd, Cert, Export Cert No.</label>
                                                <select class="selectpicker form-control dropdownclass errorerase" id="suppgrncert" name="suppgrncert" title="Select supplier,grn... here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" multiple="multiple" data-actions-box="true" data-selected-text-format="count" data-count-selected-text="Supplier, GRV, Prd, Cert, Export Cert No.({0})"></select>
                                                <span class="text-danger">
                                                    <strong id="suppgrncert-error" class="errorclass"></strong>
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
                                            <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 mb-1">
                                                <label style="font-size: 14px;color">Dispatch & Void Status</label>
                                                <select class="selectpicker form-control dropdownclass errorerase" id="status" name="status" title="Select status here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" multiple="multiple" data-actions-box="true" data-selected-text-format="count" data-count-selected-text="Dispatch & Void Status({0})"></select>
                                                <span class="text-danger">
                                                    <strong id="status-error" class="errorclass"></strong>
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
                                                <select class="selectpicker form-control" id="reqreasondefault" name="reqreasondefault" title="Select product type here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true">
                                                    @foreach ($requestreason as $requestreason)
                                                        <option value="{{ $requestreason->ReqReasonVal }}" title="{{$requestreason->DataProp}}">{{ $requestreason->RequestReason }}</option>
                                                    @endforeach    
                                                </select>
                                                <select class="selectpicker form-control" id="transactiontypedefault" name="transactiontypedefault" title="Select transaction type here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true">
                                                    @foreach ($transactiontype as $transactiontype)
                                                        <option value="{{ $transactiontype->TransactionsType }}" title="{{$transactiontype->DataProp }}">{{ $transactiontype->TransactionsType }}</option>
                                                    @endforeach    
                                                </select>
                                                <select class="selectpicker form-control" id="requistiondocdefault" name="requistiondocdefault" title="Select requistion here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true">
                                                    @foreach ($reqdocnum as $reqdocnum)
                                                        <option value="{{ $reqdocnum->id }}" title="{{$reqdocnum->DataProp }}">{{ $reqdocnum->ReferenceNo }}</option>
                                                    @endforeach    
                                                </select>
                                                <select class="selectpicker form-control" id="referencedefault" name="referencedefault" title="Select reference here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true">
                                                    @foreach ($referece as $referece)
                                                        <option value="{{ $referece->ReferenceVal }}" title="{{$referece->DataProp }}">{{ $referece->ReferenceNo }}</option>
                                                    @endforeach    
                                                </select>
                                                <select class="selectpicker form-control" id="suppgrncertdefault" name="suppgrncertdefault" title="Select reference here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true">
                                                    @foreach ($grnandprd as $grnandprd)
                                                        <option value="{{ $grnandprd->ReferenceVal }}" title="{{$grnandprd->DataProp }}">{{ $grnandprd->ReferenceNo }}</option>
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
                                                <select class="selectpicker form-control" id="statusdefault" name="statusdefault" title="Select status here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" data-selected-text-format="count" data-count-selected-text="Crop Year ({0})">
                                                    @foreach ($statusdata as $statusdata)
                                                        <option value="{{ $statusdata->StatusVal }}" title="{{$statusdata->DataProp}}">{{ $statusdata->Status }}</option>
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
                                                <table id="stockrequisitiontable" class="display table-bordered defaultdatatable nowrap" style="text-align:left;width: 100%">
                                                    <thead>
                                                        <tr style="color:white; border: 0.1px solid black;">
                                                            <th style="width:2%;color:white; border: 0.1px solid white;background-color:#00cfe8;border-left:1px solid black" title="No.">#</th>
                                                            <th style="width:4%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Request Reason">Request Reason</th>
                                                            <th style="width:4%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Supplier Name">Supplier</th>
                                                            <th style="width:4%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Good Receiving Number">Receiving No.</th>
                                                            <th style="width:4%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Production, Certificate Number">Production, Certificate No.</th>
                                                            <th style="width:4%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Export Certificate Number">Export Certificate No.</th>
                                                            <th style="width:4%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="">Store/ Station</th>
                                                            <th style="width:4%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Floor Map">Floor Map</th>
                                                            <th style="width:4%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Commodity Type">Commodity Type</th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Commodity">Commodity</th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Grade">Grade</th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Crop Year">Crop Year</th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Process Type">Process Type</th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="UOM/ Bag">UOM/ Bag</th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Number of Bag">No. of Bag</th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Bag Weight">Bag Weight</th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Total KG">Total KG</th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="Net KG">Net KG</th>
                                                            <th style="width:4%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="TON">TON</th>
                                                            <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="">Feresula</th>
                                                            <th style="width:4%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="">Variance Shortage</th>
                                                            <th style="width:4%;color:white; border: 0.1px solid white;background-color:#00cfe8;" title="">Variance Overage</th>
                                                            <th style="width:4%;color:white; border: 0.1px solid white;background-color:#00cfe8;border-right:1px solid black" title="">Dispatch Status</th>
                                                            <th style="color:white; border: 0.1px solid white;background-color:#00cfe8;width:0%;display:none;"></th>
                                                            <th style="color:white; border: 0.1px solid white;background-color:#00cfe8;width:0%;display:none;"></th>
                                                            <th style="color:white; border: 0.1px solid white;background-color:#00cfe8;width:0%;display:none;"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="table table-sm"></tbody>
                                                    <tfoot style="font-size: 13px;background-color:#ccc;color:#000000">
                                                        <tr>
                                                            <th colspan="14" style="text-align: right;border: 1px solid black;">Grand Total</th>
                                                            <th id="reptotalnumberofbag" style="text-align:left;padding-left:6px;border: 1px solid black;"></th>
                                                            <th id="reptotalbagweight" style="text-align:left;padding-left:6px;border: 1px solid black;"></th>
                                                            <th id="reptotalkg" style="text-align:left;padding-left:6px;border: 1px solid black;"></th>
                                                            <th id="reptotalnetkg" style="text-align:left;padding-left:6px;border: 1px solid black;"></th>
                                                            <th id="reptotalton" style="text-align:left;padding-left:6px;border: 1px solid black;"></th>
                                                            <th id="reptotalferesula" style="text-align:left;padding-left:6px;border: 1px solid black;"></th>
                                                            <th id="reptotalvarianceshortage" style="text-align:left;padding-left:6px;border: 1px solid black;"></th>
                                                            <th id="reptotalvarianceoverage" style="text-align:left;padding-left:6px;border: 1px solid black;"></th>
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
                                                    <div id="headingCollapse2" class="card-header" data-toggle="collapse" role="button" data-target=".inforecscl" aria-expanded="false" aria-controls="collapse1">
                                                        <span class="lead collapse-title">Basic, Delivery & Other Information</span>
                                                        
                                                    </div>
                                                    <div id="reccollapse1" role="tabpanel" aria-labelledby="headingCollapse2" class="collapse inforecscl">
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

    <!--Start Information Modal -->
    <div class="modal modal-slide-in event-sidebar fade" id="allocationmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel35" aria-hidden="true" style="overflow-y: scroll;">
        <form id="ProductionInformationForm">
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

    <!-- Start Dispatch list information modal-->
    <div class="modal modal-slide-in event-sidebar fade" id="dispatchlistmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y:scroll;">
        <form id="DispatchInfoListForm">
            <div class="modal-dialog sidebar-xl" style="width:98%;">
                <div class="modal-content p-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #ea5455 !important;font-weight:bold;">x</button>
                    <div class="modal-header mb-1">
                        <h5 class="modal-title">Dispatch List Information</h5>
                        <div style="text-align: center;padding-right:30px;" id="dispatchinfostatus"></div>
                    </div>
                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                        <div>
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-sm-12 mb-2">
                                    <table id="dispatchdatatbl" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th style="display: none;"></th>
                                                <th style="width:3%;">#</th>
                                                <th style="width:9%;">Dispatch Doc. No.</th>
                                                <th style="width:9%;">Dispatch Mode</th>
                                                <th style="width:9%;">Driver Name</th>
                                                <th style="width:9%;">Driver License No.</th>
                                                <th style="width:8%;">Driver Phone No.</th>
                                                <th style="width:8%;">Plate No.</th>
                                                <th style="width:8%;">Container No.</th>
                                                <th style="width:8%;">Seal No.</th>
                                                <th style="width:8%;">Person's Name</th>
                                                <th style="width:7%;">Person's Phone No.</th>
                                                <th style="width:7%;">Date</th>
                                                <th style="width:7%;">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table table-sm"></tbody>
                                    </table>                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="closebuttondislist" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- End Dispatch list information modal-->

    <!-- Start Dispatch slide information modal-->
    <div class="modal modal-slide-in event-sidebar fade" id="dispatchinformationmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y:scroll;">
        <form id="DispatchInfoForm">
            <div class="modal-dialog sidebar-xl" style="width:95%;">
                <div class="modal-content p-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #ea5455 !important;font-weight:bold;">x</button>
                    <div class="modal-header mb-1">
                        <h5 class="modal-title">Dispatch Detail Information</h5>
                        <div style="text-align: center;padding-right:30px;" id="dispatchinformationtitle"></div>
                    </div>
                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                        <div>
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-sm-12 mb-1">
                                    <section id="collapsible">
                                        <div class="card collapse-icon">
                                            <div class="collapse-default">
                                                <div class="card">
                                                    <div id="headingCollapse1" class="card-header" data-toggle="collapse" role="button" data-target="#collapse2" aria-expanded="false" aria-controls="collapse1">
                                                        <span class="lead collapse-title">Dispatch Header Information</span>
                                                        <div id="dispatchinformationtitleA"></div>
                                                    </div>
                                                    <div id="collapse2" role="tabpanel" aria-labelledby="headingCollapse1" class="collapse infodoc">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-xl-6 col-md-12 col-lg-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            <h6 class="card-title">Basic Information</h6>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <table style="width: 100%;">
                                                                                <tr>
                                                                                    <td style="width: 20%;"><label style="font-size: 14px;">Requisition Doc. No.</label></td>
                                                                                    <td style="width: 80%;"><label id="infoReqDocNoLbl" style="font-size: 14px;font-weight:bold;"></label></td>   
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;">Dispatch Mode</label></td>
                                                                                    <td><label id="infoDispatchModeLbl" style="font-size: 14px;font-weight:bold;"></label></td>   
                                                                                </tr>
                                                                                <tr class="allinfo vehinfo">
                                                                                    <td><label style="font-size: 14px;">Driver Name</label></td>
                                                                                    <td><label id="infoDriverNameLbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr class="allinfo vehinfo">
                                                                                    <td><label style="font-size: 14px;">Driver License No.</label></td>
                                                                                    <td><label id="infoDriverLiceNoLbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr class="allinfo vehinfo">
                                                                                    <td><label style="font-size: 14px;">Driver Phone No.</label></td>
                                                                                    <td><label id="infoDriverPhoneNoLbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr class="allinfo vehinfo">
                                                                                    <td><label style="font-size: 14px;">Plate No.</label></td>
                                                                                    <td><label id="infoPlateNoLbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr class="allinfo vehinfo">
                                                                                    <td><label style="font-size: 14px;">Container No.</label></td>
                                                                                    <td><label id="infoContainerNoLbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr class="allinfo vehinfo">
                                                                                    <td><label style="font-size: 14px;">Seal No.</label></td>
                                                                                    <td><label id="infoSealNoLbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr class="allinfo perinfo">
                                                                                    <td><label style="font-size: 14px;">Person's Name</label></td>
                                                                                    <td><label id="infoPersonNameLbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr class="allinfo perinfo">
                                                                                    <td><label style="font-size: 14px;">Person's Phone No.</label></td>
                                                                                    <td><label id="infoPersonPhoneLbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;">Remark</label></td>
                                                                                    <td><label id="infoRemark" style="font-size: 14px;font-weight:bold;"></label></td>
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
                                    </section> 
                                </div>
                            </div> 
                            <hr class="m-0">
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-sm-12 mb-2">
                                    <table id="dispatchinfodatatbl" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th style="width:3%;">#</th>
                                                <th style="width:9%;">Commodity</th>
                                                <th style="width:9%;">Supplier Name</th>
                                                <th style="width:9%;">GRN No.</th>
                                                <th style="width:9%;">Production Order No.</th>
                                                <th style="width:11%;">Production Certificate No.</th>
                                                <th style="width:9%;">Export Certificate No.</th>
                                                <th style="width:9%;">UOM/ Bag</th>
                                                <th style="width:7%;">No. of Bag</th>
                                                <th style="width:8%;">Total KG</th>
                                                <th style="width:7%;">Net KG</th>
                                                <th style="width:10%;">Remark</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table table-sm"></tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="8" style="font-size: 16px;text-align: right;padding-right:7px;">Total</th>
                                                <th style="padding-left:7px;">
                                                    <label style="font-size: 14px;font-weight:bold;" class="infodispfooter" id="infodisptotalbag"></label>
                                                </th>
                                                <th style="padding-left:7px;">
                                                    <label style="font-size: 14px;font-weight:bold;" class="infodispfooter" id="infodisptotalkg"></label>
                                                </th>
                                                <th style="padding-left:7px;">
                                                    <label style="font-size: 14px;font-weight:bold;" class="infodispfooter" id="infodispnetkg"></label>
                                                </th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                    </table>                                       
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col-xl-12 col-lg-12 col-sm-12">
                            <div class="row">
                                <div class="col-xl-8 col-lg-8" style="text-align: left">
                                    <input type="hidden" class="form-control" name="dispatchinfoid" id="dispatchinfoid" readonly="true"/> 
                                    <button type="button" id="dispatchprintbtn" class="btn btn-outline-dark waves-effect"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
                                </div>
                                <div class="col-xl-4 col-lg-8" style="text-align:right;">
                                    <button id="closebuttondisinfo" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- End Dispatch slide information modal-->
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
            var divToPrintBody = document.getElementById("stockrequisitiontable");
            var htmlToPrint = `<html>
                <head>
                    <title>Requisition & Issue Report</title>
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
                                        <h3><p style="color:#00cfe8;padding-top:8px;"><b>Requisition & Issue Report</b></p></h3>
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

            var table = document.getElementById("stockrequisitiontable");
            var workbook = new ExcelJS.Workbook();
            var worksheet = workbook.addWorksheet("Requisition_&_Issue_Report");

            let mergeCells = [];
            let maxColumnWidths = {}; // Store max column widths

            let titleRow = worksheet.addRow(["Requisition & Issue Report ("+fromdate+" to "+todate+")"]);
            titleRow.font = { bold: true, size: 16, color: { argb: "000000" } };
            titleRow.alignment = { horizontal: "center", vertical: "middle" };

            worksheet.mergeCells(1, 1, 1, 23); // 🔹 Merge across all columns

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
                saveAs(blob,"Requisition_&_Issue_Report_from_"+fromdate+"_to_"+todate+".xlsx");
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
            $("#stockrequisitiontable thead tr").each(function () {
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
            $("#stockrequisitiontable tbody tr").each(function (rowIndex) {
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

            $("#stockrequisitiontable tfoot tr").each(function (rowIndex) {
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
            const titleText = "Requisition & Issue Report ("+fromdate+" to "+todate+")";
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
                            if(parseInt(data.cell.colSpan)==14){
                                data.cell.styles.halign = "right";
                            }
                        });

                        data.cell.styles.lineWidth = 0.1;  // Thickness of the border
                        data.cell.styles.lineColor = [0, 0, 0];  // Black border color
                    }
                },
            });

            doc.save("Requisition_&_Issue_Report_from_"+fromdate+"_to_"+todate+".pdf");
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

        function getCustomer(compvalue){
            let fiscalyear=$('#fiscalyear').val(); 
            const allCombinations = [];
            var seen = {};

            allCombinations.push(fiscalyear + compvalue);

            // compvalue.forEach(a1 => {
            //     allCombinations.push(fiscalyear + a1);
            // });

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

        function getRequestReason(prdtype){
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

            $('#requestreason').empty(); 
            var requestreasonoption = $("#reqreasondefault > option").clone();
            $('#requestreason').append(requestreasonoption); 
            $('#requestreason option').each(function () { 
                var optionTitle = $(this).attr('title'); 
                if (!allCombinations.includes(optionTitle)) {
                    $(this).remove(); 
                }
                if($(this).val()==null || $(this).val()=="" || $(this).val()===""){
                    $(this).remove(); 
                }
                $(this).removeAttr('title');
            });

            $('#requestreason option').each(function () {
                var value =  $(this).val();
                if (seen[value]) {
                    $(this).remove(); 
                } else {
                    seen[value] = true; 
                }
            });
            $('#requestreason').selectpicker('refresh');
        }

        function getTransactionType(reqreas){
            let fiscalyear=$('#fiscalyear').val(); 
            let cusowner=$('#CustomerOrOwner').val(); 
            let storeid=$('#store').val();
            let prdtype=$('#producttype').val();
            const allCombinations = [];
            var seen = {};

            cusowner.forEach(a1 => {
                storeid.forEach(a2 => {
                    prdtype.forEach(a3 => { 
                        reqreas.forEach(a4 => { 
                            allCombinations.push(fiscalyear + a1 + a2 + a3 + a4);
                        });
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

        function getRequistionNo(trtype){
            let fiscalyear=$('#fiscalyear').val(); 
            let cusowner=$('#CustomerOrOwner').val(); 
            let storeid=$('#store').val();
            let prdtype=$('#producttype').val();
            let reqreas=$('#requestreason').val();
            const allCombinations = [];
            var seen = {};

            cusowner.forEach(a1 => {
                storeid.forEach(a2 => {
                    prdtype.forEach(a3 => { 
                        reqreas.forEach(a4 => { 
                            trtype.forEach(a5 => { 
                                allCombinations.push(fiscalyear + a1 + a2 + a3 + a4 + a5);
                            });
                        });
                    });
                });
            });

            $('#reqissuenum').empty(); 
            var requistiondataoption = $("#requistiondocdefault > option").clone();
            $('#reqissuenum').append(requistiondataoption); 
            $('#reqissuenum option').each(function () { 
                var optionTitle = $(this).attr('title'); 
                if (!allCombinations.includes(optionTitle)) {
                    $(this).remove(); 
                }
                if($(this).val()==null || $(this).val()=="" || $(this).val()===""){
                    $(this).remove(); 
                }
                $(this).removeAttr('title');
            });

            $('#reqissuenum option').each(function () {
                var value =  $(this).val();
                if (seen[value]) {
                    $(this).remove(); 
                } else {
                    seen[value] = true; 
                }
            });
            $('#reqissuenum').selectpicker('refresh');
        }

        function getReference(reqissueid){
            let fiscalyear=$('#fiscalyear').val(); 
            let cusowner=$('#CustomerOrOwner').val(); 
            let storeid=$('#store').val();
            let prdtype=$('#producttype').val();
            let reqreas=$('#requestreason').val();
            let trtype=$('#transactiontype').val();
            const allCombinations = [];
            const disStatus = [];
            var seen = {};
            var statusseen = {};

            cusowner.forEach(a1 => {
                storeid.forEach(a2 => {
                    prdtype.forEach(a3 => { 
                        reqreas.forEach(a4 => { 
                            trtype.forEach(a5 => { 
                                reqissueid.forEach(a6 => { 
                                    allCombinations.push(fiscalyear + a1 + a2 + a3 + a4 + a5 + a6);
                                });
                            });
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

            reqissueid.forEach(b1 => {
                disStatus.push(b1);
            });

            $('#status').empty(); 
            var statusoption = $("#statusdefault > option").clone();
            $('#status').append(statusoption); 
            $('#status option').each(function () { 
                var optionTitle = $(this).attr('title'); 
                if (!disStatus.includes(optionTitle)) {
                    $(this).remove(); 
                }
                if($(this).val()==null || $(this).val()=="" || $(this).val()===""){
                    $(this).remove(); 
                }
                $(this).removeAttr('title');
            });

            $('#status option').each(function () {
                var value =  $(this).val();
                if (statusseen[value]) {
                    $(this).remove(); 
                } else {
                    statusseen[value] = true; 
                }
            });

            $('#reference').selectpicker('refresh');
            $('#status').selectpicker('refresh');
        }

        function getSupplierGrn(bookingref){
            let fiscalyear=$('#fiscalyear').val(); 
            let cusowner=$('#CustomerOrOwner').val(); 
            let storeid=$('#store').val();
            let prdtype=$('#producttype').val();
            let reqreas=$('#requestreason').val();
            let trtype=$('#transactiontype').val();
            let reqissueid=$('#reqissuenum').val();
            const allCombinations = [];
            var seen = {};

            cusowner.forEach(a1 => {
                storeid.forEach(a2 => {
                    prdtype.forEach(a3 => { 
                        reqreas.forEach(a4 => { 
                            trtype.forEach(a5 => { 
                                reqissueid.forEach(a6 => { 
                                    bookingref.forEach(a7 => { 
                                        allCombinations.push(fiscalyear + a1 + a2 + a3 + a4 + a5 + a6 + a7);
                                    });
                                });
                            });
                        });
                    });
                });
            });

            $('#suppgrncert').empty(); 
            var suppliergrncertoption = $("#suppgrncertdefault > option").clone();
            $('#suppgrncert').append(suppliergrncertoption); 
            $('#suppgrncert option').each(function () { 
                var optionTitle = $(this).attr('title'); 
                if (!allCombinations.includes(optionTitle)) {
                    $(this).remove(); 
                }
                if($(this).val()==null || $(this).val()=="" || $(this).val()===""){
                    $(this).remove(); 
                }
                $(this).removeAttr('title');
            });

            $('#suppgrncert option').each(function () {
                var value =  $(this).val();
                if (seen[value]) {
                    $(this).remove(); 
                } else {
                    seen[value] = true; 
                }
            });
            $('#suppgrncert').selectpicker('refresh');
        }

        function getCommodityType(suppgrvcert){
            let fiscalyear=$('#fiscalyear').val(); 
            let cusowner=$('#CustomerOrOwner').val(); 
            let storeid=$('#store').val();
            let prdtype=$('#producttype').val();
            let reqreas=$('#requestreason').val();
            let trtype=$('#transactiontype').val();
            let reqid=$('#reqissuenum').val();
            
            const allCombinations = [];
            var seen = {};

            reqid.forEach(a1 => { 
                suppgrvcert.forEach(a2 => {
                    allCombinations.push(fiscalyear + a1 + a2);
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
            let reqreas=$('#requestreason').val();
            let trtype=$('#transactiontype').val();
            let reqid=$('#reqissuenum').val();
            const allCombinations = [];
            var seen = {};

            cusowner.forEach(a1 => {
                storeid.forEach(a2 => {
                    prdtype.forEach(a3 => { 
                        reqreas.forEach(a4 => { 
                            trtype.forEach(a5 => { 
                                reqid.forEach(a6 => { 
                                    commoditytype.forEach(a7 => { 
                                        allCombinations.push(fiscalyear + a1 + a2 + a3 + a4 + a5 + a6 + a7);
                                    });
                                });
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
            let reqreas=$('#requestreason').val();
            let trtype=$('#transactiontype').val();
            let reqid=$('#reqissuenum').val();
            let commoditytype=$('#commoditytype').val();
            const allCombinations = [];
            var seen = {};
                   
            reqid.forEach(a1 => { 
                commoditytype.forEach(a2 => { 
                    commodity.forEach(a3 => {
                        allCombinations.push(fiscalyear + a1 + a2 + a3);
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
            let reqid=$('#reqissuenum').val();
            let commoditytype=$('#commoditytype').val();
            let commodity=$('#commodity').val();
            const allCombinations = [];
            var seen = {};

            reqid.forEach(a1 => { 
                commoditytype.forEach(a2 => { 
                    commodity.forEach(a3 => {
                        grade.forEach(a4 => {
                            allCombinations.push(fiscalyear + a1 + a2 + a3 + a4);
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
            let reqid=$('#reqissuenum').val();
            let commoditytype=$('#commoditytype').val();
            let commodity=$('#commodity').val();
            let grade=$('#grade').val();
            const allCombinations = [];
            var seen = {};

            reqid.forEach(a1 => { 
                commoditytype.forEach(a2 => { 
                    commodity.forEach(a3 => {
                        grade.forEach(a4 => {
                            processtype.forEach(a5 => {
                                allCombinations.push(fiscalyear + a1 + a2 + a3 + a4 + a5);
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
            getDateRange(startdaterange,enddaterange);
            $('#daterange').val("");
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
            getRequestReason(prdtype);
        });

        $('#requestreason').change(function() { 
            var reqrn = $(this).val();
            getTransactionType(reqrn);
        });

        $('#transactiontype').change(function() { 
            var trtype = $(this).val();
            getRequistionNo(trtype);
        });

        $('#reqissuenum').change(function() { 
            var reqissid = $(this).val();
            getReference(reqissid);
        });

        $('#reference').change(function() { 
            var bookingref = $(this).val();
            getSupplierGrn(bookingref);
        });

        $('#suppgrncert').change(function() { 
            var suppgrvcert = $(this).val();
            getCommodityType(suppgrvcert);
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
                        dateRangeChange(startdaterange,enddaterange);
                        $('#daterange').val(moment(startdaterange,'YYYY-MM-DD').format('MMMM DD, YYYY') + ' - ' + moment(enddaterange,'YYYY-MM-DD').format('MMMM DD, YYYY'));
                        
                        $("#companytype option[value=1]").remove(); 
                        var defaultcomptypeopt = '<option selected value=1>Owner</option>';
                        $('#companytype').append(defaultcomptypeopt); 
                        //$('#companytype').find('option').prop('selected', true);
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
                        getRequestReason(prdtype);

                        $('#requestreason').find('option').prop('selected', true);
                        var reqreas = $('#requestreason').val();
                        getTransactionType(reqreas);

                        $('#transactiontype').find('option').prop('selected', true);
                        var trtype = $('#transactiontype').val();
                        getRequistionNo(trtype);

                        $('#reqissuenum').find('option').prop('selected', true);
                        var reqissueid = $('#reqissuenum').val();
                        getReference(reqissueid);

                        $('#reference').find('option').prop('selected', true);
                        var bookingref = $('#reference').val();
                        getSupplierGrn(bookingref);

                        $('#suppgrncert').find('option').prop('selected', true);
                        var suppgrvcert = $('#suppgrncert').val();
                        getCommodityType(suppgrvcert);

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

                        $('#status').find('option').prop('selected', true);

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
            var registerForm = $('#requisitionissueform');
            var formData = registerForm.serialize();

            $.ajax({ 
                url: "{{url('requisitionIssueReport')}}",
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
                        if (data.errors.requestreason) {
                            var text=data.errors.requestreason[0];
                            text = text.replace("requestreason", "request reason");
                            $('#requestreason-error').html(text);
                        }
                        if (data.errors.transactiontype) {
                            var text=data.errors.transactiontype[0];
                            text = text.replace("transactiontype", "transaction type");
                            $('#trtype-error').html(text);
                        }
                        if (data.errors.reqissuenum) {
                            var text=data.errors.reqissuenum[0];
                            text = text.replace("reqissuenum", "requisition & issue");
                            $('#reqissue-error').html(text);
                        }
                        if (data.errors.reference) {
                            var text=data.errors.reference[0];
                            text = text.replace("reference", "buyer, booking & reference");
                            $('#reference-error').html(text);
                        }
                        if (data.errors.suppgrncert) {
                            var text=data.errors.suppgrncert[0];
                            text = text.replace("suppgrncert", "supplier, GRV, Production & Certificate");
                            $('#suppgrncert-error').html(text);
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
                        if (data.errors.status) {
                            var text=data.errors.status[0];
                            text = text.replace("status", "dispatch & void");
                            $('#status-error').html(text);
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
                        var customerorownerpost="";
                        var storepost="";

                        var producttypepost="";
                        var requestreasonpost="";
                        var transactiontypepost="";
                        var requisitionidpost="";
                        var buyerbookingrefpost="";
                        var suppliergrvcertpost="";

                        var commoditytypepost="";
                        var commoditypost="";
                        var gradepost="";
                        var processtypepost="";
                        var cropyearpost="";
                        var dispatchvoidpost="";

                        var table = $("#stockrequisitiontable").DataTable({ 
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
                                url: "{{url('reqIssueDataFetch')}}",
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
                                    requestreasonpost: $('#requestreason').val(),
                                    transactiontypepost: $('#transactiontype').val(),
                                    requisitionidpost: $('#reqissuenum').val(),
                                    buyerbookingrefpost: $('#reference').val(),
                                    suppliergrvcertpost: $('#suppgrncert').val(),
                                    commoditytypepost: $('#commoditytype').val(),
                                    commoditypost: $('#commodity').val(),
                                    gradepost: $('#grade').val(),
                                    processtypepost: $('#processtype').val(),
                                    cropyearpost: $('#cropyear').val(),
                                    dispatchvoidpost: $('#status').val(),
                                },
                                dataType: "json",
                            },
                            columns: [
                                {
                                    data:'DT_RowIndex',
                                    width:"2%"
                                },
                                {
                                    data: 'RequestReason',
                                    name: 'RequestReason',
                                    width:"4%"
                                },
                                {
                                    data: 'SupplierName',
                                    name: 'SupplierName',
                                    width:"4%"
                                },
                                {
                                    data: 'GrnNumber',
                                    name: 'GrnNumber',
                                    "render": function ( data, type, row, meta ) {
                                        if(data == '-' || data == ',	'){
                                            return '';
                                        }
                                        else{
                                            return '<a @can("Receiving-View")style="text-decoration:underline;color:blue;" onclick=receivingDocFn("'+row.RecId+'")@endcan>'+data+'</a>';
                                        }
                                    },
                                    width:"4%"
                                },
                                {
                                    data: 'ProductionCertNumber',
                                    name: 'ProductionCertNumber',
                                    "render": function ( data, type, row, meta ) {
                                        if(data == '-' || data == ' , ' || data == '- , -'){
                                            return '';
                                        }
                                        else{
                                            let fl=3;
                                            let extractedlett = data.substring(0, fl);
                                            if(extractedlett=="PRD"){
                                                return '<a @can("Production-Order-View")style="text-decoration:underline;color:blue;" onclick=productionDocFn("'+row.PrdId+'")@endcan>'+data+'</a>';
                                            }
                                            else{
                                                return '<a @can("Commodity-Beginning-View")style="text-decoration:underline;color:blue;" onclick=commInfoFn("'+row.BegId+'")@endcan>'+data+'</a>';
                                            }
                                        }
                                    },
                                    width:"4%"
                                },
                                {
                                    data: 'ExportCertNumber',
                                    name: 'ExportCertNumber',
                                    width:"4%"
                                },
                                {
                                    data: 'StoreName',
                                    name: 'StoreName',
                                    width:"4%" //6
                                },
                                {
                                    data: 'FloorMap',
                                    name: 'FloorMap',
                                    width:"4%"
                                },
                                {
                                    data: 'CommodityType',
                                    name: 'CommodityType',
                                    width:"4%" //8
                                },
                                {
                                    data: 'Commodity',
                                    name: 'Commodity',
                                    width:"5%"
                                },
                                {
                                    data: 'GradeName',
                                    name: 'GradeName',
                                    width:"5%"
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
                                    data: 'UOM',
                                    name: 'UOM',
                                    width:"5%"
                                },
                                {
                                    data: 'NumOfBag',
                                    name: 'NumOfBag',
                                    render: $.fn.dataTable.render.number(',', '.',0, ''),
                                    width:"5%" //14
                                },
                                {
                                    data: 'BagWeight',
                                    name: 'BagWeight',
                                    render: $.fn.dataTable.render.number(',', '.',2, ''),
                                    width:"5%"
                                },
                                {
                                    data: 'TotalKg',
                                    name: 'TotalKg',
                                    render: $.fn.dataTable.render.number(',', '.',2, ''),
                                    width:"5%"
                                },
                                {
                                    data: 'NetKg',
                                    name: 'NetKg',
                                    render: $.fn.dataTable.render.number(',', '.',2, ''),
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
                                    data: 'VarianceShortage',
                                    name: 'VarianceShortage',
                                    render: $.fn.dataTable.render.number(',', '.',2, ''),
                                    width:"4%"
                                },
                                {
                                    data: 'VarianceOverage',
                                    name: 'VarianceOverage',
                                    render: $.fn.dataTable.render.number(',', '.',2, ''),
                                    width:"4%"
                                },
                                {
                                    data: 'DispatchStatus',
                                    name: 'DispatchStatus',
                                    "render": function ( data, type, row, meta ) {
                                        if(data=="Not-Dispatched"){
                                            return '<a style="font-size:11px;color:#82868b;"><b>'+data+'</b></a>';
                                        }
                                        else if(data=="Void"){
                                            return '<a style="font-size:11px;color:#ea5455;"><b>'+data+'</b></a>';
                                        }
                                        else  if(data=="Partially-Dispatched"){
                                            return '<a @can("Manage-Dispatch-Information")style="text-decoration:underline;font-size:11px;" onclick=dispatchInfoFn("'+row.ReqId+'",1)@endcan ><b style="color:#ff9f43;">'+data+'</b></a>';
                                        }
                                        else  if(data=="Fully-Dispatched"){
                                            return '<a @can("Manage-Dispatch-Information")style="text-decoration:underline;font-size:11px;" onclick=dispatchInfoFn("'+row.ReqId+'",1)@endcan ><b style="color:#28c76f;">'+data+'</b></a>';
                                        }
                                    },
                                    width:"4%"
                                },
                                {
                                    data: 'CustomerOwner',
                                    name: 'CustomerOwner',
                                    'visible': false //23
                                },
                                {
                                    data: 'ReqDocProp',
                                    name: 'ReqDocProp',
                                    'visible': false //24
                                },
                                {
                                    data: 'BuyerBookingReference',
                                    name: 'BuyerBookingReference',
                                    'visible': false //25
                                },
                            ],
                            "order": [[23, "asc"],[6, "asc"],[8, "asc"],[24, "asc"],[25, "asc"]],
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
                                        return $('<tr style="font-weight:bold;font-size:13px;color:#000000;background:#ccc;"><td colspan="23" style="text-align:left;border:0.1px solid black;"><b>'+cusorowner+group+'</b></td></tr>');
                                    } 
                                    if(level===1){
                                        return $('<tr style="font-weight:bold;font-size:13px;color:#000000;background:#f2f3f4;"><td colspan="23" style="text-align:center;border:0.1px solid black;"><b>Store/ Station: '+group+'</b></td></tr>');
                                    } 
                                    if(level===2){
                                        return $('<tr style="font-weight:bold;font-size:13px;color:#000000;background:#f2f3f4;"><td colspan="23" style="text-align:left;border:0.1px solid black;"><b>Commodity Type: '+group+'</b></td></tr>');
                                    }
                                    if(level===3){
                                        return $('<tr style="font-weight:bold;font-size:13px;color:#000000;background:#f2f3f4;"><td colspan="23" style="text-align:left;border:0.1px solid black;"><b>'+group+'</b></td></tr>');
                                    }
                                    if(level===4){
                                        return $('<tr style="font-weight:bold;font-size:13px;color:#000000;background:#f2f3f4;"><td colspan="23" style="text-align:left;border:0.1px solid black;"><b>'+group+'</b></td></tr>');
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

                                    var netkg = rows
                                    .data()
                                    .pluck('NetKG')
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
                                        var cusorowner="";
                                        if(group==="Owner"){
                                            cusorowner="Total of: "+group;
                                        }
                                        else{
                                            cusorowner="Total of: "+group+" Customer";
                                        }
                                        return $('<tr style="color:#000000;background:#ccc">')
                                            .append('<td colspan="14" style="text-align:right;border:0.1px solid;"><b>'+cusorowner + '</b></td>') 
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(numofbag).toFixed(0))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(bagweight).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(totalkg).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(netkg).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(ton).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(feresula).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(varianceshortage).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(varianceoverage).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;"></td>')
                                            .append('</tr>'); 
                                    }
                                    if(level===1){
                                        return $('<tr style="color:#000000;background:#f2f3f4">')
                                            .append('<td colspan="14" style="text-align:right;border:0.1px solid;"><b>Total of : ' + group+ '</b></td>') 
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(numofbag).toFixed(0))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(bagweight).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(totalkg).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(netkg).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(ton).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(feresula).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(varianceshortage).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(varianceoverage).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;"></td>')
                                            .append('</tr>'); 
                                    }
                                    if(level===2){
                                        return $('<tr style="color:#000000;background:#f2f3f4">')
                                            .append('<td colspan="14" style="text-align:right;border:0.1px solid;"><b>Total of : ' + group+ '</b></td>') 
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(numofbag).toFixed(0))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(bagweight).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(totalkg).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(netkg).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(ton).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(feresula).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(varianceshortage).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(varianceoverage).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;"></td>')
                                            .append('</tr>'); 
                                    }
                                    if(level===3){
                                        return $('<tr style="color:#000000;background:#f2f3f4">')
                                            .append('<td colspan="14" style="text-align:right;border:0.1px solid;"><b>Total of : ' + group+ '</b></td>') 
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(numofbag).toFixed(0))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(bagweight).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(totalkg).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(netkg).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(ton).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(feresula).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(varianceshortage).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(varianceoverage).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;"></td>')
                                            .append('</tr>'); 
                                    }
                                    if(level===4){
                                        return $('<tr style="color:#000000;background:#f2f3f4">')
                                            .append('<td colspan="14" style="text-align:right;border:0.1px solid;"><b>Total of : ' + group+ '</b></td>') 
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(numofbag).toFixed(0))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(bagweight).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(totalkg).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(netkg).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(ton).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(feresula).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(varianceshortage).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;">'+ numformat(parseFloat(varianceoverage).toFixed(2))+'</td>')
                                            .append('<td style="text-align:left;border:0.1px solid;"></td>')
                                            .append('</tr>'); 
                                    }
                                },
                                dataSrc: ['CustomerOwner','StoreName','CommodityType','ReqDocProp','BuyerBookingReference']
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

                                var gtnumofbag = api
                                .column(14, { filter: 'applied' })
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );

                                var gtbagweight = api
                                .column(15, { filter: 'applied' })
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );

                                var gtkg = api
                                .column(16, { filter: 'applied' })
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );

                                var gtnetkg = api
                                .column(17, { filter: 'applied' })
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );

                                var gtton = api
                                .column(18, { filter: 'applied' })
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );

                                var gtferesula = api
                                .column(19, { filter: 'applied' })
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );

                                var gtshortage = api
                                .column(20, { filter: 'applied' })
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );

                                var gtoverage = api
                                .column(21, { filter: 'applied' })
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );

                                $('#reptotalnumberofbag').html(gtnumofbag === 0 ? '' : numformat(parseFloat(gtnumofbag).toFixed(0)));
                                $('#reptotalbagweight').html(gtbagweight === 0 ? '' : numformat(parseFloat(gtbagweight).toFixed(2)));
                                $('#reptotalkg').html(gtkg === 0 ? '' : numformat(parseFloat(gtkg).toFixed(2)));
                                $('#reptotalnetkg').html(gtnetkg === 0 ? '' : numformat(parseFloat(gtnetkg).toFixed(2)));
                                $('#reptotalton').html(gtton === 0 ? '' : numformat(parseFloat(gtton).toFixed(2)));
                                $('#reptotalferesula').html(gtferesula === 0 ? '' : numformat(parseFloat(gtferesula).toFixed(2)));
                                $('#reptotalvarianceshortage').html(gtshortage === 0 ? '' : numformat(parseFloat(gtshortage).toFixed(2)));
                                $('#reptotalvarianceoverage').html(gtoverage === 0 ? '' : numformat(parseFloat(gtoverage).toFixed(2)));
                            
                                $(api.column(14).footer()).html(gtnumofbag.toLocaleString());
                                $(api.column(15).footer()).html(gtbagweight.toLocaleString());
                                $(api.column(16).footer()).html(gtkg.toLocaleString());
                                $(api.column(17).footer()).html(gtnetkg.toLocaleString());
                                $(api.column(18).footer()).html(gtton.toLocaleString());
                                $(api.column(19).footer()).html(gtferesula.toLocaleString());
                                $(api.column(20).footer()).html(gtshortage.toLocaleString());
                                $(api.column(21).footer()).html(gtoverage.toLocaleString());
                            },
                            drawCallback: function(settings) {
                                var api = this.api();
                                var currentIndex = 1;
                                var currentGroup = null;
                                api.rows({ page: 'current', search: 'applied' }).every(function() {
                                    var rowData = this.data();
                                    if (rowData) {
                                        var group = rowData['CustomerOwner','StoreName','CommodityType','ReqDocProp','BuyerBookingReference']; // Assuming 'group_column' is the name of the column used for grouping
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
            $(".inforecscl").collapse('show');
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

        function openDetailModal(recordId,transactionType){

            if(transactionType=="Receiving" || transactionType==="Receiving"){
                receivingDocFn(recordId)
            }
            if(transactionType=="Production" || transactionType==="Production"){
                productionDocFn(recordId)
            }
            if(transactionType=="Beginning" || transactionType==="Beginning"){
                commInfoFn(recordId);
            }
        }


        function openAllocModalFn(comm,str,flrmap,commtype,grade,prctype,crpyr,uomid,cusid,trtype,grn,prdno,certno){
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
                    url: "{{url('fetchAllocationData')}}",
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
                        customtrtypepost:trtype,
                        grnpost:grn,
                        prdnumpost:prdno,
                        certnumpost:certno,
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

        function dispatchInfoFn(recordId){
            $.ajax({
                url: '/showReqData'+'/'+recordId,
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
                    $.each(data.reqHeader, function(key, value) {
                        if(value.DispatchStatus=="Partially-Dispatched"){
                            $("#dispatchinfostatus").html("<span style='color:#FF9F43;font-weight:bold;font-size:16px;text-align:right;'>"+value.DocumentNumber+"     ,     "+value.DispatchStatus+"</span>");
                        }
                        else if(value.DispatchStatus=="Fully-Dispatched"){
                            $("#dispatchinfostatus").html("<span style='color:#1cc88a;font-weight:bold;font-size:16px;text-align:right;'>"+value.DocumentNumber+"     ,     "+value.DispatchStatus+"</span>");
                        }
                        else{
                            $("#dispatchinfostatus").html("<span style='color:#A8AAAE;font-weight:bold;font-size:16px;text-align:right;'>"+value.DocumentNumber+"     ,     "+value.DispatchStatus+"</span>");
                        }
                    });
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
                        "render": function ( data, type, row, meta ) {
                            return '<a style="text-decoration:underline;color:blue;font-size:11px;" onclick=infoDispatchFn("'+row.id+'")>'+data+'</a>';
                        },
                        width:"9%"
                    },
                    {
                        data: 'DispatchModeName',
                        name: 'DispatchModeName',
                        width:"9%"
                    },
                    {
                        data: 'DriverName',
                        name: 'DriverName',
                        width:"9%"
                    },
                    {
                        data: 'DriverLicenseNo',
                        name: 'DriverLicenseNo',
                        width:"9%"
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

            $('#dispatchlistmodal').modal('show');
        }

        function infoDispatchFn(recordId){
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

                        if(value.Status=="Pending"){
                            $("#dispatchinformationtitle").html("<span style='color:#f6c23e;font-weight:bold;text-shadow;1px 1px 10px #f6c23e;font-size:16px;'>"+value.DispatchDocNo+" , "+value.Status+"</span>");
                        }
                        else if(value.Status=="Verified"){
                            $("#dispatchinformationtitle").html("<span style='color:#00cfe8;font-weight:bold;font-size:16px;text-align:right;'>"+value.DispatchDocNo+" , "+value.Status+"</span>");
                        }
                        else if(value.Status=="Approved"){
                            $("#dispatchinformationtitle").html("<span style='color:#1cc88a;font-weight:bold;font-size:16px;text-align:right;'>"+value.DispatchDocNo+" , "+value.Status+"</span>");
                        }
                        else{
                            $("#dispatchinformationtitle").html("<span style='color:#e74a3b;font-weight:bold;font-size:16px;text-align:right;'>"+value.DispatchDocNo+" , "+value.Status+"</span>");
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

        //Start Dispatch Print Attachment
        $('#dispatchprintbtn').on('click', function() {
            var id = $('#dispatchinfoid').val();
            var link = "/dispcomm/"+id;
            window.open(link, 'Dispatch', 'width=1200,height=800,scrollbars=yes');
        });
        //End Dispatch Print Attachment

        function numformat(val){
            while (/(\d+)(\d{3})/.test(val.toString())){
                val = val.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
            }
            return val;
        }

    </script>
@endsection