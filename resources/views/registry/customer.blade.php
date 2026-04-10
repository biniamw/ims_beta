@extends('layout.app1')
@section('title')
@endsection
@section('content')
    <div class="app-content content">
        <section id="responsive-datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom">
                            <h3 class="card-title">Customer/Supplier</h3>
                            <ul class="nav nav-tabs" role="tablist">
                                @can('Customer-View')
                                    <li class="nav-item">
                                        <a class="nav-link active" id="customer-tab" data-toggle="tab" href="#customer"
                                            onclick="showcusbtn()" aria-controls="customer" role="tab"
                                            aria-selected="true">Customer</a>
                                    </li>
                                @endcan
                                @can('Blacklist-View')
                                    <li class="nav-item">
                                        <a class="nav-link" id="blacklist-tab" data-toggle="tab" href="#blacklist"
                                            onclick="showblbtn()" aria-controls="blacklist" role="tab"
                                            aria-selected="false">Blacklist</a>
                                    </li>
                                @endcan
                            </ul>
                            <div>
                                <div id="addbldiv" style="display: none;">
                                    @can('Blacklist-Add')
                                        <button id="blacklistaddbtn" type="button"
                                            class="btn btn-gradient-info btn-sm openBlForm" data-toggle="modal">Add</button>
                                    @endcan
                                </div>
                                @can('Customer-Add')
                                    <button id="customeraddbtn" type="button" class="btn btn-gradient-info btn-sm addcustomer"
                                        data-toggle="modal">Add</button>
                                @endcan
                            </div>
                        </div>
                        <div class="card-datatable">
                            <div class="tab-content">
                                @can('Customer-View')
                                    <div class="tab-pane active" id="customer" aria-labelledby="customer-tab" role="tabpanel">
                                        <div style="width:98%; margin-left:1%;">
                                            <div>
                                                <table id="laravel-datatable-crud" class="display table-bordered table-striped table-hover dt-responsive" style="width:100%;">
                                                    <thead>
                                                        <tr>
                                                            <th style="display: none;">Id</th>
                                                            <th>#</th>
                                                            <th>ID</th>
                                                            <th>Category</th>
                                                            <th>Name</th>
                                                            <th>TIN Number</th>
                                                            <th>MRC Number</th>
                                                            <th>VAT Number</th>
                                                            <th>Price Type</th>
                                                            <th>Phone Number</th>
                                                            <th>Status</th>
                                                            <th></th>
                                                            <th>Action</th>
                                                            <th></th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endcan
                                @can('Blacklist-View')
                                    <div class="tab-pane" id="blacklist" aria-labelledby="blacklist-tab" role="tabpanel">
                                        <div style="width:98%; margin-left:1%;">
                                            <div>
                                                <table id="datatable-crud-bl" class="display table-bordered table-striped table-hover dt-responsive" style="width:100%;">
                                                    <thead>
                                                        <tr>
                                                            <th style="display: none;">Id</th>
                                                            <th>ID</th>
                                                            <th>Name</th>
                                                            <th>Tin Number</th>
                                                            <th>Vat Number</th>
                                                            <th>Phone Number</th>
                                                            <th style="width:7%;">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!--Toast Start-->
    <div class="toast align-items-center text-white bg-primary border-0" id="myToast" role="alert" style="position: absolute; top: 2%; right: 40%; z-index: 7000; border-radius:15px;">
        <div class="toast-body">
            <strong id="toast-massages"></strong>
            <button type="button" class="ficon" data-feather="x" data-dismiss="toast">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
    <!--Toast End-->

    <!--Registration Modal -->
    <div class="modal fade" id="inlineForm" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel333">Register Customer</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onclick="closeModalWithClearValidation()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="Register">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <!-- Input Mask start -->
                        <section id="input-mask-wrapper">
                            <div class="col-md-12">
                                <div class="divider">
                                    <div class="divider-text">Basic Information</div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                        <label strong style="font-size: 14px;">Customer ID</label>
                                        <input type="text" placeholder="Customer Id" class="form-control" name="CustomerId" id="Code" onkeyup="cusCodeCV();"  autofocus/>
                                        <input type="hidden" class="form-control" readonly="true" name="codetypeinput"
                                            id="codetypeinput" />
                                        <span class="text-danger">
                                            <strong id="id-error"></strong>
                                        </span>
                                    </div>
                                    <div class="col-xl-3 col-md-6 col-sm-12 mb-2">
                                        <label strong style="font-size: 14px;">Customer Category</label>
                                        <div class="input-group input-group-merge">
                                            <select class="form-control" name="CustomerCategory" id="CustomerCategory" onchange="cusCatCV()" @can('Edit-Transactions') ondblclick="adjustprop(this);" @endcan/>
                                                <option value="Customer">Customer</option>
                                                <option value="Supplier">Supplier</option>
                                                <option value="Customer&Supplier">Customer&Supplier</option>
                                                <option value="Foreigner-Supplier">Foreigner-Supplier</option>
                                                <option value="Person">Person</option>
                                            </select>
                                        </div>
                                        <span class="text-danger">
                                            <strong id="cuscategory-error"></strong>
                                        </span>
                                    </div>
                                    <div class="col-xl-3 col-md-6 col-sm-12 mb-2">
                                        <label strong style="font-size: 14px;">Customer Name</label>
                                        <input type="hidden" placeholder="customerid" class="form-control" name="id" id="id" onkeyup="cusNameCV();" />
                                        <input type="text" placeholder="Customer Name" class="form-control" name="name" id="name" @can('Edit-Transactions') ondblclick="adjustprop(this);" @endcan onkeyup="cusNameCV();" />
                                        <span class="text-danger">
                                            <strong id="name-error"></strong>
                                        </span>
                                    </div>
                                    <div class="col-xl-2 col-md-6 col-sm-12 mb-2" id="tinDiv">
                                        <label strong style="font-size: 14px;">TIN</label>
                                        <input type="number" placeholder="TIN Number" class="form-control tinrestriction" name="TinNumber" id="TinNumber" onkeypress="return ValidateOnlyNum(event);" @can('Edit-Transactions') ondblclick="adjustprop(this);" @endcan onkeyup="countTinChar(this)" ondrop="return false;" onpaste="return false;" />
                                        <span class="text-danger">
                                            <strong id="tin-error"></strong>
                                        </span>
                                    </div>
                                    <div class="col-xl-2 col-md-6 col-sm-12 mb-2" id="mrcDiv">
                                        <label strong style="font-size: 14px;">MRC</label>
                                        <input type="text" placeholder="MRC Number" class="form-control" name="MrcNumber" id="MRCNumber" onkeypress="return ValidateMrc(event);" @can('Edit-Transactions') ondblclick="adjustprop(this);" @endcan onkeyup="countMrcChar(this)" ondrop="return false;" onpaste="return false;" />
                                        <span class="text-danger">
                                            <strong id="mrc-error"></strong>
                                        </span>
                                    </div>
                                </div>
                                <div class="row" style="display: none;" id="wholesalerulediv">
                                    <div class="col-xl-7 col-md-6 col-sm-12"></div>
                                    <div class="col-xl-5 col-md-6 col-sm-12" style="border-bottom-style: solid;border-bottom-color:rgba(34, 41, 47, 0.2);border-bottom-width: 1px;">
                                        <div style="text-align: center;">
                                            <label strong style="font-size: 16px;font-weight:bold;"><u>Wholesale Rule</u></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-2 col-md-6 col-sm-12 mb-2" id="vatRegDiv">
                                        <label strong style="font-size: 14px;">VAT Registration No.</label>
                                        <input type="number" placeholder="VAT Registration Number" class="form-control" name="VatNumber" id="VatNumber" onkeypress="return ValidateOnlyNum(event);" @can('Edit-Transactions') ondblclick="adjustprop(this);" @endcan onkeyup="cusVATCV();" ondrop="return false;" onpaste="return false;" />
                                        <span class="text-danger">
                                            <strong id="VatNumber-error"></strong>
                                        </span>
                                    </div>
                                    <div class="col-xl-1 col-md-6 col-sm-12 mb-2" id="vatDiv">
                                        <label strong style="font-size: 14px;">VAT Deduct</label>
                                        <div class="input-group input-group-merge">
                                            <select class="form-control" name="VatDeduct" id="VatType" onchange="cusVATDedCV()">
                                                @foreach ($vats as $vt)
                                                    <option value="{{ $vt->Value }}">{{ $vt->Name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <span class="text-danger">
                                            <strong id="VatDeduct-error"></strong>
                                        </span>
                                    </div>
                                    <div class="col-xl-2 col-md-6 col-sm-12 mb-2" id="withDiv">
                                        <label strong style="font-size: 14px;">Witholding Deduct</label>
                                        <div class="input-group input-group-merge">
                                            <select class="form-control" name="WitholdDeduct" id="Witholding" onchange="cusWithDedCV()">
                                                @foreach ($witholds as $wh)
                                                    <option value="{{ $wh->Value }}">{{ $wh->Name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <span class="text-danger">
                                            <strong id="WitholdDeduct-error"></strong>
                                        </span>
                                    </div>
                                    @can('Customer-Adjust-Default-Price')
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2" id="defpaymentDiv">
                                            <label strong style="font-size: 14px;">Price Type</label>
                                            <div>
                                                <select class="form-control" data-style="btn btn-outline-secondary waves-effect" name="DefaultPayment" id="DefaultPrice" onchange="cusDefPayCV()">
                                                    <option value="Retailer">Retail</option>
                                                    <option value="Wholeseller">Wholesale</option>
                                                </select>
                                            </div>
                                            <span class="text-danger">
                                                <strong id="defaultpayment-error"></strong>
                                            </span>
                                        </div>
                                    @endcan
                                    <div class="col-xl-2 col-md-6 col-sm-12 mb-2" id="minpurchasediv" style="display: none;border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                        <label strong style="font-size: 14px;">First Purchase Amount</label>&nbsp<label strong style="font-size: 14px;" title="When a customer makes their first purchase, set a minimum purchase amount that must be meet in order to unlock a wholesale price."><i class="fa fa-info" aria-hidden="true"></i></label>
                                        <input type="number" placeholder="First Purchase Amount" class="form-control" name="MinimumPurchaseAmount" id="MinimumPurchaseAmount" onkeypress="return ValidateOnlyNum(event);" onkeyup="minPurAmount();" ondblclick="minpurdbl()" readonly="true" ondrop="return false;" onpaste="return false;" />
                                        <span class="text-danger">
                                            <strong id="minpuramount-error"></strong>
                                        </span>
                                    </div>
                                    <div class="col-xl-1 col-md-6 col-sm-12 mb-2 creditLimitPeriodDiv" style="display:none;">
                                        <label strong style="font-size: 14px;">Days/ Period</label>&nbsp<label strong style="font-size: 14px;" title="Set a day for the customer's purchases of the specified amount over the specified number of days."><i class="fa fa-info" aria-hidden="true"></i></label>
                                        
                                            <input type="number" placeholder="Input days" class="form-control" value="0"
                                                name="CreditLimitPeriod" id="CreditLimitPeriod"
                                                onkeyup="creditLimitPeriodVal()" onkeypress="return ValidateOnlyNum(event);"
                                                ondrop="return false;" onpaste="return false;" readonly="true"
                                                ondblclick="crPerLimitVal()" />
                                       
                                         <span class="text-danger">
                                                <strong id="creditlimitperiod-error"></strong>
                                            </span>
                                    </div>
                                    <div class="col-xl-2 col-md-6 col-sm-12 mb-2 creditLimitPeriodDiv" style="display:none;">  
                                        <label strong style="font-size: 14px;">Days/ Period Amount</label>&nbsp<label strong style="font-size: 14px;" title="The customer must purchase provided amount within a given day/period in order to continue being a wholesale customer."><i class="fa fa-info" aria-hidden="true"></i></label>
                                        <input type="number" placeholder="Credit Limit" class="form-control" value="0"
                                                name="CreditLimit" id="CreditLimit" onkeyup="creditLimitVal()"
                                                onkeypress="return ValidateNum(event);" ondrop="return false;"
                                                onpaste="return false;" readonly="true" ondblclick="crLimitVal()" />
                                            <span class="text-danger">
                                                <strong id="creditlimit-error"></strong>
                                            </span>
                                    </div>
                                    <div class="col-xl-0 col-md-6 col-sm-12 mb-2" id="creditLimitDiv" style="display:none;"></div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-2 col-md-6 col-sm-12 mb-2" id="allowedcrsales">
                                        <label strong style="font-size: 14px;">Credit Sales</label>
                                        <div>
                                            <select class="form-control" data-style="btn btn-outline-secondary waves-effect" name="IsAllowedCreditSales" id="IsAllowedCreditSales">
                                                <option selected value="Not-Allowed">Not-Allow</option>
                                                @can('Change-Credit-Sales-Option')<option value="Allow">Allow</option>@endcan
                                            </select>
                                        </div>
                                        <span class="text-danger">
                                            <strong id="allowedcreditsales-error"></strong>
                                        </span>
                                    </div>
                                    <div class="col-xl-2 col-md-6 col-sm-12 mb-2 creditprop" style="display: none;">
                                        <label strong style="font-size: 14px;">Credit Sales Min Amount</label>
                                        <div>
                                            <input type="number" placeholder="" class="form-control crdprop" name="CreditSalesLimitStart" id="CreditSalesLimitStart" onkeyup="creditlimitstart()" onkeypress="return ValidateOnlyNum(event);" ondblclick="credminval()"/>
                                            <span class="text-danger">
                                                <strong id="creditlimitstart-error"></strong>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-md-6 col-sm-12 mb-2 creditprop" style="display: none;" ondblclick="unlimiteddblcl()">
                                        <label strong style="font-size: 14px;">Credit Sales Max Amount</label>
                                        <div>
                                            <input type="number" placeholder="" class="form-control crdprop" name="CreditSalesLimitEnd" id="CreditSalesLimitEnd" onkeyup="creditlimitend()" onkeypress="return ValidateOnlyNum(event);" ondblclick="credmaxval()"/>
                                            <span>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <input class="unlimitcreditslcbx" name="unlimitcreditslcbx" type="checkbox" id="unlimitcreditslcbx"/>
                                                        <label class="col-form-label" for="unlimitcreditslcbx" style="font-size: 11px;">Unlimit credit sales</label>
                                                    </div>
                                                </div>
                                                <strong class="text-danger" id="creditlimitend-error"></strong>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-md-6 col-sm-12 mb-2 creditprop" style="display: none;">
                                        <label strong style="font-size: 14px;">Credit Sales Payment Term</label>
                                        <div>
                                            <input type="number" placeholder="" class="form-control crdprop" name="CreditSalesLimitDay" id="CreditSalesLimitDay" onkeyup="creditslimitval()" onkeypress="return ValidateOnlyNum(event);" ondblclick="credlimitdayval()"/>
                                            <span class="text-danger">
                                                <strong id="creditslimit-error"></strong>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-md-6 col-sm-12 mb-2 creditprop" style="display: none;">
                                        <label strong style="font-size: 14px;">Credit Sales Additional %</label>
                                        <div>
                                            <input type="number" placeholder="" class="form-control crdprop" name="CreditSalesAdditionPercentage" id="CreditSalesAdditionPercentage" onkeyup="creditsalesaddval()" onkeypress="return ValidateOnlyNum(event);" ondblclick="credsalesperval()"/>
                                            <span class="text-danger">
                                                <strong id="creditsalesadd-error"></strong>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-md-6 col-sm-12 mb-2 creditprop" style="display: none;" ondblclick="settdblval()">
                                        <label strong style="font-size:14px;" for="settleallouts">Settle All Previous Outstanding for New Credit Sales</label>
                                        <div>
                                            <div id="settlecbxdiv">
                                                <input name="settleallouts" id="settleallouts" type="checkbox" readonly="readonly" ondblclick="settdblval()"/>
                                            </div>
                                            <span class="text-danger">
                                                <strong id="isprevioussalespaid-error"></strong>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="divider">
                                    <div class="divider-text">Address Information & Other Information</div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                        <label strong style="font-size: 14px;">Phone Number</label>
                                        <input type="text" placeholder="Phone or Mobile Number" class="form-control"
                                            name="PhoneNumber" id="PhoneNumber" onkeypress="return ValidatePhone(event);"
                                            onkeyup="cusPhoneCV()" />
                                        <span class="text-danger">
                                            <strong id="PhoneNumber-error"></strong>
                                        </span>
                                    </div>
                                    <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                        <label strong style="font-size: 14px;">Office Phone No.</label>
                                        <input type="text" placeholder="Office Phone Number" class="form-control"
                                            name="OfficePhoneNumber" id="OfficePhone"
                                            onkeypress="return ValidatePhone(event);" onkeyup="cusOffPhoneCV()" />
                                        <span class="text-danger">
                                            <strong id="OfficePhoneNumber-error"></strong>
                                        </span>
                                    </div>
                                    <div class="col-xl-3 col-md-6 col-sm-12 mb-2">
                                        <label strong style="font-size: 14px;">Email</label>
                                        <input type="text" placeholder="Email Address" class="form-control"
                                            name="EmailAddress" id="EmailAddress" onkeyup="ValidateEmail(this);" />
                                        <span class="text-danger">
                                            <strong id="email-error"></strong>
                                        </span>
                                    </div>
                                    <div class="col-xl-3 col-md-6 col-sm-12 mb-2">
                                        <label strong style="font-size: 14px;">Address</label>
                                        <input type="text" placeholder="Address" class="form-control" name="Address"
                                            id="Address" onkeyup="cusAddressv()" />
                                        <span class="text-danger">
                                            <strong id="Address-error"></strong>
                                        </span>
                                    </div>
                                    <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                        <label strong style="font-size: 14px;">Website</label>
                                        <input type="text" placeholder="Website" class="form-control" name="Website"
                                            id="Website" onkeyup="ValidateWebsite(this);" />
                                        <span class="text-danger">
                                            <strong id="Website-error"></strong>
                                        </span>
                                    </div>
                                    <div class="col-xl-3 col-md-6 col-sm-12 mb-2">
                                        <label strong style="font-size: 14px;">Country</label>
                                        <div>
                                            <select class="select2 form-control" name="Country"
                                                id="Country" onchange="cusCountryVC()">
                                                @foreach ($counrtys as $cn)
                                                    <option value="{{ $cn->Name }}">{{ $cn->Name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <span class="text-danger">
                                            <strong id="Country-error"></strong>
                                        </span>
                                    </div>
                                    <div class="col-xl-3 col-md-6 col-sm-12 mb-2">
                                        <label strong style="font-size: 14px;">Memo</label>
                                        <textarea type="text" placeholder="Write Memo here..." class="form-control"
                                            rows="1" name="Memo" id="Memo" onkeyup="cusMemoV()"></textarea>
                                        <span class="text-danger">
                                            <strong id="Memo-error"></strong>
                                        </span>
                                    </div>
                                    <div class="col-xl-3 col-md-6 col-sm-12 mb-2">
                                        <label strong style="font-size: 14px;">Status</label>
                                        <div class="input-group input-group-merge">
                                            <select class="form-control" name="CustomerStatus" id="ActiveStatus"
                                                aria-errormessage="Select Status" onchange="customerstatusCV()">
                                                <option value="Active">Active</option>
                                                <option value="Inactive">Inactive</option>
                                                <option value="Block">Block</option>
                                            </select>
                                        </div>
                                        <span class="text-danger">
                                            <strong id="status-error"></strong>
                                        </span>
                                    </div>
                                    <div class="col-xl-3 col-md-6 col-sm-12 mb-2" id="ReasonDiv">
                                        <label strong style="font-size: 14px;">Reason</label>
                                        <textarea type="text" placeholder="Write Reason here..." class="form-control"
                                            rows="1" name="Reason" id="Reason" onkeyup="cusReasonV()"></textarea>
                                        <span class="text-danger">
                                            <strong id="Reason-error"></strong>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!--  -->
                    <div class="modal-footer">
                        <input type="hidden" placeholder="" class="form-control" name="iswholesalebef" id="iswholesalebef"/>
                        <input type="hidden" placeholder="" class="form-control" name="unlimitflag" id="unlimitflag"/>
                        <input type="hidden" placeholder="" class="form-control" name="operationType" id="operationType" value="0" />
                        <input type="hidden" placeholder="" class="form-control" name="dprice" id="dprice" value="Retailer" />
                        @can('Customer-Edit')
                            <button id="updatecustomer" type="button" class="btn btn-info">Update</button>
                        @endcan
                        @can('Customer-Add')
                            <button id="savenewbutton" type="button" class="btn btn-info">Save & New</button>
                            <button id="savebutton" type="button" class="btn btn-info">Save & Close</button>
                        @endcan
                        <button id="closebuttona" type="button" class="btn btn-danger" onclick="closeModalWithClearValidation()" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End Registation Modal -->

    <!--Start Customer delete modal -->
    <div class="modal fade text-left" id="examplemodal-cusdelete" data-keyboard="false" data-backdrop="static"
        tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onclick="closeModalWithClearValidation()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="deletform">
                    @csrf
                    <div class="modal-body">
                        <label strong style="font-size: 16px;">Are you sure you want to delete</label>
                        <div class="form-group">
                            <input type="hidden" placeholder="id" class="form-control" name="id" id="custid">
                            <span class="text-danger">
                                <strong id="uname-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="deletecustomerbtn" type="button" class="btn btn-info">Delete</button>
                        <button id="closebuttonb" type="button" class="btn btn-danger"
                            onclick="closeModalWithClearValidation()" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Customer delete Modal -->

    <!--Start MRC Registration Modal -->
    <div class="modal fade text-left" id="MRCRegModal" data-keyboard="false" data-backdrop="static" tabindex="-1"
        role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y:scroll;">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="addmrcmodaltxt">Register MRC <strong id="st-name"></strong></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onclick="closeModalWithClearValidation()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="MRCRegister">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="card-body">
                            <!-- Accordion with margin start -->
                            <section id="accordion-with-margin">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="card collapse-icon">
                                            <div class="card-body">
                                                <div class="collapse-margin" id="accordionExample">
                                                    <div class="card-header" id="headingOne" data-toggle="collapse"
                                                        role="button" onclick="addMRC()" data-target="#collapseOne"
                                                        aria-expanded="false" aria-controls="collapseOne">
                                                        <span class="lead collapse-title" onclick="addMRC()"> Add MRC
                                                        </span>
                                                    </div>
                                                    <div id="collapseOne" class="collapse"
                                                        aria-labelledby="headingOne" data-parent="#accordionExample">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-xl-4 col-md-6 col-sm-12 mb-2">
                                                                    <label strong style="font-size: 16px;">MRC No.</label>
                                                                    <input type="hidden" id="customerid"
                                                                        class="form-control" name="customerid" />
                                                                    <input type="text" id="MrcNumber"
                                                                        placeholder="MRC Number"
                                                                        class="form-control AddMrcNum" name="MrcNumber"
                                                                        onkeypress="cusNameCV()"
                                                                        onkeyup="countAddMrcChar(this)"
                                                                        ondrop="return false;" onpaste="return false;"
                                                                        autofocus />
                                                                    <span class="text-danger" style="height:10px;">
                                                                        <strong id="mname-error"></strong>
                                                                    </span>
                                                                </div>
                                                                <div class="col-xl-4 col-md-6 col-sm-12 mb-2">
                                                                    <label strong style="font-size: 16px;">Status</label>
                                                                    <div class="invoice-customer">
                                                                        <select class="invoiceto form-control"
                                                                            name="status" id="lstatus">
                                                                            <option value="Active">Active</option>
                                                                            <option value="Inactive">Inactive</option>
                                                                        </select>
                                                                        <span class="text-danger">
                                                                            <strong id="mstatus-error"></strong>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-4 col-md-6 col-sm-12 mb-2">
                                                                    <label strong style="font-size: 16px;"></label>
                                                                    <div>
                                                                        <button id="savemrcbtn" type="button"
                                                                            class="btn btn-info">Add MRC</button>
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
                            <!-- Accordion with margin end -->
                        </div>
                        <div class="table-responsive">
                            <table id="laravel-datatable-crud-mrc" class="display table-bordered table-striped table-hover dt-responsive" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th style="width: 0%;">Id</th>
                                        <th style="width: 0%;">CustomerId</th>
                                        <th style="width: 45%;">MRC Number</th>
                                        <th style="width: 35%;">Status</th>
                                        <th style="width: 15%;">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button id="closebuttonc" type="button" class="btn btn-danger"
                            onclick="closeModalWithClearValidation()" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End MRC Registation Modal -->

    <!--- Start MRC Update Modal -->
    <div class="modal fade text-left" id="examplemodal-mrcedit" data-keyboard="false" data-backdrop="static" tabindex="-1"
        role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Edit MRC Informatoin</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onclick="closeMrcEditModalWithClearValidation()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="updatemrcform">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <label strong style="font-size: 16px;">MRC No.</label>
                        <div class="form-group">
                            <input type="hidden" placeholder="id" class="form-control" name="id" id="id">
                            <input type="hidden" placeholder="id" class="form-control" name="cusids" id="cusids">
                            <input type="text" placeholder="MRC Number" class="form-control" name="mrcnumber"
                                id="mrcnumber" onkeypress="removeMrcNameValidation()" onkeyup="countAddEdMrcChar(this)"
                                ondrop="return false;" onpaste="return false;" />
                            <span class="text-danger">
                                <strong id="muname-error"></strong>
                            </span>
                        </div>
                        <label strong style="font-size: 16px;">Status</label>
                        <div class="form-group">
                            <div class="invoice-customer">
                                <select class="invoiceto form-control" name="status" id="status">
                                    <option value="" disabled selected>Select Status</option>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                                <span class="text-danger">
                                    <strong id="mustatus-error"></strong>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="updatemrcbutton" type="button" class="btn btn-info">Update</button>
                        <button id="closebuttond" type="button" class="btn btn-danger"
                            onclick="closemrcEditModalWithClearValidation()" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End MRC Update Modal -->

    <!--Start MRC Delete modal -->
    <div class="modal fade text-left" id="examplemodal-mrcdelete" data-keyboard="false" data-backdrop="static"
        tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="deletemrcform">
                    <div class="modal-body">
                        <label strong style="font-size: 16px;">Are you sure you want to delete</label>
                        <div class="form-group">
                            <input type="hidden" placeholder="id" class="form-control" name="cid" id="cid">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="deleteMrcbtn" type="button" class="btn btn-info">Delete</button>
                        <button id="closebuttonh" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End MRC Delete Modal -->

    <!--Start Blacklist Registration Modal -->
    <div class="modal fade" id="blacklistInlineForm" data-keyboard="false" data-backdrop="static" tabindex="-1"
        role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel334">Register Blacklist</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onclick="closeModalWithClearValidation()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="BlacklistRegister">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <!-- Input Mask start -->
                        <section id="input-mask-wrapper">
                            <div class="col-md-12">
                                <div class="divider">
                                    <div class="divider-text">Basic Information</div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-3 col-md-6 col-sm-12 mb-2">
                                        <label strong style="font-size: 14px;">Name</label>
                                        <button id="searchCustomeropen" type="button"
                                            class="btn btn-icon btn-icon rounded-circle btn-flat-success btn-sm"
                                            onclick="OpenSearchCustomer()"><i data-feather='search'></i></button>
                                        <button id="searchCustomerclose" type="button"
                                            class="btn btn-icon btn-icon rounded-circle btn-flat-danger btn-sm"
                                            onclick="CloseSearchCustomer()"><i data-feather='search'></i></button>
                                        <input type="hidden" placeholder="customerid" class="form-control" name="id"
                                            id="blid" />
                                        <input type="text" placeholder="Customer Name" class="form-control" name="name"
                                            id="blname" onkeyup="cusNameCV();" autofocus />
                                        <div id="SearchCusNameDiv">
                                            <select name="CustomerName" id="blNameSearch" class="form-control">
                                                <option value=""></option>
                                            </select>
                                        </div>
                                        <span class="text-danger">
                                            <strong id="blname-error"></strong>
                                        </span>
                                    </div>
                                    <div class="col-xl-3 col-md-6 col-sm-12 mb-2">
                                        <label strong style="font-size: 14px;">Customer ID</label>
                                        <input type="text" placeholder="Customer Id" class="form-control"
                                            name="CustomerId" id="blcode" onkeyup="cusCodeCV();" />
                                        <span class="text-danger">
                                            <strong id="blid-error"></strong>
                                        </span>
                                    </div>
                                    <div class="col-xl-3 col-md-6 col-sm-12 mb-2" id="tinDiv">
                                        <label strong style="font-size: 14px;">TIN</label>
                                        <input type="number" placeholder="TIN Number" class="form-control"
                                            name="TinNumber" id="BlTinNumber" onkeypress="return ValidateOnlyNum(event);"
                                            onkeyup="countTinChar(this)" ondrop="return false;" onpaste="return false;" />
                                        <span class="text-danger">
                                            <strong id="bltin-error"></strong>
                                        </span>
                                    </div>
                                    <div class="col-xl-3 col-md-6 col-sm-12 mb-2" id="vatRegDiv">
                                        <label strong style="font-size: 14px;">VAT Registration No.</label>
                                        <input type="number" placeholder="VAT Registration Number" class="form-control"
                                            name="VatNumber" id="blVatNumber" onkeypress="return ValidateOnlyNum(event);"
                                            onkeyup="cusVATCV();" ondrop="return false;" onpaste="return false;" />
                                        <span class="text-danger">
                                            <strong id="blVatNumber-error"></strong>
                                        </span>
                                    </div>
                                </div>
                                <div class="divider">
                                    <div class="divider-text">Address Information & Other Information</div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                        <label strong style="font-size: 14px;">Phone Number</label>
                                        <input type="text" placeholder="Phone or Mobile Number" class="form-control"
                                            name="PhoneNumber" id="blPhoneNumber" onkeypress="return ValidatePhone(event);"
                                            onkeyup="cusPhoneCV()" />
                                        <span class="text-danger">
                                            <strong id="blPhoneNumber-error"></strong>
                                        </span>
                                    </div>
                                    <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                        <label strong style="font-size: 14px;">Office Phone Number</label>
                                        <input type="text" placeholder="Office Phone Number" class="form-control"
                                            name="OfficePhoneNumber" id="blOfficePhone"
                                            onkeypress="return ValidatePhone(event);" onkeyup="cusOffPhoneCV()" />
                                        <span class="text-danger">
                                            <strong id="blOfficePhoneNumber-error"></strong>
                                        </span>
                                    </div>
                                    <div class="col-xl-4 col-md-6 col-sm-12 mb-2">
                                        <label strong style="font-size: 14px;">Email</label>
                                        <input type="text" placeholder="Email Address" class="form-control"
                                            name="EmailAddress" id="blEmailAddress" onkeyup="ValidateBlEmail(this);" />
                                        <span class="text-danger">
                                            <strong id="blemail-error"></strong>
                                        </span>
                                    </div>
                                    <div class="col-xl-4 col-md-6 col-sm-12 mb-2">
                                        <label strong style="font-size: 14px;">Address</label>
                                        <input type="text" placeholder="Address" class="form-control" name="Address"
                                            id="blAddress" onkeyup="cusAddressv()" />
                                        <span class="text-danger">
                                            <strong id="blAddress-error"></strong>
                                        </span>
                                    </div>
                                    <div class="col-xl-4 col-md-6 col-sm-12 mb-2">
                                        <label strong style="font-size: 14px;">Website</label>
                                        <input type="text" placeholder="Website" class="form-control" name="Website"
                                            id="blWebsite" onkeyup="ValidateBlWebsite(this);" />
                                        <span class="text-danger">
                                            <strong id="blWebsite-error"></strong>
                                        </span>
                                    </div>
                                    <div class="col-xl-4 col-md-6 col-sm-12 mb-2">
                                        <label strong style="font-size: 14px;">Country</label>
                                        <div>
                                            <select class="select2 form-control" name="Country" id="blCountry"
                                                onchange="cusCountryVC()">
                                                @foreach ($counrtys as $cn)
                                                    <option value="{{ $cn->Name }}">{{ $cn->Name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <span class="text-danger">
                                            <strong id="blCountry-error"></strong>
                                        </span>
                                    </div>
                                    <div class="col-xl-4 col-md-6 col-sm-12 mb-2">
                                        <label strong style="font-size: 14px;">Memo</label>
                                        <textarea type="text" placeholder="Write Memo here..." class="form-control"
                                            rows="3" name="Memo" id="blMemo" onkeyup="cusMemoV()"></textarea>
                                        <span class="text-danger">
                                            <strong id="blMemo-error"></strong>
                                        </span>
                                    </div>
                                </div>

                                <div class="row">

                                </div>
                            </div>
                    </div>
                    </section>
                    <!--  -->
                    <div class="modal-footer">
                        @can('Blacklist-Edit')
                            <button id="updateblcustomer" type="button" class="btn btn-info">Update</button>
                        @endcan
                        @can('Blacklist-Add')
                            <button id="savenewblbutton" type="button" class="btn btn-info">Save & New</button>
                            <button id="saveblbutton" type="button" class="btn btn-info">Save & Close</button>
                        @endcan
                        <button id="closeblbutton" type="button" class="btn btn-danger"
                            onclick="closeModalWithClearValidation()" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End Registation Modal -->

    <!--Start Blacklist delete modal -->
    <div class="modal fade text-left" id="examplemodal-bldelete" data-keyboard="false" data-backdrop="static" tabindex="-1"
        role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onclick="closeModalWithClearValidation()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="deleteBlacklistForm">
                    @csrf
                    <div class="modal-body">
                        <label strong style="font-size: 16px;">Are you sure you want to delete</label>
                        <div class="form-group">
                            <input type="hidden" placeholder="id" class="form-control" name="id" id="blcustid">
                            <input type="hidden" placeholder="id" class="form-control" name="name" id="bldelcustname">
                            <span class="text-danger">
                                <strong id="uname-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="deleteblbtn" type="button" class="btn btn-info">Delete</button>
                        <button id="closebuttonf" type="button" class="btn btn-danger"
                            onclick="closeModalWithClearValidation()" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Blacklist delete Modal -->

    <!--Start Info Modal -->
    <div class="modal fade text-left" id="cusInfoModal" data-keyboard="false" data-backdrop="static" tabindex="-1"
        role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Customer Information</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="cusInfoform">
                    @csrf
                    <div class="modal-body">
                        <div class="col-xl-12">
                            <div class="row">
                                <div class="col-xl-5 col-md-6 col-sm-12 mb-2">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="card-title">Basic Information</h6>
                                            <div class="heading-elements">
                                                <ul class="list-inline mb-0">
                                                    <li>
                                                        <a data-action="collapse"><i data-feather="chevron-down"></i></a>
                                                    </li>
                                                    <li>
                                                        <a data-action="reload"><i data-feather="rotate-cw"></i></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="card-content collapse show">
                                            <div class="card-body">
                                                <div class="table-responsive scroll scrdiv">
                                                    <table>
                                                        <tr>
                                                            <td style="width: 40%"><label strong style="font-size: 14px;">ID</label></td>
                                                            <td style="width: 60%"><label id="cusinfoId" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label strong style="font-size: 14px;">Name</label></td>
                                                            <td><label id="cusinfoName" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label strong style="font-size: 14px;">Customer
                                                                    Category</label></td>
                                                            <td><label id="cusinfocustomercategory" strong
                                                                    style="font-size: 14px;font-weight:bold;"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label strong style="font-size: 14px;">Price Type</label>
                                                            </td>
                                                            <td><label id="cusinfodefaultpayment" strong
                                                                    style="font-size: 14px;font-weight:bold;"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label strong style="font-size: 14px;">TIN Number</label>
                                                            </td>
                                                            <td><label id="cusinfotinno" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label strong style="font-size: 14px;">VAT Number</label>
                                                            </td>
                                                            <td><label id="cusinfovatno" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label strong style="font-size: 14px;">VAT (%)</label></td>
                                                            <td><label id="cusinfovatp" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label strong style="font-size: 14px;">Witholding (%)</label></td>
                                                            <td><label id="cusinfowitholdp" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label strong style="font-size: 14px;">First Purchase Amount</label>&nbsp;<label strong="" style="font-size: 14px;" title="When a customer makes their first purchase, set a minimum purchase amount that must be meet in order to unlock a wholesale price."><i class="fa fa-info" aria-hidden="true"></i></label></td>
                                                            <td><label id="cusinfocreditamount" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label strong style="font-size: 14px;">Days/ Period</label>&nbsp;<label strong="" style="font-size: 14px;" title="Set a day for the customer's purchases of the specified amount over the specified number of days."><i class="fa fa-info" aria-hidden="true"></i></label></td>
                                                            <td><label id="cusinfocreditlimitper" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label strong style="font-size: 14px;">Days/ Period Amount</label>&nbsp;<label strong="" style="font-size: 14px;" title="The customer must purchase provided amount within a given day/period in order to continue being a wholesale customer."><i class="fa fa-info" aria-hidden="true"></i></label></td>
                                                            <td><label id="cusinfocreditlimit" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                        </tr>
                                                        
                                                        <tr id="isallowedcrinfo">
                                                            <td><label strong style="font-size: 14px;">Credit Sales</label></td>
                                                            <td><label id="isallowedcrinfolbl" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                        </tr>
                                                        <tr class="crpropinfo">
                                                            <td><label strong style="font-size: 14px;">Credit Sales Min Amount</label></td>
                                                            <td><label id="creditminsalesinfo" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                        </tr>
                                                        <tr class="crpropinfo">
                                                            <td><label strong style="font-size: 14px;">Credit Sales Max Amount</label></td>
                                                            <td><label id="creditmaxsalesinfo" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                        </tr>
                                                        <tr class="crpropinfo">
                                                            <td><label strong style="font-size: 14px;">Credit Sales Payment Term</label></td>
                                                            <td><label id="creditsaleslimitdayinfo" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                        </tr>
                                                        <tr class="crpropinfo">
                                                            <td><label strong style="font-size: 14px;">Credit Sales Additional %</label></td>
                                                            <td><label id="creditsalesadditioninfo" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                        </tr>
                                                        <tr class="crpropinfo">
                                                            <td><label strong style="font-size: 14px;">Settle Outstanding for Credit Sales</label></td>
                                                            <td><label id="settleoutstandinginfo" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                        </tr>
                                                        <tr id="totalsalesondemisstr">
                                                            <td><label strong style="font-size: 14px;">Sales in 180 days on Demiss</label></td>
                                                            <td><label id="totalsalesondemiss" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                        </tr>
                                                        
                                                        <tr id="totalsalesongohtr">
                                                            <td><label strong style="font-size: 14px;">Sales in 180 days on Goh</label></td>
                                                            <td><label id="totalsalesongoh" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6 col-sm-12 mb-2">
                                    <div class="row">
                                        <div class="col-xl-12 col-md-6 col-sm-12 mb-2">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h6 class="card-title">Address Info & Other Info</h6>
                                                    <div class="heading-elements">
                                                        <ul class="list-inline mb-0">
                                                            <li>
                                                                <a data-action="collapse"><i data-feather="chevron-down"></i></a>
                                                            </li>
                                                            <li>
                                                                <a data-action="reload"><i data-feather="rotate-cw"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="card-content collapse show">
                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table>
                                                                <tr>
                                                                    <td><label strong style="font-size: 14px;">Phone Number</label>
                                                                    </td>
                                                                    <td><label id="cusinfophoneno" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label strong style="font-size: 14px;">Office Phone</label>
                                                                    </td>
                                                                    <td><label id="cusinfoofficephoneno" strong
                                                                            style="font-size: 14px;font-weight:bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label strong style="font-size: 14px;">Email Address</label>
                                                                    </td>
                                                                    <td><label id="cusinfoemailaddress" strong
                                                                            style="font-size: 14px;font-weight:bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label strong style="font-size: 14px;">Address</label></td>
                                                                    <td><label id="cusinfoaddress" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label strong style="font-size: 14px;">Website</label></td>
                                                                    <td><label id="cusinfowebsite" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label strong style="font-size: 14px;">Country</label></td>
                                                                    <td><label id="cusinfocountry" strong style="font-size: 14px;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label strong style="font-size: 14px;">Status</label></td>
                                                                    <td><label id="cusinfostatus" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-12 col-md-6 col-sm-12 mb-2" id="creditsalesinfodiv">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h6 class="card-title">Credit Sales Info</h6>
                                                    <div class="heading-elements">
                                                        <ul class="list-inline mb-0">
                                                            <li>
                                                                <a data-action="collapse"><i data-feather="chevron-down"></i></a>
                                                            </li>
                                                            <li>
                                                                <a data-action="reload" onclick="refreshcrsales()"><i data-feather="rotate-cw"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="card-content collapse show">
                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table>
                                                                <tr>
                                                                    <td style="width: 72%"><label strong style="font-size: 14px;">Credit Sales (Net Pay)</label></td>
                                                                    <td style="width: 28%"><label id="creditsalesnetpay" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label strong style="font-size: 14px;">Settled Amount</label></td>
                                                                    <td><label id="settledamountlbl" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label strong style="font-size: 14px;">Outstanding Amount</label></td>
                                                                    <td><label id="outstandinglbl" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label strong style="font-size: 14px;">Remaining Amount for Credit Sales</label></td>
                                                                    <td><label id="remainigamountlbl" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6 col-sm-12 mb-2">
                                    <div class="row">
                                        <div class="col-xl-12 col-md-6 col-sm-12 mb-2">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h6 class="card-title">MRC Numbers</h6>
                                                    <div class="heading-elements">
                                                        <ul class="list-inline mb-0">
                                                            <li>
                                                                <a data-action="collapse"><i data-feather="chevron-down"></i></a>
                                                            </li>
                                                            <li>
                                                                <a data-action="reload"><i data-feather="rotate-cw"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="card-content collapse show">
                                                    <div class="card-body">
                                                        <div class="text-center">
                                                            <table id="cusinfodetail"
                                                                class="display table-bordered table-striped table-hover dt-responsive" style="width: 100%">
                                                                <thead>
                                                                    <th>MRC Numbers</th>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="display: none;">
                                        <div class="col-xl-12 col-md-6 col-sm-12 mb-2">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h6 class="card-title">Action Info</h6>
                                                    <div class="heading-elements">
                                                        <ul class="list-inline mb-0">
                                                            <li>
                                                                <a data-action="collapse"><i data-feather="chevron-down"></i></a>
                                                            </li>
                                                            <li>
                                                                <a data-action="reload"><i data-feather="rotate-cw"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="card-content collapse show">
                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table>
                                                                <tr>
                                                                    <td><label strong style="font-size: 14px;">Created By</label></td>
                                                                    <td><label id="createdbylbl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label strong style="font-size: 14px;">Created Date</label></td>
                                                                    <td><label id="createddatelbl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label strong style="font-size: 14px;">Last Edited By</label></td>
                                                                    <td><label id="lasteditedbylbl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label strong style="font-size: 14px;">Last Edited Date</label></td>
                                                                    <td><label id="lastediteddatelbl" strong style="font-size:14px;font-weight:bold;"></label></td>
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
                    <div class="modal-footer">
                        <button id="closebuttone" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Info -->

    <!--Start Info Modal -->
    <div class="modal fade text-left" id="blInfoModal" data-keyboard="false" data-backdrop="static" tabindex="-1"
        role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Black List Info</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="blInfoform">
                    @csrf
                    <div class="modal-body">
                        <div class="col-xl-12">
                            <div class="row">
                                <div class="col-xl-4 col-md-6 col-sm-12 mb-2">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="card-title">Basic Information</h6>
                                            <a data-action="reload"><i data-feather="rotate-cw"></i></a>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table>
                                                    <tr>
                                                        <td><label strong style="font-size: 14px;">ID</label></td>
                                                        <td><label id="blinfoId" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label strong style="font-size: 14px;">Name</label></td>
                                                        <td><label id="blinfoName" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label strong style="font-size: 14px;">Customer Category</label>
                                                        </td>
                                                        <td><label id="blinfocustomercategory" strong
                                                                style="font-size: 14px;font-weight:bold;"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label strong style="font-size: 14px;">Price Type</label>
                                                        </td>
                                                        <td><label id="blinfodefaultpayment" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label strong style="font-size: 14px;">TIN No.</label></td>
                                                        <td><label id="blinfotinno" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label strong style="font-size: 14px;">VAT No.</label></td>
                                                        <td><label id="blinfovatno" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label strong style="font-size: 14px;">VAT (%)</label></td>
                                                        <td><label id="blinfovatp" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label strong style="font-size: 14px;">Witholding (%)</label>
                                                        </td>
                                                        <td><label id="blinfowitholdp" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6 col-sm-12 mb-2">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="card-title">Address Info & Other Info</h6>
                                            <a data-action="reload"><i data-feather="rotate-cw"></i></a>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table>
                                                    <tr>
                                                        <td><label strong style="font-size: 14px;">Phone Number</label></td>
                                                        <td><label id="blinfophoneno" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label strong style="font-size: 14px;">Office Phone</label></td>
                                                        <td><label id="blinfoofficephoneno" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label strong style="font-size: 14px;">Email Address</label>
                                                        </td>
                                                        <td><label id="blinfoemailaddress" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label strong style="font-size: 14px;">Address</label></td>
                                                        <td><label id="blinfoaddress" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label strong style="font-size: 14px;">Website</label></td>
                                                        <td><label id="blinfowebsite" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label strong style="font-size: 14px;">Country</label></td>
                                                        <td><label id="blinfocountry" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6 col-sm-12 mb-2">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="card-title">MRC Numbers</h6>
                                            <a data-action="reload"><i data-feather="rotate-cw"></i></a>
                                        </div>
                                        <div class="card-body">
                                            <div class="text-center">
                                                <table id="blinfodetail"
                                                     class="display table-bordered table-striped table-hover dt-responsive" style="width: 100%">
                                                    <thead>
                                                        <th>MRC Numbers</th>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="closebuttonk" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Info -->

    <script type="text/javascript">

        $(function () {
            cardSection = $('#page-block');
        });
        //Show modal with focus textbox starts
        $(document).on('shown.bs.modal', '.modal', function() {
            $(this).find('[autofocus]').focus();
        });
        //Show modal with focus textbox ends

        //Reset Validation Starts
        function cusNameCV() {
            $('#name-error').html("");
            $('#mname-error').html("");
            $('#blname-error').html("");
        }

        function cusCodeCV() {
            var codeValue;
            codeValue = document.getElementById("Code").value.toUpperCase();
            document.getElementById("Code").value = codeValue;
            $('#id-error').html("");
            $('#blid-error').html("");
        }

        function cusCatCV() {
            $('#cuscategory-error').html("");
        }

        function cusVATCV() {
            $('#VatNumber-error').html("");
            $('#blVatNumber-error').html("");
        }

        function cusVATDedCV() {
            $('#VatDeduct-error').html("");
        }

        function minPurAmount() {
            $('#minpuramount-error').html("");
        }

        function cusWithDedCV() {
            $('#WitholdDeduct-error').html("");
        }

        function creditLimitPeriodVal() {
            $('#creditlimitperiod-error').html("");
        }

        function creditLimitVal() {
            $('#creditlimit-error').html("");
        }

        function cusDefPayCV() {
            $('#defaultpayment-error').html("");
            $('#dprice').val($('#DefaultPrice').val());
            var dprices = $('#DefaultPrice').val();
            var optype=$('#operationType').val();
            var iswholesale=$('#iswholesalebef').val();
            $.get("/getCustomerCode", function(data) {
                if (dprices === "Wholeseller") {
                    $('.creditLimitPeriodDiv').show();
                    $('#wholesalerulediv').show();
                    $('#creditLimitDiv').hide();
                    $('#CreditLimitPeriod').prop('readonly', true);
                    $('#CreditLimit').prop('readonly', true);
                    $('#MinimumPurchaseAmount').prop('readonly', true);
                    $('#CreditLimitPeriod').val(data.setting.MinimumPeriod);
                    $('#CreditLimit').val(data.setting.PurchaseLimit);
                    if(parseFloat(optype)==0){
                        $('#minpurchasediv').show();
                        $('#MinimumPurchaseAmount').val(data.setting.MinimumPurchaseAmount);
                    }
                    else if(parseFloat(optype)==1 && parseFloat(iswholesale)==0){
                        $('#minpurchasediv').show();
                        $('#MinimumPurchaseAmount').val(data.setting.MinimumPurchaseAmount);
                    }
                    else if(parseFloat(optype)==1 && parseFloat(iswholesale)>=1){
                        $('#minpurchasediv').hide();
                    }
                } else if (dprices === "Retailer") {
                    $('.creditLimitPeriodDiv').hide();
                    $('#wholesalerulediv').hide();
                    $('#minpurchasediv').hide();
                    $('#creditLimitDiv').hide();
                    $('#CreditLimitPeriod').val("0");
                    $('#CreditLimit').val("0");
                }
            });
            creditLimitVal();
            creditLimitPeriodVal();
        }

        function cusPhoneCV() {
            $('#PhoneNumber-error').html("");
            $('#blPhoneNumber-error').html("");
        }

        function cusOffPhoneCV() {
            $('#OfficePhoneNumber-error').html("");
            $('#blOfficePhoneNumber-error').html("");
        }

        function cusAddressv() {
            $('#Address-error').html("");
            $('#blAddress-error').html("");
        }

        function cusCountryVC() {
            $('#Country-error').html("");
            $('#blCountry-error').html("");
        }

        function cusMemoV() {
            $('#Memo-error').html("");
            $('#blMemo-error').html("");
        }

        function customerstatusCV() {
            $('#status-error').html("");
        }

        function cusReasonV() {
            $('#Reason-error').html("");
        }

        function removeMrcNameValidation() {
            $('#muname-error').html("");
        }
        //Reset Validation Ends

        //Reset forms or modals starts
        function closeModalWithClearValidation() {
            $("#Register")[0].reset();
            $("#MRCRegister")[0].reset();
            $("#BlacklistRegister")[0].reset();
            $('#name-error').html("");
            $('#status-error').html("");
            $('#uname-error').html("");
            $('#ustatus-error').html("");
            $('#tinDiv').show();
            $('#TinNumber').val("");
            $('#tin-error').html("");
            $('#bltin-error').html("");
            $('#vatRegDiv').show();
            $('#VatNumber').val("");
            $('#VatNumber-error').html("");
            $('#mrcDiv').show();
            $('#MrcNumber').val("");
            $('#mrc-error').html("");
            $('#vatDiv').show();
            $('#VatDeduct').val("");
            $('#VatDeduct-error').html("");
            $('#withDiv').show();
            $('#WitholdDeduct').val("");
            $('#WitholdDeduct-error').html("");
            $('#defpaymentDiv').show();
            $('#DefaultPayment').val("");
            $('#defaultpayment-error').html("");
            $('#ReasonDiv').hide();
            $('#Reason').val("");
            $('#Reason-error').html("");
            $('#mname-error').html("");
            $('#id-error').html("");
            $('#cuscategory-error').html("");
            $('#tin-error').html("");
            $('#VatNumber-error').html("");
            $('#mrc-error').html("");
            $('#VatDeduct-error').html("");
            $('#WitholdDeduct-error').html("");
            $('#defaultpayment-error').html("");
            $('#PhoneNumber-error').html("");
            $('#OfficePhoneNumber-error').html("");
            $('#Address-error').html("");
            $('#Country-error').html("");
            $('#Memo-error').html("");
            $('#status-error').html("");
            $('#Reason-error').html("");
            $('#ReasonDiv').hide();
            $('#defpaymentDiv').show(); //show defaultpayment
            $('#savenewbutton').show();
            $('#savebutton').show();
            $('#updatecustomer').hide();
            $('#myModalLabel333').html("Register Customer");
            $('#blname-error').html("");
            $('#blid-error').html("");
            $('#blVatNumber-error').html("");
            $('#blPhoneNumber-error').html("");
            $('#blOfficePhoneNumber-error').html("");
            $('#blAddress-error').html("");
            $('#blCountry-error').html("");
            $('#blMemo-error').html("");
            $('#savenewblbutton').show();
            $('#saveblbutton').show();
            $('#updateblcustomer').hide();
            $('#myModalLabel334').html("Register Blacklist");
            $('#DefaultPrice').val("Retailer");
            $('#dprice').val("Retailer");
            $('#dprice').val("Retailer");
            $('#allowedcrsales').hide();
            $('.creditprop').hide();
            $('#IsAllowedCreditSales').val("Not-Allowed");
            $('#creditlimitstart-error').html("");
            $('#creditlimitend-error').html("");
            $('#creditslimit-error').html("");
            $('#creditsalesadd-error').html("");
            $('#allowedcreditsales-error').html("");
            $('#minpuramount-error').html("");
        }

        function closeMrcEditModalWithClearValidation() {
            $("#updatemrcform")[0].reset();
            $("#muname-error").html("");
        }
        //Reset forms or modals ends

        //start checkbox change function
        $(function() {
            $("#unlimitcreditslcbx").click(function() {
                if ($(this).is(":checked")) {
                    $('#unlimitflag').val('1');
                    $("#CreditSalesLimitEnd").prop("readonly",true);

                } else {
                    $('#unlimitflag').val('0');
                    $("#CreditSalesLimitEnd").prop("readonly",false);
                }
                $("#CreditSalesLimitEnd").val("");
                $("#creditlimitend-error").html("");
            });
        });
        //end checkbox change function

        $(function() {
            $('#IsAllowedCreditSales').change(function() {
                $.get("/getCustomerCode", function(data) {
                    var crsalesminlimit=data.setting.CreditSalesLimitStart;
                    var crsalesmaxlimit=data.setting.CreditSalesLimitEnd;
                    var crsalesdaylimit=data.setting.CreditSalesLimitDay;
                    var crsalesadditionlimit=data.setting.CreditSalesAdditionPercentage;
                    var unlimitflagvar = data.setting.CreditSalesLimitFlag;
                    var settleoutst = data.setting.SettleAllOutstanding;
                    var isallowedval=$('#IsAllowedCreditSales').val();
                    if (isallowedval== "Allow") {
                        if (parseFloat(unlimitflagvar)==0) {
                            $("#unlimitcreditslcbx").prop("checked", false);
                            $("#unlimitflag").prop("checked", false);
                            $("#CreditSalesLimitEnd").prop("readonly",false);
                        }
                        if (parseFloat(unlimitflagvar)==1) {
                            $("#unlimitcreditslcbx").prop("checked", true);
                            $("#CreditSalesLimitEnd").prop("readonly",true);
                            $("#CreditSalesLimitEnd").val("");
                        }
                        if (settleoutst ==0) {
                            $("#settleallouts").prop("checked", false);
                        }
                        if (settleoutst ==1) {
                            $("#settleallouts").prop("checked", true);
                        }
                        $('#CreditSalesLimitStart').val(crsalesminlimit);
                        $('#CreditSalesLimitEnd').val(crsalesmaxlimit);
                        $('#CreditSalesLimitDay').val(crsalesdaylimit);
                        $('#CreditSalesAdditionPercentage').val(crsalesadditionlimit);
                        $('.creditprop').show();
                        $(".crdprop").prop("readonly",true);
                        $("#settlecbxdiv").prop('readonly',true);
                        $("#settleallouts").prop('disabled',true);
                        $("#unlimitcreditslcbx").prop('disabled',true);
                    }
                    else if(isallowedval == "Not-Allowed"){
                        $('#CreditSalesLimitStart').val("");
                        $('#CreditSalesLimitEnd').val("");
                        $('#CreditSalesLimitDay').val("");
                        $('#CreditSalesAdditionPercentage').val("");
                        $('.creditprop').hide();
                    }
                    $('#creditlimitstart-error').html("");
                    $('#creditlimitend-error').html("");
                    $('#creditslimit-error').html("");
                    $('#creditsalesadd-error').html("");
                    $('#allowedcreditsales-error').html("");
                });
            });
        });

        var eventhandler = function(e) {
            e.preventDefault();      
        }

        //dropdown events starts
        $(function() {
            $('#CustomerCategory').change(function() {
                $('#cuscategory-error').html("");
                if ($(this).val() == "Customer") {
                    $('#tinDiv').show();
                    $('#vatRegDiv').show();
                    $('#mrcDiv').show();
                    $('#vatDiv').show();
                    $('#withDiv').show();
                    $('#defpaymentDiv').show();
                    $('#mrc-error').html("");
                    $('#DefaultPrice').val("Retailer");
                    $('.creditLimitPeriodDiv').hide();
                    $('#wholesalerulediv').hide();
                    $('#minpurchasediv').hide();
                    $('#creditLimitDiv').hide();
                    $('#CreditLimitPeriod').val("0");
                    $('#CreditLimit').val("0");
                    $('#dprice').val("Retailer");
                    $('#allowedcrsales').show();
                } else if ($(this).val() == "Customer&Supplier") {
                    $('#tinDiv').show();
                    $('#vatRegDiv').show();
                    $('#VatNumber-error').html("");
                    $('#mrcDiv').show();
                    $('#mrc-error').html("");
                    $('#vatDiv').hide();
                    $('#VatDeduct-error').html("");
                    $('#withDiv').show();
                    $('#WitholdDeduct-error').html("");
                    $('#defpaymentDiv').show();
                    $('#defaultpayment-error').html("");
                    $('#DefaultPrice').val("Retailer");
                    $('.creditLimitPeriodDiv').hide();
                    $('#wholesalerulediv').hide();
                    $('#minpurchasediv').hide();
                    $('#creditLimitDiv').hide();
                    $('#CreditLimitPeriod').val("0");
                    $('#CreditLimit').val("0");
                    $('#allowedcrsales').show();
                    $('#dprice').val("Retailer");
                } else if ($(this).val() == "Supplier") {
                    $('#tinDiv').show();
                    $('#vatRegDiv').show();
                    $('#VatNumber-error').html("");
                    $('#mrcDiv').show();
                    $('#vatDiv').hide();
                    $('#VatDeduct-error').html("");
                    $('#withDiv').hide();
                    $('#WitholdDeduct-error').html("");
                    $('#defpaymentDiv').hide();
                    $('.creditLimitPeriodDiv').hide();
                    $('#wholesalerulediv').hide();
                    $('#minpurchasediv').hide();
                    $('#creditLimitDiv').hide();
                    $('#defaultpayment-error').html("");
                    $('#DefaultPrice').val("");
                    $('#dprice').val("");
                    $('#allowedcrsales').hide();
                    $('#IsAllowedCreditSales').val("Not-Allowed");
                    $('.creditprop').hide();
                } else if ($(this).val() == "Person") {
                    $('#tinDiv').hide();
                    $('#TinNumber').val("");
                    $('#tin-error').html("");
                    $('#vatRegDiv').hide();
                    $('#VatNumber').val("");
                    $('#VatNumber-error').html("");
                    $('#mrcDiv').hide();
                    $('#MrcNumber').val("");
                    $('#mrc-error').html("");
                    $('#vatDiv').hide();
                    $('#VatDeduct').val("");
                    $('#VatDeduct-error').html("");
                    $('#withDiv').hide();
                    $('#WitholdDeduct').val("");
                    $('#WitholdDeduct-error').html("");
                    $('#defpaymentDiv').show();
                    $('.creditLimitPeriodDiv').hide();
                    $('#wholesalerulediv').hide();
                    $('#creditLimitDiv').hide();
                    $('#DefaultPrice').val("Retailer");
                    $('#minpurchasediv').hide();
                    $('#creditLimitDiv').hide();
                    $('#CreditLimitPeriod').val("0");
                    $('#CreditLimit').val("0");
                    $('#dprice').val("Retailer");
                    $('#defaultpayment-error').html("");
                    $('#allowedcrsales').show();
                    $('#IsAllowedCreditSales').val("Not-Allowed");
                } else if ($(this).val() == "Foreigner-Supplier") {
                    $('#tinDiv').hide();
                    $('#TinNumber').val("");
                    $('#tin-error').html("");
                    $('#vatRegDiv').hide();
                    $('#VatNumber').val("");
                    $('#VatNumber-error').html("");
                    $('#mrcDiv').hide();
                    $('#MrcNumber').val("");
                    $('#mrc-error').html("");
                    $('#vatDiv').hide();
                    $('#VatDeduct').val("");
                    $('#VatDeduct-error').html("");
                    $('#withDiv').hide();
                    $('#WitholdDeduct').val("");
                    $('#WitholdDeduct-error').html("");
                    $('#defpaymentDiv').hide();
                    $('.creditLimitPeriodDiv').hide();
                    $('#wholesalerulediv').hide();
                    $('#minpurchasediv').hide();
                    $('#creditLimitDiv').hide();
                    $('#DefaultPayment').val("");
                    $('#DefaultPrice').val("");
                    $('#dprice').val("");
                    $('#defaultpayment-error').html("");
                    $('#allowedcrsales').hide();
                    $('#IsAllowedCreditSales').val("Not-Allowed");
                    $('.creditprop').hide();
                } else {
                    $('#tinDiv').hide();
                    $('#TinNumber').val("");
                    $('#tin-error').html("");
                    $('#vatRegDiv').hide();
                    $('#VatNumber').val("");
                    $('#VatNumber-error').html("");
                    $('#mrcDiv').hide();
                    $('#MrcNumber').val("");
                    $('#mrc-error').html("");
                    $('#vatDiv').hide();
                    $('#VatDeduct').val("");
                    $('#VatDeduct-error').html("");
                    $('#withDiv').hide();
                    $('#WitholdDeduct').val("");
                    $('#WitholdDeduct-error').html("");
                    $('#defpaymentDiv').hide();
                    $('.creditLimitPeriodDiv').hide();
                    $('#wholesalerulediv').hide();
                    $('#minpurchasediv').hide();
                    $('#creditLimitDiv').hide();
                    $('#DefaultPayment').val("");
                    $('#defaultpayment-error').html("");
                    $('#allowedcrsales').hide();
                    $('#IsAllowedCreditSales').val("Not-Allowed");
                    $('.creditprop').hide();
                }
            });
        });

        $(function() {
            $('#ActiveStatus').change(function() {
                $('#status-error').html("");
                if ($(this).val() == "Inactive" || $(this).val() == "Block") {
                    $('#ReasonDiv').show();
                    $('#Reason-error').html("");
                } else {
                    $('#ReasonDiv').hide();
                    $('#Reason').val("");
                    $('#Reason-error').html("");
                }
            });
        });
        //dropdown events ends

        //page load event starts
        $(document).ready(function() {
            $('#ReasonDiv').hide(); //hide reason
            $('#defpaymentDiv').show(); //show defaultpayment
            $('#savenewbutton').show();
            $('#savebutton').show();
            $('#updatecustomer').hide();
            $('#myModalLabel333').html("Register Customer");
            //Start Blacklist Forms
            $('#blname').show();
            $('#SearchCusNameDiv').hide();
            $('#searchCustomeropen').show();
            $('#searchCustomerclose').hide();
            $('#savenewblbutton').show();
            $('#saveblbutton').show();
            $('#updateblcustomer').hide();
            $('#myModalLabel334').html("Register Blacklist");
            //End Blacklist forms
            $('#customeraddbtn').show();
            $('#blacklistaddbtn').hide();
            $('#addbldiv').hide();
            $('#dprice').val("Retailer");
            $(".selectpicker").selectpicker({
                noneSelectedText: ''
            });
            $.get("/getCustomerCode", function(data) {
                $("#codetypeinput").val(data.ctype);
                var codetype = data.ctype;
                if (codetype == 1) {
                    $("#Code").prop("readonly", true);
                }
                if (codetype == 0) {
                    $("#Code").prop("readonly", false);
                }
            });
            $('#laravel-datatable-crud').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                "order": [
                    [0, "desc"]
                ],
                "lengthMenu": [50,100],
                "pagingType": "simple",
                language: {
                    search: '',
                    searchPlaceholder: "Search here"
                },
                scrollY:'55vh',
                scrollX: true,
                scrollCollapse: true,
                "dom": "<'row'<'col-lg-3 col-md-10 col-xs-1'f><'col-lg-2 col-md-2 col-xs-12'>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-4'i><'col-sm-12 col-md-6'><'col-sm-12 col-md-2'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/getcustomer',
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
                    { data: 'DT_RowIndex'},
                    {
                        data: 'Code',
                        name: 'Code'
                    },
                    {
                        data: 'CustomerCategory',
                        name: 'CustomerCategory'
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
                        data: 'MRCNumber',
                        name: 'MRCNumber'
                    },
                    {
                        data: 'VatNumber',
                        name: 'VatNumber'
                    },
                    {
                        data: 'DefaultPrice',
                        name: 'DefaultPrice'
                    },
                    {
                        data: 'PhoneNumber',
                        name: 'PhoneNumber',
                        'visible': false
                    },
                    {
                        data: 'ActiveStatus',
                        name: 'ActiveStatus'
                    },
                    {
                        data: 'salesamount',
                        name: 'salesamount',
                        'visible': false
                    }, 
                    {
                        data:'id',name:'id'
                    },
                    {
                        data: 'CreditLimit',
                        name: 'CreditLimit',
                        'visible': false
                    }, 
                    {
                        data: 'IsWholesaleBefore',
                        name: 'IsWholesaleBefore',
                        'visible': false
                    },
                ],
                
                columnDefs: [
                    {
                        targets:8,
                        render:function(data,type,row,meta){
                            var wholesaleexpire="Wholesale Expire";
                            switch(row.DefaultPrice){
                                case 'Wholeseller':
                                    if(parseFloat(row.IsWholesaleBefore)==0){
                                        return "<span style='color:#F6C23E;font-weight:bold'>New Wholesale</span>";
                                    }
                                    else if(parseFloat(row.CreditLimit)>parseFloat(row.salesamount) && parseFloat(row.IsWholesaleBefore)>=1){
                                        return "<span style='color:#f44336;font-weight:bold'>"+wholesaleexpire+"</span>";
                                    }
                                    else{
                                        return 'Wholesale';
                                    }    
                                break;
                                case 'Retailer':
                                        return 'Retail';
                                break;
                            default:
                                return data;    
                            }
                        }
                    },
                    {
                        targets:10,
                        render:function(data,type,row,meta){
                            switch(data){
                                case 'Active':
                                    return "<span style='color:#4CAF50;font-weight:bold;text-shadow:1px 1px 10px #4CAF50'>"+data+ "</span>";
                                    break;
                                default:
                                    return "<span style='color:#f44336;font-weight:bold;text-shadow:1px 1px 10px #f44336'>"+data+ "</span>";
                            }
                        }
                    },
                    {
                    targets: 12,
                    render: function ( data, type, row, meta ) {
                        var infobtn='';
                        var editbtn='';
                        var addmrcln='';
                        var deleteln='';
                        if(row.ActiveStatus=='Active'&&row.MRCNumber!=''){
                            infobtn= '<a class="dropdown-item customerInfo" onclick="customerInfo('+data+')" data-id="'+data+'" data-toggle="modal" id="dtinfobtn" title=""><i class="fa fa-info"></i><span> Info</span> </a>';
                            editbtn='@can("Customer-Edit")<a class="dropdown-item editCustomer" onclick="editCustomer('+data+')" href="javascript:void(0)" data-toggle="modal"  data-id="'+data+'" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>@endcan';
                            addmrcln='@can("Customer-MRC")<a class="dropdown-item" data-id="'+data+'"  data-name="'+row.Name+'"  data-mrc="'+row.MrcNumber+'" data-toggle="modal" id="smallButton" data-target="#MRCRegModal" title="Show MRC Under this Customer"><i class="fa fa-plus"></i><span> Add MRC No.</span></a>@endcan';
                            deleteln='@can("Customer-Delete")<a class="dropdown-item" data-id="'+data+'" data-toggle="modal" id="smallButton" data-target="#examplemodal-cusdelete" data-attr="" title="Delete Record"><i class="fa fa-trash"></i><span> Delete</span></a>@endcan';
                        }
                        if(row.ActiveStatus=='Active' && row.MRCNumber==''){
                            infobtn= '<a class="dropdown-item customerInfo" onclick="customerInfo('+data+')" data-id="'+data+'" data-toggle="modal" id="dtinfobtn" title=""><i class="fa fa-info"></i><span> Info</span> </a>';
                            editbtn='@can("Customer-Edit")<a class="dropdown-item editCustomer" onclick="editCustomer('+data+')" href="javascript:void(0)" data-toggle="modal"  data-id="'+data+'" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>@endcan';
                            addmrcln='';
                            deleteln='@can("Customer-Delete")<a class="dropdown-item" data-id="'+data+'" data-toggle="modal" id="smallButton" data-target="#examplemodal-cusdelete" data-attr="" title="Delete Record"><i class="fa fa-trash"></i><span> Delete</span></a>@endcan';
                        }
                        if(row.ActiveStatus=='Blacklist'){
                            infobtn= '<a class="dropdown-item customerInfo" onclick="customerInfo('+data+')" data-id="'+data+'" data-toggle="modal" id="dtinfobtn" title=""><i class="fa fa-info"></i><span> Info</span> </a>';
                            editbtn='';
                            addmrcln='';
                            deleteln='';
                        }
                        if(row.ActiveStatus=='Inactive'){
                            infobtn= '<a class="dropdown-item customerInfo" onclick="customerInfo('+data+')" data-id="'+data+'" data-toggle="modal" id="dtinfobtn" title=""><i class="fa fa-info"></i><span> Info</span> </a>';
                            editbtn='@can("Customer-Edit")<a class="dropdown-item editCustomer" onclick="editCustomer('+data+')" href="javascript:void(0)" data-toggle="modal"  data-id="'+data+'" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>@endcan';
                            addmrcln='';
                            deleteln='@can("Customer-Delete")<a class="dropdown-item" data-id="'+data+'" data-toggle="modal" id="smallButton" data-target="#examplemodal-cusdelete" data-attr="" title="Delete Record"><i class="fa fa-trash"></i><span> Delete</span></a>@endcan';
                        }
                        if(row.ActiveStatus=='Block'){
                            infobtn= '<a class="dropdown-item customerInfo" onclick="customerInfo('+data+')" data-id="'+data+'" data-toggle="modal" id="dtinfobtn" title=""><i class="fa fa-info"></i><span> Info</span> </a>';
                            editbtn='@can("Customer-Edit")<a class="dropdown-item editCustomer" onclick="editCustomer('+data+')" href="javascript:void(0)" data-toggle="modal"  data-id="'+data+'" data-original-title="Edit"><i class="fa fa-edit"></i><span> Edit</span></a>@endcan';
                            addmrcln='';
                            deleteln='';
                        }
                        var btn='<div class="btn-group dropleft">'+
                        '<button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'+
                            '<i class="fa fa-ellipsis-v"></i>'+
                        '</button>'+
                        '<div class="dropdown-menu">'+
                            infobtn+
                            addmrcln+
                            editbtn+
                            deleteln+
                        '</div>'+
                    '</div>';
                    return btn;
                }
            } 
        ],
                
            });

            $('#datatable-crud-bl').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                "order": [
                    [0, "desc"]
                ],
                "lengthMenu": [50,100],
                "pagingType": "simple",
                language: {
                    search: '',
                    searchPlaceholder: "Search here"
                },
                scrollY:'55vh',
                scrollX: true,
                scrollCollapse: true,
                "dom": "<'row'<'col-lg-3 col-md-10 col-xs-1'f><'col-lg-2 col-md-2 col-xs-12'>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-4'i><'col-sm-12 col-md-6'><'col-sm-12 col-md-2'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/blacklistview',
                    type: 'DELETE',
                },
                columns: [{
                        data: 'id',
                        name: 'id',
                        'visible': false
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
                        data: 'TinNumber',
                        name: 'TinNumber'
                    },
                    {
                        data: 'VatNumber',
                        name: 'VatNumber'
                    },
                    {
                        data: 'PhoneNumber',
                        name: 'PhoneNumber'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ],
                
            });
            //$.fn.dataTable.ext.errMode = 'throw';
            
        });
        //page load events ends

        $('#laravel-datatable-crud tbody').on('click', 'tr', function () {
            if($(this).hasClass('selected') ) {
                $(this).removeClass('selected');
            }
            else {
                $('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        });

        $('#datatable-crud-bl tbody').on('click', 'tr', function () {
            if($(this).hasClass('selected') ) {
                $(this).removeClass('selected');
            }
            else {
                $('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        });

        //Start Save records and close
        $('#savebutton').click(function(){
            var cc = CustomerCategory.value;
            var ast = ActiveStatus.value;
            var tn = document.getElementById("tin-error").innerHTML;
            var mc = document.getElementById("mrc-error").innerHTML;
            var em = document.getElementById("email-error").innerHTML;
            var wb = document.getElementById("Website-error").innerHTML;
            if (((ast == "Inactive" || ast == "Block") && document.getElementById("Reason").value == "") || (tn !=
                    "" || mc != "" || em != "" || wb != "")) {
                if ((ast == "Inactive" || ast == "Block") && document.getElementById("Reason").value == "") {
                    $('#Reason-error').html("Reason is required");
                }
                if (tn != "" || mc != "" || em != "" || wb != "") {
                    toastrMessage('error',"Check your inputs","Error");
                }
                toastrMessage('error',"Check your inputs","Error");
            } else {
                var registerForm = $("#Register");
                var formData = registerForm.serialize();
                $('#name-error').html("");
                $('#id-error').html("");
                $('#cuscategory-error').html("");
                $('#tin-error').html("");
                $('#VatNumber-error').html("");
                $('#mrc-error').html("");
                $('#VatDeduct-error').html("");
                $('#WitholdDeduct-error').html("");
                $('#defaultpayment-error').html("");
                $('#PhoneNumber-error').html("");
                $('#OfficePhoneNumber-error').html("");
                $('#Address-error').html("");
                $('#Country-error').html("");
                $('#Memo-error').html("");
                $('#status-error').html("");
                $('#Reason-error').html("");
                $.ajax({
                    url: '/savecustomer',
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
                        $('#savebutton').text('Saving...');
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
                            if (data.errors.name) {
                                $('#name-error').html(data.errors.name[0]);
                            }
                            if (data.errors.CustomerId) {
                                $('#id-error').html(data.errors.CustomerId[0]);
                            }
                            if (data.errors.CustomerCategory) {
                                $('#cuscategory-error').html(data.errors.CustomerCategory[0]);
                            }
                            if (data.errors.DefaultPayment) {
                                $('#defaultpayment-error').html(data.errors.DefaultPayment[0]);
                            }
                            if (data.errors.TinNumber) {
                                $('#tin-error').html(data.errors.TinNumber[0]);
                            }
                            if (data.errors.VatNumber) {
                                $('#VatNumber-error').html(data.errors.VatNumber[0]);
                            }
                            if (data.errors.MrcNumber) {
                                $('#mrc-error').html(data.errors.MrcNumber[0]);
                            }
                            if (data.errors.VatDeduct) {
                                $('#VatDeduct-error').html(data.errors.VatDeduct[0]);
                            }
                            if (data.errors.WitholdDeduct) {
                                $('#WitholdDeduct-error').html(data.errors.WitholdDeduct[0]);
                            }
                            if (data.errors.CreditLimitPeriod) {
                                $('#creditlimitperiod-error').html(
                                    "The minimum period period field is required when default payment is Wholeseller."
                                );
                            }
                            if (data.errors.CreditLimit) {
                                $('#creditlimit-error').html(
                                    "The minimum purchase limit field is required when default payment is Wholeseller."
                                );
                            }
                            if (data.errors.PhoneNumber) {
                                $('#PhoneNumber-error').html(data.errors.PhoneNumber[0]);
                            }
                            if (data.errors.OfficePhoneNumber) {
                                $('#OfficePhoneNumber-error').html(data.errors.OfficePhoneNumber[0]);
                            }
                            if (data.errors.EmailAddress) {
                                $('#email-error').html(data.errors.EmailAddress[0]);
                            }
                            if (data.errors.Address) {
                                $('#Address-error').html(data.errors.Address[0]);
                            }
                            if (data.errors.Website) {
                                $('#Website-error').html(data.errors.Website[0]);
                            }
                            if (data.errors.Country) {
                                $('#Country-error').html(data.errors.Country[0]);
                            }
                            if (data.errors.Memo) {
                                $('#Memo-error').html(data.errors.Memo[0]);
                            }
                            if (data.errors.CustomerStatus) {
                                $('#status-error').html(data.errors.CustomerStatus[0]);
                            }
                            if (data.errors.Reason) {
                                $('#Reason-error').html(data.errors.Reason[0]);
                            }
                            if (data.errors.IsAllowedCreditSales) {
                                $('#allowedcreditsales-error').html("Credit sales field is required");
                            }
                            if (data.errors.CreditSalesLimitStart) {
                                var text=data.errors.CreditSalesLimitStart[0];
                                text = text.replace("credit sales limit start", "credit sales min amount");
                                $('#creditlimitstart-error').html(text);
                            }
                            if (data.errors.CreditSalesLimitEnd) {
                                var text=data.errors.CreditSalesLimitEnd[0];
                                text = text.replace("credit sales limit end", "credit sales max amount");
                                text=text.replace("credit sales limit start", "credit sales min amount");
                                $('#creditlimitend-error').html(text);
                            }
                            if (data.errors.CreditSalesLimitDay) {
                                var text=data.errors.CreditSalesLimitDay[0];
                                text = text.replace("credit sales limit day", "credit sales payment term");
                                $('#creditslimit-error').html(text);
                            }
                            if (data.errors.CreditLimit) {
                                var text=data.errors.CreditLimit[0];
                                text = text.replace("The credit limit", "The days/ period amount");
                                $('#creditlimit-error').html(text);
                            }
                            if (data.errors.MinimumPurchaseAmount) {
                                var text=data.errors.MinimumPurchaseAmount[0];
                                text = text.replace("The minimum", "First purchase amount");
                                $('#minpuramount-error').html(text);
                            }
                            if (data.errors.CreditSalesAdditionPercentage) {
                                $('#creditsalesadd-error').html(data.errors.CreditSalesAdditionPercentage[0]);
                            }
                            $('#savebutton').text('Save & Close');
                            toastrMessage('error',"Check your inputs","Error");
                        }
                        if (data.success) {
                            $('#savebutton').text('Save & Close');
                            toastrMessage('success',"Successful","Success");
                            $("#inlineForm").modal('hide');
                            $("#Register")[0].reset();
                            var oTable = $('#laravel-datatable-crud').dataTable();
                            oTable.fnDraw(false);
                            $('#savenewbutton').show();
                            $('#savebutton').show();
                            $('#updatecustomer').hide();
                            $('#ReasonDiv').hide();
                            $('#defpaymentDiv').show();
                            $('#tinDiv').show();
                            $('#vatRegDiv').show();
                            $('#mrcDiv').show();
                            $('#vatDiv').show();
                            $('#withDiv').show();
                            $('#Country').val(null).trigger('change');
                        }
                    },
                });
            }
        });
        //End Save records and close

        //Start Save records and new
        $('#savenewbutton').click(function(){
            var cc = CustomerCategory.value;
            var ast = ActiveStatus.value;
            var tn = document.getElementById("tin-error").innerHTML;
            var mc = document.getElementById("mrc-error").innerHTML;
            var em = document.getElementById("email-error").innerHTML;
            var wb = document.getElementById("Website-error").innerHTML;
            if (((ast == "Inactive" || ast == "Block") && document.getElementById("Reason").value == "") || (tn !=
                    "" || mc != "" || em != "" || wb != "")) {
                if ((ast == "Inactive" || ast == "Block") && document.getElementById("Reason").value == "") {
                    $('#Reason-error').html("Reason is required");
                }
                if (tn != "" || mc != "" || em != "" || wb != "") {
                    toastrMessage('error',"Check your inputs","Error");
                }
                toastrMessage('error',"Check your inputs","Error");
            } else {
                var registerForm = $("#Register");
                var formData = registerForm.serialize();
                $('#name-error').html("");
                $('#id-error').html("");
                $('#cuscategory-error').html("");
                $('#tin-error').html("");
                $('#VatNumber-error').html("");
                $('#mrc-error').html("");
                $('#VatDeduct-error').html("");
                $('#WitholdDeduct-error').html("");
                $('#defaultpayment-error').html("");
                $('#PhoneNumber-error').html("");
                $('#OfficePhoneNumber-error').html("");
                $('#Address-error').html("");
                $('#Country-error').html("");
                $('#Memo-error').html("");
                $('#status-error').html("");
                $('#Reason-error').html("");
                $.ajax({
                    url: '/savecustomer',
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
                        $('#savenewbutton').text('Saving...');
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
                            if (data.errors.name) {
                                $('#name-error').html(data.errors.name[0]);
                            }
                            if (data.errors.CustomerId) {
                                $('#id-error').html(data.errors.CustomerId[0]);
                            }
                            if (data.errors.CustomerCategory) {
                                $('#cuscategory-error').html(data.errors.CustomerCategory[0]);
                            }
                            if (data.errors.DefaultPayment) {
                                $('#defaultpayment-error').html(data.errors.DefaultPayment[0]);
                            }
                            if (data.errors.TinNumber) {
                                $('#tin-error').html(data.errors.TinNumber[0]);
                            }
                            if (data.errors.VatNumber) {
                                $('#VatNumber-error').html(data.errors.VatNumber[0]);
                            }
                            if (data.errors.MrcNumber) {
                                $('#mrc-error').html(data.errors.MrcNumber[0]);
                            }
                            if (data.errors.VatDeduct) {
                                $('#VatDeduct-error').html(data.errors.VatDeduct[0]);
                            }
                            if (data.errors.WitholdDeduct) {
                                $('#WitholdDeduct-error').html(data.errors.WitholdDeduct[0]);
                            }
                            if (data.errors.CreditLimitPeriod) {
                                $('#creditlimitperiod-error').html(
                                    "The minimum period period field is required when default payment is Wholeseller."
                                );
                            }
                            if (data.errors.CreditLimit) {
                                $('#creditlimit-error').html(
                                    "The minimum purchase limit field is required when default payment is Wholeseller."
                                );
                            }
                            if (data.errors.PhoneNumber) {
                                $('#PhoneNumber-error').html(data.errors.PhoneNumber[0]);
                            }
                            if (data.errors.OfficePhoneNumber) {
                                $('#OfficePhoneNumber-error').html(data.errors.OfficePhoneNumber[0]);
                            }
                            if (data.errors.EmailAddress) {
                                $('#email-error').html(data.errors.EmailAddress[0]);
                            }
                            if (data.errors.Address) {
                                $('#Address-error').html(data.errors.Address[0]);
                            }
                            if (data.errors.Website) {
                                $('#Website-error').html(data.errors.Website[0]);
                            }
                            if (data.errors.Country) {
                                $('#Country-error').html(data.errors.Country[0]);
                            }
                            if (data.errors.Memo) {
                                $('#Memo-error').html(data.errors.Memo[0]);
                            }
                            if (data.errors.CustomerStatus) {
                                $('#status-error').html(data.errors.CustomerStatus[0]);
                            }
                            if (data.errors.Reason) {
                                $('#Reason-error').html(data.errors.Reason[0]);
                            }
                            if (data.errors.IsAllowedCreditSales) {
                                $('#allowedcreditsales-error').html("Credit sales field is required");
                            }
                            if (data.errors.CreditSalesLimitStart) {
                                var text=data.errors.CreditSalesLimitStart[0];
                                text = text.replace("credit sales limit start", "credit sales min amount");
                                $('#creditlimitstart-error').html(text);
                            }
                            if (data.errors.CreditSalesLimitEnd) {
                                var text=data.errors.CreditSalesLimitEnd[0];
                                text = text.replace("credit sales limit end", "credit sales max amount");
                                text=text.replace("credit sales limit start", "credit sales min amount");
                                $('#creditlimitend-error').html(text);
                            }
                            if (data.errors.CreditSalesLimitDay) {
                                var text=data.errors.CreditSalesLimitDay[0];
                                text = text.replace("credit sales limit day", "credit sales payment term");
                                $('#creditslimit-error').html(text);
                            }
                            if (data.errors.CreditLimit) {
                                var text=data.errors.CreditLimit[0];
                                text = text.replace("The credit limit", "The days/ period amount");
                                $('#creditlimit-error').html(text);
                            }
                            if (data.errors.MinimumPurchaseAmount) {
                                var text=data.errors.MinimumPurchaseAmount[0];
                                text = text.replace("The minimum", "First purchase amount");
                                $('#minpuramount-error').html(text);
                            }  
                            if (data.errors.CreditSalesAdditionPercentage) {
                                $('#creditsalesadd-error').html(data.errors.CreditSalesAdditionPercentage[0]);
                            }
                            $('#savenewbutton').text('Save & New');
                            toastrMessage('error',"Check your inputs","Error");
                        }
                        if (data.success) {
                            $('#savenewbutton').text('Save & New');
                            toastrMessage('success',"Successful","Success");
                            $("#Register")[0].reset();
                            var oTable = $('#laravel-datatable-crud').dataTable();
                            oTable.fnDraw(false);
                            $('#savenewbutton').show();
                            $('#savebutton').show();
                            $('#updatecustomer').hide();
                            $('#ReasonDiv').hide();
                            $('#defpaymentDiv').show();
                            $('#tinDiv').show();
                            $('#vatRegDiv').show();
                            $('#mrcDiv').show();
                            $('#vatDiv').show();
                            $('#withDiv').show();
                            $('#DefaultPrice').val("Retailer");
                            $('#dprice').val("Retailer");
                            $('#Country').val(null).trigger('change');
                            $('.creditprop').hide();
                            $.get("/getCustomerCode", function(data) {
                                $("#codetypeinput").val(data.ctype);
                                var codetype = data.ctype;
                                if (codetype == "1") {
                                    $("#Code").prop("readonly", true);
                                    $("#Code").val(data.cuscode);
                                }
                                if (codetype == "0") {
                                    $("#Code").prop("readonly", false);
                                    $("#Code").val("");
                                }
                            });
                        }
                    },
                });
            }
        });
        //End Save records and new

        //edit customer modal open
        function editCustomer(customer_id){
            $('.select2').select2();
            var salescount="0";
            var receivingcount="0";
            $('#operationType').val("1");
            $.get("custometedit" + '/' + customer_id, function(data) {
                $('#myModalLabel333').html("Update Customer");
                $('#savenewbutton').hide();
                $('#savebutton').hide();
                $('#inlineForm').modal('show');
                $('#updatecustomer').show();
                $('#id').val(data.cust.id);
                $('#name').val(data.cust.Name);
                $('#Code').val(data.cust.Code);
                $('#CustomerCategory').val(data.cust.CustomerCategory);
                $('#DefaultPrice').val(data.cust.DefaultPrice);
                $('#dprice').val(data.cust.DefaultPrice);
                $('#CreditLimitPeriod').val(data.cust.CreditLimitPeriod);
                $('#CreditLimit').val(data.cust.CreditLimit);
                $('#TinNumber').val(data.cust.TinNumber);
                $('#VatNumber').val(data.cust.VatNumber);
                $('#MRCNumber').val(data.cust.MRCNumber);
                $('#VatType').val(data.cust.VatType);
                $('#Witholding').val(data.cust.Witholding);
                $('#PhoneNumber').val(data.cust.PhoneNumber);
                $('#OfficePhone').val(data.cust.OfficePhone);
                $('#EmailAddress').val(data.cust.EmailAddress);
                $('#Website').val(data.Website);
                $('#Country').select2('destroy');
                $('#Country').val(data.cust.Country).select2();
                $('#Memo').val(data.cust.Memo);
                $('#Address').val(data.cust.Address);
                $('#ActiveStatus').val(data.cust.ActiveStatus);
                $('#Reason').val(data.cust.Reason);
                $('#IsAllowedCreditSales').val(data.cust.IsAllowedCreditSales);
                $('#CreditSalesLimitStart').val(data.cust.CreditSalesLimitStart);
                $('#CreditSalesLimitEnd').val(data.cust.CreditSalesLimitEnd);
                $('#CreditSalesLimitDay').val(data.cust.CreditSalesLimitDay);
                $('#CreditSalesAdditionPercentage').val(data.cust.CreditSalesAdditionPercentage);
                $('#iswholesalebef').val(data.cust.IsWholesaleBefore);
                $('#unlimitflag').val(data.cust.CreditSalesLimitFlag);
                $('#MinimumPurchaseAmount').val(data.cust.MinimumPurchaseAmount);
                var dpricedd=$('#DefaultPrice').val();
                var isallowed=data.cust.IsAllowedCreditSales;
                var unlimitflagvar=data.cust.CreditSalesLimitFlag;
                var settleoutst = data.cust.SettleAllOutstanding;
                var iswholesalebf=data.cust.IsWholesaleBefore;
                var dprices=data.cust.DefaultPrice;
                if (unlimitflagvar == 0) {
                    $("#unlimitcreditslcbx").prop("checked", false);
                    $("#unlimitflag").prop("checked", false);
                    $("#CreditSalesLimitEnd").prop("readonly",false);
                }
                if (unlimitflagvar == 1) {
                    $("#unlimitcreditslcbx").prop("checked", true);
                    $("#CreditSalesLimitEnd").prop("readonly",true);
                    $("#CreditSalesLimitEnd").val("");
                }
                if (settleoutst == 0) {
                    $("#settleallouts").prop("checked", false);
                }
                if (settleoutst == 1) {
                    $("#settleallouts").prop("checked", true);
                }
                if(isallowed=="Allow"){
                    $('.creditprop').show();
                }
                if(isallowed!="Allow"){
                    $('.creditprop').hide();
                }
                
                $(".crdprop").prop("readonly",true);
                $("#settlecbxdiv").prop('readonly',true);
                $("#MinimumPurchaseAmount").prop('readonly',true);
                $("#settleallouts").prop('disabled',true);
                $("#unlimitcreditslcbx").prop('disabled',true);
                receivingcount=data.getCountItem;
                salescount=data.getSalesCount;
                var cc = data.cust.CustomerCategory;
                var as = data.cust.ActiveStatus;
                $('#creditlimitstart-error').html("");
                $('#creditlimitend-error').html("");
                $('#creditslimit-error').html("");
                $('#creditsalesadd-error').html("");
                $('#allowedcreditsales-error').html("");
                if(parseFloat(receivingcount)>=1||parseFloat(salescount)>=1){
                    $("#Code").prop("readonly", true);
                    $("#name").prop("readonly", true);
                    $("#TinNumber").prop("readonly", true);
                    $("#VatNumber").prop("readonly", true);
                }
                else if(parseFloat(receivingcount)==0||parseFloat(salescount)==0){
                    $("#name").prop("readonly", false);
                    $("#TinNumber").prop("readonly", false);
                    $("#MRCNumber").prop("readonly", false);
                    $("#VatNumber").prop("readonly", false);
                    $("#CustomerCategory option[value!=100]").show();
                }
                if (cc == "Customer") {
                    $('#tinDiv').show();
                    $('#vatRegDiv').show();
                    $('#mrcDiv').show();
                    $('#vatDiv').show();
                    $('#withDiv').show();
                    $('#defpaymentDiv').show();
                    $('#mrc-error').html("");
                    $('#allowedcrsales').show();
                } else if (cc == "Customer&Supplier") {
                    $('#tinDiv').show();
                    $('#vatRegDiv').show();
                    $('#VatNumber-error').html("");
                    $('#mrcDiv').show();
                    $('#mrc-error').html("");
                    $('#vatDiv').hide();
                    $('#VatDeduct-error').html("");
                    $('#withDiv').show();
                    $('#WitholdDeduct-error').html("");
                    $('#defpaymentDiv').show();
                    $('#defaultpayment-error').html("");
                    $('#allowedcrsales').show();
                } else if (cc == "Supplier") {
                    $('#tinDiv').show();
                    $('#vatRegDiv').show();
                    $('#VatNumber-error').html("");
                    $('#mrcDiv').show();
                    $('#vatDiv').hide();
                    $('#VatDeduct-error').html("");
                    $('#withDiv').hide();
                    $('#WitholdDeduct-error').html("");
                    $('#defpaymentDiv').hide();
                    $('#defaultpayment-error').html("");
                    $('#allowedcrsales').hide();
                } else if (cc == "Person") {
                    $('#tinDiv').hide();
                    $('#TinNumber').val("");
                    $('#tin-error').html("");
                    $('#vatRegDiv').hide();
                    $('#VatNumber').val("");
                    $('#VatNumber-error').html("");
                    $('#mrcDiv').hide();
                    $('#MrcNumber').val("");
                    $('#mrc-error').html("");
                    $('#vatDiv').hide();
                    $('#VatDeduct').val("");
                    $('#VatDeduct-error').html("");
                    $('#withDiv').hide();
                    $('#WitholdDeduct').val("");
                    $('#WitholdDeduct-error').html("");
                    $('#defpaymentDiv').show();
                    $('#defaultpayment-error').html("");
                    $('#allowedcrsales').show();
                } else {
                    $('#tinDiv').hide();
                    $('#TinNumber').val("");
                    $('#tin-error').html("");
                    $('#vatRegDiv').hide();
                    $('#VatNumber').val("");
                    $('#VatNumber-error').html("");
                    $('#mrcDiv').hide();
                    $('#MrcNumber').val("");
                    $('#mrc-error').html("");
                    $('#vatDiv').hide();
                    $('#VatDeduct').val("");
                    $('#VatDeduct-error').html("");
                    $('#withDiv').hide();
                    $('#WitholdDeduct').val("");
                    $('#WitholdDeduct-error').html("");
                    $('#defpaymentDiv').hide();
                    $('#DefaultPayment').val("");
                    $('#defaultpayment-error').html("");
                    $('#allowedcrsales').hide();
                }
                if (as == "Inactive" || as == "Block") {
                    $('#ReasonDiv').show();
                } 
                else if (as == "Active") {
                    $('#ReasonDiv').hide();
                }

                var dprices = data.cust.DefaultPrice;
                if (dprices === "Wholeseller") {
                    $('#creditLimitDiv').hide();  
                    if(dpricedd===undefined){
                        $('.creditLimitPeriodDiv').hide();
                        $('#minpurchasediv').hide();
                        $('#wholesalerulediv').hide();
                    }
                    if(dpricedd!==undefined){
                        $('#wholesalerulediv').show();
                        $('.creditLimitPeriodDiv').show();
                        $('#minpurchasediv').show();
                    }
                    if(parseFloat(iswholesalebf)==0){
                        $('#minpurchasediv').show();
                    }
                    if(parseFloat(iswholesalebf)>=1){
                        $('#minpurchasediv').hide();
                    }
                } 
                else if (dprices === "Retailer") {
                    $('.creditLimitPeriodDiv').hide();
                    $('#wholesalerulediv').hide();
                    $('#minpurchasediv').hide();
                    $('#creditLimitDiv').hide();
                }
                $("#MinimumPurchaseAmount").prop("readonly", true);
                $("#CreditLimitPeriod").prop("readonly", true);
                $("#CreditLimit").prop("readonly", true);
                creditLimitVal();
                creditLimitPeriodVal();
            });
            $.get("/getCustomerCode", function(data) {
                $("#codetypeinput").val(data.ctype);
                var codetype = data.ctype;
                if (codetype == 1) {
                    $("#Code").prop("readonly", true);
                }
                if (codetype == 0) {
                    if(parseFloat(receivingcount)>=1||parseFloat(salescount)>=1){
                        $("#Code").prop("readonly", true);
                    }
                    else if(parseFloat(receivingcount)==0||parseFloat(salescount)==0){
                        $("#Code").prop("readonly", false);
                    }
                }
            });
        }
        //end edit customer modal open

        //update button click
        $('#updatecustomer').click(function(){
            var cc = CustomerCategory.value;
            var ast = ActiveStatus.value;
            var tn = document.getElementById("tin-error").innerHTML;
            var mc = document.getElementById("mrc-error").innerHTML;
            var em = document.getElementById("email-error").innerHTML;
            var wb = document.getElementById("Website-error").innerHTML;
            if (((ast == "Inactive" || ast == "Block") && document.getElementById("Reason").value == "") || (tn !=
                    "" || mc != "" || em != "" || wb != "")) {
                if ((ast == "Inactive" || ast == "Block") && document.getElementById("Reason").value == "") {
                    $('#Reason-error').html("Reason is required");
                }
                if (tn != "" || mc != "" || em != "" || wb != "") {
                    toastrMessage('error',"Check your inputs","Error");
                }
                toastrMessage('error',"Check your inputs","Error");
            } else {
                var registerForm = $("#Register");
                var formData = registerForm.serialize();
                $('#name-error').html("");
                $('#id-error').html("");
                $('#cuscategory-error').html("");
                $('#tin-error').html("");
                $('#VatNumber-error').html("");
                $('#mrc-error').html("");
                $('#VatDeduct-error').html("");
                $('#WitholdDeduct-error').html("");
                $('#defaultpayment-error').html("");
                $('#PhoneNumber-error').html("");
                $('#OfficePhoneNumber-error').html("");
                $('#Address-error').html("");
                $('#Country-error').html("");
                $('#Memo-error').html("");
                $('#status-error').html("");
                $('#Reason-error').html("");
                $.ajax({
                    url: '/customerUpdate',
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
                        $('#updatecustomer').text('Updating...');
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
                            if (data.errors.name) {
                                $('#name-error').html(data.errors.name[0]);
                            }
                            if (data.errors.CustomerId) {
                                $('#id-error').html(data.errors.CustomerId[0]);
                            }
                            if (data.errors.CustomerCategory) {
                                $('#cuscategory-error').html(data.errors.CustomerCategory[0]);
                            }
                            if (data.errors.TinNumber) {
                                $('#tin-error').html(data.errors.TinNumber[0]);
                            }
                            if (data.errors.VatNumber) {
                                $('#VatNumber-error').html(data.errors.VatNumber[0]);
                            }
                            if (data.errors.MrcNumber) {
                                $('#mrc-error').html(data.errors.MrcNumber[0]);
                            }
                            if (data.errors.VatDeduct) {
                                $('#VatDeduct-error').html(data.errors.VatDeduct[0]);
                            }
                            if (data.errors.WitholdDeduct) {
                                $('#WitholdDeduct-error').html(data.errors.WitholdDeduct[0]);
                            }
                            if (data.errors.PhoneNumber) {
                                $('#PhoneNumber-error').html(data.errors.PhoneNumber[0]);
                            }
                            if (data.errors.OfficePhoneNumber) {
                                $('#OfficePhoneNumber-error').html(data.errors.OfficePhoneNumber[0]);
                            }
                            if (data.errors.EmailAddress) {
                                $('#email-error').html(data.errors.EmailAddress[0]);
                            }
                            if (data.errors.Address) {
                                $('#Address-error').html(data.errors.Address[0]);
                            }
                            if (data.errors.Website) {
                                $('#Website-error').html(data.errors.Website[0]);
                            }
                            if (data.errors.Country) {
                                $('#Country-error').html(data.errors.Country[0]);
                            }
                            if (data.errors.Memo) {
                                $('#Memo-error').html(data.errors.Memo[0]);
                            }
                            if (data.errors.CustomerStatus) {
                                $('#status-error').html(data.errors.CustomerStatus[0]);
                            }
                            if (data.errors.Reason) {
                                $('#Reason-error').html(data.errors.Reason[0]);
                            }
                            if (data.errors.IsAllowedCreditSales) {
                                $('#allowedcreditsales-error').html("Credit sales field is required");
                            }
                            if (data.errors.CreditSalesLimitStart) {
                                var text=data.errors.CreditSalesLimitStart[0];
                                text = text.replace("credit sales limit start", "credit sales min amount");
                                $('#creditlimitstart-error').html(text);
                            }
                            if (data.errors.CreditSalesLimitEnd) {
                                var text=data.errors.CreditSalesLimitEnd[0];
                                text = text.replace("credit sales limit end", "credit sales max amount");
                                text=text.replace("credit sales limit start", "credit sales min amount");
                                $('#creditlimitend-error').html(text);
                            }
                            if (data.errors.CreditLimit) {
                                var text=data.errors.CreditLimit[0];
                                text = text.replace("The credit limit", "The days/ period amount");
                                $('#creditlimit-error').html(text);
                            }
                            if (data.errors.CreditSalesLimitDay) {
                                var text=data.errors.CreditSalesLimitDay[0];
                                text = text.replace("credit sales limit day", "credit sales payment term");
                                $('#creditslimit-error').html(text);
                            }
                            if (data.errors.MinimumPurchaseAmount) {
                                var text=data.errors.MinimumPurchaseAmount[0];
                                text = text.replace("The minimum", "First purchase amount");
                                $('#minpuramount-error').html(text);
                            }
                            if (data.errors.CreditSalesAdditionPercentage) {
                                $('#creditsalesadd-error').html(data.errors.CreditSalesAdditionPercentage[0]);
                            }
                            $('#updatecustomer').text('Update');
                            toastrMessage('error',"Check your inputs","Error");
                        }
                        if (data.success) {
                            $('#updatecustomer').text('Update');
                            toastrMessage('success',"Successful","Success");
                            $("#inlineForm").modal('hide');
                            $("#Register")[0].reset();
                            var oTable = $('#laravel-datatable-crud').dataTable();
                            oTable.fnDraw(false);
                            $('#ReasonDiv').hide();
                            $('#defpaymentDiv').show(); //show defaultpayment
                            $('#savenewbutton').show();
                            $('#savebutton').show();
                            $('#updatecustomer').hide();
                        }
                    },
                });
            }
        });
        //End of update button click

        //Start show customer doc info
        function customerInfo(recordId){
            var comments;
            var totalsales=0;
            $("#statusid").val(recordId);
            $.get("/showCustomerInfo" + '/' + recordId, function(data) {
                var dc = data;
                var len = data.cusHeader.length;
                
                $.each(data.crLimit, function (key, value) {
                    totalsales = value.TotalSales;
                });

                $.each(data.cusHeader, function (key, value) { 
                    $('#cusinfoId').text(value.Code);
                    $('#cusinfoName').text(value.Name);
                    $('#cusinfocustomercategory').text(value.CustomerCategory);
                    //$('#cusinfodefaultpayment').text(value.DefaultPrice);
                    $('#cusinfotinno').text(value.TinNumber);
                    $('#cusinfovatno').text(value.VatNumber);
                    $('#cusinfovatp').text(value.VatType);
                    $('#cusinfocreditlimitper').text(value.CreditLimitPeriod);
                    $('#cusinfocreditlimit').text(numformat(value.CreditLimit));
                    $('#cusinfocreditamount').text(numformat(value.MinimumPurchaseAmount));
                    $('#cusinfowitholdp').text(value.Witholding);
                    $('#cusinfophoneno').text(value.PhoneNumber);
                    $('#cusinfoofficephoneno').text(value.OfficePhone);
                    $('#cusinfoemailaddress').text(value.EmailAddress);
                    $('#cusinfoaddress').text(value.Address);
                    $('#cusinfowebsite').text(value.Website);
                    $('#cusinfocountry').text(value.Country);
                    $('#creditminsalesinfo').text(numformat(value.CreditSalesLimitStart));
                    $('#creditsaleslimitdayinfo').text(value.CreditSalesLimitDay);
                    $('#creditsalesadditioninfo').text(value.CreditSalesAdditionPercentage);
                    $('#createdbylbl').html(value.CreatedBy);
                    $('#createddatelbl').html(value.CreatedDateTime);
                    $('#lasteditedbylbl').html(value.LastEditedBy);
                    $('#lastediteddatelbl').html(value.LastEditedDate);
                    var creditLimit = value.CreditLimit;
                    var creditLimitPer = value.CreditLimitPeriod;
                    var dprice = value.DefaultPrice;
                    var isallowed=value.IsAllowedCreditSales;
                    var settleoutstanding=value.SettleAllOutstanding;
                    var isunlimitedcrsales=value.CreditSalesLimitFlag;
                    var customercat=value.CustomerCategory;
                    var iswholesale=value.IsWholesaleBefore;
                    var salesamount=value.salesamount;

                    $('#totalsalesondemiss').text(numformat(value.salesamount));

                    if(value.ActiveStatus=="Active"){
                        $("#cusinfostatus").html("<span style='color:#1cc88a;font-weight:bold;text-shadow;1px 1px 10px #1cc88a;font-size:14px;'>"+value.ActiveStatus+"</span>");
                    }
                    if(value.ActiveStatus=="Inactive"){
                        $("#cusinfostatus").html("<span style='color:#1cc88a;font-weight:bold;text-shadow;1px 1px 10px #1cc88a;font-size:14px;'>"+value.ActiveStatus+"</span>");
                    }
                    if(isallowed=="Allow"){
                        $('.crpropinfo').show();
                        $('#isallowedcrinfolbl').text("Allowed");
                    }
                    if(isallowed!="Allow"){
                        $('.crpropinfo').hide();
                        $('#isallowedcrinfolbl').text("Not-Allowed");
                    }
                    if(settleoutstanding=="1"){
                        $('#settleoutstandinginfo').html("Yes");
                    }
                    if(settleoutstanding=="0"){
                        $('#settleoutstandinginfo').html("No");
                    }
                    if(isunlimitedcrsales=="1"){
                        $('#creditmaxsalesinfo').text("Unlimited");
                    }
                    if(isunlimitedcrsales=="0"){
                        $('#creditmaxsalesinfo').text(numformat(value.CreditSalesLimitEnd));
                    }
                    if(customercat=="Customer"||customercat=="Customer&Supplier"||customercat=="Person"){
                        $('#isallowedcrinfo').show();
                        $('#creditsalesinfodiv').show();
                    }
                    if(customercat=="Supplier"||customercat=="Foreigner-Supplier"){
                        $('#isallowedcrinfo').hide();
                        $('#creditsalesinfodiv').hide();
                    }
                            
                    if (dprice === "Wholeseller" && (parseFloat(totalsales) < parseFloat(creditLimit)) && parseFloat(iswholesale)==1) {
                        $('#cusinfodefaultpayment').html("<label class='badge badge-danger' strong style='font-size: 14px;'>Wholesale Expire</label>");
                    } 
                    else if (dprice === "Wholeseller" && (parseFloat(totalsales) > parseFloat(creditLimit)) && parseFloat(iswholesale)==1) {
                        $('#cusinfodefaultpayment').html("<label class='badge badge-warning' strong style='font-size: 14px;'>Wholesale</label>");
                    } 
                    else if (dprice === "Wholeseller" && (parseFloat(totalsales) > parseFloat(creditLimit)) && parseFloat(iswholesale)==1) {
                        $('#cusinfodefaultpayment').html("<label class='badge badge-warning' strong style='font-size: 14px;'>Wholesale</label>");
                    }
                    else if (parseFloat(creditLimit) == 0 && parseFloat(creditLimitPer) == 0 && parseFloat(iswholesale)==1) {
                        $('#cusinfodefaultpayment').html("<label class='badge badge-warning' strong style='font-size: 14px;'>Wholesale</label>");
                    } 
                    else if (parseFloat(iswholesale)==0 && dprice === "Wholeseller") {
                        $('#cusinfodefaultpayment').html("<label class='badge badge-warning' strong style='font-size: 14px;'>New Wholesale</label>");
                    } 
                    else if (dprice === "Retailer") {  
                        $('#cusinfodefaultpayment').html("<label class='badge badge-warning' strong style='font-size: 14px;'>"+dprice+"</label>");
                        $('#totalsalesondemisstr').hide();
                        $('#totalsalesongohtr').hide();
                    } 
                    else{ 
                        $('#cusinfodefaultpayment').html("<label class='badge badge-warning' strong style='font-size: 14px;'>"+dprice+"</label>");
                        $('#totalsalesondemisstr').show();
                        $('#totalsalesongohtr').show();
                    }
                });
                
                $.each(data.gohsales, function (key, value) { 
                    $('#totalsalesongoh').text(numformat(value.salesamount));   
                });
            })

            $('#cusinfodetail').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                paging: false,
                searching: true,
                info: false,
                "order": [
                    [0, "asc"]
                ],
                "lengthMenu": [50,100],
                "pagingType": "simple",
                language: {
                    search: '',
                    searchPlaceholder: "Search here"
                },
                "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
                ajax: {
                    url: '/showCustomerDetail/' + recordId,
                    type: 'GET',
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
                    data: 'MRCNumber',
                    name: 'MRCNumber'
                }, ],
            });
            // var rTable = $('#cusinfodetail').dataTable();
            // rTable.fnDraw(false);
            $("#cusInfoModal").modal('show');
        }
        //End show customer doc info

        //Start show blacklist doc info
        $(document).on('click', '.blInfo', function() {
            var comments;
            var recordId = $(this).data('id');
            var cusName = $(this).data('name');
            var statusval = $(this).data('status');
            $("#statusid").val(recordId);
            $.get("/showBlInfo" + '/' + recordId, function(data) {
                var dc = data;
                var len = data.blHeader.length;
                for (var i = 0; i <= len; i++) {
                    $('#blinfoId').text(data.blHeader[i].Code);
                    $('#blinfoName').text(data.blHeader[i].Name);
                    $('#blinfocustomercategory').text(data.blHeader[i].CustomerCategory);
                    $('#blinfodefaultpayment').text(data.blHeader[i].DefaultPrice);
                    $('#blinfotinno').text(data.blHeader[i].TinNumber);
                    $('#blinfovatno').text(data.blHeader[i].VatNumber);
                    $('#blinfovatp').text(data.blHeader[i].VatType);
                    $('#blinfowitholdp').text(data.blHeader[i].Witholding);
                    $('#blinfophoneno').text(data.blHeader[i].PhoneNumber);
                    $('#blinfoofficephoneno').text(data.blHeader[i].OfficePhone);
                    $('#blinfoemailaddress').text(data.blHeader[i].EmailAddress);
                    $('#blinfoaddress').text(data.blHeader[i].Address);
                    $('#blinfowebsite').text(data.blHeader[i].Website);
                    $('#blinfocountry').text(data.blHeader[i].Country);
                }
            })

            $('#blinfodetail').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                paging: false,
                searching: false,
                info: false,
                "order": [
                    [0, "asc"]
                ],
                "lengthMenu": [50,100],
                "pagingType": "simple",
                language: {
                    search: '',
                    searchPlaceholder: "Search here"
                },
                "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
                ajax: {
                    url: '/showBlDetail/' + cusName,
                    type: 'GET',
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
                    data: 'MRCNumber',
                    name: 'MRCNumber'
                }, ],
            });
            // var rTable = $('#blinfodetail').dataTable();
            // rTable.fnDraw(false);
            $("#blInfoModal").modal('show');
        });
        //End show blacklist doc info

        //Starts Delete Modal With Value 
        $('#examplemodal-cusdelete').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            console.log(id);
            var modal = $(this);
            modal.find('.modal-body #custid').val(id);
        });
        //End Delete Modal With Value

        //Delete Records Starts
        $('#deletecustomerbtn').click(function() {
            var cid = document.forms['deletform'].elements['id'].value;
            var registerForm = $("#deletform");
            var formData = registerForm.serialize();
            $.ajax({
                url: '/deleteCustomer/' + cid,
                type: 'DELETE',
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
                    $('#deletecustomerbtn').text('Deleting...');
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
                        $('#deletecustomerbtn').text('Delete');
                        toastrMessage('error',"You cannot delete customer</br> Some records are save with this customer","Error");
                        $('#examplemodal-cusdelete').modal('hide');
                    }
                    if (data.success) {
                        $('#deletecustomerbtn').text('Delete');
                        toastrMessage('success',"Successful","Success");
                        $('#examplemodal-cusdelete').modal('hide');
                        $('#deletebtn').text('Delete');
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                    }
                }
            })
        });
        //Delete Records Ends


        //Start open mrc modal with values
        $('#MRCRegModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var name = button.data('name');
            var mrc = button.data('mrc');
            console.log(id);
            var modal = $(this);
            $('#addmrcmodaltxt').text("Add New MRC or View MRC (Customer: " + name + " | MRC No.: " + mrc + ")");
            modal.find('.modal-body #customerid').val(id);
            $("#collapseOne").collapse('hide');
            $(document).ready(function() {
                $('#laravel-datatable-crud-mrc').DataTable({
                    destroy: true,
                    processing: true,
                    serverSide: true,
                    "order": [
                        [0, "desc"]
                    ],
                    "lengthMenu": [50,100],
                    "pagingType": "simple",
                    language: {
                        search: '',
                        searchPlaceholder: "Search here"
                    },
                    "dom": "<'row'<'col-sm-12 col-md-8'f><'col-sm-12 col-md-4'>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
                    ajax: {
                        url: '/showmrc/' + id,
                        type: 'GET',
                    },
                    columns: [{
                            data: 'id',
                            name: 'id',
                            'visible': false
                        },
                        {
                            data: 'CustomerId',
                            name: 'CustomerId',
                            'visible': false
                        },
                        {
                            data: 'MRCNumber',
                            name: 'MRCNumber'
                        },
                        {
                            data: 'ActiveStatus',
                            name: 'ActiveStatus'
                        },
                        {
                            data: 'action',
                            name: 'action'
                        }
                    ],
                    "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                        if (aData.ActiveStatus == "Active") {
                            $(nRow).find('td:eq(1)').css({
                                "color": "#4CAF50",
                                "font-weight": "bold",
                                "text-shadow": "1px 1px 10px #4CAF50"
                            });
                        } else if (aData.ActiveStatus == "Inactive") {
                            $(nRow).find('td:eq(1)').css({
                                "color": "#f44336",
                                "font-weight": "bold",
                                "text-shadow": "1px 1px 10px #f44336"
                            });
                        }
                    }
                });
            });
        });
        //End open mrc modal with values

        //Start Save Mrc
        $('body').on('click', '#savemrcbtn', function() {
            var mc = document.getElementById("mname-error").innerHTML;
            if (mc != "") {
                $('#savemrcbtn').text('Add MRC');
                toastrMessage('error',"Check your inputs","Error");
            } else {
                var registerForm = $("#MRCRegister");
                var formData = registerForm.serialize();
                $('#mname-error').html("");
                $('#mstatus-error').html("");
                $.ajax({
                    url: '/savemrc',
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
                        $('#savemrcbtn').text('Adding...');
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
                        console.log(data);
                        if (data.errors) {
                            if (data.errors.MrcNumber) {
                                $('#mname-error').html(data.errors.MrcNumber[0]);
                            }
                            if (data.errors.status) {
                                $('#mstatus-error').html(data.errors.status[0]);
                            }
                            $('#savemrcbtn').text('Add MRC');
                            toastrMessage('error',"Check your inputs","Error");
                        }
                        if (data.success) {
                            $('#savemrcbtn').text('Add MRC');
                            toastrMessage('success',"Successful","Success");
                            $("#MRCRegister")[0].reset();
                            $('#MrcNumber').focus();
                            var oTable = $('#laravel-datatable-crud-mrc').dataTable();
                            oTable.fnDraw(false);
                        }
                    },
                });
            }
        });
        //End Save MRC

        //Start Open mrc update modal with value
        $('#examplemodal-mrcedit').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var customerid = button.data('customerid')
            var mrcnumber = button.data('mrcnumber')
            var status = button.data('status')
            var modal = $(this)
            modal.find('.modal-body #mrcnumber').val(mrcnumber);
            modal.find('.modal-body #cusids').val(customerid);
            modal.find('.modal-body #status').val(status);
            modal.find('.modal-body #id').val(id);
            $('#muname-error').html("");
            $('#mustatus-error').html("");
        });
        //End Open mrc update modal with value

        //Start mrc update 
        $('body').on('click', '#updatemrcbutton', function() {
            var mc = document.getElementById("muname-error").innerHTML;
            if (mc != "") {
                $('#updatemrcbutton').text('Update');
                toastrMessage('error',"Check your inputs","Error");
            } else {
                var updateForm = $("#updatemrcform");
                var cid = document.forms['updatemrcform'].elements['id'].value;
                console.log(cid);
                var formData = updateForm.serialize();
                $('#muname-error').html("");
                $('#mustatus-error').html("");
                console.log('button clickbale')
                $.ajax({
                    url: '/mrcupdate/' + cid,
                    type: 'GET',
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
                        $('#updatemrcbutton').text('Updating...');
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
                        console.log(data);
                        if (data.errors) {
                            if (data.errors.mrcnumber) {
                                $('#muname-error').html(data.errors.mrcnumber[0]);
                            }
                            if (data.errors.status) {
                                $('#mustatus-error').html(data.errors.status[0]);
                            }
                            $('#updatemrcbutton').text('Update');
                            toastrMessage('error',"Check your inputs","Error");
                        }
                        if (data.success) {
                            $('#updatemrcbutton').text('Update');
                            toastrMessage('success',"Successful","Success");
                            $("#examplemodal-mrcedit").modal('hide');
                            $("#updatemrcform")[0].reset();
                            var oTable = $('#laravel-datatable-crud-mrc').dataTable();
                            oTable.fnDraw(false);
                            $('#laravel-datatable-crud-mrc').DataTable().ajax.reload();
                        }
                    },
                });
            }
        });
        //End mrc update

        //Starts mrc delete Modal With Value 
        $('#examplemodal-mrcdelete').on('show.bs.modal', function(event) {
            console.log('d')
            var button = $(event.relatedTarget)
            var id = button.data('id')
            console.log(id)
            var modal = $(this)
            modal.find('.modal-body #cid').val(id);
            $('#mname-error').html("");
            $('#mstatus-error').html("");
        });
        //End mrc delete Modal With Value

        //Delete Records Starts
        $('#deleteMrcbtn').click(function() {
            var deleteForm = $("#deletemrcform");
            var formData = deleteForm.serialize();
            var cid = $('#cid').val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/mrcdelete/' + cid,
                type: 'DELETE',
                data: '',
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
                    $('#deleteMrcbtn').text('Deleting...');
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
                        $('#deleteMrcbtn').text('Delete');
                        toastrMessage('error',"There is some record saved with this MRC Numbe","Error");
                        $('#examplemodal-mrcdelete').modal('hide');
                    }
                    if (data.success) {
                        $('#deleteMrcbtn').text('Delete');
                        toastrMessage('success',"Successful","Success");
                        $('#examplemodal-mrcdelete').modal('hide');
                        var oTable = $('#laravel-datatable-crud-mrc').dataTable();
                        oTable.fnDraw(false);
                    }
                }
            })
        });
        //Delete Records Ends

        //MRC Search Customer
        function OpenSearchCustomer() {
            $('#blname').hide();
            $('#SearchCusNameDiv').show();
            $('#searchCustomeropen').hide();
            $('#searchCustomerclose').show();
        }

        function CloseSearchCustomer() {
            $('#blname').show();
            $('#SearchCusNameDiv').hide();
            $('#searchCustomeropen').show();
            $('#searchCustomerclose').hide();
        }
        //MRC Search customer ends

        //Start Save Blacklist records and close
        $('body').on('click', '#saveblbutton', function() {
            var tn = document.getElementById("bltin-error").innerHTML;
            var em = document.getElementById("blemail-error").innerHTML;
            var wb = document.getElementById("blWebsite-error").innerHTML;
            if ((tn != "" || em != "" || wb != "")) {
                if (tn != "" || em != "" || wb != "") {
                    toastrMessage('error',"Check your inputs","Error");
                }
                toastrMessage('error',"Check your inputs","Error");
            } else {
                var registerForm = $("#BlacklistRegister");
                var cname = document.forms['BlacklistRegister'].elements['blname'].value;
                var formData = registerForm.serialize();
                $('#blname-error').html("");
                $('#blid-error').html("");
                $('#blVatNumber-error').html("");
                $('#blPhoneNumber-error').html("");
                $('#blOfficePhoneNumber-error').html("");
                $('#blAddress-error').html("");
                $('#blCountry-error').html("");
                $('#blMemo-error').html("");
                $.ajax({
                    url: '/saveblacklist',
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
                        $('#saveblbutton').text('Saving...');
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
                        console.log(data);
                        if (data.errors) {
                            if (data.errors.name) {
                                $('#blname-error').html(data.errors.name[0]);
                            }
                            if (data.errors.CustomerId) {
                                $('#blid-error').html(data.errors.CustomerId[0]);
                            }
                            if (data.errors.TinNumber) {
                                $('#bltin-error').html(data.errors.TinNumber[0]);
                            }
                            if (data.errors.VatNumber) {
                                $('#blVatNumber-error').html(data.errors.VatNumber[0]);
                            }
                            if (data.errors.PhoneNumber) {
                                $('#blPhoneNumber-error').html(data.errors.PhoneNumber[0]);
                            }
                            if (data.errors.OfficePhoneNumber) {
                                $('#blOfficePhoneNumber-error').html(data.errors.OfficePhoneNumber[0]);
                            }
                            if (data.errors.EmailAddress) {
                                $('#blemail-error').html(data.errors.EmailAddress[0]);
                            }
                            if (data.errors.Address) {
                                $('#blAddress-error').html(data.errors.Address[0]);
                            }
                            if (data.errors.Website) {
                                $('#blWebsite-error').html(data.errors.Website[0]);
                            }
                            if (data.errors.Country) {
                                $('#blCountry-error').html(data.errors.Country[0]);
                            }
                            if (data.errors.Memo) {
                                $('#blMemo-error').html(data.errors.Memo[0]);
                            }
                            $('#saveblbutton').text('Save & Close');
                            toastrMessage('error',"Check your inputs","Error");
                        }
                        if (data.success) {
                            $('#saveblbutton').text('Save & Close');
                            toastrMessage('success',"Successful","Success");
                            $("#blacklistInlineForm").modal('hide');
                            $("#BlacklistRegister")[0].reset();
                            var oTable = $('#datatable-crud-bl').dataTable();
                            oTable.fnDraw(false);
                            var cTable = $('#laravel-datatable-crud').dataTable();
                            cTable.fnDraw(false);
                            $('#savenewblbutton').show();
                            $('#saveblbutton').show();
                            $('#updateblcustomer').hide();
                            $('#blNameSearch').val(null).trigger('change');
                            $('#blCountry').val(null).trigger('change');
                        }
                    },
                });
            }
        });
        //End Save blacklist records

        //Start Save and new Blacklist records and close
        $('body').on('click', '#savenewblbutton', function() {
            var tn = document.getElementById("bltin-error").innerHTML;
            var em = document.getElementById("blemail-error").innerHTML;
            var wb = document.getElementById("blWebsite-error").innerHTML;
            if ((tn != "" || em != "" || wb != "")) {
                if (tn != "" || em != "" || wb != "") {
                    toastrMessage('error',"Check your inputs","Error");
                }
                toastrMessage('error',"Check your inputs","Error");
            } else {
                var registerForm = $("#BlacklistRegister");
                var cname = document.forms['BlacklistRegister'].elements['blname'].value;
                var formData = registerForm.serialize();
                $('#blname-error').html("");
                $('#blid-error').html("");
                $('#blVatNumber-error').html("");
                $('#blPhoneNumber-error').html("");
                $('#blOfficePhoneNumber-error').html("");
                $('#blAddress-error').html("");
                $('#blCountry-error').html("");
                $('#blMemo-error').html("");
                $.ajax({
                    url: '/saveblacklist',
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
                        $('#savenewblbutton').text('Saving...');
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
                        console.log(data);
                        if (data.errors) {
                            if (data.errors.name) {
                                $('#blname-error').html(data.errors.name[0]);
                            }
                            if (data.errors.CustomerId) {
                                $('#blid-error').html(data.errors.CustomerId[0]);
                            }
                            if (data.errors.TinNumber) {
                                $('#bltin-error').html(data.errors.TinNumber[0]);
                            }
                            if (data.errors.VatNumber) {
                                $('#blVatNumber-error').html(data.errors.VatNumber[0]);
                            }
                            if (data.errors.PhoneNumber) {
                                $('#blPhoneNumber-error').html(data.errors.PhoneNumber[0]);
                            }
                            if (data.errors.OfficePhoneNumber) {
                                $('#blOfficePhoneNumber-error').html(data.errors.OfficePhoneNumber[0]);
                            }
                            if (data.errors.EmailAddress) {
                                $('#blemail-error').html(data.errors.EmailAddress[0]);
                            }
                            if (data.errors.Address) {
                                $('#blAddress-error').html(data.errors.Address[0]);
                            }
                            if (data.errors.Website) {
                                $('#blWebsite-error').html(data.errors.Website[0]);
                            }
                            if (data.errors.Country) {
                                $('#blCountry-error').html(data.errors.Country[0]);
                            }
                            if (data.errors.Memo) {
                                $('#blMemo-error').html(data.errors.Memo[0]);
                            }
                            $('#savenewblbutton').text('Save & New');
                            toastrMessage('error',"Check your inputs","Error");
                        }
                        if (data.success) {
                            $('#savenewblbutton').text('Save & New');
                            toastrMessage('success',"Successful","Success");
                            $("#BlacklistRegister")[0].reset();
                            var oTable = $('#datatable-crud-bl').dataTable();
                            oTable.fnDraw(false);
                            var cTable = $('#laravel-datatable-crud').dataTable();
                            cTable.fnDraw(false);
                            $('#savenewblbutton').show();
                            $('#saveblbutton').show();
                            $('#updateblcustomer').hide();
                            $('#blname').show();
                            $('#SearchCusNameDiv').hide();
                            $('#searchCustomeropen').show();
                            $('#searchCustomerclose').hide();
                            $('#myModalLabel334').html("Register Blacklist");
                            $('#blNameSearch').val(null).trigger('change');
                            $('#blCountry').val(null).trigger('change');
                        }
                    },
                });
            }
        });
        //End Save and new blacklist records


        //Start open modal with values
        $('body').on('click', '.editBlacklist', function() {
            $('.select2').select2();
            var customer_id = $(this).data('id');
            console.log('customer id=' + customer_id);
            $.get("blacklistedit" + '/' + customer_id, function(data) {
                $('#myModalLabel334').html("Update Blacklist");
                $('#savenewblbutton').hide();
                $('#saveblbutton').hide();
                $('#updateblcustomer').show();
                $('#blacklistInlineForm').modal('show');
                $('#blid').val(data.id);
                $('#blname').val(data.Name);
                $('#blcode').val(data.Code);
                $('#BlTinNumber').val(data.TinNumber);
                $('#blVatNumber').val(data.VatNumber);
                $('#blPhoneNumber').val(data.PhoneNumber);
                $('#blOfficePhone').val(data.OfficePhone);
                $('#blEmailAddress').val(data.EmailAddress);
                $('#blAddress').val(data.Address);
                $('#blWebsite').val(data.Website);
                $('#blCountry').select2('destroy');
                $('#blCountry').val(data.Country).select2();
                $('#blMemo').val(data.Memo);
            })
        });
        //end edit blacklist customer modal open

        //Start blacklist update code
        $('body').on('click', '#updateblcustomer', function() {
            var tn = document.getElementById("bltin-error").innerHTML;
            var em = document.getElementById("blemail-error").innerHTML;
            var wb = document.getElementById("blWebsite-error").innerHTML;
            if ((tn != "" || em != "" || wb != "")) {
                if (tn != "" || em != "" || wb != "") {
                    toastrMessage('error',"Check your inputs","Error");
                }
                toastrMessage('error',"Check your inputs","Error");
            } else {
                var registerForm = $("#BlacklistRegister");
                var cname = document.forms['BlacklistRegister'].elements['blname'].value;
                var formData = registerForm.serialize();
                $('#blname-error').html("");
                $('#blid-error').html("");
                $('#blVatNumber-error').html("");
                $('#blPhoneNumber-error').html("");
                $('#blOfficePhoneNumber-error').html("");
                $('#blAddress-error').html("");
                $('#blCountry-error').html("");
                $('#blMemo-error').html("");
                $.ajax({
                    url: '/updateblacklist',
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
                        $('#updateblcustomer').text('Updating...');
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
                        console.log(data);
                        if (data.errors) {
                            if (data.errors.name) {
                                $('#blname-error').html(data.errors.name[0]);
                            }
                            if (data.errors.CustomerId) {
                                $('#blid-error').html(data.errors.CustomerId[0]);
                            }
                            if (data.errors.TinNumber) {
                                $('#bltin-error').html(data.errors.TinNumber[0]);
                            }
                            if (data.errors.VatNumber) {
                                $('#blVatNumber-error').html(data.errors.VatNumber[0]);
                            }
                            if (data.errors.PhoneNumber) {
                                $('#blPhoneNumber-error').html(data.errors.PhoneNumber[0]);
                            }
                            if (data.errors.OfficePhoneNumber) {
                                $('#blOfficePhoneNumber-error').html(data.errors.OfficePhoneNumber[0]);
                            }
                            if (data.errors.EmailAddress) {
                                $('#blemail-error').html(data.errors.EmailAddress[0]);
                            }
                            if (data.errors.Address) {
                                $('#blAddress-error').html(data.errors.Address[0]);
                            }
                            if (data.errors.Website) {
                                $('#blWebsite-error').html(data.errors.Website[0]);
                            }
                            if (data.errors.Country) {
                                $('#blCountry-error').html(data.errors.Country[0]);
                            }
                            if (data.errors.Memo) {
                                $('#blMemo-error').html(data.errors.Memo[0]);
                            }
                            $('#updateblcustomer').text('Update');
                            toastrMessage('error',"Check your inputs","Error");
                        }
                        if (data.success) {
                            $('#updateblcustomer').text('Update');
                            toastrMessage('success',"Successful","Success");
                            $("#blacklistInlineForm").modal('hide');
                            $("#BlacklistRegister")[0].reset();
                            var oTable = $('#datatable-crud-bl').dataTable();
                            oTable.fnDraw(false);
                            var cTable = $('#laravel-datatable-crud').dataTable();
                            cTable.fnDraw(false);
                            $('#savenewblbutton').show();
                            $('#saveblbutton').show();
                            $('#updateblcustomer').hide();
                            $('#blNameSearch').val(null).trigger('change');
                            $('#blCountry').val(null).trigger('change');
                        }
                    },
                });
            }
        });
        //End blacklist update code

        //Start get customer info
        $(document).ready(function() {

            $('#blNameSearch').on('change', function() {
                $('#blname-error').html("");
                $('#blname').show();
                $('#SearchCusNameDiv').hide();
                $('#searchCustomeropen').show();
                $('#searchCustomerclose').hide();
                $('#blname').val($("#blNameSearch").val());
                var nm = $('#blNameSearch').val();
                $.get("/showBlCustomerInfo" + '/' + nm, function(data) {
                    var len = data.length;
                    for (var i = 0; i <= len; i++) {
                        $('#blcode').val(data[i].Code);
                        $('#BlTinNumber').val(data[i].TinNumber);
                        $('#blVatNumber').val(data[i].VatNumber);
                    }
                })
            });
        });
        //End get customer info

        //Starts blacklist delete Modal With Value 
        $('#examplemodal-bldelete').on('show.bs.modal', function(event) {
            console.log('d')
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var name = button.data('name')
            console.log(id)
            var modal = $(this)
            modal.find('.modal-body #blcustid').val(id);
            modal.find('.modal-body #bldelcustname').val(name);
        });
        //End blacklist delete Modal With Value

        //Delete Records Starts
        $('#deleteblbtn').click(function() {
            var deleteForm = $("#deleteBlacklistForm");
            var formData = deleteForm.serialize();
            var bid = $('#blcustid').val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/blacklistdelete/' + bid,
                type: 'DELETE',
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
                    $('#deleteblbtn').text('Deleting...');
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
                    $('#deleteblbtn').text('Delete');
                    toastrMessage('success',"Successful","Success");
                    $('#examplemodal-bldelete').modal('hide');
                    var oTable = $('#datatable-crud-bl').dataTable();
                    oTable.fnDraw(false);
                    var cTable = $('#laravel-datatable-crud').dataTable();
                    cTable.fnDraw(false);
                }
            })
        });
        //Delete Records Ends

        function showcusbtn() {
            $('#customeraddbtn').show();
            $('#blacklistaddbtn').hide();
            var cTable = $('#laravel-datatable-crud').dataTable();
            cTable.fnDraw(false);
        }

        function showblbtn() {
            $('#customeraddbtn').hide();
            $('#blacklistaddbtn').show();
            $('#addbldiv').show();
            var oTable = $('#datatable-crud-bl').dataTable();
            oTable.fnDraw(false);
        }

        function crPerLimitVal() {
            $('#CreditLimitPeriod').prop('readonly', false);
        }

        function crLimitVal() {
            $('#CreditLimit').prop('readonly', false);
        }

         function minpurdbl() {
            $('#MinimumPurchaseAmount').prop('readonly', false);
        }

        function credminval() {
            $('#CreditSalesLimitStart').prop('readonly', false);
        }

        function credmaxval() {
            $('#CreditSalesLimitEnd').prop('readonly', false);
        }

        function credlimitdayval() {
            $('#CreditSalesLimitDay').prop('readonly', false);
        }

        function credsalesperval() {
            $('#CreditSalesAdditionPercentage').prop('readonly', false);
        }

        function settdblval() {
           $('#settleallouts').prop('disabled', false);
        }

        function unlimiteddblcl() {
           $('#unlimitcreditslcbx').prop('disabled', false);
        }

        function addMRC() {
            $('#MrcNumber').val("");
            $('#mname-error').html("");
        }

        $('.openBlForm').click(function(){
            $("#blacklistInlineForm").modal('show');
            $('#blNameSearch').find('option').not(':first').remove();
            $.get("/getAllCustomers", function(data) {
                var len = data['cus'].length;
                for (var i = 0; i <= len; i++) {
                    var name = data['cus'][i].Name;
                    var id = data['cus'][i].id;
                    var option = "<option value='" + name + "'>" + name + "</option>";
                    $("#blNameSearch").append(option);
                    $('#blNameSearch').select2();
                }
            });
        });

        $('.addcustomer').click(function(){
            $("#inlineForm").modal('show');
            $('#DefaultPrice').val("Retailer");
            $('.creditLimitPeriodDiv').hide();
            $('#wholesalerulediv').hide();
            $('#creditLimitDiv').hide();
            $('#CreditLimitPeriod').val("0");
            $('#CreditLimit').val("0");
            $('#operationType').val("0");
            $('#iswholesalebef').val("");
            $('#dprice').val("Retailer");
            $('#minpurchasediv').hide();
            $('#creditLimitDiv').hide();
            $('#allowedcrsales').show();
            $('.creditprop').hide();
            $("#name").prop("readonly", false);
            $("#TinNumber").prop("readonly", false);
            $("#MRCNumber").prop("readonly", false);
            $("#VatNumber").prop("readonly", false);
            $("#CustomerCategory option[value!=100]").show();
            //$("#Witholding option[value!=100]").show();
            //$("#VatType option[value!=100]").show();  
            $.get("/getCustomerCode", function(data) {
                $("#codetypeinput").val(data.ctype);
                var codetype = data.ctype;
                if (codetype == "1") {
                    $("#Code").prop("readonly", true);
                    $("#Code").val(data.cuscode);
                }
                if (codetype == "0") {
                    $("#Code").prop("readonly", false);
                    $("#Code").val("");
                }
            });
        });


        $('#TinNumber').keyup(function(e) {
            if ($(this).val().length >= 13) {
                $(this).val($(this).val().substr(0, 13));
            }
        });

        $('#BlTinNumber').keyup(function(e) {
            if ($(this).val().length > 13) {
                $(this).val($(this).val().substr(0, 13));
            }
        });
        $('#blVatNumber').keyup(function(e) {
            if ($(this).val().length > 10) {
                $(this).val($(this).val().substr(0, 10));
            }
        });
        $('#MRCNumber').keyup(function(e) {
            if ($(this).val().length > 10) {
                $(this).val($(this).val().substr(0, 10));
            }
        });
        $('#VatNumber').keyup(function(e) {
            if ($(this).val().length > 10) {
                $(this).val($(this).val().substr(0, 10));
            }
        });
        $('.AddMrcNum').keyup(function(e) {
            if ($(this).val().length > 10) {
                $(this).val($(this).val().substr(0, 10));
            }
        });

        function adjustprop(ele){
            $("#name").prop("readonly", false);
            $("#TinNumber").prop("readonly", false);
            $("#MRCNumber").prop("readonly", false);
            $("#VatNumber").prop("readonly", false);
            $("#CustomerCategory option[value!=100]").show();
            //$("#Witholding option[value!=100]").show();
            //$("#VatType option[value!=100]").show();   
            // $('#CustomerCategory').attr("style", "pointer-events: auto;background:#ffffff;");
            // $('#Witholding').attr("style", "pointer-events: auto;background:#ffffff;");
            // $('#VatType').attr("style", "pointer-events: auto;background:#ffffff;");
        }

        function numformat(val){
            while (/(\d+)(\d{3})/.test(val.toString())){
            val = val.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
            }
            return val;
    }
    </script>

@endsection
