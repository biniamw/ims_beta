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
                @can('PYR-View')
                    <div class="card card-app-design">
                        <div class="card-body">
                            <div class="col-xl-12 col-lg-12">
                                <div class="row">
                                    <div class="col-xl-3 col-lg-12">
                                        <h4 class="card-title">Payment Request
                                            <button type="button"
                                                class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm"
                                                onclick="paymentrequestrefresh()"><i data-feather="refresh-cw"></i></button>
                                            <input type="hidden" name="currentdate" id="currentdate" class="form-control"
                                                value="{{ $todayDate }}" readonly>
                                            <input type="hidden" name="advancepercent" id="advancepercent" class="form-control"
                                                value="{{ $advancepercent }}" readonly>
                                            <input type="hidden" class="form-control" name="priceupdatepermission"
                                                id="priceupdatepermission"
                                                value="{{ auth()->user()->can('PYR-Price-Change') ? 1 : 0 }}" readonly />
                                        </h4>
                                    </div>
                                    <div class="col-xl-2 col-lg-12">
                                        <label strong style="font-size: 12px;font-weight:bold;">Fiscal Year</label>
                                        <select class="select2 form-control" name="fiscalyear" id="fiscalyear">
                                            @foreach ($fiscalyears as $fiscalyears)
                                                <option value="{{ $fiscalyears->FiscalYear }}">{{ $fiscalyears->Monthrange }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-xl-2 col-lg-12">
                                        <label strong style="font-size: 12px;font-weight:bold;">Item Type</label>
                                        <select data-column="4" class="selectpicker form-control itemfilter-select"
                                            data-live-search="true" data-selected-text-format="count" data-actions-box="true"
                                            data-count-selected-text="PE ({0})" data-live-search-placeholder="search item type"
                                            title="Select item type" multiple>
                                            <option value="Goods">Goods</option>
                                            <option value="Commodity">Commodity</option>

                                        </select>
                                    </div>
                                    <div class="col-xl-2 col-lg-12">
                                        <label strong style="font-size: 12px;font-weight:bold;">Filter by Status</label>
                                        <select data-column="12" class="selectpicker form-control filter-select"
                                            data-live-search="true" data-selected-text-format="count" data-actions-box="true"
                                            data-count-selected-text="status ({0})" data-live-search-placeholder="search here"
                                            title="Select Status" multiple>
                                            <option value="0">Draft</option>
                                            <option value="1">Pending</option>
                                            <option value="2">Verify</option>
                                            <option value="3">Approve</option>
                                            <option value="4">Void</option>
                                            <option value="5">Reject</option>
                                            <option value="6">Review</option>
                                            <option value="7">Reviewed</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-datatable">
                            <div style="width:98%; margin-left:1%" class="" id="table-block">
                                <table id="pcontracttables"
                                    class="display table-bordered table-striped table-hover dt-responsive mb-0"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">#</th>
                                            <th rowspan="2">PYR#</th>
                                            <th rowspan="2">Reference</th>
                                            <th rowspan="2">Reference#</th>
                                            <th rowspan="2">Item Type</th>
                                            <th colspan="2" style="text-align: center;">Supplier</th>
                                            <th rowspan="2">Date</th>
                                            <th rowspan="2">Payment Reference</th>
                                            <th rowspan="2">Payment Mode</th>
                                            <th rowspan="2">Payment Status</th>
                                            <th rowspan="2">Paid Amount</th>
                                            <th rowspan="2">Status</th>
                                            <th rowspan="2">Action</th>
                                        </tr>
                                        <tr style="text-align: center;">
                                            <th>Name</th>
                                            <th>TIN</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalScrollableTitle" data-backdrop="static" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <form id="Register">
                {{ csrf_field() }}
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalScrollableTitleadd"></h5>
                        <div class="row">
                            <div style="text-align: right;" id="statusdisplay"> </div>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                    <div class="modal-body scroll scrdiv">
                        <div class="col-xl-12">
                            <div class="row">
                                <div class="col-xl-6 col-lg-12">
                                    <fieldset class="fset">
                                        <legend>Basic Information</legend>
                                        <div class="row">
                                            <div class="col-xl-4 col-md-6 col-sm-12 mb-2">
                                                <label strong style="font-size: 14px;">Reference<b
                                                        style="color:red;">*</b></label>
                                                <select class="select2 form-control form-control-lg" name="type"
                                                    id="type" data-placeholder="Select Purchase Type">
                                                    <option selected disabled value=""></option>
                                                    <option value="PO">PO(Purchase Order)</option>
                                                    <option value="Direct">Direct</option>
                                                </select>
                                                <span class="text-danger">
                                                    <strong id="type-error" class="rmerror"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-4 col-md-6 col-sm-12 mb-2">
                                                <label strong style="font-size: 14px;">Product Type<b
                                                        style="color:red;">*</b></label>
                                                <select class="select2 form-control form-control-lg" name="productype"
                                                    id="productype" data-placeholder="Select Product Type">
                                                    <option selected disabled value=""></option>
                                                    <option value="Goods">Goods</option>
                                                    <option value="Commodity">Commodity</option>
                                                </select>
                                                <span class="text-danger">
                                                    <strong id="productype-error" class="rmerror"></strong>
                                                </span>
                                            </div>
                                            
                                            <div class="col-xl-4 col-md-6 col-sm-12 mb-2" id="referencenodiv">
                                                <label strong style="font-size: 14px;">Reference No.<b
                                                        style="color:red;">*</b></label>
                                                <select class="select2 form-control form-control-lg" name="referenceno"
                                                    id="referenceno" data-placeholder="Select Reference">
                                                </select>
                                                <span class="text-danger">
                                                    <strong id="referenceno-error" class="rmerror"></strong>
                                                </span>
                                            </div>

                                            <div class="col-xl-4 col-md-6 col-sm-12 mb-2" id="supplierduv">
                                                <label strong style="font-size: 14px;">Supplier <b
                                                        style="color:red;">*</b></label>
                                                <select class="select2 form-control form-control-lg selectclass"
                                                    name="supplier" id="supplier" data-placeholder="Select Supplier">
                                                    <option></option>
                                                    @foreach ($customer as $key)
                                                        <option value="{{ $key->id }}"
                                                            title="{{ $key->Name }},{{ $key->TinNumber }},{{ $key->PhoneNumber }}">
                                                            {{ $key->Name }},{{ $key->TinNumber }},{{ $key->PhoneNumber }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger">
                                                    <strong id="supplier-error" class="rmerror"></strong>
                                                </span>
                                            </div>

                                            <div class="col-xl-4 col-md-6 col-sm-12 mb-2 cmdtyclass"
                                                id="commoditytypediv">
                                                <label strong style="font-size: 14px;">Commodity Type <b
                                                        style="color:red;">*</b></label>
                                                <select class="select2 form-control form-control-lg selectclass"
                                                    name="commoditytype" id="commoditytype"
                                                    data-placeholder="select Commodity Type">
                                                    <option selected disabled value=""></option>
                                                    <option value="Coffee">Coffee</option>
                                                    <option value="Sesame Seeds">Sesame Seeds</option>
                                                    <option value="White PeaBeans">White PeaBeans</option>
                                                    <option value="Live Animals">Live Animals</option>
                                                    <option value="Soya Beans">Soya Beans</option>
                                                    <option value="Green Mung">Green Mung</option>
                                                    <option value="Red Kidney Bean">Red Kidney Bean</option>
                                                    <option value="Pinto Bean">Pinto Bean</option>
                                                    <option value="White/Bulla Pea Beans">White/Bulla Pea Beans</option>
                                                    <option value="Sprilinked Kidney Beans">Sprilinked Kidney Beans
                                                    </option>
                                                    <option value="Pigeon pea beans">Pigeon pea beans</option>
                                                </select>
                                                <span class="text-danger">
                                                    <strong id="commoditytype-error" class="rmerror"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-4 col-lg-12 cmdtyclass" id="coffeesourcediv">
                                                <label strong style="font-size: 14px;" id="docfslabel">Commodity Source <b
                                                        style="color:red;">*</b></label>
                                                <select class="select2 form-control sr" name="coffeesource"
                                                    id="coffeesource" data-placeholder="Commodity Source">
                                                    <option selected disabled value=""></option>
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

                                            <div class="col-xl-4 col-lg-12 cmdtyclass" id="coffestatusdiv">
                                                <label strong style="font-size: 14px;" id="docfslabel">Commodity Status <b
                                                        style="color:red;">*</b></label>
                                                <select class="select2 form-control sr" name="coffestatus"
                                                    id="coffestatus" data-placeholder="Commodity Status">
                                                    <option selected disabled value=""></option>
                                                    <option value="Green Bean">Green Bean</option>
                                                    <option value="Roast and Grind">Roast and Grind</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                                <span class="text-danger">
                                                    <strong id="coffestatus-error" class="rmerror"></strong>
                                                </span>
                                            </div>

                                            <div class="col-xl-4 col-md-6 col-sm-12 mb-2">
                                                <label strong style="font-size: 14px;">Prepare Date <b
                                                        style="color:red;">*</b></label>
                                                <div class="input-group input-group-merge">
                                                    <input type="text" name="date" id="date"
                                                        class="form-control flatpickr-basic flatpickr-input active"
                                                        placeholder="YYYY-MM-DD" />
                                                </div>
                                                <span class="text-danger">
                                                    <strong id="date-error" class="rmerror"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-6 col-lg-12">
                                                <label for="basicInputFile">Upload</label>
                                                <input type="file" class="form-control-file" name="pdf"
                                                    id="pdf" />
                                                <input type="hidden" class="form-control" name="filaname"
                                                    id="filename" readonly />
                                                <input type="hidden" class="form-control" name="filepath"
                                                    id="filepath" readonly />
                                                <span class="text-danger">
                                                    <strong id="pdf-error" class="rmerror"></strong>
                                                </span>
                                                <button type="button" id="slipdocumentlinkbtn"
                                                    name="slipdocumentlinkbtn"
                                                    class="btn btn-flat-info waves-effect slipdocumentlinkbtn"
                                                    onclick="SlipdocumentDownload()"><span
                                                        id="slipdocumentlinkbtntext"></span> <i
                                                        class="fa-sharp fa-solid fa-x removecontract"
                                                        style="color: #f03000;"></i></button>
                                            </div>
                                            <div class="col-xl-6 col-md-6 col-sm-12 mb-2">
                                                <label strong style="font-size: 14px;">Memo</label>
                                                <div class="input-group input-group-merge">
                                                    <textarea class="form-control" id="memo" placeholder="Write memo here" name="memo" rows="3"></textarea>
                                                </div>
                                                <span class="text-danger">
                                                    <strong id="memo-error"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-3 col-lg-12" style="display: none;">
                                                <label strong style="font-size: 14px;" id="docfslabel">UOM <b
                                                        style="color:red;">*</b></label>
                                                <select class="select2 form-control" name="hiddenuom" id="hiddenuom">
                                                    <option selected disabled value=""></option>
                                                    @foreach ($uom as $key)
                                                        <option title="{{ $key->Name }}" value="{{ $key->id }}">
                                                            {{ $key->Name }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-xl-3 col-lg-12" style="display: none;">
                                                <label strong style="font-size: 14px;" id="docfslabel">Item <b
                                                        style="color:red;">*</b></label>
                                                <select class="select2 form-control" name="hiddenitem" id="hiddenitem">
                                                    <option selected disabled value=""></option>
                                                    @foreach ($item as $key)
                                                        <option title="{{ $key->Type }}" value="{{ $key->id }}">
                                                            {{ $key->Code }} , {{ $key->Name }} ,
                                                            {{ $key->SKUNumber }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-xl-4 col-lg-12" style="display: none;">
                                                <label strong style="font-size: 14px;" id="docfslabel">Commodity <b
                                                        style="color:red;">*</b></label>
                                                <select class="select2 form-control" name="hiddencommudity"
                                                    id="hiddencommudity" data-placeholder="commudity">
                                                    <option selected disabled value=""></option>
                                                    @foreach ($woreda as $key)
                                                        <option title="{{ $key->Wh_name }}" value="{{ $key->id }}">
                                                            {{ $key->Rgn_Name }}, {{ $key->Zone_Name }},
                                                            {{ $key->Woreda_Name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-xl-4 col-lg-12" style="display: none;">
                                                <label strong style="font-size: 14px;" id="docfslabel">contract Seller <b
                                                        style="color:red;">*</b></label>
                                                <select class="select2 form-control form-control-lg sr"
                                                    name="contractsellerhidden" id="contractsellerhidden"
                                                    data-placeholder="select seller">
                                                    <option selected disabled value=""></option>
                                                    @foreach ($customer as $key)
                                                        <option value="{{ $key->id }}">{{ $key->Name }}</option>
                                                    @endforeach

                                                </select>
                                            </div>

                                            <div class="col-xl-4 col-lg-12" style="display:none;">
                                                <label strong style="font-size: 14px;" id="docfslabel">Coffee Grade
                                                </label>
                                                <select class="select2 form-control" name="coffeegrade" id="coffeegrade"
                                                    data-placeholder="coffee type">
                                                    <option selected disabled value=""></option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="UG">UG</option>
                                                    <option value="NG">NG</option>
                                                    <option value="UG(P)">UG(P)</option>
                                                    <option value="UG(NP)">UG(NP)</option>
                                                </select>
                                            </div>
                                            <div class="col-xl-2 col-lg-12" style="display:none;">
                                                <label strong style="font-size: 14px;" id="docfslabel">Proccess
                                                    Type</label>
                                                <select class="select2 form-control" name="coffeeproccesstype"
                                                    id="coffeeproccesstype" data-placeholder="Proccess type">
                                                    <option selected disabled value=""></option>
                                                    <option value="Anaerobic">Anaerobic</option>
                                                    <option value="Winey">Winey</option>
                                                    <option value="Washed">Washed</option>
                                                    <option value="UnWashed">UnWashed</option>
                                                </select>
                                            </div>

                                            <div class="col-xl-2 col-lg-12" style="display:none;">
                                                <label strong style="font-size: 14px;">Packaunit</label>
                                                <select class="select2 form-control" name="coffepackagenunit"
                                                    id="coffepackagenunit" data-placeholder="Package unit">
                                                    <option selected disabled value=""></option>
                                                    <option value="BG">BG</option>
                                                </select>
                                            </div>
                                            <div class="col-xl-2 col-lg-12" style="display:none;">
                                                <label strong style="font-size: 14px;">Packing Content</label>
                                                <select class="select2 form-control" name="coffeepackingcontent"
                                                    id="coffeepackingcontent" data-placeholder="packing content">
                                                    <option selected disabled value=""></option>
                                                    <option value="60">60</option>
                                                    <option value="80">80</option>
                                                    <option value="85">85</option>
                                                </select>
                                            </div>
                                            <div class="col-xl-2 col-md-6 col-sm-12 mb-2" style="display: none;">
                                                <label strong style="font-size: 14px;">UOM<b
                                                        style="color:red;">*</b></label>
                                                <select class="select2 form-control form-control-lg selectclass"
                                                    name="uom" id="uom" data-placeholder="select uom">
                                                    <option value="" selected disabled></option>
                                                    @foreach ($uom as $key)
                                                        <option value="{{ $key->id }}"
                                                            title="{{ $key->uomamount }}">{{ $key->Name }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger">
                                                    <strong id="uom-error" class="rmerror"></strong>
                                                </span>
                                            </div>

                                            <div class="col-xl-2 col-lg-12" id="cropYeardiv" style="display: none;">
                                                <label strong style="font-size: 14px;" id="docfslabel">Crop Year<b
                                                        style="color:red;">*</b></label>
                                                <select class="select2 form-control sr" name="cropYear" id="cropYear"
                                                    data-placeholder="crop year">
                                                    <option selected disabled value=""></option>
                                                    <option value="2014">2014</option>
                                                    <option value="2015">2015</option>
                                                    <option value="2016">2016</option>
                                                </select>
                                                <span class="text-danger">
                                                    <strong id="year-error" class="rmerror"></strong>
                                                </span>
                                            </div>

                                            <div class="col-xl-2 col-md-6 col-sm-12 mb-2" style="display: none;">
                                                <label strong style="font-size: 14px;" id="docfslabel">Contigency <b
                                                        style="color:red;">*</b></label>
                                                <div class="input-group">
                                                    <input type="text" placeholder="purchaseid" class="form-control"
                                                        name="purchaseid" id="purchaseid" readonly />
                                                </div>
                                            </div>
                                        </div>
                                        <!-- start of item Row -->
                                    </fieldset>
                                </div>

                                <div class="col-xl-6 col-lg-12">
                                    <fieldset class="fset">
                                        <legend>Payment History</legend>
                                        <div class="row">
                                            <div class="col-xl-12 col-lg-12">
                                                <div class="row">
                                                    <div class="col-xl-3 col-md-6 col-sm-12 mb-2">
                                                        <label strong style="font-size: 14px;">Payment Reference </label>
                                                        <select class="select2 form-control form-control-lg"
                                                            name="paymentreference" id="paymentreference"
                                                            data-placeholder="select payment reference">
                                                            <option selected disabled value=""></option>
                                                            <option value="PO">Purchase Order </option>
                                                            <option value="GRV">Good Recieving</option>
                                                            <option value="PI">Purchase Invoice</option>
                                                            <option value="Direct">Direct</option>
                                                        </select>
                                                        <span class="text-danger">
                                                            <strong id="paymentreference-error" class="rmerror"></strong>
                                                        </span>
                                                    </div>
                                                    <div class="col-xl-3 col-md-6 col-sm-12 mb-2">
                                                        <label strong style="font-size: 14px;">Payment Mode <b
                                                                style="color:red;">*</b></label>
                                                        <select class="select2 form-control form-control-lg"
                                                            name="paymentmode" id="paymentmode"
                                                            data-placeholder="select Payment Mode">
                                                            <option selected disabled value=""></option>
                                                            <option value="Advance">Advance </option>
                                                            <option value="Pre Finance">Pre Finacnce</option>
                                                            <option value="Recuring Payment">Recuring Payment</option>
                                                        </select>
                                                        <span class="text-danger">
                                                            <strong id="paymentmode-error" class="rmerror"></strong>
                                                        </span>
                                                    </div>
                                                    <div class="col-xl-3 col-md-6 col-sm-12 mb-2">
                                                        <label strong style="font-size: 14px;">To be paid<b
                                                                style="color:red;">*</b></label>
                                                        <div class="input-group input-group-merge">
                                                            <input type="number" step='0.01' min="0"
                                                                name="amount" id="amount" class="form-control cv"
                                                                oncontextmenu="return false;" placeholder="Amount"
                                                                onkeypress="return ValidateNum(event)"
                                                                onkeyup="checkremianingamount(0,'keyup',0)" />
                                                        </div>
                                                        <span class="text-danger">
                                                            <strong id="amount-error" class="rmerror"></strong>
                                                        </span>
                                                    </div>
                                                    <div class="col-xl-3 col-md-6 col-sm-12 mb-2">
                                                        <label strong style="font-size: 14px;">Status <b
                                                                style="color:red;">*</b></label>
                                                        <select class="select2 form-control form-control-lg"
                                                            name="paymentstatus" id="paymentstatus"
                                                            data-placeholder="select Payment Status">
                                                            <option selected disabled value=""></option>
                                                            <option value="Fully Paid">Fully Paid </option>
                                                            <option value="Partial Paid">Partial Paid</option>
                                                            <option value="Direct">Direct</option>
                                                        </select>
                                                        <span class="text-danger">
                                                            <strong id="paymentmode-error" class="rmerror"></strong>
                                                        </span>
                                                    </div>

                                                    <div class="col-xl-3 col-md-6 col-sm-12 mb-2" style="display: none;">
                                                        <label strong style="font-size: 14px;">Remain Amount</label>
                                                        <div class="input-group input-group-merge">
                                                            <input type="number" name="remainamount" id="remainamount"
                                                                class="form-control" placeholder=" Remain Amount"
                                                                readonly />
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-md-6 col-sm-12 mb-2" style="display: none;">
                                                        <label strong style="font-size: 14px;">Remain not Edited</label>
                                                        <div class="input-group input-group-merge">
                                                            <input type="number" name="constatntremainamount"
                                                                id="constatntremainamount" class="form-control"
                                                                placeholder=" Remain Amount" readonly />
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-3 col-md-6 col-sm-12 mb-2" style="display: none;">
                                                        <label strong style="font-size: 14px;">Paid not Edited</label>
                                                        <div class="input-group input-group-merge">
                                                            <input type="number" name="constantpaidamount"
                                                                id="constantpaidamount" class="form-control"
                                                                placeholder=" Remain Amount" readonly />
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-3 col-md-6 col-sm-12 mb-2" style="display: none;">
                                                        <label strong style="font-size: 14px;">Prevoius Paid not
                                                            Edited</label>
                                                        <div class="input-group input-group-merge">
                                                            <input type="number" name="previousconstantpaidamount"
                                                                id="previousconstantpaidamount" class="form-control"
                                                                placeholder="Previous Paid Amount" readonly />
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-6 col-md-6 col-sm-12 mb-2">
                                                        <label strong style="font-size: 14px;">Purpose Of Payment <b
                                                                style="color:red;">*</b></label>
                                                        <div class="input-group input-group-merge">
                                                            <textarea class="form-control" id="purpose" placeholder="Write purpose here" name="purpose" rows="6"></textarea>
                                                        </div>
                                                        <span class="text-danger">
                                                            <strong id="purpose-error"></strong>
                                                        </span>
                                                    </div>

                                                    <div class="col-xl-6 col-md-6 col-sm-12 mb-2" id="amountdetailsdiv">
                                                        <label strong style="font-size: 14px;">Payment History<b
                                                                style="color:red;">*</b></label>
                                                        <table class="table-responsive">
                                                            <tr>
                                                                <td><label strong style="font-size: 12px;">Total Amount:
                                                                    </label></td>
                                                                <td><b><label id="pototalamount" strong
                                                                            style="font-size: 12px;"></label></b></td>
                                                            </tr>
                                                            <tr>
                                                                <td><label strong style="font-size: 12px;">Paid Amount:
                                                                    </label></td>
                                                                <td><b><label id="popaidamount" strong
                                                                            style="font-size: 12px;"></label></b></td>
                                                            </tr>
                                                            <tr>
                                                                <td><label strong style="font-size: 12px;">Remaining
                                                                        Amount: </label></td>
                                                                <td><b><label id="poremainamount" strong
                                                                            style="font-size: 12px;"></label></b></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2"><b><label id="poviewhistory" strong
                                                                            style="font-weight:bold;font-size:12px;text-decoration:underline;color:blue;"
                                                                            onclick="viewpaymenthistory()"><u>View Payment
                                                                                History</u></label></b></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                                <div class="row withitemsclass" style="display: none;">
                                        <div class="col-xl-4 col-lg-12">
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                                <div class="custom-control custom-control-primary custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="colorCheck1" unchecked />
                                                    <input type="hidden" name="withitems" id="withitems" placeholder="" class="form-control" readonly="true"/>
                                                    <label class="custom-control-label" for="colorCheck1">Is this payment request have a Goods?</label>
                                                </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                        </div>
                                </div>
                            <div class="row" id="directrow" style="display: none;">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="divider divider-info">
                                        <div class="divider-text">Goods</div>
                                    </div>
                                    <div class="table-responsive scroll scrdiv">
                                        <table id="directgoodsdynamictables" class="rtable mb-1" width="100%">
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
                                                    <th colspan="2"
                                                        style="text-align:left;background-color: #FFFFFF;border:none;padding:0px;">
                                                        <button type="button" name="goodadds" id="goodadds"
                                                            class="btn btn-success btn-sm"><i
                                                                data-feather='plus'></i>Add</button>
                                                    </th>
                                                    <th colspan="1" style="text-align: right;">Total</th>
                                                    <th class="qtytotal"></th>
                                                    <th class="unitpricetotal"></th>
                                                    <th class="goodpricetotal"></th>
                                                    <th></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-xl-9 col-lg-12">

                                </div>
                                <div class="col-xl-3 col-lg-12">
                                    <table style="width:100%;" class="rtable">

                                        <tr>
                                            <td style="text-align: right; width:50%;"><label strong
                                                    style="font-size: 16px;">Sub Total</label></td>
                                            <td style="text-align: center; width:50%;"><label id="goodsdirectsubtotalLbl"
                                                    class="lbl" strong
                                                    style="font-size: 16px; font-weight: bold;"></label></td>
                                        </tr>
                                        <tr id="goodsdirecttaxtr" style="display: none;">
                                            <td style="text-align: right;"><label strong
                                                    style="font-size: 16px;">Tax(15%)</label></td>
                                            <td style="text-align: center;"><label id="goodsdirecttaxLbl" strong
                                                    style="font-size: 16px; font-weight: bold;" class="lbl"></label>
                                            </td>

                                        </tr>
                                        <tr id="goodsdirectgrandtotaltr" style="display: none;">
                                            <td style="text-align: right;"><label strong style="font-size: 16px;">Grand
                                                    Total</label></td>
                                            <td style="text-align: center;"><label id="goodsdirectgrandtotalLbl" strong
                                                    style="font-size: 16px; font-weight: bold;" class="lbl"></label>
                                            </td>

                                        </tr>
                                        <tr id="directwitholdingTr" style="display: none;">
                                            <td style="text-align: right;"><label id="directwithodingTitleLbl" strong
                                                    style="font-size: 16px;">Withold(2%)</label></td>
                                            <td style="text-align: center;">
                                                <label id="goodsdirectwitholdingAmntLbl" class="formattedNum lbl" strong
                                                    style="font-size: 16px; font-weight: bold;"></label>
                                            </td>
                                        </tr>
                                        <tr id="goodsdirectvatTr" style="display: none;">
                                            <td style="text-align: right;"><label id="vatTitleLbl" strong
                                                    style="font-size: 16px;">Vat</label></td>
                                            <td style="text-align: center;">
                                                <label id="goodsvatAmntLbl" class="formattedNum lbl" strong
                                                    style="font-size: 16px; font-weight: bold;"></label>
                                            </td>
                                        </tr>
                                        <tr id="goodsdirectnetpayTr" style="display: none;">
                                            <td style="text-align: right;"><label strong style="font-size: 16px;">Net
                                                    Pay</label></td>
                                            <td style="text-align: center;">
                                                <label id="goodsdirectnetpayLbl" class="formattedNum lbl" strong
                                                    style="font-size: 16px; font-weight: bold;"></label>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td style="text-align: right;"><label strong style="font-size: 16px;">No. of
                                                    Items</label></td>
                                            <td style="text-align: center;"><label id="goodsdirectnumberofItemsLbl" strong
                                                    style="font-size: 16px; font-weight: bold;">0</label></td>

                                        </tr>
                                        <tr>
                                            <td colspan="3" style="text-align: center;">
                                                <div class="demo-inline-spacing">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input"
                                                            id="goodsdirectcustomCheck1" />
                                                        <label class="custom-control-label"
                                                            for="goodsdirectcustomCheck1">Taxable</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="row" id="commodityrow" style="display: none;">
                                <div class="col-xl-12 col-lg-12">
                                    <ul class="nav nav-tabs nav-justified" id="paymentrequestinfoapptabs" role="tablist">

                                        <li class="nav-item" id="initation">
                                            <a class="nav-link active" id="purchaseorderview-tab" data-toggle="tab"
                                                data-tab="1" href="#purchaseorderview"
                                                aria-controls="purchaseorderview" role="tab" aria-selected="true"
                                                onclick="payrtab('po');"> <i data-feather="home"></i>Payment
                                                Reference:Purchase Orders</a>
                                        </li>

                                        <li class="nav-item" id="tectnicaltab">
                                            <a class="nav-link" id="grnview-tab" data-toggle="tab" data-tab="2"
                                                href="#grnview" aria-controls="grnview" role="tab"
                                                aria-selected="false" onclick="payrtab('grn');"><i
                                                    data-feather="tool"></i>Payment Reference:Good Recieving</a>
                                        </li>

                                        <li class="nav-item" id="purchaseinvoicetab">
                                            <a class="nav-link" id="piview-tab" data-toggle="tab" data-tab="3"
                                                href="#piview" aria-controls="piview" role="tab"
                                                aria-selected="false" onclick="payrtab('pi');"><i
                                                    data-feather="codepen"></i>Payment Reference:Purchase Invoice</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="purchaseorderview"
                                            aria-labelledby="purchaseorderview-tab" role="tabpanel">
                                            <table class="table-responsive">

                                                <tr>
                                                    <td><label strong style="font-size: 12px;">Purchase Order#: </label>
                                                    </td>
                                                    <td><b><label id="payrinfopo" class="payrinfopo" strong
                                                                style="font-size: 12px;"></label></b></td>
                                                </tr>

                                            </table>
                                            <table id="purchaseorderinfodatatables" class="rtable mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Commodity</th>
                                                        <th>Crop Year</th>
                                                        <th>Preparation</th>
                                                        <th>Grade</th>
                                                        <th>UOM/Bag</th>
                                                        <th>No. of Bag</th>
                                                        <th>Bag weight Kg</th>
                                                        <th>Total KG</th>
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
                                                        <td colspan="4"
                                                            style="text-align:left;background-color: #FFFFFF;border:none;padding:0px;">
                                                        </td>
                                                        <th colspan="2" style="text-align: right;">Total</th>
                                                        <th id="ponofbagtotal"></th>
                                                        <th id="bagweighttotal"></th>
                                                        <th id="netkgtotal"></th>
                                                        <th id="pokgtotal"></th>
                                                        <th id="potontotal"></th>
                                                        <th id="poferesulatotal"></th>
                                                        <th id="popricetotal"></th>
                                                        <th id="pototalprice"></th>
                                                        <th></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <table id="goodsdynamictables" class="rtable mb-1" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Item</th>
                                                        <th>UOM</th>
                                                        <th>Qty.</th>
                                                        <th>Unit Price</th>
                                                        <th>Total Price</th>

                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="2"
                                                            style="text-align:left;background-color: #FFFFFF;border:none;padding:0px;">
                                                        </th>
                                                        <th colspan="1" style="text-align: right;">Total</th>
                                                        <th id="qtytotal"></th>
                                                        <th id="unitpricetotal"></th>
                                                        <th id="goodpricetotal"></th>

                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <div class="row">
                                                <div class="col-xl-9 col-lg-12"></div>
                                                <div class="col-xl-3 col-lg-12">
                                                    <table style="width:100%;" id="directinfopricetable"
                                                        class="rtable mt-1">
                                                        <tr>
                                                            <td style="text-align: right; width:50%;"><label strong
                                                                    style="font-size: 16px;">Sub Total</label></td>
                                                            <td style="text-align: center; width:50%;"><label
                                                                    id="payrdirectinfosubtotalLbl" strong
                                                                    style="font-size: 16px; font-weight: bold;"></label>
                                                            </td>

                                                        </tr>
                                                        <tr id="supplierinfotaxtr" style="display: visible;">
                                                            <td style="text-align: right;"><label strong
                                                                    style="font-size: 16px;">Tax(15%)</label></td>
                                                            <td style="text-align: center;"><label
                                                                    id="payrdirectinfotaxLbl" strong
                                                                    style="font-size: 16px; font-weight: bold;"></label>
                                                            </td>

                                                        </tr>
                                                        <tr id="supplierinforandtotaltr" style="display: visible;">
                                                            <td style="text-align: right;"><label strong
                                                                    style="font-size: 16px;">Grand Total</label></td>
                                                            <td style="text-align: center;"><label
                                                                    id="payrdirectinfograndtotalLbl" strong
                                                                    style="font-size: 16px; font-weight: bold;"></label>
                                                            </td>

                                                        </tr>
                                                        <tr id="visibleinfowitholdingTr" style="display: visible;">
                                                            <td style="text-align: right;"><label id="withodingTitleLbl"
                                                                    strong style="font-size: 16px;">Withold(2%)</label>
                                                            </td>
                                                            <td style="text-align: center;">
                                                                <label id="payrdirectinfowitholdingAmntLbl"
                                                                    class="formattedNum" strong
                                                                    style="font-size: 16px; font-weight: bold;"></label>

                                                            </td>
                                                        </tr>

                                                        <tr id="directinfonetpayTr" style="display: visible;">
                                                            <td style="text-align: right;"><label strong
                                                                    style="font-size: 16px;">Net Pay</label></td>
                                                            <td style="text-align: center;">
                                                                <label id="payrdirectinfonetpayLbl" class="formattedNum"
                                                                    strong style="font-size: 16px; font-weight: bold;"
                                                                    class="lbl"></label>

                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td style="text-align: right;"><label strong
                                                                    style="font-size: 16px;">No. of Items</label></td>
                                                            <td style="text-align: center;"><label
                                                                    id="directinfonumberofItemsLbl" strong
                                                                    style="font-size: 16px; font-weight: bold;">0</label>
                                                            </td>

                                                        </tr>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="grnview" aria-labelledby="grnview-tab"
                                            role="tabpanel">
                                            <div id="commuditylistdatablediv" class="scroll scrdiv">
                                                <table class="table-responsive">

                                                    <tr>
                                                        <td><label strong style="font-size: 12px;">Purchase Order#:
                                                            </label></td>
                                                        <td><b><label id="payrinfopo" class="payrinfopo" strong
                                                                    style="font-size: 12px;"></label></b></td>
                                                    </tr>

                                                </table>
                                                <table id="directdynamicTablecommdity" class="rtable mb-0"
                                                    width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Good Recieving#</th>
                                                            <th class="pivclass">Purchase Invoice#</th>
                                                            <th>Commodity</th>
                                                            <th>Crop Year</th>
                                                            <th>Preparation</th>
                                                            <th>Grade</th>
                                                            <th>UOM/Bag</th>
                                                            <th>No of Bag</th>
                                                            <th>Bag Weight(Kg)</th>
                                                            <th>Total KG</th>
                                                            <th>Net KG</th>
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
                                                            <td class="tdcolspan" id="tdcolspan" colspan="6"
                                                                style="text-align:left;background-color: #FFFFFF;border:none;padding:0px;">
                                                            </td>
                                                            <th colspan="2" style="text-align: right;">Total</th>
                                                            <th id="nofbagtotal"></th>
                                                            <th id="recivebagweighttotal"></th>
                                                            <th id="kgtotal"></th>
                                                            <th id="recivenetkgtotal"></th>
                                                            <th id="tontotal"></th>
                                                            <th id="priceferesula"></th>
                                                            <th id="pricetotal"></th>
                                                            <th id="totalpricetotal"></th>
                                                            <th></th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                                <div class="row">
                                                    <div class="col-xl-9 col-lg-12">
                                                    </div>
                                                    <div class="col-xl-3 col-lg-12">
                                                        <table style="width:100%;" id="directpricetable"
                                                            class="rtable mt-1">
                                                            <tr>
                                                                <td style="text-align: right; width:50%;"><label strong
                                                                        style="font-size: 16px;">Sub Total</label></td>
                                                                <td style="text-align: center; width:50%;"><label
                                                                        id="directsubtotalLbl" class="lbl" strong
                                                                        style="font-size: 16px; font-weight: bold;"></label>
                                                                </td>
                                                            </tr>
                                                            <tr id="directtaxtr" style="display: visible;">
                                                                <td style="text-align: right;"><label strong
                                                                        style="font-size: 16px;">Tax(15%)</label></td>
                                                                <td style="text-align: center;"><label id="directtaxLbl"
                                                                        strong style="font-size: 16px; font-weight: bold;"
                                                                        class="lbl"></label></td>
                                                            </tr>
                                                            <tr id="directgrandtotaltr" style="display: visible;">
                                                                <td style="text-align: right;"><label strong
                                                                        style="font-size: 16px;">Grand Total</label></td>
                                                                <td style="text-align: center;"><label
                                                                        id="directgrandtotalLbl" strong
                                                                        style="font-size: 16px; font-weight: bold;"
                                                                        class="lbl"></label></td>
                                                            </tr>
                                                            <tr id="directwitholdingTr" style="display: visible;">
                                                                <td style="text-align: right;"><label
                                                                        id="directwithodingTitleLbl" strong
                                                                        style="font-size: 16px;">Withold(2%)</label></td>
                                                                <td style="text-align: center;">
                                                                    <label id="directwitholdingAmntLbl"
                                                                        class="formattedNum lbl" strong
                                                                        style="font-size: 16px; font-weight: bold;"></label>
                                                                </td>
                                                            </tr>
                                                            <tr id="directvatTr" style="display: none;">
                                                                <td style="text-align: right;"><label id="vatTitleLbl"
                                                                        strong style="font-size: 16px;">Vat</label></td>
                                                                <td style="text-align: center;">
                                                                    <label id="vatAmntLbl" class="formattedNum lbl" strong
                                                                        style="font-size: 16px; font-weight: bold;"></label>
                                                                </td>
                                                            </tr>
                                                            <tr id="directnetpayTr" style="display: visible;">
                                                                <td style="text-align: right;"><label strong
                                                                        style="font-size: 16px;">Net Pay</label></td>
                                                                <td style="text-align: center;">
                                                                    <label id="directnetpayLbl" class="formattedNum lbl"
                                                                        strong
                                                                        style="font-size: 16px; font-weight: bold;"></label>

                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td style="text-align: right;"><label strong
                                                                        style="font-size: 16px;">No. Of Products</label>
                                                                </td>
                                                                <td style="text-align: center;"><label
                                                                        id="directnumberofItemsLbl" strong
                                                                        style="font-size: 16px; font-weight: bold;">0</label>
                                                                </td>
                                                            </tr>
                                                            <tr id="hidewitholdTr" style="display: none;">
                                                                <td colspan="3" style="text-align: center;">
                                                                    <div class="demo-inline-spacing">
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox"
                                                                                class="custom-control-input"
                                                                                id="directcustomCheck1" />
                                                                            <label class="custom-control-label"
                                                                                for="directcustomCheck1">Taxable</label>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="piview" aria-labelledby="piview-tab"
                                            role="tabpanel">

                                        </div>
                                    </div>
                                    <br>

                                </div>

                            </div>
                        </div>
                        <div style="display: none;">
                            <input type="text" placeholder="" class="form-control" name="payrid" id="payrid"
                                readonly="true" value="" />
                            <input type="text" placeholder="" class="form-control" name="documentnumber"
                                id="documentnumber" readonly />
                            <input type="text" placeholder="" class="form-control" name="referencenohidden"
                                id="referencenohidden" readonly />
                            <input type="text" placeholder="" class="form-control" name="supplierhidden"
                                id="supplierhidden" readonly />
                            <input type="text" placeholder="" class="form-control" name="isdataexistornot"
                                id="isdataexistornot" readonly />
                            <input type="text" placeholder="" class="form-control" name="isgrnexistornot"
                                id="isgrnexistornot" readonly />
                            <input type="text" placeholder="" class="form-control" name="directsubtotali"
                                id="directsubtotali" readonly />
                            <input type="text" placeholder="" class="form-control" name="directtaxi" id="directtaxi"
                                readonly />
                            <input type="text" placeholder="" class="form-control" name="directgrandtotali"
                                id="directgrandtotali" readonly />
                            <input type="text" placeholder="" class="form-control" name="directwitholdingAmntin"
                                id="directwitholdingAmntin" readonly />
                            <input type="text" placeholder="" class="form-control" name="directvatAmntin"
                                id="directvatAmntin" readonly />
                            <input type="text" placeholder="" class="form-control" name="directnetpayin"
                                id="directnetpayin" readonly />
                            <input type="text" placeholder="" class="form-control" name="directistaxable"
                                id="directistaxable" readonly />
                        </div>
                    </div>
                    <div class="modal-footer">
                        @canany(['PYR-Add', 'PYR-Edit'])
                            <button id="savebutton" type="submit" class="btn btn-outline-dark"><i id="savedicon"
                                    class="fa-sharp fa-solid fa-floppy-disk"></i> <span>Save</span></button>
                        @endcanany

                        <button id="closebutton" type="button" class="btn btn-outline-danger"
                            onclick="closeinlineFormModalWithClearValidation()" data-dismiss="modal"><i
                                class="fa-regular fa-xmark"></i> Close</button>
                    </div>
                </div>
        </div>
        </form>
    </div>
    <div class="modal fade" id="paymentrequestinfomodal" tabindex="-1" aria-labelledby="exampleModalScrollableTitle"
        aria-hidden="true" data-backdrop="static" style="display: none;">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Payment Request Information</h5>
                    <div class="row">
                        <div style="text-align: right;" id="paymentrequestinfoStatus"></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            onclick="refreshmaintables();">
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
                                        <div class="card-header" id="headingOne" data-toggle="collapse" role="button"
                                            data-target="#payrcollapseOne" aria-expanded="false"
                                            aria-controls="payrcollapseOne">
                                            <span class="lead collapse-title">Payment Request Details</span>
                                            <span id="" style="font-size:16px;"></span>
                                        </div>
                                        <div id="payrcollapseOne" class="collapse" aria-labelledby="headingOne"
                                            data-parent="#accordionExample">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-xl-3 col-lg-12"
                                                        style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h6 class="card-title">Payment Request Information</h6>
                                                            </div>
                                                            <div class="card-body scroll scrdiv" style="height:18rem;">
                                                                <table class="table-responsive">
                                                                    <tr>
                                                                        <td><label strong style="font-size: 12px;">Payment
                                                                                Request No: </label></td>
                                                                        <td><b><label id="parydocno" strong
                                                                                    style="font-size: 12px;"></label></b>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label strong
                                                                                style="font-size: 12px;">Reference:
                                                                            </label></td>
                                                                        <td><b><label id="payrinforefernce" strong
                                                                                    style="font-size: 12px;"></label></b>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="poinfocmdtyclass">
                                                                        <td><label strong style="font-size: 12px;">Puchase
                                                                                Order#: </label></td>
                                                                        <td><b><label id="payrinfoporder" strong
                                                                                    style="font-size: 12px;"
                                                                                    class="paymentrequestinfopo" strong
                                                                                    style="font-size: 16px; font-weight: bold;"></label></b>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label strong style="font-size: 12px;">Payment
                                                                                Reference: </label></td>
                                                                        <td><b><label class="paymentrefernceclass" strong
                                                                                    style="font-size: 12px;"></label></b>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label strong style="font-size: 12px;">Item
                                                                                Type: </label></td>
                                                                        <td><b><label class="itemtype" strong
                                                                                    style="font-size: 12px;"></label></b>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="infocmdtyclass">
                                                                        <td><label strong
                                                                                style="font-size: 12px;">Commodity Type:
                                                                            </label></td>
                                                                        <td><b><label id="payrinfocommoditype" strong
                                                                                    style="font-size: 12px;"></label></b>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="infocmdtyclass">
                                                                        <td><label strong
                                                                                style="font-size: 12px;">Commodity Source:
                                                                            </label></td>
                                                                        <td><b><label id="payrinfocommoditysource" strong
                                                                                    style="font-size: 12px;"></label></b>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="infocmdtyclass">
                                                                        <td><label strong
                                                                                style="font-size: 12px;">Commodity Status:
                                                                            </label></td>
                                                                        <td><b><label id="payrinfocommoditystatus" strong
                                                                                    style="font-size: 12px;"></label></b>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label strong style="font-size: 12px;">Prepare
                                                                                Date: </label></td>
                                                                        <td><b><label id="payrinfodocumentdate" strong
                                                                                    style="font-size: 12px;"></label></b>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-12" id="directsupplyinformationdiv"
                                                        style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;display:visible;">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h6 class="card-title">Supplier Information</h6>
                                                            </div>
                                                            <div class="card-body scroll scrdiv" style="height:18rem;">

                                                                <table style="width: 100%">
                                                                    <tr>
                                                                        <td><label strong style="font-size: 12px;">ID:
                                                                            </label></td>
                                                                        <td><b><label id="paymentrequestinfosuppid" strong
                                                                                    style="font-size: 12px;"></label></b>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label strong style="font-size: 12px;">Name:
                                                                            </label></td>
                                                                        <td><b><label id="paymentrequestinfsupname" strong
                                                                                    style="font-size: 12px;"></label></b>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label strong style="font-size: 12px;">TIN:
                                                                            </label></td>
                                                                        <td><b><label id="paymentrequestinfosupptin"
                                                                                    strong
                                                                                    style="font-size: 12px;"></label></b>
                                                                        </td>
                                                                    </tr>

                                                                </table>

                                                                <div class="divider divider-secondary">
                                                                    <div class="divider-text"><b>Memo</b></div>
                                                                </div>

                                                                <table class="table-responsive">

                                                                    <tr>
                                                                        <td><label id="paymentrequestinfomemo"
                                                                                class="paymentrequestinfopurpose" strong
                                                                                style="font-size: 12px;"></label></td>
                                                                    </tr>

                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-12"
                                                        style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h6 class="card-title">Attached Document</h6>
                                                            </div>
                                                            <div class="card-body scroll scrdiv" style="height:18rem;">
                                                                <iframe src="" id="pdfviewer" width="100%"
                                                                    height="400px"></iframe>
                                                            </div>

                                                        </div>

                                                    </div>
                                                    <div class="col-xl-2 col-lg-3"
                                                        style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;height:20rem">
                                                        <h5>Actions</h5>
                                                        <div class="scroll scrdiv">
                                                            <ul class="timeline" id="paymentrequestulist"
                                                                style="height:18rem;">

                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12" id="paymentinfordirectprice">
                                <div class="divider divider-secondary">
                                    <div class="divider-text directdivider">Payment Details</div>
                                </div>
                                <div class="row" id="withitemsrow">
                                    <div class="col-xl-12 col-lg-12">
                                        <table id="withandwithoutgoodsinfodatatables"
                                            class="display table-bordered table-striped table-hover dt-responsive mb-0">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Item Code</th>
                                                    <th>Item Name</th>
                                                    <th>Barcode</th>
                                                    <th>UOM</th>
                                                    <th>Quantity</th>
                                                    <th>Unit Price</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="5" style="text-align: right;">Total</th>
                                                    <th class="infoqtytotal"></th>
                                                    <th class="infounitpreicetotal"></th>
                                                    <th class="infototal"></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>

                                    <div class="col-xl-9 col-lg-12"></div>

                                    <div class="col-xl-3 col-lg-12 mt-1">
                                        <table style="width:100%;" class="rtable">
                                            <tr>
                                                <td style="text-align: right; width:50%;"><label strong
                                                        style="font-size: 16px;">Sub Total</label></td>
                                                <td style="text-align: center; width:50%;"><label
                                                        id="withitemsgoodsdirectsubtotalLbl" class="lbl" strong
                                                        style="font-size: 16px; font-weight: bold;"></label></td>
                                            </tr>
                                            <tr id="withitemsgoodsdirecttaxtr" style="display: visible;">
                                                <td style="text-align: right;"><label strong
                                                        style="font-size: 16px;">Tax(15%)</label></td>
                                                <td style="text-align: center;"><label id="withitemsgoodsdirecttaxLbl"
                                                        strong style="font-size: 16px; font-weight: bold;"
                                                        class="lbl"></label></td>
                                            </tr>
                                            <tr id="withitemsgoodsdirectgrandtotaltr" style="display: visible;">
                                                <td style="text-align: right;"><label strong
                                                        style="font-size: 16px;">Grand Total</label></td>
                                                <td style="text-align: center;"><label
                                                        id="withitemsgoodsdirectgrandtotalLbl" strong
                                                        style="font-size: 16px; font-weight: bold;"
                                                        class="lbl"></label></td>
                                            </tr>
                                            <tr id="withitemsgoodsdirectwitholdingTr" style="display: visible;">
                                                <td style="text-align: right;"><label strong
                                                        style="font-size: 16px;">Withold(2%)</label></td>
                                                <td style="text-align: center;">
                                                    <label id="withitemsgoodsdirectwitholdingAmntLbl"
                                                        class="formattedNum lbl" strong
                                                        style="font-size: 16px; font-weight: bold;"></label>
                                                </td>
                                            </tr>
                                            <tr id="withitemsgoodsdirectvatTr" style="display: none;">
                                                <td style="text-align: right;"><label id="vatTitleLbl" strong
                                                        style="font-size: 16px;">Vat</label></td>
                                                <td style="text-align: center;">
                                                    <label id="withitemsgoodsdirectAmntLbl" class="formattedNum lbl"
                                                        strong style="font-size: 16px; font-weight: bold;"></label>
                                                </td>
                                            </tr>
                                            <tr id="withitemsgoodsdirectnetpayTr" style="display: visible;">
                                                <td style="text-align: right;"><label strong
                                                        style="font-size: 16px;">Net Pay</label></td>
                                                <td style="text-align: center;">
                                                    <label id="withitemsgoodsdirectnetpayLbl" class="formattedNum lbl"
                                                        strong style="font-size: 16px; font-weight: bold;"></label>

                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="text-align: right;"><label strong
                                                        style="font-size: 16px;">No. Of Products</label></td>
                                                <td style="text-align: center;"><label
                                                        id="withitemsgoodsdirectnumberofItemsLbl" strong
                                                        style="font-size: 16px; font-weight: bold;">0</label></td>
                                            </tr>
                                        </table>
                                    </div>

                                </div>
                                <div class="row" id="withoutitemsrow">
                                    <div class="col-xl-3 col-lg-12">
                                    </div>
                                    <div class="col-xl-4 col-lg-12">
                                        <table style="width:100%;" class="rtable">
                                            <tr>
                                                <td colspan="2" style="text-align: center;"><b>Payment
                                                        Information</b></td>
                                            </tr>

                                            <tr>
                                                <td style="text-align: right; width:25%;"><label strong
                                                        style="font-size: 16px;">Payment Reference</label></td>
                                                <td style="text-align: center; width:25%;"><label id="" strong
                                                        style="font-size: 16px; font-weight: bold;"> Direct</label></td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: right; width:25%;"><label strong
                                                        style="font-size: 16px;">Payment Mode</label></td>
                                                <td style="text-align: center; width:25%;"><label id="" strong
                                                        style="font-size: 16px; font-weight: bold;">Pre Finance</label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: right; width:25%;"><label strong
                                                        style="font-size: 16px;">To be paid</label></td>
                                                <td style="text-align: center; width:25%;"><label
                                                        id="directpopayrinfopaidamount" strong
                                                        style="font-size: 16px; font-weight: bold;"></label></td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: right; width:25%;"><label strong
                                                        style="font-size: 16px;">Payment Status</label></td>
                                                <td style="text-align: center; width:25%;"><label id="" strong
                                                        style="font-size: 16px; font-weight: bold;">Direct</label></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-xl-4 col-lg-12">
                                        <table class="table-responsive">
                                            <tr style="text-align: center;">
                                                <td><label strong style="font-size: 12px;"><b>Purpose of
                                                            payment</b></label></td>
                                            </tr>
                                            <tr>
                                                <td><label id="directpaymentrequestinfopurpose"
                                                        class="paymentrequestinfopurpose" strong
                                                        style="font-size: 12px;"></label></td>
                                            </tr>

                                        </table>
                                    </div>
                                    <div class="col-xl-5 col-lg-12">

                                    </div>
                                </div>
                            </div>
                            <div class="divider divider-secondary" id="dividerinfo">
                                <div class="divider-text directdivider">Commodity</div>
                            </div>
                            <div class="col-xl-12 col-lg-12" id="commodityrowinfo">
                                <ul class="nav nav-tabs nav-justified" id="payrinfoapptabs" role="tablist">

                                    <li class="nav-item" id="payrinfoinitation">
                                        <a class="nav-link active" id="payrinfopurchaseorderview-tab"
                                            data-toggle="tab" data-tab="1" href="#payrinfopurchaseorderview"
                                            aria-controls="payrinfopurchaseorderview" role="tab"
                                            aria-selected="true"> <i data-feather="home"></i>Payment Reference: Purchase
                                            Orders</a>
                                    </li>

                                    <li class="nav-item" id="payrinfotectnicaltab">
                                        <a class="nav-link" id="payrinfogrnview-tab" data-toggle="tab"
                                            data-tab="2" href="#payrinfogrnview" aria-controls="payrinfogrnview"
                                            role="tab" aria-selected="false"><i data-feather="tool"></i>Payment
                                            Reference: Good Reciving</a>
                                    </li>

                                    <li class="nav-item" id="payrinfofinancialtab">
                                        <a class="nav-link" id="payrinfopiview-tab" data-toggle="tab" data-tab="3"
                                            href="#payrinfopiview" aria-controls="payrinfopiview" role="tab"
                                            aria-selected="false"><i data-feather="codepen"></i>Payment Reference:
                                            Purchase Invoice</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="payrinfopurchaseorderview"
                                        aria-labelledby="payrinfopurchaseorderview-tab" role="tabpanel">
                                        <div class="directcommudityinfodatatablesdiv">
                                            <table id="payrinfopurchaseorderinfodatatables"
                                                class="display table-bordered table-striped table-hover dt-responsive mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Commodity</th>
                                                        <th>Grade</th>
                                                        <th>Preparation</th>
                                                        <th>Crop Year</th>
                                                        <th>UOM/Bag</th>
                                                        <th>No. of Bag</th>
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
                                                <tbody></tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="4"
                                                            style="text-align:left;background-color: #FFFFFF;border:none;padding:0px;">
                                                        </td>
                                                        <th colspan="2" style="text-align: right;">Total</th>
                                                        <th id="poinfonofbagtotal"></th>
                                                        <th id="poinfonofbagweighttotal"></th>
                                                        <th id="poinfokgtotal"></th>
                                                        <th id="poinfotontotal"></th>
                                                        <th id="poinfopriceferesula"></th>
                                                        <th id="poinfopricetotal"></th>
                                                        <th id="poinfototalpricetotal"></th>
                                                        <th id="topinfototalpricetotal"></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>

                                        <div class="directgoodsinfodatatablesdiv">
                                            <table id="directgoodsinfodatatables"
                                                class="display table-bordered table-striped table-hover dt-responsive mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Item Code</th>
                                                        <th>Item Name</th>
                                                        <th>Barcode</th>
                                                        <th>UOM</th>
                                                        <th>Quantity</th>
                                                        <th>Unit Price</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="5" style="text-align: right;">Total</th>
                                                        <th id="infoqtytotal"></th>
                                                        <th id="infounitpreicetotal"></th>
                                                        <th id="infototal"></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-9 col-lg-12">
                                                <div class="divider divider-secondary">
                                                    <div class="divider-text directdivider">Payment Details</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-8 col-lg-12">
                                                        <table style="width:100%;" class="rtable">
                                                            <tr>
                                                                <td colspan="4" style="text-align: center;">
                                                                    <b>Payment Information</b><br>
                                                                    <label>Purchase Order#</label><label
                                                                        class="paymentrequestinfopo" strong
                                                                        style="font-size: 16px; font-weight: bold;"></label>

                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2"
                                                                    style="text-align: center; width:25%;"><label strong
                                                                        style="font-size: 16px;"><b>Payment
                                                                            Request</b></label></td>
                                                                <td colspan="2"
                                                                    style="text-align: center; width:25%;"><label strong
                                                                        style="font-size: 16px;"><b>Payment
                                                                            History</b></label></td>

                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: right; width:25%;"><label strong
                                                                        style="font-size: 16px;">Payment Reference</label>
                                                                </td>
                                                                <td style="text-align: center; width:25%;"><label
                                                                        id="payrinfopaymentreference"
                                                                        class="paymentrefernceclass" strong
                                                                        style="font-size: 16px;"></label></td>

                                                                <td style="text-align: right; width:25%;"><label strong
                                                                        style="font-size: 16px;">Total Amount</label></td>
                                                                <td style="text-align: center; width:25%;"><label
                                                                        id="popayrinfototalamount" class="lbl" strong
                                                                        style="font-size: 16px;"></label></td>
                                                            </tr>
                                                            <tr>

                                                                <td style="text-align: right; width:25%;"><label strong
                                                                        style="font-size: 16px;">To be paid</label></td>
                                                                <td style="text-align: center; width:25%;"><label
                                                                        id="popayrinfopaidamount" class="lbl" strong
                                                                        style="font-size: 16px; font-weight: bold;"></label>
                                                                </td>
                                                                <td style="text-align: right; width:25%;"><label strong
                                                                        style="font-size: 16px;">Paid Amount</label></td>
                                                                <td style="text-align: center; width:25%;"><label
                                                                        id="popayrinfototalpayamount"
                                                                        class="lbl infopaidamount" strong
                                                                        style="font-size: 16px; "></label></td>

                                                            </tr>
                                                            <tr>

                                                                <td style="text-align: right; width:25%;"><label strong
                                                                        style="font-size: 16px;">Payment Mode</label></td>
                                                                <td style="text-align: center; width:25%;"><label
                                                                        id="popayrinfopaymentmode" class="lbl" strong
                                                                        style="font-size: 16px;"></label></td>

                                                                <td style="text-align: right; width:25%;"><label strong
                                                                        style="font-size: 16px;">Remaining Amount</label>
                                                                </td>
                                                                <td style="text-align: center; width:25%;"><label
                                                                        id="popayrinforemainamount"
                                                                        class="lbl inforemainamount" strong
                                                                        style="font-size: 16px;"></label></td>

                                                            </tr>

                                                            <tr>
                                                                <td style="text-align: right; width:25%;"><label strong
                                                                        style="font-size: 16px;">Payment Status</label>
                                                                </td>
                                                                <td style="text-align: center; width:25%;"><label
                                                                        id="popayrinfopaymentstatus" class="lbl"
                                                                        strong style="font-size: 16px;"></label></td>
                                                                <td colspan="2"
                                                                    style="text-align: center; width:25%;"><label strong
                                                                        style="font-size: 16px;font-weight: bold;"
                                                                        id="popayrinfoviewpaymenthistory"></label></td>
                                                            </tr>

                                                        </table>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-12">
                                                        <table class="table-responsive">
                                                            <tr style="text-align: center;">
                                                                <td><label strong style="font-size: 12px;"><b>Purpose Of
                                                                            Payment</b></label></td>
                                                            </tr>
                                                            <tr>
                                                                <td><label id="paymentrequestinfopurpose"
                                                                        class="paymentrequestinfopurpose" strong
                                                                        style="font-size: 12px;"></label></td>
                                                            </tr>

                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-lg-12">
                                                <table style="width:100%;" id="payrinfodirectinfopricetable"
                                                    class="rtable mt-1">
                                                    <tr>
                                                        <td style="text-align: right; width:50%;"><label strong
                                                                style="font-size: 16px;">Sub Total</label></td>
                                                        <td style="text-align: center; width:50%;"><label
                                                                id="payrinfodirectinfosubtotalLbl" strong
                                                                style="font-size: 16px; font-weight: bold;"></label></td>

                                                    </tr>
                                                    <tr id="payrinfosupplierinfotaxtr" style="display: visible;">
                                                        <td style="text-align: right;"><label strong
                                                                style="font-size: 16px;">Tax(15%)</label></td>
                                                        <td style="text-align: center;"><label
                                                                id="payrinfodirectinfotaxLbl" strong
                                                                style="font-size: 16px; font-weight: bold;"></label></td>

                                                    </tr>
                                                    <tr id="payrinfosupplierinforandtotaltr" style="display: visible;">
                                                        <td style="text-align: right;"><label strong
                                                                style="font-size: 16px;">Grand Total</label></td>
                                                        <td style="text-align: center;"><label
                                                                id="payrinfodirectinfograndtotalLbl" strong
                                                                style="font-size: 16px; font-weight: bold;"></label></td>

                                                    </tr>
                                                    <tr id="payrinfovisibleinfowitholdingTr" style="display: visible;">
                                                        <td style="text-align: right;"><label id="withodingTitleLbl"
                                                                strong style="font-size: 16px;">Withold(2%)</label></td>
                                                        <td style="text-align: center;">
                                                            <label id="payrinfodirectinfowitholdingAmntLbl"
                                                                class="formattedNum" strong
                                                                style="font-size: 16px; font-weight: bold;"></label>

                                                        </td>
                                                    </tr>

                                                    <tr id="payrinfodirectinfonetpayTr" style="display: visible;">
                                                        <td style="text-align: right;"><label strong
                                                                style="font-size: 16px;">Net Pay</label></td>
                                                        <td style="text-align: center;">
                                                            <label id="payrinfodirectinfonetpayLbl" class="formattedNum"
                                                                strong style="font-size: 16px; font-weight: bold;"
                                                                class="lbl"></label>

                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td style="text-align: right;"><label strong
                                                                style="font-size: 16px;">No. of Items</label></td>
                                                        <td style="text-align: center;"><label
                                                                id="payrinfodirectinfonumberofItemsLbl" strong
                                                                style="font-size: 16px; font-weight: bold;">0</label></td>

                                                    </tr>

                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="tab-pane" id="payrinfogrnview" aria-labelledby="payrinfogrnview-tab"
                                        role="tabpanel">
                                        <div id="commuditylistdatablediv" class="scroll scrdiv">
                                            <table id="payrinfodirectdynamicTablecommdity"
                                                class="display table-bordered table-striped table-hover dt-responsive mb-0"
                                                width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Good Recieving#</th>
                                                        <th>Purchase Invoice#</th>
                                                        <th>Commodity</th>
                                                        <th>Grade</th>
                                                        <th>Preparation</th>
                                                        <th>Crop year</th>
                                                        <th>UOM/Bag</th>
                                                        <th>No of Bag</th>
                                                        <th>Bag Weight(Kg)</th>
                                                        <th>Total KG</th>
                                                        <th>Net KG</th>
                                                        <th>TON</th>
                                                        <th>Feresula</th>
                                                        <th>Unit Price</th>
                                                        <th>Total</th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="6"
                                                            style="text-align:left;background-color: #FFFFFF;border:none;padding:0px;">
                                                        </td>
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

                                                <div class="col-xl-9 col-lg-12">
                                                    <div class="divider divider-secondary">
                                                        <div class="divider-text directdivider">Payment Details</div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xl-8 col-lg-12">
                                                            <table style="width:100%;" class="rtable">
                                                                <tr>
                                                                    <td colspan="4" style="text-align: center;">
                                                                        <b>Payment Information</b><br>
                                                                        <label>Purchase Order#</label><label
                                                                            class="paymentrequestinfopo" strong
                                                                            style="font-size: 16px; font-weight: bold;"></label>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2"
                                                                        style="text-align: center; width:25%;"><label
                                                                            strong style="font-size: 16px;"><b>Payment
                                                                                Request</b></label></td>

                                                                    <td colspan="2"
                                                                        style="text-align: center; width:25%;"><label
                                                                            strong style="font-size: 16px;"><b>Payment
                                                                                History</b></label></td>

                                                                </tr>

                                                                <tr>
                                                                    <td style="text-align: right; width:25%;"><label
                                                                            strong style="font-size: 16px;">Payment
                                                                            Reference</label></td>
                                                                    <td style="text-align: center; width:25%;"><label
                                                                            id="payrinfopaymentreference"
                                                                            class="paymentrefernceclass" strong
                                                                            style="font-size: 16px; "></label></td>

                                                                    <td style="text-align: right; width:25%;"><label
                                                                            strong style="font-size: 16px;">Total
                                                                            Amount</label></td>
                                                                    <td style="text-align: center; width:25%;"><label
                                                                            id="payrinfototalpayamount" class="lbl"
                                                                            strong style="font-size: 16px;"></label></td>

                                                                </tr>
                                                                <tr>

                                                                    <td style="text-align: right; width:25%;"><label
                                                                            strong style="font-size: 16px;">To be
                                                                            paid</label></td>
                                                                    <td style="text-align: center; width:25%;"><label
                                                                            id="payrinfopaidamount" class="lbl"
                                                                            strong
                                                                            style="font-size: 16px; font-weight: bold;"></label>
                                                                    </td>

                                                                    <td style="text-align: right; width:25%;"><label
                                                                            strong style="font-size: 16px;">Paid
                                                                            Amount</label></td>
                                                                    <td style="text-align: center; width:25%;"><label
                                                                            id="payrinfopayamount"
                                                                            class="lbl infopaidamount" strong
                                                                            style="font-size: 16px; "></label></td>


                                                                </tr>
                                                                <tr>
                                                                    <td style="text-align: right; width:25%;"><label
                                                                            strong style="font-size: 16px;">Payment
                                                                            Status</label></td>
                                                                    <td style="text-align: center; width:25%;"><label
                                                                            id="payrinfopaymentstatus" strong
                                                                            style="font-size: 16px;"></label></td>

                                                                    <td style="text-align: right; width:25%;"><label
                                                                            strong style="font-size: 16px;">Remaining
                                                                            Amount</label></td>
                                                                    <td style="text-align: center; width:25%;"><label
                                                                            id="payrinforemainamount"
                                                                            class="lbl inforemainamount" strong
                                                                            style="font-size: 16px;"></label></td>

                                                                </tr>
                                                                <tr>
                                                                    <td style="text-align: right; width:25%;"><label
                                                                            strong style="font-size: 16px;">Payment
                                                                            Mode</label></td>
                                                                    <td style="text-align: center; width:25%;"><label
                                                                            id="payrinfopaymentmode" class="lbl"
                                                                            strong style="font-size: 16px; "></label></td>
                                                                    <td colspan="2"
                                                                        style="text-align: center; width:25%;"><label
                                                                            strong
                                                                            style="font-size: 16px;font-weight: bold;"
                                                                            id="payrinfoviewpaymenthistory"></label></td>

                                                                </tr>


                                                            </table>

                                                        </div>
                                                        <div class="col-xl-4 col-lg-12">
                                                            <table style="width:100%;">
                                                                <tr style="text-align: center;">
                                                                    <td><label strong style="font-size: 12px;"><b>Purpose
                                                                                Of Payment</b> </label></td>

                                                                </tr>

                                                                <tr>
                                                                    <td><label id="paymentrequestinfopurpose"
                                                                            class="paymentrequestinfopurpose" strong
                                                                            style="font-size: 12px;"></label></td>
                                                                </tr>
                                                            </table>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="col-xl-3 col-lg-12 mt-1">
                                                    <table style="width:100%;" id="directpricetable" class="rtable">
                                                        <tr>
                                                            <td style="text-align: right; width:50%;"><label strong
                                                                    style="font-size: 16px;">Sub Total</label></td>
                                                            <td style="text-align: center; width:50%;"><label
                                                                    id="grndirectsubtotalLbl" class="lbl" strong
                                                                    style="font-size: 16px; font-weight: bold;"></label>
                                                            </td>
                                                        </tr>
                                                        <tr id="infodirecttaxtr" style="display: visible;">
                                                            <td style="text-align: right;"><label strong
                                                                    style="font-size: 16px;">Tax(15%)</label></td>
                                                            <td style="text-align: center;"><label id="grndirecttaxLbl"
                                                                    strong style="font-size: 16px; font-weight: bold;"
                                                                    class="lbl"></label></td>
                                                        </tr>
                                                        <tr id="grndirectgrandtotaltr" style="display: visible;">
                                                            <td style="text-align: right;"><label strong
                                                                    style="font-size: 16px;">Grand Total</label></td>
                                                            <td style="text-align: center;"><label
                                                                    id="grndirectgrandtotalLbl" strong
                                                                    style="font-size: 16px; font-weight: bold;"
                                                                    class="lbl"></label></td>
                                                        </tr>
                                                        <tr id="grndirectwitholdingTr" style="display: visible;">
                                                            <td style="text-align: right;"><label
                                                                    id="grndirectwithodingTitleLbl" strong
                                                                    style="font-size: 16px;">Withold(2%)</label></td>
                                                            <td style="text-align: center;">
                                                                <label id="grndirectwitholdingAmntLbl"
                                                                    class="formattedNum lbl" strong
                                                                    style="font-size: 16px; font-weight: bold;"></label>
                                                            </td>
                                                        </tr>
                                                        <tr id="grndirectvatTr" style="display: none;">
                                                            <td style="text-align: right;"><label id="vatTitleLbl"
                                                                    strong style="font-size: 16px;">Vat</label></td>
                                                            <td style="text-align: center;">
                                                                <label id="grnvatAmntLbl" class="formattedNum lbl"
                                                                    strong
                                                                    style="font-size: 16px; font-weight: bold;"></label>
                                                            </td>
                                                        </tr>
                                                        <tr id="grndirectnetpayTr" style="display: visible;">
                                                            <td style="text-align: right;"><label strong
                                                                    style="font-size: 16px;">Net Pay</label></td>
                                                            <td style="text-align: center;">
                                                                <label id="grndirectnetpayLbl" class="formattedNum lbl"
                                                                    strong
                                                                    style="font-size: 16px; font-weight: bold;"></label>

                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td style="text-align: right;"><label strong
                                                                    style="font-size: 16px;">No. Of Products</label></td>
                                                            <td style="text-align: center;"><label
                                                                    id="grndirectnumberofItemsLbl" strong
                                                                    style="font-size: 16px; font-weight: bold;">0</label>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="payrinfopiview" aria-labelledby="payrinfopiview-tab"
                                        role="tabpanel">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="col-xl-12 col-lg-12" id="directfooter">
                        <div class="row">
                            <input type="hidden" placeholder="" class="form-control" name="recordIds"
                                id="recordIds" readonly="true" />
                            <input type="hidden" placeholder="" class="form-control" name="evelautestatus"
                                id="evelautestatus" readonly="true" />
                            <div class="col-xl-6 col-lg-12">
                                @can('PYR-Edit')
                                    <button type="button" id="payreditbutton" class="btn btn-outline-dark"><i
                                            class="fa-sharp fa-solid fa-pen"></i> Edit</button>
                                @endcan
                                @can('PYR-Void')
                                    <button type="button" id="payrvoidbutton" class="btn btn-outline-dark"><i
                                            class="fa-solid fa-trash-xmark"></i> Void</button>
                                    <button type="button" id="payrundovoidbutton" class="btn btn-outline-dark"><i
                                            class="fa-solid fa-trash-undo"></i> Undo Void</button>
                                @endcan
                                @can('PYR-Reject')
                                    <button type="button" id="payrejectbutton" class="btn btn-outline-dark"><i
                                            class="fa-solid fa-trash-xmark"></i> Reject</button>
                                    <button type="button" id="payrundorejectbutton" class="btn btn-outline-dark"><i
                                            class="fa-solid fa-trash-undo"></i> Undo Reject</button>
                                @endcan

                                <button type="button" id="payrprintbutton" class="btn btn-outline-dark"><i
                                        data-feather="printer" class="mr-25"></i>Print</button>
                            </div>
                            <div class="col-xl-6 col-lg-12" style="text-align:right;">
                                @can('PYR-Pending')
                                    <button type="button" id="payrbacktodraftbutton" class="btn btn-outline-dark"><i
                                            class="fa-solid fa-badge-check"></i>Back To Draft</button>
                                    <button type="button" id="payrpendingbutton" class="btn btn-outline-dark"><i
                                            class="fa-solid fa-badge-check"></i>Chage To Pending</button>
                                @endcan

                                @can('PYR-Review')
                                    <button type="button" id="payrreviewbutton" class="btn btn-outline-dark"><i
                                            class="fa-solid fa-badge-check"></i>Review</button>
                                    <button type="button" id="payrundoreviewbutton" class="btn btn-outline-dark"><i
                                            class="fa-solid fa-badge-check"></i>Undo Review</button>
                                @endcan

                                @can('PYR-Verify')
                                    <button type="button" id="payrbacktopendingbutton" class="btn btn-outline-dark"><i
                                            class="fa-solid fa-badge-check"></i>Back To Pending</button>
                                    <button type="button" id="payrverifybutton" class="btn btn-outline-dark"><i
                                            class="fa-solid fa-badge-check"></i>Verify</button>
                                @endcan
                                @can('PYR-Approve')
                                    <button type="button" id="payrbacktoverifybutton" class="btn btn-outline-dark"><i
                                            class="fa-solid fa-badge-check"></i>Back To Verify</button>
                                    <button type="button" id="payrapprovebutton" class="btn btn-outline-dark"><i
                                            class="fa-solid fa-badge-check"></i>Approve</button>
                                @endcan


                                <button id="closebutton" type="button" class="btn btn-outline-danger"
                                    onclick="paymentrequestrefresh();" data-dismiss="modal"><i
                                        class="fa-regular fa-xmark"></i> Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-slide-in event-sidebar fade" id="pevualtiondocInfoModal" data-keyboard="false"
        data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true"
        style="overflow-y:scroll;">
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
                                            <div class="card-header" id="headingOne" data-toggle="collapse"
                                                role="button" data-target="#pevualtioncollapseOne"
                                                aria-expanded="false" aria-controls="pevualtioncollapseOne">
                                                <span class="lead collapse-title">Purchase Evaluation Details</span>
                                                <span id="" style="font-size:16px;"></span>
                                            </div>
                                            <div id="pevualtioncollapseOne" class="collapse"
                                                aria-labelledby="pevualtioncollapseOne" data-parent="#accordionExample">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-xl-3 col-lg-12"
                                                            style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    <h6 class="card-title">Puchase Evaluation Information
                                                                    </h6>
                                                                </div>
                                                                <div class="card-body">
                                                                    <table class="table-responsive">
                                                                        <tr>
                                                                            <td><label strong
                                                                                    style="font-size: 12px;">DOC#:
                                                                                </label></td>
                                                                            <td><b><label id="peinfope" strong
                                                                                        style="font-size: 12px;"></label></b>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label strong
                                                                                    style="font-size: 12px;">Reference:
                                                                                </label></td>
                                                                            <td><b><label id="peinforefernce" strong
                                                                                        style="font-size: 12px;"></label></b>
                                                                            </td>
                                                                        </tr>
                                                                        <tr id="trinforfq">
                                                                            <td><label strong
                                                                                    style="font-size: 12px;">Reference#:
                                                                                </label></td>
                                                                            <td><b><label id="peinforfq" strong
                                                                                        style="font-size: 12px;"></label></b>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label strong
                                                                                    style="font-size: 12px;">Product Type:
                                                                                </label></td>
                                                                            <td><b><label id="peinfotype" strong
                                                                                        style="font-size: 12px;"></label></b>
                                                                            </td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td><label strong
                                                                                    style="font-size: 12px;">Commodity
                                                                                    Type: </label></td>
                                                                            <td><b><label id="peinfocommoditype" strong
                                                                                        style="font-size: 12px;"></label></b>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label strong
                                                                                    style="font-size: 12px;">Commodity
                                                                                    Source: </label></td>
                                                                            <td><b><label id="peinfocommoditysource"
                                                                                        strong
                                                                                        style="font-size: 12px;"></label></b>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label strong
                                                                                    style="font-size: 12px;">Commodity
                                                                                    Status: </label></td>
                                                                            <td><b><label id="peinfocommoditystatus"
                                                                                        strong
                                                                                        style="font-size: 12px;"></label></b>
                                                                            </td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td><label strong
                                                                                    style="font-size: 12px;">Request Date:
                                                                                </label></td>
                                                                            <td><b><label id="peinfodocumentdate" strong
                                                                                        style="font-size: 12px;"></label></b>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label strong
                                                                                    style="font-size: 12px;">Request
                                                                                    Station: </label></td>
                                                                            <td><b><label id="peinfostation" strong
                                                                                        style="font-size: 12px;"></label></b>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label strong
                                                                                    style="font-size: 12px;">Priority:
                                                                                </label></td>
                                                                            <td><b><label id="peinfopriority" strong
                                                                                        style="font-size: 12px;"></label></b>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label strong
                                                                                    style="font-size: 12px;">Sample:
                                                                                </label></td>
                                                                            <td><b><label id="peinfosample" strong
                                                                                        style="font-size: 12px;"></label></b>
                                                                            </td>
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
                                                                    <div class="scroll scrdiv"
                                                                        style="overflow-y:scroll;height:25rem;">
                                                                        <table id="perequesteditemdatatablesoninfo"
                                                                            class="display table-bordered table-striped table-hover dt-responsive mb-0"
                                                                            style="width: 100%">
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
                                                        <div class="col-xl-4 col-lg-12"
                                                            style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    <h6 class="card-title">Action</h6>
                                                                </div>
                                                                <div class="card-body scroll scrdiv">
                                                                    <ul class="timeline" id="peulist"
                                                                        style="height:25rem;">

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
                                                                        <input type="text" class="form-control"
                                                                            id="pesearchsupplier"
                                                                            placeholder="Search here...">
                                                                    </td>
                                                                    <td style="width: 20%;">
                                                                        <button type="button"
                                                                            class="btn btn-outline-dark"
                                                                            id="peclearsupplsearch"><i
                                                                                class="fa-duotone fa-circle-xmark"></i></button>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="scroll scrdiv">
                                                        <section id="pecarddatacanvas"
                                                            style="margin-top:2rem;height:10rem">
                                                        </section>
                                                    </div>
                                                </div>
                                                <div class="col-xl-10 col-md-10 col-sm-10" id="pecommoditylistdiv">

                                                    <div id="pecomuditydocInfoItemdiv">
                                                        <ul class="nav nav-tabs nav-justified" id="infoapptabs"
                                                            role="tablist">
                                                            @can('PE-View')
                                                                <li class="nav-item" id="initation">
                                                                    <a class="nav-link active" id="initationview-tab"
                                                                        data-toggle="tab" href="#initationview"
                                                                        aria-controls="initationview" role="tab"
                                                                        aria-selected="true"
                                                                        onclick="infopelistbytab('peview');"><i
                                                                            data-feather="home"></i>Evaluation Initation</a>
                                                                </li>
                                                            @endcan
                                                            @can('TE-View')
                                                                <li class="nav-item" id="tectnicaltab">
                                                                    <a class="nav-link" id="technicalview-tab"
                                                                        data-toggle="tab" href="#technicalview"
                                                                        aria-controls="technicalview" role="tab"
                                                                        aria-selected="false"
                                                                        onclick="infopelistbytab('teview');"><i
                                                                            data-feather="tool"></i>Technical Evaluation</a>
                                                                </li>
                                                            @endcan
                                                            @can('FE-View')
                                                                <li class="nav-item" id="financialtab">
                                                                    <a class="nav-link" id="financialview-tab"
                                                                        data-toggle="tab" href="#financialview"
                                                                        aria-controls="financialview" role="tab"
                                                                        aria-selected="false"
                                                                        onclick="infopelistbytab('feview');"><i
                                                                            data-feather="codepen"></i>Financial
                                                                        Evaluation</a>
                                                                </li>
                                                            @endcan

                                                        </ul>
                                                        <div class="tab-content">
                                                            <div class="tab-pane active" id="initationview"
                                                                aria-labelledby="initationview-tab" role="tabpanel">
                                                                <table id="pecomuditydocInfoItem"
                                                                    class="display table-bordered table-striped table-hover dt-responsive mb-0"
                                                                    style="width: 100%;">
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
                                                            <div class="tab-pane" id="technicalview"
                                                                aria-labelledby="technicalview-tab" role="tabpanel">
                                                                <table id="petechnicalcomuditydocInfoItem"
                                                                    class="display table-bordered table-striped table-hover dt-responsive mb-0"
                                                                    style="width: 100%;">
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
                                                            <div class="tab-pane" id="financialview"
                                                                aria-labelledby="financialview-tab" role="tabpanel">
                                                                <table id="pefinancailcomuditydocInfoItem"
                                                                    class="display table-bordered table-striped table-hover dt-responsive mb-0"
                                                                    style="width: 100%;">
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
                    <input type="hidden" placeholder="" class="form-control" name="perecordIds" id="perecordIds"
                        readonly="true" />
                    <input type="hidden" placeholder="" class="form-control" name="peevelautestatus"
                        id="peevelautestatus" readonly="true" />
                    <input type="hidden" placeholder="" class="form-control" name="peevalsupplierid"
                        id="peevalsupplierid" readonly="true" />
                    <input type="hidden" placeholder="" class="form-control" name="peevalstatus"
                        id="peevalstatus" readonly="true" />
                    <button id="closebutton" type="button" class="btn btn-outline-danger" data-dismiss="modal"><i
                            class="fa-regular fa-xmark"></i> Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal to add new user starts-->
    <div class="modal modal-slide-in new-user-modal fade" id="modals-slide-in">
        <div class="modal-dialog modal-dialog-scrollable sidebar-xl" style="width: 90%;">
            <form class="add-new-user modal-content pt-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                <div class="modal-header mb-1">
                    <h5 class="modal-title" id="paymenthistorystatus"></h5>
                </div>
                <div class="modal-body flex-grow-1">
                    <table class="table-responsive">

                        <tr>
                            <td><label strong style="font-size: 12px;">Purchase Order#: </label></td>
                            <td><b><label id="payrinfopo" class="paymentrequestinfopo" strong
                                        style="font-size: 12px;"></label></b></td>
                        </tr>
                    </table>
                    <div class="card-datatable">
                        <div style="width:98%; margin-left:1%" class="" id="table-block">
                            <table id="historypcontracttables"
                                class="display table-bordered table-striped table-hover dt-responsive mb-0"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Payment Reqeust#</th>
                                        <th>Reference</th>
                                        <th>Payment Reference</th>
                                        <th>Payment Mode</th>
                                        <th>Payment Status</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Paid Amount</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="6"
                                            style="text-align:left;background-color: #FFFFFF;border:none;padding:0px;">
                                        </td>
                                        <th colspan="2" style="text-align: right;">Purchase Order Amount</th>
                                        <th id="historytotalamount"
                                            style='font-size:13px;color:black;font-weight:bold;'></th>
                                    </tr>
                                    <tr>
                                        <td colspan="6"
                                            style="text-align:left;background-color: #FFFFFF;border:none;padding:0px;">
                                        </td>
                                        <th colspan="2" style="text-align: right;">Paid Amount</th>
                                        <th id="historypaidamount"></th>
                                    </tr>
                                    <tr style="display: none;">
                                        <td colspan="6"
                                            style="text-align:left;background-color: #FFFFFF;border:none;padding:0px;">
                                        </td>
                                        <th colspan="2" style="text-align: right;">Purchase Order Remaining Amount
                                        </th>
                                        <th id="historyremainamount"></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-outline-danger waves-effect"
                        data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal to add new user Ends-->
    <div class="modal modal-slide-in event-sidebar fade" id="purchaseorderdocInfoModal" data-keyboard="false"
        data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true"
        style="overflow-y:scroll;">
        <div class="modal-dialog modal-dialog-scrollable sidebar-xl" style="width: 90%;">
            <div class="modal-content p-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Purchase Order Information</h5>
                    <div class="row">
                        <div style="text-align: right;" id="poinfoStatus"></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            onclick="refreshmaintables();">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                </div>
                <div class="modal-body flex-grow-1 pb-sm-0 pb-3 scroll scrdiv">
                    <form id="holdInfo">
                        @csrf
                        <div class="col-xl-12" id="docinfo-block">
                            <div class="card collapse-icon">
                                <div class="collapse-default" id="accordionExample">
                                    <div class="card">
                                        <div class="card-header" id="headingOne" data-toggle="collapse" role="button"
                                            data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                            <span class="lead collapse-title">Purchase order Details</span>
                                            <span id="" style="font-size:16px;"></span>
                                        </div>
                                        <div id="collapseOne" class="collapse" aria-labelledby="headingOne"
                                            data-parent="#accordionExample">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-xl-3 col-lg-12"
                                                        style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h6 class="card-title">Puchase order information</h6>
                                                            </div>
                                                            <div class="card-body">
                                                                <table class="table-responsive">
                                                                    <tr>
                                                                        <td><label strong
                                                                                style="font-size: 12px;">Reference:
                                                                            </label></td>
                                                                        <td><b><label id="inforefernce" strong
                                                                                    style="font-size: 12px;"></label></b>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="infopetr">
                                                                        <td><label strong
                                                                                style="font-size: 12px;">Reference#:
                                                                            </label></td>
                                                                        <td><b><label id="infope" strong
                                                                                    style="font-size: 12px;"></label></b>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label strong style="font-size: 12px;">Purchase
                                                                                Order No: </label></td>
                                                                        <td><b><label id="infopo" strong
                                                                                    style="font-size: 12px;"></label></b>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label strong style="font-size: 12px;">Purchase
                                                                                Order Type: </label></td>
                                                                        <td><b><label id="infopotype" strong
                                                                                    style="font-size: 12px;"></label></b>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="cmdtyclass">
                                                                        <td><label strong
                                                                                style="font-size: 12px;">Commodity Type:
                                                                            </label></td>
                                                                        <td><b><label id="infocommoditype" strong
                                                                                    style="font-size: 12px;"></label></b>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="cmdtyclass">
                                                                        <td><label strong
                                                                                style="font-size: 12px;">Commodity Source:
                                                                            </label></td>
                                                                        <td><b><label id="infocommoditysource" strong
                                                                                    style="font-size: 12px;"></label></b>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="cmdtyclass">
                                                                        <td><label strong
                                                                                style="font-size: 12px;">Commodity Status:
                                                                            </label></td>
                                                                        <td><b><label id="infocommoditystatus" strong
                                                                                    style="font-size: 12px;"></label></b>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label strong style="font-size: 12px;">Prepare
                                                                                Date: </label></td>
                                                                        <td><b><label id="infodocumentdate" strong
                                                                                    style="font-size: 12px;"></label></b>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="infodirect">
                                                                        <td><label strong style="font-size: 12px;">Order
                                                                                Date: </label></td>
                                                                        <td><b><label id="inforderdate" strong
                                                                                    style="font-size: 12px;"></label></b>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="infodirect">
                                                                        <td><label strong style="font-size: 12px;">Deliver
                                                                                Date: </label></td>
                                                                        <td><b><label id="infodeliverdate" strong
                                                                                    style="font-size: 12px;"></label></b>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="infodirect">
                                                                        <td><label strong style="font-size: 12px;">Station:
                                                                            </label></td>
                                                                        <td><b><label id="infowarehouse" strong
                                                                                    style="font-size: 12px;"></label></b>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="infodirect">
                                                                        <td><label strong style="font-size: 12px;">Payment
                                                                                Term: </label></td>
                                                                        <td><b><label id="infopaymenterm" strong
                                                                                    style="font-size: 12px;"></label></b>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-12" id="directsupplyinformationdiv">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h6 class="card-title">Supplier Information</h6>
                                                            </div>
                                                            <div class="card-body">
                                                                <table class="table-responsive">
                                                                    <tr>
                                                                        <td><label strong style="font-size: 12px;">ID:
                                                                            </label></td>
                                                                        <td><b><label id="infosuppid" strong
                                                                                    style="font-size: 12px;"></label></b>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label strong style="font-size: 12px;">Name:
                                                                            </label></td>
                                                                        <td><b><label id="infsupname" strong
                                                                                    style="font-size: 12px;"></label></b>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label strong style="font-size: 12px;">TIN:
                                                                            </label></td>
                                                                        <td><b><label id="infosupptin" strong
                                                                                    style="font-size: 12px;"></label></b>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                                <div class="divider divider-secondary">
                                                                    <div class="divider-text"><b>Memo</b></div>
                                                                </div>
                                                                <table class="table-responsive">
                                                                    <tr>
                                                                        <td><label id="purchaseorderinfomemo"
                                                                                class="purchaseorderinfomemo" strong
                                                                                style="font-size: 12px;"></label></td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-12">
                                                    </div>
                                                    <div class="col-xl-6 col-lg-12" id="supplyinformationdiv"
                                                        style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;display:visible;">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h6 class="card-title">Evaluation Result</h6>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="scroll scrdiv"
                                                                    style="overflow-y:scroll;height:25rem;">
                                                                    <table id="comuditydocInfoItem"
                                                                        class="display table-bordered table-striped table-hover dt-responsive mb-0"
                                                                        style="width: 100%;">
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

                                                    <div class="col-xl-3 col-lg-3"
                                                        style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;height:20rem">
                                                        <h5>Actions</h5>
                                                        <div class="scroll scrdiv">
                                                            <ul class="timeline" id="ulist" style="height:20rem;">

                                                            </ul>
                                                            <ul class="timeline" id="ulistsupplier"
                                                                style="height:25rem;">

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
                                        <table id="itemsdocInfoItem"
                                            class="display table-bordered table-striped table-hover dt-responsive mb-0">
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
                                                        <input type="text" class="form-control" id="searchsupplier"
                                                            placeholder="Search here...">
                                                    </div>
                                                    <div class="col-xl-2 col-md-2 col-sm-2">
                                                        <button type="button" class="btn btn-light btn-sm"
                                                            id="clearsupplsearch"><i
                                                                class="fa-sharp fa-solid fa-x"></i></button>
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
                                                <table id="infofinancailevdynamicTablecommdity" class="rtable mb-0"
                                                    width="100%">
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
                                                        <table style="width:100%;" id="supplierinfopricetable"
                                                            class="rtable">
                                                            <tr>
                                                                <td style="text-align: right; width:50%;"><label strong
                                                                        style="font-size: 16px;">Sub Total</label></td>
                                                                <td style="text-align: center; width:50%;"><label
                                                                        id="supplierinfosubtotalLbl" strong
                                                                        style="font-size: 16px; font-weight: bold;"></label>
                                                                </td>

                                                            </tr>
                                                            <tr id="individualsupplierinfotaxtr" style="display: none;">
                                                                <td style="text-align: right;"><label strong
                                                                        style="font-size: 16px;">Tax(15%)</label></td>
                                                                <td style="text-align: center;"><label
                                                                        id="supplierinfotaxLbl" strong
                                                                        style="font-size: 16px; font-weight: bold;"></label>
                                                                </td>

                                                            </tr>
                                                            <tr id="individualsupplierinforandtotaltr"
                                                                style="display: none;">
                                                                <td style="text-align: right;"><label strong
                                                                        style="font-size: 16px;">Grand Total</label></td>
                                                                <td style="text-align: center;"><label
                                                                        id="supplierinfograndtotalLbl" strong
                                                                        style="font-size: 16px; font-weight: bold;"></label>
                                                                </td>

                                                            </tr>
                                                            <tr id="supplierinfowitholdingTr" style="display: none;">
                                                                <td style="text-align: right;"><label
                                                                        id="withodingTitleLbl" strong
                                                                        style="font-size: 16px;">Withold(2%)</label></td>
                                                                <td style="text-align: center;">
                                                                    <label id="supplierinfowitholdingAmntLbl"
                                                                        class="formattedNum" strong
                                                                        style="font-size: 16px; font-weight: bold;"></label>

                                                                </td>
                                                            </tr>
                                                            <tr id="supplierinfovatTr" style="display: none;">
                                                                <td style="text-align: right;"><label
                                                                        id="supplierinfovatTitleLbl" strong
                                                                        style="font-size: 16px;">Vat</label></td>
                                                                <td style="text-align: center;">
                                                                    <label id="supplierinfovatAmntLbl"
                                                                        class="formattedNum" strong
                                                                        style="font-size: 16px; font-weight: bold;"></label>

                                                                </td>
                                                            </tr>
                                                            <tr id="supplierinfonetpayTr" style="display: none;">
                                                                <td style="text-align: right;"><label strong
                                                                        style="font-size: 16px;">Net Pay</label></td>
                                                                <td style="text-align: center;">
                                                                    <label id="supplierinfonetpayLbl" class="formattedNum"
                                                                        strong style="font-size: 16px; font-weight: bold;"
                                                                        class="lbl"></label>

                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td style="text-align: right;"><label strong
                                                                        style="font-size: 16px;">No. of Items</label></td>
                                                                <td style="text-align: center;"><label
                                                                        id="supplierinfonumberofItemsLbl" strong
                                                                        style="font-size: 16px; font-weight: bold;">0</label>
                                                                </td>
                                                            </tr>
                                                            <tr id="supplierinfohidewitholdTr" style="display: none;">
                                                                <td colspan="3" style="text-align: center;">
                                                                    <div class="demo-inline-spacing">
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox"
                                                                                class="custom-control-input"
                                                                                id="supplierinfocustomCheck1" />
                                                                            <label class="custom-control-label"
                                                                                for="supplierinfocustomCheck1">Taxable</label>
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
                                            <table id="directcommudityinfodatatables"
                                                class="display table-bordered table-striped table-hover dt-responsive mb-0">
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
                                                        <td class="tdcolspan" id="tdcolspan" colspan="4"
                                                            style="text-align:left;background-color: #FFFFFF;border:none;padding:0px;">
                                                        </td>
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
                                            <table id="directgoodsinfodatatablesonpaymentrequessta"
                                                class="display table-bordered table-striped table-hover dt-responsive mb-0">
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
                                                        <td style="text-align: right; width:50%;"><label strong
                                                                style="font-size: 16px;">Sub Total</label></td>
                                                        <td style="text-align: center; width:50%;"><label
                                                                id="directinfosubtotalLbl" strong
                                                                style="font-size: 16px; font-weight: bold;"></label></td>

                                                    </tr>
                                                    <tr id="pyrinfosupplierinfotaxtr" style="display: visible;">
                                                        <td style="text-align: right;"><label strong
                                                                style="font-size: 16px;">Tax(15%)</label></td>
                                                        <td style="text-align: center;"><label id="directinfotaxLbl"
                                                                strong style="font-size: 16px; font-weight: bold;"></label>
                                                        </td>

                                                    </tr>
                                                    <tr id="pyrinfosupplierinforandtotaltr" style="display: visible;">
                                                        <td style="text-align: right;"><label strong
                                                                style="font-size: 16px;">Grand Total</label></td>
                                                        <td style="text-align: center;"><label
                                                                id="directinfograndtotalLbl" strong
                                                                style="font-size: 16px; font-weight: bold;"></label></td>

                                                    </tr>
                                                    <tr id="pyrinfovisibleinfowitholdingTr" style="display: visible;">
                                                        <td style="text-align: right;"><label id="withodingTitleLbl"
                                                                strong style="font-size: 16px;">Withold(2%)</label></td>
                                                        <td style="text-align: center;">
                                                            <label id="directinfowitholdingAmntLbl" class="formattedNum"
                                                                strong style="font-size: 16px; font-weight: bold;"></label>

                                                        </td>
                                                    </tr>
                                                    <tr id="pyrinfodirectinfovatTr" style="display: none;">
                                                        <td style="text-align: right;"><label id="supplierinfovatTitleLbl"
                                                                strong style="font-size: 16px;">Vat</label></td>
                                                        <td style="text-align: center;">
                                                            <label id="directinfovatAmntLbl" class="formattedNum" strong
                                                                style="font-size: 16px; font-weight: bold;"></label>

                                                        </td>
                                                    </tr>
                                                    <tr id="pyrinfodirectinfonetpayTr" style="display: none;">
                                                        <td style="text-align: right;"><label strong
                                                                style="font-size: 16px;">Net Pay</label></td>
                                                        <td style="text-align: center;">
                                                            <label id="directinfonetpayLbl" class="formattedNum" strong
                                                                style="font-size: 16px; font-weight: bold;"
                                                                class="lbl"></label>

                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td style="text-align: right;"><label strong
                                                                style="font-size: 16px;">No. of Items</label></td>
                                                        <td style="text-align: center;"><label
                                                                id="directinfonumberofItemsLblpyr" strong
                                                                style="font-size: 16px; font-weight: bold;">0</label></td>

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
                            <input type="hidden" placeholder="" class="form-control" name="porecordIds"
                                id="porecordIds" readonly="true" />
                            <input type="hidden" placeholder="" class="form-control" name="evelautestatus"
                                id="evelautestatus" readonly="true" />
                            <div class="col-xl-6 col-lg-12">
                                <button type="button" id="poprintbutton" class="btn btn-outline-dark"><i
                                        data-feather="printer" class="mr-25"></i>Print</button>
                            </div>
                            <div class="col-xl-6 col-lg-12" style="text-align:right;">

                                <button id="closebutton" type="button" class="btn btn-outline-danger"
                                    data-dismiss="modal"><i class="fa-regular fa-xmark"></i> Close</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12" id="pefooter">
                        <div class="row">
                            <input type="hidden" placeholder="" class="form-control" name="supplierrecordIds"
                                id="supplierrecordIds" readonly="true" />
                            <input type="hidden" placeholder="" class="form-control" name="supplierevelautestatus"
                                id="supplierevelautestatus" readonly="true" />
                            <input type="hidden" placeholder="" class="form-control" name="suppliername"
                                id="suppliername" readonly="true" />
                            <div class="col-xl-6 col-lg-12">

                            </div>
                            <div class="col-xl-6 col-lg-12" style="text-align:right;">
                                <button id="closebutton" type="button" class="btn btn-outline-danger"
                                    data-dismiss="modal"><i class="fa-regular fa-xmark"></i> Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-slide-in event-sidebar fade" id="recievingdocInfoModal" data-keyboard="false"
        data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true"
        style="overflow-y: scroll;">
        <div class="modal-dialog modal-dialog-scrollable sidebar-xl" style="width: 90%;">
            <div class="modal-content p-0">
                <div class="modal-header">
                    <h4 class="modal-title" id="receivinginfomodaltitle">Receiving Information</h4>
                    <button type="button" class="close" data-dismiss="modal" onclick="closeInfoModal()"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                    <form id="holdInfo">
                        @csrf
                        <div class="col-xl-12">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-6 col-12">
                                            <section id="collapsible">
                                                <div class="card collapse-icon">
                                                    <div class="collapse-default">
                                                        <div class="card">
                                                            <div id="reciveheadingCollapse1" class="card-header"
                                                                data-toggle="collapse" role="button"
                                                                data-target=".infoscl" aria-expanded="false"
                                                                aria-controls="recivecollapse1">
                                                                <span class="lead collapse-title">Basic, Delivery,
                                                                    Receiving & Other Information</span>
                                                                <div style="text-align: right;" id="statustitles"></div>
                                                            </div>
                                                            <div id="recivecollapse1" role="tabpanel"
                                                                aria-labelledby="reciveheadingCollapse1"
                                                                class="collapse infoscl">
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="col-lg-4 col-md-6 col-12"
                                                                            style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                                            <div class="card">
                                                                                <div class="card-header">
                                                                                    <h6 class="card-title">Basic
                                                                                        Information</h6>
                                                                                </div>
                                                                                <div class="card-body">
                                                                                    <div class="row">
                                                                                        <table style="width: 100%">
                                                                                            <tr>
                                                                                                <td style="width: 40%">
                                                                                                    <label
                                                                                                        style="font-size: 14px;">Document
                                                                                                        No.</label></td>
                                                                                                <td style="width: 60%">
                                                                                                    <label
                                                                                                        class="font-weight-bolder infolbls"
                                                                                                        id="infoDocDocNo"
                                                                                                        style="font-size: 14px;"></label>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label
                                                                                                        style="font-size: 14px;">Reference</label>
                                                                                                </td>
                                                                                                <td><label
                                                                                                        class="font-weight-bolder infolbls"
                                                                                                        style="font-size: 14px;"
                                                                                                        id="referenceLbl"></label>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label
                                                                                                        style="font-size: 14px;">Reference
                                                                                                        No.</label></td>
                                                                                                <td><label
                                                                                                        class="font-weight-bolder infolbls"
                                                                                                        style="font-size: 14px;"
                                                                                                        id="purchaseOrdLbl"></label>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr style="display: none;"
                                                                                                id="commoditySrcRow">
                                                                                                <td><label
                                                                                                        style="font-size: 14px;">Commodity
                                                                                                        Source</label></td>
                                                                                                <td><label
                                                                                                        class="font-weight-bolder infolbls"
                                                                                                        style="font-size: 14px;"
                                                                                                        id="commoditySrcLbl"></label>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr style="display: none;"
                                                                                                id="commodityTypeRow">
                                                                                                <td><label
                                                                                                        style="font-size: 14px;">Commodity
                                                                                                        Type</label></td>
                                                                                                <td><label
                                                                                                        class="font-weight-bolder infolbls"
                                                                                                        style="font-size: 14px;"
                                                                                                        id="commodityTypeLbl"></label>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label
                                                                                                        style="font-size: 14px;">Product
                                                                                                        Type</label></td>
                                                                                                <td><label
                                                                                                        class="font-weight-bolder infolbls"
                                                                                                        style="font-size: 14px;"
                                                                                                        id="productTypeLbl"></label>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr style="display: none;">
                                                                                                <td><label
                                                                                                        style="font-size: 14px;">Supplier
                                                                                                        Category</label>
                                                                                                </td>
                                                                                                <td><label
                                                                                                        class="font-weight-bolder infolbls"
                                                                                                        style="font-size: 14px;"
                                                                                                        id="infoDocCustomerCategory"></label>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label
                                                                                                        style="font-size: 14px;">Supplier
                                                                                                        Name</label></td>
                                                                                                <td><label
                                                                                                        class="font-weight-bolder infolbls"
                                                                                                        style="font-size: 14px;"
                                                                                                        id="infoDocCustomerName"></label>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr style="display: none;">
                                                                                                <td><label
                                                                                                        style="font-size: 14px;">TIN</label>
                                                                                                </td>
                                                                                                <td><label
                                                                                                        class="font-weight-bolder infolbls"
                                                                                                        style="font-size: 14px;"
                                                                                                        id="infotinnumberlbl"></label>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr style="display: none;">
                                                                                                <td><label
                                                                                                        style="font-size: 14px;">VAT
                                                                                                        #</label></td>
                                                                                                <td><label
                                                                                                        class="font-weight-bolder infolbls"
                                                                                                        style="font-size: 14px;"
                                                                                                        id="infovatnumberlbl"></label>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label
                                                                                                        style="font-size: 14px;">Company
                                                                                                        Type</label></td>
                                                                                                <td><label
                                                                                                        class="font-weight-bolder infolbls"
                                                                                                        style="font-size: 14px;"
                                                                                                        id="companyTypeLbl"></label>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr style="display: none;"
                                                                                                id="customerOwnerRec">
                                                                                                <td><label
                                                                                                        style="font-size: 14px;">Customer</label>
                                                                                                </td>
                                                                                                <td><label
                                                                                                        class="font-weight-bolder infolbls"
                                                                                                        style="font-size: 14px;"
                                                                                                        id="customerOrOwnerLbl"></label>
                                                                                                </td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-5 col-md-6 col-12"
                                                                            style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                                            <div class="card">
                                                                                <div class="card-header">
                                                                                    <h6 class="card-title">Delivery,
                                                                                        Receiving & Other Information</h6>
                                                                                </div>
                                                                                <div class="card-body">
                                                                                    <table style="width: 100%">
                                                                                        <tr>
                                                                                            <td style="width:27%;"><label
                                                                                                    style="font-size: 14px;">Delivery
                                                                                                    Order No.</label></td>
                                                                                            <td style="width:73%;"><label
                                                                                                    class="font-weight-bolder infolbls"
                                                                                                    id="deliveryOrderLbl"
                                                                                                    style="font-size: 14px;"></label>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label
                                                                                                    style="font-size: 14px;">Dispatch
                                                                                                    Station</label></td>
                                                                                            <td><label
                                                                                                    class="font-weight-bolder infolbls"
                                                                                                    id="dispatchStationLbl"
                                                                                                    style="font-size: 14px;"></label>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label
                                                                                                    style="font-size: 14px;">Receiving
                                                                                                    Station</label></td>
                                                                                            <td><label
                                                                                                    class="font-weight-bolder infolbls"
                                                                                                    style="font-size: 14px;"
                                                                                                    id="infoDocReceivingStore"></label>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label
                                                                                                    style="font-size: 14px;">Received
                                                                                                    By</label></td>
                                                                                            <td><label
                                                                                                    class="font-weight-bolder infolbls"
                                                                                                    style="font-size: 14px;"
                                                                                                    id="receivedByLbl"></label>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label
                                                                                                    style="font-size: 14px;">Driver
                                                                                                    Name</label></td>
                                                                                            <td><label
                                                                                                    class="font-weight-bolder infolbls"
                                                                                                    style="font-size: 14px;"
                                                                                                    id="driverNameLbl"></label>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label
                                                                                                    style="font-size: 14px;">Plate
                                                                                                    No.</label></td>
                                                                                            <td><label
                                                                                                    class="font-weight-bolder infolbls"
                                                                                                    style="font-size: 14px;"
                                                                                                    id="plateNumberLbl"></label>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label
                                                                                                    style="font-size: 14px;">Driver
                                                                                                    Phone No.</label></td>
                                                                                            <td><label
                                                                                                    class="font-weight-bolder infolbls"
                                                                                                    style="font-size: 14px;"
                                                                                                    id="driverPhoneLbl"></label>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label
                                                                                                    style="font-size: 14px;">Delivered
                                                                                                    By</label></td>
                                                                                            <td><label
                                                                                                    class="font-weight-bolder infolbls"
                                                                                                    style="font-size: 14px;"
                                                                                                    id="deliveredByLbl"></label>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label
                                                                                                    style="font-size: 14px;">Received
                                                                                                    Date</label></td>
                                                                                            <td><label
                                                                                                    class="font-weight-bolder infolbls"
                                                                                                    style="font-size: 14px;"
                                                                                                    id="receivedDateLbl"></label>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label
                                                                                                    style="font-size: 14px;">Invoice
                                                                                                    Status</label></td>
                                                                                            <td><label
                                                                                                    class="font-weight-bolder infolbls"
                                                                                                    style="font-size: 14px;"
                                                                                                    id="invoiceStatusLbl"></label>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label
                                                                                                    style="font-size: 14px;">Remark</label>
                                                                                            </td>
                                                                                            <td><label
                                                                                                    class="font-weight-bolder infolbls"
                                                                                                    style="font-size: 14px;"
                                                                                                    id="remarkLbl"></label>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-3 col-md-6 col-12">
                                                                            <div class="card">
                                                                                <div class="card-header">
                                                                                    <h6 class="card-title">Action
                                                                                        Information</h6>
                                                                                </div>
                                                                                <div class="card-body">
                                                                                    <div class="row">
                                                                                        <div class="col-lg-12 col-md-12 col-sm-12 scrdivhor scrollhor"
                                                                                            style="overflow-y: scroll;height:20rem">
                                                                                            <ul id="actiondiv"
                                                                                                class="timeline mb-0 mt-0">
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
                                                    </div>
                                                </div>
                                            </section>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <input type="hidden" class="form-control" name="statusid" id="statusid"
                                            readonly="true">
                                        <label style="font-size: 14px;display:none;" id="infoDocType"
                                            style="font-size: 12px;"></label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="table-responsive scroll scrdiv">
                                        <div class="datatableinfocls" id="infoGoodsDatatable">
                                            <div class="row">
                                                <div class="col-xl-12 col-lg-12">
                                                    <table id="docInfoItem"
                                                        class="display table-bordered table-striped table-hover dt-responsive">
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
                                                    <table id="origindetailtable"
                                                        class="display table-bordered table-striped table-hover dt-responsive mb-0 infodatatbl"
                                                        style="width: 100%">
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
                                                                <th style="width:6%">Bag Weight(Kg)</th>
                                                                <th style="width:6%">Total KG</th>
                                                                <th style="width:6%">Net KG</th>
                                                                <th style="width:6%">Feresula<label id="feresulainfolbl"
                                                                        title="Feresula= Net KG / 17"><i
                                                                            class="fa-solid fa-circle-info"></i></label>
                                                                </th>
                                                                <th style="width:6%">TON<label id="feresulainfolbl"
                                                                        title="TON= Net KG / 1000"><i
                                                                            class="fa-solid fa-circle-info"></i></label>
                                                                </th>
                                                                <th style="width:6%">Variance Shortage by KG</th>
                                                                <th style="width:6%">Variance Overage by KG</th>
                                                                <th style="width:6%">Remark</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="table table-sm"></tbody>
                                                        <tfoot>
                                                            <th colspan="8"
                                                                style="font-size:16px;text-align: right;padding-right:7px;">
                                                                Total</th>
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

                            <div class="row"></div>
                        </div>
                </div>
                </form>
                <div class="modal-footer">
                    <input type="hidden" placeholder="" class="form-control" name="usernamelbl" id="usernamelbl"
                        readonly="true" value="">
                    <input type="hidden" class="form-control" name="selectedids" id="selectedids"
                        readonly="true">
                    <input type="hidden" class="form-control" name="recieverecordIds" id="recieverecordIds"
                        readonly="true">
                    <input type="hidden" class="form-control" name="statusIds" id="statusIds" readonly="true">
                    <div class="col-xl-12 col-lg-12">
                        <div class="row">
                            <div class="col-xl-6 col-lg-12">
                                <button type="button" id="recievingprintbutton" class="btn btn-outline-dark"><i
                                        data-feather="printer" class="mr-25"></i>Print</button>
                            </div>
                            <div class="col-xl-6 col-lg-12" style="text-align: right;">
                                <button id="closebuttone" type="button" class="btn btn-danger"
                                    data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- start of void modals  -->
    <div class="modal fade text-left" id="povoidmodal" data-keyboard="false" data-backdrop="static" tabindex="-1"
        role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="povoidform">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" placeholder="" class="form-control" name="povoidid"
                                id="povoidid" readonly="true">
                            <input type="hidden" placeholder="" class="form-control" name="voidtype"
                                id="povoidtype" readonly="true">
                        </div>
                    </div>
                    <div class="col-xl-12 col-md-6 col-sm-12 mb-2">
                        <textarea class="form-control" id="voidreason" placeholder="Write Reason here" name="Reason"
                            onkeyup="clearvoiderror();"></textarea>
                        <span class="text-danger">
                            <strong id="voidreason-error"></strong>
                        </span>
                    </div>
                    <div class="modal-footer">
                        <button id="povoidbutton" type="button" class="btn btn-outline-dark"><i
                                class="fa-solid fa-trash"></i> <span>Void</span></button>
                        <button id="closebutton" type="button" class="btn btn-outline-danger" data-dismiss="modal"
                            onclick="clearvoiderror();"><i class="fa-regular fa-xmark"></i> Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end of void modals  -->

    <div class="modal modal-slide-in event-sidebar fade" id="purchaseinvoiceinfomodal" data-keyboard="false"
        data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true"
        style="overflow-y:scroll;">
        <div class="modal-dialog modal-dialog-scrollable sidebar-xl" style="width: 90%;">
            <div class="modal-content p-0">

                <div class="modal-header mb-1">
                    <h5 class="modal-title">Purchase Invoice Information</h5>
                    <div style="text-align: right;" id="pivinfoStatus">

                    </div>
                </div>

                <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12">
                            <div class="card collapse-icon">
                                <div class="collapse-default" id="accordionExample">
                                    <div class="card">
                                        <div class="card-header" id="headingOne" data-toggle="collapse"
                                            role="button" data-target="#pivcollapseOne" aria-expanded="true"
                                            aria-controls="pivcollapseOne">
                                            <span class="lead collapse-title">Payment Invoice Details</span>
                                            <span id="" style="font-size:16px;"></span>
                                        </div>
                                        <div id="pivcollapseOne" class="collapse" aria-labelledby="headingOne"
                                            data-parent="#accordionExample">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-xl-3 col-lg-12"
                                                        style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h6 class="card-title">Purchase Invoice Information</h6>
                                                            </div>
                                                            <div class="card-body scroll scrdiv" style="height:18rem;">
                                                                <table class="table-responsive">
                                                                    <tr>
                                                                        <td><label strong
                                                                                style="font-size: 12px;">Purchase
                                                                                Invoice#: </label></td>
                                                                        <td><b><label id="pivdocno" strong
                                                                                    style="font-size: 12px;"></label></b>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label strong
                                                                                style="font-size: 12px;">Reference:
                                                                            </label></td>
                                                                        <td><b><label id="pivinforefernce" strong
                                                                                    style="font-size: 12px;"></label></b>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="infopetrpo">
                                                                        <td><label strong
                                                                                style="font-size: 12px;">Purchase Order#:
                                                                            </label></td>
                                                                        <td><b><label id="pivinfopo" class="pivinfopo"
                                                                                    strong
                                                                                    style="font-size: 12px;"></label></b>
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td><label strong
                                                                                style="font-size: 12px;">Commodity Type:
                                                                            </label></td>
                                                                        <td><b><label id="pivinfocommoditype" strong
                                                                                    style="font-size: 12px;"></label></b>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label strong
                                                                                style="font-size: 12px;">Commodity Source:
                                                                            </label></td>
                                                                        <td><b><label id="pivinfocommoditysource" strong
                                                                                    style="font-size: 12px;"></label></b>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label strong
                                                                                style="font-size: 12px;">Commodity Status:
                                                                            </label></td>
                                                                        <td><b><label id="pivinfocommoditystatus" strong
                                                                                    style="font-size: 12px;"></label></b>
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td><label strong style="font-size: 12px;">Prepare
                                                                                Date: </label></td>
                                                                        <td><b><label id="pivinfodocumentdate" strong
                                                                                    style="font-size: 12px;"></label></b>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label strong style="font-size: 12px;">Payment
                                                                                Type: </label></td>
                                                                        <td><b><label id="pivinfopaymentype" strong
                                                                                    style="font-size: 12px;"></label></b>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label strong style="font-size: 12px;">Reciept
                                                                                Type: </label></td>
                                                                        <td><b><label id="pivinforecieptype" strong
                                                                                    style="font-size: 12px;"></label></b>
                                                                        </td>
                                                                    </tr>
                                                                    <tr id="payrinfomrcnotr">
                                                                        <td><label strong style="font-size: 12px;">MRC NO:
                                                                            </label></td>
                                                                        <td><b><label id="pivinfomrcno" strong
                                                                                    style="font-size: 12px;"></label></b>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label strong
                                                                                style="font-size: 12px;">Invoice/Ref#:
                                                                            </label></td>
                                                                        <td><b><label id="pivinfoinvoice" strong
                                                                                    style="font-size: 12px;"></label></b>
                                                                        </td>
                                                                    </tr>

                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-12" id="directsupplyinformationdiv"
                                                        style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;display:visible;">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h6 class="card-title">Supplier Information</h6>
                                                            </div>
                                                            <div class="card-body scroll scrdiv" style="height:18rem;">

                                                                <table style="width: 100%">
                                                                    <tr>
                                                                        <td><label strong style="font-size: 12px;">ID:
                                                                            </label></td>
                                                                        <td><b><label id="pivinfosuppid" strong
                                                                                    style="font-size: 12px;"></label></b>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label strong style="font-size: 12px;">Name:
                                                                            </label></td>
                                                                        <td><b><label id="pivinfsupname" strong
                                                                                    style="font-size: 12px;"></label></b>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label strong style="font-size: 12px;">TIN:
                                                                            </label></td>
                                                                        <td><b><label id="pivinfosupptin" strong
                                                                                    style="font-size: 12px;"></label></b>
                                                                        </td>
                                                                    </tr>

                                                                </table>
                                                                <div class="divider divider-secondary">
                                                                    <div class="divider-text"><b>Memo</b></div>
                                                                </div>
                                                                <table class="table-responsive">

                                                                    <tr>
                                                                        <td><label id="paymentrequestinfomemo"
                                                                                class="paymentrequestinfopurpose" strong
                                                                                style="font-size: 12px;"></label></td>
                                                                    </tr>

                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-12"
                                                        style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h6 class="card-title">Attached Document</h6>
                                                            </div>
                                                            <div class="card-body scroll scrdiv" style="height:18rem;">
                                                                <iframe src="" id="purchaseinvoicepdfviewer"
                                                                    width="100%" height="400px"></iframe>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-2 col-lg-3"
                                                        style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;height:20rem">
                                                        <h5>Actions</h5>
                                                        <div class="scroll scrdiv">
                                                            <ul class="timeline" id="paymentinvoiceulist"
                                                                style="height:18rem;">

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
                                <table id="pivtable"
                                    class="display table-bordered table-striped table-hover dt-responsive mb-1">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>GRN</th>
                                            <th>Commodity</th>
                                            <th>Grade</th>
                                            <th>Preparation</th>
                                            <th>Crop Year</th>
                                            <th>UOM/Bag</th>
                                            <th>No. of Bag</th>
                                            <th>Bag Weight(Kg)</th>
                                            <th>Total Kg</th>
                                            <th>Net Kg</th>
                                            <th>TON</th>
                                            <th>Feresula</th>
                                            <th>Unit Price</th>
                                            <th>Total</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="5"
                                                style="text-align:left;background-color: #FFFFFF;border:none;padding:0px;">
                                            </td>
                                            <th colspan="2" style="text-align: right;">Total</th>
                                            <th id="pinfonofbagtotal"></th>
                                            <th id="pinfonofbagweighttotal"></th>
                                            <th id="pinfonoftotalkgtotal"></th>
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
                                            <td style="text-align: right; width:50%;"><label strong
                                                    style="font-size: 16px;">Sub Total</label></td>
                                            <td style="text-align: center; width:50%;"><label
                                                    id="pivinfodirectinfosubtotalLbl" strong
                                                    style="font-size: 16px; font-weight: bold;"></label></td>

                                        </tr>
                                        <tr id="pivinfosupplierinfotaxtr" style="display: visible;">
                                            <td style="text-align: right;"><label strong
                                                    style="font-size: 16px;">Tax(15%)</label></td>
                                            <td style="text-align: center;"><label id="pivinfodirectinfotaxLbl" strong
                                                    style="font-size: 16px; font-weight: bold;"></label></td>

                                        </tr>
                                        <tr id="pivinfosupplierinforandtotaltr" style="display: visible;">
                                            <td style="text-align: right;"><label strong style="font-size: 16px;">Grand
                                                    Total</label></td>
                                            <td style="text-align: center;"><label id="pivinfodirectinfograndtotalLbl"
                                                    strong style="font-size: 16px; font-weight: bold;"></label></td>

                                        </tr>
                                        <tr id="pivinfovisibleinfowitholdingTr" style="display: visible;">
                                            <td style="text-align: right;"><label id="withodingTitleLbl" strong
                                                    style="font-size: 16px;">Withold(2%)</label></td>
                                            <td style="text-align: center;">
                                                <label id="pivinfodirectinfowitholdingAmntLbl" class="formattedNum"
                                                    strong style="font-size: 16px; font-weight: bold;"></label>

                                            </td>
                                        </tr>

                                        <tr id="pivinfodirectinfonetpayTr" style="display: visible;">
                                            <td style="text-align: right;"><label strong style="font-size: 16px;">Net
                                                    Pay</label></td>
                                            <td style="text-align: center;">
                                                <label id="pivinfodirectinfonetpayLbl" class="formattedNum" strong
                                                    style="font-size: 16px; font-weight: bold;" class="lbl"></label>

                                            </td>
                                        </tr>

                                        <tr>
                                            <td style="text-align: right;"><label strong style="font-size: 16px;">No. of
                                                    Items</label></td>
                                            <td style="text-align: center;"><label
                                                    id="pivinfodirectinfonumberofItemsLbl" strong
                                                    style="font-size: 16px; font-weight: bold;">0</label></td>

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

    <div class="modal modal-slide-in new-user-modal fade" id="">
        <div class="modal-dialog modal-dialog-scrollable sidebar-xl" style="width: 90%;">
            <form class="add-new-user modal-content pt-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                <div class="modal-header mb-1">
                    <h5 class="modal-title" id="exampleModalLabel">Purchase Invoice Information</h5>
                </div>
                <div class="modal-body flex-grow-1">
                    <div class="col-xl-12">


                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-xl-12 col-lg-12" id="directfooter">
                        <div class="row">
                            <input type="hidden" placeholder="" class="form-control" name="recordIds"
                                id="recordIds" readonly="true" />
                            <input type="hidden" placeholder="" class="form-control" name="evelautestatus"
                                id="evelautestatus" readonly="true" />
                            <div class="col-xl-6 col-lg-12">

                                <button type="button" id="payrprintbutton" class="btn btn-outline-dark"><i
                                        data-feather="printer" class="mr-25"></i>Print</button>
                            </div>
                            <div class="col-xl-6 col-lg-12" style="text-align:right;">

                                <button id="closebutton" type="button" class="btn btn-outline-danger"
                                    onclick="paymentrequestrefresh();" data-dismiss="modal"><i
                                        class="fa-regular fa-xmark"></i> Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- add srart of history modal-->
    <div class="modal modal-slide-in event-sidebar fade" id="purchaseinvloicehistorymodal" data-keyboard="false"
        data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true"
        style="overflow-y:scroll;">
        <div class="modal-dialog modal-dialog-scrollable sidebar-xl" style="width: 80%;">
            <div class="modal-content p-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                <div class="modal-header mb-1">
                    <h5 class="modal-title" id="paymentinvoicehistorystatus"> </h5>
                </div>
                <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                    <div>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12">
                                <div class="table-responsive scroll scrdiv">
                                    <table id="historpurchaseinvoicetables"
                                        class="display table-bordered table-striped table-hover dt-responsive mb-0"
                                        style="width:100%">
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
    <!--/ end of history modal modal-->
@endsection
@section('scripts')
    <script type="text/javascript">
        var m = 0;
        var mm = 0;
        var j = 0;
        var jj = 0;
        var i = 0;
        var pctables = '';
        var previousValues = '';
        var maingblIndex = 0;
        var errorcolor = "#ffcccc";

        $("#goodadds").on('click', function() {
            let tdValue = -1;
            let inputValue = -1;
            let lastRowValues = [];
            let lastRow = $('#directgoodsdynamictables > tbody tr:last');
            lastRow.find('td').each(function() { // Get the value of the <td> element
                tdValue = $(this).text().trim(); // For text content
                inputValue = $(this).find('input, select')
            .val(); // If the <td> contains an input, select, or other form element, get its value instead
                lastRowValues.push(inputValue || tdValue); // Push the value to the array
            });
            if (inputValue != -1) {

                var itemids = $('#itemNameSl' + inputValue).val() || 0;
                if (itemids == 0) {
                    $('#select2-itemNameSl' + inputValue + '-container').parent().css('background-color',
                        errorcolor);
                    toastrMessage('error', 'Please select item from highlighted field', 'Error');
                } else {
                    appendynamictables();
                }
            } else {
                appendynamictables();
            }
        });

        function appendynamictables() {
            ++jj;
            ++mm;
            goodsappendtable(jj, mm);
            renumberRows();
            for (let k = 1; k <= mm; k++) {
                const selectedVal = $('#itemNameSl' + k).val();
                if (selectedVal) {
                    $('#itemNameSl' + mm + " option[value='" + selectedVal + "']").remove();
                }
            }
        }

        function goodsappendtable(jj, mm) {
            const tables = `<tr id="row${jj}">
                            <td style="text-align:center;">${jj}</td>
                            <td><select id="itemNameSl${mm}" class="select2 form-control form-control-lg eName" onchange="goodchanges(this)" name="row[${mm}][itemid]"></select></td>
                            <td><select id="uom${mm}" class="select2 form-control uom" onchange="goodchanges(this)" name="row[${mm}][uom]"></select></td>
                            <td><input type="text" name="row[${mm}][qauntity]" placeholder="Quantity" id="goodqty${mm}" class="goodqty form-control" onkeyup="directgoodCalculateTotal(this)" onkeypress="return ValidateNum(event);"/></td>
                            <td><input type="text" name="row[${mm}][unitprice]" placeholder="Price" id="goodprice${mm}" class="goodprice form-control" onkeyup="directgoodCalculateTotal(this)" onkeypress="return ValidateNum(event);"/></td>
                            <td><input type="text" name="row[${mm}][total]" placeholder="Total" id="goodtotal${mm}" class="goodtotal form-control" onkeypress="return ValidateNum(event);" readonly/></td>
                            <td style="width:3%;text-align:center;background-color:#efefef;"><button type="button" class="btn btn-lignt btn-sm goodsremove-tr"><i class="fa-sharp fa-solid fa-x" style="color: #f03000;"></i></button></td>
                            <td style="display:none;"><input type="text" name="row[${mm}][vals]" id="directvals${mm}" class="goodsdirectvals form-control" readonly="true" style="font-weight:bold;" value="${mm}"/></td>
                        </tr>`;
            $("#directgoodsdynamictables > tbody").append(tables);
            const itemoption = $("#hiddenitem > option").clone();
            $(`#itemNameSl${mm}`).append(itemoption);
            $(`#itemNameSl${mm}`).select2({
                placeholder: "Select Goods"
            });

            const uomoption = $("#hiddenuom > option").clone();
            $(`#uom${mm}`).append(uomoption);
            $(`#uom${mm}`).select2({
                placeholder: "Select UOM"
            });

        }
        $(document).on('click', '.goodsremove-tr', function() {
            $(this).parents('tr').remove();
            directgoodCalculateGrandTotal();
            renumberRows();
        });

        function renumberRows() {
            let ind;
            $('#directgoodsdynamictables > tbody > tr').each(function(index, el) {
                $(this).children('td').first().text(++index);
                $('#goodsdirectnumberofItemsLbl').html(index);
                ind = index;
                jj = ind;
            });
        }

        function goodchanges(ele) {
            var itemid = $(ele).closest('tr').find('.eName').val();
            const idval = $(ele).closest('tr').find('.goodsdirectvals').val();
            $('#select2-itemNameSl' + idval + '-container').parent().css('background-color', "white");
            $.ajax({
                type: "GET",
                url: "{{ url('goodsuom') }}/" + itemid,
                success: function(response) {
                    $(`#uom${idval}`).select2('destroy');
                    $(`#uom${idval}`).val(response.uomid).select2();
                    $(`#uom${idval} option`).each(function() {
                        $(this).prop('disabled', !$(this).is(
                        ':selected')); // Disable option if it is not selected
                    });
                    $(`#uom${idval}`).select2({
                        placeholder: "Select Measurement"
                    });
                }
            });
        }

        function directgoodCalculateTotal(ele) {
            const $row = $(ele).closest('tr');
            const itemId = $row.find('.eName').val();
            const idVal = $row.find('.goodsdirectvals').val();
            const qty = $row.find('.goodqty').val() || 0;
            const unitprice = $row.find('.goodprice').val() || 0;

            let total = parseFloat(qty) * parseFloat(unitprice)
            total = Number(total).toFixed(2);
            $row.find('.goodtotal ').val(total);
            directgoodCalculateGrandTotal();
        }
        $('#goodsdirectcustomCheck1').click(function() {
            if ($('#goodsdirectcustomCheck1').is(':checked')) {
                $('#directistaxable').val('1');
            } else {
                $('#directistaxable').val('0');
            }

            directgoodCalculateGrandTotal();

        });

        function directgoodCalculateGrandTotal() {
            let subtotal = 0;
            let tax = 0;
            let grandTotal = 0;
            let vat = 0;
            let withold = 0;
            let aftertax = 0;
            let netpay = 0;
            let qty = 0;
            let unitprice = 0;
            $("#directgoodsdynamictables > tbody tr").each(function(i, val) {
                subtotal += parseFloat($(this).find('td').eq(5).find('input').val() || 0);
                unitprice += parseFloat($(this).find('td').eq(4).find('input').val() || 0);
                qty += parseFloat($(this).find('td').eq(3).find('input').val() || 0);
            });
            let ispotaxable = parseInt($('#directistaxable').val(), 10) || 0;
            switch (ispotaxable) {
                case 1:
                    let percentoadd = parseFloat(15 / 100) + 1;
                    aftertax = parseFloat(subtotal) * parseFloat(percentoadd);
                    $('#goodsdirecttaxtr').show();
                    $('#goodsdirectgrandtotaltr').show();
                    tax = parseFloat(aftertax) - parseFloat(subtotal);
                    break;

                default:

                    $('#goodsdirecttaxtr').hide();
                    $('#goodsdirectgrandtotaltr').hide();
                    break;
            }

            if (parseFloat(subtotal) >= 10000) {
                withold = (parseFloat(subtotal) * 2) / 100;
                $('#directwitholdingTr').show();
                $('#goodsdirectnetpayTr').show();
                $('#goodsdirectvatTr').hide();
            } else {
                $('#directwitholdingTr').hide();
                $('#goodsdirectnetpayTr').hide();
                $('#goodsdirectvatTr').hide();

            }

            grandTotal = parseFloat(subtotal) + parseFloat(tax);
            netpay = parseFloat(grandTotal) - parseFloat(withold);
            $('#goodsdirectsubtotalLbl').html(numformat(subtotal.toFixed(2)));
            $('#goodsdirecttaxLbl').html(numformat(tax.toFixed(2)));
            $('#goodsdirectgrandtotalLbl').html(numformat(grandTotal.toFixed(2)));
            $('#goodsdirectwitholdingAmntLbl').html(numformat(withold.toFixed(2)));
            $('#goodsdirectnetpayLbl').html(numformat(netpay.toFixed(2)));

            $('#directsubtotali').val(subtotal.toFixed(2));
            $('#directtaxi').val(tax.toFixed(2));
            $('#directgrandtotali').val(grandTotal.toFixed(2));
            $('#directwitholdingAmntin').val(withold.toFixed(2));
            $('#directvatAmntin').val(vat.toFixed(2));
            $('#directnetpayin').val(netpay.toFixed(2));

            $('.qtytotal').html(numformat(qty.toFixed(2)));
            $('.unitpricetotal').html(numformat(unitprice.toFixed(2)));
            $('.goodpricetotal').html(numformat(subtotal.toFixed(2)));
        }

        $('#payrprintbutton').click(function() {
            var id = $('#recordIds').val();
            var link = "/paymentrequestattachemnt/" + id;
            window.open(link, 'Purchase Order', 'width=1200,height=800,scrollbars=yes');
        });

        function viewpaymenthistory() {
            var id = $('#referenceno').val() || 0;
            var suplier = $('#supplier').val() || 0;

            switch (id) {
                case 0:
                    toastrMessage('error', 'Please select Purchase order number', 'Error');
                    break;

                default:
                    var titleValue = $('#referenceno option:selected').attr('title');
                    var customertile = $('#supplier option:selected').attr('title');
                    paymenthistorydetails(id, titleValue, customertile, suplier);
                    break;
            }


        }

        function infoviewpaymenthistory(id, supplier) {
            var pono = $('#payrequestinfopo').text() || 0;
            var cname = $('#paymentrequestinfsupname').text() || 0;
            var tin = $('#paymentrequestinfosupptin').text() || 0;
            var customertile = cname + ' ' + tin;
            paymenthistorydetails(id, pono, customertile, supplier);
        }

        function paymenthistorydetails(id, titleValue, customertile, suplier) {
            $('#paymenthistorystatus').html('Payment History Of ' + customertile);

            $.ajax({
                type: "GET",
                url: "{{ url('getotalpodetiails') }}/" + id,
                dataType: "json",
                beforeSend: function() {
                    cardSection.block({
                        message: '<div class="d-flex justify-content-center align-items-center"><p class="mr-50 mb-50">Loading Please Wait...</p><div class="spinner-grow spinner-grow-sm text-white" role="status"></div> </div>',
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
                complete: function() {
                    cardSection.block({
                        message: '',
                        timeout: 1,
                        css: {
                            backgroundColor: '',
                            color: '',
                            border: ''
                        },
                    });

                },
                success: function(response) {
                    $('#historytotalamount').html(response.totalamount);
                    switch (response.totalamount) {
                        case 0:
                            var titleValue = $('#referenceno option:selected').attr('title');
                            toastrMessage('error', 'This Purcase Order# ' + titleValue +
                                ' does not have a previous payment history!', 'Error!');

                            break;

                        default:
                            showhistorydatatables(id, suplier);
                            break;
                    }
                }
            });

        }

        function showhistorydatatables(id, suplier) {
            $('#historypcontracttables').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                fixedHeader: true,
                searchHighlight: true,
                destroy: true,
                paging: false,
                ordering: false,
                info: false,
                lengthMenu: [
                    [50, 100],
                    [50, 100]
                ],
                "pagingType": "simple",
                language: {
                    search: '',
                    searchPlaceholder: "Search here"
                },
                "dom": "<'row'<'col-lg-5 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-5'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
                ajax: {
                    url: "{{ url('historypaymentrequestlist') }}/" + id + "/" + suplier,
                    type: 'GET',
                    beforeSend: function() {
                        cardSection.block({
                            message: '<div class="d-flex justify-content-center align-items-center"><p class="mr-50 mb-50">Loading Please Wait...</p><div class="spinner-grow spinner-grow-sm text-white" role="status"></div> </div>',
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
                    complete: function() {
                        cardSection.block({
                            message: '',
                            timeout: 1,
                            css: {
                                backgroundColor: '',
                                color: '',
                                border: ''
                            },
                        });
                        $('#modals-slide-in').modal('show');
                    },
                },
                columns: [{
                        data: 'DT_RowIndex'
                    },
                    {
                        data: 'docno',
                        name: 'docno'
                    },
                    {
                        data: 'reference',
                        name: 'reference',
                        'visible': false
                    },
                    {
                        data: 'paymentreference',
                        name: 'paymentreference',
                        'visible': true
                    },
                    {
                        data: 'paymentmode',
                        name: 'paymentmode',
                        'visible': true
                    },
                    {
                        data: 'paymentstatus',
                        name: 'paymentstatus'
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'Amount',
                        name: 'Amount'
                    },
                ],
                columnDefs: [{
                        targets: 3,
                        render: function(data, type, row, meta) {
                            switch (data) {
                                case 'PO':
                                    return 'Purchase Order';
                                    break;
                                case 'PI':
                                    return 'Purchase Invoice';
                                    break;
                                default:
                                    return 'Good Recieving';
                                    break;
                            }
                        }
                    },
                    {
                        targets: 7,
                        render: function(data, type, row, meta) {
                            switch (data) {
                                case 0:
                                    return '<span class="text-secondary font-weight-medium"><b>Draft</b></span>';
                                    break;
                                case 1:
                                    return '<span class="text-warning font-weight-medium"><b>Pending</b></span>';
                                    break;
                                case 2:
                                    return '<span class="text-primary font-weight-medium"><b>Verify</b></span>';
                                    break;
                                case 3:
                                    return '<span class="text-success font-weight-medium"><b>Approved</b></span>';
                                    break;
                                case 4:
                                    return '<span class="text-danger font-weight-danger"><b>Void</b></span>';
                                    break;
                                case 5:
                                    return '<span class="text-danger font-weight-danger"><b>Rejected</b></span>';
                                    break;
                                default:
                                    return '--';
                                    break;
                            }
                        }
                    },
                    {
                        targets: 8,
                        render: function(data, type, row, meta) {
                            switch (row.status) {
                                case 3:
                                    var numberendering = $.fn.dataTable.render.number(',', '.', 2, )
                                    .display;
                                    return numberendering(data);
                                    break;
                                default:
                                    return '';
                                    break;
                            }

                        }
                    },
                ],

                "footerCallback": function(row, data, start, end, display) {
                    var api = this.api();
                    // Helper function to parse integer from strings
                    var intVal = function(i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 : // Remove commas and convert to int
                            typeof i === 'number' ?
                            i : 0;
                    };
                    var total = api
                        .cells(function(index, data, node) {
                            return api.row(index).data().status === 3 ?
                                true : false;
                        }, 8)
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    var totamount = $('#historytotalamount').text() || 0;
                    totamount = totamount.replace(/,/g, '');
                    var numberendering = $.fn.dataTable.render.number(',', '.', 2, ).display;
                    total = total.toFixed(2);
                    var remain = parseFloat(totamount) - parseFloat(total);

                    $('#historypaidamount').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>" +
                        numberendering(total) + "</h6>");
                    $('#historyremainamount').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>" +
                        numberendering(remain) + "</h6>");

                },
            });
        }
        $('.filter-select').change(function() {
            let search = [];
            $.each($('.filter-select option:selected'), function() {
                search.push($(this).val());
            });
            search = search.join('|');
            pctables.column(12).search(search, true, false).draw();
        });
        $('.itemfilter-select').change(function() {
            let search = [];
            $.each($('.itemfilter-select option:selected'), function() {
                search.push($(this).val());
            });
            search = search.join('|');
            pctables.column(4).search(search, true, false).draw();
        });

        function clearvoiderror() {
            $('#cancelreason-error').html('');
            $('#voidreason-error').html('');
            $('#suppliervoidreason-error').html('');
        }
        $('#povoidbutton').click(function() {
            var form = $("#povoidform");
            var formData = form.serialize();
            $.ajax({
                type: "POST",
                url: "{{ url('payrvoid') }}",
                data: formData,
                dataType: "json",
                success: function(response) {
                    if (response.errors) {
                        if (response.errors.Reason) {
                            $('#voidreason-error').html(response.errors.Reason[0]);
                        }
                    } else if (response.dberrors) {
                        toastrMessage('error', response.dberrors, 'Error!');
                    } else if (response.success) {
                        switch (response.success) {
                            case 300:
                                toastrMessage('error', 'Can not verify this purchase order', 'Error');
                                break;

                            default:
                                toastrMessage('success', 'Succeesfully Saved', 'Success');
                                $('#povoidmodal').modal('hide');
                                var oTable = $('#pcontracttables').dataTable();
                                oTable.fnDraw(false);
                                $("#paymentrequestinfomodal").modal('hide');
                                break;
                        }
                    }
                }
            });
        });

        function paymentrequestrefresh() {
            var oTable = $('#pcontracttables').dataTable();
            oTable.fnDraw(false);
        }

        function payrtab(params) {

        }

        $('#directcustomCheck1').click(function() {
            if ($('#directcustomCheck1').is(':checked')) {
                $('#directistaxable').val('1');
                calculatetaxableforeeach();
            } else {
                $('#directistaxable').val('0');
                undocalculatetaxableforeeach();
            }
            directCalculateGrandTotal();
        });

        function calculatetaxableforeeach() {
            $('#directdynamicTablecommdity > tbody > tr').each(function() {
                var price = $(this).find('td').eq(14).find('input').val() || 0;
                var total = $(this).find('td').eq(15).find('input').val() || 0;
                price = (parseFloat(price) / (1 + (15 / 100))).toFixed(2);
                total = (parseFloat(total) / (1 + (15 / 100))).toFixed(2);
                $(this).find('td').eq(14).find('input').val(price);
                $(this).find('td').eq(15).find('input').val(total);
            });
        }

        function undocalculatetaxableforeeach() {
            $('#directdynamicTablecommdity > tbody > tr').each(function() {
                var price = $(this).find('td').eq(14).find('input').val() || 0;
                var total = $(this).find('td').eq(15).find('input').val() || 0;
                price = (parseFloat(price) * (1 + (15 / 100))).toFixed(2);
                total = (parseFloat(total) * (1 + (15 / 100))).toFixed(2);
                $(this).find('td').eq(14).find('input').val(price);
                $(this).find('td').eq(15).find('input').val(total);
            });
        }

        function calculatepoGrandtotal() {
            var nofbagtotal = 0;
            var kgtotal = 0;
            var bagwiehtotal = 0;
            var netkgtotal = 0;
            var tontotal = 0;
            var pricetotal = 0;
            var totalferesula = 0;
            var subtotal = 0;
            var withold = 0;
            var aftertax = 0;
            var netpay = 0;
            var tax = 0;
            var vat = 0;
            // var netpay=$('#payrdirectinfonetpayLbl').text();
            // netpay=netpay.replace(/[^0-9.]/g, '');
            var istaxable = $('#directistaxable').val();

            $("#purchaseorderinfodatatables > tbody tr").each(function(i, val) {
                subtotal += parseFloat($(this).find('td').eq(13).find('input').val() || 0);
                nofbagtotal += parseFloat($(this).find('td').eq(6).find('input').val() || 0);
                bagwiehtotal += parseFloat($(this).find('td').eq(7).find('input').val() || 0);
                kgtotal += parseFloat($(this).find('td').eq(9).find('input').val() || 0);
                netkgtotal += parseFloat($(this).find('td').eq(7).find('input').val() || 0);
                tontotal += parseFloat($(this).find('td').eq(10).find('input').val() || 0);
                totalferesula += parseFloat($(this).find('td').eq(11).find('input').val() || 0);
                pricetotal += parseFloat($(this).find('td').eq(12).find('input').val() || 0);
            });

            switch (istaxable) {
                case '1':
                    aftertax = parseFloat(subtotal) * (1 + (15 / 100));
                    // tax=parseFloat(subtotal)-parseFloat(aftertax);
                    // subtotal=parseFloat(subtotal)-parseFloat(tax);
                    tax = parseFloat(aftertax) - parseFloat(subtotal); //recently addedd comment uplad
                    $('#supplierinfotaxtr').show();
                    $('#supplierinforandtotaltr').show();
                    break;
                default:

                    $('#supplierinfotaxtr').hide();
                    $('#supplierinforandtotaltr').hide();
                    break;
            }

            if (parseFloat(subtotal) >= 10000) {
                withold = (parseFloat(subtotal) * 2) / 100;
                $('#visibleinfowitholdingTr').show();
                $('#directinfonetpayTr').show();
                $('#directvatTr').hide();
            } else {
                $('#visibleinfowitholdingTr').hide();
                $('#directinfonetpayTr').hide();
            }

            grandTotal = parseFloat(subtotal) + parseFloat(tax);
            netpay = parseFloat(grandTotal) - parseFloat(withold);

            $('#ponofbagtotal').html(numformat(nofbagtotal.toFixed(2)));
            $('#bagweighttotal').html(numformat(bagwiehtotal.toFixed(2)));
            $('#pokgtotal').html(numformat(kgtotal.toFixed(2)));
            $('#netkgtotal').html(numformat(netkgtotal.toFixed(2)));
            $('#potontotal').html(numformat(tontotal.toFixed(2)));
            $('#poferesulatotal').html(numformat(totalferesula.toFixed(2)));
            $('#popricetotal').html(numformat(pricetotal.toFixed(2)));
            $('#pototalprice').html(numformat(subtotal.toFixed(2)));

            $('#payrdirectinfosubtotalLbl').html(numformat(subtotal.toFixed(2)));
            $('#payrdirectinfotaxLbl').html(numformat(tax.toFixed(2)));

            $('#payrdirectinfowitholdingAmntLbl').html(numformat(withold.toFixed(2)));
            $('#payrdirectinfograndtotalLbl').html(numformat(grandTotal.toFixed(2)));
            $('#payrdirectinfonetpayLbl').html(numformat(netpay.toFixed(2)));

            $('#directsubtotali').val(subtotal.toFixed(2));
            $('#directtaxi').val(tax.toFixed(2));
            $('#directgrandtotali').val(grandTotal.toFixed(2));
            $('#directwitholdingAmntin').val(withold.toFixed(2));
            $('#directvatAmntin').val(vat.toFixed(2));
            $('#directnetpayin').val(netpay.toFixed(2));

            var dataexit = $('#isdataexistornot').val();
            var grnexist = $('#isgrnexistornot').val();

            var paidamount = $('#constantpaidamount').val() || 0;
            var remain = parseFloat(netpay) - parseFloat(paidamount);
            $('#pototalamount').html(numformat(netpay.toFixed(2)));
            $('#poremainamount').html(numformat(remain.toFixed(2)));
            $('#remainamount').val(remain.toFixed(2));
            $('#poremainamount').removeClass('text-success font-weight-medium');
            $('#poremainamount').addClass('text-success font-weight-medium');

            var edit = $('#payrid').val() || 0;
        }

        function directCalculateGrandTotal() {
            var subtotal = 0;
            var tax = 0;
            var grandTotal = 0;
            var vat = 0;
            var withold = 0;
            var aftertax = 0;
            var netpay = 0;
            var nofbagtotal = 0;
            var bagweighttotal = 0;
            var kgtotal = 0;
            var netkgtotal = 0;
            var tontotal = 0;
            var pricetotal = 0;
            var totalpricetotal = 0;
            var totalferesula = 0;
            var dtables = '';
            var checkboxes = '';
            var paymentreference = $('#paymentreference').val();
            switch (paymentreference) {
                case 'PI':
                    dtables = 'pidirectdynamicTablecommdity';
                    checkboxes = 'pidirectcustomCheck1';
                    break;

                default:
                    dtables = 'directdynamicTablecommdity';
                    checkboxes = 'directcustomCheck1';
                    break;
            }

            $("#directdynamicTablecommdity > tbody tr").each(function(i, val) {
                subtotal += parseFloat($(this).find('td').eq(15).find('input').val() || 0);
                nofbagtotal += parseFloat($(this).find('td').eq(8).find('input').val() || 0);
                bagweighttotal += parseFloat($(this).find('td').eq(9).find('input').val() || 0);
                kgtotal += parseFloat($(this).find('td').eq(10).find('input').val() || 0);
                netkgtotal += parseFloat($(this).find('td').eq(11).find('input').val() || 0);
                tontotal += parseFloat($(this).find('td').eq(12).find('input').val() || 0);
                pricetotal += parseFloat($(this).find('td').eq(14).find('input').val() || 0);
                totalferesula += parseFloat($(this).find('td').eq(13).find('input').val() || 0);
            });
            var istaxable = $('#directistaxable').val();
            istaxable = parseInt(istaxable);
            switch (istaxable) {
                case 1:
                    aftertax = parseFloat(subtotal) * (1 + (15 / 100));
                    $('#directtaxtr').show();
                    $('#directgrandtotaltr').show();
                    tax = parseFloat(aftertax) - parseFloat(subtotal);
                    //subtotal=parseFloat(subtotal)-parseFloat(tax);
                    break;

                default:
                    $('#directtaxtr').hide();
                    $('#directgrandtotaltr').hide();
                    break;
            }

            if (parseFloat(subtotal) >= 10000) {
                withold = (parseFloat(subtotal) * 2) / 100;
                $('#directwitholdingTr').show();
                $('#directnetpayTr').show();
                $('#directvatTr').hide();
            } else {
                $('#directwitholdingTr').hide();
                $('#directnetpayTr').hide();
                $('#directvatTr').hide();

            }
            grandTotal = parseFloat(subtotal) + parseFloat(tax);
            netpay = parseFloat(grandTotal) - parseFloat(withold);

            $('#nofbagtotal').html(numformat(nofbagtotal.toFixed(2)));
            $('#recivebagweighttotal').html(numformat(bagweighttotal.toFixed(2)));
            $('#kgtotal').html(numformat(kgtotal.toFixed(2)));
            $('#recivenetkgtotal').html(numformat(netkgtotal.toFixed(2)));
            $('#tontotal').html(numformat(tontotal.toFixed(2)));
            $('#pricetotal').html(numformat(pricetotal.toFixed(2)));
            $('#totalpricetotal').html(numformat(subtotal.toFixed(2)));
            $('#priceferesula').html(numformat(totalferesula.toFixed(2)));

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

            var dataexit = $('#isdataexistornot').val();
            var grnexist = $('#isgrnexistornot').val();

            var paidmount = $('#constantpaidamount').val();
            var remain = parseFloat(netpay) - parseFloat(paidmount)

            $('#pototalamount').html(numformat(netpay.toFixed(2)));
            $('#popaidamount').html(numformat(paidmount));
            $('#remainamount').val(remain.toFixed(2));
            $('#poremainamount').html(numformat(remain.toFixed(2)));

            $('#poremainamount').removeClass('text-success font-weight-medium');
            $('#poremainamount').addClass('text-success font-weight-medium');

        }

        function closeinlineFormModalWithClearValidation() {
            $('.rmerror').html('');
        }
        $('#Register').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            savedata(formData);
        });

        function savedata(formdata) {
            var id = $('#porderid').val() || 0;
            $.ajax({
                type: "POST",
                url: "{{ url('paymentrequestsavedata') }}",
                contentType: false,
                processData: false,
                data: formdata,
                dataType: "json",
                beforeSend: function() {
                    cardSection.block({
                        message: '<div class="d-flex justify-content-center align-items-center"><p class="mr-50 mb-50">Loading Please Wait...</p><div class="spinner-grow spinner-grow-sm text-white" role="status"></div> </div>',
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
                complete: function() {
                    cardSection.block({
                        message: '',
                        timeout: 1,
                        css: {
                            backgroundColor: '',
                            color: '',
                            border: ''
                        },
                    });

                },
                success: function(response) {
                    if (response.success) {
                        toastrMessage('success', 'Succeesfully Saved', 'Success');
                        var oTable = $('#pcontracttables').dataTable();
                        oTable.fnDraw(false);
                        $("#exampleModalScrollable").modal('hide');
                    }
                    if (response.errors) {
                        if (response.errors.type) {
                            $('#type-error').html(response.errors.type[0]);
                        }
                        if (response.errors.commoditytype) {
                            $('#commoditytype-error').html(response.errors.commoditytype[0]);
                        }
                        if (response.errors.coffeesource) {
                            $('#coffeesource-error').html(response.errors.coffeesource[0]);
                        }
                        if (response.errors.coffestatus) {
                            $('#coffestatus-error').html(response.errors.coffestatus[0]);
                        }
                        if (response.errors.paymentmode) {
                            $('#paymentmode-error').html(response.errors.paymentmode[0]);
                        }
                        if (response.errors.date) {
                            $('#date-error').html(response.errors.date[0]);
                        }
                        if (response.errors.paymentmode) {
                            $('#paymentmode-error').html(response.errors.paymentmode[0]);
                        }
                        if (response.errors.amount) {
                            $('#amount-error').html(response.errors.amount[0]);
                        }
                        if (response.errors.supplier) {
                            $('#supplier-error').html(response.errors.supplier[0]);
                        }
                        if (response.errors.productype) {
                            $('#productype-error').html(response.errors.productype[0]);
                        }
                        if (response.errors.referenceno) {
                            $('#referenceno-error').html(response.errors.referenceno[0]);
                        }
                        if (response.errors.purpose) {
                            $('#purpose-error').html(response.errors.purpose[0]);
                        }
                        
                    }
                }
            });
        }
        $('#withitems').on('change', function() {
            let selectedValue = $(this).val();
            let reference = $("#type").val() || 0;
            let productype = $("#productype").val() || 0;
            if (reference == 'Direct' && productype == 'Goods') {
                switch (selectedValue) {
                    case 'With':
                        $('#directrow').show();
                        break;
                    default:
                        $('#directrow').hide();
                        break;
                }
            } else {
            }
        });

        $('#colorCheck1').click(function() {
            if ($('#colorCheck1').is(':checked')) {
                $('#withitems').val('With');
                $('#directrow').show();
            } else {
                $('#withitems').val('Without');
                $('#directrow').hide();
            }
        });

        function resetSelect2Dropdowns() {
            const dropdowns = [
                '#productype',
                '#referenceno',
                '#purchaseordertype',
                '#commoditytype',
                '#coffeesource',
                '#coffestatus',
                '#coffestatus',
                '#paymentstatus',
                '#paymentmode',
                '#supplier',
                '#paymentreference'
            ];
            dropdowns.forEach(dropdown => {
                $(dropdown).select2('destroy').val(null).select2();
            });
        }
        function clearInputFields() {
            const fields = [
                '#constatntremainamount',
                '#constantpaidamount',
                '#amount',
            ];
            fields.forEach(field => {
                $(field).val('');
            });
        }
        function resetUI() {
            // Clear tables
            $("#purchaseorderinfodatatables > tbody").empty();
            $("#directdynamicTablecommdity > tbody").empty();
            $("#directgoodsdynamictables > tbody").empty();
            
            $('#poremainamount').html('');
            $('#popaidamount').html('');
            $('#pototalamount').html('');
            // Reset labels and totals
        }
        $('#type').on('change', function() {
            var type = $('#type').val() || 0;
            var supplier = $('#supplier').val() || 0;
            resetselect2();
            resetSelect2Dropdowns();
            clearInputFields();
            resetUI();
            $('#commodityrow').hide();
            switch (type) {
                case 'Direct':
                    $('#referencenodiv').hide();
                    $('#amountdetailsdiv').hide();

                    updateSelect2('#paymentreference', 'Direct', true);
                    updateSelect2('#paymentmode', 'Pre Finance', true);
                    updateSelect2('#paymentstatus', 'Direct', true);

                    $('#directsubtotali').val('0.00');
                    $('#directgrandtotali').val('0.00');
                    $('#directwitholdingAmntin').val('0.00');
                    $('#directnetpayin').val('0.00');
                    var supplierhidden = $('#supplierhidden').val() || 0;
                    var supplier = $('#supplier').val() || 0;
                    if (supplier != supplierhidden) {
                        $.ajax({
                            type: "GET",
                            url: "{{ url('checkdirectexist') }}/" + supplier,
                            dataType: "json",
                            beforeSend: function() {
                                cardSection.block({
                                    message: '<div class="d-flex justify-content-center align-items-center"><p class="mr-50 mb-50">Loading Please Wait...</p><div class="spinner-grow spinner-grow-sm text-white" role="status"></div> </div>',
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
                            complete: function() {
                                cardSection.block({
                                    message: '',
                                    timeout: 1,
                                    css: {
                                        backgroundColor: '',
                                        color: '',
                                        border: ''
                                    },
                                });

                            },
                            success: function(response) {
                                switch (response.dataexist) {
                                    case true:

                                        toastrMessage('error',
                                            'Payment request on pending should be approved',
                                            'Error!');
                                        $('#type').select2('destroy');
                                        $('#type').val('').select2();
                                        $('#supplier').select2('destroy');
                                        $('#supplier').val('').select2();
                                        break;

                                    default:
                                        break;
                                }
                            }
                        });
                    }

                    break;
                default:

                    $('#referencenodiv').show();
                    $('#amountdetailsdiv').show();
                    $('#paymentreference').select2('destroy');
                    $('#paymentreference').val('').select2();
                    $('#paymentmode').select2('destroy');
                    $('#paymentmode').val('').select2();
                    $('#paymentstatus').select2('destroy');
                    $('#paymentstatus').val('').select2();
                    $('#paymentmode option[value!=0]').prop('disabled', false);
                    $('#paymentstatus option[value!=0]').prop('disabled', false);

                    break;
            }
            $('#type-error').html('');
        });
        $('#productype').on('change', function() {
            $('#productype-error').html('');
            let reference = $('#type').val() || 0;
            $('#directrow').hide();
            
            switch (reference) {
                case 0:
                    toastrMessage('error', 'Select reference first', 'Error!');
                    $('#productype').select2('destroy').val('').select2();
                    $('.withitemsclass').hide();
                    break;
                case 'Direct':
                    $('.withitemsclass').show();
                    toggleElementsBasedOnProductType();
                    fetchReferenceNumber();
                    break;
                default:
                    $('.withitemsclass').hide();
                    toggleElementsBasedOnProductType();
                    fetchReferenceNumber();
                    break;
            }
        });

        function toggleElementsBasedOnProductType() {
            const productType = $('#productype').val();
            const isGoods = productType === 'Goods';
            $('.cmdtyclass').toggle(!isGoods);
        }
        $('#supplier').on('change', function() {
            $('#supplier-error').html('');
            $('#commodityrow').hide();

            $('#referenceno').select2('destroy');
            $('#referenceno').val('').select2();

            $('#commoditytype').select2('destroy');
            $('#commoditytype').val('').select2();

            $('#coffeesource').select2('destroy');
            $('#coffeesource').val('').select2();

            $('#coffestatus').select2('destroy');
            $('#coffestatus').val('').select2();

            $('#amountdetailsdiv').hide();

        });

        $('#purpose').on('keyup', function() {
            $('#purpose-error').html('');
        });
        $('#date').on('change', function() {
            $('#date-error').html('');
        });
        $('#coffestatus').on('change', function() {
            $('#coffestatus-error').html('');
        });
        $('#commoditytype').on('change', function() {
            $('#commoditytype-error').html('');
        });
        $('#coffeesource').on('change', function() {
            $('#coffeesource-error').html('');
        });

        $('#paymentmode').on('change', function() {
            $('#paymentmode-error').html('');
        });

        function fetchReferenceNumber() {
            let supplier = $('#supplier').val() || 0;
            let productype = $('#productype').val() || 0;
            $('#referenceno').empty();
            var optiondefault = "<option selected disabled value=''></option>";
            $('#referenceno').append(optiondefault);
            var option = '';
            $.ajax({
                type: "GET",
                url: "{{ url('getreference') }}/" + supplier + "/" + productype,
                dataType: "json",
                beforeSend: function() {
                    cardSection.block({
                        message: '<div class="d-flex justify-content-center align-items-center"><p class="mr-50 mb-50">Loading Please Wait...</p><div class="spinner-grow spinner-grow-sm text-white" role="status"></div> </div>',
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
                complete: function() {
                    cardSection.block({
                        message: '',
                        timeout: 1,
                        css: {
                            backgroundColor: '',
                            color: '',
                            border: ''
                        },
                    });
                    $('#approvedmodal').modal('show');
                },
                success: function(response) {
                    $.each(response.po, function(index, value) {
                        option = '<option value="' + value.id + '" title="' + value.porderno + '">' +
                            value.porderno + ',' + value.Name + ',' + value.TinNumber + '</option>';
                        $('#referenceno').append(option);
                    });
                    $('#referenceno').select2();
                }
            });
        }
        $('#amount').on('input', function() {
            let value = $(this).val();
            if (parseFloat(value) === 0) {
                $(this).val('');
            }
        });

        function checkremianingamount(amount, type, element) {
            $('#amount-error').html('');
            switch (type) {
                case 'paste':
                    var amount = amount;
                    break;
                default:
                    var amount = $('#amount').val() || 0;
                    break;
            }

            var productypes = $('#type').val() || 0;
            switch (productypes) {
                case 'Direct':
                    $('#remainamount').val('0.00');
                    $('#constatntremainamount').val('0.00');
                    $('#constantpaidamount').val('0.00');
                    break;

                default:
                    var payrid = $('#payrid').val() || 0;
                    var netpay = $('#constatntremainamount').val() || 0;
                    var type = $('#type').val();
                    var paidamount = 0.00;
                    var constpaidamount = 0.00;
                    var remaining = $('#constatntremainamount').val() || 0;
                    var paymentreference = $('#paymentreference').val() || 0;
                    var advancepercent = $('#advancepercent').val();
                    var totalamount = $('#pototalamount').html() || 0;
                    var paidam = $('#popaidamount').html() || 0;
                    var remainamount = $('#poremainamount').html() || 0;
                    totalamount = totalamount.replace(/,/g, '');
                    remainamount = remainamount.replace(/,/g, '');
                    paidam = paidam.replace(/,/g, '');
                    var remainingcalculated = parseFloat(totalamount) - parseFloat(paidam) - parseFloat(amount);
                    remainingcalculated = Number(remainingcalculated.toFixed(2));
                    switch (paymentreference) {
                        case 'PO':
                        case 'GRV':
                            netpay = $('#pototalamount').text() || 0;
                            netpay = netpay.replace(/,/g, '');
                            paidamount = parseFloat(amount) + parseFloat(paidam);
                            var advancepay = (parseFloat(advancepercent) / 100);
                            var totaltopay = parseFloat(netpay) * parseFloat(advancepay);
                            var totalpay = parseFloat(amount) + parseFloat(paidam);
                            var currentpay = parseFloat(totaltopay) - parseFloat(paidam);
                            currentpay = currentpay.toFixed(2);
                            totaltopay = totaltopay.toFixed(2);
                            totalpay = totalpay.toFixed(2);
                            if (parseFloat(totalpay) > parseFloat(totaltopay)) {
                                $('#amount').val('');
                                $(element).val('');
                                if (parseFloat(currentpay) >= 0) {
                                    toastrMessage('info',
                                        'You have reached maximum amount of advance payment. You should have to pay only ' +
                                        numformat(currentpay) + ' amounts  ', 'Info!');

                                } else {
                                    toastrMessage('info', 'You have reached maximum amount of advance payment.', 'Info!');
                                }
                            }
                            break;

                        default:

                            break;
                    }
                    if (parseFloat(amount) > parseFloat(remainamount)) {
                        $('#amount').val('');
                        toastrMessage('error', 'More than the Remaining Amount. Not possible to pay!', 'Error!');
                    } else {
                        if (parseFloat(remainingcalculated) > 0) {
                            $('#remainamount').val(remainingcalculated.toFixed(2));
                            $('#paymentstatus option[value!=0]').prop('disabled', false);
                            $('#paymentstatus').select2('destroy');
                            $('#paymentstatus').val('Partial Paid').select2();
                            $('#paymentstatus option[value!="Partial Paid"]').prop('disabled', true);
                        } else {
                            $('#paymentstatus option[value!=0]').prop('disabled', false);
                            $('#paymentstatus').select2('destroy');
                            $('#paymentstatus').val('Fully Paid').select2();
                            $('#paymentstatus option[value!="Fully Paid"]').prop('disabled', true);
                        }

                    }
                    break;
            }
        }
        $('#paymentreference').on('select2:open', function() {
            previousValues = $(this).val();
            // console.log("Values before change:", previousValues);
        });

        $('#paymentreference').on('change', function() {
            var reference = $('#referenceno').val() || 0;
            var supplier = $('#supplier').val() || 0;
            var paymentreference = $('#paymentreference').val();
            var paidamount = $('#popaidamount').html() || 0;
            var recivecount = 0;
            var pocount = 0;
            var poexist = false;

            $('#amount').val('');
            $.ajax({
                type: "GET",
                url: "{{ url('getpaymentreference') }}/" + reference + "/" + supplier + "/" +
                    paymentreference,
                dataType: "json",
                success: function(response) {
                    $('#directistaxable').val(response.istaxble);
                    $('#constantpaidamount').val(response.paidamount);
                    $('#popaidamount').html(numformat(response.paidamount));
                    recivecount = response.recievcount;
                    pocount = response.pocount;
                    poexist = response.poexist;
                    switch (paymentreference) {
                        case 'PO':
                            switch (poexist) {
                                case false:
                                    toastrMessage('error',
                                        'There is no purchase order to pay in advance', 'Error');
                                    $('#popaidamount').html(paidamount);
                                    paidamount = paidamount.replace(/[^0-9.]/g, '');
                                    $('#constantpaidamount').val(paidamount);

                                    switch (previousValues) {
                                        case 'PI':
                                            $('#paymentreference').select2('destroy');
                                            $('#paymentreference').val('PI').select2();
                                            break;
                                        default:
                                            $('#paymentreference').select2('destroy');
                                            $('#paymentreference').val('GRV').select2();
                                            break;
                                    }
                                    break;

                                default:
                                    $("#purchaseorderinfodatatables > tbody").empty();
                                    $("#directdynamicTablecommdity > tbody").empty();
                                    $('#directdynamicTablecommdity').hide();
                                    $('#directpricetable').hide();
                                    $('#directtaxi').val('0.00');
                                    $('#directgrandtotali').val('0.00');
                                    $('#directwitholdingAmntin').val('0.00');
                                    $('#directvatAmntin').val('0.00');
                                    $('#directsubtotali').val('0.00');
                                    $('#directnetpayin').val('0.00');
                                    $('#directcustomCheck1').prop('checked', false);

                                    $('#purchaseorderview-tab').removeClass('active');
                                    $('#grnview-tab').removeClass('active');
                                    $('#piview-tab').removeClass('active');
                                    $('#purchaseorderview-tab').addClass('active');

                                    $('#grnview').removeClass('active');
                                    $('#purchaseorderview').addClass('active');

                                    $('#piview-tab').removeClass('active');
                                    $('#piview').removeClass('active');
                                    $('#payrinfopiview').removeClass('active');

                                    $('#paymentreference').select2('destroy');
                                    $('#paymentreference').val('PO').select2();

                                    $('#paymentrequestinfoapptabs .nav-link[data-tab="2"]').addClass(
                                        'disabled');
                                    $('#paymentrequestinfoapptabs .nav-link[data-tab="3"]').addClass(
                                        'disabled');

                                    $('#paymentmode option[value!=0]').prop('disabled', false);
                                    $('#paymentmode').select2('destroy');
                                    $('#paymentmode option[value!="Advance"]').attr('disabled', true)
                                        .hide();
                                    $('#paymentmode').val('Advance').select2();
                                    $('#paymentmode').select2();
                                    appendpurchaseorder(response.grn);
                                    break;
                            }

                            break;

                        case 'GRV':
                            if (Array.isArray(response.grn) && response.grn.length === 0) {
                                toastrMessage('error', 'There is no good recieving to pay', 'Error');
                                $('#paymentreference').select2('destroy');
                                $('#paymentreference').val(previousValues).select2();
                                $('#popaidamount').html(paidamount);
                                paidamount = paidamount.replace(/[^0-9.]/g, '');
                                $('#constantpaidamount').val(paidamount);
                            } else {

                                $("#purchaseorderinfodatatables > tbody").empty();
                                $("#directdynamicTablecommdity > tbody").empty();
                                $('#purchaseorderview-tab').removeClass('active');
                                $('#grnview-tab').removeClass('active');
                                $('#piview-tab').removeClass('active');
                                $('#grnview-tab').addClass('active');

                                $('#piview-tab').removeClass('active');
                                $('#piview').removeClass('active');
                                $('#payrinfopiview').removeClass('active');
                                $('#purchaseorderview').removeClass('active');
                                $('#grnview').addClass('active');

                                $('#directdynamicTablecommdity').show();
                                $('#directpricetable').show();

                                $('#grnremainamount').removeClass('text-success font-weight-medium');
                                $('#paymentrequestinfoapptabs .nav-link[data-tab="2"]').removeClass(
                                    'disabled');
                                $('#paymentrequestinfoapptabs .nav-link[data-tab="1"]').addClass(
                                    'disabled');
                                $('#paymentrequestinfoapptabs .nav-link[data-tab="3"]').addClass(
                                    'disabled');

                                $('#paymentmode option[value!="0"]').attr('disabled', false);
                                $('#paymentmode option[value!="Recuring Payment"]').attr('disabled',
                                    true);
                                $('#paymentmode').select2('destroy');
                                $('#paymentmode').val('Recuring Payment').select2();
                                $('#paymentmode').select2();

                                appendcommodity(response.grn, 'grv');
                            }

                            break;
                        case 'PI':
                            switch (response.purchaseinvoicexist) {
                                case false:
                                    toastrMessage('error', 'There is no purchase invoice to pay',
                                        'Error');
                                    $('#popaidamount').html(paidamount);
                                    paidamount = paidamount.replace(/[^0-9.]/g, '');
                                    $('#constantpaidamount').val(paidamount);
                                    switch (previousValues) {
                                        case 'PO':
                                            $('#paymentreference').select2('destroy');
                                            $('#paymentreference').val('PO').select2();
                                            break;

                                        default:
                                            $('#paymentreference').select2('destroy');
                                            $('#paymentreference').val('GRV').select2();
                                            break;
                                    }

                                    break;

                                default:
                                    $('#paymentrequestinfoapptabs .nav-link[data-tab="1"]').addClass(
                                        'disabled');
                                    $('#paymentrequestinfoapptabs .nav-link[data-tab="2"]').addClass(
                                        'disabled');
                                    $('#paymentrequestinfoapptabs .nav-link[data-tab="3"]').removeClass(
                                        'disabled');
                                    $('#purchaseorderview-tab').removeClass('active');

                                    $('#purchaseorderview').removeClass('active');
                                    $('#piview-tab').addClass('active');
                                    $('#piview').addClass('active');
                                    $('#payrinfopiview').remove('active');
                                    $('#grnview').addClass('active');
                                    $('#grnview-tab').removeClass('active');

                                    $('#directdynamicTablecommdity').show();
                                    $('#directpricetable').show();

                                    $('#paymentmode option').prop('disabled', false);
                                    $('#paymentmode').select2('destroy');
                                    $('#paymentmode').val('Recuring Payment').select2();
                                    $('#paymentmode option').each(function() {
                                        $(this).prop('disabled', !$(this).is(
                                        ':selected')); // Disable option if it is not selected
                                    });
                                    $('#paymentmode').select2();

                                    appendcommodity(response.grn, 'pi');
                                    break;
                            }


                            break;
                        default:
                            break;
                    }
                }
            });
        });
        $('#referenceno').on('change', function() {
            const reference = $('#referenceno').val();
            const supplier = $('#supplier').val() || 0;
            resetFormFields();
            disableOptions(false);
            $.ajax({
                type: "GET",
                url: `{{ url('papoinfo') }}/${reference}/${supplier}`,
                beforeSend: showLoadingIndicator,
                complete: hideLoadingIndicator,
                success: function(response) {
                    updateUI(response);
                    handleResponseData(response);
                }
            });
        });

        function resetFormFields() {
            $(`#supplier option, #coffeesource option, #commoditytype option,#coffeesource option,#coffestatus option`)
                .prop(`disabled`, false);
            $('#commodityrow').show();
            $('#paymentmode, #paymentstatus').select2('destroy').val('').select2();
            $('#amount, #remainamount').val('');
            $('#coffeesource-error, #commoditytype-error, #coffestatus-error, #referenceno-error').html('');
            $("#purchaseorderinfodatatables > tbody, #directdynamicTablecommdity > tbody").empty();
            $('#paymentreference, #supplier').find('option').prop('disabled', false).end().select2();
        }

        function disableOptions(disable) {
            $('#commoditytype, #coffeesource, #coffestatus').find('option[value!=0]').prop('disabled', disable);
        }

        function showLoadingIndicator() {
            cardSection.block({
                message: '<div class="d-flex justify-content-center align-items-center"><p class="mr-50 mb-50">Loading Please Wait...</p><div class="spinner-grow spinner-grow-sm text-white" role="status"></div> </div>',
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

        function hideLoadingIndicator() {
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

        function updateUI(response) {
            const {
                createdAtInAddisAbaba,
                paidamount,
                remainamount,
                totalamount,
                dataexist,
                isgrvexist
            } = response;

            // Update document date
            $('#infodocumentdate').html(createdAtInAddisAbaba);
            // Format and update amounts
            const formattedPaidAmount = numformat(paidamount);
            const formattedRemainAmount = numformat(remainamount);
            const formattedTotalAmount = numformat(totalamount);

            $('#pototalamount').html(formattedTotalAmount);
            $('#popaidamount').html(formattedPaidAmount);
            $('#poremainamount').html(formattedRemainAmount);
            $('#poremainamount').addClass('text-success font-weight-medium');
            // Update input values
            $('#constatntremainamount, #remainamount').val(remainamount);
            $('#constantpaidamount').val(paidamount);
            $('#isdataexistornot').val(dataexist);
            $('#isgrnexistornot').val(isgrvexist);
        }

        function handleResponseData(response) {
            let status = '',
                type = '',
                poid = '',
                pono = '',
                peno = '',
                peid = '',
                polinks = '',
                ispotaxable = '';
            let purchaseinvoicexist = false,
                grvexist = false,
                isrecievexist = false,
                poexist = false;
            let purchaseordertype = '';
            response.po.forEach(value => {
                polinks = `<a href="#" onclick="viewpoinformation(${value.id});"><u>${value.porderno}</u></a>`;
                $('.payrinforeference').html(value.type);
                $('.payrinfopo').html(polinks);
                $('#payrdirectinfosubtotalLbl, #payrdirectinfotaxLbl, #payrdirectinfograndtotalLbl, #payrdirectinfowitholdingAmntLbl, #payrdirectinfonetpayLbl')
                    .html(numformat(value.subtotal), numformat(value.tax), numformat(value.grandtotal), numformat(
                        value.withold), numformat(value.netpay));
                updateSelect2('#supplier', value.customers_id, true);
                updateSelect2('#commoditytype', value.commudtytype, true);
                updateSelect2('#coffeesource', value.commudtysource, true);
                updateSelect2('#coffestatus', value.commudtystatus, true);
                status = value.status;
                type = value.type;
                poid = value.id;
                pono = value.porderno;
                peid = value.purchasevaulation_id;
                ispotaxable = value.istaxable || 0;
                $('#directistaxable').val(ispotaxable);
            });

            grvexist = response.isgrvexist;
            isrecievexist = response.isrecievexist;
            peno = response.pedocno;
            poexist = response.poexist;
            purchaseinvoicexist = response.purchaseinvoicexist;
            purchaseordertype = response.purchaseordertype;
            if (response.existonprogress) {
                const referencenohidden = $('#referencenohidden').val() || 0;
                const reference = $('#referenceno').val() || 0;
                const titleValue = $('#referenceno option:selected').attr('title');
                if (referencenohidden != reference) {
                    showunapprovedmessages(titleValue);
                } else {
                    appenddataperinvoiceorgrv(purchaseinvoicexist, response.grn, ispotaxable, poid, grvexist, poexist,
                        purchaseordertype);
                }
            } else {
                appenddataperinvoiceorgrv(purchaseinvoicexist, response.grn, ispotaxable, poid, grvexist, poexist,
                    purchaseordertype);
            }
        }

        function updateSelect2(selector, value, disableOtherOptions = false) {
            $(selector).select2('destroy').val(value).select2();
            if (disableOtherOptions) {
                $(`${selector} option[value!="${value}"]`).prop('disabled', true);
            }
        }

        function showunapprovedmessages(titleValue) {
            toastrMessage('error', 'This Purchase Order# ' + titleValue +
                ' has an unapproved payment request! Please complete it first.', 'Error!');
            $('#referenceno').select2('destroy');
            $('#referenceno').val('').select2();
            $('#pototalamount').html('');
            $('#popaidamount').html('');
            $('#poremainamount').html('');
            $('#commodityrow').hide();
            $('#commoditytype').select2('destroy');
            $('#commoditytype').val('').select2();
            $('#coffeesource').select2('destroy');
            $('#coffeesource').val('').select2();
            $('#coffestatus').select2('destroy');
            $('#coffestatus').val('').select2();
            $('#commodityrow').hide();
            $("#commoditytype option[value!=0]").prop('disabled', false);
            $("#coffeesource option[value!=0]").prop('disabled', false);
            $("#coffestatus option[value!=0]").prop('disabled', false);
        }

        function appenddataperinvoiceorgrv(purchaseinvoicexist, grn, ispotaxable, poid, grvexist, poexist,
            purchaseordertype) {
            switch (purchaseinvoicexist) {
                case true:
                    $('#paymentrequestinfoapptabs .nav-link[data-tab="1"]').addClass('disabled');
                    $('#paymentrequestinfoapptabs .nav-link[data-tab="2"]').addClass('disabled');
                    $('#paymentrequestinfoapptabs .nav-link[data-tab="3"]').removeClass('disabled');
                    $('#purchaseorderview-tab').removeClass('active');
                    $('#purchaseorderview').removeClass('active');
                    $('#piview-tab').addClass('active');
                    $('#piview').addClass('active');
                    $('#payrinfopiview').remove('active');
                    $('#grnview').addClass('active');
                    $('#grnview-tab').removeClass('active');

                    $('#directdynamicTablecommdity').show();
                    $('#directpricetable').show();
                    $('#paymentmode').select2('destroy');
                    $('#paymentmode').val('Recuring Payment').select2();
                    $('#paymentreference option').prop('disabled', false); // Remove disabled attribute from option
                    $('#paymentreference').select2('destroy');
                    $('#paymentreference').val('PI').select2();
                    var paymemtreference = $('#paymentreference').val();
                    switch (ispotaxable) {
                        case 0:
                            $('#directcustomCheck1').prop('checked', false);
                            $('#supplierinfotaxtr').hide();
                            $('#supplierinforandtotaltr').hide();
                            break;
                        default:

                            $('#directcustomCheck1').prop('checked', true);
                            $('#supplierinfotaxtr').show();
                            $('#supplierinforandtotaltr').show();
                            break;
                    }

                    appendcommodity(grn, 'pi');
                    break;
                default:
                    if (Array.isArray(grn) && grn.length === 0) {
                        // Handle empty array response here
                        switch (poexist) {
                            case false:
                                toastrMessage('error', 'There is no purchase order in to pay in advance', 'Error');
                                $('#commodityrow').hide();
                                break;
                            default:
                                $('#directdynamicTablecommdity').hide();
                                $('#directpricetable').hide();
                                $('#directtaxi').val('0.00');
                                $('#directgrandtotali').val('0.00');
                                $('#directwitholdingAmntin').val('0.00');
                                $('#directvatAmntin').val('0.00');
                                $('#directsubtotali').val('0.00');
                                $('#directnetpayin').val('0.00');
                                $('#directcustomCheck1').prop('checked', false);
                                $('#piview-tab').removeClass('active');
                                $('#piview').removeClass('active');
                                $('#payrinfopiview').removeClass('active');
                                $('#purchaseorderview-tab').removeClass('active');
                                $('#grnview-tab').removeClass('active');
                                $('#piview-tab').removeClass('active');
                                $('#purchaseorderview-tab').addClass('active');
                                $('#grnview').removeClass('active');
                                $('#purchaseorderview').addClass('active');
                                $('#paymentreference').select2('destroy');
                                $('#paymentreference').val('PO').select2();
                                $('#paymentrequestinfoapptabs .nav-link[data-tab="2"]').addClass('disabled');
                                $('#paymentrequestinfoapptabs .nav-link[data-tab="3"]').addClass('disabled');
                                $('#paymentmode option[value!=0]').prop('disabled', false);
                                $('#paymentmode').select2('destroy');
                                $('#paymentmode option[value!="Advance"]').attr('disabled', true).hide();
                                $('#paymentmode').val('Advance').select2();
                                $('#paymentmode').select2();
                                switch (ispotaxable) {
                                    case 0:

                                        $('#supplierinfotaxtr').hide();
                                        $('#supplierinforandtotaltr').hide();
                                        break;

                                    default:

                                        $('#supplierinfotaxtr').show();
                                        $('#supplierinforandtotaltr').show();
                                        break;
                                }

                                switch (purchaseordertype) {
                                    case 'Goods':
                                        $('#purchaseorderinfodatatables').hide();
                                        $('#goodsdynamictables').show();

                                        goodsorderlist(poid);
                                        break;

                                    default:
                                        $('#goodsdynamictables').hide();
                                        $('#purchaseorderinfodatatables').show();
                                        porderlist(poid);

                                        break;
                                }

                                break;
                        }

                    } else if (Array.isArray(grn)) {

                        // Handle non-empty array response here
                        $('#purchaseorderview-tab').removeClass('active');
                        $('#purchaseorderview').removeClass('active');
                        $('#grnview-tab').removeClass('active');
                        $('#piview-tab').removeClass('active');
                        $('#grnview-tab').addClass('active');
                        $('#grnview').addClass('active');

                        $('#piview-tab').removeClass('active');
                        $('#piview').removeClass('active');
                        $('#payrinfopiview').removeClass('active');

                        $('#directdynamicTablecommdity').show();
                        $('#directpricetable').show();

                        $('#paymentreference').select2('destroy');
                        $('#paymentreference').val('GRV').select2();

                        $('#paymentrequestinfoapptabs .nav-link[data-tab="2"]').removeClass('disabled');
                        $('#paymentrequestinfoapptabs .nav-link[data-tab="1"]').addClass('disabled');
                        $('#paymentrequestinfoapptabs .nav-link[data-tab="3"]').addClass('disabled');

                        $('#paymentmode option[value!="0"]').attr('disabled', false);
                        $('#paymentmode option[value!="Recuring Payment"]').attr('disabled', true);
                        $('#paymentmode').select2('destroy');
                        $('#paymentmode').val('Recuring Payment').select2();
                        $('#paymentmode').select2();

                        switch (ispotaxable) {
                            case 0:
                                $('#directcustomCheck1').prop('checked', false);
                                $('#supplierinfotaxtr').hide();
                                $('#supplierinforandtotaltr').hide();
                                break;

                            default:
                                $('#directcustomCheck1').prop('checked', true);
                                $('#supplierinfotaxtr').show();
                                $('#supplierinforandtotaltr').show();
                                break;
                        }
                        appendcommodity(grn, 'grv');
                    } else {

                        console.log('Response is not an array');
                        // Handle cases where the response is not an array
                    }
                    break;
            }
            switch (grvexist) {
                case true:
                    break;
                default:
                    switch (purchaseinvoicexist) {
                        case true:
                            break;
                        default:
                            $('#paymentreference option').each(function() {
                                $(this).prop('disabled', !$(this).is(
                                ':selected')); // Disable option if it is not selected
                            });
                            $('#paymentreference').select2();
                            break;
                    }

                    break;
            }
        }

        function appendpurchaseorder(products) {
            jj = 0;
            $.each(products, function(index, value) {
                ++jj;
                ++mm;
                ton = value.ton;
                var tables = '<tr id="row' + mm + '" class="financialevdynamic-commudity">' +
                    '<td style="text-align:center;">' + jj + '</td>' +
                    '<td><select id="itemNameSl' + mm +
                    '" class="select2 form-control form-control-lg eName" onchange="directsourceVal(this)" name="row[' +
                    mm + '][evItemId]"></select></td>' +
                    '<td><select id="cropyear' + mm +
                    '" class="select2 form-control cropyear" onchange="directsourceVal(this)" name="row[' + mm +
                    '][evcropyear]"></select></td>' +
                    '<td><select id="coffeproccesstype' + mm +
                    '" class="select2 form-control coffeproccesstype" onchange="directsourceVal(this)" name="row[' +
                    mm + '][coffeproccesstype]"></select></td>' +
                    '<td><select id="directgrade' + mm +
                    '" class="select2 form-control directgrade" onchange="directsourceVal(this)" name="row[' + mm +
                    '][directgrade]"></select></td>' +
                    '<td><select id="uom' + mm +
                    '" class="select2 form-control uom" onchange="directsourceVal(this)" name="row[' + mm +
                    '][uom]"></select></td>' +
                    '<td><input type="text" name="row[' + mm + '][nofbag]" placeholder="No of bag" id="nofbag' +
                    mm + '" value="' + value.NumOfBag + '" class="nofbag form-control" readonly/></td>' +
                    '<td><input type="text" name="row[' + mm +
                    '][bagweight]" placeholder="Bag Weight" id="bagweight' + mm + '" value="' + value.TotalKg +
                    '" class="bagweight form-control" readonly/></td>' +
                    '<td><input type="text" name="row[' + mm + '][totalkg]" placeholder="Bag Weight" id="totalkg' +
                    mm + '" value="' + value.TotalKg + '" class="totalkg form-control" readonly/></td>' +
                    '<td><input type="text" name="row[' + mm + '][netkg]" placeholder="Bag Weight" id="netkg' + mm +
                    '" value="' + value.TotalKg + '" class="netkg form-control" readonly/></td>' +
                    '<td><input type="text" name="row[' + mm + '][ton]" placeholder="Ton" id="ton' + mm +
                    '" value="' + ton + '" class="ton form-control" readonly/></td>' +
                    '<td><input type="text" name="row[' + mm + '][feresula]" placeholder="feresula" id="feresula' +
                    mm + '" value="' + value.Feresula + '" class="directferesula form-control" readonly/></td>' +
                    '<td><input type="text" name="row[' + mm + '][price]" placeholder="Price" id="price' + mm +
                    '" value="' + value.Price +
                    '" class="price form-control" onkeyup="directCalculateTotal(this)" onkeypress="return ValidateNum(event);" readonly/></td>' +
                    '<td><input type="text" name="row[' + mm + '][total]" placeholder="Total Price" id="total' +
                    mm + '" value="' + value.TotalPrice + '" class="total form-control" readonly/></td>' +
                    '<td style="display:none;"><input type="text" name="row[' + mm +
                    '][podetailid]" id="podetailid' + mm +
                    '" class="podetailid form-control" readonly="true" style="font-weight:bold;" value="' + value
                    .id + '"/></td>' +
                    '<td style="display:none;"><input type="hidden" name="row[' + mm + '][vals]" id="directvals' +
                    mm + '" class="directvals form-control" readonly="true" style="font-weight:bold;" value="' +
                    mm + '"/></td>' +
                    '</tr>';
                $("#purchaseorderinfodatatables > tbody").append(tables);

                var itemoptionsselected = '<option selected value="' + value.CommodityId + '">' + value.Origin +
                    '</option>';
                var cropyearselected = '<option selected value="' + value.CropYear + '">' + value.CropYear +
                    '</option>';
                var proccesstypeselected = '<option selected value="' + value.ProcessType + '">' + value
                    .ProcessType + '</option>';
                var uomselected = '<option selected value="' + value.uomid + '" title="' + value.amount + '">' +
                    value.uomname + '</option>';
                var gardeselected = '<option selected value="' + value.Grade + '">' + value.Grade + '</option>';

                $('#itemNameSl' + mm).append(itemoptionsselected);
                $('#itemNameSl' + mm).select2();

                $('#cropyear' + mm).append(cropyearselected);
                $('#cropyear' + mm).select2();

                $('#directgrade' + mm).append(gardeselected);
                $('#directgrade' + mm).select2();

                $('#coffeproccesstype' + mm).append(proccesstypeselected);
                $('#coffeproccesstype' + mm).select2();

                $('#uom' + mm).append(uomselected);
                $('#uom' + mm).select2();
                $('#uom' + mm).select2({
                    placeholder: "Select uom"
                });
                caclculateRemAmount(mm);
            });
            var count = $("#purchaseorderinfodatatables > tbody tr").length;
            $('#directinfonumberofItemsLbl').html(count);
            calculatepoGrandtotal();
        }

        function caclculateRemAmount(indx) {
            var commodity = "";
            var grade = "";
            var prtype = "";
            var cropyear = "";
            var uomval = "";
            var poId = "";
            var poDetId = "";
            var recId = "";
            var numofbag = 0;
            var bagweight = 1;
            var pobagweight = 0;
            var weightbykg = 0;
            var ponetkg = 0;
            var feresula = 0;
            var pototalkg = 0;
            var poton = 0;

            var rectotalkg = 0;
            var recnetkg = 0;
            var recnumofbag = 0;
            var recweightbykg = 0;
            var recferesula = 0;
            var recton = 0;
            var ponumofbag = 0;

            var poferesula = 0;
            var othnumofbag = 0;
            var othweightbykg = 0;
            var othferesula = 0;

            var remnumofbag = 0;
            var remkg = 0;

            var remweightbykg = 0;
            var remferesula = 0;

            $.ajax({
                url: '/calcRemAmount',
                type: 'POST',
                data: {
                    commodity: $('#itemNameSl' + indx).val(),
                    grade: $('#directgrade' + indx).val(),
                    prtype: $('#coffeproccesstype' + indx).val(),
                    cropyear: $('#cropyear' + indx).val(),
                    uomval: $('#uom' + indx).val(),
                    poDetId: $('#podetailid' + indx).val(),
                    poId: $('#referenceno').val(),
                    recId: $('#receivingId').val(),
                },
                beforeSend: function() {
                    cardSection.block({
                        message: '<div class="d-flex justify-content-center align-items-center"><p class="mr-50 mb-50">Loading Please Wait...</p><div class="spinner-grow spinner-grow-sm text-white" role="status"></div> </div>',
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
                complete: function() {
                    cardSection.block({
                        message: '',
                        timeout: 1,
                        css: {
                            backgroundColor: '',
                            color: '',
                            border: ''
                        },
                    });
                },
                success: function(data) {
                    $.each(data.purdetaildata, function(index, value) {
                        //console.log("This is purchase detail id="+value.totalkg);
                        ponumofbag = value.qty;
                        pototalkg = value.totalkg;
                        bagweight = value.bagweight;
                        pobagweight = parseFloat(value.qty) * parseFloat(value.bagweight);
                        ponetkg = parseFloat(value.totalkg) - parseFloat(pobagweight);
                        poferesula = parseFloat(ponetkg) / 17;
                        poton = (parseFloat(ponetkg) / 1000).toFixed(2);
                    });
                    $.each(data.recdetaildata, function(index, value) {
                        //console.log("This is receiving detail net kg="+value.NetKg);
                        recnetkg = value.NetKg;
                        rectotalkg = value.TotalKg;
                        recnumofbag = value.NumOfBag;
                        recweightbykg = value.NetKg;
                        recferesula = value.Feresula;
                        recton = (parseFloat(recnetkg) / 1000).toFixed(2);
                    });

                    remnumofbag = parseFloat(ponumofbag) - parseFloat(recnumofbag);
                    remkg = parseFloat(ponetkg) - parseFloat(recnetkg);
                    remferesula = parseFloat(poferesula) - parseFloat(recferesula);
                    remferesula = Number(remferesula.toFixed(2));
                    //remferesula = Math.floor(remferesula * 10000) / 10000;

                    var totalkg = parseFloat(pototalkg) - parseFloat(rectotalkg);
                    var price = $('#price' + indx).val();
                    var total = (parseFloat(price) * parseFloat(remferesula)).toFixed(2);

                    var bagweight = parseFloat(remnumofbag) * parseFloat(bagweight);
                    var remainton = (parseFloat(poton) - parseFloat(recton)).toFixed(2);
                    $('#nofbag' + indx).val(remnumofbag);
                    $('#bagweight' + indx).val(bagweight);
                    $('#feresula' + indx).val(remferesula);
                    $('#total' + indx).val(total);
                    $('#totalkg' + indx).val(totalkg.toFixed(2));
                    $('#netkg' + indx).val(remkg.toFixed(2));
                    $('#ton' + indx).val(remainton);
                    if (parseFloat(remnumofbag) <= 0) {
                        $("#row" + indx).remove();

                    }
                    calculatepoGrandtotal();
                }
            });
        }

        function withitemsgoodsorderlist(id) {
            $.ajax({
                type: 'GET',
                url: `{{ url('directwithitemsgood') }}/${id}`,
                dataType: 'json',
                beforeSend: showLoadingIndicator,
                complete: hideLoadingIndicator,
                error: handleAjaxError,
                success: function(response) {
                    directappendgoodlist(response.comiditylist, 'Direct');
                },
            });
        }

        function goodsorderlist(id) {
            $.ajax({
                type: 'GET',
                url: `{{ url('getgoodpurchaseorder') }}/${id}`,
                dataType: 'json',
                beforeSend: showLoadingIndicator,
                complete: hideLoadingIndicator,
                error: handleAjaxError,
                success: function(response) {
                    directappendgoodlist(response.comiditylist, 'PO');
                },
            });
        }

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

        function directappendgoodlist(params, type) {
            let jj = 0;
            let $tbody = '';
            switch (type) {
                case 'Direct':
                    $tbody = $("#directgoodsdynamictables > tbody");
                    break;
                default:
                    $tbody = $("#goodsdynamictables > tbody");
                    break;
            }
            $tbody.empty(); // Clear the table body
            $.each(params, function(index, value) {
                ++jj;
                ++mm;
                // Generate and append the table row
                const tableRow = generateTableRow(jj, mm, value, type);
                $tbody.append(tableRow);
                // Populate and configure the item dropdown
                configureItemDropdown(mm, value);
                // Populate and configure the UOM dropdown
                configureUomDropdown(mm, value);
            });
            // Update UI and calculate totals
            goodstableupdatesUI(type);
        }

        function generateTableRow(jj, mm, value, type) {
            let td = '';
            switch (type) {
                case 'Direct':
                    td = `<td style="width:3%;text-align:center;background-color:#efefef;"><button type="button" class="btn btn-lignt btn-sm goodsremove-tr"><i class="fa-sharp fa-solid fa-x" style="color: #f03000;"></i></button></td>`
                    break;

                default:
                    break;
            }
            return `
        <tr id="row${jj}">
            <td style="text-align:center;">${jj}</td>
            <td><select id="itemNameSl${mm}" class="select2 form-control form-control-lg eName" onchange="goodchanges(this)" name="row[${mm}][itemid]"></select></td>
            <td><select id="uom${mm}" class="select2 form-control uom" onchange="goodchanges(this)" name="row[${mm}][uom]"></select></td>
            <td><input type="text" name="row[${mm}][qauntity]" placeholder="Quantity" id="goodqty${mm}" value="${value.qty}" class="goodqty form-control" onkeyup="goodCalculateTotal(this)" onkeypress="return ValidateNum(event);" readonly/></td>
            <td><input type="text" name="row[${mm}][unitprice]" placeholder="Price" id="goodprice${mm}" value="${value.price}" class="goodprice form-control" onkeyup="goodCalculateTotal(this)" onkeypress="return ValidateNum(event);" readonly/></td>
            <td><input type="text" name="row[${mm}][total]" placeholder="Total" id="goodtotal${mm}" value="${value.Total}" class="goodtotal form-control" onkeypress="return ValidateNum(event);" readonly/></td>
            ${td}
            <td style="display:none;">
                <input type="text" name="row[${mm}][vals]" id="directvals${mm}" class="goodsdirectvals form-control" readonly="true" style="font-weight:bold;" value="${mm}"/>
            </td>
        
        </tr>
    `;
        }

        function configureItemDropdown(mm, value) {
            const $itemDropdown = $(`#itemNameSl${mm}`);
            const selectedOption =
            `<option selected value="${value.itemid}">${value.item}</option>`; // Create selected option
            $itemDropdown.append(selectedOption).select2();
        }

        function configureUomDropdown(mm, value) {
            const $uomDropdown = $(`#uom${mm}`);
            const selectedUom =
            `<option selected value="${value.uomid}">${value.uomname}</option>`; // Create selected UOM option
            $uomDropdown.append(selectedUom).select2();
        }

        function goodstableupdatesUI(type) {
            let count = 0;
            console.log('type=', type);
            switch (type) {
                case 'Direct':
                    count = $("#directgoodsdynamictables > tbody tr").length;
                    $('#goodsdirectnumberofItemsLbl').html(count);
                    directgoodCalculateGrandTotal(); // Recalculate totals
                    break;
                default:
                    count = $("#goodsdynamictables > tbody tr").length;
                    $('#directinfopricetable').show();
                    $('#directinfonumberofItemsLbl').html(count);
                    goodCalculateGrandTotal(); // Recalculate totals
                    break;
            }
        }

        function goodCalculateGrandTotal() {
            let subtotal = 0;
            let tax = 0;
            let grandTotal = 0;
            let vat = 0;
            let withold = 0;
            let aftertax = 0;
            let netpay = 0;
            let qty = 0;
            let unitprice = 0;
            $("#goodsdynamictables > tbody tr").each(function(i, val) {
                subtotal += parseFloat($(this).find('td').eq(5).find('input').val() || 0);
                unitprice += parseFloat($(this).find('td').eq(4).find('input').val() || 0);
                qty += parseFloat($(this).find('td').eq(3).find('input').val() || 0);
            });
            let ispotaxable = parseInt($('#directistaxable').val(), 10) || 0;
            switch (ispotaxable) {
                case 1:
                    let percentoadd = parseFloat(15 / 100) + 1;
                    aftertax = parseFloat(subtotal) * parseFloat(percentoadd);
                    $('#supplierinfotaxtr').show();
                    $('#supplierinforandtotaltr').show();
                    tax = parseFloat(aftertax) - parseFloat(subtotal);
                    break;

                default:

                    $('#supplierinfotaxtr').hide();
                    $('#supplierinforandtotaltr').hide();
                    break;
            }

            if (parseFloat(subtotal) >= 10000) {
                withold = (parseFloat(subtotal) * 2) / 100;
                $('#visibleinfowitholdingTr').show();
                $('#directinfonetpayTr').show();
                $('#directvatTr').hide();
            } else {
                $('#visibleinfowitholdingTr').hide();
                $('#directinfonetpayTr').hide();
                $('#directvatTr').hide();

            }

            grandTotal = parseFloat(subtotal) + parseFloat(tax);
            netpay = parseFloat(grandTotal) - parseFloat(withold);
            $('#payrdirectinfosubtotalLbl').html(numformat(subtotal.toFixed(2)));
            $('#payrdirectinfotaxLbl').html(numformat(tax.toFixed(2)));
            $('#payrdirectinfograndtotalLbl').html(numformat(grandTotal.toFixed(2)));
            $('#payrdirectinfowitholdingAmntLbl').html(numformat(withold.toFixed(2)));
            $('#payrdirectinfonetpayLbl').html(numformat(netpay.toFixed(2)));

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

        function goodsporderlist(id) {

        }

        function porderlist(id) {
            jj = 0;
            var ton = 0;
            var bagweight = 0;
            var netkg = 0;
            var feresula = 0;
            $.ajax({
                type: "GET",
                url: "{{ url('payrdirectcommoditylist') }}/" + id + "/" + "add",
                data: "",
                dataType: "json",
                success: function(response) {
                    $.each(response.comiditylist, function(index, value) {
                        ++jj;
                        ++mm;
                        ton = value.ton;
                        bagweight = (parseFloat(value.qty) * parseFloat(value.bagweight)).toFixed(2);
                        netkg = parseFloat(value.totalKg) - parseFloat(bagweight);
                        ton = parseFloat(netkg) / 1000;
                        feresula = parseFloat(netkg) / 17;
                        feresula = Number(feresula.toFixed(2));

                        var tables = '<tr id="row' + mm + '" class="financialevdynamic-commudity">' +
                            '<td style="text-align:center;">' + jj + '</td>' +
                            '<td><select id="itemNameSl' + mm +
                            '" class="select2 form-control form-control-lg eName" onchange="directsourceVal(this)" name="row[' +
                            mm + '][evItemId]"></select></td>' +
                            '<td><select id="cropyear' + mm +
                            '" class="select2 form-control cropyear" onchange="directsourceVal(this)" name="row[' +
                            mm + '][evcropyear]"></select></td>' +
                            '<td><select id="coffeproccesstype' + mm +
                            '" class="select2 form-control coffeproccesstype" onchange="directsourceVal(this)" name="row[' +
                            mm + '][coffeproccesstype]"></select></td>' +
                            '<td><select id="directgrade' + mm +
                            '" class="select2 form-control directgrade" onchange="directsourceVal(this)" name="row[' +
                            mm + '][directgrade]"></select></td>' +
                            '<td><select id="uom' + mm +
                            '" class="select2 form-control uom" onchange="directsourceVal(this)" name="row[' +
                            mm + '][uom]"></select></td>' +
                            '<td><input type="text" name="row[' + mm +
                            '][nofbag]" placeholder="No of bag" id="nofbag' + mm + '" value="' + value
                            .qty + '" class="nofbag form-control" readonly/></td>' +
                            '<td><input type="text" name="row[' + mm +
                            '][bagweight]" placeholder="Bag Weight" id="bagweight' + mm + '" value="' +
                            bagweight + '" class="bagweight form-control" readonly/></td>' +
                            '<td><input type="text" name="row[' + mm +
                            '][totalkg]" placeholder="Total Kg" id="totalkg' + mm + '" value="' + value
                            .totalKg + '" class="totalkg form-control" readonly/></td>' +
                            '<td><input type="text" name="row[' + mm +
                            '][netkg]" placeholder="Netkg" id="netkg' + mm + '" value="' + netkg +
                            '" class="netkg form-control" readonly/></td>' +
                            '<td><input type="text" name="row[' + mm +
                            '][ton]" placeholder="Total Kg" id="ton' + mm + '" value="' + ton +
                            '" class="ton form-control" readonly/></td>' +
                            '<td><input type="text" name="row[' + mm +
                            '][feresula]" placeholder="feresula" id="feresula' + mm + '" value="' +
                            feresula + '" class="directferesula form-control" readonly/></td>' +
                            '<td><input type="text" name="row[' + mm +
                            '][price]" placeholder="Price" id="price' + mm + '" value="' + value.price +
                            '" class="price form-control" onkeyup="directCalculateTotal(this)" onkeypress="return ValidateNum(event);" readonly/></td>' +
                            '<td><input type="text" name="row[' + mm +
                            '][total]" placeholder="Total Price" id="total' + mm + '" value="' + value
                            .Total + '" class="total form-control" readonly/></td>' +
                            '<td style="width:3%;text-align:center;background-color:#efefef;"><a type="button"><i class="fa fa-info-circle text-primary info-icon viewcommodityinfo" title="Price Information" style="cursor: pointer;"></i></a></td>' +
                            '<td style="display:none;"><input type="text" name="row[' + mm +
                            '][podetailid]" id="podetailid' + mm +
                            '" class="podetailid form-control" readonly="true" style="font-weight:bold;" value="' +
                            value.id + '"/></td>' +
                            '<td style="display:none;"><input type="hidden" name="row[' + mm +
                            '][vals]" id="directvals' + mm +
                            '" class="directvals form-control" readonly="true" style="font-weight:bold;" value="' +
                            mm + '"/></td>' +
                            '</tr>';
                        $("#purchaseorderinfodatatables > tbody").append(tables);

                        var itemoptionsselected = '<option selected value="' + value.supplyworeda +
                            '">' + value.origin + '</option>';
                        var cropyearselected = '<option selected value="' + value.cropyear + '">' +
                            value.cropyear + '</option>';
                        var proccesstypeselected = '<option selected value="' + value.proccesstype +
                            '">' + value.proccesstype + '</option>';
                        var uomselected = '<option selected value="' + value.uomid + '" title="' + value
                            .amount + '">' + value.uomname + '</option>';
                        var gardeselected = '<option selected value="' + value.grade + '">' + value
                            .grade + '</option>';

                        $('#itemNameSl' + mm).append(itemoptionsselected);
                        $('#itemNameSl' + mm).select2();

                        $('#cropyear' + mm).append(cropyearselected);
                        $('#cropyear' + mm).select2();

                        $('#directgrade' + mm).append(gardeselected);
                        $('#directgrade' + mm).select2();
                        $('#coffeproccesstype' + mm).append(proccesstypeselected);
                        $('#coffeproccesstype' + mm).select2();
                        $('#uom' + mm).append(uomselected);
                        $('#uom' + mm).select2();
                        $('#uom' + mm).select2({
                            placeholder: "Select uom"
                        });
                        caclculateRemAmount(mm);

                    });

                    var count = $("#purchaseorderinfodatatables > tbody tr").length;
                    $('#directinfonumberofItemsLbl').html(count);

                    calculatepoGrandtotal();
                }

            });

        }
        $(document).on('mouseenter', '.viewcommodityinfo', function() {
            const $icon = $(this);
            var totalprice = $($icon).closest('tr').find('.total').val() || 0;
            var netkg = $($icon).closest('tr').find('.netkg').val() || 0;
            var priceperkg = parseFloat(totalprice) / parseFloat(netkg);
            var calculatedtotalprice = parseFloat(priceperkg) * parseFloat(netkg);
            priceperkg = Number(priceperkg.toFixed(2));
            calculatedtotalprice = Number(calculatedtotalprice.toFixed(2));
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
        $(document).on('mouseleave', '.viewcommodityinfo', function() {
            $(this).popover('dispose'); // Completely remove the popover
        });


        function appendcommodity(product, type) {
            var jj = 0;
            var ton = 0;
            var links = '';
            var pilinks = '';
            var dynamictables = '';
            var itemlables = '';
            var piid = 1;
            var bagweight = 0;
            var id = $('#payrid').val() || 0;
            $("#directdynamicTablecommdity > tbody").empty();
            $.each(product, function(index, value) {
                ++jj;
                ++mm;
                links = '<a href="#" onclick="viewrecievinginformation(' + value.recid + ');"><u>' + value
                    .DocumentNumber + '</u></a>';
                ton = (parseFloat(value.NetKg) / 1000).toFixed(2);
                switch (type) {
                    case 'pi':
                        pilinks = '<a href="#" onclick="viewpiformation(' + value.pid + ');"><u>' + value.docno +
                            '</u></a>';
                        piid = value.pid;
                        switch (id) {
                            case 0:
                                bagweight = value.bagwieght; // this is for add
                                break;
                            default:
                                bagweight = value.bagwieght; // this is for edit
                                break;
                        }
                        break;

                    default:
                        pilinks = '-';
                        piid = 1;
                        switch (id) {
                            case 0:
                                bagweight = value.bagwieght; // this is for add
                                break;
                            default:
                                bagweight = value.bagweight; // this is for edit
                                break;
                        }

                        break;
                }

                var tables = '<tr id="row' + jj + '" class="financialevdynamic-commudity">' +
                    '<td style="text-align:center;">' + jj + '</td>' +
                    '<td style="width:10%"><label>' + links + '</label></td>' +
                    '<td class="pivclass" style="width:10%"><label>' + pilinks + '</label></td>' +
                    '<td><select id="itemNameSl' + mm +
                    '" class="select2 form-control form-control-lg eName" onchange="directsourceVal(this)" name="fevrow[' +
                    mm + '][evItemId]"></select></td>' +
                    '<td><select id="cropyear' + mm +
                    '" class="select2 form-control cropyear" onchange="directsourceVal(this)" name="fevrow[' + mm +
                    '][evcropyear]"></select></td>' +
                    '<td><select id="coffeproccesstype' + mm +
                    '" class="select2 form-control coffeproccesstype" onchange="directsourceVal(this)" name="fevrow[' +
                    mm + '][coffeproccesstype]"></select></td>' +
                    '<td><select id="directgrade' + mm +
                    '" class="select2 form-control directgrade" onchange="directsourceVal(this)" name="fevrow[' +
                    mm + '][directgrade]"></select></td>' +
                    '<td><select id="uom' + mm +
                    '" class="select2 form-control uom" onchange="directsourceVal(this)" name="fevrow[' + mm +
                    '][uom]"></select></td>' +
                    '<td><input type="text" name="fevrow[' + mm + '][nofbag]" placeholder="No of bag" id="nofbag' +
                    mm + '" value="' + value.NumOfBag + '" class="nofbag form-control" readonly/></td>' +
                    '<td><input type="text" name="fevrow[' + mm +
                    '][bagweight]" placeholder="Bag Weight" id="bagweight' + mm + '" value="' + value.BagWeight +
                    '" class="bagweight form-control" readonly/></td>' +
                    '<td><input type="text" name="fevrow[' + mm + '][totalkg]" placeholder="Total Kg" id="totalkg' +
                    mm + '" value="' + value.TotalKg +
                    '" ondblclick="recalculate(this)";  class="totalkg form-control" readonly/></td>' +
                    '<td><input type="text" name="fevrow[' + mm + '][netkg]" placeholder="Net KG" id="netkg' + mm +
                    '" value="' + value.NetKg + '" class="netkg form-control" readonly/></td>' +
                    '<td><input type="text" name="fevrow[' + mm + '][ton]" placeholder="TON" id="netkg' + mm +
                    '" value="' + ton + '" class="ton form-control" readonly/></td>' +
                    '<td><input type="text" name="fevrow[' + mm +
                    '][feresula]" placeholder="feresula" id="feresula' + mm + '" value="' + value.Feresula +
                    '" class="directferesula form-control" readonly/></td>' +
                    '<td><input type="text" name="fevrow[' + mm + '][price]" placeholder="Price" id="price' + mm +
                    '" value="' + value.Price +
                    '" class="price form-control" onkeyup="directCalculateTotal(this)" onkeypress="return ValidateNum(event);" ondblclick="discountActive(this)"; readonly/></td>' +
                    '<td><input type="text" name="fevrow[' + mm + '][total]" placeholder="Total Price" id="total' +
                    mm + '" value="' + value.TotalPrice + '" class="total form-control" readonly/></td>' +
                    '<td style="width:3%;text-align:center;background-color:#efefef;"><a type="button"><i class="fa fa-info-circle text-primary info-icon viewcommodityinfo" title="Price Information" style="cursor: pointer;"></i></a></td>' +
                    '<td style="display:none;"><input type="hidden" name="fevrow[' + mm +
                    '][vals]" id="directvals' + mm +
                    '" class="directvals form-control" readonly="true" style="font-weight:bold;" value="' + mm +
                    '"/></td>' +
                    '<td style="display:none;"><input type="hidden" name="fevrow[' + mm + '][grnid]" id="grnid' +
                    mm + '" class="grnid form-control" readonly="true" style="font-weight:bold;" value="' + value
                    .recid + '"/></td>' +
                    '<td style="display:none;"><input type="text" name="fevrow[' + mm +
                    '][grnidetailid]" id="grnidetailid' + mm +
                    '" class="grnidetailid form-control" readonly="true" style="font-weight:bold;" value="' + value
                    .recidetid + '"/></td>' +
                    '<td style="display:none;"><input type="text" name="fevrow[' + mm +
                    '][pivdetailid]" id="pivdetailid' + mm +
                    '" class="pivdetailid form-control" readonly="true" style="font-weight:bold;" value="' + piid +
                    '"/></td>' +
                    '<td style="display:none;"><input type="hidden" name="fevrow[' + mm + '][pdetid]" id="pdetid' +
                    mm + '"  class="pdetid form-control" readonly="true" style="font-weight:bold;"/></td>' +
                    '</tr>';
                $("#directdynamicTablecommdity > tbody").append(tables);
                var itemoptionsselected = '<option selected value="' + value.CommodityId + '">' + value.Origin +
                    '</option>';
                var cropyearselected = '<option selected value="' + value.CropYear + '">' + value.CropYear +
                    '</option>';
                var proccesstypeselected = '<option selected value="' + value.ProcessType + '">' + value
                    .ProcessType + '</option>';
                var uomselected = '<option selected value="' + value.uomid + '" title="' + value.amount + '">' +
                    value.uomname + '</option>';
                var gardeselected = '<option selected value="' + value.Grade + '">' + value.Grade + '</option>';

                $('#itemNameSl' + mm).append(itemoptionsselected);
                $('#itemNameSl' + mm).select2();

                $('#cropyear' + mm).append(cropyearselected);
                $('#cropyear' + mm).select2();

                $('#directgrade' + mm).append(gardeselected);
                $('#directgrade' + mm).select2();

                $('#coffeproccesstype' + mm).append(proccesstypeselected);
                $('#coffeproccesstype' + mm).select2();

                // $('#uom'+mm).append(uomoption);
                // $("#uom"+mm+" option[value='"+value.uomid+"']").remove();
                $('#uom' + mm).append(uomselected);
                $('#uom' + mm).select2();
                $('#uom' + mm).select2({
                    placeholder: "Select uom"
                });

            });

            $('#directdynamicTablecommdity').show();
            var count = $("#directdynamicTablecommdity > tbody tr").length;
            $('#directnumberofItemsLbl').html(count);
            let $targetTd = $('#directdynamicTablecommdity td.tdcolspan');
            switch (type) {
                case 'pi':
                    $targetTd.attr('colspan', 6);
                    $('.pivclass').show();
                    break;

                default:
                    $targetTd.attr('colspan', 5);
                    $('.pivclass').hide();
                    break;
            }
            directCalculateGrandTotal();
        }

        function recalculate(ele) {
            var idval = $(ele).closest('tr').find('.directvals').val();
            var inputid = ele.getAttribute('id');
            switch (inputid) {
                case 'totalkg' + idval:
                    console.log('logic1');
                    $(ele).closest('tr').find('.totalkg').prop("readonly", false);
                    var bagweieght = $(ele).closest('tr').find('.bagweight ').val() || 0;
                    var totalkeg = $(ele).closest('tr').find('.totalkg').val() || 0;
                    var price = $(ele).closest('tr').find('.price').val() || 0;
                    var netkg = parseFloat(totalkeg) - parseFloat(bagweieght);
                    netkg = Number(netkg.toFixed(2));
                    var feresula = parseFloat(netkg) / 17;
                    feresula = Number(feresula.toFixed(2));
                    var ton = parseFloat(netkg) / 1000;
                    ton = Number(ton.toFixed(2));
                    var totalprice = parseFloat(price) * parseFloat(feresula);
                    totalprice = Number(totalprice.toFixed(2));
                    $(ele).closest('tr').find('.netkg').val(netkg);
                    $(ele).closest('tr').find('.directferesula').val(feresula);
                    $(ele).closest('tr').find('.ton').val(ton);
                    $(ele).closest('tr').find('.total').val(totalprice);
                    directCalculateGrandTotal();
                    break;

                default:
                    console.log('logic2');
                    break;
            }

        }

        function discountActive(ele) {
            var priceupdatepermission = $('#priceupdatepermission').val();
            // switch (priceupdatepermission) {
            //     case '1':
            //         $(ele).closest('tr').find('.price ').prop("readonly", false);
            //         break;

            //     default:
            //         toastrMessage('error','Access Denied','Error');
            //         break;
            // }

        }

        function directCalculateTotal(ele) {
            var idval = $(ele).closest('tr').find('.directvals').val();
            var feresula = $(ele).closest('tr').find('.directferesula').val() || 0;
            var prcie = $(ele).closest('tr').find('.price').val() || 0;

            var total = (parseFloat(feresula) * parseFloat(prcie)).toFixed(2);
            $(ele).closest('tr').find('.total').val(total);

            directCalculateGrandTotal();
        }

        function viewrecievinginformation(recordId) {
            //var recordId = $(this).data('id');
            //var statusval = $(this).data('status');
            $('#receivinginfomodaltitle').html("Receiving Information");
            $("#statusid").val(recordId);
            $("#recieverecordIds").val(recordId);
            $('.datatableinfocls').hide();
            $('.recpropbtn').hide();
            var visibilitymode = false;
            var lidata = "";

            $.ajax({
                url: '/showRecDataRec' + '/' + recordId,
                type: 'GET',
                beforeSend: function() {
                    cardSection.block({
                        message: '<div class="d-flex justify-content-center align-items-center"><p class="mr-50 mb-50">Loading Please Wait...</p><div class="spinner-grow spinner-grow-sm text-white" role="status"></div> </div>',
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
                complete: function() {
                    cardSection.block({
                        message: '',
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
                        $('#remarkLbl').text(value.Memo);

                        $("#statusIds").val(value.Status);
                        var statusvals = value.Status;
                        var statusvalsold = value.StatusOld;
                        if (parseInt(value.CompanyType) == 1) {
                            $("#customerOwnerRec").hide();
                        } else if (parseInt(value.CompanyType) == 2) {
                            $("#customerOwnerRec").show();
                        }

                        if (value.ProductType == "Commodity") {
                            $("#commoditySrcRow").show();
                            $("#commodityTypeRow").show();
                            $("#infoCommDatatable").show();
                        } else if (value.ProductType == "Goods") {
                            $("#commoditySrcRow").hide();
                            $("#commodityTypeRow").hide();
                            $("#infoGoodsDatatable").show();
                        }

                        if (parseInt(value.InvoiceStatus) == 0) {
                            $("#invoiceStatusLbl").html("Waiting");
                        } else if (parseInt(value.InvoiceStatus) == 1) {
                            $("#invoiceStatusLbl").html("Received");
                        }

                        if (statusvals === "Draft") {
                            $("#changetopending").show();
                            $("#statustitles").html(
                                "<span style='color:#A8AAAE;font-weight:bold;text-shadow;1px 1px 10px #A8AAAE;font-size:16px;'>" +
                                statusvals + "</span>");
                        } else if (statusvals === "Pending") {
                            $("#backtodraft").show();
                            $("#checkreceiving").show();
                            $("#statustitles").html(
                                "<span style='color:#f6c23e;font-weight:bold;text-shadow;1px 1px 10px #f6c23e;font-size:16px;'>" +
                                statusvals + "</span>");
                        } else if (statusvals === "Verified") {
                            $("#confirmreceiving").show();
                            $("#backtopending").show();
                            $("#statustitles").html(
                                "<span style='color:#7367F0;font-weight:bold;text-shadow;1px 1px 10px #7367F0;font-size:16px;'>" +
                                statusvals + "</span>");
                        } else if (statusvals === "Confirmed" || statusvals === "Received") {
                            $("#changetopending").hide();
                            $("#checkadjustment").hide();
                            $("#confirmadjustment").hide();
                            $("#statustitles").html(
                                "<span style='color:#1cc88a;font-weight:bold;text-shadow;1px 1px 10px #1cc88a;font-size:16px;'>" +
                                statusvals + "</span>");
                        } else {
                            $("#changetopending").hide();
                            $("#checkadjustment").hide();
                            $("#confirmadjustment").hide();
                            $("#statustitles").html(
                                "<span style='color:#e74a3b;font-weight:bold;text-shadow;1px 1px 10px #e74a3b;font-size:16px;'>" +
                                statusvals + "(" + statusvalsold + ")</span>");
                        }

                    });

                    $.each(data.activitydata, function(key, value) {
                        var classes = "";
                        var reasonbody = "";
                        if (value.action == "Edited" || value.action == "Change to Pending" || value
                            .action == "Back to Pending") {
                            classes = "warning";
                        } else if (value.action == "Verified" || value.action == "Change to Counting") {
                            classes = "primary";
                        } else if (value.action == "Created" || value.action == "Back to Draft" || value
                            .action == "Undo Void") {
                            classes = "secondary";
                        } else if (value.action == "Confirmed" || value.action == "Received") {
                            classes = "success";
                        } else if (value.action == "Void") {
                            classes = "danger";
                        }

                        if (value.reason != null && value.reason != "") {
                            reasonbody = '</br><span class="text-muted"><b>Reason:</b> ' + value
                                .reason + '</span>';
                        } else {
                            reasonbody = "";
                        }
                        lidata +=
                            '<li class="timeline-item"><span class="timeline-point timeline-point-' +
                            classes +
                            ' timeline-point-indicator"></span><div class="timeline-header mb-sm-0 mb-0"><h6 class="mb-0">' +
                            value.action +
                            '</h6><span class="text-muted"><i class="fa-regular fa-user"></i> ' + value
                            .FullName + '</span>' + reasonbody +
                            '</br><span class="text-muted"><i class="fa-regular fa-clock"></i> ' + value
                            .time + '</span></div></li>';
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
                        data: 'DT_RowIndex'
                    },
                    {
                        data: 'ItemCode',
                        name: 'ItemCode',
                        width: '10%',
                    },
                    {
                        data: 'ItemName',
                        name: 'ItemName',
                        width: '20%',
                        "render": function(data, type, row, meta) {
                            if (row.RequireSerialNumber == "Not-Require" && row.RequireExpireDate ==
                                "Not-Require") {
                                return '<div>' + data + '</div>'
                            } else {
                                return '<div><u>' + data +
                                    '</u><br/><table><tr><td>Batch#</td><td>Serial#</td><td>ExpiredDate</td><td>ManfacDate</td></tr><tr><td>' +
                                    row.BatchNumber + '</td><td>' + row.SerialNumber + '</td><td>' + row
                                    .ExpireDate + '</td><td>' + row.ManufactureDate +
                                    '</td></tr></table></div>'
                            }
                        }
                    },
                    {
                        data: 'SKUNumber',
                        name: 'SKUNumber',
                        width: '17%',
                    },
                    {
                        data: 'UOM',
                        name: 'UOM',
                        width: '5%',
                    },
                    {
                        data: 'Quantity',
                        name: 'Quantity',
                        width: '7%',
                        render: $.fn.dataTable.render.number(',', '.', 0, '')
                    },
                    {
                        data: 'UnitCost',
                        name: 'UnitCost',
                        width: '10%',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'BeforeTaxCost',
                        name: 'BeforeTaxCost',
                        width: '10%',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'TaxAmount',
                        name: 'TaxAmount',
                        width: '10%',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'TotalCost',
                        name: 'TotalCost',
                        width: '10%',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'BatchNumber',
                        name: 'BatchNumber',
                        'visible': false
                    },
                    {
                        data: 'SerialNumber',
                        name: 'SerialNumber',
                        'visible': false
                    },
                    {
                        data: 'ExpireDate',
                        name: 'ExpireDate',
                        'visible': false
                    },
                    {
                        data: 'ManufactureDate',
                        name: 'ManufactureDate',
                        'visible': false
                    },
                    {
                        data: 'RequireSerialNumber',
                        name: 'RequireSerialNumber',
                        'visible': false
                    },
                    {
                        data: 'RequireExpireDate',
                        name: 'RequireExpireDate',
                        'visible': false
                    },
                ],
                "columnDefs": [{
                    "targets": [8, 9],
                    "visible": visibilitymode,
                }, ]
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
                columns: [{
                        data: 'DT_RowIndex',
                        width: "2%"
                    },
                    {
                        data: 'LocationName',
                        name: 'LocationName',
                        width: "6%"
                    },
                    {
                        data: 'CommType',
                        name: 'CommType',
                        width: "6%"
                    },
                    {
                        data: 'Origin',
                        name: 'Origin',
                        width: "8%"
                    },
                    {
                        data: 'GradeName',
                        name: 'GradeName',
                        width: "6%"
                    },
                    {
                        data: 'ProcessType',
                        name: 'ProcessType',
                        width: "6%"
                    },
                    {
                        data: 'CropYearData',
                        name: 'CropYearData',
                        width: "6%"
                    },
                    {
                        data: 'UomName',
                        name: 'UomName',
                        width: "6%"
                    },
                    {
                        data: 'NumOfBag',
                        name: 'NumOfBag',
                        render: $.fn.dataTable.render.number(',', '.', 0, ''),
                        width: "6%"
                    },
                    {
                        data: 'BagWeight',
                        name: 'BagWeight',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width: "6%"
                    },
                    {
                        data: 'TotalKg',
                        name: 'TotalKg',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width: "6%"
                    },
                    {
                        data: 'NetKg',
                        name: 'NetKg',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width: "6%"
                    },
                    {
                        data: 'Feresula',
                        name: 'Feresula',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width: "6%"
                    },
                    {
                        data: 'WeightByTon',
                        name: 'WeightByTon',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width: "6%"
                    },
                    {
                        data: 'VarianceShortage',
                        name: 'VarianceShortage',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width: "6%"
                    },
                    {
                        data: 'VarianceOverage',
                        name: 'VarianceOverage',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width: "6%"
                    },
                    {
                        data: 'Remark',
                        name: 'Remark',
                        width: "6%"
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
                "footerCallback": function(row, data, start, end, display) {
                    var api = this.api(),
                        data;
                    // Remove the formatting to get integer data for summation
                    var intVal = function(i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                            i : 0;
                    };

                    var totalbagvar = api
                        .column(8)
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    var totalbagweight = api
                        .column(9)
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    var totalgrosskg = api
                        .column(10)
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    var totalkgvar = api
                        .column(11)
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    var totalferesulavar = api
                        .column(12)
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    var totaltonvar = api
                        .column(13)
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    var totalvarianceshr = api
                        .column(14)
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    var totalvarianceov = api
                        .column(15)
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    $('#totalbag').html(totalbagvar === 0 ? '' : numformat(totalbagvar));
                    $('#totalbagweight').html(totalbagweight === 0 ? '' : numformat(totalbagweight.toFixed(2)));
                    $('#totalgrosskg').html(totalgrosskg === 0 ? '' : numformat(totalgrosskg.toFixed(2)));
                    $('#totalkg').html(totalkgvar === 0 ? '' : numformat(totalkgvar.toFixed(2)));
                    $('#totalton').html(totaltonvar === 0 ? '' : numformat(totaltonvar.toFixed(2)));
                    $('#totalferesula').html(totalferesulavar === 0 ? '' : numformat(totalferesulavar.toFixed(
                        2)));
                    $('#totalvarshortage').html(totalvarianceshr === 0 ? '' : numformat(totalvarianceshr
                        .toFixed(2)));
                    $('#totalvarovrage').html(totalvarianceov === 0 ? '' : numformat(totalvarianceov.toFixed(
                        2)));
                },
            });

            $("#recievingdocInfoModal").modal('show');
            $(".infoscl").collapse('show');
            $("#docRecInfoItem").show();
            $("#infoRecDiv").show();
            $("#docInfoItem").hide();
            $("#infoHoldDiv").hide();
            //var oTable = $('#docRecInfoItem').dataTable();
            //oTable.fnDraw(false);
            //$('#laravel-datatable-crud').DataTable().ajax.reload();
        }
        $('#poprintbutton').click(function() {
            var id = $('#porecordIds').val();
            var link = "/directpoattachemnt/" + id;
            window.open(link, 'Purchase Order', 'width=1200,height=800,scrollbars=yes');
        });
        $('#recievingprintbutton').click(function() {
            var id = $('#recieverecordIds').val();
            var link = "/grvComm/" + id;
            window.open(link, 'Purchase Order', 'width=1200,height=800,scrollbars=yes');
        });

        function viewpoinformation(recordId) {
            var status = '';
            var type = '';
            var purchaseordertype = '';
            var poid = '';
            var pono = '';
            var peno = '';
            var peid = '';
            $.ajax({
                type: "GET",
                url: "{{ url('poinfo') }}/" + recordId,
                beforeSend: function() {
                    cardSection.block({
                        message: '<div class="d-flex justify-content-center align-items-center"><p class="mr-50 mb-50">Loading Please Wait...</p><div class="spinner-grow spinner-grow-sm text-white" role="status"></div> </div>',
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
                complete: function() {
                    cardSection.block({
                        message: '',
                        timeout: 1,
                        css: {
                            backgroundColor: '',
                            color: '',
                            border: ''
                        },
                    });
                    $("#collapseOne").collapse('show');
                    $('#purchaseorderdocInfoModal').modal('show');
                },
                success: function(response) {
                    peno = response.pedocno;

                    $('#infodocumentdate').html(response.createdAtInAddisAbaba);
                    $.each(response.po, function(index, value) {
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

                        status = value.status;
                        type = value.type;
                        purchaseordertype = value.purchaseordertype;
                        poid = value.id;
                        pono = value.porderno;
                        peid = value.purchasevaulation_id;
                        switch (value.istaxable) {
                            case 1:
                                $('#pyrinfosupplierinfotaxtr').show();
                                $('#pyrinfosupplierinforandtotaltr').show();
                                break;
                            default:
                                $('#pyrinfosupplierinfotaxtr').hide();
                                $('#pyrinfosupplierinforandtotaltr').hide();
                                break;
                        }
                        if (parseFloat(value.subtotal) >= 10000) {
                            $('#pyrinfovisibleinfowitholdingTr').show();
                            $('#pyrinfodirectinfonetpayTr').show();
                        } else {
                            $('#pyrinfovisibleinfowitholdingTr').hide();
                            $('#pyrinfodirectinfonetpayTr').hide();
                        }
                    });
                    $.each(response.customer, function(index, value) {
                        $('#infosuppid').html(value.Code);
                        $('#infsupname').html(value.Name);
                        $('#infosupptin').html(value.TinNumber);
                    });

                    switch (type) {
                        case 'Direct':
                        case 'PE':
                            peno = (peno === undefined || peno === null || peno === '' || peno === '--') ?
                                'EMPTY' : peno;
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
                                            links = '<a href="#" onclick="viewpeinformation(' + peid +
                                                ');"><u>' + peno + '</u></a>';
                                            break;

                                        default:
                                            links = peno;
                                            break;
                                    }

                                    $('#infope').html(links);;
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
                                    var tables = 'comuditydocInfoItem';
                                    directcommoditylist(poid);
                                    break;
                            }
                            $('#directcommuditylistdatabledivinfo').hide();
                            break;
                    }

                    posetminilog(response.actions);
                }
            });
        }
        
        function directgoodlist(id) {
            const tableId = '#directgoodsinfodatatablesonpaymentrequessta';
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
                language: {
                    search: '',
                    searchPlaceholder: "Search here"
                },
                dom: "<'row'<'col-lg-5 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-5'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
                ajax: {
                    url: `{{ url('directgoodlist') }}/${id}`,
                    type: 'GET',
                    beforeSend: () => blockUI(cardSection, 'Loading Please Wait...'),
                    complete: () => unblockUI(cardSection),
                },
                columns: [{
                        data: 'DT_RowIndex'
                    },
                    {
                        data: 'Code',
                        name: 'Code'
                    },
                    {
                        data: 'Name',
                        name: 'Name'
                    },
                    {
                        data: 'SKUNumber',
                        name: 'SKUNumber'
                    },
                    {
                        data: 'uomname',
                        name: 'uomname'
                    },
                    {
                        data: 'qty',
                        name: 'qty',
                        render: renderNumber
                    },
                    {
                        data: 'price',
                        name: 'price',
                        render: renderNumber
                    },
                    {
                        data: 'Total',
                        name: 'Total',
                        render: renderNumber
                    },
                    {
                        data: 'goodid',
                        name: 'goodid'
                    },
                ],
                columnDefs: [{
                    targets: 8,
                    render: function(data, type, row, meta) {
                        return `
                            <i class="fa fa-info-circle text-primary goodsinfo" 
                            data-itemid="${data}" 
                            title="Item Information">
                            </i>
                        `;
                    }
                }, ],
                initComplete: function(settings, json) {
                    const totalRows = suptables.rows().count();
                    $('#directinfonumberofItemsLblpyr').html(totalRows);
                },
                footerCallback: function(row, data, start, end, display) {
                    const api = this.api();
                    const intVal = (i) => typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i ===
                        'number' ? i : 0;
                    const qty = api.column(5).data().reduce((a, b) => intVal(a) + intVal(b), 0);
                    const unitprice = api.column(6).data().reduce((a, b) => intVal(a) + intVal(b), 0);
                    const total = api.column(7).data().reduce((a, b) => intVal(a) + intVal(b), 0);
                    $('#infoqtytotal').html(formatFooterValue(qty));
                    $('#infounitpreicetotal').html(formatFooterValue(unitprice));
                    $('#infototal').html(formatFooterValue(total));
                },
            });
        }

        // Helper function to format footer values
        function formatFooterValue(value) {
            const renderNumber = $.fn.dataTable.render.number(',', '.', 2, '').display;
            return `<h6 style="font-size:13px;color:black;font-weight:bold;">${renderNumber(value)}</h6>`;
        }
        $(document).on('click', '.viewiteminfo, .goodsinfo', function() {
            const $icon = $(this);
            const itemId = $icon.hasClass('viewiteminfo') ?
                $icon.closest('tr').find('.eName').val() || 0 :
                $icon.data('itemid');
            const store = $icon.hasClass('viewiteminfo') ?
                $('#directwarehouse').val() || 0 :
                $('#storehidden').val() || 0;

            blockUI(cardSection, 'Loading Please Wait...');

            $.ajax({
                type: "GET",
                url: `{{ url('getgoodstorebalance') }}/${itemId}/${store}`,
                dataType: "json",
                complete: () => unblockUI(cardSection),
                success: function(response) {
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
                error: function(xhr, status, error) {
                    console.error('Error fetching item details:', error);
                    toastrMessage('error', 'Failed to fetch item details. Please try again. ' + error,
                        'Error!');
                }
            });
        });

        // Hide popover when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.viewiteminfo, .goodsinfo').length) {
                $('.viewiteminfo, .goodsinfo').popover('hide');
            }
        });
        function posetminilog(actions) {
            var list = '';
            var icons = ''
            var reason = '';
            var addedclass = '';
            $('#ulist').empty();
            $.each(actions, function(index, value) {
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
                list += '<li class="timeline-item"><span class="timeline-point timeline-point-' + icons +
                    ' timeline-point-indicator"></span><div class="timeline-header mb-sm-0 mb-0"><h6 class="mb-0 ' +
                    addedclass + '">' + value.action +
                    '</h6><span class="text-muted"><i class="fa-regular fa-user"></i>' + value.user +
                    '</span></br><span class="text-muted"><i class="fa-regular fa-clock"></i> ' + value.time +
                    '</span>' + reason + '</div></li>';
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
                order: [
                    [0, "desc"]
                ],
                language: {
                    search: '',
                    searchPlaceholder: "Search here"
                },
                "dom": "<'row'<'col-lg-5 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-5'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
                ajax: {
                    url: "{{ url('directcommoditylist') }}/" + id,
                    type: 'GET',
                },
                columns: [{
                        data: 'DT_RowIndex'
                    },
                    {
                        data: 'origin',
                        name: 'origin'
                    },
                    {
                        data: 'grade',
                        name: 'grade'
                    },
                    {
                        data: 'proccesstype',
                        name: 'proccesstype'
                    },
                    {
                        data: 'cropyear',
                        name: 'cropyear'
                    },
                    {
                        data: 'uomname',
                        name: 'uomname'
                    },
                    {
                        data: 'qty',
                        name: 'qty',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'bagweight',
                        name: 'bagweight',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'totalKg',
                        name: 'totalKg',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'netkg',
                        name: 'netkg',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'ton',
                        name: 'ton',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'feresula',
                        name: 'feresula',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'price',
                        name: 'price',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'Total',
                        name: 'Total',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'grade',
                        name: 'grade'
                    },
                ],
                columnDefs: [{
                    targets: 14,
                    render: function(data, type, row, meta) {
                        return `
                                            <i class="info-icon fa fa-info-circle text-primary" 
                                            data-netkg="${row.netkg}" 
                                            data-totalprice="${row.Total}" 
                                            title="Price Information">
                                            </i>
                                        `;
                    }
                }, ],
                "initComplete": function(settings, json) {
                    var totalRows = suptables.rows().count();
                    $('#podirectinfonumberofItemsLbl').html(totalRows);
                },
                "footerCallback": function(row, data, start, end, display) {

                    var api = this.api();
                    // Helper function to parse integer from strings
                    var intVal = function(i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 : // Remove commas and convert to int
                            typeof i === 'number' ?
                            i : 0;
                    };
                    var totalbag = api
                        .column(6) // The column index where the numeric data is
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                    var totalbagweiht = api
                        .column(7) // The column index where the numeric data is
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                    var totalkg = api
                        .column(8) // The column index where the numeric data is
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                    var totalnet = api
                        .column(9) // The column index where the numeric data is
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                    var totalton = api
                        .column(10) // The column index where the numeric data is
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                    var totalferesula = api
                        .column(11) // The column index where the numeric data is
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                    var totalprice = api
                        .column(12) // The column index where the numeric data is
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                    var totaltotal = api
                        .column(13) // The column index where the numeric data is
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                    var numberendering = $.fn.dataTable.render.number(',', '.', 2, ).display;
                    $('#ponfonofbagtotal').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>" +
                        numberendering(totalbag) + "</h6>");
                    $('#ponfonofbagweighttotal').html(
                        "<h6 style='font-size:13px;color:black;font-weight:bold;'>" + numberendering(
                            totalbagweiht) + "</h6>");
                    $('#ponfonoftotalkgtotal').html(
                        "<h6 style='font-size:13px;color:black;font-weight:bold;'>" + numberendering(
                            totalkg) + "</h6>");
                    $('#ponfokgtotal').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>" +
                        numberendering(totalnet) + "</h6>");
                    $('#ponfotontotal').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>" +
                        numberendering(totalton) + "</h6>");
                    $('#ponfopriceferesula').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>" +
                        numberendering(totalferesula) + "</h6>");
                    $('#ponfopricetotal').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>" +
                        numberendering(totalprice) + "</h6>");
                    $('#ponfototalpricetotal').html(
                        "<h6 style='font-size:13px;color:black;font-weight:bold;'>" + numberendering(
                            totaltotal) + "</h6>");
                }
            });
        }

        function viewpeinformation(id) {
            var prstatus = 0;
            var peid = 0;
            var documentumber = '';
            var status = '';
            var petype = '';
            $.ajax({
                type: "GET",
                url: "{{ url('peinfo') }}/" + id,
                beforeSend: function() {
                    cardSection.block({
                        message: '<div class="d-flex justify-content-center align-items-center"><p class="mr-50 mb-50">Loading Please Wait...</p><div class="spinner-grow spinner-grow-sm text-white" role="status"></div> </div>',
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
                complete: function() {
                    cardSection.block({
                        message: '',
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
                success: function(response) {
                    $('#peinfostation').html(response.storename);
                    $.each(response.pr, function(indexInArray, valueOfElement) {
                        peid = valueOfElement.id;
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
                        $('#peinfoStatus').html('<span class="text-success font-weight-medium"><b> ' +
                            valueOfElement.documentumber + ' Approved </b>');
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
                        prstatus = valueOfElement.status;
                        switch (valueOfElement.petype) {
                            case 'Direct':
                                $('#preditbutton').hide();
                                $('#trinforfq').hide();
                                setrequesteditemlabel(valueOfElement.id, valueOfElement.type,
                                    valueOfElement.petype);
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
                                var tables = '#perequesteditemdatatablesoninfo';
                                getrequesteditem(tables, valueOfElement.id, valueOfElement.type,
                                    valueOfElement.petype);
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
                        documentumber = valueOfElement.documentumber;
                        status = valueOfElement.status;
                        petype = valueOfElement.petype;
                    });
                    $('#inforfq').html(response.rfq);
                    if (response.supplier.length === 0) {
                        initationcommuditylist(peid);
                    } else {
                        setsupplierbytab(response.supplier, prstatus);
                        showdataonthestatus(prstatus);
                    }
                    pesetminilog(response.actions);
                }
            });
        }

        function setrequesteditemlabel(peid, type, reference) {
            var tables = '#perequesteditemdatatablesoninfo';
            switch (reference) {
                case 'Direct':
                    switch (type) {
                        case 'Goods':
                            $('#requesteditemlabel').html('Requested item');
                            getrequesteditem(tables, peid, type, reference);
                            break;
                        default:
                            $('#requesteditemlabel').html('Requested Commodity');
                            getrequesteditem(tables, peid, type, reference);
                            break;
                    }
                    break;
                default:
                    switch (type) {
                        case 'Goods':
                            $('#requesteditemlabel').html('Requested item');
                            getrequesteditem(tables, peid, type, reference);
                            break;
                        default:
                            $('#requesteditemlabel').html('Requested Commodity');
                            getrequesteditem(tables, peid, type, reference);
                            break;
                    }
                    break;
            }
        }

        function getrequesteditem(tables, peid, type, reference) {
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
                    setableslabel(type, reference);
                    break;
                default:
                    setableslabel(type, reference);
                    break;
            }
            $(tables).DataTable({
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
                order: [
                    [0, "desc"]
                ],
                language: {
                    search: '',
                    searchPlaceholder: "Search here"
                },
                "dom": "<'row'<'col-lg-6 col-md-10 col-xs-4'f><'col-lg-2 col-md-2 col-xs-8'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
                ajax: {
                    url: "{{ url('requesteditems') }}/" + peid + "/" + reference + "/" + type,
                    type: 'GET',
                },
                columns: [{
                        data: 'DT_RowIndex',
                        "width": "1%"
                    },
                    {
                        data: 'col1',
                        name: 'col1',
                        "width": "30%"
                    },
                    {
                        data: 'col2',
                        name: 'col2',
                        'width': '10%'
                    },
                    {
                        data: 'col3',
                        name: 'col3',
                        "width": "10%"
                    },
                ],
            });
        }

        function setableslabel(type, reference) {
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

        function showsupplier(peid) {
            var suptables = $('#supplierdatatables').DataTable({
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
                order: [
                    [0, "desc"]
                ],
                language: {
                    search: '',
                    searchPlaceholder: "Search here"
                },
                "dom": "<'row'<'col-lg-5 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-5'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
                ajax: {
                    url: "{{ url('showsupplierpo') }}/" + peid,
                    type: 'GET',
                },
                columns: [{
                        data: 'DT_RowIndex'
                    },
                    {
                        data: 'docno',
                        name: 'docno'
                    },
                    {
                        data: 'Name',
                        name: 'Name'
                    },
                    {
                        data: 'TinNumber',
                        name: 'TinNumber'
                    },
                    {
                        data: 'orderdate',
                        name: 'orderdate'
                    },
                    {
                        data: 'deliverydate',
                        name: 'deliverydate'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'id',
                        name: 'id',
                        width: '3%'
                    },
                ],
                columnDefs: [{
                    targets: 6,
                    render: function(data, type, row, meta) {
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
                }, {
                    targets: 7,
                    render: function(data, type, row, meta) {
                        var anchor =
                            '<a class="enVoiceinformation" href="javascript:void(0)" data-id=' + data +
                            ' data-name="' + row.Name +
                            '" title="Initate order"><i class="fa-sharp fa-regular fa-circle-info fa-xl" style="color: #00cfe8;"></i></a>';
                        return anchor;
                    }
                }],

            });

        }

        function setsupplierbytab(supplier) {
            var carddata = '';
            var backcolor = "";
            var forecolor = "";
            var status = '';
            var jj = 0;
            var stitles = '';
            var firstsupplierid = 0;
            var sumbitdate = '';
            var supplycode = '';
            var sec = 0;
            $.each(supplier, function(index, value) {
                ++jj;
                switch (index) {
                    case 0:
                        pefetchorders(value.id, 1);
                        firstsupplierid = value.id;
                        break;

                    default:
                        break;
                }
                stitles = "Name:" + value.Name + " " + value.TinNumber;
                supplycode = "Code:" + value.pecode;
                sumbitdate = "Submit Date:" + value.recievedate;
                carddata += "<div id='commcard" + value.id + "' class='card supcard commcardcls" + value.id +
                    "' data-title='" + stitles +
                    "' style='margin-top:-1.75rem;border:0.5px solid #FFFFFF' onclick='fetchorders(" + value.id +
                    "," + sec +
                    ")'><div class='card-header' style='margin-top:-1rem;margin-left:-1rem;margin-right:-1rem'><span class='badge badge-center rounded-pill bg-secondary'>" +
                    jj + "</span> <span><b>" + supplycode + "</b></span><div id='targetspandiv" + value.id +
                    "'><span style='background-color:" + backcolor + ";color:" + forecolor +
                    ";padding:3px 5px;font-size:11px;'><b>" + status +
                    "</b></span></div></div><div class='card-body pb-0' style='margin-top:-1.2rem'><div class='row mt-0'><div class='col-xl-12 col-md-12 col-lg-12 p-0'><b>@can('Supplier-View')" +
                    stitles +
                    "@endcan</b></div><div class='col-xl-12 col-md-12 col-lg-12 p-0'><b>@can('Supplier-View')" +
                    sumbitdate +
                    "@endcan</b></div></div></div></div>";
            });
            $('#pecarddatacanvas').empty();
            $('#pecarddatacanvas').html(carddata);
            $('.commcardcls' + firstsupplierid).addClass('supplierselected');
        }

        function pefetchorders(id, isfirst) {
            console.log('suplier id=' + id);
            var headerid = $('#perecordIds').val();
            $('#peevalsupplierid').val(id);
            $('.supcard').removeClass('supplierselected');
            $('.commcardcls' + id).addClass('supplierselected');
            switch (isfirst) {
                case 1:
                    commuditylist(headerid, id);
                    break;
                default:
                    var activeTab = $("#infoapptabs .nav-item .active").attr("href");
                    switch (activeTab) {
                        case '#initationview':
                            commuditylist(headerid, id);
                            break;
                        case '#technicalview':
                            commuditylistoftechnicalview(headerid, id);
                            break;
                        default:
                            commuditylistoffinancialview(headerid, id);
                            break;
                    }
                    break;
            }
        }

        function commuditylist(headerid, id) {

            $('#initiationcomuditydocInfoItemdiv').hide();
            $('#comuditydocInfoItemdiv').show();
            $("#supllierlistdiv").show();
            var status = $('#peevelautestatus').val();
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
            var title = '---';
            var comudtable = $('#pecomuditydocInfoItem').DataTable({
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
                order: [
                    [0, "desc"]
                ],
                language: {
                    search: '',
                    searchPlaceholder: "Search here"
                },
                "dom": "<'row'<'col-lg-2 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
                ajax: {
                    url: "{{ url('getpebysupplier') }}/" + headerid + '/' + id,
                    type: 'GET',
                },
                columns: [{
                        data: 'DT_RowIndex',
                        "width": "1%"
                    },
                    {
                        data: 'customername',
                        name: 'customername',
                        'visible': false
                    },
                    {
                        data: 'requestedorigin',
                        name: 'requestedorigin',
                        width: '20%'
                    },
                    {
                        data: 'supplyorigin',
                        name: 'supplyorigin',
                        width: '20%'
                    },
                    {
                        data: 'cropyear',
                        name: 'cropyear',
                        width: '10%'
                    },
                    {
                        data: 'proccesstype',
                        name: 'proccesstype',
                        width: '10%'
                    },
                    {
                        data: 'sampleamount',
                        name: 'sampleamount',
                        width: '5%'
                    },
                    {
                        data: 'remark',
                        name: 'remark'
                    },

                ],
                columnDefs: [{
                        targets: 6,
                        render: function(data, type, row, meta) {
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
                        render: function(data, type, row, meta) {
                            var remark = (data === undefined || data === null || data === '') ? 'EMPTY' :
                                data;
                            switch (remark) {
                                case 'EMPTY':
                                    return '';
                                    break;

                                default:
                                    switch (type) {
                                        case 'display':
                                            return data.length > 40 ? '<div class="text-ellipsis" title="' +
                                                data + '">' + data.substr(0, 50) + '…</div>' : data;
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

        function showdataonthestatus(status) {
            var headerid = $('#perecordIds').val();
            var id = $('#peevalsupplierid').val();
            $('#peevalstatus').val(status);

            var technicalpermit = $('#technicalviewpermission').val();
            var financalpremit = $('#financialviewpermission').val();
            var feprogresspermit = $('#financialprogresspermission').val();

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

                            commuditylistoftechnicalview(headerid, id);
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

                            commuditylistoffinancialview(headerid, id);
                            break;

                        default:
                            break;
                    }

                    break;
                default:
                    break;
            }
        }

        function pesetminilog(actions) {
            var list = '';
            var icons = ''
            var reason = '';
            var addedclass = '';
            $('#peulist').empty();
            $.each(actions, function(index, value) {
                switch (value.status) {
                    case 'Pending':
                        icons = 'warning timeline-point';
                        addedclass = 'text-warning';
                        switch (value.action) {
                            case 'Back to pending':
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
                    case 'Approved':
                        icons = 'success timeline-point';
                        addedclass = 'text-success';
                        break;
                    case 'Confirm':
                        icons = 'success timeline-point';
                        addedclass = 'text-success';
                        break;
                    case 'Change To TE':
                        icons = 'primary timeline-point';
                        addedclass = 'text-primary';
                        break;
                    case 'Change To FE':
                        icons = 'warning timeline-point';
                        addedclass = 'text-warning';
                        break;
                    case 'Back To FE':
                        icons = 'warning timeline-point';
                        addedclass = 'text-warning';
                        reason = '<p class="text-muted"><b><u>Reason:</u></b>' + value.reason + '.</p>';
                        break;
                    case 'Back To TE':
                        icons = 'warning timeline-point';
                        addedclass = 'text-warning';
                        reason = '<p class="text-muted"><b><u>Reason:</u></b>' + value.reason + '.</p>';
                        break;
                    case 'TE Inserted':
                        icons = 'warning timeline-point';
                        addedclass = 'text-warning';
                        break;

                    case 'Edited':
                        icons = 'warning timeline-point';
                        addedclass = 'text-warning';
                        break;
                    case 'Verify':
                        icons = 'primary timeline-point';
                        addedclass = 'text-primary';
                        switch (value.action) {
                            case 'Back To Verify':
                                reason = '<p class="text-muted"><b><u>Reason:</u></b>' + value.reason + '.</p>';
                                break;

                            default:
                                reason = '';
                                break;
                        }


                        break;
                    case 'Back To TE':
                    case 'Back To FE':
                    case 'Changed To TE':
                    case 'Changed To FE':
                        icons = 'warning timeline-point';
                        addedclass = 'text-warning';
                        reason = '';
                        break;
                    case 'Approve':
                        icons = 'success timeline-point';
                        addedclass = 'text-success';
                        reason = '';
                        break;
                    case 'Authorize':
                        icons = 'success timeline-point';
                        addedclass = 'text-success';
                        reason = '';
                        break;
                    case 'Finished TE':
                    case 'Finished FE':
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
                list += '<li class="timeline-item"><span class="timeline-point timeline-point-' + icons +
                    ' timeline-point-indicator"></span><div class="timeline-header mb-sm-0 mb-0"><h6 class="mb-0 ' +
                    addedclass + '">' + value.action +
                    '</h6><span class="text-muted"><i class="fa-regular fa-user"></i>' + value.user +
                    '</span></br><span class="text-muted"><i class="fa-regular fa-clock"></i> ' + value.time +
                    '</span>' + reason + '</div></li>';
            });
            $('#peulist').append(list);
        }

        function infopelistbytab(params) {
            var headerid = $('#perecordIds').val();
            var id = $('#peevalsupplierid').val();
            var status = $('#peevalstatus').val();
            switch (params) {
                case 'peview':
                    break;
                case 'teview':
                    commuditylistoftechnicalview(headerid, id);
                    break;
                default:
                    commuditylistoffinancialview(headerid, id);
                    console.log('status=' + status);
                    break;
            }
        }

        function commuditylistoftechnicalview(headerid, id) {
            var comudtable = $('#petechnicalcomuditydocInfoItem').DataTable({
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
                order: [
                    [0, "desc"]
                ],
                language: {
                    search: '',
                    searchPlaceholder: "Search here"
                },
                "dom": "<'row'<'col-lg-2 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
                ajax: {
                    url: "{{ url('getpebysupplier') }}/" + headerid + '/' + id,
                    type: 'GET',
                },
                columns: [{
                        data: 'DT_RowIndex',
                        "width": "1%"
                    },
                    {
                        data: 'customername',
                        name: 'customername',
                        'visible': false
                    },
                    {
                        data: 'requestedorigin',
                        name: 'requestedorigin',
                        width: '20%'
                    },
                    {
                        data: 'supplyorigin',
                        name: 'supplyorigin',
                        width: '20%'
                    },
                    {
                        data: 'cropyear',
                        name: 'cropyear',
                        width: '10%'
                    },
                    {
                        data: 'proccesstype',
                        name: 'proccesstype',
                        width: '10%'
                    },
                    {
                        data: 'sampleamount',
                        name: 'sampleamount',
                        width: '10%'
                    },
                    {
                        data: 'qualitygrade',
                        name: 'qualitygrade'
                    },
                    {
                        data: 'screensieve',
                        name: 'screensieve'
                    },
                    {
                        data: 'evmoisture',
                        name: 'evmoisture'
                    },
                    {
                        data: 'evcupvalue',
                        name: 'evcupvalue'
                    },
                    {
                        data: 'rowvalue',
                        name: 'rowvalue'
                    },
                    {
                        data: 'evscore',
                        name: 'evscore'
                    },
                    {
                        data: 'evstatus',
                        name: 'evstatus'
                    },
                    {
                        data: 'tecremark',
                        name: 'tecremark',
                        width: '30%'
                    },
                ],
                columnDefs: [

                    {
                        targets: 14,
                        render: function(data, type, row, meta) {
                            var remark = (data === undefined || data === null || data === '') ? 'EMPTY' :
                                data;
                            switch (remark) {
                                case 'EMPTY':
                                    return '';
                                    break;

                                default:
                                    switch (type) {
                                        case 'display':
                                            return data.length > 40 ? '<div class="text-ellipsis" title="' +
                                                data + '">' + data.substr(0, 50) + '…</div>' : data;
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

        function commuditylistoffinancialview(headerid, id) {
            var comudtable = $('#pefinancailcomuditydocInfoItem').DataTable({
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
                order: [
                    [0, "desc"]
                ],
                language: {
                    search: '',
                    searchPlaceholder: "Search here"
                },
                "dom": "<'row'<'col-lg-2 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
                ajax: {
                    url: "{{ url('getpebysupplier') }}/" + headerid + '/' + id,
                    type: 'GET',
                },
                columns: [{
                        data: 'DT_RowIndex',
                        "width": "1%"
                    },
                    {
                        data: 'customername',
                        name: 'customername',
                        'visible': false
                    },
                    {
                        data: 'requestedorigin',
                        name: 'requestedorigin',
                        width: '10%'
                    },
                    {
                        data: 'supplyorigin',
                        name: 'supplyorigin',
                        width: '10%'
                    },

                    {
                        data: 'cropyear',
                        name: 'cropyear',
                        width: '5%'
                    },
                    {
                        data: 'proccesstype',
                        name: 'proccesstype',
                        width: '5%'
                    },
                    {
                        data: 'qualitygrade',
                        name: 'qualitygrade'
                    },
                    {
                        data: 'bagamount',
                        name: 'bagamount'
                    },
                    {
                        data: 'customerprice',
                        name: 'customerprice'
                    },
                    {
                        data: 'proposedprice',
                        name: 'proposedprice'
                    },
                    {
                        data: 'finalprice',
                        name: 'finalprice'
                    },
                    {
                        data: 'rank',
                        name: 'rank',
                        width: '2%'
                    },
                    {
                        data: 'fevremark',
                        name: 'fevremark'
                    },
                ],
                columnDefs: [{
                        targets: 11,
                        render: function(data, type, row, meta) {
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
                        render: function(data, type, row, meta) {
                            var remark = (data === undefined || data === null || data === '') ? 'EMPTY' :
                                data;
                            switch (remark) {
                                case 'EMPTY':
                                    return '';
                                    break;

                                default:
                                    switch (type) {
                                        case 'display':
                                            return data.length > 40 ? '<div class="text-ellipsis" title="' +
                                                data + '">' + data.substr(0, 50) + '…</div>' : data;
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

        $('body').on('click', '.addbutton', function() {
            setvaluestoempty();
        });
                $('#colorCheck1').click(function() {
                    if ($('#colorCheck1').is(':checked')) {
                        $('#withitems').val('With');
                    } else {
                        $('#withitems').val('Without');
                    }
                });
        function setvaluestoempty() {
            $("#exampleModalScrollable").modal('show');
            $('#exampleModalScrollableTitleadd').html('Add Payment Request');
            $('#type').select2('destroy');
            $('#type').val('').select2();
            resetselect2();
            resetSelect2Dropdowns();
            resetUI();
            foraddclearInputFields();
        }
        function foraddclearInputFields() {
            const fields = [
                '#isdataexistornot',
                '#documentnumber',
                '#isgrnexistornot',
                '#supplierhidden',
                '#date',
                '#memo',
                '#referencenohidden',
                '#payrid',
                '#amount',
                '#purpose',
                '#filepath',
                '#pdf',
                '#filename',
                '#constantpaidamount',
                '#constatntremainamount',
                '#remainamount'
            ];
            fields.forEach(field => $(field).val('')); 
            // Set date to current date
            var currentdate = $('#currentdate').val();
            // Initialize flatpickr with the desired configuration
            flatpickr('#date', {
                dateFormat: 'Y-m-d', 
                defaultDate: currentdate, 
                clickOpens: false, 
                allowInput: false 
            });
            // Set the value of the #date input field to the current date
            $('#date').val(currentdate);
            // Clear error messages
            $('.rmerror').html('');
            // Uncheck checkbox
            $('#colorCheck1').prop({ disabled: false, checked: false });
            
            $('.lbl').html('0.00');
            
            $('#directdynamicTablecommdity, #directpricetable, #commodityrow, #amountdetailsdiv, #referencenodiv, #slipdocumentlinkbtn, #directrow, .cmdtyclass, .withitemsclass').hide();
            $('#directtaxi, #directgrandtotali, #directwitholdingAmntin, #directvatAmntin, #directsubtotali, #directnetpayin').val('0.00');
            $('#directistaxable').val('0');
            $('#withitems').val('Without');
            $('#payrdirectinfosubtotalLbl, #payrdirectinfotaxLbl, #payrdirectinfograndtotalLbl, #payrdirectinfowitholdingAmntLbl, #payrdirectinfovatAmntLbl, #payrdirectinfonetpayLbl').html('');
            // Uncheck additional checkboxes
            $('#directcustomCheck1, #goodsdirectcustomCheck1').prop('checked', false);
            // Remove active class from tabs
            $('#purchaseorderview-tab, #grnview-tab, #piview-tab').removeClass('active');

            $("#savebutton")
            .find('span')
            .text("Save")
            .end() // Go back to the #savebutton element
            .find("#savedicon")
            .removeClass("fa-duotone fa-pen") // Remove unnecessary classes
            .addClass("fa-sharp fa-solid fa-floppy-disk"); // Add the desired class

        }
        $(document).ready(function() {
            // var canPYRAdd = @json(auth()->user()->can('PYR-Add')); // Pass permission check result to JavaScript
            paymentrequestlist();
        });

        function paymentrequestlist(params) {
            const canPYRAdd = @json(auth()->user()->can('PYR-Add')); // Pass permission check result to JavaScript
            pctables = $('#pcontracttables').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                fixedHeader: true,
                searchHighlight: true,
                destroy: true,
                lengthMenu: [
                    [50, 100],
                    [50, 100]
                ],
                "pagingType": "simple",
                language: {
                    search: '',
                    searchPlaceholder: "Search here"
                },
                dom: '<"row mt-75"' +
                    '<"col-lg-12 col-xl-6" f>' +
                    '<"col-lg-12 col-xl-6 pl-xl-75 pl-0"<"dt-action-buttons text-xl-right text-lg-left text-md-right text-left d-flex align-items-center justify-content-lg-end align-items-center flex-sm-nowrap flex-wrap mr-1 mt-2"<"mr-1">B>>' +
                    '>t' +
                    '<"d-flex justify-content-between mx-2 row mb-1"' +
                    '<"col-sm-12 col-md-3"i>' + '<"col-sm-12 col-md-6">' +
                    '<"col-sm-12 col-md-3"p>' +
                    '>',
                buttons: [{
                    text: '@can('PYR-Add')<i data-feather="plus"></i> Add @endcan',
                    className: '@can('PYR-Add') btn btn-gradient-info btn-sm addbutton @endcan',
                    action: function(e, dt, node, config) {
                        // Button action
                    },
                    init: function(api, node, config) {
                        // Remove default classes if permission is not granted
                        if (!@json(auth()->user()->can('PYR-Add'))) {
                            $(node).hide();
                        }
                    }
                }],
                ajax: {
                    url: "{{ url('paymentrequestlist') }}",
                    type: 'GET',
                    beforeSend: function() {
                        cardSection.block({
                            message: '<div class="d-flex justify-content-center align-items-center"><p class="mr-50 mb-50">Loading Please Wait...</p><div class="spinner-grow spinner-grow-sm text-white" role="status"></div> </div>',
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
                    complete: function() {
                        cardSection.block({
                            message: '',
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
                columns: [{
                        data: 'DT_RowIndex'
                    },
                    {
                        data: 'docno',
                        name: 'docno'
                    },
                    {
                        data: 'reference',
                        name: 'reference'
                    },
                    {
                        data: 'refno',
                        name: 'refno'
                    },
                    {
                        data: 'productypes',
                        name: 'productypes'
                    },
                    {
                        data: 'Name',
                        name: 'Name'
                    },
                    {
                        data: 'TinNumber',
                        name: 'TinNumber'
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'paymentreference',
                        name: 'paymentreference'
                    },
                    {
                        data: 'paymentmode',
                        name: 'paymentmode'
                    },
                    {
                        data: 'paymentstatus',
                        name: 'paymentstatus'
                    },
                    {
                        data: 'Amount',
                        name: 'Amount',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'id',
                        name: 'id',
                        orderable: false
                    },
                ],
                columnDefs: [{
                        targets: 8,
                        render: function(data, type, row, meta) {
                            switch (data) {
                                case 'PI':
                                    return 'Purchase Invoice';
                                    break;
                                case 'PO':
                                    return 'Purchase Order';
                                    break;
                                case 'GRV':
                                    return 'Good Recieving';
                                    break;
                                default:
                                    return data;
                                    break;
                            }
                        }
                    },
                    {
                        targets: 12,
                        render: function(data, type, row, meta) {
                            switch (data) {
                                case 0:
                                    return '<span class="text-secondary font-weight-medium"><b>Draft</b></span>';
                                    break;
                                case 1:
                                    return '<span class="text-warning font-weight-medium"><b>Pending</b></span>';
                                    break;
                                case 2:
                                    return '<span class="text-primary font-weight-medium"><b>Verify</b></span>';
                                    break;
                                case 3:
                                    return '<span class="text-success font-weight-medium"><b>Approved</b></span>';
                                    break;
                                case 4:
                                    return '<span class="text-danger font-weight-medium"><b>Void</b></span>';
                                    break;
                                case 5:
                                    return '<span class="text-danger font-weight-medium"><b>Reject</b></span>';
                                    break;
                                case 6:
                                    return '<span class="text-danger font-weight-medium"><b>Review</b></span>';
                                    break;
                                case 7:
                                    return '<span class="text-success font-weight-medium"><b>Reviewed</b></span>';
                                    break;
                                default:
                                    return '--';
                                    break;
                            }
                        }
                    },
                    {
                        targets: 13,
                        render: function(data, type, row, meta) {
                            var anchor = '<a class="DocPrInfo" href="javascript:void(0)" data-id=' + data +
                                ' title="View payment request"><i class="fa-sharp fa-regular fa-circle-info fa-xl" style="color: #00cfe8;"></i></a>';
                            return anchor;
                        }
                    },

                ],
            });
        }

        function setFocus() {
            $($('#pcontracttables tbody > tr')[maingblIndex]).addClass('selected');
        }
        $('#pcontracttables tbody').on('click', 'tr', function() {
            $('#pcontracttables tbody > tr').removeClass('selected');
            $(this).addClass('selected');
            maingblIndex = $(this).index();
        });


        $('#payreditbutton').click(function() {
            var headerid = $('#recordIds').val();
            editpayemntrequest(headerid);
        });

        function resetselect2(params) {
            $(`#supplier option, #paymentreference option, #paymentreference option, #paymentmode option, #paymentstatus option,
            #productype option, #coffeesource option, #commoditytype option,#coffeesource option,#type option,
            #coffestatus option`).prop(`disabled`, false);
        }

        function editpayemntrequest(id) {
            var filename = '';
            var peno = '';
            var paymentreference = '';
            var grnexist = '';
            let purchaseordertype = '';
            let reference = '';
            let withitems = '';
            let productype = '';
            let recordid = 0;
            let poid = 0;
            $("#directdynamicTablecommdity > tbody").empty();
            $("#purchaseorderinfodatatables > tbody").empty();
            $('#exampleModalScrollableTitleadd').html('Edit Payment Request')
            resetselect2();
            var priceupdatepermission = $('#priceupdatepermission').val();
            switch (priceupdatepermission) {
                case '1':
                    $('#directcustomCheck1').prop('disabled', false);
                    break;

                default:
                    $('#directcustomCheck1').prop('disabled', true);
                    break;
            }

            $.ajax({
                type: "GET",
                url: "{{ url('editepaymentrequest') }}/" + id,
                dataType: "json",
                beforeSend: function() {
                    cardSection.block({
                        message: '<div class="d-flex justify-content-center align-items-center"><p class="mr-50 mb-50">Loading Please Wait...</p><div class="spinner-grow spinner-grow-sm text-white" role="status"></div> </div>',
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
                complete: function() {
                    cardSection.block({
                        message: '',
                        timeout: 1,
                        css: {
                            backgroundColor: '',
                            color: '',
                            border: ''
                        },
                    });

                    $('#paymentrequestinfomodal').modal('hide');
                    $('#exampleModalScrollable').modal('show');
                    $("#savedicon").removeClass("fa-sharp fa-solid fa-floppy-disk");
                    $("#savedicon").removeClass("fa-duotone fa-pen");
                    $("#savedicon").addClass("fa-duotone fa-pen");
                    $("#savebutton").find('span').text("Update");
                },
                success: function(response) {
                    $('#remainamount').val(response.remainamount);
                    $('#constatntremainamount').val(response.remainamount.toFixed(2));
                    $('#constantpaidamount').val(response.paidamount.toFixed(2));
                    $('#previousconstantpaidamount').val(response.previouspaidamount.toFixed(2));
                    $('#popaidamount').html(numformat(response.paidamount));
                    $('#poremainamount').html(numformat(response.remainamount));
                    $('#pototalamount').html(numformat(response.totalamount));
                    grnexist = response.grnexist;
                    $('#referenceno').empty();
                    var optiondefault = "<option selected disabled value=''></option>";
                    $('#referenceno').append(optiondefault);
                    $.each(response.podata, function(index, value) {
                        polinks = '<a href="#" onclick="viewpoinformation(' + value.id + ');"><u>' +
                            value.porderno + '</u></a>';
                        $('.payrinforeference').html(value.type);
                        $('.payrinfopo').html(polinks);
                        $('#payrdirectinfosubtotalLbl').html(numformat(value.subtotal));
                        $('#payrdirectinfotaxLbl').html(numformat(value.tax));
                        $('#payrdirectinfograndtotalLbl').html(numformat(value.grandtotal));
                        $('#payrdirectinfowitholdingAmntLbl').html(numformat(value.withold));
                        $('#payrdirectinfovatAmntLbl').html(value.withold);
                        $('#payrdirectinfonetpayLbl').html(numformat(value.netpay));

                        var status = value.status;
                        var type = value.type;
                        poid = value.id;
                        var pono = value.porderno;
                        var peid = value.purchasevaulation_id;
                        

                        switch (value.istaxable) {
                            case 0:
                                $('#supplierinfotaxtr').hide();
                                $('#supplierinforandtotaltr').hide();
                                break;
                            default:
                                $('#supplierinfotaxtr').show();
                                $('#supplierinforandtotaltr').show();
                                break;
                        }
                    });

                    $.each(response.po, function(index, value) {
                        option = '<option value="' + value.id + '" title="' + value.porderno + '">' +
                            value.porderno + ',' + value.Name + ',' + value.TinNumber + '</option>';
                        $('#referenceno').append(option);
                    });
                    $('#referenceno').select2();
                    $.each(response.payrequest, function(index, value) {
                        filename = value.name;
                        paymentreference = value.paymentreference;
                        reference = value.reference;
                        withitems = value.withitems;
                        purchaseordertype = value.productypes;
                        recordid = value.id;
                        filename = (filename === undefined || filename === null || filename === '') ?
                            'EMPTY' : filename;
                        $('#payrid').val(value.id);
                        $('#documentnumber').val(value.docno);
                        $('#referencenohidden').val(value.poid);
                        updateSelect2('#productype', value.productypes, true);
                        updateSelect2('#type', value.reference, true);
                        updateSelect2('#referenceno', value.poid, true);
                        updateSelect2('#supplier', value.supplier, true);
                        updateSelect2('#commoditytype', value.commoditype, true);
                        updateSelect2('#coffeesource', value.commoditysource, true);
                        updateSelect2('#coffestatus', value.commoditystatus, true);
                        updateSelect2('#paymentreference', value.paymentreference, true);
                        updateSelect2('#paymentstatus', value.paymentstatus, true);
                        updateSelect2('#paymentmode', value.paymentmode, true);
                        $('#withitems').val(value.withitems);
                        $('#date').val(value.date);
                        $('#amount').val(value.Amount);
                        $('#memo').val(value.memo);
                        $('#purpose').val(value.purpose);
                        $('#supplierhidden').val(value.supplier);
                        $('#directistaxable').val(value.istaxable);
                        $('#filaname').val(value.name);
                        $('#filepath').val(value.path);
                        switch (value.status) {
                            case 0:
                                $('#statusdisplay').html(
                                    '<span class="text-secondary font-weight-medium"><b> ' + value
                                    .docno + ' Draft</b>');
                                break;
                            case 1:
                                $('#statusdisplay').html(
                                    '<span class="text-warning font-weight-medium"><b> ' + value
                                    .docno + ' Pending</b>');
                                break;
                            default:
                                $('#statusdisplay').html(
                                    '<span class="text-primary font-weight-medium"><b> ' + value
                                    .docno + ' Verify</b>');
                                break;
                        }

                        switch (value.istaxable) {
                            case 1:
                                $('#directcustomCheck1').prop('checked', true);
                                break;

                            default:
                                $('#directcustomCheck1').prop('checked', false);
                                break;
                        }

                        switch (filename) {
                            case 'EMPTY':
                                $('#slipdocumentlinkbtn').hide();
                                $('.removecontract').hide();
                                break;
                            default:
                                $('#slipdocumentlinkbtn').show();
                                $('.removecontract').show();
                                $("#slipdocumentlinkbtntext").text(filename);
                                break;
                        }
                    });
                    switch (reference) {
                        case 'Direct':
                            
                            $('.cmdtyclass').hide();
                            $('#amountdetailsdiv').hide();
                            if (reference == 'Direct' && purchaseordertype == 'Goods') {
                                switch (withitems) {
                                    case 'With':
                                        $('#directrow').show();
                                        $('.withitemsclass').show();
                                        $('#colorCheck1').prop('checked', true);
                                        withitemsgoodsorderlist(recordid);
                                        break;
                                    default:
                                        $('#directrow').hide();
                                        $('.withitemsclass').hide();
                                        $('#colorCheck1').prop('checked', false);
                                        break;
                                }
                            }
                            $('#colorCheck1').prop('disabled', true);
                            $('#commodityrow').hide();
                            $('#referencenodiv').hide();
                            break;
                        default:
                            $('#directrow').hide();
                            $('.cmdtyclass').show();
                            $('#referencenodiv').show();
                            $('.withitemsclass').hide();
                            switch (paymentreference) {
                                case 'PO':
                                    $('#commodityrow').show();
                                    $('#amountdetailsdiv').show();
                                    $('#referencenodiv').show();
                                    $('#poremainamount').addClass('text-success font-weight-medium');
                                    toggleElementsBasedOnProductType();
                                    switch (purchaseordertype) {
                                        case 'Goods':
                                            $('#purchaseorderinfodatatables').hide();
                                            $('#goodsdynamictables').show();
                                            goodsorderlist(poid);
                                            break;

                                        default:
                                            $('#purchaseorderinfodatatables').show();
                                            $('#goodsdynamictables').hide();
                                            porderlist(poid);
                                            break;
                                    }
                                    break;
                                default:
                                    $('#commodityrow').show();
                                    $('#amountdetailsdiv').show();
                                    $('#referencenodiv').show();
                                    break;
                            }

                            switch (response.grnexist) {
                                case true:
                                    $('#isgrnexistornot').val(response.grnexist);
                                    $('#isdataexistornot').val(response.grnexist);
                                    $('#purchaseorderview-tab').removeClass('active');
                                    $('#grnview-tab').removeClass('active');
                                    $('#piview-tab').removeClass('active');
                                    $('#grnview-tab').addClass('active');
                                    toggleElementsBasedOnProductType();
                                    switch (paymentreference) {
                                        case 'PI':
                                            appendcommodity(response.comiditylist, 'pi');
                                            $('#paymentrequestinfoapptabs .nav-link[data-tab="3"]').removeClass(
                                                'disabled');
                                            $('#paymentrequestinfoapptabs .nav-link[data-tab="2"]').addClass(
                                                'disabled');
                                            $('#paymentrequestinfoapptabs .nav-link[data-tab="1"]').addClass(
                                                'disabled');

                                            $('#purchaseorderview-tab').removeClass('active');
                                            $('#grnview-tab').removeClass('active');
                                            $('#purchaseorderview').removeClass('active');
                                            $('#piview-tab').addClass('active');
                                            $('#piview').addClass('active');
                                            $('#payrinfopiview').removeClass('active');
                                            $('#grnview').addClass('active');
                                            break;

                                        default:
                                            appendcommodity(response.comiditylist, 'grv');
                                            $('#paymentrequestinfoapptabs .nav-link[data-tab="2"]').removeClass(
                                                'disabled');
                                            $('#paymentrequestinfoapptabs .nav-link[data-tab="3"]').addClass(
                                                'disabled');
                                            $('#paymentrequestinfoapptabs .nav-link[data-tab="1"]').addClass(
                                                'disabled');

                                            $('#purchaseorderview-tab').removeClass('active');
                                            $('#grnview-tab').removeClass('active');
                                            $('#piview-tab').removeClass('active');
                                            $('#grnview-tab').addClass('active');

                                            $('#piview-tab').removeClass('active');
                                            $('#piview').removeClass('active');
                                            $('#payrinfopiview').removeClass('active');
                                            $('#purchaseorderview').removeClass('active');
                                            $('#grnview').addClass('active');
                                            break;
                                    }
                                    $('#directpricetable').show();
                                    break;

                                default:
                                    $('#isgrnexistornot').val('false');
                                    $('#isdataexistornot').val('false');
                                    $('#purchaseorderview-tab').removeClass('active');
                                    $('#grnview-tab').removeClass('active');
                                    $('#piview-tab').removeClass('active');
                                    $('#purchaseorderview-tab').addClass('active');
                                    $('#grnview').removeClass('active');
                                    $('#purchaseorderview').addClass('active');
                                    $('#paymentrequestinfoapptabs .nav-link[data-tab="1"]').removeClass(
                                        'disabled');
                                    $('#paymentrequestinfoapptabs .nav-link[data-tab="2"]').removeClass(
                                        'disabled');
                                    $('#paymentrequestinfoapptabs .nav-link[data-tab="2"]').addClass(
                                    'disabled');
                                    $('#paymentrequestinfoapptabs .nav-link[data-tab="3"]').addClass(
                                    'disabled');
                                    $('#directsubtotali').val('0.00');
                                    $('#directtaxi').val('0.00');
                                    $('#directgrandtotali').val('0.00');
                                    $('#directwitholdingAmntin').val('0.00');
                                    $('#directvatAmntin').val('0.00');
                                    $('#directnetpayin').val('0.00');
                                    toggleElementsBasedOnProductType();
                                    break;
                            }
                            break;
                    }


                }
            });
        }

        $('body').on('click', '.DocPrInfo', function() {
            var recordId = $(this).data('id');
            $('#recordIds').val(recordId);
            payrinformations(recordId);
        });

        function payrinformations(recordId) {
            var reference = '';
            var poid = 0;
            var path = '';
            var paidamount = 0.00;
            var popaidamount = 0.00;
            var remaining = 0.00;
            var poremaining = 0.00;
            var paymentreference = '';
            var totalamount = 0.00;
            let purchaseordertype = '';
            $.ajax({
                type: "GET",
                url: "{{ url('payrinfo') }}/" + recordId,
                beforeSend: function() {
                    cardSection.block({
                        message: '<div class="d-flex justify-content-center align-items-center"><p class="mr-50 mb-50">Loading Please Wait...</p><div class="spinner-grow spinner-grow-sm text-white" role="status"></div> </div>',
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
                complete: function() {
                    cardSection.block({
                        message: '',
                        timeout: 1,
                        css: {
                            backgroundColor: '',
                            color: '',
                            border: ''
                        },
                    });
                    $("#payrcollapseOne").collapse('show');
                    $('#paymentrequestinfomodal').modal('show');
                },
                success: function(response) {
                    paidamount = response.paidamount;
                    popaidamount = response.popaidamount;
                    totalamount = response.totalamount;
                    remaining = parseFloat(totalamount) - parseFloat(paidamount);
                    $('#popayrinfototalamount').html(numformat(totalamount));
                    $('#popayrinfototalpayamount').html(popaidamount);

                    $.each(response.supplier, function(index, value) {
                        $('#paymentrequestinfosuppid').html(value.Code);
                        $('#paymentrequestinfsupname').html(value.Name);
                        $('#paymentrequestinfosupptin').html(value.TinNumber);
                    });
                    $.each(response.podata, function(index, value) {
                        switch (value.type) {
                            case 'Direct':
                                $('.paymentrequestinfopetr').hide();

                                break;
                            default:
                                $('.paymentrequestinfopetr').show();
                                break;
                        }
                        $('.paymentrequestinforeference').html(value.type);

                        $('#popayrinfopaymentreference').html('PO');
                        $('#popayrinfopaymentmode').html('Advance');
                        $('#popayrinfopaymentstatus').html('Partial');

                        $('#popayrinfototalpayamount').html(numformat(paidamount));
                        poremaining = parseFloat(value.netpay) - parseFloat(paidamount);
                        $('#popayrinforemainamount').html(numformat(poremaining.toFixed(2)));
                        var links = '<a href="#" onclick="infoviewpaymenthistory(' + value.id + ',' +
                            value.supplier + ');"><u>View Payment History</u></a>';
                        $('#popayrinfoviewpaymenthistory').html(links);
                    });
                    $.each(response.payrninfo, function(index, value) {
                        paymentreference = value.paymentreference;
                        purchaseordertype = value.productypes;
                        $('.itemtype').html(value.productypes);
                        switch (value.paymentreference) {
                            case 'PO':
                                $('.paymentrefernceclass').html('Purchase Order');
                                break;
                            case 'PI':
                                $('.paymentrefernceclass').html('Purchase Invoice');
                                break;
                            case 'GRV':
                                $('.paymentrefernceclass').html('Purchase Invoice');
                                break;
                            default:
                                $('.paymentrefernceclass').html('Direct');
                                break;
                        }
                        switch (value.reference) {
                            case 'Direct':
                                $('.poinfocmdtyclass').hide(); 
                                break;

                            default:
                                $('.poinfocmdtyclass').show();
                                break;
                        }
                        $('#parydocno').html(value.docno);
                        $('#payrinfocommoditype').html(value.commoditype);
                        $('#payrinfocommoditysource').html(value.commoditysource);
                        $('#payrinfocommoditystatus').html(value.commoditystatus);
                        $('#payrinfopaymentmode').html(value.paymentmode);
                        $('#payrinfodocumentdate').html(value.date);
                        $('#payrinfopaymentstatus').html(value.paymentstatus);
                        $('#grndirectsubtotalLbl').html(numformat(value.subtotal));
                        $('#grndirecttaxLbl').html(numformat(value.tax));
                        $('#grndirectgrandtotalLbl').html(numformat(value.grandtotal));
                        $('#grndirectwitholdingAmntLbl').html(numformat(value.withold));
                        $('#grndirectnetpayLbl').html(numformat(value.netpay));
                        $('#payrinfototalpayamount').html(numformat(value.netpay));
                        $('#payrinfopaidamount').html(numformat(value.Amount));
                        $("#payrinfopaidamount").css("text-decoration", "underline");
                        $('#payrinfototalpayamount').html(numformat(totalamount));
                        $('#directpopayrinfopaidamount').html(numformat(value.Amount));
                        $('#payrinfopayamount').html(numformat(paidamount.toFixed(2)));
                        $('#popayrinfopaidamount').html(numformat(value.Amount));
                        $("#popayrinfopaidamount").css("text-decoration", "underline");
                        $('.popayrinfopar').html(value.docno);
                        $('#payrinforemainamount').html(numformat(remaining.toFixed(2)));
                        var links = '<a href="#" onclick="infoviewpaymenthistory(' + value.poid +
                            ');"><u>View Payment History</u></a>';
                        $('#payrinfoviewpaymenthistory').html(links);
                        $('.paymentrequestinfopurpose').html(value.purpose);

                        $('#paymentrequestinfomemo').html(value.memo);

                        reference = value.reference;
                        poid = value.poid;
                        path = value.path;

                        showactionbuttondependonstat(value.status, value.docno);
                        switch (value.istaxable) {
                            case 0:
                                $('#infodirecttaxtr').hide();
                                $('#grndirectgrandtotaltr').hide();
                                $('#payrinfosupplierinfotaxtr').hide();
                                $('#payrinfosupplierinforandtotaltr').hide();
                                $('#withitemsgoodsdirecttaxtr').hide();
                                $('#withitemsgoodsdirectgrandtotaltr').hide();
                                break;

                            default:
                                $('#infodirecttaxtr').show();
                                $('#grndirectgrandtotaltr').show();
                                $('#payrinfosupplierinfotaxtr').show();
                                $('#payrinfosupplierinforandtotaltr').show();
                                $('#withitemsgoodsdirecttaxtr').show();
                                $('#withitemsgoodsdirectgrandtotaltr').show();
                                break;
                        }
                        switch (value.reference) {
                            case 'PO':
                                $('#dividerinfo').show();
                                $('#commodityrowinfo').show();
                                $('#paymentinfordirectprice').hide();
                                let links = '<a href="#" onclick="viewpoinformation(' + value.poid +
                                    ');"><u>' + value.porderno + '</u></a>';
                                $('.paymentrequestinfopo').html(links);
                                $('.infopetr').show();
                                $('#payrinforefernce').html('Purchase Order');
                                //-----show for po data----
                                $('#payrinfodirectinfosubtotalLbl').html(numformat(value.subtotal));
                                $('#payrinfodirectinfotaxLbl').html(numformat(value.tax));
                                $('#payrinfodirectinfograndtotalLbl').html(numformat(value.grandtotal));
                                $('#payrinfodirectinfowitholdingAmntLbl').html(numformat(value
                                .withold));
                                $('#payrinfodirectinfonetpayLbl').html(numformat(value.netpay));
                                // end of show po data
                                break;
                            default:
                                switch (value.withitems) {
                                    case 'With':
                                        $('#withoutitemsrow').hide();
                                        $('#withitemsrow').show();
                                        getdirepaymentreferencewithitems(recordId);
                                        $('#withitemsgoodsdirectsubtotalLbl').html(numformat(value
                                            .subtotal));
                                        $('#withitemsgoodsdirecttaxLbl').html(numformat(value.tax));
                                        $('#withitemsgoodsdirectgrandtotalLbl').html(numformat(value
                                            .grandtotal));
                                        $('#withitemsgoodsdirectwitholdingAmntLbl').html(numformat(value
                                            .withold));
                                        $('#withitemsgoodsdirectnetpayLbl').html(numformat(value
                                            .netpay));
                                        break;

                                    default:
                                        $('#withoutitemsrow').show();
                                        $('#withitemsrow').hide();;
                                        break;
                                }
                                $('.infopetr').hide();
                                $('#payrinforefernce').html(value.reference);
                                $('#paymentinfordirectprice').show();
                                $('#commodityrowinfo').hide();
                                $('#dividerinfo').hide();
                                $('#payrinfopaymentreference').html('Direct');
                                break;
                        }
                        path = (path === undefined || path === null || path === '') ? 'EMPTY' : path;
                        switch (path) {
                            case 'EMPTY':
                                var iframe = $('#pdfviewer')[0];
                                var doc = iframe.contentDocument || iframe.contentWindow.document;
                                doc.open();
                                // Write a simple HTML structure with the text
                                var text = "No Document Attached";
                                doc.write('<html><body><h1>' + text + '</h1></body></html>');
                                // Close the document to apply changes
                                doc.close();
                                break;
                            default:
                                viewdocuments(recordId);
                                break;
                        }
                    });
                    switch (response.exist) {
                        case true:
                            showcommodity(recordId, paymentreference, purchaseordertype);
                            switch (paymentreference) {
                                case 'PI':
                                    $('#payrinfoapptabs .nav-link[data-tab="1"]').addClass('disabled');
                                    $('#payrinfoapptabs .nav-link[data-tab="2"]').addClass('disabled');
                                    $('#payrinfoapptabs .nav-link[data-tab="3"]').removeClass('disabled');
                                    $('#purchaseorderview-tab').removeClass('active');
                                    $('#payrinfopurchaseorderview-tab').removeClass('active');
                                    $('#payrinfogrnview-tab').removeClass('active');
                                    $('#payrinfopurchaseorderview').removeClass('active');
                                    $('#payrinfogrnview').addClass('active');
                                    $('#payrinfopiview-tab').addClass('active');
                                    $('#payrinfopiview').removeClass('active');
                                    break;
                                case 'PO':
                                    $('#payrinfoapptabs .nav-link[data-tab="2"]').addClass('disabled');
                                    $('#payrinfoapptabs .nav-link[data-tab="3"]').addClass('disabled');
                                    $('#payrinfogrnview-tab').removeClass('active');
                                    $('#payrinfopiview-tab').removeClass('active');
                                    $('#payrinfopurchaseorderview-tab').removeClass('active');
                                    $('#payrinfopurchaseorderview-tab').addClass('active');
                                    $('#payrinfogrnview').removeClass('active');
                                    $('#payrinfopurchaseorderview').addClass('active');
                                    switch (purchaseordertype) {
                                        case 'Goods':
                                            $('.directcommudityinfodatatablesdiv').hide();
                                            $('.directgoodsinfodatatablesdiv').show();
                                            $('.cmdtyclass').hide();
                                            break;

                                        default:
                                            $('.directcommudityinfodatatablesdiv').show();
                                            $('.directgoodsinfodatatablesdiv').hide();
                                            $('.cmdtyclass').show();
                                            break;
                                    }
                                    break;
                                default:
                                    $('#payrinfoapptabs .nav-link[data-tab="1"]').addClass('disabled');
                                    $('#payrinfoapptabs .nav-link[data-tab="2"]').removeClass('disabled');
                                    $('#payrinfoapptabs .nav-link[data-tab="3"]').addClass('disabled');
                                    $('#purchaseorderview-tab').removeClass('active');
                                    $('#payrinfogrnview-tab').removeClass('active');
                                    $('#payrinfopiview-tab').removeClass('active');
                                    $('#payrinfopurchaseorderview-tab').removeClass('active');
                                    $('#payrinfogrnview-tab').addClass('active');
                                    $('#payrinfopurchaseorderview').removeClass('active');
                                    $('#payrinfopiview').removeClass('active');
                                    $('#payrinfogrnview').addClass('active');
                                    break;
                            }

                            break;

                        default:
                            $('#payrinfoapptabs .nav-link[data-tab="2"]').addClass('disabled');
                            $('#payrinfoapptabs .nav-link[data-tab="3"]').addClass('disabled');
                            $('#payrinfogrnview-tab').removeClass('active');
                            $('#payrinfopiview-tab').removeClass('active');
                            $('#payrinfopurchaseorderview-tab').removeClass('active');
                            $('#payrinfopurchaseorderview-tab').addClass('active');
                            $('#payrinfogrnview').removeClass('active');
                            $('#payrinfopurchaseorderview').addClass('active');
                            switch (purchaseordertype) {
                                case 'Goods':
                                    $('.directcommudityinfodatatablesdiv').hide();
                                    $('.directgoodsinfodatatablesdiv').show();
                                    $('.infocmdtyclass').hide();
                                    break;
                                default:
                                    $('.directcommudityinfodatatablesdiv').show();
                                    $('.infocmdtyclass').show();
                                    $('.directgoodsinfodatatablesdiv').hide();
                                    break;
                            }
                            break;
                    }
                    switch (reference) {
                        case 'PO':
                            switch (purchaseordertype) {
                                case 'Goods':
                                    getgoods(recordId);
                                    break;

                                default:
                                    showpodata(recordId, response.podata);
                                    break;
                            }

                            break;

                        default:
                            break;
                    }
                    setpaymentrequestminilog(response.actions);

                }
            });
        }

        function viewdocuments(id) {
            $.ajax({
                type: "GET",
                url: "{{ url('downloadpaymentrequest') }}/" + id,
                beforeSend: function() {
                    cardSection.block({
                        message: '<div class="d-flex justify-content-center align-items-center"><p class="mr-50 mb-50">Loading Please Wait...</p><div class="spinner-grow spinner-grow-sm text-white" role="status"></div> </div>',
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
                complete: function() {
                    cardSection.block({
                        message: '',
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
                success: function(response) {
                    var blobUrl = URL.createObjectURL(response);
                    $('#pdfviewer').attr('src', blobUrl);
                },
                error: function(xhr) {

                    toastrMessage('error', 'An error occurred while loading the PDF.', 'Error!');
                }
            });
        }

        function showactionbuttondependonstat(status, docno) {
            switch (status) {
                case 0:
                    $('#payreditbutton').show();
                    $('#payrpendingbutton').show();
                    $('#payrvoidbutton').show();
                    $('#payrejectbutton').show();
                    $('#payrverifybutton').hide();
                    $('#payrapprovebutton').hide();
                    $('#payrundovoidbutton').hide();
                    $('#payrundorejectbutton').hide();
                    $('#payrundoreviewbutton').hide();
                    $('#payrreviewbutton').hide();
                    $('#payrbacktopendingbutton').hide();
                    $('#payrbacktodraftbutton').hide();
                    $('#payrbacktoverifybutton').hide();
                    $('#payrprintbutton').hide();
                    $('#paymentrequestinfoStatus').html('<span class="text-secondary font-weight-medium"><b> ' + docno +
                        ' Draft</b>');
                    break;
                case 1:
                    $('#payreditbutton').show();
                    $('#payrbacktodraftbutton').show();
                    $('#payrpendingbutton').hide();
                    $('#payrverifybutton').show();
                    $('#payrapprovebutton').hide();
                    $('#payrundovoidbutton').hide();
                    $('#payrundorejectbutton').hide();
                    $('#payrundoreviewbutton').hide();
                    $('#payrreviewbutton').hide();
                    $('#payrbacktopendingbutton').hide();
                    $('#payrbacktoverifybutton').hide();
                    $('#payrprintbutton').hide();
                    $('#paymentrequestinfoStatus').html('<span class="text-warning font-weight-medium"><b> ' + docno +
                        ' Pending</b>');
                    break;
                case 2:
                    $('#payreditbutton').show();
                    $('#payrbacktopendingbutton').show();
                    $('#payrpendingbutton').hide();
                    $('#payrverifybutton').hide();
                    $('#payrapprovebutton').show();
                    $('#payrundovoidbutton').hide();
                    $('#payrundorejectbutton').hide();
                    $('#payrbacktodraftbutton').hide();
                    $('#payrbacktoverifybutton').hide();
                    $('#payrundoreviewbutton').hide();
                    $('#payrreviewbutton').hide();
                    $('#payrprintbutton').hide();
                    $('#paymentrequestinfoStatus').html('<span class="text-primary font-weight-medium"><b> ' + docno +
                        ' Verify</b>');
                    break;
                case 3:
                    $('#payrbacktoverifybutton').show();
                    $('#payrprintbutton').show();
                    $('#payrpendingbutton').hide();
                    $('#payrverifybutton').hide();
                    $('#payrapprovebutton').hide();
                    $('#payrundovoidbutton').hide();
                    $('#payrundorejectbutton').hide();
                    $('#payreditbutton').hide();
                    $('#payrundoreviewbutton').hide();
                    $('#payrreviewbutton').hide();
                    $('#payrbacktopendingbutton').hide();
                    $('#payrbacktodraftbutton').hide();
                    $('#paymentrequestinfoStatus').html('<span class="text-success font-weight-medium"><b> ' + docno +
                        ' Approved</b>');
                    break;
                case 5:
                    $('#payrundorejectbutton').show();
                    $('#payrpendingbutton').hide();
                    $('#payrverifybutton').hide();
                    $('#payrapprovebutton').hide();
                    $('#payrundovoidbutton').hide();
                    $('#payrvoidbutton').hide();
                    $('#payreditbutton').hide();
                    $('#payrejectbutton').hide();
                    $('#payrprintbutton').hide();
                    $('#payrbacktopendingbutton').hide();
                    $('#payrbacktodraftbutton').hide();
                    $('#payrbacktoverifybutton').hide();
                    $('#payrreviewbutton').hide();
                    $('#payrundoreviewbutton').hide();
                    $('#paymentrequestinfoStatus').html('<span class="text-danger font-weight-medium"><b> ' + docno +
                        ' Reject</b>');
                    break;
                case 4:
                    $('#payrundovoidbutton').show();
                    $('#payrundorejectbutton').hide();
                    $('#payrpendingbutton').hide();
                    $('#payrverifybutton').hide();
                    $('#payrapprovebutton').hide();
                    $('#payrvoidbutton').hide();
                    $('#payreditbutton').hide();
                    $('#payrejectbutton').hide();
                    $('#payrprintbutton').hide();
                    $('#payrbacktopendingbutton').hide();
                    $('#payrbacktodraftbutton').hide();
                    $('#payrbacktoverifybutton').hide();
                    $('#payrreviewbutton').hide();
                    $('#payrundoreviewbutton').hide();
                    $('#paymentrequestinfoStatus').html('<span class="text-danger font-weight-medium"><b> ' + docno +
                        ' Void</b>');
                    break;
                case 6:
                    $('#payrreviewbutton').show();
                    $('#payrundoreviewbutton').hide();
                    $('#payrundovoidbutton').hide();
                    $('#payrundorejectbutton').hide();
                    $('#payrpendingbutton').hide();
                    $('#payrverifybutton').hide();
                    $('#payrapprovebutton').hide();
                    $('#payrvoidbutton').hide();
                    $('#payreditbutton').hide();
                    $('#payrejectbutton').hide();
                    $('#payrbacktopendingbutton').show();
                    $('#payrbacktodraftbutton').hide();
                    $('#payrbacktoverifybutton').hide();
                    $('#payrprintbutton').hide();
                    $('#paymentrequestinfoStatus').html('<span class="text-danger font-weight-medium"><b> ' + docno +
                        ' Review</b>');
                    break;
                default:
                    $('#payrundoreviewbutton').show();
                    $('#payrapprovebutton').show();
                    $('#payrbacktopendingbutton').show();
                    $('#payrreviewbutton').hide();
                    $('#payrundovoidbutton').hide();
                    $('#payrundorejectbutton').hide();
                    $('#payrpendingbutton').hide();
                    $('#payrverifybutton').hide();
                    $('#payrvoidbutton').hide();
                    $('#payreditbutton').hide();
                    $('#payrejectbutton').hide();
                    $('#payrbacktodraftbutton').hide();
                    $('#payrbacktoverifybutton').hide();
                    $('#payrprintbutton').hide();
                    $('#paymentrequestinfoStatus').html('<span class="text-success font-weight-medium"><b> ' + docno +
                        ' Reviewed</b>');
                    break;
            }
        }
        $('#payrbacktoverifybutton').click(function() {
            var id = $('#recordIds').val();
            $('#povoidid').val(id);
            $('#povoidtype').val('Verify');
            $("#voidreason").val('');
            $("#povoidbutton").find('span').text("Back To Verify");
            $('#povoidmodal').modal('show');
        });
        $('#payrbacktopendingbutton').click(function() {
            var id = $('#recordIds').val();
            $('#povoidid').val(id);
            $('#povoidtype').val('Pending');
            $("#voidreason").val('');
            $("#povoidbutton").find('span').text("Back To Pending");
            $('#povoidmodal').modal('show');
        });

        $('#payrbacktodraftbutton').click(function() {
            var id = $('#recordIds').val();
            $('#povoidid').val(id);
            $('#povoidtype').val('Draft');
            $("#voidreason").val('');
            $("#povoidbutton").find('span').text("Back To Draft");
            $('#povoidmodal').modal('show');
        });

        $('#payrejectbutton').click(function() {
            var id = $('#recordIds').val();
            $('#povoidid').val(id);
            $('#povoidtype').val('Reject');
            $("#voidreason").val('');
            $("#povoidbutton").find('span').text("Reject");
            $('#povoidmodal').modal('show');
        });
        $('#payrvoidbutton').click(function() {
            var id = $('#recordIds').val();
            $('#povoidid').val(id);
            $('#povoidtype').val('Void');
            $("#voidreason").val('');
            $("#povoidbutton").find('span').text("Void");
            $('#povoidmodal').modal('show');
        });

        $('#payrpendingbutton').click(function() {
            var id = $('#recordIds').val();
            confirmAction(id, 1);
        });

        $('#payrverifybutton').click(function() {
            var id = $('#recordIds').val();
            confirmAction(id, 2);
        });

        $('#payrapprovebutton').click(function() {
            var id = $('#recordIds').val();
            confirmAction(id, 3);
        });

        $('#payrundorejectbutton').click(function() {
            var id = $('#recordIds').val();
            confirmAction(id, 5);
        });
        $('#payrundovoidbutton').click(function() {
            var id = $('#recordIds').val();
            confirmAction(id, 4);
        });
        $('#payrreviewbutton').click(function() {
            var id = $('#recordIds').val();
            confirmAction(id, 6);
        });
        $('#payrundoreviewbutton').click(function() {
            var id = $('#recordIds').val();
            confirmAction(id, 7);
        });


        function confirmAction(id, status) {
            var msg = '--';
            var title = '--';
            var buttontext = '--';
            switch (status) {
                case 1:
                    msg = 'Are you sure do you want to pending';
                    title = 'Confirmation';
                    buttontext = 'Pending';
                    break;
                case 2:
                    msg = 'Are you sure do you want to verify';
                    title = 'Confirmation';
                    buttontext = 'Verify';
                    break;
                case 3:
                    msg = 'Are you sure do you want to approve';
                    title = 'Confirmation';
                    buttontext = 'Approve';
                    break;
                case 4:
                    msg = 'Are you sure do you want to undo void';
                    title = 'Confirmation';
                    buttontext = 'Undo void';
                    break;
                case 5:
                    msg = 'Are you sure do you want to undo reject';
                    title = 'Confirmation';
                    buttontext = 'Undo Reject';
                    break;
                case 6:
                    msg = 'Are you sure do you review';
                    title = 'Confirmation';
                    buttontext = 'Review';
                    break;
                case 7:
                    msg = 'Are you sure do you undo review';
                    title = 'Confirmation';
                    buttontext = 'Undo Review';
                    break;
                default:
                    msg = 'whoops';
                    title = 'whoops';
                    buttontext = 'whoops';
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
            }).then(function(e) {
                if (e.value === true) {
                    let token = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        type: 'GET',
                        url: "{{ url('paymentrequestaction') }}/" + id + '/' + status,
                        data: {
                            _token: token
                        },
                        success: function(resp) {
                            switch (resp.success) {
                                case 200:
                                    toastrMessage('success', resp.message, 'success');
                                    switch (resp.status) {
                                        case 3:
                                            $('.infopaidamount').html(numformat(resp.paidamount.toFixed(
                                                2)));
                                            $('.inforemainamount').html(numformat(resp.remainamount));
                                            break;

                                        default:
                                            break;
                                    }
                                    showactionbuttondependonstat(resp.status, resp.docno);
                                    setpaymentrequestminilog(resp.actions);
                                    break;
                                case 201:
                                    toastrMessage('error',
                                        'Please fill all the technical feild evaluatins', 'Error');
                                    break;
                                default:
                                    swal.fire("Whoops!",
                                        'Something went wrong please contact support team.', "error"
                                        );
                                    break;
                            }

                        },
                        error: function(resp) {
                            swal.fire("Error!", 'Something went wrong.', "error");
                        }
                    });
                } else {
                    e.dismiss;
                }
            }, function(dismiss) {
                return false;
            })
        }

        function setpaymentrequestminilog(actions) {
            var list = '';
            var icons = ''
            var reason = '';
            var addedclass = '';
            $('#paymentrequestulist').empty();
            $.each(actions, function(index, value) {
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
                list += '<li class="timeline-item"><span class="timeline-point timeline-point-' + icons +
                    ' timeline-point-indicator"></span><div class="timeline-header mb-sm-0 mb-0"><h6 class="mb-0 ' +
                    addedclass + '">' + value.action +
                    '</h6><span class="text-muted"><i class="fa-regular fa-user"></i>' + value.user +
                    '</span></br><span class="text-muted"><i class="fa-regular fa-clock"></i> ' + value.time +
                    '</span>' + reason + '</div></li>';
            });
            $('#paymentrequestulist').append(list);

        }

        function showpodata(recordId, podata) {
            var suptables = $('#payrinfopurchaseorderinfodatatables').DataTable({
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
                order: [
                    [0, "desc"]
                ],
                language: {
                    search: '',
                    searchPlaceholder: "Search here"
                },
                "dom": "<'row'<'col-lg-5 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-5'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
                ajax: {
                    url: "{{ url('payrequestpocommoditylist') }}/" + recordId,
                    type: 'GET',
                    beforeSend: function() {
                        cardSection.block({
                            message: '<div class="d-flex justify-content-center align-items-center"><p class="mr-50 mb-50">Loading Please Wait...</p><div class="spinner-grow spinner-grow-sm text-white" role="status"></div> </div>',
                            css: {
                                backgroundColor: 'transparent',
                                color: '#fff',
                                border: '0'
                            },
                            overlayCSS: {
                                opacity: 0.5
                            }
                        });
                        $('#payrinfopurchaseorderinfodatatables').hide(); // hide datatables
                    },
                },
                columns: [{
                        data: 'DT_RowIndex'
                    },
                    {
                        data: 'origin',
                        name: 'origin'
                    },
                    {
                        data: 'grade',
                        name: 'grade'
                    },
                    {
                        data: 'proccesstype',
                        name: 'proccesstype'
                    },
                    {
                        data: 'cropyear',
                        name: 'cropyear'
                    },
                    {
                        data: 'uomname',
                        name: 'uomname'
                    },
                    {
                        data: 'nofbag',
                        name: 'nofbag',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'bagwieght',
                        name: 'bagwieght',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'totalkg',
                        name: 'totalkg',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'netkg',
                        name: 'netkg',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'ton',
                        name: 'ton',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'feresula',
                        name: 'feresula',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'price',
                        name: 'price',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'total',
                        name: 'total',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'cropyear',
                        name: 'cropyear'
                    },

                ],
                columnDefs: [{
                        targets: 14,
                        render: function(data, type, row, meta) {
                            return `
                                            <i class="info-icon fa fa-info-circle text-primary" 
                                            data-netkg="${row.netkg}" 
                                            data-totalprice="${row.total}" 
                                            title="Price Information">
                                            </i>
                                        `;
                        }
                    },

                ],
                drawCallback: function() {
                    cardSection.block({
                        message: '',
                        timeout: 1,
                        css: {
                            backgroundColor: '',
                            color: '',
                            border: ''
                        },
                    });

                    $('#payrinfopurchaseorderinfodatatables').show(); // show datatables after render
                },
                "footerCallback": function(row, data, start, end, display) {
                    var api = this.api();
                    // Helper function to parse integer from strings
                    var intVal = function(i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 : // Remove commas and convert to int
                            typeof i === 'number' ?
                            i : 0;
                    };

                    var totalbag = api
                        .column(6) // The column index where the numeric data is
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    var totalbagweight = api
                        .column(7) // The column index where the numeric data is
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);


                    var totalkg = api
                        .column(8) // The column index where the numeric data is
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    var totalton = api
                        .column(9) // The column index where the numeric data is
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    var totalferesula = api
                        .column(10) // The column index where the numeric data is
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    var totalprice = api
                        .column(11) // The column index where the numeric data is
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    var total = api
                        .column(12) // The column index where the numeric data is
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    var top = api
                        .column(13) // The column index where the numeric data is
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    var numberendering = $.fn.dataTable.render.number(',', '.', 2, ).display;
                    $('#poinfonofbagtotal').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>" +
                        numberendering(totalbag) + "</h6>");
                    $('#poinfonofbagweighttotal').html(
                        "<h6 style='font-size:13px;color:black;font-weight:bold;'>" + numberendering(
                            totalbagweight) + "</h6>");
                    $('#poinfokgtotal').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>" +
                        numberendering(totalkg) + "</h6>");
                    $('#poinfotontotal').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>" +
                        numberendering(totalton) + "</h6>");
                    $('#poinfopriceferesula').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>" +
                        numberendering(totalferesula) + "</h6>");
                    $('#poinfopricetotal').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>" +
                        numberendering(totalprice) + "</h6>");
                    $('#poinfototalpricetotal').html(
                        "<h6 style='font-size:13px;color:black;font-weight:bold;'>" + numberendering(
                        total) + "</h6>");
                    $('#topinfototalpricetotal').html(
                        "<h6 style='font-size:13px;color:black;font-weight:bold;'>" + numberendering(top) +
                        "</h6>");


                },
                "initComplete": function(settings, json) {
                    var totalRows = suptables.rows().count();
                    $('#payrinfodirectinfonumberofItemsLbl').html(totalRows);
                }
            });

        }
        $(document).on('mouseenter', '.info-icon', function() {
            var $icon = $(this);
            // Check if popover is already initialized
            if (!$icon.data('bs.popover')) {
                // Extract row data from attributes
                var totalprice = $icon.data('totalprice');
                var netkg = $icon.data('netkg');
                //Create dynamic content
                var priceperkg = parseFloat(totalprice) / parseFloat(netkg);
                //var formattedTotalPrice = new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(totalprice);
                var calculatedtotalprice = parseFloat(priceperkg) * parseFloat(netkg);
                //priceperkg=Number(priceperkg.toFixed(2));
                calculatedtotalprice = Number(calculatedtotalprice.toFixed(2));

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
        $(document).on('mouseleave', '.info-icon', function() {
            $(this).popover('dispose');
        });

        function showcommodity(recordId, paymentreference, purchaseordertype) {
            switch (purchaseordertype) {
                case 'Goods':
                    getgoods(recordId);
                    break;

                default:
                    getcommodity(recordId, paymentreference);
                    break;
            }

        }


        function getdirepaymentreferencewithitems(id) {
            const tableId = '#withandwithoutgoodsinfodatatables';
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
                language: {
                    search: '',
                    searchPlaceholder: "Search here"
                },
                dom: "<'row'<'col-lg-5 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-5'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
                ajax: {
                    url: `{{ url('getpaymentrequestgoods') }}/${id}`,
                    type: 'GET',
                    beforeSend: () => blockUI(cardSection, 'Loading Please Wait...'),
                    complete: () => unblockUI(cardSection),
                },
                columns: [{
                        data: 'DT_RowIndex'
                    },
                    {
                        data: 'Code',
                        name: 'Code'
                    },
                    {
                        data: 'Name',
                        name: 'Name'
                    },
                    {
                        data: 'SKUNumber',
                        name: 'SKUNumber'
                    },
                    {
                        data: 'uomname',
                        name: 'uomname'
                    },
                    {
                        data: 'qty',
                        name: 'qty',
                        render: renderNumber
                    },
                    {
                        data: 'price',
                        name: 'price',
                        render: renderNumber
                    },
                    {
                        data: 'Total',
                        name: 'Total',
                        render: renderNumber
                    },
                ],
                initComplete: function(settings, json) {
                    const totalRows = suptables.rows().count();
                    $('#withitemsgoodsdirectnumberofItemsLbl').html(totalRows);
                },
                footerCallback: function(row, data, start, end, display) {
                    const api = this.api();
                    const intVal = (i) => typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i ===
                        'number' ? i : 0;
                    const qty = api.column(5).data().reduce((a, b) => intVal(a) + intVal(b), 0);
                    const unitprice = api.column(6).data().reduce((a, b) => intVal(a) + intVal(b), 0);
                    const total = api.column(7).data().reduce((a, b) => intVal(a) + intVal(b), 0);
                    $('.infoqtytotal').html(formatFooterValue(qty));
                    $('.infounitpreicetotal').html(formatFooterValue(unitprice));
                    $('.infototal').html(formatFooterValue(total));
                },
            });
        }

        function getgoods(id) {
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
                language: {
                    search: '',
                    searchPlaceholder: "Search here"
                },
                dom: "<'row'<'col-lg-5 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-5'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
                ajax: {
                    url: `{{ url('getpaymentrequestgoods') }}/${id}`,
                    type: 'GET',
                    beforeSend: () => blockUI(cardSection, 'Loading Please Wait...'),
                    complete: () => unblockUI(cardSection),
                },
                columns: [{
                        data: 'DT_RowIndex'
                    },
                    {
                        data: 'Code',
                        name: 'Code'
                    },
                    {
                        data: 'Name',
                        name: 'Name'
                    },
                    {
                        data: 'SKUNumber',
                        name: 'SKUNumber'
                    },
                    {
                        data: 'uomname',
                        name: 'uomname'
                    },
                    {
                        data: 'qty',
                        name: 'qty',
                        render: renderNumber
                    },
                    {
                        data: 'price',
                        name: 'price',
                        render: renderNumber
                    },
                    {
                        data: 'Total',
                        name: 'Total',
                        render: renderNumber
                    },
                ],
                initComplete: function(settings, json) {
                    const totalRows = suptables.rows().count();
                    $('#payrinfodirectinfonumberofItemsLbl').html(totalRows);
                },
                footerCallback: function(row, data, start, end, display) {
                    const api = this.api();
                    const intVal = (i) => typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i ===
                        'number' ? i : 0;
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
                css: {
                    backgroundColor: 'transparent',
                    color: '#fff',
                    border: '0'
                },
                overlayCSS: {
                    opacity: 0.5
                },
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

        function getcommodity(recordId, paymentreference) {

            var visiblemode = false;
            switch (paymentreference) {
                case 'PI':
                    visiblemode = true;
                    break;

                default:
                    visiblemode = false;
                    break;
            }
            var suptables = $('#payrinfodirectdynamicTablecommdity').DataTable({
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
                language: {
                    search: '',
                    searchPlaceholder: "Search here"
                },
                "dom": "<'row'<'col-lg-5 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-5'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
                ajax: {
                    url: "{{ url('payrequestcommoditylist') }}/" + recordId,
                    type: 'GET',
                    beforeSend: function() {
                        cardSection.block({
                            message: '<div class="d-flex justify-content-center align-items-center"><p class="mr-50 mb-50">Loading Please Wait...</p><div class="spinner-grow spinner-grow-sm text-white" role="status"></div> </div>',
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
                    complete: function() {
                        cardSection.block({
                            message: '',
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

                    {
                        data: 'DT_RowIndex'
                    },
                    {
                        data: 'docno',
                        name: 'docno',
                        width: '11%'
                    },
                    {
                        data: 'pidocno',
                        name: 'pidocno',
                        width: '11%',
                        visible: visiblemode
                    },
                    {
                        data: 'origin',
                        name: 'origin',
                        width: '15%'
                    },
                    {
                        data: 'grade',
                        name: 'grade'
                    },
                    {
                        data: 'proccesstype',
                        name: 'proccesstype'
                    },
                    {
                        data: 'cropyear',
                        name: 'cropyear'
                    },
                    {
                        data: 'uomname',
                        name: 'uomname'
                    },
                    {
                        data: 'nofbag',
                        name: 'nofbag'
                    },
                    {
                        data: 'bagwieght',
                        name: 'bagwieght'
                    },
                    {
                        data: 'totalkg',
                        name: 'totalkg',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'netkg',
                        name: 'netkg',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'ton',
                        name: 'ton',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'feresula',
                        name: 'feresula',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'price',
                        name: 'price',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'total',
                        name: 'total',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'recid',
                        name: 'recid',
                        visible: false
                    },
                    {
                        data: 'pid',
                        name: 'pid',
                        visible: false
                    },
                    {
                        data: 'pid',
                        name: 'pid',
                        visible: true
                    },
                ],
                columnDefs: [{
                        targets: 1,
                        render: function(data, type, row, meta) {
                            return '<a href="#" onclick="viewrecievinginformation(' + row.recid +
                                ');"><u>' + data + '</u></a>';
                        }
                    },
                    {
                        targets: 2,
                        render: function(data, type, row, meta) {
                            return '<a href="#" onclick="viewpiformation(' + row.pid + ');"><u>' + data +
                                '</u></a>';
                        }
                    },
                    {
                        targets: 18,
                        render: function(data, type, row, meta) {
                            return `
                                            <i class="info-icon fa fa-info-circle text-primary" 
                                            data-netkg="${row.netkg}" 
                                            data-totalprice="${row.total}" 
                                            title="Price Information">
                                            </i>
                                        `;
                        }
                    }


                ],
                "footerCallback": function(row, data, start, end, display) {

                    var api = this.api();
                    // Helper function to parse integer from strings
                    var intVal = function(i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 : // Remove commas and convert to int
                            typeof i === 'number' ?
                            i : 0;
                    };

                    var totalbag = api
                        .column(8) // The column index where the numeric data is
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    var totalbagwieght = api
                        .column(9) // The column index where the numeric data is
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    var totalkg = api
                        .column(10) // The column index where the numeric data is
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    var totalnet = api
                        .column(11) // The column index where the numeric data is
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    var totalton = api
                        .column(12) // The column index where the numeric data is
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    var totalferesula = api
                        .column(13) // The column index where the numeric data is
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    var totalprice = api
                        .column(14) // The column index where the numeric data is
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    var totaltotal = api
                        .column(15) // The column index where the numeric data is
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    var numberendering = $.fn.dataTable.render.number(',', '.', 2, ).display;
                    $('#infonofbagtotal').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>" +
                        numberendering(totalbag) + "</h6>");
                    $('#infobagweighttotal').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>" +
                        numberendering(totalbagwieght) + "</h6>");
                    $('#infokgtotal').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>" +
                        numberendering(totalkg) + "</h6>");
                    $('#infonetkgtotal').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>" +
                        numberendering(totalnet) + "</h6>");
                    $('#infotontotal').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>" +
                        numberendering(totalton) + "</h6>");
                    $('#infopriceferesula').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>" +
                        numberendering(totalferesula) + "</h6>");
                    $('#infopricetotal').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>" +
                        numberendering(totalprice) + "</h6>");
                    $('#infototalpricetotal').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>" +
                        numberendering(totaltotal) + "</h6>");
                },
                "initComplete": function(settings, json) {
                    var totalRows = suptables.rows().count();
                    $('#grndirectnumberofItemsLbl').html(totalRows);
                }
            });

        }

        function viewpiformation(recordId) {
            var reference = '';
            var poid = 0;
            var path = '';
            var paidamount = 0.00;
            var popaidamount = 0.00;
            var remaining = 0.00;
            var poremaining = 0.00;
            $.ajax({
                type: "GET",
                url: "{{ url('purinvoinfo') }}/" + recordId,
                beforeSend: function() {
                    cardSection.block({
                        message: '<div class="d-flex justify-content-center align-items-center"><p class="mr-50 mb-50">Loading Please Wait...</p><div class="spinner-grow spinner-grow-sm text-white" role="status"></div> </div>',
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
                complete: function() {
                    cardSection.block({
                        message: '',
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
                success: function(response) {
                    paidamount = response.paidamount;
                    popaidamount = response.popaidamount;
                    $.each(response.supplier, function(index, value) {
                        $('#pivinfosuppid').html(value.Code);
                        $('#pivinfsupname').html(value.Name);
                        $('#pivinfosupptin').html(value.TinNumber);
                    });

                    $.each(response.payrninfo, function(index, value) {
                        switch (value.reference) {
                            case 'PO':
                                var links = '<b><u>' + value.porderno + '</u></b>';
                                var glinks = '<a href="#" onclick="infoviewpurchaseivoicehistory(' +
                                    value.poid + ');"><u><b>View GRV History</b></u></a>';
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
                        $('#pivinfoStatus').html('<span class="text-success font-weight-medium"><b> ' +
                            value.docno + ' Confirm</b>');
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
                        $('#pivinfodirectinfosubtotalLbl').html(numformat(value.subtotal));
                        $('#pivinfodirectinfotaxLbl').html(numformat(value.tax));
                        $('#pivinfodirectinfograndtotalLbl').html(numformat(value.grandtotal));
                        $('#pivinfodirectinfowitholdingAmntLbl').html(numformat(value.withold));
                        $('#pivinfodirectinfonetpayLbl').html(numformat(value.netpay));
                        $('.popayrinfopar').html(value.docno);
                        $('#payrinforemainamount').html(numformat(remaining.toFixed(2)));
                        var links = '<a href="#" onclick="infoviewpaymenthistory(' + value.poid +
                            ');"><u>View Payment History</u></a>';

                        $('#pivinfoviewpaymenthistory').html(links);
                        $('.paymentrequestinfopurpose').html(value.purpose);

                        $('#pivmentrequestinfomemo').html(value.memo);

                        reference = value.reference;
                        poid = value.poid;
                        path = value.path;

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
                                var text = "No Document Attached";
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

        function infoviewpurchaseivoicehistory(id) {
            var cname = $('#pivinfsupname').text() || 0;
            var tin = $('#pivinfosupptin').text() || 0;
            var customertile = cname + ' ' + tin;
            $('#paymentinvoicehistorystatus').html('History Of ' + customertile);
            $('#historpurchaseinvoicetables').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                fixedHeader: true,
                searchHighlight: true,
                destroy: true,
                paging: false,
                ordering: false,
                info: false,
                lengthMenu: [
                    [50, 100],
                    [50, 100]
                ],
                "pagingType": "simple",
                language: {
                    search: '',
                    searchPlaceholder: "Search here"
                },
                "dom": "<'row'<'col-lg-5 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-5'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
                ajax: {
                    url: "{{ url('pihistorypaymentrequestlist') }}/" + id,
                    type: 'GET',
                    beforeSend: function() {
                        cardSection.block({
                            message: '<div class="d-flex justify-content-center align-items-center"><p class="mr-50 mb-50">Loading Please Wait...</p><div class="spinner-grow spinner-grow-sm text-white" role="status"></div> </div>',
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
                    complete: function() {
                        cardSection.block({
                            message: '',
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
                columns: [{
                        data: 'DT_RowIndex'
                    },
                    {
                        data: 'grv',
                        name: 'grv',
                        'visible': true
                    },
                    {
                        data: 'piv',
                        name: 'piv'
                    },
                    {
                        data: 'invoicedate',
                        name: 'invoicedate'
                    },
                    {
                        data: 'paymentype',
                        name: 'paymentype'
                    },
                    {
                        data: 'invoicetype',
                        name: 'invoicetype'
                    },
                    {
                        data: 'mrc',
                        name: 'mrc'
                    },
                    {
                        data: 'voucherno',
                        name: 'voucherno'
                    },
                    {
                        data: 'invoiceno',
                        name: 'invoiceno'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },

                ],

                columnDefs: [

                    {
                        targets: 9,
                        render: function(data, type, row, meta) {
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
                    },
                ],
            });
        }

        function purchaseinvoiceviewdocuments(id) {
            $.ajax({
                type: "GET",
                url: "{{ url('downloadpaymentinvoice') }}/" + id,
                xhrFields: {
                    responseType: 'blob' // important for handling binary data
                },
                success: function(response) {
                    var blobUrl = URL.createObjectURL(response);
                    $('#purchaseinvoicepdfviewer').attr('src', blobUrl);
                },
                error: function(xhr) {

                    toastrMessage('error', 'An error occurred while loading the PDF.', 'Error!');
                }
            });
        }

        function setpurchaseinvoiceminilog(actions) {
            var list = '';
            var icons = ''
            var reason = '';
            var addedclass = '';
            $('#paymentinvoiceulist').empty();
            $.each(actions, function(index, value) {
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
                    case 'Confirmed':
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
                    case 'Refund':
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
                list += '<li class="timeline-item"><span class="timeline-point timeline-point-' + icons +
                    ' timeline-point-indicator"></span><div class="timeline-header mb-sm-0 mb-0"><h6 class="mb-0 ' +
                    addedclass + '">' + value.action +
                    '</h6><span class="text-muted"><i class="fa-regular fa-user"></i>' + value.user +
                    '</span></br><span class="text-muted"><i class="fa-regular fa-clock"></i> ' + value.time +
                    '</span>' + reason + '</div></li>';
            });
            $('#paymentinvoiceulist').append(list);
        }

        function showpurchaseinvloicecommodity(recordId) {
            var someCondition = true;
            var reference = $('#pivinforefernce').html();
            switch (reference) {
                case 'Direct':
                    someCondition = false;
                    break;

                default:
                    someCondition = true;
                    break;
            }
            var suptables = $('#pivtable').DataTable({
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
                order: [
                    [0, "desc"]
                ],
                language: {
                    search: '',
                    searchPlaceholder: "Search here"
                },
                "dom": "<'row'<'col-lg-5 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-5'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
                ajax: {
                    url: "{{ url('purcachaseinvloicecommoditylist') }}/" + recordId,
                    type: 'GET',
                },
                columns: [{
                        data: 'DT_RowIndex'
                    },
                    {
                        data: 'docno',
                        name: 'docno',
                        width: '11%',
                        visible: false
                    },
                    {
                        data: 'origin',
                        name: 'origin',
                        width: '15%'
                    },
                    {
                        data: 'grade',
                        name: 'grade'
                    },
                    {
                        data: 'proccesstype',
                        name: 'proccesstype'
                    },
                    {
                        data: 'cropyear',
                        name: 'cropyear'
                    },
                    {
                        data: 'uomname',
                        name: 'uomname'
                    },
                    {
                        data: 'nofbag',
                        name: 'nofbag',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'bagwieght',
                        name: 'bagwieght',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'totalkg',
                        name: 'totalkg',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'netkg',
                        name: 'netkg',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'ton',
                        name: 'ton',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'feresula',
                        name: 'feresula',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'price',
                        name: 'price',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'total',
                        name: 'total',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'recid',
                        name: 'recid',
                        visible: false
                    },
                    {
                        data: 'recid',
                        name: 'recid',
                        visible: true
                    },
                ],
                columnDefs: [{
                        targets: 1,
                        render: function(data, type, row, meta) {

                            return '<a href="#" onclick="viewrecievinginformation(' + row.recid +
                                ');"><u>' + data + '</u></a>';
                        }
                    },
                    {
                        targets: 16,
                        render: function(data, type, row, meta) {
                            return `
                                            <i class="info-icon fa fa-info-circle text-primary" 
                                            data-netkg="${row.netkg}" 
                                            data-totalprice="${row.total}" 
                                            title="Price Information">
                                            </i>
                                        `;
                        }
                    }
                ],
                rowGroup: {
                    startRender: function(rows, group, level) {
                        var color = '';
                        var gr = '--';
                        switch (someCondition) {
                            case true:
                                var reid = []
                                var groupedData = rows.data();
                                groupedData.each(function(rowData) {
                                    reid.push(rowData.recid); // Collect names
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
                                if (level === 0) {
                                    var grp = '<b><u>' + group + '</u></b>';
                                    return $('<tr ' + color + '/>')
                                        .append(
                                            '<th colspan="15" style="text-align:left;background:#ccc; font-size:12px;">' +
                                            grp + ' </th>')
                                } else {
                                    return $('<tr ' + color + '/>')
                                        .append(
                                            '<th colspan="5" style="text-align:left;border:1px solid;background:#f2f3f4;font-size:12px;">Customer: ' +
                                            group + '</th>')
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
                "footerCallback": function(row, data, start, end, display) {

                    var api = this.api();
                    // Helper function to parse integer from strings
                    var intVal = function(i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 : // Remove commas and convert to int
                            typeof i === 'number' ?
                            i : 0;
                    };

                    var totalbag = api
                        .column(7) // The column index where the numeric data is
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    var totalbagweiht = api
                        .column(8) // The column index where the numeric data is
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    var totalkg = api
                        .column(9) // The column index where the numeric data is
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    var totalnet = api
                        .column(10) // The column index where the numeric data is
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    var totalton = api
                        .column(11) // The column index where the numeric data is
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    var totalferesula = api
                        .column(12) // The column index where the numeric data is
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    var totalprice = api
                        .column(13) // The column index where the numeric data is
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    var totaltotal = api
                        .column(14) // The column index where the numeric data is
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    var numberendering = $.fn.dataTable.render.number(',', '.', 2, ).display;
                    $('#pinfonofbagtotal').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>" +
                        numberendering(totalbag) + "</h6>");
                    $('#pinfonofbagweighttotal').html(
                        "<h6 style='font-size:13px;color:black;font-weight:bold;'>" + numberendering(
                            totalbagweiht) + "</h6>");
                    $('#pinfonoftotalkgtotal').html(
                        "<h6 style='font-size:13px;color:black;font-weight:bold;'>" + numberendering(
                            totalkg) + "</h6>");
                    $('#pinfokgtotal').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>" +
                        numberendering(totalnet) + "</h6>");
                    $('#pinfotontotal').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>" +
                        numberendering(totalton) + "</h6>");
                    $('#pinfopriceferesula').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>" +
                        numberendering(totalferesula) + "</h6>");
                    $('#pinfopricetotal').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>" +
                        numberendering(totalprice) + "</h6>");
                    $('#pinfototalpricetotal').html(
                        "<h6 style='font-size:13px;color:black;font-weight:bold;'>" + numberendering(
                            totaltotal) + "</h6>");

                }
            });
        }

        function numformat(val) {
            while (/(\d+)(\d{3})/.test(val.toString())) {
                val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
            }
            return val;
        }
    </script>
@endsection
